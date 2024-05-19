@extends('template_user')
@section('content')
    <div class="page-title" data-aos="fade">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $data->judul }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">Article</li>
                </ol>
            </nav>
        </div>
    </div>
    <section id="portfolio-details" class="portfolio-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-12">
                    <img src="{{ url('storage/foto-artikel/' . $data->gambar) }}">
                </div>

                <div class="col-lg-12">
                    <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                        <h2>{{ $data->judul }}</h2>
                        {!! $data->konten !!}
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Portfolio Details Section -->
@endsection
