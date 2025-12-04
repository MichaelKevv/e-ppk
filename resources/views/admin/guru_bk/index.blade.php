@extends('admin.layouts.template')
@section('title', 'Data Guru BK')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Guru BK</li>
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
                        <h6 class="text-white text-capitalize ps-3 mb-0">Data Guru BK</h6>
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('admin.guru-bk.create') }}" class="btn btn-success btn-sm">
                                <i class="material-symbols-rounded">add</i>
                                <span class="d-none d-md-inline">Tambah Guru BK</span>
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
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Gender</th>
                                        <th>No. Telepon</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($guruBks as $guruBk)
                                    <tr>
                                        <td>{{ $guruBk->nip }}</td>
                                        <td>{{ $guruBk->nama }}</td>
                                        <td>{{ $guruBk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ $guruBk->no_telp ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.guru-bk.show', $guruBk->nip) }}" 
                                               class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                            </a>
                                            <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}" 
                                               class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" 
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.guru-bk.destroy', $guruBk->nip) }}" 
                                                  method="POST" class="d-none deleteForm">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data Guru BK.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-md-none">
                        <div class="row px-3">
                            @forelse($guruBks as $guruBk)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            @if($guruBk->foto)
                                            <img src="{{ asset('storage/' . $guruBk->foto) }}" 
                                                 class="rounded-circle me-3" width="50" height="50" 
                                                 alt="{{ $guruBk->nama }}">
                                            @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="material-symbols-rounded text-white">person</i>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $guruBk->nama }}</h6>
                                                <p class="mb-0 text-xs text-muted">{{ $guruBk->nip }}</p>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled mb-3 text-xs">
                                            <li><strong>Gender:</strong> {{ $guruBk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</li>
                                            <li><strong>No. Telp:</strong> {{ $guruBk->no_telp ?? '-' }}</li>
                                        </ul>
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.guru-bk.show', $guruBk->nip) }}" 
                                               class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                            </a>
                                            <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}" 
                                               class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" 
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                            </button>
                                            <form action="{{ route('admin.guru-bk.destroy', $guruBk->nip) }}" 
                                                  method="POST" class="d-none deleteForm">
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
                                        <i class="material-symbols-rounded mb-2" 
                                           style="font-size: 48px; opacity: 0.5;">school</i>
                                        <p class="mb-0">Belum ada data Guru BK.</p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if ($guruBks->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $guruBks->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
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
                title: 'Yakin ingin menghapus data Guru BK ini?',
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