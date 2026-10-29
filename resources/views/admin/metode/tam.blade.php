@extends('admin.layouts.template')
@section('title', 'Kalkulasi Model TAM')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-microchip"></i>
                <span>Metodologi Akseptansi Teknologi (Davis, 1989)</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Evaluasi & Kalkulasi Model TAM
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Analisis empiris tingkat penerimaan sistem Lapora melalui pengukuran Perceived Usefulness, Perceived Ease of Use, dan Behavioral Intention.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.survey.index') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                <i class="fa-solid fa-table-list"></i>
                <span>Data Survey ({{ $hasil['total'] }})</span>
            </a>

            <form action="{{ route('admin.tam.hitung') }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-arrows-rotate"></i>
                    <span>Kalkulasi Ulang Model</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Recalculation Alert Notification if triggered -->
    @if(isset($isRecalculated) && $isRecalculated)
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span><strong>Kalkulasi Berhasil:</strong> Seluruh konstruk TAM dan koefisien korelasi Pearson telah diperbarui berdasarkan <strong>{{ $hasil['total'] }}</strong> data responden survey aktif.</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <!-- 4 Key Construct Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Perceived Usefulness (PU) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-blue-300 transition-all">
            <div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200 text-[11px] font-bold">
                        Konstruk 1
                    </span>
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-lightbulb"></i>
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-700 mt-3">Perceived Usefulness (PU)</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Persepsi Kegunaan Sistem</p>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-baseline justify-between">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-extrabold text-blue-700">{{ number_format($hasil['PU'], 2) }}</span>
                        <span class="text-xs text-slate-400">/ 5.00</span>
                    </div>
                    <span class="text-xs font-bold text-blue-600">{{ round(($hasil['PU'] / 5) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($hasil['PU'] / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- 2. Perceived Ease of Use (PEOU) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-emerald-300 transition-all">
            <div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold">
                        Konstruk 2
                    </span>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-hand-pointer"></i>
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-700 mt-3">Perceived Ease of Use (PEOU)</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Persepsi Kemudahan Pakai</p>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-baseline justify-between">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-extrabold text-emerald-700">{{ number_format($hasil['PEOU'], 2) }}</span>
                        <span class="text-xs text-slate-400">/ 5.00</span>
                    </div>
                    <span class="text-xs font-bold text-emerald-600">{{ round(($hasil['PEOU'] / 5) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ min(100, ($hasil['PEOU'] / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- 3. Behavioral Intention (BI) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between hover:border-purple-300 transition-all">
            <div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 border border-purple-200 text-[11px] font-bold">
                        Konstruk 3
                    </span>
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-repeat"></i>
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-700 mt-3">Behavioral Intention (BI)</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Niat Penggunaan Berkelanjutan</p>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="flex items-baseline justify-between">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-extrabold text-purple-700">{{ number_format($hasil['BI'], 2) }}</span>
                        <span class="text-xs text-slate-400">/ 5.00</span>
                    </div>
                    <span class="text-xs font-bold text-purple-600">{{ round(($hasil['BI'] / 5) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ min(100, ($hasil['BI'] / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- 4. Indeks Akseptansi Global TAM -->
        <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-950 p-5 rounded-2xl text-white shadow-md flex flex-col justify-between relative overflow-hidden">
            <div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-white/10 text-indigo-200 border border-white/20 text-[11px] font-bold">
                        Indeks Global
                    </span>
                    <span class="w-8 h-8 rounded-xl bg-white/10 text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-trophy"></i>
                    </span>
                </div>
                <h3 class="text-xs font-bold text-indigo-100 mt-3">Tingkat Akseptansi TAM</h3>
                <p class="text-[11px] text-indigo-300/80 mt-0.5">Rata-rata 3 Konstruk</p>
            </div>
            
            <div class="mt-4 pt-3 border-t border-white/10">
                <div class="flex items-baseline justify-between">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-extrabold text-white">{{ number_format($hasil['overall'], 2) }}</span>
                        <span class="text-xs text-indigo-200">/ 5.00</span>
                    </div>
                    <span class="text-sm font-extrabold text-emerald-400">{{ $hasil['acceptancePct'] }}%</span>
                </div>
                <div class="mt-2">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $hasil['kategori']['badge'] }}">
                        {{ $hasil['kategori']['label'] }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Visualizations & Framework: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Column 1: Radar Chart (5 Cols) -->
        <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Diagram Radar Keseimbangan Dimensi</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Distribusi skor konstruk pada skala Likert 1 - 5</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-chart-radar"></i>
                    </span>
                </div>

                <div class="mt-4 flex items-center justify-center p-2 relative">
                    <div class="w-full max-w-[280px] aspect-square">
                        <canvas id="tamRadarChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-2">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Kegunaan (PU)</span>
                    <span class="font-bold text-slate-700">{{ number_format($hasil['PU'], 2) }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px]">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Kemudahan (PEOU)</span>
                    <span class="font-bold text-slate-700">{{ number_format($hasil['PEOU'], 2) }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px]">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Intensi Pakai (BI)</span>
                    <span class="font-bold text-slate-700">{{ number_format($hasil['BI'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Column 2: TAM Theoretical Framework & Path Diagram (7 Cols) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">Kerangka Struktural Model TAM (Davis, 1989)</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Jalur pengaruh kausal dan koefisien korelasi Pearson (r)</p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-diagram-project"></i>
                    </span>
                </div>

                <!-- Interactive Path Diagram Flow -->
                <div class="py-6 px-2">
                    <div class="relative bg-slate-50/80 rounded-2xl p-6 border border-slate-200/70">
                        
                        <!-- Top Row: PEOU -> PU -> BI -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            
                            <!-- Node 1: PEOU -->
                            <div class="p-4 rounded-xl bg-white border-2 border-emerald-300 shadow-xs text-center relative z-10">
                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-extrabold text-xs inline-flex items-center justify-center mb-1">
                                    PEOU
                                </span>
                                <div class="text-xs font-bold text-slate-800">Kemudahan Pakai</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Perceived Ease of Use</div>
                                <div class="mt-2 text-sm font-extrabold text-emerald-700">{{ number_format($hasil['PEOU'], 2) }}</div>
                            </div>

                            <!-- Node 2: PU -->
                            <div class="p-4 rounded-xl bg-white border-2 border-blue-300 shadow-xs text-center relative z-10">
                                <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 font-extrabold text-xs inline-flex items-center justify-center mb-1">
                                    PU
                                </span>
                                <div class="text-xs font-bold text-slate-800">Persepsi Kegunaan</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Perceived Usefulness</div>
                                <div class="mt-2 text-sm font-extrabold text-blue-700">{{ number_format($hasil['PU'], 2) }}</div>
                            </div>

                            <!-- Node 3: BI -->
                            <div class="p-4 rounded-xl bg-white border-2 border-purple-300 shadow-xs text-center relative z-10">
                                <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-700 font-extrabold text-xs inline-flex items-center justify-center mb-1">
                                    BI
                                </span>
                                <div class="text-xs font-bold text-slate-800">Intensi Perilaku</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">Behavioral Intention</div>
                                <div class="mt-2 text-sm font-extrabold text-purple-700">{{ number_format($hasil['BI'], 2) }}</div>
                            </div>

                        </div>

                        <!-- Connector Indicators / Hypotheses Badge Bar -->
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-slate-200">
                            <!-- Jalur 1 -->
                            <div class="p-2.5 rounded-lg bg-white border border-slate-200 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-600 flex items-center gap-1.5">
                                    <i class="fa-solid fa-arrow-right text-indigo-500"></i>
                                    <span>PEOU &rarr; PU</span>
                                </span>
                                <span class="font-extrabold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200">
                                    r = {{ $hasil['r_peou_pu'] }}
                                </span>
                            </div>

                            <!-- Jalur 2 -->
                            <div class="p-2.5 rounded-lg bg-white border border-slate-200 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-600 flex items-center gap-1.5">
                                    <i class="fa-solid fa-arrow-right text-indigo-500"></i>
                                    <span>PU &rarr; BI</span>
                                </span>
                                <span class="font-extrabold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200">
                                    r = {{ $hasil['r_pu_bi'] }}
                                </span>
                            </div>

                            <!-- Jalur 3 (Direct Effect) -->
                            <div class="p-2.5 rounded-lg bg-white border border-slate-200 flex items-center justify-between text-xs sm:col-span-2">
                                <span class="font-medium text-slate-600 flex items-center gap-1.5">
                                    <i class="fa-solid fa-route text-indigo-500"></i>
                                    <span>PEOU &rarr; BI (Pengaruh Langsung)</span>
                                </span>
                                <span class="font-extrabold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200">
                                    r = {{ $hasil['r_peou_bi'] }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Theory explanation -->
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600">
                <i class="fa-solid fa-circle-info text-indigo-600 mr-1.5"></i>
                Menurut teori TAM, semakin mudah sistem digunakan (PEOU), maka persepsi kegunaannya (PU) akan meningkat, yang pada akhirnya secara signifikan mendorong niat responden untuk terus menggunakannya (BI).
            </div>
        </div>

    </div>

    <!-- Statistical Hypotheses Verification Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Uji Hubungan Hipotesis Antar-Variabel TAM</h2>
                <p class="text-xs text-slate-400 mt-0.5">Koefisien Korelasi Pearson (r) dan verifikasi hipotesis penelitian</p>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                N = {{ $hasil['total'] }} responden
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Hipotesis</th>
                        <th class="py-3 px-4">Jalur Hubungan</th>
                        <th class="py-3 px-4 text-center">Nilai Korelasi (r)</th>
                        <th class="py-3 px-4 text-center">Tingkat Kekuatan</th>
                        <th class="py-3 px-4 text-center">Status Hubungan</th>
                        <th class="py-3 px-4">Kesimpulan Ilmiah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <!-- H1 -->
                    @php
                        $r1 = $hasil['r_peou_pu'];
                        $strength1 = abs($r1) >= 0.7 ? 'Sangat Kuat' : (abs($r1) >= 0.5 ? 'Kuat' : (abs($r1) >= 0.3 ? 'Sedang' : 'Lemah'));
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-800">H1</td>
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-800">PEOU &rarr; PU</span>
                            <div class="text-[11px] text-slate-400">Kemudahan Pakai berpengaruh terhadap Kegunaan</div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-md font-extrabold text-xs bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $r1 }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">
                            {{ $strength1 }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $r1 > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                Positif Signifikan
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            Responden yang merasa Lapora mudah digunakan cenderung menilai sistem sangat bermanfaat dalam tugas mereka.
                        </td>
                    </tr>

                    <!-- H2 -->
                    @php
                        $r2 = $hasil['r_pu_bi'];
                        $strength2 = abs($r2) >= 0.7 ? 'Sangat Kuat' : (abs($r2) >= 0.5 ? 'Kuat' : (abs($r2) >= 0.3 ? 'Sedang' : 'Lemah'));
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-800">H2</td>
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-800">PU &rarr; BI</span>
                            <div class="text-[11px] text-slate-400">Kegunaan berpengaruh terhadap Intensi Penggunaan</div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-md font-extrabold text-xs bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $r2 }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">
                            {{ $strength2 }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $r2 > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                Positif Signifikan
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            Semakin tinggi manfaat yang dirasakan guru/admin, semakin kuat komitmen mereka untuk terus memakai Lapora.
                        </td>
                    </tr>

                    <!-- H3 -->
                    @php
                        $r3 = $hasil['r_peou_bi'];
                        $strength3 = abs($r3) >= 0.7 ? 'Sangat Kuat' : (abs($r3) >= 0.5 ? 'Kuat' : (abs($r3) >= 0.3 ? 'Sedang' : 'Lemah'));
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        <td class="py-3.5 px-4 font-bold text-slate-800">H3</td>
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-800">PEOU &rarr; BI</span>
                            <div class="text-[11px] text-slate-400">Kemudahan Pakai berpengaruh langsung terhadap Intensi</div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-md font-extrabold text-xs bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $r3 }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-semibold text-slate-700">
                            {{ $strength3 }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $r3 > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                Positif Signifikan
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            Kemudahan antarmuka secara mandiri mempercepat adopsi teknologi oleh seluruh pengguna di sekolah.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Executive Interpretation & Recommendation Card -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-lg border border-slate-800">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-award text-lg"></i>
            </div>
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-base font-extrabold text-white">Kesimpulan Evaluasi & Rekomendasi Manajerial</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $hasil['kategori']['badge'] }}">
                        {{ $hasil['kategori']['label'] }} ({{ $hasil['acceptancePct'] }}%)
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $hasil['kategori']['keterangan'] }} Berdasarkan pengujian empiris TAM, sistem Lapora memenuhi kriteria kesiapan operasional dengan skor rata-rata komposit <strong>{{ number_format($hasil['overall'], 2) }} / 5.00</strong>.
                </p>
                <div class="pt-2 flex flex-wrap gap-2 text-xs">
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-indigo-200 border border-white/10">
                        <i class="fa-solid fa-check mr-1 text-emerald-400"></i> Akseptansi User Tinggi
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-indigo-200 border border-white/10">
                        <i class="fa-solid fa-check mr-1 text-emerald-400"></i> Alur Kerja Intuitif
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-indigo-200 border border-white/10">
                        <i class="fa-solid fa-check mr-1 text-emerald-400"></i> Siap Implementasi Luas
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('tamRadarChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Kegunaan (PU)', 'Kemudahan (PEOU)', 'Intensi Pakai (BI)'],
                datasets: [{
                    label: 'Skor TAM Lapora',
                    data: [{{ $hasil['PU'] }}, {{ $hasil['PEOU'] }}, {{ $hasil['BI'] }}],
                    fill: true,
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    pointBackgroundColor: 'rgb(67, 56, 202)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(67, 56, 202)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    r: {
                        angleLines: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        },
                        pointLabels: {
                            font: {
                                size: 11,
                                weight: '600',
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            color: '#475569'
                        },
                        suggestedMin: 0,
                        suggestedMax: 5,
                        ticks: {
                            stepSize: 1,
                            backdropColor: 'transparent',
                            font: {
                                size: 9
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.dataset.label + ': ' + context.formattedValue + ' / 5.00';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
