
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
                  <label for="tgl_tunggu" class="form-label">Tgl Rencana Cair</label>
                  <input autocomplete="off" type="date" name="tgl_tunggu" id="tgl_tunggu"
                    class="form-control date" value="{{ Tanggal::tglIndo($perguliran_i->tgl_verifikasi) }}">
                  <small class="text-danger" id="msg_tgl_tunggu"></small>
                </div>
              </div>

              <div class="col-md-3">
                <div class="mb-3">
                  <label for="alokasi" class="form-label">Alokasi Rp.</label>
                  <input autocomplete="off" type="text" name="alokasi" id="alokasi" readonly 
                    class="form-control money" value="{{ number_format($perguliran_i->verifikasi, 2) }}">
                  <small class="text-danger" id="msg_alokasi"></small>
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
                <button type="button" id="simpan_waiting" class="btn btn-github ms-1 btn-sm">
                    Masukkan ke waiting list
                </button>
            </div>
        </div>
    </div>
