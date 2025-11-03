@extends('admin.layouts.template')
@section('title', 'Edit Pengaduan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.pengaduan.index') }}">Data Pengaduan</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pengaduan</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Data Pengaduan</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <form action="{{ route('admin.pengaduan.update', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <!-- Bentuk Perundungan -->
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="bentuk_perundungan" class="ms-0">Bentuk Perundungan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bentuk_perundungan" id="bentuk_perundungan" required>
                                        <option value="" disabled>Pilih Bentuk Perundungan</option>
                                        <option value="verbal" {{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) == 'verbal' ? 'selected' : '' }}>Verbal</option>
                                        <option value="fisik" {{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) == 'fisik' ? 'selected' : '' }}>Fisik</option>
                                        <option value="sosial" {{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                        <option value="siber" {{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) == 'siber' ? 'selected' : '' }}>Siber</option>
                                        <option value="seksual" {{ old('bentuk_perundungan', $pengaduan->bentuk_perundungan) == 'seksual' ? 'selected' : '' }}>Seksual</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nama Pelapor (tampil hanya jika bentuk seksual) -->
                            <div class="col-md-6" id="nama-pelapor-container" style="display: none;">
                                <div class="input-group input-group-static mb-4">
                                    <label for="nama_pelapor" class="ms-0">Nama Pelapor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor"
                                        value="{{ old('nama_pelapor', $pengaduan->nama_pelapor) }}">
                                    <div class="form-text">Hanya diisi untuk kasus perundungan seksual</div>
                                </div>
                            </div>

                            <!-- Frekuensi Kejadian -->
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="frekuensi_kejadian" class="ms-0">Frekuensi Kejadian <span class="text-danger">*</span></label>
                                    <select class="form-control" name="frekuensi_kejadian" id="frekuensi_kejadian" required>
                                        <option value="" disabled>Pilih Frekuensi</option>
                                        <option value="sekali" {{ old('frekuensi_kejadian', $pengaduan->frekuensi_kejadian) == 'sekali' ? 'selected' : '' }}>Sekali</option>
                                        <option value="2-3_kali" {{ old('frekuensi_kejadian', $pengaduan->frekuensi_kejadian) == '2-3_kali' ? 'selected' : '' }}>2-3 Kali</option>
                                        <option value="sering" {{ old('frekuensi_kejadian', $pengaduan->frekuensi_kejadian) == 'sering' ? 'selected' : '' }}>Sering</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="lokasi" class="ms-0">Lokasi Kejadian</label>
                                    <input type="text" class="form-control" id="lokasi"
                                        name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                        placeholder="Contoh: Ruang kelas, Lapangan, Kantin, dll.">
                                </div>
                            </div>

                            <!-- Checkbox Group -->
                            <div class="col-12">
                                <div class="row">
                                    @php
                                        $checkboxes = [
                                            'trauma_mental' => 'Trauma Mental',
                                            'luka_fisik' => 'Luka Fisik',
                                            'pelaku_lebih_dari_satu' => 'Pelaku Lebih dari Satu',
                                            'konten_digital' => 'Konten Digital',
                                        ];
                                    @endphp
                                    @foreach ($checkboxes as $field => $label)
                                        <div class="col-md-3 col-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                                                    {{ old($field, $pengaduan->$field) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Jenis Kata -->
                            <div class="col-12">
                                <div class="input-group input-group-static mb-4">
                                    <label for="jenis_kata" class="ms-0">Jenis Kata/Kalimat yang Digunakan</label>
                                    <input type="text" class="form-control" id="jenis_kata"
                                        name="jenis_kata" value="{{ old('jenis_kata', $pengaduan->jenis_kata) }}"
                                        placeholder="Contoh: Kata-kata kasar, ancaman, dll.">
                                </div>
                            </div>

                            <!-- Klasifikasi -->
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="klasifikasi" class="ms-0">Klasifikasi <span class="text-danger">*</span></label>
                                    <select class="form-control" name="klasifikasi" id="klasifikasi" required>
                                        <option value="" disabled>Pilih Klasifikasi</option>
                                        <option value="ringan" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                        <option value="sedang" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="berat" {{ old('klasifikasi', $pengaduan->klasifikasi) == 'berat' ? 'selected' : '' }}>Berat</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Foto Bukti -->
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="foto" class="ms-0">Foto Bukti <small class="text-muted">(maks. 2 MB, opsional)</small></label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                </div>
                                @if ($pengaduan->foto)
                                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-thumbnail mt-2"
                                        style="max-height: 200px; max-width: 300px;" alt="Foto Bukti Lama">
                                @endif
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12">
                                <div class="input-group input-group-static mb-4">
                                    <label for="deskripsi" class="ms-0">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// === tampilkan nama pelapor jika bentuk seksual ===
document.addEventListener('DOMContentLoaded', function() {
    const bentukSelect = document.getElementById('bentuk_perundungan');
    const pelaporContainer = document.getElementById('nama-pelapor-container');
    const pelaporInput = document.getElementById('nama_pelapor');

    function toggleNamaPelapor() {
        const selectedValue = bentukSelect.value;
        if (selectedValue === 'seksual') {
            pelaporContainer.style.display = 'block';
            pelaporInput.setAttribute('required', true);
        } else {
            pelaporContainer.style.display = 'none';
            pelaporInput.removeAttribute('required');
            pelaporInput.value = '';
        }
    }

    toggleNamaPelapor(); 
    bentukSelect.addEventListener('change', toggleNamaPelapor);
});
</script>
@endpush
