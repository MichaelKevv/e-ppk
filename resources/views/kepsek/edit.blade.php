@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Data Kepala Sekolah</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('kepsek') }}">Data Kepala Sekolah</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data Kepala Sekolah</li>
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
                                <form class="form form-vertical" action="{{ route('kepsek.update', $kepsek->id_kepala) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Nama" value="{{ $kepsek->nama }}"
                                                        name="nama" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Alamat</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Alamat" value="{{ $kepsek->alamat }}"
                                                        name="alamat" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Gender</label>
                                                    <select class="form-control" name="gender" id="gender" required>
                                                        <option value="" disabled>Pilih Gender</option>
                                                        <option value="laki-laki"
                                                            {{ $kepsek->gender == 'laki-laki' ? 'selected' : '' }}>Laki-Laki
                                                        </option>
                                                        <option value="perempuan"
                                                            {{ $kepsek->gender == 'perempuan' ? 'selected' : '' }}>Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telepon</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Nomor Telepon / WA"
                                                        value="{{ $kepsek->no_telp }}" name="no_telp" required>
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
                                                        placeholder="Masukkan Username" value="{{ $pengguna->username }}"
                                                        name="username" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Password</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        placeholder="Masukkan Password" name="password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Foto <small>(maks. 2 MB)</small></label>
                                                    <br>
                                                    <img src="{{ asset('storage/foto-kepsek/' . $kepsek->foto) }}"
                                                        alt="{{ $kepsek->nama }}"
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
