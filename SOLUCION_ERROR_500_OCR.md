# 🚨 Solución al Error 500 en OCR

## ❌ Error: "Error 500: Internal Server Error"

Este error significa que **n8n está recibiendo tu petición**, pero algo **falla internamente** en el procesamiento del workflow.

---

## 🔍 Diagnóstico Paso a Paso

### **Paso 1: Verifica las Ejecuciones en n8n**

1. Abre n8n: `http://localhost:5678`
2. Busca tu workflow "Imagenes" (o el nombre que le hayas puesto)
3. Haz clic en el botón **"Executions"** (arriba a la derecha, junto a "Active")
4. Busca la última ejecución fallida (tendrá un ❌ rojo)
5. Haz clic en ella para ver los detalles

**¿Qué buscar?**

- ¿Qué nodo está fallando? (aparecerá en rojo)
- ¿Cuál es el mensaje de error?
- ¿Los datos están llegando correctamente al webhook?

---

### **Paso 2: Verifica el Nodo Webhook**

El nodo Webhook debe estar configurado así:

```yaml
HTTP Method: POST
Path: /
Response Mode: When Last Node Finishes
Response Code: 200
Response Data: First Entry JSON
```

**IMPORTANTE:**

- No debe tener autenticación configurada (o si la tiene, debe coincidir con lo que envías)
- El campo "Imagen" debe estar llegando correctamente

**Cómo verificar:**

1. Haz clic en el nodo Webhook
2. Ve a "Executions" del workflow
3. Abre la última ejecución
4. Haz clic en el nodo Webhook
5. Verifica que en "OUTPUT" aparezca el campo "Imagen" con datos binarios

---

### **Paso 3: Errores Comunes**

#### ❌ Error 1: Nodo OCR sin credenciales

Si usas un servicio OCR externo (Google Vision, Tesseract API, etc.):

**Síntoma:** El nodo de OCR falla con "invalid credentials" o "API key required"

**Solución:**

1. Ve a n8n → Credentials
2. Verifica que las credenciales del servicio OCR estén configuradas
3. Prueba las credenciales haciendo clic en "Test"
4. Si están vencidas o incorrectas, actualízalas

#### ❌ Error 2: Campo "Imagen" no se encuentra

**Síntoma:** Error como "field 'Imagen' not found" o similar

**Solución:**

1. Verifica que el nombre del campo sea exactamente `Imagen` (con mayúscula inicial)
2. En el nodo que procesa la imagen, asegúrate de usar la expresión correcta:
    ```
    {{ $binary.Imagen }}
    ```

#### ❌ Error 3: Formato de imagen no soportado

**Síntoma:** Error al procesar la imagen (corrupt image, invalid format, etc.)

**Solución:**

1. Verifica qué formatos acepta tu servicio OCR
2. Agrega un nodo de conversión de imagen si es necesario
3. Valida el tamaño de la imagen (algunos servicios tienen límites)

#### ❌ Error 4: Timeout en el procesamiento

**Síntoma:** La petición tarda mucho y falla

**Solución:**

1. Aumenta el timeout en el nodo HTTP Request (si usas uno)
2. Optimiza el procesamiento de la imagen (reducir tamaño, comprimir, etc.)
3. Verifica que el servicio OCR externo esté respondiendo

---

### **Paso 4: Prueba Manual del Workflow**

1. En n8n, abre el workflow "Imagenes"
2. Haz clic en el nodo Webhook
3. Haz clic en "Listen for Test Event" (o "Waiting for webhook call")
4. Desde tu chatbot, envía una imagen de prueba
5. Observa qué sucede en n8n en tiempo real

Esto te permitirá ver **exactamente** dónde falla el workflow.

---

### **Paso 5: Ejemplo de Workflow Correcto**

Aquí hay un ejemplo de workflow mínimo que funciona:

```
┌──────────┐    ┌─────────────┐    ┌──────────┐
│ Webhook  │───▶│ Move Binary │───▶│ Response │
│  (POST)  │    │  to JSON    │    │  (JSON)  │
└──────────┘    └─────────────┘    └──────────┘
```

**Configuración de cada nodo:**

**1. Webhook:**

- HTTP Method: POST
- Path: /
- Binary Property: Imagen

**2. Move Binary Data (opcional, si solo quieres confirmar que llega):**

