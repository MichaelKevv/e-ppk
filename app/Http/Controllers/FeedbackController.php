<?php

namespace App\Http\Controllers;

use App\Models\TbFeedback;
use App\Models\TbPengaduan;
use App\Models\TbSiswa;
use App\Models\TbPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $data = TbFeedback::where('id_siswa', session('userdata')->id_siswa)
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $data = TbFeedback::orderBy('created_at', 'desc')->get();
        }
        $title = 'Hapus Pengaduan';
        $text = "Apakah anda yakin untuk hapus?";
        confirmDelete($title, $text);
        return view('feedback/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TbPengaduan $pengaduan)
    {
        return view('feedback.create', compact('pengaduan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $pengaduanId)
    {
        $pengaduan = TbPengaduan::findOrFail($pengaduanId);

        $request->validate([
            'teks_tanggapan' => 'required|string',
        ]);

        $pengaduan->status = $request->status;
        $pengaduan->save();

        TbFeedback::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_petugas' => session('userdata')->id_petugas,
            'id_siswa' => $pengaduan->id_siswa,
            'teks_tanggapan' => $request->teks_tanggapan,
            'status' => 'diproses',
        ]);
        Alert::success("Success", "Berhasil memberikan feedback");

        return redirect()->route('pengaduan.show', $pengaduan->id_pengaduan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TbFeedback $feedback)
    {
        $pengaduan = TbPengaduan::where('id_pengaduan', $feedback->id_pengaduan)->first();
        return view('feedback.detail', compact('feedback', 'pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TbSiswa $pengaduan)
    {
        $pengguna = TbPengguna::find($pengaduan->id_pengguna);
        return view('pengaduan/edit', compact('pengaduan', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TbSiswa $pengaduan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'username' => 'required|string|unique:tb_pengguna,username,' . $pengaduan->id_pengguna . ',id_pengguna',
            'email' => 'required|email|unique:tb_pengguna,email,' . $pengaduan->id_pengguna . ',id_pengguna',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pengguna = TbPengguna::findOrFail($pengaduan->id_pengguna);

            $pengguna->username = $request->username;
            $pengguna->email = $request->email;
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }
            $pengguna->save();
            $pengaduan->nama = $request->nama;
            $pengaduan->kelas = $request->kelas;
            $pengaduan->jurusan = $request->jurusan;
            $pengaduan->alamat = $request->alamat;
            $pengaduan->no_telp = $request->no_telp;
            $pengaduan->save();

            DB::commit();

            Alert::success("Success", "Data berhasil diperbarui");

            return redirect("pengaduan");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TbSiswa $pengaduan)
    {
        DB::beginTransaction();

        try {
            $pengguna = TbPengguna::findOrFail($pengaduan->id_pengguna);

            $pengaduan->delete();

            $pengguna->delete();

            DB::commit();

            Alert::success("Success", "Data berhasil dihapus");

            return redirect("pengaduan");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function export()
    {
        $feedback = TbFeedback::all();
        $pdf = Pdf::loadview('feedback.export_pdf', ['data' => $feedback]);
        return $pdf->download('laporan-feedback.pdf');
    }
}
