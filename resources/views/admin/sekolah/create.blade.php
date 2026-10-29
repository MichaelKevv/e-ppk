@extends('admin.layouts.template')
@section('title', 'Tambah Sekolah Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.sekolah.index') }}" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Daftar Sekolah</span>
                </a>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Tambah Data Sekolah Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Daftarkan institusi/sekolah baru ke dalam jaringan pemantauan anti-bullying Lapora.</p>
        </div>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.sekolah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Data Pokok Sekolah -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-school text-blue-600"></i>
                    <span>Informasi Pokok Sekolah</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Sekolah <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required placeholder="Contoh: SMA Negeri 8 Jakarta"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NPSN (Nomor Pokok Sekolah Nasional)</label>
                        <input type="text" name="npsn" value="{{ old('npsn') }}" placeholder="8 digit angka NPSN"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Akreditasi <span class="text-rose-500">*</span></label>
                        <select name="akreditasi" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="A" {{ old('akreditasi') == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                            <option value="B" {{ old('akreditasi') == 'B' ? 'selected' : '' }}>B (Baik)</option>
                            <option value="C" {{ old('akreditasi') == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                            <option value="Belum" {{ old('akreditasi') == 'Belum' ? 'selected' : '' }}>Belum Terakreditasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                        <select name="jenjang" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD / MI</option>
                            <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                            <option value="SMA" {{ old('jenjang', 'SMA') == 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                            <option value="SMK" {{ old('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Lembaga <span class="text-rose-500">*</span></label>
                        <select name="status_sekolah" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                            <option value="Negeri" {{ old('status_sekolah') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                            <option value="Swasta" {{ old('status_sekolah') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Pimpinan & Kontak -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-blue-600"></i>
                    <span>Kepala Sekolah & Kontak</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah') }}" placeholder="Nama beserta gelar"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah') }}" placeholder="18 digit NIP"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. Telepon / Fax</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="(021) 1234567"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi Sekolah</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="sekolah@sch.id"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Website Lembaga</label>
                        <input type="url" name="website" value="{{ old('website') }}" placeholder="https://..."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>
                </div>
            </div>

            <!-- Section 3: Alamat Wilayah -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                    <span>Alamat & Lokasi Sekolah</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Jalan</label>
                        <textarea name="alamat" rows="2" placeholder="Nama jalan, nomor gedung, RT/RW"
                                  class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kelurahan / Desa</label>
                        <input type="text" name="kelurahan" value="{{ old('kelurahan') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="kota" value="{{ old('kota', 'Jakarta Selatan') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Provinsi</label>
                        <input type="text" name="provinsi" value="{{ old('provinsi', 'DKI Jakarta') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">
                    </div>
                </div>
            </div>

            <!-- Section 4: Deskripsi & Visi Anti-Bullying -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-blue-600"></i>
                    <span>Kebijakan & Komitmen Sekolah Ramah Anak</span>
                </h3>

                <div class="mt-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi / Komitmen Anti Perundungan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Tuliskan komitmen perlindungan dan pencegahan kekerasan sekolah..."
                              class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden text-xs">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.sekolah.index') }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/25 transition-all hover:scale-105 active:scale-95">
                    Simpan Sekolah Baru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
