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
     $waiting_user] = array_pad(explode('#', $perguliran_i->data_waiting), 9, null);

    $sistem_angsuran_list = \App\Models\SistemAngsuran::all()->keyBy('id');

    // Helper: format Rupiah
    $fmt_rp = fn($val) => $val ? 'Rp ' . number_format((float) $val, 0, ',', '.') : '-';

    // Helper: format bulan
    $fmt_bln = fn($val) => $val ? $val . ' Bulan' : '-';

    // Helper: truncate catatan 25 char
    $fmt_cat = fn($val) => $val
        ? (mb_strlen($val) > 25 ? mb_substr($val, 0, 25) . ' . . .' : $val)
        : '-';

    // Helper: ambil deskripsi sistem_angsuran by id
    $fmt_sa = fn($id) => ($id && isset($sistem_angsuran_list[$id]))
        ? $sistem_angsuran_list[$id]->deskripsi_sistem
        : ($id ? $id : '-');
@endphp

<style>
    .tooltip-catatan {
        position: fixed;
        background: #1a202c;
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        max-width: 280px;
        word-wrap: break-word;
        pointer-events: none;
        z-index: 99999;
        display: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        line-height: 1.5;
    }
    .td-catatan {
        cursor: default;
    }
    .td-catatan[data-full]:hover {
        background-color: #f0fffe;
    }
</style>

