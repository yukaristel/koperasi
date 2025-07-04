@extends('layouts.app')

@section('content')

<div class="container-fluid py-4 px-5">
    <div class="nav-wrapper position-relative end-0">
       <ul class="nav nav-pills nav-fill p-1 d-flex w-100" role="tablist">
          <li class="nav-item">
             <a class="nav-link mb-0 px-0 py-1 {{ $status == 'p' ? 'active' : '' }}" data-bs-toggle="tab" href="#Proposal" role="tab" aria-selected="true">
                <i class="fa-solid fa-file-circle-plus"></i><b>&nbsp;&nbsp;Proposal (P)</b>
             </a>
          </li>
          <li class="nav-item">
             <a class="nav-link mb-0 px-0 py-1 {{ $status == 'v' ? 'active' : '' }}" data-bs-toggle="tab" href="#Verified" role="tab" aria-selected="true">
                <i class="fa-solid fa-file-pen"></i><b>&nbsp;&nbsp;Verified (V)</b>
             </a>
          </li>

          @php
              $tahapanTambahan = json_decode($tambahan, true);
          @endphp

          @if(is_array($tahapanTambahan) && count($tahapanTambahan) > 0)
              @foreach($tahapanTambahan as $index => $nama)
                  @php
                      $versi = 'v' . ($index + 1);
                  @endphp
                  <li class="nav-item">
                      <a class="nav-link mb-0 px-0 py-1 {{ $status == $versi ? 'active' : '' }}" data-bs-toggle="tab" href="#Verified{{ $index + 1 }}" role="tab" aria-selected="true">
                          <i class="fa-solid fa-file-pen"></i>
                          <b>&nbsp;&nbsp;{{ $nama }} ({{ strtoupper($versi) }})</b>
                      </a>
                  </li>
              @endforeach
          @endif

          <li class="nav-item">
             <a class="nav-link mb-0 px-0 py-1 {{ $status == 'w' ? 'active' : '' }}" data-bs-toggle="tab" href="#Waiting" role="tab" aria-selected="true">
                <i class="fa-solid fa-clock-rotate-left"></i><b>&nbsp;&nbsp;Waiting (W)</b>
             </a>
          </li>
       </ul>
    </div>

        <style>
            @media (max-width: 576px) {
                .nav-item .nav-link {
                    display: flex;
                    justify-content: center;
                }
            }
        </style>
        

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade  {{ $status == 'p' ? 'show active' : '' }}" id="Proposal" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">

                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table align-items-center justify-content-center mb-0 table-hover " width="100%" id="TbProposal">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota P</th>
                                                <th>Desa</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Pengajuan</th>
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
            
            <div class="tab-pane tabs-animation fade{{ $status == 'v' ? 'show active' : '' }}" id="Verified" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 card">

                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbVerified">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota V</th>
                                                <th>Desa</th>
                                                <th>Tgl Verified</th>
                                                <th>Verifikasi</th>
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



            
            <div class="tab-pane tabs-animation fade{{ $status == 'v1' ? 'show active' : '' }}" id="Verified1" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 card">

                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbVerified1">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota V1</th>
                                                <th>Desa</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
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
            <div class="tab-pane tabs-animation fade{{ $status == 'v2' ? 'show active' : '' }}" id="Verified2" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 card">

                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbVerified2">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota V2</th>
                                                <th>Desa</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
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
            <div class="tab-pane tabs-animation fade{{ $status == 'v3' ? 'show active' : '' }}" id="Verified3" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3 card">

                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbVerified3">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota V3</th>
                                                <th>Desa</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
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








            <div class="tab-pane tabs-animation fade{{ $status == 'w' ? 'show active' : '' }}" id="Waiting" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbWaiting">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota W</th>
                                                <th>Desa</th>
                                                <th>Tgl Waiting</th>
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
            <div class="tab-pane tabs-animation fade{{ $status == 'a' ? 'show active' : '' }}" id="Aktif" role="tabpanel" >
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
            <div class="tab-pane tabs-animation fade{{ $status == 'l' ? 'show active' : '' }}" id="Lunas" role="tabpanel" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover table-click" width="100%" id="TbLunas">
                                        <thead>
                                            <tr>
                                                <th>Loan id</th>
                                                <th>Nama Anggota L</th>
                                                <th>Alamat</th>
                                                <th>Tgl Cair</th>
                                                <th>Verifikasi</th>
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
        var tbProposal = CreateTable('#TbProposal', '/perguliran_i/proposal', [ {
            data: 'id',
            name: 'id'
        }, {
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_proposal',
            name: 'tgl_proposal'
        }, {
            data: 'proposal',
            name: 'proposal'
        }, {
            data: 'jasa',
            name: 'jasa',
            orderable: false,
            searchable: false
        }])

        var tbVerified = CreateTable('#TbVerified', '/perguliran_i/verified', [{
            data: 'id',
            name: 'id'
        },{
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_verifikasi',
            name: 'tgl_verifikasi'
        }, {
            data: 'verifikasi',
            name: 'verifikasi'
        }, {
            data: 'jasa',
            name: 'jasa',
            orderable: false,
            searchable: false
        }])
        
        var tbVerified1 = CreateTable('#TbVerified1', '/perguliran_i/verified1', [{
            data: 'id',
            name: 'id'
        },{
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_verifikasi1',
            name: 'tgl_verifikasi1'
        }, {
            data: 'verifikasi1',
            name: 'verifikasi1'
        }, {
            data: 'jasa',
            name: 'jasa',
            orderable: false,
            searchable: false
        }])
        
        var tbVerified2 = CreateTable('#TbVerified2', '/perguliran_i/verified2', [{
            data: 'id',
            name: 'id'
        },{
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_verifikasi2',
            name: 'tgl_verifikasi2'
        }, {
            data: 'verifikasi2',
            name: 'verifikasi2'
        }, {
            data: 'jasa',
            name: 'jasa',
            orderable: false,
            searchable: false
        }])

        var tbVerified1 = CreateTable('#TbVerified3', '/perguliran_i/verified3', [{
            data: 'id',
            name: 'id'
        },{
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_verifikasi3',
            name: 'tgl_verifikasi3'
        }, {
            data: 'verifikasi3',
            name: 'verifikasi3'
        }, {
            data: 'jasa',
            name: 'jasa',
            orderable: false,
            searchable: false
        }])

        var tbWaiting = CreateTable('#TbWaiting', '/perguliran_i/waiting', [{
            data: 'id',
            name: 'id'
        },{
            data: 'anggota.namadepan',
            name: 'anggota.namadepan'
        }, {
            data: 'anggota.d.nama_desa',
            name: 'anggota.d.nama_desa'
        }, {
            data: 'tgl_tunggu',
            name: 'tgl_tunggu'
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

        $('#TbProposal').on('click', 'tbody tr', function(e) {
            var data = tbProposal.row(this).data();

            window.location.href = '/detail_i/' + data.id
        })

        $('#TbVerified').on('click', 'tbody tr', function(e) {
            var data = tbVerified.row(this).data();

            window.location.href = '/detail_i/' + data.id
        })

        $('#TbWaiting').on('click', 'tbody tr', function(e) {
            var data = tbWaiting.row(this).data();

            window.location.href = '/detail_i/' + data.id
        })
    </script>
@endsection
