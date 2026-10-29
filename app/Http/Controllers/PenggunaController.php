<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PenggunaController extends Controller
{
    /**
     * Tampilkan semua akun pengguna terdaftar
     */
    public function index()
    {
        $data = User::with(['siswas', 'gurubks.sekolah', 'dinsos', 'admins'])->orderBy('created_at', 'desc')->get();

        $title = 'Hapus Pengguna';
        $text = "Apakah anda yakin ingin menghapus akun ini?";
        confirmDelete($title, $text);

        return view('admin.pengguna.index', compact('data'));
    }

    /**
     * Form tambah akun pengguna baru
     */
    public function create()
    {
        return view('admin.pengguna.create');
    }

    /**
     * Simpan akun pengguna baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'role' => 'required|in:admin,admin_it,gurubk,dinsos,siswa',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Berhasil', 'Akun pengguna berhasil ditambahkan');
        return redirect()->route('admin.pengguna.index');
    }

    /**
     * Form edit akun pengguna
     */
    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    /**
     * Update kredensial dan role akun pengguna
     */
    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username,' . $pengguna->id_pengguna . ',id_pengguna',
            'email' => 'required|email|max:100|unique:users,email,' . $pengguna->id_pengguna . ',id_pengguna',
            'role' => 'required|in:admin,admin_it,gurubk,dinsos,siswa',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pengguna->username = $request->username;
        $pengguna->email = $request->email;
        $pengguna->role = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        Alert::success('Berhasil', 'Data akun pengguna berhasil diperbarui');
        return redirect()->route('admin.pengguna.index');
    }

    /**
     * Hapus akun pengguna
     */
    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);

        if ($pengguna->id_pengguna === Auth::id()) {
            Alert::error('Gagal', 'Anda tidak dapat menghapus akun Anda yang sedang aktif.');
            return redirect()->back();
        }

        $pengguna->delete();

        Alert::success('Berhasil', 'Akun pengguna berhasil dihapus');
        return redirect()->route('admin.pengguna.index');
    }

    /**
     * Export daftar akun pengguna ke PDF
     */
    public function export()
    {
        $data = User::select('username', 'email', 'role as tipe')->get();
        $pdf = Pdf::loadView('admin.pengguna.export_pdf', ['data' => $data]);
        return $pdf->download('laporan-pengguna.pdf');
    }
}
