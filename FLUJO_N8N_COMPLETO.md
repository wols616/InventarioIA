# 🎯 Diagrama del Flujo Mejorado en n8n

## 🔄 Flujo Completo con Ayuda de la App

```
┌─────────────────────┐
│   Webhook           │ ← Usuario envía mensaje
│ (Recibe mensaje)    │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│   Code Node         │
│ Clasificar Intención│
│                     │
│ Detecta si es:      │
│ • Ayuda de la app   │
│ • Datos inventario  │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│   Switch Node       │
│ Rutear por tipo     │
└───┬────────────┬────┘
    │            │
    │            └──────────────────────┐
    │                                   │
    ▼                                   ▼
┌─────────────────┐           ┌────────────────────┐
│ Ruta 1:         │           │ Ruta 2-9:          │
│ tipo=ayuda_app  │           │ Datos Inventario   │
└────────┬────────┘           └──────────┬─────────┘
         │                               │
         ▼                               ▼
┌─────────────────┐           ┌────────────────────┐
│ Code Node       │           │ PostgreSQL Node    │
│ Respuestas App  │           │ Query SQL          │
│ (Sin DB)        │           │                    │
│                 │           │ SELECT * FROM      │
│ Retorna:        │           │ vista_asistente... │
│ • URLs          │           └──────────┬─────────┘
│ • Pasos         │                      │
│ • Instrucciones │                      ▼
└────────┬────────┘           ┌────────────────────┐
         │                    │ AI Agent Node      │
         │                    │ (Con prompt)       │
         │                    │                    │
         │                    │ Formatea respuesta │
         │                    │ con los datos SQL  │
         │                    └──────────┬─────────┘
         │                               │
         └───────────┬───────────────────┘
                     │
                     ▼
         ┌───────────────────────┐
         │ Respond to Webhook    │
         │ (Envía respuesta)     │
         └───────────────────────┘
```

---

## 📊 Detalle de Cada Nodo

### 1️⃣ Webhook Node

```json
{
    "mensaje": "¿Cómo veo el inventario?",
    "sessionId": "session_123"
}
```

### 2️⃣ Code: Clasificar Intención

```javascript
Output para AYUDA APP:
{
  "mensaje": "¿Cómo veo el inventario?",
  "sessionId": "session_123",
  "intencion": "ayuda_ver_inventario",
  "parametros": {},
  "tipo": "ayuda_app"  ← KEY: Rutea sin DB
}

Output para DATOS:
{
  "mensaje": "¿Quién tiene la MacBook?",
  "sessionId": "session_123",
  "intencion": "consultar_persona",
  "parametros": {},
  "tipo": "datos_inventario"  ← KEY: Rutea a DB
}
```

### 3️⃣ Switch Node

**Configuración:**

- **Output 1** (Ayuda App): `{{ $json.tipo == "ayuda_app" }}`
- **Output 2-9** (Datos): Según `$json.intencion`
- **Fallback**: Búsqueda general

### 4️⃣a Code: Respuestas App (Output 1)

**Input:**

```json
{
    "intencion": "ayuda_ver_inventario",
    "tipo": "ayuda_app"
}
```

**Output:**

```json
{
    "reply": "Para ver el inventario completo:\n\n1. Ve a la sección **Activos**...",
    "tipo": "ayuda_app"
}
```

✅ **Va directo a Respond to Webhook** (sin pasar por DB ni AI)

### 4️⃣b PostgreSQL (Output 2-9)

**Input:**

```json
{
    "intencion": "consultar_persona",
    "tipo": "datos_inventario"
}
```

**Query SQL:**

```sql
SELECT * FROM vista_asistente_inventario
WHERE responsable_nombre ILIKE '%MacBook%'
```

**Output:**

```json
[
    {
        "nombre_completo_activo": "MacBook Pro M3",
        "responsable_nombre": "Ana Martínez",
        "ubicacion_completa": "Edificio A, Piso 2"
    }
]
```

