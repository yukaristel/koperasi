<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Konfigurasi Database
$host = 'localhost';
$user = 'siupk_global';
$pass = 'siupk_global';
$db_lkm = 'siupk_lkm';
$db_koperasi = 'siupk_koperasi';

// Handle AJAX request untuk autocomplete
if (isset($_GET['action']) && $_GET['action'] == 'get_kecamatan') {
    try {
        $conn_lkm = new mysqli($host, $user, $pass, $db_lkm);
        if ($conn_lkm->connect_error) {
            throw new Exception("Koneksi gagal: " . $conn_lkm->connect_error);
        }
        $conn_lkm->set_charset("utf8");
        
        $search = isset($_GET['term']) ? $_GET['term'] : '';
        $query = "SELECT id, nama_kec FROM kecamatan WHERE nama_kec LIKE ? ORDER BY nama_kec LIMIT 20";
        $stmt = $conn_lkm->prepare($query);
        $searchTerm = "%$search%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id' => $row['id'],
                'label' => $row['nama_kec'],
                'value' => $row['nama_kec']
            );
        }
        
        $stmt->close();
        $conn_lkm->close();
        
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

// Handle AJAX request untuk migrasi dengan logging
if (isset($_POST['action']) && $_POST['action'] == 'migrate') {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    
    // Disable output buffering
    if (ob_get_level()) ob_end_clean();
    
    function sendLog($type, $message) {
        echo "data: " . json_encode(['type' => $type, 'message' => $message]) . "\n\n";
        if (ob_get_level()) ob_flush();
        flush();
    }
    
    try {
        // Koneksi ke Database
        $conn_lkm = new mysqli($host, $user, $pass, $db_lkm);
        if ($conn_lkm->connect_error) {
            throw new Exception("Koneksi LKM gagal: " . $conn_lkm->connect_error);
        }
        $conn_lkm->set_charset("utf8");
        
        $conn_koperasi = new mysqli($host, $user, $pass, $db_koperasi);
        if ($conn_koperasi->connect_error) {
            throw new Exception("Koneksi Koperasi gagal: " . $conn_koperasi->connect_error);
        }
        $conn_koperasi->set_charset("utf8");
        
        $lokasi = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : '';
        $nama_kec = isset($_POST['nama_kec']) ? $_POST['nama_kec'] : '';
        
        sendLog('info', "🚀 Memulai proses migrasi ANGGOTA untuk kecamatan: $nama_kec (ID: $lokasi)");
        
        if (empty($lokasi)) {
            throw new Exception("Lokasi tidak valid!");
        }
        
        $table_lkm = "anggota_" . intval($lokasi);
        $table_koperasi = "anggota_" . intval($lokasi);
        
        sendLog('info', "📋 Tabel LKM: $table_lkm");
        sendLog('info', "📋 Tabel Koperasi: $table_koperasi");
        
        // Cek apakah tabel ada di LKM
        $check_lkm = $conn_lkm->query("SHOW TABLES LIKE '$table_lkm'");
        if (!$check_lkm || $check_lkm->num_rows == 0) {
            throw new Exception("Tabel $table_lkm tidak ditemukan di database LKM!");
        }
        sendLog('success', "✓ Tabel LKM ditemukan");
        
        // Cek apakah tabel ada di Koperasi
        $check_kop = $conn_koperasi->query("SHOW TABLES LIKE '$table_koperasi'");
        if (!$check_kop || $check_kop->num_rows == 0) {
            throw new Exception("Tabel $table_koperasi tidak ditemukan di database Koperasi!");
        }
        sendLog('success', "✓ Tabel Koperasi ditemukan");
        
        // Mulai transaction
        $conn_koperasi->autocommit(FALSE);
        
        // Truncate tabel koperasi
        sendLog('info', "🗑️ Menghapus data lama di tabel koperasi...");
        $conn_koperasi->query("SET FOREIGN_KEY_CHECKS=0");
        if (!$conn_koperasi->query("TRUNCATE TABLE $table_koperasi")) {
            throw new Exception("Gagal truncate: " . $conn_koperasi->error);
        }
        $conn_koperasi->query("SET FOREIGN_KEY_CHECKS=1");
        sendLog('success', "✓ Data lama berhasil dihapus");
        
        // Ambil data dari LKM
        sendLog('info', "📥 Mengambil data dari tabel LKM...");
        $result_lkm = $conn_lkm->query("SELECT * FROM $table_lkm ORDER BY id");
        
        if (!$result_lkm) {
            throw new Exception("Gagal mengambil data: " . $conn_lkm->error);
        }
        
        $total = $result_lkm->num_rows;
        sendLog('success', "✓ Ditemukan $total record untuk dimigrasi");
        
        $success = 0;
        $failed = 0;
        $errors = array();
        
        // Prepare statement untuk insert
        $sql = "INSERT INTO $table_koperasi (
            id, nik, namadepan, nama_panggilan, jk, tempat_lahir, tgl_lahir, alamat, domisi,
            desa, lokasi, hp, kk, agama, pendidikan, status_pernikahan, nik_penjamin,
            penjamin, hubungan, nama_ibu, tempat_kerja, usaha, keterangan_usaha, foto,
            terdaftar, status, petugas
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn_koperasi->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement gagal: " . $conn_koperasi->error);
        }
        
        while ($row = $result_lkm->fetch_assoc()) {
            $current_id = isset($row['id']) ? $row['id'] : 'unknown';
            
            try {
                // Mapping field nama_pangilan ke nama_panggilan (perbedaan ejaan)
                $nama_panggilan = isset($row['nama_pangilan']) ? $row['nama_pangilan'] : '';
                
                // Handle keterangan_usaha (tidak ada di LKM, set NULL)
                $keterangan_usaha = NULL;
                
                // Handle foto (replace 'undefined' dengan empty string)
                $foto = isset($row['foto']) ? $row['foto'] : '';
                if ($foto == 'undefined') {
                    $foto = '';
                }
                
                // Bind parameters
                $stmt->bind_param(
                    "issssssssssssssssssssssssss",
                    $row['id'],
                    $row['nik'],
                    $row['namadepan'],
                    $nama_panggilan,
                    $row['jk'],
                    $row['tempat_lahir'],
                    $row['tgl_lahir'],
                    $row['alamat'],
                    $row['domisi'],
                    $row['desa'],
                    $row['lokasi'],
                    $row['hp'],
                    $row['kk'],
                    $row['agama'],
                    $row['pendidikan'],
                    $row['status_pernikahan'],
                    $row['nik_penjamin'],
                    $row['penjamin'],
                    $row['hubungan'],
                    $row['nama_ibu'],
                    $row['tempat_kerja'],
                    $row['usaha'],
                    $keterangan_usaha,
                    $foto,
                    $row['terdaftar'],
                    $row['status'],
                    $row['petugas']
                );
                
                if ($stmt->execute()) {
                    $success++;
                    if ($success % 10 == 0 || $success == 1) {
                        sendLog('progress', "⏳ Progress: $success/$total record berhasil dimigrasi");
                    }
                } else {
                    throw new Exception($stmt->error);
                }
                
            } catch (Exception $e) {
                $failed++;
                $error_msg = "ID $current_id (NIK: {$row['nik']}): " . $e->getMessage();
                $errors[] = $error_msg;
                if ($failed <= 5) { // Hanya tampilkan 5 error pertama
                    sendLog('warning', "⚠️ " . $error_msg);
                }
            }
        }
        
        $stmt->close();
        
        // Commit transaction
        if (!$conn_koperasi->commit()) {
            throw new Exception("Gagal commit: " . $conn_koperasi->error);
        }
        
        sendLog('info', "");
        sendLog('success', "🎉 MIGRASI SELESAI!");
        sendLog('info', "📊 Total Record: $total");
        sendLog('success', "✓ Berhasil: $success");
        if ($failed > 0) {
            sendLog('warning', "⚠️ Gagal: $failed");
            if ($failed > 5) {
                sendLog('info', "   (Menampilkan 5 error pertama saja)");
            }
        }
        sendLog('complete', json_encode(['total' => $total, 'success' => $success, 'failed' => $failed]));
        
        $conn_lkm->close();
        $conn_koperasi->close();
        
    } catch (Exception $e) {
        if (isset($conn_koperasi)) {
            $conn_koperasi->rollback();
        }
        sendLog('error', "❌ ERROR: " . $e->getMessage());
        sendLog('complete', json_encode(['error' => true, 'message' => $e->getMessage()]));
    }
    
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrasi Anggota</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 700px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        input[type="text"], input[type="hidden"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #11998e;
            box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1);
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(17, 153, 142, 0.4);
        }
        .btn:active:not(:disabled) {
            transform: translateY(0);
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .info-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 13px;
            color: #2e7d32;
        }
        .log-container {
            display: none;
            margin-top: 25px;
            background: #1e1e1e;
            border-radius: 8px;
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.3);
        }
        .log-container.active {
            display: block;
        }
        .log-entry {
            padding: 5px 0;
            border-bottom: 1px solid #333;
            animation: slideIn 0.3s ease;
        }
        .log-entry:last-child {
            border-bottom: none;
        }
        .log-info {
            color: #61dafb;
        }
        .log-success {
            color: #4caf50;
        }
        .log-warning {
            color: #ff9800;
        }
        .log-error {
            color: #f44336;
        }
        .log-progress {
            color: #9c27b0;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            z-index: 9999;
        }
        .ui-menu-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        .ui-menu-item:hover {
            background: #f8f9fa;
        }
        .progress-bar {
            display: none;
            width: 100%;
            height: 30px;
            background: #e0e0e0;
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
        }
        .progress-bar.active {
            display: block;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
            width: 0%;
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }
        .summary-box {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #4caf50;
        }
        .summary-box.active {
            display: block;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .summary-item:last-child {
            border-bottom: none;
        }
        .summary-label {
            font-weight: 600;
            color: #555;
        }
        .summary-value {
            color: #333;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👥 Migrasi Data Anggota</h1>
        <p class="subtitle">LKM → Koperasi</p>
        
        <div class="info-box">
            <strong>⚠️ Perhatian:</strong> Proses ini akan menghapus semua data anggota di tabel koperasi yang dipilih dan menggantinya dengan data dari LKM.
        </div>
        
        <form id="migrateForm">
            <div class="form-group">
                <label for="kecamatan">Pilih Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" placeholder="Ketik nama kecamatan..." autocomplete="off">
                <input type="hidden" id="lokasi_id" name="lokasi_id">
            </div>
            
            <button type="submit" class="btn" id="btnMigrate" disabled>
                Mulai Migrasi Anggota
            </button>
            
            <div class="progress-bar" id="progressBar">
                <div class="progress-fill" id="progressFill">0%</div>
            </div>
        </form>
        
        <div class="summary-box" id="summaryBox">
            <h3 style="margin-bottom: 15px; color: #333;">📊 Ringkasan Migrasi</h3>
            <div class="summary-item">
                <span class="summary-label">Total Anggota:</span>
                <span class="summary-value" id="summaryTotal">0</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Berhasil:</span>
                <span class="summary-value" style="color: #4caf50;" id="summarySuccess">0</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Gagal:</span>
                <span class="summary-value" style="color: #f44336;" id="summaryFailed">0</span>
            </div>
        </div>
        
        <div class="log-container" id="logContainer">
            <div style="color: #888; margin-bottom: 10px;">═══ LOG MIGRASI ANGGOTA ═══</div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedKecamatan = '';
            
            $("#kecamatan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: window.location.href,
                        dataType: "json",
                        data: {
                            action: 'get_kecamatan',
                            term: request.term
                        },
                        success: function(data) {
                            if (data.error) {
                                console.error(data.error);
                                response([]);
                            } else {
                                response(data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Autocomplete error:', error);
                            response([]);
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $("#lokasi_id").val(ui.item.id);
                    selectedKecamatan = ui.item.label;
                    $("#btnMigrate").prop('disabled', false);
                }
            });
            
            $("#kecamatan").on('input', function() {
                if ($(this).val() === '') {
                    $("#lokasi_id").val('');
                    selectedKecamatan = '';
                    $("#btnMigrate").prop('disabled', true);
                }
            });
            
            $("#migrateForm").on('submit', function(e) {
                e.preventDefault();
                
                const lokasiId = $("#lokasi_id").val();
                if (!lokasiId) {
                    alert('Silakan pilih kecamatan terlebih dahulu!');
                    return;
                }
                
                // Reset UI
                $("#logContainer").addClass('active').html('<div style="color: #888; margin-bottom: 10px;">═══ LOG MIGRASI ANGGOTA ═══</div>');
                $("#progressBar").addClass('active');
                $("#progressFill").css('width', '0%').text('0%');
                $("#summaryBox").removeClass('active');
                $("#btnMigrate").prop('disabled', true).text('Sedang Memproses...');
                $("#kecamatan").prop('disabled', true);
                
                // Scroll to log
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $("#logContainer").offset().top - 20
                    }, 500);
                }, 100);
                
                // Start migration with AJAX
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    data: {
                        action: 'migrate',
                        lokasi_id: lokasiId,
                        nama_kec: selectedKecamatan
                    },
                    xhrFields: {
                        onprogress: function(e) {
                            const response = e.currentTarget.response;
                            const lines = response.split('\n\n');
                            
                            let lastProcessed = parseInt($(this).data('lastProcessed') || 0);
                            
                            for (let i = lastProcessed; i < lines.length; i++) {
                                const line = lines[i];
                                if (line.startsWith('data: ')) {
                                    try {
                                        const data = JSON.parse(line.substring(6));
                                        
                                        if (data.type === 'complete') {
                                            const result = JSON.parse(data.message);
                                            if (!result.error) {
                                                $("#summaryTotal").text(result.total);
                                                $("#summarySuccess").text(result.success);
                                                $("#summaryFailed").text(result.failed);
                                                $("#summaryBox").addClass('active');
                                                $("#progressFill").css('width', '100%').text('100%');
                                            } else {
                                                addLog('error', 'Migrasi gagal: ' + (result.message || 'Unknown error'));
                                            }
                                            $("#btnMigrate").prop('disabled', false).text('Mulai Migrasi Anggota');
                                            $("#kecamatan").prop('disabled', false);
                                        } else {
                                            addLog(data.type, data.message);
                                            
                                            // Update progress bar
                                            if (data.type === 'progress') {
                                                const match = data.message.match(/(\d+)\/(\d+)/);
                                                if (match) {
                                                    const current = parseInt(match[1]);
                                                    const total = parseInt(match[2]);
                                                    const percent = Math.round((current / total) * 100);
                                                    $("#progressFill").css('width', percent + '%').text(percent + '%');
                                                }
                                            }
                                        }
                                    } catch (err) {
                                        console.error('Parse error:', err, line);
                                    }
                                }
                            }
                            
                            $(this).data('lastProcessed', lines.length);
                        }
                    },
                    error: function(xhr, status, error) {
                        addLog('error', '❌ Request failed: ' + error);
                        addLog('error', 'Status: ' + xhr.status + ' - ' + xhr.statusText);
                        if (xhr.responseText) {
                            addLog('error', 'Response: ' + xhr.responseText.substring(0, 200));
                        }
                        $("#btnMigrate").prop('disabled', false).text('Mulai Migrasi Anggota');
                        $("#kecamatan").prop('disabled', false);
                    }
                });
            });
            
            function addLog(type, message) {
                const logClass = 'log-' + type;
                const timestamp = new Date().toLocaleTimeString();
                const logEntry = $('<div>')
                    .addClass('log-entry ' + logClass)
                    .html(`[${timestamp}] ${message}`);
                
                $("#logContainer").append(logEntry);
                
                // Auto scroll to bottom
                const container = document.getElementById('logContainer');
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</body>
</html>