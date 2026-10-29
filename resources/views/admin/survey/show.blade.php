@extends('admin.layouts.template')
@section('title', 'Detail Survey TAM - ' . $survey->respondent_name)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-file-lines"></i>
                <span>Detail Instrumen TAM #{{ $survey->id }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Evaluasi Responden: {{ $survey->respondent_name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Dicatat pada {{ $survey->created_at ? $survey->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.survey.index') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('admin.tam.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all">
                <i class="fa-solid fa-calculator"></i>
                <span>Model TAM</span>
            </a>
        </div>
    </div>

    <!-- Main Grid: Profile & Score Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Responden & Case Info -->
        <div class="space-y-6">
            <!-- Respondent Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white font-extrabold text-lg flex items-center justify-center shadow-sm shadow-indigo-500/30">
                        {{ strtoupper(substr($survey->respondent_name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">{{ $survey->respondent_name }}</h2>
                        <span class="text-xs text-slate-400">Responden Kuesioner</span>
                    </div>
                </div>

                <div class="pt-4 space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Alamat Email</span>
                        <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-envelope text-slate-400"></i>
                            {{ $survey->email ?? 'Tidak dicantumkan' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">ID Kasus Terkait</span>
                        @if($survey->pengaduan)
                            <a href="{{ route('admin.pengaduan.show', $survey->pengaduan->id_pengaduan) }}"
                               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-semibold transition-colors">
                                <i class="fa-solid fa-folder-open text-xs"></i>
                                <span>{{ $survey->pengaduan->kode_kasus ?? '#KASUS-'.$survey->id_pengaduan }}</span>
                            </a>
                        @elseif($survey->id_pengaduan)
                            <span class="font-semibold text-slate-700">#{{ $survey->id_pengaduan }}</span>
                        @else
                            <span class="text-slate-500 italic">Evaluasi Umum (Tanpa Kasus Khusus)</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5 font-medium">Waktu Pengisian</span>
                        <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-slate-400"></i>
                            {{ $survey->created_at ? $survey->created_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Global Score Summary Card -->
            <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-950 p-6 rounded-2xl text-white shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-300">Skor Gabungan TAM</span>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="text-4xl font-extrabold tracking-tight text-white">{{ number_format($meanScore, 2) }}</span>
                        <span class="text-sm text-indigo-200">/ 5.00</span>
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between">
                        <div>
                            <div class="text-[11px] text-indigo-200">Persentase Akseptansi</div>
                            <div class="text-lg font-extrabold text-emerald-400">{{ $acceptancePct }}%</div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $acceptancePct >= 80 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                            {{ $acceptancePct >= 80 ? 'Sangat Diterima' : ($acceptancePct >= 60 ? 'Diterima Baik' : 'Cukup') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: TAM Constructs Breakdown -->
        <div class="lg:col-span-2 space-y-4">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-indigo-600"></i>
                    <span>Rincian Konstruk Model TAM</span>
                </h3>

                <div class="space-y-5">
                    <!-- Perceived Usefulness (PU) -->
                    <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:border-blue-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">
                                    PU
                                </span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Perceived Usefulness (Kegunaan)</div>
                                    <div class="text-[11px] text-slate-400">Tingkat keyakinan bahwa sistem meningkatkan efektivitas penanganan kasus.</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-blue-700">{{ number_format($survey->perceived_usefulness, 2) }}</span>
                                <span class="text-[10px] text-slate-400 block">/ 5.0</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mt-3">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($survey->perceived_usefulness / 5) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Perceived Ease of Use (PEOU) -->
                    <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:border-emerald-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">
                                    PEOU
                                </span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Perceived Ease of Use (Kemudahan)</div>
                                    <div class="text-[11px] text-slate-400">Tingkat keyakinan bahwa sistem Lapora mudah dipahami dan bebas hambatan.</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-emerald-700">{{ number_format($survey->perceived_ease_of_use, 2) }}</span>
                                <span class="text-[10px] text-slate-400 block">/ 5.0</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mt-3">
                            <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ min(100, ($survey->perceived_ease_of_use / 5) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Behavioral Intention (BI) -->
                    <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:border-purple-300 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-bold">
                                    BI
                                </span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Behavioral Intention (Intensi Penggunaan)</div>
                                    <div class="text-[11px] text-slate-400">Kecenderungan dan komitmen untuk terus memanfaatkan sistem di masa depan.</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base font-extrabold text-purple-700">{{ number_format($survey->behavioral_intention_to_use, 2) }}</span>
                                <span class="text-[10px] text-slate-400 block">/ 5.0</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mt-3">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ min(100, ($survey->behavioral_intention_to_use / 5) * 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Delete Action -->
                <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400">Perlu menghapus data survey ini?</span>
                    <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data survey ini?')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 transition-colors">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Hapus Survey</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
