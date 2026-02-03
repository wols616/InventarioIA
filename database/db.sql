-- =========================
-- 1. CATEGORIAS_ACTIVOS
-- =========================
CREATE TABLE categorias_activos (
    id_categoria SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    vida_util_estimada_meses INT,
    depreciable BOOLEAN NOT NULL DEFAULT true,
    activo BOOLEAN NOT NULL DEFAULT true
);

-- =========================
-- 2. TIPOS_ACTIVOS
-- =========================
CREATE TABLE tipos_activos (
    id_tipo SERIAL PRIMARY KEY,
    id_categoria INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    requiere_serie BOOLEAN DEFAULT false,
    requiere_marca BOOLEAN DEFAULT false,
    requiere_modelo BOOLEAN DEFAULT false,
    requiere_especificaciones BOOLEAN DEFAULT false,
    CONSTRAINT fk_tipos_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias_activos(id_categoria)
);

-- =========================
-- 3. ESTADOS_ACTIVOS
-- =========================
CREATE TABLE estados_activos (
    id_estado SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    anotacion TEXT,
    es_operativo BOOLEAN NOT NULL
);

-- =========================
-- 4. EDIFICIOS
-- =========================
CREATE TABLE edificios (
    id_edificio SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(20) NOT NULL UNIQUE
);

-- =========================
-- 5. PISOS
-- =========================
CREATE TABLE pisos (
    id_piso SERIAL PRIMARY KEY,
    id_edificio INT NOT NULL,
    numero_piso INT NOT NULL,
    CONSTRAINT fk_pisos_edificio
        FOREIGN KEY (id_edificio)
        REFERENCES edificios(id_edificio)
);

-- =========================
-- 6. AREAS
-- =========================
CREATE TABLE areas (
    id_area SERIAL PRIMARY KEY,
    id_piso INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    tipo_area VARCHAR(50),
    estado BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT fk_areas_piso
        FOREIGN KEY (id_piso)
        REFERENCES pisos(id_piso)
);

-- =========================
-- 7. UBICACIONES_FISICAS
-- =========================
CREATE TABLE ubicaciones_fisicas (
    id_ubicacion SERIAL PRIMARY KEY,
    id_area INT NOT NULL,
    nombre VARCHAR(100),
    codigo_interno VARCHAR(50),
    descripcion_detallada TEXT,
    estado BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT fk_ubicaciones_area
        FOREIGN KEY (id_area)
        REFERENCES areas(id_area)
);

-- =========================
-- 8. ACTIVOS
-- =========================
CREATE TABLE activos (
    id_activo SERIAL PRIMARY KEY,
    id_tipo INT NOT NULL,
    id_estado INT NOT NULL,
    id_ubicacion_actual INT,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    codigo_barra VARCHAR(100),
    marca VARCHAR(100),
    modelo VARCHAR(100),
    numero_serie VARCHAR(100),
    fecha_adquisicion DATE,
    valor_adquisicion NUMERIC(12,2),
    CONSTRAINT fk_activos_tipo
        FOREIGN KEY (id_tipo)
        REFERENCES tipos_activos(id_tipo),
    CONSTRAINT fk_activos_estado
        FOREIGN KEY (id_estado)
        REFERENCES estados_activos(id_estado),
    CONSTRAINT fk_activos_ubicacion
        FOREIGN KEY (id_ubicacion_actual)
        REFERENCES ubicaciones_fisicas(id_ubicacion)
);

-- =========================
-- 9. INVENTARIO
-- =========================
CREATE TABLE inventario (
    id_inventario SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    cantidad INT NOT NULL,
    descripcion TEXT,
    cantidad_minima INT,
    cantidad_maxima INT,
    CONSTRAINT fk_inventario_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo)
);

-- =========================
-- 10. PROVEEDORES
-- =========================
CREATE TABLE proveedores (
    id_proveedor SERIAL PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    contacto VARCHAR(150),
    descripcion TEXT
);

-- =========================
-- 11. COMPRAS
-- =========================
CREATE TABLE compras (
    id_compra SERIAL PRIMARY KEY,
    id_proveedor INT NOT NULL,
    numero_factura VARCHAR(50),
    fecha_compra DATE NOT NULL,
    monto_total NUMERIC(12,2),
    CONSTRAINT fk_compras_proveedor
        FOREIGN KEY (id_proveedor)
        REFERENCES proveedores(id_proveedor)
);

