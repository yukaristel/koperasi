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

    $continue = [
        'sumber',
        'catatan_verifikasi',
        'wt_cair',
        'lu',
        'pendapatan',
        'biaya',
        'aktiva',
        'pasiva',
        'jaminan',
        'data_proposal',
        'data_verifikasi',
        'data_verifikasi1',
        'data_verifikasi2',
        'data_verifikasi3',
        'data_waiting',
        'catatan',
    ];

    $hints = [
        'jenis_pp'   => '1 = Anggota &nbsp;|&nbsp; 2 = Kop. Lain &nbsp;|&nbsp; 3 = Non-Anggota',
        'status'     => 'P = Proposal &nbsp;|&nbsp; V = Verifikasi &nbsp;|&nbsp; W = Waiting &nbsp;|&nbsp; L = Lunas',
        'jenis_jasa' => '1 = Flat &nbsp;|&nbsp; 3 = Anuitas',
    ];
@endphp

<form class="form-generate">
    @csrf

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
                    @php if (in_array($val, $continue)) { continue; } @endphp
                    <tr>
                        <td>
                            <b>{{ ucwords(str_replace('_', ' ', $val)) }}</b>
                            @if (isset($hints[$val]))
                                <br><small class="text-muted">{!! $hints[$val] !!}</small>
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
                                <input type="text"
                                       name="{{ $val }}[value]"
                                       class="form-control"
                                       placeholder="{{ isset($hints[$val]) ? strip_tags($hints[$val]) : '' }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-info btn-sm">
            <span class="material-icons" style="font-size:16px;vertical-align:middle;margin-right:4px">play_arrow</span>
            Generate Kelompok
        </button>
    </div>
</form>
