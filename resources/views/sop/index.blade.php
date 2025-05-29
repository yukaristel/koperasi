@extends('layouts.app')

@section('content')
<style>
    .btn-white-custom {
        display: flex;
        align-items: center;
        background-color: rgb(253, 12, 12);
        color: black;
        border-color: #ffffff;
        /* Menjaga warna border asli */
    }

    .btn-white-custom:hover,
    .btn-white-custom:focus,
    .btn-white-custom.active {
        background-color: #202b3c;
        /* Warna asli saat aktif atau hover */
        color: rgb(255, 250, 250);
    }

    .left-align {
        display: flex;
        align-items: center;
    }

    .left-align span {
        font-size: 14px;
        /* Adjust the text size as needed */
    }
    .btn:focus {
      box-shadow: none !important;
    }

</style>

<div class="app-main__inner">

    <div class="tab-content">
        <div class="tab-pane  fade show active" id="" role="tabpanel">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="main-card card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Pengaturan</h5>
                            <div class="nav flex-column nav-pills gap-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="btn btn-outline-primary w-100 text-start active text-nowrap" id="wellcome"
                                    data-bs-toggle="tab" href="#tab-content-0" role="tab">
                                    <i class="fa-solid fa-home"></i>&nbsp; Welcome
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="lembaga"
                                    data-bs-toggle="tab" href="#tab-content-1" role="tab">
                                    <i class="fa-solid fa-tree-city"></i>&nbsp; Identitas Lembaga
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="pengelola"
                                    data-bs-toggle="tab" href="#tab-content-2" role="tab">
                                    <i class="fa-solid fa-person-chalkboard"></i>&nbsp; Sebutan Pengelola
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="peminjam"
                                    data-bs-toggle="tab" href="#tab-content-3" role="tab">
                                    <i class="fa-solid fa-chart-simple"></i>&nbsp; Sistem Pinjaman
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="perguliran"
                                    data-bs-toggle="tab" href="#tab-content-9" role="tab">
                                    <i class="fa-solid fa-vault"></i>&nbsp; Perguliran
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="simpanan"
                                    data-bs-toggle="tab" href="#tab-content-8" role="tab">
                                    <i class="fa-solid fa-vault"></i>&nbsp; Sistem Simpanan
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="asuransi"
                                    data-bs-toggle="tab" href="#tab-content-4" role="tab">
                                    <i class="fa-solid fa-money-bill-transfer"></i>&nbsp; Pengaturan Asuransi
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap"
                                    data-bs-toggle="tab" href="#tab-content-5" role="tab">
                                    <i class="fa-solid fa-laptop-file"></i>&nbsp; Redaksi SPK
                                </a>
                                <a class="btn btn-outline-primary w-100 text-start text-nowrap"
                                    data-bs-toggle="tab" href="#tab-content-6" role="tab">
                                    <i class="fa-solid fa-panorama"></i>&nbsp; Logo
                                </a>
                                {{-- <a class="btn btn-outline-primary w-100 text-start text-nowrap"
                                    data-bs-toggle="tab" href="#tab-content-7" role="tab">
                                    <i class="fa-solid fa-camera-rotate"></i>&nbsp; Whatsapp
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Wellcome !!</h5>
                                        @include('sop.partials._wellcome')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Identitas Lembaga</h5>
                                        @include('sop.partials._lembaga')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sebutan Pengelola Lembaga</h5>
                                        <div class="position-relative mb-3">
                                            @include('sop.partials._pengelola')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sistem Peminjam</h5>
                                        @include('sop.partials._pinjaman')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Asuransi</h5>
                                        @include('sop.partials._asuransi')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Redaksi Dokumen SPK</h5>
                                        @include('sop.partials._spk')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-6" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Upload LOGO</h5>
                                        @include('sop.partials._logo')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-7" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Whatsapp</h5>
                                        @include('sop.partials._whatsapp')
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="tab-content-8" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Simpanan</h5>
                                        @include('sop.partials._simpanan')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane tabs-animation fade" id="tab-content-9" role="tabpanel">
                            <div class="row">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Perguliran</h5>
                                        @include('sop.partials._perguliran')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<form action="/pengaturan/whatsapp/{{ $token }}" method="post" id="FormWhatsapp">
    @csrf
</form>
@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnTambah = document.getElementById('btnTambahTahapan');
        const daftar = document.getElementById('daftar-tahapan');
        const placeholder = daftar.querySelector('.tombol-tambah-placeholder');
        const max = 3;
        const sisaSlot = document.getElementById('sisaSlot');

        btnTambah.addEventListener('click', () => {
            const inputs = daftar.querySelectorAll('input[name="tahapan_baru[]"]');
            if (inputs.length >= max) return;

            const panah = document.createElement('div');
            panah.className = "text-center mb-1 panah";
            panah.innerHTML = `<i class="fas fa-arrow-down"></i>`;

            const wrapper = document.createElement('div');
            wrapper.className = "mb-3 d-flex gap-2 align-items-center";
            wrapper.innerHTML = `
                <input type="text" name="tahapan_baru[]" class="form-control" placeholder="Tahapan Baru">
                <button type="button" class="btn btn-danger btn-hapus-tahapan">-</button>
            `;

            daftar.insertBefore(panah, placeholder);
            daftar.insertBefore(wrapper, placeholder);

            updateSisa();
        });

        daftar.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-hapus-tahapan')) {
                const wrapper = e.target.closest('.mb-3');
                const panah = wrapper.previousElementSibling;

                if (panah && panah.classList.contains('panah')) {
                    panah.remove();
                }

                wrapper.remove();
                updateSisa();
            }
        });

        function updateSisa() {
            const jumlah = daftar.querySelectorAll('input[name="tahapan_baru[]"]').length;
            sisaSlot.textContent = max - jumlah;
        }
    });

    $(document).on('click', '.btn-simpan', function (e) {
        e.preventDefault();
    
        let btn = $(this);
        let targetForm = $($(this).data('target'));
        let formData = new FormData(targetForm[0]);
        let actionUrl = targetForm.attr('action');
        let method = targetForm.find('input[name="_method"]').val() || 'POST';

        // Hapus pesan error sebelumnya
        targetForm.find('small.text-danger').text('');
        $.ajax({
            url: actionUrl,
            method: 'POST', 
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                btn.prop('disabled', true).text('Menyimpan...');
            },
            success: function (res) {
                btn.prop('disabled', false).text('Simpan Perubahan');
                if (res.success) {
                    toastr.success(res.msg);
                } else {
                    toastr.warning('Data berhasil dikirim, tapi tidak ada respon sukses.');
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).text('Simpan Perubahan');
                if (xhr.status === 301 || xhr.status === 422) {
                    let errors = xhr.responseJSON;
                    $.each(errors, function (key, messages) {
                        $('#msg_' + key).text(messages[0]);
                    });
                } else {
                    // Kalau response JSON ada dan berbentuk object error pesan
                    if (xhr.responseJSON && typeof xhr.responseJSON === 'object') {
                        $.each(xhr.responseJSON, function(key, messages) {
                            $.each(messages, function(i, msg) {
                                toastr.warning(msg);
                            });
                        });
                    } else {
                        toastr.error('Terjadi kesalahan pada server.');
                    }
                }
            }

        });
    });
</script>
@endsection
