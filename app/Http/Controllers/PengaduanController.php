<?php

namespace App\Http\Controllers;

use App\Models\TbPengaduan;
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
            $data = TbPengaduan::where('id_siswa', session('userdata')->id_siswa)->get();
        } else {
            $data = TbPengaduan::all();
        }
        $title = 'Hapus Pengaduan';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('pengaduan/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengaduan/create');
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduanData = $request->only(['judul', 'deskripsi']);
            $pengaduanData['id_siswa'] = session('userdata')->id_siswa;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-pengaduan', $image->hashName());
                $pengaduanData['foto'] = $image->hashName();
            }
            TbPengaduan::create($pengaduanData);

            Alert::success("Success", "Data berhasil disimpan");

            DB::commit();

            return redirect("pengaduan");
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
    public function show(TbPengaduan $pengaduan)
    {
        return view('pengaduan.detail', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TbPengaduan $pengaduan)
    {
        return view('pengaduan/edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbPengaduan $pengaduan)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduan->judul = $request->judul;
            $pengaduan->deskripsi = $request->deskripsi;
            if ($request->hasFile('foto')) {
                if ($pengaduan->foto) {
                    Storage::delete('public/foto-pengaduan/' . $pengaduan->gambar);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-pengaduan', $foto->hashName());
                $pengaduan->foto = $foto->hashName();
            }
            $pengaduan->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("pengaduan");
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
    public function destroy(TbPengaduan $pengaduan)
    {
        DB::beginTransaction();

        try {
            if ($pengaduan->gambar) {
                Storage::delete('public/foto-pengaduan/' . $pengaduan->gambar);
            }
            $pengaduan->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("pengaduan");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $pengaduan = TbPengaduan::all();
        $pdf = Pdf::loadview('pengaduan.export_pdf', ['data' => $pengaduan]);
        return $pdf->download('laporan-pengaduan.pdf');
    }

    public function generateNomorSurat($pengaduan)
    {
        $year = $pengaduan->created_at->format('Y');
        $month = $pengaduan->created_at->format('m');

        $lastPengaduan = TbPengaduan::whereYear('created_at', $year)
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
        $pengaduan = TbPengaduan::findOrFail($id);
        $pengaduan['no_surat'] = $this->generateNomorSurat($pengaduan);
        $pdf = Pdf::loadview('pengaduan.export_single', compact('pengaduan'));
        return $pdf->download('laporan-pengaduan-' . $pengaduan->tb_siswa->nama . '.pdf');
    }
}
