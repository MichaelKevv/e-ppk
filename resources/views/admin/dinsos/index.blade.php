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
                                    <i class="bi bi-plus-circle"></i> Tambah Dinsos
                                </a>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Telp</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Akun</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
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
                                                                 class="img-fluid"
                                                                 width="70" height="70"
                                                                 style="object-fit: cover;">
                                                        </picture>
                                                    @else
                                                        <img src="{{ asset('assets/img/default-avatar.png') }}"
                                                             alt="Default Avatar"
                                                             class="img-fluid rounded-circle"
                                                             width="70" height="70">
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $dinsos->nama }}</h6>
                                            </td>

                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $dinsos->nip }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $dinsos->gender }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $dinsos->no_telp ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">
                                                    {{ $dinsos->user->email ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($dinsos->created_at)->isoFormat('D MMMM YYYY HH:mm') }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-row gap-1">
                                                    <a href="{{ route('admin.dinsos.edit', $dinsos->id_dinsos) }}"
                                                       class="btn btn-warning"
                                                       data-bs-toggle="tooltip" title="Edit Dinsos">
                                                        <i class="material-symbols-rounded">edit</i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-danger btnDelete"
                                                            data-bs-toggle="tooltip" title="Hapus Dinsos">
                                                        <i class="material-symbols-rounded">delete</i>
                                                    </button>
                                                    <form action="{{ route('admin.dinsos.destroy', $dinsos->id_dinsos) }}"
                                                          method="POST" class="d-none deleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Tidak ada data dinsos
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                const form = this.closest('td').querySelector('.deleteForm');
                Swal.fire({
                    title: 'Yakin hapus dinsos ini?',
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
