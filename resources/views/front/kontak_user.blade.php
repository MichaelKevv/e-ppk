@extends('front.layouts.template')
@section('content')
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2></h2>
                <ol>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li>Kontak Petugas</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs Section -->
    <section class="inner-page portfolio section">
        <div class="container section-title">
            <h2>Kontak Petugas</h2>
        </div>
        <!-- ======= Team Section ======= -->
        <section id="team" class="team" style="padding-top: 0!important">
            <div class="container">
                <div class="row" data-aos="fade-left">
                    @foreach ($petugas as $petugasItem) {{-- Changed variable name to avoid conflict --}}
                        <div class="col-lg-3 col-md-6">
                            <div class="member" data-aos="zoom-in" data-aos-delay="100">
                                <div class="pic">
                                    @if($petugasItem->foto)
                                        <img src="{{ url('storage/foto-petugas/' . $petugasItem->foto) }}" class="img-fluid" alt="{{ $petugasItem->nama }}">
                                    @else
                                        <img src="{{ url('assets/img/default-profile.png') }}" class="img-fluid" alt="{{ $petugasItem->nama }}">
                                    @endif
                                </div>
                                <div class="member-info">
                                    <h4>{{ $petugasItem->nama }}</h4>
                                    <span>{{ $petugasItem->no_telp }}</span>
                                    <div class="social">
                                        <a href="http://wa.me/{{ substr_replace($petugasItem->no_telp, '62', 0, 1) }}" target="_blank">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section><!-- End Team Section -->
    </section>
@endsection