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
                </div>
            </div>
        </div>
    </div>
@endsection
