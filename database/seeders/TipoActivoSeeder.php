<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TipoActivo;
use App\Models\CategoriaActivo;

class TipoActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates at least 2 tipos_activos per existing categoria_activo.
     */
    public function run()
    {
        $categories = DB::table('categorias_activos')->pluck('id_categoria')->toArray();
        if (empty($categories)) {
            throw new \RuntimeException('No se encontraron categorias_activos. Ejecuta primero CategoriaActivoSeeder.');
        }

        $created = 0;
        foreach ($categories as $catId) {
            // For each category create 2 specific and 1 optional random
            $names = [
                "General {$catId}",
                "Avanzado {$catId}",
            ];

            foreach ($names as $n) {
                DB::table('tipos_activos')->updateOrInsert(
                    ['id_categoria' => $catId, 'nombre' => $n],
                    [
                        'descripcion' => "Tipo {$n} para categoria {$catId}",
                        'requiere_serie' => (bool)rand(0,1),
                        'requiere_marca' => (bool)rand(0,1),
                        'requiere_modelo' => (bool)rand(0,1),
                        'requiere_especificaciones' => (bool)rand(0,1),
                    ]
                );
                $created++;
            }

            // add one more random type for diversity
            TipoActivo::factory()->count(1)->create(['id_categoria' => $catId]);
            $created++;
        }

        // Ensure at least 40 exists: create extra random types if needed
        $total = DB::table('tipos_activos')->count();
        if ($total < 40) {
            $toCreate = 40 - $total;
            TipoActivo::factory()->count($toCreate)->create([/* id_categoria will be random if factory overridden */]);
        }
    }
}
