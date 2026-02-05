# 🤖 Queries SQL Optimizadas para n8n

Este documento contiene las consultas SQL que tu bot de n8n debe usar según la **intención** detectada en el mensaje del usuario.

## 📋 Estructura del Flujo en n8n

```
Webhook → Code (Clasificar Intención) → Switch (Rutear) → PostgreSQL (Query) → Code (Formatear Respuesta) → Respond to Webhook
```

---

## 1️⃣ Nodo CODE: Clasificar Intención

```javascript
// Clasificar la intención del usuario
const mensaje = $json.mensaje.toLowerCase();
let intencion = "general";
let parametros = {};

// DETECCIÓN DE PREGUNTAS SOBRE LA APP (PRIORIDAD ALTA)
if (
    mensaje.match(
        /cómo|como|dónde|donde|para qué|para que|puedo|función|usar|acceder|ver.*app|página|pagina|pantalla|botón|boton|sección|seccion|menú|menu|registro|crear|editar|agregar/i,
    )
) {
    // Subcategorías de ayuda de la app
    if (
        mensaje.match(
            /ver.*inventario|mostrar.*inventario|listado.*activos|todos.*activos/i,
        )
    ) {
        intencion = "ayuda_ver_inventario";
    } else if (
        mensaje.match(/registrar|crear|nuevo|agregar.*activo|alta.*activo/i)
    ) {
        intencion = "ayuda_crear_activo";
    } else if (mensaje.match(/asignar|asignación|asignacion/i)) {
        intencion = "ayuda_asignacion";
    } else if (
        mensaje.match(/mantenimiento.*registro|registrar.*mantenimiento/i)
    ) {
        intencion = "ayuda_mantenimiento";
    } else if (
        mensaje.match(/secciones|módulos|modulos|partes.*app|funciones.*app/i)
    ) {
        intencion = "ayuda_secciones_app";
    } else if (mensaje.match(/ubicación|ubicacion|edificio.*crear|piso/i)) {
        intencion = "ayuda_ubicaciones";
    } else if (mensaje.match(/persona.*crear|usuario.*crear|departamento/i)) {
        intencion = "ayuda_personas";
    } else if (
        mensaje.match(/reporte|auditoría|auditoria|inventario.*general/i)
    ) {
        intencion = "ayuda_reportes";
    } else {
        intencion = "ayuda_general_app";
    }

    return {
        mensaje: $json.mensaje,
        sessionId: $json.sessionId,
        intencion: intencion,
        parametros: parametros,
        tipo: "ayuda_app", // Marca que no necesita query SQL
        timestamp: new Date().toISOString(),
    };
}

// DETECCIÓN DE PREGUNTAS SOBRE DATOS (Query SQL necesaria)

// Detectar código de activo directo
const codigoMatch = mensaje.match(/\b(act-\d+|sn-[a-z]+-\d+)\b/i);
if (codigoMatch) {
    intencion = "buscar_codigo";
    parametros.codigo = codigoMatch[0].toUpperCase();
}

// Detectar búsqueda por persona
else if (mensaje.match(/quién|quien|tiene|asignado.*a|equipos.*de/i)) {
    intencion = "consultar_persona";
    // Intentar extraer nombre
    const nombreMatch = mensaje.match(
        /(?:tiene|de|a)\s+([A-Z][a-z]+(?:\s+[A-Z][a-z]+)?)/,
    );
    if (nombreMatch) parametros.nombre = nombreMatch[1];
}

// Detectar consulta de ubicación
else if (
    mensaje.match(/edificio|piso|ubicación|ubicacion|donde|dónde|hay.*en/i)
) {
    intencion = "consultar_ubicacion";
    const edificioMatch = mensaje.match(/edificio\s+([A-Z])/i);
    if (edificioMatch)
        parametros.edificio = "Edificio " + edificioMatch[1].toUpperCase();
    const pisoMatch = mensaje.match(/piso\s+(\d+)/i);
    if (pisoMatch) parametros.piso = pisoMatch[1];
}

// Detectar consulta de mantenimiento
else if (
    mensaje.match(
        /mantenimiento|reparación|reparacion|último.*mantenimiento|próximo.*mantenimiento/i,
    )
) {
    intencion = "consultar_mantenimiento";
}

// Detectar consulta de disponibilidad
else if (mensaje.match(/disponible|ocupado|stock|libre|situación|situacion/i)) {
    intencion = "consultar_disponibilidad";
    if (mensaje.match(/disponible/i)) parametros.estado = "DISPONIBLE EN STOCK";
    else if (mensaje.match(/ocupado/i)) parametros.estado = "OCUPADO";
    else if (mensaje.match(/no disponible/i))
        parametros.estado = "NO DISPONIBLE";
}

// Detectar búsqueda por marca/modelo
else if (mensaje.match(/buscar|laptop|dell|hp|macbook|apple|lenovo/i)) {
    intencion = "buscar_modelo";
}

// Detectar consulta de asignaciones
else if (mensaje.match(/asignaciones|todas.*las.*asignaciones/i)) {
    intencion = "ver_asignaciones";
}

// Detectar consulta de departamento
else if (
    mensaje.match(
        /departamento|tecnología|tecnologia|administración|administracion|laboratorio/i,
    )
) {
    intencion = "consultar_departamento";
}

return {
    mensaje: $json.mensaje,
    sessionId: $json.sessionId,
    intencion: intencion,
    parametros: parametros,
    tipo: "datos_inventario", // Marca que necesita query SQL
    timestamp: new Date().toISOString(),
};
```

