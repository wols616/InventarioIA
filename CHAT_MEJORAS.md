# Mejoras del Chat - Sistema de Inventario IA

## 🎉 Características Implementadas

### ✅ 1. Sistema de Sesiones Múltiples

- Cada chat tiene su propio `session_id` único por usuario
- Formato: `session_{userId}_{timestamp}_{random}`
- Cada usuario tiene sus propias sesiones separadas

### ✅ 2. Persistencia Completa del Historial

- Todo el historial se guarda en la base de datos
- Tablas: `chat_sessions` y `chat_messages`
- Al recargar la página, se recupera el último chat activo

### ✅ 3. Botón "Nuevo Chat"

- Crea una nueva sesión independiente
- Limpia el área de mensajes
- Genera automáticamente un nuevo `session_id`

### ✅ 4. Sidebar con Historial

- Muestra todos los chats previos del usuario
- Ordenados por última actividad
- Cada chat muestra su título y fecha de última actividad

### ✅ 5. Títulos Automáticos

- Se generan basados en el primer mensaje del usuario
- Limitados a 50 caracteres
- Se actualizan automáticamente

### ✅ 6. Eliminación de Chats

- Cada chat tiene un botón para eliminarlo
- Confirmación antes de eliminar
- Si eliminas el chat activo, se crea uno nuevo

### ✅ 7. Cambio entre Chats

- Click en cualquier chat del sidebar para cargarlo
- Se recuperan todos los mensajes de la sesión
- Marca visualmente el chat activo

## 📊 Estructura de Base de Datos

### Tabla: `chat_sessions`

```sql
- id (PK)
- user_id (FK -> users)
- session_id (unique)
- title (varchar)
- last_activity_at (timestamp)
- created_at
- updated_at
```

### Tabla: `chat_messages`

```sql
- id (PK)
- session_id (FK -> chat_sessions)
- role (enum: 'user', 'assistant')
- content (text)
- created_at
- updated_at
```

## 🎨 Interfaz de Usuario

### Layout Principal

```
┌─────────────────┬──────────────────────────────┐
│   Sidebar       │      Chat Principal          │
│                 │                              │
│  [Nuevo Chat]   │  Header (Título del Chat)   │
│                 │                              │
│  Chat 1         │  ┌─────────────────────┐    │
│  Chat 2  ✓      │  │   Mensajes          │    │
│  Chat 3         │  │                     │    │
│                 │  └─────────────────────┘    │
│                 │                              │
│  [Usuario]      │  [Input de mensaje] [Enviar]│
└─────────────────┴──────────────────────────────┘
```

## 🔧 Archivos Creados/Modificados

### Nuevos Archivos:

1. `database/migrations/2026_02_05_000000_create_chat_sessions_and_messages_tables.php`
2. `app/Models/ChatSession.php`
3. `app/Models/ChatMessage.php`

### Archivos Modificados:

1. `app/Http/Controllers/ChatController.php` - Métodos de gestión de sesiones
2. `routes/web.php` - Rutas para las nuevas funcionalidades
3. `resources/views/chat/index.blade.php` - Nueva interfaz con sidebar

## 🚀 Nuevas Rutas API

```php
// Gestión de sesiones
POST   /chat/sessions/create           -> Crear nueva sesión
GET    /chat/sessions                  -> Listar sesiones del usuario
GET    /chat/sessions/{id}/history     -> Obtener historial de una sesión
DELETE /chat/sessions/{id}             -> Eliminar una sesión

// Chat (modificadas para usar session_id)
POST   /chat/send                      -> Enviar mensaje (requiere session_id)
POST   /chat/test-bot                  -> Bot de prueba (requiere session_id)
```

## 💾 Funcionamiento del SessionId

### Generación

```javascript
// Formato: session_{userId}_{timestamp}_{random}
"session_1_1738713600_abc12345";
```

### Almacenamiento

- **Base de datos**: Tabla `chat_sessions`
- **LocalStorage**: `last_session_id` (para recuperar al recargar)

### Flujo de Uso

1. Usuario abre el chat → Se carga o crea una sesión
2. Usuario envía mensaje → Se guarda con `session_id`
3. Bot responde → Respuesta se guarda en la misma sesión
4. Usuario recarga página → Se recupera última sesión activa
5. Usuario crea nuevo chat → Se genera nuevo `session_id`

## 🔄 Persistencia del Historial

### Al Cargar la Página

```javascript
1. Cargar lista de sesiones del usuario
2. Buscar última sesión activa en localStorage
3. Si existe, cargar sus mensajes
4. Si no, crear nueva sesión
```

### Al Cambiar de Chat

```javascript
1. Hacer clic en chat del sidebar
2. Cargar mensajes de esa sesión
3. Actualizar título del chat
4. Guardar session_id en localStorage
```

## 🎯 Características Especiales

### Por Usuario

- Cada usuario solo ve sus propios chats
- SessionIds incluyen el `user_id`
- Aislamiento completo entre usuarios

### Recuperación Automática

- Al recargar, se carga el último chat usado
- Si falla, se crea uno nuevo automáticamente
- No se pierden mensajes

### Actualización en Tiempo Real

- Títulos se actualizan con el primer mensaje
- Lista de chats se reordena por actividad
- Indicador visual del chat activo

## 📝 Notas de Implementación

### Backend (Laravel)

- Validación de `session_id` requerido en envío de mensajes
- Relaciones Eloquent: User → ChatSessions → ChatMessages
- Soft deletes en cascada al eliminar sesiones

### Frontend (JavaScript)

- Manejo de estados con variables globales
- Async/await para todas las peticiones
- LocalStorage para persistencia entre recargas

### Seguridad

- CSRF tokens en todas las peticiones POST/DELETE
- Validación de pertenencia de sesión al usuario
- Escape de HTML en mensajes

## 🐛 Solución de Problemas

### El historial no se carga

- Verificar que las migraciones se ejecutaron
- Comprobar conexión a base de datos
- Revisar console del navegador

### SessionId duplicado

- Cada sesión tiene ID único generado con timestamp
- Probabilidad de colisión: ~1 en 1 billón

### No aparecen los chats en sidebar

- Verificar que el usuario está autenticado
- Comprobar que existen registros en `chat_sessions`
- Revisar respuesta de la ruta `/chat/sessions`

## 🎓 Cómo Usar

1. **Iniciar un nuevo chat**:
    - Click en botón "Nuevo Chat"
    - Se crea automáticamente una nueva sesión

2. **Enviar mensajes**:
    - Escribir en el input
    - Click en "Enviar" o presionar Enter
    - Mensajes se guardan automáticamente

3. **Ver chats anteriores**:
    - Lista visible en el sidebar izquierdo
    - Click en cualquier chat para abrirlo

4. **Eliminar un chat**:
    - Click en icono de basura del chat
    - Confirmar eliminación
    - Se eliminan todos los mensajes asociados

5. **Recargar página**:
    - El último chat activo se recupera automáticamente
    - Todo el historial está intacto

## ✨ Ventajas

- ✅ No se pierde historial al recargar
- ✅ Sesiones separadas por usuario
- ✅ Interfaz similar a ChatGPT
- ✅ Persistencia completa en BD
- ✅ Fácil cambio entre conversaciones
- ✅ Títulos descriptivos automáticos
- ✅ Compatible con n8n webhook

¡Disfruta de tu nuevo sistema de chat mejorado! 🚀
