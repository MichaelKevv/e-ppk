@extends('admin.layouts.template')
@section('title', 'Buat Laporan Pengaduan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pengaduan.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Pengaduan</span>
        </a>
        <span class="text-xs text-slate-400">Formulir Pengaduan Terlindungi</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xs">
        <div class="border-b border-slate-100 pb-5 mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Privasi Terlindungi Lapora</span>
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Formulir Laporan Pengaduan Kasus</h1>
            <p class="text-xs text-slate-500 mt-1">
                Ceritakan insiden perundungan yang Anda alami atau saksikan secara jujur dan rinci. Informasi ini akan langsung ditindaklanjuti oleh Guru BK dan Dinas Sosial.
            </p>
        </div>

        <form action="{{ route('admin.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="pengaduanForm()">
            @csrf

            <!-- Section 1: Informasi Terlibat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if(isset($sekolahList) && $sekolahList->count() > 0)
                <div class="sm:col-span-2">
                    <label for="id_sekolah" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Institusi / Sekolah Tempat Kejadian <span class="text-rose-500">*</span>
                    </label>
                    <select name="id_sekolah" id="id_sekolah" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        @foreach($sekolahList as $s)
                            <option value="{{ $s->id }}" {{ old('id_sekolah') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_sekolah }} ({{ $s->jenjang }} - {{ $s->status_sekolah }}) &bull; {{ $s->kota ?? 'DKI Jakarta' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <!-- Nama Pelapor -->
                <div>
                    <label for="nama_pelapor" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nama Pelapor / Korban <span class="text-slate-400 font-normal">(Kosongkan jika ingin Anonim)</span>
                    </label>
                    <input type="text" name="nama_pelapor" id="nama_pelapor" value="{{ old('nama_pelapor') }}"
                           placeholder="Boleh dikosongkan untuk anonimitas"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>

                <!-- Nama Pelaku -->
                <div>
                    <label for="nama_pelaku" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nama Terduga Pelaku <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_pelaku" id="nama_pelaku" required value="{{ old('nama_pelaku') }}"
                           placeholder="Nama siswa/pihak yang melakukan perundungan"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Section 2: Bentuk & Frekuensi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Bentuk Perundungan -->
                <div>
                    <label for="bentuk_perundungan" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Bentuk Perundungan <span class="text-rose-500">*</span>
                    </label>
                    <select name="bentuk_perundungan" id="bentuk_perundungan" required x-model="bentuk"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="verbal">Verbal (Makian, ejekan, hinaan nama, julukan buruk)</option>
                        <option value="fisik">Fisik (Pemukulan, dorongan, penendangan, perusakan barang)</option>
                        <option value="sosial">Sosial (Pengucilan, fitnah kelompok, boikot teman)</option>
                        <option value="siber">Siber (Media sosial, WhatsApp, teror pesan digital)</option>
                        <option value="seksual">Seksual (Pelecehan fisik, verbal, atau visual)</option>
                    </select>
                </div>

                <!-- Frekuensi Kejadian -->
                <div>
                    <label for="frekuensi_kejadian" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Frekuensi Kejadian <span class="text-rose-500">*</span>
                    </label>
                    <select name="frekuensi_kejadian" id="frekuensi_kejadian" required x-model="frekuensi"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="sekali">Sekali (Kejadian pertama kali)</option>
                        <option value="2-3_kali">2 - 3 Kali (Pernah terjadi beberapa kali)</option>
                        <option value="sering">Sering (Berulang intensif / hampir setiap hari)</option>
                    </select>
                </div>
            </div>

            <!-- Section 3: Indikator Kondisi & Dampak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Trauma Mental -->
                <div>
                    <label for="trauma_mental" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Apakah Mengalami Trauma / Ketakutan Mental? <span class="text-rose-500">*</span>
                    </label>
                    <select name="trauma_mental" id="trauma_mental" required x-model="trauma"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="0">Tidak (Masih bisa beraktivitas seperti biasa)</option>
                        <option value="1">Ya (Merasa takut ke sekolah, menangis, depresi, cemas)</option>
                    </select>
                </div>

                <!-- Luka Fisik -->
                <div>
                    <label for="luka_fisik" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Apakah Ada Luka Fisik / Cidera Tubuh? <span class="text-rose-500">*</span>
                    </label>
                    <select name="luka_fisik" id="luka_fisik" required x-model="luka"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="0">Tidak Ada Luka Fisik</option>
                        <option value="1">Ya, Terdapat Luka / Memar / Cedera Tubuh</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Pelaku Lebih dari Satu -->
                <div>
                    <label for="pelaku_lebih_dari_satu" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Jumlah Pelaku
                    </label>
                    <select name="pelaku_lebih_dari_satu" id="pelaku_lebih_dari_satu" x-model="pelakuGanda"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="0">Pelaku Tunggal (1 orang)</option>
                        <option value="1">Pelaku Lebih dari Satu (Kelompok / Geng)</option>
                    </select>
                </div>

                <!-- Konten Digital -->
                <div>
                    <label for="konten_digital" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Adanya Bukti Konten Siber / Rekaman Digital
                    </label>
                    <select name="konten_digital" id="konten_digital" x-model="kontenDigital"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                        <option value="0">Tidak Ada Konten Digital</option>
                        <option value="1">Ya, Terdapat Screenshot / Video / Pesan Medsos</option>
                    </select>
                </div>
            </div>

            <!-- Section 4: Lokasi & Ujaran Kata -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Lokasi Tempat Kejadian
                    </label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Contoh: Belakang kantin, kelas 10A, toilet, media sosial"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>

                <div>
                    <label for="jenis_kata" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Kata-kata / Ujaran yang Diucapkan (Jika Ada)
                    </label>
                    <input type="text" name="jenis_kata" id="jenis_kata" value="{{ old('jenis_kata') }}"
                           placeholder="Contoh kata makian / ejekan yang dilontarkan"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Section 5: Deskripsi Kronologi -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Kronologi Kejadian Lengkap <span class="text-rose-500">*</span>
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required
                          placeholder="Jelaskan secara kronologis apa yang terjadi, kapan waktu kejadian, dan bagaimana insiden tersebut berlangsung..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden bg-slate-50 focus:bg-white transition-all">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Section 6: Bukti Foto -->
            <div>
                <label for="foto" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Unggah Bukti Foto / Tangkapan Layar (Opsional)
                </label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1 bg-slate-50">
                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
            </div>

            <!-- Smart Classification Assist Card: ID3 Decision Tree + Weighted Scoring Cross-Check -->
            <div class="p-5 rounded-3xl border border-blue-200 bg-linear-to-br from-blue-50/80 via-white to-indigo-50/50 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-blue-500/20">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] uppercase font-black tracking-wider text-blue-700">Klasifikasi Pohon Keputusan ID3</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                    <span>Model Aktif</span>
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Diklasifikasikan otomatis melalui simpul-simpul inferensi Pohon Keputusan ID3 yang telah dilatih.
                            </p>
                        </div>
                    </div>

                    <!-- Output Klasifikasi Badge -->
                    <div class="flex items-center gap-2 self-start sm:self-auto bg-white/80 p-1.5 rounded-2xl border border-slate-200/80 shadow-2xs">
                        <span class="text-xs text-slate-500 pl-2 font-medium">Prediksi:</span>
                        <span class="px-3.5 py-1.5 rounded-xl font-black uppercase text-xs tracking-wider shadow-xs"
                              :class="{
                                  'bg-emerald-500 text-white shadow-emerald-500/20': klasifikasiOtomatis === 'ringan',
                                  'bg-amber-500 text-white shadow-amber-500/20': klasifikasiOtomatis === 'sedang',
                                  'bg-rose-500 text-white shadow-rose-500/20': klasifikasiOtomatis === 'berat'
                              }"
                              x-text="klasifikasiOtomatis">
                        </span>
                        <span class="text-[11px] font-bold px-2 py-1 rounded-lg bg-slate-100 text-slate-600"
                              title="Tingkat keyakinan berdasarkan proporsi sampel daun">
                            <span x-text="result.confidence"></span>%
                        </span>
                    </div>
                </div>

                <!-- Jalur Penelusuran Pohon ID3 (Decision Path) -->
                <div class="pt-3 border-t border-blue-100/70">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-route text-blue-600 text-xs"></i>
                        <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wide">Jalur Simpul Keputusan (Decision Path):</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-1.5">
                        <template x-for="(step, idx) in result.path" :key="idx">
                            <div class="inline-flex items-center gap-1.5">
                                <span class="px-2.5 py-1 rounded-xl bg-white border border-blue-200/90 text-xs font-semibold text-slate-700 shadow-2xs flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    <span x-text="step"></span>
                                </span>
                                <i x-show="idx < result.path.length - 1" class="fa-solid fa-arrow-right text-[10px] text-blue-400"></i>
                            </div>
                        </template>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-black uppercase"
                              :class="{
                                  'bg-emerald-100 text-emerald-800 border border-emerald-200': klasifikasiOtomatis === 'ringan',
                                  'bg-amber-100 text-amber-800 border border-amber-200': klasifikasiOtomatis === 'sedang',
                                  'bg-rose-100 text-rose-800 border border-rose-200': klasifikasiOtomatis === 'berat'
                              }">
                            <i class="fa-solid fa-flag-checkered text-[10px]"></i>
                            <span x-text="'Hasil = ' + klasifikasiOtomatis"></span>
                        </span>
                    </div>
                </div>

                <!-- Footer Cross-Check: Formula Skor Terbobot Klien (Ground Truth Acuan) -->
                <div class="pt-3 border-t border-blue-100/70 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11px] text-slate-500">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-600">Cross-Check Formula Klien:</span>
                        <span class="font-mono text-slate-600 bg-white px-2 py-0.5 rounded-md border border-slate-200">
                            S = 0.20X₁ + 0.15X₂ + 0.20X₃ + 0.20X₄ + 0.10X₅ + 0.15X₆ = <strong class="text-blue-600" x-text="weightedScore"></strong>
                        </span>
                        <span class="px-2 py-0.5 rounded-md font-bold"
                              :class="{
                                  'bg-emerald-50 text-emerald-700 border border-emerald-200': weightedLabel === 'Ringan',
                                  'bg-amber-50 text-amber-700 border border-amber-200': weightedLabel === 'Sedang',
                                  'bg-rose-50 text-rose-700 border border-rose-200': weightedLabel === 'Berat'
                              }"
                              x-text="'Kategori: ' + weightedLabel">
                        </span>
                    </div>
                    <span class="text-[10px] text-slate-400">
                        *Model ID3 dibangun melalui Entropy & Gain pada dataset berlabel ini.
                    </span>
                </div>

                <!-- Hidden Input bound to genuine ID3 model prediction -->
                <input type="hidden" name="klasifikasi" :value="klasifikasiOtomatis">
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pengaduan.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pengaduan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function pengaduanForm() {
    return {
        bentuk: @json(old('bentuk_perundungan', 'verbal')),
        frekuensi: @json(old('frekuensi_kejadian', 'sekali')),
        trauma: @json(old('trauma_mental', '0')),
        luka: @json(old('luka_fisik', '0')),
        pelakuGanda: @json(old('pelaku_lebih_dari_satu', '0')),
        kontenDigital: @json(old('konten_digital', '0')),
        tree: @json($tree ?? null),

        evaluateTree(node, sample, path = []) {
            if (!node) {
                return {
                    klasifikasi: 'sedang',
                    confidence: 60,
                    path: ['Model pohon keputusan belum dimuat (default: Sedang)']
                };
            }

            if (node.type === 'leaf') {
                return {
                    klasifikasi: node.label,
                    confidence: node.confidence || 100,
                    distribution: node.distribution || {},
                    path: path
                };
            }

            const attr = node.attribute;
            let val = sample[attr] !== undefined ? String(sample[attr]) : '';
            const attrLabel = node.attribute_label || attr;
            const valDisplay = val === '1' ? 'Ya' : (val === '0' ? 'Tidak' : (val.charAt(0).toUpperCase() + val.slice(1)));

            const currentPath = [...path, `${attrLabel} = ${valDisplay}`];

            if (node.branches && node.branches[val]) {
                return this.evaluateTree(node.branches[val], sample, currentPath);
            }

            return {
                klasifikasi: node.majority_class || 'sedang',
                confidence: 60,
                distribution: node.distribution || {},
                path: [...currentPath, `(Cabang lain, fallback: ${node.majority_class || 'sedang'})`]
            };
        },

        get result() {
            const sample = {
                bentuk_perundungan: this.bentuk,
                frekuensi_kejadian: this.frekuensi,
                trauma_mental: this.trauma,
                luka_fisik: this.luka,
                pelaku_lebih_dari_satu: this.pelakuGanda,
                konten_digital: this.kontenDigital
            };
            return this.evaluateTree(this.tree, sample);
        },

        get klasifikasiOtomatis() {
            return this.result.klasifikasi || 'sedang';
        },

        get weightedScore() {
            const x1Scores = { 'verbal': 20, 'sosial': 40, 'siber': 60, 'fisik': 80, 'seksual': 100 };
            const x2Scores = { 'sekali': 33.3, '2-3_kali': 66.6, 'sering': 100 };
            
            const x1 = x1Scores[this.bentuk] || 20;
            const x2 = x2Scores[this.frekuensi] || 33.3;
            const x3 = this.trauma === '1' ? 100 : 0;
            const x4 = this.luka === '1' ? 100 : 0;
            const x5 = this.pelakuGanda === '1' ? 100 : 0;
            const x6 = this.kontenDigital === '1' ? 100 : 0;

            const score = (0.20 * x1) + (0.15 * x2) + (0.20 * x3) + (0.20 * x4) + (0.10 * x5) + (0.15 * x6);
            return Math.round(score * 10) / 10;
        },

        get weightedLabel() {
            if (this.weightedScore < 34) return 'Ringan';
            if (this.weightedScore < 67) return 'Sedang';
            return 'Berat';
        }
    };
}
</script>
@endpush
