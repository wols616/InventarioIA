<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema de Inventario') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Navigation -->
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
                                    <a href="{{ route('auditorias.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Auditorías</a>
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
                                    <a href="{{ route('roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-800">Roles</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <a href="{{ route('activos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Activos</a>
                <a href="{{ route('inventario.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Inventario</a>
                <a href="{{ route('movimientos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Movimientos</a>
                <a href="{{ route('asignaciones.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Asignaciones</a>
                <a href="{{ route('mantenimientos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Mantenimientos</a>
                <a href="{{ route('auditorias.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Auditorías</a>
                <a href="{{ route('tipos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Tipos</a>
                <a href="{{ route('categorias.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Categorías</a>
                <a href="{{ route('estados.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Estados</a>
                <a href="{{ route('ubicaciones.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Ubicaciones</a>
                <a href="{{ route('compras.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Compras</a>
                <a href="{{ route('proveedores.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Proveedores</a>
                <a href="{{ route('personas.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Personas</a>
                <a href="{{ route('departamentos.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Departamentos</a>
                <a href="{{ route('roles.index') }}" class="text-white hover:bg-brand-800 block px-3 py-2 rounded-md text-base font-medium">Roles</a>
            </div>
        </div>
    </nav>

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

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
