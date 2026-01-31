<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaInventario extends Model
{
    protected $table = 'auditorias_inventario';
    protected $primaryKey = 'id_auditoria';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'fecha_auditoria',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleAuditoria::class, 'id_auditoria', 'id_auditoria');
    }
}