---

## 2️⃣ Nodo SWITCH: Rutear según Intención

Configura el Switch con estas rutas:

| Ruta                                     | Condición                                            | Va a                           |
| ---------------------------------------- | ---------------------------------------------------- | ------------------------------ |
| **AYUDA DE LA APP** (Sin query SQL)      |
| 1                                        | `{{ $json.tipo }}` = `ayuda_app`                     | Code: Respuestas App           |
| **DATOS DEL INVENTARIO** (Con query SQL) |
| 2                                        | `{{ $json.intencion }}` = `buscar_codigo`            | Query: Buscar por Código       |
| 3                                        | `{{ $json.intencion }}` = `consultar_persona`        | Query: Buscar por Persona      |
| 4                                        | `{{ $json.intencion }}` = `consultar_ubicacion`      | Query: Buscar por Ubicación    |
| 4                                        | `{{ $json.intencion }}` = `consultar_mantenimiento`  | Query: Mantenimientos          |
| 5                                        | `{{ $json.intencion }}` = `consultar_disponibilidad` | Query: Disponibilidad          |
| 6                                        | `{{ $json.intencion }}` = `buscar_modelo`            | Query: Buscar por Marca/Modelo |
| 7                                        | `{{ $json.intencion }}` = `ver_asignaciones`         | Query: Todas las Asignaciones  |
| 8                                        | `{{ $json.intencion }}` = `consultar_departamento`   | Query: Por Departamento        |
| Fallback                                 | -                                                    | Query: Búsqueda General        |

---

## 2️⃣.1 Nodo CODE: Respuestas para Ayuda de la App

Este nodo responde preguntas sobre cómo usar la aplicación **SIN consultar la base de datos**.
Conéctalo a la salida 1 del Switch (cuando `tipo` = `ayuda_app`).

```javascript
// Respuestas predefinidas para ayuda con la app
const intencion = $json.intencion;
const baseUrl = "http://127.0.0.1:8000";

const respuestasApp = {
    ayuda_ver_inventario: `Para ver el inventario completo:

1. Ve a la sección **Activos** en el menú principal
2. Ahí verás el listado de todos los activos registrados
3. Puedes buscar, filtrar y ordenar

🔗 ${baseUrl}/activos`,

    ayuda_crear_activo: `Para registrar un nuevo activo:

