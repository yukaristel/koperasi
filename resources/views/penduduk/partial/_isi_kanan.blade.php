
<div>
    <div class="card mb-3 text-center">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fa fa-user"></i></span>
            <span>|</span>
        </div>
        <div class="card-body">
            @php
                $fotoPath = "../assets/img/{$anggota->foto}.jpg";
                $defaultFoto = $anggota->jk == 'L' ? '../assets/img/male.jpg' : '../assets/img/female.jpg';
            @endphp

            <img src="{{ file_exists(public_path($fotoPath)) ? asset($fotoPath) : asset($defaultFoto) }}" class="img-thumbnail w-50" alt="Foto Nasabah"> 
            <br/>
            <button class="btn btn-sm btn-secondary mb-2" >AMBIL FOTO</button>
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary btn-sm" >SIMPAN DATA</button>
                <button class="btn btn-outline-secondary btn-sm" >Cetak Kartu Anggota</button>
                <button class="btn btn-outline-danger btn-sm" >Black List NIK</button>
            </div>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <div class="mb-2">
                <i class="fa fa-users"></i> Status Keanggotaan
            </div>
        </div>
        <div class="card-body text-center">

            @php
                $status = $status ?? null;
                $tgl_kondisi = $simpanan_anggota->realSimpananTerbesar->tgl_transaksi ?? null;
                $tgl_kondisi = \Carbon\Carbon::parse($tgl_kondisi ?? null);
                $tgl_hari_ini = \Carbon\Carbon::today();
                if ($tgl_hari_ini->day > $tgl) {
                    // Ambil tanggal 15 bulan ini
                    $tgl_hitung = $tgl_hari_ini->copy()->day($tgl);
                } else {
                    // Ambil tanggal 15 bulan sebelumnya
                    $tgl_hitung = $tgl_hari_ini->copy()->subMonth()->day($tgl);
                }
            @endphp

            @if ($status === 'B')
                <p class="text-github fw-bold">YBS Terblokir oleh sistem.</p>
                <a href="" class="btn btn-github">Buka Blokir</a>

            @elseif ($status === 'A')
                @if ($tgl_kondisi->greaterThan($tgl_hitung))
                    <p class="text-success fw-bold">Anggota Aktif</p>
                @else
                    <p class="text-warning fw-bold">
                        Anggota Tidak Aktif sejak {{ $tgl_kondisi->format('d-m-Y') }}
                    </p>
                    <a href="" class="btn btn-primary">Perpanjang Keanggotaan</a>
                @endif

            @else
                <p class="text-secondary fw-bold">YBS Belum Terdaftar sebagai anggota.</p>
                <a href="" class="btn btn-success">Daftarkan Anggota</a>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <div class="mb-2">
                <i class="fa fa-database"></i> Simpanan
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-white" disabled>[+] Simp. Umum</button>
                <button class="btn btn-sm btn-white" disabled>[+] Simp. Deposito</button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm small">
                    <thead>
                        <tr class="fw-semi-bold">
                            <td>No.Rek</td>
                            <td>jenis</td>
                            <td>Saldo</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($simpanan->count())
                            @foreach ($simpanan as $simp)
                                <tr class="fw-normal" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetailSimpanan" id="DetailSimpanan{{$simp->id}}">
                                    <td>{{ $simp->nomor_rekening }}</td>
                                    <td>{{ $simp->js->nama_js }}</td>
                                    <td>{{ number_format($simp->realSimpananTerbesar->sum) }}</td>
                                    <td><span class="badge bg-{{ $simp->sts->warna_status }} text-black">{{ $simp->sts->nama_status }}</span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"><i>* Klik untuk detail</i></td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5" class="text-danger text-center">YBS Tidak memiliki Simpanan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="mb-2">
                <i class="fa fa-money-bill"></i> Pinjaman
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-white" disabled>Tambah Pinjaman</button>
                <button class="btn btn-sm btn-white" disabled>Form Pinjaman</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm small">
                    <thead>
                        <tr class="fw-semi-bold">
                            <td>LoanID</td>
                            <td>Tanggal</td>
                            <td>Alokasi</td>
                            <td>Saldo</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pinjaman->count())
                            @foreach ($pinjaman as $pinj)
                                <tr class="fw-normal" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetailProposalIndividu" id="DetailProposalIndividu{{$pinj->id}}">
                                    <td>{{ $pinj->id }}</td>
                                    <td>{{ $pinj->tgl_cair }}</td>
                                    <td>{{ number_format($pinj->alokasi) }}</td>
                                    <td>{{ number_format($pinj->saldo->saldo_pokok) }}</td>
                                    <td><span class="badge bg-{{ $pinj->sts->warna_status }} text-black">{{ $pinj->sts->nama_status }}</span></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"><i>* Klik untuk detail</i></td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5" class="text-danger text-center">YBS Tidak memiliki pinjaman</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
