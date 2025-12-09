<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gurubk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GuruBKController extends Controller
{
    public function index()
    {
        $guruBks = Gurubk::orderBy('nama')->paginate(10);
        return view('admin.guru_bk.index', compact('guruBks'));
    }
    public function create()
    {
        return view('admin.guru_bk.create');
    }
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:gurubk,nip',
            'nama' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors()->all();
            $errorMessage = "Create data Guru BK gagal. periksa kembali data yang diinput.<br>";
            foreach ($errors as $error) {
                $errorMessage .= "$error";
            }
            $errorMessage .= "<br>";
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        $data = $request->all();


        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'gurubk',
        ]);

        $data['id_pengguna'] = $user->id_pengguna;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('admin_') . '.' . $ext;

            $manager = new ImageManager(new Driver());

            // Simpan dalam 3 ukuran
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('gurubk/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('gurubk/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('gurubk/foto/lg/' . $filename, (string) $lg);

            $data['foto'] = $filename;
        }

        Gurubk::create($data);

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil ditambahkan.');
    }
    public function show(Gurubk $guruBk)
    {
        return view('admin.guru_bk.show', compact('guruBk'));
    }
    public function edit(Gurubk $guruBk)
    {
        return view('admin.guru_bk.edit', compact('guruBk'));
    }
    public function update(Request $request, Gurubk $guruBk)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $user = $guruBk->user;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $guruBk->nama = $request->nama;
        $guruBk->gender = $request->gender;
        $guruBk->alamat = $request->alamat;
        $guruBk->no_telp = $request->no_telp;

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($guruBk->foto) {
                Storage::disk('public')->delete('gurubk/foto/sm/' . $guruBk->foto);
                Storage::disk('public')->delete('gurubk/foto/md/' . $guruBk->foto);
                Storage::disk('public')->delete('gurubk/foto/lg/' . $guruBk->foto);
            }

            $file = $request->file('foto');
            $ext = 'webp';
            $filename = uniqid('gurubk_') . '.' . $ext;

            $manager = new ImageManager(new Driver());
            $sm = $manager->read($file)->scale(150, 150)->toWebp(80);
            Storage::disk('public')->put('gurubk/foto/sm/' . $filename, (string) $sm);

            $md = $manager->read($file)->scale(400, 400)->toWebp(85);
            Storage::disk('public')->put('gurubk/foto/md/' . $filename, (string) $md);

            $lg = $manager->read($file)->scale(800, 800)->toWebp(90);
            Storage::disk('public')->put('gurubk/foto/lg/' . $filename, (string) $lg);

            $guruBk->foto = $filename;
        }

        $guruBk->save();

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil diperbarui.');
    }
    public function destroy(Gurubk $guruBk)
    {
        if ($guruBk->foto) {
            Storage::disk('public')->delete('gurubk/foto/sm/' . $guruBk->foto);
            Storage::disk('public')->delete('gurubk/foto/md/' . $guruBk->foto);
            Storage::disk('public')->delete('gurubk/foto/lg/' . $guruBk->foto);
        }

        $guruBk->delete();

        return redirect()->route('admin.guru-bk.index')
            ->with('success', 'Data Guru BK berhasil dihapus.');
    }
}
