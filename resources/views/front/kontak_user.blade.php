@extends('front.layouts.template')
@section('title', 'Kontak Petugas & Konselor BK - Lapora')

@section('content')
<div class="pt-24 pb-20 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-blue-700 text-xs font-bold mb-3">
                <i class="fa-solid fa-headset text-blue-600"></i>
                <span>Bantuan & Saluran Darurat</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kontak Guru Bimbingan Konseling & Dinas Terkait
            </h1>
            <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed">
                Kamu tidak sendirian. Jangan ragu menghubungi konselor sekolah atau petugas perlindungan anak untuk mendapatkan pendampingan aman dan terpercaya.
            </p>
        </div>

        <!-- Section 1: Guru BK Sekolah -->
        <div class="space-y-6 mb-16">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Guru Bimbingan Konseling (BK) Satuan Pendidikan</h2>
                </div>
                <span class="text-xs text-slate-500 font-medium">Bantuan di Lingkungan Sekolah</span>
            </div>

            @if(isset($guruBk) && $guruBk->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($guruBk as $gbk)
                        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:border-indigo-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-indigo-500/20">
                                        {{ strtoupper(substr($gbk->nama, 0, 2)) }}
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 uppercase">
                                        {{ $gbk->sekolah?->jenjang ?? 'Sekolah' }}
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-slate-900">{{ $gbk->nama }}</h3>
                                <p class="text-xs text-slate-500 font-mono mt-0.5">NIP: {{ $gbk->nip }}</p>

                                <div class="mt-3 pt-3 border-t border-slate-100 space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class="fa-solid fa-school text-indigo-500 text-[11px] w-4"></i>
                                        <span class="font-medium truncate">{{ $gbk->sekolah?->nama_sekolah ?? 'Satuan Pendidikan' }}</span>
                                    </div>
                                    @if($gbk->no_telp)
                                        <div class="flex items-center gap-2 text-xs text-slate-600">
                                            <i class="fa-solid fa-phone text-indigo-500 text-[11px] w-4"></i>
                                            <span>{{ $gbk->no_telp }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100">
                                @php
                                    $rawPhone = preg_replace('/[^0-9]/', '', $gbk->no_telp ?? '');
                                    if (str_starts_with($rawPhone, '0')) {
                                        $rawPhone = '62' . substr($rawPhone, 1);
                                    }
                                @endphp
                                @if($rawPhone)
                                    <a href="https://wa.me/{{ $rawPhone }}?text={{ urlencode('Halo Bapak/Ibu ' . $gbk->nama . ', saya siswa yang membutuhkan konsultasi bimbingan di ' . ($gbk->sekolah?->nama_sekolah ?? 'sekolah') . '.') }}"
                                       target="_blank"
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all hover:scale-102">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                        <span>Konsultasi WhatsApp</span>
                                    </a>
                                @else
                                    <span class="block text-center py-2 text-xs text-slate-400 font-medium bg-slate-50 rounded-xl">
                                        Kontak tatap muka di ruang BK
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Section 2: Tim Satgas Dinas Sosial / Perlindungan Anak -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Petugas Dinas Sosial & Satgas Perlindungan Anak</h2>
                </div>
                <span class="text-xs text-slate-500 font-medium">Intervensi Kasus Khusus / Darurat</span>
            </div>

            @if(isset($petugas) && $petugas->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($petugas as $p)
                        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:border-rose-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-rose-600 to-amber-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-rose-500/20">
                                        {{ strtoupper(substr($p->nama, 0, 2)) }}
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/60 uppercase">
                                        Dinas Sosial
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-slate-900">{{ $p->nama }}</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $p->jabatan ?? 'Petugas Pendamping Sosial' }}</p>

                                <div class="mt-3 pt-3 border-t border-slate-100 space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i class="fa-solid fa-phone text-rose-500 text-[11px] w-4"></i>
                                        <span>{{ $p->no_telp }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100">
                                @php
                                    $rawDinsos = preg_replace('/[^0-9]/', '', $p->no_telp ?? '');
                                    if (str_starts_with($rawDinsos, '0')) {
                                        $rawDinsos = '62' . substr($rawDinsos, 1);
                                    }
                                @endphp
                                @if($rawDinsos)
                                    <a href="https://wa.me/{{ $rawDinsos }}?text={{ urlencode('Halo Petugas Dinas Sosial, saya ingin berkonsultasi mengenai perlindungan kekerasan anak.') }}"
                                       target="_blank"
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition-all hover:scale-102">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                        <span>Hubungi Hotline Darurat</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection