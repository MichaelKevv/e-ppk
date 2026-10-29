@extends('front.layouts.template')
@section('title', 'Pusat Edukasi & Artikel Perlindungan - Lapora')

@section('content')
<div class="pt-24 pb-20 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-blue-700 text-xs font-bold mb-3">
                <i class="fa-solid fa-book-open-reader text-blue-600"></i>
                <span>Literasi & Pencegahan Perundungan</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pusat Edukasi & Pemulihan Psikologis
            </h1>
            <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed">
                Panduan praktis, artikel pencegahan kekerasan sekolah, kiat kesehatan mental, dan langkah aman bagi siswa, guru, serta orang tua.
            </p>
        </div>

        <!-- Articles Grid -->
        @if ($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($articles as $article)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-xl hover:border-blue-300 transition-all duration-300 overflow-hidden flex flex-col group">
                        <!-- Image Container -->
                        <div class="relative h-52 bg-slate-100 overflow-hidden">
                            @if ($article->gambar)
                                <img src="{{ asset('storage/artikel/gambar/md/' . $article->gambar) }}"
                                     alt="{{ $article->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-blue-600 to-indigo-700 text-white">
                                    <i class="fa-solid fa-newspaper text-4xl opacity-40"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-white/95 backdrop-blur-md text-blue-700 shadow-sm uppercase tracking-wider">
                                    {{ $article->kategori }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-2 font-medium">
                                    <i class="fa-regular fa-calendar-days text-[11px]"></i>
                                    <span>{{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMMM YYYY') }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                    <a href="{{ route('artikel.detail', $article->id_artikel) }}">
                                        {{ $article->judul }}
                                    </a>
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 mt-2.5 line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($article->konten), 130) }}
                                </p>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('artikel.detail', $article->id_artikel) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 group-hover:text-blue-700">
                                    <span>Baca Lengkap</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <span class="text-[11px] text-slate-400 font-medium">Edukasi Siswa</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Belum Ada Artikel yang Diterbitkan</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Materi literasi dan edukasi sedang disiapkan oleh tim konselor bimbingan sekolah.
                </p>
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md transition-colors">
                    <i class="fa-solid fa-house"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
