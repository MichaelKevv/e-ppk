<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PPK</title>

    <link rel="Shortcut icon" href = "{{ asset('images/logo_eppk.png') }}"alt="">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/table-datatable.css') }}">
</head>

<body>
    <script src="{{ asset('static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ url('dashboard') }}"><img src="{{ asset('images/logo_eppk.png') }}"
                                    alt="Logo Perusahaan" style="width: 80px; height: auto;">
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a href="{{ url('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'kepala_sekolah')
                            <li class="sidebar-item  has-sub">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-people-fill"></i>
                                    <span>Pengguna</span>
                                </a>
                                <ul class="submenu ">
                                    <li class="submenu-item  ">
                                        <a href="{{ url('siswa') }}" class="submenu-link">Siswa</a>
                                    </li>
                                    <li class="submenu-item  ">
                                        <a href="{{ url('petugas') }}" class="submenu-link">Petugas</a>
                                    </li>
                                    <li class="submenu-item  ">
                                        <a href="{{ url('kepsek') }}" class="submenu-link">Kepala Sekolah</a>
                                    </li>
                                    <li class="submenu-item  ">
                                        <a href="{{ url('pengguna') }}" class="submenu-link">Pengguna</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'petugas')
                            <li class="sidebar-item  ">
                                <a href="{{ url('artikel') }}" class='sidebar-link'>
                                    <i class="bi bi-book-fill"></i>
                                    <span>Artikel</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->role == 'siswa' || Auth::user()->role == 'kepala_sekolah' || Auth::user()->role == 'petugas')
                            <li class="sidebar-item  ">
                                <a href="{{ url('pengaduan') }}" class='sidebar-link'>
                                    <i class="bi bi-briefcase-fill"></i>
                                    <span>Pengaduan</span>
                                </a>
                            </li>
                            <li class="sidebar-item  ">
                                <a href="{{ url('feedback') }}" class='sidebar-link'>
                                    <i class="bi bi-chat-left-dots-fill"></i>
                                    <span>Feedback</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                {{-- <li class="nav-item dropdown me-1">
                                    <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-envelope bi-sub fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Mail</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-bell bi-sub fs-4"></i>
                                        <span class="badge badge-notification bg-danger">7</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                                        aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-header">
                                            <h6>Notifications</h6>
                                        </li>
                                        <li class="dropdown-item notification-item">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="notification-icon bg-primary">
                                                    <i class="bi bi-cart-check"></i>
                                                </div>
                                                <div class="notification-text ms-4">
                                                    <p class="notification-title font-bold">
                                                        Successfully check out
                                                    </p>
                                                    <p class="notification-subtitle font-thin text-sm">
                                                        Order ID #256
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="dropdown-item notification-item">
                                            <a class="d-flex align-items-center" href="#">
                                                <div class="notification-icon bg-success">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </div>
                                                <div class="notification-text ms-4">
                                                    <p class="notification-title font-bold">
                                                        Homework submitted
                                                    </p>
                                                    <p class="notification-subtitle font-thin text-sm">
                                                        Algebra math homework
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <p class="text-center py-2 mb-0">
                                                <a href="#">See all notification</a>
                                            </p>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">
                                                {{ session('userdata')->nama }}
                                            </h6>
                                            @if (Auth::check())
                                                @if (Auth::user()->role == 'kepala_sekolah')
                                                    <p class="mb-0 text-sm text-gray-600">
                                                        Kepala Sekolah
                                                    </p>
                                                @elseif (Auth::user()->role == 'petugas')
                                                    <p class="mb-0 text-sm text-gray-600">
                                                        Petugas
                                                    </p>
                                                @elseif (Auth::user()->role == 'siswa')
                                                    <p class="mb-0 text-sm text-gray-600">
                                                        Siswa
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                @if (Auth::check())
                                                    @if (Auth::user()->role == 'kepala_sekolah')
                                                        <img
                                                            src="{{ url('storage/foto-kepsek/' . session('userdata')->foto) }}" />
                                                    @elseif (Auth::user()->role == 'petugas')
                                                        <img
                                                            src="{{ url('storage/foto-petugas/' . session('userdata')->foto) }}" />
                                                    @elseif (Auth::user()->role == 'siswa')
                                                        <img
                                                            src="{{ url('storage/foto-siswa/' . session('userdata')->foto) }}" />
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                    style="min-width: 11rem">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ session('userdata')->nama }}!</h6>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="icon-mid bi bi-person me-2"></i>
                                            My Profile
                                        </a>
                                    </li> --}}
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        @if (Auth::user()->role == 'siswa')
                                            <a class="dropdown-item" href="{{ url('siswa/edit/profile/'. session('userdata')->id_siswa) }}">
                                                <i class="icon-mid bi bi-pencil me-2"></i>
                                                Edit Profile
                                            </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                @yield('content')
            </div>
        </div>

    </div>

    <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('compiled/js/app.js') }}"></script>

    @include('sweetalert::alert')

    <!-- Need: Apexcharts -->
    <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/pengaduan-data')
                .then(response => response.json())
                .then(data => {
                    const maxValue = Math.max(...data);
                    var optionsProfileVisit = {
                        annotations: {
                            position: "back",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        chart: {
                            type: "bar",
                            height: 300,
                        },
                        fill: {
                            opacity: 1,
                        },
                        plotOptions: {},
                        series: [{
                            name: "Pengaduan",
                            data: data,
                        }, ],
                        colors: "#435ebe",
                        xaxis: {
                            categories: [
                                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ],
                        },
                        yaxis: {
                            tickAmount: maxValue,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        }
                    };

                    var chartProfileVisit = new ApexCharts(
                        document.querySelector("#chart-pengaduan-siswa"),
                        optionsProfileVisit
                    );

                    chartProfileVisit.render();
                })
                .catch(error => console.error('Error fetching data:', error));
            fetch('/feedback-data')
                .then(response => response.json())
                .then(data => {
                    const maxValue = Math.max(...data);
                    var optionsProfileVisit = {
                        annotations: {
                            position: "back",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        chart: {
                            type: "bar",
                            height: 300,
                        },
                        fill: {
                            opacity: 1,
                        },
                        plotOptions: {},
                        series: [{
                            name: "Feedback",
                            data: data,
                        }, ],
                        colors: "#435ebe",
                        xaxis: {
                            categories: [
                                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ],
                        },
                        yaxis: {
                            tickAmount: maxValue,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        }
                    };

                    var chartProfileVisit = new ApexCharts(
                        document.querySelector("#chart-feedback-siswa"),
                        optionsProfileVisit
                    );

                    chartProfileVisit.render();
                })
                .catch(error => console.error('Error fetching data:', error));
            fetch('/siswa-data')
                .then(response => response.json())
                .then(data => {
                    const maxValue = Math.max(...data);
                    var optionsProfileVisit = {
                        annotations: {
                            position: "back",
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        chart: {
                            type: "bar",
                            height: 300,
                        },
                        fill: {
                            opacity: 1,
                        },
                        plotOptions: {},
                        series: [{
                            name: "Siswa",
                            data: data,
                        }, ],
                        colors: "#435ebe",
                        xaxis: {
                            categories: [
                                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ],
                        },
                        yaxis: {
                            tickAmount: maxValue,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        }
                    };

                    var chartProfileVisit = new ApexCharts(
                        document.querySelector("#chart-total-siswa"),
                        optionsProfileVisit
                    );

                    chartProfileVisit.render();
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>

    {{-- <script src="{{ asset('static/js/pages/dashboard.js') }}"></script> --}}

    <script src="{{ asset('extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('static/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('static/js/components/dark.js') }}"></script>

    <script script src="https://cdn.tiny.cloud/1/1n3f7wnxsqlud0ga3vqsndjt3zhzvf7skeun894b43byqkwk/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            // plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan URL saat ini
            var currentUrl = window.location.href;

            // Mencari setiap link di sidebar
            var sidebarItems = document.querySelectorAll('.sidebar-item a');
            sidebarItems.forEach(function(item) {
                var href = item.getAttribute('href');

                // Memeriksa apakah URL saat ini cocok dengan URL link sidebar
                if (currentUrl.includes(href)) {
                    // Menambahkan kelas active pada elemen parent dari link yang cocok
                    item.closest('.sidebar-item').classList.add('active');

                    // Jika elemen memiliki submenu, juga tambahkan kelas active pada elemen submenu-nya
                    var parentSubmenu = item.closest('.has-sub');
                    if (parentSubmenu) {
                        parentSubmenu.classList.add('active');
                    }
                }
            });
        });
    </script>


</body>

</html>
