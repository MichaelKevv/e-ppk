@extends('template_user')
@section('content')
    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Artikel Mental Health</h2>
            <p>Dibawah ini adalah rekomendasi Edukasi untuk Kesehatan Mentalmu!</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-mental">Mental</li>
                    <li data-filter=".filter-stress">Stress</li>
                    <li data-filter=".filter-anxiety">Anxiety</li>
                    <li data-filter=".filter-therapy">Therapy</li>
                    <li data-filter=".filter-selfcare">Selfcare</li>
                    <li data-filter=".filter-relationships">Relationships</li>
                </ul>

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

                    @foreach ($data as $artikel)
                        <div
                            class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ strtolower($artikel->kategori) }}">
                            <div class="portfolio-content h-100">
                                <img src="{{ url('storage/foto-artikel/' . $artikel->gambar) }}" class="img-fluid"
                                    alt="">
                                <div class="portfolio-info">
                                    <h4>{{ $artikel->kategori }}</h4>
                                    <p>{{ Str::limit($artikel->judul, 50) }}</p>
                                    <a href="{{ url('storage/foto-artikel/' . $artikel->gambar) }}"
                                        title="{{ $artikel->judul }}"
                                        data-gallery="portfolio-gallery-{{ strtolower($artikel->kategori) }}"
                                        class="glightbox preview-link">
                                        <i class="bi bi-zoom-in"></i></a>
                                    <a href="{{ url('article_detail/' . $artikel->id_artikel) }}" title="More Details"
                                        class="details-link">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div><!-- End Portfolio Item -->
                    @endforeach

                </div><!-- End Portfolio Container -->

            </div>

        </div>

    </section><!-- /Portfolio Section -->
@endsection
