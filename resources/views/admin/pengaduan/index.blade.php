@extends('admin.layouts.template')
@section('title', 'Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Pengaduan</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Pengaduan</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <!-- Desktop View -->
                        <div class="d-none d-md-block">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Siswa</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Kelas</th>
                                            @endif
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Judul</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Deskripsi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $pengaduan)
                                            <tr>
                                                @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $pengaduan->tb_siswa->nama }}</h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-xs text-secondary mb-0">{{ $pengaduan->tb_siswa->kelas }}</span>
                                                    </td>
                                                @endif
                                                <td>
                                                    <span class="text-xs font-weight-bold mb-0">{{ $pengaduan->judul }}</span>
                                                </td>
                                                <td>
                                                    {!! Str::limit($pengaduan->deskripsi, 50) !!}
                                                </td>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-sm {{ $pengaduan->status == 'ditutup' ? 'bg-gradient-secondary' : 'bg-gradient-success' }}">
                                                        {{ $pengaduan->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-row gap-1">
                                                        @if (Auth::user()->role == 'siswa')
                                                            <a href="{{ route('pengaduan.edit', $pengaduan->id_pengaduan) }}"
                                                                class="text-secondary font-weight-bold text-xs"
                                                                data-toggle="tooltip" data-original-title="Edit Pengaduan">
                                                                <button class="btn btn-primary btn-sm" type="button">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                                class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                                Detail
                                                            </a>
                                                            <a href="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                                                class="btn btn-danger btn-sm font-weight-bold text-xs"
                                                                data-confirm-delete="true">
                                                                Delete
                                                            </a>
                                                            @if ($pengaduan->status != 'ditutup')
                                                                <form
                                                                    action="{{ url('pengaduan/selesai/' . $pengaduan->id_pengaduan) }}"
                                                                    method="post" style="display:inline;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        Selesai
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                                class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                                Detail
                                                            </a>
                                                        @endif
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
                                @foreach ($data as $pengaduan)
                                <div class="col-12 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body p-3">
                                            <!-- Header dengan judul dan status -->
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 text-sm font-weight-bold text-primary flex-grow-1 me-2">
                                                    {{ Str::limit($pengaduan->judul, 60) }}
                                                </h6>
                                                <span class="badge badge-sm {{ $pengaduan->status == 'ditutup' ? 'bg-gradient-secondary' : 'bg-gradient-success' }} flex-shrink-0">
                                                    {{ $pengaduan->status }}
                                                </span>
                                            </div>
                                            
                                            <!-- Info siswa (hanya untuk petugas & kepala sekolah) -->
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                            <div class="d-flex flex-wrap gap-3 mb-2">
                                                <div>
                                                    <small class="text-muted">Siswa:</small>
                                                    <div class="text-xs font-weight-bold">{{ $pengaduan->tb_siswa->nama }}</div>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Kelas:</small>
                                                    <div class="text-xs font-weight-bold">{{ $pengaduan->tb_siswa->kelas }}</div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <!-- Deskripsi pengaduan -->
                                            <div class="mb-3">
                                                <small class="text-muted">Deskripsi:</small>
                                                <div class="text-xs mb-1 p-2 bg-light rounded">
                                                    {!! Str::limit(strip_tags($pengaduan->deskripsi), 80) !!}
                                                </div>
                                            </div>
                                            
                                            <!-- Tanggal -->
                                            <div class="mb-3">
                                                <small class="text-muted">Tanggal:</small>
                                                <div class="text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm') }}
                                                </div>
                                            </div>
                                            
                                            <!-- Tombol Aksi -->
                                            <div class="d-flex flex-wrap gap-1 justify-content-end">
                                                @if (Auth::user()->role == 'siswa')
                                                    <!-- Aksi untuk siswa -->
                                                    <a href="{{ route('pengaduan.edit', $pengaduan->id_pengaduan) }}"
                                                        class="btn btn-primary btn-sm text-xs"
                                                        data-toggle="tooltip" title="Edit Pengaduan">
                                                        <i class="bi bi-pencil"></i>
                                                        <span class="d-none d-sm-inline ms-1">Edit</span>
                                                    </a>
                                                    <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                        class="btn btn-warning btn-sm text-xs">
                                                        <i class="bi bi-eye"></i>
                                                        <span class="d-none d-sm-inline ms-1">Detail</span>
                                                    </a>
                                                    <a href="{{ route('admin.pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                                        class="btn btn-danger btn-sm text-xs"
                                                        data-confirm-delete="true">
                                                        <i class="bi bi-trash"></i>
                                                        <span class="d-none d-sm-inline ms-1">Hapus</span>
                                                    </a>
                                                    @if ($pengaduan->status != 'ditutup')
                                                        <form
                                                            action="{{ url('pengaduan/selesai/' . $pengaduan->id_pengaduan) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm text-xs">
                                                                <i class="bi bi-check-circle"></i>
                                                                <span class="d-none d-sm-inline ms-1">Selesai</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <!-- Aksi untuk petugas & kepala sekolah -->
                                                    <a href="{{ route('admin.pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                        class="btn btn-warning btn-sm text-xs">
                                                        <i class="bi bi-eye"></i>
                                                        <span class="d-none d-sm-inline ms-1">Detail</span>
                                                    </a>
                                                @endif
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
            const deleteButtons = document.querySelectorAll('a[data-confirm-delete="true"]');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');
                    
                    if (confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')) {
                        // Buat form untuk submit
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection