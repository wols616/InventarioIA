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
    <div id="chat-container" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <div id="chat-button" class="bg-brand-600 hover:bg-brand-700 text-white rounded-full shadow-lg cursor-pointer transition-all duration-200 w-14 h-14 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>

        <!-- Chat Window -->
        <div id="chat-window" class="hidden absolute bottom-16 right-0 w-80 h-[500px] bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col">
            <!-- Chat Header -->
            <div class="bg-brand-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Asistente Virtual</span>
                </div>
                <button id="close-chat" class="hover:bg-brand-700 rounded p-1 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3">
                <!-- Bot Message -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                        </svg>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                        <p class="text-sm text-gray-800">¡Hola! Soy tu asistente virtual del sistema de inventario. ¿En qué puedo ayudarte?</p>
                        <span class="text-xs text-gray-500 mt-1 block">10:30 AM</span>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex items-start space-x-2 justify-end">
                    <div class="bg-brand-600 text-white rounded-lg p-3 max-w-xs">
                        <p class="text-sm">¿Cómo puedo ver todos los activos disponibles?</p>
                        <span class="text-xs text-brand-100 mt-1 block">10:31 AM</span>
                    </div>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>

                <!-- Bot Response -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                        </svg>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                        <p class="text-sm text-gray-800">Puedes acceder a la lista completa de activos desde el menú "Inventario" → "Activos", o desde el botón de acceso rápido en la página principal.</p>
                        <span class="text-xs text-gray-500 mt-1 block">10:31 AM</span>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <form id="chat-form" class="border-t border-gray-200 p-4">
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        id="chat-input" 
                        placeholder="Escribe tu mensaje..." 
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                    >
                    <button 
                        type="submit" 
                        class="bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-4 py-2 transition duration-200 flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });

        // Chat functionality
        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const closeChat = document.getElementById('close-chat');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            // Toggle chat window
            chatButton.addEventListener('click', function() {
                chatWindow.classList.toggle('hidden');
                if (!chatWindow.classList.contains('hidden')) {
                    chatInput.focus();
                }
            });

            // Close chat window
            closeChat.addEventListener('click', function() {
                chatWindow.classList.add('hidden');
            });

            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                
                if (message === '') return;

                // Add user message
                addMessage(message, 'user');
                chatInput.value = '';

                // Simulate API call and response
                setTimeout(() => {
                    // TODO: Replace with actual API call
                    // Example API endpoint: '/api/chat'
                    // Example payload: { message: message, session_id: 'user_session' }
                    
                    // For now, simulate a response
                    const botResponse = 'Gracias por tu mensaje. Esta es una respuesta de prueba mientras se configura la API del chatbot.';
                    addMessage(botResponse, 'bot');
                }, 1000);
            });

            // Function to add messages to chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                const timestamp = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                if (sender === 'user') {
                    messageDiv.innerHTML = `
                        <div class="flex items-start space-x-2 justify-end">
                            <div class="bg-brand-600 text-white rounded-lg p-3 max-w-xs">
                                <p class="text-sm">${text}</p>
                                <span class="text-xs text-brand-100 mt-1 block">${timestamp}</span>
                            </div>
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                                <p class="text-sm text-gray-800">${text}</p>
                                <span class="text-xs text-gray-500 mt-1 block">${timestamp}</span>
                            </div>
                        </div>
                    `;
                }

                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
</body>
</html>
