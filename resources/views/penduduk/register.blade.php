@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="bg-primary text-white p-3 rounded">
                    <h5 class="mb-0 text-white">
                        <i class="fa fa-address-card text-white"></i> Keanggotaan
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
        $('.date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });

        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#cari_nik').focus();

            $('#cari_nik').on('input', function() {
                let nik = $(this).val().replace(/\D/g, ''); // hanya angka
                $(this).val(nik);

                const msg = $('#nik_message');

                if (nik.length === 0) {
                    msg.text("* Silahkan ketik/Scan NIK").removeClass('text-primary').addClass(
                        'text-danger');
                } else if (nik.length < 16) {
                    msg.text("Pastikan NIK berjumlah 16 digit").removeClass('text-primary').addClass(
                        'text-danger');
                } else if (nik.length === 16) {
                    msg.text("Mohon menunggu ").removeClass('text-danger').addClass('text-primary');

                    let dots = 0;
                    const waitingInterval = setInterval(() => {
                        dots = (dots + 1) % 4;
                        const loadingText = "Mohon menunggu " + ". ".repeat(dots);
                        msg.text(loadingText);
                    }, 500);
                    msg.data('waitingInterval', waitingInterval);

                    $.ajax({
                        url: `/anggota/load-form/${nik}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            clearInterval(msg.data('waitingInterval'));
                            msg.text(""); // valid
                            $('#isi_kiri').html(res.html_kiri);
                            $('#isi_kanan').html(res.html_kanan);
                            $('#namadepan').focus();
                        },
                        error: function() {
                            msg.text("❌ Terjadi kesalahan saat mengambil data.").addClass(
                                'text-danger');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-simpan-angg', function(e) {
            e.preventDefault();
    console.log('Button clicked');
            $('small.text-danger').text('');

            let btn = $(this);
            let originalText = btn.html();
    var form = $('#FormPenduduk');
    console.log('Form data:', form.serialize());

            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                    );
                },
                success: function(res) {
                    btn.prop('disabled', false).html(originalText);
    
                    console.log('Response:', res); // Untuk debug
    
                    if (res.success === true) {
                        toastr.success(res.msg);
                        $('#isi_kiri').html(res.html_kiri);
                        $('#isi_kanan').html(res.html_kanan);
                        $('#namadepan').focus();
                    } else if (res.success === false) {
                        toastr.warning(res.msg || 'Proses gagal, silakan coba lagi');
                    } else {
                        toastr.info('Respons tidak valid dari server');
                        console.error('Invalid response structure:', res);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            $('#msg_' + key).text(messages[0]);
                        });
                        toastr.warning('Silakan periksa kembali data yang diisi');
                    } else {
                        toastr.error('Terjadi kesalahan server');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        $(document).on('click', '#simpan_pokok', function(e) {
            e.preventDefault();
            $('small.text-danger').text('');

            let btn = $(this);
            let originalText = btn.html();
            var form = $('#formDaftarAnggota')

            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                    );
                },
                success: function(response) {
                    toastr.clear();
                    btn.text(originalText);

                    if (response.success) {
                        toastr.success(response.msg || 'Transaksi ' + (jenisMutasi == '1' ? 'setor' :
                            'tarik') + ' berhasil disimpan');
                        document.querySelectorAll('.modal.show').forEach(modalEl => {
                            const modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) modalInstance.hide();
                        });

                        if (response.html_kiri) $('#isi_kiri').html(response.html_kiri);
                        if (response.html_kanan) $('#isi_kanan').html(response.html_kanan);
                        $('#namadepan').focus();
                    } else {
                        toastr.warning(response.msg || 'Gagal menyimpan transaksi');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            $('#msg_' + key).text(messages[0]);
                        });
                        toastr.warning('Silakan periksa kembali data yang diisi');
                    } else {
                        toastr.error('Terjadi kesalahan server');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
        $(document).on('click', '#simpan_pinjaman', function(e) {
            e.preventDefault();
            console.log('Button simpan pinjaman clicked');
    
            $('small.text-danger').text('');

            let btn = $(this);
            let originalText = btn.html();
            var form = $('#formDaftarPinjaman');
    
            console.log('Form action:', form.attr('action'));
            console.log('Form data:', form.serialize());
    
            let nia = $('#nia_pinjaman').val();
            console.log('NIA value:', nia);
    
            if (!nia || nia === '') {
                toastr.error('NIA anggota tidak ditemukan. Silakan tutup modal dan coba lagi.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                beforeSend: function() {
                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                    );
                },
                success: function(response) {
                    console.log('Response:', response);
            
                    btn.prop('disabled', false).html(originalText);

                    if (response.success === true) {
                        toastr.success(response.msg || 'Data pinjaman berhasil disimpan');
                
                        let modal = bootstrap.Modal.getInstance(document.getElementById('ModalPinj'));
                        if (modal) {
                            modal.hide();
                        }
                
                        if (response.html_kiri) {
                            $('#isi_kiri').html(response.html_kiri);
                        }
                        if (response.html_kanan) {
                            $('#isi_kanan').html(response.html_kanan);
                        }
                
                        $('.date').datetimepicker({
                            timepicker: false,
                            format: 'd/m/Y'
                        });
                        $('.select2').select2({
                            theme: 'bootstrap4'
                        });
                
                        $('#namadepan').focus();
                    } else {
                        toastr.warning(response.msg || 'Gagal menyimpan data pinjaman');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
            
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            $('#msg_' + key).text(messages[0]);
                            console.log('Error for', key, ':', messages[0]);
                        });
                        toastr.warning('Silakan periksa kembali data yang diisi');
                    } else if (xhr.status === 301) {
                        let errors = xhr.responseJSON;
                        $.each(errors, function(key, messages) {
                            if (Array.isArray(messages)) {
                                $('#msg_' + key).text(messages[0]);
                            }
                        });
                        toastr.warning('Silakan periksa kembali data yang diisi');
                    } else {
                        toastr.error('Terjadi kesalahan server');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        $(document).on('keyup', '.keuangan', function() {
            let val = $(this).val();
            val = val.replace(/[^0-9.]/g, '');
            let parts = val.split('.');
            let integerPart = parts[0];
            let decimalPart = parts[1] ? parts[1].substring(0, 2) : '';
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            if (decimalPart.length > 0) {
                val = integerPart + '.' + decimalPart;
            } else {
                val = integerPart;
            }
            $(this).val(val);
        });

        $('#formDaftarPinjaman').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#modalDaftarAnggota').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let anggotaId = button.data('id');
    
            let modal = $(this);
            modal.find('input#nia').val(anggotaId);
    
            modal.find('form')[0].reset();
            modal.find('.text-danger').text('');
            modal.find('input#nia').val(anggotaId);
            modal.find('input#tgl_buka_rekening').val('{{ date("d/m/Y") }}');
    
            $('.date').datetimepicker({
                timepicker: false,
                format: 'd/m/Y'
            });
        });

        $('#modalPerpanjang').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let anggotaId = button.data('id');
            let jumlahDefault = button.data('jumlah') || 0;
    
            console.log('Modal Perpanjang opened with anggotaId:', anggotaId);
            console.log('Jumlah Default:', jumlahDefault);
    
            let modal = $(this);
            modal.find('input#nia_perpanjang').val(anggotaId);
            modal.find('input#jumlah_default').val(jumlahDefault);
    
            modal.find('.text-danger').text('');
    
            modal.find('input#tgl_transaksi_perpanjang').val('{{ date("d/m/Y") }}');
            modal.find('input#jumlah_perpanjang').val(formatRupiah(jumlahDefault));
    
            $('.date').datetimepicker({
                timepicker: false,
                format: 'd/m/Y'
            });
        });

        $(document).on('click', '#simpanPerpanjang', function(e) {
            e.preventDefault();
            console.log('Button simpan perpanjang clicked');
    
            $('small.text-danger').text('');

            let btn = $(this);
            let originalText = btn.html();
            var form = $('#formPerpanjang');
    
            let nia = $('#nia_perpanjang').val();
            console.log('NIA value:', nia);
    
            if (!nia || nia === '') {
                toastr.error('NIA anggota tidak ditemukan. Silakan tutup modal dan coba lagi.');
                return;
            }

            let jumlahInput = $('#jumlah_perpanjang').val();
            let jumlahBersih = jumlahInput.replace(/\./g, '').replace(/,/g, '');
    
            var formData = form.serializeArray();
    
            formData = formData.map(function(item) {
                if (item.name === 'jumlah') {
                    item.value = jumlahBersih;
                }
                return item;
            });
    
            console.log('Form data (cleaned):', $.param(formData));
            console.log('Jumlah bersih:', jumlahBersih);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: $.param(formData),
                beforeSend: function() {
                    btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                    );
                },
                success: function(response) {
                    console.log('Response:', response);
            
                    btn.prop('disabled', false).html(originalText);

                    if (response.success === true) {
                        toastr.success(response.msg || 'Perpanjangan keanggotaan berhasil');
                
                        // Tutup modal
                        let modal = bootstrap.Modal.getInstance(document.getElementById('modalPerpanjang'));
                        if (modal) {
                            modal.hide();
                        }
                
                        // Update view kiri dan kanan
                        if (response.html_kiri) {
                            $('#isi_kiri').html(response.html_kiri);
                        }
                        if (response.html_kanan) {
                            $('#isi_kanan').html(response.html_kanan);
                        }
                
                        // Re-initialize plugins
                        $('.date').datetimepicker({
                            timepicker: false,
                            format: 'd/m/Y'
                        });
                        $('.select2').select2({
                            theme: 'bootstrap4'
                        });
                
                        $('#namadepan').focus();
                    } else {
                        toastr.warning(response.msg || 'Gagal menyimpan perpanjangan');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
            
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            $('#msg_' + key).text(messages[0]);
                            console.log('Error for', key, ':', messages[0]);
                        });
                        toastr.warning('Silakan periksa kembali data yang diisi');
                    } else {
                        toastr.error('Terjadi kesalahan server');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Helper function format rupiah
        function formatRupiah(angka) {
            if (!angka) return '0';
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
    
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        $('#ModalPinj').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let anggotaId = button.data('id');
    
            console.log('Modal opened with anggotaId:', anggotaId); // Debug
    
            let modal = $(this);
            modal.find('input#nia_pinjaman').val(anggotaId);
    
            modal.find('form')[0].reset();
            modal.find('.text-danger').text('');
            modal.find('input#nia_pinjaman').val(anggotaId); 
    
            modal.find('input#tgl_proposal').val('{{ date("d/m/Y") }}');
            modal.find('input#jangka').val('12');
            modal.find('input#pros_jasa').val('1.75');
    
            $('.date').datetimepicker({
                timepicker: false,
                format: 'd/m/Y'
            });
    
            $('.select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#ModalPinj')
            });
        });
        $('#simpanTransaksiAnggota').click(function() {
            var jenisMutasi = '3';
            var tglTransaksi = $('#tgl_transaksi_anggota').val();
            var jumlah = $('#jumlah_anggota').val();
            var nia = $('#nia').val();

            if (!jenisMutasi || !tglTransaksi || !jumlah) {
                toastr.warning('Mohon lengkapi semua field.');
                return;
            }

            let loadingToast = toastr.info('Sedang memproses transaksi...', 'Mohon menunggu', {
                timeOut: 0,
                extendedTimeOut: 0,
                tapToDismiss: false,
                closeButton: false
            });

        $.ajax({
            url: '/simpanan/simpan-transaksi',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                jenis_mutasi: jenisMutasi,
                tgl_transaksi: tglTransaksi,
                jumlah: jumlah,
                nomor_rekening: nomorRekening,
                nama_debitur: namaDebitur,
                nia: nia
            },
            success: function(response) {
                toastr.clear(); 
                if (response.success) {
                    toastr.success('Transaksi ' + (jenisMutasi == '1' ? 'setor' : 'tarik') + ' berhasil disimpan');
                    refreshTransaksiContainer();
                    resetForm();
                } else {
                    toastr.error('Gagal menyimpan transaksi: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.clear(); 
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        $('#msg_' + key).text(messages[0]);
                    });
                    toastr.warning('Silakan periksa kembali data yang diisi');
                } else {
                    toastr.error('Terjadi kesalahan: ' + error);
                }
            }
        });
    });
    $('#modalSimpananUmum').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let anggotaId = button.data('id');
    
        console.log('Modal Simpanan Umum opened with anggotaId:', anggotaId);
    
        let modal = $(this);
        modal.find('input#nia_simpanan_umum').val(anggotaId);
    
        modal.find('form')[0].reset();
        modal.find('.text-danger').text('');
        modal.find('input#nia_simpanan_umum').val(anggotaId);
        modal.find('input#jenis_simpanan_umum').val('3');
    
        modal.find('input#tgl_buka_simpanan_umum').val('{{ date("d/m/Y") }}');
        modal.find('input#setoran_awal_umum').val('0');
        modal.find('input#bunga_umum').val('0');
        modal.find('input#pajak_bunga_umum').val('0');
        modal.find('input#admin_umum').val('0');
    
        $('#jabatan_container').hide();
    
        $('.date').datetimepicker({
            timepicker: false,
            format: 'd/m/Y'
        });
    
        $('.select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modalSimpananUmum')
        });
    });

    $(document).on('change', '#lembaga_umum', function() {
        if ($(this).is(':checked')) {
            $('#jabatan_container').slideDown();
            $('#jabatan_umum').attr('required', true);
        } else {
            $('#jabatan_container').slideUp();
            $('#jabatan_umum').attr('required', false).val('');
        }
    });

    $(document).on('click', '#simpan_simpanan_umum', function(e) {
        e.preventDefault();
        console.log('Button simpan simpanan umum clicked');
    
        $('small.text-danger').text('');

        let btn = $(this);
        let originalText = btn.html();
        var form = $('#formSimpananUmum');
    
        console.log('Form action:', form.attr('action'));
        console.log('Form data:', form.serialize());
    
        let nia = $('#nia_simpanan_umum').val();
        console.log('NIA value:', nia);
    
        if (!nia || nia === '') {
            toastr.error('NIA anggota tidak ditemukan. Silakan tutup modal dan coba lagi.');
            return;
        }

        var formData = form.serializeArray();
    
        var lembagaChecked = $('#lembaga_umum').is(':checked');
        var lembagaExists = formData.some(item => item.name === 'lembaga');
    
        if (!lembagaChecked && !lembagaExists) {
            formData.push({name: 'lembaga', value: '0'});
        }
    
        console.log('Form data with lembaga:', $.param(formData));

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: $.param(formData),
            beforeSend: function() {
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                );
            },
            success: function(response) {
                console.log('Response:', response);
            
                btn.prop('disabled', false).html(originalText);

                if (response.success === true) {
                    toastr.success(response.msg || 'Simpanan umum berhasil dibuat');
                
                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalSimpananUmum'));
                    if (modal) {
                        modal.hide();
                    }
                
                    if (response.html_kiri) {
                        $('#isi_kiri').html(response.html_kiri);
                    }
                    if (response.html_kanan) {
                        $('#isi_kanan').html(response.html_kanan);
                    }
                
                    $('.date').datetimepicker({
                        timepicker: false,
                        format: 'd/m/Y'
                    });
                    $('.select2').select2({
                        theme: 'bootstrap4'
                    });
                
                    $('#namadepan').focus();
                } else {
                    toastr.warning(response.msg || 'Gagal membuat simpanan umum');
                }
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, messages) {
                        $('#msg_' + key).text(messages[0]);
                        console.log('Error for', key, ':', messages[0]);
                    });
                    toastr.warning('Silakan periksa kembali data yang diisi');
                } else {
                    toastr.error('Terjadi kesalahan server');
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

</script>
@endsection

@section('modal')
    <div class="modal fade" id="modalDaftarAnggota" tabindex="-1" aria-labelledby="modalDaftarAnggotaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/simpanan_anggota" method="post" id="formDaftarAnggota" name="formDaftarAnggota">
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
                            <label for="tgl_buka_rekening" class="form-label">Tanggal Pendaftaran</label>
                            <input type="text" class="form-control date" id="tgl_buka_rekening" name="tgl_buka_rekening" value="{{ date('d/m/Y') }}" required>
                            <small class="text-danger" id="msg_tgl_buka_rekening"></small>
                        </div>
                    
                        <div class="mb-3">
                            <label for="setoran_awal" class="form-label">Simpanan Pokok</label>
                            <input type="text" class="form-control keuangan" id="setoran_awal" name="setoran_awal" value="0" required>
                            <small class="text-danger" id="msg_setoran_awal"></small>
                        </div>
                    
                        <div class="mb-3">
                            <label for="simpanan_wajib" class="form-label">Simpanan Wajib</label>
                            <input type="text" class="form-control keuangan" id="simpanan_wajib" name="simpanan_wajib" value="0" required>
                            <small class="text-danger" id="msg_simpanan_wajib"></small>
                        </div>
                    
                        <div class="mb-3">
                            <label for="biaya_administrasi" class="form-label">Biaya Administrasi</label>
                            <input type="text" class="form-control keuangan" id="biaya_administrasi" name="biaya_administrasi" value="0" required>
                            <small class="text-danger" id="msg_biaya_administrasi"></small>
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
        <div class="modal-dialog modal-lg modal-custom-height">
            <div class="modal-content">
                <div class="modal-header sticky-top bg-white">
                    <h5 class="modal-title" id="navsModalLabel">Register Pinjaman Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/perguliran_i" method="post" id="formDaftarPinjaman" name="formDaftarPinjaman">
                    @csrf
                    <input type="hidden" id="nia_pinjaman" name="nia" value="">
                
                    <div class="modal-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                                    type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                    Data Pengajuan Pinjaman
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                    type="button" role="tab" aria-controls="tab2" aria-selected="false">
                                    Laba Rugi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                    type="button" role="tab" aria-controls="tab3" aria-selected="false">
                                    Neraca Keuangan
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4"
                                    type="button" role="tab" aria-controls="tab4" aria-selected="false">
                                    Aspek Jaminan
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="myTabContent">
                            <!-- Tab 1: Data Pengajuan Pinjaman -->
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="jenis_produk_pinjaman" class="form-label">Jenis Produk Pinjaman</label>
                                            <select class="js-example-basic-single form-control" name="jenis_produk_pinjaman" id="jenis_produk_pinjaman" style="width: 100%;">
                                                @foreach ($jenis_pp as $jpp)
                                                <option value="{{ $jpp->id }}">
                                                    {{ $jpp->nama_jpp }} ({{ $jpp->deskripsi_jpp }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_jenis_produk_pinjaman"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="tgl_proposal" class="form-label">Tgl Proposal</label>
                                            <input autocomplete="off" type="text" name="tgl_proposal" id="tgl_proposal" 
                                                class="form-control date" value="{{ date('d/m/Y') }}">
                                            <small class="text-danger" id="msg_tgl_proposal"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="pengajuan" class="form-label">Pengajuan Rp.</label>
                                            <input autocomplete="off" type="text" name="pengajuan" id="pengajuan" class="form-control keuangan">
                                            <small class="text-danger" id="msg_pengajuan"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="sistem_angsuran_pokok" class="form-label">Sistem Angs. Pokok</label>
                                            <select class="select2 form-control" name="sistem_angsuran_pokok" id="sistem_angsuran_pokok" style="width: 100%;">
                                                @foreach ($sistem_angsuran as $sa)
                                                <option value="{{ $sa->id }}">
                                                    {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_sistem_angsuran_pokok"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="jangka" class="form-label">Jangka (Bulan)</label>
                                            <input autocomplete="off" type="number" name="jangka" id="jangka"
                                                class="form-control" value="12">
                                            <small class="text-danger" id="msg_jangka"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="position-relative mb-3">
                                            <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                                            <input autocomplete="off" type="number" name="pros_jasa" id="pros_jasa"
                                                class="form-control" value="1.75" step="0.01">
                                            <small class="text-danger" id="msg_pros_jasa"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="sistem_angsuran_jasa" class="form-label">Sistem Angs. Jasa</label>
                                            <select class="select2 form-control" name="sistem_angsuran_jasa"
                                                id="sistem_angsuran_jasa" style="width: 100%;">
                                                @foreach ($sistem_angsuran as $sa)
                                                <option value="{{ $sa->id }}">
                                                    {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="msg_sistem_angsuran_jasa"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Laba Rugi -->
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <div class="row">
                                    <div class="col-md-6 border-end">
                                        <div class="position-relative mb-3">
                                            <label class="form-label fw-bold">PENDAPATAN</label>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pendapatan1" class="form-label">Penghasilan Pemohon</label>
                                            <input autocomplete="off" type="text" name="pendapatan1" id="pendapatan1" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pendapatan1"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pendapatan2" class="form-label">Penghasilan Suami/Istri</label>
                                            <input autocomplete="off" type="text" name="pendapatan2" id="pendapatan2" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pendapatan2"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pendapatan3" class="form-label">Penghasilan Lainnya</label>
                                            <input autocomplete="off" type="text" name="pendapatan3" id="pendapatan3" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pendapatan3"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 border-start">
                                        <div class="position-relative mb-3">
                                            <label class="form-label fw-bold">BIAYA</label>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya1" class="form-label">Pangan</label>
                                            <input autocomplete="off" type="text" name="biaya1" id="biaya1" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya1"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya2" class="form-label">Sandang</label>
                                            <input autocomplete="off" type="text" name="biaya2" id="biaya2" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya2"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya3" class="form-label">Listrik & Air</label>
                                            <input autocomplete="off" type="text" name="biaya3" id="biaya3" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya3"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya4" class="form-label">Telpon & Internet</label>
                                            <input autocomplete="off" type="text" name="biaya4" id="biaya4" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya4"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya5" class="form-label">Biaya Pendidikan</label>
                                            <input autocomplete="off" type="text" name="biaya5" id="biaya5" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya5"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya6" class="form-label">Angsuran Bank Lain</label>
                                            <input autocomplete="off" type="text" name="biaya6" id="biaya6" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya6"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="biaya7" class="form-label">Biaya Lainnya</label>
                                            <input autocomplete="off" type="text" name="biaya7" id="biaya7" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_biaya7"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Neraca Keuangan -->
                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                <div class="row">
                                    <div class="col-md-6 border-end">
                                        <div class="position-relative mb-3">
                                            <label class="form-label fw-bold">AKTIVA</label>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva1" class="form-label">Uang Tunai</label>
                                            <input autocomplete="off" type="text" name="aktiva1" id="aktiva1" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva1"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva2" class="form-label">Simpanan</label>
                                            <input autocomplete="off" type="text" name="aktiva2" id="aktiva2" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva2"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva3" class="form-label">Kendaraan</label>
                                            <input autocomplete="off" type="text" name="aktiva3" id="aktiva3" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva3"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva4" class="form-label">Tanah</label>
                                            <input autocomplete="off" type="text" name="aktiva4" id="aktiva4" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva4"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva5" class="form-label">Bangunan</label>
                                            <input autocomplete="off" type="text" name="aktiva5" id="aktiva5" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva5"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="aktiva6" class="form-label">Aktiva Lain-lain</label>
                                            <input autocomplete="off" type="text" name="aktiva6" id="aktiva6" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_aktiva6"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 border-start">
                                        <div class="position-relative mb-3">
                                            <label class="form-label fw-bold">PASIVA</label>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pasiva1" class="form-label">Pinjaman Pribadi</label>
                                            <input autocomplete="off" type="text" name="pasiva1" id="pasiva1" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pasiva1"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pasiva2" class="form-label">Pinjaman</label>
                                            <input autocomplete="off" type="text" name="pasiva2" id="pasiva2" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pasiva2"></small>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="pasiva3" class="form-label">Pinjaman Bank</label>
                                            <input autocomplete="off" type="text" name="pasiva3" id="pasiva3" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_pasiva3"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 4: Aspek Jaminan -->
                            <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="position-relative mb-3">
                                            <label class="form-label fw-bold">JAMINAN</label>
                                            <p class="text-muted">Dari Permohonan Pinjaman ini, Dijaminkan Harta/Benda Berupa:</p>
                                        </div>
                                        <div class="position-relative mb-3">
                                            <label for="jaminan" class="form-label">Deskripsi Jaminan:</label>
                                            <textarea name="jaminan" id="jaminan" class="form-control" rows="4" autocomplete="off" 
                                                placeholder="Tuliskan deskripsi jaminan selengkap mungkin, misalnya : nomor sertifikat, type, merk, nomor rangka, nomor kepemilikan dan yang lainnya"></textarea>
                                            <small class="text-danger" id="msg_jaminan"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="nilai_jaminan" class="form-label">Estimasi Nilai Jual Rp.:</label>
                                            <input autocomplete="off" type="text" name="nilai_jaminan" id="nilai_jaminan" class="form-control keuangan" value="0">
                                            <small class="text-danger" id="msg_nilai_jaminan"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer sticky-bottom bg-white">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="simpan_pinjaman" name="simpan_pinjaman">Simpan Registrasi Pinjaman</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalSimpananUmum" tabindex="-1" aria-labelledby="modalSimpananUmumLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/simpanan" method="post" id="formSimpananUmum" name="formSimpananUmum">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSimpananUmumLabel">Form Simpanan Umum</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="jenis_simpanan_umum" name="jenis_simpanan" value="3">
                        <input type="hidden" id="nia_simpanan_umum" name="nia" value="">
                    
                        <div class="mb-3">
                            <label for="tgl_buka_simpanan_umum" class="form-label">Tanggal Pembukaan Rekening</label>
                            <input type="text" class="form-control date" id="tgl_buka_simpanan_umum" name="tgl_buka_rekening" value="{{ date('d/m/Y') }}" required>
                            <small class="text-danger" id="msg_tgl_buka_rekening"></small>
                        </div>
                    
                        <div class="mb-3">
                            <label for="setoran_awal_umum" class="form-label">Setoran Awal</label>
                            <input type="text" class="form-control keuangan" id="setoran_awal_umum" name="setoran_awal" value="0" required>
                            <small class="text-danger" id="msg_setoran_awal"></small>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="bunga_umum" class="form-label">Bunga (%)</label>
                                <input type="number" class="form-control" id="bunga_umum" name="bunga" value="0" step="0.01">
                                <small class="text-danger" id="msg_bunga"></small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pajak_bunga_umum" class="form-label">Pajak (%)</label>
                                <input type="number" class="form-control" id="pajak_bunga_umum" name="pajak_bunga" value="0" step="0.01">
                                <small class="text-danger" id="msg_pajak_bunga"></small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="admin_umum" class="form-label">Biaya Admin</label>
                                <input type="text" class="form-control keuangan" id="admin_umum" name="admin" value="0">
                                <small class="text-danger" id="msg_admin"></small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lembaga_umum" name="lembaga" value="1">
                                <label class="form-check-label" for="lembaga_umum">
                                    Simpanan Lembaga
                                </label>
                            </div>
                            <small class="text-muted">Centang jika simpanan ini milik lembaga/organisasi</small>
                        </div>

                        <div class="mb-3" id="jabatan_container" style="display: none;">
                            <label for="jabatan_umum" class="form-label">Jabatan di Lembaga</label>
                            <input type="text" class="form-control" id="jabatan_umum" name="jabatan" placeholder="Contoh: Ketua, Bendahara, dll">
                            <small class="text-danger" id="msg_jabatan"></small>
                        </div>

                        <div class="mb-3">
                            <label for="pengampu_umum" class="form-label">Pengampu / Ahli Waris</label>
                            <input type="text" class="form-control" id="pengampu_umum" name="pengampu" placeholder="Nama pengampu atau ahli waris">
                            <small class="text-danger" id="msg_pengampu"></small>
                        </div>

                        <div class="mb-3">
                            <label for="hubungan_umum" class="form-label">Hubungan dengan Pengampu</label>
                            <select class="form-control select2" id="hubungan_umum" name="hubungan">
                                <option value="">-- Pilih Hubungan --</option>
                                <option value="Suami/Istri">Suami/Istri</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Anak">Anak</option>
                                <option value="Saudara Kandung">Saudara Kandung</option>
                                <option value="Keluarga Lain">Keluarga Lain</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <small class="text-danger" id="msg_hubungan"></small>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_simpanan_umum" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan_simpanan_umum" name="catatan_simpanan" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                            <small class="text-danger" id="msg_catatan_simpanan"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success" id="simpan_simpanan_umum" name="simpan_simpanan_umum">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPerpanjang" tabindex="-1" aria-labelledby="modalPerpanjangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/simpanan/perpanjang" method="post" id="formPerpanjang" name="formPerpanjang">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPerpanjangLabel">Perpanjang Keanggotaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="nia_perpanjang" name="nia" value="">
                        <input type="hidden" id="jumlah_default" name="jumlah_default" value="">
                    
                        <div class="mb-3">
                            <label for="tgl_transaksi_perpanjang" class="form-label">Tanggal Transaksi</label>
                            <input type="text" name="tgl_transaksi" id="tgl_transaksi_perpanjang"
                                class="date form-control" value="{{ date('d/m/Y') }}" required>
                            <small class="text-danger" id="msg_tgl_transaksi"></small>
                        </div>
                    
                        <div class="mb-3">
                            <label for="jumlah_perpanjang" class="form-label">Jumlah</label>
                            <input type="text" name="jumlah" id="jumlah_perpanjang" class="form-control keuangan"
                                value="0" required>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Kosongkan atau isi 0 untuk menggunakan jumlah default dari simpanan wajib
                            </small>
                            <small class="text-danger" id="msg_jumlah"></small>
                        </div>
                    
                        <div class="alert alert-info">
                            <strong>Info:</strong> Perpanjangan keanggotaan akan menambah saldo simpanan wajib Anda.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" name="simpanPerpanjang" id="simpanPerpanjang"
                            class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
