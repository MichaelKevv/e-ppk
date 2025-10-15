@extends('template_user')
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
                    @foreach ($data as $petugas)
                        <div class="col-lg-3 col-md-6">
                            <div class="member" data-aos="zoom-in" data-aos-delay="100">
                                <div class="pic"><img src="{{ url('storage/foto-petugas/' . $petugas->foto) }}"
                                        class="img-fluid" alt="">
                                </div>
                                <div class="member-info">
                                    <h4>{{ $petugas->nama }}</h4>
                                    <div class="social">
                                        <a href="http://wa.me/{{ substr_replace($petugas->no_telp, '62', 0, 1) }}"
                                            target="_blank">
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
