@extends('template')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Beri Feedback</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('pengaduan') }}">Data Feedback</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Beri Feedback</li>
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
                            <div class="card-body">
                                <form class="form form-vertical"
                                    action="{{ route('feedback.store', $pengaduan->id_pengaduan) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Judul Pengaduan</label>
                                                    <input type="text" id="email-id-vertical" class="form-control"
                                                        value="{{ $pengaduan->judul }}" name="judul" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="feedback-textarea">Feedback</label>
                                                    <textarea id="feedback-textarea" data-purpose="feedback" class="form-control" name="teks_tanggapan">
                                                    </textarea>
                                                </div>
                                            </div>
                                            {{-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Status</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="" disabled>Pilih Status</option>
                                                        <option value="terbuka"
                                                            {{ $pengaduan->status == 'terbuka' ? 'selected' : '' }}>Terbuka
                                                        </option>
                                                        <option value="diproses"
                                                            {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses
                                                        </option>
                                                        <option value="ditutup"
                                                            {{ $pengaduan->status == 'ditutup' ? 'selected' : '' }}>Ditutup
                                                        </option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
