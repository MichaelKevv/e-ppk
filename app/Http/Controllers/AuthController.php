<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();


        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard')->with('success', 'Anda berhasil login');
        }

        return redirect()->back()
            ->onlyInput('email')
            ->with('error', 'Email atau password yang Anda masukkan salah');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'gender' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Registrasi gagal, periksa kembali data yang diinput.<br><ul>";
            foreach ($errors as $error) {
                $errorMessage .= "<li>$error</li>";
            }
            $errorMessage .= "</ul>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Ambil data yang sudah divalidasi
        $validated = $validator->validated();

        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotosiswa', 'public');
        }

        // Buat user baru dengan role siswa
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'siswa',
        ]);

        // Buat data siswa
        Siswa::create([
            'id_pengguna' => $user->id_pengguna,
            'nama'        => $validated['nama'],
            'kelas'       => $validated['kelas'],
            'gender'      => $validated['gender'],
            'alamat'      => $validated['alamat'] ?? null,
            'no_telp'     => $validated['no_telp'] ?? null,
            'foto'        => $fotoPath,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
