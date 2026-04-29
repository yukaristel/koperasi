<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Jembatan Akuntabilitas Koperasi">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Enfii">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ $logo }}">
    <link rel="icon" type="image/png" href="{{ $logo }}">
    <title>GENERATE &mdash; SI Koperasi Online</title>

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="/assets/css/material-dashboard.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/style.css">

    <style>
        table.table tr td,
        table.table tr th {
            vertical-align: middle;
        }

        .custom-tabs {
            position: relative;
            background: #fff;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
        }

        .custom-tab {
            flex: 1;
            text-align: center;
            padding: 12px 24px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #67748e;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .custom-tab:hover {
            color: #344767;
        }

        .custom-tab.active {
            color: #fff;
            background: linear-gradient(310deg, #2152ff, #21d4fd);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(33, 82, 255, 0.4);
        }

        .custom-tab .material-icons {
            font-size: 20px;
        }

        .tab-content-custom {
            display: none;
            animation: fadeIn 0.4s ease-in;
        }

        .tab-content-custom.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .loading-spinner {
            text-align: center;
            padding: 40px;
            color: #67748e;
        }

        .loading-spinner .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    <main class="main-content mt-3">
        <section class="container">

            <!-- Tab Individu / Kelompok -->
            <div class="custom-tabs">
                <div class="custom-tab active" data-tab="individu">
                    <span class="material-icons">person</span>
                    <span>Individu</span>
                </div>
                <div class="custom-tab" data-tab="kelompok">
                    <span class="material-icons">groups</span>
                    <span>Kelompok</span>
                </div>
            </div>

            <!-- Tab Individu -->
            <div class="tab-content-custom active" id="tab-individu">
                <div class="card">
                    <div class="card-body" id="StructureIndividu">
                        <div class="loading-spinner">
                            <div class="spinner-border text-info" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-3">Memuat data individu...</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Kelompok -->
            <div class="tab-content-custom" id="tab-kelompok">
                <div class="card">
                    <div class="card-body" id="StructureKelompok">
                        <div class="loading-spinner">
                            <div class="spinner-border text-info" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-3">Memuat data kelompok...</div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/material-dashboard.min.js"></script>
    <script src="/assets/js/plugins/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {

            // Load partials via AJAX
            $.get('/generate/individu', function (result) {
                $('#StructureIndividu').html(result.view);
            }).fail(function () {
                $('#StructureIndividu').html('<div class="alert alert-danger">Gagal memuat data individu</div>');
            });

            $.get('/generate/kelompok', function (result) {
                $('#StructureKelompok').html(result.view);
            }).fail(function () {
                $('#StructureKelompok').html('<div class="alert alert-danger">Gagal memuat data kelompok</div>');
            });

            // Tab switching
            $('.custom-tab').on('click', function () {
                const tabName = $(this).data('tab');
                $('.custom-tab').removeClass('active');
                $(this).addClass('active');
                $('.tab-content-custom').removeClass('active');
                $('#tab-' + tabName).addClass('active');
            });
        });
    </script>

    <script>
        if (localStorage.getItem('devops') !== 'true') {
            $(document).bind("contextmenu", function (e) { return false; });
            $(document).keydown(function (event) {
                if (event.keyCode == 123) return false;
                if (event.ctrlKey && event.shiftKey && event.keyCode == 73) return false;
                if (event.ctrlKey && event.shiftKey && event.keyCode == 67) return false;
                if (event.ctrlKey && event.shiftKey && event.keyCode == 74) return false;
            });
        }
    </script>
</body>

</html>
