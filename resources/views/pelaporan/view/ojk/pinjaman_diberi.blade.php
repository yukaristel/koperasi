@php
use App\Utils\Tanggal;
$section = 0;
@endphp

@extends('pelaporan.layout.base')

@section('content')
    @php
        $nomor = 0;
    @endphp

    @foreach ($jenis_pp_i as $jpp_i)
        @php
            if ($jpp_i->pinjaman_individu->isEmpty()) {
                $empty = true;
                continue;
            }
            $nomor++;
        @endphp

        @if ($nomor > 1)
            <div class="break"></div>
            @php
                $empty = false;
            @endphp
        @endif

        @php
            $kd_desa = [];
            $t_alokasi = 0;
            $t_saldo_pokok = 0;
            $t_saldo = 0;
            $t_tunggakan_pokok = 0;
            $t_tunggakan_jasa = 0;
            $jumlah_aktif = 0;
        @endphp

        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
            <tr>
                <td colspan="5" align="center">
                    <div style="font-size: 20px;">
                        <b>DAFTAR RINCIAN PINJAMAN YANG DIBERIKAN {{ strtoupper($jpp_i->nama_jpp) }}</b>
                    </div>
                    <div style="font-size: 16px;">
                        <b>{{ strtoupper($sub_judul) }}</b>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5" height="5"></td>
            </tr>
        </table>

        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px; table-layout: fixed;">
            <tr align="center" height="30px" style="font-size: 11px;">
                <th width="3%" rowspan="2" class="t l b">No</th>
                <th width="18%" rowspan="2" class="t l b">Peminjam - Loan ID</th>
                <th width="12%" rowspan="2" class="t l b">Jenis Penggunaan</th>
                <th width="7%" rowspan="2" class="t l b">Periode Pembayaran</th>
                <th colspan="2" class="t l b">Jangka Waktu</th>
                <th colspan="2" class="t l b">Suku Bunga</th>
                <th width="7%" rowspan="2" class="t l b">Plafon</th>
                <th width="8%" rowspan="2" class="t l b">Baki Debet</th>
                <th width="6%" rowspan="2" class="t l b">Tunggakan</th>
                <th width="5%" rowspan="2" class="t l r b">Kualitas</th>
                <th width="6%" rowspan="2" class="t l r b">Jenis Agunan</th>
                <th width="9%" rowspan="2" class="t l r b">Nilai Agunan</th>
            </tr>
            <tr align="center" height="30px" class="style9">
                <th width="6%" class="l b">Mulai</th>
                <th width="6%" class="l b">Jatuh Tempo</th>
                <th width="4%" class="l b">%</th>
                <th width="5%" class="l b">Keterangan</th>
            </tr>

            @foreach ($jpp_i->pinjaman_individu as $pinj_i)
                @php
                    $kd_desa[] = $pinj_i->kd_desa;
                    $desa = $pinj_i->kd_desa;
                @endphp

                @if (array_count_values($kd_desa)[$pinj_i->kd_desa] <= '1')
                    @if ($section != $desa && count($kd_desa) > 1)
                        @php
                            $j_pross = $j_saldo / $j_alokasi;
                            $t_alokasi += $j_alokasi;
                            $t_saldo_pokok += $saldo_pokok;
                            $t_saldo += $j_saldo;
                            $t_tunggakan_pokok += $j_tunggakan_pokok;
                            $t_tunggakan_jasa += $j_tunggakan_jasa;
                        @endphp
                        <tr style="font-weight: bold; border: 1px solid; font-size: 11px;">
                            <td class="t b" colspan="8" align="left" height="15">Jumlah {{ $nama_desa }}</td>
                            <td class="t l b" align="right">{{ number_format($j_alokasi) }}</td>
                            <td class="t l b" align="right">{{ number_format($j_saldo) }}</td>
                            <td class="t l b" align="right">{{ number_format($j_tunggakan_pokok) }}</td>
                            <td colspan="3" class="t l b" align="right"></td>
                        </tr>
                    @endif

                    <tr>
                        <td class="t l b" align="center"></td>
                        <td class="style27 t r b" colspan="13">{{ $pinj_i->kode_desa }}. {{ $pinj_i->nama_desa }}</td>
                    </tr>

                    @php
                        $kidp = $pinj_i['id'];
                        $nomor = 1;
                        $section = $pinj_i->kd_desa;
                        $nama_desa = $pinj_i->sebutan_desa . ' ' . $pinj_i->nama_desa;
                        $kpros_jasa = number_format($pinj_i['pros_jasa'] - $pinj_i['jangka'], 2);
                        $ktgl1 = $pinj_i['tgl_cair'];
                        $kpenambahan = "+" . $pinj_i['jangka'] . " month";
                        $kpros_jasa = number_format($pinj_i['pros_jasa'] / $pinj_i['jangka'], 2);
                        $j_alokasi = 0;
                        $j_tunggakan_pokok = 0;
                        $j_tunggakan_jasa = 0;
                        $j_saldo = 0;
                    @endphp
                @endif

                @php
                    $jumlah_aktif += 1;
                    $sum_pokok = 0;
                    $sum_jasa = 0;
                    $saldo_pokok = $pinj_i->alokasi;
                    $saldo_jasa = $pinj_i->pros_jasa == 0 ? 0 : $pinj_i->alokasi * ($pinj_i->pros_jasa / 100);
                    if ($pinj_i->saldo) {
                        $sum_pokok = $pinj_i->saldo->sum_pokok;
                        $sum_jasa = $pinj_i->saldo->sum_jasa;
                        $saldo_pokok = $pinj_i->saldo->saldo_pokok;
                        $saldo_jasa = $pinj_i->saldo->saldo_jasa;
                    }

                    if ($saldo_jasa < 0) {
                        $saldo_jasa = 0;
                    }
                    if ($pinj_i->tgl_lunas <= $tgl_kondisi && $pinj_i->status == 'L') {
                        $saldo_jasa = 0;
                    }

                    $target_pokok = 0;
                    $target_jasa = 0;
                    $wajib_pokok = 0;
                    $wajib_jasa = 0;
                    $angsuran_ke = 0;
                    $jatuh_tempo = 0;
                    if ($pinj_i->target) {
                        $target_pokok = $pinj_i->target->target_pokok;
                        $target_jasa = $pinj_i->target->target_jasa;
                        $wajib_pokok = $pinj_i->target->wajib_pokok;
                        $wajib_jasa = $pinj_i->target->wajib_jasa;
                        $angsuran_ke = $pinj_i->target->angsuran_ke;
                        $jatuh_tempo = $pinj_i->target->jatuh_tempo;
                    }

                    $tunggakan_pokok = $target_pokok - $sum_pokok;
                    if ($tunggakan_pokok < 0) {
                        $tunggakan_pokok = 0;
                    }
                    $tunggakan_jasa = $target_jasa - $sum_jasa;
                    if ($tunggakan_jasa < 0) {
                        $tunggakan_jasa = 0;
                    }
                    $pross = $saldo_pokok == 0 ? 0 : $saldo_pokok / $pinj_i->alokasi;

                    if ($pinj_i->tgl_lunas <= $tgl_kondisi && $pinj_i->status == 'L') {
                        $tunggakan_pokok = 0;
                        $tunggakan_jasa = 0;
                        $saldo_pokok = 0;
                        $saldo_jasa = 0;
                    } elseif ($pinj_i->tgl_lunas <= $tgl_kondisi && $pinj_i->status == 'R') {
                        $tunggakan_pokok = 0;
                        $tunggakan_jasa = 0;
                        $saldo_pokok = 0;
                        $saldo_jasa = 0;
                    } elseif ($pinj_i->tgl_lunas <= $tgl_kondisi && $pinj_i->status == 'H') {
                        $tunggakan_pokok = 0;
                        $tunggakan_jasa = 0;
                        $saldo_pokok = 0;
                        $saldo_jasa = 0;
                    }
                    
                    $kpenambahan = "+" . $pinj_i->jangka . " month";
                    $ktgl2 = date('Y-m-d', strtotime($kpenambahan, strtotime($pinj_i->tgl_cair)));
                    $tgl_cair = explode('-', $pinj_i->tgl_cair);
                    $th_cair = $tgl_cair[0];
                    $bl_cair = $tgl_cair[1];
                    $tg_cair = $tgl_cair[2];

                    $selisih_tahun = ($tahun - $th_cair) * 12;
                    $selisih_bulan = $bulan - $bl_cair;

                    $selisih = $selisih_bulan + $selisih_tahun;
                    $jum_nunggak = ceil($wajib_pokok == 0 ? 0 : $tunggakan_pokok/$wajib_pokok);
                    $kolek = 0;
                    if ($tunggakan_pokok <= 0) {
                        $kolek = 0;
                    } elseif ($jatuh_tempo != 0) {
                        $kolek = round((strtotime($tgl_kondisi) - strtotime($jatuh_tempo)) / (60 * 60 * 24))+(($jum_nunggak-1)*30);
                        if ($kolek < 0) {
                            $kolek = 0;
                        }
                    }

                    if ($kolek < 10) {
                        $keterangan = 'Lancar';
                    } elseif ($kolek < 90) {
                        $keterangan = 'Dalam Perhatian Khusus';
                    } elseif ($kolek < 120) {
                        $keterangan = 'kurang Lancar';
                    } elseif ($kolek < 180) {
                        $keterangan = 'Diragukan';
                    } else {
                        $keterangan = 'Macet';
                    }
                    if ($pinj_i->tgl_lunas <= $tgl_kondisi && $pinj_i->status != 'A') {
                        $keterangan = match ($pinj_i->status) {
                            'L' => 'Lunas',
                            'R' => 'Rescheduling',
                            'H' => 'Hapus',
                            default => 'Lunas',
                        };
                    }
                    $jaminan = json_decode($pinj_i->jaminan, true) ?? [];
                    $jenisJaminan = $jaminan['jenis_jaminan'] ?? null;
                    $nilaiJaminan = isset($jaminan['nilai_jaminan']) ? (float) $jaminan['nilai_jaminan'] : 0;

                    $jenisJaminanMap = [
                        '1' => 'Surat Tanah',
                        '2' => 'BPKB',
                        '3' => 'SK. Pegawai',
                        '4' => 'Lain Lain',
                        '5' => 'Surat Tanah dan Bangunan (SHM)'
                    ];

                    $Jenis_Agunan = $jenisJaminanMap[$jenisJaminan] ?? 'Tidak Diketahui';
                    $Nilai_Agunan = number_format($nilaiJaminan, 2);

                @endphp

                <tr align="right" height="15px" class="style9">
                    <td class="l t" align="center">{{ $nomor++ }}</td>
                    <td class="l t" align="left">{{ $pinj_i->namadepan }} - {{ $pinj_i->id }}</td>
                    <td class="l t" align="left">{{ strtoupper($jpp_i->deskripsi_jpp) }}</td>
                    <td class="l t" align="center">{{ $pinj_i->angsuran_pokok->nama_sistem }}</td>
                    <td class="l t" align="center">{{ Tanggal::tglIndo($pinj_i->tgl_cair) }}</td>
                    <td class="l t" align="center">{{ Tanggal::tglIndo($ktgl2) }}</td>
                    <td class="l t">{{ $kpros_jasa }}%</td>
                    <td class="l t" align="center">per bulan</td>
                    <td class="l t">{{ number_format($pinj_i->alokasi) }}</td>
                    <td class="l t">{{ number_format($saldo_pokok) }}</td>
                    <td class="l t">
                        @if ($kolek > 180)
                            {{ ceil($kolek / 30) }} bulan
                        @elseif ($kolek > 0)
                            {{ number_format($kolek) }} hari
                        @else
                            {{ $kolek }}
                        @endif 
                    </td>
                <td class="l t" align="left">{{$keterangan}}</td>
                <td class="l t">{{ $Jenis_Agunan }}</td>
                <td class="l t r" align="left">{{ $Nilai_Agunan }}</td>
                </tr>

                @php
                    $j_alokasi += $pinj_i->alokasi;
                    $j_saldo += $saldo_pokok;
                    $j_tunggakan_pokok += $tunggakan_pokok;
                    $j_tunggakan_jasa += $tunggakan_jasa;
                @endphp
            @endforeach

            @if (count($kd_desa) > 0)
                @php
                    $j_pross = $j_saldo / $j_alokasi;
                    $t_alokasi += $j_alokasi;
                    $t_saldo += $j_saldo;
                    $t_tunggakan_pokok += $j_tunggakan_pokok;
                    $t_tunggakan_jasa += $j_tunggakan_jasa;
                @endphp
                <tr style="font-weight: bold; border: 1px solid;">
                    <td class="t l b" colspan="8" align="left" height="15">Jumlah {{ $nama_desa }}</td>
                    <td class="t l b" align="right">{{ number_format($j_alokasi) }}</td>
                    <td class="t l b" align="right">{{ number_format($j_saldo) }}</td>
                    <td colspan="4" class="t l b" align="right"></td>
                </tr>

                @php
                    $t_pros = 0;
                    if ($t_saldo) {
                        $t_pross = $t_saldo / $t_alokasi;
                    }
                @endphp

                <tr>
                    <td colspan="14" style="padding: 0px !important;">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px; table-layout: fixed;">
                            @php
                                $t_pros = 0;
                                if ($t_saldo) {
                                    $t_pross = $t_saldo / $t_alokasi;
                                }
                            @endphp

                            <tr align="center" height="3px" style="font-size: 11px;">
                                <td width="3%">&nbsp;</td>
                                <td width="18%"></td>
                                <td width="12%"></td>
                                <td width="7%"></td>
                                <td width="6%"></td>
                                <td width="6%"></td>
                                <td width="4%"></td>
                                <td width="5%"></td>
                                <td width="7%"></td>
                                <td width="8%"></td>
                                <td width="6%"></td>
                                <td width="5%"></td>
                                <td width="6%"></td>
                                <td width="9%"></td>
                            </tr>

                            <tr class="style9">
                                <th colspan="8" class="l t b" align="center" style="background:rgba(0,0,0, 0.3);">TOTAL KESELURUHAN({{ $jumlah_aktif }} Anggota)</th>
                                <th class="l t b" align="right">{{ number_format($t_alokasi) }}</th>
                                <th class="l t b" align="right">{{ number_format($t_saldo) }}</th>
                                <th colspan="4" class="l r t b" align="right"></th>
                            </tr>

                            <tr>
                                <td colspan="14">
                                    <div style="margin-top: 16px;"></div>
                                    {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endif
        </table>
    @endforeach
@endsection
