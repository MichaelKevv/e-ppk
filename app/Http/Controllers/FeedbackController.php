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
        $user = Auth::user();
        if ($user && $user->role == 'siswa') {
            $data = Feedback::with(['pengaduan.siswa', 'pengaduan.user.siswas', 'user.siswas'])
                ->whereHas('pengaduan', function ($q) use ($user) {
                    $q->where('id_user', $user->id_pengguna);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $data = Feedback::with(['pengaduan.siswa', 'pengaduan.user.siswas', 'gurubk', 'user.siswas', 'user.gurubks', 'user.dinsos'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = $data->map(function ($item) {
            if ($item->pengaduan) {
                $p = $item->pengaduan;
                $pUser = $p->user;
                $namaSiswa = $p->siswa?->nama ?? ($pUser && $pUser->siswas->isNotEmpty() ? $pUser->siswas->first()->nama : "Siswa #{$p->id_user}");
                $kelasSiswa = $p->siswa?->kelas ?? ($pUser && $pUser->siswas->isNotEmpty() ? $pUser->siswas->first()->kelas : '-');
                $jurusanSiswa = $p->siswa?->jurusan ?? ($pUser && $pUser->siswas->isNotEmpty() ? $pUser->siswas->first()->jurusan : '-');
                $lokasi = $p->lokasi ? ucfirst($p->lokasi) : 'Lokasi tidak spesifik';
                $bentuk = $p->bentuk_perundungan ? ucfirst($p->bentuk_perundungan) : 'Kasus Perundungan';

                $item->judul_pengaduan = "{$bentuk} di {$lokasi} - {$namaSiswa}";
                $item->nama_siswa = $namaSiswa;
                $item->kelas_siswa = $kelasSiswa;
                $item->jurusan_siswa = $jurusanSiswa;
                $item->status_pengaduan = $p->status;
                $item->klasifikasi_pengaduan = $p->klasifikasi;
            } else {
                $item->judul_pengaduan = 'Pengaduan Terhapus';
                $item->nama_siswa = '-';
                $item->kelas_siswa = '-';
                $item->jurusan_siswa = '-';
                $item->status_pengaduan = 'selesai';
                $item->klasifikasi_pengaduan = null;
            }

            // Identifikasi nama dan role pengirim
            if ($item->id_user) {
                $u = $item->user ?? User::find($item->id_user);
                if ($u) {
                    if ($u->role === 'siswa') {
                        $item->nama_pengirim = $u->siswas->first()?->nama ?? $u->name ?? $u->username;
                        $item->role_pengirim = 'Siswa (Korban/Pelapor)';
                    } elseif ($u->role === 'gurubk') {
                        $item->nama_pengirim = $u->gurubks->first()?->nama ?? $u->name ?? $u->username;
                        $item->role_pengirim = 'Guru BK (Konselor)';
                    } elseif ($u->role === 'dinsos') {
                        $item->nama_pengirim = $u->dinsos->first()?->nama ?? $u->name ?? $u->username;
                        $item->role_pengirim = 'Dinas Sosial';
                    } elseif ($u->role === 'kepala_sekolah') {
                        $item->nama_pengirim = $u->name ?? $u->username;
                        $item->role_pengirim = 'Kepala Sekolah';
                    } else {
                        $item->nama_pengirim = $u->name ?? $u->username ?? 'Administrator';
                        $item->role_pengirim = 'Admin';
                    }
                } else {
                    $item->nama_pengirim = 'Pengguna #' . $item->id_user;
                    $item->role_pengirim = 'Petugas';
                }
            } else {
                $item->nama_pengirim = 'Petugas BK / Admin';
                $item->role_pengirim = 'Konselor';
            }

            return $item;
        });

        // Metrik Statistik Ringkas
        $totalFeedback = $data->count();
        $totalKasus = $data->pluck('id_pengaduan')->filter()->unique()->count();
        $totalBulanIni = $data->filter(function ($item) {
            return $item->created_at && \Carbon\Carbon::parse($item->created_at)->isCurrentMonth();
        })->count();
        $totalSurvey = \App\Models\SurveyData::count();

        return view('admin.feedback.index', compact('data', 'totalFeedback', 'totalKasus', 'totalBulanIni', 'totalSurvey'));
    }

    public function create(Pengaduan $pengaduan)
    {
        if ($pengaduan) {
            $p = $pengaduan;
            $user = User::find($p->id_user);
            $namaSiswa = $user && $user->siswas->isNotEmpty() ? $user->siswas[0]->nama : ($p->siswa?->nama ?? "Siswa #{$p->id_user}");
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

        $user = Auth::user();
        $nip = $user->isGuruBk() ? $user->guruBk?->nip : null;

        Feedback::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'nip' => $nip,
            'id_user' => $user->id_pengguna,
            'isi_tanggapan' => $request->teks_tanggapan,
            'created_at' => now(),
        ]);

        if ($request->filled('status')) {
            $pengaduan->status = $request->status;
            $pengaduan->save();
        }

        return redirect()->route('admin.pengaduan.show', $pengaduan->id_pengaduan)
            ->with('success', 'Pesan tanggapan dan arahan konseling berhasil dikirimkan.');
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['pengaduan.siswa', 'pengaduan.user.siswas', 'gurubk', 'user.siswas', 'user.gurubks', 'user.dinsos']);

        if ($feedback->pengaduan) {
            $p = $feedback->pengaduan;
            $user = $p->user ?? User::find($p->id_user);
            $namaSiswa = $p->siswa?->nama ?? ($user && $user->siswas->isNotEmpty() ? $user->siswas[0]->nama : "Siswa #{$p->id_user}");
            $lokasi = $p->lokasi ? ucfirst($p->lokasi) : 'Lokasi tidak diketahui';
            $bentuk = $p->bentuk_perundungan ? ucfirst($p->bentuk_perundungan) : 'Perundungan';
            $feedback->judul_pengaduan = "{$bentuk} di {$lokasi} - {$namaSiswa}";
            $feedback->nama_siswa = $namaSiswa;
            $feedback->kelas_siswa = $p->siswa?->kelas ?? ($user && $user->siswas->isNotEmpty() ? $user->siswas[0]->kelas : '-');
            $feedback->jurusan_siswa = $p->siswa?->jurusan ?? ($user && $user->siswas->isNotEmpty() ? $user->siswas[0]->jurusan : '-');
        } else {
            $feedback->judul_pengaduan = 'Pengaduan Terhapus';
            $feedback->nama_siswa = '-';
            $feedback->kelas_siswa = '-';
            $feedback->jurusan_siswa = '-';
        }

        if ($feedback->id_user) {
            $user = $feedback->user ?? User::find($feedback->id_user);
            if ($user && $user->role == 'siswa') {
                $siswa = $user->siswas()->first();
                $feedback->nama_pengirim = $siswa ? $siswa->nama : ($user->name ?? $user->username);
                $feedback->role_pengirim = 'Siswa (Korban/Pelapor)';
            } elseif ($user && $user->role == 'gurubk') {
                $guru = $user->gurubks()->first();
                $feedback->nama_pengirim = $guru ? $guru->nama : ($user->name ?? $user->username);
                $feedback->role_pengirim = 'Guru BK (Konselor)';
            } elseif ($user && $user->role == 'dinsos') {
                $dinsos = $user->dinsos()->first();
                $feedback->nama_pengirim = $dinsos ? $dinsos->nama : ($user->name ?? $user->username);
                $feedback->role_pengirim = 'Dinas Sosial';
            } else {
                $feedback->nama_pengirim = $user?->name ?? $user?->username ?? 'Administrator';
                $feedback->role_pengirim = ucfirst($user?->role ?? 'Admin');
            }
        } else {
            $feedback->nama_pengirim = 'Petugas BK / Admin';
            $feedback->role_pengirim = 'Konselor';
        }

        // Muat seluruh percakapan/tanggapan terkait pengaduan yang sama (Conversation Thread)
        $thread = [];
        if ($feedback->id_pengaduan) {
            $thread = Feedback::with(['user.siswas', 'user.gurubks', 'user.dinsos'])
                ->where('id_pengaduan', $feedback->id_pengaduan)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.feedback.detail', compact('feedback', 'thread'));
    }

    public function edit(Feedback $feedback)
    {
        $feedback->load(['pengaduan.siswa', 'pengaduan.user']);
        return view('admin.feedback.edit', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
        ]);

        $feedback->update([
            'isi_tanggapan' => $request->isi_tanggapan,
        ]);

        return redirect()->route('admin.feedback.show', $feedback->id_feedback)
            ->with('success', 'Catatan tanggapan/konseling berhasil diperbarui.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        Alert::success('Berhasil', 'Feedback berhasil dihapus');
        return redirect()->route('admin.feedback.index');
    }

    public function export()
    {
        $feedback = Feedback::with(['pengaduan.siswa', 'pengaduan.user.siswas', 'gurubk', 'user'])->get();
        $pdf = Pdf::loadview('admin.feedback.export_pdf', ['data' => $feedback]);
        return $pdf->download('laporan-feedback-konseling.pdf');
    }
}
