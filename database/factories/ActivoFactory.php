<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activo;

class ActivoFactory extends Factory
{
    protected $model = Activo::class;

    public function definition()
    {
        return [
            'id_tipo' => null, // preferir pasar por override en el seeder
            'id_estado' => null, // override en seeder
            'id_ubicacion_actual' => null, // override en seeder
            'codigo' => 'ACT-' . strtoupper($this->faker->unique()->bothify('####-???')),
            'codigo_barra' => $this->faker->optional(0.8)->ean13(),
            'marca' => $this->faker->randomElement([$this->faker->company(), $this->faker->companySuffix(), null]),
            'modelo' => $this->faker->bothify('Model-##??'),
            'numero_serie' => $this->faker->optional(0.8)->bothify('SN-####-??'),
            'fecha_adquisicion' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'valor_adquisicion' => $this->faker->randomFloat(2, 10, 5000),
        ];
    }
}