-- =========================
-- 12. DETALLE_COMPRA
-- =========================
CREATE TABLE detalle_compra (
    id_detalle_compra SERIAL PRIMARY KEY,
    id_compra INT NOT NULL,
    id_activo INT NOT NULL,
    cantidad INT NOT NULL,
    costo_unitario NUMERIC(12,2),
    subtotal NUMERIC(12,2),
    CONSTRAINT fk_detalle_compra_compra
        FOREIGN KEY (id_compra)
        REFERENCES compras(id_compra),
    CONSTRAINT fk_detalle_compra_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo)
);

-- =========================
-- 13. MOVIMIENTOS_ACTIVOS
-- =========================
CREATE TABLE movimientos_activos (
    id_movimiento SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    id_ubicacion_origen INT,
    id_ubicacion_destino INT,
    fecha_movimiento DATE NOT NULL,
    motivo TEXT,
    CONSTRAINT fk_movimientos_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo),
    CONSTRAINT fk_mov_origen
        FOREIGN KEY (id_ubicacion_origen)
        REFERENCES ubicaciones_fisicas(id_ubicacion),
    CONSTRAINT fk_mov_destino
        FOREIGN KEY (id_ubicacion_destino)
        REFERENCES ubicaciones_fisicas(id_ubicacion)
);

-- =========================
-- 14. MANTENIMIENTOS
-- =========================
CREATE TABLE mantenimientos (
    id_mantenimiento SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    tipo_mantenimiento VARCHAR(50),
    fecha_inicio DATE,
    fecha_fin DATE,
    costo NUMERIC(12,2),
    anotacion TEXT,
    CONSTRAINT fk_mantenimientos_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo)
);

-- =========================
-- 15. HISTORIAL_ESTADOS
-- =========================
CREATE TABLE historial_estados (
    id_historial SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    id_estado_anterior INT,
    id_estado_nuevo INT,
    fecha_cambio DATE NOT NULL,
    CONSTRAINT fk_historial_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo),
    CONSTRAINT fk_estado_anterior
        FOREIGN KEY (id_estado_anterior)
        REFERENCES estados_activos(id_estado),
    CONSTRAINT fk_estado_nuevo
        FOREIGN KEY (id_estado_nuevo)
        REFERENCES estados_activos(id_estado)
);

-- =========================
-- 16. DOCUMENTOS_ADJUNTOS
-- =========================
CREATE TABLE documentos_adjuntos (
    id_documento SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    tipo_documento VARCHAR(50),
    ruta_archivo TEXT NOT NULL,
    CONSTRAINT fk_documentos_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo)
);

-- =========================
-- 17. ROLES
-- =========================
CREATE TABLE roles (
    id_rol SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    estado BOOLEAN NOT NULL DEFAULT true
);

-- =========================
-- 18. DEPARTAMENTOS
-- =========================
CREATE TABLE departamentos (
    id_departamento SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    estado BOOLEAN NOT NULL DEFAULT true
);

-- =========================
-- 19. PERSONAS
-- =========================
CREATE TABLE personas (
    id_persona SERIAL PRIMARY KEY,
    id_rol INT NOT NULL,
    id_departamento INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dui VARCHAR(20),
    correo VARCHAR(150),
    estado BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT fk_personas_rol
        FOREIGN KEY (id_rol)
        REFERENCES roles(id_rol),
    CONSTRAINT fk_personas_departamento
        FOREIGN KEY (id_departamento)
        REFERENCES departamentos(id_departamento)
);

-- =========================
-- 20. ASIGNACIONES_ACTIVOS
-- =========================
CREATE TABLE asignaciones_activos (
    id_asignacion SERIAL PRIMARY KEY,
    id_activo INT NOT NULL,
    id_persona INT NOT NULL,
    fecha_asignacion DATE NOT NULL,
    fecha_fin DATE,
    es_responsable_principal BOOLEAN DEFAULT false,
    estado BOOLEAN NOT NULL DEFAULT true,
    CONSTRAINT fk_asignacion_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo),
    CONSTRAINT fk_asignacion_persona
        FOREIGN KEY (id_persona)
        REFERENCES personas(id_persona)
);

-- =========================
-- 21. AUDITORIAS_INVENTARIO
-- =========================
CREATE TABLE auditorias_inventario (
    id_auditoria SERIAL PRIMARY KEY,
    id_persona INT NOT NULL,
    fecha_auditoria DATE NOT NULL,
    CONSTRAINT fk_auditoria_persona
        FOREIGN KEY (id_persona)
        REFERENCES personas(id_persona)
);

