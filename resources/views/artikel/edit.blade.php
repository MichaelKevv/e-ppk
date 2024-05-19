@extends('template')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Data Artikel</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('artikel') }}">Data Artikel</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical"
                                    action="{{ route('artikel.update', $artikel->id_artikel) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Judul</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Judul" name="judul"
                                                        value="{{ $artikel->judul }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Konten</label>
                                                    <textarea id="konten" name="konten">{{ $artikel->konten }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Kategori</label>
                                                    <select class="form-control" name="kategori" id="kategori" required>
                                                        <option value="" disabled>Pilih Kategori</option>
                                                        <option value="Mental"
                                                            {{ $artikel->kategori == 'Mental' ? 'selected' : '' }}>Mental
                                                        </option>
                                                        <option value="Stress"
                                                            {{ $artikel->kategori == 'Stress' ? 'selected' : '' }}>Stress
                                                        </option>
                                                        <option value="Anxiety"
                                                            {{ $artikel->kategori == 'Anxiety' ? 'selected' : '' }}>Anxiety
                                                        </option>
                                                        <option value="Therapy"
                                                            {{ $artikel->kategori == 'Therapy' ? 'selected' : '' }}>Therapy
                                                        </option>
                                                        <option value="Selfcare"
                                                            {{ $artikel->kategori == 'Selfcare' ? 'selected' : '' }}>
                                                            Selfcare</option>
                                                        <option value="Relationships"
                                                            {{ $artikel->kategori == 'Relationships' ? 'selected' : '' }}>
                                                            Relationships</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Gambar</label>
                                                    <br>
                                                    <img src="{{ asset('storage/foto-artikel/' . $artikel->gambar) }}"
                                                        alt="{{ $artikel->judul }}"
                                                        style="max-width: 200px; margin-top: 10px;">
                                                    <input type="file" id="email-id-vertical" class="form-control"
                                                        name="gambar">

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Author</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        name="author" placeholder="Masukkan Nama Author"
                                                        value="{{ $artikel->author }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
