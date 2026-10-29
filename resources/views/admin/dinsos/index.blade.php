@extends('admin.layouts.template')
@section('title', 'Data Dinas Sosial')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    genderFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-sky-100 text-sky-700">Master Data &bull; Mitra Instansi</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Pendampingan Sosial</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Data Petugas Dinas Sosial</h1>
            <p class="text-xs text-slate-500 mt-1">
                Daftar petugas pendamping dari Dinas Sosial yang berwenang dalam penanganan kasus perlindungan anak dan perundungan berat.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.dinsos.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-md shadow-sky-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Petugas Dinsos</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Petugas -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Petugas</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $data->count() }}</h3>
                    <span class="text-[10px] text-sky-600 font-semibold">Petugas Aktif Lapora</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-hands-holding-child"></i>
                </div>
            </div>
        </div>

        <!-- Pria -->
        @php
            $countLaki = $data->filter(fn($d) => strtoupper($d->gender) === 'L')->count();
            $countPerempuan = $data->filter(fn($d) => strtoupper($d->gender) === 'P')->count();
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Petugas Pria</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countLaki }}</h3>
                    <span class="text-[10px] text-indigo-600 font-semibold">Laki-laki</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-mars"></i>
                </div>
            </div>
        </div>

        <!-- Wanita -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Petugas Wanita</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countPerempuan }}</h3>
                    <span class="text-[10px] text-pink-600 font-semibold">Perempuan</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-venus"></i>
                </div>
            </div>
        </div>

        <!-- Wilayah Instansi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Yurisdiksi</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">Dinsos</h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">Tingkat Kota / Wilayah</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-building-shield"></i>
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
            <input type="text" x-model="search" placeholder="Cari nama, NIP, atau kontak..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
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

    <!-- Dinsos Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Identitas Petugas Dinsos</th>
                        <th class="p-4">NIP & Akun</th>
                        <th class="p-4">Gender</th>
                        <th class="p-4">Kontak / WhatsApp</th>
                        <th class="p-4">Alamat Domisili</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data as $dinsos)
                        @php
                            $gender = strtoupper($dinsos->gender);
                            $fotoPath = public_path('storage/dinsos/foto/sm/' . $dinsos->foto);
                            $hasFoto = !empty($dinsos->foto) && file_exists($fotoPath);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(
                                (search === '' ||
                                 '{{ strtolower(addslashes($dinsos->nama)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($dinsos->nip)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($dinsos->no_telp)) }}'.includes(search.toLowerCase())) &&
                                (genderFilter === 'all' || '{{ $gender }}' === genderFilter)
                            )">
                            
                            <!-- Foto & Nama -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold overflow-hidden shadow-xs flex-shrink-0">
                                        @if($hasFoto)
                                            <img src="{{ asset('storage/dinsos/foto/sm/' . $dinsos->foto) }}" alt="{{ $dinsos->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($dinsos->nama, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-sm">{{ $dinsos->nama }}</span>
                                        <span class="text-[10px] text-sky-600 font-medium">Petugas Pendamping</span>
                                    </div>
                                </div>
                            </td>

                            <!-- NIP & Akun -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="font-mono text-xs font-bold text-slate-800 block">{{ $dinsos->nip }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">&#64;{{ $dinsos->user->username ?? '-' }}</span>
                                </div>
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
                                <div class="space-y-1">
                                    @if(!empty($dinsos->no_telp))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $dinsos->no_telp) }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-[11px] font-mono font-bold text-slate-800 hover:text-emerald-600 transition-colors">
                                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                            <span>{{ $dinsos->no_telp }}</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                    <span class="block text-[11px] text-slate-400 truncate max-w-[170px]">{{ $dinsos->user->email ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Alamat -->
                            <td class="p-4">
                                <span class="text-slate-600 text-xs block max-w-xs truncate" title="{{ $dinsos->alamat }}">
                                    {{ $dinsos->alamat ?: '-' }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.dinsos.edit', $dinsos->id_dinsos) }}"
                                       title="Edit Data Petugas"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete via Form -->
                                    <form action="{{ route('admin.dinsos.destroy', $dinsos->id_dinsos) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas Dinsos {{ $dinsos->nama }}?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Petugas"
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
                                    <i class="fa-solid fa-hands-holding-child"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Belum Ada Data Dinas Sosial</h3>
                                <p class="text-xs text-slate-400 mt-1">Data petugas Dinsos yang terdaftar akan ditampilkan di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
