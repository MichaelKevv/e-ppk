@extends('front.layouts.auth')
@section('title', 'Masuk - Lapora')

@section('content')
<div class="w-full max-w-md my-auto">
    <!-- Back to Home -->
    <div class="mb-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Halaman Beranda</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white mx-auto shadow-md shadow-indigo-500/30 mb-3">
                <i class="fa-solid fa-shield-heart text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Selamat Datang di Lapora</h1>
            <p class="text-xs text-slate-500 mt-1">
                Masuk ke sistem Lapora untuk mengakses layanan pelaporan &amp; konseling siswa.
            </p>
        </div>

        <!-- Alert Error -->
        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation text-base text-rose-500 mt-0.5 shrink-0"></i>
                <div>{!! session('error') !!}</div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-start gap-3">
                <i class="fa-solid fa-circle-check text-base text-emerald-500 mt-0.5 shrink-0"></i>
                <div>{!! session('success') !!}</div>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" required autofocus
                           value="{{ old('email') }}"
                           placeholder="nama@sekolah.sch.id"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                    <a href="#" class="text-[11px] font-semibold text-indigo-600 hover:underline">Lupa sandi?</a>
                </div>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required
                           placeholder="Masukkan kata sandi"
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 text-sm">
                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-xs font-bold tracking-wide shadow-md shadow-indigo-500/25 transition-all hover:scale-[1.01] active:scale-95">
                Masuk ke Akun
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            Belum memiliki akun siswa?
            <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 ml-1">
                Daftar Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
