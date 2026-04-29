<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        table.table tr td, table.table tr th { vertical-align: middle; }

        .custom-tabs {
            background: #fff;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .custom-tab:hover { color: #344767; }
        .custom-tab.active {
            color: #fff;
            background: linear-gradient(310deg, #2152ff, #21d4fd);
            box-shadow: 0 4px 20px 0 rgba(0,0,0,0.14), 0 7px 10px -5px rgba(33,82,255,0.4);
        }
        .custom-tab .material-icons { font-size: 20px; }

        .tab-content-custom { display: none; animation: fadeIn 0.4s ease-in; }
        .tab-content-custom.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .loading-spinner { text-align: center; padding: 40px; color: #67748e; }
        .loading-spinner .spinner-border { width: 3rem; height: 3rem; }

        /* ── Progress Overlay ─────────────────────────────────── */
        #gen-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        #gen-overlay.show { display: flex; }

        #gen-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px 52px;
            min-width: 380px;
            text-align: center;
            box-shadow: 0 24px 64px rgba(0,0,0,0.3);
        }
        .gen-icon-wrap {
            width: 68px; height: 68px;
            border-radius: 50%;
            background: linear-gradient(310deg, #2152ff, #21d4fd);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            transition: background 0.4s;
        }
        #gen-box.done  .gen-icon-wrap { background: linear-gradient(310deg, #17ad37, #98ec2d); }
        #gen-box.error .gen-icon-wrap { background: linear-gradient(310deg, #f5365c, #f56036); }
        .gen-icon-wrap .material-icons { color: #fff; font-size: 34px; }

        #gen-title  { font-size: 1.15rem; font-weight: 700; color: #344767; margin-bottom: 6px; }
        #gen-status { font-size: 0.88rem; color: #67748e; margin-bottom: 20px; min-height: 24px; }

        .gen-bar-wrap {
            background: #e9ecef;
            border-radius: 8px;
            height: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        #gen-bar {
            height: 100%;
            width: 5%;
            background: linear-gradient(90deg, #2152ff, #21d4fd);
            border-radius: 8px;
            transition: width 0.35s ease;
        }
        #gen-count { font-size: 0.82rem; color: #adb5bd; }
    </style>
</head>

<body>
<main class="main-content mt-3">
    <section class="container">

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

        <div class="tab-content-custom active" id="tab-individu">
            <div class="card">
                <div class="card-body" id="StructureIndividu">
                    <div class="loading-spinner">
                        <div class="spinner-border text-info" role="status"></div>
                        <div class="mt-3">Memuat data individu...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content-custom" id="tab-kelompok">
            <div class="card">
                <div class="card-body" id="StructureKelompok">
                    <div class="loading-spinner">
                        <div class="spinner-border text-info" role="status"></div>
                        <div class="mt-3">Memuat data kelompok...</div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

<!-- Progress Overlay -->
<div id="gen-overlay">
    <div id="gen-box">
        <div class="gen-icon-wrap">
            <span class="material-icons" id="gen-icon">sync</span>
        </div>
        <div id="gen-title">Sedang Generate...</div>
        <div id="gen-status">Mempersiapkan data</div>
        <div class="gen-bar-wrap">
            <div id="gen-bar"></div>
        </div>
        <div id="gen-count">–</div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/assets/js/material-dashboard.min.js"></script>
<script src="/assets/js/plugins/sweetalert.min.js"></script>

<script>
// ── Setup CSRF untuk semua AJAX ──────────────────────────────────────────────
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// ── Load partials ────────────────────────────────────────────────────────────
$(document).ready(function () {
    $.get('/generate/individu', function (r) {
        $('#StructureIndividu').html(r.view);
    }).fail(function () {
        $('#StructureIndividu').html('<div class="alert alert-danger">Gagal memuat form individu</div>');
    });

    $.get('/generate/kelompok', function (r) {
        $('#StructureKelompok').html(r.view);
    }).fail(function () {
        $('#StructureKelompok').html('<div class="alert alert-danger">Gagal memuat form kelompok</div>');
    });

    // Tab switching
    $(document).on('click', '.custom-tab', function () {
        const tab = $(this).data('tab');
        $('.custom-tab').removeClass('active');
        $(this).addClass('active');
        $('.tab-content-custom').removeClass('active');
        $('#tab-' + tab).addClass('active');
    });
});

// ── Intersep submit form generate (event delegation karena form dimuat AJAX) ─
$(document).on('submit', '.form-generate', function (e) {
    e.preventDefault();

    const formData = $(this).serializeArray();
    const LIMIT    = 30; // harus sama dengan $limit di GenerateController
    let   offset   = 0;
    let   total    = 0;

    overlayShow();

    // Konversi serializeArray ke object, tangani field array mis. status[operator]
    function buildPayload(offset) {
        const p = { offset: offset };
        formData.forEach(function (item) {
            const m = item.name.match(/^(.+)\[(.+)\]$/);
            if (m) {
                if (!p[m[1]]) p[m[1]] = {};
                p[m[1]][m[2]] = item.value;
            } else {
                p[item.name] = item.value;
            }
        });
        return p;
    }

    function doGenerate() {
        overlayStatus('Memproses batch ke-' + (Math.floor(offset / LIMIT) + 1) + '...');

        $.ajax({
            url    : '/generate/save/' + offset,
            method : 'POST',
            data   : buildPayload(offset),
            success: function (res) {
                // Controller mengembalikan JSON { count: N }
                const count = parseInt(res.count) || 0;
                total += count;
                overlayCount(total);

                if (count >= LIMIT) {
                    offset += LIMIT;
                    doGenerate(); // batch berikutnya
                } else {
                    overlayDone(total);
                }
            },
            error: function (xhr) {
                let msg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (xhr.status === 419) msg = 'Sesi expired. Silakan refresh halaman lalu coba lagi.';
                if (xhr.status === 500) {
                    const json = xhr.responseJSON;
                    msg = 'Error 500: ' + (json?.message ?? 'Internal Server Error');
                }
                overlayError(msg);
            }
        });
    }

    doGenerate();
});

// ── Overlay helpers ──────────────────────────────────────────────────────────
let _barTimer = null;
let _barVal   = 5;

function overlayShow() {
    _barVal = 5;
    clearInterval(_barTimer);
    $('#gen-box').removeClass('done error');
    $('#gen-icon').text('sync');
    $('#gen-title').text('Sedang Generate...');
    $('#gen-status').text('Mempersiapkan data...');
    $('#gen-bar').css('width', _barVal + '%');
    $('#gen-count').text('–');
    $('#gen-overlay').addClass('show');

    // Bar bergerak perlahan (indeterminate)
    _barTimer = setInterval(function () {
        if (_barVal < 88) {
            _barVal += (Math.random() * 5);
            $('#gen-bar').css('width', Math.min(_barVal, 88) + '%');
        }
    }, 400);
}

function overlayStatus(msg) { $('#gen-status').text(msg); }

function overlayCount(n) {
    $('#gen-count').text(n + ' data diproses');
}

function overlayDone(total) {
    clearInterval(_barTimer);
    $('#gen-bar').css('width', '100%');
    $('#gen-box').addClass('done');
    $('#gen-icon').text('check_circle');
    $('#gen-title').text('Generate Selesai!');
    $('#gen-status').text('Berhasil memproses ' + total + ' pinjaman.');
    $('#gen-count').text('Klik di luar kotak ini untuk menutup');
    $('#gen-overlay').one('click', function () { $(this).removeClass('show'); });
}

function overlayError(msg) {
    clearInterval(_barTimer);
    $('#gen-box').addClass('error');
    $('#gen-icon').text('error_outline');
    $('#gen-title').text('Generate Gagal');
    $('#gen-status').text(msg);
    $('#gen-count').text('Klik di luar kotak ini untuk menutup');
    $('#gen-overlay').one('click', function () { $(this).removeClass('show'); });
}
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
