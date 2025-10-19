<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::all();
        $title = 'Hapus Siswa';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('admin.siswa/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.siswa/create');
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
            'kelas' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
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
            $penggunaData['role'] = 'siswa';

            $pengguna = User::create($penggunaData);

            $siswaData = $request->only(['nama', 'kelas', 'jurusan', 'alamat', 'no_telp', 'gender']);
            $siswaData['id_pengguna'] = $pengguna->id_pengguna;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-siswa', $image->hashName());
                $siswaData['foto'] = $image->hashName();
            }
            Siswa::create($siswaData);

            Alert::success("Success", "Data berhasil disimpan");

            DB::commit();

            return redirect("admin.siswa");
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
    public function edit(Siswa $siswa)
    {
        $pengguna = User::find($siswa->id_pengguna);
        return view('admin.siswa/edit', compact('siswa', 'pengguna'));
    }

    public function editProfile($id)
    {
        $siswa = Siswa::findOrFail($id);
        $pengguna = User::find($siswa->id_pengguna);
        return view('admin.siswa/edit_profile', compact('siswa', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username,' . $siswa->id_pengguna . ',id_pengguna',
            'email' => 'required|email|unique:tb_pengguna,email,' . $siswa->id_pengguna . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna = User::findOrFail($siswa->id_pengguna);

            $pengguna->username = $request->username;
            $pengguna->email = $request->email;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();
            $siswa->nama = $request->nama;
            $siswa->kelas = $request->kelas;

            $siswa->alamat = $request->alamat;
            $siswa->no_telp = $request->no_telp;
            $siswa->gender = $request->gender;
            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Storage::delete('public/foto-siswa/' . $siswa->gambar);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-siswa', $foto->hashName());
                $siswa->foto = $foto->hashName();
            }
            $siswa->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("admin.siswa");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username,' . $siswa->id_pengguna . ',id_pengguna',
            'email' => 'required|email|unique:tb_pengguna,email,' . $siswa->id_pengguna . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna = User::findOrFail($siswa->id_pengguna);

            $pengguna->username = $request->username;
            $pengguna->email = $request->email;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();
            $siswa->nama = $request->nama;
            $siswa->kelas = $request->kelas;

            $siswa->alamat = $request->alamat;
            $siswa->no_telp = $request->no_telp;
            $siswa->gender = $request->gender;
            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Storage::delete('public/foto-siswa/' . $siswa->gambar);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto-siswa', $foto->hashName());
                $siswa->foto = $foto->hashName();
            }
            $siswa->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("admin.dashboard");
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
    public function destroy(Siswa $siswa)
    {
        DB::beginTransaction();

        try {
            if ($siswa->gambar) {
                Storage::delete('public/foto-siswa/' . $siswa->gambar);
            }
            $pengguna = User::findOrFail($siswa->id_pengguna);

            $siswa->delete();

            $pengguna->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("admin.siswa");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $siswa = Siswa::all();
        $pdf = Pdf::loadview('siswa.export_pdf', ['data' => $siswa]);
        return $pdf->download('laporan-siswa.pdf');
    }
}
