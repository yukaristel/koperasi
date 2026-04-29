@php
    $operator = [
        '=',
        '!=',
        '>',
        '<',
        'LIKE',
        'NOT LIKE',
        ['title' => 'IN (...)',     'value' => 'IN'],
        ['title' => 'NOT IN (...)', 'value' => 'NOT IN'],
    ];

    /**
     * Kolom-kolom yang disembunyikan dari form filter kelompok.
     */
    $continue = [
        'sumber',               // internal
        'catatan_verifikasi',   // teks bebas
        'wt_cair',              // waktu cair (auto)
        'lu',                   // last update timestamp
        'pendapatan',           // string gabungan
        'biaya',                // string gabungan
        'aktiva',               // string gabungan
        'pasiva',               // string gabungan
        'jaminan',              // string gabungan
        'data_proposal',        // string gabungan tgl#alokasi#...
        'data_verifikasi',
        'data_verifikasi1',
        'data_verifikasi2',
        'data_verifikasi3',
        'data_waiting',
        'catatan',
    ];
@endphp

<form action="/generate/save" method="post" target="_blank">
    @csrf

    {{-- Hidden: tipe pinjaman kelompok --}}
    <input type="hidden" name="pinjaman" value="kelompok">

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Kolom</th>
                    <th>Operator</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($struktur as $val)
                    @php
                        if (in_array($val, $continue)) { continue; }
                    @endphp
                    <tr>
                        <td>
                            <b>{{ ucwords(str_replace('_', ' ', $val)) }}</b>
                            @if ($val === 'jenis_pp')
                                <br><small class="text-muted">1 = Anggota &nbsp;|&nbsp; 2 = Kop. Lain &nbsp;|&nbsp; 3 = Non-Anggota</small>
                            @endif
                            @if ($val === 'status')
                                <br><small class="text-muted">P = Proposal &nbsp;|&nbsp; V = Verifikasi &nbsp;|&nbsp; W = Waiting &nbsp;|&nbsp; L = Lunas</small>
                            @endif
                            @if ($val === 'jenis_jasa')
                                <br><small class="text-muted">1 = Flat &nbsp;|&nbsp; 3 = Anuitas</small>
                            @endif
                        </td>
                        <td>
                            <div class="input-group input-group-static">
                                <select name="{{ $val }}[operator]" class="form-control">
                                    @foreach ($operator as $opt)
                                        @php
                                            $title = is_array($opt) ? $opt['title'] : $opt;
                                            $value = is_array($opt) ? $opt['value'] : $opt;
                                        @endphp
                                        <option value="{{ $value }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group input-group-static">
                                <input type="text" name="{{ $val }}[value]" class="form-control"
                                    placeholder="{{ $val === 'jenis_pp' ? '1 / 2 / 3' : '' }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="material-icons" style="font-size:16px;vertical-align:middle">play_arrow</span>
            Generate
        </button>
    </div>
</form>
