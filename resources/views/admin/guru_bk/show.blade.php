@extends('admin.layouts.template')
@section('title', 'Detail Guru BK - ' . $guruBk->nama)

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" href="{{ route('admin.guru-bk.index') }}">Data Guru BK</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detail Guru BK</li>
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
                        <h6 class="text-white text-capitalize ps-3 mb-0">Detail Guru BK</h6>
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('admin.guru-bk.edit', $guruBk->nip) }}" class="btn btn-warning btn-sm">
                                <i class="material-symbols-rounded">edit</i>
                                <span class="d-none d-md-inline">Edit</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($guruBk->foto)
                                <img src="{{ asset('storage/gurubk/foto/lg/' . $guruBk->foto) }}"
                                     class="img-fluid rounded shadow-lg"
                                     alt="{{ $guruBk->nama }}"
                                     style="max-width: 300px;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded"
                                     style="width: 300px; height: 300px; margin: 0 auto;">
                                    <i class="material-symbols-rounded text-white" style="font-size: 100px;">person</i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%;" class="bg-light">NIP</th>
                                            <td>{{ $guruBk->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nama Lengkap</th>
                                            <td>{{ $guruBk->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Jenis Kelamin</th>
                                            <td>{{ $guruBk->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">No. Telepon</th>
                                            <td>{{ $guruBk->no_telp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Alamat</th>
                                            <td>{{ $guruBk->alamat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">ID Pengguna</th>
                                            <td>{{ $guruBk->id_pengguna ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Dibuat Pada</th>
                                            <td>{{ $guruBk->created_at ? $guruBk->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Diperbarui Pada</th>
                                            <td>{{ $guruBk->updated_at ? $guruBk->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.guru-bk.index') }}" class="btn btn-secondary">
                            <i class="material-symbols-rounded">arrow_back</i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
