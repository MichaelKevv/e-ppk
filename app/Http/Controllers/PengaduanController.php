<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Sekolah;
use App\Services\DecisionTreeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PengaduanController extends Controller
{
    protected DecisionTreeService $treeService;

    protected array $candidateAttributes = [
        'bentuk_perundungan',
        'frekuensi_kejadian',
        'trauma_mental',
        'luka_fisik',
        'pelaku_lebih_dari_satu',
        'konten_digital',
    ];

    public function __construct(DecisionTreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    /**
     * Dapatkan model pohon keputusan aktif dari Cache atau latih otomatis dari dataset
     */
    protected function getActiveTree(): ?array
    {
        $tree = Cache::get('active_decision_tree');
        if (!$tree) {
            $allData = Pengaduan::whereNotNull('klasifikasi')->get();
            if ($allData->count() > 0) {
                $tree = $this->treeService->buildTree($allData, $this->candidateAttributes);
                Cache::put('active_decision_tree', $tree, now()->addDays(7));
            }
        }
        return $tree;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pengaduan::with(['sekolah', 'siswa'])->forUser($user);

        // Jika administrator / dinsos memilih filter sekolah spesifik
        if ($user->isAdmin() && $request->filled('id_sekolah')) {
            $query->where('id_sekolah', $request->id_sekolah);
        }

        if ($request->filled('sumber') && in_array($request->sumber, ['pengaduan', 'history'])) {
            $query->where('sumber', $request->sumber);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        // Filter khusus kasus darurat 1x24 jam
        if ($request->filled('filter_darurat') && $request->filter_darurat == 1) {
            $query->darurat();
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        // Hitung metrik terisolasi per sekolah jika Guru BK, atau total jika Admin
        $baseCounter = Pengaduan::forUser($user);
        if ($user->isAdmin() && $request->filled('id_sekolah')) {
            $baseCounter->where('id_sekolah', $request->id_sekolah);
        }

        $countSemua = (clone $baseCounter)->count();
        $countLaporan = (clone $baseCounter)->where('sumber', 'pengaduan')->count();
        $countHistory = (clone $baseCounter)->where('sumber', 'history')->count();
        $countDiproses = (clone $baseCounter)->where('status', 'diproses')->count();
        $countDarurat = (clone $baseCounter)->darurat()->count();

        // Daftar sekolah untuk filter interaktif (khusus Admin / Dinsos)
        $sekolahList = $user->isAdmin() ? Sekolah::orderBy('nama_sekolah')->get() : collect();
        $selectedSekolahId = $request->get('id_sekolah');
        $isFilterDarurat = $request->filled('filter_darurat') && $request->filter_darurat == 1;

        return view('admin.pengaduan.index', compact(
            'data',
            'countSemua',
            'countLaporan',
            'countHistory',
            'countDiproses',
            'countDarurat',
            'sekolahList',
            'selectedSekolahId',
            'isFilterDarurat'
        ));
    }

    public function create()
    {
        $sekolahList = Sekolah::orderBy('nama_sekolah')->get();
        $tree = $this->getActiveTree();
        return view('admin.pengaduan.create', compact('sekolahList', 'tree'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sekolah' => 'nullable|exists:sekolah,id',
            'nama_pelaku' => 'required|string|max:255',
            'nama_pelapor' => 'nullable|string|max:255',
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'nullable|in:ringan,sedang,berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal dibuat.<br>" . implode('<br>', $errors);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $data = $request->only([
                'id_sekolah',
                'nama_pelaku',
                'nama_pelapor',
                'bentuk_perundungan',
                'frekuensi_kejadian',
                'lokasi',
                'trauma_mental',
                'luka_fisik',
                'pelaku_lebih_dari_satu',
                'konten_digital',
                'jenis_kata',
                'deskripsi',
            ]);

            // Klasifikasi Otomatis berbasis Model Decision Tree ID3 yang telah dilatih
            $sample = [
                'bentuk_perundungan' => $data['bentuk_perundungan'],
                'frekuensi_kejadian' => $data['frekuensi_kejadian'],
                'trauma_mental' => (bool)($request->trauma_mental ?? 0),
                'luka_fisik' => (bool)($request->luka_fisik ?? 0),
                'pelaku_lebih_dari_satu' => (bool)($request->pelaku_lebih_dari_satu ?? 0),
                'konten_digital' => (bool)($request->konten_digital ?? 0),
            ];

            $tree = $this->getActiveTree();
            if ($tree) {
                $prediction = $this->treeService->predict($sample, $tree);
                $data['klasifikasi'] = $prediction['klasifikasi'] ?? ($request->klasifikasi ?? 'sedang');
            } else {
                $data['klasifikasi'] = $request->klasifikasi ?? 'sedang';
            }

            // Assign school & metadata
            if (empty($data['id_sekolah'])) {
                $defaultSekolah = Sekolah::first();
                $data['id_sekolah'] = $defaultSekolah ? $defaultSekolah->id : 1;
            }
            $data['kode_kasus'] = 'PGD-' . date('Ymd') . '-' . rand(100, 999);
            $data['sumber'] = 'pengaduan';
            $data['status'] = 'diproses';
            $data['id_user'] = Auth::id();

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = uniqid('pengaduan_') . '.webp';
                $manager = new ImageManager(new Driver());

                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string)$lg);

                $data['foto'] = $filename;
            }

            Pengaduan::create($data);
            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dibuat dan didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::with(['sekolah', 'siswa', 'riwayatTindakan.user', 'feedback.user'])
            ->leftJoin('siswa', 'pengaduan.id_user', 'siswa.id_pengguna')
            ->select('pengaduan.*', 'siswa.nama as nama_siswa', 'siswa.kelas as kelas_siswa')
            ->findOrFail($id);

        // Proteksi Multi-Tenancy: Siswa hanya dapat membuka berkas miliknya sendiri
        if ($user && $user->isSiswa() && $pengaduan->id_user !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuka berkas pengaduan ini.');
        }

        // Proteksi Multi-Tenancy: Guru BK hanya dapat menangani kasus di sekolahnya sendiri
        if ($user && $user->isGuruBk() && $pengaduan->id_sekolah && $user->sekolah_id && $pengaduan->id_sekolah !== $user->sekolah_id) {
            abort(403, 'Akses ditolak: Kasus ini terdaftar pada sekolah lain dan berada di luar yurisdiksi penanganan Anda.');
        }
            
        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    /**
     * Catat tindakan baru dan perbarui tahap penanganan kasus
     */
    public function tambahTindakan(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $user = Auth::user();
        if ($user->isSiswa()) {
            abort(403, 'Siswa tidak memiliki izin mencatat tindakan penanganan kasus.');
        }
        if ($user->isGuruBk() && $pengaduan->id_sekolah && $user->sekolah_id && $pengaduan->id_sekolah !== $user->sekolah_id) {
            abort(403, 'Akses ditolak: Anda hanya dapat mencatat tindakan untuk kasus di sekolah Anda.');
        }

        $request->validate([
            'status_tahap' => 'required|in:diproses,investigasi,konseling,mediasi,selesai,ditutup',
            'judul_tindakan' => 'required|string|max:255',
            'catatan' => 'required|string',
            'rekomendasi' => 'nullable|string',
            'kesimpulan_kasus' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp|max:5120',
        ]);

        $namaPetugas = $user->username;
        $peranPetugas = 'Petugas';

        if ($user->role === 'gurubk') {
            $guru = $user->gurubks()->first();
            $namaPetugas = $guru ? $guru->nama : $user->username;
            $peranPetugas = 'Guru BK';
        } elseif ($user->role === 'dinsos') {
            $dinsos = $user->dinsos()->first();
            $namaPetugas = $dinsos ? $dinsos->nama : $user->username;
            $peranPetugas = 'Dinas Sosial';
        } elseif (in_array($user->role, ['admin', 'admin_it'])) {
            $namaPetugas = $user->username . ' (Administrator)';
            $peranPetugas = 'Administrator';
        }

        $filename = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = 'tindakan_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('tindakan', $filename, 'public');
        }

        \App\Models\RiwayatPenangananKasus::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_user' => $user->id_pengguna ?? Auth::id(),
            'nama_petugas' => $namaPetugas,
            'peran_petugas' => $peranPetugas,
            'status_tahap' => $request->status_tahap,
            'judul_tindakan' => $request->judul_tindakan,
            'catatan' => $request->catatan,
            'rekomendasi' => $request->rekomendasi,
            'lampiran' => $filename,
        ]);

        // Perbarui status & tahap pengaduan
        $tahapLabels = [
            'investigasi' => 'Investigasi Bukti & Saksi',
            'konseling' => 'Sesi Konseling Siswa',
            'mediasi' => 'Mediasi Pihak Terkait',
            'selesai' => 'Penanganan Kasus Selesai',
            'ditutup' => 'Kasus Selesai & Ditutup',
            'diproses' => 'Laporan Diterima / Diproses',
        ];

        $pengaduan->status = $request->status_tahap;
        $pengaduan->tahap_penanganan = $tahapLabels[$request->status_tahap] ?? 'Dalam Penanganan';

        if (in_array($request->status_tahap, ['selesai', 'ditutup'])) {
            $pengaduan->tanggal_selesai = now();
            if ($request->filled('kesimpulan_kasus')) {
                $pengaduan->kesimpulan_kasus = $request->kesimpulan_kasus;
            }
        }

        $pengaduan->save();

        return redirect()->route('admin.pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Tahap penanganan kasus berhasil diperbarui ke: ' . ($tahapLabels[$request->status_tahap] ?? $request->status_tahap));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_pelaku' => 'nullable|string|max:255',
            'nama_pelapor' => 'nullable|string|max:255',
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:diproses,selesai,ditutup,history',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal diperbarui.<br>" . implode('<br>', $errors);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $pengaduan->update($request->except('foto'));

            if ($request->hasFile('foto')) {
                if ($pengaduan->foto) {
                    Storage::disk('public')->delete('pengaduan/foto/lg/' . $pengaduan->foto);
                }

                $file = $request->file('foto');
                $filename = uniqid('pengaduan_') . '.webp';
                $manager = new ImageManager(new Driver());
                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string)$lg);

                $pengaduan->update(['foto' => $filename]);
            }

            DB::commit();
            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete('pengaduan/foto/lg/' . $pengaduan->foto);
            }
            $pengaduan->delete();
            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Data pengaduan/kasus berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function pengaduanSelesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'selesai']);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Status pengaduan berhasil diselesaikan.');
    }

    public function export()
    {
        $pengaduan = Pengaduan::all();
        $pdf = Pdf::loadview('admin.pengaduan.export_pdf', ['data' => $pengaduan]);
        return $pdf->download('laporan-pengaduan-lapora.pdf');
    }

    public function export_single($id)
    {
        $pengaduan = Pengaduan::with(['sekolah', 'siswa', 'riwayatTindakan.user'])->findOrFail($id);
        $pdf = Pdf::loadview('admin.pengaduan.export_single', compact('pengaduan'));
        $filename = 'berita-acara-' . ($pengaduan->kode_kasus ?: 'kasus-' . $pengaduan->id_pengaduan) . '.pdf';
        return $pdf->download($filename);
    }
}
