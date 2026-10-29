@extends('admin.layouts.template')
@section('title', 'Analisis Decision Tree (ID3)')

@section('content')
<div x-data="{
    activeTab: '{{ request('tab', request()->has('page') ? 'dataset' : 'tree') }}'
}" class="space-y-6">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-microchip"></i>
                <span>Metode Data Mining (Iterative Dichotomiser 3)</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Pohon Keputusan Klasifikasi Perundungan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Melatih model pohon keputusan secara rekursif berdasarkan Information Gain untuk mengklasifikasikan tingkat keparahan kasus.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Retrain Model Button -->
            <form action="{{ route('admin.decision-tree.latih') }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-arrows-rotate"></i>
                    <span>Latih Ulang Pohon</span>
                </button>
            </form>

            <!-- Sync from Pengaduan -->
            <form action="{{ route('admin.decision-tree.sinkron') }}" method="POST">
                @csrf
                <button type="submit"
                        title="Ambil data kasus dari tabel pengaduan yang sudah memiliki klasifikasi"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition-all">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                    <span>Sinkron dari Pengaduan</span>
                </button>
            </form>

            <!-- Download Template CSV -->
            <a href="{{ route('admin.decision-tree.download-template') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                <i class="fa-solid fa-file-csv text-emerald-600"></i>
                <span>Template CSV</span>
            </a>

            <!-- Export CSV -->
            <a href="{{ route('admin.decision-tree.export-csv') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                <i class="fa-solid fa-download"></i>
                <span>Export Dataset</span>
            </a>
        </div>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Akurasi Model -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 text-xl font-bold">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Akurasi Latih</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $evaluation['accuracy'] ?? 0 }}%
                </p>
                <span class="text-[11px] text-emerald-600 font-semibold">
                    {{ $evaluation['correct'] ?? 0 }} / {{ $evaluation['total'] ?? 0 }} sampel tepat
                </span>
            </div>
        </div>

        <!-- Total Data Latih -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-600 text-xl font-bold">
                <i class="fa-solid fa-database"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Total Dataset</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalDataset }} Kasus
                </p>
                <span class="text-[11px] text-slate-500 font-medium">
                    Historis &amp; Pengaduan
                </span>
            </div>
        </div>

        <!-- Node Utama (Root Node) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 flex items-center justify-center text-purple-600 text-xl font-bold">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-slate-500">Node Utama (Root)</p>
                <p class="text-base font-extrabold text-slate-800 tracking-tight truncate">
                    {{ $tree['attribute_label'] ?? ($tree['attribute'] ?? '-') }}
                </p>
                <span class="text-[11px] text-purple-600 font-semibold">
                    Gain Max: {{ $tree['gain'] ?? '0' }}
                </span>
            </div>
        </div>

        <!-- Entropi Total -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Entropi Total S</p>
                <p class="text-xl font-extrabold text-slate-800 tracking-tight">
                    {{ $entropyTotal }}
                </p>
                <span class="text-[11px] text-amber-600 font-semibold">
                    {{ count($rules) }} Aturan terbentuk
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200 bg-white px-6 rounded-t-2xl shadow-xs">
        <nav class="flex gap-4 sm:gap-6 -mb-px overflow-x-auto custom-scrollbar">
            <button @click="activeTab = 'tree'; history.replaceState(null, '', '?tab=tree')"
                    :class="activeTab === 'tree' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                    class="py-4 px-2 border-b-2 text-sm transition-colors flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-network-wired text-sm"></i>
                <span>Struktur Pohon Keputusan</span>
            </button>
            <button @click="activeTab = 'rumus'; history.replaceState(null, '', '?tab=rumus')"
                    :class="activeTab === 'rumus' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                    class="py-4 px-2 border-b-2 text-sm transition-colors flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-square-root-variable text-sm"></i>
                <span>Rumus &amp; Perhitungan ID3</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200">Formula</span>
            </button>
            <button @click="activeTab = 'dataset'; history.replaceState(null, '', '?tab=dataset')"
                    :class="activeTab === 'dataset' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                    class="py-4 px-2 border-b-2 text-sm transition-colors flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-table-list text-sm"></i>
                <span>Dataset Latih ({{ $totalDataset }})</span>
            </button>
            <button @click="activeTab = 'classify'; history.replaceState(null, '', '?tab=classify')"
                    :class="activeTab === 'classify' ? 'border-indigo-600 text-indigo-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 font-medium'"
                    class="py-4 px-2 border-b-2 text-sm transition-colors flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                <span>Simulasi Prediksi Kasus</span>
            </button>
        </nav>
    </div>

    <!-- TAB 1: POHON KEPUTUSAN & ATURAN -->
    <div x-show="activeTab === 'tree'" class="space-y-6">

        <!-- Rumus Quick Link Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-gradient-to-r from-indigo-50/90 via-purple-50/80 to-white rounded-2xl border border-indigo-100/90 shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-sm shadow-xs shrink-0">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-800">Transparansi Rumus &amp; Perhitungan Algoritma ID3</h4>
                    <p class="text-[11px] text-slate-500">Pelajari formula Shannon Entropy, penurunan Information Gain, dan rincian matematis dari {{ $totalDataset }} sampel kasus.</p>
                </div>
            </div>
            <button type="button" @click="activeTab = 'rumus'"
                    class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition-all shrink-0 hover:scale-[1.02] active:scale-95">
                <span>Buka Rumus &amp; Perhitungan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </button>
        </div>

        <!-- Visual Tree Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs"
             x-data="{
                 zoom: 1,
                 isDragging: false,
                 startX: 0,
                 scrollLeft: 0,
                 centerTree() {
                     this.$nextTick(() => {
                         if (this.$refs.canvas) {
                             const el = this.$refs.canvas;
                             el.scrollLeft = (el.scrollWidth - el.clientWidth) / 2;
                         }
                     });
                 },
                 zoomIn() {
                     if (this.zoom < 1.4) this.zoom = +(this.zoom + 0.1).toFixed(1);
                 },
                 zoomOut() {
                     if (this.zoom > 0.5) this.zoom = +(this.zoom - 0.1).toFixed(1);
                 },
                 resetZoom() {
                     this.zoom = 1;
                     this.centerTree();
                 },
                 startDrag(e) {
                     this.isDragging = true;
                     this.startX = e.pageX - this.$refs.canvas.offsetLeft;
                     this.scrollLeft = this.$refs.canvas.scrollLeft;
                 },
                 stopDrag() {
                     this.isDragging = false;
                 },
                 doDrag(e) {
                     if (!this.isDragging) return;
                     e.preventDefault();
                     const x = e.pageX - this.$refs.canvas.offsetLeft;
                     const walk = (x - this.startX) * 1.4;
                     this.$refs.canvas.scrollLeft = this.scrollLeft - walk;
                 }
             }"
             x-init="centerTree()">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Visualisasi Hierarki Pohon Keputusan</h3>
                    <p class="text-xs text-slate-500">Diagram alur penalaran otomatis dari Root Node hingga Leaf Node hasil pelatihan algoritma ID3.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Legend -->
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Ringan
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sedang
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Berat
                        </span>
                    </div>

                    <!-- Zoom & Reset Controls -->
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs">
                        <button type="button" @click="zoomOut()" title="Perkecil Diagram"
                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-white hover:bg-slate-50 text-slate-700 shadow-2xs font-bold transition-transform active:scale-90">
                            <i class="fa-solid fa-minus text-[10px]"></i>
                        </button>
                        <span class="px-2 text-[11px] font-bold font-mono text-slate-600 min-w-10 text-center" x-text="Math.round(zoom * 100) + '%'">100%</span>
                        <button type="button" @click="zoomIn()" title="Perbesar Diagram"
                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-white hover:bg-slate-50 text-slate-700 shadow-2xs font-bold transition-transform active:scale-90">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                        </button>
                        <button type="button" @click="resetZoom()" title="Reset Posisi & Zoom ke Tengah"
                                class="px-2.5 h-7 flex items-center gap-1 rounded-lg bg-white hover:bg-slate-50 text-slate-700 shadow-2xs text-[10px] font-bold transition-transform active:scale-90">
                            <i class="fa-solid fa-arrows-to-dot text-[10px]"></i>
                            <span>Tengah</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hint Navigasi -->
            <div class="flex items-center justify-between text-[11px] text-slate-400 mb-3 px-1">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-hand-pointer text-indigo-500"></i>
                    <span>Klik & tahan (drag kanvas) atau geser scrollbar untuk navigasi ke kiri dan ke kanan secara leluasa.</span>
                </span>
                <span class="hidden sm:inline-block font-mono text-indigo-600 font-medium">Bisa digeser penuh ke kiri & kanan</span>
            </div>

            <!-- Tree Diagram Overflow Canvas (No negative coordinates bug) -->
            <div x-ref="canvas"
                 @mousedown="startDrag($event)"
                 @mouseleave="stopDrag()"
                 @mouseup="stopDrag()"
                 @mousemove="doDrag($event)"
                 :class="isDragging ? 'cursor-grabbing select-none' : 'cursor-grab'"
                 class="overflow-x-auto py-10 px-8 bg-slate-50/60 rounded-2xl border border-slate-200/80 custom-scrollbar relative"
                 style="scroll-behavior: smooth;">
                @if ($tree)
                    <div class="w-max min-w-full flex transition-transform duration-150 origin-top"
                         :style="'transform: scale(' + zoom + '); transform-origin: top center;'">
                        <div class="m-auto px-16 py-4">
                            @include('admin.metode.partials.tree-node', ['node' => $tree])
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 text-slate-400">
                        <i class="fa-solid fa-tree text-4xl mb-3 opacity-40"></i>
                        <p class="text-sm font-semibold">Pohon Keputusan belum dilatih.</p>
                        <p class="text-xs mt-1">Klik tombol "Latih Ulang Pohon" di kanan atas untuk membangun pohon keputusan.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Rules Table -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-600"></i>
                        <span>Daftar Aturan Keputusan (IF-THEN Rules)</span>
                    </h3>
                    <span class="text-xs text-slate-500 font-semibold">{{ count($rules) }} Rules</span>
                </div>

                <div class="overflow-y-auto max-h-96 divide-y divide-slate-100 text-xs">
                    @forelse ($rules as $idx => $r)
                        @php
                            $label = strtolower($r['label']);
                            $badge = match($label) {
                                'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <div class="py-2.5 flex items-start justify-between gap-3 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                            <div class="flex items-start gap-2">
                                <span class="text-[10px] font-bold text-slate-400 mt-0.5">#{{ $idx + 1 }}</span>
                                <p class="text-slate-700 leading-relaxed font-mono text-[11px]">{!! str_replace(['JIKA ', ' DAN ', ' MAKA '], ['<b class="text-indigo-600">JIKA</b> ', '<b class="text-indigo-600"> DAN </b>', '<b class="text-indigo-600"> MAKA </b>'], e($r['rule'])) !!}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-full border text-[10px] font-extrabold uppercase shrink-0 {{ $badge }}">
                                {{ $r['label'] }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center py-6 text-slate-400">Belum ada aturan keputusan yang diekstrak.</p>
                    @endforelse
                </div>
            </div>

            <!-- Information Gain & Confusion Matrix -->
            <div class="space-y-6">
                <!-- Information Gain Ranking -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                        <span>Information Gain Setiap Atribut</span>
                    </h3>
                    <div class="space-y-3">
                        @foreach ($gains as $attr => $gain)
                            @php
                                $maxGain = max($gains) > 0 ? max($gains) : 1;
                                $percent = round(($gain / $maxGain) * 100);
                                $labels = [
                                    'bentuk_perundungan' => 'Bentuk Perundungan',
                                    'frekuensi_kejadian' => 'Frekuensi Kejadian',
                                    'trauma_mental' => 'Trauma Mental',
                                    'luka_fisik' => 'Luka Fisik',
                                    'pelaku_lebih_dari_satu' => 'Pelaku > 1 Orang',
                                    'konten_digital' => 'Konten Digital (Bukti Siber)',
                                ];
                            @endphp
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-700">{{ $labels[$attr] ?? ucfirst($attr) }}</span>
                                    <span class="font-bold text-indigo-600 font-mono">{{ $gain }}</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Confusion Matrix -->
                @if ($evaluation && isset($evaluation['matrix']))
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                        <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-table-cells text-emerald-600"></i>
                            <span>Confusion Matrix (Evaluasi Prediksi)</span>
                        </h3>
                        <div class="overflow-x-auto text-xs">
                            <table class="w-full text-center border-collapse">
                                <thead>
                                    <tr class="text-[11px] text-slate-400 font-bold uppercase border-b border-slate-100">
                                        <th class="p-2 text-left">Aktual \ Prediksi</th>
                                        <th class="p-2 text-emerald-700">Ringan</th>
                                        <th class="p-2 text-amber-700">Sedang</th>
                                        <th class="p-2 text-rose-700">Berat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                                    <tr>
                                        <td class="p-2 text-left font-bold text-emerald-700">Ringan</td>
                                        <td class="p-2 bg-emerald-50/60 font-bold text-emerald-800">{{ $evaluation['matrix']['ringan']['ringan'] ?? 0 }}</td>
                                        <td class="p-2">{{ $evaluation['matrix']['ringan']['sedang'] ?? 0 }}</td>
                                        <td class="p-2">{{ $evaluation['matrix']['ringan']['berat'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-left font-bold text-amber-700">Sedang</td>
                                        <td class="p-2">{{ $evaluation['matrix']['sedang']['ringan'] ?? 0 }}</td>
                                        <td class="p-2 bg-amber-50/60 font-bold text-amber-800">{{ $evaluation['matrix']['sedang']['sedang'] ?? 0 }}</td>
                                        <td class="p-2">{{ $evaluation['matrix']['sedang']['berat'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-left font-bold text-rose-700">Berat</td>
                                        <td class="p-2">{{ $evaluation['matrix']['berat']['ringan'] ?? 0 }}</td>
                                        <td class="p-2">{{ $evaluation['matrix']['berat']['sedang'] ?? 0 }}</td>
                                        <td class="p-2 bg-rose-50/60 font-bold text-rose-800">{{ $evaluation['matrix']['berat']['berat'] ?? 0 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- TAB 2: RUMUS & PERHITUNGAN MATEMATIS ID3 -->
    <div x-show="activeTab === 'rumus'" class="space-y-6" style="display: none;">
        @include('admin.metode.partials.rumus-id3')
    </div>

    <!-- TAB 3: DATASET LATIH & IMPORT CSV -->
    <div x-show="activeTab === 'dataset'" class="space-y-6" style="display: none;">
        <!-- Upload CSV Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <h3 class="text-sm font-bold text-slate-800 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-file-arrow-up text-indigo-600"></i>
                <span>Impor Dataset Historis Baru (File CSV)</span>
            </h3>
            <p class="text-xs text-slate-500 mb-4">
                Unggah file CSV berisi data kasus perundungan terdahulu untuk memperkaya dataset latih pohon keputusan.
                Gunakan template standar agar header dan format data valid.
            </p>

            <form action="{{ route('admin.decision-tree.import-csv') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-3">
                @csrf
                <div class="flex-1 w-full">
                    <input type="file" name="csv_file" accept=".csv" required
                           class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-xl p-1">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition-all">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Unggah &amp; Impor</span>
                    </button>
                    <a href="{{ route('admin.decision-tree.download-template') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                        <i class="fa-solid fa-download text-emerald-600"></i>
                        <span>Template CSV</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Filter & Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tabel Data Latih (Dataset Training)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar kasus historis dan pengaduan terverifikasi yang digunakan untuk membangun model.</p>
                </div>

                <!-- Reset Seeder Action -->
                <form action="{{ route('admin.decision-tree.reset-seeder') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset dataset ke 60 data historis awal? Data kustom akan terhapus.')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset ke 60 Data Seeder</span>
                    </button>
                </form>
            </div>

            <!-- Legenda Indikator Biner Kasus -->
            <div class="px-6 py-3 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <span class="text-slate-500 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-indigo-500"></i>
                    <span>Keterangan Indikator Kasus:</span>
                </span>
                <div class="flex flex-wrap items-center gap-3 text-[11px]">
                    <span class="flex items-center gap-1 text-slate-600">
                        <span class="px-2 py-0.2 rounded-full font-bold bg-rose-50 text-rose-700 border border-rose-200 text-[10px]">Ya</span>
                        = Mengalami Trauma / Cedera Fisik
                    </span>
                    <span class="flex items-center gap-1 text-slate-600">
                        <span class="px-2 py-0.2 rounded-full font-bold bg-purple-50 text-purple-700 border border-purple-200 text-[10px]">Kelompok</span>
                        = Pelaku Lebih dari 1 Orang
                    </span>
                    <span class="flex items-center gap-1 text-slate-600">
                        <span class="px-2 py-0.2 rounded-full font-bold bg-sky-50 text-sky-700 border border-sky-200 text-[10px]">Ada Bukti</span>
                        = Penyebaran Konten Siber / Medsos
                    </span>
                    <span class="flex items-center gap-1 text-slate-600">
                        <span class="px-2 py-0.2 rounded-full font-medium bg-slate-100 text-slate-500 border border-slate-200 text-[10px]">Tidak / Tunggal</span>
                        = Negatif / 1 Pelaku
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-3.5">Kode Kasus</th>
                            <th class="p-3.5">Bentuk Perundungan</th>
                            <th class="p-3.5">Frekuensi</th>
                            <th class="p-3.5 text-center">Trauma Mental</th>
                            <th class="p-3.5 text-center">Luka Fisik</th>
                            <th class="p-3.5 text-center">Pelaku &gt; 1</th>
                            <th class="p-3.5 text-center">Konten Siber</th>
                            <th class="p-3.5">Klasifikasi</th>
                            <th class="p-3.5">Sumber</th>
                            <th class="p-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse ($dataset as $row)
                            @php
                                $badgeClass = match($row->klasifikasi) {
                                    'ringan' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'berat' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-3.5 font-bold font-mono text-slate-900">{{ $row->kode_kasus }}</td>
                                <td class="p-3.5 capitalize font-semibold">{{ $row->bentuk_perundungan }}</td>
                                <td class="p-3.5 capitalize">{{ str_replace('_', ' ', $row->frekuensi_kejadian) }}</td>
                                
                                <!-- Trauma Mental -->
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    @if ($row->trauma_mental)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="fa-solid fa-heart-crack text-[9px]"></i>
                                            <span>Ya</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                            <span>Tidak</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Luka Fisik -->
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    @if ($row->luka_fisik)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="fa-solid fa-bandage text-[9px]"></i>
                                            <span>Ya</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                            <span>Tidak</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Pelaku > 1 Orang -->
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    @if ($row->pelaku_lebih_dari_satu)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <i class="fa-solid fa-users text-[9px]"></i>
                                            <span>Kelompok</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                            <i class="fa-solid fa-user text-[9px]"></i>
                                            <span>Tunggal</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Konten Digital (Siber) -->
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    @if ($row->konten_digital)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                            <i class="fa-solid fa-photo-film text-[9px]"></i>
                                            <span>Ada Bukti</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                            <span>Tidak</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Klasifikasi -->
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded-full border text-[11px] font-bold uppercase {{ $badgeClass }}">
                                        {{ $row->klasifikasi }}
                                    </span>
                                </td>

                                <!-- Sumber -->
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="text-[11px] px-2 py-0.5 rounded-md font-medium {{ $row->sumber === 'pengaduan' ? 'bg-sky-50 text-sky-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($row->sumber) }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="p-3.5 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.decision-tree.dataset.destroy', $row->getKey()) }}" method="POST" onsubmit="return confirm('Hapus data sampel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600 p-1 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-8 text-slate-400">
                                    Tidak ada data dalam dataset latih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Numbered Pagination Bar (Preserves Tab: Dataset) -->
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Menampilkan data ke-<span class="font-bold text-slate-800">{{ $dataset->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-800">{{ $dataset->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-indigo-700">{{ $dataset->total() }}</span> kasus latih
                </div>

                @if ($dataset->hasPages())
                    <div class="flex items-center gap-1 text-xs">
                        {{-- Previous Button --}}
                        @if ($dataset->onFirstPage())
                            <span class="px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 font-bold cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Prev
                            </span>
                        @else
                            <a href="{{ $dataset->appends(['tab' => 'dataset'])->previousPageUrl() }}"
                               class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 font-bold transition-all shadow-2xs">
                                <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Prev
                            </a>
                        @endif

                        {{-- Numbered Page Links --}}
                        @foreach ($dataset->appends(['tab' => 'dataset'])->getUrlRange(max(1, $dataset->currentPage() - 2), min($dataset->lastPage(), $dataset->currentPage() + 2)) as $page => $url)
                            @if ($page == $dataset->currentPage())
                                <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-extrabold flex items-center justify-center shadow-xs">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="w-8 h-8 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center transition-all shadow-2xs">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($dataset->hasMorePages())
                            <a href="{{ $dataset->appends(['tab' => 'dataset'])->nextPageUrl() }}"
                               class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 font-bold transition-all shadow-2xs">
                                Next <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                            </a>
                        @else
                            <span class="px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 font-bold cursor-not-allowed">
                                Next <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- TAB 3: SIMULASI PREDIKSI KASUS BARU -->
    <div x-show="activeTab === 'classify'" class="space-y-6" style="display: none;">
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs max-w-4xl mx-auto">
            <div class="pb-6 border-b border-slate-100 mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold mb-2">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Inference Engine ID3</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800">Uji Coba Prediksi Klasifikasi Kasus Baru</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Masukkan indikator kasus perundungan baru. Sistem akan menelusuri cabang pohon keputusan (Decision Tree Traversal) untuk menyimpulkan klasifikasi tingkat keparahan beserta alur penalaran (Decision Path).
                </p>
            </div>

            <form action="{{ route('admin.decision-tree.classify') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bentuk Perundungan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Bentuk Perundungan *</label>
                        <select name="bentuk_perundungan" required class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="">-- Pilih Bentuk --</option>
                            <option value="verbal">Verbal (Makian, ejekan, penghinaan nama)</option>
                            <option value="fisik">Fisik (Pemukulan, dorongan, penendangan)</option>
                            <option value="sosial">Sosial (Pengucilan, fitnah, perusakan relasi)</option>
                            <option value="siber">Siber / Cyberbullying (Media sosial, grup chat)</option>
                            <option value="seksual">Seksual (Pelecehan fisik, verbal, atau visual)</option>
                        </select>
                    </div>

                    <!-- Frekuensi Kejadian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Frekuensi Kejadian *</label>
                        <select name="frekuensi_kejadian" required class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="">-- Pilih Frekuensi --</option>
                            <option value="sekali">Sekali (Insiden pertama kali)</option>
                            <option value="2-3_kali">2 - 3 Kali (Berulang beberapa kali)</option>
                            <option value="sering">Sering (Berulang intensif / sistematis)</option>
                        </select>
                    </div>

                    <!-- Trauma Mental -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Kondisi Trauma Mental Korban *</label>
                        <select name="trauma_mental" required class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="0">Tidak Mengalami Trauma (Masih mampu beraktivitas normal)</option>
                            <option value="1">Ya, Mengalami Trauma / Ketakutan / Depresi</option>
                        </select>
                    </div>

                    <!-- Luka Fisik -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Adanya Luka Fisik / Cidera *</label>
                        <select name="luka_fisik" required class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="0">Tidak Ada Luka Fisik</option>
                            <option value="1">Ya, Terdapat Luka / Memar / Cedera Fisik</option>
                        </select>
                    </div>

                    <!-- Pelaku Lebih dari Satu -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Jumlah Pelaku (Pengeroyokan/Kelompok)</label>
                        <select name="pelaku_lebih_dari_satu" class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="0">Pelaku Tunggal (1 Orang)</option>
                            <option value="1">Pelaku Lebih dari Satu (Kelompok / Geng)</option>
                        </select>
                    </div>

                    <!-- Konten Digital -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Penyebaran Bukti Konten Digital</label>
                        <select name="konten_digital" class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                            <option value="0">Tidak Ada Penyebaran Digital</option>
                            <option value="1">Ya, Disebarkan via Medsos / WhatsApp / Foto / Video</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Hitung Prediksi dengan Pohon ID3</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
