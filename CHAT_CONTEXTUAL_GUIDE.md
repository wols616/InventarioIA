# 🎯 Sistema de Chat Contextual Proactivo - Guía Completa

## 📋 Resumen de Mejoras Implementadas

Hemos transformado el chat de un sistema reactivo simple a un **asistente proactivo inteligente** que guía al usuario a través de menús contextuales.

---

## 🆕 ¿Qué cambió?

### ANTES ❌

- Usuario tiene que adivinar qué preguntar
- Botones estáticos con preguntas fijas
- Sin contexto de conversación
- Usuario se pierde fácilmente

### AHORA ✅

- Bot guía al usuario con menús categorizados
- Opciones dinámicas según el contexto
- Sistema de navegación intuitivo
- Sugerencias contextuales después de cada respuesta
- Placeholders dinámicos para inputs específicos

---

## 🎨 Flujo de Usuario Mejorado

```
┌─────────────────────────────────────┐
│  Usuario entra al chat              │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  Bot: "¡Hola! ¿Qué te gustaría      │
│  consultar hoy?"                    │
│                                     │
│  [🔍 Buscar activo]                 │
│  [👤 Ver asignaciones]              │
│  [📍 Consultar ubicación]           │
│  [🔧 Mantenimientos]                │
│  [📊 Disponibilidad]                │
│  [💬 Pregunta libre]                │
└──────────────┬──────────────────────┘
               │
               ▼ (Usuario selecciona)
┌─────────────────────────────────────┐
│  Bot: "¿Qué información tienes?"    │
│                                     │
│  [📟 Tengo el código]               │
│  [🏷️ Sé la marca/modelo]           │
│  [🔢 Tengo número de serie]         │
│  [⬅️ Volver]                        │
└──────────────┬──────────────────────┘
               │
               ▼ (Usuario elige)
┌─────────────────────────────────────┐
│  Input activado con placeholder:    │
│  "Escribe el código del activo..."  │
└──────────────┬──────────────────────┘
               │
               ▼ (Usuario escribe ACT-001)
┌─────────────────────────────────────┐
│  Bot responde con información       │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  "¿Necesitas algo más?"             │
│                                     │
│  [🔄 Otra consulta similar]         │
│  [🏠 Menú principal]                │
│  [✍️ Pregunta personalizada]        │
└─────────────────────────────────────┘
```

---

## 🗂️ Categorías Implementadas

### 1️⃣ **Buscar Activo** 🔍

```
Opciones:
├── Tengo el código (ACT-XXX)
├── Sé la marca o modelo
├── Tengo el número de serie
└── Volver al menú principal
```

**Flujo:**

1. Usuario selecciona tipo de búsqueda
2. Input se activa con placeholder específico
3. Usuario escribe la información
4. Bot busca en n8n/database
5. Muestra opciones de continuación

---

### 2️⃣ **Ver Asignaciones** 👤

```
Opciones:
├── Buscar por nombre de persona
├── Ver por departamento
│   ├── Tecnología
│   ├── Administración
│   ├── Laboratorio
│   └── Recursos Humanos
├── Ver todas las asignaciones activas
└── Volver al menú principal
```

---

### 3️⃣ **Consultar Ubicación** 📍

```
Opciones:
├── Edificio A
├── Edificio B
├── Buscar por piso o área específica
├── Ver activos sin ubicación
└── Volver al menú principal
```

---

### 4️⃣ **Mantenimientos** 🔧

```
Opciones:
├── Activos con mantenimiento pendiente
├── Últimos mantenimientos realizados
├── Buscar mantenimiento de un activo
├── Historial de mantenimientos
└── Volver al menú principal
```

---

### 5️⃣ **Disponibilidad** 📊

```
Opciones:
├── Activos disponibles en stock ✅
├── Activos ocupados 🔴
├── Activos no disponibles ⚠️
├── Resumen general de disponibilidad
└── Volver al menú principal
```

---

### 6️⃣ **Pregunta Libre** 💬

```
Opciones:
├── Ver ejemplos de preguntas
│   ├── ¿Quién tiene el ACT-003?
│   ├── ¿Cuándo fue el último mantenimiento?
│   ├── ¿Cuántos activos tiene Roberto?
│   └── Equipos en el Piso 2
└── Volver al menú principal
```

---

## 💻 Código Implementado

### 1. Sistema de Categorías (JavaScript)

```javascript
const consultasCategorias = {
    inicio: {
        mensaje: "¡Hola! 👋 Soy el Gestor de Inventario...",
        opciones: [
            { texto: "🔍 Buscar un activo", accion: "buscar_activo" },
            // ... más opciones
        ],
    },

    buscar_activo: {
        mensaje: "¿Qué información tienes?",
        opciones: [
            {
                texto: "📟 Tengo el código",
                accion: "input",
                placeholder: "Escribe el código...",
            },
            {
                texto: "🏷️ Sé la marca",
                query: "buscar por marca",
            },
        ],
    },
};
```

### 2. Función de Navegación

```javascript
function mostrarOpciones(categoria) {
    contextoActual = categoria;
    const config = consultasCategorias[categoria];

    // Renderizar botones dinámicamente
    config.opciones.forEach((opcion) => {
        if (opcion.accion === "input") {
            activarInput(opcion.placeholder);
        } else if (opcion.query) {
            enviarMensajeContextual(opcion.query);
        } else if (opcion.accion) {
            mostrarOpciones(opcion.accion);
        }
    });
}
```

