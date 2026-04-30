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

// Handle AJAX request untuk autocomplete kecamatan
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

// Handle AJAX request untuk mendapatkan rekening LKM
if (isset($_GET['action']) && $_GET['action'] == 'get_rekening_lkm') {
    try {
        $lokasi = isset($_GET['lokasi']) ? intval($_GET['lokasi']) : 0;
        
        $conn_lkm = new mysqli($host, $user, $pass, $db_lkm);
        if ($conn_lkm->connect_error) {
            throw new Exception("Koneksi gagal: " . $conn_lkm->connect_error);
        }
        $conn_lkm->set_charset("utf8");
        
        $table_rekening = "rekening_" . $lokasi;
        
        // Ambil rekening yang digunakan di transaksi
        $query = "SELECT DISTINCT r.kode_akun, r.nama_akun 
                  FROM $table_rekening r
                  WHERE r.kode_akun IN (
                      SELECT DISTINCT rekening_debit FROM transaksi_$lokasi
                      UNION
                      SELECT DISTINCT rekening_kredit FROM transaksi_$lokasi
                  )
                  ORDER BY r.kode_akun";
        
        $result = $conn_lkm->query($query);
        
        if (!$result) {
            throw new Exception("Gagal ambil rekening: " . $conn_lkm->error);
        }
        
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
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

// Handle AJAX request untuk autocomplete rekening koperasi
if (isset($_GET['action']) && $_GET['action'] == 'get_rekening_koperasi') {
    try {
        $lokasi = isset($_GET['lokasi']) ? intval($_GET['lokasi']) : 0;
        $search = isset($_GET['term']) ? $_GET['term'] : '';
        
        $conn_koperasi = new mysqli($host, $user, $pass, $db_koperasi);
        if ($conn_koperasi->connect_error) {
            throw new Exception("Koneksi gagal: " . $conn_koperasi->connect_error);
        }
        $conn_koperasi->set_charset("utf8");
        
        $table_rekening = "rekening_" . $lokasi;
        
        $query = "SELECT kode_akun, nama_akun FROM $table_rekening 
                  WHERE kode_akun LIKE ? OR nama_akun LIKE ? 
                  ORDER BY kode_akun LIMIT 20";
        $stmt = $conn_koperasi->prepare($query);
        $searchTerm = "%$search%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'value' => $row['kode_akun'],
                'label' => $row['kode_akun'] . ' - ' . $row['nama_akun'],
                'nama' => $row['nama_akun']
            );
        }
        
        $stmt->close();
        $conn_koperasi->close();
        
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
        
        $lokasi = isset($_POST['lokasi_id']) ? intval($_POST['lokasi_id']) : 0;
        $nama_kec = isset($_POST['nama_kec']) ? $_POST['nama_kec'] : '';
        $mapping = isset($_POST['mapping']) ? json_decode($_POST['mapping'], true) : array();
        
        sendLog('info', "🚀 Memulai proses migrasi TRANSAKSI untuk kecamatan: $nama_kec (ID: $lokasi)");
        sendLog('info', "📋 Total mapping rekening: " . count($mapping));
        
        if (empty($lokasi)) {
            throw new Exception("Lokasi tidak valid!");
        }
        
        if (empty($mapping)) {
            throw new Exception("Mapping rekening tidak boleh kosong!");
        }
        
        $table_lkm = "transaksi_" . $lokasi;
        $table_koperasi = "transaksi_" . $lokasi;
        
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
        $result_lkm = $conn_lkm->query("SELECT * FROM $table_lkm ORDER BY idt");
        
        if (!$result_lkm) {
            throw new Exception("Gagal mengambil data: " . $conn_lkm->error);
        }
        
        $total = $result_lkm->num_rows;
        sendLog('success', "✓ Ditemukan $total record untuk dimigrasi");
        
        $success = 0;
        $failed = 0;
        $skipped = 0;
        $errors = array();
        
        // Prepare statement untuk insert
        $sql = "INSERT INTO $table_koperasi (
            idt, tgl_transaksi, rekening_debit, rekening_kredit, idtp, id_pinj, id_pinj_i,
            id_simp, keterangan_transaksi, relasi, jumlah, urutan, id_user
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn_koperasi->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare statement gagal: " . $conn_koperasi->error);
        }
        
        while ($row = $result_lkm->fetch_assoc()) {
            $current_id = isset($row['idt']) ? $row['idt'] : 'unknown';
            
            try {
                // Mapping rekening debit
                $rek_debit_lkm = $row['rekening_debit'];
                $rek_debit_kop = isset($mapping[$rek_debit_lkm]) ? $mapping[$rek_debit_lkm] : '';
                
                // Mapping rekening kredit
                $rek_kredit_lkm = $row['rekening_kredit'];
                $rek_kredit_kop = isset($mapping[$rek_kredit_lkm]) ? $mapping[$rek_kredit_lkm] : '';
                
                // Skip jika mapping tidak lengkap
                if (empty($rek_debit_kop) || empty($rek_kredit_kop)) {
                    $skipped++;
                    if ($skipped <= 3) {
                        sendLog('warning', "⚠️ IDT $current_id diskip: Mapping rekening tidak lengkap");
                    }
                    continue;
                }
                
                // Handle id_simp (bisa NULL)
                $id_simp = !empty($row['id_simp']) ? $row['id_simp'] : NULL;
                
                // Bind parameters
                $stmt->bind_param(
                    "sssssssssssss",
                    $row['idt'],
                    $row['tgl_transaksi'],
                    $rek_debit_kop,
                    $rek_kredit_kop,
                    $row['idtp'],
                    $row['id_pinj'],
                    $row['id_pinj_i'],
                    $id_simp,
                    $row['keterangan_transaksi'],
                    $row['relasi'],
                    $row['jumlah'],
                    $row['urutan'],
                    $row['id_user']
                );
                
                if ($stmt->execute()) {
                    $success++;
                    if ($success % 50 == 0 || $success == 1) {
                        sendLog('progress', "⏳ Progress: $success/$total record berhasil dimigrasi");
                    }
                } else {
                    throw new Exception($stmt->error);
                }
                
            } catch (Exception $e) {
                $failed++;
                $error_msg = "IDT $current_id: " . $e->getMessage();
                $errors[] = $error_msg;
                if ($failed <= 5) {
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
        if ($skipped > 0) {
            sendLog('info', "⊘ Diskip: $skipped (mapping tidak lengkap)");
        }
        if ($failed > 0) {
            sendLog('warning', "⚠️ Gagal: $failed");
            if ($failed > 5) {
                sendLog('info', "   (Menampilkan 5 error pertama saja)");
            }
        }
        sendLog('complete', json_encode(['total' => $total, 'success' => $success, 'failed' => $failed, 'skipped' => $skipped]));
        
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
    <title>Migrasi Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 1200px;
            margin: 0 auto;
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
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .step-item {
            padding: 10px 20px;
            background: #e0e0e0;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
        }
        .step-item.active {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
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
            border-color: #f5576c;
            box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1);
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        }
        .btn:active:not(:disabled) {
            transform: translateY(0);
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .btn-secondary {
            background: #6c757d;
            margin-top: 10px;
        }
        .btn-secondary:hover:not(:disabled) {
            box-shadow: 0 5px 20px rgba(108, 117, 125, 0.4);
        }
        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 13px;
            color: #856404;
        }
        .mapping-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        .mapping-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        .mapping-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #dee2e6;
        }
        .mapping-table tr:hover {
            background: #f8f9fa;
        }
        .rekening-input {
            width: 100%;
            padding: 8px 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 13px;
        }
        .rekening-input:focus {
            outline: none;
            border-color: #f5576c;
        }
        .rekening-input.mapped {
            border-color: #28a745;
            background: #f0fff4;
        }
        .rekening-info {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }
        .mapping-status {
            text-align: center;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            font-weight: 600;
        }
        .mapping-status.complete {
            background: #d4edda;
            color: #155724;
        }
        .mapping-status.incomplete {
            background: #f8d7da;
            color: #721c24;
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
        .log-info { color: #61dafb; }
        .log-success { color: #4caf50; }
        .log-warning { color: #ff9800; }
        .log-error { color: #f44336; }
        .log-progress { color: #9c27b0; }
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
            font-size: 13px;
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
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
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
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #f5576c;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💸 Migrasi Data Transaksi</h1>
        <p class="subtitle">LKM → Koperasi (dengan Mapping Rekening)</p>
        
        <div class="step-indicator">
            <div class="step-item active" id="indicator-step1">1. Pilih Kecamatan</div>
            <div class="step-item" id="indicator-step2">2. Mapping Rekening</div>
            <div class="step-item" id="indicator-step3">3. Migrasi</div>
        </div>
        
        <!-- STEP 1: Pilih Kecamatan -->
        <div class="step active" id="step1">
            <div class="info-box">
                <strong>ℹ️ Informasi:</strong> Pilih kecamatan terlebih dahulu untuk memulai proses mapping rekening.
            </div>
            
            <div class="form-group">
                <label for="kecamatan">Pilih Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" placeholder="Ketik nama kecamatan..." autocomplete="off">
                <input type="hidden" id="lokasi_id" name="lokasi_id">
            </div>
            
            <button type="button" class="btn" id="btnNextStep1" disabled>
                Lanjut ke Mapping Rekening →
            </button>
        </div>
        
        <!-- STEP 2: Mapping Rekening -->
        <div class="step" id="step2">
            <div class="info-box">
                <strong>⚠️ Penting:</strong> Mapping semua rekening LKM ke rekening Koperasi. Sistem akan otomatis mengisi rekening dengan kode yang sama jika tersedia.
            </div>
            
            <div class="loading" id="loadingMapping">
                <div class="spinner"></div>
                <p>Memuat data rekening...</p>
            </div>
            
            <div id="mappingContainer" style="display:none;">
                <table class="mapping-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Rekening LKM</th>
                            <th width="5%" style="text-align:center;">→</th>
                            <th width="55%">Rekening Koperasi</th>
                        </tr>
                    </thead>
                    <tbody id="mappingTableBody">
                    </tbody>
                </table>
                
                <div class="mapping-status incomplete" id="mappingStatus">
                    <span id="mappingStatusText">Belum semua rekening dimapping</span>
                </div>
            </div>
            
            <button type="button" class="btn-secondary btn" id="btnBackStep2">
                ← Kembali
            </button>
            
            <button type="button" class="btn" id="btnNextStep2" disabled>
                Lanjut ke Migrasi →
            </button>
        </div>
        
        <!-- STEP 3: Migrasi -->
        <div class="step" id="step3">
            <div class="info-box">
                <strong>⚠️ Perhatian:</strong> Proses ini akan menghapus semua data transaksi di tabel koperasi yang dipilih dan menggantinya dengan data dari LKM (dengan rekening yang sudah dimapping).
            </div>
            
            <div id="mappingSummary" style="margin: 20px 0; padding: 25px; background: white; border: 2px solid #dee2e6; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #dee2e6;">
                    <h2 style="color: #333; margin-bottom: 5px; font-size: 22px;">📋 PERNYATAAN MAPPING REKENING</h2>
                    <p style="color: #666; font-size: 13px; margin: 0;">Migrasi Transaksi dari Database LKM ke Database Koperasi</p>
                </div>
                
                <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px 15px; margin-bottom: 20px; border-radius: 5px;">
                    <p style="margin: 0; color: #856404; font-size: 13px; line-height: 1.6;">
                        <strong>Dengan ini dinyatakan bahwa:</strong><br>
                        Seluruh transaksi pada kecamatan <strong id="summaryKecamatan"></strong> akan dimigrasi dari database LKM ke database Koperasi dengan perubahan kode rekening sebagai berikut:
                    </p>
                </div>
                
                <div id="mappingSummaryContent"></div>
                
                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 12px; color: #666;">
                    <strong style="color: #333;">Catatan:</strong>
                    <ul style="margin: 8px 0 0 20px; padding: 0;">
                        <li>Mapping ini akan diterapkan pada semua transaksi (rekening debit dan kredit)</li>
                        <li>Data transaksi lama di database Koperasi akan dihapus dan diganti dengan data baru</li>
                        <li>Proses migrasi akan melewati transaksi yang rekeningnya tidak dapat dimapping</li>
                    </ul>
                </div>
                
                <div style="text-align: right; margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6; font-size: 12px; color: #999;">
                    Tanggal: <span id="summaryDate"></span>
                </div>
            </div>
            
            <button type="button" class="btn-secondary btn" id="btnBackStep3">
                ← Kembali ke Mapping
            </button>
            
            <button type="button" class="btn" id="btnMigrate">
                Mulai Migrasi Transaksi
            </button>
            
            <div class="progress-bar" id="progressBar">
                <div class="progress-fill" id="progressFill">0%</div>
            </div>
            
            <div class="summary-box" id="summaryBox">
                <h3 style="margin-bottom: 15px; color: #333;">📊 Ringkasan Migrasi</h3>
                <div class="summary-item">
                    <span class="summary-label">Total Record:</span>
                    <span class="summary-value" id="summaryTotal">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Berhasil:</span>
                    <span class="summary-value" style="color: #4caf50;" id="summarySuccess">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Diskip:</span>
                    <span class="summary-value" style="color: #ffc107;" id="summarySkipped">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Gagal:</span>
                    <span class="summary-value" style="color: #f44336;" id="summaryFailed">0</span>
                </div>
            </div>
            
            <div class="log-container" id="logContainer">
                <div style="color: #888; margin-bottom: 10px;">═══ LOG MIGRASI TRANSAKSI ═══</div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedKecamatan = '';
            let lokasiId = 0;
            let rekeningLKM = [];
            let mappingData = {};
            
            // Autocomplete Kecamatan
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
                    lokasiId = ui.item.id;
                    $("#lokasi_id").val(ui.item.id);
                    selectedKecamatan = ui.item.label;
                    $("#btnNextStep1").prop('disabled', false);
                }
            });
            
            $("#kecamatan").on('input', function() {
                if ($(this).val() === '') {
                    $("#lokasi_id").val('');
                    selectedKecamatan = '';
                    lokasiId = 0;
                    $("#btnNextStep1").prop('disabled', true);
                }
            });
            
            // Step 1 -> Step 2
            $("#btnNextStep1").on('click', function() {
                goToStep(2);
                loadRekeningLKM();
            });
            
            // Load Rekening LKM
            function loadRekeningLKM() {
                $("#loadingMapping").show();
                $("#mappingContainer").hide();
                
                $.ajax({
                    url: window.location.href,
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'get_rekening_lkm',
                        lokasi: lokasiId
                    },
                    success: function(data) {
                        if (data.error) {
                            alert('Error: ' + data.error);
                            goToStep(1);
                            return;
                        }
                        
                        rekeningLKM = data;
                        buildMappingTable();
                        $("#loadingMapping").hide();
                        $("#mappingContainer").show();
                    },
                    error: function(xhr, status, error) {
                        alert('Gagal memuat rekening: ' + error);
                        goToStep(1);
                    }
                });
            }
            
            // Build Mapping Table
            function buildMappingTable() {
                let html = '';
                
                rekeningLKM.forEach(function(rek, index) {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                <strong>${rek.kode_akun}</strong><br>
                                <span class="rekening-info">${rek.nama_akun}</span>
                            </td>
                            <td style="text-align:center; color:#f5576c; font-weight:bold;">→</td>
                            <td>
                                <input type="text" 
                                       class="rekening-input rekening-koperasi" 
                                       data-kode-lkm="${rek.kode_akun}"
                                       data-kode-kop=""
                                       placeholder="Pilih rekening koperasi..."
                                       value="">
                                <div class="rekening-info" id="info-${rek.kode_akun}" style="color:#999; font-size:11px;"></div>
                            </td>
                        </tr>
                    `;
                });
                
                $("#mappingTableBody").html(html);
                
                // Setup autocomplete untuk setiap input
                $(".rekening-koperasi").each(function() {
                    let input = $(this);
                    let kodeLKM = input.data('kode-lkm');
                    
                    input.autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: window.location.href,
                                dataType: "json",
                                data: {
                                    action: 'get_rekening_koperasi',
                                    lokasi: lokasiId,
                                    term: request.term
                                },
                                success: function(data) {
                                    if (data.error) {
                                        response([]);
                                    } else {
                                        response(data);
                                    }
                                }
                            });
                        },
                        minLength: 0,
                        select: function(event, ui) {
                            $(this).val(ui.item.nama);
                            $(this).attr('data-kode-kop', ui.item.value);
                            $("#info-" + kodeLKM).text(ui.item.value);
                            mappingData[kodeLKM] = ui.item.value;
                            $(this).addClass('mapped');
                            checkMappingComplete();
                            return false;
                        }
                    }).on('focus', function() {
                        $(this).autocomplete('search', '');
                    });
                    
                    // Auto-check jika sudah ada rekening dengan kode yang sama
                    $.ajax({
                        url: window.location.href,
                        dataType: "json",
                        data: {
                            action: 'get_rekening_koperasi',
                            lokasi: lokasiId,
                            term: kodeLKM
                        },
                        success: function(data) {
                            let found = data.find(r => r.value === kodeLKM);
                            if (found) {
                                input.val(found.nama);
                                input.attr('data-kode-kop', found.value);
                                $("#info-" + kodeLKM).text(found.value);
                                mappingData[kodeLKM] = kodeLKM;
                                input.addClass('mapped');
                                checkMappingComplete();
                            }
                        }
                    });
                });
            }
            
            // Check Mapping Complete
            function checkMappingComplete() {
                let total = rekeningLKM.length;
                let mapped = Object.keys(mappingData).length;
                
                if (mapped === total) {
                    $("#mappingStatus")
                        .removeClass('incomplete')
                        .addClass('complete')
                        .find('#mappingStatusText')
                        .text(`✓ Semua rekening sudah dimapping (${mapped}/${total})`);
                    $("#btnNextStep2").prop('disabled', false);
                } else {
                    $("#mappingStatus")
                        .removeClass('complete')
                        .addClass('incomplete')
                        .find('#mappingStatusText')
                        .text(`Masih ada ${total - mapped} rekening yang belum dimapping (${mapped}/${total})`);
                    $("#btnNextStep2").prop('disabled', true);
                }
            }
            
            // Step 2 -> Step 1
            $("#btnBackStep2").on('click', function() {
                goToStep(1);
            });
            
            // Step 2 -> Step 3
            $("#btnNextStep2").on('click', function() {
                goToStep(3);
                showMappingSummary();
            });
            
            // Show Mapping Summary
            function showMappingSummary() {
                // Set kecamatan dan tanggal
                $("#summaryKecamatan").text(selectedKecamatan);
                
                const now = new Date();
                const dateStr = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) + ' pukul ' + now.toLocaleTimeString('id-ID');
                $("#summaryDate").text(dateStr);
                
                let html = '<table style="width:100%; border-collapse: collapse; font-size:14px; margin-top: 15px;">';
                html += '<thead><tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">';
                html += '<th style="padding:12px 10px; text-align:left; color: #495057; font-weight: 600; width: 5%;">No</th>';
                html += '<th style="padding:12px 10px; text-align:left; color: #495057; font-weight: 600;">Rekening Asal (LKM)</th>';
                html += '<th style="padding:12px; text-align:center; color: #495057; font-weight: 600; width: 8%;">→</th>';
                html += '<th style="padding:12px 10px; text-align:left; color: #495057; font-weight: 600;">Rekening Tujuan (Koperasi)</th>';
                html += '</tr></thead><tbody>';
                
                rekeningLKM.forEach(function(rek, index) {
                    let kodeKop = mappingData[rek.kode_akun] || '-';
                    let namaKop = '';
                    
                    // Ambil nama rekening koperasi
                    $(".rekening-koperasi[data-kode-lkm='" + rek.kode_akun + "']").each(function() {
                        if ($(this).attr('data-kode-kop') === kodeKop) {
                            namaKop = $(this).val();
                        }
                    });
                    
                    html += `
                        <tr style="border-bottom:1px solid #dee2e6;">
                            <td style="padding:12px 10px; text-align: center; color: #666; font-weight: 600;">${index + 1}</td>
                            <td style="padding:12px 10px;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 3px;">${rek.kode_akun}</div>
                                <div style="font-size: 12px; color: #666;">${rek.nama_akun}</div>
                            </td>
                            <td style="padding:12px; text-align:center; color:#f5576c; font-weight:bold; font-size: 18px;">→</td>
                            <td style="padding:12px 10px;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 3px;">${kodeKop}</div>
                                <div style="font-size: 12px; color: #666;">${namaKop || '-'}</div>
                            </td>
                        </tr>
                    `;
                });
                
                html += '</tbody></table>';
                
                html += `
                    <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-left: 4px solid #2196F3; border-radius: 5px;">
                        <p style="margin: 0; color: #0d47a1; font-size: 13px; line-height: 1.6;">
                            <strong>Pernyataan:</strong><br>
                            Dengan menyetujui mapping di atas, saya memahami bahwa seluruh rekening pada transaksi akan diubah sesuai dengan pemetaan yang telah ditentukan. Proses ini tidak dapat dibatalkan setelah migrasi dimulai.
                        </p>
                    </div>
                `;
                
                $("#mappingSummaryContent").html(html);
            }
            
            // Step 3 -> Step 2
            $("#btnBackStep3").on('click', function() {
                goToStep(2);
            });
            
            // Go to Step
            function goToStep(step) {
                $(".step").removeClass('active');
                $(".step-item").removeClass('active');
                
                $("#step" + step).addClass('active');
                $("#indicator-step" + step).addClass('active');
                
                if (step < 3) {
                    for (let i = 1; i < step; i++) {
                        $("#indicator-step" + i).addClass('active');
                    }
                }
            }
            
            // Migrate
            $("#btnMigrate").on('click', function() {
                if (!confirm('Yakin ingin memulai migrasi? Data transaksi di koperasi akan dihapus dan diganti dengan data dari LKM.')) {
                    return;
                }
                
                // Reset UI
                $("#logContainer").addClass('active').html('<div style="color: #888; margin-bottom: 10px;">═══ LOG MIGRASI TRANSAKSI ═══</div>');
                $("#progressBar").addClass('active');
                $("#progressFill").css('width', '0%').text('0%');
                $("#summaryBox").removeClass('active');
                $("#btnMigrate").prop('disabled', true).text('Sedang Memproses...');
                $("#btnBackStep3").prop('disabled', true);
                
                // Scroll to log
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $("#logContainer").offset().top - 20
                    }, 500);
                }, 100);
                
                // Start migration
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    data: {
                        action: 'migrate',
                        lokasi_id: lokasiId,
                        nama_kec: selectedKecamatan,
                        mapping: JSON.stringify(mappingData)
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
                                                $("#summarySkipped").text(result.skipped || 0);
                                                $("#summaryFailed").text(result.failed);
                                                $("#summaryBox").addClass('active');
                                                $("#progressFill").css('width', '100%').text('100%');
                                            } else {
                                                addLog('error', 'Migrasi gagal: ' + (result.message || 'Unknown error'));
                                            }
                                            $("#btnMigrate").prop('disabled', false).text('Mulai Migrasi Transaksi');
                                            $("#btnBackStep3").prop('disabled', false);
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
                        $("#btnMigrate").prop('disabled', false).text('Mulai Migrasi Transaksi');
                        $("#btnBackStep3").prop('disabled', false);
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