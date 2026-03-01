<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Persona;

/**
 * Factory para `Persona` con restricciones en `id_rol` e `id_departamento`.
 * - `id_rol` solamente puede ser uno de los ids especificados en la lista permitida.
 * - `id_departamento` solamente puede ser uno de los ids permitidos (1..13 según lista).
 * - `dui` cumple el formato ########-#.
 *
 * Nota: Asegúrate de poblar previamente las tablas `roles` y `departamentos` con los ids indicados
 * si vas a ejecutar la factory en un entorno con restricciones FK.
 */
class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        // Lista permitida de roles (ids proporcionados)
        $allowedRoles = [4,1,2,7,8,9,10,11,12];

        // Lista permitida de departamentos (ids disponibles entre 1 y 13 según tu lista)
        $allowedDepartamentos = [1,2,3,6,7,8,9,10,11,12,13];

        return [
            'id_rol' => $this->faker->randomElement($allowedRoles),
            'id_departamento' => $this->faker->randomElement($allowedDepartamentos),
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'dui' => $this->faker->unique()->numerify('########-#'),
            'correo' => $this->faker->unique()->safeEmail(),
            'estado' => $this->faker->boolean(90),
        ];
    }
}