<div id="tooltip-catatan" class="tooltip-catatan"></div>

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
            <td>{{ $fmt_rp($proposal_alokasi) }}</td>
            <td>{{ $fmt_bln($proposal_jangka) }}</td>
            <td>{{ $proposal_persen ?? '0' }} %</td>
            <td>{{ $proposal_jj ? Pinjaman::namaJJ($proposal_jj) : '-' }}</td>
            <td>{{ $fmt_sa($proposal_sa_pokok) }}</td>
            <td>{{ $fmt_sa($proposal_sa_jasa) }}</td>
            <td class="td-catatan" @if($proposal_catatan && mb_strlen($proposal_catatan) > 25) data-full="{{ $proposal_catatan }}" @endif>
                {{ $fmt_cat($proposal_catatan) }}
            </td>
            <td>{{ $proposal_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi ================= --}}
        @if(in_array('V', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">Verifikasi</span></td>
            <td>{{ $verifikasi_tanggal ?? '-' }}</td>
            <td>{{ $fmt_rp($verifikasi_alokasi) }}</td>
            <td>{{ $fmt_bln($verifikasi_jangka) }}</td>
            <td>{{ $verifikasi_persen ?? '0' }} %</td>
            <td>{{ $verifikasi_jj ? Pinjaman::namaJJ($verifikasi_jj) : '-' }}</td>
            <td>{{ $fmt_sa($verifikasi_sa_pokok) }}</td>
            <td>{{ $fmt_sa($verifikasi_sa_jasa) }}</td>
            <td class="td-catatan" @if($verifikasi_catatan && mb_strlen($verifikasi_catatan) > 25) data-full="{{ $verifikasi_catatan }}" @endif>
                {{ $fmt_cat($verifikasi_catatan) }}
            </td>
            <td>{{ $verifikasi_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 1 ================= --}}
        @if(in_array('V1', $tampilkan_status) && isset($v1))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v1 }}</span></td>
            <td>{{ $verifikasi1_tanggal ?? '-' }}</td>
            <td>{{ $fmt_rp($verifikasi1_alokasi) }}</td>
            <td>{{ $fmt_bln($verifikasi1_jangka) }}</td>
            <td>{{ $verifikasi1_persen ?? '0' }} %</td>
            <td>{{ $verifikasi1_jj ? Pinjaman::namaJJ($verifikasi1_jj) : '-' }}</td>
            <td>{{ $fmt_sa($verifikasi1_sa_pokok) }}</td>
            <td>{{ $fmt_sa($verifikasi1_sa_jasa) }}</td>
            <td class="td-catatan" @if($verifikasi1_catatan && mb_strlen($verifikasi1_catatan) > 25) data-full="{{ $verifikasi1_catatan }}" @endif>
                {{ $fmt_cat($verifikasi1_catatan) }}
            </td>
            <td>{{ $verifikasi1_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 2 ================= --}}
        @if(in_array('V2', $tampilkan_status) && isset($v2))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v2 }}</span></td>
            <td>{{ $verifikasi2_tanggal ?? '-' }}</td>
            <td>{{ $fmt_rp($verifikasi2_alokasi) }}</td>
            <td>{{ $fmt_bln($verifikasi2_jangka) }}</td>
            <td>{{ $verifikasi2_persen ?? '0' }} %</td>
            <td>{{ $verifikasi2_jj ? Pinjaman::namaJJ($verifikasi2_jj) : '-' }}</td>
            <td>{{ $fmt_sa($verifikasi2_sa_pokok) }}</td>
            <td>{{ $fmt_sa($verifikasi2_sa_jasa) }}</td>
            <td class="td-catatan" @if($verifikasi2_catatan && mb_strlen($verifikasi2_catatan) > 25) data-full="{{ $verifikasi2_catatan }}" @endif>
                {{ $fmt_cat($verifikasi2_catatan) }}
            </td>
            <td>{{ $verifikasi2_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Verifikasi 3 ================= --}}
        @if(in_array('V3', $tampilkan_status) && isset($v3))
        <tr>
            <td class="text-center"><span class="badge bg-info text-dark fs-7 w-100 d-block">{{ $v3 }}</span></td>
            <td>{{ $verifikasi3_tanggal ?? '-' }}</td>
            <td>{{ $fmt_rp($verifikasi3_alokasi) }}</td>
            <td>{{ $fmt_bln($verifikasi3_jangka) }}</td>
            <td>{{ $verifikasi3_persen ?? '0' }} %</td>
            <td>{{ $verifikasi3_jj ? Pinjaman::namaJJ($verifikasi3_jj) : '-' }}</td>
            <td>{{ $fmt_sa($verifikasi3_sa_pokok) }}</td>
            <td>{{ $fmt_sa($verifikasi3_sa_jasa) }}</td>
            <td class="td-catatan" @if($verifikasi3_catatan && mb_strlen($verifikasi3_catatan) > 25) data-full="{{ $verifikasi3_catatan }}" @endif>
                {{ $fmt_cat($verifikasi3_catatan) }}
            </td>
            <td>{{ $verifikasi3_user ?? '-' }}</td>
        </tr>
        @endif

        {{-- ================= Waiting ================= --}}
        @if(in_array('W', $tampilkan_status))
        <tr>
            <td class="text-center"><span class="badge bg-warning text-dark fs-7 w-100 d-block">Waiting List</span></td>
            <td>{{ $waiting_tanggal ?? '-' }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td>{{ $waiting_user ?? '-' }}</td>
        </tr>
        @endif
    </tbody>
</table>

<script>
    (function () {
        const tooltip = document.getElementById('tooltip-catatan');
        if (!tooltip) return;

        document.querySelectorAll('.td-catatan[data-full]').forEach(function (td) {
            td.addEventListener('mouseenter', function () {
                tooltip.textContent = td.getAttribute('data-full');
                tooltip.style.display = 'block';
            });
            td.addEventListener('mousemove', function (e) {
                const offsetX = 14;
                const offsetY = 14;
                let x = e.clientX + offsetX;
                let y = e.clientY + offsetY;

                // Jaga agar tooltip tidak keluar dari viewport
                const rect = tooltip.getBoundingClientRect();
                if (x + rect.width > window.innerWidth - 10) {
                    x = e.clientX - rect.width - offsetX;
                }
                if (y + rect.height > window.innerHeight - 10) {
                    y = e.clientY - rect.height - offsetY;
                }

                tooltip.style.left = x + 'px';
                tooltip.style.top  = y + 'px';
            });
            td.addEventListener('mouseleave', function () {
                tooltip.style.display = 'none';
            });
        });
    })();
</script>
