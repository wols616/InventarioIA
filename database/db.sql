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
