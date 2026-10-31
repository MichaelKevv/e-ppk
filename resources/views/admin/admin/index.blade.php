@extends('admin.layouts.template')
@section('title', 'Data Master Admin')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    roleFilter: 'all'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-indigo-100 text-indigo-700">Master Data &bull; Administrator</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Keamanan & Kontrol Sistem</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Data Master Admin</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola profil administrator sistem, kredensial login, hak akses tingkat tinggi, dan kontak penanggung jawab aplikasi Lapora.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.admin.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Admin Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Admin -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Admin</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $data->count() }}</h3>
                    <span class="text-[10px] text-indigo-600 font-semibold">Pengelola Sistem</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Super Admin / Administrator Utama -->
        @php
            $countAdmin = $data->filter(fn($a) => ($a->user->role ?? 'admin') === 'admin')->count();
            $countAdminIt = $data->filter(fn($a) => ($a->user->role ?? '') === 'admin_it')->count();
        @endphp
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Administrator</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countAdmin }}</h3>
                    <span class="text-[10px] text-purple-600 font-semibold">Akses Penuh Sistem</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
        </div>

        <!-- IT Support / Teknis -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Staff / IT Support</span>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $countAdminIt }}</h3>
                    <span class="text-[10px] text-sky-600 font-semibold">Dukungan Teknis</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
            </div>
        </div>

        <!-- Status Keamanan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Status Akses</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">Aktif</h3>
                    <span class="text-[10px] text-emerald-600 font-semibold">RBAC Terproteksi</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-lock"></i>
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
            <input type="text" x-model="search" placeholder="Cari nama, username, email, jabatan..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <!-- Filter Role -->
            <select x-model="roleFilter"
                    class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700 font-medium">
                <option value="all">Semua Tipe Akun</option>
                <option value="admin">Administrator</option>
                <option value="admin_it">IT Support</option>
            </select>

            <!-- Reset Filters -->
            <button type="button" @click="search = ''; roleFilter = 'all';"
                    x-show="search !== '' || roleFilter !== 'all'"
                    class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">
                <i class="fa-solid fa-rotate-left mr-1"></i> Reset
            </button>
        </div>
    </div>

    <!-- Main Content Table / Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-3.5">Administrator</th>
                        <th class="px-5 py-3.5">Kredensial & Role</th>
                        <th class="px-5 py-3.5">Jabatan</th>
                        <th class="px-5 py-3.5">Kontak</th>
                        <th class="px-5 py-3.5">Terdaftar Sejak</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($data as $admin)
                        @php
                            $userRole = $admin->user->role ?? 'admin';
                            $isCurrentUser = Auth::user() && (Auth::user()->id_pengguna === $admin->id_pengguna);
                            $cleanPhone = preg_replace('/[^0-9]/', '', $admin->no_telp ?? '');
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors"
                            x-show="
                                (roleFilter === 'all' || '{{ $userRole }}' === roleFilter) &&
                                (search === '' ||
                                 '{{ strtolower(addslashes($admin->nama)) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($admin->user->username ?? '')) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($admin->user->email ?? '')) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($admin->jabatan ?? '')) }}'.includes(search.toLowerCase()) ||
                                 '{{ strtolower(addslashes($admin->no_telp ?? '')) }}'.includes(search.toLowerCase()))
                            ">
                            <!-- Admin Name & Photo -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative">
                                        @if ($admin->foto)
                                            <img src="{{ asset('storage/admin/foto/sm/' . $admin->foto) }}"
                                                 alt="{{ $admin->nama }}"
                                                 class="w-11 h-11 rounded-xl object-cover border border-slate-200 shadow-2xs">
                                        @else
                                            <div class="w-11 h-11 rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                                                {{ strtoupper(substr($admin->nama, 0, 2)) }}
                                            </div>
                                        @endif
                                        @if ($isCurrentUser)
                                            <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full" title="Akun Anda Saat Ini"></span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $admin->nama }}</h4>
                                            @if ($isCurrentUser)
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-700">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-400 font-mono">ID: #ADM-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Credentials & Role -->
                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 font-semibold text-slate-700">
                                        <i class="fa-solid fa-at text-[10px] text-slate-400"></i>
                                        <span>{{ $admin->user->username ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-500 text-[11px]">
                                        <i class="fa-regular fa-envelope text-[10px] text-slate-400"></i>
                                        <span>{{ $admin->user->email ?? '-' }}</span>
                                    </div>
                                    <div>
                                        @if ($userRole === 'admin')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                <i class="fa-solid fa-shield-halved text-[9px]"></i> Administrator
                                            </span>
                                        @elseif ($userRole === 'admin_it')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                                <i class="fa-solid fa-code text-[9px]"></i> IT Support
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ ucfirst($userRole) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-700">
                                    {{ $admin->jabatan ?? 'Administrator Sistem' }}
                                </div>
                                <span class="text-[11px] text-slate-400">Manajemen Pusat</span>
                            </td>

                            <!-- Kontak -->
                            <td class="px-5 py-4">
                                @if ($admin->no_telp)
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                        <span>{{ $admin->no_telp }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum diisi</span>
                                @endif
                            </td>

                            <!-- Tanggal Terdaftar -->
                            <td class="px-5 py-4 text-slate-500">
                                <div class="font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($admin->created_at)->translatedFormat('d M Y') }}
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono">
                                    {{ \Carbon\Carbon::parse($admin->created_at)->format('H:i') }} WIB
                                </span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.admin.edit', $admin->id_admin) }}"
                                       class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors"
                                       title="Edit Data Admin">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>

                                    <!-- Delete -->
                                    @if ($isCurrentUser)
                                        <button type="button" disabled
                                                class="p-2 text-slate-300 cursor-not-allowed rounded-lg"
                                                title="Tidak dapat menghapus akun Anda sendiri">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    @elseif ($data->count() <= 1)
                                        <button type="button" disabled
                                                class="p-2 text-slate-300 cursor-not-allowed rounded-lg"
                                                title="Tidak dapat menghapus admin terakhir">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('admin.admin.destroy', $admin->id_admin) }}" method="POST"
                                              class="inline-block delete-form"
                                              data-name="{{ $admin->nama }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors btn-delete"
                                                    title="Hapus Admin">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-user-shield text-4xl text-slate-300 mb-3"></i>
                                    <p class="font-bold text-slate-600">Belum ada data administrator</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Silakan tambahkan akun administrator pertama sistem.</p>
                                    <a href="{{ route('admin.admin.create') }}" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 transition-colors">
                                        + Tambah Admin
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const adminName = form.dataset.name || 'Admin';

                Swal.fire({
                    title: 'Hapus Data Admin?',
                    html: `Apakah Anda yakin ingin menghapus data admin <strong>${adminName}</strong>?<br><small class="text-slate-400">Akun kredensial login juga akan dihapus secara permanen.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                        cancelButton: 'rounded-xl text-xs font-semibold px-4 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection