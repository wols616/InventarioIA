<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoriaActivo;

class CategoriaActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Inserts a curated list of ~20 categorias_activos. Uses updateOrInsert
     * to avoid duplicates when re-running.
     */
    public function run()
    {
        $items = [
            ['nombre'=>'Equipo de computo','descripcion'=>'Equipos de cómputo, servidores y periféricos','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Mobiliario','descripcion'=>'Escritorios, sillas, estantes','vida'=>120,'depreciable'=>true],
            ['nombre'=>'Equipo de Laboratorio','descripcion'=>'Microscopios, reactores, equipos de medición','vida'=>84,'depreciable'=>true],
            ['nombre'=>'Vehículos','descripcion'=>'Transporte institucional','vida'=>96,'depreciable'=>true],
            ['nombre'=>'Licencias de Software','descripcion'=>'Suscripciones y perpetuas','vida'=>12,'depreciable'=>false],
            ['nombre'=>'Equipos de Red','descripcion'=>'Routers, switches, firewalls','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Herramientas','descripcion'=>'Herramientas manuales y eléctricas','vida'=>72,'depreciable'=>true],
            ['nombre'=>'Instrumental Médico','descripcion'=>'Equipos y material médico especializado','vida'=>84,'depreciable'=>true],
            ['nombre'=>'Sensores y Medidores','descripcion'=>'Sensores ambientales y equipos de medición','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Equipos Audiovisuales','descripcion'=>'Proyectores, cámaras y sistemas de audio','vida'=>48,'depreciable'=>true],
            ['nombre'=>'Mobiliario de Laboratorio','descripcion'=>'Mesas y bancadas de laboratorio','vida'=>120,'depreciable'=>true],
            ['nombre'=>'Material Didáctico','descripcion'=>'Materiales educativos y de enseñanza','vida'=>36,'depreciable'=>false],
            ['nombre'=>'Equipos de Impresión','descripcion'=>'Impresoras, fotocopiadoras','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Equipos de Almacenamiento','descripcion'=>'NAS, SAN y discos de almacenamiento','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Elementos de Seguridad','descripcion'=>'Cámaras CCTV, cerraduras electrónicas','vida'=>72,'depreciable'=>true],
            ['nombre'=>'Equipos de Energía','descripcion'=>'UPS, generadores y baterías','vida'=>84,'depreciable'=>true],
            ['nombre'=>'Software Empresarial','descripcion'=>'ERP, CRM y software de gestión','vida'=>36,'depreciable'=>false],
            ['nombre'=>'Material de Oficina','descripcion'=>'Papelería y suministros generales','vida'=>24,'depreciable'=>false],
            ['nombre'=>'Equipos de Medición de Campo','descripcion'=>'Instrumentos portátiles para campo','vida'=>60,'depreciable'=>true],
            ['nombre'=>'Otros Activos','descripcion'=>'Activos diversos no categorizados','vida'=>60,'depreciable'=>true],
        ];

        foreach ($items as $it) {
            DB::table('categorias_activos')->updateOrInsert(
                ['nombre' => $it['nombre']],
                [
                    'descripcion' => $it['descripcion'],
                    'vida_util_estimada_meses' => $it['vida'],
                    'depreciable' => $it['depreciable'],
                    'activo' => true,
                ]
            );
        }

        // Ensure at least 20 exist; if not, generate random ones
        $count = DB::table('categorias_activos')->count();
        if ($count < 20) {
            $toCreate = 20 - $count;
            CategoriaActivo::factory()->count($toCreate)->create();
        }
    }
}
