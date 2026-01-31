<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    protected $table = 'activos';
    protected $primaryKey = 'id_activo';
    public $timestamps = false;

    protected $fillable = [
        'id_tipo',
        'id_estado',
        'id_ubicacion_actual',
        'codigo',
        'codigo_barra',
        'marca',
        'modelo',
        'numero_serie',
        'fecha_adquisicion',
        'valor_adquisicion',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'valor_adquisicion' => 'decimal:2',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoActivo::class, 'id_tipo', 'id_tipo');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoActivo::class, 'id_estado', 'id_estado');
    }

    public function ubicacion()
    {
        return $this->belongsTo(UbicacionFisica::class, 'id_ubicacion_actual', 'id_ubicacion');
    }
}
