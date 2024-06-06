@extends('template_user')
@section('content')
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2></h2>
                <ol>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/showarticle') }}">Artikel</a></li>
                    <li>{{ $data->judul }}</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page portfolio section">
        <div class="container section-title" style="padding-bottom: 0!important" data-aos="fade-up" data-aos-delay="100">
            <h2>Artikel Mental Health</h2>
            <p>{{ $data->judul }}</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <p>{{ $data->author }} - {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM YYYY') }}</p>
            <div class="col-lg-12 d-flex justify-content-center">
                <img src="{{ url('storage/foto-artikel/' . $data->gambar) }}" class="img-fluid mb-4" width="50%">
            </div>
            {!! $data->konten !!}
        </div>
    </section>
@endsection
