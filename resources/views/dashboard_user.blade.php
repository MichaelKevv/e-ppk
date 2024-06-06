@extends('template_user')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                    <div data-aos="zoom-out">
                        <h1>Merasa Lebih Lega bersama <span>E-PPK</span></h1>
                        <h2>Kami adalah tim pengaduan untuk semua masalah mu!</h2>
                        <div class="text-center text-lg-start">
                            <a href="{{ url('login') }}" class="btn-get-started scrollto">Adukan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                    <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/1.jpg') }}" class="img-fluid" alt="">
                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/2.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/3.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/4.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/5.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/6.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('img/sekolah/7.jpg') }}" class="img-fluid" alt="">

                                </div>
                            </div><!-- End testimonial item -->

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
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

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 " data-aos="fade-right">
                    <img src="{{ asset('images/kepsek.JPG') }}" alt=""
                        class="img-fluid">
                </div>

                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"
                    data-aos="fade-left">
                    <h3>Sambutan Kepala Sekolah</h3>
                    <p data-aos="zoom-in" data-aos-delay="100">Selamat datang di website pengaduan perundungan siswa SMP
                        Negeri 2 Bantaran Satu Atap Kabupaten
                        Probolinggo. Kami sangat bangga memperkenalkan platform ini sebagai bagian dari komitmen kami
                        untuk menciptakan lingkungan sekolah yang aman dan nyaman bagi seluruh siswa. Melalui website
                        ini, kami berharap setiap siswa yang mengalami atau menyaksikan perundungan dapat melaporkannya
                        dengan mudah dan aman. Setiap laporan akan ditangani dengan serius untuk memastikan
                        kesejahteraan seluruh siswa.</p>
                    <p data-aos="zoom-in" data-aos-delay="100">
                        Kami juga menyediakan berbagai informasi dan sumber daya untuk membantu siswa memahami dan
                        menangani perundungan. Kami berharap dengan adanya website ini, kita semua dapat bekerja sama
                        menciptakan budaya sekolah yang positif dan bebas dari perundungan. Terima kasih atas dukungan
                        dan partisipasi Anda dalam mewujudkan lingkungan sekolah yang lebih baik.
                    </p>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Beberapa Layanan yang Kami Tawarkan</p>
            </div>

            <div class="row" data-aos="fade-left">
                <div class="col-lg-4 col-md-4">
                    <div class="icon-box feature-item" data-feature="pengaduan" data-aos="zoom-in" data-aos-delay="50">
                        <i class="bi bi-briefcase icon" style="color: #ffbb2c;"></i>
                        <h3><a href="javascript:void(0);">Pengaduan</a></h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box feature-item" data-feature="feedback" data-aos="zoom-in" data-aos-delay="100">
                        <i class="bi bi-chat-left-dots icon" style="color: #5578ff;"></i>
                        <h3><a href="javascript:void(0);">Feedback</a></h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mt-4 mt-md-0">
                    <div class="icon-box feature-item" data-feature="artikel" data-aos="zoom-in" data-aos-delay="150">
                        <i class="bi bi-activity icon" style="color: #e80368;"></i>
                        <h3><a href="javascript:void(0);">Artikel</a></h3>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Gallery</h2>
                <p>Check our Gallery</p>
            </div>

            <div class="col-lg-12 order-1 order-lg-2" data-aos="zoom-out" data-aos-delay="300">
                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/1.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/2.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/3.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/4.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/5.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/6.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ asset('img/sekolah/7.jpg') }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- End testimonial item -->
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

        </div>
    </section><!-- End Gallery Section -->
@endsection
