<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
        <link rel="Shortcut icon" href = "{{ asset('images/logo_eppk.png') }}"alt="">
        <link rel="stylesheet" href="{{  asset('css/register.css') }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@500;700&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrasi - CVIndahCemerlang</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2><i class="fas fa-user-plus"></i> Registrasi</h2>
            <form>
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" id="name" placeholder="Masukkan nama lengkap">
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" placeholder="Masukkan password">
                </div>
                <div class="form-group">
                    <label for="confirm-password"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                    <input type="password" id="confirm-password" placeholder="Konfirmasi password">
                </div>
                <button type="submit" class="btn"><i class="fas fa-user-plus"></i> Daftar</button>
            </form>
            <div class="login-link">
                <p>Sudah punya akun? <a href="/">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
