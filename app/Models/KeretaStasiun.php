<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeretaStasiun extends Model
{
    protected $table = 'tb_kereta_stasiun';
    public $timestamps = true;

    protected $fillable = [
        'id_kereta',
        'id_stasiun',
        'urutan',
    ];

    /**
     * Kereta yang direlasikan
     */
    public function kereta(): BelongsTo
    {
        return $this->belongsTo(Kereta::class, 'id_kereta', 'id_kereta');
    }

    /**
     * Stasiun yang direlasikan
     */
    public function stasiun(): BelongsTo
    {
        return $this->belongsTo(Stasiun::class, 'id_stasiun', 'id_stasiun');
    }
}
