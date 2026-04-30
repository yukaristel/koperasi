<!DOCTYPE html>
<html lang="id" translate="no">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ $logo }}">
    <title>Generate — SI Koperasi</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #0f1117;
            min-height: 100vh;
            color: #e2e8f0;
        }

        /* ── Header ──────────────────────────────── */
        .header-bar {
            position: fixed; top: 0; left: 0; width: 100%; height: 50px;
            z-index: 9999; background: #1a1d2e; color: #a78bfa;
            padding: 0 24px; display: flex;
            justify-content: space-between; align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.4);
            border-bottom: 1px solid rgba(167,139,250,0.15);
        }
        .header-bar .left { display: flex; align-items: center; gap: 10px; }
        .dev-badge {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
            color: #fff; font-size: 10px; font-weight: 700;
            padding: 3px 8px; border-radius: 4px;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .header-bar .title   { font-weight: 700; font-size: 15px; color: #e2e8f0; }
        .header-bar .kec-name { font-size: 13px; opacity: 0.7; color: #a78bfa; }

        /* ── Layout ──────────────────────────────── */
        .main-content {
            padding-top: 70px; padding-bottom: 40px;
            max-width: 1100px; margin: 0 auto;
            padding-left: 24px; padding-right: 24px;
        }

        /* ── Page title ──────────────────────────── */
        .page-title { margin-bottom: 24px; }
        .page-title h2 { font-size: 19px; font-weight: 700; color: #e2e8f0; margin-bottom: 4px; }
        .page-title h2 i { color: #a78bfa; margin-right: 8px; }
        .page-title p { font-size: 13px; color: #64748b; }

        /* ── Tabs ─────────────────────────────────── */
        .tab-bar { display: flex; gap: 8px; margin-bottom: 20px; }
        .tab-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 22px; border-radius: 8px;
            border: 1px solid #2d3148; background: #1a1d2e;
            color: #64748b; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.25s ease; font-family: inherit;
        }
        .tab-btn:hover { border-color: #7c3aed; color: #a78bfa; }
        .tab-btn.active {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
            border-color: transparent; color: #fff;
            box-shadow: 0 4px 16px rgba(124,58,237,0.35);
        }

        .tab-pane { display: none; }
        .tab-pane.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        /* ── Card ─────────────────────────────────── */
        .card { background: #1a1d2e; border: 1px solid #2d3148; border-radius: 12px; overflow: hidden; }
        .card-body { padding: 24px; }

        /* ── Loading ──────────────────────────────── */
        .loading-state { text-align: center; padding: 50px 20px; color: #64748b; }
        .spin-ring {
            width: 36px; height: 36px;
            border: 3px solid #2d3148; border-top-color: #a78bfa;
            border-radius: 50%; animation: spin 0.8s linear infinite;
            margin: 0 auto 14px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Table ─────────────────────────────────── */
        table { width: 100%; border-collapse: collapse; }
        thead tr th {
            background: #12141f; color: #a78bfa;
            font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
            padding: 10px 14px; text-align: left;
            border-bottom: 1px solid #2d3148;
        }
        tbody tr { border-bottom: 1px solid #1e2235; }
        tbody tr:hover { background: rgba(167,139,250,0.04); }
        tbody tr td { padding: 9px 14px; font-size: 13px; color: #cbd5e1; }
        tbody tr td b { color: #e2e8f0; font-weight: 600; }
        tbody tr td small { color: #64748b; font-size: 11px; display: block; margin-top: 2px; }

        select.form-control, input.form-control {
            background: #12141f; border: 1px solid #2d3148;
            color: #e2e8f0; border-radius: 6px;
            padding: 6px 10px; font-size: 12px; width: 100%;
            outline: none; transition: border-color 0.2s; font-family: inherit;
        }
        select.form-control:focus, input.form-control:focus { border-color: #7c3aed; }
        option { background: #1a1d2e; }

        /* ── Submit button ─────────────────────────── */
        .btn-generate {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
            color: #fff; border: none; border-radius: 8px;
            padding: 10px 26px; font-size: 13px; font-weight: 700;
            cursor: pointer; transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(124,58,237,0.35);
            margin-top: 16px; font-family: inherit;
        }
        .btn-generate:hover { box-shadow: 0 6px 20px rgba(124,58,237,0.5); transform: translateY(-1px); }
        .btn-generate:active { transform: translateY(0); }

        /* ── Progress Overlay ──────────────────────── */
        #gen-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.75); z-index: 99999;
            align-items: center; justify-content: center;
        }
        #gen-overlay.show { display: flex; }

        #gen-box {
            background: #1a1d2e; border: 1px solid #2d3148;
            border-radius: 16px; padding: 40px 52px;
            min-width: 420px; max-width: 90vw; text-align: center;
            box-shadow: 0 24px 64px rgba(0,0,0,0.7);
            position: relative; overflow: hidden;
        }
        /* Top accent line */
        #gen-box::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #7c3aed, #a78bfa);
            transition: background 0.4s;
        }
        #gen-box.done::before  { background: linear-gradient(90deg, #17ad37, #4ade80); }
        #gen-box.error::before { background: linear-gradient(90deg, #dc2626, #f87171); }

        .gen-icon-wrap {
            width: 68px; height: 68px; border-radius: 50%;
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; transition: background 0.4s;
        }
        #gen-box.done  .gen-icon-wrap { background: linear-gradient(135deg, #17ad37, #4ade80); }
        #gen-box.error .gen-icon-wrap { background: linear-gradient(135deg, #dc2626, #f87171); }
        .gen-icon-wrap i { color: #fff; font-size: 30px; }

        #gen-title  { font-size: 18px; font-weight: 700; color: #e2e8f0; margin-bottom: 6px; }
        #gen-status { font-size: 13px; color: #94a3b8; margin-bottom: 22px; min-height: 22px; line-height: 1.5; }

        .gen-bar-wrap { background: #12141f; border-radius: 8px; height: 8px; overflow: hidden; margin-bottom: 10px; }
        #gen-bar {
            height: 100%; width: 5%;
            background: linear-gradient(90deg, #7c3aed, #a78bfa);
            border-radius: 8px; transition: width 0.35s ease;
        }
        #gen-box.done  #gen-bar { background: linear-gradient(90deg, #17ad37, #4ade80); }
        #gen-box.error #gen-bar { background: linear-gradient(90deg, #dc2626, #f87171); width: 100%; }

        #gen-count { font-size: 12px; color: #475569; margin-bottom: 4px; }

        /* Error detail */
        #gen-error-detail {
            display: none; margin-top: 14px;
            background: #12141f;
            border: 1px solid rgba(220,38,38,0.3);
            border-radius: 8px; padding: 12px 14px;
            text-align: left; font-size: 11px; color: #fca5a5;
            font-family: 'Courier New', monospace;
            max-height: 150px; overflow-y: auto; word-break: break-all;
        }
        #gen-error-detail.show { display: block; }

        .close-hint {
            display: none; margin-top: 18px;
            font-size: 12px; color: #475569; cursor: pointer; transition: color 0.2s;
        }
        .close-hint:hover { color: #a78bfa; }

        /* ── Footer ────────────────────────────────── */
        .page-footer { text-align: center; margin-top: 40px; font-size: 11px; color: #2d3148; }
    </style>
</head>

<body>

    <div class="header-bar">
        <div class="left">
            <span class="dev-badge"><i class="fas fa-code"></i> DEV</span>
            <span class="title">Generate Angsuran Pinjaman</span>
        </div>
        <span class="kec-name">SI Koperasi Online</span>
    </div>

    <div class="main-content">

        <div class="page-title">
            <h2><i class="fas fa-terminal"></i> Generate Rencana &amp; Real Angsuran</h2>
            <p>Gunakan filter di bawah untuk memilih pinjaman yang akan di-generate. Biarkan semua value kosong untuk generate seluruh data.</p>
        </div>

        <div class="tab-bar">
            <button class="tab-btn active" data-tab="individu">
                <i class="fas fa-user"></i> Individu
            </button>
            <button class="tab-btn" data-tab="kelompok">
                <i class="fas fa-users"></i> Kelompok
            </button>
        </div>

        <div class="tab-pane active" id="tab-individu">
            <div class="card">
                <div class="card-body" id="StructureIndividu">
                    <div class="loading-state">
                        <div class="spin-ring"></div>
                        <div>Memuat struktur tabel individu...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab-kelompok">
            <div class="card">
                <div class="card-body" id="StructureKelompok">
                    <div class="loading-state">
                        <div class="spin-ring"></div>
                        <div>Memuat struktur tabel kelompok...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-footer">&copy; {{ date('Y') }} Developer Tools &mdash; Sistem Informasi Koperasi</div>
    </div>

    <!-- Progress Overlay -->
    <div id="gen-overlay">
        <div id="gen-box">
            <div class="gen-icon-wrap">
                <i class="fas fa-sync-alt" id="gen-icon" style="animation:spin 1s linear infinite;"></i>
            </div>
            <div id="gen-title">Sedang Generate...</div>
            <div id="gen-status">Mempersiapkan data...</div>
            <div class="gen-bar-wrap"><div id="gen-bar"></div></div>
            <div id="gen-count">–</div>
            <div id="gen-error-detail"></div>
            <div class="close-hint" id="gen-close-hint">
                <i class="fas fa-times-circle"></i> Klik di sini untuk menutup
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script>
    // ── CSRF ───────────────────────────────────────────────────────────────
    $.ajaxSetup({
        headers  : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        xhrFields: { withCredentials: true }
    });

    // ── Load partials ──────────────────────────────────────────────────────
    $(document).ready(function () {
        $.get('/generate/individu', function (r) {
            $('#StructureIndividu').html(r.view);
        }).fail(function (xhr) {
            $('#StructureIndividu').html(errBox('Gagal memuat form individu', xhr));
        });

        $.get('/generate/kelompok', function (r) {
            $('#StructureKelompok').html(r.view);
        }).fail(function (xhr) {
            $('#StructureKelompok').html(errBox('Gagal memuat form kelompok', xhr));
        });

        $(document).on('click', '.tab-btn', function () {
            const tab = $(this).data('tab');
            $('.tab-btn').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#tab-' + tab).addClass('active');
        });
    });

    function errBox(msg, xhr) {
        const code = xhr ? ' (HTTP ' + xhr.status + ')' : '';
        return '<div style="color:#f87171;padding:20px 0;font-size:13px;">'
             + '<i class="fas fa-exclamation-circle"></i> ' + msg + code + '</div>';
    }

    // ── Generate via AJAX ──────────────────────────────────────────────────
    $(document).on('submit', '.form-generate', function (e) {
        e.preventDefault();

        const formData = $(this).serializeArray();
        const LIMIT    = 30;
        let   offset   = 0;
        let   total    = 0;

        overlayShow();

        function buildPayload(off) {
            const p = { offset: off };
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
            overlayStatus('Memproses batch ke-' + (Math.floor(offset / LIMIT) + 1)
                        + '&nbsp;&mdash;&nbsp;offset ' + offset);

            $.ajax({
                url    : '/generate/save/' + offset,
                method : 'POST',
                data   : buildPayload(offset),
                timeout: 120000,

                success: function (res) {
                    if (typeof res !== 'object' || res === null) {
                        overlayError('Response tidak valid dari server.', String(res).substring(0, 300));
                        return;
                    }
                    if (res.error) {
                        overlayError(res.error, res.detail ?? '');
                        return;
                    }

                    const count = parseInt(res.count) || 0;
                    total += count;
                    overlayCount(total);

                    if (count >= LIMIT) {
                        offset += LIMIT;
                        setTimeout(doGenerate, 120);
                    } else {
                        overlayDone(total);
                    }
                },

                error: function (xhr, textStatus, errorThrown) {
                    let msg = '', detail = '';

                    if (textStatus === 'timeout') {
                        msg    = 'Request timeout — server terlalu lama merespons.';
                        detail = 'Coba filter data lebih spesifik, misal per status atau per jenis_pp.';

                    } else if (xhr.status === 0) {
                        msg    = 'Tidak dapat terhubung ke server.';
                        detail = 'Periksa koneksi internet atau pastikan server Laravel berjalan.';

                    } else if (xhr.status === 419) {
                        msg    = 'CSRF token expired.';
                        detail = 'Refresh halaman (F5) lalu coba generate ulang.';

                    } else if (xhr.status === 422) {
                        const j = safeJson(xhr.responseText);
                        msg    = j?.error   ?? 'Data tidak valid (422).';
                        detail = j?.detail  ?? '';

                    } else if (xhr.status === 500) {
                        const j = safeJson(xhr.responseText);
                        msg    = 'Internal Server Error (500)';
                        detail = j?.message
                               ?? j?.error
                               ?? extractTitle(xhr.responseText)
                               ?? errorThrown
                               ?? 'Tidak ada detail.';

                    } else if (xhr.status === 503) {
                        msg    = 'Server sedang maintenance (503).';
                        detail = 'Coba beberapa saat lagi.';

                    } else {
                        msg    = 'HTTP Error ' + xhr.status + ': ' + (errorThrown || textStatus);
                        detail = xhr.responseText
                               ? xhr.responseText.replace(/<[^>]+>/g, ' ').substring(0, 400).trim()
                               : '';
                    }

                    overlayError(msg, detail);
                }
            });
        }

        doGenerate();
    });

    // ── Helpers ────────────────────────────────────────────────────────────
    function safeJson(str) {
        try { return JSON.parse(str); } catch (e) { return null; }
    }
    function extractTitle(html) {
        if (!html) return null;
        const m = html.match(/<title[^>]*>([^<]+)<\/title>/i);
        return m ? m[1].trim() : null;
    }

    // ── Overlay ────────────────────────────────────────────────────────────
    let _barTimer = null, _barVal = 5;

    function overlayShow() {
        _barVal = 5;
        clearInterval(_barTimer);
        $('#gen-box').removeClass('done error');
        $('#gen-icon').attr('class','fas fa-sync-alt').css('animation','spin 1s linear infinite');
        $('#gen-title').text('Sedang Generate...');
        $('#gen-status').html('Mempersiapkan data...');
        $('#gen-bar').css('width', _barVal + '%');
        $('#gen-count').text('–');
        $('#gen-error-detail').removeClass('show').empty();
        $('#gen-close-hint').hide();
        $('#gen-overlay').addClass('show');

        _barTimer = setInterval(function () {
            if (_barVal < 85) {
                _barVal += Math.random() * 5;
                $('#gen-bar').css('width', Math.min(_barVal, 85) + '%');
            }
        }, 500);
    }

    function overlayStatus(html) { $('#gen-status').html(html); }
    function overlayCount(n)     { $('#gen-count').text(n + ' data diproses'); }

    function overlayDone(total) {
        clearInterval(_barTimer);
        $('#gen-bar').css('width','100%');
        $('#gen-box').addClass('done');
        $('#gen-icon').attr('class','fas fa-check-circle').css('animation','none');
        $('#gen-title').text('Generate Selesai!');
        $('#gen-status').text('Berhasil memproses ' + total + ' pinjaman.');
        $('#gen-count').text('Data rencana & real angsuran telah diperbarui.');
        $('#gen-close-hint').show().off('click').on('click', closeOverlay);
    }

    function overlayError(msg, detail) {
        clearInterval(_barTimer);
        $('#gen-box').addClass('error');
        $('#gen-icon').attr('class','fas fa-exclamation-circle').css('animation','none');
        $('#gen-title').text('Generate Gagal');
        $('#gen-status').text(msg);
        $('#gen-count').text('Tidak ada data yang tersimpan pada batch ini.');
        if (detail) $('#gen-error-detail').addClass('show').text(detail);
        $('#gen-close-hint').show().off('click').on('click', closeOverlay);
    }

    function closeOverlay() { $('#gen-overlay').removeClass('show'); }
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
