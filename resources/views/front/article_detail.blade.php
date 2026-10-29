@extends('front.layouts.template')
@section('title', $article->judul . ' - Lapora Edukasi')

@section('content')
<div class="pt-24 pb-16 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium">
            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('artikel.semua') }}" class="hover:text-blue-600 transition-colors">Edukasi & Artikel</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate">{{ Str::limit($article->judul, 40) }}</span>
        </nav>

        <!-- Article Card -->
        <article class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <!-- Article Header -->
            <div class="p-6 sm:p-10 border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60 uppercase tracking-wider">
                        {{ $article->kategori }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">
                        <i class="fa-regular fa-calendar-days mr-1 text-slate-400"></i>
                        {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMMM YYYY') }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">
                        <i class="fa-regular fa-clock mr-1 text-slate-400"></i>
                        3 Menit Baca
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $article->judul }}
                </h1>

                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-blue-600/10 border border-blue-500/20 text-blue-600 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Tim Edukasi Lapora</p>
                        <p class="text-[11px] text-slate-500">Pusat Informasi Perlindungan & Hak Anak</p>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if ($article->gambar)
                <div class="w-full bg-slate-900/5 max-h-[460px] overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('storage/artikel/gambar/lg/' . $article->gambar) }}"
                         alt="{{ $article->judul }}"
                         class="w-full h-auto object-cover max-h-[460px]">
                </div>
            @endif

            <!-- Article Body -->
            <div class="p-6 sm:p-10 space-y-6 text-slate-700 leading-relaxed text-sm sm:text-base font-normal prose max-w-none">
                {!! $article->konten !!}
            </div>

            <!-- Share & Back Actions -->
            <div class="p-6 sm:p-10 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <a href="{{ route('artikel.semua') }}"
                   class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Daftar Artikel</span>
                </a>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="font-semibold">Bagikan:</span>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->judul . ' ' . url()->current()) }}"
                       target="_blank"
                       class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-colors flex items-center justify-center">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>
        </article>

        <!-- Recent Related Articles -->
        @if(isset($recentArticles) && $recentArticles->count() > 0)
            <div class="mt-12 space-y-6">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Artikel Edukasi Terkait Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ($recentArticles as $recent)
                        <a href="{{ route('artikel.detail', $recent->id_artikel) }}"
                           class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:border-blue-300 hover:shadow-md transition-all group block">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 mb-2 inline-block">
                                {{ $recent->kategori }}
                            </span>
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                {{ $recent->judul }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                                {{ Str::limit(strip_tags($recent->konten), 80) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
