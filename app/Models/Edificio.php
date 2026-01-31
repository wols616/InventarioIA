<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $table = 'edificios';
    protected $primaryKey = 'id_edificio';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo',
    ];

    public function pisos()
    {
        return $this->hasMany(Piso::class, 'id_edificio', 'id_edificio');
    }
}
