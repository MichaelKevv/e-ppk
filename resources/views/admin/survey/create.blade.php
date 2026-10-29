@extends('admin.layouts.template')
@section('title', 'Tambah Data Survey TAM')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Formulir Penginputan Manual TAM</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Tambah Data Survey TAM
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Catat hasil kuesioner evaluasi akseptasi sistem dari responden secara mandiri.
            </p>
        </div>

        <a href="{{ route('admin.survey.index') }}"
           class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.survey.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Profil Responden -->
            <div>
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-pen text-indigo-600"></i>
                    <span>Informasi Responden</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Responden -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nama Responden <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="respondent_name"
                               required
                               placeholder="Contoh: Budi Santoso, S.Pd"
                               class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Alamat Email (Opsional)
                        </label>
                        <input type="email"
                               name="email"
                               placeholder="Contoh: budi@sekolah.sch.id"
                               class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                    </div>

                    <!-- Hubungkan ke Kasus -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Terkait Kasus Pengaduan (Opsional)
                        </label>
                        <select name="id_pengaduan"
                                class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-white">
                            <option value="">-- Tidak Terikat Kasus Khusus (Evaluasi Umum) --</option>
                            @foreach($pengaduanList as $p)
                                <option value="{{ $p->id_pengaduan }}">
                                    {{ $p->kode_kasus ?? '#'.$p->id_pengaduan }} - Pelapor: {{ $p->nama_pelapor ?? 'Anonim' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Dimensi Model TAM -->
            <div>
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-chart-simple text-indigo-600"></i>
                    <span>Penilaian Dimensi Model TAM (Skala Likert 1 - 5)</span>
                </h2>

                <div class="space-y-4">
                    <!-- PU -->
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/70">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                            <div>
                                <label class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-extrabold">PU</span>
                                    <span>Perceived Usefulness (Persepsi Kegunaan)</span>
                                </label>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Sejauh mana sistem Lapora dinilai membantu dan meningkatkan produktivitas penanganan perundungan.
                                </p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <input type="number"
                                       name="perceived_usefulness"
                                       step="0.1"
                                       min="1"
                                       max="5"
                                       value="4.5"
                                       required
                                       class="w-20 px-2.5 py-1.5 text-center text-xs font-bold rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                <span class="text-xs text-slate-400">/ 5.0</span>
                            </div>
                        </div>
                    </div>

                    <!-- PEOU -->
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/70">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                            <div>
                                <label class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-extrabold">PEOU</span>
                                    <span>Perceived Ease of Use (Persepsi Kemudahan)</span>
                                </label>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Sejauh mana sistem dinilai mudah dipelajari, intuitif, dan tidak memerlukan upaya mental yang berat.
                                </p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <input type="number"
                                       name="perceived_ease_of_use"
                                       step="0.1"
                                       min="1"
                                       max="5"
                                       value="4.5"
                                       required
                                       class="w-20 px-2.5 py-1.5 text-center text-xs font-bold rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                <span class="text-xs text-slate-400">/ 5.0</span>
                            </div>
                        </div>
                    </div>

                    <!-- BI -->
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-200/70">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                            <div>
                                <label class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded bg-purple-100 text-purple-700 flex items-center justify-center text-[10px] font-extrabold">BI</span>
                                    <span>Behavioral Intention to Use (Intensi Penggunaan)</span>
                                </label>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Niat dan komitmen responden untuk terus menggunakan Lapora secara berkelanjutan di lingkungan sekolah.
                                </p>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <input type="number"
                                       name="behavioral_intention_to_use"
                                       step="0.1"
                                       min="1"
                                       max="5"
                                       value="4.5"
                                       required
                                       class="w-20 px-2.5 py-1.5 text-center text-xs font-bold rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600">
                                <span class="text-xs text-slate-400">/ 5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.survey.index') }}"
                   class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Simpan Data Survey
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
