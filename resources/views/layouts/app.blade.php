<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title itemprop="name">
        {{ $title ? $title : 'SiKopii' }}
    </title>
    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    
    <style>
        .modal-open .select2-dropdown {
            z-index: 10060;
        }

        .modal-open .select2-close-mask {
            z-index: 10055;
        }
        .modal-open .select2-close-mask {
            z-index: 10055;
        }
        .bg-primary {
            background-color: #129990 !important;
        }
        .text-primary {
            color: #129990 !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #129990 !important;
            box-shadow: 0 0 8px 2px rgba(18, 153, 144, 0.6) !important;

        }
        .text-black {
            color: #333333 !important;
        }
         
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @php
        $topSidenavArray = ['wallet', 'profile'];
        $topSidenavTransparent = ['signin', 'signup'];
        $topSidenavRTL = ['RTL'];
    @endphp
    @if (in_array(request()->route()->getName(),
            $topSidenavArray))
        <x-sidenav-top />
    @elseif(in_array(request()->route()->getName(),
            $topSidenavTransparent))

    @elseif(in_array(request()->route()->getName(),
            $topSidenavRTL))
    @else
        <x-app.sidebar />
    @endif
    
    <div class="main-content">
        <x-app.navbar />
        @yield('content')
    </div>

    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"></i>
        </a>
        <div class="card shadow-lg ">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Corporate UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active" data-class="bg-slate-900"
                        onclick="sidebarType(this)">Dark</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-dark w-100" target="_blank"
                    href="https://www.creative-tim.com/product/corporate-ui-dashboard-laravel">Free Download</a>
                <a class="btn btn-outline-dark w-100" target="_blank"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/installation-guide/corporate-ui-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" target="_blank" href="https://github.com/creativetimofficial/corporate-ui-dashboard-laravel"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/corporate-ui-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Corporate%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%26%20%40UPDIVISION%20%23webdesign%20%23dashboard%20%23bootstrap5%20%23laravel&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fcorporate-ui-dashboard-laravel"
                    class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/corporate-ui-dashboard-laravel"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    @yield('modal')
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
    <script>
        tinymce.init({
            selector: '.tiny-mce-editor',
            plugins: 'table visualblocks fullscreen',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align | table fullscreen | removeformat',
            font_family_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace;',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'ARAFII'
        });

        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        function Toastr(icon, text) {
            font = "1.2rem Nimrod MT";

            canvas = document.createElement("canvas");
            context = canvas.getContext("2d");
            context.font = font;
            width = context.measureText(text).width;
            formattedWidth = Math.ceil(width) + 100;

            Toast.fire({
                icon: icon,
                title: text,
                width: formattedWidth
            })
        }

        function MultiToast(icon, text) {
            font = "1.2rem Nimrod MT";

            canvas = document.createElement("canvas");
            context = canvas.getContext("2d");
            context.font = font;
            width = context.measureText(text).width;
            formattedWidth = Math.ceil(width) + 100;

            let MultiToast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            MultiToast.fire({
                icon: icon,
                title: text,
                width: formattedWidth
            })
        }
    </script>
        @yield('script')
</body>

</html>
