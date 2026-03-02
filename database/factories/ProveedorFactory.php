<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proveedor;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company() . ' ' . $this->faker->optional(0.5)->companySuffix(),
            'contacto' => $this->faker->unique()->safeEmail(),
            'descripcion' => $this->faker->sentence(8),
        ];
    }
}
