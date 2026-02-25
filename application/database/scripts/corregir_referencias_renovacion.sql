-- Script para corregir idSolicitudAcreditado en organizaciones acreditadas
-- Versión corregida que evita el error MySQL 1093

-- Paso 1: Crear una tabla temporal con los valores correctos para renovaciones
CREATE TEMPORARY TABLE temp_corrections AS
SELECT 
    e1.id_estadoOrganizacion,
    e1.idSolicitud as solicitud_actual,
    e1.idSolicitudAcreditado as id_actual_incorrecto,
    s_anterior.idSolicitud as id_correcto
FROM estadoorganizaciones e1
JOIN solicitudes s_actual ON e1.idSolicitud = s_actual.idSolicitud
JOIN solicitudes s_anterior ON s_actual.organizaciones_id_organizacion = s_anterior.organizaciones_id_organizacion
JOIN estadoorganizaciones e_anterior ON s_anterior.idSolicitud = e_anterior.idSolicitud
WHERE e1.nombre = 'Acreditado'  -- Organizaciones actualmente acreditadas
AND e1.idSolicitudAcreditado = e1.idSolicitud  -- Solo registros incorrectos (apuntan a sí mismos)
AND e1.tipoSolicitudAcreditado != 'Acreditación Primera vez'  -- Solo renovaciones
AND s_anterior.fechaCreacion < s_actual.fechaCreacion  -- Solicitud anterior en el tiempo
AND e_anterior.nombre IN ('Acreditado', 'Vencida')  -- Estados válidos de la solicitud anterior
AND s_anterior.idSolicitud = (
    -- Obtener la solicitud anterior más reciente que estuvo acreditada
    SELECT MAX(s2.idSolicitud)
    FROM solicitudes s2
    JOIN estadoorganizaciones e2 ON s2.idSolicitud = e2.idSolicitud
    WHERE s2.organizaciones_id_organizacion = s_actual.organizaciones_id_organizacion
    AND s2.fechaCreacion < s_actual.fechaCreacion
    AND e2.nombre IN ('Acreditado', 'Vencida')
);

-- Crear tabla temporal para solicitudes nuevas sin anterior acreditada
CREATE TEMPORARY TABLE temp_solicitudes_nuevas AS
SELECT 
    e.id_estadoOrganizacion,
    e.idSolicitud as solicitud_actual
FROM estadoorganizaciones e
JOIN solicitudes s ON e.idSolicitud = s.idSolicitud
WHERE e.nombre = 'Acreditado'
AND e.tipoSolicitudAcreditado = 'Solicitud Nueva'
AND e.idSolicitudAcreditado = e.idSolicitud
AND NOT EXISTS (
    -- Verificar que NO existe una solicitud anterior acreditada o vencida
    SELECT 1
    FROM solicitudes s_anterior
    JOIN estadoorganizaciones e_anterior ON s_anterior.idSolicitud = e_anterior.idSolicitud
    WHERE s_anterior.organizaciones_id_organizacion = s.organizaciones_id_organizacion
    AND s_anterior.fechaCreacion < s.fechaCreacion
    AND e_anterior.nombre IN ('Acreditado', 'Vencida')
);

-- Paso 2: Mostrar qué se va a corregir (renovaciones)
SELECT 
    'RENOVACIONES A CORREGIR' as tipo,
    tc.solicitud_actual,
    tc.id_actual_incorrecto,
    tc.id_correcto,
    o.nombreOrganizacion,
    s.fechaCreacion as fecha_solicitud_actual,
    s_ant.fechaCreacion as fecha_solicitud_anterior
FROM temp_corrections tc
JOIN solicitudes s ON tc.solicitud_actual = s.idSolicitud
JOIN solicitudes s_ant ON tc.id_correcto = s_ant.idSolicitud
JOIN organizaciones o ON s.organizaciones_id_organizacion = o.id_organizacion

UNION ALL

