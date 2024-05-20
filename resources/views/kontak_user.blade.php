@extends('template_user')
@section('content')
    <section id="team" class="team section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kontak Petugas</h2>
            <p>Dibawah ini adalah kontak dari Petugas kami</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">
                @foreach ($data as $petugas)
                    <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <img src="{{ url('storage/foto-petugas/' . $petugas->foto) }}" class="img-fluid" alt="">
                            <div class="member-info">
                                <div class="member-info-content">
                                    <h4>{{ $petugas->nama }}</h4>
                                </div>
                                <div class="social">
                                    <a href="http://wa.me/{{ substr_replace($petugas->no_telp, '62', 0, 1) }}" target="_blank">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                @endforeach


            </div>

        </div>

    </section>
@endsection
