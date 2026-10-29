@extends('front.layouts.auth')
@section('title', 'Pendaftaran Siswa - Lapora')

@section('content')
<div class="w-full max-w-2xl my-auto">
    <!-- Back to Home -->
    <div class="mb-4">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Halaman Masuk</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white mx-auto shadow-md shadow-indigo-500/30 mb-3">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Registrasi Akun Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">
                Lengkapi identitas siswa untuk mendaftar akun perlindungan dan layanan pengaduan.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                <p class="font-bold flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>Terdapat kesalahan pada formulir:</span>
                </p>
                <ul class="list-disc list-inside space-y-0.5 pl-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Section 1: Akun Pengguna -->
            <div class="text-xs font-bold text-indigo-600 uppercase tracking-wider pb-1 border-b border-slate-100 flex items-center gap-1.5">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Informasi Akun</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1">Username / NISN *</label>
                    <input type="text" name="username" id="username" required value="{{ old('username') }}"
                           placeholder="Contoh: siswa_kevin"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Alamat Email *</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                           placeholder="siswa@sekolah.sch.id"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ show: false }">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi (min. 6 karakter) *</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password" required
                               placeholder="Buat sandi aman"
                               class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 text-xs">
                            <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="no_telp" class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / Telepon *</label>
                    <input type="text" name="no_telp" id="no_telp" required value="{{ old('no_telp') }}"
                           placeholder="081234567890"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Section 2: Data Siswa -->
            <div class="text-xs font-bold text-indigo-600 uppercase tracking-wider pt-3 pb-1 border-b border-slate-100 flex items-center gap-1.5">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Data Diri & Satuan Pendidikan</span>
            </div>

            <!-- Pilih Sekolah -->
            <div>
                <label for="id_sekolah" class="block text-xs font-bold text-slate-700 mb-1">
                    <i class="fa-solid fa-school text-indigo-500 mr-1"></i> Asal Satuan Pendidikan / Sekolah *
                </label>
                <select name="id_sekolah" id="id_sekolah" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all font-medium">
                    <option value="">-- Pilih Satuan Pendidikan --</option>
                    @if(isset($sekolahList))
                        @foreach ($sekolahList as $sek)
                            <option value="{{ $sek->id }}" {{ old('id_sekolah') == $sek->id ? 'selected' : '' }}>
                                {{ $sek->nama_sekolah }} (NPSN: {{ $sek->npsn }} &bull; {{ $sek->jenjang }})
                            </option>
                        @endforeach
                    @endif
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Pilih sekolah tempat Anda terdaftar sebagai peserta didik aktif.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
                    <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                           placeholder="Masukkan nama sesuai rapor"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>

                <div>
                    <label for="kelas" class="block text-xs font-bold text-slate-700 mb-1">Kelas *</label>
                    <input type="text" name="kelas" id="kelas" required value="{{ old('kelas') }}"
                           placeholder="Contoh: XII IPA 1"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select name="gender" id="gender" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="foto" class="block text-xs font-bold text-slate-700 mb-1">Pasfoto Profil (Opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*"
                           class="block w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-xl p-1 bg-slate-50">
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1">Alamat Tinggal *</label>
                <textarea name="alamat" id="alamat" rows="2" required
                          placeholder="Tuliskan alamat rumah lengkap"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">{{ old('alamat') }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-xs font-bold tracking-wide shadow-md shadow-indigo-500/25 transition-all hover:scale-[1.01] active:scale-95">
                    Daftar Sebagai Siswa
                </button>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 ml-1">
                Masuk di Sini
            </a>
        </div>
    </div>
</div>
@endsection