-- =========================
-- 22. DETALLE_AUDITORIA
-- =========================
CREATE TABLE detalle_auditoria (
    id_detalle SERIAL PRIMARY KEY,
    id_auditoria INT NOT NULL,
    id_activo INT NOT NULL,
    coincide_con_sistema BOOLEAN NOT NULL,
    anotaciones TEXT,
    CONSTRAINT fk_detalle_auditoria
        FOREIGN KEY (id_auditoria)
        REFERENCES auditorias_inventario(id_auditoria),
    CONSTRAINT fk_detalle_activo
        FOREIGN KEY (id_activo)
        REFERENCES activos(id_activo)
);

-- 23. USUARIOS
-- =========================
CREATE TABLE usuarios (
    id_usuario SERIAL PRIMARY KEY,
    id_persona INT NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    ultimo_login TIMESTAMP,
    estado BOOLEAN NOT NULL DEFAULT true,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_persona
        FOREIGN KEY (id_persona)
        REFERENCES personas(id_persona)
        ON DELETE CASCADE
);

-- =================================================================
-- VISTA PARA EL ASISTENTE IA DE N8N
-- Esta vista une TODAS las 23 tablas en una sola consulta
-- Para que el bot pueda responder preguntas consultando aquí
-- =================================================================

-- Primero eliminar la vista si existe (necesario cuando se cambian nombres de columnas)
DROP VIEW IF EXISTS vista_asistente_inventario;

