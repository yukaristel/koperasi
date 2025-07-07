
<div>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-users"></i> Status Keanggotaan
            </div>
            <a href="URL-DOKUMEN" target="_blank" class="text-white" title="Form Anggota">
                <i class="fa fa-file-alt"></i>
            </a>
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
                
                <button type="button" id="blokir" name="blokir" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#ModalPinj">
                    Buka Blokir
                </button>

            @elseif ($status === 'A')
                @if ($tgl_kondisi->greaterThan($tgl_hitung))
                    <p class="text-success fw-bold">Anggota Aktif</p>
                @else
                    <p class="text-warning fw-bold">
                        Anggota Tidak Aktif sejak {{ $tgl_kondisi->format('d-m-Y') }}
                    </p>
                    
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPerpanjang">
                        Perpanjang Keanggotaan
                    </button>
                    
                    <button type="button" id="riwayat_anggota" name="riwayat_anggota" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModalPinj">
                        Riwayat Pembayaran Keanggotaan
                    </button>
                @endif

            @else
                <p class="text-secondary fw-bold">YBS Belum Terdaftar sebagai anggota.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDaftarAnggota" data-id="{{ $anggota->id ?? '' }}">
                  Daftarkan Anggota
                </button>
            @endif
        </div>
    </div>

    <div class="card mb-3 text-center">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fa fa-user"></i></span>
            <span>|</span>
        </div>
        <div class="card-body">
            @php
                // Cek dulu apakah $anggota ada
                if ($anggota) {
                    $fotoPath = "../assets/img/{$anggota->foto}.jpg";
                    $defaultFoto = $anggota->jk == 'L' ? '../assets/img/male.jpg' : '../assets/img/female.jpg';
                } else {
                    $nik = request()->route('nik');
                    $tanggalNIK = intval(substr($nik, 6, 2));
                    $jk = $tanggalNIK >= 40 ? 'P' : 'L';

                    $fotoPath = "../assets/img/kosong.jpg";
                    $defaultFoto = $jk == 'L' ? '../assets/img/male.jpg' : '../assets/img/female.jpg';
                }

            @endphp
            
            <img src="{{ file_exists(public_path($fotoPath)) ? asset($fotoPath) : asset($defaultFoto) }}" class="img-thumbnail w-50" alt="Foto Nasabah"> 
            <br/>
            <br/>
            <button type="button" class="btn btn-sm btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#ModalFoto">
                AMBIL FOTO
            </button>
            

            <div class="d-grid gap-2 mt-3">
                <button id="simpan_data" name="simpan_data" class="btn btn-primary btn-sm btn-simpan-angg" data-target="#FormPenduduk">SIMPAN DATA</button>
                <a href="/a" 
                   class="btn btn-outline-secondary btn-sm" 
                   target="_blank" 
                   {{ !$anggota ? 'disabled' : '' }}>
                   Cetak Kartu Anggota
                </a>
                <button class="btn btn-outline-danger btn-sm" {{ !$anggota ? 'disabled' : '' }}>Black List NIK</button>
            </div>
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
                        @if ($simpanan && $simpanan->count() > 0)
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
                <button type="button" class="btn btn-sm btn-white" data-bs-toggle="modal" data-bs-target="#ModalPinj">
                    Tambah Pinjaman
                </button>

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
                        @if ($pinjaman && $pinjaman->count() > 0)
                            @foreach ($pinjaman as $pinj)
                                <tr class="fw-normal" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetailProposalIndividu" id="DetailProposalIndividu{{$pinj->id}}">
                                    <td>{{ $pinj->id }}</td>
                                    <td>{{ $pinj->tgl_cair }}</td>
                                    <td>{{ number_format($pinj->alokasi ?? 0) }}</td>
                                    <td>{{ number_format($pinj->saldo->saldo_pokok ?? 0) }}</td>
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
