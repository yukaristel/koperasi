<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class SimpananAnggota extends Model
{
    use HasFactory;
    protected $table;
    public $timestamps = false;

    protected $guarded = ['id'];

    public function __construct()
    {
        $this->table = 'simpanan_anggota_' . Session::get('lokasi');
    }

    // ambil data dari jenis simpanan
    public function js()
    {
        return $this->belongsTo(JenisSimpanan::class, 'jenis_simpanan', 'id');
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'nia', 'id');
    }

    // ambil data dari transaksi
    public function trx_tarik()
    {
        return $this->hasMany(Transaksi::class, 'id_simp', 'id');
    }
    
    // ambil data dari transaksi
    public function trx_setor()
    {
        return $this->hasMany(Transaksi::class, 'id_simp', 'id');
    }
    public function real_s()
    {
        return $this->hasMany(RealSimpanan::class, 'cif', 'id')->orderBy('tgl_transaksi', 'ASC')->orderBy('id', 'ASC');
    }

}

