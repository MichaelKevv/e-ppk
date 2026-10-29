@extends('admin.layouts.template')
@section('title', 'Detail Kasus ' . ($pengaduan->kode_kasus ?? '#' . $pengaduan->id_pengaduan))

@section('content')
<div class="space-y-6" x-data="{ modalTindakan: false }">

    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Daftar Pengaduan Kasus</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-mono font-bold text-slate-500">{{ $pengaduan->kode_kasus ?? ('#' . $pengaduan->id_pengaduan) }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2.5">
                <span>Berkas Kasus: {{ ucfirst($pengaduan->bentuk_perundungan) }}</span>
                @php
                    $badgeKlasifikasi = match($pengaduan->klasifikasi) {
                        'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp
                <span class="px-2.5 py-0.5 rounded-full border text-xs font-black uppercase tracking-wider {{ $badgeKlasifikasi }}">
                    Tingkat {{ $pengaduan->klasifikasi }}
                </span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Dilaporkan pada {{ $pengaduan->created_at?->format('d F Y, H:i') }} WIB &bull; Sumber: <span class="font-semibold">{{ $pengaduan->sumber === 'history' ? 'Dataset Historis' : 'Laporan Siswa' }}</span>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Cetak PDF -->
            <a href="{{ route('admin.pengaduan.export_single', $pengaduan->id_pengaduan) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-pdf text-rose-600"></i>
                <span>Cetak Berkas Kasus PDF</span>
            </a>

            <!-- Tombol Update Tindakan (Khusus Guru BK, Admin, Dinsos) -->
            @if (Auth::user()->role !== 'siswa')
                <button type="button" @click="modalTindakan = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>Perbarui Tahap Kasus</span>
                </button>
            @endif
        </div>
    </div>

    @if($pengaduan->is_darurat)
        <!-- Emergency Response Alert Header -->
        <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-rose-500/10 via-rose-500/5 to-transparent border border-rose-300 text-rose-900 flex items-start gap-3.5 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                <i class="fa-solid fa-triangle-exclamation text-base animate-pulse"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-black uppercase tracking-wider">
                        STATUS DARURAT 1x24 JAM
                    </span>
                    <span class="text-xs text-rose-800 font-bold">Perlindungan Intensif Diperlukan</span>
                </div>
                <p class="text-xs text-rose-800/90 leading-relaxed">
                    Berdasarkan asesmen indikator (<strong>{{ $pengaduan->luka_fisik ? 'Terindikasi Luka Fisik, ' : '' }}{{ $pengaduan->trauma_mental ? 'Terindikasi Trauma Mental, ' : '' }}Klasifikasi {{ ucfirst($pengaduan->klasifikasi) }}</strong>), berkas ini masuk dalam kategori prioritas tinggi. Petugas konselor diwajibkan melakukan intervensi pendampingan pertama dan pengamanan saksi/korban.
                </p>
            </div>
        </div>
    @endif

    <!-- Interactive Case Progression Stepper -->
    @php
        $currentStatus = $pengaduan->status;
        $steps = [
            ['key' => 'diproses', 'label' => '1. Laporan Masuk', 'icon' => 'fa-bullhorn', 'desc' => 'Laporan diterima & diklasifikasi ID3'],
            ['key' => 'investigasi', 'label' => '2. Investigasi', 'icon' => 'fa-magnifying-glass', 'desc' => 'Pemeriksaan bukti & saksi'],
            ['key' => 'konseling', 'label' => '3. Konseling BK', 'icon' => 'fa-comments', 'desc' => 'Pendampingan psikologis siswa'],
            ['key' => 'mediasi', 'label' => '4. Mediasi', 'icon' => 'fa-handshake', 'desc' => 'Pertemuan pihak & orang tua'],
            ['key' => 'selesai', 'label' => '5. Kasus Selesai', 'icon' => 'fa-circle-check', 'desc' => 'Penyelesaian tuntas & evaluasi'],
        ];

        $statusOrder = ['diproses' => 1, 'investigasi' => 2, 'konseling' => 3, 'mediasi' => 4, 'selesai' => 5, 'ditutup' => 5];
        $currentOrder = $statusOrder[$currentStatus] ?? 1;
    @endphp

    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Alur Tahapan Penanganan Kasus</span>
                <h3 class="text-sm font-bold text-slate-800 mt-0.5">
                    Status Saat Ini: <span class="text-blue-600 font-extrabold">{{ $pengaduan->status_label }}</span>
                </h3>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-700">{{ $pengaduan->progress_percent }}%</span>
                <div class="w-24 sm:w-32 h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: {{ $pengaduan->progress_percent }}%"></div>
                </div>
            </div>
        </div>

        <!-- Stepper Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 pt-2">
            @foreach($steps as $idx => $step)
                @php
                    $stepOrder = $statusOrder[$step['key']] ?? 1;
                    $isPassed = $currentOrder > $stepOrder;
                    $isCurrent = $currentOrder === $stepOrder;
                @endphp
                <div class="relative p-3.5 rounded-xl border text-xs transition-all
                    {{ $isCurrent ? 'bg-blue-50/80 border-blue-300 ring-2 ring-blue-500/20 shadow-xs' : ($isPassed ? 'bg-emerald-50/50 border-emerald-200 text-slate-700' : 'bg-slate-50/60 border-slate-200 text-slate-400') }}">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-sm">
                            @if($isPassed)
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            @elseif($isCurrent)
                                <i class="fa-solid fa-circle-dot text-blue-600 animate-pulse"></i>
                            @else
                                <i class="fa-regular fa-circle text-slate-300"></i>
                            @endif
                        </span>
                        <i class="fa-solid {{ $step['icon'] }} {{ $isCurrent ? 'text-blue-600' : ($isPassed ? 'text-emerald-600' : 'text-slate-300') }} text-sm"></i>
                    </div>
                    <span class="font-bold block {{ $isCurrent ? 'text-blue-900' : ($isPassed ? 'text-emerald-900' : 'text-slate-500') }}">
                        {{ $step['label'] }}
                    </span>
                    <span class="text-[10px] block mt-0.5 leading-snug {{ $isCurrent ? 'text-blue-700' : ($isPassed ? 'text-emerald-700' : 'text-slate-400') }}">
                        {{ $step['desc'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Case Information Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Identitas Korban / Pelapor & Pelaku -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-users text-blue-600"></i>
                    <span>Pihak yang Terlibat & Lokasi Kejadian</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block mb-1">Korban / Pelapor</span>
                        <p class="font-bold text-slate-800 text-sm">{{ $pengaduan->nama_pelapor ?: ($pengaduan->nama_siswa ?: 'Pelapor Anonim (Dirahasiakan)') }}</p>
                        @if($pengaduan->kelas_siswa)
                            <span class="text-[11px] text-slate-500 font-semibold block mt-0.5">Kelas: {{ $pengaduan->kelas_siswa }}</span>
                        @endif
                        @if($pengaduan->sekolah)
                            <span class="text-[11px] text-blue-600 block mt-0.5">{{ $pengaduan->sekolah->nama_sekolah }}</span>
                        @endif
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block mb-1">Terduga Pelaku</span>
                        <p class="font-bold text-slate-800 text-sm">{{ $pengaduan->nama_pelaku ?: 'Tidak Diketahui' }}</p>
                        <span class="text-[11px] text-slate-500 block mt-0.5">
                            Karakteristik: {{ $pengaduan->pelaku_lebih_dari_satu ? 'Pelaku Berkelompok (> 1 Orang)' : 'Pelaku Tunggal' }}
                        </span>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 sm:col-span-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Lokasi & Frekuensi Kejadian</span>
                                <p class="font-bold text-slate-800">{{ $pengaduan->lokasi ?: 'Lingkungan Sekolah' }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-slate-200/70 text-slate-700 font-bold text-[11px] capitalize w-fit">
                                Frekuensi: {{ str_replace('_', ' ', $pengaduan->frekuensi_kejadian) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Indikator Perundungan (ID3 Attributes) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <span>Indikator Bukti Klinis & Dampak (Atribut ID3)</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <!-- Luka Fisik -->
                    <div class="p-3.5 rounded-xl border text-center {{ $pengaduan->luka_fisik ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                        <i class="fa-solid fa-bandage text-lg mb-1 block {{ $pengaduan->luka_fisik ? 'text-rose-600' : 'text-slate-400' }}"></i>
                        <span class="font-bold block">Luka Fisik</span>
                        <span class="text-[10px] font-semibold">{{ $pengaduan->luka_fisik ? 'Teridentifikasi (Ada)' : 'Tidak Ada' }}</span>
                    </div>

                    <!-- Trauma Mental -->
                    <div class="p-3.5 rounded-xl border text-center {{ $pengaduan->trauma_mental ? 'bg-purple-50 border-purple-200 text-purple-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                        <i class="fa-solid fa-brain text-lg mb-1 block {{ $pengaduan->trauma_mental ? 'text-purple-600' : 'text-slate-400' }}"></i>
                        <span class="font-bold block">Trauma Mental</span>
                        <span class="text-[10px] font-semibold">{{ $pengaduan->trauma_mental ? 'Tertekan / Takut' : 'Tidak Ada' }}</span>
                    </div>

                    <!-- Pelaku > 1 -->
                    <div class="p-3.5 rounded-xl border text-center {{ $pengaduan->pelaku_lebih_dari_satu ? 'bg-amber-50 border-amber-200 text-amber-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                        <i class="fa-solid fa-users text-lg mb-1 block {{ $pengaduan->pelaku_lebih_dari_satu ? 'text-amber-600' : 'text-slate-400' }}"></i>
                        <span class="font-bold block">Pelaku > 1 Orang</span>
                        <span class="text-[10px] font-semibold">{{ $pengaduan->pelaku_lebih_dari_satu ? 'Kelompok / Geng' : 'Individu' }}</span>
                    </div>

                    <!-- Konten Digital -->
                    <div class="p-3.5 rounded-xl border text-center {{ $pengaduan->konten_digital ? 'bg-sky-50 border-sky-200 text-sky-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                        <i class="fa-solid fa-mobile-screen-button text-lg mb-1 block {{ $pengaduan->konten_digital ? 'text-sky-600' : 'text-slate-400' }}"></i>
                        <span class="font-bold block">Bukti Digital</span>
                        <span class="text-[10px] font-semibold">{{ $pengaduan->konten_digital ? 'Ada Jejak Siber' : 'Tidak Ada' }}</span>
                    </div>
                </div>

                @if($pengaduan->jenis_kata)
                    <div class="p-3 bg-amber-50/60 rounded-xl border border-amber-200/80 text-xs text-amber-900">
                        <span class="font-bold block mb-0.5">Ujaran / Kata-kata yang Digunakan:</span>
                        <p class="font-mono text-[11px] italic">"{{ $pengaduan->jenis_kata }}"</p>
                    </div>
                @endif
            </div>

            <!-- Deskripsi & Bukti Foto -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-blue-600"></i>
                    <span>Kronologi Kejadian & Bukti Pendukung</span>
                </h3>

                <div class="p-4 bg-slate-50 rounded-xl text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $pengaduan->deskripsi ?: 'Tidak ada uraian kronologi tertulis pada berkas ini.' }}
                </div>

                @if($pengaduan->foto)
                    <div>
                        <span class="text-xs font-bold text-slate-700 block mb-2">Lampiran Bukti Foto Kasus:</span>
                        <a href="{{ asset('storage/pengaduan/foto/lg/' . $pengaduan->foto) }}" target="_blank" class="inline-block group">
                            <img src="{{ asset('storage/pengaduan/foto/lg/' . $pengaduan->foto) }}" alt="Bukti Kasus"
                                 class="max-w-xs h-auto rounded-xl border border-slate-200 shadow-xs group-hover:scale-105 transition-transform">
                            <span class="text-[11px] text-blue-600 font-semibold block mt-1 group-hover:underline">Buka Gambar Penuh &rarr;</span>
                        </a>
                    </div>
                @endif

                @if($pengaduan->kesimpulan_kasus)
                    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 text-xs text-emerald-950">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="fa-solid fa-handshake text-emerald-600"></i>
                            <span>Kesimpulan & Kesepakatan Akhir Penanganan Kasus:</span>
                        </div>
                        <p class="leading-relaxed">{{ $pengaduan->kesimpulan_kasus }}</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Timeline Riwayat Penanganan Kasus -->
        <div class="space-y-6">

            <!-- Action Timeline Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-blue-600 text-sm"></i>
                        <h3 class="text-sm font-bold text-slate-800">Riwayat Penanganan</h3>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                        {{ $pengaduan->riwayatTindakan->count() }} Tindakan
                    </span>
                </div>

                <!-- Timeline Entries -->
                <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 text-xs">
                    <!-- Event 0: Laporan Masuk -->
                    <div class="relative">
                        <div class="absolute -left-6 top-0 w-4 h-4 rounded-full bg-blue-600 border-2 border-white shadow-xs"></div>
                        <div>
                            <span class="text-[10px] text-slate-400 block font-mono">{{ $pengaduan->created_at?->format('d M Y, H:i') }}</span>
                            <h4 class="font-bold text-slate-800 text-xs mt-0.5">Laporan Didaftarkan ke Sistem</h4>
                            <p class="text-slate-500 mt-0.5 text-[11px]">
                                Kasus masuk dan diklasifikasikan secara otomatis oleh model Decision Tree sebagai <b>Tingkat {{ ucfirst($pengaduan->klasifikasi) }}</b>.
                            </p>
                        </div>
                    </div>

                    <!-- Riwayat Tindakan Berurutan -->
                    @forelse($pengaduan->riwayatTindakan as $tindakan)
                        @php
                            $colorDot = match($tindakan->status_tahap) {
                                'investigasi' => 'bg-amber-500',
                                'konseling' => 'bg-indigo-500',
                                'mediasi' => 'bg-purple-500',
                                'selesai', 'ditutup' => 'bg-emerald-500',
                                default => 'bg-blue-500',
                            };
                            $badgePeran = match($tindakan->peran_petugas) {
                                'Guru BK' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Dinas Sosial' => 'bg-sky-50 text-sky-700 border-sky-200',
                                default => 'bg-purple-50 text-purple-700 border-purple-200',
                            };
                        @endphp
                        <div class="relative pt-1">
                            <div class="absolute -left-6 top-1 w-4 h-4 rounded-full {{ $colorDot }} border-2 border-white shadow-xs"></div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $badgePeran }}">
                                        {{ $tindakan->peran_petugas ?: 'Petugas' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $tindakan->created_at->format('d M Y, H:i') }}</span>
                                </div>

                                <h4 class="font-bold text-slate-800 text-xs">{{ $tindakan->judul_tindakan }}</h4>
                                <p class="text-slate-600 text-[11px] leading-relaxed">{{ $tindakan->catatan }}</p>

                                @if($tindakan->rekomendasi)
                                    <div class="pt-1.5 border-t border-slate-200/60 text-[11px] text-indigo-700">
                                        <span class="font-semibold block">Rekomendasi / Rencana Lanjut:</span>
                                        <p>{{ $tindakan->rekomendasi }}</p>
                                    </div>
                                @endif

                                @if($tindakan->lampiran)
                                    <a href="{{ asset('storage/tindakan/' . $tindakan->lampiran) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 hover:underline pt-1">
                                        <i class="fa-solid fa-paperclip"></i>
                                        <span>Lihat Dokumen Berita Acara</span>
                                    </a>
                                @endif

                                <span class="text-[10px] text-slate-400 block pt-0.5">Oleh: {{ $tindakan->nama_petugas }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="relative pt-1">
                            <p class="text-slate-400 italic text-[11px]">Belum ada catatan investigasi atau sesi konseling tambahan.</p>
                        </div>
                    @endforelse
                </div>

                @if(Auth::user()->role !== 'siswa')
                    <div class="pt-2">
                        <button type="button" @click="modalTindakan = true"
                                class="w-full py-2.5 rounded-xl border border-dashed border-blue-300 bg-blue-50/50 hover:bg-blue-50 text-blue-700 text-xs font-bold transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus-circle"></i>
                            <span>Catat Tindakan Baru</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Ruang Konsultasi & Pesan Siswa / Petugas Konselor -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-indigo-600"></i>
                        <span>{{ Auth::user()->isSiswa() ? 'Ruang Konsultasi Bersama Guru BK' : 'Pesan & Tanggapan Konseling' }}</span>
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        <i class="fa-solid fa-lock text-[8px]"></i>
                        <span>Privat & Aman</span>
                    </span>
                </div>

                <!-- Chat history -->
                @if($pengaduan->feedback->count() > 0)
                    <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                        @foreach($pengaduan->feedback as $fb)
                            @php
                                $isMe = $fb->id_user === Auth::id();
                            @endphp
                            <div class="p-3.5 rounded-2xl text-xs space-y-1 {{ $isMe ? 'bg-indigo-50/80 border border-indigo-200/60 ml-4' : 'bg-slate-50 border border-slate-200/80 mr-4' }}">
                                <div class="flex items-center justify-between text-[10px]">
                                    <span class="font-bold {{ $isMe ? 'text-indigo-800' : 'text-slate-800' }}">
                                        {{ $isMe ? 'Anda (' . Auth::user()->nama_lengkap . ')' : ($fb->user?->nama_lengkap ?? 'Petugas Konselor') }}
                                    </span>
                                    <span class="text-slate-400 font-medium">{{ \Carbon\Carbon::parse($fb->created_at)->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-line">{{ $fb->isi_tanggapan }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400 italic text-xs py-1">Belum ada pesan atau pertanyaan lanjutan pada berkas ini.</p>
                @endif

                <!-- Form Balas Pesan -->
                <form action="{{ route('admin.feedback.store', $pengaduan->id_pengaduan) }}" method="POST" class="pt-2 border-t border-slate-100 space-y-3">
                    @csrf
                    <div>
                        <textarea name="teks_tanggapan" rows="2" required
                                  placeholder="{{ Auth::user()->isSiswa() ? 'Tuliskan pertanyaan, perasaan, atau perkembangan baru untuk Guru BK...' : 'Tuliskan arahan konseling atau pertanyaan kepada pelapor...' }}"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all resize-none"></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                            <span>Pesan hanya dapat dibaca oleh Anda & Guru BK</span>
                        </span>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm shadow-indigo-600/20 transition-all hover:scale-105 active:scale-95">
                            <i class="fa-solid fa-paper-plane text-[10px]"></i>
                            <span>Kirim Pesan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @if(Auth::user()->role !== 'siswa')
        <!-- Modal Form: Perbarui Tahap Penanganan Kasus (Khusus Guru BK & Admin) -->
        <div x-show="modalTindakan"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="modalTindakan = false"
                 class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-xl w-full p-6 sm:p-8 space-y-5 animate-in fade-in zoom-in-95 duration-200">

                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Catat Tindakan & Perbarui Tahap Kasus</h3>
                        <p class="text-xs text-slate-500">Rekam setiap sesi investigasi, konseling, mediasi, atau penyelesaian akhir kasus.</p>
                    </div>
                    <button type="button" @click="modalTindakan = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.pengaduan.tindakan.store', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Pilih Tahap Baru -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Tahap Penanganan Selanjutnya <span class="text-rose-500">*</span></label>
                        <select name="status_tahap" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                            <option value="investigasi" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Tahap 2: Investigasi Bukti & Saksi</option>
                            <option value="konseling" {{ $pengaduan->status == 'investigasi' ? 'selected' : '' }}>Tahap 3: Sesi Konseling Bimbingan Siswa</option>
                            <option value="mediasi" {{ $pengaduan->status == 'konseling' ? 'selected' : '' }}>Tahap 4: Proses Mediasi & Pemanggilan Pihak Terkait</option>
                            <option value="selesai" {{ $pengaduan->status == 'mediasi' ? 'selected' : '' }}>Tahap 5: Kasus Selesai (Tuntas Ditangani)</option>
                            <option value="ditutup">Kasus Selesai & Ditutup (Arsip)</option>
                        </select>
                    </div>

                    <!-- Judul Tindakan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul / Bentuk Tindakan <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul_tindakan" required placeholder="Contoh: Sesi Konseling Individu Korban & Penguatan Mental"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                    </div>

                    <!-- Catatan Hasil -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Hasil Tindakan / Laporan Investigasi <span class="text-rose-500">*</span></label>
                        <textarea name="catatan" rows="3" required placeholder="Deskripsikan fakta yang ditemukan, dinamika sesi konseling, atau kesepakatan yang dicapai..."
                                  class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden"></textarea>
                    </div>

                    <!-- Rekomendasi Lanjut -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Rekomendasi Tindak Lanjut <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="rekomendasi" placeholder="Contoh: Pemantauan interaksi kelas selama 2 minggu ke depan"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                    </div>

                    <!-- Kesimpulan Kasus jika selesai -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kesimpulan / Kesepakatan Akhir Kasus <span class="text-slate-400 font-normal">(Jika kasus selesai)</span></label>
                        <textarea name="kesimpulan_kasus" rows="2" placeholder="Tuliskan jika penanganan telah tuntas (contoh: Kedua pihak saling memaafkan dan menandatangani surat komitmen damai)..."
                                  class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden"></textarea>
                    </div>

                    <!-- Upload Dokumen Berita Acara -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Lampiran / Berita Acara <span class="text-slate-400 font-normal">(PDF / Foto max 5MB)</span></label>
                        <input type="file" name="lampiran" accept=".pdf,image/*"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-slate-50 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="modalTindakan = false"
                                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                            Simpan Tindakan Kasus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection
