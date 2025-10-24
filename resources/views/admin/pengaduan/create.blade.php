@extends('admin.layouts.template')
@section('title', 'Tambah Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                    href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.pengaduan.index') }}">Data
                    Pengaduan</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Pengaduan</li>
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
                            <h6 class="text-white text-capitalize ps-3">Tambah Data Pengaduan</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2">
                        <form action="{{ route('admin.pengaduan.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Bentuk Perundungan -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="bentuk_perundungan" class="ms-0">Bentuk Perundungan <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="bentuk_perundungan" id="bentuk_perundungan"
                                            required>
                                            <option value="" selected disabled>Pilih Bentuk Perundungan</option>
                                            <option value="verbal">Verbal</option>
                                            <option value="fisik">Fisik</option>
                                            <option value="sosial">Sosial</option>
                                            <option value="siber">Siber</option>
                                            <option value="seksual">Seksual</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Frekuensi Kejadian -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="frekuensi_kejadian" class="ms-0">Frekuensi Kejadian <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="frekuensi_kejadian" id="frekuensi_kejadian"
                                            required>
                                            <option value="" selected disabled>Pilih Frekuensi</option>
                                            <option value="sekali">Sekali</option>
                                            <option value="2-3_kali">2-3 Kali</option>
                                            <option value="sering">Sering</option>
                                        </select>
                                    </div>
                                </div>

                                @if (Auth::user()->role !== 'siswa')
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="lokasi" class="ms-0">Siswa</label>
                                            <select name="id_pengguna" id="id_pengguna" class="form-control">
                                                <option value="">Pilih Siswa</option>
                                                @foreach ($siswa as $s)
                                                    <option value="{{ $s->id_pengguna }}">{{ $s->nama }} |
                                                        {{ $s->kelas }} </option>
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
                                            placeholder="Contoh: Ruang kelas, Lapangan, Kantin, dll." name="lokasi">
                                        <div class="form-text">Tempat dimana kejadian berlangsung (opsional)</div>
                                    </div>
                                </div>

                                <!-- Checkbox Group -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="trauma_mental"
                                                    id="trauma_mental" value="1">
                                                <label class="form-check-label" for="trauma_mental">
                                                    Trauma Mental
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="luka_fisik"
                                                    id="luka_fisik" value="1">
                                                <label class="form-check-label" for="luka_fisik">
                                                    Luka Fisik
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pelaku_lebih_dari_satu" id="pelaku_lebih_dari_satu"
                                                    value="1">
                                                <label class="form-check-label" for="pelaku_lebih_dari_satu">
                                                    Pelaku Lebih dari Satu
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="konten_digital"
                                                    id="konten_digital" value="1">
                                                <label class="form-check-label" for="konten_digital">
                                                    Konten Digital
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jenis Kata -->
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="jenis_kata" class="ms-0">Jenis Kata/Kalimat yang Digunakan</label>
                                        <input type="text" class="form-control" id="jenis_kata"
                                            placeholder="Contoh: Kata-kata kasar, ancaman, dll." name="jenis_kata">
                                        <div class="form-text">Jenis kata atau kalimat yang digunakan pelaku (opsional)
                                        </div>
                                    </div>
                                </div>

                                <!-- Klasifikasi -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="klasifikasi" class="ms-0">Klasifikasi <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="klasifikasi" id="klasifikasi" required>
                                            <option value="" selected disabled>Pilih Klasifikasi</option>
                                            <option value="ringan">Ringan</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="berat">Berat</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Foto Bukti -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="foto" class="ms-0">Foto Bukti <small class="text-muted">(maks.
                                                2 MB, opsional)</small></label>
                                        <input type="file" class="form-control" id="foto" name="foto"
                                            accept="image/*">
                                    </div>
                                    <div id="image-preview" class="mt-2"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="deskripsi" class="ms-0">Deskripsi</small></label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                                    </div>
                                </div>


                                <!-- Informasi -->
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <div>
                                                <strong>Informasi Penting:</strong>
                                                Pengaduan Anda akan dijaga kerahasiaannya dan diproses secara profesional.
                                                Pastikan data yang dimasukkan sudah benar dan sesuai fakta.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send"></i> Kirim Pengaduan
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
