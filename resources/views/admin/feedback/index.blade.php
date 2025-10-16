@extends('admin.layouts.template')
@section('title', 'Feedback')
@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Feedback</li>
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
                            <h6 class="text-white text-capitalize ps-3">Data Feedback</h6>
                            @if (Auth::user()->role == 'kepala_sekolah')
                                <a href="{{ url('export/feedback') }}" target="_blank" class="btn btn-success btn-sm me-3">
                                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Siswa</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kelas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Jurusan</th>
                                        @endif
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Judul Pengaduan</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Feedback</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Petugas</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $feedback)
                                        <tr>
                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $feedback->tb_siswa->nama }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-xs text-secondary mb-0">{{ $feedback->tb_siswa->kelas }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-xs text-secondary mb-0">{{ $feedback->tb_siswa->jurusan }}</span>
                                                </td>
                                            @endif
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{{ Str::limit($feedback->tb_pengaduan->judul, 30) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{!! Str::limit($feedback->teks_tanggapan, 50) !!}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold mb-0">{{ $feedback->tb_petuga->nama }}</span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-row gap-1">
                                                    <a href="{{ route('admin.feedback.show', $feedback->id_tanggapan) }}"
                                                        class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                        Detail
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