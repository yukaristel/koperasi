<form action="/perguliran_i/{{ $perguliran_i->id }}" method="post" id="FormInputV">
    @csrf
    @method('PUT')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row mt-0">
                @include('perguliran_i.partials.proses')
                
                @php
                    $tgl="";
                    $alokasi ="";
                @endphp
            </div>
        </div>
    </div>

    <div class="card card-body p-2 pb-0 mb-3">
        <div class="d-grid">
            <button type="button" data-bs-toggle="modal" data-bs-target="#CetakDokumenProposal"
                class="btn btn-success btn-sm mb-2">Cetak Dokumen Proposal</button>
        </div>
    </div>
    @if($v1)
    <div class="card mb-3">
        <div class="card-header pb-0 p-3">
            <h6>Input {{$v1}}</h6>
        </div>
        <div class="card-body p-3">
            <input type="hidden" name="_id" id="_id" value="{{ $perguliran_i->id }}">
            <input type="hidden" name="status" id="status" value="V1">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="tgl_verifikasi" class="form-label">Tgl  {{$v1}}</label>
                        <input type="date" name="tgl_verifikasi" id="tgl_verifikasi" autocomplete="off"
                            class="form-control date" value="{{$tgl}}">
                        <small class="text-danger" id="msg_tgl_verifikasi"></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="verifikasi" class="form-label"> {{$v1}} Rp.</label>
                        <input type="text" name="verifikasi" id="verifikasi" autocomplete="off"
                            class="form-control keuangan" value="{{ $alokasi }}">
                        <small class="text-danger" id="msg_verifikasi"></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="jangka" class="form-label">Jangka</label>
                        <input type="number" name="jangka" id="jangka" autocomplete="off"
                            class="form-control" value="{{ $perguliran_i->jangka }}">
                        <small class="text-danger" id="msg_jangka"></small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                        <input type="number" name="pros_jasa" id="pros_jasa" autocomplete="off"
                            class="form-control" value="{{ $perguliran_i->pros_jasa }}">
                        <small class="text-danger" id="msg_pros_jasa"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="jenis_jasa" class="form-label">Jenis Jasa</label>
                        <select class="form-control" name="jenis_jasa" id="jenis_jasa">
                            @foreach ($jenis_jasa as $jj)
                                <option {{ $jj->id == $perguliran_i->jenis_jasa ? 'selected' : '' }} value="{{ $jj->id }}">
                                    {{ $jj->nama_jj }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_jenis_jasa"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="sistem_angsuran_pokok" class="form-label">Sistem Angs. Pokok</label>
                        <select class="form-control" name="sistem_angsuran_pokok" id="sistem_angsuran_pokok">
                            @foreach ($sistem_angsuran as $sa)
                                <option {{ $sa->id == $perguliran_i->sistem_angsuran ? 'selected' : '' }} value="{{ $sa->id }}">
                                    {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_sistem_angsuran_pokok"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="sistem_angsuran_jasa" class="form-label">Sistem Angs. Jasa</label>
                        <select class="form-control" name="sistem_angsuran_jasa" id="sistem_angsuran_jasa">
                            @foreach ($sistem_angsuran as $sa)
                                <option {{ $sa->id == $perguliran_i->sa_jasa ? 'selected' : '' }} value="{{ $sa->id }}">
                                    {{ $sa->nama_sistem }} ({{ $sa->deskripsi_sistem }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="msg_sistem_angsuran_jasa"></small>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="catatan_verifikasi" class="form-label">Catatan  {{$v1}}</label>
                <textarea class="form-control" name="catatan_verifikasi" id="catatan_verifikasi" rows="3"
                    placeholder="Catatan">{{ $perguliran_i->catatan_verifikasi }}</textarea>
                <small class="text-danger" id="msg_catatan_verifikasi"></small>
            </div>

                <button type="button" id="simpan_verifikasi" class="btn btn-github float-end btn-sm"
                    {{-- @if (!in_array('perguliran.simpan_verifikator', Session::get('tombol', []))) disabled @endif --}}>
                    Simpan {{$v1}}
                </button>

        </div>
    </div>
    
    @else
        @include('perguliran_i.partials._waiting')
    @endif
</form>
