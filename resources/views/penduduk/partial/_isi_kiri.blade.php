<form action="/database/penduduk/{{ $anggota->id ?? '' }}" method="post" id="FormPenduduk" name="FormPenduduk">
    @csrf
    @if ($anggota)
        @method('PUT')
	@endif
    
    <div>
        <h6 class="fw-bold">1. IDENTITAS NASABAH</h6>
        <div class="row">
            <div class="col-md-2 mb-2">
                <label class="form-label">NIA</label>
                <input type="text" class="form-control" value="{{ $anggota->id ?? '' }}" disabled>

                <input type="hidden" id="nia" name="nia" class="form-control" value="{{ $anggota->id ?? '' }}" >
                <input type="hidden" id="nik" name="nik" class="form-control" value="{{$nik}}">
            </div>
            <div class="col-md-10 mb-2">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="namadepan" name="namadepan" value="{{ $anggota->namadepan ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_namadepan"></small>
            </div>
            
            <div class="col-md-6 mb-2">
                <label class="form-label">Nama Panggilan</label>
                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="{{ $anggota->nama_panggilan ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_nama_panggilan"></small>
            </div>
            
            <div class="col-md-6 mb-2">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="jk" name="jk" {{ $disabled }}>
                    <option value="">Pilih</option>
                    @php
                        $jenisKelamin = $anggota->jk ?? '';
                        if(empty($jenisKelamin) && request()->route('nik')) {
                            $nik = request()->route('nik');
                            $tanggalNIK = intval(substr($nik, 6, 2));
                            $jenisKelamin = $tanggalNIK >= 40 ? 'P' : 'L';
                        }
                    @endphp
                    <option value="L" {{ $jenisKelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jenisKelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <small class="text-danger" id="msg_jk"></small>
            </div>
            <div class="col-md-6 mb-2 d-flex gap-2">
                <div class="flex-fill">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $anggota->tempat_lahir ?? '' }}" {{ $disabled }}>
                    <small class="text-danger" id="msg_tempat_lahir"></small>
                </div>
                <div class="flex-fill">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $anggota->tgl_lahir ?? '' }}" {{ $disabled }}>
                    <small class="text-danger" id="msg_tgl_lahir"></small>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Desa/Kelurahan</label>
                <select class="form-control" id="desa" name="desa" {{ $disabled }}>
                    <option value="">--Pilih Desa--</option>
                    @foreach($desa as $d)
                        <option value="{{ $d->kd_desa }}" {{ ($anggota->desa ?? null) == $d->kd_desa ? 'selected' : '' }}>
                            {{ $d->kd_desa }} - {{ $d->nama_desa }}
                        </option>
                    @endforeach
                </select>
                <small class="text-danger" id="msg_desa"></small>
            </div>

            <div class="col-12 mb-2">
                <label class="form-label">Alamat KTP</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $anggota->alamat ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_alamat"></small>
            </div>

            <div class="col-12 mb-2">
                <label class="form-label">Alamat Tinggal</label>
                <input type="text" class="form-control" id="domisili" name="domisili" value="{{ $anggota->domisili ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_domisili"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="hp" name="hp" value="{{ $anggota->hp ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_hp"></small>
            </div>

            <div class="col-md-6 mb-2 d-flex gap-2 flex-column">
                <div class="d-flex gap-2">
                    <div class="flex-fill">
                        <label class="form-label">Jenis Usaha</label>
                        <select class="form-control" id="jenis_usaha" name="jenis_usaha" {{ $disabled }}>
                            <option value="">Pilih Jenis Usaha</option>
                            @foreach ($jenis_kegiatan as $jk)
                                <optgroup label="{{ $jk->nama_jk }}">
                                    @foreach ($jk->usaha as $usaha)
                                        <option value="{{ $usaha->id }}" {{ ($anggota->usaha ?? '') == $usaha->id ? 'selected' : '' }}>
                                            {{ $usaha->nama_usaha }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-fill">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan_usaha" name="keterangan_usaha" value="{{ $anggota->keterangan_usaha ?? '' }}" {{ $disabled }}>
                    </div>
                </div>
                <small class="text-danger" id="msg_jenis_usaha"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Alamat Kerja</label>
                <input type="text" class="form-control" id="tempat_kerja" name="tempat_kerja" value="{{ $anggota->tempat_kerja ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_tempat_kerja"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Pendidikan Terakhir</label>
                <select class="form-control" id="pendidikan" name="pendidikan" {{ $disabled }}>
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="Tidak Menempuh Pendidikan" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'Tidak Menempuh Pendidikan' ? 'selected' : '' }}>Tidak Menempuh Pendidikan</option>
                    <option value="SD/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                    <option value="SLTP/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'SLTP/Sederajat' ? 'selected' : '' }}>SLTP/Sederajat</option>
                    <option value="SLTA/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'SLTA/Sederajat' ? 'selected' : '' }}>SLTA/Sederajat</option>
                    <option value="Diploma/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'Diploma/Sederajat' ? 'selected' : '' }}>Diploma/Sederajat</option>
                    <option value="Sarjana/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'Sarjana/Sederajat' ? 'selected' : '' }}>Sarjana/Sederajat</option>
                    <option value="Magister/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'Magister/Sederajat' ? 'selected' : '' }}>Magister/Sederajat</option>
                    <option value="Doktor/Sederajat" {{ isset($anggota->pendidikan) && $anggota->pendidikan == 'Doktor/Sederajat' ? 'selected' : '' }}>Doktor/Sederajat</option>
                </select>
                <small class="text-danger" id="msg_pendidikan"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Agama</label>
                <select class="form-control" id="agama" name="agama" {{ $disabled }}>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ ($anggota->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ ($anggota->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen (Protestan)</option>
                    <option value="Katolik" {{ ($anggota->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ ($anggota->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ ($anggota->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ ($anggota->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="Kepercayaan" {{ ($anggota->agama ?? '') == 'Kepercayaan' ? 'selected' : '' }}>Kepercayaan Lain</option>
                </select>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Status Pernikahan</label>
                <select class="form-control" id="status_pernikahan" name="status_pernikahan" {{ $disabled }}>
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Menikah" {{ ($anggota->status_pernikahan ?? '') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="Menikah" {{ ($anggota->status_pernikahan ?? '') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="Duda" {{ ($anggota->status_pernikahan ?? '') == 'Duda' ? 'selected' : '' }}>Duda</option>
                    <option value="Janda" {{ ($anggota->status_pernikahan ?? '') == 'Janda' ? 'selected' : '' }}>Janda</option>
                </select>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Nomor KK</label>
                <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{ $anggota->kk ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_no_kk"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Nama Ibu</label>
                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ $anggota->nama_ibu ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_nama_ibu"></small>
            </div>
        </div>

        <hr>

        <h6 class="fw-bold">2. IDENTITAS PENJAMIN / AHLI WARIS</h6>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">N I K</label>
                <input type="text" class="form-control" id="nik_penjamin" name="nik_penjamin" maxlength="16" value="{{ $anggota->nik_penjamin ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_nik_penjamin"></small>
            </div>

            <div class="col-md-6 mb-2">
                <label class="form-label">Hubungan</label>
                <select class="form-control" id="hubungan_penjamin" name="hubungan_penjamin" {{ $disabled }}>
                    <option value="">-- Pilih Hubungan --</option>
                    <option value="Suami/Istri" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Suami/Istri' ? 'selected' : '' }}>Suami/Istri</option>
                    <option value="Orang Tua" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Anak" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Saudara Kandung" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Saudara Kandung' ? 'selected' : '' }}>Saudara Kandung</option>
                    <option value="Keluarga Lain" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Keluarga Lain' ? 'selected' : '' }}>Keluarga Lain</option>
                    <option value="Teman/Kolega" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Teman/Kolega' ? 'selected' : '' }}>Teman/Kolega</option>
                    <option value="Lainnya" {{ isset($anggota->hubungan) && $anggota->hubungan == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <small class="text-danger" id="msg_hubungan_penjamin"></small>
            </div>

            <div class="col-md-12 mb-2">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_penjamin" name="nama_penjamin" value="{{ $anggota->penjamin ?? '' }}" {{ $disabled }}>
                <small class="text-danger" id="msg_nama_penjamin"></small>
            </div>
        </div>
    </div>
</form>
