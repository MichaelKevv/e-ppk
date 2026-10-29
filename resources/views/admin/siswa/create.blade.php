@extends('admin.layouts.template')
@section('title', 'Tambah Siswa Baru')

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
                <a href="{{ route('admin.siswa.index') }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Daftar Siswa</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Registrasi Akun</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Tambah Siswa Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Daftarkan data siswa beserta akun login ke sistem pelaporan Lapora.</p>
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

    <!-- Create Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Afiliasi Sekolah & Kelas -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">1</span>
                    <span>Afiliasi Satuan Pendidikan & Kelas</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                    @if(auth()->user()->isAdmin() && isset($sekolahList) && $sekolahList->count() > 0)
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Sekolah Afiliasi <span class="text-rose-500">*</span></label>
                            <select name="id_sekolah" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                                <option value="" disabled selected>Pilih Sekolah Afiliasi</option>
                                @foreach($sekolahList as $s)
                                    <option value="{{ $s->id }}" {{ old('id_sekolah') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_sekolah }} (NPSN: {{ $s->npsn ?: '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat / Kelas <span class="text-rose-500">*</span></label>
                        <select name="kelas" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="" disabled selected>Pilih Kelas</option>
                            <option value="7" {{ old('kelas') == '7' ? 'selected' : '' }}>Kelas 7 (Tujuh)</option>
                            <option value="8" {{ old('kelas') == '8' ? 'selected' : '' }}>Kelas 8 (Delapan)</option>
                            <option value="9" {{ old('kelas') == '9' ? 'selected' : '' }}>Kelas 9 (Sembilan)</option>
                            <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10 (Sepuluh)</option>
                            <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11 (Sebelas)</option>
                            <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12 (Dua Belas)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jurusan / Peminatan</label>
                        <select name="jurusan"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="" selected>Umum / Tidak Ada</option>
                            <option value="IPA" {{ old('jurusan') == 'IPA' ? 'selected' : '' }}>MIPA / IPA</option>
                            <option value="IPS" {{ old('jurusan') == 'IPS' ? 'selected' : '' }}>IPS / Sosial</option>
                            <option value="Bahasa" {{ old('jurusan') == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                            <option value="Kejuruan" {{ old('jurusan') == 'Kejuruan' ? 'selected' : '' }}>Kejuruan (SMK)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="gender" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="" disabled selected>Pilih Gender</option>
                            <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Data Diri Siswa -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">2</span>
                    <span>Informasi Data Diri & Kontak</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Muhammad Kevin"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="tel" name="no_telp" value="{{ old('no_telp') }}" required placeholder="Contoh: 081234567890"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Tempat Tinggal <span class="text-rose-500">*</span></label>
                        <textarea name="alamat" rows="2" required placeholder="Masukkan alamat lengkap domisili siswa..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kredensial Login Siswa -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">3</span>
                    <span>Kredensial Akun Login Siswa</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Username Akun <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" required placeholder="Contoh: kevin2024"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Siswa <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="kevin@siswa.belajar.id"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="Minimal 6 karakter"
                                   class="w-full px-3.5 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Foto Profil -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">4</span>
                    <span>Foto Profil Siswa</span>
                </h3>

                <div class="flex items-center gap-6 mt-5">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Preview Foto" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <i class="fa-solid fa-user text-2xl"></i>
                        </template>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Pas Foto Siswa</label>
                        <input type="file" name="foto" @change="fileChosen" accept="image/*"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG. Maksimal 2 MB.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Data Siswa</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection