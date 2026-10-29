@extends('admin.layouts.template')
@section('title', 'Dashboard Utama')

@section('content')
<div class="space-y-6">

    <!-- 1. Hero / Welcome Banner -->
    <div class="relative overflow-hidden p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border border-slate-800 text-white shadow-lg">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Sistem Lapora Siaga &bull; Suara Kamu Penting</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang, {{ Auth::user()->nama_lengkap }}!
                </h1>
                @if(isset($sekolah) && $sekolah)
                    <div class="inline-flex items-center gap-2 mt-2 px-3.5 py-1.5 rounded-xl bg-white/10 border border-white/15 text-indigo-200 text-xs font-medium">
                        <i class="fa-solid fa-school text-indigo-400"></i>
                        <span>Satuan Pendidikan: <strong class="text-white">{{ $sekolah->nama_sekolah }}</strong> (NPSN: {{ $sekolah->npsn }} &bull; {{ $sekolah->jenjang }})</span>
                    </div>
                @else
                    <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                        Sistem pemantauan dan penanganan perundungan sekolah terpadu dengan klasifikasi otomatis ID3 dan evaluasi akseptasi TAM.
                    </p>
                @endif
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                @if (Auth::user()->isSiswa())
                    <a href="{{ route('admin.pengaduan.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-lg shadow-indigo-600/30 transition-all hover:scale-105 active:scale-95">
                        <i class="fa-solid fa-plus-circle text-sm"></i>
                        <span>Buat Pengaduan Baru</span>
                    </a>
                @else
                    <a href="{{ route('admin.statistik.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-md shadow-indigo-600/30 transition-all hover:scale-105 active:scale-95">
                        <i class="fa-solid fa-chart-line text-sm"></i>
                        <span>Statistik Eksekutif</span>
                    </a>
                    <a href="{{ route('admin.decision-tree.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/15 transition-colors">
                        <i class="fa-solid fa-sitemap text-sm"></i>
                        <span>Pohon Keputusan ID3</span>
                    </a>
                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/15 transition-colors">
                        <i class="fa-solid fa-table-list"></i>
                        <span>Semua Kasus</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Background Decorative Ornaments -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 -top-12 w-48 h-48 bg-purple-500/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- 2. Emergency Response Banner (Tanggap Darurat 1x24 Jam) -->
    @if (!Auth::user()->isSiswa() && isset($urgentKasusCount) && $urgentKasusCount > 0)
        <div class="relative overflow-hidden p-5 sm:p-6 rounded-3xl bg-gradient-to-r from-rose-900 via-rose-950 to-slate-900 border border-rose-500/40 text-white shadow-lg shadow-rose-950/20">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/20 border border-rose-400/40 text-rose-400 flex items-center justify-center shrink-0 shadow-inner">
                        <i class="fa-solid fa-triangle-exclamation text-xl animate-bounce"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-rose-500/30 border border-rose-400/30 text-rose-200 text-[11px] font-bold uppercase tracking-wider mb-1">
                            <span class="w-2 h-2 rounded-full bg-rose-400 animate-ping"></span>
                            <span>Protokol Siaga Tanggap Darurat 1x24 Jam</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black tracking-tight text-white">
                            Terdapat {{ $urgentKasusCount }} Kasus Tingkat Berat yang Membutuhkan Respon Segera!
                        </h3>
                        <p class="text-xs text-rose-200/80 mt-1 max-w-2xl leading-relaxed">
                            Laporan terindikasi mengalami luka fisik, trauma mental akut, atau perundungan berat. Tim Satgas PPK & Guru BK diwajibkan melakukan koordinasi pengamanan awal.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="{{ route('admin.pengaduan.index', ['filter_darurat' => 1]) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-md shadow-rose-600/30 transition-all hover:scale-105 active:scale-95">
                        <i class="fa-solid fa-shield-virus"></i>
                        <span>Buka Kasus Darurat ({{ $urgentKasusCount }})</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- 3. Key Performance Indicators (Stat Cards) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Card 1: Total Pengaduan -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Total Pengaduan</span>
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-200/60 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-2 tracking-tight">
                {{ $data['totalPengaduan'] ?? 0 }}
            </p>
            <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-indigo-600">+{{ $data['pengaduanBulanIni'] ?? 0 }}</span> kasus baru bulan ini
            </div>
        </div>

        <!-- Card 2: Sedang Diproses / Investigasi -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:border-amber-300 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Dalam Penanganan</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200/60 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-hourglass-half text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-2 tracking-tight">
                {{ $data['pengaduanDiproses'] ?? 0 }}
            </p>
            <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span>Investigasi & konseling aktif</span>
            </div>
        </div>

        <!-- Card 3: Kasus Selesai -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:border-emerald-300 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">Kasus Selesai</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-200/60 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-2 tracking-tight">
                {{ $data['pengaduanSelesai'] ?? 0 }}
            </p>
            <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-emerald-600">Mediasi & tuntas</span>
            </div>
        </div>

        <!-- Card 4: Siswa Terdaftar / Edukasi -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:border-purple-300 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">
                    {{ Auth::user()->isSiswa() ? 'Feedback Konseling' : 'Peserta Didik' }}
                </span>
                <div class="w-10 h-10 rounded-2xl bg-purple-50 border border-purple-200/60 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid {{ Auth::user()->isSiswa() ? 'fa-comments' : 'fa-user-graduate' }} text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-2 tracking-tight">
                {{ Auth::user()->isSiswa() ? ($data['totalFeedback'] ?? 0) : ($data['totalSiswa'] ?? 0) }}
            </p>
            <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-purple-600">{{ $data['totalArtikel'] ?? 0 }}</span> artikel edukasi aktif
            </div>
        </div>
    </div>

    @if (Auth::user()->isSiswa())
        <!-- ========================================== -->
        <!-- PORTAL SISWA: PELACAK STATUS LAPORAN AKTIF -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Active Case Progression Tracker (2 Kolom) -->
            <div class="lg:col-span-2 bg-white p-6 sm:p-7 rounded-3xl border border-indigo-100 shadow-md shadow-indigo-50/50 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 mb-1">
                            <i class="fa-solid fa-radar text-indigo-500 animate-pulse"></i>
                            <span>Pelacak Status Laporan Kasus</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Progres Penanganan Laporan Terkini Anda</h2>
                    </div>

                    @if ($activeKasus)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $activeKasus->status === 'selesai' || $activeKasus->status === 'ditutup' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            <span class="w-2 h-2 rounded-full {{ $activeKasus->status === 'selesai' || $activeKasus->status === 'ditutup' ? 'bg-emerald-500' : 'bg-amber-500 animate-ping' }}"></span>
                            <span>{{ $activeKasus->status_label }}</span>
                        </span>
                    @endif
                </div>

                @if ($activeKasus)
                    @php
                        $currentStatus = $activeKasus->status;
                        $statusOrder = ['diproses' => 1, 'investigasi' => 2, 'konseling' => 3, 'mediasi' => 4, 'selesai' => 5, 'ditutup' => 5];
                        $currentOrder = $statusOrder[$currentStatus] ?? 1;

                        $steps = [
                            ['order' => 1, 'title' => 'Laporan Masuk', 'icon' => 'fa-bullhorn', 'desc' => 'Diterima sistem'],
                            ['order' => 2, 'title' => 'Investigasi', 'icon' => 'fa-magnifying-glass', 'desc' => 'Pemeriksaan bukti'],
                            ['order' => 3, 'title' => 'Konseling BK', 'icon' => 'fa-comments', 'desc' => 'Sesi bimbingan'],
                            ['order' => 4, 'title' => 'Mediasi', 'icon' => 'fa-handshake', 'desc' => 'Penyelesaian pihak'],
                            ['order' => 5, 'title' => 'Selesai', 'icon' => 'fa-circle-check', 'desc' => 'Kasus ditutup'],
                        ];

                        $latestTindakan = $activeKasus->riwayatTindakan->sortByDesc('created_at')->first();
                    @endphp

                    <!-- Progress Bar Header -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-semibold">
                            <span class="text-slate-600 flex items-center gap-1.5">
                                <span class="font-mono font-bold text-slate-800">{{ $activeKasus->kode_kasus }}</span>
                                <span class="text-slate-400">&bull;</span>
                                <span class="capitalize">{{ $activeKasus->bentuk_perundungan }}</span>
                            </span>
                            <span class="text-indigo-600 font-extrabold">{{ $activeKasus->progress_percent }}% Selesai</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full transition-all duration-500"
                                 style="width: {{ $activeKasus->progress_percent }}%"></div>
                        </div>
                    </div>

                    <!-- 5-Stage Visual Stepper -->
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5 pt-1">
                        @foreach ($steps as $st)
                            @php
                                $isDone = $currentOrder > $st['order'];
                                $isNow = $currentOrder === $st['order'];
                            @endphp
                            <div class="p-3 rounded-2xl border text-center transition-all {{ $isNow ? 'bg-indigo-50/90 border-indigo-300 ring-2 ring-indigo-500/20 shadow-xs' : ($isDone ? 'bg-emerald-50/40 border-emerald-200 text-slate-700' : 'bg-slate-50 border-slate-200/80 text-slate-400 opacity-70') }}">
                                <div class="w-7 h-7 mx-auto rounded-full flex items-center justify-center text-xs mb-1.5 {{ $isNow ? 'bg-indigo-600 text-white shadow-sm' : ($isDone ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                                    @if($isDone)
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    @else
                                        <i class="fa-solid {{ $st['icon'] }} text-[10px]"></i>
                                    @endif
                                </div>
                                <span class="block font-bold text-[11px] leading-tight text-slate-800">{{ $st['title'] }}</span>
                                <span class="block text-[10px] text-slate-500 mt-0.5">{{ $st['desc'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Update Catatan Tindakan Terakhir -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs space-y-1.5">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-slate-700 flex items-center gap-1.5">
                                <i class="fa-solid fa-bell text-indigo-500"></i>
                                <span>Pembaruan Terkini dari Petugas BK:</span>
                            </span>
                            @if($latestTindakan)
                                <span class="text-slate-400 font-medium">{{ \Carbon\Carbon::parse($latestTindakan->created_at)->diffForHumans() }}</span>
                            @endif
                        </div>
                        <p class="text-slate-600 text-[11px] leading-relaxed">
                            {{ $latestTindakan ? $latestTindakan->catatan : 'Laporan telah diverifikasi ke dalam antrean investigasi tim konselor sekolah.' }}
                        </p>
                    </div>

                    <!-- Tombol Aksi Detail -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <span class="text-[11px] text-slate-500 flex items-center gap-1">
                            <i class="fa-solid fa-lock text-emerald-600"></i>
                            <span>Identitas dan seluruh rekaman konseling dijamin rahasia</span>
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.pengaduan.export_single', $activeKasus->id_pengaduan) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-all shadow-xs">
                                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                <span>Unduh Berita Acara</span>
                            </a>
                            <a href="{{ route('admin.pengaduan.show', $activeKasus->id_pengaduan) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition-all hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-timeline"></i>
                                <span>Lihat Pelacak Lengkap</span>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- State Belum Ada Laporan Aktif -->
                    <div class="text-center py-8 px-4 space-y-3">
                        <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto text-xl shadow-xs">
                            <i class="fa-solid fa-shield-heart"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Tidak Ada Laporan Pengaduan Aktif</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                            Sekolah adalah tempat belajar yang aman dan menyenangkan bagi semua. Jika kamu mengalami atau melihat perundungan, laporkan segera tanpa rasa takut.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('admin.pengaduan.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/25 transition-all hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-plus-circle"></i>
                                <span>Buat Laporan Baru Sekarang</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Pusat Bimbingan Konseling Sekolah (1 Kolom) -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400">Layanan Bimbingan Konseling</span>
                    <h3 class="text-base font-bold text-slate-800 mt-0.5">Kontak Konselor Sekolah</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Guru BK siap mendengarkan dan mendampingi permasalahanmu.</p>
                </div>

                <div class="space-y-3">
                    @forelse($guruBkList as $guru)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs shrink-0 shadow-xs">
                                {{ strtoupper(substr($guru->nama, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-800 truncate">{{ $guru->nama }}</h4>
                                <p class="text-[10px] text-slate-500">NIP: {{ $guru->nip }}</p>
                                @if($guru->no_telp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guru->no_telp) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold transition-colors border border-emerald-200">
                                        <i class="fa-brands fa-whatsapp text-xs text-emerald-600"></i>
                                        <span>Konsultasi WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/80 text-amber-800 text-xs space-y-1">
                            <div class="font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Guru BK Belum Ditugaskan</span>
                            </div>
                            <p class="text-[11px] leading-relaxed">
                                Petugas bimbingan konseling untuk sekolahmu sedang dalam penetapan data oleh pihak administrasi sekolah.
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Safe School Guarantee Note -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-indigo-900 text-xs">
                        <i class="fa-solid fa-hand-holding-heart text-indigo-600"></i>
                        <span>Komitmen Perlindungan Lapora</span>
                    </div>
                    <p class="text-[11px] text-indigo-800 leading-relaxed">
                        Kamu tidak sendirian. Kami menjamin perlindungan dari pembalasan (*retaliasi*) dan penanganan yang adil demi masa depanmu.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- 4. Charts & Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Complaint Trends Chart (2 Columns) -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tren Pengaduan Kasus Perundungan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Statistik insiden yang tercatat sepanjang tahun {{ date('Y') }}.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                        Periode Bulanan
                    </span>
                </div>
            </div>
            <div class="h-72 w-full">
                <canvas id="chartPengaduan"></canvas>
            </div>
        </div>

        <!-- Severity Breakdown & Algorithm Card (1 Column) -->
        <div class="space-y-6">
            <!-- Severity Distribution -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-indigo-600 text-sm"></i>
                        <span>Tingkat Keparahan Kasus</span>
                    </h3>
                    <span class="text-[11px] font-semibold text-slate-400">ID3</span>
                </div>

                @php
                    $totalKasus = ($data['totalPengaduan'] ?? 0) ?: 1;
                    $ringanPct = round((($data['pengaduanRingan'] ?? 0) / $totalKasus) * 100);
                    $sedangPct = round((($data['pengaduanSedang'] ?? 0) / $totalKasus) * 100);
                    $beratPct = round((($data['pengaduanBerat'] ?? 0) / $totalKasus) * 100);
                @endphp

                <div class="space-y-4 text-xs font-medium">
                    <!-- Ringan -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="font-bold text-emerald-700 flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Ringan
                            </span>
                            <span class="text-slate-600 font-semibold">{{ $data['pengaduanRingan'] ?? 0 }} kasus ({{ $ringanPct }}%)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $ringanPct }}%"></div>
                        </div>
                    </div>

                    <!-- Sedang -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="font-bold text-amber-700 flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Sedang
                            </span>
                            <span class="text-slate-600 font-semibold">{{ $data['pengaduanSedang'] ?? 0 }} kasus ({{ $sedangPct }}%)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: {{ $sedangPct }}%"></div>
                        </div>
                    </div>

                    <!-- Berat -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="font-bold text-rose-700 flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Berat
                            </span>
                            <span class="text-slate-600 font-semibold">{{ $data['pengaduanBerat'] ?? 0 }} kasus ({{ $beratPct }}%)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full transition-all duration-500" style="width: {{ $beratPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decision Tree ID3 Engine Card -->
            <div class="p-6 rounded-3xl bg-gradient-to-tr from-indigo-950 via-slate-900 to-indigo-900 border border-indigo-800 text-white shadow-md space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center text-indigo-300">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold">Decision Tree ID3</h4>
                            <p class="text-[11px] text-indigo-200">Klasifikasi Pohon Keputusan</p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                        Aktif
                    </span>
                </div>
                <p class="text-xs text-indigo-200/90 leading-relaxed">
                    Sistem mengklasifikasi tingkat keparahan kasus baru secara rekursif berbasis entropi data historis.
                </p>
                <div class="pt-2 flex items-center justify-between border-t border-indigo-800/80">
                    <span class="text-[11px] text-indigo-300">Entropy & Information Gain</span>
                    <a href="{{ route('admin.decision-tree.index') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-white hover:text-indigo-200 transition-colors">
                        <span>Buka Pohon</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Recent Complaints Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-800">Laporan Pengaduan Terkini</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar kasus perundungan terbaru yang masuk ke dalam sistem.</p>
            </div>
            <a href="{{ route('admin.pengaduan.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition-colors">
                <span>Lihat Semua Kasus</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Berkas Kasus</th>
                        <th class="p-4">Bentuk Perundungan</th>
                        <th class="p-4">Lokasi Kejadian</th>
                        <th class="p-4 text-center">Klasifikasi ID3</th>
                        <th class="p-4 text-center">Status Alur</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data['recentPengaduan'] ?? [] as $item)
                        @php
                            $badgeKlasifikasi = match($item->klasifikasi) {
                                'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                            $badgeStatus = match($item->status) {
                                'selesai', 'ditutup' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'mediasi' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'konseling' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'investigasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                default => 'bg-blue-50 text-blue-700 border-blue-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-slate-900 block font-mono text-xs">
                                    {{ $item->kode_kasus ?: '#' . $item->id_pengaduan }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    {{ $item->created_at?->format('d M Y, H:i') }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-800 capitalize">{{ $item->bentuk_perundungan }}</span>
                                @if($item->luka_fisik || $item->trauma_mental)
                                    <div class="flex items-center gap-1 mt-0.5">
                                        @if($item->luka_fisik)
                                            <span class="px-1.5 py-0.2 rounded-md bg-rose-100 text-rose-700 text-[9px] font-bold">Luka</span>
                                        @endif
                                        @if($item->trauma_mental)
                                            <span class="px-1.5 py-0.2 rounded-md bg-purple-100 text-purple-700 text-[9px] font-bold">Trauma</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 text-slate-600">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                    <span>{{ $item->lokasi ?? 'Lingkungan Sekolah' }}</span>
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full border text-[10px] font-bold uppercase {{ $badgeKlasifikasi }}">
                                    {{ $item->klasifikasi }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full border text-[10px] font-bold capitalize {{ $badgeStatus }}">
                                    {{ $item->status ?? 'diproses' }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.pengaduan.show', $item->id_pengaduan) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition-colors">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 opacity-50 block"></i>
                                Belum ada laporan pengaduan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ url("admin/pengaduan-data") }}')
            .then(res => res.json())
            .then(chartData => {
                const ctx = document.getElementById('chartPengaduan').getContext('2d');
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                // Create gradient background
                const gradient = ctx.createLinearGradient(0, 0, 0, 260);
                gradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)');
                gradient.addColorStop(1, 'rgba(79, 70, 229, 0.00)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Jumlah Pengaduan',
                            data: chartData,
                            borderColor: '#4F46E5',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointBackgroundColor: '#4F46E5',
                            pointBorderColor: '#FFFFFF',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0F172A',
                                padding: 12,
                                cornerRadius: 10,
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' Kasus Terdata';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    maxTicksLimit: 6,
                                    color: '#94A3B8',
                                    font: { size: 11 }
                                },
                                grid: { color: '#F1F5F9' }
                            },
                            x: {
                                ticks: { color: '#94A3B8', font: { size: 11 } },
                                grid: { display: false }
                            }
                        }
                    }
                });
            })
            .catch(err => console.error('Error fetching chart data:', err));
    });
</script>
@endpush