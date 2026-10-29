@extends('admin.layouts.template')
@section('title', 'Edit Data Pengaduan Kasus')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    bentuk: '{{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) }}',
    frekuensi: '{{ old('frekuensi_kejadian', $pengaduan->frekuensi_kejadian) }}',
    trauma: '{{ old('trauma_mental', $pengaduan->trauma_mental) ? '1' : '0' }}',
    luka: '{{ old('luka_fisik', $pengaduan->luka_fisik) ? '1' : '0' }}',
    pelakuGanda: '{{ old('pelaku_lebih_dari_satu', $pengaduan->pelaku_lebih_dari_satu) ? '1' : '0' }}',
    kontenDigital: '{{ old('konten_digital', $pengaduan->konten_digital) ? '1' : '0' }}',
    previewUrl: '{{ !empty($pengaduan->foto) ? asset('storage/' . $pengaduan->foto) : '' }}',
    fileChosen(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">

    <!-- Top Action Card -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Detail Kasus</span>
                </a>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-mono font-bold text-slate-500">{{ $pengaduan->kode_kasus ?? ('#' . $pengaduan->id_pengaduan) }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Edit Berkas Pengaduan Kasus</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui rincian investigasi kasus perundungan dan indikator dampak.</p>
        </div>
    </div>

    <!-- Error Alert if any -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terdapat kesalahan input:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Karakteristik Insiden -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">1</span>
                    <span>Bentuk & Karakteristik Insiden</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Bentuk Perundungan <span class="text-rose-500">*</span></label>
                        <select name="bentuk_perundungan" x-model="bentuk" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="verbal">Verbal (Kata kasar, hinaan, olokan)</option>
                            <option value="fisik">Fisik (Pemukulan, dorongan, luka fisik)</option>
                            <option value="sosial">Sosial (Pengucilan, fitnah, penyebaran rumor)</option>
                            <option value="siber">Siber (Pelecehan online, doxxing, medsos)</option>
                            <option value="seksual">Seksual (Pelecehan seksual)</option>
                        </select>
                    </div>

                    <!-- Pelapor Khusus Pelecehan Seksual -->
                    <div x-show="bentuk === 'seksual'" x-transition>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Pelapor / Kerabat <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor', $pengaduan->nama_pelapor) }}"
                               :required="bentuk === 'seksual'" placeholder="Nama orang tua, wali, atau saksi"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Frekuensi Kejadian <span class="text-rose-500">*</span></label>
                        <select name="frekuensi_kejadian" x-model="frekuensi" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="sekali">Sekali (Insiden Pertama)</option>
                            <option value="2-3_kali">2-3 Kali (Berulang Jarang)</option>
                            <option value="sering">Sering (Berulang Intensif)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Lokasi Tempat Kejadian</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}" placeholder="Contoh: Toilet lantai 2, Kantin, Lapangan..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata/Kalimat yang Digunakan (Jika Ada)</label>
                        <input type="text" name="jenis_kata" value="{{ old('jenis_kata', $pengaduan->jenis_kata) }}" placeholder="Contoh: Kata kasar, makian, ancaman..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>
                </div>
            </div>

            <!-- Section 2: Indikator & Dampak Kejadian -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs">2</span>
                    <span>Indikator Dampak & Keterlibatan Pelaku</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                    <!-- Luka Fisik -->
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100/70 cursor-pointer transition-all">
                        <input type="checkbox" name="luka_fisik" value="1"
                               {{ old('luka_fisik', $pengaduan->luka_fisik) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Mengakibatkan Luka Fisik</span>
                            <span class="text-[11px] text-slate-400">Memar, luka berdarah, cidera tubuh</span>
                        </div>
                    </label>

                    <!-- Trauma Mental -->
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100/70 cursor-pointer transition-all">
                        <input type="checkbox" name="trauma_mental" value="1"
                               {{ old('trauma_mental', $pengaduan->trauma_mental) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Indikasi Trauma Mental</span>
                            <span class="text-[11px] text-slate-400">Menangis histeris, takut ke sekolah, murung</span>
                        </div>
                    </label>

                    <!-- Pelaku Ganda -->
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100/70 cursor-pointer transition-all">
                        <input type="checkbox" name="pelaku_lebih_dari_satu" value="1"
                               {{ old('pelaku_lebih_dari_satu', $pengaduan->pelaku_lebih_dari_satu) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Pelaku Lebih dari Satu Orang</span>
                            <span class="text-[11px] text-slate-400">Pengeroyokan atau aksi kelompok/geng</span>
                        </div>
                    </label>

                    <!-- Konten Digital -->
                    <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100/70 cursor-pointer transition-all">
                        <input type="checkbox" name="konten_digital" value="1"
                               {{ old('konten_digital', $pengaduan->konten_digital) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Penyebaran Konten Digital</span>
                            <span class="text-[11px] text-slate-400">Viral di medsos, grup chat, rekaman video</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Section 3: Klasifikasi & Deskripsi Kronologi -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">3</span>
                    <span>Tingkat Klasifikasi & Kronologi Kasus</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Klasifikasi Kasus <span class="text-rose-500">*</span></label>
                        <select name="klasifikasi" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-bold">
                            <option value="ringan" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'ringan' ? 'selected' : '' }}>Tingkat Ringan (Bimbingan Konseling Sekolah)</option>
                            <option value="sedang" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'sedang' ? 'selected' : '' }}>Tingkat Sedang (Konseling & Pemanggilan Orang Tua)</option>
                            <option value="berat" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'berat' ? 'selected' : '' }}>Tingkat Berat (Intervensi Dinsos / Hukum)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Identitas Pelaku (Jika Diketahui)</label>
                        <input type="text" name="nama_pelaku" value="{{ old('nama_pelaku', $pengaduan->nama_pelaku) }}" placeholder="Nama siswa/pihak pelaku..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap Kronologi Insiden</label>
                        <textarea name="deskripsi" rows="4" placeholder="Ceritakan urutan peristiwa secara detail..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Bukti Foto / Lampiran -->
            <div>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">4</span>
                    <span>Lampiran & Bukti Foto</span>
                </h3>

                <div class="flex items-center gap-6 mt-5">
                    <div class="w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Bukti Foto" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <i class="fa-solid fa-image text-2xl"></i>
                        </template>
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Bukti Baru (Opsional)</label>
                        <input type="file" name="foto" @change="fileChosen" accept="image/*"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Berkas</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