### 5️⃣ AI Agent

**System Prompt:** (Ver PROMPT_N8N_MEJORADO.md)

**User Message:**

```
Pregunta: ¿Quién tiene la MacBook?
Datos: {{ JSON.stringify($json) }}
```

**Output:**

```json
{
    "reply": "La tiene Ana Martínez en el Edificio A, Piso 2."
}
```

### 6️⃣ Respond to Webhook

**Output Final:**

```json
{
    "reply": "La tiene Ana Martínez en el Edificio A, Piso 2."
}
```

---

## 🎯 Ejemplos de Flujo Completo

### Ejemplo 1: Pregunta sobre la App

```
Usuario: "¿Cómo registro un mantenimiento?"

→ Webhook recibe mensaje
→ Code clasifica: intencion="ayuda_mantenimiento", tipo="ayuda_app"
→ Switch rutea a Output 1
→ Code responde SIN consultar DB:
   "Para registrar un mantenimiento:
    1. Ve a **Mantenimiento**
    2. Clic en 'Nuevo Mantenimiento'
    🔗 http://127.0.0.1:8000/mantenimientos"
→ Respond to Webhook envía respuesta
```

**Tiempo:** ~100ms (sin DB, sin AI)

---

### Ejemplo 2: Pregunta sobre Datos

```
Usuario: "¿Quién tiene el ACT-003?"

→ Webhook recibe mensaje
→ Code clasifica: intencion="buscar_codigo", tipo="datos_inventario"
→ Switch rutea a Output 2
→ PostgreSQL ejecuta:
   SELECT * FROM vista_asistente_inventario
   WHERE codigo_activo = 'ACT-003'
→ AI Agent formatea con prompt:
   "Lo tiene Ana Martínez en el Edificio A, Piso 2."
→ Respond to Webhook envía respuesta
```

**Tiempo:** ~2-3s (con DB + AI)

---

### Ejemplo 3: Pregunta Mixta

```
Usuario: "¿Quién tiene la MacBook y cómo lo veo en la app?"

→ Webhook recibe mensaje
→ Code clasifica: intencion="consultar_persona", tipo="datos_inventario"
   (detecta nombre de activo, prioridad a datos)
→ Switch rutea a Output 3
→ PostgreSQL consulta datos de MacBook
→ AI Agent detecta "cómo lo veo en la app" en el prompt
   y agrega instrucciones:
   "La tiene Ana Martínez en el Edificio A.

    Para verlo en la app: Ve a **Activos** → Buscar 'MacBook'
    🔗 http://127.0.0.1:8000/activos"
→ Respond to Webhook envía respuesta
```

**Tiempo:** ~2-3s (con DB + AI inteligente)

---

## 🚀 Configuración Paso a Paso en n8n

### Paso 1: Webhook

1. Agrega nodo **Webhook**
2. Método: POST
3. Path: `/webhook-test/asistente`
4. Responde con: "Using 'Respond to Webhook' Node"

### Paso 2: Code - Clasificar Intención

1. Agrega nodo **Code**
2. Copia el código de `N8N_QUERIES.md` sección 1️⃣
3. Conecta desde Webhook

### Paso 3: Switch

1. Agrega nodo **Switch**
2. Mode: Rules
3. Regla 1: `{{ $json.tipo }}` equals `ayuda_app`
4. Regla 2: `{{ $json.intencion }}` equals `buscar_codigo`
5. Regla 3: `{{ $json.intencion }}` equals `consultar_persona`
6. ... (resto de intenciones)
7. Fallback: Búsqueda general

### Paso 4a: Code - Respuestas App

1. Agrega nodo **Code**
2. Copia el código de `N8N_QUERIES.md` sección 2️⃣.1
3. Conecta desde Switch Output 1
4. **Conecta DIRECTO a Respond to Webhook** (no pasa por DB ni AI)

