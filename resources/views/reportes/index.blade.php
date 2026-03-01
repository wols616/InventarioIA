@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-lg font-semibold mb-4">Generador de reportes - Asignaciones por persona</h2>

        <form action="{{ route('reportes.generar') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Buscar persona</label>
                <input id="person_search" type="text" placeholder="Escriba nombre o apellido" class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Persona</label>
                <select id="persona_select" name="persona_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Seleccione una persona --</option>
                    @foreach($personas as $p)
                        <option data-nombre="{{ strtolower($p->nombre . ' ' . $p->apellido) }}" value="{{ $p->id_persona }}">{{ $p->nombre }} {{ $p->apellido }} ({{ $p->correo ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded">Generar reporte</button>
                <a href="/" class="text-sm text-gray-600">Cancelar</a>
            </div>
        </form>
    
    <script>
        (function(){
            const input = document.getElementById('person_search');
            const select = document.getElementById('persona_select');

            if(!input || !select) return;

            input.addEventListener('input', function(){
                const q = this.value.trim().toLowerCase();
                for(const opt of select.options){
                    const name = (opt.dataset.nombre || '').toLowerCase();
                    if(opt.value === "") { opt.style.display = q ? 'none' : ''; continue; }
                    if(q === '' || name.includes(q)) opt.style.display = '';
                    else opt.style.display = 'none';
                }
                // if current selection hidden, clear it
                if(select.selectedOptions.length && select.selectedOptions[0].style.display === 'none') select.value = '';
            });
        })();
    </script>
    </div>
@endsection
