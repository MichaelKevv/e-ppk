@extends('front.layouts.auth')

@section('title', 'Login - SAFESCHOOL')
@section('content')
<div class="login-container">
    <div class="login-form">
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo-new.png') }}" alt=""
                        class="img-fluid" width=200>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    placeholder="Masukkan email anda" required autofocus>
            </div>

            <div class="mb-4 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Masukkan password anda" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
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
@endsection

@push('scripts')
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
function togglePassword() {
    const passwordField = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
</script>
@endpush
@push('styles')
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

    .toggle-password {
        cursor: pointer;
        position: absolute;
        right: 20px;
        top: 52%;
        font-size: 20px;
        color: #888;
    }
</style>
@endpush
