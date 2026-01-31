<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle_compra';
    public $timestamps = false;

    protected $fillable = [
        'id_compra',
        'id_activo',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compra');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
