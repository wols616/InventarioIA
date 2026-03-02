<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AsignacionActivoFactory extends Factory
{
    public function definition()
    {
        $start = Carbon::now()->subYears(rand(0,10))->subDays(rand(0,365));
        $hasEnd = $this->faker->boolean(60); // 60% ended
        $end = $hasEnd ? $start->copy()->addDays(rand(30, 900)) : null;

        return [
            'id_activo' => null, // override in seeder
            'id_persona' => null, // override in seeder
            'fecha_asignacion' => $start->toDateString(),
            'fecha_fin' => $end ? $end->toDateString() : null,
            'es_responsable_principal' => $this->faker->boolean(15),
            'estado' => $hasEnd ? false : true,
        ];
    }
}
