<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'jenis_kegiatan';
    public $timestamps = false;

    public function usaha()
    {
        return $this->hasMany(Usaha::class, 'jenis_kegiatan');
    }

}