### 3. Opciones de Continuación

```javascript
function mostrarOpcionesContinuacion() {
    const opciones = [
        { texto: "🔄 Otra consulta similar", accion: contextoActual },
        { texto: "🏠 Menú principal", accion: "inicio" },
        { texto: "✍️ Pregunta personalizada", accion: "input" },
    ];

    // Renderizar opciones después de respuesta del bot
}
```

---

## 🎯 Ventajas del Sistema Contextual

### Para el Usuario 👤

- ✅ No necesita saber qué preguntar
- ✅ Navegación intuitiva tipo menú
- ✅ Siempre sabe qué opciones tiene disponibles
- ✅ Puede volver atrás fácilmente
- ✅ Placeholders ayudan con formato correcto

### Para el Bot 🤖

- ✅ Conversaciones más estructuradas
- ✅ Menos consultas ambiguas
- ✅ Mejor detección de intención
- ✅ Datos más limpios para procesar
- ✅ Mayor tasa de éxito en respuestas

### Para el Sistema 📊

- ✅ Menos carga en n8n (queries más específicas)
- ✅ Mejor experiencia de usuario
- ✅ Métricas más claras de uso
- ✅ Fácil agregar nuevas categorías
- ✅ Escalable y mantenible

---

## 🚀 Cómo Usar el Sistema

### Para el Usuario Final:

1. **Entra al chat** → http://127.0.0.1:8000/chat

2. **Ve el mensaje de bienvenida** con 6 categorías principales

3. **Selecciona una categoría** (ej: "🔍 Buscar activo")

4. **Elige el tipo de búsqueda** (ej: "📟 Tengo el código")

5. **El input se activa automáticamente** con un placeholder específico

6. **Escribe tu información** (ej: "ACT-001")

7. **Recibe la respuesta del bot**

8. **Elige qué hacer después:**
    - Consulta similar
    - Volver al menú
    - Pregunta personalizada

---

## 🔧 Configuración en n8n

### Paso 1: Recibir Mensaje

El webhook recibe:

```json
{
    "mensaje": "ACT-001",
    "sessionId": "session_1234567890_abc123"
}
```

### Paso 2: Clasificar Intención

Nodo Code detecta:

- Si es código de activo → `buscar_codigo`
- Si es nombre de persona → `consultar_persona`
- Si menciona ubicación → `consultar_ubicacion`
- Etc.

### Paso 3: Ejecutar Query SQL

Según la intención, ejecuta query específica en la vista:

```sql
SELECT * FROM vista_asistente_inventario
WHERE codigo_activo = 'ACT-001';
```

### Paso 4: Formatear Respuesta

Nodo Code formatea la respuesta legible:

```javascript
const respuesta = `
Encontré el activo:

**${activo.nombre_completo_activo}**

📊 Situación: ${activo.situacion_actual}
👤 Responsable: ${activo.responsable_nombre}
📍 Ubicación: ${activo.ubicacion_completa}
`;

return { reply: respuesta };
```

### Paso 5: Responder

El bot envía:

```json
{
    "reply": "Encontré el activo: Dell Latitude 5420..."
}
```

---

## 📈 Métricas de Éxito

Puedes medir:

- **Tasa de navegación**: ¿Los usuarios usan los menús?
- **Categorías más usadas**: ¿Qué consultan más?
- **Tasa de éxito**: ¿Encuentran lo que buscan?
- **Tiempo de resolución**: ¿Cuánto tardan?
- **Uso de "Volver"**: ¿Se pierden en el menú?

---

## 🎨 Personalización

### Agregar Nueva Categoría

```javascript
// En consultasCategorias
nueva_categoria: {
    mensaje: "Mensaje al entrar a esta categoría",
    opciones: [
        { texto: "Opción 1", query: "query predefinida" },
        { texto: "Opción 2", accion: "otra_categoria" },
        { texto: "Buscar", accion: "input", placeholder: "..." },
        { texto: "⬅️ Volver", accion: "inicio" }
    ]
}
```

### Modificar Estilos de Botones

```javascript
button.className = "px-4 py-3 bg-gradient-to-r from-brand-50...";
```

### Cambiar Timeout de Continuación

```javascript
setTimeout(() => {
    mostrarOpcionesContinuacion();
}, 800); // Cambiar 800ms aquí
```

---

## 🐛 Debugging

### Ver contexto actual:

```javascript
console.log("Contexto actual:", contextoActual);
```

### Ver opciones renderizadas:

```javascript
console.log("Opciones:", consultasCategorias[contextoActual]);
```

### Ver mensaje del usuario:

```javascript
console.log("Mensaje:", messageInput.value);
```

---

## ✨ Próximas Mejoras

- [ ] Agregar breadcrumbs de navegación
- [ ] Implementar historial de búsquedas
- [ ] Agregar favoritos/búsquedas frecuentes
- [ ] Implementar búsqueda por voz
- [ ] Agregar sugerencias inteligentes basadas en historial
- [ ] Multi-idioma (ES/EN)
- [ ] Modo oscuro
- [ ] Exportar conversación a PDF

---

## 🎉 ¡Listo para usar!

Tu chat ahora es un **asistente proactivo inteligente** que:
✅ Guía a los usuarios paso a paso
✅ Reduce la fricción en las consultas
✅ Mejora la experiencia de usuario
✅ Facilita el mantenimiento del sistema
✅ Es fácilmente extensible

Recarga el chat en http://127.0.0.1:8000/chat y prueba el nuevo flujo!
