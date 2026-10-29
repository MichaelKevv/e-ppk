@extends('admin.layouts.template')
@section('title', 'Detail Data Sekolah - ' . $sekolah->nama_sekolah)

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'siswa' }">

    <!-- Top Navigation & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.sekolah.index') }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Daftar Semua Sekolah</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Profil Lembaga</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">{{ $sekolah->nama_sekolah }}</h1>
            <p class="text-xs text-slate-500 mt-1">
                Pusat data kelembagaan sekolah terintegrasi dengan data Siswa, Guru BK, dan Kasus Pengaduan.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Sekolah</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards for this school -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Siswa Terdaftar</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_siswa'] }}</h3>
                    <span class="text-[10px] text-blue-600 font-semibold">Siswa di Sekolah Ini</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
        </div>

        <!-- Guru BK -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Guru BK</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_guru_bk'] }}</h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">Konselor Bertugas</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <!-- Kasus Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Kasus Masuk</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['pengaduan_aktif'] }}</h3>
                    <span class="text-[10px] text-amber-600 font-semibold">{{ $stats['diproses'] }} Kasus Diproses</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
            </div>
        </div>

        <!-- Kasus Selesai -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Kasus Selesai</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['selesai'] }}</h3>
                    <span class="text-[10px] text-purple-600 font-semibold">Tuntas Ditangani</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Identitas Pokok Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between pb-5 border-b border-slate-100 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl shadow-md shadow-blue-500/20 flex-shrink-0">
                    @if($sekolah->logo)
                        <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" alt="Logo" class="w-full h-full object-cover rounded-2xl">
                    @else
                        <i class="fa-solid fa-school"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">{{ $sekolah->nama_sekolah }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Akreditasi {{ $sekolah->akreditasi }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                            Jenjang {{ $sekolah->jenjang }} &bull; {{ $sekolah->status_sekolah }}
                        </span>
                        <span class="text-xs text-slate-500 font-mono">
                            NPSN: {{ $sekolah->npsn ?: '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Severity Pills -->
            <div class="flex items-center gap-2 text-xs">
                <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 font-bold border border-emerald-100">
                    Ringan: {{ $stats['ringan'] }}
                </span>
                <span class="px-3 py-1 rounded-xl bg-amber-50 text-amber-700 font-bold border border-amber-100">
                    Sedang: {{ $stats['sedang'] }}
                </span>
                <span class="px-3 py-1 rounded-xl bg-rose-50 text-rose-700 font-bold border border-rose-100">
                    Berat: {{ $stats['berat'] }}
                </span>
            </div>
        </div>

        <!-- Detail Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-xs">
            <div class="p-3.5 bg-slate-50 rounded-xl">
                <span class="text-slate-400 block mb-0.5">Kepala Sekolah</span>
                <p class="font-bold text-slate-800">{{ $sekolah->kepala_sekolah ?: '-' }}</p>
                <span class="text-[11px] text-slate-400 font-mono">NIP: {{ $sekolah->nip_kepala_sekolah ?: '-' }}</span>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl">
                <span class="text-slate-400 block mb-0.5">Telepon & Email</span>
                <p class="font-bold text-slate-800">{{ $sekolah->no_telp ?: '-' }}</p>
                <span class="text-[11px] text-blue-600">{{ $sekolah->email ?: '-' }}</span>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl sm:col-span-2">
                <span class="text-slate-400 block mb-0.5">Alamat Lengkap</span>
                <p class="font-semibold text-slate-800">
                    {{ $sekolah->alamat }}
                    @if($sekolah->kota), {{ $sekolah->kota }} {{ $sekolah->provinsi }}@endif
                </p>
            </div>
        </div>
    </div>

    <!-- Integrated School Data Tabs (Siswa, Guru BK, Pengaduan Kasus) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <!-- Tabs Nav -->
        <div class="flex items-center border-b border-slate-100 px-6 pt-4 gap-4 text-xs font-bold">
            <button type="button" @click="activeTab = 'siswa'"
                    :class="activeTab === 'siswa' ? 'border-b-2 border-blue-600 text-blue-600 pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors flex items-center gap-2">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Data Siswa ({{ $stats['total_siswa'] }})</span>
            </button>

            <button type="button" @click="activeTab = 'gurubk'"
                    :class="activeTab === 'gurubk' ? 'border-b-2 border-blue-600 text-blue-600 pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors flex items-center gap-2">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span>Data Guru BK ({{ $stats['total_guru_bk'] }})</span>
            </button>

            <button type="button" @click="activeTab = 'pengaduan'"
                    :class="activeTab === 'pengaduan' ? 'border-b-2 border-blue-600 text-blue-600 pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors flex items-center gap-2">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengaduan Kasus ({{ $stats['total_pengaduan'] }})</span>
            </button>

            <button type="button" @click="activeTab = 'visi'"
                    :class="activeTab === 'visi' ? 'border-b-2 border-blue-600 text-blue-600 pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors flex items-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Komitmen & Visi</span>
            </button>
        </div>

        <!-- Tab 1: Data Siswa -->
        <div x-show="activeTab === 'siswa'" class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Daftar Siswa Terdaftar di {{ $sekolah->nama_sekolah }}</h3>
                <a href="{{ route('admin.siswa.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Buka Manajemen Siswa &rarr;
                </a>
            </div>

            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3">Nama Siswa</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3">Jenis Kelamin</th>
                            <th class="p-3">No. Telp</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($siswaList as $s)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-bold text-slate-800">{{ $s->nama }}</td>
                                <td class="p-3 font-semibold">{{ $s->kelas }}</td>
                                <td class="p-3 capitalize">{{ $s->gender }}</td>
                                <td class="p-3 text-slate-500 font-mono">{{ $s->no_telp ?: '-' }}</td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}" class="text-blue-600 hover:underline font-semibold">
                                        Edit / Data Siswa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">
                                    Belum ada siswa yang terafiliasi dengan sekolah ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 2: Data Guru BK -->
        <div x-show="activeTab === 'gurubk'" class="p-6" style="display: none;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Guru Bimbingan Konseling di {{ $sekolah->nama_sekolah }}</h3>
                <a href="{{ route('admin.guru-bk.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Buka Manajemen Guru BK &rarr;
                </a>
            </div>

            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3">NIP & Nama</th>
                            <th class="p-3">Gender</th>
                            <th class="p-3">No. Kontak</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($guruBkList as $g)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3">
                                    <span class="font-bold text-slate-800 block">{{ $g->nama }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono">NIP: {{ $g->nip }}</span>
                                </td>
                                <td class="p-3 capitalize">{{ $g->gender }}</td>
                                <td class="p-3 font-mono text-slate-500">{{ $g->no_telp ?: '-' }}</td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.guru-bk.show', $g->nip) }}" class="text-blue-600 hover:underline font-semibold">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-slate-400">
                                    Belum ada Guru BK yang ditugaskan di sekolah ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 3: Pengaduan Kasus -->
        <div x-show="activeTab === 'pengaduan'" class="p-6" style="display: none;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Kasus Pengaduan di {{ $sekolah->nama_sekolah }}</h3>
                <a href="{{ route('admin.pengaduan.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    Buka Rekapitulasi Kasus &rarr;
                </a>
            </div>

            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3">Kode Kasus</th>
                            <th class="p-3">Bentuk Kasus</th>
                            <th class="p-3">Klasifikasi</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($pengaduanList as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-bold font-mono text-slate-900">{{ $p->kode_kasus ?: ('#' . $p->id_pengaduan) }}</td>
                                <td class="p-3 capitalize">{{ $p->bentuk_perundungan }} ({{ str_replace('_', ' ', $p->frekuensi_kejadian) }})</td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        {{ $p->klasifikasi === 'ringan' ? 'bg-emerald-50 text-emerald-700' : ($p->klasifikasi === 'sedang' ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">
                                        {{ $p->klasifikasi }}
                                    </span>
                                </td>
                                <td class="p-3 capitalize">{{ $p->status }}</td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.pengaduan.show', $p->id_pengaduan) }}" class="text-blue-600 hover:underline font-semibold">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">
                                    Belum ada kasus yang dilaporkan di sekolah ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 4: Komitmen & Visi -->
        <div x-show="activeTab === 'visi'" class="p-6" style="display: none;">
            <div class="max-w-2xl space-y-4 text-xs text-slate-700 leading-relaxed">
                <h3 class="text-sm font-bold text-slate-800">Komitmen Ramah Anak & Nol Toleransi Perundungan</h3>
                <div class="p-4 bg-blue-50/60 rounded-xl border border-blue-100">
                    {{ $sekolah->deskripsi ?: 'Sekolah ini berkomitmen mendukung terciptanya lingkungan belajar yang aman, ramah, dan bebas dari segala bentuk diskriminasi serta perundungan.' }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
