@extends('admin.layouts.template')
@section('title', 'Edit Siswa')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Siswa</li>
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
                            <h6 class="text-white text-capitalize ps-3">Edit Data Siswa</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2">
                        <form action="{{ route('admin.siswa.update', $siswa->id_siswa) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="nama" class="ms-0">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" 
                                               placeholder="Masukkan nama lengkap" name="nama" 
                                               value="{{ old('nama', $siswa->nama) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="email" class="ms-0">Email</label>
                                        <input type="email" class="form-control" id="email" 
                                               placeholder="Masukkan email" name="email"
                                               value="{{ old('email', $pengguna->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="username" class="ms-0">Username</label>
                                        <input type="text" class="form-control" id="username" 
                                               placeholder="Masukkan username" name="username"
                                               value="{{ old('username', $pengguna->username) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="password" class="ms-0">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                                        <input type="password" class="form-control" id="password" 
                                               placeholder="Masukkan password baru" name="password">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="kelas" class="ms-0">Kelas</label>
                                        <select class="form-control" name="kelas" id="kelas" required>
                                            <option value="" disabled>Pilih Kelas</option>
                                            <option value="7" {{ old('kelas', $siswa->kelas) == '7' ? 'selected' : '' }}>Kelas 7</option>
                                            <option value="8" {{ old('kelas', $siswa->kelas) == '8' ? 'selected' : '' }}>Kelas 8</option>
                                            <option value="9" {{ old('kelas', $siswa->kelas) == '9' ? 'selected' : '' }}>Kelas 9</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="jurusan" class="ms-0">Jurusan</label>
                                        <select class="form-control" name="jurusan" id="jurusan" required>
                                            <option value="" disabled>Pilih Jurusan</option>
                                            <option value="IPA" {{ old('jurusan', $siswa->jurusan ?? '') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                            <option value="IPS" {{ old('jurusan', $siswa->jurusan ?? '') == 'IPS' ? 'selected' : '' }}>IPS</option>
                                            <option value="Bahasa" {{ old('jurusan', $siswa->jurusan ?? '') == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="gender" class="ms-0">Gender</label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="" disabled>Pilih Gender</option>
                                            <option value="laki-laki" {{ old('gender', $siswa->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                            <option value="perempuan" {{ old('gender', $siswa->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="no_telp" class="ms-0">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp" 
                                               placeholder="Contoh: 085xxxxxxx" name="no_telp"
                                               value="{{ old('no_telp', $siswa->no_telp) }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="alamat" class="ms-0">Alamat</label>
                                        <textarea class="form-control" id="alamat" rows="3" 
                                                  placeholder="Masukkan alamat lengkap" name="alamat" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="foto" class="ms-0">Foto Profil <small class="text-muted">(maks. 2 MB, kosongkan jika tidak diubah)</small></label>
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/foto-siswa/' . $siswa->foto) }}" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 200px; max-width: 200px;" 
                                                 alt="Foto Profil {{ $siswa->nama }}"
                                                 id="current-photo">
                                            <div class="form-text mt-1">Foto saat ini</div>
                                        </div>
                                        <input type="file" class="form-control" id="foto" name="foto" 
                                               accept="image/*">
                                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, GIF</div>
                                    </div>
                                    <div id="image-preview" class="mt-2"></div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Update Data
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
        .toggle-password {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-left: none;
        }
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        #current-photo {
            border: 2px solid #dee2e6;
            border-radius: 0.375rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const passwordInput = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

        // Preview gambar baru sebelum upload
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const currentPhoto = document.getElementById('current-photo');
            
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
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Preview Foto Baru:</strong> Foto lama akan diganti.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 200px; max-width: 200px;" alt="Preview Foto Baru">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="cancelImageUpload()">
                            <i class="bi bi-x-circle"></i> Batalkan Perubahan
                        </button>
                    `;
                    
                    // Sembunyikan foto lama
                    if (currentPhoto) {
                        currentPhoto.style.opacity = '0.5';
                    }
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
                // Tampilkan kembali foto lama
                if (currentPhoto) {
                    currentPhoto.style.opacity = '1';
                }
            }
        });

        // Fungsi untuk membatalkan upload gambar baru
        function cancelImageUpload() {
            document.getElementById('foto').value = '';
            document.getElementById('image-preview').innerHTML = '';
            const currentPhoto = document.getElementById('current-photo');
            if (currentPhoto) {
                currentPhoto.style.opacity = '1';
            }
        }

        // Validasi nomor telepon
        document.getElementById('no_telp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9+]/g, '');
            
            // Validasi panjang nomor telepon
            if (this.value.length < 10 || this.value.length > 15) {
                this.setCustomValidity('Nomor telepon harus antara 10-15 digit');
            } else {
                this.setCustomValidity('');
            }
        });

        // Generate username dari email jika username kosong
        document.getElementById('email').addEventListener('blur', function(e) {
            const usernameField = document.getElementById('username');
            if (!usernameField.value && this.value) {
                const email = this.value;
                const username = email.split('@')[0];
                usernameField.value = username.toLowerCase().replace(/[^a-z0-9]/g, '');
            }
        });

        // Konfirmasi sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin mengupdate data siswa ini?')) {
                e.preventDefault();
            }
        });

        // Tampilkan pesan error validasi jika ada
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const firstErrorField = document.querySelector('.is-invalid');
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
            });
        @endif
    </script>
@endpush