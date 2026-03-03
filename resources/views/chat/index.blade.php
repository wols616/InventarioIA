@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- ============================================================ -->
        <!-- HEADER DEL CHAT -->
        <!-- ============================================================ -->
        <div class="relative bg-gradient-to-br from-brand-600 via-brand-700 to-brand-800 px-6 py-5">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 400 120" preserveAspectRatio="none">
                    <circle cx="50" cy="20" r="60" fill="white" opacity="0.1"/>
                    <circle cx="350" cy="80" r="80" fill="white" opacity="0.08"/>
                    <circle cx="200" cy="-20" r="40" fill="white" opacity="0.06"/>
                </svg>
            </div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">Asistente IA</h1>
                        <p class="text-brand-200 text-sm font-medium">Gestión inteligente de inventario</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div id="connection-status" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm">
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        <span class="text-white/80 text-xs font-medium">Desconectado</span>
                    </div>
                    <button 
                        id="new-chat-btn"
                        class="p-2.5 bg-white/15 hover:bg-white/25 text-white rounded-xl transition-all duration-200 backdrop-blur-sm group"
                        title="Iniciar nuevo chat"
                    >
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                    <button 
                        id="toggle-settings-btn"
                        class="p-2.5 bg-white/15 hover:bg-white/25 text-white rounded-xl transition-all duration-200 backdrop-blur-sm group"
                        title="Configuración"
                    >
                        <svg class="w-5 h-5 group-hover:rotate-45 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- PANEL DE CONFIGURACIÓN (Colapsable) -->
        <!-- ============================================================ -->
        <div id="settings-panel" class="hidden border-b border-gray-100 bg-gradient-to-b from-gray-50 to-white transition-all duration-300">
            <div class="px-6 py-5 space-y-4">
                <!-- Modo -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 min-w-[80px]">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.14 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-600">Modo</span>
                    </div>
                    <select id="bot-mode" class="px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all shadow-sm">
                        <option value="local">Bot Local (Prueba)</option>
                        <option value="n8n">n8n Webhook</option>
                    </select>
                    <span class="text-xs text-gray-400 italic hidden sm:inline">Usa "Bot Local" para probar sin n8n</span>
                </div>
                
                <!-- Chat URL (solo visible en modo n8n) -->
                <div id="webhook-config" class="hidden space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 min-w-[80px]">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-600">Chat</span>
                        </div>
                        <div class="flex-1 flex gap-2">
                            <input 
                                type="url" 
                                id="webhook-url" 
                                placeholder="http://localhost:5678/webhook-test/asistente"
                                class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all shadow-sm font-mono text-xs"
                                value=""
                            >
                            <button 
                                id="test-connection" 
                                class="px-4 py-2 bg-emerald-500 text-white text-xs font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap"
                            >
                                Probar
                            </button>
                        </div>
                    </div>
                    <p class="ml-[92px] text-xs text-gray-400">Formato: {"mensaje", "texto", "sessionId", "id"}</p>
                </div>
                
                <!-- OCR URL -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 min-w-[80px]">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-600">OCR</span>
                    </div>
                    <div class="flex-1 flex gap-2">
                        <input 
                            type="url" 
                            id="ocr-webhook-url" 
                            placeholder="http://localhost:5678/webhook-test/analizar"
                            class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all shadow-sm font-mono text-xs"
                            value=""
                        >
                        <button 
                            id="test-ocr-connection" 
                            class="px-4 py-2 bg-brand-500 text-white text-xs font-semibold rounded-xl hover:bg-brand-600 transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap"
                        >
                            Probar
                        </button>
                    </div>
                </div>
                
                <button 
                    id="btn-error-ocr"
                    class="ml-[92px] inline-flex items-center gap-1.5 text-xs text-amber-600 hover:text-amber-700 font-medium transition-colors"
                    onclick="mostrarModalDiagnosticoVacio()"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Diagnosticar problemas OCR
                </button>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- CHAT CONTAINER -->
        <!-- ============================================================ -->
        <div class="h-[560px] flex flex-col">
            <!-- Mensajes -->
            <div id="chat-messages" class="flex-1 overflow-y-auto px-6 py-5 space-y-5 bg-gradient-to-b from-gray-50/50 to-white">
                <!-- Los mensajes se agregarán dinámicamente -->
            </div>

            <!-- ============================================================ -->
            <!-- INPUT AREA -->
            <!-- ============================================================ -->
            <div class="border-t border-gray-100 px-5 py-4 bg-white">
                <!-- Vista previa de imagen -->
                <div id="image-preview-container" class="hidden mb-3">
                    <div class="inline-flex items-center gap-3 bg-brand-50 border border-brand-200 rounded-xl px-4 py-2.5 animate-fade-in">
                        <img id="image-preview" src="" alt="Vista previa" class="h-14 w-14 object-cover rounded-lg ring-2 ring-brand-300 shadow-sm">
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-brand-700">Imagen lista para OCR</span>
                            <span id="image-file-name" class="text-xs text-brand-500 truncate max-w-[200px]"></span>
                        </div>
                        <button 
                            type="button" 
                            id="remove-image-btn"
                            class="ml-2 w-7 h-7 bg-red-100 text-red-500 rounded-lg hover:bg-red-200 hover:text-red-600 transition-all flex items-center justify-center"
                            title="Eliminar imagen"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <form id="chat-form" class="flex items-end gap-3">
                    <!-- Input file oculto -->
                    <input type="file" id="image-input" accept="image/*" class="hidden">
                    
                    <!-- Botón para adjuntar imagen -->
                    <button 
                        type="button" 
                        id="attach-image-btn"
                        class="flex-shrink-0 w-11 h-11 bg-gray-50 text-gray-400 rounded-xl hover:bg-brand-50 hover:text-brand-500 transition-all duration-200 flex items-center justify-center border border-gray-200 hover:border-brand-300 group"
                        title="Adjuntar imagen para análisis OCR"
                    >
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    
                    <!-- Input de texto -->
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            id="message-input" 
                            placeholder="Escribe tu mensaje aquí..."
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent focus:bg-white transition-all duration-200 text-sm placeholder-gray-400"
                            autocomplete="off"
                        >
                    </div>
                    
                    <!-- Botón enviar -->
                    <button 
                        type="submit" 
                        id="send-button"
                        class="flex-shrink-0 w-11 h-11 bg-brand-600 text-white rounded-xl hover:bg-brand-700 active:scale-95 transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none disabled:active:scale-100"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SUGERENCIAS CONTEXTUALES -->
    <!-- ============================================================ -->
    <div id="suggestions-container" class="mt-5 bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Header del panel de sugerencias -->
        <div id="suggestions-header" class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center gap-2">
                <div id="suggestions-icon" class="w-7 h-7 bg-brand-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-gray-700" id="suggestions-title">¿Qué te gustaría consultar?</h3>
            </div>
            <span id="suggestions-breadcrumb" class="text-xs text-gray-400 hidden"></span>
        </div>
        <!-- Grid de opciones -->
        <div id="suggestions-wrapper" class="p-4">
            <!-- Las sugerencias se generarán dinámicamente según el contexto -->
        </div>
    </div>

    <!-- Modal de Diagnóstico OCR -->
    <div id="modal-diagnostico-ocr" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-100">
            <div class="sticky top-0 bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Error 500: Internal Server Error
                    </h3>
                    <button onclick="cerrarModalDiagnostico()" class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ n8n está respondiendo pero algo falla en el procesamiento.</strong><br>
                        Esto significa que el servidor está activo, pero hay un error en el workflow.
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">🔍 Información Técnica:</h4>
                        <div class="bg-gray-100 rounded p-3 font-mono text-xs">
                            <div><strong>URL:</strong> <span id="diag-url"></span></div>
                            <div><strong>Método:</strong> POST</div>
                            <div><strong>Content-Type:</strong> multipart/form-data</div>
                            <div><strong>Campo imagen:</strong> "Imagen"</div>
                            <div><strong>Archivo:</strong> <span id="diag-file"></span></div>
                            <div class="mt-2"><strong>Respuesta servidor:</strong></div>
                            <div class="bg-white p-2 mt-1 rounded border max-h-32 overflow-y-auto">
                                <pre id="diag-response" class="text-red-600"></pre>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 mb-2">✅ Checklist de Solución:</h4>
                        <div class="space-y-2">
                            <div class="flex items-start gap-2">
                                <span class="text-lg">1️⃣</span>
                                <div>
                                    <strong>Verifica el workflow en n8n:</strong>
                                    <ul class="text-sm text-gray-600 ml-4 mt-1">
                                        <li>• Ve a <code class="bg-gray-200 px-2 py-0.5 rounded">http://localhost:5678</code></li>
                                        <li>• Abre el workflow "Imagenes"</li>
                                        <li>• Revisa las últimas ejecuciones (botón "Executions")</li>
                                        <li>• <strong class="text-red-600">Busca qué nodo está fallando</strong></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <span class="text-lg">2️⃣</span>
                                <div>
                                    <strong>Verifica la configuración del Webhook:</strong>
                                    <ul class="text-sm text-gray-600 ml-4 mt-1">
                                        <li>• Haz clic en el nodo "Webhook" en n8n</li>
                                        <li>• <strong>HTTP Method:</strong> debe ser POST</li>
                                        <li>• <strong>Response Mode:</strong> "When Last Node Finishes"</li>
                                        <li>• No debe tener authentication (o configurarla correctamente)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <span class="text-lg">3️⃣</span>
                                <div>
                                    <strong>Verifica el nodo que procesa la imagen:</strong>
                                    <ul class="text-sm text-gray-600 ml-4 mt-1">
                                        <li>• ¿Tiene acceso al campo "Imagen"?</li>
                                        <li>• ¿Las credenciales de API están configuradas? (si usa OCR externo)</li>
                                        <li>• Ejecuta el workflow manualmente con una imagen de prueba</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <span class="text-lg">4️⃣</span>
                                <div>
                                    <strong>Reinicia el workflow:</strong>
                                    <ul class="text-sm text-gray-600 ml-4 mt-1">
                                        <li>• Desactiva el workflow (toggle OFF)</li>
                                        <li>• Espera 2 segundos</li>
                                        <li>• Actívalo de nuevo (toggle ON)</li>
                                        <li>• Intenta de nuevo desde el chatbot</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-bold text-blue-900 mb-2">💡 Prueba Manual:</h4>
                        <p class="text-sm text-blue-800 mb-2">
                            Ejecuta este comando en tu terminal para probar directamente:
                        </p>
                        <div class="bg-gray-900 text-green-400 p-3 rounded font-mono text-xs overflow-x-auto">
                            <code id="diag-curl"></code>
                        </div>
                        <p class="text-xs text-blue-600 mt-2">
                            Si este comando también da error 500, el problema está en n8n, no en el chatbot.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button onclick="window.open('http://localhost:5678', '_blank')" 
                            class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition font-medium">
                        🔗 Abrir n8n
                    </button>
                    <button onclick="cerrarModalDiagnostico()" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Agendamiento -->
    <div id="modal-agendar" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <span class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center">📅</span>
                    Agendar Reunión
                </h3>
                <button onclick="cerrarModalAgendar()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="form-agendar" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Fecha</label>
                    <input type="date" id="input-fecha" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Hora</label>
                    <input type="time" id="input-hora" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Motivo / Título</label>
                    <input type="text" id="input-motivo" placeholder="Ej: Reunión de seguimiento" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Invitados (opcional)</label>
                    <textarea id="input-invitados" rows="2" placeholder="correo1@ejemplo.com, correo2@ejemplo.com"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all text-sm resize-none"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Separa correos con comas. Deja vacío para evento privado.</p>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition-all font-semibold text-sm shadow-md hover:shadow-lg">
                        Agendar
                    </button>
                    <button type="button" onclick="cerrarModalAgendar()" class="px-5 py-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all text-sm font-medium">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Scrollbar personalizada */
    #chat-messages::-webkit-scrollbar { width: 5px; }
    #chat-messages::-webkit-scrollbar-track { background: transparent; }
    #chat-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    #chat-messages::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Animación de typing */
    @keyframes typingBounce {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-6px); opacity: 1; }
    }
    .typing-indicator span {
        animation: typingBounce 1.4s infinite;
        display: inline-block;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.15s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.3s; }

    /* Animación de entrada para mensajes */
    @keyframes messageSlideIn {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message-animate {
        animation: messageSlideIn 0.3s ease-out forwards;
    }

    /* Animación fade in */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in {
        animation: fadeIn 0.25s ease-out forwards;
    }

    /* Burbuja de chat del bot */
    .chat-bubble-bot {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px 16px 16px 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    
    /* Burbuja de chat del usuario */
    .chat-bubble-user {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-radius: 16px 4px 16px 16px;
        box-shadow: 0 2px 8px rgba(37,99,235,0.25);
    }

    /* Hover en sugerencias */
    .suggestion-btn {
        transition: all 0.2s ease;
    }
    .suggestion-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37,99,235,0.12);
    }

    /* Efecto de pulso suave para status */
    @keyframes softPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .status-pulse {
        animation: softPulse 2s ease-in-out infinite;
    }

    /* Efecto shimmer para el panel de settings */
    .settings-panel-enter {
        animation: fadeIn 0.2s ease-out forwards;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const webhookUrlInput = document.getElementById('webhook-url');
    const ocrWebhookUrlInput = document.getElementById('ocr-webhook-url');
    const testConnectionBtn = document.getElementById('test-connection');
    const testOcrConnectionBtn = document.getElementById('test-ocr-connection');
    const connectionStatus = document.getElementById('connection-status');
    const botModeSelect = document.getElementById('bot-mode');
    const webhookConfig = document.getElementById('webhook-config');
    
    // Variables para manejo de imágenes
    const imageInput = document.getElementById('image-input');
    const attachImageBtn = document.getElementById('attach-image-btn');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const removeImageBtn = document.getElementById('remove-image-btn');
    let selectedImage = null;

    const savedWebhookUrl = localStorage.getItem('webhook_url') || 'http://localhost:5678/webhook-test/asistente';
    const savedOcrWebhookUrl = localStorage.getItem('ocr_webhook_url') || 'http://localhost:5678/webhook-test/analizar';
    const savedBotMode = localStorage.getItem('bot_mode') || 'local';
    
    webhookUrlInput.value = savedWebhookUrl;
    ocrWebhookUrlInput.value = savedOcrWebhookUrl;
    botModeSelect.value = savedBotMode;

    // Toggle del panel de configuración
    const toggleSettingsBtn = document.getElementById('toggle-settings-btn');
    const settingsPanel = document.getElementById('settings-panel');
    
    toggleSettingsBtn.addEventListener('click', function() {
        settingsPanel.classList.toggle('hidden');
        if (!settingsPanel.classList.contains('hidden')) {
            settingsPanel.classList.add('settings-panel-enter');
        }
    });

    // =========================================================================
    // SISTEMA DE MENÚ CONTEXTUAL PROACTIVO
    // =========================================================================
    
    let contextoActual = 'inicio';
    let esperandoRespuesta = false;
    
    const consultasCategorias = {
        inicio: {
            mensaje: "¡Hola! 👋 Soy el **Gestor de Inventario de TechLogistics**.\n\n¿Qué te gustaría consultar hoy?",
            opciones: [
                { emoji: "📅", texto: "Agendar reunión",        desc: "Programa una cita rápidamente",          accion: "agendar_reunion",   color: "violet" },
                { emoji: "🔍", texto: "Buscar activo",           desc: "Por código, marca o número de serie",   accion: "buscar_activo",     color: "blue" },
                { emoji: "👤", texto: "Asignaciones",           desc: "Ver activos asignados a personas",      accion: "ver_asignaciones",  color: "cyan" },
                { emoji: "📍", texto: "Ubicaciones",            desc: "Consulta por edificio, piso o área",   accion: "consultar_ubicacion", color: "teal" },
                { emoji: "🔧", texto: "Mantenimientos",         desc: "Pendientes, historial y seguimiento",  accion: "ver_mantenimientos", color: "amber" },
                { emoji: "📊", texto: "Disponibilidad",         desc: "Stock libre, ocupado o no disponible", accion: "ver_disponibilidad", color: "green" },
                { emoji: "💬", texto: "Pregunta libre",          desc: "Escribe cualquier consulta",           accion: "pregunta_libre",    color: "gray" }
            ]
        },
        
        agendar_reunion: {
            mensaje: "Voy a ayudarte a agendar una reunión. Por favor completa los datos:",
            opciones: [
                { emoji: "📝", texto: "Llenar formulario",       desc: "Abrir el formulario de agendamiento",  accion: "form_agendar" },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        buscar_activo: {
            mensaje: "Perfecto, puedo ayudarte a buscar un activo. ¿Qué información tienes?",
            opciones: [
                { emoji: "📟", texto: "Código del activo",       desc: "Ej: ACT-001, ACT-023",                 accion: "input", placeholder: "Escribe el código del activo (ej: ACT-001)..." },
                { emoji: "🏷️", texto: "Marca o modelo",          desc: "Ej: Dell, MacBook, HP",                accion: "input", placeholder: "Escribe la marca o modelo..." },
                { emoji: "🔢", texto: "Número de serie",         desc: "Código único del fabricante",          accion: "input", placeholder: "Escribe el número de serie..." },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        ver_asignaciones: {
            mensaje: "¿De quién quieres ver las asignaciones de activos?",
            opciones: [
                { emoji: "👤", texto: "Por nombre de persona",   desc: "Buscar activos de un empleado",        accion: "input", placeholder: "Escribe el nombre de la persona..." },
                { emoji: "🏢", texto: "Por departamento",        desc: "Ver activos de un área completa",      accion: "departamentos" },
                { emoji: "📋", texto: "Todas las asignaciones",  desc: "Listado completo de activos activos",  query: "Muéstrame todas las asignaciones activas de activos" },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        consultar_ubicacion: {
            mensaje: "¿Qué ubicación te interesa consultar?",
            opciones: [
                { emoji: "🏢", texto: "Edificio A",              desc: "Ver todos los activos del Edificio A", query: "¿Qué activos hay en el Edificio A?" },
                { emoji: "🏢", texto: "Edificio B",              desc: "Ver todos los activos del Edificio B", query: "¿Qué activos hay en el Edificio B?" },
                { emoji: "📍", texto: "Piso o área específica",  desc: "Ej: Piso 2, Laboratorio 101",          accion: "input", placeholder: "Escribe el piso o área (ej: Piso 2, Laboratorio 101)..." },
                { emoji: "🗺️", texto: "Sin ubicación",           desc: "Activos sin lugar asignado",           query: "Muéstrame los activos sin ubicación asignada" },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        ver_mantenimientos: {
            mensaje: "¿Qué información de mantenimiento necesitas?",
            opciones: [
                { emoji: "⚠️", texto: "Pendientes",              desc: "Activos que necesitan atención pronto", query: "¿Qué activos necesitan mantenimiento próximamente?" },
                { emoji: "🔧", texto: "Últimos realizados",       desc: "Historial reciente de intervenciones",  query: "Muéstrame los últimos mantenimientos realizados" },
                { emoji: "🔍", texto: "Buscar por activo",        desc: "Historial de un equipo específico",    accion: "input", placeholder: "Escribe el código del activo..." },
                { emoji: "📅", texto: "Historial completo",       desc: "Resumen general de mantenimientos",    query: "Dame un resumen del historial de mantenimientos" },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        ver_disponibilidad: {
            mensaje: "¿Qué tipo de activos necesitas ver?",
            opciones: [
                { emoji: "✅", texto: "Disponibles",             desc: "Activos libres listos para asignar",   query: "¿Qué activos están disponibles en stock?" },
                { emoji: "🔴", texto: "Ocupados",               desc: "Activos asignados a personas o áreas", query: "Muéstrame los activos ocupados" },
                { emoji: "⛔", texto: "No disponibles",          desc: "En reparación, baja o similar",        query: "¿Qué activos están marcados como no disponibles?" },
                { emoji: "📊", texto: "Resumen general",         desc: "Vista completa del inventario",        query: "Dame un resumen de la disponibilidad de todos los activos" },
                { emoji: "⬅️", texto: "Volver al inicio",        desc: "Regresar al menú principal",           accion: "inicio",  esVolver: true }
            ]
        },
        
        departamentos: {
            mensaje: "Selecciona el departamento que quieres consultar:",
            opciones: [
                { emoji: "💻", texto: "Tecnología",              desc: "Equipos del área de TI",               query: "Muéstrame los activos asignados al departamento de Tecnología" },
                { emoji: "📊", texto: "Administración",          desc: "Equipos del área administrativa",      query: "Muéstrame los activos asignados al departamento de Administración" },
                { emoji: "🔬", texto: "Laboratorio",             desc: "Equipos del área de laboratorio",      query: "Muéstrame los activos asignados al departamento de Laboratorio" },
                { emoji: "👥", texto: "Recursos Humanos",        desc: "Equipos del área de RRHH",             query: "Muéstrame los activos asignados a Recursos Humanos" },
                { emoji: "⬅️", texto: "Volver",                  desc: "Regresar a asignaciones",              accion: "ver_asignaciones", esVolver: true }
            ]
        },
        
        pregunta_libre: {
            mensaje: "¡Perfecto! Escribe tu pregunta libremente y haré mi mejor esfuerzo por ayudarte. 😊\n\nPuedes preguntarme sobre activos, ubicaciones, personas, mantenimientos, etc.",
            opciones: [
                { emoji: "💡", texto: "Ver ejemplos",             desc: "Inspirate con preguntas de ejemplo",    accion: "ejemplos_preguntas" },
                { emoji: "⬅️", texto: "Volver al inicio",         desc: "Regresar al menú principal",           accion: "inicio", esVolver: true }
            ]
        },
        
        ejemplos_preguntas: {
            mensaje: "Aquí hay algunos ejemplos de preguntas que puedes hacerme:",
            opciones: [
                { emoji: "❓", texto: "¿Quién tiene el ACT-003?",                          desc: "Consulta el responsable de un activo",  query: "¿Quién tiene el ACT-003?" },
                { emoji: "❓", texto: "Último mantenimiento del laptop Dell",              desc: "Historial de un equipo específico",     query: "¿Cuándo fue el último mantenimiento del laptop Dell?" },
                { emoji: "❓", texto: "¿Cuántos activos tiene Roberto?",                  desc: "Inventario asignado a una persona",     query: "¿Cuántos activos tiene Roberto?" },
                { emoji: "❓", texto: "Equipos en el Piso 2",                             desc: "Activos de una ubicación concreta",     query: "¿Qué equipos hay en el Piso 2?" },
                { emoji: "⬅️", texto: "Volver",                                           desc: "Regresar a pregunta libre",             accion: "pregunta_libre", esVolver: true }
            ]
        }
    };
    
    // Mapa de colores por categoría
    const colorMap = {
        violet: { bg: 'bg-violet-50',  border: 'border-violet-200',  icon: 'bg-violet-100 text-violet-600',  hover: 'hover:border-violet-400 hover:bg-violet-50' },
        blue:   { bg: 'bg-blue-50',    border: 'border-blue-200',    icon: 'bg-blue-100 text-blue-600',      hover: 'hover:border-blue-400 hover:bg-blue-50' },
        cyan:   { bg: 'bg-cyan-50',    border: 'border-cyan-200',    icon: 'bg-cyan-100 text-cyan-600',      hover: 'hover:border-cyan-400 hover:bg-cyan-50' },
        teal:   { bg: 'bg-teal-50',    border: 'border-teal-200',    icon: 'bg-teal-100 text-teal-600',      hover: 'hover:border-teal-400 hover:bg-teal-50' },
        amber:  { bg: 'bg-amber-50',   border: 'border-amber-200',   icon: 'bg-amber-100 text-amber-600',    hover: 'hover:border-amber-400 hover:bg-amber-50' },
        green:  { bg: 'bg-emerald-50', border: 'border-emerald-200', icon: 'bg-emerald-100 text-emerald-600',hover: 'hover:border-emerald-400 hover:bg-emerald-50' },
        gray:   { bg: 'bg-gray-50',    border: 'border-gray-200',    icon: 'bg-gray-100 text-gray-500',      hover: 'hover:border-gray-400 hover:bg-gray-50' }
    };

    function mostrarOpciones(categoria) {
        contextoActual = categoria;
        const config = consultasCategorias[categoria];
        const suggestionsWrapper = document.getElementById('suggestions-wrapper');
        const suggestionsTitle = document.getElementById('suggestions-title');
        const breadcrumb = document.getElementById('suggestions-breadcrumb');
        
        // Actualizar título y breadcrumb
        if (categoria === 'inicio') {
            suggestionsTitle.textContent = '¿Qué te gustaría consultar?';
            breadcrumb.classList.add('hidden');
        } else {
            const titulos = {
                buscar_activo: 'Buscar activo', ver_asignaciones: 'Asignaciones',
                consultar_ubicacion: 'Ubicaciones', ver_mantenimientos: 'Mantenimientos',
                ver_disponibilidad: 'Disponibilidad', departamentos: 'Departamentos',
                agendar_reunion: 'Agendar reunión', pregunta_libre: 'Pregunta libre',
                ejemplos_preguntas: 'Ejemplos'
            };
            suggestionsTitle.textContent = titulos[categoria] || 'Opciones';
            breadcrumb.textContent = 'Inicio → ' + (titulos[categoria] || categoria);
            breadcrumb.classList.remove('hidden');
        }
        
        suggestionsWrapper.innerHTML = '';

        // Usar grid de 2 o 3 columnas según cantidad de opciones
        const opcionesNormales = config.opciones.filter(o => !o.esVolver);
        const opcionVolver   = config.opciones.find(o => o.esVolver);

        const gridCols = categoria === 'inicio' ? 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-4' : 'grid-cols-1 sm:grid-cols-2';
        const grid = document.createElement('div');
        grid.className = `grid ${gridCols} gap-3`;

        opcionesNormales.forEach((opcion, index) => {
            const colors = colorMap[opcion.color] || colorMap.gray;
            const button = document.createElement('button');
            button.className = `suggestion-btn group text-left p-4 bg-white border ${colors.border} ${colors.hover} rounded-2xl transition-all duration-200 flex flex-col gap-2`;
            button.style.animationDelay = (index * 0.05) + 's';
            button.classList.add('animate-fade-in');
            button.innerHTML = `
                <div class="flex items-start gap-3">
                    <span class="text-2xl leading-none flex-shrink-0" aria-hidden="true">${opcion.emoji}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-gray-900 leading-tight">${opcion.texto}</p>
                        ${opcion.desc ? `<p class="text-xs text-gray-400 mt-0.5 leading-tight">${opcion.desc}</p>` : ''}
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 flex-shrink-0 mt-0.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            `;
            button.onclick = () => handleOpcionClick(opcion);
            grid.appendChild(button);
        });

        suggestionsWrapper.appendChild(grid);

        // Botón de volver separado, estilo discreto
        if (opcionVolver) {
            const backBtn = document.createElement('button');
            backBtn.className = 'suggestion-btn mt-3 w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-xl border border-transparent hover:border-brand-200 transition-all duration-200';
            backBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>${opcionVolver.texto}</span>
                <span class="text-xs text-gray-300">${opcionVolver.desc || ''}</span>
            `;
            backBtn.onclick = () => handleOpcionClick(opcionVolver);
            suggestionsWrapper.appendChild(backBtn);
        }
    }

    function handleOpcionClick(opcion) {
        if (opcion.accion === 'form_agendar') {
            abrirModalAgendar();
        } else if (opcion.accion === 'input') {
            activarInput(opcion.placeholder);
        } else if (opcion.query) {
            enviarMensajeContextual(opcion.query);
        } else if (opcion.accion) {
            const nuevoConfig = consultasCategorias[opcion.accion];
            if (nuevoConfig) {
                addMessage(nuevoConfig.mensaje, false);
                setTimeout(() => mostrarOpciones(opcion.accion), 300);
            }
        }
    }
    
    function activarInput(placeholder) {
        messageInput.placeholder = placeholder;
        messageInput.focus();
        messageInput.classList.add('ring-2', 'ring-brand-400', 'border-brand-400', 'bg-white');
        
        setTimeout(() => {
            messageInput.classList.remove('ring-2', 'ring-brand-400', 'border-brand-400');
            messageInput.placeholder = 'Escribe tu mensaje aquí...';
        }, 5000);
    }
    
    function enviarMensajeContextual(texto) {
        messageInput.value = texto;
        chatForm.dispatchEvent(new Event('submit'));
    }
    
    function mostrarOpcionesContinuacion() {
        const suggestionsWrapper = document.getElementById('suggestions-wrapper');
        const suggestionsTitle = document.getElementById('suggestions-title');
        const breadcrumb = document.getElementById('suggestions-breadcrumb');
        
        suggestionsTitle.textContent = '¿Qué deseas hacer ahora?';
        breadcrumb.classList.add('hidden');
        suggestionsWrapper.innerHTML = '';
        
        const opciones = [
            { emoji: "🔄", texto: "Repetir consulta",       desc: "Hacer otra búsqueda similar",     accion: contextoActual, color: 'blue' },
            { emoji: "🏠", texto: "Menú principal",         desc: "Ver todas las opciones",          accion: "inicio",        color: 'gray' },
            { emoji: "✍️", texto: "Pregunta personalizada", desc: "Escribe lo que necesitas",        accion: "input",  placeholder: "Escribe tu pregunta...", color: 'teal' }
        ];
        
        const grid = document.createElement('div');
        grid.className = 'grid grid-cols-1 sm:grid-cols-3 gap-3';

        opciones.forEach(opcion => {
            const colors = colorMap[opcion.color] || colorMap.gray;
            const button = document.createElement('button');
            button.className = `suggestion-btn group text-left p-4 bg-white border ${colors.border} ${colors.hover} rounded-2xl transition-all duration-200 flex flex-col gap-2 animate-fade-in`;
            button.innerHTML = `
                <div class="flex items-start gap-3">
                    <span class="text-xl leading-none flex-shrink-0">${opcion.emoji}</span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-gray-900 leading-tight">${opcion.texto}</p>
                        <p class="text-xs text-gray-400 mt-0.5">${opcion.desc}</p>
                    </div>
                </div>
            `;
            button.onclick = () => {
                if (opcion.accion === 'input') {
                    activarInput(opcion.placeholder);
                } else {
                    mostrarOpciones(opcion.accion);
                }
            };
            grid.appendChild(button);
        });
        suggestionsWrapper.appendChild(grid);
    }
    
    // Inicializar con mensaje de bienvenida y menú
    setTimeout(() => {
        addMessage(consultasCategorias.inicio.mensaje, false);
        setTimeout(() => mostrarOpciones('inicio'), 500);
    }, 300);
    
    // =========================================================================
    // FIN DEL SISTEMA DE MENÚ CONTEXTUAL
    // =========================================================================
    
    function updateModeUI() {
        if (botModeSelect.value === 'n8n') {
            webhookConfig.classList.remove('hidden');
            updateConnectionStatus(false, 'Configura webhook');
        } else {
            webhookConfig.classList.add('hidden');
            updateConnectionStatus(true, 'Bot local activo');
        }
        localStorage.setItem('bot_mode', botModeSelect.value);
    }
    
    updateModeUI();
    botModeSelect.addEventListener('change', updateModeUI);

    function getSessionId() {
        let sessionId = localStorage.getItem('chat_session_id');
        if (!sessionId) {
            sessionId = generateNewSessionId();
            localStorage.setItem('chat_session_id', sessionId);
        }
        return sessionId;
    }

    function generateNewSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    webhookUrlInput.addEventListener('change', function() {
        localStorage.setItem('webhook_url', this.value);
    });
    
    ocrWebhookUrlInput.addEventListener('change', function() {
        localStorage.setItem('ocr_webhook_url', this.value);
    });

    function updateConnectionStatus(isConnected, message = '') {
        const statusDot = connectionStatus.querySelector('.w-2');
        const statusText = connectionStatus.querySelector('.text-xs');
        
        connectionStatus.classList.remove('hidden');
        connectionStatus.classList.add('flex');
        
        if (isConnected) {
            statusDot.className = 'w-2 h-2 bg-emerald-400 rounded-full status-pulse';
            statusText.textContent = message || 'Conectado';
            statusText.className = 'text-emerald-200 text-xs font-medium';
        } else {
            statusDot.className = 'w-2 h-2 bg-red-400 rounded-full';
            statusText.textContent = message || 'Desconectado';
            statusText.className = 'text-white/80 text-xs font-medium';
        }
    }

    testConnectionBtn.addEventListener('click', async function() {
        const webhookUrl = webhookUrlInput.value.trim();
        
        if (!webhookUrl) {
            alert('Por favor ingresa la URL del webhook');
            return;
        }

        testConnectionBtn.disabled = true;
        testConnectionBtn.textContent = 'Probando...';

        try {
            const response = await fetch(webhookUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({mensaje: 'test', sessionId: getSessionId()})
            });

            if (response.ok) {
                updateConnectionStatus(true);
                alert('✅ Conexión exitosa');
            } else {
                updateConnectionStatus(false, 'Error');
                alert('❌ Error: ' + response.status);
            }
        } catch (error) {
            updateConnectionStatus(false, 'Error');
            alert('❌ ' + error.message);
        } finally {
            testConnectionBtn.disabled = false;
            testConnectionBtn.textContent = 'Probar Conexión';
        }
    });
    
    testOcrConnectionBtn.addEventListener('click', async function() {
        const ocrUrl = ocrWebhookUrlInput.value.trim();
        
        if (!ocrUrl) {
            alert('⚠️ Por favor ingresa la URL del webhook OCR');
            return;
        }

        testOcrConnectionBtn.disabled = true;
        testOcrConnectionBtn.textContent = 'Probando...';

        try {
            // Crear una imagen de prueba pequeña (1x1 pixel transparente PNG)
            const testBlob = await fetch('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==')
                .then(res => res.blob());
            
            const testFile = new File([testBlob], 'test.png', { type: 'image/png' });
            
            const formData = new FormData();
            formData.append('Imagen', testFile);
            formData.append('test', 'true');
            
            console.log('🔍 Enviando prueba a:', ocrUrl);
            
            const response = await fetch(ocrUrl, {
                method: 'POST',
                body: formData
            });

            console.log('📥 Respuesta recibida:', response.status, response.statusText);
            
            const responseText = await response.text();
            console.log('📄 Contenido:', responseText);

            if (response.ok) {
                try {
                    const data = JSON.parse(responseText);
                    alert(`✅ Webhook OCR funciona correctamente\n\nRespuesta:\n${JSON.stringify(data, null, 2)}`);
                } catch {
                    alert(`✅ Webhook OCR responde (código 200)\n\nRespuesta:\n${responseText.substring(0, 200)}`);
                }
            } else {
                alert(`❌ Error ${response.status}: ${response.statusText}\n\nVerifica:\n1. Que el workflow esté publicado\n2. Que la URL sea correcta\n3. Que el nodo Webhook esté configurado\n\nRespuesta:\n${responseText.substring(0, 300)}`);
            }
        } catch (error) {
            console.error('❌ Error en prueba OCR:', error);
            alert(`❌ Error de conexión: ${error.message}\n\nVerifica:\n1. Que n8n esté corriendo\n2. La URL correcta del webhook\n3. No hay problemas de CORS`);
        } finally {
            testOcrConnectionBtn.disabled = false;
            testOcrConnectionBtn.textContent = 'Probar OCR';
        }
    });

    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-end gap-3 message-animate ${isUser ? 'flex-row-reverse' : ''}`;

        const timestamp = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});

        // Formatear el mensaje del bot
        const formattedMessage = isUser ? escapeHtml(message) : formatBotResponse(message);

        if (isUser) {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="flex flex-col items-end max-w-[75%]">
                    <div class="chat-bubble-user text-white px-4 py-3">
                        <p class="text-sm leading-relaxed">${formattedMessage}</p>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1.5 mr-1">${timestamp}</span>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-gradient-to-br from-brand-100 to-brand-200 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"></path></svg>
                </div>
                <div class="flex flex-col max-w-[80%]">
                    <div class="chat-bubble-bot px-4 py-3">
                        <div class="text-sm leading-relaxed text-gray-700 prose-sm">${formattedMessage}</div>
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1.5 ml-1">${timestamp}</span>
                </div>
            `;
        }

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'flex items-end gap-3 message-animate';
        typingDiv.innerHTML = `
            <div class="w-8 h-8 bg-gradient-to-br from-brand-100 to-brand-200 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"></path></svg>
            </div>
            <div class="chat-bubble-bot px-5 py-3.5">
                <div class="typing-indicator flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-brand-400 rounded-full"></span>
                    <span class="w-2 h-2 bg-brand-400 rounded-full"></span>
                    <span class="w-2 h-2 bg-brand-400 rounded-full"></span>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) typingIndicator.remove();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Formatear respuesta del bot con estilos mejorados
    function formatBotResponse(text) {
        // Escapar HTML primero
        text = escapeHtml(text);
        
        // Detectar si es una respuesta de ayuda (contiene pasos numerados o URLs)
        const esAyuda = text.match(/\d+\.\s+|🔗\s*http/);
        
        if (esAyuda) {
            // Formatear pasos numerados con contenedor visual
            text = text.replace(/(\d+)\.\s+([^\n]+)/g, function(match, numero, contenido) {
                return `<div class="my-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm shadow-md">${numero}</span>
                        <p class="flex-1 text-gray-800 leading-relaxed pt-1">${contenido}</p>
                    </div>
                </div>`;
            });
            
            // Formatear URLs como botones elegantes
            text = text.replace(/🔗\s*(http[^\s<]+)/g, function(match, url) {
                return `<div class="my-2">
                    <a href="${url}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Abrir en la aplicación
                    </a>
                </div>`;
            });
            
            // Formatear secciones con emoji (📌, ✨, etc.)
            text = text.replace(/([📌✨💡🎯📍🔍])\s*([^:\n]+):/g, '<div class="mt-4 mb-2"><span class="inline-block px-3 py-1 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 rounded-full font-semibold text-sm shadow-sm">$1 $2</span></div>');
            
            // Mejorar bullets con hover
            text = text.replace(/(?:^|\n)[•*-]\s+(.+)/g, '<div class="ml-4 my-1.5 pl-3 border-l-2 border-gray-300 hover:border-blue-500 transition-colors"><span class="text-gray-700">• $1</span></div>');
        } else {
            // Formateo normal para respuestas de datos
            // Detectar y formatear códigos de activos (ACT-XXX, SN-XXX-XX)
            text = text.replace(/\b(ACT-\d+|SN-[A-Z]+-\d+)\b/g, '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-mono">$1</span>');
            
            // Resaltar estados importantes
            text = text.replace(/\b(OCUPADO|DISPONIBLE|NO DISPONIBLE|OPERATIVO|EN MANTENIMIENTO)\b/gi, function(match) {
                const colors = {
                    'OCUPADO': 'bg-yellow-100 text-yellow-800',
                    'DISPONIBLE': 'bg-green-100 text-green-800',
                    'NO DISPONIBLE': 'bg-red-100 text-red-800',
                    'OPERATIVO': 'bg-green-100 text-green-800',
                    'EN MANTENIMIENTO': 'bg-orange-100 text-orange-800'
                };
                const color = colors[match.toUpperCase()] || 'bg-gray-100 text-gray-800';
                return `<span class="px-2 py-1 ${color} rounded text-xs font-semibold">${match}</span>`;
            });
            
            // Formatear nombres de ubicaciones (Edificio X, Piso Y, etc.)
            text = text.replace(/\b(Edificio [A-Z]|Piso \d+|Laboratorio [^\s,]+|Decanato de [^\s,]+|Facultad de [^\s,]+)\b/g, '<span class="text-purple-700 font-medium">$1</span>');
            
            // Resaltar nombres de personas (patrón común: Nombre Apellido)
            text = text.replace(/\b([A-ZÁÉÍÓÚÑ][a-záéíóúñ]+ [A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)\b/g, '<span class="text-blue-700 font-medium">👤 $1</span>');
            
            // Convertir listas con viñetas (* item o - item)
            text = text.replace(/(?:^|\n)[*-] (.+)/g, '<br>• $1');
            
            // Formatear fechas (dd/mm/yyyy o d de mes de yyyy)
            text = text.replace(/\b(\d{1,2}\/\d{1,2}\/\d{4}|\d{1,2} de [a-z]+ de \d{4})\b/gi, '<span class="text-gray-700 font-medium">📅 $1</span>');
        }
        
        // Preservar saltos de línea
        text = text.replace(/\n/g, '<br>');
        
        return text;
    }

    // =========================================================================
    // FUNCIONALIDAD DE SUBIDA DE IMÁGENES PARA OCR
    // =========================================================================
    
    // Abrir selector de archivo cuando se hace clic en el botón de adjuntar
    attachImageBtn.addEventListener('click', function() {
        imageInput.click();
    });
    
    // Manejar selección de imagen
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar que sea una imagen
            if (!file.type.startsWith('image/')) {
                alert('⚠️ Por favor selecciona un archivo de imagen válido');
                return;
            }
            
            // Validar tamaño (máximo 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('⚠️ La imagen es demasiado grande. Máximo 10MB');
                return;
            }
            
            selectedImage = file;
            
            // Mostrar vista previa
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                const fileNameEl = document.getElementById('image-file-name');
                if (fileNameEl) fileNameEl.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                imagePreviewContainer.classList.remove('hidden');
                attachImageBtn.classList.add('bg-brand-50', 'text-brand-500', 'border-brand-300');
                attachImageBtn.classList.remove('bg-gray-50', 'text-gray-400', 'border-gray-200');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Eliminar imagen seleccionada
    removeImageBtn.addEventListener('click', function() {
        selectedImage = null;
        imageInput.value = '';
        imagePreviewContainer.classList.add('hidden');
        imagePreview.src = '';
        attachImageBtn.classList.remove('bg-brand-50', 'text-brand-500', 'border-brand-300');
        attachImageBtn.classList.add('bg-gray-50', 'text-gray-400', 'border-gray-200');
    });
    
    /**
     * Envía una imagen al endpoint de n8n para análisis OCR
     * @param {File} imageFile - Archivo de imagen a analizar
     * @returns {Promise<Object>} - Respuesta del servidor
     */
    async function sendImageForOCR(imageFile) {
        // Obtener URL configurada del webhook OCR
        const ocrEndpoint = ocrWebhookUrlInput.value.trim();
        
        if (!ocrEndpoint) {
            return {
                success: false,
                error: 'No se ha configurado la URL del webhook OCR. Por favor configúrala en la sección de ajustes.'
            };
        }
        
        console.log('📤 Enviando imagen para OCR...');
        console.log('📍 Endpoint:', ocrEndpoint);
        console.log('📄 Archivo:', imageFile.name, '|', imageFile.type, '|', (imageFile.size / 1024).toFixed(2) + ' KB');
        
        try {
            // Crear FormData con la imagen usando la clave exacta "Imagen"
            const formData = new FormData();
            formData.append('Imagen', imageFile);
            
            // Opcional: agregar sessionId si es necesario
            formData.append('sessionId', getSessionId());
            
            console.log('🚀 Realizando petición POST...');
            
            // Realizar petición HTTP POST con multipart/form-data
            const response = await fetch(ocrEndpoint, {
                method: 'POST',
                body: formData
                // No establecer Content-Type - el navegador lo hará automáticamente con el boundary correcto
            });
            
            console.log('📥 Respuesta recibida:', response.status, response.statusText);
            
            // Obtener el texto de la respuesta primero
            const responseText = await response.text();
            console.log('📄 Contenido de respuesta:', responseText.substring(0, 500));
            
            // Verificar si la respuesta fue exitosa
            if (!response.ok) {
                // Guardar información del error para el modal de diagnóstico
                const errorInfo = {
                    success: false,
                    errorCode: response.status,
                    errorMessage: response.statusText,
                    responseText: responseText,
                    error: `Error ${response.status}: ${response.statusText}\n\nDetalles: ${responseText.substring(0, 200)}`
                };
                
                console.error('❌ Error HTTP:', errorInfo);
                return errorInfo;
            }
            
            // Intentar parsear respuesta JSON
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('✅ JSON parseado:', data);
            } catch (e) {
                console.warn('⚠️ La respuesta no es JSON válido');
                return {
                    success: true,
                    data: { text: responseText }
                };
            }
            
            return {
                success: true,
                data: data
            };
            
        } catch (error) {
            console.error('❌ Error al enviar imagen para OCR:', error);
            
            // Manejo de errores específicos
            if (error.message.includes('Failed to fetch') || error.message.includes('NetworkError')) {
                return {
                    success: false,
                    error: `No se pudo conectar con el servidor de n8n.\n\n✓ Verifica que n8n esté activo\n✓ URL correcta: ${ocrEndpoint}\n✓ Workflow publicado`
                };
            }
            
            return {
                success: false,
                error: error.message || 'Error desconocido al procesar la imagen'
            };
        }
    }
    
    // =========================================================================
    // FIN DE FUNCIONALIDAD DE IMÁGENES
    // =========================================================================

    async function sendMessage(message) {
        if (!message.trim()) return;

        const botMode = botModeSelect.value;
        console.log('🗨️ RUTA 2: Chat de Texto Normal - Webhook:', webhookUrlInput.value);

        addMessage(message, true);
        messageInput.value = '';
        sendButton.disabled = true;
        messageInput.disabled = true;

        showTypingIndicator();

        try {
            let response;
            
            if (botMode === 'local') {
                response = await fetch('{{ route("chat.testBot") }}', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    body: JSON.stringify({message: message})
                });
            } else {
                const webhookUrl = webhookUrlInput.value.trim();
                
                if (!webhookUrl) {
                    removeTypingIndicator();
                    addMessage('Configura la URL del webhook primero', false);
                    sendButton.disabled = false;
                    messageInput.disabled = false;
                    return;
                }
                
                response = await fetch(webhookUrl, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({mensaje: message, sessionId: getSessionId()})
                });
            }

            removeTypingIndicator();

            if (response.ok) {
                const data = await response.json();
                const botMessage = botMode === 'local' 
                    ? (data.data?.response || data.response || JSON.stringify(data))
                    : (data.reply || data.response || data.message || data.output || JSON.stringify(data));
                addMessage(botMessage, false);
                if (botMode === 'n8n') updateConnectionStatus(true);
                
                // Mostrar opciones de continuación después de la respuesta
                setTimeout(() => {
                    mostrarOpcionesContinuacion();
                }, 800);
            } else {
                addMessage('Error ' + response.status + ': ' + response.statusText, false);
                if (botMode === 'n8n') updateConnectionStatus(false, 'Error');
            }
        } catch (error) {
            removeTypingIndicator();
            addMessage(botMode === 'n8n' ? 'Error: Verifica que n8n esté activo' : 'Error de conexión', false);
            if (botMode === 'n8n') updateConnectionStatus(false, 'Error');
            console.error('Error:', error);
        } finally {
            sendButton.disabled = false;
            messageInput.disabled = false;
            messageInput.focus();
        }
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // =========================================================================
        // ENRUTAMIENTO: Decide qué webhook usar según el tipo de mensaje
        // =========================================================================
        
        if (selectedImage) {
            // ✅ RUTA 1: Análisis OCR de Imagen
            // Webhook: http://localhost:5678/webhook-test/analizar
            console.log('🖼️ RUTA: Análisis OCR - Enviando imagen a webhook OCR');
            handleImageSubmit();
        } else {
            // ✅ RUTA 2: Chat de Texto Normal
            // Webhook: http://localhost:5678/webhook-test/asistente (o bot local)
            const message = messageInput.value.trim();
            if (message) {
                console.log('💬 RUTA: Chat Normal - Enviando texto a webhook asistente');
                sendMessage(message);
            }
        }
    });
    
    /**
     * Maneja el envío de una imagen para análisis OCR
     */
    async function handleImageSubmit() {
        const messageText = messageInput.value.trim() || 'Analizar esta imagen';
        
        // Mostrar mensaje del usuario con indicador de imagen
        addMessage(`📷 ${messageText}`, true);
        
        // Deshabilitar controles
        sendButton.disabled = true;
        messageInput.disabled = true;
        attachImageBtn.disabled = true;
        
        // Mostrar indicador de carga
        showTypingIndicator();
        
        try {
            // Enviar imagen al endpoint de OCR
            console.log('🖼️ Procesando imagen:', selectedImage.name);
            const result = await sendImageForOCR(selectedImage);
            
            removeTypingIndicator();
            
            if (result.success) {
                // Procesar respuesta exitosa
                const ocrData = result.data;
                
                console.log('✅ Respuesta exitosa del OCR:', ocrData);
                
                // Extraer el mensaje de respuesta (adaptar según la estructura de tu respuesta)
                let botMessage = '';
                
                // 1. Buscar mensajes directos del LLM/Asistente
                if (ocrData.reply) {
                    botMessage = ocrData.reply;
                } else if (ocrData.response && typeof ocrData.response === 'string') {
                    botMessage = ocrData.response;
                } else if (ocrData.output && typeof ocrData.output === 'string') {
                    botMessage = ocrData.output;
                } else if (ocrData.message && typeof ocrData.message === 'string') {
                    botMessage = ocrData.message;
                    
                // 2. Buscar datos estructurados de OCR/Análisis
                } else if (ocrData.analisis || ocrData.texto || ocrData.text || ocrData.data) {
                    let datosExtraidos = {};
                    
                    // Recopilar todos los campos con datos útiles
                    if (ocrData.analisis !== undefined && ocrData.analisis !== null) {
                        // Si analisis es un string JSON, parsearlo
                        if (typeof ocrData.analisis === 'string') {
                            try {
                                const parsed = JSON.parse(ocrData.analisis);
                                if (typeof parsed === 'object' && parsed !== null) {
                                    datosExtraidos = parsed;
                                } else {
                                    datosExtraidos.analisis = ocrData.analisis;
                                }
                            } catch (e) {
                                datosExtraidos.analisis = ocrData.analisis;
                            }
                        } else if (typeof ocrData.analisis === 'object') {
                            datosExtraidos = ocrData.analisis;
                        } else {
                            datosExtraidos.analisis = ocrData.analisis;
                        }
                    }
                    if (ocrData.texto) datosExtraidos.texto = ocrData.texto;
                    if (ocrData.text) datosExtraidos.text = ocrData.text;
                    if (ocrData.codigo) datosExtraidos.codigo = ocrData.codigo;
                    if (ocrData.barcode) datosExtraidos.barcode = ocrData.barcode;
                    if (ocrData.qr) datosExtraidos.qr = ocrData.qr;
                    if (ocrData.descripcion) datosExtraidos.descripcion = ocrData.descripcion;
                    if (ocrData.categoria) datosExtraidos.categoria = ocrData.categoria;
                    if (ocrData.marca) datosExtraidos.marca = ocrData.marca;
                    if (ocrData.modelo) datosExtraidos.modelo = ocrData.modelo;
                    if (ocrData.data && typeof ocrData.data === 'object') {
                        Object.assign(datosExtraidos, ocrData.data);
                    }
                    
                    // Mapa de emojis por tipo de campo
                    const emojiMap = {
                        'producto': '🏷️',
                        'product': '🏷️',
                        'nombre': '🏷️',
                        'name': '🏷️',
                        'serial': '🔢',
                        'serie': '🔢',
                        's/n': '🔢',
                        'sn': '🔢',
                        'part_number': '🔧',
                        'part': '🔧',
                        'numero_parte': '🔧',
                        'specs': '⚙️',
                        'especificaciones': '⚙️',
                        'specifications': '⚙️',
                        'modelo': '📱',
                        'model': '📱',
                        'marca': '🏢',
                        'brand': '🏢',
                        'fabricante': '🏢',
                        'manufacturer': '🏢',
                        'categoria': '📂',
                        'category': '📂',
                        'tipo': '📂',
                        'type': '📂',
                        'codigo': '🔖',
                        'code': '🔖',
                        'barcode': '🔖',
                        'qr': '📷',
                        'descripcion': '📝',
                        'description': '📝',
                        'precio': '💰',
                        'price': '💰',
                        'costo': '💰',
                        'cost': '💰',
                        'fecha': '📅',
                        'date': '📅',
                        'ubicacion': '📍',
                        'location': '📍',
                        'estado': '🔄',
                        'status': '🔄',
                        'condicion': '✨',
                        'condition': '✨',
                        'cantidad': '🔢',
                        'quantity': '🔢',
                        'stock': '📦',
                        'inventario': '📦',
                        'inventory': '📦'
                    };
                    
                    // Función para obtener emoji de un campo
                    const getEmoji = (campo) => {
                        const key = campo.toLowerCase().replace(/[_\s-]/g, '');
                        return emojiMap[key] || '•';
                    };
                    
                    // Construir mensaje formateado
                    if (Object.keys(datosExtraidos).length > 0) {
                        botMessage = `✅ **Análisis OCR Completado**\n\n`;
                        botMessage += `╭─────────────────────────╮\n`;
                        botMessage += `│  **📋 INFORMACIÓN DETECTADA**  │\n`;
                        botMessage += `╰─────────────────────────╯\n\n`;
                        
                        // Formatear cada campo detectado con diseño de tarjeta
                        for (const [campo, valor] of Object.entries(datosExtraidos)) {
                            const emoji = getEmoji(campo);
                            const nombreCampo = campo
                                .replace(/_/g, ' ')
                                .split(' ')
                                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                                .join(' ');
                            
                            if (typeof valor === 'string' && valor.trim().length > 0) {
                                // Formatear según longitud del texto
                                if (valor.length > 100) {
                                    const palabras = valor.trim().split(/\s+/).length;
                                    botMessage += `${emoji} **${nombreCampo}:**\n`;
                                    botMessage += `   *(${valor.length} caracteres, ${palabras} palabras)*\n\n`;
                                    botMessage += `\`\`\`\n${valor}\n\`\`\`\n\n`;
                                } else {
                                    botMessage += `${emoji} **${nombreCampo}:** ${valor}\n\n`;
                                }
                            } else if (typeof valor === 'number') {
                                botMessage += `${emoji} **${nombreCampo}:** ${valor}\n\n`;
                            } else if (typeof valor === 'boolean') {
                                botMessage += `${emoji} **${nombreCampo}:** ${valor ? '✓ Sí' : '✗ No'}\n\n`;
                            } else if (Array.isArray(valor)) {
                                botMessage += `${emoji} **${nombreCampo}:**\n`;
                                valor.forEach(item => {
                                    botMessage += `   • ${item}\n`;
                                });
                                botMessage += `\n`;
                            } else if (typeof valor === 'object' && valor !== null) {
                                botMessage += `${emoji} **${nombreCampo}:**\n`;
                                for (const [subKey, subVal] of Object.entries(valor)) {
                                    botMessage += `   • ${subKey}: ${subVal}\n`;
                                }
                                botMessage += `\n`;
                            } else {
                                botMessage += `${emoji} **${nombreCampo}:** ${valor}\n\n`;
                            }
                        }
                        
                        botMessage += `───────────────────────\n\n`;
                        botMessage += `📁 **Archivo:** ${selectedImage.name}`;
                    } else {
                        // Campos vacíos
                        botMessage = `⚠️ **Análisis OCR Completado**\n\n` +
                                   `❌ **No se detectó información** en la imagen.\n\n` +
                                   `**Posibles causas:**\n` +
                                   `• La imagen no contiene texto legible\n` +
                                   `• El texto es demasiado pequeño o borroso\n` +
                                   `• La calidad de la imagen es insuficiente\n` +
                                   `• El formato no es compatible\n\n` +
                                   `**Sugerencias:**\n` +
                                   `• Intenta con una imagen de mayor resolución\n` +
                                   `• Asegúrate de que el contenido sea claro y visible\n` +
                                   `• Verifica que la imagen no esté rotada o invertida`;
                    }
                    
                // 3. Buscar campo result
                } else if (ocrData.result) {
                    botMessage = typeof ocrData.result === 'string' 
                        ? ocrData.result 
                        : `✅ **Resultado del análisis:**\n\n\`\`\`json\n${JSON.stringify(ocrData.result, null, 2)}\n\`\`\``;
                        
                // 4. Respuesta genérica - intentar extraer información útil
                } else {
                    // Buscar cualquier campo que no sea metadata
                    const camposExcluidos = ['status', 'success', 'ok', 'timestamp', 'duration', 'executionId'];
                    const camposUtiles = Object.entries(ocrData).filter(([key]) => 
                        !camposExcluidos.includes(key.toLowerCase())
                    );
                    
                    if (camposUtiles.length > 0) {
                        botMessage = `✅ **Análisis Completado**\n\n`;
                        
                        for (const [campo, valor] of camposUtiles) {
                            const nombreCampo = campo.charAt(0).toUpperCase() + campo.slice(1);
                            
                            if (typeof valor === 'string' && valor.trim().length > 0) {
                                botMessage += `**${nombreCampo}:** \`${valor}\`\n\n`;
                            } else if (typeof valor === 'number') {
                                botMessage += `**${nombreCampo}:** \`${valor}\`\n\n`;
                            } else if (typeof valor === 'object' && valor !== null) {
                                botMessage += `**${nombreCampo}:**\n\`\`\`json\n${JSON.stringify(valor, null, 2)}\n\`\`\`\n\n`;
                            }
                        }
                    } else {
                        // Última opción: mostrar todo
                        botMessage = `✅ **Imagen Procesada**\n\n` +
                                   `📦 **Respuesta del servidor:**\n\n` +
                                   `\`\`\`json\n${JSON.stringify(ocrData, null, 2)}\n\`\`\`\n\n` +
                                   `ℹ️ *Configura el workflow en n8n para devolver campos como: analisis, texto, codigo, etc.*`;
                    }
                }
                
                addMessage(botMessage, false);
                updateConnectionStatus(true, 'OCR completado');
                
            } else {
                // Mostrar mensaje de error detallado
                console.error('❌ Error en OCR:', result.error);
                
                // Si es un error 500, mostrar modal de diagnóstico
                if (result.errorCode === 500 && result.responseText) {
                    mostrarModalDiagnostico(
                        ocrWebhookUrlInput.value.trim(),
                        selectedImage.name + ' (' + (selectedImage.size / 1024).toFixed(2) + ' KB)',
                        result.responseText
                    );
                    addMessage(`❌ **Error 500: Internal Server Error**\n\nSe ha abierto el diagnóstico detallado. Revisa el modal para más información.`, false);
                } else {
                    addMessage(`❌ **Error al procesar la imagen**\n\n${result.error}\n\n**Sugerencias:**\n\n1️⃣ Verifica que el workflow esté **publicado** en n8n\n2️⃣ Comprueba la URL del webhook en la configuración\n3️⃣ Presiona "Probar OCR" para diagnosticar\n4️⃣ Revisa la consola del navegador (F12) para más detalles`, false);
                }
                
                updateConnectionStatus(false, 'Error OCR');
            }
            
        } catch (error) {
            removeTypingIndicator();
            console.error('❌ Error inesperado en handleImageSubmit:', error);
            addMessage(`❌ **Error inesperado:** ${error.message}\n\nRevisa la consola del navegador (F12) para más información.`, false);
        } finally {
            // Limpiar imagen seleccionada
            selectedImage = null;
            imageInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            imagePreview.src = '';
            attachImageBtn.classList.remove('bg-brand-50', 'text-brand-500', 'border-brand-300');
            attachImageBtn.classList.add('bg-gray-50', 'text-gray-400', 'border-gray-200');
            
            // Limpiar input de mensaje
            messageInput.value = '';
            
            // Rehabilitar controles
            sendButton.disabled = false;
            messageInput.disabled = false;
            attachImageBtn.disabled = false;
            messageInput.focus();
            
            // Mostrar opciones de continuación
            setTimeout(() => {
                mostrarOpcionesContinuacion();
            }, 800);
        }
    }

    // =========================================================================
    // SISTEMA DE AGENDAMIENTO RÁPIDO
    // =========================================================================

    function abrirModalAgendar() {
        const modal = document.getElementById('modal-agendar');
        modal.classList.remove('hidden');
        
        // Establecer fecha mínima a hoy
        const inputFecha = document.getElementById('input-fecha');
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.setAttribute('min', hoy);
        inputFecha.value = hoy;
        
        // Establecer hora por defecto (hora actual + 1)
        const inputHora = document.getElementById('input-hora');
        const ahora = new Date();
        ahora.setHours(ahora.getHours() + 1);
        inputHora.value = ahora.toTimeString().substring(0, 5);
    }

    function cerrarModalAgendar() {
        const modal = document.getElementById('modal-agendar');
        modal.classList.add('hidden');
        
        // Limpiar formulario
        document.getElementById('form-agendar').reset();
    }

    // Manejar submit del formulario de agendamiento
    const formAgendar = document.getElementById('form-agendar');
    
    formAgendar.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obtener valores del formulario
        const fecha = document.getElementById('input-fecha').value;
        const hora = document.getElementById('input-hora').value;
        const motivo = document.getElementById('input-motivo').value;
        const invitadosRaw = document.getElementById('input-invitados').value.trim();
        
        // Procesar múltiples invitados
        let invitadosLista = [];
        if (invitadosRaw) {
            // Separar por comas, punto y coma, o saltos de línea
            invitadosLista = invitadosRaw
                .split(/[,;\n]+/)
                .map(email => email.trim())
                .filter(email => email.length > 0);
            
            // Validar formato de emails
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const emailsInvalidos = invitadosLista.filter(email => !emailRegex.test(email));
            
            if (emailsInvalidos.length > 0) {
                alert(`Los siguientes correos no son válidos:\n${emailsInvalidos.join('\n')}`);
                return;
            }
        }
        
        // Construir mensaje estructurado según el formato requerido
        let mensajeEstructurado = '';
        
        if (invitadosLista.length > 0) {
            // Caso 1: Reunión con invitados (uno o múltiples)
            const invitadosStr = invitadosLista.join(', ');
            mensajeEstructurado = `Comando: Agendar reunión. Fecha: ${fecha}. Hora: ${hora}. Motivo: ${motivo}. Invitar al correo: ${invitadosStr}.`;
        } else {
            // Caso 2: Bloqueo personal sin invitados
            mensajeEstructurado = `Comando: Bloquear agenda. Fecha: ${fecha}. Hora: ${hora}. Motivo: ${motivo}. Nota: Evento privado sin invitados.`;
        }
        
        // Cerrar modal
        cerrarModalAgendar();
        
        // Mostrar confirmación visual al usuario
        const fechaFormateada = new Date(fecha + 'T00:00:00').toLocaleDateString('es-ES', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        const mensajeUsuario = invitadosLista.length > 0
            ? `Agendar reunión: "${motivo}" para el ${fechaFormateada} a las ${hora}. Invitados (${invitadosLista.length}): ${invitadosLista.join(', ')}`
            : `Bloquear agenda: "${motivo}" para el ${fechaFormateada} a las ${hora} (evento privado)`;
        
        addMessage(mensajeUsuario, true);
        
        // Enviar mensaje estructurado al bot
        sendMessage(mensajeEstructurado);
    });

    // Botón de nuevo chat - limpiar conversación y reiniciar
    document.getElementById('new-chat-btn').addEventListener('click', function() {
        if (confirm('¿Deseas iniciar un nuevo chat? Se limpiará la conversación actual.')) {
            // Limpiar mensajes
            chatMessages.innerHTML = '';
            
            // Generar nuevo sessionId y guardarlo
            const newSessionId = generateNewSessionId();
            localStorage.setItem('chat_session_id', newSessionId);
            
            // Mostrar mensaje de bienvenida
            mostrarOpciones('inicio');
            
            // Limpiar input
            messageInput.value = '';
            messageInput.focus();
            
            console.log('🆕 Nuevo chat iniciado con sessionId:', newSessionId);
        }
    });
    
    // =========================================================================
    // FUNCIONES GLOBALES PARA MODAL DE DIAGNÓSTICO OCR
    // =========================================================================
    
    window.mostrarModalDiagnostico = function(url, filename, responseText) {
        const modal = document.getElementById('modal-diagnostico-ocr');
        
        // Rellenar información
        document.getElementById('diag-url').textContent = url;
        document.getElementById('diag-file').textContent = filename;
        document.getElementById('diag-response').textContent = responseText.substring(0, 500);
        
        // Generar comando cURL
        const curlCommand = `curl -X POST "${url}" \\
  -F "Imagen=@/ruta/a/tu/imagen.jpg" \\
  -v`;
        document.getElementById('diag-curl').textContent = curlCommand;
        
        // Mostrar modal
        modal.classList.remove('hidden');
    };
    
    window.mostrarModalDiagnosticoVacio = function() {
        const modal = document.getElementById('modal-diagnostico-ocr');
        const url = ocrWebhookUrlInput.value.trim() || 'http://localhost:5678/webhook/TU-WEBHOOK-ID';
        
        // Rellenar información con valores por defecto
        document.getElementById('diag-url').textContent = url;
        document.getElementById('diag-file').textContent = 'imagen.jpg (ejemplo)';
        document.getElementById('diag-response').textContent = 'Aún no se ha enviado ninguna imagen.\n\nEsta guía te ayudará a solucionar el Error 500 cuando lo encuentres.';
        
        // Generar comando cURL
        const curlCommand = `curl -X POST "${url}" \\
  -F "Imagen=@/ruta/a/tu/imagen.jpg" \\
  -v`;
        document.getElementById('diag-curl').textContent = curlCommand;
        
        // Mostrar modal
        modal.classList.remove('hidden');
    };
    
    window.cerrarModalDiagnostico = function() {
        const modal = document.getElementById('modal-diagnostico-ocr');
        modal.classList.add('hidden');
    };

    messageInput.focus();
});
</script>
@endsection
