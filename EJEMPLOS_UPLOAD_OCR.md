# 📸 Ejemplos de Código para Subida de Imágenes OCR

Este documento contiene ejemplos de código en diferentes lenguajes para realizar peticiones HTTP al endpoint de análisis OCR de n8n.

**Endpoint:** `POST http://localhost:5678/webhook/analizar`

**Formato:** `multipart/form-data`

**Parámetro de imagen:** `Imagen` (clave exacta)

---

## 📋 Tabla de Contenidos

1. [JavaScript Vanilla (Ya integrado en el chatbot)](#javascript-vanilla)
2. [JavaScript con Axios](#javascript-con-axios)
3. [React + Axios](#react--axios)
4. [Python con requests](#python-con-requests)
5. [Node.js con form-data](#nodejs-con-form-data)
6. [cURL](#curl)

---

## 🟨 JavaScript Vanilla

Esta es la implementación ya integrada en tu chatbot actual.

```javascript
/**
 * Envía una imagen al endpoint de n8n para análisis OCR
 * @param {File} imageFile - Archivo de imagen a analizar
 * @returns {Promise<Object>} - Respuesta del servidor
 */
async function sendImageForOCR(imageFile) {
    const ocrEndpoint = "http://localhost:5678/webhook/analizar";

    try {
        // Crear FormData con la imagen usando la clave exacta "Imagen"
        const formData = new FormData();
        formData.append("Imagen", imageFile);

        // Opcional: agregar sessionId
        formData.append("sessionId", "session_123");

        // Realizar petición HTTP POST con multipart/form-data
        const response = await fetch(ocrEndpoint, {
            method: "POST",
            body: formData,
            // No establecer Content-Type - el navegador lo hará automáticamente
        });

        // Verificar si la respuesta fue exitosa
        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        // Parsear respuesta JSON
        const data = await response.json();

        return {
            success: true,
            data: data,
        };
    } catch (error) {
        console.error("Error al enviar imagen para OCR:", error);

        // Manejo de errores específicos
        if (error.message.includes("Failed to fetch")) {
            return {
                success: false,
                error: "No se pudo conectar con el servidor de n8n. Verifica que esté activo.",
            };
        }

        return {
            success: false,
            error: error.message || "Error desconocido al procesar la imagen",
        };
    }
}

// Ejemplo de uso con un input file
document
    .getElementById("file-input")
    .addEventListener("change", async function (e) {
        const file = e.target.files[0];

        if (file) {
            console.log("Enviando imagen:", file.name);
            const result = await sendImageForOCR(file);

            if (result.success) {
                console.log("✅ Respuesta:", result.data);
            } else {
                console.error("❌ Error:", result.error);
            }
        }
    });
```

### Ejemplo HTML completo:

```html
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <title>Test OCR</title>
    </head>
    <body>
        <h1>📷 Test de OCR</h1>
        <input type="file" id="file-input" accept="image/*" />
        <div id="resultado"></div>

        <script>
            async function sendImageForOCR(imageFile) {
                // ... código de arriba ...
            }

            document
                .getElementById("file-input")
                .addEventListener("change", async function (e) {
                    const file = e.target.files[0];
                    const resultDiv = document.getElementById("resultado");

                    if (file) {
                        resultDiv.innerHTML = "⏳ Procesando...";
                        const result = await sendImageForOCR(file);

                        if (result.success) {
                            resultDiv.innerHTML = `✅ <pre>${JSON.stringify(result.data, null, 2)}</pre>`;
                        } else {
                            resultDiv.innerHTML = `❌ Error: ${result.error}`;
                        }
                    }
                });
        </script>
    </body>
</html>
```

---

## 🟨 JavaScript con Axios

```javascript
import axios from "axios";

/**
 * Envía una imagen usando Axios
 */
async function sendImageWithAxios(imageFile) {
    const endpoint = "http://localhost:5678/webhook/analizar";

    try {
        const formData = new FormData();
        formData.append("Imagen", imageFile);

        const response = await axios.post(endpoint, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            timeout: 30000, // 30 segundos de timeout
        });

        return {
            success: true,
            data: response.data,
        };
    } catch (error) {
        console.error("Error:", error);

        if (error.code === "ECONNABORTED") {
            return {
                success: false,
                error: "Timeout - el servidor tardó demasiado",
            };
        }

        if (error.response) {
            // El servidor respondió con un código de error
            return {
                success: false,
                error: `Error ${error.response.status}: ${error.response.statusText}`,
            };
        } else if (error.request) {
            // La petición se hizo pero no hubo respuesta
            return {
                success: false,
                error: "No se recibió respuesta del servidor. Verifica que n8n esté activo.",
            };
        } else {
            return {
                success: false,
                error: error.message,
            };
        }
    }
}

// Uso:
const fileInput = document.querySelector('input[type="file"]');
fileInput.addEventListener("change", async (e) => {
    const result = await sendImageWithAxios(e.target.files[0]);
    console.log(result);
});
```

---

## ⚛️ React + Axios

```jsx
import React, { useState } from "react";
import axios from "axios";

function OCRUploader() {
    const [selectedFile, setSelectedFile] = useState(null);
    const [preview, setPreview] = useState(null);
    const [loading, setLoading] = useState(false);
    const [result, setResult] = useState(null);
    const [error, setError] = useState(null);

    const handleFileSelect = (event) => {
        const file = event.target.files[0];

        if (file) {
            // Validar que sea imagen
            if (!file.type.startsWith("image/")) {
                setError("Por favor selecciona un archivo de imagen");
                return;
            }

            // Validar tamaño (máximo 10MB)
            if (file.size > 10 * 1024 * 1024) {
                setError("La imagen es demasiado grande. Máximo 10MB");
                return;
            }

            setSelectedFile(file);
            setError(null);

            // Crear vista previa
            const reader = new FileReader();
            reader.onloadend = () => {
                setPreview(reader.result);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleUpload = async () => {
        if (!selectedFile) {
            setError("Por favor selecciona una imagen primero");
            return;
        }

        setLoading(true);
        setError(null);
        setResult(null);

        try {
            const formData = new FormData();
            formData.append("Imagen", selectedFile);

            const response = await axios.post(
                "http://localhost:5678/webhook/analizar",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    timeout: 30000,
                },
            );

            setResult(response.data);
            console.log("✅ Respuesta del servidor:", response.data);
        } catch (err) {
            console.error("❌ Error:", err);

            if (err.code === "ECONNABORTED") {
                setError("Timeout: El servidor tardó demasiado en responder");
            } else if (err.response) {
                setError(
                    `Error ${err.response.status}: ${err.response.statusText}`,
                );
            } else if (err.request) {
                setError(
                    "No se pudo conectar con el servidor. Verifica que n8n esté activo en http://localhost:5678",
                );
            } else {
                setError(err.message);
            }
        } finally {
            setLoading(false);
        }
    };

    const handleClear = () => {
        setSelectedFile(null);
        setPreview(null);
        setResult(null);
        setError(null);
    };

    return (
        <div className="ocr-uploader">
            <h2>📷 Análisis OCR de Activos</h2>

            <div className="upload-section">
                <input
                    type="file"
                    accept="image/*"
                    onChange={handleFileSelect}
                    disabled={loading}
                />

                {preview && (
                    <div className="preview">
                        <img
                            src={preview}
                            alt="Vista previa"
                            style={{ maxWidth: "300px" }}
                        />
                        <button onClick={handleClear}>Eliminar</button>
                    </div>
                )}

                <button
                    onClick={handleUpload}
                    disabled={!selectedFile || loading}
                >
                    {loading ? "⏳ Procesando..." : "📤 Analizar Imagen"}
                </button>
            </div>

            {error && (
                <div
                    className="error"
                    style={{ color: "red", marginTop: "10px" }}
                >
                    ❌ {error}
                </div>
            )}

            {result && (
                <div className="result" style={{ marginTop: "20px" }}>
                    <h3>✅ Resultado:</h3>
                    <pre>{JSON.stringify(result, null, 2)}</pre>
                </div>
            )}
        </div>
    );
}

export default OCRUploader;
```

---

## 🐍 Python con requests

```python
import requests
import os

def send_image_for_ocr(image_path):
    """
    Envía una imagen al endpoint de n8n para análisis OCR

    Args:
        image_path (str): Ruta al archivo de imagen

    Returns:
        dict: Respuesta del servidor o información de error
    """
    endpoint = 'http://localhost:5678/webhook/analizar'

    try:
        # Verificar que el archivo existe
        if not os.path.exists(image_path):
            return {
                'success': False,
                'error': f'El archivo {image_path} no existe'
            }

        # Abrir el archivo en modo binario
        with open(image_path, 'rb') as image_file:
            # Preparar el archivo con la clave exacta "Imagen"
            files = {
                'Imagen': (
                    os.path.basename(image_path),  # nombre del archivo
                    image_file,                     # contenido del archivo
                    'image/jpeg'                    # tipo MIME (ajustar según necesidad)
                )
            }

            # Opcional: enviar datos adicionales
            data = {
                'sessionId': 'session_python_123'
            }

            # Realizar petición POST
            response = requests.post(
                endpoint,
                files=files,
                data=data,
                timeout=30  # timeout de 30 segundos
            )

            # Verificar si fue exitoso
            response.raise_for_status()

            return {
                'success': True,
                'data': response.json()
            }

    except requests.exceptions.ConnectionError:
        return {
            'success': False,
            'error': 'No se pudo conectar con el servidor. Verifica que n8n esté activo en http://localhost:5678'
        }

    except requests.exceptions.Timeout:
        return {
            'success': False,
            'error': 'Timeout: El servidor tardó demasiado en responder'
        }

    except requests.exceptions.HTTPError as e:
        return {
            'success': False,
            'error': f'Error HTTP {response.status_code}: {response.reason}'
        }

    except Exception as e:
        return {
            'success': False,
            'error': f'Error inesperado: {str(e)}'
        }

# Ejemplo de uso
if __name__ == '__main__':
    # Ruta a la imagen
    image_path = 'ruta/a/tu/imagen.jpg'

    print(f'📤 Enviando imagen: {image_path}')
    result = send_image_for_ocr(image_path)

    if result['success']:
        print('✅ Respuesta del servidor:')
        print(result['data'])
    else:
        print(f'❌ Error: {result["error"]}')
```

### Ejemplo con Flask (servidor web):

```python
from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

@app.route('/upload', methods=['POST'])
def upload_image():
    """Endpoint para recibir una imagen y reenviarla a n8n"""

    if 'image' not in request.files:
        return jsonify({'error': 'No se encontró imagen en la petición'}), 400

    file = request.files['image']

    if file.filename == '':
        return jsonify({'error': 'No se seleccionó archivo'}), 400

    try:
        # Preparar archivo para n8n con la clave "Imagen"
        files = {'Imagen': (file.filename, file.stream, file.content_type)}

        # Enviar a n8n
        response = requests.post(
            'http://localhost:5678/webhook/analizar',
            files=files,
            timeout=30
        )

        response.raise_for_status()

        return jsonify({
            'success': True,
            'data': response.json()
        })

    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

if __name__ == '__main__':
    app.run(debug=True, port=5000)
```

---

## 🟢 Node.js con form-data

```javascript
const axios = require("axios");
const FormData = require("form-data");
const fs = require("fs");
const path = require("path");

/**
 * Envía una imagen desde Node.js al endpoint de OCR
 * @param {string} imagePath - Ruta al archivo de imagen
 * @returns {Promise<Object>} Respuesta del servidor
 */
async function sendImageForOCR(imagePath) {
    const endpoint = "http://localhost:5678/webhook/analizar";

    try {
        // Verificar que el archivo existe
        if (!fs.existsSync(imagePath)) {
            throw new Error(`El archivo ${imagePath} no existe`);
        }

        // Crear FormData
        const form = new FormData();

        // Agregar la imagen con la clave exacta "Imagen"
        form.append("Imagen", fs.createReadStream(imagePath), {
            filename: path.basename(imagePath),
            contentType: "image/jpeg", // Ajustar según el tipo de imagen
        });

        // Opcional: agregar datos adicionales
        form.append("sessionId", "session_nodejs_123");

        // Realizar petición
        const response = await axios.post(endpoint, form, {
            headers: {
                ...form.getHeaders(),
            },
            timeout: 30000,
            maxContentLength: Infinity,
            maxBodyLength: Infinity,
        });

        return {
            success: true,
            data: response.data,
        };
    } catch (error) {
        console.error("Error al enviar imagen:", error.message);

        if (error.code === "ECONNREFUSED") {
            return {
                success: false,
                error: "No se pudo conectar con el servidor. Verifica que n8n esté activo.",
            };
        }

        if (error.code === "ECONNABORTED") {
            return {
                success: false,
                error: "Timeout: El servidor tardó demasiado en responder",
            };
        }

        if (error.response) {
            return {
                success: false,
                error: `Error ${error.response.status}: ${error.response.statusText}`,
            };
        }

        return {
            success: false,
            error: error.message,
        };
    }
}

// Ejemplo de uso
async function main() {
    const imagePath = "./imagen-activo.jpg";

    console.log(`📤 Enviando imagen: ${imagePath}`);
    const result = await sendImageForOCR(imagePath);

    if (result.success) {
        console.log("✅ Respuesta del servidor:");
        console.log(JSON.stringify(result.data, null, 2));
    } else {
        console.log(`❌ Error: ${result.error}`);
    }
}

// Ejecutar
main().catch(console.error);
```

---

## 🔧 cURL

```bash
# Ejemplo básico
curl -X POST http://localhost:5678/webhook/analizar \
  -F "Imagen=@/ruta/a/tu/imagen.jpg"

# Con datos adicionales
curl -X POST http://localhost:5678/webhook/analizar \
  -F "Imagen=@/ruta/a/tu/imagen.jpg" \
  -F "sessionId=session_123"

# Con verbose para ver detalles
curl -v -X POST http://localhost:5678/webhook/analizar \
  -F "Imagen=@/ruta/a/tu/imagen.jpg"

# Guardando la respuesta en un archivo
curl -X POST http://localhost:5678/webhook/analizar \
  -F "Imagen=@/ruta/a/tu/imagen.jpg" \
  -o respuesta.json

# Con timeout
curl --max-time 30 -X POST http://localhost:5678/webhook/analizar \
  -F "Imagen=@/ruta/a/tu/imagen.jpg"
```

---

## 📝 Notas Importantes

### ✅ Mejores Prácticas

1. **Validación de archivos**: Siempre valida el tipo y tamaño del archivo antes de enviarlo
2. **Timeouts**: Establece timeouts apropiados (30-60 segundos para OCR)
3. **Manejo de errores**: Implementa manejo robusto de errores para diferentes escenarios
4. **Feedback visual**: Muestra indicadores de carga mientras se procesa la imagen
5. **Limpiar recursos**: Limpia los archivos y previsualizaciones después de usarlos

### ⚠️ Consideraciones

- **Tamaño máximo**: Limita el tamaño de las imágenes (recomendado: 10MB)
- **Formatos soportados**: Verifica qué formatos acepta tu servidor (JPG, PNG, etc.)
- **Seguridad**: En producción, usa HTTPS y valida en el servidor
- **Rate limiting**: Implementa límites de tasa si es necesario
- **CORS**: Si es cross-origin, configura CORS en n8n

### 🔍 Depuración

Si tienes problemas:

1. Verifica que n8n esté corriendo: `http://localhost:5678`
2. Revisa la consola del navegador para errores
3. Usa las herramientas de red del navegador para inspeccionar la petición
4. Verifica que el nombre del campo sea exactamente `Imagen`
5. Asegúrate de que el Content-Type sea `multipart/form-data`

---

## 🎯 Integración Completada

La funcionalidad de subida de imágenes ya está **completamente integrada** en tu chatbot en el archivo:

📄 `resources/views/chat/index.blade.php`

### Características implementadas:

✅ Botón para adjuntar imagen  
✅ Vista previa de imagen seleccionada  
✅ Validación de tipo y tamaño  
✅ Envío al endpoint de n8n con `multipart/form-data`  
✅ Manejo de errores completo  
✅ Feedback visual durante el proceso  
✅ Integración con el flujo del chat existente

### Cómo usar:

1. Haz clic en el botón 📎 (clip/imagen) junto al input de mensaje
2. Selecciona una imagen
3. (Opcional) Escribe un mensaje como contexto
4. Presiona "Enviar" o Enter
5. El sistema enviará la imagen al endpoint de n8n y mostrará la respuesta

¡Disfruta tu nuevo sistema de análisis OCR! 🎉
