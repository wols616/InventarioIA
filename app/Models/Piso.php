<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    protected $table = 'pisos';
    protected $primaryKey = 'id_piso';
    public $timestamps = false;

    protected $fillable = [
        'id_edificio',
        'numero_piso',
    ];

    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'id_edificio', 'id_edificio');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'id_piso', 'id_piso');
    }
}
