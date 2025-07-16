<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
use Session;

class RekeningRekap extends Model
{
    use HasFactory, Compoships;
    protected $table;
    public $timestamps = false;

    protected $guarded = ['id'];

    public function __construct()
    {
        $this->table = 'rekening_' . Session::get('lokasi');
    }
    public function kom_saldo()
    {
        return $this->hasMany(Saldo::class, 'kode_akun', 'kode_akun');
    }
}
