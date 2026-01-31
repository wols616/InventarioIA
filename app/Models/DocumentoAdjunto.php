<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoAdjunto extends Model
{
    protected $table = 'documentos_adjuntos';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'tipo_documento',
        'ruta_archivo',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
