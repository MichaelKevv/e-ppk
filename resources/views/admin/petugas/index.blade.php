@extends('admin.layouts.template')
@section('title', 'Petugas')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Petugas</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Data Petugas</h6>
                            <div class="d-flex gap-2 me-3">
                                <a href="{{ route('admin.petugas.create') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> Tambah Data
                                </a>
                                @if (Auth::user()->role == 'kepala_sekolah')
                                    <a href="{{ url('export/petugas') }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Telepon</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $petugas)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ url('storage/foto-petugas/' . $petugas->foto) }}" 
                                                         class="avatar avatar-sm me-3 border-radius-lg" 
                                                         alt="{{ $petugas->nama }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $petugas->nama }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ Str::limit($petugas->alamat, 30) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm {{ $petugas->gender == 'Laki-laki' ? 'bg-gradient-info' : 'bg-gradient-warning' }}">
                                                    {{ $petugas->gender }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{{ $petugas->no_telp }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{{ $petugas->tb_pengguna->username }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{{ $petugas->tb_pengguna->email }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-row gap-1">
                                                    <a href="{{ route('admin.petugas.edit', $petugas->id_petugas) }}"
                                                       class="text-secondary font-weight-bold text-xs"
                                                       data-toggle="tooltip" 
                                                       data-original-title="Edit Petugas">
                                                        <button class="btn btn-primary btn-sm" type="button">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('admin.petugas.destroy', $petugas->id_petugas) }}"
                                                       class="btn btn-danger btn-sm font-weight-bold text-xs"
                                                       data-confirm-delete="true">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection