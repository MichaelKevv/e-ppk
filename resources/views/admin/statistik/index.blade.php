@extends('admin.layouts.template')
@section('title', 'Laporan & Statistik Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- Header & Filter Bar -->
    <div class="relative overflow-hidden p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border border-slate-800 text-white shadow-lg">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
                    <i class="fa-solid fa-chart-line text-indigo-400"></i>
                    <span>Analisis Eksekutif &bull; Terintegrasi Multi-Sekolah</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Statistik & Laporan Penanganan Perundungan
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                    Evaluasi komparatif insiden kekerasan sekolah, kepatuhan respon 1x24 jam, tingkat resolusi kasus, dan peta sebaran perundungan berdasarkan klasifikasi ID3.
                </p>
            </div>

            <!-- Export PDF & Quick Print -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.statistik.export', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-lg shadow-rose-600/30 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-file-pdf text-sm"></i>
                    <span>Unduh Rekap Eksekutif (PDF)</span>
                </a>
            </div>
        </div>

        <!-- Filter Controls Form -->
        <div class="relative z-10 mt-6 pt-6 border-t border-slate-800/80">
            <form action="{{ route('admin.statistik.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                @if (Auth::user()->isAdmin() || Auth::user()->role === 'dinsos')
                    <!-- Filter Sekolah -->
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-300 mb-1">Satuan Pendidikan</label>
                        <select name="sekolah_id" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-hidden focus:border-indigo-500">
                            <option value="">Semua Sekolah (Lintas Jenjang)</option>
                            @foreach ($sekolahList as $s)
                                <option value="{{ $s->id }}" {{ $selectedSekolahId == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_sekolah }} ({{ $s->jenjang }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Jenjang -->
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-300 mb-1">Jenjang Pendidikan</label>
                        <select name="jenjang" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-hidden focus:border-indigo-500">
                            <option value="">Semua Jenjang</option>
                            <option value="SMP" {{ $selectedJenjang === 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                            <option value="SMA" {{ $selectedJenjang === 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                            <option value="SMK" {{ $selectedJenjang === 'SMK' ? 'selected' : '' }}>SMK</option>
                        </select>
                    </div>
                @else
                    <div class="col-span-2">
                        <label class="block text-[11px] font-semibold text-slate-300 mb-1">Yurisdiksi Sekolah</label>
                        <div class="w-full bg-slate-800/50 border border-slate-700/60 rounded-xl px-3 py-2 text-xs text-indigo-300 font-semibold flex items-center gap-2">
                            <i class="fa-solid fa-school text-indigo-400"></i>
                            <span class="truncate">{{ Auth::user()->sekolah?->nama_sekolah ?? 'Sekolah Terdaftar' }}</span>
                        </div>
                    </div>
                @endif

                <!-- Filter Tahun -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-300 mb-1">Tahun Laporan</label>
                    <select name="tahun" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-hidden focus:border-indigo-500">
                        @for ($y = date('Y'); $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Filter Sumber Data -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-300 mb-1">Sumber Rekam Kasus</label>
                    <select name="sumber" class="w-full bg-slate-800/90 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-hidden focus:border-indigo-500">
                        <option value="all" {{ $selectedSumber === 'all' ? 'selected' : '' }}>Semua Berkas (Riil + Historis)</option>
                        <option value="pengaduan" {{ $selectedSumber === 'pengaduan' ? 'selected' : '' }}>Laporan Siswa Aktif</option>
                        <option value="history" {{ $selectedSumber === 'history' ? 'selected' : '' }}>Dataset Latih Algoritma</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold shadow-md transition-colors flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    @if(request()->hasAny(['sekolah_id', 'jenjang', 'sumber']))
                        <a href="{{ route('admin.statistik.index') }}"
                           title="Reset Filter"
                           class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition-colors">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Background Ornaments -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Executive KPI Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- 1. Total Insiden -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Kasus Tercatat</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200/60 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-folder-open text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-2 tracking-tight">
                {{ $totalKasus }}
            </p>
            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-indigo-600">{{ $kasusDiproses }}</span> dalam investigasi / mediasi
            </div>
        </div>

        <!-- 2. Tingkat Resolusi (Resolution Rate) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-emerald-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Tingkat Resolusi Kasus</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-2 tracking-tight">
                {{ $resolutionRate }}%
            </p>
            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-emerald-600">{{ $kasusSelesai }}</span> dari {{ $totalKasus }} kasus tuntas
            </div>
        </div>

        <!-- 3. Rata-rata Durasi Penanganan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-amber-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Rata-rata Waktu Resolusi</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-stopwatch text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-2 tracking-tight">
                {{ $avgResolutionDays > 0 ? $avgResolutionDays . ' Hari' : '< 1 Hari' }}
            </p>
            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-semibold text-amber-600">Kecepatan Bimbingan BK</span>
            </div>
        </div>

        <!-- 4. Kasus Berisiko Tinggi / Darurat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-rose-300 transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Kasus Risiko Tinggi</span>
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-200/60 text-rose-600 flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold {{ $kasusDarurat > 0 ? 'text-rose-600' : 'text-slate-800' }} mt-2 tracking-tight">
                {{ $kasusDarurat }}
            </p>
            <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="font-bold text-rose-600">Perlindungan 1x24 Jam</span>
            </div>
        </div>
    </div>

    <!-- Charts Row 1: Komparasi Sekolah & Distribusi Bentuk Perundungan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Komparasi Antar Satuan Pendidikan (2 Kolom) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Komparasi Penanganan Kasus Antar Satuan Pendidikan</h3>
                    <p class="text-xs text-slate-500">Perbandingan jumlah kasus selesai vs dalam penanganan aktif di tiap sekolah.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                    Lintas Sekolah
                </span>
            </div>
            <div class="h-72 w-full">
                <canvas id="chartKomparasiSekolah"></canvas>
            </div>
        </div>

        <!-- Distribusi Bentuk Perundungan (1 Kolom) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Bentuk Perundungan</h3>
                    <p class="text-xs text-slate-500">Klasifikasi modalitas perundungan.</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-shapes"></i>
                </div>
            </div>
            <div class="h-60 w-full relative">
                <canvas id="chartBentukPerundungan"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 text-[11px] pt-1">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-slate-600">Verbal: <strong class="text-slate-800">{{ $bentukCounts['verbal'] }}</strong></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <span class="text-slate-600">Fisik: <strong class="text-slate-800">{{ $bentukCounts['fisik'] }}</strong></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <span class="text-slate-600">Sosial: <strong class="text-slate-800">{{ $bentukCounts['sosial'] }}</strong></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-600">Siber: <strong class="text-slate-800">{{ $bentukCounts['siber'] }}</strong></span>
                </div>
                <div class="flex items-center gap-1.5 col-span-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <span class="text-slate-600">Seksual: <strong class="text-slate-800">{{ $bentukCounts['seksual'] }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Tren Bulanan & Klasifikasi Tingkat Keparahan ID3 -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tren Bulanan Sepanjang Tahun (2 Kolom) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tren Insiden Perundungan (Januari - Desember {{ $selectedYear }})</h3>
                    <p class="text-xs text-slate-500">Pola frekuensi pelaporan kasus bulanan.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                    Tahun {{ $selectedYear }}
                </span>
            </div>
            <div class="h-64 w-full">
                <canvas id="chartTrenBulanan"></canvas>
            </div>
        </div>

        <!-- Tingkat Keparahan ID3 (1 Kolom) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Klasifikasi Algoritma ID3</h3>
                    <p class="text-xs text-slate-500">Distribusi tingkat keparahan insiden.</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
            </div>
            <div class="h-60 w-full relative">
                <canvas id="chartSeverity"></canvas>
            </div>
            <div class="flex justify-between items-center text-xs pt-1 border-t border-slate-100">
                <span class="text-emerald-700 font-bold">Ringan: {{ $severityCounts['ringan'] }}</span>
                <span class="text-amber-700 font-bold">Sedang: {{ $severityCounts['sedang'] }}</span>
                <span class="text-rose-700 font-bold">Berat: {{ $severityCounts['berat'] }}</span>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi per Satuan Pendidikan -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-bold text-slate-800">Tabel Rekapitulasi Kasus Satuan Pendidikan</h3>
                <p class="text-xs text-slate-500">Daftar agregasi kasus, efektivitas penanganan, dan tingkat bahaya per sekolah.</p>
            </div>
            <span class="text-xs font-semibold text-slate-500">
                Total: <strong class="text-slate-800">{{ count($sekolahStats) }}</strong> Sekolah
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-4">Satuan Pendidikan</th>
                        <th class="p-4">Jenjang & Status</th>
                        <th class="p-4 text-center">Total Kasus</th>
                        <th class="p-4 text-center">Selesai</th>
                        <th class="p-4 text-center">Investigasi / Aktif</th>
                        <th class="p-4 text-center">Kasus Darurat</th>
                        <th class="p-4">Rasio Resolusi</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse ($sekolahStats as $stat)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block text-sm">{{ $stat['nama'] }}</span>
                                <span class="text-slate-400 text-[11px] font-mono">NPSN: {{ $stat['npsn'] }}</span>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                    {{ $stat['jenjang'] }}
                                </span>
                                <span class="text-slate-500 text-[11px] ml-1">{{ $stat['status_sekolah'] }}</span>
                            </td>
                            <td class="p-4 text-center font-bold text-slate-800 text-sm">
                                {{ $stat['total'] }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $stat['selesai'] }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $stat['diproses'] }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($stat['darurat'] > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-700">
                                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                                        <span>{{ $stat['darurat'] }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 font-mono">-</span>
                                @endif
                            </td>
                            <td class="p-4 w-44">
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[11px]">
                                        <span class="font-bold text-slate-700">{{ $stat['rate'] }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $stat['rate'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.pengaduan.index', ['sekolah_id' => $stat['id']]) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition-colors">
                                    <i class="fa-solid fa-folder-open text-xs"></i>
                                    <span>Buka Berkas</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                Belum ada data statistik satuan pendidikan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart Komparasi Antar Sekolah
        const sekolahLabels = {!! json_encode(array_column($sekolahStats, 'nama')) !!};
        const dataSelesai = {!! json_encode(array_column($sekolahStats, 'selesai')) !!};
        const dataDiproses = {!! json_encode(array_column($sekolahStats, 'diproses')) !!};

        const ctxKomparasi = document.getElementById('chartKomparasiSekolah').getContext('2d');
        new Chart(ctxKomparasi, {
            type: 'bar',
            data: {
                labels: sekolahLabels.map(l => l.length > 25 ? l.substring(0, 22) + '...' : l),
                datasets: [
                    {
                        label: 'Kasus Selesai',
                        data: dataSelesai,
                        backgroundColor: '#10B981',
                        borderRadius: 6,
                    },
                    {
                        label: 'Dalam Investigasi / Mediasi',
                        data: dataDiproses,
                        backgroundColor: '#F59E0B',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { size: 11, weight: 'bold' } }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 } },
                        grid: { color: '#F1F5F9' }
                    }
                }
            }
        });

        // 2. Chart Bentuk Perundungan
        const ctxBentuk = document.getElementById('chartBentukPerundungan').getContext('2d');
        new Chart(ctxBentuk, {
            type: 'doughnut',
            data: {
                labels: ['Verbal', 'Fisik', 'Sosial', 'Siber', 'Seksual'],
                datasets: [{
                    data: [
                        {{ $bentukCounts['verbal'] }},
                        {{ $bentukCounts['fisik'] }},
                        {{ $bentukCounts['sosial'] }},
                        {{ $bentukCounts['siber'] }},
                        {{ $bentukCounts['seksual'] }}
                    ],
                    backgroundColor: ['#3B82F6', '#EF4444', '#F59E0B', '#10B981', '#A855F7'],
                    borderWidth: 2,
                    borderColor: '#FFFFFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '65%'
            }
        });

        // 3. Chart Tren Bulanan
        const ctxTren = document.getElementById('chartTrenBulanan').getContext('2d');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const monthlyData = {!! json_encode(array_values($monthlyTrend)) !!};

        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Insiden Dilaporkan',
                    data: monthlyData,
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointBackgroundColor: '#6366F1',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#F1F5F9' }
                    }
                }
            }
        });

        // 4. Chart Tingkat Keparahan ID3
        const ctxSeverity = document.getElementById('chartSeverity').getContext('2d');
        new Chart(ctxSeverity, {
            type: 'pie',
            data: {
                labels: ['Ringan', 'Sedang', 'Berat'],
                datasets: [{
                    data: [
                        {{ $severityCounts['ringan'] }},
                        {{ $severityCounts['sedang'] }},
                        {{ $severityCounts['berat'] }}
                    ],
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                    borderWidth: 2,
                    borderColor: '#FFFFFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endpush
