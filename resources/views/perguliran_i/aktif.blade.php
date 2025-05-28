@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-5">
    <style>
        @media (max-width: 576px) {
            .nav-item .nav-link {
                display: flex;
                justify-content: center;
            }
        }
    </style>

    <div class="tab-content">
        <!-- Aktif Tab -->
        <div class="tab-pane tabs-animation fade {{ $status == 'a' ? 'show active' : '' }}" id="Aktif" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <div class="table-responsive">
                                <table class="table table-flush table-hover table-click" width="100%" id="TbAktif">
                                    <thead>
                                        <tr>
                                            <th>Loan id</th>
                                            <th>Nama Anggota A</th>
                                            <th>Desa</th>
                                            <th>Tgl Cair</th>
                                            <th>Alokasi</th>
                                            <th>Jasa/Jangka</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card p-2">
            <div class="text-sm">
                @foreach($jenis_pp as $jpp)
                <small class="badge badge-{{$jpp->warna_jpp}}">{{$jpp->nama_jpp}}</small>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    var tbAktif = CreateTable('#TbAktif', '/perguliran_i/aktif', [{
        data: 'id',
        name: 'id'
    },{
        data: 'anggota.namadepan',
        name: 'anggota.namadepan'
    }, {
        data: 'anggota.d.nama_desa',
        name: 'anggota.d.nama_desa'
    }, {
        data: 'tgl_cair',
        name: 'tgl_cair'
    }, {
        data: 'alokasi',
        name: 'alokasi'
    }, {
        data: 'jasa',
        name: 'jasa',
        orderable: false,
        searchable: false
    }])

    function CreateTable(tabel, url, column) {
        var table = $(tabel).DataTable({
            language: {
                paginate: {
                    previous: "&laquo;",
                    next: "&raquo;"
                }
            },
            processing: true,
            serverSide: true,
            ajax: url,
            columns: column,
            order: [
                [2, 'desc']
            ]
        })

        return table
    }

    $('#TbAktif').on('click', 'tbody tr', function(e) {
        var data = tbAktif.row(this).data();

        window.location.href = '/detail_i/' + data.id
    })

</script>
@endsection
