<form action="/pengaturan/spk/{{ $kec->id }}" method="post" id="FormSPK">
    @csrf
    @method('PUT')

    <textarea name="editor_spk" id="editor_spk">{!! json_decode($kec->redaksi_spk, true) !!}</textarea>
    <textarea name="spk" id="spk" class="d-none"></textarea>
</form>

<div class="d-flex justify-content-end mt-3">
    <button type="button" data-bs-toggle="modal" data-bs-target="#keyword" class="btn btn-info btn-sm">
        Kata Kunci
    </button>
    <button type="button" id="SimpanSPK" data-target="#FormSPK" class="btn btn-sm btn-dark ms-2 btn-simpan ">
        Simpan Perubahan
    </button>
</div>

@section('modal')
    <div class="modal fade" id="keyword" tabindex="-1" aria-labelledby="keywordLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="keywordLabel">Daftar Kata Kunci & Fungsi SPK</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="alert alert-info text-center py-2">
                                <strong>Kata Kunci</strong> yang digunakan dalam redaksi SPK
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th width="40">No</th>
                                            <th width="150">Kata Kunci</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keywordSPK as $keyword => $value)
                                            <tr>
                                                <td class="text-center">
                                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                                                </td>
                                                <td><code>{{ $keyword }}</code></td>
                                                <td>{{ $value['desc'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info text-center py-2">
                                <strong>Fungsi</strong>
                            </div>
                            <div class="alert alert-secondary small" style="text-align: justify;">
                                Penulisan fungsi berada di antara <code>{</code> dan <code>}</code>, diawali dengan tanda
                                sama dengan <code>=</code>, diikuti nama fungsi. Contoh:
                                <code>{=terbilang(10000)}</code> akan menghasilkan teks <code>Sepuluh Ribu</code>.
                                <br><br>
                                Anda juga bisa menyisipkan kata kunci/fungsi ke dalam fungsi:
                                <ul>
                                    <li><code>{=terbilang({alokasi})}</code></li>
                                    <li><code>{=terbilang({=(10000*(10/100))})}</code></li>
                                </ul>
                            </div>
                            @foreach ($fungsiSPK as $fungsi => $value)
                                <div class="mb-2">
                                    <button class="btn btn-light w-100 text-start" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fungsiDropdown{{ $loop->index }}" aria-expanded="false"
                                        aria-controls="fungsiDropdown{{ $loop->index }}">
                                        <strong>{{ $fungsi }}</strong>
                                    </button>
                                    <div class="collapse mt-2" id="fungsiDropdown{{ $loop->index }}">
                                        <div class="card card-body">
                                            <blockquote class="blockquote">
                                                <code>{{ $value['fungsi'] }}</code>
                                            </blockquote>
                                            <div style="text-align: justify;">
                                                {!! $value['desc'] !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <small class="text-muted">Gunakan dengan format yang sesuai agar hasil dokumen SPK maksimal.</small>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
