@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header del Chat -->
        <div class="bg-gradient-to-r from-brand-600 to-brand-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Asistente IA</h1>
                        <p class="text-brand-100 text-sm">Pregúntame sobre el inventario</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button 
                        id="new-chat-btn"
                        class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition duration-200 flex items-center space-x-2 text-sm font-medium backdrop-blur-sm"
                        title="Iniciar nuevo chat"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Nuevo Chat</span>
                    </button>
                    <div id="connection-status" class="flex items-center space-x-2">
                        <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        <span class="text-white text-sm">Desconectado</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración del Webhook -->
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="space-y-3">
                <!-- Selector de Modo -->
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Modo:</label>
                    <select id="bot-mode" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="local">Bot Local (Prueba)</option>
                        <option value="n8n">n8n Webhook</option>
                    </select>
                    <span class="text-xs text-gray-500">Usa "Bot Local" para probar sin n8n</span>
                </div>
                
                <!-- Configuración de Webhook (solo visible en modo n8n) -->
                <div id="webhook-config" class="hidden">
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Webhook URL:</label>
                        <input 
                            type="url" 
                            id="webhook-url" 
                            placeholder="http://localhost:5678/webhook-test/asistente"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-500"
                            value=""
                        >
                        <button 
                            id="test-connection" 
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition duration-200"
                        >
                            Probar Conexión
                        </button>
                    </div>
                    <div class="mt-2 text-xs text-gray-600">
                        <strong>Formato:</strong> {"mensaje": "texto", "sessionId": "id"}
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="h-[500px] flex flex-col">
            <!-- Mensajes -->
            <div id="chat-messages" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                <!-- Los mensajes se agregarán dinámicamente -->
            </div>

            <!-- Input de Mensaje -->
            <div class="border-t border-gray-200 px-6 py-4 bg-white">
                <form id="chat-form" class="flex space-x-4">
                    <input 
                        type="text" 
                        id="message-input" 
                        placeholder="Escribe tu mensaje aquí..."
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        id="send-button"
                        class="px-6 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition duration-200 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span>Enviar</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sugerencias contextuales dinámicas -->
    <div id="suggestions-container" class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-3" id="suggestions-title">💡 ¿Qué te gustaría consultar?</h3>
        <div id="suggestions-wrapper" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Las sugerencias se generarán dinámicamente según el contexto -->
        </div>
    </div>

    <!-- Modal de Agendamiento -->
    <div id="modal-agendar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">📅 Agendar Reunión</h3>
                <button onclick="cerrarModalAgendar()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="form-agendar" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" id="input-fecha" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
                    <input type="time" id="input-hora" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motivo/Título</label>
                    <input type="text" id="input-motivo" placeholder="Ej: Reunión de seguimiento" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Invitados (opcional)</label>
                    <textarea id="input-invitados" rows="2" placeholder="correo1@ejemplo.com, correo2@ejemplo.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Separa múltiples correos con comas. Deja vacío para evento privado.</p>
                </div>
                
                <div class="flex space-x-3 pt-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700 transition font-medium">
                        Agendar
                    </button>
                    <button type="button" onclick="cerrarModalAgendar()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #chat-messages::-webkit-scrollbar {width: 6px;}
    #chat-messages::-webkit-scrollbar-track {background: #f1f1f1;}
    #chat-messages::-webkit-scrollbar-thumb {background: #cbd5e0; border-radius: 3px;}
    #chat-messages::-webkit-scrollbar-thumb:hover {background: #a0aec0;}
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .typing-indicator span {animation: bounce 1.4s infinite;}
    .typing-indicator span:nth-child(2) {animation-delay: 0.2s;}
    .typing-indicator span:nth-child(3) {animation-delay: 0.4s;}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const webhookUrlInput = document.getElementById('webhook-url');
    const testConnectionBtn = document.getElementById('test-connection');
    const connectionStatus = document.getElementById('connection-status');
    const botModeSelect = document.getElementById('bot-mode');
    const webhookConfig = document.getElementById('webhook-config');

    const savedWebhookUrl = localStorage.getItem('webhook_url') || 'http://localhost:5678/webhook-test/asistente';
    const savedBotMode = localStorage.getItem('bot_mode') || 'local';
    
    webhookUrlInput.value = savedWebhookUrl;
    botModeSelect.value = savedBotMode;

    // =========================================================================
    // SISTEMA DE MENÚ CONTEXTUAL PROACTIVO
    // =========================================================================
    
    let contextoActual = 'inicio';
    let esperandoRespuesta = false;
    
    const consultasCategorias = {
        inicio: {
            mensaje: "¡Hola! 👋 Soy el **Gestor de Inventario de TechLogistics**.\n\n¿Qué te gustaría consultar hoy?",
            opciones: [
                { texto: "� Agendar reunión rápida", accion: "agendar_reunion" },
                { texto: "🔍 Buscar un activo específico", accion: "buscar_activo" },
                { texto: "👤 Ver asignaciones de personas", accion: "ver_asignaciones" },
                { texto: "📍 Consultar por ubicación", accion: "consultar_ubicacion" },
                { texto: "🔧 Información de mantenimientos", accion: "ver_mantenimientos" },
                { texto: "📊 Ver disponibilidad de activos", accion: "ver_disponibilidad" },
                { texto: "💬 Hacer una pregunta libre", accion: "pregunta_libre" }
            ]
        },
        
        agendar_reunion: {
            mensaje: "Voy a ayudarte a agendar una reunión. Por favor completa los datos:",
            opciones: [
                { texto: "📝 Llenar formulario de agendamiento", accion: "form_agendar" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        buscar_activo: {
            mensaje: "Perfecto, puedo ayudarte a buscar un activo. ¿Qué información tienes?",
            opciones: [
                { texto: "📟 Tengo el código del activo (ej: ACT-001)", accion: "input", placeholder: "Escribe el código del activo (ej: ACT-001)..." },
                { texto: "🏷️ Sé la marca o modelo (ej: Dell, MacBook)", accion: "input", placeholder: "Escribe la marca o modelo..." },
                { texto: "🔢 Tengo el número de serie", accion: "input", placeholder: "Escribe el número de serie..." },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        ver_asignaciones: {
            mensaje: "¿De quién quieres ver las asignaciones de activos?",
            opciones: [
                { texto: "👤 Buscar por nombre de persona", accion: "input", placeholder: "Escribe el nombre de la persona..." },
                { texto: "🏢 Ver por departamento", accion: "departamentos" },
                { texto: "📋 Ver todas las asignaciones activas", query: "Muéstrame todas las asignaciones activas de activos" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        consultar_ubicacion: {
            mensaje: "¿Qué ubicación te interesa consultar?",
            opciones: [
                { texto: "🏢 Edificio A", query: "¿Qué activos hay en el Edificio A?" },
                { texto: "🏢 Edificio B", query: "¿Qué activos hay en el Edificio B?" },
                { texto: "📍 Buscar por piso o área específica", accion: "input", placeholder: "Escribe el piso o área (ej: Piso 2, Laboratorio 101)..." },
                { texto: "🗺️ Ver activos sin ubicación", query: "Muéstrame los activos sin ubicación asignada" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        ver_mantenimientos: {
            mensaje: "¿Qué información de mantenimiento necesitas?",
            opciones: [
                { texto: "⚠️ Activos con mantenimiento pendiente", query: "¿Qué activos necesitan mantenimiento próximamente?" },
                { texto: "🔧 Últimos mantenimientos realizados", query: "Muéstrame los últimos mantenimientos realizados" },
                { texto: "🔍 Buscar mantenimiento de un activo", accion: "input", placeholder: "Escribe el código del activo..." },
                { texto: "📅 Historial de mantenimientos", query: "Dame un resumen del historial de mantenimientos" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        ver_disponibilidad: {
            mensaje: "¿Qué tipo de activos necesitas ver?",
            opciones: [
                { texto: "✅ Activos disponibles en stock", query: "¿Qué activos están disponibles en stock?" },
                { texto: "🔴 Activos ocupados actualmente", query: "Muéstrame los activos ocupados" },
                { texto: "⚠️ Activos no disponibles", query: "¿Qué activos están marcados como no disponibles?" },
                { texto: "📊 Resumen general de disponibilidad", query: "Dame un resumen de la disponibilidad de todos los activos" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        departamentos: {
            mensaje: "Selecciona el departamento que quieres consultar:",
            opciones: [
                { texto: "💻 Tecnología", query: "Muéstrame los activos asignados al departamento de Tecnología" },
                { texto: "📊 Administración", query: "Muéstrame los activos asignados al departamento de Administración" },
                { texto: "🔬 Laboratorio", query: "Muéstrame los activos asignados al departamento de Laboratorio" },
                { texto: "👥 Recursos Humanos", query: "Muéstrame los activos asignados a Recursos Humanos" },
                { texto: "⬅️ Volver", accion: "ver_asignaciones" }
            ]
        },
        
        pregunta_libre: {
            mensaje: "¡Perfecto! Escribe tu pregunta libremente y haré mi mejor esfuerzo por ayudarte. 😊\n\nPuedes preguntarme sobre activos, ubicaciones, personas, mantenimientos, etc.",
            opciones: [
                { texto: "💡 Ver ejemplos de preguntas", accion: "ejemplos_preguntas" },
                { texto: "⬅️ Volver al menú principal", accion: "inicio" }
            ]
        },
        
        ejemplos_preguntas: {
            mensaje: "Aquí hay algunos ejemplos de preguntas que puedes hacerme:",
            opciones: [
                { texto: "¿Quién tiene el ACT-003?", query: "¿Quién tiene el ACT-003?" },
                { texto: "¿Cuándo fue el último mantenimiento del laptop Dell?", query: "¿Cuándo fue el último mantenimiento del laptop Dell?" },
                { texto: "¿Cuántos activos tiene Roberto?", query: "¿Cuántos activos tiene Roberto?" },
                { texto: "Equipos en el Piso 2", query: "¿Qué equipos hay en el Piso 2?" },
                { texto: "⬅️ Volver", accion: "pregunta_libre" }
            ]
        }
    };
    
    function mostrarOpciones(categoria) {
        contextoActual = categoria;
        const config = consultasCategorias[categoria];
        const suggestionsWrapper = document.getElementById('suggestions-wrapper');
        const suggestionsTitle = document.getElementById('suggestions-title');
        
        // Actualizar título
        suggestionsTitle.textContent = categoria === 'inicio' ? '💡 ¿Qué te gustaría consultar?' : '💡 Opciones disponibles:';
        
        suggestionsWrapper.innerHTML = '';
        
        config.opciones.forEach(opcion => {
            const button = document.createElement('button');
            button.className = 'text-left px-4 py-3 bg-gradient-to-r from-brand-50 to-white hover:from-brand-100 hover:to-brand-50 border-2 border-brand-200 hover:border-brand-400 rounded-lg transition-all duration-200 text-sm font-medium text-gray-700 hover:text-brand-700 shadow-sm hover:shadow-md transform hover:-translate-y-0.5';
            button.textContent = opcion.texto;
            
            button.onclick = () => {
                if (opcion.accion === 'form_agendar') {
                    // Abrir modal de agendamiento
                    abrirModalAgendar();
                } else if (opcion.accion === 'input') {
                    // Activar input con placeholder personalizado
                    activarInput(opcion.placeholder);
                } else if (opcion.query) {
                    // Enviar query predefinida
                    enviarMensajeContextual(opcion.query);
                } else if (opcion.accion) {
                    // Cambiar a otra categoría
                    const nuevoConfig = consultasCategorias[opcion.accion];
                    addMessage(nuevoConfig.mensaje, false);
                    setTimeout(() => mostrarOpciones(opcion.accion), 300);
                }
            };
            
            suggestionsWrapper.appendChild(button);
        });
    }
    
    function activarInput(placeholder) {
        messageInput.placeholder = placeholder;
        messageInput.focus();
        messageInput.classList.add('ring-2', 'ring-brand-500', 'border-brand-500');
        
        setTimeout(() => {
            messageInput.classList.remove('ring-2', 'ring-brand-500', 'border-brand-500');
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
        
        suggestionsTitle.textContent = '💬 ¿Necesitas algo más?';
        suggestionsWrapper.innerHTML = '';
        
        const opciones = [
            { texto: "🔄 Hacer otra consulta similar", accion: contextoActual },
            { texto: "🏠 Volver al menú principal", accion: "inicio" },
            { texto: "✍️ Escribir pregunta personalizada", accion: "input", placeholder: "Escribe tu pregunta..." }
        ];
        
        opciones.forEach(opcion => {
            const button = document.createElement('button');
            button.className = 'text-left px-4 py-3 bg-white hover:bg-brand-50 border border-gray-300 hover:border-brand-400 rounded-lg transition-all text-sm font-medium text-gray-600 hover:text-brand-700';
            button.textContent = opcion.texto;
            
            button.onclick = () => {
                if (opcion.accion === 'input') {
                    activarInput(opcion.placeholder);
                } else {
                    mostrarOpciones(opcion.accion);
                }
            };
            
            suggestionsWrapper.appendChild(button);
        });
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

    function updateConnectionStatus(isConnected, message = '') {
        const statusDot = connectionStatus.querySelector('.w-2');
        const statusText = connectionStatus.querySelector('.text-sm');
        
        if (isConnected) {
            statusDot.className = 'w-2 h-2 bg-green-400 rounded-full animate-pulse';
            statusText.textContent = message || 'Conectado';
        } else {
            statusDot.className = 'w-2 h-2 bg-red-400 rounded-full';
            statusText.textContent = message || 'Desconectado';
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

    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start space-x-3 ${isUser ? 'flex-row-reverse space-x-reverse' : ''}`;

        const timestamp = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});

        // Formatear el mensaje del bot
        const formattedMessage = isUser ? escapeHtml(message) : formatBotResponse(message);

        messageDiv.innerHTML = `
            <div class="w-8 h-8 ${isUser ? 'bg-brand-600' : 'bg-brand-100'} rounded-full flex items-center justify-center flex-shrink-0">
                ${isUser ? '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>' : '<svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>'}
            </div>
            <div class="flex-1">
                <div class="${isUser ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-800'} rounded-lg px-4 py-3 inline-block max-w-3xl">
                    <p class="leading-relaxed">${formattedMessage}</p>
                </div>
                <p class="text-xs text-gray-500 mt-1 ${isUser ? 'text-right' : ''}">${timestamp}</p>
            </div>
        `;

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'flex items-start space-x-3';
        typingDiv.innerHTML = '<div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path></svg></div><div class="flex-1"><div class="bg-gray-100 rounded-lg px-4 py-3 inline-block"><div class="typing-indicator flex space-x-1"><span class="w-2 h-2 bg-gray-500 rounded-full"></span><span class="w-2 h-2 bg-gray-500 rounded-full"></span><span class="w-2 h-2 bg-gray-500 rounded-full"></span></div></div></div>';
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

    async function sendMessage(message) {
        if (!message.trim()) return;

        const botMode = botModeSelect.value;

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
        const message = messageInput.value.trim();
        if (message) sendMessage(message);
    });

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

    messageInput.focus();
});
</script>
@endsection
