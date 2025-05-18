@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="bg-primary text-white p-3 rounded">
                <h5 class="mb-0 text-white">
                    <i class="fa fa-address-card text-white"></i> Register Nasabah
                </h5>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- KIRI: Form -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <input type="text" class="form-control form-control-lg mb-2 fs-3 fw-bold" id="cari_nik" placeholder="Masukkan Nomor Induk Kependudukan (NIK)" maxlength="16" inputmode="numeric" pattern="[0-9]*" oninput="validateNik(this)">
                    <small id="nik_message" class="text-danger">* Silahkan ketik/Scan NIK</small>
                    <hr>
                    <div id="isi_kiri">
                        <h6 class="fw-bold">1. IDENTITAS NASABAH</h6>
                        <div class="row">
                            <div class="col-md-10 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" disabled>
                                    <option value="">Pilih</option>
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2 d-flex gap-2">
                                <div class="flex-fill">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" disabled>
                                </div>
                                <div class="flex-fill">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Desa/Kelurahan</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-label">Alamat KTP</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2 d-flex gap-2">
                                <div class="flex-fill">
                                    <label class="form-label">Jenis Kegiatan / Usaha</label>
                                    <select class="form-control" disabled>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                                <div class="flex-fill">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" disabled>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" class="form-control" disabled>
                            </div>

                        </div>
                        <hr>
                        <h6 class="fw-bold">2. IDENTITAS PENJAMIN / AHLI WARIS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">N I K</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Hubungan</label>
                                <input type="text" class="form-control" maxlength="16" disabled>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div id="isi_kanan">
                <div class="card mb-3 text-center">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-user"></i></span>
                        <span>|</span>
                    </div>
                    <div class="card-body">
                        <img src="../assets/img/male.jpg" class="img-thumbnail w-50" alt="Foto Nasabah">
                        <br/>
                        <button class="btn btn-sm btn-secondary mb-2" disabled>AMBIL FOTO</button>
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-primary btn-sm" disabled>SIMPAN DATA</button>
                            <button class="btn btn-outline-secondary btn-sm" disabled>Cetak Kartu Anggota</button>
                            <button class="btn btn-outline-black btn-sm" disabled>Black List NIK</button>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <div class="mb-2">
                            <i class="fa fa-users"></i> Status Keanggotaan
                        </div>
                    </div>
                    <div class="card-body">
                        <span class="text-danger">&nbsp;</span>
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
                        <span class="text-danger">YBS Tidak memiliki simpanan</span>
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
                        <span class="text-danger">YBS Tidak memiliki pinjaman</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#cari_nik').focus();

        $('#cari_nik').on('input', function () {
            let nik = $(this).val().replace(/\D/g, ''); // hanya angka
            $(this).val(nik);

            const msg = $('#nik_message');

            if (nik.length === 0) {
                msg.text("* Silahkan ketik/Scan NIK").addClass('text-danger');
            } else if (nik.length < 16) {
                msg.text("Pastikan NIK berjumlah 16 digit").addClass('text-danger');
            } else if (nik.length === 16) {
                msg.text(""); // valid

                // AJAX load ke controller
                $.ajax({
                    url: `/anggota/load-form/${nik}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        $('#isi_kiri').html(res.html_kiri);
                        $('#isi_kanan').html(res.html_kanan);
                        $('#nama_lengkap').focus();
                    },
                    error: function () {
                        msg.text("❌ Terjadi kesalahan saat mengambil data.").addClass('text-danger');
                    }
                });
            }
        });
    });
</script>
@endsection

