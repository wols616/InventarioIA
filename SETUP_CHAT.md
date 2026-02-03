# 🤖 Configuración del Chat con IA

## ✅ Pasos Completados

1. ✅ Dependencias instaladas (Composer + NPM)
2. ✅ Archivo `.env` configurado
3. ✅ Clave de aplicación generada
4. ✅ Componente de chat creado
5. ✅ Rutas configuradas
6. ✅ Menú de navegación actualizado

## 📋 Pasos Siguientes

### 1. Configurar Base de Datos

#### Opción A: PostgreSQL (Recomendado para producción)

```bash
# Crear la base de datos
createdb inventario

# O manualmente en psql:
psql -U tu_usuario
CREATE DATABASE inventario;
\q
```

Luego actualiza el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventario
DB_USERNAME=tu_usuario_postgres
DB_PASSWORD=tu_contraseña
```

#### Opción B: SQLite (Rápido para desarrollo)

```bash
# Crear archivo de base de datos
touch database/database.sqlite
```

Actualiza el archivo `.env`:

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=inventario
# DB_USERNAME=root
# DB_PASSWORD=
```

### 2. Ejecutar Migraciones

```bash
# Crear las tablas usando el SQL proporcionado
php artisan migrate

# O importar el archivo db.sql directamente
psql -U tu_usuario inventario < database/db.sql
```

### 3. Iniciar el Servidor

```bash
# Terminal 1: Servidor PHP
php artisan serve

# Terminal 2: Compilar assets frontend
npm run dev
```

### 4. Configurar n8n

En tu flujo de n8n:

1. Crea un nodo **Webhook**
2. Configura el método como **POST**
3. Copia la URL del webhook (ej: `http://localhost:5678/webhook/tu-webhook-id`)
4. Asegúrate de que tu n8n esté corriendo localmente

### 5. Usar el Chat

1. Accede a `http://localhost:8000/login`
2. Inicia sesión con tus credenciales
3. Haz clic en "Chat IA" en el menú superior
4. Pega la URL del webhook de n8n
5. Haz clic en "Probar Conexión"
6. ¡Comienza a chatear!

## 🔧 Estructura del Webhook

El chat envía peticiones POST con este formato:

```json
{
    "message": "mensaje del usuario",
    "timestamp": "2026-02-02T12:00:00Z"
}
```

Tu webhook de n8n debe responder con:

```json
{
    "response": "respuesta del bot"
}
```

O cualquiera de estos formatos alternativos:

- `{ "message": "respuesta" }`
- `{ "output": "respuesta" }`
- Cualquier JSON (se mostrará como texto)

## 🎨 Características del Chat

- ✅ Interfaz moderna con Tailwind CSS
- ✅ Mensajes en tiempo real
- ✅ Indicador de escritura
- ✅ Estado de conexión
- ✅ Sugerencias de preguntas
- ✅ Historial de conversación
- ✅ Guarda la URL del webhook en localStorage
- ✅ Responsive design

## 🐛 Solución de Problemas

### Error de conexión

- Verifica que n8n esté corriendo: `http://localhost:5678`
- Verifica que la URL del webhook sea correcta
- Revisa la consola del navegador para más detalles

### Error 404

- Asegúrate de haber iniciado sesión
- Verifica que las rutas estén en `routes/web.php`

### CORS Error

Si tienes problemas de CORS, configura n8n para permitir solicitudes desde tu dominio.

## 📝 Notas

- El chat guarda la URL del webhook en localStorage del navegador
- Los mensajes no se guardan en base de datos (solo en la sesión del navegador)
- Requiere autenticación para acceder
