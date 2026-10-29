@extends('admin.layouts.template')
@section('title', 'Detail Profil Guru BK - ' . $guruBk->nama)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.guru-bk.index') }}" class="text-xs text-purple-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Daftar Guru BK</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-mono font-bold text-slate-500">NIP: {{ $guruBk->nip }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Profil Konselor Bimbingan Konseling</h1>
            <p class="text-xs text-slate-500 mt-1">Identitas lengkap tenaga pendidik konselor penanggung jawab kasus perundungan siswa.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Profil</span>
            </a>
        </div>
    </div>

    <!-- Counselor Profile Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <!-- Top decorative banner -->
        <div class="h-32 bg-gradient-to-r from-purple-700 via-indigo-700 to-slate-900 relative">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        </div>

        <!-- Bio Content -->
        <div class="px-6 sm:px-8 pb-8 pt-0 relative">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 -mt-16 mb-6">
                <!-- Avatar -->
                <div class="flex items-end gap-5">
                    <div class="w-28 h-28 rounded-3xl border-4 border-white bg-slate-100 shadow-lg overflow-hidden shrink-0">
                        @php
                            $fotoPath = public_path('storage/gurubk/foto/lg/' . $guruBk->foto);
                            $hasFoto = !empty($guruBk->foto) && file_exists($fotoPath);
                        @endphp
                        @if($hasFoto)
                            <img src="{{ asset('storage/gurubk/foto/lg/' . $guruBk->foto) }}" alt="{{ $guruBk->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white text-3xl font-black">
                                {{ strtoupper(substr($guruBk->nama, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-700">
                                Konselor Resmi
                            </span>
                            <span class="text-xs text-slate-400">&bull;</span>
                            <span class="text-xs font-semibold text-slate-500">{{ $guruBk->sekolah->nama_sekolah ?? 'Sekolah Terdaftar' }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900">{{ $guruBk->nama }}</h2>
                        <span class="text-xs font-mono text-slate-400 block mt-0.5">NIP: {{ $guruBk->nip }}</span>
                    </div>
                </div>

                <!-- Fast WhatsApp Action -->
                @if(!empty($guruBk->no_telp))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guruBk->no_telp) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition-all shadow-xs">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                @endif
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-6 border-t border-slate-100">
                <!-- Sekolah -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Sekolah Penugasan</span>
                    <span class="text-xs font-bold text-slate-800 block">{{ $guruBk->sekolah->nama_sekolah ?? '-' }}</span>
                    <span class="text-[10px] font-mono text-slate-400">NPSN: {{ $guruBk->sekolah->npsn ?? '-' }}</span>
                </div>

                <!-- Gender -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Jenis Kelamin</span>
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        @if(strtoupper($guruBk->gender) === 'L')
                            <i class="fa-solid fa-mars text-sky-500"></i>
                            <span>Laki-laki</span>
                        @else
                            <i class="fa-solid fa-venus text-pink-500"></i>
                            <span>Perempuan</span>
                        @endif
                    </span>
                </div>

                <!-- No Telepon -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Nomor Telepon</span>
                    <span class="text-xs font-mono font-bold text-slate-800 block">{{ $guruBk->no_telp ?: '-' }}</span>
                </div>

                <!-- Username Akun -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Username Login</span>
                    <span class="text-xs font-mono font-bold text-purple-700 block">&#64;{{ $guruBk->user->username ?? '-' }}</span>
                </div>

                <!-- Email Akun -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Alamat Email</span>
                    <span class="text-xs font-semibold text-slate-800 block truncate">{{ $guruBk->user->email ?? '-' }}</span>
                </div>

                <!-- Status Akun -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Peran Akses</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                        <span>Guru BK Terverifikasi</span>
                    </span>
                </div>

                <!-- Alamat Domisili -->
                <div class="md:col-span-2 lg:col-span-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 block mb-1">Alamat Tempat Tinggal</span>
                    <p class="text-xs text-slate-700 leading-relaxed">{{ $guruBk->alamat ?: 'Alamat belum dilengkapi.' }}</p>
                </div>
            </div>

            <!-- Footer Action Row -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-slate-100">
                <a href="{{ route('admin.guru-bk.index') }}"
                   class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-800 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Daftar Guru BK</span>
                </a>

                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.guru-bk.destroy', $guruBk->nip) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus Guru BK {{ $guruBk->nama }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200 transition-all">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                            <span>Hapus Data</span>
                        </button>
                    </form>

                    <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition-all shadow-xs">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Edit Profil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
