@extends('admin.layouts.template')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Artikel</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Artikel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.artikel.create') }}">
                    <button class="btn btn-success">Tambah Artikel</button>
                </a>
                @if (Auth::user()->role == 'kepala_sekolah')
                <a href="{{ url('export/artikel') }}" target="_blank"><button class="btn btn-success">Export PDF</button></a>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Kategori</th>
                            <th>Tanggal Upload</th>
                            <th>Author</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $artikel)
                        <tr>
                            <td>
                                <img src="{{ url('storage/foto-artikel/' . $artikel->gambar) }}" width="100px">
                            </td>
                            <td>{{ $artikel->judul }}</td>
                            <td>{!! $artikel->konten !!}</td>
                            <td>{{ $artikel->kategori }}</td>
                            <td>{{ \Carbon\Carbon::parse($artikel->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                            </td>
                            <td>{{ $artikel->author }}</td>
                            <td>
                                <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}"
                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                    data-original-title="Edit Artikel">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <a href="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}"
                                    class="btn btn-danger font-weight-bold text-xs" data-confirm-delete="true">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection