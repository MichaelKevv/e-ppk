<?php

namespace App\Http\Controllers;

use App\Models\TbPengguna;
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
                $pengguna->load('tb_kepala_sekolahs');
            } elseif ($pengguna->role == 'petugas') {
                $pengguna->load('tb_petugas');
            } elseif ($pengguna->role == 'siswa') {
                $pengguna->load('tb_siswas');
            }
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
