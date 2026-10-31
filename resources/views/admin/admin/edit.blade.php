@extends('admin.layouts.template')
@section('title', 'Edit Data Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    showPassword: false,
    previewUrl: null,
    fileChosen(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">

    <!-- Top Action Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.admin.index') }}" class="text-xs text-indigo-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Data Admin</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Perbarui Data</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Edit Data Administrator</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui profil administrator, informasi kontak, dan hak akses akun #ADM-{{ str_pad($admin->id_admin, 3, '0', STR_PAD_LEFT) }}.</p>
        </div>
    </div>

    <!-- Error Alert if any -->
    @if (isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terdapat kesalahan pada input form:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.admin.update', $admin->id_admin) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Profil Admin -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">1</span>
                    <span>Identitas & Profil Administrator</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $admin->nama) }}" required placeholder="Contoh: Rahmat Hidayat, S.Kom."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jabatan / Posisi</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $admin->jabatan) }}" placeholder="Contoh: Administrator Sistem, Staff IT Support"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp</label>
                        <input type="tel" name="no_telp" value="{{ old('no_telp', $admin->no_telp) }}" placeholder="Contoh: 081234567890"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <!-- Existing or Preview -->
                            <div class="relative">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" alt="Preview Foto" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-xs">
                                </template>
                                <template x-if="!previewUrl">
                                    @if ($admin->foto)
                                        <img src="{{ asset('storage/admin/foto/sm/' . $admin->foto) }}" alt="{{ $admin->nama }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-linear-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($admin->nama, 0, 2)) }}
                                        </div>
                                    @endif
                                </template>
                            </div>

                            <label class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-semibold text-slate-700 transition-colors">
                                <i class="fa-solid fa-cloud-arrow-up text-indigo-600"></i>
                                <span>Ganti Foto</span>
                                <input type="file" name="foto" accept="image/*" class="hidden" @change="fileChosen">
                            </label>
                        </div>
                        <span class="text-[11px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto.</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Kredensial Login & Hak Akses -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">2</span>
                    <span>Kredensial Login & Hak Akses Akun</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $admin->username) }}" required placeholder="Contoh: admin_rahmat"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Akun <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required placeholder="Contoh: rahmat@lapora.id"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Peran / Role <span class="text-rose-500">*</span></label>
                        <select name="role" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
                            <option value="admin" {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                            <option value="admin_it" {{ old('role', $admin->role) === 'admin_it' ? 'selected' : '' }}>IT Support / Teknis</option>
                        </select>
                        <span class="text-[11px] text-slate-400 mt-1 block">Tingkatan hak otorisasi dalam sistem Lapora</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Kosongkan jika tidak diubah..."
                                   class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden text-xs">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <span class="text-[11px] text-slate-400 mt-1 block">Hanya isi jika ingin mengganti password akun ini.</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.admin.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-500/25 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
