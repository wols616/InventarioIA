<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Este seeder NO inserta roles ni departamentos; en su lugar valida que los
     * ids permitidos ya existan en las tablas `roles` y `departamentos`.
     * Si falta algún id requerido, el seeder lanzará una excepción y no continuará
     * para evitar errores de FK al crear personas.
     */
    public function run()
    {
        // IDs permitidos (según tu especificación)
        $allowedRoles = [4,1,2,7,8,9,10,11,12];
        $allowedDepartamentos = [1,2,3,6,7,8,9,10,11,12,13];

        // Verificar roles existentes
        $existingRoles = DB::table('roles')->whereIn('id_rol', $allowedRoles)->pluck('id_rol')->toArray();
        $missingRoles = array_diff($allowedRoles, $existingRoles);
        if (!empty($missingRoles)) {
            throw new \RuntimeException('Faltan roles en la tabla `roles`. IDs faltantes: ' . implode(',', $missingRoles) . '. Por favor inserta esos roles antes de ejecutar este seeder.');
        }

        // Verificar departamentos existentes
        $existingDeps = DB::table('departamentos')->whereIn('id_departamento', $allowedDepartamentos)->pluck('id_departamento')->toArray();
        $missingDeps = array_diff($allowedDepartamentos, $existingDeps);
        if (!empty($missingDeps)) {
            throw new \RuntimeException('Faltan departamentos en la tabla `departamentos`. IDs faltantes: ' . implode(',', $missingDeps) . '. Por favor inserta esos departamentos antes de ejecutar este seeder.');
        }

        // Generar 1,000 personas en lotes para controlar uso de memoria
        $total = 1000;
        $batch = 100;
        for ($i = 0; $i < $total; $i += $batch) {
            $count = min($batch, $total - $i);
            Persona::factory()->count($count)->create();
        }
    }
}
