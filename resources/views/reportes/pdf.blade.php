<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte - {{ $persona->nombre }} {{ $persona->apellido }}</title>
    <style>
        body{ font-family: Arial, Helvetica, sans-serif; color:#111; }
        .header{ text-align:center; margin-bottom:20px }
        table{ width:100%; border-collapse:collapse }
        th, td{ border:1px solid #ddd; padding:8px; font-size:12px }
        th{ background:#f4f4f4 }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de asignaciones</h2>
        <div>{{ $persona->nombre }} {{ $persona->apellido }}</div>
        <div>Período: {{ $inicio }} — {{ $fin }}</div>
    </div>

    @if($asignaciones->isEmpty())
        <div>No se encontraron asignaciones en el período seleccionado.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Activo (código)</th>
                    <th>Descripción</th>
                    <th>Fecha asignación</th>
                    <th>Fecha fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $asig)
                    <tr>
                        <td>{{ $asig->activo->codigo ?? '—' }}</td>
                        <td>
                            {{ $asig->activo->marca ?? '' }} {{ $asig->activo->modelo ?? '' }}
                            <div style="font-size:11px;color:#555">S/N: {{ $asig->activo->numero_serie ?? '-' }} — Tipo: {{ $asig->activo->tipo->nombre ?? '-' }}</div>
                        </td>
                        <td>{{ optional($asig->fecha_asignacion)->format('Y-m-d') }}</td>
                        <td>{{ optional($asig->fecha_fin)->format('Y-m-d') ?? 'Activo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <script>
        // Auto disparar diálogo de impresión para que el usuario guarde como PDF
        window.addEventListener('load', function(){
            setTimeout(function(){ window.print(); }, 300);
        });
    </script>
</body>
</html>
