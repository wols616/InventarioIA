<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoriaActivo;

class CategoriaActivoFactory extends Factory
{
    protected $model = CategoriaActivo::class;

    public function definition()
    {
        // generar vida útil entre 6 meses y 180 meses
        $vida = $this->faker->numberBetween(6, 180);
        // depreciable: true para vida > 12 meses por defecto
        $depreciable = $vida > 12 ? true : $this->faker->boolean(30);

        return [
            'nombre' => ucfirst($this->faker->unique()->words(2, true)),
            'descripcion' => $this->faker->sentence(6),
            'vida_util_estimada_meses' => $vida,
            'depreciable' => $depreciable,
            'activo' => true,
        ];
    }
}
