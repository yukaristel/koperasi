@extends('layouts.app')

@section('content')
    <style>
        /* Hilangkan branding TinyMCE */
        .tox .tox-promotion,
        .tox .tox-statusbar__branding {
            display: none !important;
        }
    </style>

    <div class="app-main__inner">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Tanda Tangan <b>Pelaporan</b></h5>

                                <form action="/pengaturan/sop/simpanttdpelaporan" method="post" id="formTtdPelaporan">
                                    @csrf
                                    <input type="hidden" name="field" id="field" value="tanda_tangan_pelaporan">
                                    <textarea class="tiny-mce-editor" name="tanda_tangan" id="tanda_tangan" rows="20">
                                        @if ($kec->ttd)
{!! json_decode($kec->ttd->tanda_tangan_pelaporan, true) !!}
@endif
                                    </textarea>
                                </form>

                                @if (!$tanggal)
                                    <small class="text-danger">
                                        Masukkan <span style="text-transform: lowercase">
                                            *{tanggal}* pada form tanda tangan untuk menuliskan tanggal laporan dibuat.
                                            <b>Hapus tanda bintang (*)</b>
                                        </span>
                                    </small>
                                @endif

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" id="simpanTtdPelaporan" class="btn btn-dark btn-sm ms-2">
                                        Simpan Perubahan
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br><br><br>
@endsection

@section('modal')
    <div class="modal fade" id="kataKunci" tabindex="-1" aria-labelledby="kataKunciLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="kataKunciLabel">Kata Kunci</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped midle">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="10">No</th>
                                <th width="100">Kata Kunci</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Kosongkan atau isi sesuai kebutuhan --}}
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#simpanTtdPelaporan', function(e) {
            e.preventDefault()

            tinymce.triggerSave()
            var form = $('#formTtdPelaporan')
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.success) {
                        Toastr('success', result.msg)
                    }
                }
            })
        })
    </script>
@endsection