1. Ve a **Activos** en el menú
2. Clic en "Nuevo Activo" (esquina superior derecha)
3. Llena el formulario con los datos del activo
4. Guarda los cambios

🔗 ${baseUrl}/activos`,

    ayuda_asignacion: `Para asignar un activo a una persona:

1. Ve a **Personas** → **Asignaciones**
2. Clic en "Nueva Asignación"
3. Selecciona el activo y la persona
4. Guarda

🔗 ${baseUrl}/asignaciones`,

    ayuda_mantenimiento: `Para registrar un mantenimiento:

1. Ve a **Mantenimiento** en el menú
2. Clic en "Nuevo Mantenimiento"
3. Selecciona el activo y completa los datos
4. Guarda el registro

🔗 ${baseUrl}/mantenimientos`,

    ayuda_secciones_app: `La aplicación tiene estas secciones:

📦 **Activos** - Gestión de equipos
🏢 **Ubicaciones** - Edificios, pisos y áreas
👥 **Personas** - Usuarios y asignaciones
🔧 **Mantenimiento** - Registro de reparaciones
📊 **Reportes** - Inventario y auditorías
🛒 **Compras** - Proveedores y adquisiciones
🤖 **Chat IA** - Asistente virtual (¡yo!)

Todas en el menú lateral izquierdo.`,

    ayuda_ubicaciones: `Para gestionar ubicaciones:

**Edificios** → ${baseUrl}/edificios
**Pisos** → ${baseUrl}/pisos
**Áreas** → ${baseUrl}/areas
**Ubicaciones Físicas** → ${baseUrl}/ubicaciones

Todo está en el menú **Ubicaciones**.`,

    ayuda_personas: `Para gestionar personas:

**Personas** → ${baseUrl}/personas
**Departamentos** → ${baseUrl}/departamentos
**Roles** → ${baseUrl}/roles
**Asignaciones** → ${baseUrl}/asignaciones

Todo en el menú **Personas**.`,

    ayuda_reportes: `Reportes disponibles:

📊 **Inventario** → ${baseUrl}/inventario
🔍 **Auditorías** → ${baseUrl}/auditorias
📦 **Movimientos** → ${baseUrl}/movimientos

Accede desde el menú **Reportes**.`,

    ayuda_general_app: `¿En qué te puedo ayudar con la app?

Puedo explicarte cómo:
• Ver el inventario
• Crear/editar activos
• Asignar equipos a personas
• Registrar mantenimientos
• Generar reportes

¿Qué necesitas?`,
};

// Retornar respuesta según la intención
const respuesta = respuestasApp[intencion] || respuestasApp.ayuda_general_app;

return {
    reply: respuesta,
    tipo: "ayuda_app",
    intencion: intencion,
};
```

**Nota:** Este nodo debe ir directo al nodo "Respond to Webhook" sin pasar por PostgreSQL ni AI Agent.

---

## 3️⃣ Queries SQL por Intención

### 🔍 Buscar por Código (buscar_codigo)

```sql
SELECT
    nombre_completo_activo,
    situacion_actual,
    responsable_nombre,
    responsable_departamento,
    ubicacion_completa,
    ultima_fecha_mantenimiento,
    valor_adquisicion,
    fecha_adquisicion
FROM vista_asistente_inventario
WHERE codigo_activo = '{{ $json.parametros.codigo }}'
   OR numero_serie ILIKE '%{{ $json.parametros.codigo }}%'
LIMIT 1;
```

**Respuesta formateada:**

```javascript
const activo = $input.first().json;

if (!activo || Object.keys(activo).length === 0) {
    return {
        reply: `No encontré ningún activo con el código **{{ $json.parametros.codigo }}**. ¿Podrías verificar el código?`,
    };
}

const respuesta = `
Encontré el activo:

**${activo.nombre_completo_activo}**