### Paso 5b: PostgreSQL

1. Agrega nodo **Postgres**
2. Conecta desde Switch Output 2-9
3. Query según la intención (ver sección 3️⃣)

### Paso 6: AI Agent

1. Agrega nodo **AI Agent** o **Ollama/OpenAI**
2. System Message: Copia prompt de `PROMPT_N8N_MEJORADO.md`
3. User Message: `{{ $json.mensaje }}\n\nDatos: {{ JSON.stringify($input.all()) }}`
4. Conecta desde PostgreSQL

### Paso 7: Code - Formatear Output

1. Agrega nodo **Code**
2. Código:

```javascript
return {
    reply: $json.output || $json.reply || $json.text,
};
```

### Paso 8: Respond to Webhook

1. Agrega nodo **Respond to Webhook**
2. Responder con: Using Fields Below
3. Campo: `reply` = `{{ $json.reply }}`
4. Conecta desde:
    - Code Respuestas App (Output 1)
    - Code Formatear Output (Output 2-9)

---

## 📈 Ventajas del Flujo Mejorado

### ✅ Rendimiento

- Preguntas de app: **10x más rápido** (sin DB ni AI)
- Cache natural: Respuestas predefinidas
- Menos carga en el servidor

### ✅ Escalabilidad

- Fácil agregar nuevas respuestas de app
- Modificar URLs sin tocar el prompt
- Separación de concerns

### ✅ UX

- Respuestas instantáneas para navegación
- URLs directas a secciones
- Pasos claros y concisos

---

## 🔧 Testing del Flujo

### Test 1: Ayuda de App

```bash
curl -X POST http://localhost:5678/webhook-test/asistente \
  -H "Content-Type: application/json" \
  -d '{"mensaje":"¿Cómo veo el inventario?","sessionId":"test_123"}'
```

**Esperado:**

```json
{
    "reply": "Para ver el inventario completo:\n\n1. Ve a la sección **Activos**..."
}
```

### Test 2: Datos de Inventario

```bash
curl -X POST http://localhost:5678/webhook-test/asistente \
  -H "Content-Type: application/json" \
  -d '{"mensaje":"¿Quién tiene la MacBook?","sessionId":"test_123"}'
```

**Esperado:**

```json
{
    "reply": "La tiene Ana Martínez en el Edificio A, Piso 2."
}
```

### Test 3: Pregunta Mixta

```bash
curl -X POST http://localhost:5678/webhook-test/asistente \
  -H "Content-Type: application/json" \
  -d '{"mensaje":"¿Quién tiene el ACT-003 y cómo lo veo?","sessionId":"test_123"}'
```

**Esperado:**

```json
{
    "reply": "Lo tiene Ana Martínez...\n\nPara verlo en la app: **Activos** → Buscar ACT-003..."
}
```

---

## 🐛 Troubleshooting

### Problema: "Pregunta de app va a DB"

**Solución:** Verifica que la regex en Code incluya la palabra clave:

```javascript
if (mensaje.match(/cómo|como|dónde|donde|ver.*app/i)) {
```

### Problema: "Respuesta de app vacía"

**Solución:** Verifica que la intención tenga respuesta en `respuestasApp`:

```javascript
const respuesta = respuestasApp[intencion] || respuestasApp.ayuda_general_app;
```

### Problema: "URLs rotas"

**Solución:** Actualiza `baseUrl` en Code Respuestas App:

```javascript
const baseUrl = "http://TU_DOMINIO:8000";
```

---

## 🎉 Resultado Final

Con este flujo mejorado:

- ✅ Bot responde preguntas de navegación SIN consultar DB
- ✅ Respuestas instantáneas para ayuda de app
- ✅ Datos precisos para consultas de inventario
- ✅ URLs directas a secciones específicas
- ✅ Mejor experiencia de usuario
- ✅ Menos carga en servidores

**El bot es ahora un asistente completo: Datos + Navegación**
