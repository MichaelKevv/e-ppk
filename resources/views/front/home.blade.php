@extends('front.layouts.template')
@section('title', 'Lapora - Suara Kamu Penting &bull; Sekolah Aman Untuk Semua')

@section('content')
<!-- HERO SECTION (MENYATU SEMPURNA DENGAN NAVBAR & ARTWORK) -->
<section class="relative bg-white overflow-hidden min-h-[640px] lg:min-h-[720px] xl:min-h-[780px] flex items-center pt-28 sm:pt-32 lg:pt-24 pb-14 lg:pb-16">
    <!-- RIGHT SIDE BACKGROUND ARTWORK (HERO-ART.JPG MEMBENTANG DARI UJUNG ATAS Y=0) -->
    <div class="absolute inset-y-0 right-0 w-full lg:w-[65%] xl:w-[60%] pointer-events-none overflow-hidden select-none">
        <img src="{{ asset('images/hero-art.jpg') }}"
             alt="Sekolah Aman Untuk Semua"
             class="w-full h-full object-cover object-right">
        <!-- Smooth organic gradient mask for seamless transition into white left area -->
        <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent lg:from-white lg:via-transparent lg:to-transparent"></div>
    </div>

    <!-- LEFT SIDE CONTENT CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 py-4 sm:py-8 lg:py-12">
        <div class="max-w-xl lg:max-w-lg xl:max-w-xl">
            <!-- Badge: Bersama Cegah Perundungan -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-blue-200/90 bg-blue-50/90 text-blue-700 text-xs font-semibold mb-6 shadow-2xs backdrop-blur-xs">
                <i class="fa-solid fa-shield-halved text-blue-600 text-xs"></i>
                <span>Bersama Cegah Perundungan</span>
            </div>

            <!-- Big Main Title -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.08] mb-6">
                Suara Kamu <br>
                <span class="text-blue-600 relative inline-block">
                    Penting
                    <!-- Stylized blue brush underline matching reference design -->
                    <svg class="absolute -bottom-3 left-0 w-full h-3.5 text-blue-600" viewBox="0 0 250 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 14 C50 6, 130 4, 246 12 C185 18, 95 19, 15 16" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <!-- Subtitle Description -->
            <p class="text-slate-600 font-normal text-sm sm:text-base leading-relaxed mb-8">
                Laporkan perundungan di sekolahmu dengan aman, rahasia, dan mudah. Karena setiap suara berhak didengar, setiap siswa berhak merasa aman.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-wrap items-center gap-3.5 mb-10">
                <a href="{{ Auth::check() ? route('admin.pengaduan.create') : route('login') }}"
                   class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm sm:text-base shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95 group">
                    <i class="fa-solid fa-paper-plane text-xs group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                    <span>Laporkan Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs ml-0.5"></i>
                </a>

                <a href="{{ route('artikel.semua') }}"
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-bold text-sm transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-graduation-cap text-blue-600"></i>
                    <span>Pelajari Panduan</span>
                </a>
            </div>

            <!-- Stats Row Matching Reference Design -->
            <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-200/80 max-w-md">
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">100%</div>
                    <div class="text-xs text-slate-500 font-medium mt-0.5">Kerahasiaan Terjamin</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-blue-600 tracking-tight">ID3</div>
                    <div class="text-xs text-slate-500 font-medium mt-0.5">Klasifikasi Cerdas</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">24/7</div>
                    <div class="text-xs text-slate-500 font-medium mt-0.5">Akses Pengaduan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EDUCATIONAL ARTICLES SECTION -->
<section class="py-20 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                    Edukasi &amp; Wawasan
                </span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Artikel &amp; Panduan Anti-Perundungan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kenali jenis-jenis bullying dan langkah pencegahannya di lingkungan sekolah.
                </p>
            </div>
            <a href="{{ route('artikel.semua') }}"
               class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                <span>Lihat Semua Artikel</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($articles as $article)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden hover:shadow-lg hover:border-blue-300 transition-all flex flex-col group">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        @if ($article->gambar)
                            <img src="{{ asset('storage/' . $article->gambar) }}" alt="{{ $article->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-300">
                                <i class="fa-solid fa-newspaper text-4xl"></i>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-blue-600/90 backdrop-blur-xs text-white text-[10px] font-bold uppercase tracking-wider">
                            Edukasi
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-slate-400 font-medium block mb-2">
                                {{ $article->created_at?->format('d M Y') }} &bull; Oleh {{ $article->penulis ?? 'Tim Lapora' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2">
                                {{ $article->judul }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($article->konten), 120) }}
                            </p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ url('article_detail/' . $article->id_artikel) }}"
                               class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200 text-slate-400">
                    <i class="fa-regular fa-newspaper text-3xl mb-2 block opacity-50"></i>
                    <p class="text-xs font-semibold">Belum ada artikel yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CALL TO ACTION BANNER -->
<section class="py-16 bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-3xl sm:text-4xl font-black tracking-tight mb-4">
            Jangan Diam. Suaramu Bisa Menyelamatkan Temanmu!
        </h2>
        <p class="text-sm sm:text-base text-blue-100 max-w-2xl mx-auto mb-8 leading-relaxed">
            Lapora menjamin perlindungan privasi dan kerahasiaan identitas setiap siswa pelapor. Bersama-sama, kita ciptakan sekolah yang aman dan nyaman.
        </p>
        <a href="{{ Auth::check() ? route('admin.pengaduan.create') : route('register') }}"
           class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white text-blue-700 hover:bg-blue-50 font-black text-sm shadow-xl shadow-blue-900/30 transition-all hover:scale-105 active:scale-95">
            <i class="fa-solid fa-bullhorn text-sm"></i>
            <span>Daftar &amp; Laporkan Sekarang</span>
        </a>
    </div>

    <!-- Decorative circles -->
    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
</section>
@endsection
