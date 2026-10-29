@extends('admin.layouts.template')
@section('title', 'Data Survey TAM')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-square-poll-vertical"></i>
                <span>Metode Evaluasi Akseptasi Sistem (Davis, 1989)</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Data Survey TAM (Technology Acceptance Model)
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kompilasi kuesioner evaluasi kegunaan, kemudahan operasional, dan intensi penggunaan sistem Lapora.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.tam.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                <i class="fa-solid fa-calculator"></i>
                <span>Kalkulasi Model TAM</span>
            </a>

            <a href="{{ route('admin.survey.create') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Survey</span>
            </a>
        </div>
    </div>

    <!-- Stat Metric Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3.5 sm:gap-4">
        <!-- Total Responden -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Responden</span>
                <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-extrabold text-slate-800">{{ $totalSurvey }}</div>
                <div class="text-[11px] text-slate-400 mt-0.5">Total data kuesioner</div>
            </div>
        </div>

        <!-- Perceived Usefulness (PU) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">PU (Kegunaan)</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-lightbulb"></i>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-blue-700">{{ number_format($avgPU, 2) }}</span>
                    <span class="text-xs text-slate-400">/ 5.0</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($avgPU / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Perceived Ease of Use (PEOU) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">PEOU (Kemudahan)</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-hand-pointer"></i>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-emerald-700">{{ number_format($avgPEOU, 2) }}</span>
                    <span class="text-xs text-slate-400">/ 5.0</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ min(100, ($avgPEOU / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Behavioral Intention (BI) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">BI (Intensi)</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-repeat"></i>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-purple-700">{{ number_format($avgBI, 2) }}</span>
                    <span class="text-xs text-slate-400">/ 5.0</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ min(100, ($avgBI / 5) * 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Tingkat Penerimaan Global -->
        <div class="col-span-2 md:col-span-1 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Penerimaan</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-chart-pie"></i>
                </span>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-extrabold text-slate-800">{{ $acceptanceRate }}%</span>
                </div>
                <div class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>{{ $acceptanceRate >= 80 ? 'Sangat Diterima' : ($acceptanceRate >= 60 ? 'Diterima Baik' : 'Cukup') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success Notification if any -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Table Search & Header Bar -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-2">
                <h2 class="text-sm sm:text-base font-bold text-slate-800">Daftar Responden Survey</h2>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                    {{ $surveys->total() }} data
                </span>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.survey.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau email..."
                           class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>
                @if(request('search'))
                <a href="{{ route('admin.survey.index') }}"
                   title="Reset Pencarian"
                   class="px-2.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                @endif
                <button type="submit"
                        class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Responden</th>
                        <th class="py-3.5 px-4">Terkait Kasus</th>
                        <th class="py-3.5 px-4 text-center">PU (Kegunaan)</th>
                        <th class="py-3.5 px-4 text-center">PEOU (Kemudahan)</th>
                        <th class="py-3.5 px-4 text-center">BI (Intensi)</th>
                        <th class="py-3.5 px-4 text-center">Rata-rata TAM</th>
                        <th class="py-3.5 px-4">Tanggal Input</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($surveys as $survey)
                    @php
                        $meanRow = round(($survey->perceived_usefulness + $survey->perceived_ease_of_use + $survey->behavioral_intention_to_use) / 3, 2);
                        $badgeClass = match(true) {
                            $meanRow >= 4.0 => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            $meanRow >= 3.0 => 'bg-blue-50 text-blue-700 border-blue-200',
                            default => 'bg-amber-50 text-amber-700 border-amber-200',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- Responden -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($survey->respondent_name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-800 truncate">{{ $survey->respondent_name }}</div>
                                    <div class="text-[11px] text-slate-400 truncate">{{ $survey->email ?? 'Tanpa email' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Terkait Kasus -->
                        <td class="py-3.5 px-4">
                            @if($survey->pengaduan)
                            <a href="{{ route('admin.pengaduan.show', $survey->pengaduan->id_pengaduan) }}"
                               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-[11px] font-semibold transition-colors">
                                <i class="fa-solid fa-folder-open text-[10px]"></i>
                                <span>{{ $survey->pengaduan->kode_kasus ?? '#KASUS-'.$survey->id_pengaduan }}</span>
                            </a>
                            @elseif($survey->id_pengaduan)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[11px]">
                                #{{ $survey->id_pengaduan }}
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-50 text-slate-400 text-[11px] border border-slate-200/60">
                                Evaluasi Umum
                            </span>
                            @endif
                        </td>

                        <!-- Perceived Usefulness -->
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ number_format($survey->perceived_usefulness, 2) }}
                            </span>
                        </td>

                        <!-- Perceived Ease of Use -->
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ number_format($survey->perceived_ease_of_use, 2) }}
                            </span>
                        </td>

                        <!-- Behavioral Intention -->
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                {{ number_format($survey->behavioral_intention_to_use, 2) }}
                            </span>
                        </td>

                        <!-- Mean Skor TAM -->
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-extrabold border {{ $badgeClass }}">
                                <i class="fa-solid fa-star text-[10px]"></i>
                                <span>{{ number_format($meanRow, 2) }}</span>
                            </span>
                        </td>

                        <!-- Tanggal Input -->
                        <td class="py-3.5 px-4 whitespace-nowrap text-[11px] text-slate-500">
                            {{ $survey->created_at ? $survey->created_at->translatedFormat('d M Y, H:i') : '-' }}
                        </td>

                        <!-- Aksi -->
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.survey.show', $survey->id) }}"
                                   title="Lihat Detail Survey"
                                   class="p-2 rounded-lg bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 transition-colors">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>

                                <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete(this)"
                                            title="Hapus Survey"
                                            class="p-2 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mb-3">
                                    <i class="fa-solid fa-inbox"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum Ada Data Survey TAM</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm">
                                    Data survey akan terisi otomatis ketika responden mengisi form TAM atau dapat ditambahkan secara manual.
                                </p>
                                <a href="{{ route('admin.survey.create') }}" class="mt-4 px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition-colors">
                                    <i class="fa-solid fa-plus mr-1"></i> Tambah Survey Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        @if ($surveys->hasPages())
        <div class="p-4 sm:p-5 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Menampilkan <span class="font-semibold text-slate-700">{{ $surveys->firstItem() ?? 0 }}</span> - <span class="font-semibold text-slate-700">{{ $surveys->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-700">{{ $surveys->total() }}</span> survey
            </div>
            <div>
                {{ $surveys->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(button) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Survey?',
                text: 'Data responden dan skor penilaian TAM ini akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                    cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        } else {
            if (confirm('Yakin ingin menghapus data survey TAM ini?')) {
                button.closest('form').submit();
            }
        }
    }
</script>
@endpush
