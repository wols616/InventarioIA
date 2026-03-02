<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Activo;
use App\Models\Persona;

class AsignacionActivoSeeder extends Seeder
{
    public function run()
    {
        $target = 3000;
        $created = 0;
        $batch = [];
        $batchSize = 500;

        $activos = Activo::pluck('id_activo')->toArray();
        $personas = Persona::pluck('id_persona')->toArray();

        if (empty($activos) || empty($personas)) {
            $this->command->warn('No hay activos o personas para crear asignaciones. Asegúrese de ejecutar los seeders previos.');
            return;
        }

        // Shuffle activos to distribute assignments
        shuffle($activos);

        // Start generating assignments per activo sequentially to avoid overlaps
        $minStart = Carbon::create(2015, 1, 1);
        $now = Carbon::now();

        $i = 0;
        while ($created < $target) {
            // Cycle through activos
            $activoId = $activos[$i % count($activos)];
            $i++;

            // Decide how many assignments this activo will have in this pass (1-4)
            $num = rand(1, 4);

            // Build a timeline for this activo starting at a random past date
            $currentStart = (clone $minStart)->addDays(rand(0, 365 * 3));

            for ($j = 0; $j < $num && $created < $target; $j++) {
                // pick a persona
                $idPersona = $personas[array_rand($personas)];

                // decide duration and whether this assignment ended
                $durationDays = rand(7, 900);
                $ended = (bool) rand(0, 1); // 50% chance ended

                $fechaAsignacion = $currentStart->copy()->addDays(rand(0, 120));
                $fechaFin = $ended ? $fechaAsignacion->copy()->addDays($durationDays) : null;

                // If fechaFin is in the future, mark as ended=false (active)
                if ($fechaFin && $fechaFin->greaterThan($now)) {
                    $fechaFin = null;
                    $estado = true;
                } else {
                    $estado = $fechaFin ? false : true;
                }

                $batch[] = [
                    'id_activo' => $activoId,
                    'id_persona' => $idPersona,
                    'fecha_asignacion' => $fechaAsignacion->toDateString(),
                    'fecha_fin' => $fechaFin ? $fechaFin->toDateString() : null,
                    'es_responsable_principal' => (rand(1,100) <= 10) ? true : false,
                    'estado' => $estado,
                ];

                $created++;

                // advance timeline: next assignment starts after this one ends (or after a small gap)
                if ($fechaFin) {
                    $gap = rand(1, 120);
                    $currentStart = $fechaFin->copy()->addDays($gap);
                } else {
                    // active assignment; next assignments for this activo should be later (simulate future) so break
                    break;
                }

                // insert batch if large
                if (count($batch) >= $batchSize) {
                    DB::table('asignaciones_activos')->insert($batch);
                    $batch = [];
                }
            }
        }

        if (!empty($batch)) {
            DB::table('asignaciones_activos')->insert($batch);
            $batch = [];
        }

        $this->command->info("Asignaciones creadas: {$created}");
    }
}
