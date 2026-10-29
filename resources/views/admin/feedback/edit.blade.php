@extends('admin.layouts.template')
@section('title', 'Edit Tanggapan Konseling')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Back Button -->
    <div class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
           class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-all shrink-0">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-1">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Koreksi Catatan Konseling</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Edit Tanggapan / Feedback
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Perbarui isi pesan atau arahan konseling yang telah dikirimkan sebelumnya.
            </p>
        </div>
    </div>

    <!-- Informasi Kasus Singkat -->
    @if ($feedback->pengaduan)
        <div class="bg-indigo-50/70 p-5 rounded-2xl border border-indigo-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
            <div>
                <span class="text-[10px] font-bold uppercase text-indigo-500 tracking-wider">Kasus Terkait:</span>
                <h4 class="font-bold text-indigo-950 text-sm mt-0.5">
                    {{ ucfirst($feedback->pengaduan->bentuk_perundungan ?? 'Kasus') }} di {{ $feedback->pengaduan->lokasi ?? '-' }}
                </h4>
                <p class="text-slate-600 mt-0.5">
                    Waktu kirim awal: <span class="font-mono text-slate-700">{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB</span>
                </p>
            </div>
            <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-indigo-50 text-indigo-700 font-bold border border-indigo-200 shadow-2xs transition-all text-xs shrink-0">
                <i class="fa-solid fa-comments text-xs"></i>
                <span>Lihat Riwayat Thread</span>
            </a>
        </div>
    @endif

    <!-- Form Edit Feedback -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.feedback.update', $feedback->id_feedback) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Text Tanggapan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    Isi Tanggapan / Catatan Konseling <span class="text-rose-500">*</span>
                </label>
                <textarea name="isi_tanggapan" rows="7" required
                          placeholder="Perbarui catatan bimbingan atau arahan konseling..."
                          class="w-full text-xs rounded-xl border border-slate-200 p-4 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all leading-relaxed">{{ old('isi_tanggapan', $feedback->isi_tanggapan) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1.5">
                    Pastikan informasi yang diperbarui jelas, mendidik, dan mendukung pemulihan psikologis siswa.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
