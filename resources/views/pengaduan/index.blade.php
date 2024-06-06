@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pengaduan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Pengaduan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    @if (Auth::user()->role == 'siswa')
                        <a href="{{ url('pengaduan/create') }}"><button class="btn btn-success">Tambah Data</button></a>
                    @elseif (Auth::user()->role == 'kepala_sekolah')
                        <a href="{{ url('export/pengaduan') }}" target="_blank"><button class="btn btn-success">Export PDF</button></a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                @endif
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $pengaduan)
                                <tr>
                                    @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                        <td>{{ $pengaduan->tb_siswa->nama }}</td>
                                        <td>{{ $pengaduan->tb_siswa->kelas }}</td>
                                    @endif
                                    <td>{{ $pengaduan->judul }}</td>
                                    <td>{!! Str::limit($pengaduan->deskripsi, 50) !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                    </td>
                                    <td>{{ $pengaduan->status }}</td>
                                    <td>
                                        @if (Auth::user()->role == 'siswa')
                                            <a href="{{ route('pengaduan.edit', $pengaduan->id_pengaduan) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit Pengaduan">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                class="btn btn-warning font-weight-bold text-xs">
                                                Detail
                                            </a>
                                            <a href="{{ route('pengaduan.destroy', $pengaduan->id_pengaduan) }}"
                                                class="btn btn-danger font-weight-bold text-xs" data-confirm-delete="true">
                                                Delete
                                            </a>
                                        @else
                                            <a href="{{ route('pengaduan.show', $pengaduan->id_pengaduan) }}"
                                                class="btn btn-warning font-weight-bold text-xs">
                                                Detail
                                            </a>
                                        @endif
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
