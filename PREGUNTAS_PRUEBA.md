# 📋 Preguntas de Prueba - Asistente de Inventario

Este documento contiene preguntas de prueba organizadas por categorías para validar el funcionamiento completo del chatbot de inventario.

---

## 🎯 1. BÚSQUEDA DE ACTIVOS POR CÓDIGO

### Preguntas para probar:

- `¿Cuál es el estado del activo ACT-001?`
- `Busca el activo con código ACT-123`
- `Dame información del activo SN-LAB-456`
- `¿Dónde está el activo ACT-789?`
- `Necesito saber quién tiene el activo ACT-100`

### Respuesta esperada:

- Código del activo
- Nombre/descripción completa
- Estado actual (OPERATIVO, EN MANTENIMIENTO, etc.)
- Ubicación física (Edificio, Piso, Área)
- Responsable asignado (si aplica)
- Fecha de última asignación/mantenimiento

---

## 👤 2. CONSULTAS SOBRE PERSONAS/RESPONSABLES

### Preguntas para probar:

- `¿Qué activos tiene asignados María García?`
- `¿Cuántos equipos tiene Juan Pérez?`
- `Muéstrame todos los activos de Carlos Rodríguez`
- `¿Quién es el responsable del laboratorio de computación?`
- `Lista de activos asignados a Ana López`

### Respuesta esperada:

- Nombre completo de la persona
- Lista de activos asignados con sus códigos
- Estado de cada activo
- Ubicación de los activos
- Fechas de asignación

---

## 📍 3. CONSULTAS SOBRE UBICACIONES

### Preguntas para probar:

- `¿Qué activos hay en el Edificio A?`
- `Lista todos los equipos del Piso 3`
- `¿Cuántos activos están en el Laboratorio de Computación?`
- `Muéstrame el inventario del Decanato de Ingeniería`
- `¿Qué hay en la Facultad de Ciencias?`
- `Activos ubicados en Sala 301`

### Respuesta esperada:

- Ubicación completa (Edificio/Piso/Área)
- Lista de activos en esa ubicación
- Códigos y nombres de activos
- Estado de cada activo
- Responsables (si están asignados)
- Total de activos en esa ubicación

---

## 🔧 4. CONSULTAS DE MANTENIMIENTO

### Preguntas para probar:

- `¿Cuándo fue el último mantenimiento del activo ACT-001?`
- `¿Qué activos necesitan mantenimiento?`
- `Lista de mantenimientos programados`
- `¿Qué activos están en mantenimiento actualmente?`
- `Historial de mantenimiento del activo ACT-123`
- `¿Cuándo es el próximo mantenimiento del equipo ACT-456?`

### Respuesta esperada:

- Código del activo
- Fecha del último mantenimiento
- Tipo de mantenimiento (preventivo/correctivo)
- Descripción del trabajo realizado
- Técnico responsable
- Próxima fecha programada (si aplica)
- Costo del mantenimiento

---

## ✅ 5. DISPONIBILIDAD DE ACTIVOS

### Preguntas para probar:

- `¿Qué laptops están disponibles?`
- `Muéstrame proyectores disponibles`
- `¿Hay computadoras sin asignar?`
- `Lista de activos disponibles en el Edificio B`
- `¿Qué equipos puedo solicitar?`
- `Activos DISPONIBLES del tipo Laptop`

### Respuesta esperada:

- Lista de activos disponibles
- Códigos y nombres
- Ubicación actual
- Estado DISPONIBLE
- Categoría/tipo de activo
- Cantidad total disponible

---

## ❓ 6. PREGUNTAS LIBRES / EXPLORATORIAS

### Preguntas para probar:

- `¿Cuántos activos hay en total?`
- `¿Cuáles son los tipos de activos que tenemos?`
- `Resumen del inventario`
- `¿Qué activos fueron comprados en 2025?`
- `¿Cuántos activos están operativos?`
- `Estadísticas del inventario`
- `¿Qué categorías de activos manejamos?`

### Respuesta esperada:

- Información consolidada
- Números/estadísticas
- Listas agrupadas
- Resúmenes claros y concisos

---

## 🔍 7. AUDITORÍAS E INVENTARIOS

### Preguntas para probar:

- `¿Cuándo fue la última auditoría?`
- `¿Qué activos se auditaron en enero 2026?`
- `Resultados de la última auditoría`
- `¿Hay activos con faltantes?`
- `Lista de activos con observaciones en auditoría`

### Respuesta esperada:

- Fecha de auditoría
- Activos auditados
- Estado de cada activo (ENCONTRADO, FALTANTE, DAÑADO)
- Observaciones
- Responsable de la auditoría

---

## 🛒 8. COMPRAS Y PROVEEDORES

### Preguntas para probar:

