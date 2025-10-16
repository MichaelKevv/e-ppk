<?php

namespace App\Http\Controllers;

use App\Models\TbKepalaSekolah;
use App\Models\TbPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KepsekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TbKepalaSekolah::all();
        $title = 'Hapus Kepala Sekolah';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('admin.kepsek/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kepsek/create');
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
            $penggunaData['role'] = 'kepala_sekolah';

            $pengguna = TbPengguna::create($penggunaData);

            $kepsekData = $request->only(['nama', 'alamat', 'no_telp', 'gender']);
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-kepsek', $image->hashName());
                $kepsekData['foto'] = $image->hashName();
            }
            $kepsekData['id_pengguna'] = $pengguna->id_pengguna;

            TbKepalaSekolah::create($kepsekData);

            Alert::success("Success", "Data berhasil disimpan");

            DB::commit();

            return redirect("admin.kepsek");
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
    public function edit(TbKepalaSekolah $kepsek)
    {
        $pengguna = TbPengguna::find($kepsek->id_pengguna);
        return view('admin.kepsek/edit', compact('kepsek', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbKepalaSekolah $kepsek)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username,' . $kepsek->id_pengguna . ',id_pengguna',
            'email' => 'required|email|unique:tb_pengguna,email,' . $kepsek->id_pengguna . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna = TbPengguna::findOrFail($kepsek->id_pengguna);

            $pengguna->username = $request->username;
            $pengguna->email = $request->email;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();
            $kepsek->nama = $request->nama;
            $kepsek->alamat = $request->alamat;
            $kepsek->no_telp = $request->no_telp;
            $kepsek->gender = $request->gender;
            if ($request->hasFile('foto')) {
                if ($kepsek->foto) {
                    Storage::delete('public/foto-kepsek/' . $kepsek->gambar);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-kepsek', $foto->hashName());
                $kepsek->foto = $foto->hashName();
            }
            $kepsek->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("admin.kepsek");
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
    public function destroy(TbKepalaSekolah $kepsek)
    {
        DB::beginTransaction();

        try {
            if ($kepsek->gambar) {
                Storage::delete('public/foto-kepsek/' . $kepsek->gambar);
            }
            $pengguna = TbPengguna::findOrFail($kepsek->id_pengguna);

            $kepsek->delete();

            $pengguna->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("admin.kepsek");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $kepsek = TbKepalaSekolah::all();
        $pdf = Pdf::loadview('kepsek.export_pdf', ['data' => $kepsek]);
        return $pdf->download('laporan-kepala-sekolah.pdf');
    }
}
