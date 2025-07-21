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
            @foreach(range(0, 8) as $i)
                <td>{{ $data_proposal[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif

        @if(in_array('V', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">Verifikasi</span></td>
            @foreach(range(0, 8) as $i)
                <td>{{ $data_verifikasi[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif

        @if(in_array('V1', $tampilkan_status) && isset($v1))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v1 }}</span></td>
            @foreach(range(0, 8) as $i)
                <td>{{ $data_verifikasi1[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif

        @if(in_array('V2', $tampilkan_status) && isset($v2))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v2 }}</span></td>
            @foreach(range(0, 8) as $i)
                <td>{{ $data_verifikasi2[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif

        @if(in_array('V3', $tampilkan_status) && isset($v3))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v3 }}</span></td>
            @foreach(range(0, 8) as $i)
                <td>{{ $data_verifikasi3[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif

        @if(in_array('W', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-warning text-dark fs-7 w-100 d-block">Waiting List</span></td>
            @foreach(range(0, 8) as $i)
                <td>{{ $data_waiting[$i] ?? '-' }}</td>
            @endforeach
        </tr>
        @endif
    </tbody>
</table>
