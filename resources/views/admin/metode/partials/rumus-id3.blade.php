<!-- LANDASAN TEORI & RUMUS MATEMATIS ALGORITMA ID3 -->
<div class="space-y-8">

    <!-- Header & Konsep Dasar ID3 -->
    <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-800 text-white p-6 sm:p-8 rounded-3xl shadow-xl relative overflow-hidden border border-indigo-500/20">
        <!-- Background Decorative Elements -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-20 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3 backdrop-blur-md">
                <i class="fa-solid fa-square-root-variable text-indigo-400"></i>
                <span>Metodologi Machine Learning: Iterative Dichotomiser 3 (ID3)</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-3">
                Landasan Teori &amp; Perhitungan Matematis ID3
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Algoritma ID3 dikembangkan oleh <strong>J. Ross Quinlan (1986)</strong> untuk membangun pohon keputusan (<em>Decision Tree</em>) klasifikasi secara rekursif dari atas ke bawah (<em>Top-Down Induction</em>). ID3 menggunakan konsep <strong>Entropi Informasi Shannon</strong> untuk mengukur derajat keacakan data dan <strong>Information Gain</strong> sebagai kriteria pemilihan atribut pemilah terbaik (<em>Split Node</em>) pada setiap tingkatan pohon.
            </p>

            <!-- 4 Pilar Algoritma ID3 -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-slate-700/60">
                <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-xs">
                    <div class="text-indigo-400 text-sm font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Shannon Entropy</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-normal">
                        Mengukur ketidakpastian atau keheterogenan kelas data kasus perundungan.
                    </p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-xs">
                    <div class="text-emerald-400 text-sm font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span>Information Gain</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-normal">
                        Mengukur efektivitas atribut dalam mereduksi nilai entropi himpunan data.
                    </p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-xs">
                    <div class="text-amber-400 text-sm font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Greedy Search</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-normal">
                        Memilih atribut dengan Gain terbesar pada setiap level tanpa proses <em>backtrack</em>.
                    </p>
                </div>

                <div class="bg-white/5 border border-white/10 rounded-xl p-3 backdrop-blur-xs">
                    <div class="text-purple-400 text-sm font-bold mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-bullseye"></i>
                        <span>Purity Termination</span>
                    </div>
                    <p class="text-[11px] text-slate-300 leading-normal">
                        Berhenti saat seluruh sampel homogen (murni), atribut habis, atau batas kedalaman tercapai.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 RUMUS UTAMA (CORE FORMULAS) -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-calculator text-indigo-600"></i>
                    <span>Rumus-Rumus Matematis Algoritma ID3</span>
                </h3>
                <p class="text-xs text-slate-500">
                    Formulasi standar yang digunakan mesin untuk menghitung probabilitas dan penurunan entropi.
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-xs font-semibold">
                <i class="fa-solid fa-square-check text-emerald-500"></i>
                <span>Standar Quinlan (1986)</span>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card 1: Entropi Total S -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-indigo-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-600 font-extrabold text-xs">
                                01
                            </span>
                            <h4 class="text-sm font-bold text-slate-800">Entropi Himpunan Kasus (Entropy S)</h4>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase">
                            Derajat Keacakan
                        </span>
                    </div>

                    <!-- Kotak Rumus Formal -->
                    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white p-4 rounded-xl font-mono text-center mb-4 shadow-inner border border-slate-800">
                        <div class="text-xs text-indigo-300 mb-1 font-sans">Rumus Shannon's Entropy:</div>
                        <div class="text-base sm:text-lg font-bold text-amber-300 tracking-wider">
                            Entropy(S) = &sum;<sub>i=1</sub><sup>c</sup> -p<sub>i</sub> &times; log<sub>2</sub>(p<sub>i</sub>)
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-3">
                        Mengukur ketidakpastian himpunan data kasus <em>S</em> terhadap kelas target (<strong>Ringan, Sedang, Berat</strong>).
                    </p>

                    <!-- Definisi Variabel -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/70 text-[11px] text-slate-600 space-y-1.5 font-sans">
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-8 shrink-0">S</strong>
                            <span>Himpunan sampel kasus perundungan yang sedang dievaluasi.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-8 shrink-0">c</strong>
                            <span>Jumlah kelas keputusan target (<code class="bg-white px-1 py-0.5 rounded border border-slate-200 font-bold text-indigo-600">c = 3</code> : Ringan, Sedang, Berat).</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-8 shrink-0">p<sub>i</sub></strong>
                            <span>Proporsi sampel kasus kelas <em>i</em> terhadap total sampel <em>S</em> (<code class="bg-white px-1 py-0.5 rounded border border-slate-200 font-mono">p<sub>i</sub> = |S<sub>i</sub>| / |S|</code>).</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-8 shrink-0">log<sub>2</sub></strong>
                            <span>Logaritma basis 2 (satuan pengukuran dalam bit informasi).</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-emerald-700 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>Entropy = 0 &rarr; Kasus 100% Homogen (Murni)</span>
                    </span>
                    <span class="text-slate-500 font-mono">Max = log<sub>2</sub>(3) &approx; 1.585</span>
                </div>
            </div>

            <!-- Card 2: Entropi Subset Cabang Sv -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-purple-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-purple-50 border border-purple-200 flex items-center justify-center text-purple-600 font-extrabold text-xs">
                                02
                            </span>
                            <h4 class="text-sm font-bold text-slate-800">Entropi Subset Cabang (Entropy S<sub>v</sub>)</h4>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 uppercase">
                            Ketidakpastian Cabang
                        </span>
                    </div>

                    <!-- Kotak Rumus Formal -->
                    <div class="bg-gradient-to-r from-slate-900 to-purple-950 text-white p-4 rounded-xl font-mono text-center mb-4 shadow-inner border border-slate-800">
                        <div class="text-xs text-purple-300 mb-1 font-sans">Rumus Entropi Subset Cabang Nilai v:</div>
                        <div class="text-base sm:text-lg font-bold text-amber-300 tracking-wider">
                            Entropy(S<sub>v</sub>) = &sum;<sub>j=1</sub><sup>c</sup> -p<sub>v,j</sub> &times; log<sub>2</sub>(p<sub>v,j</sub>)
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-3">
                        Mengukur ketidakpastian khusus pada subset data <em>S<sub>v</sub></em> yang memiliki nilai cabang <em>v</em> pada atribut tertentu.
                    </p>

                    <!-- Definisi Variabel -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/70 text-[11px] text-slate-600 space-y-1.5 font-sans">
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-10 shrink-0">S<sub>v</sub></strong>
                            <span>Subset data kasus di mana atribut <em>A</em> bernilai <em>v</em> (misal: <em>Luka Fisik = 'Ya'</em>).</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-10 shrink-0">p<sub>v,j</sub></strong>
                            <span>Proporsi kasus kelas <em>j</em> khusus di dalam subset cabang <em>S<sub>v</sub></em> (<code class="bg-white px-1 py-0.5 rounded border border-slate-200 font-mono">p<sub>v,j</sub> = |S<sub>v,j</sub>| / |S<sub>v</sub>|</code>).</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-10 shrink-0">0 log 0</strong>
                            <span>Sesuai definisi batas informasi Shannon: jika <code class="font-mono">p = 0</code>, maka <code class="font-mono">0 &times; log<sub>2</sub>(0) = 0</code>.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-purple-700 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-code-branch text-purple-500"></i>
                        <span>Dihitung untuk tiap variasi nilai atribut</span>
                    </span>
                    <span class="text-slate-500 font-mono">&forall; v &isin; Values(A)</span>
                </div>
            </div>

            <!-- Card 3: Information Gain(S, A) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 font-extrabold text-xs">
                                03
                            </span>
                            <h4 class="text-sm font-bold text-slate-800">Information Gain Atribut (Gain S, A)</h4>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                            Reduksi Entropi
                        </span>
                    </div>

                    <!-- Kotak Rumus Formal -->
                    <div class="bg-gradient-to-r from-slate-900 to-emerald-950 text-white p-4 rounded-xl font-mono text-center mb-4 shadow-inner border border-slate-800">
                        <div class="text-xs text-emerald-300 mb-1 font-sans">Rumus Perolehan Informasi:</div>
                        <div class="text-sm sm:text-base font-bold text-amber-300 tracking-tight sm:tracking-wider">
                            Gain(S, A) = Entropy(S) - &sum;<sub>v &isin; Values(A)</sub> <span class="text-emerald-300">(|S<sub>v</sub>| / |S|)</span> &times; Entropy(S<sub>v</sub>)
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-3">
                        Menghitung efektivitas suatu atribut dalam memisahkan data ke dalam kelas target. Semakin tinggi nilai Gain, semakin kuat atribut tersebut membedakan keparahan kasus.
                    </p>

                    <!-- Definisi Variabel -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/70 text-[11px] text-slate-600 space-y-1.5 font-sans">
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-14 shrink-0">Values(A)</strong>
                            <span>Himpunan semua nilai unik yang dimiliki oleh atribut <em>A</em>.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-14 shrink-0">|S<sub>v</sub>| / |S|</strong>
                            <span>Bobot proporsi ukuran data cabang <em>v</em> terhadap total keseluruhan sampel <em>S</em>.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <strong class="text-slate-800 font-mono w-14 shrink-0">&sum; Bobot&times;E</strong>
                            <span>Entropi rata-rata terbobot (<em>Weighted Entropy</em>) setelah himpunan data dipartisi oleh atribut <em>A</em>.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-emerald-700 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up-right-dots text-emerald-500"></i>
                        <span>Gain bernilai &ge; 0 (Makin besar makin baik)</span>
                    </span>
                    <span class="text-slate-500 font-mono">Gain = E(S) - E<sub>weighted</sub></span>
                </div>
            </div>

            <!-- Card 4: Kriteria Split Node & Stopping Condition -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs hover:border-amber-300 transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 font-extrabold text-xs">
                                04
                            </span>
                            <h4 class="text-sm font-bold text-slate-800">Kriteria Split Node &amp; Kondisi Berhenti</h4>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase">
                            Seleksi Terbaik
                        </span>
                    </div>

                    <!-- Kotak Rumus Formal -->
                    <div class="bg-gradient-to-r from-slate-900 to-amber-950 text-white p-4 rounded-xl font-mono text-center mb-4 shadow-inner border border-slate-800">
                        <div class="text-xs text-amber-300 mb-1 font-sans">Kriteria Pemilihan Node Terbaik:</div>
                        <div class="text-base sm:text-lg font-bold text-amber-300 tracking-wider">
                            A<sup>*</sup> = argmax<sub>A &isin; Atribut</sub> Gain(S, A)
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-3">
                        Atribut <em>A<sup>*</sup></em> dengan nilai Information Gain tertinggi secara otomatis terpilih sebagai <strong>Node Akar (Root Node)</strong> pada tingkat pertama, atau sebagai <strong>Internal Split Node</strong> pada sub-cabang berikutnya.
                    </p>

                    <!-- Syarat Berhenti (Stopping Criteria) -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/70 text-[11px] text-slate-600 space-y-1.5 font-sans">
                        <div class="flex items-start gap-2">
                            <span class="text-emerald-600 font-bold shrink-0">&bull; Pure Leaf:</span>
                            <span>Jika <code class="font-mono">Entropy(S<sub>v</sub>) = 0</code>, subset sudah homogen &rarr; Langsung menjadi <strong>Leaf Node</strong>.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-indigo-600 font-bold shrink-0">&bull; Batas Kedalaman:</span>
                            <span>Jika atribut kandidat habis atau kedalaman mencapai batas (<code class="font-mono">Max Depth = 6</code>), daun dibuat menggunakan kelas mayoritas.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-amber-600 font-bold shrink-0">&bull; Gain Nol:</span>
                            <span>Jika semua <code class="font-mono">Gain &le; 0</code>, pemisahan data dihentikan karena tidak menambah informasi baru.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-amber-700 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-flag-checkered text-amber-500"></i>
                        <span>Diulang secara rekursif hingga tuntas</span>
                    </span>
                    <span class="text-slate-500 font-mono">Max Depth = 6 level</span>
                </div>
            </div>

        </div>
    </div>

    <!-- RINCIAN PERHITUNGAN LANGKAH-DEMI-LANGKAH (LIVE DATASET COMPUTATION) -->
    @if ($detailedCalculation && isset($detailedCalculation['total_samples']) && $detailedCalculation['total_samples'] > 0)
        <div class="space-y-6 pt-4 border-t border-slate-200">
            <!-- Header Section Live Calculation -->
            <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-database"></i>
                        <span>Komputasi Berdasarkan Dataset Nyata</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-800 tracking-tight">
                        Simulasi Perhitungan Nyata Algoritma ID3 pada Dataset Aktif
                    </h3>
                    <p class="text-xs text-slate-600 mt-0.5">
                        Berikut adalah rincian matematis langkah-demi-langkah yang dihitung langsung oleh mesin berdasarkan <strong>{{ $detailedCalculation['total_samples'] }} sampel kasus</strong> yang tersimpan di sistem saat ini.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="bg-white px-4 py-2.5 rounded-xl border border-indigo-200 text-right shadow-2xs">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Entropy Total Himpunan S</div>
                        <div class="text-lg font-extrabold text-indigo-700 font-mono">
                            {{ $detailedCalculation['entropy_total'] }}
                        </div>
                    </div>
                    <div class="bg-white px-4 py-2.5 rounded-xl border border-indigo-200 text-right shadow-2xs">
                        <div class="text-[10px] font-bold text-slate-400 uppercase">Node Utama (Gain Max)</div>
                        <div class="text-xs font-extrabold text-slate-800 truncate max-w-36">
                            {{ $detailedCalculation['best_attribute']['label'] ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- LANGKAH 1: PERHITUNGAN ENTROPI TOTAL S -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            Step 1
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Menghitung Entropi Total Himpunan Kasus (Entropy S)</h4>
                            <p class="text-xs text-slate-500">Mengevaluasi keanekaragaman kelas keparahan kasus pada seluruh data latih sebelum dilakukan pemisahan.</p>
                        </div>
                    </div>
                    <span class="text-xs font-mono font-bold text-indigo-600 px-3 py-1 bg-indigo-50 rounded-lg border border-indigo-200">
                        |S| = {{ $detailedCalculation['total_samples'] }} Kasus
                    </span>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Sebaran Sampel Per Kelas -->
                    <div>
                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
                            A. Distribusi Frekuensi &amp; Probabilitas Kelas Target (p<sub>i</sub>)
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <!-- Ringan -->
                            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/40">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>Kasus Ringan (p<sub>1</sub>)</span>
                                    </span>
                                    <span class="text-xs font-mono font-bold text-emerald-700">
                                        {{ $detailedCalculation['class_counts']['ringan'] }} kasus
                                    </span>
                                </div>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between text-slate-600">
                                        <span>Proporsi p<sub>1</sub> = {{ $detailedCalculation['class_counts']['ringan'] }} / {{ $detailedCalculation['total_samples'] }}:</span>
                                        <strong class="font-mono text-slate-800">{{ $detailedCalculation['class_proportions']['ringan'] }}</strong>
                                    </div>
                                    <div class="flex justify-between text-slate-600">
                                        <span>-p<sub>1</sub> &times; log<sub>2</sub>(p<sub>1</sub>):</span>
                                        <strong class="font-mono text-emerald-700">{{ $detailedCalculation['entropy_terms']['ringan'] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Sedang -->
                            <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/40">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span>Kasus Sedang (p<sub>2</sub>)</span>
                                    </span>
                                    <span class="text-xs font-mono font-bold text-amber-700">
                                        {{ $detailedCalculation['class_counts']['sedang'] }} kasus
                                    </span>
                                </div>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between text-slate-600">
                                        <span>Proporsi p<sub>2</sub> = {{ $detailedCalculation['class_counts']['sedang'] }} / {{ $detailedCalculation['total_samples'] }}:</span>
                                        <strong class="font-mono text-slate-800">{{ $detailedCalculation['class_proportions']['sedang'] }}</strong>
                                    </div>
                                    <div class="flex justify-between text-slate-600">
                                        <span>-p<sub>2</sub> &times; log<sub>2</sub>(p<sub>2</sub>):</span>
                                        <strong class="font-mono text-amber-700">{{ $detailedCalculation['entropy_terms']['sedang'] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Berat -->
                            <div class="p-4 rounded-xl border border-rose-200 bg-rose-50/40">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        <span>Kasus Berat (p<sub>3</sub>)</span>
                                    </span>
                                    <span class="text-xs font-mono font-bold text-rose-700">
                                        {{ $detailedCalculation['class_counts']['berat'] }} kasus
                                    </span>
                                </div>
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between text-slate-600">
                                        <span>Proporsi p<sub>3</sub> = {{ $detailedCalculation['class_counts']['berat'] }} / {{ $detailedCalculation['total_samples'] }}:</span>
                                        <strong class="font-mono text-slate-800">{{ $detailedCalculation['class_proportions']['berat'] }}</strong>
                                    </div>
                                    <div class="flex justify-between text-slate-600">
                                        <span>-p<sub>3</sub> &times; log<sub>2</sub>(p<sub>3</sub>):</span>
                                        <strong class="font-mono text-rose-700">{{ $detailedCalculation['entropy_terms']['berat'] }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Persamaan Substitusi Lengkap -->
                    <div>
                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            B. Substitusi Nilai ke Dalam Rumus Entropi Shannon
                        </div>
                        <div class="bg-slate-900 text-slate-100 p-4 sm:p-5 rounded-xl font-mono text-xs sm:text-sm leading-relaxed overflow-x-auto shadow-inner border border-slate-800">
                            <div class="text-slate-400">// Persamaan Substitusi Entropi:</div>
                            <div class="mt-1 text-slate-300">
                                Entropy(S) = - [ p(Ringan)&times;log<sub>2</sub>(p(Ringan)) + p(Sedang)&times;log<sub>2</sub>(p(Sedang)) + p(Berat)&times;log<sub>2</sub>(p(Berat)) ]
                            </div>
                            <div class="mt-2 text-indigo-300">
                                Entropy(S) = - [ ({{ $detailedCalculation['class_proportions']['ringan'] }} &times; log<sub>2</sub>({{ $detailedCalculation['class_proportions']['ringan'] }})) + ({{ $detailedCalculation['class_proportions']['sedang'] }} &times; log<sub>2</sub>({{ $detailedCalculation['class_proportions']['sedang'] }})) + ({{ $detailedCalculation['class_proportions']['berat'] }} &times; log<sub>2</sub>({{ $detailedCalculation['class_proportions']['berat'] }})) ]
                            </div>
                            <div class="mt-2 text-emerald-300">
                                Entropy(S) = {{ $detailedCalculation['entropy_terms']['ringan'] }} + {{ $detailedCalculation['entropy_terms']['sedang'] }} + {{ $detailedCalculation['entropy_terms']['berat'] }}
                            </div>
                            <div class="mt-3 pt-3 border-t border-slate-800 flex items-center justify-between">
                                <span class="text-amber-400 font-bold">&rArr; Nilai Entropi Total Himpunan Data S:</span>
                                <span class="text-lg font-extrabold text-amber-300 bg-amber-500/10 px-3 py-1 rounded-lg border border-amber-500/30">
                                    Entropy(S) = {{ $detailedCalculation['entropy_total'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LANGKAH 2: PERHITUNGAN INFORMATION GAIN SETIAP ATRIBUT -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            Step 2
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Menghitung Information Gain untuk Setiap Atribut Kandidat</h4>
                            <p class="text-xs text-slate-500">Mengevaluasi penurunan entropi (Gain) jika data dipisahkan berdasarkan masing-masing atribut indikator.</p>
                        </div>
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">
                        {{ count($detailedCalculation['attributes']) }} Atribut Diuji
                    </span>
                </div>

                <div class="p-6 space-y-6">
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Untuk setiap atribut kandidat, himpunan data <em>S</em> dipartisi ke dalam cabang-cabang nilai <em>v</em>. Pada tiap cabang, dihitung nilai <strong>Entropy(S<sub>v</sub>)</strong> dan <strong>Entropi Terbobot</strong> (|S<sub>v</sub>| / |S| &times; Entropy(S<sub>v</sub>)). Nilai <strong>Gain(S, A)</strong> diperoleh dari pengurangan Entropi Total dengan jumlah Entropi Terbobot.
                    </p>

                    <!-- Accordion / Grid Per Atribut -->
                    <div class="space-y-4">
                        @foreach ($detailedCalculation['attributes'] as $attrKey => $attrCalc)
                            @php
                                $isBest = ($detailedCalculation['best_attribute']['attribute'] ?? '') === $attrKey;
                            @endphp
                            <div class="border rounded-2xl transition-all {{ $isBest ? 'border-indigo-400 bg-indigo-50/20 shadow-xs ring-1 ring-indigo-200' : 'border-slate-200 hover:border-slate-300 bg-white' }}"
                                 x-data="{ openDetail: {{ $isBest ? 'true' : 'false' }} }">
                                <!-- Atribut Bar Header -->
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 cursor-pointer select-none"
                                     @click="openDetail = !openDetail">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm {{ $isBest ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                            @if ($isBest)
                                                <i class="fa-solid fa-crown text-amber-300"></i>
                                            @else
                                                <i class="fa-solid fa-sliders text-xs"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h5 class="text-sm font-extrabold text-slate-800">{{ $attrCalc['label'] }}</h5>
                                                @if ($isBest)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-600 text-white uppercase tracking-wider">
                                                        Gain Tertinggi (Root Node)
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[11px] text-slate-500 font-mono">
                                                Atribut: <code class="text-indigo-600">{{ $attrKey }}</code> &bull; {{ count($attrCalc['branches']) }} Cabang Nilai
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 sm:justify-end">
                                        <div class="text-right">
                                            <div class="text-[10px] text-slate-400 font-bold uppercase">Nilai Information Gain</div>
                                            <div class="text-base sm:text-lg font-extrabold font-mono {{ $isBest ? 'text-indigo-700' : 'text-slate-800' }}">
                                                Gain = {{ $attrCalc['gain'] }}
                                            </div>
                                        </div>
                                        <button type="button" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-transform" :class="openDetail ? 'rotate-180' : ''">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Detail Perhitungan Cabang Tabel (Expandable) -->
                                <div x-show="openDetail" class="px-4 pb-5 sm:px-6 sm:pb-6 border-t border-slate-100 pt-4" style="{{ $isBest ? '' : 'display: none;' }}">
                                    <div class="overflow-x-auto rounded-xl border border-slate-200 text-xs">
                                        <table class="w-full text-left divide-y divide-slate-200">
                                            <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase">
                                                <tr>
                                                    <th class="p-3">Nilai Cabang (v)</th>
                                                    <th class="p-3 text-center">Jumlah Sampel (|S<sub>v</sub>|)</th>
                                                    <th class="p-3 text-center">Bobot (|S<sub>v</sub>| / |S|)</th>
                                                    <th class="p-3 text-center">Sebaran [R / S / B]</th>
                                                    <th class="p-3 text-center">Entropy(S<sub>v</sub>)</th>
                                                    <th class="p-3 text-right">Entropi Terbobot</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 font-sans">
                                                @foreach ($attrCalc['branches'] as $br)
                                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                                        <td class="p-3 font-semibold text-slate-800 flex items-center gap-2">
                                                            <span class="w-2 h-2 rounded-full {{ $br['entropy'] == 0 ? 'bg-emerald-500' : 'bg-indigo-400' }}"></span>
                                                            <span>{{ $br['label'] }}</span>
                                                            @if ($br['entropy'] == 0)
                                                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 font-bold border border-emerald-200">
                                                                    Murni (Pure)
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="p-3 text-center font-mono font-bold text-slate-700">
                                                            {{ $br['total'] }} kasus
                                                        </td>
                                                        <td class="p-3 text-center font-mono text-slate-600">
                                                            {{ $br['total'] }}/{{ $detailedCalculation['total_samples'] }} = <strong class="text-slate-800">{{ $br['weight'] }}</strong>
                                                        </td>
                                                        <td class="p-3 text-center font-mono text-[11px]">
                                                            <span class="text-emerald-700 font-bold">{{ $br['distribution']['ringan'] ?? 0 }}</span> /
                                                            <span class="text-amber-700 font-bold">{{ $br['distribution']['sedang'] ?? 0 }}</span> /
                                                            <span class="text-rose-700 font-bold">{{ $br['distribution']['berat'] ?? 0 }}</span>
                                                        </td>
                                                        <td class="p-3 text-center font-mono {{ $br['entropy'] == 0 ? 'text-emerald-600 font-bold' : 'text-slate-700' }}">
                                                            {{ $br['entropy'] }}
                                                        </td>
                                                        <td class="p-3 text-right font-mono font-bold text-indigo-700">
                                                            {{ $br['weighted_entropy'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-slate-50 font-bold text-slate-700 border-t border-slate-200">
                                                <tr>
                                                    <td colspan="5" class="p-3 text-right uppercase text-[11px] text-slate-500">
                                                        Total Entropi Terbobot (&sum; |S<sub>v</sub>|/|S| &times; Entropy(S<sub>v</sub>)):
                                                    </td>
                                                    <td class="p-3 text-right font-mono text-slate-900 font-extrabold">
                                                        {{ $attrCalc['sum_weighted_entropy'] }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Persamaan Gain Final Atribut -->
                                    <div class="mt-3 p-3.5 bg-slate-900 text-slate-100 rounded-xl font-mono text-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 shadow-inner">
                                        <div class="flex items-center gap-2">
                                            <span class="text-slate-400 font-sans">Formula Pengurangan:</span>
                                            <span class="text-indigo-300">Gain(S, {{ $attrCalc['label'] }}) = Entropy(S) - &sum; Entropi Terbobot</span>
                                        </div>
                                        <div class="text-emerald-300 font-bold">
                                            {{ $detailedCalculation['entropy_total'] }} - {{ $attrCalc['sum_weighted_entropy'] }} = <span class="text-amber-300 text-sm font-extrabold bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/30">{{ $attrCalc['gain'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- LANGKAH 3: MATRIKS PERBANDINGAN GAIN & PENENTUAN NODE AKAR -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            Step 3
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Matriks Perbandingan Information Gain &amp; Penetapan Node Akar</h4>
                            <p class="text-xs text-slate-500">Memilih atribut dengan Gain maksimal (ArgMax) untuk dijadikan Root Node pohon keputusan.</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                        <i class="fa-solid fa-crown text-amber-500"></i>
                        <span>Root Selected</span>
                    </span>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Tabel Ranking Information Gain -->
                    <div class="overflow-x-auto rounded-xl border border-slate-200 text-xs">
                        <table class="w-full text-left divide-y divide-slate-200">
                            <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase">
                                <tr>
                                    <th class="p-3 text-center w-14">Rank</th>
                                    <th class="p-3">Nama Atribut Indikator</th>
                                    <th class="p-3 text-center">Entropi Terbobot</th>
                                    <th class="p-3 text-center">Nilai Information Gain</th>
                                    <th class="p-3 text-center">Visual Bar Proporsi</th>
                                    <th class="p-3 text-right">Status Keputusan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-sans">
                                @php
                                    $rank = 1;
                                    $maxGainVal = !empty($detailedCalculation['attributes']) ? max(array_column($detailedCalculation['attributes'], 'gain')) : 1;
                                    if ($maxGainVal <= 0) $maxGainVal = 1;
                                @endphp
                                @foreach ($detailedCalculation['attributes'] as $attrKey => $attrCalc)
                                    @php
                                        $isWinner = ($rank === 1);
                                        $barPercent = round(($attrCalc['gain'] / $maxGainVal) * 100);
                                    @endphp
                                    <tr class="{{ $isWinner ? 'bg-indigo-50/50 font-bold' : 'hover:bg-slate-50/80' }} transition-colors">
                                        <td class="p-3 text-center">
                                            @if ($isWinner)
                                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-extrabold text-xs inline-flex items-center justify-center shadow-xs">
                                                    1
                                                </span>
                                            @else
                                                <span class="text-slate-400 font-bold">#{{ $rank }}</span>
                                            @endif
                                        </td>
                                        <td class="p-3 font-bold text-slate-800 flex items-center gap-2">
                                            <span>{{ $attrCalc['label'] }}</span>
                                            @if ($isWinner)
                                                <i class="fa-solid fa-crown text-amber-500 text-xs"></i>
                                            @endif
                                        </td>
                                        <td class="p-3 text-center font-mono text-slate-600">
                                            {{ $attrCalc['sum_weighted_entropy'] }}
                                        </td>
                                        <td class="p-3 text-center font-mono text-sm font-extrabold {{ $isWinner ? 'text-indigo-700' : 'text-slate-800' }}">
                                            {{ $attrCalc['gain'] }}
                                        </td>
                                        <td class="p-3 text-center w-48">
                                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                                <div class="h-full rounded-full {{ $isWinner ? 'bg-gradient-to-r from-indigo-600 to-purple-600' : 'bg-slate-400' }}"
                                                     style="width: {{ $barPercent }}%"></div>
                                            </div>
                                        </td>
                                        <td class="p-3 text-right">
                                            @if ($isWinner)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-indigo-600 text-white shadow-xs">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>Terpilih sebagai Root Node</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    <span>Kandidat Level Cabang</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $rank++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Kesimpulan Naratif Hasil Teorema ID3 -->
                    @if ($detailedCalculation['best_attribute'])
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-5 rounded-2xl border border-indigo-200 flex items-start gap-4 text-xs leading-relaxed text-indigo-950">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-base shadow-xs">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div>
                                <h5 class="font-extrabold text-indigo-900 text-sm mb-1">Kesimpulan Pemilihan Node Akar (Root Decision)</h5>
                                <p>
                                    Berdasarkan teorema ID3, atribut <strong>{{ $detailedCalculation['best_attribute']['label'] }}</strong> menghasilkan Information Gain tertinggi yaitu <code class="bg-white px-2 py-0.5 rounded font-mono font-bold text-indigo-700 border border-indigo-200">{{ $detailedCalculation['best_attribute']['gain'] }}</code>.
                                    Hal ini membuktikan secara matematis bahwa mempartisi data kasus perundungan berdasarkan atribut <strong>{{ $detailedCalculation['best_attribute']['label'] }}</strong> memberikan reduksi ketidakpastian terbesar dibandingkan seluruh atribut lainnya, sehingga secara sah terpilih sebagai <strong>Node Akar (Root Node)</strong> dari Pohon Keputusan ini.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- LANGKAH 4: ALUR REKURSI CABANG ANAK (SUB-TREE GENERATION) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            Step 4
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Proses Rekursif Pembentukan Sub-Pohon (Recursive Splitting)</h4>
                            <p class="text-xs text-slate-500">Meneruskan partisi cabang yang belum murni hingga seluruh aturan keputusan terbentuk.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 font-mono">
                        Loop: Repeat Step 1-3
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cabang Murni (Homogen) -->
                        <div class="p-5 rounded-2xl border border-emerald-200 bg-emerald-50/30">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-200 text-emerald-700 flex items-center justify-center text-lg font-bold mb-3">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <h5 class="text-sm font-bold text-emerald-950 mb-1.5">Cabang Homogen (Entropy = 0) &rarr; Leaf Node</h5>
                            <p class="text-xs text-slate-600 leading-relaxed mb-3">
                                Apabila suatu cabang hanya menghasilkan sampel dari 1 kelas tertentu (misal: seluruh kasus pada cabang ini berkategori <strong>Berat</strong>), maka cabang tersebut dihentikan dan dijadikan <strong>Daun Keputusan (Leaf Node)</strong> dengan tingkat keyakinan <em>(Confidence)</em> 100%.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-lg">
                                <i class="fa-solid fa-check-double"></i>
                                <span>Menghasilkan Aturan Pasti (Rule Engine)</span>
                            </span>
                        </div>

                        <!-- Cabang Heterogen (Belum Murni) -->
                        <div class="p-5 rounded-2xl border border-indigo-200 bg-indigo-50/30">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 border border-indigo-200 text-indigo-700 flex items-center justify-center text-lg font-bold mb-3">
                                <i class="fa-solid fa-code-fork"></i>
                            </div>
                            <h5 class="text-sm font-bold text-indigo-950 mb-1.5">Cabang Heterogen (Entropy > 0) &rarr; Rekursi Lanjutan</h5>
                            <p class="text-xs text-slate-600 leading-relaxed mb-3">
                                Apabila suatu cabang masih memuat campuran kelas (misal: terdapat kasus Sedang dan Berat), maka algoritma ID3 akan mengulangi <strong>Langkah 1 s.d. Langkah 3</strong> khusus untuk subset data pada cabang tersebut, menggunakan sisa atribut kandidat yang belum dipakai.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-indigo-700 bg-indigo-100/70 px-2.5 py-1 rounded-lg">
                                <i class="fa-solid fa-arrows-spin"></i>
                                <span>Membentuk Internal Branch Node Baru</span>
                            </span>
                        </div>
                    </div>

                    <!-- Shortcut to Visual Tree -->
                    <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <span class="text-xs text-slate-500">
                            Ingin melihat bentuk fisik pohon keputusan yang dihasilkan dari kalkulasi ini?
                        </span>
                        <button type="button" @click="activeTab = 'tree'"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition-all hover:scale-[1.02] active:scale-95">
                            <i class="fa-solid fa-network-wired"></i>
                            <span>Buka Visualisasi Pohon Keputusan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white p-12 rounded-2xl border border-slate-200 text-center">
            <i class="fa-solid fa-database text-4xl text-slate-300 mb-3"></i>
            <h4 class="text-base font-bold text-slate-700">Dataset Latih Masih Kosong</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                Silakan sinkronisasi data dari pengaduan atau impor file CSV data historis untuk memuat simulasi perhitungan langkah-demi-langkah ID3.
            </p>
        </div>
    @endif

</div>
