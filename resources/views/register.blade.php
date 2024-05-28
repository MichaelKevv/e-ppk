<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PPK</title>

    <link rel="Shortcut icon" href = "{{ asset('images/logo_eppk.png') }}"alt="">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/table-datatable.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('compiled/css/auth.css') }}">

</head>

<body>
    <script src="{{ asset('static/js/initTheme.js') }}"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-4 d-none d-lg-block">
                <div id="auth-right" class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center">
                        <img src="{{ asset('images/logo_eppk.png') }}" alt="Logo">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div id="auth-left">
                    <h1 class="auth-title">Register.</h1>
                    <p class="auth-subtitle mb-5">Silakan register untuk mendapatkan akses</p>

                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group position-relative mb-4">
                            <input type="text" name="nama" class="form-control " placeholder="Nama Lengkap"
                                required>
                        </div>
                        <div class="form-group position-relative mb-4">
                            <input type="text" name="alamat" class="form-control " placeholder="Alamat" required>
                        </div>
                        <div class="form-group position-relative mb-4">
                            <input type="text" name="no_telp" class="form-control " placeholder="Nomor Telepon / WA"
                                required>
                        </div>
                        <div class="form-group mb-4">
                            <select class="form-control" name="gender" id="gender">
                                <option value="" selected>Pilih Gender</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email-id-vertical">Kelas</label>
                                <select class="form-control" name="kelas" id="kelas">
                                    <option value="" selected>Pilih Kelas</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group position-relative  mb-4">
                            <input type="text" name="username" class="form-control " placeholder="Username" required>
                        </div>
                        <div class="form-group position-relative  mb-4">
                            <input type="text" name="email" class="form-control " placeholder="Email" required>
                        </div>
                        <div class="form-group position-relative  mb-4">
                            <input type="password" name="password" class="form-control " placeholder="Password"
                                required>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email-id-vertical">Foto</label>
                                <input type="file" id="email-id-vertical" class="form-control" name="foto"
                                    required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Submit</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script src="{{ asset('static/js/components/dark.js') }}"></script>
    <script src="{{ asset('extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('compiled/js/app.js') }}"></script>

    @include('sweetalert::alert')

    <!-- Need: Apexcharts -->
    <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('static/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('static/js/pages/simple-datatables.js') }}"></script>

</body>

</html>
