<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
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
                ->with('siswa')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $data = Pengaduan::with('siswa')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('admin.pengaduan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::with('user')->get();
        return view('admin.pengaduan.create', compact('siswa'));
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
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal dibuat. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        DB::beginTransaction();

        try {
            $pengaduanData = $request->all();

            if (Auth::user()->role == 'siswa') {
                $pengaduanData['id_siswa'] = Auth::user()->id_pengguna;
            } else {
                $pengaduanData['id_siswa'] = $request->id_pengguna;
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $ext = 'webp';
                $filename = uniqid('pengaduan_') . '.' . $ext;

                $manager = new ImageManager(new Driver());

                // Simpan dalam 3 ukuran
                $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
                Storage::disk('public')->put('pengaduan/foto/sm/' . $filename, (string) $sm);

                $md = $manager->read($file)->scale(400, 400)->toWebp(85);
                Storage::disk('public')->put('pengaduan/foto/md/' . $filename, (string) $md);

                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string) $lg);

                $data['foto'] = $filename;
            }

            Pengaduan::create($pengaduanData);

            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dibuat');
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

        // Cek authorization - hanya siswa pemilik atau admin yang bisa edit
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengedit pengaduan ini.");
            return redirect()->route('admin.pengaduan.index');
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

        // Cek authorization - hanya siswa pemilik atau admin yang bisa edit
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengedit pengaduan ini.");
            return redirect()->route('admin.pengaduan.index');
        }

        $validator = Validator::make($request->all(), [
            'bentuk_perundungan' => 'required|in:verbal,fisik,sosial,siber,seksual',
            'frekuensi_kejadian' => 'required|in:sekali,2-3_kali,sering',
            'lokasi' => 'nullable|string|max:255',
            'trauma_mental' => 'nullable|boolean',
            'luka_fisik' => 'nullable|boolean',
            'pelaku_lebih_dari_satu' => 'nullable|boolean',
            'konten_digital' => 'nullable|boolean',
            'jenis_kata' => 'nullable|string|max:255',
            'klasifikasi' => 'required|in:ringan,sedang,berat',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Pengaduan gagal dibuat. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
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
                // hapus foto lama
                if ($pengaduan->foto) {
                    Storage::disk('public')->delete('pengaduan/foto/sm/' . $pengaduan->foto);
                    Storage::disk('public')->delete('pengaduan/foto/md/' . $pengaduan->foto);
                    Storage::disk('public')->delete('pengaduan/foto/lg/' . $pengaduan->foto);
                }

                $file = $request->file('foto');
                $ext = 'webp';
                $filename = uniqid('pengaduan_') . '.' . $ext;

                $manager = new ImageManager(new Driver());
                $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
                Storage::disk('public')->put('pengaduan/foto/sm/' . $filename, (string) $sm);

                $md = $manager->read($file)->scale(400, 400)->toWebp(85);
                Storage::disk('public')->put('pengaduan/foto/md/' . $filename, (string) $md);

                $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
                Storage::disk('public')->put('pengaduan/foto/lg/' . $filename, (string) $lg);

                $pengaduan->foto = $filename;
            }

            $pengaduan->save();

            DB::commit();
            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui');
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

        // Cek authorization - hanya siswa pemilik atau admin yang bisa hapus
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk menghapus pengaduan ini.");
            return redirect()->route('admin.pengaduan.index');
        }

        DB::beginTransaction();

        try {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete('pengaudan$pengaduan/foto/sm/' . $pengaduan->foto);
                Storage::disk('public')->delete('pengaudan$pengaduan/foto/md/' . $pengaduan->foto);
                Storage::disk('public')->delete('pengaudan$pengaduan/foto/lg/' . $pengaduan->foto);
            }

            $pengaduan->delete();

            DB::commit();

            return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $pengaduan = Pengaduan::with('siswa')->get();
        $pdf = Pdf::loadview('admin.pengaduan.export_pdf', ['data' => $pengaduan]);
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
        $pdf = Pdf::loadview('admin.pengaduan.export_single', compact('pengaduan'));
        return $pdf->download('laporan-pengaduan-' . $pengaduan->siswa->nama . '.pdf');
    }

    public function pengaduanSelesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Cek authorization - siswa hanya bisa menutup pengaduannya sendiri, admin bisa menutup semua
        if (Auth::user()->role == 'siswa' && $pengaduan->id_siswa != session('userdata')->id_siswa) {
            Alert::error("Error", "Anda tidak memiliki akses untuk mengubah status pengaduan ini.");
            return redirect()->route('admin.pengaduan.index');
        }

        // Admin bisa menutup semua pengaduan
        if (
            Auth::user()->role == 'admin' ||
            (Auth::user()->role == 'siswa' && $pengaduan->id_siswa == session('userdata')->id_siswa)
        ) {

            $pengaduan->status = 'ditutup';
            $pengaduan->save();

            Alert::success("Success", "Pengaduan telah ditandai sebagai selesai!");
            return redirect()->route('admin.pengaduan.index');
        }

        Alert::error("Error", "Anda tidak memiliki akses untuk mengubah status pengaduan ini.");
        return redirect()->route('admin.pengaduan.index');
    }
}
