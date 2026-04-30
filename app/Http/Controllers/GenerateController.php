<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PinjamanIndividu;
use App\Models\PinjamanKelompok;
use App\Models\RealAngsuran;
use App\Models\RealAngsuranI;
use App\Models\RencanaAngsuran;
use App\Models\RencanaAngsuranI;
use App\Utils\Keuangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use Throwable;
use URL;

class GenerateController extends Controller
{
    // =========================================================================
    // COA Koperasi — $RRODUX2 (siupk_koperasi)
    // =========================================================================
    // jenis_pp = 1  → Anggota
    //   Pokok  : 1.1.03.01  | Jasa  : 4.1.01.01  | Denda : 4.1.02.01
    //
    // jenis_pp = 2  → Pinjaman Koperasi Lain  (diperlakukan sama dengan Non-Anggota)
    // jenis_pp = 3  → Non-Anggota
    //   Pokok  : 1.1.03.02  | Jasa  : 4.2.01.01  | Denda : 4.2.02.01
    // =========================================================================

    private function getRekening(int $jenis_pp): array
    {
        if ($jenis_pp === 1) {
            return [
                'pokok' => '1.1.03.01',
                'jasa'  => '4.1.01.01',
                'denda' => '4.1.02.01',
            ];
        }

        return [
            'pokok' => '1.1.03.02',
            'jasa'  => '4.2.01.01',
            'denda' => '4.2.02.01',
        ];
    }

    // =========================================================================
    // Routes
    // =========================================================================

    public function index()
    {
        $kec = Kecamatan::where('web_kec', explode('//', URL::to('/'))[1])
            ->orWhere('web_alternatif', explode('//', URL::to('/'))[1])
            ->first();

        Session::put('lokasi', $kec->id);

        $logo = '/assets/img/icon/favicon.png';
        if ($kec->logo) {
            $logo = '/storage/logo/' . $kec->logo;
        }

        return view('generate.index')->with(compact('logo'));
    }

