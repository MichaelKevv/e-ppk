<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    public function index()
    {
        $data = Admin::with('user')->latest()->get();
        return view('admin.admin.index', compact('data'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|in:admin,admin_it',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'nama.required' => 'Nama lengkap admin wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar pada akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'admin',
        ]);

        $adminData = [
            'id_pengguna' => $user->id_pengguna,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan ?? 'Administrator',
            'no_telp' => $request->no_telp,
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('admin_') . '.' . $ext;

            $manager = new ImageManager(new Driver());

            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('admin/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('admin/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('admin/foto/lg/' . $filename, (string) $lg);

            $adminData['foto'] = $filename;
        }

        Admin::create($adminData);

        return redirect()->route('admin.admin.index')->with('success', 'Data Admin baru berhasil ditambahkan');
    }

    public function edit(Admin $admin)
    {
        $admin->load('user');
        $admin->username = $admin->user->username ?? '';
        $admin->email = $admin->user->email ?? '';
        $admin->role = $admin->user->role ?? 'admin';
        return view('admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $user = $admin->user;
        $userId = $user ? $user->id_pengguna : 0;

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username,' . $userId . ',id_pengguna',
            'email' => 'required|string|email|max:100|unique:users,email,' . $userId . ',id_pengguna',
            'password' => 'nullable|string|min:6',
            'role' => 'nullable|in:admin,admin_it',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'nama.required' => 'Nama lengkap admin wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($user) {
            $user->username = $request->username;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->filled('role')) {
                $user->role = $request->role;
            }
            $user->save();
        }

        $admin->nama = $request->nama;
        $admin->jabatan = $request->jabatan;
        $admin->no_telp = $request->no_telp;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($admin->foto) {
                Storage::disk('public')->delete('admin/foto/sm/' . $admin->foto);
                Storage::disk('public')->delete('admin/foto/md/' . $admin->foto);
                Storage::disk('public')->delete('admin/foto/lg/' . $admin->foto);
            }

            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('admin_') . '.' . $ext;

            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('admin/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('admin/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('admin/foto/lg/' . $filename, (string) $lg);

            $admin->foto = $filename;
        }

        $admin->save();

        return redirect()->route('admin.admin.index')->with('success', 'Data Admin berhasil diperbarui');
    }

    public function destroy(Admin $admin)
    {
        // Cegah menghapus akun yang sedang login
        if (Auth::user() && Auth::user()->id_pengguna === $admin->id_pengguna) {
            return redirect()->route('admin.admin.index')->with('error', 'Anda tidak dapat menghapus akun administrator Anda sendiri saat sedang login.');
        }

        // Cegah menghapus admin terakhir
        if (Admin::count() <= 1) {
            return redirect()->route('admin.admin.index')->with('error', 'Tidak dapat menghapus akun admin terakhir pada sistem.');
        }

        if ($admin->foto) {
            Storage::disk('public')->delete('admin/foto/sm/' . $admin->foto);
            Storage::disk('public')->delete('admin/foto/md/' . $admin->foto);
            Storage::disk('public')->delete('admin/foto/lg/' . $admin->foto);
        }

        $user = $admin->user;
        $admin->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.admin.index')->with('success', 'Data Admin dan kredensial akun berhasil dihapus');
    }
}