CREATE VIEW vista_asistente_inventario AS
SELECT 
    -- ============================================
    -- IDENTIFICADORES PRINCIPALES
    -- ============================================
    a.id_activo,
    a.codigo as codigo_activo,
    a.codigo_barra,
    a.numero_serie,
    
    -- ============================================
    -- NOMBRE COMPLETO DEL ACTIVO (columna clave)
    -- ============================================
    CONCAT(
        COALESCE(a.marca, ''), ' ',
        COALESCE(a.modelo, ''), ' ',
        COALESCE(ta.nombre, ''),
        CASE 
            WHEN a.numero_serie IS NOT NULL THEN CONCAT(' (Serie: ', a.numero_serie, ')')
            ELSE ''
        END
    ) as nombre_completo_activo,
    
    -- ============================================
    -- CLASIFICACIÓN DEL ACTIVO
    -- ============================================
    a.marca,
    a.modelo,
    ta.nombre as tipo_activo,
    ta.descripcion as tipo_descripcion,
    ca.nombre as categoria_activo,
    ca.descripcion as categoria_descripcion,
    ca.vida_util_estimada_meses,
    ca.depreciable,
    
    -- ============================================
    -- SITUACIÓN ACTUAL (columna clave)
    -- Estados: OCUPADO | DISPONIBLE EN STOCK | NO DISPONIBLE
    -- ============================================
    CASE 
        WHEN ea.es_operativo = false THEN 'NO DISPONIBLE'
        WHEN EXISTS (
            SELECT 1 FROM asignaciones_activos aa 
            WHERE aa.id_activo = a.id_activo 
            AND aa.estado = true 
            AND (aa.fecha_fin IS NULL OR aa.fecha_fin > CURRENT_DATE)
        ) THEN 'OCUPADO'
        ELSE 'DISPONIBLE EN STOCK'
    END as situacion_actual,
    
    ea.nombre as estado_activo,
    ea.es_operativo,
    ea.anotacion as estado_anotacion,
    
    -- ============================================
    -- RESPONSABLE ACTUAL (columna clave)
    -- ============================================
    CASE 
        WHEN asg.id_persona IS NOT NULL 
        THEN CONCAT(p.nombre, ' ', p.apellido)
        ELSE 'Sin asignar'
    END as responsable_nombre,
    
    p.correo as responsable_correo,
    p.dui as responsable_dui,
    r.nombre as responsable_rol,
    r.descripcion as responsable_rol_descripcion,
    dep.nombre as responsable_departamento,
    dep.descripcion as responsable_departamento_descripcion,
    
    asg.fecha_asignacion,
    asg.fecha_fin as fecha_fin_asignacion,
    asg.es_responsable_principal,
    
    -- ============================================
    -- UBICACIÓN COMPLETA (columna clave)
    -- ============================================
    CASE 
        WHEN uf.nombre IS NOT NULL THEN
            CONCAT(
                COALESCE(uf.nombre, 'Sin nombre'), 
                ' (', 
                COALESCE(ed.nombre, 'Sin edificio'), ', ', 
                'Piso ', COALESCE(pi.numero_piso::text, '?'), ', ',
                COALESCE(ar.nombre, 'Sin área'), ')'
            )
        ELSE 'Sin ubicación asignada'
    END as ubicacion_completa,
    
    -- Detalles de ubicación separados
    ed.nombre as edificio,
    ed.codigo as codigo_edificio,
    pi.numero_piso as piso,
    ar.nombre as area,
    ar.tipo_area,
    uf.nombre as ubicacion_especifica,
    uf.codigo_interno as codigo_ubicacion,
    uf.descripcion_detallada as descripcion_ubicacion,
    
    -- ============================================
    -- ÚLTIMO MANTENIMIENTO (columna clave)
    -- ============================================
    (
        SELECT MAX(m.fecha_fin)
        FROM mantenimientos m
        WHERE m.id_activo = a.id_activo
        AND m.fecha_fin IS NOT NULL
    ) as ultima_fecha_mantenimiento,
    
    (
        SELECT m.tipo_mantenimiento
        FROM mantenimientos m
        WHERE m.id_activo = a.id_activo
        AND m.fecha_fin IS NOT NULL
        ORDER BY m.fecha_fin DESC
        LIMIT 1
    ) as tipo_ultimo_mantenimiento,
    
    (
        SELECT m.costo
        FROM mantenimientos m
        WHERE m.id_activo = a.id_activo
        AND m.fecha_fin IS NOT NULL
        ORDER BY m.fecha_fin DESC
        LIMIT 1
    ) as costo_ultimo_mantenimiento,
    
    (
        SELECT m.anotacion
        FROM mantenimientos m
        WHERE m.id_activo = a.id_activo
        AND m.fecha_fin IS NOT NULL
        ORDER BY m.fecha_fin DESC
        LIMIT 1
    ) as notas_ultimo_mantenimiento,
    
    -- ============================================
    -- INFORMACIÓN FINANCIERA
    -- ============================================
    a.valor_adquisicion,
    a.fecha_adquisicion,
    
    -- ============================================
    -- INVENTARIO
    -- ============================================
    inv.cantidad as cantidad_inventario,
    inv.descripcion as descripcion_inventario,
    inv.cantidad_minima,
    inv.cantidad_maxima,
    
    -- ============================================
    -- ÚLTIMA COMPRA
    -- ============================================
    (
        SELECT c.fecha_compra
        FROM detalle_compra dc
        INNER JOIN compras c ON dc.id_compra = c.id_compra
        WHERE dc.id_activo = a.id_activo
        ORDER BY c.fecha_compra DESC
        LIMIT 1
    ) as ultima_fecha_compra,
    
    (
        SELECT prov.nombre
        FROM detalle_compra dc
        INNER JOIN compras c ON dc.id_compra = c.id_compra
        INNER JOIN proveedores prov ON c.id_proveedor = prov.id_proveedor
        WHERE dc.id_activo = a.id_activo
        ORDER BY c.fecha_compra DESC
        LIMIT 1
    ) as ultimo_proveedor,
    
    (
        SELECT c.numero_factura
        FROM detalle_compra dc
        INNER JOIN compras c ON dc.id_compra = c.id_compra
        WHERE dc.id_activo = a.id_activo
        ORDER BY c.fecha_compra DESC
        LIMIT 1
    ) as ultima_factura,
    
    -- ============================================
    -- ÚLTIMO MOVIMIENTO
    -- ============================================
    (
        SELECT mov.fecha_movimiento
        FROM movimientos_activos mov
        WHERE mov.id_activo = a.id_activo
        ORDER BY mov.fecha_movimiento DESC
        LIMIT 1
    ) as ultimo_movimiento_fecha,
    
    (
        SELECT mov.motivo
        FROM movimientos_activos mov
        WHERE mov.id_activo = a.id_activo
        ORDER BY mov.fecha_movimiento DESC
        LIMIT 1
    ) as ultimo_movimiento_motivo,
    
    -- ============================================
    -- HISTORIAL DE ESTADOS
    -- ============================================
    (
        SELECT he.fecha_cambio
        FROM historial_estados he
        WHERE he.id_activo = a.id_activo
        ORDER BY he.fecha_cambio DESC
        LIMIT 1
    ) as ultimo_cambio_estado_fecha,
    
    (
        SELECT ea_ant.nombre
        FROM historial_estados he
        LEFT JOIN estados_activos ea_ant ON he.id_estado_anterior = ea_ant.id_estado
        WHERE he.id_activo = a.id_activo
        ORDER BY he.fecha_cambio DESC
        LIMIT 1
    ) as estado_anterior,
    
    -- ============================================
    -- DOCUMENTOS ADJUNTOS (cuenta)
    -- ============================================
    (
        SELECT COUNT(*)
        FROM documentos_adjuntos doc
        WHERE doc.id_activo = a.id_activo
    ) as total_documentos,
    
    -- ============================================
    -- AUDITORÍAS (última)
    -- ============================================
    (
        SELECT aud.fecha_auditoria
        FROM detalle_auditoria da
        INNER JOIN auditorias_inventario aud ON da.id_auditoria = aud.id_auditoria
        WHERE da.id_activo = a.id_activo
        ORDER BY aud.fecha_auditoria DESC
        LIMIT 1
    ) as ultima_auditoria_fecha,
    
    (
        SELECT da.coincide_con_sistema
        FROM detalle_auditoria da
        INNER JOIN auditorias_inventario aud ON da.id_auditoria = aud.id_auditoria
        WHERE da.id_activo = a.id_activo
        ORDER BY aud.fecha_auditoria DESC
        LIMIT 1
    ) as ultima_auditoria_coincide,
    
    (
        SELECT da.anotaciones
        FROM detalle_auditoria da
        INNER JOIN auditorias_inventario aud ON da.id_auditoria = aud.id_auditoria
        WHERE da.id_activo = a.id_activo
        ORDER BY aud.fecha_auditoria DESC
        LIMIT 1
    ) as ultima_auditoria_notas,
    
    -- ============================================
    -- TIMESTAMP DE CONSULTA
    -- ============================================
    CURRENT_TIMESTAMP as fecha_consulta