- Mode: Binary to JSON
- Set All Data: true

**3. Respond to Webhook:**

- Response Data: JSON
- Response JSON:
    ```json
    {
        "success": true,
        "message": "Imagen recibida correctamente",
        "filename": "{{ $node['Webhook'].binary.Imagen.fileName }}"
    }
    ```

Este workflow simple solo verifica que la imagen llegue. Luego puedes agregar el procesamiento OCR.

---

## 🧪 Prueba con cURL

Para descartar que el problema sea del chatbot, prueba directamente con cURL:

```bash
# 1. Crea una imagen de prueba
curl -o test.jpg https://via.placeholder.com/150

# 2. Envía a n8n (REEMPLAZA LA URL)
curl -X POST "http://localhost:5678/webhook/TU-WEBHOOK-ID" \
  -F "Imagen=@test.jpg" \
  -v

# 3. Observa la respuesta
```

**¿Qué esperar?**

- ✅ **200 OK + JSON:** Todo funciona, el problema era del chatbot
- ❌ **500 Error:** El problema está en n8n, sigue los pasos anteriores

---

## 🔧 Workflow de Ejemplo Completo (con OCR)

Si quieres un workflow funcional de ejemplo:

```
┌──────────┐    ┌──────────────┐    ┌─────────────┐    ┌──────────┐
│ Webhook  │───▶│ HTTP Request │───▶│ Set/Process │───▶│ Response │
│  (POST)  │    │ Google Vision│    │  OCR Result │    │  (JSON)  │
└──────────┘    └──────────────┘    └─────────────┘    └──────────┘
```

**Nodo HTTP Request (Google Vision API ejemplo):**

```yaml
Method: POST
URL: https://vision.googleapis.com/v1/images:annotate
Authentication: API Key in Header
Header Key: X-goog-api-key
Body:
{
  "requests": [{
    "image": {
      "content": "{{ $binary.Imagen.data.toString('base64') }}"
    },
    "features": [{
      "type": "TEXT_DETECTION"
    }]
  }]
}
```

---

## 📊 Checklist Final

Antes de pedir ayuda, verifica:

- [ ] n8n está corriendo (`http://localhost:5678` funciona)
- [ ] El workflow está **activo** (toggle verde)
- [ ] Has revisado las ejecuciones en n8n
- [ ] El nodo específico que falla ha sido identificado
- [ ] Las credenciales del servicio OCR están configuradas (si aplica)
- [ ] La prueba con cURL da el mismo error
- [ ] Has reiniciado el workflow (desactivar y activar)

---

## 💡 Soluciones Rápidas

### Si el webhook no recibe el campo "Imagen":

Verifica en el chatbot que el código sea:

```javascript
const formData = new FormData();
formData.append("Imagen", imageFile); // Exactamente "Imagen" con mayúscula
```

### Si el servicio OCR falla:

1. Prueba con una imagen simple (texto grande y claro)
2. Verifica que las credenciales sean válidas
3. Revisa los límites de tu plan (gratuito vs pago)
4. Comprueba que el servicio esté operativo

### Si todo lo demás falla:

**Workflow de prueba mínimo:**

1. Crea un nuevo workflow
2. Agrega solo un Webhook (POST)
3. Agrega un nodo "Respond to Webhook"
4. Configura la respuesta:
    ```json
    {
        "recibido": true,
        "archivo": "{{ $node['Webhook'].binary.Imagen.fileName }}"
    }
    ```
5. Activa el workflow
6. Prueba con el chatbot

Si esto funciona, el problema está en tu workflow de OCR, no en la conexión.

---

## 🆘 Necesitas Más Ayuda?

Si después de todo esto sigue sin funcionar:

1. **Captura de pantalla** de la ejecución fallida en n8n
2. **El mensaje de error completo** del nodo que falla
3. **La configuración** de tu nodo Webhook
4. **El output de cURL** cuando haces la prueba

Con esa información se puede diagnosticar el problema específico.

---

## ✅ Una vez solucionado

Cuando funcione, deberías ver:

**En n8n:**

- Ejecuciones exitosas (✅ verde)
- El campo "Imagen" llegando correctamente
- Respuesta JSON devuelta

**En el chatbot:**

- La imagen se envía
- Se recibe una respuesta
- El texto extraído (o resultado OCR) se muestra

¡Éxito! 🎉
