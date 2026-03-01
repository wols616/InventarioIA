<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Activo;
use App\Models\Inventario;

class ActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates assets and inventory entries. Some tipos are marked as "inventariable"
     * (one Activo + an Inventario entry with cantidad >1). Others are created
     * as individual Activo records (one row per unit).
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $tipos = DB::table('tipos_activos')->pluck('id_tipo')->toArray();
        $estados = DB::table('estados_activos')->pluck('id_estado')->toArray();
        $ubicaciones = DB::table('ubicaciones_fisicas')->pluck('id_ubicacion')->toArray();

        if (empty($tipos) || empty($estados) || empty($ubicaciones)) {
            throw new \RuntimeException('Asegúrate de tener datos en tipos_activos, estados_activos y ubicaciones_fisicas antes de ejecutar ActivoSeeder.');
        }

        $totalAssets = 1000; // configurable: total logical assets to generate
        $inventoriableRatio = 0.20; // % of assets that should be stored in inventory (aggregated)

        $inventoriableCount = (int) round($totalAssets * $inventoriableRatio);
        $uniqueCount = $totalAssets - $inventoriableCount;

        // pick a subset of tipos to be considered inventoriable (20% of tipos)
        $tiposShuffled = $tipos;
        shuffle($tiposShuffled);
        $inventoriableTipos = array_slice($tiposShuffled, 0, max(1, (int) round(count($tipos) * 0.2)));

        // helper to generate sequential codigo
        $startId = DB::table('activos')->max('id_activo') ?? 0;
        $nextSeq = $startId + 1;

        // First, create inventoriable groups: one Activo + Inventario record
        for ($i = 0; $i < $inventoriableCount; $i++) {
            $tipo = $faker->randomElement($inventoriableTipos);
            $estado = $faker->randomElement($estados);
            $ubicacion = $faker->randomElement($ubicaciones);

            $activo = Activo::factory()->create([
                'id_tipo' => $tipo,
                'id_estado' => $estado,
                'id_ubicacion_actual' => $ubicacion,
                'codigo' => 'ACT-' . str_pad($nextSeq++, 6, '0', STR_PAD_LEFT),
            ]);

            // create inventory entry for this activo
            $cantidad = $faker->numberBetween(5, 200);
            Inventario::create([
                'id_activo' => $activo->id_activo,
                'cantidad' => $cantidad,
                'descripcion' => $faker->sentence(6),
                'cantidad_minima' => max(1, (int) round($cantidad * 0.05)),
                'cantidad_maxima' => (int) round($cantidad * 1.5),
            ]);
        }

        // Then, create unique assets (one row per unit)
        for ($i = 0; $i < $uniqueCount; $i++) {
            $tipo = $faker->randomElement($tipos);
            $estado = $faker->randomElement($estados);
            $ubicacion = $faker->randomElement($ubicaciones);

            Activo::factory()->create([
                'id_tipo' => $tipo,
                'id_estado' => $estado,
                'id_ubicacion_actual' => $ubicacion,
                'codigo' => 'ACT-' . str_pad($nextSeq++, 6, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
