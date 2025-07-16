<?php

namespace App\Utils;

use App\Models\ArusKasLkm;
use App\Models\Rekening;

class ArusKas
{
  protected static $rekDebit = [];
  protected static $rekKredit = [];

  public static function getTransaksiBulanan($tgl_awal_bulan, $tgl_akhir_bulan)
  {
    $akun1 = [];
    $akun2 = [];
    $akun3 = [];
    $akun4 = [];

    $queryRekening = Rekening::with([
      'trx_debit' => function ($query) use ($tgl_awal_bulan, $tgl_akhir_bulan) {
        $query->whereBetween('tgl_transaksi', [$tgl_awal_bulan, $tgl_akhir_bulan])->where('rekening_kredit', 'LIKE', '1.1.01%');
      },
      'trx_kredit' => function ($query) use ($tgl_awal_bulan, $tgl_akhir_bulan) {
        $query->whereBetween('tgl_transaksi', [$tgl_awal_bulan, $tgl_akhir_bulan])->where('rekening_debit', 'LIKE', '1.1.01%');
      }
    ])->get();
    foreach ($queryRekening as $rek) {
      $levelAkun = explode('.', $rek->kode_akun);
      $lev1 = $levelAkun[0];
      $lev2 = $levelAkun[1];
      $lev3 = str_pad($levelAkun[2], 2, '0', STR_PAD_LEFT);
      $lev4 = str_pad($levelAkun[3], 2, '0', STR_PAD_LEFT);

      $akunLevel1 = $lev1;
      $akunLevel2 = $lev1 . '.' . $lev2;
      $akunLevel3 = $lev1 . '.' . $lev2 . '.' . $lev3;
      $akunLevel4 = $lev1 . '.' . $lev2 . '.' . $lev3 . '.' . $lev4;

      $akun1[$akunLevel1][] = $rek;
      $akun2[$akunLevel2][] = $rek;
      $akun3[$akunLevel3][] = $rek;
      $akun4[$akunLevel4][] = $rek;
    }

    return [
      'akun1' => $akun1,
      'akun2' => $akun2,
      'akun3' => $akun3,
      'akun4' => $akun4
    ];
  }

