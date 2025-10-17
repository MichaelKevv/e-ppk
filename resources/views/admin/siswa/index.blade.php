@extends('admin.layouts.template')
@section('title', 'Siswa')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Siswa</li>
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
                        <h6 class="text-white text-capitalize ps-3">Data Siswa</h6>
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('admin.siswa.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Data</span>
                            </a>
                            @if (Auth::user()->role == 'kepala_sekolah')
                            <a href="{{ url('export/siswa') }}" target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-md-inline">Export PDF</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <!-- Desktop View -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Telepon</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelas</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $siswa)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                $fotoPath = public_path('storage/foto-siswa/' . $siswa->foto);
                                                @endphp

                                                @if (!empty($siswa->foto) && file_exists($fotoPath))
                                                <img src="{{ asset('storage/foto-siswa/' . $siswa->foto) }}"
                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                    alt="{{ $siswa->nama }}">
                                                @else
                                                <img src="{{ asset('admin/img/landscape-placeholder.svg') }}"
                                                    class="avatar avatar-sm me-3 border-radius-lg"
                                                    alt="No Image">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $siswa->nama }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">
                                                {{ Str::limit($siswa->alamat, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $siswa->gender == 'Laki-laki' ? 'bg-gradient-info' : 'bg-gradient-warning' }}">
                                                {{ $siswa->gender }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">{{ $siswa->no_telp }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-success">
                                                {{ $siswa->kelas }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">{{ $siswa->user->username ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">{{ $siswa->user->email ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row gap-1">
                                                <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}"
                                                    class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip"
                                                    data-original-title="Edit Siswa">
                                                    <button class="btn btn-primary btn-sm" type="button">
                                                        Edit
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin.siswa.destroy', $siswa->id_siswa) }}"
                                                    class="btn btn-danger btn-sm font-weight-bold text-xs"
                                                    data-confirm-delete="true">
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-md-none">
                        <div class="row px-3">
                            @foreach ($data as $siswa)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-3">
                                                @php
                                                $fotoPath = public_path('storage/foto-siswa/' . $siswa->foto);
                                                @endphp

                                                @if (!empty($siswa->foto) && file_exists($fotoPath))
                                                <img src="{{ asset('storage/foto-siswa/' . $siswa->foto) }}"
                                                    class="avatar avatar-md border-radius-lg"
                                                    alt="{{ $siswa->nama }}">
                                                @else
                                                <img src="{{ asset('admin/img/landscape-placeholder.svg') }}"
                                                    class="avatar avatar-md border-radius-lg"
                                                    alt="No Image">
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm">{{ $siswa->nama }}</h6>
                                                <span class="badge badge-sm bg-gradient-success">
                                                    {{ $siswa->kelas }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <small class="text-muted">Gender</small>
                                                <div>
                                                    <span class="badge badge-sm {{ $siswa->gender == 'Laki-laki' ? 'bg-gradient-info' : 'bg-gradient-warning' }}">
                                                        {{ $siswa->gender }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Telepon</small>
                                                <div class="text-xs font-weight-bold">{{ $siswa->no_telp }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Alamat</small>
                                            <div class="text-xs font-weight-bold">
                                                {{ Str::limit($siswa->alamat, 50) }}
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted">Username</small>
                                                <div class="text-xs font-weight-bold">{{ $siswa->user->username ?? '-' }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Email</small>
                                                <div class="text-xs font-weight-bold">{{ $siswa->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}"
                                                class="text-secondary font-weight-bold text-xs">
                                                <button class="btn btn-primary btn-sm" type="button">
                                                    Edit
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.siswa.destroy', $siswa->id_siswa) }}"
                                                class="btn btn-danger btn-sm font-weight-bold text-xs"
                                                data-confirm-delete="true">
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection