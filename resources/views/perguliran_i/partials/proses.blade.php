@php
    $status_urut = ['P', 'V', 'V1', 'V2', 'V3', 'W', 'A'];
    $current_status = $perguliran_i->status;
    $tampilkan_status = [];

    foreach ($status_urut as $s) {
        $tampilkan_status[] = $s;
        if ($s == $current_status) break;
    }

    $data_proposal = explode('#', $perguliran_i->data_proposal);
    $data_verifikasi = explode('#', $perguliran_i->data_verifikasi);
    $data_verifikasi1 = explode('#', $perguliran_i->data_verifikasi1);
    $data_verifikasi2 = explode('#', $perguliran_i->data_verifikasi2);
    $data_verifikasi3 = explode('#', $perguliran_i->data_verifikasi3);
    $data_waiting = explode('#', $perguliran_i->data_waiting);
@endphp
<table class="table table-bordered table-striped small">
    <thead class="text-center">
        <tr>
            <th style="width: 10%;">Sumber Data/Status</th>
            <th style="width: 10%;">Tanggal</th>
            <th style="width: 10%;">Alokasi</th>
            <th style="width: 10%;">Jangka</th>
            <th style="width: 5%;">%</th>
            <th style="width: 10%;">Jenis Jasa</th>
            <th style="width: 10%;">SA. Pokok</th>
            <th style="width: 10%;">SA. Jasa</th>
            <th style="width: 20%;">Catatan</th>
            <th style="width: 5%;"><i class="fas fa-user"></i></th>
        </tr>
    </thead>
    <tbody>
        @if(in_array('P', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-secondary text-dark fs-7 w-100 d-block">Proposal</span></td>
            <td>{{ $data_proposal[0] ?? '-' }}</td>
            <td>Rp. {{ $data_proposal[1] ?? '-' }}</td>
            <td>{{ $data_proposal[2] ?? '-' }} Bulan</td>
            <td>{{ $data_proposal[3] ?? '0' }} %</td>
            <td>{{ isset($data_proposal[4]) ? Pinjaman::namaJJ($data_proposal[4]) : '-' }}</td>
            <td>{{ $data_proposal[5] ?? '-' }}</td>
            <td>{{ $data_proposal[6] ?? '-' }}</td>
            <td>{{ $data_proposal[7] ?? '-' }}</td>
            <td>{{ $data_proposal[8] ?? '-' }}</td>
        </tr>
        @endif

        @if(in_array('V', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">Verifikasi</span></td>
            <td>{{ $data_verifikasi[0] ?? '-' }}</td>
            <td>{{ $data_verifikasi[1] ?? '-' }}</td>
            <td>{{ $data_verifikasi[2] ?? '-' }}</td>
            <td>{{ $data_verifikasi[3] ?? '0' }} %</td>
            <td>{{ isset($data_verifikasi[4]) ? Pinjaman::namaJJ($data_verifikasi[4]) : '-' }}</td>
            <td>{{ $data_verifikasi[5] ?? '-' }}</td>
            <td>{{ $data_verifikasi[6] ?? '-' }}</td>
            <td>{{ $data_verifikasi[7] ?? '-' }}</td>
            <td>{{ $data_verifikasi[8] ?? '-' }}</td>
        </tr>
        @endif

        @if(in_array('V1', $tampilkan_status) && isset($v1))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v1 }}</span></td>
            <td>{{ $data_verifikasi1[0] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[1] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[2] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[3] ?? '0' }} %</td>
            <td>{{ isset($data_verifikasi1[4]) ? Pinjaman::namaJJ($data_verifikasi1[4]) : '-' }}</td>
            <td>{{ $data_verifikasi1[5] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[6] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[7] ?? '-' }}</td>
            <td>{{ $data_verifikasi1[8] ?? '-' }}</td>
        </tr>
        @endif

        @if(in_array('V2', $tampilkan_status) && isset($v2))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v2 }}</span></td>
            <td>{{ $data_verifikasi2[0] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[1] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[2] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[3] ?? '0' }} %</td>
            <td>{{ isset($data_verifikasi2[4]) ? Pinjaman::namaJJ($data_verifikasi2[4]) : '-' }}</td>
            <td>{{ $data_verifikasi2[5] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[6] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[7] ?? '-' }}</td>
            <td>{{ $data_verifikasi2[8] ?? '-' }}</td>
        </tr>
        @endif

        @if(in_array('V3', $tampilkan_status) && isset($v3))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v3 }}</span></td>
            <td>{{ $data_verifikasi3[0] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[1] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[2] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[3] ?? '0' }} %</td>
            <td>{{ isset($data_verifikasi3[4]) ? Pinjaman::namaJJ($data_verifikasi3[4]) : '-' }}</td>
            <td>{{ $data_verifikasi3[5] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[6] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[7] ?? '-' }}</td>
            <td>{{ $data_verifikasi3[8] ?? '-' }}</td>
        </tr>
        @endif

        @if(in_array('W', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-warning text-dark fs-7 w-100 d-block">Waiting List</span></td>
            <td>{{ $data_waiting[0] ?? '-' }}</td>
            <td>{{ $data_waiting[1] ?? '-' }}</td>
            <td>{{ $data_waiting[2] ?? '-' }}</td>
            <td>{{ $data_waiting[3] ?? '0' }} %</td>
            <td>{{ isset($data_waiting[4]) ? Pinjaman::namaJJ($data_waiting[4]) : '-' }}</td>
            <td>{{ $data_waiting[5] ?? '-' }}</td>
            <td>{{ $data_waiting[6] ?? '-' }}</td>
            <td>{{ $data_waiting[7] ?? '-' }}</td>
            <td>{{ $data_waiting[8] ?? '-' }}</td>
        </tr>
        @endif
    </tbody>
</table>
