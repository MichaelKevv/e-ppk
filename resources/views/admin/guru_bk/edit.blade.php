@extends('admin.layouts.template')
@section('title', 'Edit Guru BK - ' . $guruBk->nama)

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.guru-bk.index') }}">Data Guru BK</a>
        </li>
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.guru-bk.show', $guruBk->nip) }}">Detail</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Guru BK</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3 mb-0">Edit Data Guru BK</h6>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <form action="{{ route('admin.guru-bk.update', $guruBk->nip) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control bg-light" 
                                           id="nip" value="{{ $guruBk->nip }}" readonly>
                                    <small class="text-muted">NIP tidak dapat diubah</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', $guruBk->nama) }}" 
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="L" {{ old('gender', $guruBk->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $guruBk->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_telp" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                           id="no_telp" name="no_telp" value="{{ old('no_telp', $guruBk->no_telp) }}" 
                                           placeholder="Masukkan nomor telepon">
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $guruBk->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="foto" class="form-label">Foto</label>
                            
                            @if($guruBk->foto)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $guruBk->foto) }}" 
                                     class="img-fluid rounded shadow-sm mb-2" 
                                     alt="Foto saat ini"
                                     style="max-width: 200px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="hapus_foto" name="hapus_foto" value="1">
                                    <label class="form-check-label text-danger" for="hapus_foto">
                                        Hapus foto saat ini
                                    </label>
                                </div>
                            </div>
                            @endif
                            
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF | Maks: 2MB</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.guru-bk.show', $guruBk->nip) }}" class="btn btn-secondary">
                                <i class="material-symbols-rounded">cancel</i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="material-symbols-rounded">save</i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection