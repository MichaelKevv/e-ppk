<?php

namespace App\Http\Controllers;

use App\Models\TbPetuga;
use App\Models\TbPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TbPetuga::all();
        $title = 'Hapus Petugas';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('admin.petugas/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.petugas/create');
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
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username',
            'email' => 'required|email|unique:tb_pengguna,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $penggunaData = $request->only(['username', 'email']);
            $penggunaData['password'] = Hash::make($request->password);
            $penggunaData['role'] = 'petugas';

            $pengguna = TbPengguna::create($penggunaData);

            $petugasData = $request->only(['nama', 'alamat', 'no_telp', 'gender']);
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-petugas', $image->hashName());
                $petugasData['foto'] = $image->hashName();
            }
            $petugasData['id_pengguna'] = $pengguna->id_pengguna;

            TbPetuga::create($petugasData);

            Alert::success("Success", "Data berhasil disimpan");

            DB::commit();

            return redirect("admin.petugas");
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TbPetuga $petuga)
    {
        $pengguna = TbPengguna::find($petuga->id_pengguna);
        return view('admin.petugas.edit', compact('petuga', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbPetuga $petuga)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username,' . $petuga->id_pengguna . ',id_pengguna',
            'email' => 'required|email|unique:tb_pengguna,email,' . $petuga->id_pengguna . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna = TbPengguna::findOrFail($petuga->id_pengguna);

            $pengguna->username = $request->username;
            $pengguna->email = $request->email;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();
            $petuga->nama = $request->nama;
            $petuga->alamat = $request->alamat;
            $petuga->no_telp = $request->no_telp;
            $petuga->gender = $request->gender;
            if ($request->hasFile('foto')) {
                if ($petuga->foto) {
                    Storage::delete('public/foto-petugas/' . $petuga->gambar);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-petugas', $foto->hashName());
                $petuga->foto = $foto->hashName();
            }
            $petuga->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("admin.petugas");
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
    public function destroy(TbPetuga $petuga)
    {
        DB::beginTransaction();

        try {
            if ($petuga->gambar) {
                Storage::delete('public/foto-petugas/' . $petuga->gambar);
            }
            $pengguna = TbPengguna::findOrFail($petuga->id_pengguna);

            $petuga->delete();

            $pengguna->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("admin.petugas");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $petugas = TbPetuga::all();
        $pdf = Pdf::loadview('petugas.export_pdf', ['data' => $petugas]);
        return $pdf->download('laporan-petugas.pdf');
    }
}
