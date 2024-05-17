<?php

namespace App\Http\Controllers;

use App\Models\TbPengguna;
use App\Models\TbPetuga;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TbPengguna::all();
        $title = 'Hapus Pengguna';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('pengguna/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengguna/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TbPengguna::create([
            'id_pegawai' => $request->id_pegawai,
            'id_jam_kerja' => $request->id_jam_kerja,
            'jabatan'  => $request->jabatan,
        ]);
        Alert::success("Success", "Data berhasil disimpan");

        return redirect("pengguna");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TbPengguna $pengguna)
    {
        $data["pegawaiExist"] = TbPengguna::find($pengguna->id_pegawai);
        $data['pengguna'] = TbPengguna::all();
        return view('pengguna/edit', compact('pengguna'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbPengguna $pengguna)
    {
        $pengguna->update([
            'id_pegawai' => $request->id_pegawai,
            'id_jam_kerja' => $request->id_jam_kerja,
            'jabatan'  => $request->jabatan,
        ]);
        Alert::success("Success", "Data berhasil disimpan");

        return redirect("pengguna");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbPengguna $pengguna)
    {
        $pengguna->delete();
        Alert::success("Success", "Data berhasil dihapus");

        return redirect("pengguna");
    }
}