  public static function arusKas($tgl_awal_bulan, $tgl_akhir_bulan)
  {
    self::$rekDebit = [];
    self::$rekKredit = [];

    $transaksiBulanan = self::getTransaksiBulanan($tgl_awal_bulan, $tgl_akhir_bulan);
    $akun1 = $transaksiBulanan['akun1'];
    $akun2 = $transaksiBulanan['akun2'];
    $akun3 = $transaksiBulanan['akun3'];
    $akun4 = $transaksiBulanan['akun4'];

    $nomor = 1;
    $arusKas = [];
    $arus_kas = ArusKasLkm::where('parent_id', '0')->with([
      'child.child.child.child',
    ])->get();
    foreach ($arus_kas as $arus_kas) {
      $arusKas[$nomor] = [
        'nomor' => $nomor,
        'nama_akun' => $arus_kas->nama_akun,
        'is_parent' => true,
        'child' => [],
        'saldo' => 0,
      ];
      if (count($arus_kas->child) > 0) {
        $numberChild1 = 1;
        $Child1 = [];
        foreach ($arus_kas->child as $child1) {
          $Child1[$numberChild1] = [
            'nomor' => $numberChild1,
            'nama_akun' => $child1->nama_akun,
            'child' => [],
            'saldo' => 0
          ];

          $Child1[$numberChild1]['mutasi'] = 'kredit';
          if (Keuangan::startWith($child1->nama_akun, 'A.')) {
            $Child1[$numberChild1]['mutasi'] = 'debit';
          }

          $numberChild2 = 1;
          $Child2 = [];
          foreach ($child1->child as $child2) {
            $Child2[$numberChild2] = [
              'nomor' => $numberChild2,
              'nama_akun' => $child2->nama_akun,
              'child' => [],
              'saldo' => 0
            ];

            $numberChild3 = 1;
            $Child3 = [];
            foreach ($child2->child as $child3) {
              if ($child3->nama_akun) {
                $Child3[$numberChild3] = [
                  'nomor' => $numberChild3,
                  'nama_akun' => $child3->nama_akun,
                  'child' => [],
                  'saldo' => 0
                ];
              }

              if (count($child3->child) > 0) {
                foreach ($child3->child as $child4) {
                  $jumlah = self::getSumTransaksi($child4, $akun1, $akun2, $akun3, $akun4);
                  $Child3[$numberChild3]['saldo'] += $jumlah;
                  $Child2[$numberChild2]['saldo'] += $jumlah;
                  $Child1[$numberChild1]['saldo'] += $jumlah;
                  $arusKas[$nomor]['saldo'] += $jumlah;
                }
              } else {
                if ($child3->debit || $child3->kredit) {
                  $jumlah = self::getSumTransaksi($child3, $akun1, $akun2, $akun3, $akun4);
                  $Child2[$numberChild2]['saldo'] += $jumlah;
                  $Child1[$numberChild1]['saldo'] += $jumlah;
                  $arusKas[$nomor]['saldo'] += $jumlah;
                }
              }

              $numberChild3++;
            }

            if (count($Child3) > 0) {
              $Child2[$numberChild2]['child'] = $Child3;
            }
            $numberChild2++;
          }

          if (count($Child2) > 0) {
            $Child1[$numberChild1]['child'] = $Child2;
          }

          if (str_contains($child1->nama_akun, 'A-B')) {
            $Child1[$numberChild1]['saldo'] = $Child1[$numberChild1 - 2]['saldo'] - $Child1[$numberChild1 - 1]['saldo'];
          }
          $numberChild1++;
        }

        if (count($Child1) > 0) {
          $arusKas[$nomor]['child'] = $Child1;
        }
      }

      $nomor++;
    }

    return $arusKas;
  }

  private static function getSumTransaksi($kode_akun, $akun1, $akun2, $akun3, $akun4)
  {
    $isKredit = true;
    $kodeAkun = $kode_akun->kredit;
    $kodeAkunPasangan = $kode_akun->debit;
    if (Keuangan::startWith($kode_akun->kredit, '1.1.01')) {
      $isKredit = false;
      $kodeAkun = $kode_akun->debit;
      $kodeAkunPasangan = $kode_akun->kredit;
    }

    $rekening = '';
    if (strlen($kodeAkun) == '9') {
      $rekening = $akun4[$kodeAkun] ??[];
    }

    if (strlen($kodeAkun) == '6') {
      $rekening = $akun3[$kodeAkun] ??[];
    }

    if (strlen($kodeAkun) == '3') {
      $rekening = $akun2[$kodeAkun] ??[];
    }

    if (strlen($kodeAkun) == '1') {
      $rekening = $akun1[$kodeAkun] ??[];
    }

    $jumlah = 0;
    foreach ($rekening as $rek) {
      $transaksi = $rek->trx_debit;
      $kode_rekening = $rek->kode_akun;
      $daftarKodeRekening = self::$rekDebit;
      if ($isKredit) {
        $transaksi = $rek->trx_kredit;
        $daftarKodeRekening = self::$rekKredit;
      }

      if (in_array($kode_rekening, $daftarKodeRekening)) {
        continue;
      }

      foreach ($transaksi as $trx) {
        $pasangan = $trx->rekening_kredit;
        if ($isKredit) {
          $pasangan = $trx->rekening_debit;
        }

        if (Keuangan::startWith($pasangan, $kodeAkunPasangan)) {
          $jumlah += floatval($trx->jumlah);
        }
      }

      $daftarKodeRekening[] = $kode_rekening;
      if ($isKredit) {
        self::$rekKredit = $daftarKodeRekening;
      } else {
        self::$rekDebit = $daftarKodeRekening;
      }
    }

    return $jumlah;
  }
}
