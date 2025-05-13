<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class RealSimpanan extends Model
{
    use HasFactory;

    protected $table;
    public $timestamps = false;

    protected $guarded = [''];

    public function __construct()
    {
        $this->table = 'real_simpanan_' . Session::get('lokasi');
    }

    public function trx()
    {
        return $this->hasMany(Transaksi::class, 'id_simp', 'cif')
            ->whereRaw("id_simp LIKE CONCAT('%-', cif)");
    }

    public function transaksi()
{
    return $this->hasOne(Transaksi::class, 'idt', 'idt'); 
}
}
