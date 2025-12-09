<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Safeschool - Student Complaiment</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="Shortcut icon" href = "{{ asset('images/logo_eppk.png') }}"alt="">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('front/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('front/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header"
        class="fixed-top d-flex align-items-center {{ Request::is('/') ? 'header-transparent' : '' }}">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ asset('images/Logo (1).png') }}" alt=""
                        class="img-fluid" width="100" style="max-height: 100px!important"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link text-dark fw-bold" href="{{ url('/') }}" class="">Beranda</a></li>
                    <li><a class="nav-link text-dark fw-bold" href="{{route('artikel.semua')}}">Edukasi</a></li>
                    <li><a class="nav-link text-dark fw-bold" href="{{ url('kontak-petugas') }}">Kontak</a></li>
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
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Safeschool</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('front/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('front/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('front/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: '{{ session('warning') }}',
                confirmButtonColor: '#f1c40f',
            });
        </script>
    @endif

    <!-- Template Main JS File -->
    <script src="{{ asset('front/js/main.js') }}"></script>
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
