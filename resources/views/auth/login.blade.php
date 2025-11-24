<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Selamat Datang Di Aplikasi Sistem Informasi Koperasi</title>
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

        .header-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            z-index: 9999;
            background-color: #129990;
            color: white;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .header-bar span:first-child {
            font-weight: 700;
            font-size: 16px;
        }

        .header-bar span:last-child {
            font-style: italic;
            font-size: 14px;
            opacity: 0.95;
        }

        .login-container {
            display: flex;
            position: fixed;
            top: 50px;
            left: 0;
            width: 100%;
            height: calc(100vh - 50px);
        }

        .login-image {
            width: 66.66%;
            background-color: #129990;
            position: relative;
            overflow: hidden;
            display: block;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></svg>');
            background-size: 50px 50px;
            opacity: 0.3;
        }

        .login-image-content {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(18, 153, 144, 0.75);
            z-index: 1;
        }

        .login-form-container {
            width: 33.34%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: white;
            overflow-y: auto;
            max-height: calc(100vh - 50px);
        }

        .login-card {
            width: 100%;
            max-width: 360px;
        }

        .login-card .card-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .login-card .logo-wrapper {
            display: inline-block;
            padding: 12px;
            background-color: #129990;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(18, 153, 144, 0.25);
        }

        .login-card .logo-wrapper img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .login-card .card-body {
            padding: 0;
        }

        .login-card h6 {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: center;
        }

        .login-card p {
            font-size: 14px;
            color: #718096;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 11px 13px;
            font-size: 14px;
            transition: all 0.3s ease;
            margin-bottom: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #129990;
            box-shadow: 0 0 0 3px rgba(18, 153, 144, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #cbd5e0;
        }

        label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .forgot-password-link {
            color: #129990;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #0d6b63;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 11px;
            background-color: #129990;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(18, 153, 144, 0.25);
        }

        .btn-login:hover {
            background-color: #0d6b63;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(18, 153, 144, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: center;
        }

        .alert-danger {
            background-color: #fed7d7;
            color: #742a2a;
            border: 1px solid #fc8181;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: center;
        }

        .card-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            text-align: center;
            margin-top: 20px;
        }

        .card-footer p {
            font-size: 12px;
            color: #a0aec0;
            margin: 0;
        }

        .checkbox-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 10px;
        }

        .checkbox-wrapper label {
            margin-bottom: 0;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .checkbox-wrapper input[type="checkbox"] {
            margin-right: 6px;
            cursor: pointer;
            accent-color: #129990;
        }

        @media (max-width: 768px) {
            .login-image {
                display: none;
                width: 0;
            }

            .login-form-container {
                width: 100%;
                max-height: calc(100vh - 50px);
            }

            .login-card {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="header-bar">
        <span>{{ $kec->nama_lembaga_long }}</span>
        <span class="efek-ketik">{{ $kec->nama_kec }}</span>
    </div>

    <main class="login-container">
        <!-- Form Section (1/3) - Left -->
        <div class="login-form-container">
            <div class="login-card">
                <div class="card-header">
                    <div class="logo-wrapper">
                        <img src="../../../{{ $logo }}" alt="logo" />
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    @if (session('status'))
                        <div class="alert-success">{{ session('status') }}</div>
                    @endif
                    @error('message')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h6>Selamat Datang</h6>
                <p>Masuk ke Sistem Koperasi Anda</p>

                <form method="POST" action="/login">
                    @csrf
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Masukkan username Anda" autocomplete="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Masukkan password Anda" autocomplete="current-password" required>
                    </div>
                    <div class="checkbox-wrapper">
                        <label>
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                        <a href="javascript:void(0);" id="forgotPasswordLink" class="forgot-password-link">Lupa password?</a>
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <div class="card-footer">
                    <p>© 2024 Sistem Informasi Koperasi</p>
                </div>
            </div>
        </div>

        <!-- Image Section (2/3) - Right -->
        <div class="login-image">
            <div class="image-overlay"></div>
            <div class="login-image-content" style="background-image: url('../assets/img/image-sign-in.jpg')">
                <div style="position: relative; z-index: 3; text-align: center; color: white; padding: 40px;">
                    <i class="fas fa-lock" style="font-size: 60px; margin-bottom: 20px; display: block;"></i>
                    <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 15px; color: white;">Keamanan Terjamin</h2>
                    <p style="font-size: 14px; max-width: 300px; line-height: 1.6; margin: 0 auto; color: rgba(255,255,255,0.95);">Akses aman dan terpercaya untuk mengelola data koperasi Anda dengan enkripsi tingkat enterprise.</p>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>

    <script>
        if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
                damping: '0.5'
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const forgotLink = document.getElementById('forgotPasswordLink');
            if (forgotLink) {
                forgotLink.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Lupa Password?',
                        text: 'Silakan hubungi tim teknikal support untuk reset akun Anda.',
                        icon: 'info',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#129990'
                    });
                });
            }
        });
    </script>
    @if (session('pesan'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.style.top = '60px';
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: @json(session('pesan'))
                });
            });
        </script>
    @endif
</body>

</html>
