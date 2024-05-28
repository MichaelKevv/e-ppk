@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Data Pengaduan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('pengaduan') }}">Data Pengaduan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data Pengaduan</li>
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
                                    action="{{ route('pengaduan.update', $pengaduan->id_pengaduan) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Judul Pengaduan</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Judul Pengaduan"
                                                        value="{{ $pengaduan->judul }}" name="judul">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Deskripsi Pengaduan</label>
                                                    <textarea type="text" id="email-id-vertical" class="form-control" name="deskripsi">{{ $pengaduan->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Foto Pengaduan <small>(maks. 2 MB,
                                                            opsional)</small></label>
                                                    <br>
                                                    <img src="{{ asset('storage/foto-pengaduan/' . $pengaduan->foto) }}"
                                                        style="max-width: 200px; margin-top: 10px;">
                                                    <input type="file" id="email-id-vertical" class="form-control"
                                                        name="foto">

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
