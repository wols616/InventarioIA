#!/bin/bash

# Script de prueba rápida del webhook OCR
# Uso: ./test-ocr-webhook.sh [ruta-a-imagen]

echo "🧪 Prueba de Webhook OCR"
echo "========================"
echo ""

# URL del webhook
WEBHOOK_URL="http://localhost:5678/webhook-test/analizar"

echo "📍 URL: $WEBHOOK_URL"
echo ""

# Verificar si se proporcionó una imagen
if [ -z "$1" ]; then
    echo "⚠️  No se proporcionó imagen, usando imagen de prueba..."
    # Crear imagen de prueba (1x1 pixel PNG transparente)
    echo "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==" | base64 -d > /tmp/test-ocr.png
    IMAGE_PATH="/tmp/test-ocr.png"
    echo "✅ Imagen de prueba creada: $IMAGE_PATH"
else
    IMAGE_PATH="$1"
    if [ ! -f "$IMAGE_PATH" ]; then
        echo "❌ Error: El archivo '$IMAGE_PATH' no existe"
        exit 1
    fi
    echo "📄 Usando imagen: $IMAGE_PATH"
fi

echo ""
echo "🚀 Enviando petición..."
echo ""

# Realizar petición con curl
RESPONSE=$(curl -s -w "\n%{http_code}" -X POST "$WEBHOOK_URL" \
  -F "Imagen=@$IMAGE_PATH" \
  -F "test=true")

# Separar el código de estado de la respuesta
HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
BODY=$(echo "$RESPONSE" | sed '$d')

echo "📥 Respuesta:"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "HTTP Status: $HTTP_CODE"
echo ""
echo "$BODY" | python3 -m json.tool 2>/dev/null || echo "$BODY"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Evaluar resultado
if [ "$HTTP_CODE" -eq 200 ]; then
    echo "✅ ¡Éxito! El webhook OCR está funcionando correctamente"
    exit 0
elif [ "$HTTP_CODE" -eq 404 ]; then
    echo "❌ Error 404: Webhook no encontrado"
    echo ""
    echo "Verifica:"
    echo "  1. Que la URL sea correcta: $WEBHOOK_URL"
    echo "  2. Que el workflow esté creado en n8n"
    echo "  3. Que el path del webhook coincida"
    exit 1
elif [ "$HTTP_CODE" -eq 500 ]; then
    echo "❌ Error 500: Error interno del servidor"
    echo ""
    echo "El webhook recibió la petición pero falló al procesarla."
    echo ""
    echo "Pasos para diagnosticar:"
    echo "  1. Abre n8n en http://localhost:5678"
    echo "  2. Ve al workflow de análisis de imágenes"
    echo "  3. Haz clic en 'Executions' para ver las ejecuciones"
    echo "  4. Busca la última ejecución fallida (❌ roja)"
    echo "  5. Revisa qué nodo está fallando y por qué"
    echo ""
    echo "Errores comunes:"
    echo "  • Credenciales de API OCR no configuradas"
    echo "  • Campo 'Imagen' no se encuentra en el webhook"
    echo "  • Servicio OCR externo caído o sin créditos"
    echo "  • Formato de imagen no soportado"
    exit 1
elif [ -z "$HTTP_CODE" ] || [ "$HTTP_CODE" -eq 000 ]; then
    echo "❌ Error de conexión: No se pudo conectar con n8n"
    echo ""
    echo "Verifica:"
    echo "  1. Que n8n esté corriendo: http://localhost:5678"
    echo "  2. Que no haya problemas de firewall"
    echo "  3. Que el puerto 5678 esté disponible"
    echo ""
    echo "Para iniciar n8n:"
    echo "  n8n start"
    exit 1
else
    echo "❌ Error $HTTP_CODE"
    exit 1
fi
