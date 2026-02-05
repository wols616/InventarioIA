# 🔧 Guía de Configuración del Webhook de n8n

## ✅ Ahora tienes 2 opciones:

### Opción 1: Bot Local (Prueba Inmediata) ⚡

Ya está listo para usar. Solo recarga la página y selecciona "Bot Local (Prueba)" en el dropdown.

### Opción 2: Conectar con n8n (Producción) 🤖

## Pasos para configurar n8n:

### 1. Asegúrate de que n8n esté corriendo

```bash
# Si usas n8n localmente
n8n start

# O si usas Docker
docker run -it --rm --name n8n -p 5678:5678 n8nio/n8n
```

Verifica que puedas acceder a: **http://localhost:5678**

### 2. Crear un Workflow en n8n

1. Abre n8n en http://localhost:5678
2. Crea un nuevo workflow
3. Agrega un nodo **Webhook**

### 3. Configurar el nodo Webhook

**Configuración del Webhook:**

```
HTTP Method: POST
Path: asistente (o el nombre que prefieras)
Authentication: None (para desarrollo local)
Response Mode: Immediately
Response Data: First Entrant
```

**Importante:**

- Copia la **Webhook URL** que te muestra (ej: `http://localhost:5678/webhook-test/asistente`)
- Asegúrate de hacer clic en "Listen for Test Event" o activar el workflow

### 4. Procesar el mensaje (Ejemplo básico)

Agrega los siguientes nodos después del Webhook:

#### Nodo 2: Function (Procesar mensaje)

```javascript
// Extraer el mensaje del usuario
const userMessage = $json.body.message;

// Aquí puedes agregar tu lógica
let response = "";

if (userMessage.toLowerCase().includes("hola")) {
    response = "¡Hola! ¿En qué puedo ayudarte?";
} else if (userMessage.toLowerCase().includes("activos")) {
    response = "Puedo ayudarte con información sobre activos del inventario.";
} else {
    response = `Has dicho: "${userMessage}". ¿En qué más puedo ayudarte?`;
}

return {
    json: {
        response: response,
    },
};
```

#### Nodo 3: Respond to Webhook

```
Response Mode: Immediately
Response Data: JSON
Response Body:
{
  "response": "={{ $json.response }}"
}
```

### 5. Activar el Workflow

1. Guarda el workflow
2. Activa el workflow (toggle en la esquina superior derecha)
3. El webhook ahora está listo para recibir peticiones

### 6. Probar en la aplicación

1. En tu chat, selecciona **"n8n Webhook"**
2. Pega la URL del webhook: `http://localhost:5678/webhook-test/asistente`
3. Haz clic en **"Probar Conexión"**
4. Si ves ✅ "Conexión exitosa", ¡estás listo!

## 🔍 Solución de Problemas

### Error 404: Webhook not found

**Causas:**

- El workflow no está activado
- La URL del webhook es incorrecta
- n8n no está corriendo

**Solución:**

```bash
# Verifica que n8n esté corriendo
curl http://localhost:5678

# Verifica tu webhook específico
curl -X POST http://localhost:5678/webhook-test/asistente \
  -H "Content-Type: application/json" \
  -d '{"message": "test"}'
```

### Error de CORS

Si tienes problemas de CORS, agrega esto en tu configuración de n8n:

```env
N8N_CUSTOM_CORS_ORIGINS=http://localhost:8000,http://127.0.0.1:8000
```

### El bot no responde

1. Revisa los logs de n8n
2. Verifica que el nodo "Respond to Webhook" esté correctamente configurado
3. Asegúrate de que la respuesta tenga el campo `response`

## 📊 Estructura de Datos

### Lo que el chat envía:

```json
{
    "message": "mensaje del usuario",
    "timestamp": "2026-02-02T12:00:00Z"
}
```

### Lo que n8n debe responder:

```json
{
    "response": "respuesta del bot"
}
```

## 💡 Ejemplo Completo de Workflow

```
[Webhook] → [Function: Analizar Mensaje] → [IF: Tipo de Pregunta]
                                              ├→ [HTTP Request: Consultar BD]
                                              └→ [Set: Respuesta Simple]
                                                    ↓
                                            [Respond to Webhook]
```

## 🚀 Mejoras Avanzadas

Una vez que funcione básicamente, puedes:

1. **Conectar con la BD del inventario** usando HTTP Request nodes
2. **Integrar IA** (OpenAI, Claude, etc.) para respuestas inteligentes
3. **Agregar contexto** guardando historial de conversación
4. **Buscar en la base de datos** usando PostgreSQL nodes
5. **Formatear respuestas** con HTML o Markdown

## 📝 Notas

- Para desarrollo usa `http://localhost:5678`
- Para producción necesitarás configurar n8n en un servidor
- Recuerda activar el workflow después de crearlo
- Usa el modo "Bot Local" mientras configuras n8n
