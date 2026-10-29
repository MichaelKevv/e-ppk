<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <title>@yield('title', 'Lapora - Sistem Pengaduan & Perlindungan Siswa')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Tailwind CSS v4 via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-full font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 bg-white flex flex-col antialiased" x-data="{ mobileMenu: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 30)">
    @include('sweetalert::alert')

    <!-- Navigation Header (Blends Seamlessly with Hero Artwork) -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="scrolled || !{{ Request::is('/') ? 'true' : 'false' }}
                    ? 'bg-white/95 backdrop-blur-md shadow-xs border-b border-slate-100 py-0'
                    : 'bg-transparent border-b border-transparent py-2 lg:py-3'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Lapora Logo" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform drop-shadow-xs">
                    <div class="flex flex-col">
                        <span class="text-xl font-black text-slate-900 tracking-tight leading-none">Lapora</span>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-blue-600 mt-0.5">Suara Kamu Penting</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
                    <a href="{{ url('/') }}"
                       class="relative py-2 transition-colors {{ Request::is('/') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}">
                        <span>Beranda</span>
                        @if (Request::is('/'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('artikel.semua') }}"
                       class="relative py-2 transition-colors {{ Request::is('artikel*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}">
                        <span>Edukasi</span>
                        @if (Request::is('artikel*'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('kontak.petugas') }}"
                       class="relative py-2 transition-colors {{ Request::is('kontak*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}">
                        <span>Kontak</span>
                        @if (Request::is('kontak*'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 rounded-full"></span>
                        @endif
                    </a>
                </nav>

                <!-- Desktop CTA Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @if (Auth::check())
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard ({{ Auth::user()->username }})</span>
                        </a>
                    @else
                        <!-- Login Button (Pill with user icon) -->
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-5 py-2 rounded-full border-2 border-blue-600 text-blue-600 bg-white/80 hover:bg-white backdrop-blur-xs font-bold text-xs shadow-2xs transition-all hover:scale-[1.02] active:scale-95">
                            <i class="fa-regular fa-user text-xs"></i>
                            <span>Login</span>
                        </a>

                        <!-- Register Button (Filled Blue Pill) -->
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                            <span>Daftar</span>
                        </a>
                    @endif
                </div>

                <!-- Mobile Hamburger Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-slate-700 p-2 hover:bg-white/80 rounded-lg backdrop-blur-xs">
                    <i :class="mobileMenu ? 'fa-solid fa-xmark text-xl' : 'fa-solid fa-bars text-xl'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden border-t border-slate-100 bg-white px-5 py-4 space-y-3 shadow-xl"
             style="display: none;">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ Request::is('/') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('artikel.semua') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ Request::is('artikel*') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50' }}">
                Edukasi
            </a>
            <a href="{{ route('kontak.petugas') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ Request::is('kontak*') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50' }}">
                Kontak
            </a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @if (Auth::check())
                    <a href="{{ route('admin.dashboard') }}" class="w-full py-2.5 text-center rounded-full bg-blue-600 text-white text-xs font-bold shadow-xs">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full py-2.5 text-center rounded-full border-2 border-blue-600 text-blue-600 text-xs font-bold">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="w-full py-2.5 text-center rounded-full bg-blue-600 text-white text-xs font-bold shadow-md shadow-blue-500/20">
                        Daftar Akun
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content (Zero top padding on home so hero connects to screen top, pt-20 on other pages) -->
    <main class="flex-1 {{ Request::is('/') ? '' : 'pt-20' }}">
        @yield('content')
    </main>

    <!-- Footer with Blue Accent -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 text-xs pt-16 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-icon.png') }}" alt="Lapora Logo" class="w-9 h-9 object-contain">
                        <span class="text-xl font-black text-white">Lapora</span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                        Sistem Pelaporan dan Penanganan Perundungan Ramah Anak. Mewujudkan lingkungan sekolah yang aman, inklusif, dan bebas kekerasan untuk semua peserta didik.
                    </p>
                    <div class="pt-2 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-blue-900/40 border border-blue-500/30 text-blue-300 font-mono text-[11px]">
                            Sekolah Aman Untuk Semua &bull; Lapora
                        </span>
                    </div>
                </div>

                <!-- Col 2: Nav Links -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 font-medium">
                        <li><a href="{{ url('/') }}" class="hover:text-blue-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('artikel.semua') }}" class="hover:text-blue-400 transition-colors">Edukasi &amp; Artikel</a></li>
                        <li><a href="{{ route('kontak.petugas') }}" class="hover:text-blue-400 transition-colors">Kontak Darurat Konseling</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors">Portal Masuk</a></li>
                    </ul>
                </div>

                <!-- Col 3: Hotline -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Bantuan &amp; Konseling</h4>
                    <ul class="space-y-3 font-medium">
                        <li class="flex items-center gap-2.5 text-slate-300">
                            <i class="fa-solid fa-phone text-blue-400 text-sm"></i>
                            <span>Hotline: (021) 555-LAPOR</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-slate-300">
                            <i class="fa-solid fa-envelope text-blue-400 text-sm"></i>
                            <span>bantuan@lapora.sch.id</span>
                        </li>
                        <li class="flex items-center gap-2.5 text-emerald-400 font-bold">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>WhatsApp BK: 0812-9988-7766</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-slate-500 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} Lapora. Bersama Cegah Perundungan di Lingkungan Satuan Pendidikan.</p>
                <p class="text-blue-400/80 font-medium">Suara Kamu Penting &bull; Laporkan Sekarang</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
