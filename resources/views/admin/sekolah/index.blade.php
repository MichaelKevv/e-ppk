@extends('admin.layouts.template')
@section('title', 'Master Data Sekolah')

@section('content')
<div class="space-y-6">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-blue-100 text-blue-700">Master Data</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Lembaga Terdaftar</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Data Sekolah</h1>
            <p class="text-xs text-slate-500 mt-1">
                Daftar institusi dan sekolah yang terafiliasi dengan sistem Lapora untuk pengawasan dan penanganan perundungan.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.sekolah.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Tambah Sekolah Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid across all schools -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Sekolah</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_sekolah'] }}</h3>
                    <span class="text-[10px] text-blue-600 font-semibold">Institusi Terdaftar</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Siswa Terdata</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_siswa'] }}</h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">Siswa Seluruh Sekolah</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Guru BK Aktif</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_guru_bk'] }}</h3>
                    <span class="text-[10px] text-purple-600 font-semibold">Konselor & Petugas</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Kasus Pengaduan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_pengaduan'] }}</h3>
                    <span class="text-[10px] text-amber-600 font-semibold">{{ $stats['total_laporan_aktif'] }} Laporan Siswa</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <form action="{{ route('admin.sekolah.index') }}" method="GET"
          class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sekolah, NPSN, atau kota..."
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Jenjang -->
            <select name="jenjang" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700">
                <option value="all">Semua Jenjang</option>
                <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD / MI</option>
                <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
            </select>

            <!-- Filter Status -->
            <select name="status_sekolah" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700">
                <option value="all">Semua Status</option>
                <option value="Negeri" {{ request('status_sekolah') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                <option value="Swasta" {{ request('status_sekolah') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
            </select>

            <!-- Filter Akreditasi -->
            <select name="akreditasi" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700">
                <option value="all">Semua Akreditasi</option>
                <option value="A" {{ request('akreditasi') == 'A' ? 'selected' : '' }}>Akreditasi A</option>
                <option value="B" {{ request('akreditasi') == 'B' ? 'selected' : '' }}>Akreditasi B</option>
                <option value="C" {{ request('akreditasi') == 'C' ? 'selected' : '' }}>Akreditasi C</option>
            </select>

            @if(request()->hasAny(['search', 'jenjang', 'status_sekolah', 'akreditasi']))
                <a href="{{ route('admin.sekolah.index') }}"
                   class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Sekolah Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Sekolah & NPSN</th>
                        <th class="p-4">Jenjang & Status</th>
                        <th class="p-4">Wilayah / Alamat</th>
                        <th class="p-4">Pimpinan</th>
                        <th class="p-4 text-center">Data Terintegrasi</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($sekolahList as $sekolah)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Sekolah & NPSN -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-base font-bold shadow-xs flex-shrink-0">
                                        @if($sekolah->logo)
                                            <img src="{{ asset('storage/sekolah/' . $sekolah->logo) }}" alt="Logo" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <i class="fa-solid fa-school"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.sekolah.show', $sekolah->id) }}" class="font-bold text-slate-900 hover:text-blue-600 transition-colors block text-sm">
                                            {{ $sekolah->nama_sekolah }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5 text-[11px] text-slate-400 font-mono">
                                            <span>NPSN: {{ $sekolah->npsn ?: '-' }}</span>
                                            <span>&bull;</span>
                                            <span class="text-blue-600">{{ $sekolah->email ?: '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jenjang & Status -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $sekolah->jenjang }} &bull; {{ $sekolah->status_sekolah }}
                                    </span>
                                    <span class="block text-[11px] font-semibold text-emerald-700">
                                        Akreditasi {{ $sekolah->akreditasi }}
                                    </span>
                                </div>
                            </td>

                            <!-- Wilayah -->
                            <td class="p-4">
                                <p class="text-slate-800 font-semibold truncate max-w-xs">{{ $sekolah->alamat ?: '-' }}</p>
                                <span class="text-[11px] text-slate-400 block">{{ $sekolah->kota ?? 'DKI Jakarta' }}, {{ $sekolah->provinsi ?? '' }}</span>
                            </td>

                            <!-- Pimpinan -->
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block">{{ $sekolah->kepala_sekolah ?: '-' }}</span>
                                <span class="text-[11px] text-slate-400 font-mono">NIP: {{ $sekolah->nip_kepala_sekolah ?: '-' }}</span>
                            </td>

                            <!-- Data Terintegrasi (Siswa, BK, Kasus) -->
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Siswa -->
                                    <span title="Jumlah Siswa" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                        <i class="fa-solid fa-user-graduate text-[10px]"></i>
                                        <span>{{ $sekolah->siswa_count }}</span>
                                    </span>
                                    <!-- Guru BK -->
                                    <span title="Guru BK" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-100">
                                        <i class="fa-solid fa-chalkboard-user text-[10px]"></i>
                                        <span>{{ $sekolah->guru_bk_count }}</span>
                                    </span>
                                    <!-- Pengaduan -->
                                    <span title="Kasus Pengaduan" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                                        <i class="fa-solid fa-bullhorn text-[10px]"></i>
                                        <span>{{ $sekolah->pengaduan_count }}</span>
                                    </span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail / Show -->
                                    <a href="{{ route('admin.sekolah.show', $sekolah->id) }}"
                                       title="Lihat Detail Profil & Data Sekolah"
                                       class="p-2 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}"
                                       title="Edit Data Sekolah"
                                       class="p-2 rounded-lg bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete -->
                                    @if($sekolahList->count() > 1)
                                        <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sekolah {{ $sekolah->nama_sekolah }}? Data yang terkait akan kehilangan relasi sekolah.')"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Sekolah"
                                                    class="p-2 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <i class="fa-solid fa-school-circle-xmark text-4xl mb-3 opacity-40 block"></i>
                                <p class="text-sm font-semibold">Tidak ada data sekolah yang cocok dengan pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sekolahList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $sekolahList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
