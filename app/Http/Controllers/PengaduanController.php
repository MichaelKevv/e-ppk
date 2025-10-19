<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Siswa; // Tambahkan model Siswa
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $data = Pengaduan::where('id_siswa', session('userdata')->id_siswa)
                            ->with('siswa') // Eager load relasi siswa
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            $data = Pengaduan::with('siswa') // Eager load relasi siswa
                            ->orderBy('created_at', 'desc')
                            ->get();
        }
        
        $title = 'Hapus Pengaduan';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('admin.pengaduan.index', compact('data')); // Perbaiki penulisan path view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'required|boolean',
            'luka_fisik' => 'required|boolean',
            'pelaku_lebih_dari_satu' => 'required|boolean',
            'konten_digital' => 'required|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduanData = $request->only([
                'bentuk_perundungan', 
                'frekuensi_kejadian', 
                'lokasi', 
                'trauma_mental', 
                'luka_fisik', 
                'pelaku_lebih_dari_satu', 
                'konten_digital', 
                'jenis_kata', 
                'klasifikasi',
                'deskripsi'
            ]);
            
            $pengaduanData['id_siswa'] = session('userdata')->id_siswa;
            
            // Handle upload foto jika ada field foto
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-pengaduan', $image->hashName());
                $pengaduanData['foto'] = $image->hashName();
            }
            
            Pengaduan::create($pengaduanData);

            Alert::success("Success", "Data berhasil disimpan");

            DB::commit();

            return redirect()->route('pengaduan.index'); // Perbaiki redirect
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with('siswa')->findOrFail($id);
        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Cek authorization - hanya siswa pemilik yang bisa edit
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengedit pengaduan ini.");
            return redirect()->route('pengaduan.index');
        }
        
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Cek authorization
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengedit pengaduan ini.");
            return redirect()->route('pengaduan.index');
        }

        $validator = Validator::make($request->all(), [
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'required|boolean',
            'luka_fisik' => 'required|boolean',
            'pelaku_lebih_dari_satu' => 'required|boolean',
            'konten_digital' => 'required|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduan->bentuk_perundungan = $request->bentuk_perundungan;
            $pengaduan->frekuensi_kejadian = $request->frekuensi_kejadian;
            $pengaduan->lokasi = $request->lokasi;
            $pengaduan->trauma_mental = $request->trauma_mental;
            $pengaduan->luka_fisik = $request->luka_fisik;
            $pengaduan->pelaku_lebih_dari_satu = $request->pelaku_lebih_dari_satu;
            $pengaduan->konten_digital = $request->konten_digital;
            $pengaduan->jenis_kata = $request->jenis_kata;
            $pengaduan->klasifikasi = $request->klasifikasi;
            $pengaduan->deskripsi = $request->deskripsi;
            
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($pengaduan->foto) {
                    Storage::delete('public/foto-pengaduan/' . $pengaduan->foto);
                }
                
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-pengaduan', $foto->hashName());
                $pengaduan->foto = $foto->hashName();
            }
            
            $pengaduan->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect()->route('pengaduan.index'); // Perbaiki redirect
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Cek authorization
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk menghapus pengaduan ini.");
            return redirect()->route('pengaduan.index');
        }

        DB::beginTransaction();

        try {
            if ($pengaduan->foto) {
                Storage::delete('public/foto-pengaduan/' . $pengaduan->foto);
            }
            $pengaduan->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect()->route('pengaduan.index'); // Perbaiki redirect
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $pengaduan = Pengaduan::with('siswa')->get();
        $pdf = Pdf::loadview('admin.pengaduan.export_pdf', ['data' => $pengaduan]); // Perbaiki path view
        return $pdf->download('laporan-pengaduan.pdf');
    }

    public function generateNomorSurat($pengaduan)
    {
        $year = $pengaduan->created_at->format('Y');
        $month = $pengaduan->created_at->format('m');

        $lastPengaduan = Pengaduan::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastPengaduan) {
            $lastNomorSurat = $lastPengaduan->nomor_surat ?? '000';
            $lastNumber = (int) substr($lastNomorSurat, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        $nomorSurat = "{$newNumber}/137426.101.11.SMP.2.E-PPK/{$year}";

        return $nomorSurat;
    }

    public function export_single($id)
    {
        $pengaduan = Pengaduan::with('siswa')->findOrFail($id);
        $pengaduan['no_surat'] = $this->generateNomorSurat($pengaduan);
        $pdf = Pdf::loadview('admin.pengaduan.export_single', compact('pengaduan')); // Perbaiki path view
        return $pdf->download('laporan-pengaduan-' . $pengaduan->siswa->nama . '.pdf');
    }

    public function pengaduanSelesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Cek authorization
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengubah status pengaduan ini.");
            return redirect()->route('pengaduan.index');
        }
        
        $pengaduan->status = 'ditutup';
        $pengaduan->save();
        
        Alert::success("Success", "Pengaduan telah ditandai sebagai selesai!");
        return redirect()->route('pengaduan.index'); // Perbaiki redirect
    }
}