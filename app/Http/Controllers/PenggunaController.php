<?php

namespace App\Http\Controllers;

use App\Models\Dinso;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PenggunaController extends Controller
{
    /**
     * Tampilkan semua pengguna dari tabel siswa, admin, dan dinso
     */
    public function index()
    {
        $data = User::with('admins')->get();

        $title = 'Hapus Pengguna';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);

        return view('admin.pengguna.index', compact('data'));
    }

    /**
     * Form edit pengguna berdasarkan tipe
     */
    public function edit($tipe, $id)
    {
        if ($tipe === 'siswa') {
            $pengguna = Siswa::findOrFail($id);
        } elseif ($tipe === 'admin') {
            $pengguna = Admin::findOrFail($id);
        } else {
            $pengguna = Dinso::findOrFail($id);
        }

        return view('admin.pengguna.edit', compact('pengguna', 'tipe'));
    }

    /**
     * Update data pengguna berdasarkan tipe
     */
    public function update(Request $request, $tipe, $id)
    {
        $model = $tipe === 'siswa' ? new Siswa : ($tipe === 'admin' ? new Admin : new Dinso);
        $pengguna = $model->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna->nama = $request->username;
            $pengguna->email = $request->email;

            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }

            $pengguna->save();

            DB::commit();

            Alert::success("Success", "Data pengguna berhasil diperbarui");
            return redirect()->route('admin.pengguna.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    /**
     * Hapus pengguna berdasarkan tipe
     */
    public function destroy($tipe, $id)
    {
        if ($tipe === 'siswa') {
            $pengguna = Siswa::findOrFail($id);
        } elseif ($tipe === 'admin') {
            $pengguna = Admin::findOrFail($id);
        } else {
            $pengguna = Dinso::findOrFail($id);
        }

        $pengguna->delete();

        Alert::success("Success", "Data pengguna berhasil dihapus");
        return redirect()->route('admin.pengguna.index');
    }

    /**
     * Export semua pengguna ke PDF
     */
    public function export()
    {
        $data = collect()
            ->merge(Siswa::select('nama as username', 'email', DB::raw("'siswa' as tipe"))->get())
            ->merge(Admin::select('nama as username', 'email', DB::raw("'admin' as tipe"))->get())
            ->merge(Dinso::select('nama as username', 'email', DB::raw("'dinso' as tipe"))->get());

        $pdf = Pdf::loadview('pengguna.export_pdf', ['data' => $data]);
        return $pdf->download('laporan-pengguna.pdf');
    }
}
