<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    <!-- Sidebar Header / Logo -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/40">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-shield-heart text-white text-base"></i>
            </div>
            <div>
                <span class="text-base font-bold text-white tracking-tight">Lapora</span>
                <span class="block text-[10px] uppercase font-semibold tracking-wider text-indigo-400">Suara Kamu Penting</span>
            </div>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- User Mini Profile -->
    <div class="px-5 py-4 border-b border-slate-800/80 bg-slate-900/40">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-600/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-bold text-sm">
                {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->username }}</p>
                @php
                    $roleBadges = [
                        'admin_it' => ['label' => 'Admin IT', 'color' => 'bg-purple-500/20 text-purple-300 border-purple-500/30'],
                        'admin' => ['label' => 'Administrator', 'color' => 'bg-purple-500/20 text-purple-300 border-purple-500/30'],
                        'gurubk' => ['label' => 'Guru BK', 'color' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'],
                        'dinsos' => ['label' => 'Dinas Sosial', 'color' => 'bg-sky-500/20 text-sky-300 border-sky-500/30'],
                        'siswa' => ['label' => 'Siswa', 'color' => 'bg-amber-500/20 text-amber-300 border-amber-500/30'],
                    ];
                    $currentRole = $roleBadges[Auth::user()->role] ?? ['label' => ucfirst(Auth::user()->role), 'color' => 'bg-slate-700 text-slate-300 border-slate-600'];
                @endphp
                <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-medium rounded-full border {{ $currentRole['color'] }}">
                    {{ $currentRole['label'] }}
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1.5 custom-scrollbar text-sm font-medium">
        <div class="text-[11px] uppercase font-bold tracking-wider text-slate-400 px-3 pt-2 pb-1">Menu Utama</div>

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40 font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <i class="fa-solid fa-chart-pie w-5 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
            <span>Dashboard</span>
        </a>

        <!-- Pengaduan -->
        <a href="{{ route('admin.pengaduan.index') }}"
           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/pengaduan*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40 font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-bullhorn w-5 text-center text-sm {{ request()->is('admin/pengaduan*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Pengaduan Kasus</span>
            </div>
            @php $countLaporan = \App\Models\Pengaduan::where('status', 'diproses')->count(); @endphp
            @if ($countLaporan > 0 && Auth::user()->role !== 'siswa')
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-rose-500 text-white">
                    {{ $countLaporan }}
                </span>
            @endif
        </a>

        <!-- Feedback & Konseling -->
        <a href="{{ route('admin.feedback.index') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/feedback*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40 font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <i class="fa-solid fa-comments w-5 text-center text-sm {{ request()->is('admin/feedback*') ? 'text-white' : 'text-slate-400' }}"></i>
            <span>Feedback & Konseling</span>
        </a>

        @if (Auth::user()->role !== 'siswa')
            <!-- Statistik & Laporan Eksekutif -->
            <a href="{{ route('admin.statistik.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/statistik*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40 font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-chart-line w-5 text-center text-sm {{ request()->is('admin/statistik*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Statistik & Laporan</span>
            </a>
        @endif

        <!-- Metode Analitik (Decision Tree & TAM) -->
        <div class="pt-4 text-[11px] uppercase font-bold tracking-wider text-slate-400 px-3 pb-1">Metode & Analitik</div>

        <div x-data="{ open: {{ request()->is('admin/decision-tree*') || request()->is('admin/survey*') || request()->is('admin/tam*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition-all duration-150">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-brain w-5 text-center text-sm text-indigo-400"></i>
                    <span>Analisis Komputasi</span>
                </div>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="mt-1 pl-7 space-y-1" style="display: none;">
                <!-- Decision Tree ID3 -->
                <a href="{{ route('admin.decision-tree.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/decision-tree*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-sitemap text-xs"></i>
                    <span>Decision Tree (ID3)</span>
                </a>
                <!-- Survey Data & TAM -->
                <a href="{{ route('admin.survey.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/survey*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-poll text-xs"></i>
                    <span>Survey Data (TAM)</span>
                </a>
                <!-- Evaluasi TAM Model -->
                <a href="{{ route('admin.tam.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/tam*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-calculator text-xs"></i>
                    <span>Kalkulasi Model TAM</span>
                </a>
            </div>
        </div>

        @if (in_array(Auth::user()->role, ['admin', 'admin_it', 'gurubk']))
            <!-- Master Data Section -->
            <div class="pt-4 text-[11px] uppercase font-bold tracking-wider text-slate-400 px-3 pb-1">Master Data</div>

            <!-- Data Sekolah (Parent Group) -->
            <div x-data="{ openSekolah: {{ request()->is('admin/sekolah*') || request()->is('admin/siswa*') || request()->is('admin/guru-bk*') ? 'true' : 'false' }} }">
                <button @click="openSekolah = !openSekolah"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800/80 hover:text-white transition-all duration-150 {{ request()->is('admin/sekolah*') || request()->is('admin/siswa*') || request()->is('admin/guru-bk*') ? 'bg-slate-800/50 text-white font-semibold' : '' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-school w-5 text-center text-sm text-indigo-400"></i>
                        <span>Data Sekolah</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="openSekolah ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openSekolah" class="mt-1 pl-7 space-y-1">
                    <!-- Profil Sekolah -->
                    <a href="{{ route('admin.sekolah.index') }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/sekolah*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <i class="fa-solid fa-id-card-clip text-xs"></i>
                        <span>Profil & Ringkasan</span>
                    </a>

                    <!-- Data Siswa -->
                    <a href="{{ route('admin.siswa.index') }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/siswa*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <i class="fa-solid fa-user-graduate text-xs"></i>
                        <span>Data Siswa</span>
                    </a>

                    <!-- Guru BK -->
                    <a href="{{ route('admin.guru-bk.index') }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->is('admin/guru-bk*') ? 'bg-indigo-600/30 text-indigo-300 font-semibold border-l-2 border-indigo-500' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <i class="fa-solid fa-chalkboard-user text-xs"></i>
                        <span>Data Guru BK</span>
                    </a>
                </div>
            </div>

            <!-- Dinsos -->
            <a href="{{ route('admin.dinsos.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/dinsos*') ? 'bg-indigo-600 text-white shadow-sm font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-hands-holding-child w-5 text-center text-sm {{ request()->is('admin/dinsos*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Dinas Sosial</span>
            </a>

            <!-- Artikel Edukasi -->
            <a href="{{ route('admin.artikel.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/artikel*') ? 'bg-indigo-600 text-white shadow-sm font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-newspaper w-5 text-center text-sm {{ request()->is('admin/artikel*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Artikel Edukasi</span>
            </a>

            @if (in_array(Auth::user()->role, ['admin', 'admin_it']))
                <!-- Pengguna Akun -->
                <a href="{{ route('admin.pengguna.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 {{ request()->is('admin/pengguna*') ? 'bg-indigo-600 text-white shadow-sm font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center text-sm {{ request()->is('admin/pengguna*') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Manajemen Akun</span>
                </a>
            @endif
        @endif
    </nav>

    <!-- Sidebar Bottom / Quick Actions -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between">
        <a href="{{ url('/') }}" target="_blank"
           class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Portal Publik</span>
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    title="Keluar dari Sistem"
                    class="p-2 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-lg transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>
</aside>
