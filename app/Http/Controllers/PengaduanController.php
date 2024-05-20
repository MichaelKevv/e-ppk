<?php

namespace App\Http\Controllers;

use App\Models\TbPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduanData = $request->only(['judul', 'deskripsi']);

            $pengaduanData['id_siswa'] = session('userdata')->id_siswa;
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
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengaduan->judul = $request->judul;
            $pengaduan->deskripsi = $request->deskripsi;
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

            $pengaduan->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("pengaduan");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
