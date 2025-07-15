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

        .nav-pills .btn {
            padding: 10px 8px;
            font-size: 13px;
            margin-bottom: 12px;
            /* Jarak antar tombol */
        }

        .nav-pills .btn:last-child {
            margin-bottom: 0;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
        }
    </style>

    <div class="app-main__inner">

        <div class="tab-content">
            <div class="tab-pane  fade show active" id="" role="tabpanel">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="main-card card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Pengaturan</h5>
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="btn btn-outline-primary w-100 text-start active text-nowrap" id="wellcome"
                                        data-bs-toggle="tab" href="#tab-content-0" role="tab">
                                        <i class="fa-solid fa-house"></i>&nbsp; Welcome
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="lembaga"
                                        data-bs-toggle="tab" href="#tab-content-1" role="tab">
                                        <i class="fa-solid fa-building-columns"></i>&nbsp; Identitas Lembaga
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="pengelola"
                                        data-bs-toggle="tab" href="#tab-content-2" role="tab">
                                        <i class="fa-solid fa-user-tie"></i>&nbsp; Sebutan Pengelola
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="peminjam"
                                        data-bs-toggle="tab" href="#tab-content-3" role="tab">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>&nbsp; Sistem Pinjaman
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="perguliran"
                                        data-bs-toggle="tab" href="#tab-content-9" role="tab">
                                        <i class="fa-solid fa-recycle"></i>&nbsp; Perguliran
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="simpanan"
                                        data-bs-toggle="tab" href="#tab-content-8" role="tab">
                                        <i class="fa-solid fa-piggy-bank"></i>&nbsp; Sistem Simpanan
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" id="asuransi"
                                        data-bs-toggle="tab" href="#tab-content-4" role="tab">
                                        <i class="fa-solid fa-shield-heart"></i>&nbsp; Pengaturan Asuransi
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" data-bs-toggle="tab"
                                        href="#tab-content-5" role="tab">
                                        <i class="fa-solid fa-file-contract"></i>&nbsp; Redaksi SPK
                                    </a>
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" data-bs-toggle="tab"
                                        href="#tab-content-6" role="tab">
                                        <i class="fa-solid fa-image"></i>&nbsp; Logo
                                    </a>
                                    {{-- 
                                    <a class="btn btn-outline-primary w-100 text-start text-nowrap" data-bs-toggle="tab"
                                        href="#tab-content-7" role="tab">
                                        <i class="fa-solid fa-whatsapp"></i>&nbsp; Whatsapp
                                    </a>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Definisi toast global
        window.toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>

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

                const panah = Object.assign(document.createElement('div'), {
                    className: "text-center mb-1 panah",
                    innerHTML: `<i class="fas fa-arrow-down"></i>`
                });

                const wrapper = Object.assign(document.createElement('div'), {
                    className: "mb-3 d-flex gap-2 align-items-center",
                    innerHTML: `
                    <input type="text" name="tahapan_baru[]" class="form-control" placeholder="Tahapan Baru">
                    <button type="button" class="btn btn-danger btn-hapus-tahapan">-</button>
                `
                });

                daftar.insertBefore(panah, placeholder);
                daftar.insertBefore(wrapper, placeholder);
                updateSisa();
            });

            daftar.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn-hapus-tahapan')) {
                    const wrapper = e.target.closest('.mb-3');
                    const panah = wrapper.previousElementSibling;
                    if (panah ? .classList.contains('panah')) panah.remove();
                    wrapper.remove();
                    updateSisa();
                }
            });

            function updateSisa() {
                sisaSlot.textContent = max - daftar.querySelectorAll('input[name="tahapan_baru[]"]').length;
            }
        });
        $(document).on('click', '.btn-simpan', function(e) {
            e.preventDefault();

            let btn = $(this);
            let targetForm = $($(this).data('target'));
            let formData = new FormData(targetForm[0]);
            let actionUrl = targetForm.attr('action');
            let method = targetForm.find('input[name="_method"]').val() || 'POST';
            let originalText = btn.text();

            targetForm.find('small.text-danger').text('');

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: () => btn.prop('disabled', true).text('Menyimpan...'),
                success: res => {
                    btn.prop('disabled', false).text(originalText);

                    if (res.success) {
                        window.toastMixin.fire({
                            icon: 'success',
                            title: res.msg
                        });
                    } else {
                        window.toastMixin.fire({
                            icon: 'warning',
                            title: 'Data berhasil dikirim, tapi tidak ada respon sukses.'
                        });
                    }
                },
                error: xhr => {
                    btn.prop('disabled', false).text(originalText);

                    if (xhr.status === 301 || xhr.status === 422) {
                        $.each(xhr.responseJSON, (key, messages) => {
                            $('#msg_' + key).text(messages[0]);
                        });
                    } else if (xhr.responseJSON && typeof xhr.responseJSON === 'object') {
                        $.each(xhr.responseJSON, (key, messages) => {
                            $.each(messages, (_, msg) => {
                                window.toastMixin.fire({
                                    icon: 'warning',
                                    title: msg
                                });
                            });
                        });
                    } else {
                        window.toastMixin.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan pada server.'
                        });
                    }
                }
            });
        });
    </script>
@endsection
