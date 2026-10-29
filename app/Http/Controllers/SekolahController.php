<?php

namespace App\Http\Controllers;

use App\Models\Gurubk;
use App\Models\Pengaduan;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SekolahController extends Controller
{
    /**
     * Menampilkan daftar seluruh sekolah yang terdaftar di sistem Lapora
     */
    public function index(Request $request)
    {
        $query = Sekolah::withCount(['siswa', 'guruBk', 'pengaduan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('kepala_sekolah', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenjang') && $request->jenjang !== 'all') {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->filled('status_sekolah') && $request->status_sekolah !== 'all') {
            $query->where('status_sekolah', $request->status_sekolah);
        }

        if ($request->filled('akreditasi') && $request->akreditasi !== 'all') {
            $query->where('akreditasi', $request->akreditasi);
        }

        $sekolahList = $query->orderBy('nama_sekolah', 'asc')->paginate(10);

        // Agregat Statistik Sistem
        $stats = [
            'total_sekolah' => Sekolah::count(),
            'total_siswa' => Siswa::count(),
            'total_guru_bk' => Gurubk::count(),
            'total_pengaduan' => Pengaduan::count(),
            'total_laporan_aktif' => Pengaduan::where('sumber', 'pengaduan')->count(),
        ];

        return view('admin.sekolah.index', compact('sekolahList', 'stats'));
    }

    /**
     * Form tambah sekolah baru
     */
    public function create()
    {
        return view('admin.sekolah.create');
    }

    /**
     * Simpan data sekolah baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20|unique:sekolah,npsn',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status_sekolah' => 'required|in:Negeri,Swasta',
            'akreditasi' => 'required|in:A,B,C,Belum',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'no_telp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:150',
            'kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '_' . uniqid() . '.webp';
            $manager = new ImageManager(new Driver());
            $img = $manager->read($file)->scale(300, 300)->toWebp(90);
            Storage::disk('public')->put('sekolah/' . $filename, (string)$img);
            $validated['logo'] = $filename;
        }

        $sekolah = Sekolah::create($validated);

        return redirect()->route('admin.sekolah.show', $sekolah->id)
            ->with('success', 'Data sekolah baru berhasil ditambahkan.');
    }

    /**
     * Detail dan profil lengkap satu sekolah tertentu
     */
    public function show($id)
    {
        $sekolah = Sekolah::withCount(['siswa', 'guruBk', 'pengaduan'])->findOrFail($id);

        $siswaList = Siswa::where('id_sekolah', $sekolah->id)->latest()->take(10)->get();
        $guruBkList = Gurubk::where('id_sekolah', $sekolah->id)->get();
        $pengaduanList = Pengaduan::where('id_sekolah', $sekolah->id)->latest()->take(10)->get();

        $stats = [
            'total_siswa' => Siswa::where('id_sekolah', $sekolah->id)->count(),
            'total_guru_bk' => Gurubk::where('id_sekolah', $sekolah->id)->count(),
            'total_pengaduan' => Pengaduan::where('id_sekolah', $sekolah->id)->count(),
            'pengaduan_aktif' => Pengaduan::where('id_sekolah', $sekolah->id)->where('sumber', 'pengaduan')->count(),
            'diproses' => Pengaduan::where('id_sekolah', $sekolah->id)->where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('id_sekolah', $sekolah->id)->whereIn('status', ['selesai', 'ditutup'])->count(),
            'ringan' => Pengaduan::where('id_sekolah', $sekolah->id)->where('klasifikasi', 'ringan')->count(),
            'sedang' => Pengaduan::where('id_sekolah', $sekolah->id)->where('klasifikasi', 'sedang')->count(),
            'berat' => Pengaduan::where('id_sekolah', $sekolah->id)->where('klasifikasi', 'berat')->count(),
        ];

        return view('admin.sekolah.show', compact('sekolah', 'siswaList', 'guruBkList', 'pengaduanList', 'stats'));
    }

    /**
     * Form edit profil data sekolah
     */
    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.sekolah.edit', compact('sekolah'));
    }

    /**
     * Simpan pembaruan profil data sekolah
     */
    public function update(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20|unique:sekolah,npsn,' . $id,
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status_sekolah' => 'required|in:Negeri,Swasta',
            'akreditasi' => 'required|in:A,B,C,Belum',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'no_telp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:150',
            'kepala_sekolah' => 'nullable|string|max:150',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($sekolah->logo) {
                Storage::disk('public')->delete('sekolah/' . $sekolah->logo);
            }

            $file = $request->file('logo');
            $filename = 'logo_' . time() . '_' . uniqid() . '.webp';
            $manager = new ImageManager(new Driver());
            $img = $manager->read($file)->scale(300, 300)->toWebp(90);
            Storage::disk('public')->put('sekolah/' . $filename, (string)$img);
            $validated['logo'] = $filename;
        }

        $sekolah->update($validated);

        return redirect()->route('admin.sekolah.show', $sekolah->id)
            ->with('success', 'Profil sekolah "' . $sekolah->nama_sekolah . '" berhasil diperbarui.');
    }

    /**
     * Hapus data sekolah
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        if ($sekolah->logo) {
            Storage::disk('public')->delete('sekolah/' . $sekolah->logo);
        }

        $nama = $sekolah->nama_sekolah;
        $sekolah->delete();

        return redirect()->route('admin.sekolah.index')
            ->with('success', 'Data sekolah "' . $nama . '" berhasil dihapus dari sistem.');
    }
}
