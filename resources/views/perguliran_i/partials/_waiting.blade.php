
    <div class="card mb-3">
        <div class="card-header pb-0 p-3">
            <h6>
                Masukkan Data Ke Waiting List
            </h6>
        </div>
        <div class="card-body p-3">
            <input type="hidden" name="_id" id="_id" value="{{ $perguliran_i->id }}">
            <input type="hidden" name="status" id="status" value="W">
            <div class="row">
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="tgl_tunggu" class="form-label">Tgl Tunggu</label>
                  <input autocomplete="off" type="text" name="tgl_tunggu" id="tgl_tunggu"
                    class="form-control date" value="{{ Tanggal::tglIndo($perguliran_i->tgl_verifikasi) }}">
                  <small class="text-danger" id="msg_tgl_tunggu"></small>
                </div>
              </div>

              <div class="col-md-3">
                <div class="mb-3">
                  <label for="alokasi" class="form-label">Alokasi Rp.</label>
                  <input autocomplete="off" type="text" name="alokasi" id="alokasi"
                    class="form-control money" value="{{ number_format($perguliran_i->verifikasi, 2) }}">
                  <small class="text-danger" id="msg_alokasi"></small>
                </div>
              </div>

              <div class="col-md-3">
                <div class="mb-3">
                  <label for="jangka" class="form-label">Jangka</label>
                  <input autocomplete="off" type="number" name="jangka" id="jangka" class="form-control"
                    value="{{ $perguliran_i->jangka }}">
                  <small class="text-danger" id="msg_jangka"></small>
                </div>
              </div>

              <div class="col-md-3">
                <div class="mb-3">
                  <label for="pros_jasa" class="form-label">Prosentase Jasa (%)</label>
                  <input autocomplete="off" type="number" name="pros_jasa" id="pros_jasa" class="form-control"
                    value="{{ $perguliran_i->pros_jasa }}">
                  <small class="text-danger" id="msg_pros_jasa"></small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label" for="jenis_jasa">Jenis Jasa</label>
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
                <div class="mb-3">
                  <label class="form-label" for="sistem_angsuran_pokok">Sistem Angs. Pokok</label>
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
                <div class="mb-3">
                  <label class="form-label" for="sistem_angsuran_jasa">Sistem Angs. Jasa</label>
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

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="tgl_cair" class="form-label">Tanggal Cair</label>
                  <input autocomplete="off" type="text" name="tgl_cair" id="tgl_cair"
                    class="form-control date" value="{{ Tanggal::tglIndo($perguliran_i->tgl_verifikasi) }}">
                  <small class="text-danger" id="msg_tgl_cair"></small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="nomor_spk" class="form-label">Nomor SPK</label>
                  <input autocomplete="off" type="text" name="nomor_spk" id="nomor_spk"
                    class="form-control" value="{{ $perguliran_i->spk_no }}">
                  <small class="text-danger" id="msg_nomor_spk"></small>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" id="kembaliProposal" class="btn btn-warning btn-sm"
                    @if (!in_array('perguliran.balik_proposal', Session::get('tombol', [])))
                        disabled
                    @endif
                >
                    Kembalikan Ke Proposal
                </button>
                <button type="button" id="Simpan" class="btn btn-github ms-1 btn-sm"
                    @if (!in_array('perguliran.simpan_dana', Session::get('tombol', [])))
                        disabled
                    @endif
                >
                    Masukkan ke waiting list
                </button>
            </div>
        </div>
    </div>
