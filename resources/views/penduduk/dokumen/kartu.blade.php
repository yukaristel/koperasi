<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota</title>
    <style>
        .card {
            width: 350px;
            border: 1px solid #333;
            padding: 16px;
            font-family: Arial, sans-serif;
            border-radius: 8px;
            position: relative;
            background-color: #fff;
            background-image: url('{{ $logo }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 70%;
            opacity: 1;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ $logo }}') no-repeat center;
            background-size: 70%;
            opacity: 0.06;
            z-index: 1;
        }

        .photo {
            width: 80px;
            height: 100px;
            border: 1px solid #ccc;
            background: #eee;
            object-fit: cover;
        }
        .info {
            margin-left: 12px;
        }
        .barcode {
            margin-top: 10px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="card">
        <div style="display: flex; align-items: center;">
            @php
                $fotoFile = public_path("assets/img/{$anggota->foto}.jpg");
                $fotoPath = file_exists($fotoFile) ? asset("assets/img/{$anggota->foto}.jpg") : null;

                $defaultFoto = $anggota->jk == 'L'
                    ? asset('assets/img/male.jpg')
                    : asset('assets/img/female.jpg');

                $finalFoto = $fotoPath ?: $defaultFoto;
            @endphp

            <img src="{{ $finalFoto }}" alt="Foto" class="photo">

            <div class="info">
                <strong>ID:</strong> {{ $anggota->id }}<br>
                <strong>NIK:</strong> {{ $anggota->nik }}<br>
                <strong>Nama:</strong> {{ $anggota->namadepan }}<br>
                <strong>Panggilan:</strong> {{ $anggota->nama_panggilan }}<br>
                <strong>JK:</strong> {{ $anggota->jk }}<br>
                <strong>Lahir:</strong> {{ $anggota->tempat_lahir }}, {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d/m/Y') }}
            </div>
        </div>

        <div class="barcode">
            <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode NIK"><br>
            <small>{{ $anggota->nik }}</small>
        </div>
    </div>
</body>
</html>
