@extends('admin.layouts.template')
@section('title', 'Daftar Pengaduan Kasus')

@section('content')
<div class="space-y-6" x-data="{
    search: '',
    statusFilter: 'all',
    klasifikasiFilter: 'all',
    sumberTab: '{{ request('sumber', 'all') }}'
}">

    <!-- Top Action Card -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-md bg-blue-100 text-blue-700">Master Data &bull; Data Sekolah</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Rekapitulasi Kasus</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Manajemen Pengaduan Kasus</h1>
            <p class="text-xs text-slate-500 mt-1">
                Rekap laporan tindak perundungan siswa dan dataset historis kasus sekolah terintegrasi dalam sistem Lapora.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Export All PDF -->
            <a href="{{ route('admin.pengaduan.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all shadow-xs">
                <i class="fa-solid fa-file-pdf text-rose-600"></i>
                <span>Ekspor Rekap PDF</span>
            </a>

            <!-- Buat Pengaduan Baru -->
            <a href="{{ route('admin.pengaduan.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Buat Pengaduan Baru</span>
            </a>
        </div>
    </div>

    <!-- Category Tabs (Semua, Laporan Siswa, Dataset History) -->
    <div class="flex flex-wrap items-center gap-2 p-1.5 bg-slate-200/60 rounded-2xl w-fit">
        <button type="button"
                @click="sumberTab = 'all'"
                :class="sumberTab === 'all' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
            <span>Semua Kasus</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-700 font-bold">
                {{ $countSemua ?? count($data) }}
            </span>
        </button>

        <button type="button"
                @click="sumberTab = 'pengaduan'"
                :class="sumberTab === 'pengaduan' ? 'bg-white text-blue-700 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span>Laporan Siswa Aktif</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-50 text-blue-700 font-bold">
                {{ $countLaporan ?? 0 }}
            </span>
        </button>

        <button type="button"
                @click="sumberTab = 'history'"
                :class="sumberTab === 'history' ? 'bg-white text-purple-700 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            <span>Dataset Historis (Data Latih ID3)</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] bg-purple-50 text-purple-700 font-bold">
                {{ $countHistory ?? 0 }}
            </span>
        </button>

        <!-- Tab Kasus Darurat (Prioritas Tinggi) -->
        <a href="{{ request('filter_darurat') == 1 ? route('admin.pengaduan.index') : route('admin.pengaduan.index', ['filter_darurat' => 1]) }}"
           class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-2 border {{ request('filter_darurat') == 1 ? 'bg-rose-600 text-white border-rose-600 shadow-sm font-bold' : 'text-rose-700 bg-rose-50/80 border-rose-200 hover:bg-rose-100 font-semibold' }}">
            <span class="w-2 h-2 rounded-full {{ request('filter_darurat') == 1 ? 'bg-white' : 'bg-rose-500 animate-ping' }}"></span>
            <span>🚨 Tanggap Darurat</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ request('filter_darurat') == 1 ? 'bg-white text-rose-800' : 'bg-rose-200 text-rose-800' }} font-black">
                {{ $countDarurat ?? 0 }}
            </span>
        </a>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
        <div class="w-full md:w-80 relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" x-model="search" placeholder="Cari kode, pelaku, pelapor, atau lokasi..."
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            @if(isset($sekolahList) && $sekolahList->isNotEmpty())
                <!-- Filter Sekolah (Admin / Dinsos) -->
                <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="inline-block">
                    <select name="id_sekolah" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-indigo-200 bg-indigo-50/50 text-xs text-indigo-900 font-semibold focus:ring-2 focus:ring-indigo-500">
                        <option value="">🏫 Semua Sekolah</option>
                        @foreach ($sekolahList as $sek)
                            <option value="{{ $sek->id }}" {{ request('id_sekolah') == $sek->id ? 'selected' : '' }}>
                                {{ $sek->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            <!-- Filter Status -->
            <select x-model="statusFilter" class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700">
                <option value="all">Semua Status</option>
                <option value="diproses">Sedang Diproses</option>
                <option value="investigasi">Investigasi</option>
                <option value="konseling">Konseling</option>
                <option value="mediasi">Mediasi</option>
                <option value="selesai">Kasus Selesai</option>
                <option value="ditutup">Ditutup</option>
                <option value="history">Arsip Historis</option>
            </select>

            <!-- Filter Klasifikasi -->
            <select x-model="klasifikasiFilter" class="px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-xs text-slate-700">
                <option value="all">Semua Klasifikasi</option>
                <option value="ringan">Tingkat Ringan</option>
                <option value="sedang">Tingkat Sedang</option>
                <option value="berat">Tingkat Berat</option>
            </select>
        </div>
    </div>

    <!-- Complaints Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto text-xs">
            <table class="w-full text-left divide-y divide-slate-100">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Kode &bull; Tanggal</th>
                        <th class="p-4">Sumber Data</th>
                        <th class="p-4">Pelaku / Pelapor</th>
                        <th class="p-4">Bentuk Kasus</th>
                        <th class="p-4">Frekuensi &bull; Lokasi</th>
                        <th class="p-4">Klasifikasi ID3</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse ($data as $item)
                        @php
                            $badgeClass = match($item->klasifikasi) {
                                'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-slate-100 text-slate-700',
                            };
                            $badgeStatus = match($item->status) {
                                'selesai', 'ditutup' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'history' => 'bg-purple-50 text-purple-700 border-purple-200',
                                default => 'bg-amber-50 text-amber-700 border-amber-200',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors"
                            x-show="(sumberTab === 'all' || '{{ $item->sumber ?? 'pengaduan' }}' === sumberTab) &&
                                    (statusFilter === 'all' || '{{ $item->status ?? 'diproses' }}' === statusFilter) &&
                                    (klasifikasiFilter === 'all' || '{{ $item->klasifikasi }}' === klasifikasiFilter) &&
                                    (search === '' || '{{ strtolower(($item->kode_kasus ?? '') . ' ' . $item->nama_pelaku . ' ' . $item->nama_pelapor . ' ' . $item->lokasi) }}'.includes(search.toLowerCase()))">
                            <!-- Kode & Tanggal -->
                            <td class="p-4">
                                <span class="font-bold text-slate-900 block font-mono">{{ $item->kode_kasus ?? ('# ' . $item->id_pengaduan) }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item->created_at?->format('d M Y, H:i') }}</span>
                                @if($item->sekolah)
                                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold border border-slate-200">
                                        <i class="fa-solid fa-school text-[9px] text-indigo-500"></i>
                                        <span class="truncate max-w-[130px]" title="{{ $item->sekolah->nama_sekolah }}">{{ $item->sekolah->nama_sekolah }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Sumber Data -->
                            <td class="p-4">
                                @if($item->sumber === 'history')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        <i class="fa-solid fa-database text-[9px]"></i>
                                        <span>Dataset Historis</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fa-solid fa-user-pen text-[9px]"></i>
                                        <span>Laporan Siswa</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Pelaku / Pelapor -->
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block">{{ $item->nama_pelaku ?: 'Tidak Diketahui' }}</span>
                                <span class="text-[11px] text-slate-500">
                                    Pelapor: {{ $item->nama_pelapor ?: '(Dirahasiakan)' }}
                                </span>
                            </td>

                            <!-- Bentuk -->
                            <td class="p-4">
                                <span class="capitalize font-semibold text-slate-800 block">{{ $item->bentuk_perundungan }}</span>
                                <div class="flex items-center gap-1 mt-1 text-[10px]">
                                    @if ($item->luka_fisik)
                                        <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-bold border border-rose-200">Fisik</span>
                                    @endif
                                    @if ($item->trauma_mental)
                                        <span class="px-1.5 py-0.5 rounded bg-purple-50 text-purple-700 font-bold border border-purple-200">Trauma</span>
                                    @endif
                                    @if ($item->pelaku_lebih_dari_satu)
                                        <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-bold border border-amber-200">>1 Org</span>
                                    @endif
                                    @if ($item->konten_digital)
                                        <span class="px-1.5 py-0.5 rounded bg-sky-50 text-sky-700 font-bold border border-sky-200">Siber</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Frekuensi & Lokasi -->
                            <td class="p-4">
                                <span class="capitalize block">{{ str_replace('_', ' ', $item->frekuensi_kejadian) }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item->lokasi ?: 'Lingkungan Sekolah' }}</span>
                            </td>

                            <!-- Klasifikasi ID3 -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full border text-[10px] font-black uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $item->klasifikasi }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full border text-[10px] font-bold capitalize {{ $badgeStatus }}">
                                    {{ $item->status ?? 'diproses' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.pengaduan.show', $item->id_pengaduan) }}"
                                       title="Lihat Detail Kasus"
                                       class="p-2 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    <!-- Feedback (Guru BK / Dinsos) -->
                                    @if (Auth::user()->role !== 'siswa' && $item->sumber === 'pengaduan')
                                        <a href="{{ route('admin.feedback.create', $item->id_pengaduan) }}"
                                           title="Beri Tanggapan / Feedback"
                                           class="p-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition-colors">
                                            <i class="fa-solid fa-comment-dots text-xs"></i>
                                        </a>
                                    @endif

                                    <!-- Export Single PDF -->
                                    <a href="{{ route('admin.pengaduan.export_single', $item->id_pengaduan) }}"
                                       title="Cetak Berkas Kasus PDF"
                                       class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                                        <i class="fa-solid fa-file-pdf text-xs text-rose-600"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.pengaduan.edit', $item->id_pengaduan) }}"
                                       title="Edit Data"
                                       class="p-2 rounded-lg bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-colors">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>

                                    <!-- Delete (Admin only) -->
                                    @if (in_array(Auth::user()->role, ['admin', 'admin_it']))
                                        <form action="{{ route('admin.pengaduan.destroy', $item->id_pengaduan) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kasus ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Kasus"
                                                    class="p-2 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 opacity-40 block"></i>
                                <p class="text-sm font-semibold">Belum ada data pengaduan yang terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection