<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $primaryKey = 'id_inventario';
    public $timestamps = false;

    protected $fillable = [
        'id_activo',
        'cantidad',
        'descripcion',
        'cantidad_minima',
        'cantidad_maxima',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
