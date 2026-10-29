@extends('admin.layouts.template')
@section('title', 'Tambah Akun Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="{ showPassword: false }">

    <!-- Top Action Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.pengguna.index') }}" class="text-xs text-purple-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Daftar Akun</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Buat Kredensial</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Tambah Akun Pengguna Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Daftarkan akun login dengan peranan sistem yang sesuai.</p>
        </div>
    </div>

    <!-- Error Alert if any -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terdapat kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Username -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Username <span class="text-rose-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="Contoh: user_lapora"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs font-mono">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@lapora.id"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs">
            </div>

            <!-- Role Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Peran Akses (Role) <span class="text-rose-500">*</span></label>
                <select name="role" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs font-semibold text-slate-800">
                    <option value="" disabled selected>Pilih Peran Pengguna</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Manajemen)</option>
                    <option value="admin_it" {{ old('role') === 'admin_it' ? 'selected' : '' }}>Admin IT (Pengelola Sistem Teknis & Model AI)</option>
                    <option value="gurubk" {{ old('role') === 'gurubk' ? 'selected' : '' }}>Guru BK (Konselor Sekolah & Penanganan)</option>
                    <option value="dinsos" {{ old('role') === 'dinsos' ? 'selected' : '' }}>Dinas Sosial (Mitra Intervensi Tingkat Lanjut)</option>
                    <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa (Pelapor & Pelacak Kasus Mandiri)</option>
                </select>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden text-xs">
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.pengguna.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
