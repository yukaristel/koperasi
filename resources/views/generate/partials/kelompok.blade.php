@php
    $operator = [
        '=', '!=', '>', '<', 'LIKE', 'NOT LIKE',
        ['title' => 'IN (...)',     'value' => 'IN'],
        ['title' => 'NOT IN (...)', 'value' => 'NOT IN'],
    ];

    $continue = [
        'sumber', 'catatan_verifikasi', 'wt_cair', 'lu',
        'pendapatan', 'biaya', 'aktiva', 'pasiva', 'jaminan',
        'data_proposal', 'data_verifikasi', 'data_verifikasi1',
        'data_verifikasi2', 'data_verifikasi3', 'data_waiting',
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
    <input type="hidden" name="_lokasi"  value="{{ Session::get('lokasi') }}">

    <div style="margin-bottom:16px;font-size:13px;color:#94a3b8;">
        <i class="fas fa-info-circle" style="color:#a78bfa;margin-right:6px;"></i>
        <b style="color:#e2e8f0;">GENERATE KELOMPOK</b>
        <br>
        <small style="color:#475569;margin-top:4px;display:block;">
            Biarkan semua value kosong untuk generate seluruh pinjaman kelompok.
        </small>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th style="width:30%">Kolom</th>
                    <th style="width:20%">Operator</th>
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
                                <small>{!! $hints[$val] !!}</small>
                            @endif
                        </td>
                        <td>
                            <select name="{{ $val }}[operator]" class="form-control">
                                @foreach ($operator as $opt)
                                    @php
                                        $title = is_array($opt) ? $opt['title'] : $opt;
                                        $value = is_array($opt) ? $opt['value'] : $opt;
                                    @endphp
                                    <option value="{{ $value }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="{{ $val }}[value]" class="form-control"
                                placeholder="{{ isset($hints[$val]) ? strip_tags($hints[$val]) : '' }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-top:20px;">
        <button type="submit" class="btn-generate">
            <i class="fas fa-play"></i> Generate Kelompok
        </button>
    </div>
</form>
