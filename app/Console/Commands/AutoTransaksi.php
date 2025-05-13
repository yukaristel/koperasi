<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\transaksi; 
use Carbon\Carbon;

class AutoTransaksi extends Command
{
    protected $signature = 'transaction:auto-insert';
    protected $description = 'input admin per bulan';

    public function handle()
    {
        $simpananList = Simpanan::where('status', 'A')
                                    ->with('anggota')
                                    ->get();

        foreach ($simpananList as $simpanan) {
            $cif = $simpanan->id;
            $nomorRekening = $simpanan->no_rekening;
            $namaDebitur = $simpanan->anggota->namadepan;
            $jenisSimpanan = JenisSimpanan::where('id', substr($nomorRekening, 0, 1))->first();

            
            $real = RealSimpanan::where('cif', $cif)->latest('tgl_transaksi')->first();
            $sumSebelumnya = $real ? $real->sum : 0;

            //admin register
            Transaksi::create([
                'tgl_transaksi' => Tanggal::tglNasional($request->tgl_buka_rekening),
                'rekening_debit' => $js->rek_kas,
                'rekening_kredit' =>  $js->rek_adm,
                'idtp' => '0',
                'id_pinj' => '0',
                'id_pinj_i' => '0',
                'id_simp' => '0',
                'keterangan_transaksi' => 'Pendapatan Admin Simpanan ' . $js->nama_js . ' ' . $anggota->namadepan . '',
                'relasi' => $anggota->namadepan . '[' . $request->nia . ']',
                'jumlah' => str_replace(',', '', str_replace('.00', '', $request->admin_register)),
                'urutan' => '0',
                'id_user' => auth()->user()->id,
            ]);

            //real setoran awalx
            RealSimpanan::create([
                'cif' => $maxId,
                'idt' => $maxIdt,
                'kode' => 1,
                'tgl_transaksi' => Tanggal::tglNasional($request->tgl_buka_rekening),
                'real_d' =>  '0',
                'real_k' => str_replace(',', '', str_replace('.00', '', $request->setoran_awal)),
                'sum' => str_replace(',', '', str_replace('.00', '', $request->setoran_awal)),
                'lu' => date('Y-m-d H:i:s'),
                'id_user' => auth()->user()->id,
            ]);
        }

        $this->info('Transaksi otomatis berhasil ditambahkan.');
    }
}
