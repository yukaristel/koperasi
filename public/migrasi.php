<?php
// Konfigurasi Database
$host = '45.149.187.98';
$user = 'siupk_global';
$pass = 'siupk_global';
$db_lkm = 'siupk_lkm';
$db_koperasi = 'siupk_koperasi';

// Koneksi ke Database LKM
$conn_lkm = new mysqli($host, $user, $pass, $db_lkm);
if ($conn_lkm->connect_error) {
    die("Koneksi LKM gagal: " . $conn_lkm->connect_error);
}

// Koneksi ke Database Koperasi
$conn_koperasi = new mysqli($host, $user, $pass, $db_koperasi);
if ($conn_koperasi->connect_error) {
    die("Koneksi Koperasi gagal: " . $conn_koperasi->connect_error);
}

// Set charset
$conn_lkm->set_charset("utf8");
$conn_koperasi->set_charset("utf8");

// Handle AJAX request untuk autocomplete
if (isset($_GET['action']) && $_GET['action'] == 'get_kecamatan') {
    $search = isset($_GET['term']) ? $_GET['term'] : '';
    $query = "SELECT id, nama_kec FROM kecamatan WHERE nama_kec LIKE ? ORDER BY nama_kec";
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
    
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Handle proses migrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['migrate'])) {
    $lokasi = $_POST['lokasi_id'];
    
    if (empty($lokasi)) {
        $error = "Silakan pilih kecamatan terlebih dahulu!";
    } else {
        $table_lkm = "pinjaman_anggota_" . $lokasi;
        $table_koperasi = "pinjaman_anggota_" . $lokasi;
        
        // Cek apakah tabel ada di LKM
        $check_lkm = $conn_lkm->query("SHOW TABLES LIKE '$table_lkm'");
        if ($check_lkm->num_rows == 0) {
            $error = "Tabel $table_lkm tidak ditemukan di database LKM!";
        } else {
            // Mulai migrasi
            $conn_koperasi->begin_transaction();
            
            try {
                // Truncate tabel koperasi
                $conn_koperasi->query("TRUNCATE TABLE $table_koperasi");
                
                // Ambil data dari LKM
                $query_lkm = "SELECT * FROM $table_lkm ORDER BY id";
                $result_lkm = $conn_lkm->query($query_lkm);
                
                $total = 0;
                $success = 0;
                $failed = 0;
                
                while ($row = $result_lkm->fetch_assoc()) {
                    $total++;
                    
                    // Parsing jaminan
                    $jaminan = '#';
                    if (!empty($row['jaminan'])) {
                        $jaminan_data = json_decode($row['jaminan'], true);
                        if ($jaminan_data && is_array($jaminan_data)) {
                            $nilai = isset($jaminan_data['nilai_jaminan']) ? $jaminan_data['nilai_jaminan'] : '0';
                            $ket_parts = array();
                            foreach ($jaminan_data as $key => $value) {
                                if ($key != 'nilai_jaminan' && !empty($value)) {
                                    $ket_parts[] = $value;
                                }
                            }
                            $keterangan = implode(', ', $ket_parts);
                            $jaminan = $nilai . '#' . $keterangan;
                        }
                    }
                    
                    // Konstruksi data_proposal
                    $data_proposal = sprintf(
                        "%s#%s#%s#%s#%s#%s#%s",
                        $row['tgl_proposal'],
                        $row['proposal'],
                        $row['jangka'],
                        $row['pros_jasa'],
                        $row['jenis_jasa'],
                        $row['sistem_angsuran'],
                        $row['sa_jasa']
                    );
                    
                    // Konstruksi data_verifikasi (base)
                    $data_verifikasi_base = sprintf(
                        "%s#%s#%s#%s#%s#%s#%s",
                        $row['tgl_verifikasi'],
                        $row['verifikasi'],
                        $row['jangka'],
                        $row['pros_jasa'],
                        $row['jenis_jasa'],
                        $row['sistem_angsuran'],
                        $row['sa_jasa']
                    );
                    
                    // Konstruksi catatan dari field yang tidak ada di koperasi
                    $catatan_parts = array();
                    if (!empty($row['harga']) && $row['harga'] != '0') {
                        $catatan_parts[] = "Harga: " . $row['harga'];
                    }
                    if (!empty($row['nama_barang'])) {
                        $catatan_parts[] = "Barang: " . $row['nama_barang'];
                    }
                    if (!empty($row['catatan_verifikasi'])) {
                        $catatan_parts[] = "Catatan Verifikasi: " . $row['catatan_verifikasi'];
                    }
                    if (!empty($row['fee_agent']) && $row['fee_agent'] != '0') {
                        $catatan_parts[] = "Fee Agent: " . $row['fee_agent'];
                    }
                    if (!empty($row['fee_supplier']) && $row['fee_supplier'] != '0') {
                        $catatan_parts[] = "Fee Supplier: " . $row['fee_supplier'];
                    }
                    if (!empty($row['id_agent']) && $row['id_agent'] != '0') {
                        $catatan_parts[] = "ID Agent: " . $row['id_agent'];
                    }
                    if (!empty($row['id_supplier']) && $row['id_supplier'] != '0') {
                        $catatan_parts[] = "ID Supplier: " . $row['id_supplier'];
                    }
                    if (!empty($row['depe']) && $row['depe'] != '0') {
                        $catatan_parts[] = "Depe: " . $row['depe'];
                    }
                    $catatan = !empty($row['catatan']) ? $row['catatan'] : '';
                    if (!empty($catatan_parts)) {
                        $catatan .= (!empty($catatan) ? ' | ' : '') . implode(' | ', $catatan_parts);
                    }
                    
                    // data_verifikasi1, 2, 3 dengan tambahan catatan dan user_id
                    $data_verifikasi1 = $data_verifikasi_base . "##" . $row['user_id'];
                    $data_verifikasi2 = $data_verifikasi_base . "##" . $row['user_id'];
                    $data_verifikasi3 = $data_verifikasi_base . "##" . $row['user_id'];
                    
                    // data_waiting
                    $tgl_tunggu = !empty($row['tgl_tunggu']) ? $row['tgl_tunggu'] : $row['tgl_verifikasi'];
                    $data_waiting = $tgl_tunggu . "#" . $row['user_id'];
                    
                    // Default values dengan #
                    $pendapatan = "0#0#0";
                    $biaya = "0#0#0#0#0#0#0";
                    $aktiva = "0#0#0#0#0#0";
                    $pasiva = "0#0#0";
                    
                    // Insert ke koperasi
                    $sql = "INSERT INTO $table_koperasi (
                        jenis_pinjaman, id_pinkel, jenis_pp, nia, pendapatan, biaya, aktiva, pasiva,
                        jaminan, data_proposal, data_verifikasi, data_verifikasi1, data_verifikasi2,
                        data_verifikasi3, data_waiting, tgl_cair, tgl_lunas, alokasi, catatan,
                        spk_no, jangka, pros_jasa, jenis_jasa, sistem_angsuran, sa_jasa, status,
                        lu, wt_cair, user_id
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $conn_koperasi->prepare($sql);
                    
                    $id_pinkel = 0;
                    $tgl_cair_val = !empty($row['tgl_cair']) ? $row['tgl_cair'] : null;
                    $tgl_lunas_val = !empty($row['tgl_lunas']) ? $row['tgl_lunas'] : null;
                    
                    $stmt->bind_param(
                        "sssssssssssssssssssssssssssss",
                        $row['jenis_pinjaman'],
                        $id_pinkel,
                        $row['jenis_pp'],
                        $row['nia'],
                        $pendapatan,
                        $biaya,
                        $aktiva,
                        $pasiva,
                        $jaminan,
                        $data_proposal,
                        $data_verifikasi_base,
                        $data_verifikasi1,
                        $data_verifikasi2,
                        $data_verifikasi3,
                        $data_waiting,
                        $tgl_cair_val,
                        $tgl_lunas_val,
                        $row['alokasi'],
                        $catatan,
                        $row['spk_no'],
                        $row['jangka'],
                        $row['pros_jasa'],
                        $row['jenis_jasa'],
                        $row['sistem_angsuran'],
                        $row['sa_jasa'],
                        $row['status'],
                        $row['lu'],
                        $row['wt_cair'],
                        $row['user_id']
                    );
                    
                    if ($stmt->execute()) {
                        $success++;
                    } else {
                        $failed++;
                        $errors[] = "Gagal insert ID " . $row['id'] . ": " . $stmt->error;
                    }
                }
                
                $conn_koperasi->commit();
                $success_msg = "Migrasi berhasil! Total: $total, Sukses: $success, Gagal: $failed";
                
            } catch (Exception $e) {
                $conn_koperasi->rollback();
                $error = "Terjadi kesalahan: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrasi Pinjaman Anggota</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            max-width: 600px;
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
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .ui-menu-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        .ui-menu-item:hover {
            background: #f8f9fa;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 13px;
            color: #0d47a1;
        }
        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        .loading.active {
            display: block;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Migrasi Data Pinjaman</h1>
        <p class="subtitle">LKM → Koperasi</p>
        
        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success">
                ✓ <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                ✗ <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="info-box">
            <strong>⚠️ Perhatian:</strong> Proses ini akan menghapus semua data di tabel koperasi yang dipilih dan menggantinya dengan data dari LKM.
        </div>
        
        <form method="POST" id="migrateForm">
            <div class="form-group">
                <label for="kecamatan">Pilih Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" placeholder="Ketik nama kecamatan..." autocomplete="off">
                <input type="hidden" id="lokasi_id" name="lokasi_id">
            </div>
            
            <button type="submit" name="migrate" class="btn" id="btnMigrate" disabled>
                Mulai Migrasi
            </button>
            
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p style="margin-top: 10px; color: #667eea;">Sedang memproses migrasi...</p>
            </div>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#kecamatan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "",
                        dataType: "json",
                        data: {
                            action: 'get_kecamatan',
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $("#lokasi_id").val(ui.item.id);
                    $("#btnMigrate").prop('disabled', false);
                }
            });
            
            $("#kecamatan").on('input', function() {
                if ($(this).val() === '') {
                    $("#lokasi_id").val('');
                    $("#btnMigrate").prop('disabled', true);
                }
            });
            
            $("#migrateForm").on('submit', function() {
                $("#btnMigrate").prop('disabled', true).text('Memproses...');
                $("#loading").addClass('active');
            });
        });
    </script>
</body>
</html>
<?php
$conn_lkm->close();
$conn_koperasi->close();
?>
