<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionFisica extends Model
{
    protected $table = 'ubicaciones_fisicas';
    protected $primaryKey = 'id_ubicacion';
    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'nombre',
        'codigo_interno',
        'descripcion_detallada',
        'estado',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'id_ubicacion_actual', 'id_ubicacion');
    }
}