📊 **Situación:** ${activo.situacion_actual}
${activo.responsable_nombre !== "Sin asignar" ? `👤 **Responsable:** ${activo.responsable_nombre} (${activo.responsable_departamento})` : "👤 **Sin asignar actualmente**"}
📍 **Ubicación:** ${activo.ubicacion_completa}
${activo.ultima_fecha_mantenimiento ? `🔧 **Último mantenimiento:** ${new Date(activo.ultima_fecha_mantenimiento).toLocaleDateString("es-ES")}` : ""}
💰 **Valor:** $${activo.valor_adquisicion?.toFixed(2) || "N/A"}
📅 **Adquisición:** ${new Date(activo.fecha_adquisicion).toLocaleDateString("es-ES")}
`.trim();

return { reply: respuesta };
```

---

### 👤 Buscar por Persona (consultar_persona)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    situacion_actual,
    ubicacion_completa,
    fecha_asignacion,
    tipo_activo
FROM vista_asistente_inventario
WHERE responsable_nombre ILIKE '%{{ $json.mensaje }}%'
   OR responsable_nombre ILIKE '%{{ $json.parametros.nombre }}%'
ORDER BY fecha_asignacion DESC;
```

**Respuesta formateada:**

```javascript
const activos = $input.all();

if (activos.length === 0) {
    return {
        reply: `No encontré activos asignados con ese nombre. ¿Podrías ser más específico?`,
    };
}

const persona = activos[0].json.responsable_nombre || "la persona consultada";
let respuesta = `**${persona}** tiene ${activos.length} activo(s) asignado(s):\n\n`;

activos.forEach((item, index) => {
    const a = item.json;
    respuesta += `${index + 1}. **${a.nombre_completo_activo}** (${a.codigo_activo})\n`;
    respuesta += `   📊 ${a.situacion_actual}\n`;
    respuesta += `   📍 ${a.ubicacion_completa}\n`;
    respuesta += `   📅 Asignado desde: ${new Date(a.fecha_asignacion).toLocaleDateString("es-ES")}\n\n`;
});

return { reply: respuesta };
```

---

### 📍 Buscar por Ubicación (consultar_ubicacion)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    situacion_actual,
    responsable_nombre,
    piso,
    area
FROM vista_asistente_inventario
WHERE ubicacion_completa ILIKE '%{{ $json.mensaje }}%'
   ${$json.parametros.edificio ? `OR edificio = '${$json.parametros.edificio}'` : ''}
   ${$json.parametros.piso ? `OR piso = ${$json.parametros.piso}` : ''}
ORDER BY codigo_activo;
```

**Respuesta formateada:**

```javascript
const activos = $input.all();

if (activos.length === 0) {
    return {
        reply: `No encontré activos en esa ubicación. ¿La ubicación es correcta?`,
    };
}

const ubicacion = activos[0].json.edificio || "la ubicación consultada";
let respuesta = `Activos en **${ubicacion}** (${activos.length} encontrado(s)):\n\n`;

activos.forEach((item, index) => {
    const a = item.json;
    respuesta += `${index + 1}. ${a.codigo_activo} - ${a.nombre_completo_activo}\n`;
    respuesta += `   📊 ${a.situacion_actual}\n`;
    if (a.responsable_nombre !== "Sin asignar") {
        respuesta += `   👤 ${a.responsable_nombre}\n`;
    }
    respuesta += `   📍 Piso ${a.piso}, ${a.area}\n\n`;
});

return { reply: respuesta };
```

---

### 🔧 Consultar Mantenimientos (consultar_mantenimiento)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    ultima_fecha_mantenimiento,
    tipo_ultimo_mantenimiento,
    costo_ultimo_mantenimiento,
    responsable_nombre
FROM vista_asistente_inventario
WHERE ultima_fecha_mantenimiento IS NOT NULL
ORDER BY ultima_fecha_mantenimiento DESC
LIMIT 10;
```

**Para mantenimientos pendientes:**

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    responsable_nombre,
    ubicacion_completa,
    ultima_fecha_mantenimiento,
    situacion_actual
FROM vista_asistente_inventario
WHERE ultima_fecha_mantenimiento < CURRENT_DATE - INTERVAL '6 months'
   OR ultima_fecha_mantenimiento IS NULL
ORDER BY ultima_fecha_mantenimiento ASC NULLS LAST
LIMIT 15;
```

