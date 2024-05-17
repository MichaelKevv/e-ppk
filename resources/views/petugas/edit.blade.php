@extends('template')
@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Data Petugas</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('petugas') }}">Data Petugas</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Data Petugas</li>
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
                                        action="{{ route('petugas.update', $petuga->id_petugas) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Nama</label>
                                                        <input type="text" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Nama" value="{{ $petuga->nama }}"
                                                            name="nama" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Alamat</label>
                                                        <input type="text" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Alamat" value="{{ $petuga->alamat }}"
                                                            name="alamat" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Nomor Telepon</label>
                                                        <input type="text" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Nomor Telepon / WA"
                                                            value="{{ $petuga->no_telp }}" name="no_telp" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Email</label>
                                                        <input type="email" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Email" name="email"
                                                            value="{{ $pengguna->email }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Username</label>
                                                        <input type="text" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Username"
                                                            value="{{ $pengguna->username }}" name="username" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Password</label>
                                                        <input type="text" id="email-id-vertical" class="form-control"
                                                            placeholder="Masukkan Password" name="password">
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
    </div>
@endsection
