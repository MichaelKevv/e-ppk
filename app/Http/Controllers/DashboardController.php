<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pengaduan;
use App\Models\TbPetuga;
use App\Models\Siswa;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getPengaduanData()
    {
        $user = Auth::user();
        $query = Pengaduan::forUser($user)->whereYear('created_at', date('Y'));

        $pengaduanData = $query->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $pengaduanData[$i] ?? 0;
        }

        return response()->json($formattedData);
    }

    public function getDashboardStats()
    {
        $stats = [];

        if (Auth::user()->role == 'siswa') {
            $id_user = Auth::id();

            $stats['total_pengaduan'] = Pengaduan::where('id_user', $id_user)->count();
            $stats['pengaduan_diproses'] = Pengaduan::where('id_user', $id_user)
                ->where('status', 'diproses')
                ->count();
            $stats['pengaduan_selesai'] = Pengaduan::where('id_user', $id_user)
                ->where('status', 'ditutup')
                ->count();
        } else {
            $stats['total_siswa'] = Siswa::count();
            $stats['total_pengaduan'] = Pengaduan::count();
            $stats['total_feedback'] = Feedback::count();
            $stats['total_artikel'] = Artikel::count() ?? 0; // Default ke 0 jika model tidak ada
        }

        return response()->json($stats);
    }

    public function index()
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id;

        // Base query for scoped metrics
        $basePengaduan = Pengaduan::forUser($user);

        $data['totalSiswa'] = ($user->isGuruBk() && $sekolahId) 
            ? Siswa::where('id_sekolah', $sekolahId)->count() 
            : Siswa::count();

        $data['totalPengaduan'] = (clone $basePengaduan)->count();
        $data['totalFeedback'] = Feedback::count();
        $data['totalArtikel'] = class_exists(Artikel::class) ? Artikel::count() : 0;

        // Statistik pengaduan berdasarkan klasifikasi (scoped)
        $data['pengaduanRingan'] = (clone $basePengaduan)->where('klasifikasi', 'ringan')->count();
        $data['pengaduanSedang'] = (clone $basePengaduan)->where('klasifikasi', 'sedang')->count();
        $data['pengaduanBerat'] = (clone $basePengaduan)->where('klasifikasi', 'berat')->count();

        // Pengaduan bulan ini (scoped)
        $data['pengaduanBulanIni'] = (clone $basePengaduan)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Feedback bulan ini
        $data['feedbackBulanIni'] = Feedback::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $data['totalLaporanSiswa'] = (clone $basePengaduan)->where('sumber', 'pengaduan')->count();
        $data['totalHistoryKasus'] = (clone $basePengaduan)->where('sumber', 'history')->count();
        $data['pengaduanDiproses'] = (clone $basePengaduan)->where('status', 'diproses')->count();
        $data['pengaduanSelesai'] = (clone $basePengaduan)->whereIn('status', ['selesai', 'ditutup'])->count();

        $data['recentPengaduan'] = (clone $basePengaduan)->with(['sekolah', 'siswa'])->latest()->take(6)->get();

        $activeKasus = null;
        $guruBkList = collect();

        if ($user->isSiswa()) {
            $data['totalPengaduan'] = Pengaduan::where('id_user', $user->id_pengguna)->count();
            $data['pengaduanDiproses'] = Pengaduan::where('id_user', $user->id_pengguna)->whereNotIn('status', ['selesai', 'ditutup'])->count();
            $data['pengaduanSelesai'] = Pengaduan::where('id_user', $user->id_pengguna)->whereIn('status', ['selesai', 'ditutup'])->count();
            $data['recentPengaduan'] = Pengaduan::where('id_user', $user->id_pengguna)->with('sekolah')->latest()->take(6)->get();

            // Kasus aktif untuk Pelacak Kasus Siswa (Case Tracker)
            $activeKasus = Pengaduan::where('id_user', $user->id_pengguna)
                ->with(['sekolah', 'riwayatTindakan'])
                ->latest()
                ->first();

            // Kontak Guru BK di sekolah siswa untuk bantuan cepat
            if ($user->sekolah_id) {
                $guruBkList = \App\Models\Gurubk::where('id_sekolah', $user->sekolah_id)->get();
            }
        }

        $sekolah = $user->sekolah;

        return view('admin.dashboard', compact('data', 'user', 'sekolah', 'activeKasus', 'guruBkList'));
    }

    public function indexUser()
    {
        return view('front.home');
    }
}
