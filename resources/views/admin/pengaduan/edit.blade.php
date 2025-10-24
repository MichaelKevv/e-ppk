@extends('admin.layouts.template')
@section('title', 'Edit Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                    href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.pengaduan.index') }}">Data
                    Pengaduan</a></li>
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

                                @if (Auth::user()->role !== 'siswa')
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="id_pengguna" class="ms-0">Siswa</label>
                                            <select name="id_pengguna" id="id_pengguna" class="form-control">
                                                <option value="">Pilih Siswa</option>
                                                @foreach ($siswa as $s)
                                                    <option value="{{ $s->id_pengguna }}" {{ old('id_pengguna', $pengaduan->id_pengguna) == $s->id_pengguna ? 'selected' : '' }}>
                                                        {{ $s->nama }} | {{ $s->kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <!-- Lokasi -->
                                <div class="{{ Auth::user()->role !== 'siswa' ? 'col-6' : 'col-12' }}">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="lokasi" class="ms-0">Lokasi Kejadian</label>
                                        <input type="text" class="form-control" id="lokasi"
                                            placeholder="Contoh: Ruang kelas, Lapangan, Kantin, dll."
                                            name="lokasi"
                                            value="{{ old('lokasi', $pengaduan->lokasi) }}">
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
                                                    <input class="form-check-input" type="checkbox" name="{{ $field }}"
                                                        id="{{ $field }}" value="1"
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
                                            placeholder="Contoh: Kata-kata kasar, ancaman, dll."
                                            name="jenis_kata"
                                            value="{{ old('jenis_kata', $pengaduan->jenis_kata) }}">
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

                                    <div id="image-preview" class="mt-2">
                                        @if ($pengaduan->foto)
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Preview Foto Lama:</strong> Gambar tersimpan saat ini.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-thumbnail mt-2"
                                                style="max-height: 200px; max-width: 300px;" alt="Preview Foto Lama">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="deskripsi" class="ms-0">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> Simpan Perubahan
                                        </button>
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

@push('styles')
    <style>
        .input-group.input-group-static label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #344767;
        }

        .form-control:focus {
            border-color: #e91e63;
            box-shadow: 0 0 0 2px rgba(233, 30, 99, 0.25);
        }

        .card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 0;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .alert-info {
            background-color: #e8f4fd;
            border-color: #b6e0fe;
            color: #122f35ff;
        }

        .form-check-label {
            font-weight: 500;
            color: #344767;
        }

        .form-check-input:checked {
            background-color: #e91e63;
            border-color: #e91e63;
        }

        .text-danger {
            color: #e91e63 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Preview gambar sebelum upload
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                // Validasi ukuran file
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }

                // Validasi tipe file
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Preview Foto:</strong> Gambar berhasil diunggah.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 200px; max-width: 300px;" alt="Preview Foto">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                            <i class="bi bi-trash"></i> Hapus Gambar
                        </button>
                    `;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

        // Fungsi untuk menghapus gambar
        function removeImage() {
            document.getElementById('foto').value = '';
            document.getElementById('image-preview').innerHTML = '';
        }

        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const bentukPerundungan = document.getElementById('bentuk_perundungan').value;
            const frekuensiKejadian = document.getElementById('frekuensi_kejadian').value;
            const klasifikasi = document.getElementById('klasifikasi').value;
            const deskripsi = document.getElementById('deskripsi').value.trim();

            if (!bentukPerundungan) {
                e.preventDefault();
                alert('Bentuk perundungan harus dipilih.');
                document.getElementById('bentuk_perundungan').focus();
                return;
            }

            if (!frekuensiKejadian) {
                e.preventDefault();
                alert('Frekuensi kejadian harus dipilih.');
                document.getElementById('frekuensi_kejadian').focus();
                return;
            }

            if (!klasifikasi) {
                e.preventDefault();
                alert('Klasifikasi harus dipilih.');
                document.getElementById('klasifikasi').focus();
                return;
            }

            if (!deskripsi) {
                e.preventDefault();
                alert('Deskripsi pengaduan harus diisi.');
                document.getElementById('deskripsi').focus();
                return;
            }

            if (deskripsi.length < 10) {
                e.preventDefault();
                alert('Deskripsi pengaduan minimal 10 karakter.');
                document.getElementById('deskripsi').focus();
                return;
            }

            // Konfirmasi sebelum submit
            if (!confirm('Apakah Anda yakin ingin mengirim pengaduan ini?')) {
                e.preventDefault();
            }
        });

        // Counter karakter untuk deskripsi
        document.getElementById('deskripsi').addEventListener('input', function(e) {
            const charCount = this.value.length;
            const counter = document.getElementById('char-counter') || createCharCounter();
            counter.textContent = `${charCount} karakter`;

            if (charCount > 2000) {
                counter.classList.add('text-danger');
                counter.innerHTML = `${charCount} karakter <span class="text-danger">(Terlalu panjang!)</span>`;
            } else if (charCount > 1000) {
                counter.classList.add('text-warning');
                counter.innerHTML = `${charCount} karakter`;
            } else {
                counter.classList.remove('text-danger', 'text-warning');
                counter.innerHTML = `${charCount} karakter`;
            }
        });

        function createCharCounter() {
            const counter = document.createElement('div');
            counter.id = 'char-counter';
            counter.className = 'form-text text-end';
            counter.textContent = '0 karakter';
            document.getElementById('deskripsi').parentNode.appendChild(counter);
            return counter;
        }

        // Initialize char counter
        document.addEventListener('DOMContentLoaded', function() {
            createCharCounter();

            // Set default value untuk checkbox (0)
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        this.value = '0';
                    } else {
                        this.value = '1';
                    }
                });
                // Set initial value
                checkbox.value = checkbox.checked ? '1' : '0';
            });
        });
    </script>
@endpush
