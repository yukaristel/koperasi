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
                    <input type="text" class="form-control form-control-lg mb-2 fs-3 fw-bold" id="cari_nik" placeholder="Masukkan Nomor Induk Kependudukan (NIK)" maxlength="16" inputmode="numeric" pattern="[0-9]*" oninput="validateNik(this)" onclick="this.select()">
                    <small id="nik_message" class="text-danger">* Silahkan ketik/Scan NIK</small>
                    <hr>
                    <div id="isi_kiri">
                        <h6 class="fw-bold">1. IDENTITAS NASABAH</h6>
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label class="form-label">NIA</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-10 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
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
                                    <label class="form-label">Jenis Usaha</label>
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
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-users"></i> Status Keanggotaan
                        </div>
                        <a href="URL-DOKUMEN" target="_blank" class="text-white" title="Form Anggota">
                            <i class="fa fa-file-alt"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <span class="text-danger">&nbsp;</span>
                    </div>
                </div>
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
                msg.text("* Silahkan ketik/Scan NIK").removeClass('text-primary').addClass('text-danger');
            } else if (nik.length < 16) {
                msg.text("Pastikan NIK berjumlah 16 digit").removeClass('text-primary').addClass('text-danger');
            } else if (nik.length === 16) {
                    msg.text("Mohon menunggu ").removeClass('text-danger').addClass('text-primary');
    
                    let dots = 0;
                    const waitingInterval = setInterval(() => {
                        dots = (dots + 1) % 4;
                        const loadingText = "Mohon menunggu " + ". ".repeat(dots);
                        msg.text(loadingText);
                    }, 500); 
                    msg.data('waitingInterval', waitingInterval);

                // AJAX load ke controller
                $.ajax({
                    url: `/anggota/load-form/${nik}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        clearInterval(msg.data('waitingInterval'));
                        msg.text(""); // valid
                        $('#isi_kiri').html(res.html_kiri);
                        $('#isi_kanan').html(res.html_kanan);
                        $('#namadepan').focus();
                    },
                    error: function () {
                        msg.text("❌ Terjadi kesalahan saat mengambil data.").addClass('text-danger');
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-simpan-angg', function (e) {
        e.preventDefault();
        $('small.text-danger').text('');

        let btn = $(this);
        let originalText = btn.html();
        var form = $('#FormPenduduk')

        $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
            beforeSend: function () {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function (res) {
                btn.prop('disabled', false).text(originalText);
                if (res.success) {
                    toastr.success(res.msg);
                    $('#isi_kiri').html(res.html_kiri);
                    $('#isi_kanan').html(res.html_kanan);
                    $('#namadepan').focus();
                } else {
                    toastr.warning(res.msg || 'Proses berhasil tetapi ada peringatan');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        $('#msg_' + key).text(messages[0]);
                    });
                    toastr.warning('Silakan periksa kembali data yang diisi');
                } else {
                    toastr.error('Terjadi kesalahan server');
                }
            },
            complete: function () {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    $(document).on('click', '#simpan_pokok', function (e) {
        e.preventDefault();
        $('small.text-danger').text('');

        let btn = $(this);
        let originalText = btn.html();
        var form = $('#formDaftarAnggota')

        $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
            beforeSend: function () {
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function (res) {
                btn.text(originalText);
                if (res.success) {
                    toastr.success(res.msg);
                    document.querySelectorAll('.modal.show').forEach(modalEl => {
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                    });
                    $('#isi_kiri').html(res.html_kiri);
                    $('#isi_kanan').html(res.html_kanan);
                    $('#namadepan').focus();
                } else {
                    toastr.warning(res.msg || 'Proses berhasil tetapi ada peringatan');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        $('#msg_' + key).text(messages[0]);
                    });
                    toastr.warning('Silakan periksa kembali data yang diisi');
                } else {
                    toastr.error('Terjadi kesalahan server');
                }
            },
            complete: function () {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    $('#modalDaftarAnggota').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); 
        let anggotaId = button.data('id'); 

        let modal = $(this);
        modal.find('input#nia').val(anggotaId); 
    });

</script>
@endsection

@section('modal')

<div class="modal fade" id="modalDaftarAnggota" tabindex="-1" aria-labelledby="modalDaftarAnggotaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/simpanan" method="post" id="formDaftarAnggota" name="formDaftarAnggota">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDaftarAnggotaLabel">Form Daftar Anggota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          @csrf
            <input type="hidden" id="jenis_simpanan" name="jenis_simpanan" value="1">
            <input type="hidden" id="nia" name="nia" value="">
            <input type="hidden" id="bunga" name="bunga" value="0">
            <input type="hidden" id="pajak_bunga" name="pajak_bunga" value="0">
            <input type="hidden" id="admin" name="admin" value="0">
          <div class="mb-3">
            <label for="tanggal_buka" class="form-label">Tanggal Pendaftaran</label>
            <input type="date" class="form-control" name="tgl_buka_rekening" required>
                <small class="text-danger" id="msg_tgl_buka_rekening"></small>
        </div>
          <div class="mb-3">
            <label for="simpanan_pokok" class="form-label">Simpanan Pokok</label>
            <input type="text" class="form-control keuangan" id="setoran_awal" name="setoran_awal" required>
          </div>
          <div class="mb-3">
            <label for="simpanan_wajib" class="form-label">Simpanan Wajib</label>
            <input type="text" class="form-control keuangan" id="simpanan_wajib" name="simpanan_wajib" required>
          </div>
          <div class="mb-3">
            <label for="biaya_administrasi" class="form-label">Biaya Administrasi</label>
            <input type="text" class="form-control keuangan" id="biaya_administrasi" name="biaya_administrasi" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-success" id="simpan_pokok" name="simpan_pokok">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalPinj" tabindex="-1" aria-labelledby="navsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="navsModalLabel">Modal dengan Tab Navigasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        {{-- Tabs --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
              type="button" role="tab" aria-controls="tab1" aria-selected="true">Tab 1</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
              type="button" role="tab" aria-controls="tab2" aria-selected="false">Tab 2</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
              type="button" role="tab" aria-controls="tab3" aria-selected="false">Tab 3</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4"
              type="button" role="tab" aria-controls="tab4" aria-selected="false">Tab 4</button>
          </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content mt-3" id="myTabContent">
          <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            Konten Tab 1
          </div>
          <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            Konten Tab 2
          </div>
          <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            Konten Tab 3
          </div>
          <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
            Konten Tab 4
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPerpanjang" tabindex="-1" aria-labelledby="modalPerpanjangLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/transaksi" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPerpanjangLabel">Perpanjang Keanggotaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
