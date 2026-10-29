@extends('admin.layouts.template')
@section('title', 'Hasil Prediksi Decision Tree')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.decision-tree.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Halaman Decision Tree</span>
        </a>
        <span class="text-xs text-slate-400">Algoritma ID3 (Decision Tree Traversal)</span>
    </div>

    @php
        $label = strtolower($klasifikasi);
        $theme = match($label) {
            'ringan' => [
                'bg' => 'bg-emerald-50',
                'border' => 'border-emerald-200',
                'text' => 'text-emerald-800',
                'badge' => 'bg-emerald-500 text-white',
                'icon' => 'fa-circle-check',
                'action' => 'Penanganan internal melalui mediasi wali kelas dan Guru BK. Pemantauan perilaku selama 2 minggu.',
            ],
            'sedang' => [
                'bg' => 'bg-amber-50',
                'border' => 'border-amber-200',
                'text' => 'text-amber-800',
                'badge' => 'bg-amber-500 text-white',
                'icon' => 'fa-triangle-exclamation',
                'action' => 'Konseling terstruktur oleh Guru BK, pemanggilan orang tua kedua belah pihak, dan pendampingan psikologis korban.',
            ],
            'berat' => [
                'bg' => 'bg-rose-50',
                'border' => 'border-rose-200',
                'text' => 'text-rose-800',
                'badge' => 'bg-rose-600 text-white',
                'icon' => 'fa-skull-crossbones',
                'action' => 'Eskalasi segera ke Kepala Sekolah, Dinas Sosial, dan tim TPPK. Pendampingan medis/visum jika luka fisik, dan perlindungan darurat bagi korban.',
            ],
            default => [
                'bg' => 'bg-slate-50',
                'border' => 'border-slate-200',
                'text' => 'text-slate-800',
                'badge' => 'bg-slate-700 text-white',
                'icon' => 'fa-info-circle',
                'action' => 'Pemeriksaan lanjutan oleh petugas konseling.',
            ],
        };
    @endphp

    <!-- Result Banner -->
    <div class="p-8 rounded-3xl border-2 {{ $theme['border'] }} {{ $theme['bg'] }} shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl {{ $theme['badge'] }} flex items-center justify-center text-3xl shadow-md">
                    <i class="fa-solid {{ $theme['icon'] }}"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider {{ $theme['text'] }} opacity-80">
                        Hasil Klasifikasi Kasus
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight {{ $theme['text'] }}">
                        Kasus Tingkat {{ $klasifikasi }}
                    </h1>
                    <p class="text-xs {{ $theme['text'] }} opacity-80 mt-1 font-medium">
                        Tingkat Keyakinan Prediksi: <b class="font-mono">{{ $confidence }}%</b>
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div>
                <a href="{{ route('admin.decision-tree.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs transition-all">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Uji Kasus Lain</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Input Attributes Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-indigo-600"></i>
                <span>Parameter Input Kasus</span>
            </h3>

            <div class="divide-y divide-slate-100 text-xs">
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Bentuk Perundungan</span>
                    <span class="font-bold text-slate-800 capitalize">{{ $validated['bentuk_perundungan'] }}</span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Frekuensi Kejadian</span>
                    <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $validated['frekuensi_kejadian']) }}</span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Trauma Mental</span>
                    <span class="font-bold {{ $validated['trauma_mental'] ? 'text-rose-600' : 'text-slate-600' }}">
                        {{ $validated['trauma_mental'] ? 'Ya, Mengalami Trauma' : 'Tidak' }}
                    </span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Luka Fisik</span>
                    <span class="font-bold {{ $validated['luka_fisik'] ? 'text-rose-600' : 'text-slate-600' }}">
                        {{ $validated['luka_fisik'] ? 'Ya, Ada Luka Fisik' : 'Tidak' }}
                    </span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Pelaku &gt; 1 Orang</span>
                    <span class="font-bold {{ !empty($validated['pelaku_lebih_dari_satu']) ? 'text-indigo-600' : 'text-slate-600' }}">
                        {{ !empty($validated['pelaku_lebih_dari_satu']) ? 'Ya (Kelompok / Geng)' : 'Tidak (Tunggal)' }}
                    </span>
                </div>
                <div class="py-2.5 flex justify-between items-center">
                    <span class="text-slate-500 font-medium">Penyebaran Siber / Digital</span>
                    <span class="font-bold {{ !empty($validated['konten_digital']) ? 'text-indigo-600' : 'text-slate-600' }}">
                        {{ !empty($validated['konten_digital']) ? 'Ya (Ada Bukti Digital)' : 'Tidak' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Decision Path & Recommendation -->
        <div class="space-y-6">
            <!-- Traversed Path -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-route text-indigo-600"></i>
                    <span>Jalur Keputusan (Decision Path Trace)</span>
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Alur evaluasi simpul pohon yang dilewati dari root hingga menghasilkan kesimpulan:
                </p>

                <div class="space-y-2 text-xs">
                    @foreach ($path as $idx => $step)
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[10px] font-bold flex items-center justify-center shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="p-2 rounded-xl bg-slate-50 border border-slate-100 text-slate-700 font-mono text-[11px] flex-1">
                                {{ $step }}
                            </div>
                        </div>
                    @endforeach
                    <div class="flex items-center gap-3 pt-2">
                        <span class="w-6 h-6 rounded-full {{ $theme['badge'] }} text-xs font-bold flex items-center justify-center shrink-0">
                            &check;
                        </span>
                        <div class="p-2.5 rounded-xl {{ $theme['bg'] }} border {{ $theme['border'] }} font-bold text-xs flex-1 {{ $theme['text'] }}">
                            Kesimpulan: Tingkat {{ strtoupper($klasifikasi) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Standard Protocol Recommendation -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-800 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-hand-holding-medical text-indigo-600"></i>
                    <span>Rekomendasi Tindak Lanjut Satuan Pendidikan</span>
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed mt-2 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                    {{ $theme['action'] }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection