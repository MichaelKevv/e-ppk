@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Data Artikel</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('artikel') }}">Data Artikel</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Data Artikel</li>
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
                                <form class="form form-vertical" action="{{ route('artikel.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Judul</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Judul" name="judul" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Konten</label>
                                                    <textarea id="konten" name="konten" data-purpose="artikel"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Kategori</label>
                                                    <select class="form-control" name="kategori" id="kategori">
                                                        <option value="" selected>Pilih Kategori</option>
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
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Gambar <small>(maks. 2 MB)</small></label>
                                                    <input type="file" id="email-id-vertical" class="form-control"
                                                        name="gambar" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Author</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        name="author" placeholder="Masukkan Nama Author" value=" {{ session('userdata')->nama }}" required readonly>
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
