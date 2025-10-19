@extends('admin.layouts.template')
@section('title', 'Detail Pengaduan')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.pengaduan.index') }}">Data Pengaduan</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Pengaduan</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Detail Pengaduan</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Informasi Siswa -->
                            @if (Auth::user()->role != 'siswa')
                            <div class="col-md-6">
                                <div class="card card-info mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title">Informasi Pelapor</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <th width="40%">Nama Siswa</th>
                                                <td>{{ $pengaduan->siswa->nama ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kelas</th>
                                                <td>{{ $pengaduan->siswa->kelas ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>NIS</th>
                                                <td>{{ $pengaduan->siswa->nis ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Informasi Pengaduan -->
                            <div class="{{ Auth::user()->role != 'siswa' ? 'col-md-6' : 'col-12' }}">
                                <div class="card card-primary mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title">Informasi Pengaduan</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <th width="40%">Bentuk Perundungan</th>
                                                <td>
                                                    <span class="text-capitalize">
                                                        {{ str_replace('_', ' ', $pengaduan->bentuk_perundungan) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Frekuensi Kejadian</th>
                                                <td>
                                                    <span class="text-capitalize">
                                                        {{ str_replace('_', ' ', $pengaduan->frekuensi_kejadian) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Klasifikasi</th>
                                                <td>
                                                    <span class="badge 
                                                        @if($pengaduan->klasifikasi == 'ringan') bg-success
                                                        @elseif($pengaduan->klasifikasi == 'sedang') bg-warning
                                                        @else bg-danger
                                                        @endif">
                                                        {{ $pengaduan->klasifikasi }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="badge {{ $pengaduan->status == 'ditutup' ? 'bg-secondary' : 'bg-info' }}">
                                                        {{ $pengaduan->status ?? 'diproses' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Pengaduan</th>
                                                <td>
                                                    <strong>
                                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Lengkap -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h6 class="card-title">Detail Kejadian</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Lokasi -->
                                        @if($pengaduan->lokasi)
                                        <div class="mb-3">
                                            <strong>Lokasi Kejadian:</strong>
                                            <p class="mb-0">{{ $pengaduan->lokasi }}</p>
                                        </div>
                                        @endif

                                        <!-- Kondisi Korban -->
                                        <div class="mb-3">
                                            <strong>Kondisi Korban:</strong>
                                            <div class="d-flex flex-wrap gap-3 mt-2">
                                                @if($pengaduan->trauma_mental)
                                                <span class="badge bg-danger">Trauma Mental</span>
                                                @endif
                                                @if($pengaduan->luka_fisik)
                                                <span class="badge bg-danger">Luka Fisik</span>
                                                @endif
                                                @if($pengaduan->pelaku_lebih_dari_satu)
                                                <span class="badge bg-warning">Pelaku Lebih dari Satu</span>
                                                @endif
                                                @if($pengaduan->konten_digital)
                                                <span class="badge bg-info">Ada Konten Digital</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Jenis Kata -->
                                        @if($pengaduan->jenis_kata)
                                        <div class="mb-3">
                                            <strong>Jenis Kata/Kalimat yang Digunakan:</strong>
                                            <p class="mb-0">{{ $pengaduan->jenis_kata }}</p>
                                        </div>
                                        @endif

                                        <!-- Foto Bukti -->
                                        @if ($pengaduan->foto)
                                        <div class="mb-3">
                                            <strong>Foto Bukti:</strong>
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/foto-pengaduan/' . $pengaduan->foto) }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 400px; max-width: 100%;" 
                                                     alt="Foto Bukti Pengaduan">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    @if (Auth::user()->role == 'petugas' && $pengaduan->status != 'ditutup')
                                        <a href="{{ url('feedback/create/' . $pengaduan->id_pengaduan) }}" class="btn btn-success">
                                            <i class="bi bi-chat-dots"></i> Berikan Feedback
                                        </a>
                                    @endif
                                    
                                    @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                        <a href="{{ route('pengaduan.export_single', $pengaduan->id_pengaduan) }}" 
                                           class="btn btn-primary" target="_blank">
                                            <i class="bi bi-download"></i> Export PDF
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .card-title {
            color: #344767;
            font-weight: 600;
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            color: #344767;
            background-color: #f8f9fa;
        }
        .bg-gradient-dark {
            background: linear-gradient(195deg, #42424a, #191919);
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }
        .img-thumbnail {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
    </style>
@endpush