@extends('admin.layouts.template')
@section('title', 'Tambah Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.pengaduan.index') }}">Data Pengaduan</a></li>
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
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="judul" class="ms-0">Judul Pengaduan</label>
                                        <input type="text" class="form-control" id="judul" 
                                               placeholder="Masukkan judul pengaduan" name="judul" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="deskripsi" class="ms-0">Deskripsi Pengaduan</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                                  rows="6" placeholder="Jelaskan detail pengaduan Anda di sini..." 
                                                  data-purpose="pengaduan" required></textarea>
                                        <div class="form-text">Jelaskan pengaduan Anda dengan jelas dan lengkap.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="kategori" class="ms-0">Kategori Pengaduan</label>
                                        <select class="form-control" name="kategori" id="kategori" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="akademik">Akademik</option>
                                            <option value="fasilitas">Fasilitas Sekolah</option>
                                            <option value="sarana">Sarana Prasarana</option>
                                            <option value="sosial">Sosial</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="urgensi" class="ms-0">Tingkat Urgensi</label>
                                        <select class="form-control" name="urgensi" id="urgensi" required>
                                            <option value="" selected disabled>Pilih Tingkat Urgensi</option>
                                            <option value="rendah">Rendah</option>
                                            <option value="sedang">Sedang</option>
                                            <option value="tinggi">Tinggi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="foto" class="ms-0">Foto Bukti <small class="text-muted">(maks. 2 MB, opsional)</small></label>
                                        <input type="file" class="form-control" id="foto" name="foto" 
                                               accept="image/*">
                                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, GIF. Maksimal 2MB.</div>
                                    </div>
                                    <div id="image-preview" class="mt-2"></div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <div>
                                                <strong>Informasi:</strong> Pengaduan Anda akan diproses dalam 1-3 hari kerja. 
                                                Pastikan data yang dimasukkan sudah benar.
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            color: #055160;
        }
        /* Styling untuk textarea */
        #deskripsi {
            resize: vertical;
            min-height: 120px;
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
            const judul = document.getElementById('judul').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const kategori = document.getElementById('kategori').value;
            const urgensi = document.getElementById('urgensi').value;

            if (!judul) {
                e.preventDefault();
                alert('Judul pengaduan harus diisi.');
                document.getElementById('judul').focus();
                return;
            }

            if (!deskripsi) {
                e.preventDefault();
                alert('Deskripsi pengaduan harus diisi.');
                document.getElementById('deskripsi').focus();
                return;
            }

            if (!kategori) {
                e.preventDefault();
                alert('Kategori pengaduan harus dipilih.');
                document.getElementById('kategori').focus();
                return;
            }

            if (!urgensi) {
                e.preventDefault();
                alert('Tingkat urgensi harus dipilih.');
                document.getElementById('urgensi').focus();
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
            
            if (charCount > 1000) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
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
        });
    </script>
@endpush