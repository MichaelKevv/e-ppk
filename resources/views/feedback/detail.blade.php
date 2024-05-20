@extends('template')
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
                        <div class="card-content">
                            <div class="card-header">
                                <h5>{{ $pengaduan->judul }}</h5>
                            </div>
                            <div class="card-body">
                                <strong>Feedback :</strong>
                                {!! $pengaduan->deskripsi !!}
                                <strong>Feedback :</strong>
                                {!! $feedback->teks_tanggapan !!}
                                Tanggal Feedback :
                                <strong>{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('D MMMM YYYY HH:mm:ss') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
