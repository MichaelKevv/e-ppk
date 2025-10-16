<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERU | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9ff;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 1100px;
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .login-form {
            flex: 1;
            padding: 70px 60px;
        }

        .login-form h4 {
            font-weight: 700;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .login-form .form-label {
            font-weight: 600;
        }

        .login-form .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1rem;
        }

        .login-form .btn {
            border-radius: 12px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .illustration {
            flex: 1;
            background: #f8faff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .illustration img {
            max-width: 100%;
            height: auto;
        }

        .text-muted a {
            text-decoration: none;
        }

        .brand {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .brand span {
            color: #ffb703;
        }

        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
            }

            .illustration {
                display: none;
            }

            .login-form {
                padding: 50px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="text-center mb-4">
                <h4 class="brand"><span>SI</span>PERU</h4>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus
                        value="{{ old('username') }}">
                    @error('username')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" required
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" name="kelas" id="kelas" class="form-control" required
                        value="{{ old('kelas') }}">
                    @error('kelas')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Pilih Gender</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                        value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control"
                        value="{{ old('no_telp') }}">
                    @error('no_telp')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    @error('foto')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark">Sign up</button>
            </form>

            <div class="text-center mt-4 text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>

        <div class="illustration">
            <img src="{{ asset('images/vector.PNG') }}" alt="Illustration">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                html: '{!! session('error') !!}',
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
</body>

</html>
