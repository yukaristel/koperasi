<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rekap extends Authenticatable
{
    use HasFactory;

    protected $table = 'rekap';

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kd_prov', 'kode');
    }
    
    public function kec()
    {
        $ids = array_filter(explode(',', $this->lokasi));

        return Kecamatan::whereIn('id', $ids)->get();
    }
}
