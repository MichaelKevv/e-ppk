@extends('admin.layouts.template')
@section('title', 'Tambah Artikel')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.artikel.index') }}">Data Artikel</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Artikel</li>
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
                            <h6 class="text-white text-capitalize ps-3">Tambah Data Artikel</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-2">
                        <form action="{{ route('admin.artikel.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="judul" class="ms-0">Judul Artikel</label>
                                        <input type="text" class="form-control" id="judul" 
                                               placeholder="Masukkan judul artikel" name="judul" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="konten" class="ms-0">Konten Artikel</label>
                                        <textarea id="konten" name="konten" class="form-control" rows="10" 
                                                  placeholder="Tulis konten artikel disini..." data-purpose="artikel"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="kategori" class="ms-0">Kategori</label>
                                        <select class="form-control" name="kategori" id="kategori" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="Mental">Mental</option>
                                            <option value="Stress">Stress</option>
                                            <option value="Anxiety">Anxiety</option>
                                            <option value="Therapy">Therapy</option>
                                            <option value="Selfcare">Selfcare</option>
                                            <option value="Relationships">Relationships</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="gambar" class="ms-0">Gambar Artikel <small class="text-muted">(maks. 2 MB)</small></label>
                                        <input type="file" class="form-control" id="gambar" name="gambar" 
                                               accept="image/*" required>
                                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, GIF</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="author" class="ms-0">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" 
                                               value="{{ session('userdata')->nama }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Simpan Artikel
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
    </style>
@endpush

@push('scripts')
    <script>
        // Preview gambar sebelum upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hapus preview sebelumnya jika ada
                    const existingPreview = document.getElementById('image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Buat elemen preview baru
                    const preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mt-2';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;" alt="Preview">
                        <small class="text-muted d-block mt-1">Preview gambar</small>
                    `;
                    
                    // Sisipkan preview setelah input file
                    document.getElementById('gambar').parentNode.appendChild(preview);
                }
                reader.readAsDataURL(file);
            }
        });

        // Validasi file size
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            
            if (file && file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                
                // Hapus preview jika ada
                const preview = document.getElementById('image-preview');
                if (preview) {
                    preview.remove();
                }
            }
        });
    </script>
@endpush