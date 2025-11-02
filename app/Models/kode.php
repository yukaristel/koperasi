<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class kode extends Model
{
    use HasFactory;
    protected $table = 'kode_simp';
    public $timestamps = false;
    
    /**
     * Boot method untuk apply global scope
     */
    protected static function booted()
    {
        static::addGlobalScope('lokasi', function ($query) {
            $lokasiSession = Session::get('lokasi');
            
            if ($lokasiSession) {
                $query->where(function($q) use ($lokasiSession) {
                    $q->where(function($subQ) use ($lokasiSession) {
                        $subQ->where('lokasi', 0)
                             ->orWhere('lokasi', $lokasiSession);
                    })
                    ->where(function($subQ) use ($lokasiSession) {
                        $subQ->whereNull('kecuali')
                             ->orWhereRaw("COALESCE(FIND_IN_SET(?, kecuali), 0) = 0", [$lokasiSession]);
                    });
                });
            }
        });
    }
}
