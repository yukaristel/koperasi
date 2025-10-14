@php
    $status_urut = ['P', 'V', 'V1', 'V2', 'V3', 'W', 'A'];
    $current_status = $perguliran_i->status;
    $tampilkan_status = [];

    foreach ($status_urut as $s) {
        $tampilkan_status[] = $s;
        if ($s == $current_status) break;
    }

    // ================= Proposal =================
    [$proposal_tanggal,
     $proposal_alokasi,
     $proposal_jangka,
     $proposal_persen,
     $proposal_jj,
     $proposal_sa_pokok,
     $proposal_sa_jasa,
     $proposal_catatan,
     $proposal_user] = array_pad(explode('#', $perguliran_i->data_proposal), 9, null);

    // ================= Verifikasi =================
    [$verifikasi_tanggal,
     $verifikasi_alokasi,
     $verifikasi_jangka,
     $verifikasi_persen,
     $verifikasi_jj,
     $verifikasi_sa_pokok,
     $verifikasi_sa_jasa,
     $verifikasi_catatan,
     $verifikasi_user] = array_pad(explode('#', $perguliran_i->data_verifikasi), 9, null);

    // ================= Verifikasi 1 =================
    [$verifikasi1_tanggal,
     $verifikasi1_alokasi,
     $verifikasi1_jangka,
     $verifikasi1_persen,
     $verifikasi1_jj,
     $verifikasi1_sa_pokok,
     $verifikasi1_sa_jasa,
     $verifikasi1_catatan,
     $verifikasi1_user] = array_pad(explode('#', $perguliran_i->data_verifikasi1), 9, null);

    // ================= Verifikasi 2 =================
    [$verifikasi2_tanggal,
     $verifikasi2_alokasi,
     $verifikasi2_jangka,
     $verifikasi2_persen,
     $verifikasi2_jj,
     $verifikasi2_sa_pokok,
     $verifikasi2_sa_jasa,
     $verifikasi2_catatan,
     $verifikasi2_user] = array_pad(explode('#', $perguliran_i->data_verifikasi2), 9, null);

    // ================= Verifikasi 3 =================
    [$verifikasi3_tanggal,
     $verifikasi3_alokasi,
     $verifikasi3_jangka,
     $verifikasi3_persen,
     $verifikasi3_jj,
     $verifikasi3_sa_pokok,
     $verifikasi3_sa_jasa,
     $verifikasi3_catatan,
     $verifikasi3_user] = array_pad(explode('#', $perguliran_i->data_verifikasi3), 9, null);

    // ================= Waiting =================
    [$waiting_tanggal,
     $waiting_alokasi,
     $waiting_jangka,
     $waiting_persen,
     $waiting_jj,
     $waiting_sa_pokok,
     $waiting_sa_jasa,
     $waiting_catatan,
     $waiting_user] = array_pad(explode('#', $perguliran_i->data_waiting), 9, null);
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
        {{-- ================= Proposal ================= --}}
        @if(in_array('P', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-secondary text-dark fs-7 w-100 d-block">Proposal</span></td>
            <td>{{ $proposal_tanggal ?? '-' }}</td>
            <td>Rp. {{ $proposal_alokasi ?? '-' }}</td>
            <td>{{ $proposal_jangka ?? '-' }} Bulan</td>
            <td>{{ $proposal_persen ?? '0' }} %</td>
            <td>{{ $proposal_jj ? Pinjaman::namaJJ($proposal_jj) : '-' }}</td>
            <td>{{ $proposal_sa_pokok ?? '-' }}</td>
            <td>{{ $proposal_sa_jasa ?? '-' }}</td>
            <td>{{ $proposal_catatan ?? '-' }}</td>
            <td>{{ $proposal_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi ================= --}}
        @if(in_array('V', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">Verifikasi</span></td>
            <td>{{ $verifikasi_tanggal ?? '-' }}</td>
            <td>{{ $verifikasi_alokasi ?? '-' }}</td>
            <td>{{ $verifikasi_jangka ?? '-' }}</td>
            <td>{{ $verifikasi_persen ?? '0' }} %</td>
            <td>{{ $verifikasi_jj ? Pinjaman::namaJJ($verifikasi_jj) : '-' }}</td>
            <td>{{ $verifikasi_sa_pokok ?? '-' }}</td>
            <td>{{ $verifikasi_sa_jasa ?? '-' }}</td>
            <td>{{ $verifikasi_catatan ?? '-' }}</td>
            <td>{{ $verifikasi_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 1 ================= --}}
        @if(in_array('V1', $tampilkan_status) && isset($v1))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v1 }}</span></td>
            <td>{{ $verifikasi1_tanggal ?? '-' }}</td>
            <td>{{ $verifikasi1_alokasi ?? '-' }}</td>
            <td>{{ $verifikasi1_jangka ?? '-' }}</td>
            <td>{{ $verifikasi1_persen ?? '0' }} %</td>
            <td>{{ $verifikasi1_jj ? Pinjaman::namaJJ($verifikasi1_jj) : '-' }}</td>
            <td>{{ $verifikasi1_sa_pokok ?? '-' }}</td>
            <td>{{ $verifikasi1_sa_jasa ?? '-' }}</td>
            <td>{{ $verifikasi1_catatan ?? '-' }}</td>
            <td>{{ $verifikasi1_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 2 ================= --}}
        @if(in_array('V2', $tampilkan_status) && isset($v2))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v2 }}</span></td>
            <td>{{ $verifikasi2_tanggal ?? '-' }}</td>
            <td>{{ $verifikasi2_alokasi ?? '-' }}</td>
            <td>{{ $verifikasi2_jangka ?? '-' }}</td>
            <td>{{ $verifikasi2_persen ?? '0' }} %</td>
            <td>{{ $verifikasi2_jj ? Pinjaman::namaJJ($verifikasi2_jj) : '-' }}</td>
            <td>{{ $verifikasi2_sa_pokok ?? '-' }}</td>
            <td>{{ $verifikasi2_sa_jasa ?? '-' }}</td>
            <td>{{ $verifikasi2_catatan ?? '-' }}</td>
            <td>{{ $verifikasi2_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 3 ================= --}}
        @if(in_array('V3', $tampilkan_status) && isset($v3))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v3 }}</span></td>
            <td>{{ $verifikasi3_tanggal ?? '-' }}</td>
            <td>{{ $verifikasi3_alokasi ?? '-' }}</td>
            <td>{{ $verifikasi3_jangka ?? '-' }}</td>
            <td>{{ $verifikasi3_persen ?? '0' }} %</td>
            <td>{{ $verifikasi3_jj ? Pinjaman::namaJJ($verifikasi3_jj) : '-' }}</td>
            <td>{{ $verifikasi3_sa_pokok ?? '-' }}</td>
            <td>{{ $verifikasi3_sa_jasa ?? '-' }}</td>
            <td>{{ $verifikasi3_catatan ?? '-' }}</td>
            <td>{{ $verifikasi3_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Waiting ================= --}}
        @if(in_array('W', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-warning text-dark fs-7 w-100 d-block">Waiting List</span></td>
            <td>{{ $waiting_tanggal ?? '-' }}</td>
            <td>{{ $waiting_alokasi ?? '-' }}</td>
            <td>{{ $waiting_jangka ?? '-' }}</td>
            <td>{{ $waiting_persen ?? '0' }} %</td>
            <td>{{ $waiting_jj ? Pinjaman::namaJJ($waiting_jj) : '-' }}</td>
            <td>{{ $waiting_sa_pokok ?? '-' }}</td>
            <td>{{ $waiting_sa_jasa ?? '-' }}</td>
            <td>{{ $waiting_catatan ?? '-' }}</td>
            <td>{{ $waiting_user ?? '-' }}</td>
        </tr>
        @endif
    </tbody>
</table>
