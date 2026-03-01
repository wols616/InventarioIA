<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaActivo extends Model
{
    use HasFactory;

    protected $table = 'categorias_activos';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'vida_util_estimada_meses',
        'depreciable',
        'activo',
    ];

    public function tipos()
    {
        return $this->hasMany(TipoActivo::class, 'id_categoria', 'id_categoria');
    }
}
