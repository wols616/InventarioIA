<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionActivo extends Model
{
    protected $table = 'asignaciones_activos';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'id_persona',
        'fecha_asignacion',
        'fecha_fin',
        'es_responsable_principal',
        'estado',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }
}
