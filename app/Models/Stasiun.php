<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stasiun extends Model
{
    protected $table = 'tb_stasiun';
    protected $primaryKey = 'id_stasiun';
    public $timestamps = true;

    protected $fillable = [
        'nama_stasiun',
        'kota',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Rute dimana stasiun ini sebagai asal
     */
    public function ruteAsal(): HasMany
    {
        return $this->hasMany(Rute::class, 'stasiun_asal', 'id_stasiun');
    }

    /**
     * Rute dimana stasiun ini sebagai tujuan
     */
    public function ruteTujuan(): HasMany
    {
        return $this->hasMany(Rute::class, 'stasiun_tujuan', 'id_stasiun');
    }

    /**
     * Kereta yang melewati stasiun ini
     */
    public function keretaStasiun(): HasMany
    {
        return $this->hasMany(KeretaStasiun::class, 'id_stasiun', 'id_stasiun');
    }
}
