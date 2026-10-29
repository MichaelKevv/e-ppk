<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->isSiswa()) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses statistik eksekutif dibatasi untuk konselor dan administrator.');
        }

        $sekolahList = Sekolah::all();

        // Multi-tenancy filter rules
        $selectedSekolahId = $request->query('sekolah_id');
        $selectedJenjang = $request->query('jenjang');
        $selectedYear = $request->query('tahun', date('Y'));
        $selectedSumber = $request->query('sumber', 'all'); // 'all', 'pengaduan', 'history'

        // If Guru BK, strictly lock to their school
        if ($user->isGuruBk() && $user->sekolah_id) {
            $selectedSekolahId = $user->sekolah_id;
        }

        // Base query with multi-tenancy scoping
        $query = Pengaduan::forUser($user)->with(['sekolah']);

        if ($selectedSekolahId) {
            $query->where('id_sekolah', $selectedSekolahId);
        }

        if ($selectedJenjang) {
            $query->whereHas('sekolah', function($q) use ($selectedJenjang) {
                $q->where('jenjang', $selectedJenjang);
            });
        }

        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($selectedSumber === 'pengaduan') {
            $query->where('sumber', 'pengaduan');
        } elseif ($selectedSumber === 'history') {
            $query->where('sumber', 'history');
        }

        $allFilteredCases = (clone $query)->get();

        // 1. Executive Key Performance Indicators (KPI)
        $totalKasus = $allFilteredCases->count();
        $kasusSelesai = $allFilteredCases->whereIn('status', ['selesai', 'ditutup'])->count();
        $kasusDiproses = $allFilteredCases->whereNotIn('status', ['selesai', 'ditutup'])->count();
        $kasusDarurat = $allFilteredCases->filter(fn($c) => $c->is_darurat)->count();

        $resolutionRate = $totalKasus > 0 ? round(($kasusSelesai / $totalKasus) * 100, 1) : 0;

        // Average resolution days for completed cases
        $completedWithDates = $allFilteredCases->filter(function($c) {
            return in_array($c->status, ['selesai', 'ditutup']) && $c->tanggal_selesai && $c->created_at;
        });

        $avgResolutionDays = 0;
        if ($completedWithDates->count() > 0) {
            $totalDays = $completedWithDates->reduce(function($carry, $item) {
                $created = Carbon::parse($item->created_at);
                $finished = Carbon::parse($item->tanggal_selesai);
                return $carry + max(1, $created->diffInDays($finished));
            }, 0);
            $avgResolutionDays = round($totalDays / $completedWithDates->count(), 1);
        }

        // 2. Breakdown Bentuk Perundungan (Verbal, Fisik, Sosial, Siber, Seksual)
        $bentukLabels = ['verbal', 'fisik', 'sosial', 'siber', 'seksual'];
        $bentukCounts = [];
        foreach ($bentukLabels as $b) {
            $bentukCounts[$b] = $allFilteredCases->where('bentuk_perundungan', $b)->count();
        }

        // 3. Breakdown Tingkat Keparahan (ID3 Klasifikasi)
        $severityCounts = [
            'ringan' => $allFilteredCases->where('klasifikasi', 'ringan')->count(),
            'sedang' => $allFilteredCases->where('klasifikasi', 'sedang')->count(),
            'berat' => $allFilteredCases->where('klasifikasi', 'berat')->count(),
        ];

        // 4. Komparasi Kasus per Satuan Pendidikan (Tabel & Bar Chart)
        $sekolahStats = [];
        $scopedSekolahs = $user->isGuruBk() && $user->sekolah_id 
            ? Sekolah::where('id', $user->sekolah_id)->get() 
            : ($selectedSekolahId ? Sekolah::where('id', $selectedSekolahId)->get() : Sekolah::all());

        foreach ($scopedSekolahs as $s) {
            $scCases = $allFilteredCases->where('id_sekolah', $s->id);
            $scTotal = $scCases->count();
            $scSelesai = $scCases->whereIn('status', ['selesai', 'ditutup'])->count();
            $scDiproses = $scCases->whereNotIn('status', ['selesai', 'ditutup'])->count();
            $scDarurat = $scCases->filter(fn($c) => $c->is_darurat)->count();
            $scRate = $scTotal > 0 ? round(($scSelesai / $scTotal) * 100) : 0;

            $sekolahStats[] = [
                'id' => $s->id,
                'nama' => $s->nama_sekolah,
                'npsn' => $s->npsn,
                'jenjang' => $s->jenjang,
                'status_sekolah' => $s->status_sekolah,
                'total' => $scTotal,
                'selesai' => $scSelesai,
                'diproses' => $scDiproses,
                'darurat' => $scDarurat,
                'rate' => $scRate,
            ];
        }

        // 5. Tren Bulanan Kasus (Jan - Des)
        $monthlyTrend = array_fill(1, 12, 0);
        foreach ($allFilteredCases as $case) {
            $m = (int) Carbon::parse($case->created_at)->format('n');
            $monthlyTrend[$m]++;
        }

        // 6. Komparasi Jenjang (SMP vs SMA vs SMK)
        $jenjangCounts = [
            'SMP' => 0,
            'SMA' => 0,
            'SMK' => 0,
        ];
        foreach ($allFilteredCases as $c) {
            $j = strtoupper($c->sekolah?->jenjang ?? '');
            if (isset($jenjangCounts[$j])) {
                $jenjangCounts[$j]++;
            }
        }

        return view('admin.statistik.index', compact(
            'sekolahList',
            'selectedSekolahId',
            'selectedJenjang',
            'selectedYear',
            'selectedSumber',
            'totalKasus',
            'kasusSelesai',
            'kasusDiproses',
            'kasusDarurat',
            'resolutionRate',
            'avgResolutionDays',
            'bentukCounts',
            'severityCounts',
            'sekolahStats',
            'monthlyTrend',
            'jenjangCounts',
            'user'
        ));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        if ($user->isSiswa()) {
            abort(403);
        }

        $selectedSekolahId = $request->query('sekolah_id');
        $selectedJenjang = $request->query('jenjang');
        $selectedYear = $request->query('tahun', date('Y'));
        $selectedSumber = $request->query('sumber', 'all');

        if ($user->isGuruBk() && $user->sekolah_id) {
            $selectedSekolahId = $user->sekolah_id;
        }

        $query = Pengaduan::forUser($user)->with(['sekolah']);

        if ($selectedSekolahId) {
            $query->where('id_sekolah', $selectedSekolahId);
        }
        if ($selectedJenjang) {
            $query->whereHas('sekolah', fn($q) => $q->where('jenjang', $selectedJenjang));
        }
        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }
        if ($selectedSumber === 'pengaduan') {
            $query->where('sumber', 'pengaduan');
        } elseif ($selectedSumber === 'history') {
            $query->where('sumber', 'history');
        }

        $cases = $query->latest()->get();

        $totalKasus = $cases->count();
        $kasusSelesai = $cases->whereIn('status', ['selesai', 'ditutup'])->count();
        $kasusDiproses = $cases->whereNotIn('status', ['selesai', 'ditutup'])->count();
        $kasusDarurat = $cases->filter(fn($c) => $c->is_darurat)->count();
        $resolutionRate = $totalKasus > 0 ? round(($kasusSelesai / $totalKasus) * 100, 1) : 0;

        $bentukCounts = [
            'verbal' => $cases->where('bentuk_perundungan', 'verbal')->count(),
            'fisik' => $cases->where('bentuk_perundungan', 'fisik')->count(),
            'sosial' => $cases->where('bentuk_perundungan', 'sosial')->count(),
            'siber' => $cases->where('bentuk_perundungan', 'siber')->count(),
            'seksual' => $cases->where('bentuk_perundungan', 'seksual')->count(),
        ];

        $targetSekolah = $selectedSekolahId ? Sekolah::find($selectedSekolahId) : null;

        $pdf = Pdf::loadView('admin.statistik.export_pdf', compact(
            'cases',
            'totalKasus',
            'kasusSelesai',
            'kasusDiproses',
            'kasusDarurat',
            'resolutionRate',
            'bentukCounts',
            'targetSekolah',
            'selectedYear',
            'user'
        ))->setPaper('a4', 'portrait');

        $filename = 'Laporan-Eksekutif-Lapora-' . ($targetSekolah ? $targetSekolah->npsn : 'Lintas-Sekolah') . '-' . $selectedYear . '.pdf';
        return $pdf->download($filename);
    }
}
