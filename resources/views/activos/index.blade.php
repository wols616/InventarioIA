<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activos</title>
</head>
<body>
    <h1>Activos</h1>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <p><a href="{{ route('activos.create') }}">Crear activo</a></p>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Fecha Adquisición</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($activos as $activo)
            <tr>
                <td>{{ $activo->id_activo }}</td>
                <td>{{ $activo->codigo }}</td>
                <td>{{ $activo->marca }}</td>
                <td>{{ $activo->modelo }}</td>
                <td>{{ optional($activo->fecha_adquisicion)->format('Y-m-d') }}</td>
                <td>{{ $activo->valor_adquisicion }}</td>
                <td>
                    <a href="{{ route('activos.show', $activo) }}">Ver</a>
                    <a href="{{ route('activos.edit', $activo) }}">Editar</a>
                    <form action="{{ route('activos.destroy', $activo) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $activos->links() }}</div>
</body>
</html>
