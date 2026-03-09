<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema de Inventario') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Navigation (visible solo si hay sesión) -->
    @if(isset($authUser))
    <nav class="bg-gradient-to-r from-brand-800 to-brand-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo / Home -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 text-white hover:text-brand-200 transition duration-200">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-lg">Inventario</span>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Inventario Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                Inventario
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('activos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Activos</a>
                                    <a href="{{ route('inventario.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Inventario</a>
                                    <a href="{{ route('movimientos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Movimientos</a>
                                    <a href="{{ route('asignaciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Asignaciones</a>
                                    <a href="{{ route('mantenimientos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Mantenimientos</a>
                                    @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Auditor']))
                                        <a href="{{ route('auditorias.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Auditorías</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Clasificación Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                Clasificación
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('tipos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Tipos</a>
                                    <a href="{{ route('categorias.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Categorías</a>
                                    <a href="{{ route('estados.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Estados</a>
                                </div>
                            </div>
                        </div>

                        <!-- Ubicaciones Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                Ubicaciones
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('ubicaciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Ubicaciones</a>
                                    <a href="{{ route('areas.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Áreas</a>
                                    <a href="{{ route('pisos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Pisos</a>
                                    <a href="{{ route('edificios.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Edificios</a>
                                </div>
                            </div>
                        </div>

                        <!-- Compras Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                Compras
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('compras.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Compras</a>
                                    <a href="{{ route('proveedores.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Proveedores</a>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Dropdown -->
                        <div class="relative group">
                            <button class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                Personal
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('personas.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Personas</a>
                                    <a href="{{ route('departamentos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Departamentos</a>
                                    @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                                        <a href="{{ route('roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Roles</a>
                                        <a href="{{ route('usuarios.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Usuarios</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Reportes -->
                        <div>
                            <a href="{{ route('reportes.index') }}" class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Reportes</a>
                        </div>
                    </div>
                </div>

                <!-- Auth area -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Botón de Chat con IA -->
                    <a href="{{ route('chat.index') }}" class="text-white hover:text-brand-200 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span>Chat IA</span>
                    </a>
                    
                    @if(isset($authUser))
                        <span class="text-white text-sm">{{ $authUser->username }} ({{ $authUser->persona->rol->nombre ?? '' }})</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-white text-brand-800 px-3 py-1 rounded">Cerrar sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white px-3 py-2 rounded-md text-sm font-medium">Iniciar sesión</a>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="mobile-menu-button text-white hover:text-brand-200 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden bg-brand-900">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('chat.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <span>Chat IA</span>
                </a>
                <a href="{{ route('activos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Activos</a>
                <a href="{{ route('inventario.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Inventario</a>
                <a href="{{ route('movimientos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Movimientos</a>
                <a href="{{ route('asignaciones.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Asignaciones</a>
                <a href="{{ route('mantenimientos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Mantenimientos</a>
                <a href="{{ route('reportes.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Reportes</a>
                @if(isset($authUser) && in_array(($authUser->persona->rol->nombre ?? ''), ['Admin','Auditor']))
                    <a href="{{ route('auditorias.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Auditorías</a>
                @endif
                <a href="{{ route('tipos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Tipos</a>
                <a href="{{ route('categorias.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Categorías</a>
                <a href="{{ route('estados.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Estados</a>
                <a href="{{ route('ubicaciones.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Ubicaciones</a>
                @if(isset($authUser) && ($authUser->persona->rol->nombre ?? '') === 'Admin')
                    <a href="{{ route('compras.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Compras</a>
                    <a href="{{ route('proveedores.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Proveedores</a>
                    <a href="{{ route('roles.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Roles</a>
                    <a href="{{ route('usuarios.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Usuarios</a>
                @else
                    <a href="{{ route('personas.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Personas</a>
                    <a href="{{ route('departamentos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Departamentos</a>
                @endif
            </div>
        </div>
        </nav>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Chat Widget -->
    <style>
        #widget-chat-messages::-webkit-scrollbar { width: 4px; }
        #widget-chat-messages::-webkit-scrollbar-track { background: #f1f1f1; }
        #widget-chat-messages::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 3px; }
        @keyframes widget-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .widget-typing span { animation: widget-bounce 1.4s infinite; }
        .widget-typing span:nth-child(2) { animation-delay: 0.2s; }
        .widget-typing span:nth-child(3) { animation-delay: 0.4s; }
        
        /* Quick Actions Panel */
        #widget-quick-panel {
            flex-shrink: 0;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8fafc;
            border-top: 1.5px solid #e2e8f0;
        }
        #widget-quick-panel.open { max-height: 210px; }
        .wqp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 10px 3px;
        }
        .wqp-breadcrumb {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 9.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .wqp-breadcrumb svg { width: 10px; height: 10px; stroke: #94a3b8; }
        .wqp-nav { display: flex; align-items: center; gap: 2px; }
        .wqp-nav button {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; padding: 3px; border-radius: 4px;
            display: flex; align-items: center; transition: all 0.15s;
        }
        .wqp-nav button:hover { color: #475569; background: #e2e8f0; }
        .wqp-nav button svg { width: 13px; height: 13px; }
        .wqp-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 5px;
            padding: 2px 8px 8px;
            overflow-y: auto;
            max-height: 162px;
        }
        .wqp-grid::-webkit-scrollbar { width: 3px; }
        .wqp-grid::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .wqp-chip {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 9px;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.15s ease;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            user-select: none;
        }
        .wqp-chip:hover { transform: translateY(-1px); box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .wqp-chip:active { transform: none; box-shadow: none; }
        .wqp-chip.violet { border-color: #ddd6fe; background: #faf5ff; }
        .wqp-chip.violet:hover { background: #ede9fe; border-color: #c4b5fd; }
        .wqp-chip.violet .wqp-ci { background: #7c3aed; }
        .wqp-chip.blue { border-color: #bfdbfe; background: #eff6ff; }
        .wqp-chip.blue:hover { background: #dbeafe; border-color: #93c5fd; }
        .wqp-chip.blue .wqp-ci { background: #2563eb; }
        .wqp-chip.cyan { border-color: #a5f3fc; background: #ecfeff; }
        .wqp-chip.cyan:hover { background: #cffafe; border-color: #67e8f9; }
        .wqp-chip.cyan .wqp-ci { background: #0891b2; }
        .wqp-chip.teal { border-color: #99f6e4; background: #f0fdfa; }
        .wqp-chip.teal:hover { background: #ccfbf1; border-color: #5eead4; }
        .wqp-chip.teal .wqp-ci { background: #0d9488; }
        .wqp-chip.amber { border-color: #fde68a; background: #fffbeb; }
        .wqp-chip.amber:hover { background: #fef3c7; border-color: #fcd34d; }
        .wqp-chip.amber .wqp-ci { background: #d97706; }
        .wqp-chip.green { border-color: #bbf7d0; background: #f0fdf4; }
        .wqp-chip.green:hover { background: #dcfce7; border-color: #86efac; }
        .wqp-chip.green .wqp-ci { background: #16a34a; }
        .wqp-chip.gray { border-color: #e2e8f0; background: #f8fafc; }
        .wqp-chip.gray:hover { background: #f1f5f9; border-color: #cbd5e1; }
        .wqp-chip.gray .wqp-ci { background: #475569; }
        .wqp-chip.back {
            grid-column: span 2; justify-content: center;
            border-style: dashed; background: transparent; box-shadow: none;
        }
        .wqp-chip.back:hover { background: #f1f5f9; border-style: solid; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .wqp-chip.back .wqp-ci { background: #94a3b8; }
        .wqp-ci {
            width: 24px; height: 24px; border-radius: 6px;
            flex-shrink: 0; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.18);
        }
        .wqp-ci svg { width: 12px; height: 12px; stroke: #fff; fill: none; }
        .wqp-label {
            font-size: 11px; font-weight: 600;
            color: #1e293b; line-height: 1.25; letter-spacing: -0.01em;
        }
        .wqp-chip.back .wqp-label { color: #64748b; font-weight: 500; font-size: 10.5px; }
        /* Toggle button active state */
        #widget-quick-toggle.active { background: #eff6ff; color: #2563eb; }
        #widget-quick-toggle.active svg { stroke: #2563eb; }
    </style>

    <div id="widget-container" class="fixed bottom-6 right-6 z-50">
        <!-- Badge de notificación -->
        <div id="widget-badge" class="hidden absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold z-10">1</div>

        <!-- Botón flotante -->
        <div id="widget-btn" class="bg-brand-600 hover:bg-brand-700 text-white rounded-full shadow-lg cursor-pointer transition-all duration-200 w-14 h-14 flex items-center justify-center">
            <svg id="widget-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <svg id="widget-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>

        <!-- Ventana del chat -->
        <div id="widget-window" class="hidden absolute bottom-16 right-0 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden" style="height:480px">

            <!-- Header -->
            <div class="bg-gradient-to-r from-brand-600 to-brand-700 px-4 py-3 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm leading-none">Asistente IA</p>
                        <div id="widget-status" class="flex items-center space-x-1 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                            <span class="text-brand-100 text-xs">En línea</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <button id="widget-new-chat" title="Nuevo chat" class="text-white/70 hover:text-white hover:bg-white/20 rounded p-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                    <a href="{{ route('chat.index') }}" title="Abrir chat completo" class="text-white/70 hover:text-white hover:bg-white/20 rounded p-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                    <button id="widget-close" class="text-white/70 hover:text-white hover:bg-white/20 rounded p-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mensajes -->
            <div id="widget-chat-messages" class="flex-1 overflow-y-auto px-3 py-3 space-y-3">
            </div>

            <!-- Panel de acciones rápidas (colapsable) -->
            <div id="widget-quick-panel">
                <div class="wqp-header">
                    <div class="wqp-breadcrumb">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span id="wqp-title">Acciones rápidas</span>
                    </div>
                    <div class="wqp-nav">
                        <button id="wqp-back" class="hidden" title="Volver">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        </button>
                        <button id="wqp-close" title="Cerrar">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <div id="wqp-grid" class="wqp-grid"></div>
            </div>

            <!-- Input -->
            <div class="border-t border-gray-100 px-3 py-2.5 bg-white flex-shrink-0">
                <form id="widget-form" class="flex items-center space-x-2">
                    <button type="button" id="widget-quick-toggle" title="Acciones rápidas"
                        class="flex-shrink-0 w-8 h-8 rounded-lg border border-gray-200 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 text-gray-400 hover:text-blue-500 flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </button>
                    <input
                        type="text"
                        id="widget-input"
                        placeholder="Escribe tu mensaje..."
                        autocomplete="off"
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                    >
                    <button type="submit" id="widget-send" class="flex-shrink-0 bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-3 py-2 transition flex items-center justify-center disabled:opacity-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileBtn = document.querySelector('.mobile-menu-button');
        if (mobileBtn) {
            mobileBtn.addEventListener('click', function() {
                document.querySelector('.mobile-menu').classList.toggle('hidden');
            });
        }

        // =====================================================================
        // CHAT WIDGET FUNCIONAL
        // =====================================================================
        document.addEventListener('DOMContentLoaded', function() {
            const widgetBtn      = document.getElementById('widget-btn');
            const widgetWindow   = document.getElementById('widget-window');
            const widgetClose    = document.getElementById('widget-close');
            const widgetNewChat  = document.getElementById('widget-new-chat');
            const widgetForm     = document.getElementById('widget-form');
            const widgetInput    = document.getElementById('widget-input');
            const widgetSend     = document.getElementById('widget-send');
            const widgetMessages = document.getElementById('widget-chat-messages');
            const widgetBadge    = document.getElementById('widget-badge');
            const iconOpen       = document.getElementById('widget-icon-open');
            const iconClose      = document.getElementById('widget-icon-close');

            const widgetQuickPanel  = document.getElementById('widget-quick-panel');
            const widgetQuickToggle = document.getElementById('widget-quick-toggle');
            const wqpGrid           = document.getElementById('wqp-grid');
            const wqpTitle          = document.getElementById('wqp-title');
            const wqpBack           = document.getElementById('wqp-back');
            const wqpClose          = document.getElementById('wqp-close');

            let widgetOpened    = false;
            let isFirstOpen     = true;
            let widgetContexto  = 'inicio';
            let panelHistorial  = [];

            // -----------------------------------------------------------------
            // Categorías de consulta (acciones rápidas)
            // -----------------------------------------------------------------
            const widgetCategorias = {
                inicio: {
                    mensaje: "¡Hola! 👋 Soy el asistente de inventario.\n¿Qué te gustaría consultar?",
                    opciones: [
                        { emoji: "📅", texto: "Agendar reunión", desc: "Programa una cita", accion: "agendar_reunion", color: "violet" },
                        { emoji: "🔍", texto: "Buscar activo", desc: "Por código o serie", accion: "buscar_activo", color: "blue" },
                        { emoji: "👤", texto: "Asignaciones", desc: "Activos asignados", accion: "ver_asignaciones", color: "cyan" },
                        { emoji: "📍", texto: "Ubicaciones", desc: "Por edificio o área", accion: "consultar_ubicacion", color: "teal" },
                        { emoji: "🔧", texto: "Mantenimientos", desc: "Pendientes e historial", accion: "ver_mantenimientos", color: "amber" },
                        { emoji: "📊", texto: "Disponibilidad", desc: "Stock disponible", accion: "ver_disponibilidad", color: "green" },
                        { emoji: "💬", texto: "Pregunta libre", desc: "Escribe tu consulta", accion: "pregunta_libre", color: "gray" }
                    ]
                },
                agendar_reunion: {
                    mensaje: "Para agendar una reunión, escribe los detalles:\n• Asunto\n• Fecha y hora\n• Participantes",
                    opciones: [
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                buscar_activo: {
                    mensaje: "¿Qué información tienes del activo?",
                    opciones: [
                        { emoji: "📟", texto: "Código", desc: "Ej: ACT-001", accion: "input", placeholder: "Escribe el código..." },
                        { emoji: "🏷️", texto: "Marca/Modelo", desc: "Ej: Dell, HP", accion: "input", placeholder: "Escribe marca o modelo..." },
                        { emoji: "🔢", texto: "Núm. serie", desc: "Código fabricante", accion: "input", placeholder: "Escribe el número de serie..." },
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                ver_asignaciones: {
                    mensaje: "¿De quién quieres ver las asignaciones?",
                    opciones: [
                        { emoji: "👤", texto: "Por persona", desc: "Buscar por nombre", accion: "input", placeholder: "Nombre de la persona..." },
                        { emoji: "📋", texto: "Todas", desc: "Listado completo", query: "Muéstrame todas las asignaciones activas" },
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                consultar_ubicacion: {
                    mensaje: "¿Qué ubicación te interesa?",
                    opciones: [
                        { emoji: "🏢", texto: "Edificio A", desc: "Ver activos", query: "¿Qué activos hay en el Edificio A?" },
                        { emoji: "🏢", texto: "Edificio B", desc: "Ver activos", query: "¿Qué activos hay en el Edificio B?" },
                        { emoji: "📍", texto: "Otra ubicación", desc: "Piso o área", accion: "input", placeholder: "Escribe el piso o área..." },
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                ver_mantenimientos: {
                    mensaje: "¿Qué información necesitas?",
                    opciones: [
                        { emoji: "⚠️", texto: "Pendientes", desc: "Requieren atención", query: "¿Qué activos necesitan mantenimiento?" },
                        { emoji: "🔧", texto: "Realizados", desc: "Historial reciente", query: "Muéstrame los últimos mantenimientos" },
                        { emoji: "🔍", texto: "Por activo", desc: "Buscar específico", accion: "input", placeholder: "Código del activo..." },
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                ver_disponibilidad: {
                    mensaje: "¿Qué tipo de activos necesitas ver?",
                    opciones: [
                        { emoji: "✅", texto: "Disponibles", desc: "Listos para asignar", query: "¿Qué activos están disponibles?" },
                        { emoji: "🔴", texto: "Ocupados", desc: "Ya asignados", query: "Muéstrame los activos ocupados" },
                        { emoji: "📊", texto: "Resumen", desc: "Vista general", query: "Dame un resumen de disponibilidad" },
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Menú principal", accion: "inicio", esVolver: true }
                    ]
                },
                pregunta_libre: {
                    mensaje: "Escribe tu pregunta libremente. Puedo ayudarte con:\n• Activos y ubicaciones\n• Asignaciones y personas\n• Mantenimientos",
                    opciones: [
                        { emoji: "⬅️", texto: "Volver al inicio", desc: "Ver opciones", accion: "inicio", esVolver: true }
                    ]
                }
            };

            // -----------------------------------------------------------------
            // Abrir / cerrar
            // -----------------------------------------------------------------
            function openWidget() {
                widgetWindow.classList.remove('hidden');
                widgetWindow.classList.add('flex');
                widgetBtn.classList.add('bg-brand-700');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
                widgetBadge.classList.add('hidden');
                widgetOpened = true;

                if (isFirstOpen) {
                    isFirstOpen = false;
                    widgetAddMessage('¡Hola! 👋 Soy el asistente de inventario.\n¿En qué puedo ayudarte?', false);
                    widgetRenderPanel('inicio');
                    widgetQuickPanel.classList.add('open');
                    widgetQuickToggle.classList.add('active');
                }

                setTimeout(() => widgetInput.focus(), 100);
            }

            function closeWidget() {
                widgetWindow.classList.add('hidden');
                widgetWindow.classList.remove('flex');
                widgetBtn.classList.remove('bg-brand-700');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }

            widgetBtn.addEventListener('click', () => widgetOpened && !widgetWindow.classList.contains('hidden') ? closeWidget() : openWidget());
            widgetClose.addEventListener('click', closeWidget);

            widgetNewChat.addEventListener('click', function() {
                widgetMessages.innerHTML = '';
                isFirstOpen = false;
                panelHistorial = [];
                widgetRenderPanel('inicio');
                widgetQuickPanel.classList.add('open');
                widgetQuickToggle.classList.add('active');
                widgetAddMessage('¡Chat reiniciado! 🔄 ¿Qué deseas consultar?', false);
            });

            // Toggle panel
            widgetQuickToggle.addEventListener('click', function() {
                const isOpen = widgetQuickPanel.classList.contains('open');
                if (isOpen) {
                    widgetQuickPanel.classList.remove('open');
                    widgetQuickToggle.classList.remove('active');
                } else {
                    widgetRenderPanel(widgetContexto);
                    widgetQuickPanel.classList.add('open');
                    widgetQuickToggle.classList.add('active');
                }
            });

            // Panel back / close
            wqpBack.addEventListener('click', function() {
                if (panelHistorial.length > 0) {
                    const prev = panelHistorial.pop();
                    widgetRenderPanel(prev, false);
                }
            });
            wqpClose.addEventListener('click', function() {
                widgetQuickPanel.classList.remove('open');
                widgetQuickToggle.classList.remove('active');
            });

            // -----------------------------------------------------------------
            // Panel de acciones rápidas
            // -----------------------------------------------------------------
            const wqpIcons = {
                agendar_reunion:     `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`,
                buscar_activo:       `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>`,
                ver_asignaciones:    `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`,
                consultar_ubicacion: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
                ver_mantenimientos:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`,
                ver_disponibilidad:  `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>`,
                pregunta_libre:      `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`,
                input:               `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
                query:               `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`,
                inicio:              `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>`,
            };

            const wqpTitles = {
                inicio: 'Acciones rápidas',
                agendar_reunion: 'Agendar reunión',
                buscar_activo: 'Buscar activo',
                ver_asignaciones: 'Asignaciones',
                consultar_ubicacion: 'Ubicaciones',
                ver_mantenimientos: 'Mantenimientos',
                ver_disponibilidad: 'Disponibilidad',
                pregunta_libre: 'Pregunta libre',
            };

            function widgetRenderPanel(contextoId, pushHistory = true) {
                const contexto = widgetCategorias[contextoId];
                if (!contexto) return;

                if (pushHistory && widgetContexto !== contextoId && widgetContexto) {
                    panelHistorial.push(widgetContexto);
                }
                widgetContexto = contextoId;

                // Header
                wqpTitle.textContent = wqpTitles[contextoId] || 'Acciones rápidas';
                if (panelHistorial.length > 0) {
                    wqpBack.classList.remove('hidden');
                } else {
                    wqpBack.classList.add('hidden');
                }

                // Grid
                wqpGrid.innerHTML = '';
                contexto.opciones.forEach((op, idx) => {
                    const colorClass = op.esVolver ? 'gray back' : (op.color || 'gray');
                    let iconSvg;
                    if (op.esVolver) iconSvg = wqpIcons.inicio;
                    else if (op.accion === 'input') iconSvg = wqpIcons.input;
                    else if (op.query) iconSvg = wqpIcons.query;
                    else iconSvg = wqpIcons[op.accion] || wqpIcons.pregunta_libre;

                    const chip = document.createElement('div');
                    chip.className = `wqp-chip ${colorClass}`;
                    chip.title = op.desc;
                    chip.innerHTML = `<div class="wqp-ci">${iconSvg}</div><span class="wqp-label">${op.texto}</span>`;
                    chip.addEventListener('click', () => widgetHandleQuickAction(contextoId, idx));
                    wqpGrid.appendChild(chip);
                });
            }

            // Alias por compatibilidad
            function widgetMostrarContexto(contextoId) { widgetRenderPanel(contextoId); }

            function widgetHandleQuickAction(contextoId, idx) {
                const contexto = widgetCategorias[contextoId];
                if (!contexto || !contexto.opciones[idx]) return;
                const opcion = contexto.opciones[idx];

                if (opcion.query) {
                    widgetSendMessage(opcion.query);
                    widgetQuickPanel.classList.remove('open');
                    widgetQuickToggle.classList.remove('active');
                    return;
                }
                if (opcion.accion === 'input') {
                    widgetInput.placeholder = opcion.placeholder || 'Escribe tu mensaje...';
                    widgetQuickPanel.classList.remove('open');
                    widgetQuickToggle.classList.remove('active');
                    widgetInput.focus();
                    return;
                }
                if (opcion.esVolver && panelHistorial.length > 0) {
                    const prev = panelHistorial.pop();
                    widgetRenderPanel(prev, false);
                    return;
                }
                if (opcion.accion && widgetCategorias[opcion.accion]) {
                    widgetRenderPanel(opcion.accion);
                    return;
                }
            }

            // -----------------------------------------------------------------
            // Añadir mensaje
            // -----------------------------------------------------------------
            function widgetEscapeHtml(text) {
                const d = document.createElement('div');
                d.textContent = text;
                return d.innerHTML;
            }

            function widgetFormatResponse(text) {
                text = widgetEscapeHtml(text);
                text = text.replace(/\b(ACT-\d+)\b/g, '<span class="px-1 py-0.5 bg-blue-100 text-blue-800 rounded text-xs font-mono">$1</span>');
                text = text.replace(/\b(DISPONIBLE|OPERATIVO)\b/gi, '<span class="px-1 py-0.5 bg-green-100 text-green-800 rounded text-xs font-semibold">$1</span>');
                text = text.replace(/\b(OCUPADO|NO DISPONIBLE|EN MANTENIMIENTO)\b/gi, '<span class="px-1 py-0.5 bg-red-100 text-red-800 rounded text-xs font-semibold">$1</span>');
                text = text.replace(/\n/g, '<br>');
                return text;
            }

            function widgetAddMessage(message, isUser) {
                const div = document.createElement('div');
                div.className = 'flex items-end space-x-2' + (isUser ? ' justify-end' : '');

                const timestamp = new Date().toLocaleTimeString('es-ES', {hour:'2-digit', minute:'2-digit'});
                const formatted = isUser ? widgetEscapeHtml(message) : widgetFormatResponse(message);

                if (isUser) {
                    div.innerHTML = `
                        <div class="max-w-[220px]">
                            <div class="bg-brand-600 text-white rounded-lg rounded-br-none px-3 py-2 text-sm">${formatted}</div>
                            <p class="text-xs text-gray-400 text-right mt-0.5">${timestamp}</p>
                        </div>
                        <div class="w-6 h-6 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0 mb-4">
                            <svg class="w-3.5 h-3.5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>`;
                } else {
                    div.innerHTML = `
                        <div class="w-6 h-6 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0 mb-4">
                            <svg class="w-3.5 h-3.5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>
                        </div>
                        <div class="max-w-[220px]">
                            <div class="bg-gray-100 text-gray-800 rounded-lg rounded-bl-none px-3 py-2 text-sm leading-relaxed">${formatted}</div>
                            <p class="text-xs text-gray-400 mt-0.5">${timestamp}</p>
                        </div>`;
                }

                widgetMessages.appendChild(div);
                widgetMessages.scrollTop = widgetMessages.scrollHeight;

                // Badge si está cerrado
                if (!isUser && widgetWindow.classList.contains('hidden')) {
                    widgetBadge.classList.remove('hidden');
                }
            }

            // -----------------------------------------------------------------
            // Typing indicator
            // -----------------------------------------------------------------
            function widgetShowTyping() {
                const d = document.createElement('div');
                d.id = 'widget-typing';
                d.className = 'flex items-end space-x-2';
                d.innerHTML = `
                    <div class="w-6 h-6 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0 mb-4">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path></svg>
                    </div>
                    <div class="bg-gray-100 rounded-lg rounded-bl-none px-3 py-2">
                        <div class="widget-typing flex space-x-1">
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                        </div>
                    </div>`;
                widgetMessages.appendChild(d);
                widgetMessages.scrollTop = widgetMessages.scrollHeight;
            }

            function widgetRemoveTyping() {
                const t = document.getElementById('widget-typing');
                if (t) t.remove();
            }

            // -----------------------------------------------------------------
            // Enviar mensaje
            // -----------------------------------------------------------------
            function widgetGetSessionId() {
                let s = localStorage.getItem('chat_session_id');
                if (!s) {
                    s = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                    localStorage.setItem('chat_session_id', s);
                }
                return s;
            }

            async function widgetSendMessage(message) {
                if (!message.trim()) return;

                widgetAddMessage(message, true);
                widgetInput.value = '';
                widgetSend.disabled = true;
                widgetInput.disabled = true;
                widgetShowTyping();

                const botMode    = localStorage.getItem('bot_mode') || 'local';
                const webhookUrl = localStorage.getItem('webhook_url') || '';

                try {
                    let response;

                    if (botMode === 'local') {
                        response = await fetch('{{ route("chat.testBot") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ message: message })
                        });
                    } else {
                        if (!webhookUrl) {
                            widgetRemoveTyping();
                            widgetAddMessage('No hay webhook configurado. Abre el chat completo para configurarlo.', false);
                            return;
                        }
                        response = await fetch(webhookUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ mensaje: message, sessionId: widgetGetSessionId() })
                        });
                    }

                    widgetRemoveTyping();

                    if (response.ok) {
                        const data = await response.json();
                        const reply = botMode === 'local'
                            ? (data.data?.response || data.response || JSON.stringify(data))
                            : (data.reply || data.response || data.message || data.output || JSON.stringify(data));
                        widgetAddMessage(reply, false);
                    } else {
                        widgetAddMessage('Error ' + response.status + '. Intenta de nuevo.', false);
                    }
                } catch (err) {
                    widgetRemoveTyping();
                    widgetAddMessage('No se pudo conectar al asistente. Verifica tu conexión.', false);
                    console.error('Widget chat error:', err);
                } finally {
                    widgetSend.disabled = false;
                    widgetInput.disabled = false;
                    widgetInput.placeholder = 'Escribe tu mensaje...';
                    widgetInput.focus();
                }
            }

            widgetForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msg = widgetInput.value.trim();
                if (msg) widgetSendMessage(msg);
            });
        });
    </script>
</body>
</html>
