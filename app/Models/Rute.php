<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rute extends Model
{
    protected $table = 'tb_rute';
    protected $primaryKey = 'id_rute';
    public $timestamps = true;

    protected $fillable = [
        'stasiun_asal',
        'stasiun_tujuan',
        'durasi_menit',
        'jarak_km',
    ];

    protected $casts = [
        'jarak_km' => 'float',
    ];

    /**
     * Stasiun asal
     */
    public function stasiun_asal(): BelongsTo
    {
        return $this->belongsTo(Stasiun::class, 'stasiun_asal', 'id_stasiun');
    }

    /**
     * Stasiun tujuan
     */
    public function stasiun_tujuan(): BelongsTo
    {
        return $this->belongsTo(Stasiun::class, 'stasiun_tujuan', 'id_stasiun');
    }
}
