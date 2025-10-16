@extends('admin.layouts.template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Kepala Sekolah</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Kepala Sekolah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.kepsek.create') }}"><button class="btn btn-success">Tambah Data</button></a>
                    @if (Auth::user()->role == 'kepala_sekolah')
                        <a href="{{ url('export/kepsek') }}" target="_blank"><button class="btn btn-success">Export
                                PDF</button></a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $kepsek)
                                <tr>
                                    <td>{{ $kepsek->nama }}</td>
                                    <td>{{ $kepsek->gender }}</td>
                                    <td>{{ $kepsek->alamat }}</td>
                                    <td>{{ $kepsek->no_telp }}</td>
                                    <td>{{ $kepsek->tb_pengguna->username }}</td>
                                    <td>{{ $kepsek->tb_pengguna->email }}</td>
                                    <td>
                                        <img src="{{ url('storage/foto-kepsek/' . $kepsek->foto) }}" width="100px">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.kepsek.edit', $kepsek->id_kepala) }}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit Kepala Sekolah">
                                            <button class="btn btn-primary" type="button">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin.kepsek.destroy', $kepsek->id_kepala) }}"
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
