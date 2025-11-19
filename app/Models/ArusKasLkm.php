<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ArusKasLkm extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('aktif', function (Builder $builder) {
            $builder->where('aktif', 'Y');
        });
    }

    public function getTable()
    {
        $lokasi = session('lokasi');
        $lokasiKop = [1, 351, 352, 353, 354];

        return in_array($lokasi, $lokasiKop)
            ? 'arus_kas_kop'
            : 'arus_kas_lkm';
    }

    public function child()
    {
        return $this->hasMany(ArusKasLkm::class, 'parent_id');
    }
}
