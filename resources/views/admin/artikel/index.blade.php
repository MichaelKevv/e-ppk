@extends('admin.layouts.template')
@section('title', 'Artikel')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                    href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Artikel</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div
                            class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Data Artikel</h6>
                            <div class="d-flex gap-2 me-3">
                                <a href="{{ route('admin.artikel.create') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-circle"></i> <span class="d-none d-md-inline">Tambah Artikel</span>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Judul</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Konten</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kategori</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Upload</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Author</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $artikel)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <picture>
                                                            <source srcset="{{ asset($artikel->gambar_sm) }}"
                                                                media="(max-width: 480px)">
                                                            <source srcset="{{ asset($artikel->gambar_md) }}"
                                                                media="(max-width: 1024px)">
                                                            <img src="{{ asset($artikel->gambar_lg) }}"
                                                                alt="{{ $artikel->judul }}" class="img-fluid" width="100">
                                                        </picture>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ Str::limit($artikel->judul, 30) }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold mb-0">
                                                        {!! Str::limit(strip_tags($artikel->konten), 50) !!}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        {{ $artikel->kategori }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($artikel->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-xs font-weight-bold mb-0">{{ Str::ucfirst($artikel->admin->nama) }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-row gap-1">
                                                        <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}"
                                                            class="btn btn-warning btn-sm"
                                                            data-bs-toggle="tooltip" title="Edit Artikel">
                                                            <i class="material-symbols-rounded">edit</i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btnDelete"
                                                            data-bs-toggle="tooltip" title="Hapus Artikel">
                                                            <i class="material-symbols-rounded">delete</i>
                                                        </button>
                                                        <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}"
                                                            method="POST" class="d-none deleteForm">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
                                @foreach ($data as $artikel)
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body p-3">
                                            <!-- Header dengan gambar dan judul -->
                                            <div class="d-flex align-items-start mb-2">
                                                <div class="me-3 flex-shrink-0">
                                                    <img src="{{ asset($artikel->gambar_sm) }}"
                                                         alt="{{ $artikel->judul }}"
                                                         class="rounded"
                                                         width="80"
                                                         height="60"
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 text-sm font-weight-bold">{{ Str::limit($artikel->judul, 40) }}</h6>
                                                    <div class="d-flex flex-wrap gap-1 align-items-center">
                                                        <span class="badge badge-sm bg-gradient-info">
                                                            {{ $artikel->kategori }}
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($artikel->created_at)->isoFormat('D MMM YYYY') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Konten artikel -->
                                            <div class="mb-2">
                                                <small class="text-muted">Konten:</small>
                                                <p class="text-xs mb-1">
                                                    {!! Str::limit(strip_tags($artikel->konten), 80) !!}
                                                </p>
                                            </div>

                                            <!-- Info author -->
                                            <div class="mb-3">
                                                <small class="text-muted">Oleh:</small>
                                                <span class="text-xs font-weight-bold">{{ Str::ucfirst($artikel->admin->nama) }}</span>
                                            </div>

                                            <!-- Tombol aksi -->
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="tooltip" title="Edit Artikel">
                                                    <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                                    <span class="d-none d-sm-inline ms-1">Edit</span>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm btnDelete"
                                                    data-bs-toggle="tooltip" title="Hapus Artikel">
                                                    <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                                    <span class="d-none d-sm-inline ms-1">Hapus</span>
                                                </button>
                                                <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}"
                                                    method="POST" class="d-none deleteForm">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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

    <!-- JavaScript untuk konfirmasi hapus -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfirmasi hapus untuk semua tombol delete
            const deleteButtons = document.querySelectorAll('.btnDelete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.nextElementSibling;

                    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btnDelete').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('td').querySelector('.deleteForm');
                Swal.fire({
                    title: 'Yakin hapus artikel ini?',
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
