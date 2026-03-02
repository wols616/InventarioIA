<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoActivo;

class TipoActivoFactory extends Factory
{
    protected $model = TipoActivo::class;

    public function definition()
    {
        // Decide flags randomly but biased: many types require marca/modelo, fewer require serie/especificaciones
        return [
            'id_categoria' => 1, // overwritten by seeder when needed
            'nombre' => ucfirst($this->faker->unique()->words(2, true)),
            'descripcion' => $this->faker->sentence(6),
            'requiere_serie' => $this->faker->boolean(25),
            'requiere_marca' => $this->faker->boolean(70),
            'requiere_modelo' => $this->faker->boolean(60),
            'requiere_especificaciones' => $this->faker->boolean(20),
        ];
    }
}
