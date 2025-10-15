@extends('front.template')
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

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
            </g>
        </svg>

    </section><!-- End Hero -->

    <!-- ======= Articles Section ======= -->
    <section id="articles" class="features">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Education</h2>
                <p>Top Articles</p>
            </div>

            <div class="row" data-aos="fade-left">
                @php
                    $articles = [
                        [
                            'title' => 'Cara Mengatasi Perundungan di Sekolah',
                            'excerpt' => 'Pelajari langkah-langkah sederhana untuk menghadapi dan melaporkan perundungan.',
                            'image' => 'images/article1.jpg',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Pentingnya Berani Bicara',
                            'excerpt' => 'Mengapa suara kamu sangat berarti dalam menciptakan lingkungan yang aman.',
                            'image' => 'images/article2.jpg',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Tips Mendukung Teman yang Terkena Bullying',
                            'excerpt' => 'Bagaimana cara membantu teman yang menjadi korban perundungan.',
                            'image' => 'images/article3.jpg',
                            'url' => '#'
                        ],
                    ];
                @endphp

                @foreach($articles as $article)
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset($article['image']) }}" class="card-img-top" alt="{{ $article['title'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article['title'] }}</h5>
                                <p class="card-text">{{ $article['excerpt'] }}</p>
                                <a href="{{ $article['url'] }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section><!-- End Articles Section -->
@endsection
