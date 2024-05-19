<?php

namespace App\Http\Controllers;

use App\Models\TbKepalaSekolah;
use App\Models\TbPengguna;
use App\Models\TbPetuga;
use App\Models\TbSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $pengguna = TbPengguna::where('email', $credentials['email'])->first();

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

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
