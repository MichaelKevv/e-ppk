@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Feedback</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Feedback</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    @if (Auth::user()->role == 'kepala_sekolah')
                        <a href="{{ url('export/feedback') }}" target="_blank"><button class="btn btn-success">Export PDF</button></a>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                @endif
                                <th>Judul Pengaduan</th>
                                <th>Feedback</th>
                                <th>Petugas</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $feedback)
                                <tr>
                                    @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                        <td>{{ $feedback->tb_siswa->nama }}</td>
                                        <td>{{ $feedback->tb_siswa->kelas }}</td>
                                        <td>{{ $feedback->tb_siswa->jurusan }}</td>
                                    @endif
                                    <td>{!! Str::limit($feedback->tb_pengaduan->judul, 50) !!}</td>
                                    <td>{!! Str::limit($feedback->teks_tanggapan, 50) !!}</td>
                                    <td>{{ $feedback->tb_petuga->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('feedback.show', $feedback->id_tanggapan) }}"
                                            class="btn btn-warning font-weight-bold text-xs">
                                            Detail
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
