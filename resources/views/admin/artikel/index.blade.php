@extends('admin.layouts.template')
@section('title', 'Artikel Edukasi')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    kategoriFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-emerald-100 text-emerald-700">Literasi & Edukasi</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Pencegahan Perundungan</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Artikel & Materi Edukasi</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola artikel panduan anti-bullying, materi bimbingan konseling, dan publikasi literasi perlindungan anak.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.artikel.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-pen-nib"></i>
                <span>Tulis Artikel Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Artikel -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Artikel</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $data->count() }}</h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">Publikasi Tayang</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
        </div>

        <!-- Kategori Edukasi -->
        @php
            $countEdukasi = $data->filter(fn($a) => strtolower($a->kategori) === 'edukasi')->count();
            $countTips = $data->filter(fn($a) => in_array(strtolower($a->kategori), ['tips', 'tips siswa', 'panduan']))->count();
            $kategoriList = $data->pluck('kategori')->unique()->filter();
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Materi Edukasi</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countEdukasi }}</h3>
                    <span class="text-[10px] text-blue-600 font-semibold">Wawasan Siswa</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
        </div>

        <!-- Tips & Panduan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Tips & Panduan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countTips }}</h3>
                    <span class="text-[10px] text-amber-600 font-semibold">Solusi Praktis</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
            </div>
        </div>

        <!-- Portal Publik Link -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Portal Publik</span>
                    <a href="{{ route('artikel.semua') }}" target="_blank"
                       class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 mt-2">
                        <span>Buka Katalog Publik</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-globe"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" x-model="search" placeholder="Cari judul artikel, topik, atau penulis..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Kategori -->
            <select x-model="kategoriFilter"
                    class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700 font-medium">
                <option value="all">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ strtolower($kat) }}">{{ $kat }}</option>
                @endforeach
            </select>

            <!-- Reset Filters -->
            <button type="button" @click="search = ''; kategoriFilter = 'all';"
                    x-show="search !== '' || kategoriFilter !== 'all'"
                    class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </button>
        </div>
    </div>

    <!-- Artikel Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Cover & Judul Artikel</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Ringkasan Konten</th>
                        <th class="p-4">Tanggal Rilis</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data as $artikel)
                        @php
                            $katKey = strtolower($artikel->kategori);
                            $badgeColor = match($katKey) {
                                'edukasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'tips', 'tips siswa' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'hukum', 'regulasi' => 'bg-purple-50 text-purple-700 border-purple-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200'
                            };
                            $coverUrl = !empty($artikel->gambar_sm) ? asset($artikel->gambar_sm) : asset('admin/img/landscape-placeholder.svg');
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(
                                (search === '' ||
                                 '{{ strtolower(addslashes($artikel->judul)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes(strip_tags($artikel->konten))) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($artikel->admin->nama ?? '')) }}'.includes(search.toLowerCase())) &&
                                (kategoriFilter === 'all' || '{{ $katKey }}' === kategoriFilter)
                            )">
                            
                            <!-- Cover & Judul -->
                            <td class="p-4 max-w-sm">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-16 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 shadow-2xs">
                                        <img src="{{ $coverUrl }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}"
                                           class="font-bold text-slate-900 hover:text-emerald-600 transition-colors block text-sm line-clamp-1">
                                            {{ $artikel->judul }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 block mt-0.5">ID: #{{ $artikel->id_artikel }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="p-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeColor }}">
                                    {{ $artikel->kategori }}
                                </span>
                            </td>

                            <!-- Konten Excerpt -->
                            <td class="p-4 max-w-xs">
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($artikel->konten), 90) }}
                                </p>
                            </td>

                            <!-- Tanggal Rilis -->
                            <td class="p-4 whitespace-nowrap">
                                <span class="text-slate-800 font-semibold block">{{ $artikel->created_at?->format('d M Y') }}</span>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $artikel->created_at?->format('H:i') }} WIB</span>
                            </td>

                            <!-- Penulis -->
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($artikel->admin->nama ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800 text-xs">{{ $artikel->admin->nama ?? 'Administrator' }}</span>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Preview Portal -->
                                    <a href="{{ route('artikel.detail', $artikel->id_artikel) }}" target="_blank"
                                       title="Lihat di Portal Publik"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 transition-colors">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}"
                                       title="Edit Artikel"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Artikel"
                                                class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Belum Ada Artikel</h3>
                                <p class="text-xs text-slate-400 mt-1">Publikasi artikel dan materi edukasi baru akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
