-- =================================================================
-- VISTA PARA EL ASISTENTE IA
-- Esta vista consolida toda la información del inventario en un
-- formato que el bot de n8n puede leer fácilmente
-- =================================================================

CREATE OR REPLACE VIEW vista_asistente_inventario AS
SELECT 
    -- Identificadores
    a.id_activo,
    a.codigo as codigo_activo,
    a.numero_serie,
    
    -- Nombre completo del activo (como lo pide el prompt)
    CONCAT(
        COALESCE(a.marca, ''), ' ',
        COALESCE(a.modelo, ''), ' ',
        COALESCE(ta.nombre, ''),
        CASE 
            WHEN a.numero_serie IS NOT NULL THEN CONCAT(' (Serie ', a.numero_serie, ')')
            ELSE ''
        END
    ) as nombre_completo_activo,
    
    -- Detalles del activo
    a.marca,
    a.modelo,
    ta.nombre as tipo_activo,
    ca.nombre as categoria_activo,
    
    -- SITUACIÓN ACTUAL (crítico para el prompt)
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
    
    -- Estado del activo
    ea.nombre as estado_activo,
    ea.es_operativo,
    ea.anotacion as estado_anotacion,
    
    -- RESPONSABLE (persona asignada actualmente)
    CASE 
        WHEN asg.id_persona IS NOT NULL 
        THEN CONCAT(p.nombre, ' ', p.apellido)
        ELSE NULL
    END as responsable_nombre,
    
    p.correo as responsable_correo,
    p.dui as responsable_dui,
    r.nombre as responsable_rol,
    dep.nombre as responsable_departamento,
    
    -- UBICACIÓN COMPLETA (como pide el prompt)
    CASE 
        WHEN uf.nombre IS NOT NULL THEN
            CONCAT(
                COALESCE(uf.nombre, ''), 
                ' (', ed.nombre, ', ', 
                'Piso ', pi.numero_piso, ', ',
                ar.nombre, ')'
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
    
    -- ÚLTIMO MANTENIMIENTO (como pide el prompt)
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
        SELECT m.anotacion
        FROM mantenimientos m
        WHERE m.id_activo = a.id_activo
        AND m.fecha_fin IS NOT NULL
        ORDER BY m.fecha_fin DESC
        LIMIT 1
    ) as notas_ultimo_mantenimiento,
    
    -- Información financiera
    a.valor_adquisicion,
    a.fecha_adquisicion,
    
    -- Fechas de asignación
    asg.fecha_asignacion,
    asg.fecha_fin as fecha_fin_asignacion,
    asg.es_responsable_principal,
    
    -- Información adicional útil
    ca.vida_util_estimada_meses,
    ca.depreciable,
    
    -- Timestamp de consulta
    CURRENT_TIMESTAMP as fecha_consulta

FROM activos a

-- Tipo y categoría del activo
INNER JOIN tipos_activos ta ON a.id_tipo = ta.id_tipo
INNER JOIN categorias_activos ca ON ta.id_categoria = ca.id_categoria

-- Estado del activo
INNER JOIN estados_activos ea ON a.id_estado = ea.id_estado

-- Ubicación física (LEFT JOIN porque puede no tener ubicación)
LEFT JOIN ubicaciones_fisicas uf ON a.id_ubicacion_actual = uf.id_ubicacion
LEFT JOIN areas ar ON uf.id_area = ar.id_area
LEFT JOIN pisos pi ON ar.id_piso = pi.id_piso
LEFT JOIN edificios ed ON pi.id_edificio = ed.id_edificio

-- Asignación actual (LEFT JOIN porque puede no estar asignado)
LEFT JOIN asignaciones_activos asg ON a.id_activo = asg.id_activo 
    AND asg.estado = true 
    AND (asg.fecha_fin IS NULL OR asg.fecha_fin > CURRENT_DATE)

-- Persona responsable
LEFT JOIN personas p ON asg.id_persona = p.id_persona
LEFT JOIN roles r ON p.id_rol = r.id_rol
LEFT JOIN departamentos dep ON p.id_departamento = dep.id_departamento

-- Solo activos activos
WHERE ca.activo = true

ORDER BY a.codigo;

-- =================================================================
-- COMENTARIOS PARA EL DESARROLLADOR
-- =================================================================
-- Esta vista proporciona EXACTAMENTE los campos que el prompt menciona:
-- 
-- 1. nombre_completo_activo: Marca + Modelo + Tipo + Serie
-- 2. situacion_actual: "OCUPADO" | "DISPONIBLE EN STOCK" | "NO DISPONIBLE"
-- 3. responsable_nombre: Nombre completo de quien lo tiene
-- 4. ubicacion_completa: Formato legible con edificio, piso y área
-- 5. ultima_fecha_mantenimiento: Fecha del último mantenimiento
--
-- USO EN N8N:
-- SELECT * FROM vista_asistente_inventario
-- WHERE nombre_completo_activo ILIKE '%MacBook%'
-- 
-- O para ver todo:
-- SELECT * FROM vista_asistente_inventario
-- =================================================================
