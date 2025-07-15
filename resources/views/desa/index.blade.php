@extends('layouts.app')
@section('content')

<div class="container-fluid">
    {{-- HEADER --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="bg-primary text-white p-3 rounded">
                <h5 class="mb-0">
                    <i class="fa fa-house me-1"></i> Data Desa
                </h5>
            </div>
        </div>
    </div>

    {{-- KONTEN --}}
    <div class="container-fluid">
            <table id="desa-table" class="table align-items-center justify-content-center mb-0 table-hover hover">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7">Kode</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Nama Desa</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Telepon</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Kepala Desa</th>
                    </tr>
                </thead>
            </table><br>
            <div class="alert alert-info text-dark text-sm" role="alert">
                <strong>Info!</strong> Data desa ini digunakan untuk dokumen yang berhubungan dengan lembaga desa seperti dokumen persetujuan dan yang lainnya
            </div>
</div>


<!-- Modal untuk Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Desa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalEditContent">
        <!-- Form edit akan dimuat di sini melalui AJAX -->
        <div class="text-center">Loading...</div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const table = $('#desa-table').DataTable({
        language: {
            paginate: {
                previous: "<",
                next: ">"
            }
        },
        processing: true,
        serverSide: true,
        ajax: '/database/desa',
        columns: [
            { data: 'kode_desa', name: 'kode_desa' },
            { data: 'nama_desa', name: 'nama_desa' },
            { data: 'telp_desa', name: 'telp_desa' },
            { data: 'kades', name: 'kades' }
        ],
        responsive: true,
        order: [[1, 'asc']],
        columnDefs: [
            { targets: 0, className: 'fw-bold' }, 
            { targets: '_all', className: 'align-middle small' }, 
            { targets: 0, width: '20%' },
            { targets: 1, width: '30%' },
            { targets: 2, width: '20%' },
            { targets: 3, width: '30%' }
        ]
    });

    $('#desa-table tbody').on('click', 'tr', function () {
        const data = table.row(this).data();
        if (!data || !data.id) return;

        const url = `/database/desa/${data.id}/edit`;

        $('#modalEditContent').html('<div class="text-center">Loading...</div>');
        $('#editModal').modal('show');

        $('#modalEditContent').load(url);
    });
});
</script>
@endsection
