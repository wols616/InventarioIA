# 🎯 Resumen: URL Correcta del Webhook OCR

## ✅ URL Confirmada

```
POST http://localhost:5678/webhook/analizar
```

**❌ INCORRECTO:** ~~`http://localhost:5678/webhook/analizar-activo`~~  
**✅ CORRECTO:** `http://localhost:5678/webhook/analizar`

---

## 🔧 Ya Actualizado en Todo el Sistema

✅ Campo de configuración en el chatbot  
✅ Valor por defecto en localStorage  
✅ Documentación (EJEMPLOS_UPLOAD_OCR.md)  
✅ Guía rápida (GUIA_RAPIDA_OCR.md)  
✅ Guía de solución de errores (SOLUCION_ERROR_500_OCR.md)

---

## 🧪 Cómo Probar la Conexión

### **Opción 1: Desde el Chatbot (Interfaz)**

1. Abre el chatbot en tu navegador
2. En la sección de configuración, verás el campo **"OCR URL"**
3. La URL correcta ya está configurada: `http://localhost:5678/webhook/analizar`
4. Haz clic en el botón **"Probar OCR"**
5. Observa el resultado:
    - ✅ **"Webhook OCR funciona correctamente"** → Todo bien
    - ❌ **Error 500** → Revisa n8n (ver guía abajo)
    - ❌ **Failed to fetch** → n8n no está corriendo

### **Opción 2: Desde la Terminal (Script)**

```bash
# Prueba con imagen de prueba (recomendado)
./test-ocr-webhook.sh

# Prueba con tu propia imagen
./test-ocr-webhook.sh /ruta/a/tu/imagen.jpg
```

El script te mostrará:

- ✅ Si la conexión funciona
- ❌ Diagnóstico detallado si falla
- 📋 Instrucciones específicas para cada tipo de error

### **Opción 3: cURL Manual**

```bash
# 1. Crea una imagen de prueba
echo "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==" | base64 -d > test.png

# 2. Envía al webhook
curl -X POST "http://localhost:5678/webhook/analizar" \
  -F "Imagen=@test.png" \
  -F "test=true" \
  -v
```

---

## 📊 Respuestas Esperadas

| Código          | Significado      | ¿Qué Hacer?                                  |
| --------------- | ---------------- | -------------------------------------------- |
| **200**         | ✅ Éxito         | Todo funciona, puedes enviar imágenes reales |
| **404**         | ❌ No encontrado | Verifica la URL del webhook en n8n           |
| **500**         | ❌ Error interno | Revisa las ejecuciones en n8n (ver abajo)    |
| **000** o error | ❌ Sin conexión  | Inicia n8n con `n8n start`                   |

---

## 🔍 Si Obtienes Error 500

El error 500 significa que **n8n recibió la petición** pero **algo falló internamente**.

### Diagnóstico Paso a Paso:

1. **Abre n8n**: http://localhost:5678

2. **Abre el workflow** que procesa las imágenes

3. **Ve a "Executions"** (botón arriba a la derecha)

4. **Busca la última ejecución fallida** (tendrá un ❌ rojo)

5. **Haz clic en ella** para ver detalles

6. **Identifica qué nodo falló** (aparecerá en rojo)

7. **Lee el mensaje de error**

### Errores Comunes:

#### ❌ **"Credentials required"**

- **Causa:** Falta configurar credenciales de API (Google Vision, Tesseract, etc.)
- **Solución:** Ve a n8n → Credentials → Configura las credenciales del servicio OCR

#### ❌ **"Field 'Imagen' not found"**

- **Causa:** El nodo no encuentra el campo de la imagen
- **Solución:** En el nodo que procesa la imagen, usa `{{ $binary.Imagen }}`

#### ❌ **"Invalid image format"**

- **Causa:** El servicio OCR no soporta ese formato de imagen
- **Solución:** Agrega un nodo de conversión de imagen o valida el formato

#### ❌ **"API quota exceeded"**

- **Causa:** Te quedaste sin créditos gratuitos del servicio OCR
- **Solución:** Espera el reset mensual o actualiza tu plan

---

## 🎯 Workflow Mínimo para Probar

Si quieres verificar que el webhook funciona sin OCR:

```
┌──────────┐    ┌────────────────────┐
│ Webhook  │───▶│ Respond to Webhook │
│  (POST)  │    │      (JSON)        │
└──────────┘    └────────────────────┘
```

**Configuración del Webhook:**

- HTTP Method: POST
- Path: `/analizar`
- Response Mode: When Last Node Finishes

**Configuración de la Respuesta:**

```json
{
    "success": true,
    "recibido": "{{ $node['Webhook'].binary.Imagen.fileName }}",
    "tamaño": "{{ $node['Webhook'].binary.Imagen.fileSize }}"
}
```

Si esto funciona, el webhook está bien configurado y el problema está en el procesamiento OCR.

---

## 📚 Más Información

- **Ejemplos de código:** [EJEMPLOS_UPLOAD_OCR.md](EJEMPLOS_UPLOAD_OCR.md)
- **Guía rápida:** [GUIA_RAPIDA_OCR.md](GUIA_RAPIDA_OCR.md)
- **Solución a errores:** [SOLUCION_ERROR_500_OCR.md](SOLUCION_ERROR_500_OCR.md)

---

## ✅ Checklist Antes de Usar

- [ ] n8n está corriendo (`http://localhost:5678` funciona)
- [ ] El workflow está **activo** (toggle verde en n8n)
- [ ] La URL del webhook es exactamente: `http://localhost:5678/webhook/analizar`
- [ ] Has probado la conexión con el botón "Probar OCR"
- [ ] Si usas servicio OCR externo, las credenciales están configuradas

---

¡Listo para usar! 🚀
