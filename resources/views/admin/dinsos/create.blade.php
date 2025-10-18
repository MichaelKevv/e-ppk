@extends('admin.layouts.template')
@section('title', 'Tambah Dinsos')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="{{ route('admin.dinsos.index') }}">Data Dinsos</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Dinsos</li>
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
                            <h6 class="text-white text-capitalize ps-3">Tambah Data Dinsos</h6>
                        </div>
                    </div>

                    <div class="card-body px-4 pb-2">
                        <form action="{{ route('admin.dinsos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="nama">Nama Dinsos</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" placeholder="Masukkan nama dinsos" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            value="{{ old('nip') }}" placeholder="Masukkan nip dinsos" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="jabatan">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">Pilih Gender</option>
                                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-Laki
                                            </option>
                                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="no_telp">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            value="{{ old('no_telp') }}" placeholder="Masukkan nomor telepon">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ old('username') }}" placeholder="Masukkan username" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" placeholder="Masukkan email" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                            value="{{ old('password') }}" placeholder="Masukkan password" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="foto">Foto Dinsos <small class="text-muted">(maks.
                                                2MB)</small></label>
                                        <input type="file" class="form-control" id="foto" name="foto"
                                            accept="image/*">
                                        <div id="image-preview" class="mt-2"></div>
                                        <div class="form-text text-muted">Format: JPG, PNG, JPEG, GIF</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Simpan Dinsos
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

@push('scripts')
    <script>
        const inputFoto = document.getElementById('foto');
        const preview = document.getElementById('image-preview');
        const maxSize = 2 * 1024 * 1024;

        inputFoto.addEventListener('change', e => {
            const file = e.target.files[0];
            preview.innerHTML = '';

            if (!file) return;
            if (file.size > maxSize) {
                alert('Ukuran file maksimal 2MB!');
                inputFoto.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML =
                    `<img src="${e.target.result}" class="img-thumbnail mt-2" style="max-height: 200px;">`;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush
