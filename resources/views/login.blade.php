<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERU | Login</title>
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
            max-width: 1100px; /* lebih lebar */
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .login-form {
            flex: 1;
            padding: 70px 60px; /* lebih lega */
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
            padding: 14px 18px; /* lebih besar */
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
            font-size: 34px; /* lebih besar */
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Example@gmail.com"
                        required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="At least 8 characters" required>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <a href="#" class="text-decoration-none small">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-dark">Sign in</button>
            </form>

            <div class="text-center mt-4 text-muted">
                Don't you have an account?
                <a href="{{ route('register') }}">Sign up</a>
            </div>
        </div>

        <div class="illustration">
            <img src="{{ asset('images/vector.PNG') }}" alt="Illustration">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
