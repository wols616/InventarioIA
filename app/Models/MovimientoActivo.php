<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoActivo extends Model
{
    protected $table = 'movimientos_activos';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'id_ubicacion_origen',
        'id_ubicacion_destino',
        'fecha_movimiento',
        'motivo',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
