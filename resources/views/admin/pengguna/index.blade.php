@extends('admin.layouts.template')
@section('title', 'Manajemen Akun Pengguna')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    roleFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-purple-100 text-purple-700">Keamanan & Akses</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Kredensial Sistem</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Manajemen Akun Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola hak akses, peranan pengguna (Role Based Access Control), serta kredensial akun dalam ekosistem Lapora.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.pengguna.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Akun Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards across all Roles -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3.5">
        <!-- Total Akun -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[11px] font-semibold text-slate-500 block">Total Pengguna</span>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $data->count() }}</h3>
            <span class="text-[10px] text-slate-400 font-medium">Semua Akun Aktif</span>
        </div>

        <!-- Admin -->
        @php
            $countAdmin = $data->filter(fn($u) => in_array($u->role, ['admin', 'admin_it']))->count();
            $countBK = $data->filter(fn($u) => $u->role === 'gurubk')->count();
            $countDinsos = $data->filter(fn($u) => $u->role === 'dinsos')->count();
            $countSiswa = $data->filter(fn($u) => $u->role === 'siswa')->count();
        @endphp
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[11px] font-semibold text-slate-500 block">Administrator</span>
            <h3 class="text-2xl font-black text-purple-600 mt-1">{{ $countAdmin }}</h3>
            <span class="text-[10px] text-purple-600 font-medium">Admin & IT Support</span>
        </div>

        <!-- Guru BK -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[11px] font-semibold text-slate-500 block">Guru BK</span>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $countBK }}</h3>
            <span class="text-[10px] text-emerald-600 font-medium">Konselor Sekolah</span>
        </div>

        <!-- Dinas Sosial -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[11px] font-semibold text-slate-500 block">Dinas Sosial</span>
            <h3 class="text-2xl font-black text-sky-600 mt-1">{{ $countDinsos }}</h3>
            <span class="text-[10px] text-sky-600 font-medium">Pendamping Khusus</span>
        </div>

        <!-- Siswa -->
        <div class="bg-white p-4.5 rounded-2xl border border-slate-200 shadow-xs col-span-2 lg:col-span-1">
            <span class="text-[11px] font-semibold text-slate-500 block">Siswa</span>
            <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $countSiswa }}</h3>
            <span class="text-[10px] text-amber-600 font-medium">Pelajar Terdaftar</span>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" x-model="search" placeholder="Cari username atau email pengguna..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Role -->
            <select x-model="roleFilter"
                    class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700 font-medium">
                <option value="all">Semua Peran (Role)</option>
                <option value="admin">Administrator</option>
                <option value="admin_it">Admin IT</option>
                <option value="gurubk">Guru BK</option>
                <option value="dinsos">Dinas Sosial</option>
                <option value="siswa">Siswa</option>
            </select>

            <!-- Reset Filters -->
            <button type="button" @click="search = ''; roleFilter = 'all';"
                    x-show="search !== '' || roleFilter !== 'all'"
                    class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </button>
        </div>
    </div>

    <!-- Pengguna Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Identitas Akun</th>
                        <th class="p-4">Email Login</th>
                        <th class="p-4">Peran (Role)</th>
                        <th class="p-4">Terdaftar Sejak</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data as $pengguna)
                        @php
                            $role = $pengguna->role;
                            $roleConfig = match($role) {
                                'admin', 'admin_it' => ['label' => 'Administrator', 'badge' => 'bg-purple-50 text-purple-700 border-purple-200', 'bg' => 'from-purple-600 to-indigo-600'],
                                'gurubk' => ['label' => 'Guru BK', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'bg' => 'from-emerald-600 to-teal-600'],
                                'dinsos' => ['label' => 'Dinas Sosial', 'badge' => 'bg-sky-50 text-sky-700 border-sky-200', 'bg' => 'from-sky-600 to-blue-600'],
                                'siswa' => ['label' => 'Siswa', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'bg' => 'from-amber-600 to-orange-600'],
                                default => ['label' => ucfirst($role), 'badge' => 'bg-slate-100 text-slate-700 border-slate-200', 'bg' => 'from-slate-600 to-slate-700']
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(
                                (search === '' ||
                                 '{{ strtolower(addslashes($pengguna->username)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($pengguna->email)) }}'.includes(search.toLowerCase())) &&
                                (roleFilter === 'all' || '{{ $role }}' === roleFilter)
                            )">
                            
                            <!-- Avatar & Username -->
                            <td class="p-4">
                                @php
                                    $profil = match($role) {
                                        'siswa' => $pengguna->siswas->first(),
                                        'gurubk' => $pengguna->gurubks->first(),
                                        'dinsos' => $pengguna->dinsos->first(),
                                        default => $pengguna->admins->first()
                                    };
                                @endphp
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr {{ $roleConfig['bg'] }} flex items-center justify-center text-white text-xs font-bold shadow-2xs shrink-0">
                                        {{ strtoupper(substr($pengguna->username, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 block text-sm">{{ $pengguna->username }}</span>
                                            <span class="text-[10px] text-slate-400 font-mono">#{{ $pengguna->id_pengguna }}</span>
                                        </div>
                                        @if ($profil)
                                            <div class="flex items-center gap-1.5 text-xs text-indigo-700 font-semibold mt-0.5">
                                                <i class="fa-solid fa-id-card text-[11px] text-indigo-500"></i>
                                                <span>{{ $profil->nama }}</span>
                                                @if ($role === 'gurubk' && $profil->sekolah)
                                                    <span class="text-[11px] text-slate-500 font-normal">({{ $profil->sekolah->nama_sekolah }})</span>
                                                @elseif ($role === 'siswa' && $profil->kelas)
                                                    <span class="text-[11px] text-slate-500 font-normal">({{ $profil->kelas }})</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic block mt-0.5">Data profil belum diisi</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="p-4">
                                <span class="font-mono text-xs font-semibold text-slate-800">{{ $pengguna->email }}</span>
                            </td>

                            <!-- Role -->
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border {{ $roleConfig['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    <span>{{ $roleConfig['label'] }}</span>
                                </span>
                            </td>

                            <!-- Registered At -->
                            <td class="p-4">
                                <span class="text-slate-800 font-semibold block">{{ $pengguna->created_at?->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $pengguna->created_at?->format('H:i') }} WIB</span>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.pengguna.edit', $pengguna->id_pengguna) }}"
                                       title="Edit Akun"
                                       class="p-2 rounded-xl bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete (Kecuali Akun Sendiri) -->
                                    @if($pengguna->id_pengguna !== Auth::id())
                                        <form action="{{ route('admin.pengguna.destroy', $pengguna->id_pengguna) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $pengguna->username }}?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Akun"
                                                    class="p-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                    <i class="fa-solid fa-users-slash"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Belum Ada Akun Pengguna</h3>
                                <p class="text-xs text-slate-400 mt-1">Akun pengguna terdaftar akan ditampilkan di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection