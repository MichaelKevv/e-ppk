@extends('admin.layouts.template')
@section('title', 'Beri Feedback & Konseling')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Back Button -->
    <div class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
           class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-all shrink-0">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-1">
                <i class="fa-solid fa-comment-medical"></i>
                <span>Tanggapan &amp; Layanan Pendampingan</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                Beri Feedback / Arahan Konseling
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Kirimkan arahan, tindak lanjut penanganan, atau catatan bimbingan untuk laporan pengaduan siswa ini.
            </p>
        </div>
    </div>

    <!-- Informasi Kasus Singkat -->
    <div class="bg-indigo-50/70 p-5 rounded-2xl border border-indigo-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
        <div>
            <span class="text-[10px] font-bold uppercase text-indigo-500 tracking-wider">Pengaduan yang Ditanggapi:</span>
            <h4 class="font-bold text-indigo-950 text-sm mt-0.5">{{ $judul_pengaduan }}</h4>
            <p class="text-slate-600 mt-0.5">
                Status saat ini: <span class="font-bold uppercase text-indigo-700">{{ $pengaduan->status_label ?? $pengaduan->status }}</span>
            </p>
        </div>
        <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-indigo-50 text-indigo-700 font-bold border border-indigo-200 shadow-2xs transition-all text-xs shrink-0">
            <i class="fa-solid fa-folder-open text-xs"></i>
            <span>Lihat Berkas Laporan</span>
        </a>
    </div>

    <!-- Form Feedback -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.feedback.store', $pengaduan->id_pengaduan) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Text Tanggapan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    Isi Feedback / Catatan Konseling <span class="text-rose-500">*</span>
                </label>
                <textarea name="teks_tanggapan" rows="6" required
                          placeholder="Tuliskan arahan konseling, respons resmi, atau langkah tindak lanjut yang perlu diambil oleh korban/sekolah..."
                          class="w-full text-xs rounded-xl border border-slate-200 p-4 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all leading-relaxed"></textarea>
                <p class="text-[11px] text-slate-400 mt-1.5">
                    Pesan ini akan tercatat dalam riwayat penanganan kasus dan dapat dibaca oleh siswa pelapor serta tim konselor.
                </p>
            </div>

            <!-- Perbarui Status Kasus (Opsional) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    Perbarui Status Alur Kasus (Opsional)
                </label>
                <select name="status" class="w-full text-xs rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden transition-all">
                    <option value="">-- Tetap Pertahankan Status Saat Ini ({{ ucfirst($pengaduan->status) }}) --</option>
                    <option value="konseling">Pindahkan ke Tahap Konseling</option>
                    <option value="mediasi">Pindahkan ke Tahap Mediasi</option>
                    <option value="investigasi">Pindahkan ke Tahap Investigasi Lanjutan</option>
                    <option value="selesai">Tandai Kasus Selesai (Teratasi)</option>
                </select>
                <p class="text-[11px] text-slate-400 mt-1.5">
                    Pilih status baru jika pengiriman feedback ini menandai perpindahan tahap penanganan kasus.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs shadow-indigo-600/30 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Tanggapan Konseling</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
