@extends('admin.layouts.template')
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
                    <div class="card shadow-sm border-0" style="border-radius: 10px;">
                        <div class="card-body">
                            <form action="{{ route('admin.feedback.store', $pengaduan->id_pengaduan) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="judul_pengaduan" class="form-label fw-semibold">Judul Pengaduan</label>
                                                <input type="text" id="judul_pengaduan" class="form-control shadow-sm"
                                                    value="{{ $judul_pengaduan }}" name="judul" readonly
                                                    style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px;">
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label for="feedback-textarea" class="form-label fw-semibold">Feedback</label>
                                                <textarea id="feedback-textarea" class="form-control shadow-sm" name="teks_tanggapan"
                                                    placeholder="Tuliskan feedback Anda di sini..." rows="6"
                                                    style="border: 1.5px solid #ced4da; border-radius: 8px; transition: all 0.3s ease;"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                                <i class="bi bi-send-fill me-2"></i>Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        #feedback-textarea:hover {
            border-color: #80bdff;
        }

        #feedback-textarea:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
            outline: none;
        }
    </style>
@endsection
