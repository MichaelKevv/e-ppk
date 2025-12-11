<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class FeedbackController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $data = Feedback::where('id_user', Auth::id())
                ->with(['pengaduan', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $data = Feedback::with(['pengaduan', 'gurubk', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $data = $data->map(function ($item) {
            if ($item->pengaduan) {
                $p = $item->pengaduan;
                $user = User::find($p->id_user);
                $namaSiswa = $user ? $user->siswas[0]->nama : "Siswa #{$p->id_user}";
                $lokasi = $p->lokasi ? ucfirst($p->lokasi) : 'Lokasi tidak diketahui';
                $bentuk = $p->bentuk_perundungan ? ucfirst($p->bentuk_perundungan) : 'Tidak diketahui';
                $item->judul_pengaduan = "{$bentuk} di {$lokasi} - {$namaSiswa}";
            } else {
                $item->judul_pengaduan = '-';
            }

            return $item;
        });

        return view('admin.feedback.index', compact('data'));
    }


    public function create(Pengaduan $pengaduan)
    {
        if ($pengaduan) {
            $p = $pengaduan;
            $user = User::find($p->id_user);
            $namaSiswa = $user ? $user->siswas[0]->nama : "Siswa #{$p->id_user}";
            $lokasi = $p->lokasi ? ucfirst($p->lokasi) : 'Lokasi tidak diketahui';
            $bentuk = $p->bentuk_perundungan ? ucfirst($p->bentuk_perundungan) : 'Tidak diketahui';
            $judul_pengaduan = "{$bentuk} di {$lokasi} - {$namaSiswa}";
        } else {
            $judul_pengaduan = '-';
        }

        return view('admin.feedback.create', compact('pengaduan', 'judul_pengaduan'));
    }


    public function store(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'teks_tanggapan' => 'required|string',
        ]);

        Feedback::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'nip' => Auth::user()->nip,
            'id_user' => Auth::id(),
            'isi_tanggapan' => $request->teks_tanggapan, // gunakan teks_tanggapan dari form
            'created_at' => now(),
        ]);

        // update status pengaduan
        $pengaduan->status = $request->status ?? 'diproses';
        $pengaduan->save();
        return redirect()->route('admin.pengaduan.show', $pengaduan->id_pengaduan)->with('success', 'Feedback berhasil dikirim');
    }


    public function show(Feedback $feedback)
    {
        $feedback->load(['pengaduan', 'gurubk', 'user']);
        if ($feedback->pengaduan) {
            $p = $feedback->pengaduan;
            $user = User::find($p->id_user);
            $namaSiswa = $user ? $user->siswas[0]->nama : "Siswa #{$p->id_user}";
            $lokasi = $p->lokasi ? ucfirst($p->lokasi) : 'Lokasi tidak diketahui';
            $bentuk = $p->bentuk_perundungan ? ucfirst($p->bentuk_perundungan) : 'Tidak diketahui';
            $feedback->judul_pengaduan = "{$bentuk} di {$lokasi} - {$namaSiswa}";
        } else {
            $feedback->judul_pengaduan = '-';
        }

        if ($feedback->id_user) {
            $user = User::find($feedback->id_user);
            if ($user && $user->role == 'siswa') {
                $siswa = $user->siswas()->first();
                $feedback->nama_pengirim = $siswa ? $siswa->nama . " - " . $user->role : "User #{$feedback->id_user}";
            } else if ($user && $user->role == 'gurubk') {
                $guru = $user->gurubks()->first();
                $feedback->nama_pengirim = $guru ? $guru->nama . " - " . $user->role : "User #{$feedback->id_user}";
            }
        } else {
            $feedback->nama_pengirim = 'Admin';
        }

        return view('admin.feedback.detail', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        Alert::success('Berhasil', 'Feedback berhasil dihapus');
        return redirect()->route('admin.feedback.index');
    }

    public function export()
    {
        $feedback = Feedback::with(['pengaduan', 'gurubk', 'user'])->get();
        $pdf = Pdf::loadview('admin.feedback.export_pdf', ['data' => $feedback]);
        return $pdf->download('laporan-feedback.pdf');
    }
}
