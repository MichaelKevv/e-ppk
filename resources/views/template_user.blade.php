<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>E-PPK</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="Shortcut icon" href = "{{ asset('images/logo_eppk.png') }}"alt="">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('bootslander/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('bootslander/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('bootslander/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header"
        class="fixed-top d-flex align-items-center {{ Request::is('/') ? 'header-transparent' : '' }}">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo_black.PNG') }}" alt=""
                        class="img-fluid" width="100" style="max-height: 100px!important"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link text-dark fw-bold" href="{{ url('/') }}" class="">Beranda</a>
                    </li>
                    <li><a class="nav-link text-dark fw-bold" href="{{ url('showarticle') }}">Edukasi</a></li>
                    <li><a class="nav-link text-dark fw-bold" href="{{ url('kontak') }}">Kontak</a></li>
                    @if (Auth::check() && session('userdata'))
                        <li>
                            <a class="nav-link text-dark fw-bold" href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li>
                            <a class="nav-link text-dark fw-bold" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                    <li>
                        <a href="" class="btn-header">
                            <button class="btn btn-outline-dark fw-bold">Daftar</button>
                        </a>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <main id="main">

        @yield('content')

    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                            <a href="{{ url('/') }}" class="">
                                <img src="{{ asset('images/logo_eppk.png') }}" alt="" width="100"
                                    class="mb-4">
                            </a>
                            <p>Jl. Tugu Pancasila Desa Kedungrejo Kec. Bantaran</p>
                            <p>Kabupaten Probolinggo, Jawa Timur 67261</p>
                            <p class="mt-3"><strong>Phone:</strong> <span>+6281216494265</span></p>
                            <p><strong>Email:</strong> <span>smpn2bantaran@gmail.com</span></p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>E-PPK</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                {{-- <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('bootslander/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('bootslander/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('bootslander/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bootslander/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('bootslander/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('bootslander/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('bootslander/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toCapitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
            const featureDescriptions = {
                'pengaduan': 'Siswa dapat melakukan pengaduan tentang permasalahan mereka',
                'feedback': 'Kami berkomitmen memberikan feedback yang terbaik untuk siswa',
                'artikel': 'Kami memberikan artikel tentang Mental Health'
            };

            document.querySelectorAll('.feature-item').forEach(item => {
                item.addEventListener('click', function() {
                    const feature = this.getAttribute('data-feature');
                    Swal.fire({
                        title: toCapitalize(feature),
                        text: featureDescriptions[feature],
                        icon: 'info',
                        confirmButtonText: 'Close'
                    });
                });
            });
        });
    </script>

</body>

</html>
