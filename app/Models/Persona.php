<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    protected $fillable = [
        'id_rol',
        'id_departamento',
        'nombre',
        'apellido',
        'dui',
        'correo',
        'estado',
    ];

    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }
}
