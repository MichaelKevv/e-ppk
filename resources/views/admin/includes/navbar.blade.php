<header class="h-16 bg-white border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-xs">
    <!-- Left: Mobile Toggle & Page Title -->
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Button -->
        <button @click="sidebarOpen = true"
                class="lg:hidden text-slate-500 hover:text-slate-800 p-2 rounded-lg hover:bg-slate-100 transition-colors">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <!-- Breadcrumb / Title -->
        <div class="flex items-center gap-2 text-sm">
            <span class="text-slate-400 font-medium">Lapora</span>
            <span class="text-slate-300">/</span>
            <span class="font-bold text-slate-800 tracking-tight">@yield('title', 'Dashboard')</span>
        </div>
    </div>

    <!-- Right: Quick Info & User Dropdown -->
    <div class="flex items-center gap-4">
        <!-- Live Status Pill -->
        <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Sistem Siaga</span>
        </div>

        <!-- Quick Link to Portal -->
        <a href="{{ url('/') }}" target="_blank"
           class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-colors">
            <i class="fa-solid fa-earth-asia"></i>
            <span>Portal Siswa</span>
        </a>

        <!-- Urgent Case Notification Bell -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen"
                    title="Peringatan Kasus Darurat"
                    class="relative p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors focus:outline-hidden">
                <i class="fa-solid fa-bell text-base"></i>
                @if(isset($urgentKasusCount) && $urgentKasusCount > 0)
                    <span class="absolute top-1 right-1 flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-600 text-[9px] font-black text-white items-center justify-center">
                            {{ $urgentKasusCount > 9 ? '9+' : $urgentKasusCount }}
                        </span>
                    </span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div x-show="notifOpen"
                 @click.away="notifOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-white shadow-xl border border-slate-200 py-2 text-xs z-50 divide-y divide-slate-100"
                 style="display: none;">
                
                <div class="px-4 py-3 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 {{ isset($urgentKasusCount) && $urgentKasusCount > 0 ? 'animate-ping' : '' }}"></span>
                        <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wide">Peringatan Kasus Darurat</h4>
                    </div>
                    @if(isset($urgentKasusCount) && $urgentKasusCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700">
                            {{ $urgentKasusCount }} Prioritas Tinggi
                        </span>
                    @endif
                </div>

                <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                    @if(isset($urgentKasusList) && $urgentKasusList->count() > 0)
                        @foreach($urgentKasusList as $uk)
                            <a href="{{ route('admin.pengaduan.show', $uk->id_pengaduan) }}"
                               class="p-3.5 hover:bg-rose-50/40 transition-colors block space-y-1">
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="font-mono font-bold text-rose-700 flex items-center gap-1">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                        <span>{{ $uk->kode_kasus }}</span>
                                    </span>
                                    <span class="text-slate-400 text-[10px]">{{ $uk->created_at?->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-800 font-semibold text-xs capitalize truncate">
                                    {{ $uk->bentuk_perundungan }} &bull; {{ $uk->nama_pelaku }}
                                </p>
                                <div class="flex flex-wrap items-center gap-1 text-[10px] pt-0.5">
                                    @if($uk->luka_fisik)
                                        <span class="px-1.5 py-0.2 rounded-md bg-rose-100 text-rose-700 font-bold">Luka Fisik</span>
                                    @endif
                                    @if($uk->trauma_mental)
                                        <span class="px-1.5 py-0.2 rounded-md bg-purple-100 text-purple-700 font-bold">Trauma Mental</span>
                                    @endif
                                    <span class="text-slate-400">&bull; {{ $uk->sekolah?->nama_sekolah ?? 'Satuan Pendidikan' }}</span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-slate-400 space-y-1">
                            <i class="fa-solid fa-circle-check text-2xl text-emerald-500/80 mb-1 block"></i>
                            <p class="font-semibold text-slate-700 text-xs">Situasi Aman & Terkendali</p>
                            <p class="text-[11px]">Tidak ada laporan kasus darurat yang membutuhkan penanganan saat ini.</p>
                        </div>
                    @endif
                </div>

                @if(isset($urgentKasusCount) && $urgentKasusCount > 0)
                    <div class="p-2 text-center bg-slate-50">
                        <a href="{{ route('admin.pengaduan.index', ['filter_darurat' => 1]) }}"
                           class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline">
                            Lihat Semua Kasus Butuh Tanggap Darurat &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- User Dropdown Menu -->
        <div class="relative" x-data="{ userMenu: false }">
            <button @click="userMenu = !userMenu"
                    class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-hidden">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-500 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                    {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 2)) }}
                </div>
                <div class="hidden sm:block text-left text-xs">
                    <p class="font-bold text-slate-800">{{ Auth::user()->username }}</p>
                    <p class="text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="userMenu ? 'rotate-180' : ''"></i>
            </button>

            <!-- Dropdown Body -->
            <div x-show="userMenu"
                 @click.away="userMenu = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg border border-slate-200 py-1.5 text-xs text-slate-700 z-50 divide-y divide-slate-100"
                 style="display: none;">
                <div class="px-4 py-2.5 bg-slate-50/50">
                    <p class="font-semibold text-slate-800">{{ Auth::user()->username }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 hover:text-indigo-600">
                        <i class="fa-solid fa-gauge-high text-slate-400"></i>
                        <span>Dashboard</span>
                    </a>
                    @if (Auth::user()->role === 'siswa' && Auth::user()->siswas->first())
                        <a href="{{ url('admin/siswa/edit/profile/' . Auth::user()->siswas->first()->id_siswa) }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 hover:text-indigo-600">
                            <i class="fa-solid fa-id-badge text-slate-400"></i>
                            <span>Ubah Profil</span>
                        </a>
                    @endif
                </div>
                <div class="py-1">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-left">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
