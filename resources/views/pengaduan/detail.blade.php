@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Pengaduan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('pengaduan') }}">Data Pengaduan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Pengaduan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h5>{{ $pengaduan->judul }}</h5>
                            </div>
                            <div class="card-body">
                                {!! $pengaduan->deskripsi !!}
                                @if ($pengaduan->foto)
                                    <p>Foto Pengaduan</p>
                                    <img src="{{ url('storage/foto-pengaduan/' . $pengaduan->foto) }}" width="500px"
                                        class="mb-3">
                                @endif
                                <p>Tanggal Pengaduan :
                                    <strong>{{ \Carbon\Carbon::parse($pengaduan->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</strong>
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    @if (Auth::user()->role == 'petugas' && $pengaduan->status != 'ditutup')
                                        <a href="{{ url('feedback/create/' . $pengaduan->id_pengaduan) }}" class="me-2">
                                            <button class="btn btn-success">Tambahkan Feedback</button>

                                        </a>
                                    @endif
                                    @if (Auth::user()->role == 'petugas' || Auth::user()->role == 'kepala_sekolah')
                                        <a href="{{ url('export/single/pengaduan/' . $pengaduan->id_pengaduan) }}"
                                            target="_blank"><button class="btn btn-success">Export Pengaduan</button></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
