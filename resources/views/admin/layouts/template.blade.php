<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/Logo-new.png') }}">
    <title>Lapora | @yield('title', 'Panel Kelola')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Vite Assets (Tailwind CSS v4) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="h-full font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 bg-slate-50" x-data="{ sidebarOpen: false }">
    @include('sweetalert::alert')

    <div class="min-h-full flex">
        <!-- Sidebar Navigation -->
        @include('admin.includes.sidebar')

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
             @click="sidebarOpen = false"
             style="display: none;"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:pl-64">
            <!-- Top Navbar -->
            @include('admin.includes.navbar')

            <!-- Main Page Content -->
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Session Alerts -->
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs" role="alert">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <div class="flex-1 text-sm font-medium">{!! session('success') !!}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs" role="alert">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                        <div class="flex-1 text-sm font-medium">{!! session('error') !!}</div>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
                        <div class="flex items-center gap-2 font-semibold text-sm mb-2">
                            <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                            <span>Terdapat beberapa kesalahan validasi:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 pl-2">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin.includes.footer')
        </div>
    </div>

    @stack('scripts')
</body>

</html>
