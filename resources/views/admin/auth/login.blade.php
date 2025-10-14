<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Admin - Sistem Informasi Koperasi</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />

    <style>
        body {
            background: url("{{ asset('assets/img/image-sign-in.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }

        .login-card {
            backdrop-filter: blur(8px);
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            padding: 2rem;
            color: white;
        }

        .login-card label {
            color: #f0f0f0;
        }

        .login-card .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
        }

        .login-card .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
</head>

<body>
    <main class="main-content d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="login-card shadow-lg">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/apple-icon.png') }}" alt="logo"
                                class="rounded-circle mb-3" style="width: 90px; height: 90px; object-fit: cover;">
                            <h4 class="fw-bold">Login Admin</h4>
                            <p class="text-sm opacity-8">Sistem Informasi Koperasi</p>
                        </div>

                        @if (session('status'))
                            <div class="mb-3 font-medium text-sm text-success">{{ session('status') }}</div>
                        @endif
                        @error('message')
                            <div class="alert alert-danger text-sm" role="alert">{{ $message }}</div>
                        @enderror

                        <form method="POST" action="/admin/login">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username"
                                    class="form-control form-control-lg" placeholder="Masukkan username admin"
                                    autocomplete="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg" placeholder="Masukkan password"
                                    autocomplete="current-password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="javascript:void(0);" id="forgotPasswordLink"
                                    class="text-sm text-warning">Lupa password?</a>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger w-100 mt-2">Masuk Admin</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-light">© 2025 Sistem Informasi Koperasi - Admin</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const forgotLink = document.getElementById('forgotPasswordLink');
            if (forgotLink) {
                forgotLink.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Reset Password Admin',
                        text: 'Silakan hubungi super-admin untuk reset akun Anda.',
                        icon: 'warning',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#d33'
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
