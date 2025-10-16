@extends('admin.layouts.template')
@section('title', 'Tambah Petugas')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.petugas.index') }}">Data Petugas</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Petugas</li>
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
                            <h6 class="text-white text-capitalize ps-3">Tambah Data Petugas</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2">
                        <form action="{{ route('admin.petugas.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="nama" class="ms-0">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" 
                                               placeholder="Masukkan nama lengkap" name="nama" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="email" class="ms-0">Email</label>
                                        <input type="email" class="form-control" id="email" 
                                               placeholder="Masukkan email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="username" class="ms-0">Username</label>
                                        <input type="text" class="form-control" id="username" 
                                               placeholder="Masukkan username" name="username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="password" class="ms-0">Password</label>
                                        <input type="password" class="form-control" id="password" 
                                               placeholder="Masukkan password" name="password" required>
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="alamat" class="ms-0">Alamat</label>
                                        <textarea class="form-control" id="alamat" rows="3" 
                                                  placeholder="Masukkan alamat lengkap" name="alamat" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="gender" class="ms-0">Gender</label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="" selected disabled>Pilih Gender</option>
                                            <option value="laki-laki">Laki-Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="no_telp" class="ms-0">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp" 
                                               placeholder="Contoh: 085xxxxxxx" name="no_telp" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="foto" class="ms-0">Foto Profil <small class="text-muted">(maks. 2 MB)</small></label>
                                        <input type="file" class="form-control" id="foto" name="foto" 
                                               accept="image/*" required>
                                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, GIF</div>
                                    </div>
                                    <div id="image-preview" class="mt-2"></div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Simpan Data
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
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Preview Foto:</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 200px; max-width: 200px;" alt="Preview Foto">
                    `;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

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

        // Generate username dari email
        document.getElementById('email').addEventListener('blur', function(e) {
            const usernameField = document.getElementById('username');
            if (!usernameField.value && this.value) {
                const email = this.value;
                const username = email.split('@')[0];
                usernameField.value = username.toLowerCase().replace(/[^a-z0-9]/g, '');
            }
        });

        // Generate password acak
        function generatePassword() {
            const length = 8;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            return password;
        }

        // Opsional: Tombol generate password
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            if (!passwordField.value) {
                passwordField.value = generatePassword();
            }
        });
    </script>
@endpush