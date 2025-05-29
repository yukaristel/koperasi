<form action="/pengaturan/perguliran/{{ $kec->id }}" method="POST" id="FormPerguliran">
    @csrf
    @method('PUT')
    @php
        // Ambil array tahapan dari kolom JSON, atau array kosong
        $tahapanBaru = is_array($kec->tahapan_perguliran) ? $kec->tahapan_perguliran : json_decode($kec->tahapan_perguliran ?? '[]', true);
    @endphp
    <div id="daftar-tahapan">
        <!-- Tahapan default -->
        <div class="mb-3">
            <input type="text" class="form-control" value="Proposal" readonly>
        </div>
        <div class="text-center mb-1"><i class="fas fa-arrow-down"></i></div>
        <div class="mb-3">
            <input type="text" class="form-control" value="Verifikasi" readonly>
        </div>

        <!-- Tahapan tambahan dari database -->
        @foreach ($tahapanBaru as $tahapan)
            <div class="text-center mb-1"><i class="fas fa-arrow-down"></i></div>
            <div class="mb-3 d-flex gap-2">
                <input type="text" name="tahapan_baru[]" class="form-control" value="{{ $tahapan }}">
                <button type="button" class="btn btn-danger btn-hapus-tahapan">-</button>
            </div>
        @endforeach

        <!-- MARKER -->
        <div class="tombol-tambah-placeholder"></div>
    </div>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-success" id="btnTambahTahapan">
            + Tambah Tahapan (<span id="sisaSlot">{{ 3 - count($tahapanBaru) }}</span>)
        </button>
    </div>

    <!-- Tahapan akhir -->
    <div class="text-center mb-1"><i class="fas fa-arrow-down"></i></div>
    <div class="mb-3"><input type="text" class="form-control" value="Waiting" readonly></div>
    <div class="text-center mb-1"><i class="fas fa-arrow-down"></i></div>
    <div class="mb-3"><input type="text" class="form-control" value="Aktif" readonly></div>
    <div class="text-center mb-1"><i class="fas fa-arrow-down"></i></div>
    <div class="mb-3"><input type="text" class="form-control" value="Lunas" readonly></div>

</form>

<div class="d-flex justify-content-end">
    <button type="button" id="SimpanPerguliran" data-target="#FormPerguliran" class="btn btn-secondary mb-0 btn-simpan">
        Simpan Perubahan
    </button>
</div>
