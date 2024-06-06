@extends('template_user')
@section('content')
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2></h2>
                <ol>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li>Artikel</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page portfolio section">
        <div class="container section-title" data-aos="fade-up" data-aos-delay="100">
            <h2>Artikel Mental Health</h2>
        </div>

        <div class="container mt-3">
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
                <div class="row gy-4 mt-3 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($data as $artikel)
                        <div
                            class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ strtolower($artikel->kategori) }}">
                            <div class="portfolio-content h-100">
                                <a href="{{ url('article_detail/' . $artikel->id_artikel) }}" title="More Details">
                                    <img src="{{ url('storage/foto-artikel/' . $artikel->gambar) }}" class="img-fluid"
                                        alt="">
                                    <div class="portfolio-info">
                                        <h4 class="bg-primary">{{ $artikel->kategori }}</h4>
                                        <p class="px-2">{{ Str::limit($artikel->judul, 50) }}</p>
                                    </div>
                                </a>
                            </div>
                        </div><!-- End Portfolio Item -->
                    @endforeach
                </div><!-- End Portfolio Container -->
            </div>
        </div>
    </section>
@endsection
