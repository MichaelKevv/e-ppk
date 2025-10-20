@extends('admin.layouts.template')
@section('title', 'Feedback')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
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
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Data Feedback</h6>
                        @if (Auth::user()->role == 'kepala_sekolah')
                        <a href="{{ url('export/feedback') }}" target="_blank" class="btn btn-success btn-sm me-3">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <span class="d-none d-md-inline">Export PDF</span>
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
                                    @forelse ($data as $feedback)
                                    <tr>
                                        @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    {{ optional($feedback->pengaduan->siswa ?? null)->nama ?? '-' }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs text-secondary mb-0">{{ optional($feedback->pengaduan->siswa ?? null)->kelas ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-xs text-secondary mb-0">{{ optional($feedback->pengaduan->siswa ?? null)->jurusan ?? '-' }}</span>
                                        </td>
                                        @endif

                                        <td>
                                            <span class="text-xs font-weight-bold mb-0">
                                                {{ Str::limit($feedback->judul_pengaduan ?? '-', 70) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span
                                                class="text-xs font-weight-bold mb-0">{!! Str::limit($feedback->isi_tanggapan, 60) !!}</span>
                                        </td>

                                        <td>
                                            <span
                                                class="text-xs font-weight-bold mb-0">{{ optional($feedback->user)->username ?? '-' }}</span>
                                        </td>

                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm') }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-row gap-1">
                                                <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
                                                    class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                    Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <em>Tidak ada data feedback</em>
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
                            @forelse ($data as $feedback)
                            <div class="col-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <h6 class="mb-2 text-sm font-weight-bold text-primary">
                                                {{ Str::limit($feedback->judul_pengaduan ?? '-', 100) }}
                                            </h6>

                                            @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                <div>
                                                    <small class="text-muted">Siswa:</small>
                                                    <div class="text-xs font-weight-bold">
                                                        {{ optional($feedback->pengaduan->siswa ?? null)->nama ?? '-' }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Kelas:</small>
                                                    <div class="text-xs font-weight-bold">
                                                        {{ optional($feedback->pengaduan->siswa ?? null)->kelas ?? '-' }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Jurusan:</small>
                                                    <div class="text-xs font-weight-bold">
                                                        {{ optional($feedback->pengaduan->siswa ?? null)->jurusan ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">Feedback:</small>
                                            <div class="text-xs mb-1 p-2 bg-light rounded">
                                                {!! Str::limit($feedback->isi_tanggapan, 100) !!}
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">Petugas:</small>
                                                <span
                                                    class="text-xs font-weight-bold">{{ optional($feedback->user)->username ?? '-' }}</span>
                                            </div>

                                            <div class="d-flex flex-column text-end">
                                                <small class="text-muted">Tanggal:</small>
                                                <span class="text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMM YYYY') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}"
                                                class="btn btn-warning btn-sm font-weight-bold text-xs">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center text-muted py-3">
                                <em>Tidak ada data feedback</em>
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
