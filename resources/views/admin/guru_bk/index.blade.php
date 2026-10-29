@extends('admin.layouts.template')
@section('title', 'Data Guru BK')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    genderFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-purple-100 text-purple-700">Master Data &bull; Data Sekolah</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Konselor & Petugas BK</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Manajemen Guru BK</h1>
            <p class="text-xs text-slate-500 mt-1">
                Daftar konselor bimbingan konseling dan penanggung jawab penanganan perundungan di masing-masing sekolah.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.guru-bk.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Guru BK Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Guru BK -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Guru BK</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $guruBks->total() }}</h3>
                    <span class="text-[10px] text-purple-600 font-semibold">Konselor Bertugas</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <!-- Guru Laki-laki -->
        @php
            $countLaki = $guruBks->filter(fn($g) => strtoupper($g->gender) === 'L')->count();
            $countPerempuan = $guruBks->filter(fn($g) => strtoupper($g->gender) === 'P')->count();
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Konselor Pria</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countLaki }}</h3>
                    <span class="text-[10px] text-sky-600 font-semibold">Laki-laki</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-mars"></i>
                </div>
            </div>
        </div>

        <!-- Guru Perempuan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Konselor Wanita</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countPerempuan }}</h3>
                    <span class="text-[10px] text-pink-600 font-semibold">Perempuan</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-venus"></i>
                </div>
            </div>
        </div>

        <!-- Lembaga Sekolah -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Sekolah Naungan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">
                        {{ $sekolahList->count() > 0 ? $sekolahList->count() : ($guruBks->first()?->sekolah?->nama_sekolah ? 1 : '-') }}
                    </h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">Satuan Pendidikan</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <!-- Live Search -->
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" x-model="search" placeholder="Cari nama, NIP, no. telepon..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Sekolah (Khusus Admin) -->
            @if(isset($sekolahList) && $sekolahList->count() > 0)
                <form action="{{ route('admin.guru-bk.index') }}" method="GET" class="inline-block">
                    <select name="id_sekolah" onchange="this.form.submit()"
                            class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700 font-medium">
                        <option value="">Semua Sekolah</option>
                        @foreach($sekolahList as $sek)
                            <option value="{{ $sek->id }}" {{ (string)$selectedSekolahId === (string)$sek->id ? 'selected' : '' }}>
                                {{ Str::limit($sek->nama_sekolah, 28) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            <!-- Filter Gender -->
            <select x-model="genderFilter"
                    class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700 font-medium">
                <option value="all">Semua Gender</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <!-- Reset Filters -->
            <button type="button" @click="search = ''; genderFilter = 'all';"
                    x-show="search !== '' || genderFilter !== 'all'"
                    class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </button>
        </div>
    </div>

    <!-- Guru BK Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Identitas Guru BK</th>
                        <th class="p-4">NIP & Kredensial</th>
                        <th class="p-4">Sekolah Penugasan</th>
                        <th class="p-4">Gender</th>
                        <th class="p-4">Kontak / WhatsApp</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($guruBks as $guruBk)
                        @php
                            $gender = strtoupper($guruBk->gender);
                            $fotoPath = public_path('storage/gurubk/foto/sm/' . $guruBk->foto);
                            $hasFoto = !empty($guruBk->foto) && file_exists($fotoPath);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(
                                (search === '' ||
                                 '{{ strtolower(addslashes($guruBk->nama)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($guruBk->nip)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($guruBk->no_telp ?? '')) }}'.includes(search.toLowerCase())) &&
                                (genderFilter === 'all' || '{{ $gender }}' === genderFilter)
                            )">
                            
                            <!-- Foto & Nama -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold overflow-hidden shadow-xs flex-shrink-0">
                                        @if($hasFoto)
                                            <img src="{{ asset('storage/gurubk/foto/sm/' . $guruBk->foto) }}" alt="{{ $guruBk->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($guruBk->nama, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.guru-bk.show', $guruBk->nip) }}" class="font-bold text-slate-900 hover:text-purple-600 transition-colors block text-sm">
                                            {{ $guruBk->nama }}
                                        </a>
                                        <span class="text-[10px] text-slate-400">Konselor Siswa</span>
                                    </div>
                                </div>
                            </td>

                            <!-- NIP & Kredensial -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="font-mono text-xs font-bold text-slate-800 block">{{ $guruBk->nip }}</span>
                                    <span class="text-[10px] text-purple-600 font-mono">&#64;{{ $guruBk->user->username ?? 'user-bk' }}</span>
                                </div>
                            </td>

                            <!-- Sekolah Penugasan -->
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    <i class="fa-solid fa-school text-[10px]"></i>
                                    <span>{{ $guruBk->sekolah->nama_sekolah ?? 'Sekolah Terdaftar' }}</span>
                                </span>
                            </td>

                            <!-- Gender -->
                            <td class="p-4">
                                @if($gender === 'L')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                        <i class="fa-solid fa-mars text-[10px]"></i>
                                        <span>Laki-laki</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-pink-50 text-pink-700 border border-pink-200">
                                        <i class="fa-solid fa-venus text-[10px]"></i>
                                        <span>Perempuan</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Kontak -->
                            <td class="p-4">
                                @if(!empty($guruBk->no_telp))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guruBk->no_telp) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 text-xs font-mono font-bold text-slate-800 hover:text-emerald-600 transition-colors">
                                        <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                        <span>{{ $guruBk->no_telp }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.guru-bk.show', $guruBk->nip) }}"
                                       title="Lihat Profil Lengkap"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-purple-50 text-slate-600 hover:text-purple-600 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}"
                                       title="Edit Guru BK"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.guru-bk.destroy', $guruBk->nip) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Guru BK {{ $guruBk->nama }}?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Guru BK"
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
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Belum Ada Data Guru BK</h3>
                                <p class="text-xs text-slate-400 mt-1">Data guru BK yang terdaftar akan ditampilkan pada tabel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guruBks->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $guruBks->links() }}
            </div>
        @endif
    </div>

</div>
@endsection