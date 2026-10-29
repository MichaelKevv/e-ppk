@extends('admin.layouts.template')
@section('title', 'Edit Petugas Dinsos - ' . $dinso->nama)

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    showPassword: false,
    previewUrl: '{{ !empty($dinso->foto) && file_exists(public_path('storage/dinsos/foto/md/' . $dinso->foto)) ? asset('storage/dinsos/foto/md/' . $dinso->foto) : '' }}',
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
                <a href="{{ route('admin.dinsos.index') }}" class="text-xs text-sky-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Daftar Dinsos</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Perbarui Data</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Edit Petugas: {{ $dinso->nama }}</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui biodata dan kredensial login akun petugas pendamping dinas sosial.</p>
        </div>
    </div>

    <!-- Error Alert if any -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terdapat kesalahan pengisian data:</span>
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
        <form action="{{ route('admin.dinsos.update', $dinso->id_dinsos) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Identitas Kepegawaian Dinsos -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs">1</span>
                    <span>Identitas Kepegawaian Dinas Sosial</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Pegawai (NIP)</label>
                        <input type="text" name="nip" value="{{ old('nip', $dinso->nip) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $dinso->nama) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="gender" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">
                            <option value="L" {{ old('gender', strtoupper($dinso->gender)) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', strtoupper($dinso->gender)) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="tel" name="no_telp" value="{{ old('no_telp', $dinso->no_telp) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Tempat Tinggal <span class="text-rose-500">*</span></label>
                        <textarea name="alamat" rows="2" required
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">{{ old('alamat', $dinso->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Kredensial Login -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">2</span>
                    <span>Kredensial Akun Login Dinsos</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $dinso->username ?? '') }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Petugas <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $dinso->email ?? '') }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Baru <span class="text-[10px] text-slate-400 font-normal">(opsional)</span></label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Kosongkan jika tak diubah"
                                   class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden text-xs">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Foto Profil Petugas -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">3</span>
                    <span>Pas Foto Petugas Dinsos</span>
                </h3>

                <div class="flex items-center gap-6 mt-5">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Foto Petugas" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <i class="fa-solid fa-hands-holding-child text-2xl"></i>
                        </template>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Pas Foto Petugas</label>
                        <input type="file" name="foto" @change="fileChosen" accept="image/*"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti foto profil.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.dinsos.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-md shadow-sky-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
