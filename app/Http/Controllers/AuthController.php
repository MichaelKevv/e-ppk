<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
            $errorMessage = "Registrasi gagal, periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Ambil data yang sudah divalidasi
        $validated = $validator->validated();

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext  = 'webp';
            $filename = uniqid() . '.' . $ext;
            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(300, 300)->toWebp(80);
            Storage::disk('public')->put('foto-siswa/sm/' . $filename, (string) $sm);
            $md = $manager->read($file)->scale(600, 600)->toWebp(80);
            Storage::disk('public')->put('foto-siswa/md/' . $filename, (string) $md);
            $lg = $manager->read($file)->scale(1000, 1000)->toWebp(80);
            Storage::disk('public')->put('foto-siswa/lg/' . $filename, (string) $lg);

            $data['foto'] = $filename;
        }

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
            'foto'        => $data['foto'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