    public function individu()
    {
        $kec      = Kecamatan::where('id', Session::get('lokasi'))->first();
        $database = env('DB_DATABASE', 'siupk_koperasi');
        $table    = 'pinjaman_anggota_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?
            ORDER BY ORDINAL_POSITION
        ", [$table, $database]);

        $struktur = array_map(fn($k) => $k->COLUMN_NAME, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.individu')->with(compact('struktur', 'kec'))->render()
        ]);
    }

    public function kelompok()
    {
        $database = env('DB_DATABASE', 'siupk_koperasi');
        $table    = 'pinjaman_kelompok_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?
            ORDER BY ORDINAL_POSITION
        ", [$table, $database]);

        $struktur = array_map(fn($k) => $k->COLUMN_NAME, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.kelompok')->with(compact('struktur'))->render()
        ]);
    }

    // =========================================================================
    // Generate
    // =========================================================================

    public function generate(Request $request)
    {
        // Bungkus seluruh proses dalam try-catch utama
        try {
            return $this->doGenerate($request);
        } catch (Throwable $e) {
            // Log detail error untuk debugging server
            Log::error('[Generate] Uncaught exception', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile() . ':' . $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error'  => 'Terjadi error tidak terduga: ' . class_basename($e),
                'detail' => $e->getMessage() . ' — ' . basename($e->getFile()) . ':' . $e->getLine(),
            ], 500);
        }
    }

    private function doGenerate(Request $request): \Illuminate\Http\JsonResponse
    {
        $real    = [];
        $rencana = [];
        $offset  = (int) $request->input('offset', 0);
        $limit   = 30;
        $is_pinkel = ($request->input('pinjaman') === 'kelompok');

        // ------------------------------------------------------------------
        // Pastikan lokasi — session atau fallback dari _lokasi (AJAX)
        // ------------------------------------------------------------------
        $lokasi = Session::get('lokasi');
        if (!$lokasi && $request->filled('_lokasi')) {
            $lokasi = $request->input('_lokasi');
            Session::put('lokasi', $lokasi);
        }

        if (!$lokasi) {
            return response()->json([
                'error'  => 'Lokasi tidak ditemukan di session.',
                'detail' => 'Silakan refresh halaman dan coba lagi.',
            ], 422);
        }

        $kec = Kecamatan::where('id', $lokasi)->first();
        if (!$kec) {
            return response()->json([
                'error'  => 'Kecamatan dengan ID ' . $lokasi . ' tidak ditemukan.',
                'detail' => 'Periksa konfigurasi session lokasi.',
            ], 422);
        }

        // ------------------------------------------------------------------
        // Bangun WHERE — skip field kosong & field internal
        // ------------------------------------------------------------------
        $skip       = ['_token', 'pinjaman', 'offset', '_lokasi', 'jenis_pinjaman'];
        $where      = [];
        $whereIn    = [];
        $whereNotIn = [];

        foreach ($request->all() as $key => $val) {
            if (in_array($key, $skip)) continue;

            if (is_array($val)) {
                $opt   = $val['operator'] ?? '=';
                $value = trim($val['value'] ?? '');

                if ($value === '') continue; // kosong → abaikan

                if ($opt === 'IN') {
                    foreach (explode(',', $value) as $v) {
                        $v = trim($v);
                        if ($v !== '') $whereIn[$key][] = $v;
                    }
                    continue;
                }

                if ($opt === 'NOT IN') {
                    foreach (explode(',', $value) as $v) {
                        $v = trim($v);
                        if ($v !== '') $whereNotIn[$key][] = $v;
                    }
                    continue;
                }

                $where[] = [$key, $opt, $value];
            } else {
                $val = trim((string) $val);
                if ($val !== '') $where[] = [$key, '=', $val];
            }
        }

        // ------------------------------------------------------------------
        // Query pinjaman
        // ------------------------------------------------------------------
        if ($is_pinkel) {
            $query = PinjamanKelompok::where($where)->with([
                'sis_pokok', 'sis_jasa',
                'trx'        => fn($q) => $q->where('idtp', '!=', '0'),
                'trx.tr_idtp',
                'kelompok', 'kelompok.d',
            ]);
        } else {
            $query = PinjamanIndividu::where($where)->with([
                'sis_pokok', 'sis_jasa',
                'trx'        => fn($q) => $q->where('idtp', '!=', '0'),
                'trx.tr_idtp',
                'anggota', 'anggota.d',
            ]);
        }

        foreach ($whereIn    as $k => $v) $query = $query->whereIn($k, $v);
        foreach ($whereNotIn as $k => $v) $query = $query->whereNotIn($k, $v);

        $pinjaman = $query->limit($limit)->offset($offset)->orderBy('id', 'ASC')->get();

        if ($pinjaman->isEmpty()) {
            return response()->json(['count' => 0, 'offset' => $offset + $limit]);
        }

        // ------------------------------------------------------------------
        // Loop setiap pinjaman
        // ------------------------------------------------------------------
        $data_id_pinj = [];
        $data_id_real = [];

        foreach ($pinjaman as $pinj) {
            try {
                $this->processPinjaman(
                    $pinj, $kec, $is_pinkel,
                    $rencana, $real,
                    $data_id_pinj, $data_id_real
                );
            } catch (Throwable $e) {
                // Satu pinjaman error tidak boleh menghentikan batch
                Log::warning('[Generate] Skip pinjaman id=' . $pinj->id, [
                    'error' => $e->getMessage(),
                    'file'  => basename($e->getFile()) . ':' . $e->getLine(),
                ]);
            }
        }

        // ------------------------------------------------------------------
        // Simpan ke database
        // ------------------------------------------------------------------
        try {
            if ($is_pinkel) {
                RencanaAngsuran::whereIn('loan_id', $data_id_pinj)->delete();
                RealAngsuran::whereIn('loan_id', $data_id_pinj)->delete();
                if (!empty($rencana)) RencanaAngsuran::insert($rencana);
                if (!empty($real))    RealAngsuran::insert(array_values($real));
            } else {
                RencanaAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();
                RealAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();
                if (!empty($rencana)) RencanaAngsuranI::insert($rencana);
                if (!empty($real))    RealAngsuranI::insert(array_values($real));
            }
        } catch (Throwable $e) {
            Log::error('[Generate] Gagal insert ke database', [
                'message' => $e->getMessage(),
                'ids'     => $data_id_pinj,
            ]);

            return response()->json([
                'error'  => 'Gagal menyimpan data ke database.',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'count'  => count($data_id_pinj),
            'offset' => $offset + $limit,
            'ids'    => $data_id_pinj,
        ]);
    }

    // =========================================================================
    // Proses satu pinjaman
    // =========================================================================

    private function processPinjaman(
        $pinj, $kec, bool $is_pinkel,
        array &$rencana, array &$real,
        array &$data_id_pinj, array &$data_id_real
    ): void {
        $data_id_pinj[] = $pinj->id;

        // ── COA berdasarkan jenis_pp ─────────────────────────────────────────
        $jenis_pp = (int) ($pinj->jenis_pp ?? 1);
        $rek      = $this->getRekening($jenis_pp);

        // ── Parsing tgl_cair & alokasi dari kolom data_* ─────────────────────
        [$alokasi, $tgl_cair] = $this->parseAlokasiTgl($pinj);

        // Validasi alokasi — harus numerik positif
        if (!is_numeric($alokasi) || $alokasi <= 0) {
            throw new \RuntimeException(
                "Pinjaman id={$pinj->id}: alokasi tidak valid ({$alokasi})"
            );
        }
        $alokasi = (int) $alokasi;

        // Validasi tanggal
        if (!$tgl_cair || $tgl_cair === '0000-00-00') {
            throw new \RuntimeException(
                "Pinjaman id={$pinj->id}: tgl_cair tidak valid ({$tgl_cair})"
            );
        }

        $jenis_jasa = (string) ($pinj->jenis_jasa ?? '1');
        $jangka     = (int)   ($pinj->jangka     ?? 0);
        $sa_pokok   = (int)   ($pinj->sistem_angsuran ?? 1);
        $sa_jasa    = (int)   ($pinj->sa_jasa    ?? 1);
        $pros_jasa  = (float) ($pinj->pros_jasa  ?? 0);

        if ($jangka <= 0) {
            throw new \RuntimeException("Pinjaman id={$pinj->id}: jangka tidak valid ({$jangka})");
        }

        // ── Jadwal angsuran ──────────────────────────────────────────────────
        $index           = 1;
        $jumlah_angsuran = $jangka;
        $simpan_tgl      = $tgl_cair;

        if ((int) $kec->jdwl_angsuran === 1) {
            $index           = 0;
            $jumlah_angsuran = $jangka - 1;
        }

        $desa = $is_pinkel
            ? ($pinj->kelompok->d ?? null)
            : ($pinj->anggota->d  ?? null);

        $tanggal_cair = (int) date('d', strtotime($tgl_cair));

        if ($desa && (int) $desa->jadwal_angsuran_desa > 0) {
            $tgl_cair = date('Y-m', strtotime($tgl_cair)) . '-' . $desa->jadwal_angsuran_desa;
        }

        if ((int) $kec->batas_angsuran > 0 && $tanggal_cair >= (int) $kec->batas_angsuran) {
            $tgl_cair = date('Y-m-d', strtotime('+1 month', strtotime($tgl_cair)));
        }

        // ── Sistem angsuran ──────────────────────────────────────────────────
        $sistem_pokok = $pinj->sis_pokok ? (int) $pinj->sis_pokok->sistem : 1;
        $sistem_jasa  = $pinj->sis_jasa  ? (int) $pinj->sis_jasa->sistem  : 1;

        $tempo_pokok = $this->hitungTempo($sa_pokok, $jangka, $sistem_pokok);
        $tempo_jasa  = $this->hitungTempo($sa_jasa,  $jangka, $sistem_jasa);

        // ── Hitung rencana angsuran (ra) ─────────────────────────────────────
        $ra = $this->hitungRa(
            $jenis_jasa, $alokasi, $jangka, $pros_jasa,
            $index, $jumlah_angsuran,
            $sistem_pokok, $sistem_jasa,
            $tempo_pokok, $tempo_jasa,
            $kec
        );

        // ── Build data_rencana ───────────────────────────────────────────────
        $data_rencana = [];
        $target_pokok = 0;
        $target_jasa  = 0;

        if ($index === 1) {
            $row0 = [
                'loan_id'      => $pinj->id,
                'angsuran_ke'  => 0,
                'jatuh_tempo'  => $simpan_tgl,
                'wajib_pokok'  => 0,
                'wajib_jasa'   => 0,
                'target_pokok' => 0,
                'target_jasa'  => 0,
                'lu'           => now()->toDateTimeString(),
                'id_user'      => 1,
            ];
            $data_rencana[strtotime($simpan_tgl)] = $row0;
            $rencana[] = $row0;
        }

        for ($x = $index; $x <= $jumlah_angsuran; $x++) {
            $jatuh_tempo = ($sa_pokok === 12 || $sa_pokok === 25)
                ? Carbon::parse($tgl_cair)->addDays($x * 7)->toDateString()
                : Carbon::parse($tgl_cair)->addMonthsNoOverflow($x)->toDateString();

            $pokok = (int) ($ra[$x]['pokok'] ?? 0);
            $jasa  = (int) ($ra[$x]['jasa']  ?? 0);

            $target_pokok += $pokok;
            $target_jasa  += $jasa;

            $row = [
                'loan_id'      => $pinj->id,
                'angsuran_ke'  => $x,
                'jatuh_tempo'  => $jatuh_tempo,
                'wajib_pokok'  => $pokok,
                'wajib_jasa'   => $jasa,
                'target_pokok' => $target_pokok,
                'target_jasa'  => $target_jasa,
                'lu'           => now()->toDateTimeString(),
                'id_user'      => 1,
            ];
            $data_rencana[strtotime($jatuh_tempo)] = $row;
            $rencana[] = $row;
        }

        // ── Build data_real dari transaksi ───────────────────────────────────
        $alokasi_pokok = $alokasi;
        $alokasi_jasa  = $target_jasa;
        $sum_pokok     = 0;
        $sum_jasa      = 0;
        $data_idtp     = [];

        ksort($data_rencana);

        foreach ($pinj->trx as $trx) {
            // Skip denda
            if (Keuangan::startWith($trx->rekening_kredit ?? '', $rek['denda'])) continue;
            if (in_array($trx->idtp, $data_idtp)) continue;

            $realisasi_pokok = 0;
            $realisasi_jasa  = 0;

            foreach ($trx->tr_idtp as $idtp) {
                if ($is_pinkel) {
                    if ($idtp->id_pinj   != $pinj->id) continue;
                } else {
                    if ($idtp->id_pinj_i != $pinj->id) continue;
                }

                $jumlah = intval($idtp->jumlah ?? 0);

                if (Keuangan::startWith($idtp->rekening_kredit ?? '', $rek['pokok'])) {
                    $realisasi_pokok  = $jumlah;
                    $sum_pokok       += $jumlah;
                    $alokasi_pokok   -= $jumlah;
                }

                if (Keuangan::startWith($idtp->rekening_kredit ?? '', $rek['jasa'])) {
                    $realisasi_jasa  = $jumlah;
                    $sum_jasa       += $jumlah;
                    $alokasi_jasa   -= $jumlah;
                }
            }

            // Cari rencana aktif saat tanggal transaksi
            $ra_aktif       = [];
            $time_transaksi = strtotime($trx->tgl_transaksi);
            foreach ($data_rencana as $key => $value) {
                if ($key <= $time_transaksi) $ra_aktif = $value;
            }

            $tp = (int) ($ra_aktif['target_pokok'] ?? 0);
            $tj = (int) ($ra_aktif['target_jasa']  ?? 0);

            $real[$trx->idtp] = [
                'id'              => $trx->idtp,
                'loan_id'         => $pinj->id,
                'tgl_transaksi'   => $trx->tgl_transaksi,
                'realisasi_pokok' => $realisasi_pokok,
                'realisasi_jasa'  => $realisasi_jasa,
                'sum_pokok'       => $sum_pokok,
                'sum_jasa'        => $sum_jasa,
                'saldo_pokok'     => $alokasi_pokok,
                'saldo_jasa'      => $alokasi_jasa,
                'tunggakan_pokok' => max(0, $tp - $sum_pokok),
                'tunggakan_jasa'  => max(0, $tj - $sum_jasa),
                'lu'              => now()->toDateTimeString(),
                'id_user'         => 1,
            ];

            $data_id_real[] = $trx->idtp;
            $data_idtp[]    = $trx->idtp;
        }
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Parsing alokasi & tgl_cair dari kolom data_* berdasarkan status pinjaman.
     */
    private function parseAlokasiTgl($pinj): array
    {
        $status = $pinj->status ?? '';

        if (in_array($status, ['P', 'V'])) {
            $col   = ($status === 'P') ? $pinj->data_proposal : $pinj->data_verifikasi;
            $parts = explode('#', $col ?? '');
            $tgl   = $parts[0] ?? $pinj->tgl_cair;
            $alok  = $parts[1] ?? $pinj->alokasi;
        } elseif ($status === 'W') {
            $parts = explode('#', $pinj->data_waiting ?? '');
            $tgl   = $parts[0] ?? $pinj->tgl_cair;
            $alok  = $pinj->alokasi;
        } else {
            // Status L/aktif — pakai kolom langsung
            $alok = $pinj->alokasi;
            $tgl  = $pinj->tgl_cair;

            if (!$tgl || $tgl === '0000-00-00') {
                $parts = explode('#', $pinj->data_waiting ?? '');
                $tgl   = $parts[0] ?? date('Y-m-d');
            }
        }

        return [$alok, $tgl];
    }

    /**
     * Hitung tempo berdasarkan kode sistem angsuran.
     */
    private function hitungTempo(int $sa, int $jangka, int $sistem): int
    {
        return match ($sa) {
            11 => (int) ($jangka - 24 / $sistem),
            14 => (int) ($jangka - 3  / $sistem),
            15 => (int) ($jangka - 2  / $sistem),
            20 => (int) ($jangka - 12 / $sistem),
            default => (int) floor($jangka / $sistem),
        };
    }

    /**
     * Hitung rencana angsuran per periode (ra).
     */
    private function hitungRa(
        string $jenis_jasa, int $alokasi, int $jangka, float $pros_jasa,
        int $index, int $jumlah_angsuran,
        int $sistem_pokok, int $sistem_jasa,
        int $tempo_pokok, int $tempo_jasa,
        $kec
    ): array {
        $ra = [];

        if ($jenis_jasa === '3') {
            // ── Anuitas ───────────────────────────────────────────────────
            if ($pros_jasa <= 0 || $jangka <= 0) {
                throw new \RuntimeException('Anuitas: pros_jasa atau jangka tidak valid.');
            }

            $bpm   = ($pros_jasa / 100) / $jangka;
            $total = Keuangan::pembulatan(
                ($alokasi * $bpm) / (1 - pow(1 + $bpm, -$jangka)),
                (string) $kec->pembulatan
            );

            $sisa = $alokasi;
            for ($j = $index; $j <= $jumlah_angsuran; $j++) {
                $jasa  = Keuangan::pembulatan($sisa * $bpm, (string) $kec->pembulatan);
                $pokok = $total - $jasa;

                if ($j === $jumlah_angsuran) {
                    $pokok = $sisa;
                    $total = $pokok + $jasa;
                }

                $ra[$j] = ['pokok' => $pokok, 'jasa' => $jasa];
                $sisa  -= $pokok;
            }
        } else {
            // ── Flat / Efektif ────────────────────────────────────────────
            $sum_jasa  = 0;
            $sum_pokok = 0;

            for ($j = $index; $j <= $jumlah_angsuran; $j++) {
                $sisa_j    = $j % $sistem_jasa;
                $ke_j      = $j / $sistem_jasa;
                $alokasi_j = Keuangan::pembulatan($alokasi * ($pros_jasa / 100));
                $wajib_j   = $alokasi_j / $tempo_jasa;

                if ($kec->pembulatan != '5000') {
                    $wajib_j = Keuangan::pembulatan($wajib_j, (string) $kec->pembulatan);
                }

                if ($sisa_j == 0 && $ke_j != $tempo_jasa && ($sum_jasa + $wajib_j) < $alokasi_j) {
                    $angsuran_jasa = $wajib_j;
                } elseif ($sisa_j == 0 && ($ke_j == $tempo_jasa || ($sum_jasa + $wajib_j) >= $alokasi_j)) {
                    $angsuran_jasa = $alokasi_j - $sum_jasa;
                } else {
                    $angsuran_jasa = 0;
                }

                $sum_jasa      += $angsuran_jasa;
                $ra[$j]['jasa'] = $angsuran_jasa;
            }

            for ($i = $index; $i <= $jumlah_angsuran; $i++) {
                $sisa_i = $i % $sistem_pokok;
                $ke_i   = $i / $sistem_pokok;
                $wajib  = Keuangan::pembulatan($alokasi / $tempo_pokok, (string) $kec->pembulatan);

                if ($sisa_i == 0 && $ke_i != $tempo_pokok && ($sum_pokok + $wajib) < $alokasi) {
                    $angsuran_pokok = $wajib;
                } elseif ($sisa_i == 0 && ($ke_i == $tempo_pokok || ($sum_pokok + $wajib) >= $alokasi)) {
                    $angsuran_pokok = $alokasi - $sum_pokok;
                } else {
                    $angsuran_pokok = 0;
                }

                $sum_pokok        += $angsuran_pokok;
                $ra[$i]['pokok']   = $angsuran_pokok;
            }
        }

        return $ra;
    }
}
