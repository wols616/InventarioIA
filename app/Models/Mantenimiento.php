<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';
    protected $primaryKey = 'id_mantenimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'tipo_mantenimiento',
        'fecha_inicio',
        'fecha_fin',
        'costo',
        'anotacion',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
