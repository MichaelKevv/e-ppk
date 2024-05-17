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
                        <h3>Data Siswa</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ url('siswa/create') }}"><button class="btn btn-success">Tambah Data</button></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telepon</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ $siswa->alamat }}</td>
                                        <td>{{ $siswa->no_telp }}</td>
                                        <td>{{ $siswa->tb_pengguna->username }}</td>
                                        <td>{{ $siswa->tb_pengguna->email }}</td>
                                        <td>
                                            <a href="{{ route('siswa.edit', $siswa->id_siswa) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit Siswa">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('siswa.destroy', $siswa->id_siswa) }}"
                                                class="btn btn-danger font-weight-bold text-xs" data-confirm-delete="true">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection
