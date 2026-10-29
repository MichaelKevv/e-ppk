@extends('admin.layouts.template')
@section('title', 'Detail Feedback & Konseling')

@section('content')
<div class="space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.feedback.index') }}"
               class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-all shrink-0">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-1">
                    <i class="fa-solid fa-comments"></i>
                    <span>Sesi Konseling &amp; Tanggapan</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                    Detail Konseling Kasus
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Riwayat interaksi konseling, pendampingan, dan catatan penanganan kasus perundungan.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($feedback->pengaduan)
                <a href="{{ route('admin.pengaduan.show', $feedback->pengaduan->id_pengaduan) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition-all">
                    <i class="fa-solid fa-folder-open text-xs"></i>
                    <span>Buka Berkas Kasus</span>
                </a>
            @endif

            <a href="{{ route('admin.feedback.export') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                <span class="hidden sm:inline">Export PDF</span>
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1: Info Kasus & Siswa Terkait -->
        <div class="space-y-6">
            <!-- Kasus Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Kasus Pengaduan Terkait</h3>
                </div>

                @if ($feedback->pengaduan)
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Judul / Peristiwa</span>
                            <p class="font-bold text-slate-800 text-xs mt-0.5">
                                {{ $feedback->judul_pengaduan }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="text-slate-400 block text-[11px] font-semibold">Status Alur</span>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase bg-indigo-50 text-indigo-700 border-indigo-200 mt-1">
                                    {{ $feedback->pengaduan->status_label ?? ucfirst($feedback->pengaduan->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px] font-semibold">Tingkat Keparahan</span>
                                @php
                                    $klasifikasi = strtolower($feedback->pengaduan->klasifikasi ?? 'ringan');
                                    $kBadge = match($klasifikasi) {
                                        'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase {{ $kBadge }} mt-1">
                                    {{ $feedback->pengaduan->klasifikasi ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Lokasi Kejadian</span>
                            <p class="font-semibold text-slate-700 mt-0.5">
                                <i class="fa-solid fa-location-dot text-rose-500 mr-1"></i>
                                {{ $feedback->pengaduan->lokasi ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Deskripsi Singkat Laporan</span>
                            <div class="mt-1 p-3 bg-slate-50 rounded-xl text-slate-600 text-[11px] leading-relaxed max-h-36 overflow-y-auto custom-scrollbar border border-slate-100">
                                {!! nl2br(e($feedback->pengaduan->deskripsi ?? 'Tidak ada catatan deskripsi.')) !!}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Data pengaduan terkait telah dihapus dari sistem.</p>
                @endif
            </div>

            <!-- Korban/Siswa Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Profil Siswa / Korban</h3>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px] font-semibold">Nama Siswa</span>
                        <p class="font-bold text-slate-800 text-xs mt-0.5">
                            {{ $feedback->nama_siswa }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Kelas</span>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ $feedback->kelas_siswa }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Jurusan</span>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ $feedback->jurusan_siswa }}</p>
                        </div>
                    </div>

                    @if ($feedback->pengaduan && $feedback->pengaduan->siswa)
                        <div>
                            <span class="text-slate-400 block text-[11px] font-semibold">Kontak / No. Telepon</span>
                            <p class="font-semibold text-slate-700 mt-0.5">
                                {{ $feedback->pengaduan->siswa->no_telp ?? '-' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Column 2: Thread Percakapan & Tanggapan Konseling -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                            <i class="fa-solid fa-comments text-indigo-600"></i>
                            <span>Riwayat Bimbingan &amp; Konseling</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Percakapan dan tanggapan resmi yang tercatat untuk kasus pengaduan ini.
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        {{ count($thread) }} Tanggapan
                    </span>
                </div>

                <!-- Timeline / Chat Stream -->
                <div class="space-y-4">
                    @forelse ($thread as $msg)
                        @php
                            $msgRole = strtolower($msg->user->role ?? '');
                            $isCounselor = in_array($msgRole, ['gurubk', 'dinsos', 'admin', 'admin_it']);
                            $senderName = match($msgRole) {
                                'siswa' => $msg->user?->siswas->first()?->nama ?? $msg->user?->name ?? 'Siswa',
                                'gurubk' => $msg->user?->gurubks->first()?->nama ?? $msg->user?->name ?? 'Guru BK',
                                'dinsos' => $msg->user?->dinsos->first()?->nama ?? $msg->user?->name ?? 'Dinas Sosial',
                                default => $msg->user?->name ?? $msg->user?->username ?? 'Petugas Lapora',
                            };
                            $roleLabel = match($msgRole) {
                                'siswa' => 'Siswa / Korban',
                                'gurubk' => 'Guru BK (Konselor)',
                                'dinsos' => 'Dinas Sosial',
                                default => 'Administrator',
                            };
                            $roleBadgeClass = match($msgRole) {
                                'siswa' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'gurubk' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'dinsos' => 'bg-purple-50 text-purple-700 border-purple-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                            $avatarIcon = match($msgRole) {
                                'siswa' => 'fa-graduation-cap text-emerald-600',
                                'gurubk' => 'fa-chalkboard-user text-indigo-600',
                                'dinsos' => 'fa-building-shield text-purple-600',
                                default => 'fa-user-gear text-slate-600',
                            };
                            $isTargetMessage = ($msg->id_feedback === $feedback->id_feedback);
                        @endphp

                        <div class="p-4 sm:p-5 rounded-2xl border transition-all {{ $isTargetMessage ? 'border-indigo-300 bg-indigo-50/20 ring-1 ring-indigo-200' : 'border-slate-200/90 bg-white hover:border-slate-300' }}">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-sm">
                                        <i class="fa-solid {{ $avatarIcon }}"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h5 class="text-xs sm:text-sm font-extrabold text-slate-800">
                                                {{ $senderName }}
                                            </h5>
                                            @if ($isTargetMessage)
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-indigo-600 text-white uppercase">
                                                    Pesan Ini
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="px-2 py-0.2 rounded text-[10px] font-bold border {{ $roleBadgeClass }}">
                                                {{ $roleLabel }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 font-mono">
                                                {{ \Carbon\Carbon::parse($msg->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Edit (khusus pesan ini & admin/pembuat) -->
                                @if (Auth::id() === $msg->id_user || Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.feedback.edit', $msg->id_feedback) }}"
                                       title="Edit Catatan Tanggapan"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors text-xs">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Pesan Isi -->
                            <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-100 text-xs sm:text-sm text-slate-700 leading-relaxed font-sans whitespace-pre-line">
                                {!! strip_tags($msg->isi_tanggapan) !!}
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-slate-400 text-xs">Belum ada riwayat tanggapan untuk kasus ini.</p>
                    @endforelse
                </div>

                <!-- Tambah Tanggapan / Balas Konseling Langsung -->
                @if ($feedback->pengaduan)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-reply text-indigo-600 text-xs"></i>
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                                Kirim Arahan / Tanggapan Tambahan
                            </h4>
                        </div>

                        <form action="{{ route('admin.feedback.store', $feedback->pengaduan->id_pengaduan) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="id_pengaduan" value="{{ $feedback->pengaduan->id_pengaduan }}">
                            <textarea name="teks_tanggapan" rows="3" required
                                      placeholder="Tuliskan arahan konseling, perkembangan mediasi, atau pesan tindak lanjut..."
                                      class="w-full text-xs rounded-xl border border-slate-200 p-3.5 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all"></textarea>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-slate-500 font-medium">Perbarui Status Kasus:</span>
                                    <select name="status" class="text-xs rounded-xl border border-slate-200 py-1.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                                        <option value="">-- Tetap (Tidak Berubah) --</option>
                                        <option value="konseling">Konseling Berjalan</option>
                                        <option value="mediasi">Tahap Mediasi</option>
                                        <option value="selesai">Selesai (Kasus Teratasi)</option>
                                    </select>
                                </div>

                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition-all hover:scale-[1.02] active:scale-95">
                                    <i class="fa-solid fa-paper-plane text-xs"></i>
                                    <span>Kirim Tanggapan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
