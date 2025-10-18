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
        $data = Admin::with('user')->get();
        return view('admin.admin.index', compact('data'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Create data Admin gagal. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $data = $request->only(['nama', 'jabatan', 'no_telp', 'username', 'email', 'password']);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'admin',
        ]);

        $data['id_pengguna'] = $user->id_pengguna;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('admin_') . '.' . $ext;

            $manager = new ImageManager(new Driver());

            // Simpan dalam 3 ukuran
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('admin/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('admin/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('admin/foto/lg/' . $filename, (string) $lg);

            $data['foto'] = $filename;
        }

        Admin::create($data);
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit(Admin $admin)
    {
        $admin->username = $admin->user->username;
        $admin->email = $admin->user->email;
        return view('admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string',
            'email' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Create data Admin gagal. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $user = $admin->user;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $admin->nama = $request->nama;
        $admin->jabatan = $request->jabatan;
        $admin->no_telp = $request->no_telp;

        if ($request->hasFile('foto')) {
            // hapus foto lama
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
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->foto) {
            Storage::disk('public')->delete('admin/foto/sm/' . $admin->foto);
            Storage::disk('public')->delete('admin/foto/md/' . $admin->foto);
            Storage::disk('public')->delete('admin/foto/lg/' . $admin->foto);
        }

        $admin->delete();

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
