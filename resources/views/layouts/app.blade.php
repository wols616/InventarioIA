<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inventario') }}</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:0}
        header{background:#1b1b18;color:#fff;padding:0.5rem 1rem}
        nav a{color:#fff;margin-right:1rem;text-decoration:none}
        .container{padding:1rem}
        .flash{color:green}
        table{border-collapse:collapse;width:100%}
        table th, table td{border:1px solid #ccc;padding:0.4rem;text-align:left}
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('activos.index') }}">Activos</a>
            <a href="{{ route('tipos.index') }}">Tipos</a>
            <a href="{{ route('categorias.index') }}">Categorías</a>
            <a href="{{ route('estados.index') }}">Estados</a>
            <a href="{{ route('ubicaciones.index') }}">Ubicaciones</a>
            <a href="{{ route('departamentos.index') }}">Departamentos</a>
            <a href="{{ route('proveedores.index') }}">Proveedores</a>
            <a href="{{ route('personas.index') }}">Personas</a>
            <a href="{{ route('roles.index') }}">Roles</a>
        </nav>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
