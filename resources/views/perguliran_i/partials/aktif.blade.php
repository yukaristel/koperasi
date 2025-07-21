<div class="card mb-3">
    <div class="card-body">
            <div class="row mt-0">
                @include('perguliran_i.partials.proses')
            </div>
        <hr class="horizontal dark">
    </div>
</div>

<div class="card card-body p-2 pb-0 mb-3">
    <form action="/perguliran_i/dokumen?status=A" target="_blank" method="post">
        @csrf

        <input type="hidden" name="id" value="{{ $perguliran_i->id }}">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                <div class="d-grid">
                    <a href="/perguliran_i/dokumen/kartu_angsuran/{{ $perguliran_i->id }}" target="_blank"
                        class="btn btn-outline-info btn-sm mb-2">Kartu Angsuran</a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-info btn-sm mb-2" name="report"
                        value="rencanaAngsuran#pdf">Rencana Angsuran</button>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-info btn-sm mb-2" name="report"
                        value="rekeningKoran#pdf">Rekening Koran</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card card-body p-2 pb-0 mb-3">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <div class="d-grid">
                <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenProposal"
                    class="btn btn-info btn-sm mb-2">Cetak Dokumen Proposal</button>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="d-grid">
                <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenPencairan"
                    class="btn btn-info btn-sm mb-2">Cetak Dokumen Pencairan</button>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body pb-2">
        <h5 class="mb-1">
            Riwayat Angsuran
        </h5>

        <div class="table-responsive">
            <table class="table table-striped align-items-center mb-0" width="100%">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>#</th>
                        <th>Tgl transaksi</th>
                        <th>Pokok</th>
                        <th>Jasa</th>
                        <th>Saldo Pokok</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perguliran_i->real_i as $real)
                        <tr>
                            <td align="center">{{ $loop->iteration }}</td>
                            <td align="center">{{ Tanggal::tglIndo($real->tgl_transaksi) }}</td>
                            <td align="right">{{ number_format($real->realisasi_pokok) }}</td>
                            <td align="right">{{ number_format($real->realisasi_jasa) }}</td>
                            <td align="right">{{ number_format($real->saldo_pokok) }}</td>
                            <td align="center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-instagram btn-icon-only btn-tooltip"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="btn-inner--icon"><i class="fas fa-file"></i></span>
                                    </button>
                                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item border-radius-md" target="_blank"
                                                href="/transaksi/dokumen/struk/{{ $real->id }}">
                                                Kuitansi
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item border-radius-md" target="_blank"
                                                href="/transaksi/dokumen/struk_matrix/{{ $real->id }}">
                                                Kuitansi Dot Matrix
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item border-radius-md" target="_blank"
                                                href="/transaksi/dokumen/struk_thermal/{{ $real->id }}">
                                                Kuitansi Thermal
                                            </a>
                                        </li>
                                    </ul>
                                    <button type="button" class="btn btn-tumblr btn-icon-only btn-tooltip"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="btn-inner--icon"><i class="fas fa-file-invoice"></i></span>
                                    </button>
                                    <ul class="dropdown-menu px-2 py-3" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item border-radius-md" target="_blank"
                                                href="/perguliran/dokumen/kartu_angsuran/{{ $real->loan_id }}/{{ $real->id }}">
                                                Kelompok
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item border-radius-md" target="_blank"
                                                href="/perguliran/dokumen/cetak_kartu_angsuran_anggota/{{ $real->loan_id }}/{{ $real->id }}">
                                                Anggota
                                            </a>
                                        </li>
                                    </ul>
                                    <button type="button"
                                        data-action="/transaksi/dokumen/bkm_angsuran/{{ $real->transaksi->idt }}"
                                        class="btn btn-github btn-icon-only btn-tooltip btn-link"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="BKM"
                                        data-container="body" data-animation="true">
                                        <span class="btn-inner--icon"><i
                                                class="fas fa-file-circle-exclamation"></i></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if ($perguliran_i->status == 'A')
            <div class="d-flex justify-content-end mt-3">
                <button type="button" data-bs-toggle="modal" data-bs-target="#Rescedule"
                    class="btn btn-warning btn-sm"
                    @if (!in_array('perguliran.resceduling', Session::get('tombol', [])))
                        disabled
                    @endif
                >Resceduling Pinjaman</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#Penghapusan"
                    class="btn btn-danger btn-sm ms-1"
                    @if (!in_array('perguliran.penghapusan', Session::get('tombol', [])))
                        disabled
                    @endif
                >Penghapusan Pinjaman</button>
            </div>
        @endif
    </div>
</div>
