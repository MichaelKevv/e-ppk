<?php

namespace App\Http\Controllers;

use App\Models\TbKepalaSekolah;
use App\Models\TbPengguna;
use App\Models\TbPetuga;
use App\Models\TbSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }
    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $pengguna = TbPengguna::where('email', $credentials['email'])
            ->orWhere('username', $credentials['email'])
            ->first();

        if ($pengguna && Hash::check($credentials['password'], $pengguna->password)) {
            Auth::login($pengguna);
            if ($pengguna->role == 'kepala_sekolah') {
                $userdata = TbKepalaSekolah::where('id_pengguna', $pengguna->id_pengguna)->first();
            } elseif ($pengguna->role == 'petugas') {
                $userdata = TbPetuga::where('id_pengguna', $pengguna->id_pengguna)->first();
            } elseif ($pengguna->role == 'siswa') {
                $userdata = TbSiswa::where('id_pengguna', $pengguna->id_pengguna)->first();
            }
            session(['userdata' => $userdata]);
            return redirect()->intended('dashboard');
        }

        return redirect()->back()->with('error', 'Email atau Password salah');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
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
            $penggunaData['role'] = 'siswa';

            $pengguna = TbPengguna::create($penggunaData);

            $siswaData = $request->only(['nama', 'kelas', 'jurusan', 'alamat', 'no_telp', 'gender']);
            $siswaData['id_pengguna'] = $pengguna->id_pengguna;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $image->storeAs('public/foto-siswa', $image->hashName());
                $siswaData['foto'] = $image->hashName();
            }
            TbSiswa::create($siswaData);

            Alert::success("Success", "Registrasi berhasil! Silakan Login");

            DB::commit();

            return redirect("login");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