FROM activos a

-- JOINS principales (tipo, categoría, estado)
INNER JOIN tipos_activos ta ON a.id_tipo = ta.id_tipo
INNER JOIN categorias_activos ca ON ta.id_categoria = ca.id_categoria
INNER JOIN estados_activos ea ON a.id_estado = ea.id_estado

-- Ubicación física (puede no tener)
LEFT JOIN ubicaciones_fisicas uf ON a.id_ubicacion_actual = uf.id_ubicacion
LEFT JOIN areas ar ON uf.id_area = ar.id_area
LEFT JOIN pisos pi ON ar.id_piso = pi.id_piso
LEFT JOIN edificios ed ON pi.id_edificio = ed.id_edificio

-- Asignación actual (puede no estar asignado)
LEFT JOIN asignaciones_activos asg ON a.id_activo = asg.id_activo 
    AND asg.estado = true 
    AND (asg.fecha_fin IS NULL OR asg.fecha_fin > CURRENT_DATE)

-- Persona responsable (puede no tener)
LEFT JOIN personas p ON asg.id_persona = p.id_persona
LEFT JOIN roles r ON p.id_rol = r.id_rol
LEFT JOIN departamentos dep ON p.id_departamento = dep.id_departamento

-- Inventario (puede no estar en inventario)
LEFT JOIN inventario inv ON a.id_activo = inv.id_activo

-- Solo activos activos
WHERE ca.activo = true

ORDER BY a.codigo;

-- =================================================================
-- USO EN N8N:
-- =================================================================
-- 
-- Consultas de ejemplo que el bot puede usar:
--
-- 1. Ver todos los activos:
--    SELECT * FROM vista_asistente_inventario
--
-- 2. Buscar por nombre/marca/modelo:
--    SELECT * FROM vista_asistente_inventario
--    WHERE nombre_completo_activo ILIKE '%MacBook%'
--
-- 3. Ver quién tiene un activo:
--    SELECT responsable_nombre, responsable_rol, responsable_departamento
--    FROM vista_asistente_inventario
--    WHERE codigo_activo = 'ACT-001'
--
-- 4. Activos de una persona:
--    SELECT nombre_completo_activo, situacion_actual, ubicacion_completa
--    FROM vista_asistente_inventario
--    WHERE responsable_nombre ILIKE '%Roberto%'
--
-- 5. Activos disponibles:
--    SELECT nombre_completo_activo, ubicacion_completa
--    FROM vista_asistente_inventario
--    WHERE situacion_actual = 'DISPONIBLE EN STOCK'
--
-- 6. Activos en un edificio:
--    SELECT nombre_completo_activo, responsable_nombre, piso, area
--    FROM vista_asistente_inventario
--    WHERE edificio = 'Edificio A'
--
-- 7. Activos con mantenimiento pendiente:
--    SELECT nombre_completo_activo, responsable_nombre, 
--           ultima_fecha_mantenimiento
--    FROM vista_asistente_inventario
--    WHERE ultima_fecha_mantenimiento < CURRENT_DATE - INTERVAL '6 months'
--       OR ultima_fecha_mantenimiento IS NULL
--
-- =================================================================
