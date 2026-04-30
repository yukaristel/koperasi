<?php
// ============================================
// KONFIGURASI MENU MIGRASI
// Tambahkan menu baru di sini dengan format:
// ['nama', 'file', 'icon', 'warna', 'deskripsi']
// ============================================

$menu_migrasi = [
    [
        'nama' => 'Pinjaman Anggota',
        'file' => 'migrasi_pinj.php',
        'icon' => '💰',
        'warna' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'deskripsi' => 'Migrasi data pinjaman anggota dari LKM ke Koperasi'
    ],
    [
        'nama' => 'Data Anggota',
        'file' => 'migrasi_angg.php',
        'icon' => '👥',
        'warna' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
        'deskripsi' => 'Migrasi data anggota dari LKM ke Koperasi'
    ],
    [
        'nama' => 'Transaksi',
        'file' => 'migrasi_trans.php',
        'icon' => '💸',
        'warna' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
        'deskripsi' => 'Migrasi data transaksi dengan mapping rekening'
    ],
    // Tambahkan menu baru di bawah ini
    // [
    //     'nama' => 'Simpanan',
    //     'file' => 'migrasi_simp.php',
    //     'icon' => '🏦',
    //     'warna' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
    //     'deskripsi' => 'Migrasi data simpanan anggota'
    // ],
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migrasi Data - LKM ke Koperasi</title>
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
            padding: 40px 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
            animation: fadeInDown 0.6s ease;
        }
        
        .header h1 {
            font-size: 42px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .header p {
            font-size: 18px;
            opacity: 0.95;
        }
        
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .migration-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }
        
        .migration-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .migration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--card-color);
        }
        
        .card-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }
        
        .card-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .card-description {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .card-button {
            display: inline-block;
            padding: 12px 30px;
            background: var(--card-color);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .card-button:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .info-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeInUp 0.8s ease;
        }
        
        .info-box h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .info-box ul {
            list-style: none;
            padding-left: 0;
        }
        
        .info-box li {
            padding: 8px 0;
            color: #555;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-box li:last-child {
            border-bottom: none;
        }
        
        .info-box li::before {
            content: '✓';
            color: #4caf50;
            font-weight: bold;
            margin-right: 10px;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 32px;
            }
            
            .header p {
                font-size: 16px;
            }
            
            .card-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #4caf50;
            color: white;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Migrasi Data</h1>
            <p>LKM → Koperasi</p>
        </div>
        
        <div class="card-grid">
            <?php foreach ($menu_migrasi as $index => $menu): ?>
                <div class="migration-card" style="--card-color: <?php echo $menu['warna']; ?>; animation-delay: <?php echo $index * 0.1; ?>s;">
                    <span class="card-icon"><?php echo $menu['icon']; ?></span>
                    <h2 class="card-title"><?php echo $menu['nama']; ?></h2>
                    <p class="card-description"><?php echo $menu['deskripsi']; ?></p>
                    <a href="<?php echo $menu['file']; ?>" class="card-button">
                        Mulai Migrasi →
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="info-box">
            <h3>ℹ️ Informasi Penting</h3>
            <ul>
                <li>Pastikan koneksi database LKM dan Koperasi sudah tersedia</li>
                <li>Proses migrasi akan menghapus data lama di tabel Koperasi</li>
                <li>Untuk migrasi transaksi, diperlukan mapping rekening terlebih dahulu</li>
                <li>Semua proses migrasi dilengkapi dengan log real-time</li>
                <li>Backup data sebelum melakukan migrasi untuk keamanan</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>Sistem Migrasi Data SIUPK © <?php echo date('Y'); ?></p>
        </div>
    </div>
</body>
</html>