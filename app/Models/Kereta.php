<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kereta extends Model
{
    protected $table = 'tb_kereta';
    protected $primaryKey = 'id_kereta';
    public $timestamps = true;

    protected $fillable = [
        'nama_kereta',
    ];

    public function getRouteKeyName(): string
    {
        return 'id_kereta';
    }

    /**
     * Stasiun-stasiun yang dilewati kereta ini
     */
    public function keretaStasiun(): HasMany
    {
        return $this->hasMany(KeretaStasiun::class, 'id_kereta', 'id_kereta');
    }

    public function keretaStasiunOrdered(): HasMany
    {
        return $this->hasMany(KeretaStasiun::class, 'id_kereta', 'id_kereta')->orderBy('urutan');
    }

    /**
     * Mendapatkan daftar stasiun secara berurutan
     */
    public function stasiun()
    {
        return $this->hasManyThrough(
            Stasiun::class,
            KeretaStasiun::class,
            'id_kereta',
            'id_stasiun',
            'id_kereta',
            'id_stasiun'
        );
    }
}
