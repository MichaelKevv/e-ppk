<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class FeedbackController extends Controller
{
    public function index()
    {
        // Ambil semua data feedback sesuai role user
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

        // Tambahkan kolom virtual 'judul_pengaduan'
        foreach ($data as $item) {
            if ($item->pengaduan) {
                $p = $item->pengaduan;
                $item->judul_pengaduan = implode(' | ', [
                    "ID: {$p->id_pengaduan}",
                    "Siswa: {$p->id_siswa}",
                    "Bentuk: {$p->bentuk_perundungan}",
                    "Frekuensi: {$p->frekuensi_kejadian}",
                    "Lokasi: {$p->lokasi}",
                    "Trauma: {$p->trauma_mental}",
                    "Luka: {$p->luka_fisik}",
                    "Pelaku: {$p->pelaku_lebih_dari_satu}",
                    "Konten: {$p->konten_digital}",
                    "Kata: {$p->jenis_kata}",
                    "Klasifikasi: {$p->klasifikasi}"
                ]);
            } else {
                $item->judul_pengaduan = '-';
            }
        }

        $title = 'Hapus Feedback';
        $text = 'Apakah anda yakin ingin menghapus feedback ini?';
        confirmDelete($title, $text);

        return view('admin.feedback.index', compact('data'));
    }

    public function create(Pengaduan $pengaduan)
    {
        return view('admin.feedback.create', compact('pengaduan'));
    }

    public function store(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
        ]);

        Feedback::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'nip' => Auth::user()->nip ?? null,
            'id_user' => Auth::id(),
            'isi_tanggapan' => $request->isi_tanggapan,
            'created_at' => now(),
        ]);

        $pengaduan->status = $request->status ?? 'diproses';
        $pengaduan->save();

        Alert::success('Berhasil', 'Feedback berhasil dikirim');
        return redirect()->route('admin.pengaduan.show', $pengaduan->id_pengaduan);
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['pengaduan', 'gurubk', 'user']);
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
