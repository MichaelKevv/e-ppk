@extends('front.layouts.template')

@section('content')

    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                    <div data-aos="zoom-out">
                        <h5 class="text-uppercase fw-bold" style="color: #df6c56; margin-bottom:20px!important">Berani Lapor,
                            Berani Peduli</h5>
                        <h1 class="text-uppercase" style="color: #171d4a">Suara <span style="color: #171d4a">kamu</span>
                            Penting !!!</h1>
                        <p class="" style="color: #171d4a">SIPERU hadir sebagai sistem pengaduan yang aman dan
                            mudah digunakan untuk melaporkan tindakan
                            perundungan di lingkungan sekolah. Tidak perlu takut,
                            karena perubahan dimulai dari keberanianmu bersuara.</p>
                        <div class="text-center text-lg-start">
                            <a href="{{ url('login') }}" class="btn-get-started scrollto">Lapor Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                    <img src="{{ asset('images/vector.PNG') }}" width="550px" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)"></use>
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)"></use>
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9" fill="#fff"></use>
            </g>
        </svg>
    </section>
<section id="articles" class="features">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3 section-title" data-aos="fade-up">
            <div>
                <h2>Education</h2>
                <p>Top Articles</p>
            </div>
            <div>
                <a href="{{ route('artikel.semua') }}" class="btn btn-outline-primary btn-sm">
                    Lihat Artikel Lainnya <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        @if ($articles->count() > 0)
            <div class="row" data-aos="fade-left">
                @foreach ($articles as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if ($article->gambar)
                                <img src="{{ asset('storage/artikel/gambar/md/' . $article->gambar) }}" class="card-img-top"
                                     alt="{{ $article->judul }}">
                            @else
                                <img src="{{ asset('admin/img/landscape-placeholder.svg') }}" class="card-img-top" alt="No Image">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $article->judul }}</h5>
                                <p class="card-text text-muted">{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                                <a href="{{ url('artikel/' . $article->id) }}" class="btn btn-primary btn-sm">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5" data-aos="fade-up">
                <img src="{{ asset('admin/img/landscape-placeholder.svg') }}" alt="No Articles" width="220"
                     class="mb-3 opacity-75">
                <h5 class="fw-bold text-secondary">Belum Ada Artikel</h5>
                <p class="text-muted">Artikel akan segera hadir untuk menambah wawasan dan edukasi kamu.</p>
            </div>
        @endif

    </div>
</section>
@endsection
