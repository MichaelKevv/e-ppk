@extends('admin.layouts.template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Feedback</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('feedback') }}">Data Feedback</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Feedback</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $feedback->judul_pengaduan ?? 'Tanpa Judul' }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Pengaduan:</label>
                                <p class="text-muted">{!! $feedback->pengaduan->deskripsi ?? '-' !!}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Feedback:</label>
                                <p class="text-muted">{!! $feedback->isi_tanggapan ?? '-' !!}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pemberi Feedback:</label>
                                    <p>{{ $feedback->nama_pengirim ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Feedback:</label>
                                    <p>{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