- `¿Qué activos se compraron el último mes?`
- `¿Cuál es el proveedor del activo ACT-001?`
- `Lista de compras del año 2025`
- `¿Qué proveedor nos vende laptops?`
- `Costo total de compras en 2025`

### Respuesta esperada:

- Detalles de compra
- Proveedor
- Fecha de compra
- Costo total
- Lista de activos comprados
- Número de factura

---

## 🧭 9. AYUDA SOBRE LA APLICACIÓN (APP HELP)

### Preguntas para probar:

- `¿Cómo veo el inventario en la app?`
- `¿Cómo creo un nuevo activo?`
- `¿Dónde asigno un equipo a una persona?`
- `¿Cómo programo un mantenimiento?`
- `¿Dónde veo los reportes?`
- `¿Qué secciones tiene la aplicación?`
- `¿Cómo hago una auditoría?`
- `¿Dónde registro una compra?`

### Respuesta esperada:

- Pasos numerados claros (1, 2, 3...)
- URL directa a la sección (🔗 http://...)
- Instrucciones concisas
- Formato visual mejorado con:
    - Contenedores con degradado
    - Badges numerados circulares
    - Botones para URLs con hover effect
    - Secciones con emoji

---

## 🧪 10. CASOS DE PRUEBA COMBINADOS

### Preguntas para probar:

- `¿Qué activos DISPONIBLES hay en el Edificio A Piso 2?`
- `Muéstrame laptops OPERATIVAS asignadas a profesores`
- `¿Qué equipos del Laboratorio de Química necesitan mantenimiento?`
- `Lista de activos comprados en 2025 que están en el Decanato`
- `¿Qué proyectores están DISPONIBLES para préstamo?`

### Respuesta esperada:

- Respuestas que combinen múltiples filtros
- Datos precisos y relevantes
- Formato claro con badges y colores

---

## 📊 11. VALIDACIÓN DE RESPUESTAS PROGRESIVAS

### Nivel 1 (Conciso - 1-2 líneas):

**Pregunta:** `¿Está disponible el activo ACT-001?`
**Respuesta esperada:** `Sí, el activo ACT-001 (Laptop Dell Latitude) está DISPONIBLE en Edificio A, Piso 2.`

### Nivel 2 (Contexto estándar):

**Pregunta:** `¿Qué equipos tiene María García?`
**Respuesta esperada:**

```
María García tiene 3 activos asignados:
• ACT-100 - Laptop HP - Edificio A, Piso 3 - OPERATIVO
• ACT-101 - Proyector Epson - Sala 301 - OPERATIVO
• ACT-102 - Mouse Inalámbrico - Edificio A, Piso 3 - OPERATIVO
```

### Nivel 3 (Detallado completo):

**Pregunta:** `Dame todos los detalles del activo ACT-001`
**Respuesta esperada:**

```
📦 ACTIVO: ACT-001
Nombre: Laptop Dell Latitude 5520
Tipo: Laptop | Categoría: Equipos de Cómputo
Estado: OPERATIVO
Ubicación: Edificio A, Piso 2, Laboratorio 201
Responsable: 👤 Juan Pérez (Docente)
Fecha de asignación: 15/01/2026
Proveedor: Dell Technologies
Fecha de compra: 10/12/2025
Costo: $1,200.00
Último mantenimiento: 📅 05/01/2026 (Mantenimiento Preventivo)
Observaciones: Equipo en excelente estado
```

---

## 🎨 12. VALIDACIÓN DE FORMATO VISUAL

### Para respuestas de DATOS (con base de datos):

**Elementos esperados:**

- ✅ Códigos con badge azul: `ACT-001`
- ✅ Estados con colores: `DISPONIBLE` (verde), `OCUPADO` (amarillo)
- ✅ Ubicaciones en morado: `Edificio A`
- ✅ Nombres con emoji: `👤 María García`
- ✅ Fechas con emoji: `📅 15/01/2026`

### Para respuestas de AYUDA (sin base de datos):

**Elementos esperados:**

- ✅ Pasos con contenedor degradado y badge circular numerado
- ✅ URLs como botones con gradiente e ícono
- ✅ Secciones con emoji en badge
- ✅ Bullets con borde y hover effect

---

## ⚡ 13. PRUEBAS DE RENDIMIENTO

### Comparación de tiempos:

**Preguntas de AYUDA (sin DB):**

- `¿Cómo veo el inventario?`
- `¿Dónde creo un activo?`
- **Tiempo esperado:** < 1 segundo (respuesta predefinida)

**Preguntas de DATOS (con DB):**

- `¿Qué activos hay en el Edificio A?`
- `¿Cuántos equipos tiene Juan Pérez?`
- **Tiempo esperado:** 2-5 segundos (consulta SQL + AI)

---

## 🔄 14. FLUJO COMPLETO DE MENÚ CONTEXTUAL

### Secuencia de prueba:

1. Usuario hace clic en **"Buscar activo por código"**
2. Bot muestra opciones: ACT-001, ACT-002, ACT-003, "Otro código"
3. Usuario selecciona ACT-001
4. Bot responde con información del activo
5. Bot muestra opciones de continuación:
    - Ver mantenimientos de este activo
    - Ver historial de asignaciones
    - Buscar otro activo
    - Volver al menú principal

---

## ✨ 15. CASOS EXTREMOS

### Preguntas para validar manejo de errores:

- `¿Dónde está el activo ACT-9999?` (código inexistente)
- `Muéstrame equipos de Pedro Inexistente` (persona no registrada)
- `¿Qué hay en el Edificio Z?` (ubicación inexistente)
- `asdfghjkl` (texto sin sentido)
- `¿Cuánto cuesta un café?` (pregunta fuera de contexto)

### Respuesta esperada:

- Mensaje amable indicando que no se encontraron resultados
- Sugerencia de cómo hacer la pregunta correctamente
- Opciones de menú contextual para guiar al usuario

---

## 📝 CHECKLIST DE VALIDACIÓN

### Funcionalidad del Bot:

- [ ] Clasifica correctamente intenciones (ayuda_app vs datos_inventario)
- [ ] Responde preguntas de ayuda sin consultar DB (rápido)
- [ ] Responde preguntas de datos consultando DB correctamente
- [ ] Aplica niveles de respuesta progresivos (1, 2, 3)
- [ ] Maneja errores con mensajes amables

### Formato Visual:

- [ ] Códigos con badge azul en respuestas de datos
- [ ] Estados con colores correctos (verde, amarillo, rojo)
- [ ] Pasos numerados con contenedor degradado en ayuda
- [ ] URLs como botones elegantes en ayuda
- [ ] Emojis correctamente aplicados

### Menú Contextual:

- [ ] Muestra opciones según categoría seleccionada
- [ ] Botones clickables funcionan correctamente
- [ ] Opciones de continuación aparecen después de respuesta
- [ ] "Volver al menú" funciona correctamente

### Integración n8n:

- [ ] Webhook recibe mensajes correctamente
- [ ] Switch enruta según tipo de intención
- [ ] PostgreSQL se conecta y consulta correctamente
- [ ] AI Agent genera respuestas coherentes
- [ ] Respuesta llega al frontend formateada

---

## 🚀 COMANDOS DE PRUEBA CURL

### Probar webhook de n8n directamente:

```bash
# Pregunta de ayuda (debe ser rápida, sin DB)
curl -X POST http://localhost:5678/webhook/chat-inventario \
  -H "Content-Type: application/json" \
  -d '{"mensaje": "¿Cómo veo el inventario en la app?"}'

# Pregunta de datos (consulta DB)
curl -X POST http://localhost:5678/webhook/chat-inventario \
  -H "Content-Type: application/json" \
  -d '{"mensaje": "¿Qué activos hay en el Edificio A?"}'

# Búsqueda por código
curl -X POST http://localhost:5678/webhook/chat-inventario \
  -H "Content-Type: application/json" \
  -d '{"mensaje": "Dame información del activo ACT-001"}'
```

---

## 📖 INSTRUCCIONES DE USO

### Para probar localmente:

1. Asegúrate que Laravel está corriendo: `php artisan serve`
2. Abre http://127.0.0.1:8000/chat
3. Selecciona modo de bot (n8n o local)
4. Prueba cada categoría de preguntas de este documento
5. Valida que el formato visual sea correcto
6. Verifica tiempos de respuesta

### Para probar con n8n:

1. Configura el flujo según `FLUJO_N8N_COMPLETO.md`
2. Activa el workflow en n8n
3. Usa los comandos curl para probar directamente
4. O usa la interfaz web del chat
5. Monitorea logs en n8n para debug

---

## 🎯 MÉTRICAS DE ÉXITO

### Precisión de respuestas:

- ✅ 95%+ de consultas correctamente clasificadas
- ✅ 90%+ de respuestas con datos precisos
- ✅ 100% de URLs de ayuda funcionales

### Rendimiento:

- ✅ Ayuda: < 1 segundo
- ✅ Datos simples: < 3 segundos
- ✅ Datos complejos: < 5 segundos

### UX:

- ✅ Formato visual atractivo y legible
- ✅ Menú contextual intuitivo
- ✅ Opciones de continuación relevantes
- ✅ Errores manejados elegantemente

---

**Documento creado:** 2 de febrero de 2026  
**Última actualización:** 2 de febrero de 2026  
**Versión:** 1.0