-- Mostrar primeras acreditaciones que se van a limpiar
SELECT 
    'PRIMERAS ACREDITACIONES A LIMPIAR' as tipo,
    e.idSolicitud as solicitud_actual,
    e.idSolicitudAcreditado as id_actual_incorrecto,
    NULL as id_correcto,
    o.nombreOrganizacion,
    s.fechaCreacion as fecha_solicitud_actual,
    NULL as fecha_solicitud_anterior
FROM estadoorganizaciones e
JOIN solicitudes s ON e.idSolicitud = s.idSolicitud
JOIN organizaciones o ON s.organizaciones_id_organizacion = o.id_organizacion
WHERE e.nombre = 'Acreditado'
AND e.tipoSolicitudAcreditado = 'Acreditación Primera vez'
AND e.idSolicitudAcreditado = e.idSolicitud

UNION ALL

-- Mostrar solicitudes nuevas sin anterior acreditada que se van a limpiar
SELECT 
    'SOLICITUDES NUEVAS SIN ANTERIOR ACREDITADA A LIMPIAR' as tipo,
    tsn.solicitud_actual,
    e.idSolicitudAcreditado as id_actual_incorrecto,
    NULL as id_correcto,
    o.nombreOrganizacion,
    s.fechaCreacion as fecha_solicitud_actual,
    NULL as fecha_solicitud_anterior
FROM temp_solicitudes_nuevas tsn
JOIN estadoorganizaciones e ON tsn.id_estadoOrganizacion = e.id_estadoOrganizacion
JOIN solicitudes s ON tsn.solicitud_actual = s.idSolicitud
JOIN organizaciones o ON s.organizaciones_id_organizacion = o.id_organizacion;

-- Paso 3: Realizar las actualizaciones

-- 3a: Corregir renovaciones con la solicitud anterior correcta y marcar como renovadas
UPDATE estadoorganizaciones e1
JOIN temp_corrections tc ON e1.id_estadoOrganizacion = tc.id_estadoOrganizacion
SET e1.idSolicitudAcreditado = tc.id_correcto,
    e1.renovada = 'Si';

-- 3b: Limpiar idSolicitudAcreditado para primeras acreditaciones y marcar como no renovadas
UPDATE estadoorganizaciones 
SET idSolicitudAcreditado = NULL,
    renovada = 'No'
WHERE nombre = 'Acreditado'
AND tipoSolicitudAcreditado = 'Acreditación Primera vez'
AND idSolicitudAcreditado = idSolicitud;

-- 3c: Limpiar idSolicitudAcreditado para solicitudes donde la anterior no está acreditada ni vencida y marcar como no renovadas
UPDATE estadoorganizaciones e1
JOIN temp_solicitudes_nuevas tsn ON e1.id_estadoOrganizacion = tsn.id_estadoOrganizacion
SET e1.idSolicitudAcreditado = NULL,
    e1.renovada = 'No';

-- Paso 4: Limpiar tablas temporales
DROP TEMPORARY TABLE temp_corrections;
DROP TEMPORARY TABLE temp_solicitudes_nuevas;

-- Verificación final: Mostrar todos los registros acreditados después de las correcciones
SELECT 
    e.idSolicitud as solicitud_actual,
    e.idSolicitudAcreditado as solicitud_anterior,
    e.tipoSolicitudAcreditado as tipo,
    e.nombre as estado_actual,
    e.renovada as es_renovacion,
    o.nombreOrganizacion,
    s_actual.fechaCreacion as fecha_solicitud_actual,
    CASE 
        WHEN e.idSolicitudAcreditado IS NULL THEN 'PRIMERA ACREDITACIÓN (NULL)'
        ELSE s_anterior.fechaCreacion 
    END as fecha_solicitud_anterior
FROM estadoorganizaciones e
JOIN solicitudes s_actual ON e.idSolicitud = s_actual.idSolicitud
LEFT JOIN solicitudes s_anterior ON e.idSolicitudAcreditado = s_anterior.idSolicitud
JOIN organizaciones o ON s_actual.organizaciones_id_organizacion = o.id_organizacion
WHERE e.nombre = 'Acreditado'
ORDER BY o.nombreOrganizacion, s_actual.fechaCreacion;
