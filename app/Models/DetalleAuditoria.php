<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleAuditoria extends Model
{
    protected $table = 'detalle_auditoria';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_auditoria',
        'id_activo',
        'coincide_con_sistema',
        'anotaciones',
    ];

    public function auditoria()
    {
        return $this->belongsTo(AuditoriaInventario::class, 'id_auditoria', 'id_auditoria');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
