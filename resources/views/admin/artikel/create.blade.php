@extends('admin.layouts.template')
@section('title', 'Tulis Artikel Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
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
                <a href="{{ route('admin.artikel.index') }}" class="text-xs text-emerald-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Daftar Artikel</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Editor Konten</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Tulis Artikel Edukasi Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Publikasikan panduan literasi anti-bullying dan kesehatan mental untuk komunitas sekolah.</p>
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
        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Artikel -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Mengenali Tanda-tanda Perundungan Siber dan Cara Menghadapinya"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden text-sm font-bold text-slate-900 placeholder:font-normal">
            </div>

            <!-- Kategori & Cover -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Materi <span class="text-rose-500">*</span></label>
                    <select name="kategori" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden text-xs font-semibold text-slate-800">
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Edukasi" {{ old('kategori') == 'Edukasi' ? 'selected' : '' }}>Edukasi Anti-Bullying</option>
                        <option value="Tips" {{ old('kategori') == 'Tips' ? 'selected' : '' }}>Tips & Tindakan Siswa</option>
                        <option value="Mental" {{ old('kategori') == 'Mental' ? 'selected' : '' }}>Kesehatan Mental & Konseling</option>
                        <option value="Hukum" {{ old('kategori') == 'Hukum' ? 'selected' : '' }}>Regulasi & Aspek Hukum</option>
                        <option value="Relationships" {{ old('kategori') == 'Relationships' ? 'selected' : '' }}>Hubungan Pertemanan Sehat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Gambar Sampul / Cover</label>
                    <input type="file" name="gambar" @change="fileChosen" accept="image/*"
                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2 MB.</p>
                </div>
            </div>

            <!-- Cover Preview -->
            <div x-show="previewUrl" x-transition class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="text-xs font-bold text-slate-600 block mb-2">Pratinjau Gambar Sampul:</span>
                <div class="w-full max-w-sm h-48 rounded-xl overflow-hidden border border-slate-200">
                    <img :src="previewUrl" alt="Cover Preview" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Konten Artikel -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Isi Konten Artikel <span class="text-rose-500">*</span></label>
                <textarea name="konten" rows="12" required placeholder="Tulis isi artikel secara lengkap dan terstruktur..."
                          class="w-full p-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden text-xs text-slate-800 leading-relaxed">{{ old('konten') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.artikel.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Terbitkan Artikel</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
