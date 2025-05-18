<div>
    <h6 class="fw-bold">1. IDENTITAS NASABAH</h6>
    <div class="row">
        <div class="col-md-10 mb-2">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $anggota->namadepan ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-2 mb-2">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" {{ $disabled }}>
                <option value="">Pilih</option>
                <option value="L" {{ ($anggota->jk ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ ($anggota->jk ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="col-md-6 mb-2 d-flex gap-2">
            <div class="flex-fill">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $anggota->tempat_lahir ?? '' }}" {{ $disabled }}>
            </div>
            <div class="flex-fill">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $anggota->tgl_lahir ?? '' }}" {{ $disabled }}>
            </div>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Desa/Kelurahan</label>
            <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ $anggota->desa ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-12 mb-2">
            <label class="form-label">Alamat KTP</label>
            <input type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" value="{{ $anggota->alamat ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $anggota->hp ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2 d-flex gap-2">
            <div class="flex-fill">
                <label class="form-label">Jenis Kegiatan / Usaha</label>
                <select class="form-control" id="jenis_usaha" name="jenis_usaha" {{ $disabled }}>
                    <option value="">Pilih</option>
                    <option value="Pertanian" {{ ($anggota->jenis_usaha ?? '') === 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                    <option value="Perdagangan" {{ ($anggota->jenis_usaha ?? '') === 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                    <option value="Jasa" {{ ($anggota->jenis_usaha ?? '') === 'Jasa' ? 'selected' : '' }}>Jasa</option>
                    <option value="Lainnya" {{ ($anggota->jenis_usaha ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="flex-fill">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan_usaha" name="keterangan_usaha" value="{{ $anggota->keterangan_usaha ?? '' }}" {{ $disabled }}>
            </div>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Pekerjaan</label>
            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $anggota->pekerjaan ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Nomor KK</label>
            <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{ $anggota->no_kk ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Pendidikan Terakhir</label>
            <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="{{ $anggota->pendidikan ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Nama Ibu</label>
            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ $anggota->nama_ibu ?? '' }}" {{ $disabled }}>
        </div>
    </div>

    <hr>

    <h6 class="fw-bold">2. IDENTITAS PENJAMIN / AHLI WARIS</h6>
    <div class="row">
        <div class="col-md-6 mb-2">
            <label class="form-label">N I K</label>
            <input type="text" class="form-control" id="nik_penjamin" name="nik_penjamin" maxlength="16" value="{{ $anggota->nik_penjamin ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-6 mb-2">
            <label class="form-label">Hubungan</label>
            <input type="text" class="form-control" id="hubungan_penjamin" name="hubungan_penjamin" value="{{ $anggota->hubungan_penjamin ?? '' }}" {{ $disabled }}>
        </div>

        <div class="col-md-12 mb-2">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_penjamin" name="nama_penjamin" value="{{ $anggota->nama_penjamin ?? '' }}" {{ $disabled }}>
        </div>
    </div>
</div>
