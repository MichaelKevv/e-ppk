@extends('admin.layouts.template')
@section('title', 'Data Dinsos')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dinsos</li>
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
                        <h6 class="text-white text-capitalize ps-3">Data Dinsos</h6>
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('admin.dinsos.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Dinsos</span>
                            </a>
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
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Gender</th>
                                        <th>No. Telp</th>
                                        <th>Email</th>
                                        <th>Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $dinsos)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($dinsos->foto)
                                                <picture>
                                                    <source srcset="{{ asset($dinsos->foto_sm) }}" media="(max-width: 480px)">
                                                    <source srcset="{{ asset($dinsos->foto_md) }}" media="(max-width: 1024px)">
                                                    <img src="{{ asset($dinsos->foto_lg) }}"
                                                        alt="{{ $dinsos->nama }}"
                                                        class="img-fluid rounded-circle"
                                                        width="70" height="70"
                                                        style="object-fit: cover;">
                                                </picture>
                                                @else
                                                <img src="{{ asset('assets/img/default-avatar.png') }}"
                                                    alt="Default Avatar"
                                                    class="rounded-circle"
                                                    width="60" height="60">
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $dinsos->nama }}</td>
                                        <td>{{ $dinsos->nip }}</td>
                                        <td>{{ $dinsos->gender }}</td>
                                        <td>{{ $dinsos->no_telp ?? '-' }}</td>
                                        <td>{{ $dinsos->user->email ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dinsos->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                        <td>
                                            <a href="{{ route('admin.dinsos.edit', $dinsos->id_dinsos) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Dinsos">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-bs-toggle="tooltip" title="Hapus Dinsos">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.dinsos.destroy', $dinsos->id_dinsos) }}" method="POST" class="d-none deleteForm">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Tidak ada data dinsos
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-md-none">
                        <div class="row px-3">
                            @forelse ($data as $dinsos)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="me-3 flex-shrink-0">
                                                @if ($dinsos->foto)
                                                <img src="{{ asset($dinsos->foto_sm) }}" alt="{{ $dinsos->nama }}" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                                                @else
                                                <img src="{{ asset('assets/img/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle" width="60" height="60">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-sm font-weight-bold">{{ $dinsos->nama }}</h6>
                                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                                    <span class="badge badge-sm bg-gradient-primary">NIP: {{ $dinsos->nip }}</span>
                                                    <span class="badge badge-sm {{ $dinsos->gender == 'Laki-laki' ? 'bg-gradient-info' : 'bg-gradient-warning' }}">
                                                        {{ $dinsos->gender }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted">Telepon</small>
                                                <div class="text-xs font-weight-bold">{{ $dinsos->no_telp ?? '-' }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Email</small>
                                                <div class="text-xs font-weight-bold text-truncate">{{ $dinsos->user->email ?? '-' }}</div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">Bergabung</small>
                                            <div class="text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($dinsos->created_at)->isoFormat('D MMMM YYYY') }}
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.dinsos.edit', $dinsos->id_dinsos) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Dinsos">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-bs-toggle="tooltip" title="Hapus Dinsos">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.dinsos.destroy', $dinsos->id_dinsos) }}" method="POST" class="d-none deleteForm">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body text-center text-muted py-5">
                                        <i class="material-symbols-rounded mb-2" style="font-size: 48px; opacity: 0.5;">account_circle</i>
                                        <p class="mb-0">Tidak ada data dinsos</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btnDelete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.card-body').querySelector('.deleteForm') ||
                this.closest('td').querySelector('.deleteForm');

            Swal.fire({
                title: 'Yakin hapus data dinsos ini?',
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
