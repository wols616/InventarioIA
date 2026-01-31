<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoActivo extends Model
{
    protected $table = 'tipos_activos';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'requiere_serie',
        'requiere_marca',
        'requiere_modelo',
        'requiere_especificaciones',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaActivo::class, 'id_categoria', 'id_categoria');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'id_tipo', 'id_tipo');
    }
}
