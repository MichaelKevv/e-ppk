@extends('admin.layouts.template')
@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    genderFilter: 'all',
    kelasFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-blue-100 text-blue-700">Master Data &bull; Data Sekolah</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Kompilasi Siswa</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Manajemen Data Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">
                Basis data kependidikan siswa terintegrasi, identitas kelas, dan hak akses pelaporan konseling Lapora.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.siswa.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Siswa Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Siswa Terdata</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $data->count() }}</h3>
                    <span class="text-[10px] text-blue-600 font-semibold">Pelajar Aktif</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
        </div>

        <!-- Laki-laki -->
        @php
            $countLaki = $data->filter(fn($s) => in_array(strtolower($s->gender), ['laki-laki', 'l', 'pria']))->count();
            $countPerempuan = $data->filter(fn($s) => in_array(strtolower($s->gender), ['perempuan', 'p', 'wanita']))->count();
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Siswa Laki-laki</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countLaki }}</h3>
                    <span class="text-[10px] text-sky-600 font-semibold">Laki-laki</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-mars"></i>
                </div>
            </div>
        </div>

        <!-- Perempuan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Siswa Perempuan</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countPerempuan }}</h3>
                    <span class="text-[10px] text-pink-600 font-semibold">Perempuan</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-venus"></i>
                </div>
            </div>
        </div>

        <!-- Lembaga Terkait -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Sekolah Afiliasi</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">
                        {{ $sekolahList->count() > 0 ? $sekolahList->count() : ($data->first()?->sekolah?->nama_sekolah ? 1 : '-') }}
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
        <!-- Live Search Input -->
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" x-model="search" placeholder="Cari nama, username, kelas, no. telp..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Sekolah (Khusus Admin) -->
            @if(isset($sekolahList) && $sekolahList->count() > 0)
                <form action="{{ route('admin.siswa.index') }}" method="GET" class="inline-block">
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
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>

            <!-- Reset Filters -->
            <button type="button" @click="search = ''; genderFilter = 'all'; kelasFilter = 'all';"
                    x-show="search !== '' || genderFilter !== 'all' || kelasFilter !== 'all'"
                    class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </button>
        </div>
    </div>

    <!-- Siswa Table (Desktop) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Identitas Siswa</th>
                        <th class="p-4">Sekolah & Kelas</th>
                        <th class="p-4">Gender</th>
                        <th class="p-4">Kontak & Akun</th>
                        <th class="p-4">Alamat Domisili</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data as $siswa)
                        @php
                            $genderKey = strtolower($siswa->gender);
                            $cleanGender = in_array($genderKey, ['laki-laki', 'l', 'pria']) ? 'laki-laki' : 'perempuan';
                            $fotoPath = public_path('storage/foto-siswa/' . $siswa->foto);
                            $hasFoto = !empty($siswa->foto) && file_exists($fotoPath);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(
                                (search === '' ||
                                 '{{ strtolower(addslashes($siswa->nama)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($siswa->user->username ?? '')) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($siswa->kelas)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($siswa->no_telp)) }}'.includes(search.toLowerCase())) &&
                                (genderFilter === 'all' || '{{ $cleanGender }}' === genderFilter)
                            )">
                            
                            <!-- Foto & Identitas -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold overflow-hidden shadow-xs flex-shrink-0">
                                        @if($hasFoto)
                                            <img src="{{ asset('storage/foto-siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($siswa->nama, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-sm">{{ $siswa->nama }}</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-mono">
                                                &#64;{{ $siswa->user->username ?? 'belum-ada-user' }}
                                            </span>
                                            @if($siswa->jurusan)
                                                <span class="text-[10px] text-slate-400">&bull; {{ $siswa->jurusan }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Sekolah & Kelas -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fa-solid fa-graduation-cap text-[10px]"></i>
                                        <span>Kelas {{ $siswa->kelas }}</span>
                                    </span>
                                    <span class="block text-[11px] text-slate-500 font-medium truncate max-w-xs">
                                        {{ $siswa->sekolah->nama_sekolah ?? 'Sekolah Terdaftar' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Gender -->
                            <td class="p-4">
                                @if($cleanGender === 'laki-laki')
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

                            <!-- Kontak & Akun -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_telp) }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-[11px] font-mono font-bold text-slate-800 hover:text-emerald-600 transition-colors">
                                        <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                        <span>{{ $siswa->no_telp }}</span>
                                    </a>
                                    <span class="block text-[11px] text-slate-400 truncate max-w-[180px]">
                                        {{ $siswa->user->email ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Alamat -->
                            <td class="p-4">
                                <span class="text-slate-600 text-xs block max-w-xs truncate" title="{{ $siswa->alamat }}">
                                    {{ $siswa->alamat ?: '-' }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}"
                                       title="Edit Data Siswa"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete via SweetAlert or Form -->
                                    <a href="{{ route('admin.siswa.destroy', $siswa->id_siswa) }}"
                                       title="Hapus Siswa"
                                       data-confirm-delete="true"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                    <i class="fa-solid fa-user-slash"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Belum Ada Data Siswa</h3>
                                <p class="text-xs text-slate-400 mt-1">Data siswa yang terdaftar akan ditampilkan pada tabel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection