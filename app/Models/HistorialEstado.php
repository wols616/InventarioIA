<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $table = 'historial_estados';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'id_estado_anterior',
        'id_estado_nuevo',
        'fecha_cambio',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
