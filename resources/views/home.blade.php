<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMP Islam Parung - Portal Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* background-color: #f8f9fa; */
            /* background-image: url('/assets/img/login/v960-ning-31.jpg'); */
            background-image: url('/assets/img/login/smpislamparungg.jpg');
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .btn-login {
            padding: 10px 0;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login i {
            margin-right: 10px;
            /* Jarak antara ikon dan teks */
        }
    </style>
</head>

<body>
    <div class="login-container text-center">
        <img src="/assets/img/login/logo-smpislamparung.png" alt="SMP Islam Parung Logo" class="logo">
        <h2 class="mb-3">Sistem Presensi Guru</h2>
        <p class="text-muted mb-4">SMP Islam Parung</p>

        <div class="d-grid gap-3">
            <a href="{{ route('login.guru') }}" class="btn btn-primary btn-login">
                <i class="fas fa-user"></i> <span>Login Guru</span>
            </a>
            <a href="{{ route('login.administrator') }}" class="btn btn-secondary btn-login">
                <i class="fas fa-user-cog"></i> <span>Login Administrator</span>
            </a>
        </div>

        <p class="mt-4 mb-0 text-muted small">© 2024 SMP Islam Parung</p>
    </div>

    <!-- Bootstrap 5 JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
