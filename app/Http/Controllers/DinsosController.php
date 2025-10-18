<?php

namespace App\Http\Controllers;

use App\Models\Dinso;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class DinsosController extends Controller
{
    public function index()
    {
        $data = Dinso::with('user')->get();
        return view('admin.dinsos.index', compact('data'));
    }

    public function create()
    {
        return view('admin.dinsos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gender' => 'required|string|in:L,P',
            'no_telp' => 'required|string|max:20',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Create data dinsos gagal. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $data = $request->only(['nip','nama', 'alamat', 'gender', 'no_telp', 'username', 'email', 'password']);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'dinsos',
        ]);

        $data['id_pengguna'] = $user->id_pengguna;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('dinsos_') . '.' . $ext;

            $manager = new ImageManager(new Driver());

            // Simpan dalam 3 ukuran
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('dinsos/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('dinsos/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('dinsos/foto/lg/' . $filename, (string) $lg);

            $data['foto'] = $filename;
        }

        Dinso::create($data);
        return redirect()->route('admin.dinsos.index')->with('success', 'Dinso berhasil ditambahkan');
    }

    public function edit(Dinso $dinso)
    {
        $dinso->username = $dinso->user->username;
        $dinso->email = $dinso->user->email;
        return view('admin.dinsos.edit', compact('dinso'));
    }

    public function update(Request $request, Dinso $dinso)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:L,P',
            'username' => 'required|string',
            'email' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = "Update data dinsos gagal. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $user = $dinso->user;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $dinso->nama = $request->nama;
        $dinso->gender = $request->gender;
        $dinso->alamat = $request->alamat;
        $dinso->no_telp = $request->no_telp;

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($dinso->foto) {
                Storage::disk('public')->delete('dinsos/foto/sm/' . $dinso->foto);
                Storage::disk('public')->delete('dinsos/foto/md/' . $dinso->foto);
                Storage::disk('public')->delete('dinsos/foto/lg/' . $dinso->foto);
            }

            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('dinsos_') . '.' . $ext;

            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('dinsos/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('dinsos/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('dinsos/foto/lg/' . $filename, (string) $lg);

            $dinso->foto = $filename;
        }

        $dinso->save();
        return redirect()->route('admin.dinsos.index')->with('success', 'Dinsos berhasil diperbarui');
    }

    public function destroy(Dinso $dinso)
    {
        if ($dinso->foto) {
            Storage::disk('public')->delete('dinso/foto/sm/' . $dinso->foto);
            Storage::disk('public')->delete('dinso/foto/md/' . $dinso->foto);
            Storage::disk('public')->delete('dinso/foto/lg/' . $dinso->foto);
        }

        $dinso->delete();

        return redirect()->route('admin.dinsos.index')->with('success', 'Dinso berhasil dihapus');
    }
}
