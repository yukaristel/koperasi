<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Pengguna - {{ $kec->nama_kec ?? 'Koperasi' }}</title>
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f0f4f8;
            min-height: 100vh;
        }

        .header-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            z-index: 9999;
            background-color: #129990;
            color: white;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .header-bar span:first-child {
            font-weight: 700;
            font-size: 16px;
        }

        .header-bar span:last-child {
            font-style: italic;
            font-size: 14px;
            opacity: 0.95;
        }

        .main-content {
            padding-top: 70px;
            padding-bottom: 40px;
            max-width: 900px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .page-title p {
            font-size: 14px;
            color: #718096;
        }

        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .user-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .user-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(18, 153, 144, 0.15);
            border-color: #129990;
        }

        .user-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #129990;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 15px;
            color: #2d3748;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-uname {
            font-size: 12px;
            color: #a0aec0;
            margin-top: 2px;
        }

        .user-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-level {
            background-color: #ebf8ff;
            color: #2b6cb0;
        }

        .badge-jabatan {
            background-color: #f0fff4;
            color: #276749;
        }

        .card-footer-section {
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
            text-align: center;
            margin-top: 30px;
        }

        .card-footer-section p {
            font-size: 12px;
            color: #a0aec0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #129990;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #0d6b63;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a0aec0;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 16px;
        }

        @media (max-width: 600px) {
            .user-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="header-bar">
        <span>{{ $kec->nama_lembaga_long ?? 'Koperasi' }}</span>
        <span>{{ $kec->nama_kec ?? '' }}</span>
    </div>

    <div class="main-content">
        <a href="/" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Login
        </a>

        <div class="page-title">
            <h2><i class="fas fa-users"></i> Daftar Pengguna</h2>
            <p>{{ $kec->nama_kec ?? '' }} &mdash; {{ $kec->kabupaten->nama_kab ?? '' }}</p>
        </div>

        @if($users->count() > 0)
            <div class="user-grid">
                @foreach($users as $user)
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-avatar">
                                @if($user->foto)
                                    <img src="/storage/foto/{{ $user->foto }}" alt="{{ $user->namadepan }}">
                                @else
                                    {{ strtoupper(substr($user->namadepan ?? 'U', 0, 1)) }}
                                @endif
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $user->namadepan }} {{ $user->namabelakang }}</div>
                                <div class="user-uname">{{ '@' . $user->uname }}</div>
                            </div>
                        </div>
                        <div class="user-meta">
                            @if($user->l)
                                <span class="badge badge-level">{{ $user->l->nama_level ?? '' }}</span>
                            @endif
                            @if($user->j)
                                <span class="badge badge-jabatan">{{ $user->j->nama_jabatan ?? '' }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <p>Tidak ada pengguna terdaftar untuk kecamatan ini.</p>
            </div>
        @endif

        <div class="card-footer-section">
            <p>&copy; {{ date('Y') }} Sistem Informasi Koperasi</p>
        </div>
    </div>
</body>

</html>
