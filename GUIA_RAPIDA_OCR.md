# 🚀 Guía Rápida: Configurar OCR en el Chatbot

## ❌ Problema Común: Error 500

Si ves **"Error 500: Internal Server Error"** al intentar enviar una imagen, sigue estos pasos:

---

## 📋 Checklist de Solución

### ✅ Paso 1: Verificar n8n está corriendo

```bash
# Verifica que n8n esté activo
curl http://localhost:5678

# Deberías ver una respuesta HTML
```

Si no responde, inicia n8n:

```bash
n8n start
```

---

### ✅ Paso 2: Obtener la URL correcta del Webhook

1. **Abre n8n** en tu navegador: `http://localhost:5678`

2. **Busca el workflow "Imagenes"** (o el nombre de tu workflow de OCR)

3. **Abre el workflow** haciendo clic en él

4. **Busca el nodo "Webhook"** (generalmente el primer nodo)

5. **Copia la URL del Webhook**:
    - Haz clic en el nodo Webhook
    - Busca el campo **"Webhook URL"** o **"Production URL"**
    - Debería verse algo como: `http://localhost:5678/webhook/XXXXX`
    - **Copia esa URL completa**

#### 📸 Ejemplo Visual:

```
Nodo Webhook:
┌─────────────────────────────────┐
│  Webhook                        │
│                                 │
│  Webhook URL:                   │
│  http://localhost:5678/webhook/ │
│  abc123-def456-ghi789          │  ← COPIA ESTO
│                                 │
│  HTTP Method: POST              │
│  Path: /                        │
└─────────────────────────────────┘
```

---

### ✅ Paso 3: Verificar que el Workflow esté Publicado

**IMPORTANTE:** Los webhooks solo funcionan cuando el workflow está **activo/publicado**.

1. En n8n, mira la esquina superior derecha del workflow
2. Verifica que el interruptor diga **"Active"** o **"Activo"** (color verde)
3. Si dice "Inactive", haz clic para activarlo

```
┌──────────────────────┐
│  ● Active            │  ← Debe estar verde/activo
└──────────────────────┘
```

---

### ✅ Paso 4: Configurar la URL en el Chatbot

1. **Abre tu chatbot** en el navegador
2. **Busca la sección de configuración** (parte superior)
3. **Pega la URL** en el campo **"OCR URL"**
4. **Haz clic en "Probar OCR"**

Si todo está correcto, deberías ver un mensaje de éxito ✅

---

### ✅ Paso 5: Verificar la Configuración del Webhook en n8n

El nodo Webhook debe tener esta configuración:

```yaml
HTTP Method: POST
Path: / (o el path que prefieras)
Response Mode: When Last Node Finishes
Response Code: 200
Response Data: First Entry JSON
```

**Campos que debe recibir:**

- Campo de imagen: `Imagen` (exactamente con mayúscula inicial)
- Otros campos opcionales: `sessionId`, `test`, etc.

---

## 🔧 Solución de Problemas

### Error 500: Internal Server Error

**Causas posibles:**

1. **❌ Workflow no está activo**
    - Solución: Activa el workflow en n8n

2. **❌ Error en el procesamiento dentro de n8n**
    - Solución: Abre n8n y ejecuta el workflow manualmente
    - Revisa los logs de n8n para ver el error específico

3. **❌ Nodo de procesamiento falla**
    - Solución: Verifica que todos los nodos del workflow funcionen
    - Prueba ejecutar cada nodo individualmente

4. **❌ Campo "Imagen" no se recibe correctamente**
    - Solución: Verifica que el nodo Webhook esté configurado para `multipart/form-data`

### Error de conexión / Failed to fetch

**Causas posibles:**

1. **❌ n8n no está corriendo**
    - Solución: `n8n start`

2. **❌ URL incorrecta**
    - Solución: Verifica la URL en n8n y cópiala exactamente

3. **❌ Puerto incorrecto**
    - Solución: Verifica que n8n esté en el puerto 5678

### El webhook no responde

**Causas posibles:**

1. **❌ Workflow inactivo**
    - Solución: Activa el workflow

2. **❌ Path incorrecto**
    - Solución: Verifica que la URL coincida con la configurada en n8n

---

## 🧪 Prueba Manual con cURL

Para verificar que el webhook funciona independientemente del chatbot:

```bash
# Crear una imagen de prueba
echo "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==" | base64 -d > test.png

# Enviar a n8n (REEMPLAZA LA URL CON LA TUYA)
curl -X POST http://localhost:5678/webhook/TU-WEBHOOK-ID \
  -F "Imagen=@test.png" \
  -v

# Deberías ver una respuesta JSON (no un error 500)
```

---

## 📊 Debugging Avanzado

### Ver logs en el navegador

1. Abre las **DevTools** del navegador (F12)
2. Ve a la pestaña **Console**
3. Intenta enviar una imagen
4. Busca los mensajes que empiezan con:
    - `📤 Enviando imagen para OCR...`
    - `📥 Respuesta recibida:`
    - `📄 Contenido de respuesta:`

### Ver logs en n8n

1. Abre n8n
2. Ve al workflow de "Imagenes"
3. Haz clic en **"Executions"** (ejecuciones)
4. Busca la última ejecución fallida
5. Revisa qué nodo falló y por qué

---

## ✅ Configuración Correcta Final

Una vez configurado correctamente, deberías tener:

```
Chatbot:
┌─────────────────────────────────────────┐
│ OCR URL: http://localhost:5678/webhook/ │
│          abc123-def456-ghi789           │
│ [Probar OCR] ← Click aquí primero       │
└─────────────────────────────────────────┘
```

n8n:

```
Workflow "Imagenes": ● Active
Webhook URL: http://localhost:5678/webhook/abc123-def456-ghi789
HTTP Method: POST
Campo imagen: "Imagen"
```

---

## 🎯 Flujo Completo de Trabajo

1. Usuario hace clic en 📎 (adjuntar imagen)
2. Selecciona una imagen
3. Ve la vista previa
4. Presiona "Enviar"
5. **JavaScript:**
    - Crea FormData
    - Agrega la imagen con clave "Imagen"
    - POST a `http://localhost:5678/webhook/...`
6. **n8n recibe:**
    - Webhook recibe el archivo
    - Procesa la imagen (OCR u otro procesamiento)
    - Devuelve JSON con el resultado
7. **Chatbot muestra:**
    - Respuesta del servidor
    - Texto extraído o resultado del análisis

---

## 📞 ¿Aún no funciona?

Si después de todos estos pasos sigue sin funcionar:

1. **Copia y pega aquí:**
    - La URL exacta del webhook de n8n
    - El mensaje de error completo de la consola
    - Los logs de ejecución de n8n

2. **Verifica:**
    - ¿n8n está corriendo? ✓
    - ¿El workflow está activo? ✓
    - ¿La URL es correcta? ✓
    - ¿El botón "Probar OCR" funciona? ✓

3. **Prueba con el ejemplo cURL** para descartar problemas del chatbot

---

## 🔥 Tips Finales

- **Usa el botón "Probar OCR"** antes de enviar imágenes reales
- **Revisa siempre la consola del navegador** (F12) para mensajes de debug
- **Mantén n8n abierto** para ver las ejecuciones en tiempo real
- **Tamaño máximo de imagen:** 10MB (configurable)
- **Formatos soportados:** JPG, PNG, GIF, WebP (depende de tu configuración OCR)

---

¡Listo! Tu sistema OCR debería funcionar perfectamente ahora. 🎉
