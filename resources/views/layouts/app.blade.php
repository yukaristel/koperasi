<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title ?? 'SiKopii' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">

    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <style>
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
        }

        .modal-custom-height {
            height: 90vh;
            max-height: 90vh;
        }

        .modal-custom-height .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .modal-custom-height .modal-body {
            flex: 1 1 auto;
            overflow-y: auto;
        }

        .modal-header,
        .modal-footer {
            z-index: 1;
        }

        .bg-primary,
        .btn-success,
        .btn-outline-primary:hover,
        .btn-outline-primary.active,
        .nav-pills .nav-link.active,
        .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link,
        .dataTables_wrapper .dataTables_paginate .pagination .page-item .page-link:hover {
            background-color: #129990 !important;
            color: #fff !important;
            border-color: #129990 !important;
        }

        .bg-primary h5,
        .text-primary,
        .btn-outline-primary,
        .btn-outline-primary:disabled,
        .btn-outline-primary.disabled,
        .dataTables_wrapper .dataTables_paginate .pagination .page-link {
            color: #129990 !important;
            border-color: #129990 !important;
        }

        .btn-outline-primary {
            background-color: transparent !important;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #129990 !important;
            box-shadow: 0 0 8px 2px rgba(18, 153, 144, 0.6) !important;
        }

        .dataTable,
        .dataTable thead th,
        .dataTable tbody td {
            font-size: 0.8rem !important;
        }

        .dataTables_length select {
            height: 38px;
            padding: 6px 12px;
            font-size: 14px;
            width: 80px;
            margin: 0 5px;
        }

        .dataTables_length label {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .modal-open .select2-dropdown {
            z-index: 10060 !important;
        }

        .modal-open .select2-close-mask {
            z-index: 10055 !important;
        }

        .hover tbody tr:hover {
            background-color: #f0fff8;
            cursor: pointer;
        }

        .text-black {
            color: #333 !important;
        }

        .badge-github {
            background-color: #e0e0e0;
            color: #000;
        }

        .sidenav {
            z-index: 1040 !important;
        }
    </style>



    @yield('style')
</head>

<body class="g-sidenav-show bg-gray-100">
    <x-app.sidebar />
    <div class="main-content">
        <x-app.navbar />
        <div class="container-fluid py-3 px-3">@yield('content')</div>
        @yield('modal')
    </div>

    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2"><i class="fa fa-cog py-2"></i></a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Corporate UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button"><i
                            class="fa fa-close"></i></button>
                </div>
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
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
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                    <div class="d-flex">
                        <button class="btn bg-gradient-primary w-100 px-3 mb-2 active" data-class="bg-slate-900"
                            onclick="sidebarType(this)">Dark</button>
                        <button class="btn bg-gradient-primary w-100 px-3 mb-2 ms-2" data-class="bg-white"
                            onclick="sidebarType(this)">White</button>
                    </div>
                    <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                </div>
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-dark w-100" target="_blank"
                    href="https://www.creative-tim.com/product/corporate-ui-dashboard-laravel">Free Download</a>
                <a class="btn btn-outline-dark w-100" target="_blank"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/installation-guide/corporate-ui-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" target="_blank"
                        href="https://github.com/creativetimofficial/corporate-ui-dashboard-laravel"
                        data-icon="octicon-star" data-size="large" data-show-count="true">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Corporate%20UI%20Dashboard..."
                        class="btn btn-dark mb-0 me-2" target="_blank"><i class="fab fa-twitter me-1"></i> Tweet</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/corporate-ui-dashboard-laravel"
                        class="btn btn-dark mb-0 me-2" target="_blank"><i class="fab fa-facebook-square me-1"></i>
                        Share</a>
                </div>
            </div>
        </div>
    </div>

    @stack('modal')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi TinyMCE
            tinymce.init({
                selector: '.tiny-mce-editor',
                height: 300,
                menubar: false,
                plugins: 'table visualblocks fullscreen link code',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright | table link fullscreen code | removeformat',
                font_family_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace;',
                branding: false,
                tinycomments_mode: 'embedded',
                tinycomments_author: 'ARAFII'
            });

            // Tombol Simpan
            $(document).on('click', '#simpanTtdPelaporan', function(e) {
                e.preventDefault();

                tinymce.triggerSave(); // Sinkronisasi isi editor ke textarea

                const form = $('#formTtdPelaporan');

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(result) {
                        if (result.success) {
                            Toastr('success', result.msg);
                        } else {
                            Toastr('error', 'Gagal menyimpan.');
                        }
                    },
                    error: function() {
                        Toastr('error', 'Terjadi kesalahan pada server.');
                    }
                });
            });
        });

        // Fungsi Toastr Custom (pakai Swal.fire Toast)
        function Toastr(icon, text) {
            const font = "1.2rem Nimrod MT";
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");
            context.font = font;
            const width = context.measureText(text).width;
            const formattedWidth = Math.ceil(width) + 100;

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: text,
                width: formattedWidth
            });
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tinymce.init({
            selector: '.tiny-mce-editor',
            plugins: 'table visualblocks fullscreen',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align | table fullscreen | removeformat',
            font_family_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace;',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'ARAFII'
        });

        if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), {
                damping: '0.5'
            });
        }

        toastr.options = {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            progressBar: true,
            timeOut: 3000
        };

        $(".keuangan").maskMoney({
            allowNegative: true
        });
    </script>

    @yield('script')
</body>

</html>
