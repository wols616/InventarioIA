<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_departamento', 'id_departamento');
    }
}
