<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates 100 proveedores using the factory.
     */
    public function run()
    {
        $total = 100;
        $batch = 25;
        for ($i = 0; $i < $total; $i += $batch) {
            $count = min($batch, $total - $i);
            Proveedor::factory()->count($count)->create();
        }
    }
}
