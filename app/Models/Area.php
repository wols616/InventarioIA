<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        'id_piso',
        'nombre',
        'tipo_area',
        'estado',
    ];

    public function piso()
    {
        return $this->belongsTo(Piso::class, 'id_piso', 'id_piso');
    }

    public function ubicaciones()
    {
        return $this->hasMany(UbicacionFisica::class, 'id_area', 'id_area');
    }
}
