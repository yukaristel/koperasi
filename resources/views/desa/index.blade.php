@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $title ?? 'Data Desa' }}</h3>
    <table id="desa-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Desa</th>
                <th>Telepon</th>
                <th>Kepala Desa</th>
            </tr>
        </thead>
    </table>
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
<!-- Pastikan jQuery dan DataTables sudah dimuat -->
<script>
$(document).ready(function() {
    // Setup CSRF token untuk semua request Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Inisialisasi DataTable
    const table = $('#desa-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("desa.index") }}',
        columns: [
            { data: 'kode_desa', name: 'kode_desa' },
            { data: 'nama_desa', name: 'nama_desa' },
            { data: 'telp_desa', name: 'telp_desa' },
            { data: 'kades', name: 'kades' }
        ],
        responsive: true,
        order: [[1, 'asc']]
    });

    // Klik baris untuk memunculkan modal edit
    $('#desa-table tbody').on('click', 'tr', function () {
        const data = table.row(this).data();
        if (!data || !data.id) return;

        const url = `/database/desa/${data.id}/edit`;

        $('#modalEditContent').html('<div class="text-center">Loading...</div>');
        $('#editModal').modal('show');

        // Ambil isi form edit dari edit.blade.php
        $('#modalEditContent').load(url);
    });
});
</script>
@endsection
