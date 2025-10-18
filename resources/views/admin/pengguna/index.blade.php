@extends('admin.layouts.template')
@section('title', 'Pengguna')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pengguna</li>
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
                            <h6 class="text-white text-capitalize ps-3">Data Pengguna</h6>
                            @if (Auth::user()->role == 'kepala_sekolah')
                                <a href="{{ url('export/pengguna') }}" target="_blank" class="btn btn-success btn-sm me-3">
                                    <i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-md-inline">Export PDF</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <!-- Desktop View -->
                        <div class="d-none d-md-block">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $pengguna)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pengguna->email }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold mb-0">{{ $pengguna->username }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm 
                                                        @if($pengguna->role == 'kepala_sekolah') bg-gradient-primary
                                                        @elseif($pengguna->role == 'petugas') bg-gradient-info
                                                        @elseif($pengguna->role == 'siswa') bg-gradient-success
                                                        @elseif($pengguna->role == 'admin') bg-gradient-warning
                                                        @else ()bg-gradient-secondary @endif flex-shrink-0">
                                                        {{ ucfirst(str_replace('_', ' ', $pengguna->role)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-row gap-1">
                                                        <a href="{{ route('admin.pengguna.edit', $pengguna->id_pengguna) }}"
                                                           class="text-secondary font-weight-bold text-xs"
                                                           data-toggle="tooltip" 
                                                           data-original-title="Edit Pengguna">
                                                            <button class="btn btn-primary btn-sm" type="button">
                                                                Edit
                                                            </button>
                                                        </a>
                                                        {{-- <a href="{{ route('pengguna.destroy', $pengguna->id_pengguna) }}"
                                                             class="btn btn-danger btn-sm font-weight-bold text-xs"
                                                             data-confirm-delete="true">
                                                             <i class="bi bi-trash"></i>
                                                         </a> --}}
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
                                @foreach ($data as $pengguna)
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body p-3">
                                            <!-- Header dengan email dan role -->
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1 me-2">
                                                    <h6 class="mb-1 text-sm font-weight-bold text-primary text-truncate">
                                                        {{ $pengguna->email }}
                                                    </h6>
                                                    <div class="text-xs text-muted">
                                                        @:{{ $pengguna->username }}
                                                    </div>
                                                </div>
                                                <span class="badge badge-sm 
                                                    @if($pengguna->role == 'kepala_sekolah') bg-gradient-primary
                                                    @elseif($pengguna->role == 'petugas') bg-gradient-info
                                                    @elseif($pengguna->role == 'siswa') bg-gradient-success
                                                    @else bg-gradient-secondary @endif flex-shrink-0">
                                                    {{ ucfirst(str_replace('_', ' ', $pengguna->role)) }}
                                                </span>
                                            </div>
                                            
                                            <!-- Informasi tambahan -->
                                            <div class="mb-3">
                                                <div class="d-flex flex-wrap gap-3 text-xs">
                                                    <div>
                                                        <small class="text-muted">Username:</small>
                                                        <div class="font-weight-bold">{{ $pengguna->username }}</div>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">Role:</small>
                                                        <div class="font-weight-bold">{{ ucfirst(str_replace('_', ' ', $pengguna->role)) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Tombol aksi -->
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('admin.pengguna.edit', $pengguna->id_pengguna) }}"
                                                   class="btn btn-primary btn-sm text-xs"
                                                   data-toggle="tooltip" 
                                                   title="Edit Pengguna">
                                                    <i class="bi bi-pencil me-1"></i>
                                                    Edit
                                                </a>
                                                {{-- <a href="{{ route('pengguna.destroy', $pengguna->id_pengguna) }}"
                                                     class="btn btn-danger btn-sm text-xs ms-1"
                                                     data-confirm-delete="true">
                                                     <i class="bi bi-trash me-1"></i>
                                                     Hapus
                                                 </a> --}}
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