---

### ✅ Consultar Disponibilidad (consultar_disponibilidad)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    ubicacion_completa,
    categoria_activo,
    tipo_activo
FROM vista_asistente_inventario
WHERE situacion_actual = '{{ $json.parametros.estado || "DISPONIBLE EN STOCK" }}'
ORDER BY categoria_activo, tipo_activo;
```

**Respuesta para disponibles:**

```javascript
const activos = $input.all();

if (activos.length === 0) {
    return {
        reply: `No hay activos disponibles en este momento. Todos están asignados o en mantenimiento.`,
    };
}

let respuesta = `✅ **Activos disponibles en stock** (${activos.length}):\n\n`;

// Agrupar por categoría
const porCategoria = {};
activos.forEach((item) => {
    const a = item.json;
    const cat = a.categoria_activo || "Sin categoría";
    if (!porCategoria[cat]) porCategoria[cat] = [];
    porCategoria[cat].push(a);
});

Object.keys(porCategoria).forEach((cat) => {
    respuesta += `**${cat}:**\n`;
    porCategoria[cat].forEach((a) => {
        respuesta += `  • ${a.codigo_activo} - ${a.tipo_activo}\n`;
        respuesta += `    📍 ${a.ubicacion_completa}\n`;
    });
    respuesta += "\n";
});

return { reply: respuesta };
```

---

### 🏢 Consultar por Departamento (consultar_departamento)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    responsable_nombre,
    responsable_rol,
    situacion_actual,
    ubicacion_completa
FROM vista_asistente_inventario
WHERE responsable_departamento ILIKE '%{{ $json.mensaje }}%'
ORDER BY responsable_nombre;
```

---

### 🔎 Búsqueda General (fallback)

```sql
SELECT
    nombre_completo_activo,
    codigo_activo,
    situacion_actual,
    responsable_nombre,
    ubicacion_completa
FROM vista_asistente_inventario
WHERE nombre_completo_activo ILIKE '%{{ $json.mensaje }}%'
   OR codigo_activo ILIKE '%{{ $json.mensaje }}%'
   OR marca ILIKE '%{{ $json.mensaje }}%'
   OR modelo ILIKE '%{{ $json.mensaje }}%'
ORDER BY codigo_activo
LIMIT 10;
```

---

## 4️⃣ Resumen de Estadísticas

Query útil para responder "¿Cuántos activos hay?"

```sql
SELECT
    COUNT(*) as total_activos,
    COUNT(*) FILTER (WHERE situacion_actual = 'DISPONIBLE EN STOCK') as disponibles,
    COUNT(*) FILTER (WHERE situacion_actual = 'OCUPADO') as ocupados,
    COUNT(*) FILTER (WHERE situacion_actual = 'NO DISPONIBLE') as no_disponibles,
    COUNT(DISTINCT categoria_activo) as categorias,
    COUNT(DISTINCT edificio) as edificios
FROM vista_asistente_inventario;
```

---

## 🎯 Consejos para n8n

1. **Usa Cache**: Agrega un nodo **Cache** después de PostgreSQL para respuestas frecuentes
2. **Timeout**: Configura timeout de 30 segundos en queries
3. **Paginación**: Limita resultados con `LIMIT 20` para evitar respuestas muy largas
4. **Logs**: Guarda queries en un nodo **Spreadsheet File** para debugging
5. **Fallback**: Siempre ten un mensaje por defecto si no hay resultados

---

## 🚀 Próximos pasos

- ✅ Implementar detección de intención
- ✅ Crear queries SQL optimizadas
- ⏳ Agregar memoria de conversación (Simple Memory)
- ⏳ Implementar sugerencias contextuales desde n8n
- ⏳ Agregar análisis de sentimiento
