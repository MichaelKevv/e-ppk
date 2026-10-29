@extends('admin.layouts.template')
@section('title', 'Edit Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{
    previewUrl: '{{ !empty($siswa->foto) && file_exists(public_path('storage/foto-siswa/' . $siswa->foto)) ? asset('storage/foto-siswa/' . $siswa->foto) : '' }}',
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
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Akun Siswa</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Edit Profil Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui biodata profil dan kontak Anda di sistem Lapora.</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ url('siswa/update/profile/' . $siswa->id_siswa) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section: Foto Profil -->
            <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                <div class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="Foto Siswa" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewUrl">
                        <i class="fa-solid fa-user text-2xl"></i>
                    </template>
                </div>

                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Foto Profil</label>
                    <input type="file" name="foto" @change="fileChosen" accept="image/*"
                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG. Maksimal 2 MB.</p>
                </div>
            </div>

            <!-- Fields Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelas</label>
                    <select name="kelas"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                        <option value="7" {{ $siswa->kelas == '7' ? 'selected' : '' }}>Kelas 7</option>
                        <option value="8" {{ $siswa->kelas == '8' ? 'selected' : '' }}>Kelas 8</option>
                        <option value="9" {{ $siswa->kelas == '9' ? 'selected' : '' }}>Kelas 9</option>
                        <option value="10" {{ $siswa->kelas == '10' ? 'selected' : '' }}>Kelas 10</option>
                        <option value="11" {{ $siswa->kelas == '11' ? 'selected' : '' }}>Kelas 11</option>
                        <option value="12" {{ $siswa->kelas == '12' ? 'selected' : '' }}>Kelas 12</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin</label>
                    <select name="gender" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                        <option value="laki-laki" {{ strtolower($siswa->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ strtolower($siswa->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WhatsApp</label>
                    <input type="tel" name="no_telp" value="{{ old('no_telp', $siswa->no_telp) }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-mono">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                    <textarea name="alamat" rows="2"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Profil</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
