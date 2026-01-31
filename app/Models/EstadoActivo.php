<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoActivo extends Model
{
    protected $table = 'estados_activos';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'anotacion',
        'es_operativo',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'id_estado', 'id_estado');
    }
}
