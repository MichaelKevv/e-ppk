@extends('admin.layouts.template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Petugas</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Petugas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.petugas.create') }}"><button class="btn btn-success">Tambah Data</button></a>
                    @if (Auth::user()->role == 'kepala_sekolah')
                        <a href="{{ url('export/petugas') }}" target="_blank"><button class="btn btn-success">Export
                                PDF</button></a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Gender</th>
                                <th>Nomor Telepon</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $petugas)
                                <tr>
                                    <td>{{ $petugas->nama }}</td>
                                    <td>{{ $petugas->alamat }}</td>
                                    <td>{{ $petugas->gender }}</td>
                                    <td>{{ $petugas->no_telp }}</td>
                                    <td>{{ $petugas->tb_pengguna->username }}</td>
                                    <td>{{ $petugas->tb_pengguna->email }}</td>
                                    <td>
                                        <img src="{{ url('storage/foto-petugas/' . $petugas->foto) }}" width="100px">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.petugas.edit', $petugas->id_petugas) }}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit Petugas">
                                            <button class="btn btn-primary" type="button">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin.petugas.destroy', $petugas->id_petugas) }}"
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
@endsection
