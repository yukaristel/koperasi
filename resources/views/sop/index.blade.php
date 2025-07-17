@extends('layouts.app')

@section('content')
    <style>
        .drive-sidebar {
            background: linear-gradient(to bottom, #3a8fff, #6fb1fc);
            border-radius: 10px;
            padding: 20px 10px;
            height: 100%;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            border: 2px solid rgba(224, 220, 220, 0.514);

        }

        .drive-sidebar .nav {
            background: transparent !important;
            padding: 0;
            margin: 0;
        }

        .drive-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin-bottom: 8px;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 700;
            border-radius: 20px 0 0 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
            background: transparent;
            position: relative;
        }

        .drive-sidebar .nav-link i {
            color: #ffffff !important;
            font-size: 15px;
        }

        .drive-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .drive-sidebar .nav-link.active {
            background-color: #ffffff !important;
            color: #000000 !important;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .drive-sidebar .nav-link.active *,
        .drive-sidebar .nav-link.active i {
            color: #000000 !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="drive-sidebar">
                    <div class="nav flex-column nav-pills" id="sidebar-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="wellcome" data-bs-toggle="tab" href="#tab-content-0" role="tab">
                            <i class="fa-solid fa-house"></i> Welcome
                        </a>
                        <a class="nav-link" id="lembaga" data-bs-toggle="tab" href="#tab-content-1" role="tab">
                            <i class="fa-solid fa-building-columns"></i> Identitas Lembaga
                        </a>
                        <a class="nav-link" id="pengelola" data-bs-toggle="tab" href="#tab-content-2" role="tab">
                            <i class="fa-solid fa-user-tie"></i> Sebutan Pengelola
                        </a>
                        <a class="nav-link" id="peminjam" data-bs-toggle="tab" href="#tab-content-3" role="tab">
                            <i class="fa-solid fa-hand-holding-dollar"></i> Sistem Pinjaman
                        </a>
                        <a class="nav-link" id="perguliran" data-bs-toggle="tab" href="#tab-content-9" role="tab">
                            <i class="fa-solid fa-recycle"></i> Perguliran
                        </a>
                        <a class="nav-link" id="simpanan" data-bs-toggle="tab" href="#tab-content-8" role="tab">
                            <i class="fa-solid fa-piggy-bank"></i> Sistem Simpanan
                        </a>
                        <a class="nav-link" id="asuransi" data-bs-toggle="tab" href="#tab-content-4" role="tab">
                            <i class="fa-solid fa-shield-heart"></i> Pengaturan Asuransi
                        </a>
                        <a class="nav-link" id="spk" data-bs-toggle="tab" href="#tab-content-5" role="tab">
                            <i class="fa-solid fa-file-contract"></i> Redaksi SPK
                        </a>
                        <a class="nav-link" id="logo" data-bs-toggle="tab" href="#tab-content-6" role="tab">
                            <i class="fa-solid fa-image"></i> Logo
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-content-0" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Welcome !!</h5>
                                @include('sop.partials._wellcome')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-1" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Identitas Lembaga</h5>
                                @include('sop.partials._lembaga')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-2" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sebutan Pengelola Lembaga</h5>
                                @include('sop.partials._pengelola')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-3" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sistem Peminjam</h5>
                                @include('sop.partials._pinjaman')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-4" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pengaturan Asuransi</h5>
                                @include('sop.partials._asuransi')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-5" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Redaksi Dokumen SPK</h5>
                                @include('sop.partials._spk')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-6" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Upload LOGO</h5>
                                @include('sop.partials._logo')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-7" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pengaturan Whatsapp</h5>
                                @include('sop.partials._whatsapp')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-8" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pengaturan Simpanan</h5>
                                @include('sop.partials._simpanan')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-content-9" role="tabpanel">
                        <div class="card">
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
    <form action="/pengaturan/whatsapp/{{ $token }}" method="post" id="FormWhatsapp">
        @csrf
    </form>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script>
        let editor;
        // CKEDITOR.replace('editor_spk');
        CKEDITOR.replace('editor_spk', {
            on: {
                instanceReady: function(evt) {
                    setTimeout(function() {
                        $('.cke_notification_warning').hide();
                    }, 100);
                }
            }
        });
        const toast = Swal.mixin({
            toast: true,
            icon: 'success',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        $(document).on('click', '.btn-simpan', function(e) {
            e.preventDefault();

            const btn = $(this);
            const form = $(btn.data('target'));
            const action = form.attr('action');
            const method = form.find('input[name="_method"]').val() || 'POST';

            $('textarea#spk').val(CKEDITOR.instances.editor_spk.getData());

            $.ajax({
                url: action,
                method: 'POST',
                data: new FormData(form[0]),
                processData: false,
                contentType: false,
                beforeSend: () => btn.prop('disabled', true).text('Menyimpan...'),
                success: res => {
                    btn.prop('disabled', false).text('Simpan Perubahan');
                    toast.fire({
                        icon: 'success',
                        title: res.msg || 'Berhasil'
                    });
                },
                error: xhr => {
                    btn.prop('disabled', false).text('Simpan Perubahan');
                    const res = xhr.responseJSON;
                    if (res && typeof res === 'object') {
                        Object.values(res).flat().forEach(msg => {
                            toast.fire({
                                icon: 'warning',
                                title: msg
                            });
                        });
                    } else {
                        toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan.'
                        });
                    }
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '#EditLogo', function(e) {
            e.preventDefault();
            $('#logo_kec').trigger('click');
        });

        $(document).on('change', '#logo_kec', function(e) {
            e.preventDefault();

            const file = this.files[0];
            if (!file) return;

            const form = $('#FormLogo')[0];
            const formData = new FormData(form);
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewSrc = e.target.result;

                $('.previewLogo').attr('src', previewSrc);
                $('.colored-shadow').css('background-image', `url(${previewSrc})`);
                $('.PreviewLogo').attr('src', previewSrc);
            };
            reader.readAsDataURL(file);

            $.ajax({
                type: 'POST',
                url: $('#FormLogo').attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success) {
                        const newFile = result.filename || file.name;
                        const newSrc = `/storage/logo/${newFile}?t=${new Date().getTime()}`;

                        setTimeout(() => {
                            $('.previewLogo').attr('src', newSrc);
                            $('.colored-shadow').css('background-image', `url(${newSrc})`);
                            $('.PreviewLogo').attr('src', newSrc);
                        }, 300);

                        Toastr('success', result.msg);
                    } else {
                        Toastr('error', result.msg || 'Upload gagal.');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Toastr('error', 'Terjadi kesalahan saat upload logo.');
                }
            });
        });
    </script>
@endsection
