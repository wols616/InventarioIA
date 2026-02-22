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

            <!-- Input -->
            <div class="border-t border-gray-100 px-3 py-3 bg-white flex-shrink-0">
                <form id="widget-form" class="flex space-x-2">
                    <input
                        type="text"
                        id="widget-input"
                        placeholder="Escribe tu mensaje..."
                        autocomplete="off"
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                    >
                    <button type="submit" id="widget-send" class="bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-3 py-2 transition flex items-center justify-center disabled:opacity-50">
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

            let widgetOpened  = false;
            let isFirstOpen   = true;

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
                    widgetAddMessage('¡Hola! 👋 Soy el asistente de inventario.\n¿En qué puedo ayudarte hoy?', false);
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
                widgetAddMessage('¡Chat reiniciado! 🔄 ¿Qué deseas consultar?', false);
            });

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
