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
</head>

<body class="">
    <div
        style="position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; background-color: #007bff; color: white; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold;">{{ $kec->nama_lembaga_long }}</span>
        <span class="efek-ketik" style="font-style: italic;">{{ $kec->nama_kec }}</span>
    </div>

    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <img class="rounded-circle" src="../../../{{ $logo }}" alt="logo"
                                        style="width: 110px; height: 110px; object-fit: cover;" />
                                </div>

                                <div class="text-center">
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-success">{{ session('status') }}</div>
                                    @endif
                                    @error('message')
                                        <div class="alert alert-danger text-sm" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card-body">
                                    <h6 class="text-center mb-2 fw-bold">Selamat Datang di Sistem Koperasi</h6>
                                    <p class="text-center text-muted mb-4">Silakan login untuk mengakses dashboard Anda
                                    </p>

                                    <form method="POST" action="/login">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control"
                                                placeholder="Masukkan username Anda" autocomplete="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Masukkan password Anda" autocomplete="current-password"
                                                required>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <a href="javascript:void(0);" id="forgotPasswordLink"
                                                class="text-sm text-primary">Lupa password?</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8"
                                    style="background-image:url('../assets/img/image-sign-in.jpg')">
                                    <div
                                        class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                                        <h6 class="text-dark text-sm mt-1">Copyright © 2022 Corporate UI Design System
                                            by Creative Tim.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                        confirmButtonColor: '#3085d6'
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
