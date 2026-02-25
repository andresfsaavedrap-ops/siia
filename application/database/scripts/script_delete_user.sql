DELIMITER //

DROP PROCEDURE IF EXISTS EliminarOrganizacionCompleta//

CREATE PROCEDURE EliminarOrganizacionCompleta(
    IN p_id_organizacion INT
)
BEGIN
    DECLARE v_count INT DEFAULT 0;
    DECLARE v_usuario_id INT DEFAULT 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    -- Verificar que la organización existe
    SELECT COUNT(*) INTO v_count 
    FROM organizaciones 
    WHERE id_organizacion = p_id_organizacion;
    
    IF v_count = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La organización especificada no existe';
    END IF;
    
    -- Obtener el ID del usuario asociado
    SELECT usuarios_id_usuario INTO v_usuario_id 
    FROM organizaciones 
    WHERE id_organizacion = p_id_organizacion;
    
    START TRANSACTION;
    
    -- Desactivar verificación de claves foráneas temporalmente
    SET FOREIGN_KEY_CHECKS = 0;
    
    -- Eliminar registros de tablas relacionadas con informeactividades
    DELETE FROM certificaciones 
    WHERE informeActividades_id_informeActividades IN (
        SELECT id_informeActividades 
        FROM informeactividades 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    DELETE FROM historico_estado_informe 
    WHERE informeActividades_id_informeActividades IN (
        SELECT id_informeActividades 
        FROM informeactividades 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    DELETE FROM observaciones_informe 
    WHERE informeActividades_id_informeActividades IN (
        SELECT id_informeActividades 
        FROM informeactividades 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    -- Eliminar registros de tablas relacionadas con docentes
    DELETE FROM archivosdocente 
    WHERE docentes_id_docente IN (
        SELECT id_docente 
        FROM docentes 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    DELETE FROM observacionesdocente 
    WHERE docentes_id_docente IN (
        SELECT id_docente 
        FROM docentes 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    -- Eliminar registros de seguimiento (relacionados con visitas)
    DELETE FROM seguimiento 
    WHERE visitas_id_visitas IN (
        SELECT id_visitas 
        FROM visitas 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    -- Eliminar registros de historialresoluciones (relacionados con historial)
    DELETE FROM historialresoluciones 
    WHERE historial_id_historial IN (
        SELECT id_historial 
        FROM historial 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    -- Eliminar registros de asistentes (relacionados con informeactividades)
    DELETE FROM asistentes 
    WHERE informeActividades_id_informeActividades IN (
        SELECT id_informeActividades 
        FROM informeactividades 
        WHERE organizaciones_id_organizacion = p_id_organizacion
    );
    
    -- Eliminar registros directamente relacionados con organizaciones
    DELETE FROM antecedentesacademicos WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM archivos WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM certificadoexistencia WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM datosaplicacion WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM datosbasicosprogramas WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM datosenlinea WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM datosmodalidades WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM datosprogramas WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM documentacion WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM documentacionlegal WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM historial WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM informaciongeneral WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM jornadasactualizacion WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM observaciones WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM planmejoramiento WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM programasavalar WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM programasavaleconomia WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM registroeducativoprogramas WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM registrotelefonico WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM resoluciones WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM seguimientosimple WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM tiposolicitud WHERE organizaciones_id_organizacion = p_id_organizacion;
    DELETE FROM visitas WHERE organizaciones_id_organizacion = p_id_organizacion;
    
    -- Eliminar informes de actividades
    DELETE FROM informeactividades WHERE organizaciones_id_organizacion = p_id_organizacion;
    
    -- Eliminar docentes
    DELETE FROM docentes WHERE organizaciones_id_organizacion = p_id_organizacion;
    
    -- Eliminar token del usuario (si existe)
    IF v_usuario_id > 0 THEN
        DELETE FROM token WHERE usuarios_id_usuario = v_usuario_id;
    END IF;
    
    -- Eliminar la organización (esto eliminará automáticamente estadoorganizaciones y solicitudes por CASCADE)
    DELETE FROM organizaciones WHERE id_organizacion = p_id_organizacion;
    
    -- Eliminar el usuario asociado (si existe)
    IF v_usuario_id > 0 THEN
        DELETE FROM usuarios WHERE id_usuario = v_usuario_id;
    END IF;
    
    -- Reactivar verificación de claves foráneas
    SET FOREIGN_KEY_CHECKS = 1;
    
    COMMIT;
    
    SELECT CONCAT('Organización con ID ', p_id_organizacion, ' y usuario asociado eliminados exitosamente') AS mensaje;
    
END//

DELIMITER ;

CALL EliminarOrganizacionCompleta(433);

-- INSTRUCCIONES DE USO:
-- 1. Ejecuta este script para crear el procedimiento almacenado
-- 2. Para eliminar una organización específica, ejecuta:
--    CALL EliminarOrganizacionCompleta(ID_DE_LA_ORGANIZACION);
--    Ejemplo: CALL EliminarOrganizacionCompleta(433);
-- 3. Para eliminar el procedimiento después de usarlo (opcional):
--    DROP PROCEDURE IF EXISTS EliminarOrganizacionCompleta;

-- TABLAS INCLUIDAS (que SÍ tienen organizaciones_id_organizacion):
-- ✓ antecedentesacademicos
-- ✓ archivos  
-- ✓ certificadoexistencia
-- ✓ datosaplicacion
-- ✓ datosbasicosprogramas
-- ✓ datosenlinea
-- ✓ datosmodalidades
-- ✓ datosprogramas
-- ✓ documentacion
-- ✓ documentacionlegal
-- ✓ historial
-- ✓ informaciongeneral
-- ✓ jornadasactualizacion
-- ✓ observaciones
-- ✓ planmejoramiento
-- ✓ programasavalar
-- ✓ programasavaleconomia
-- ✓ registroeducativoprogramas
-- ✓ registrotelefonico
-- ✓ resoluciones
-- ✓ seguimientosimple
-- ✓ tiposolicitud
-- ✓ visitas
-- ✓ docentes
-- ✓ informeactividades

-- TABLAS EXCLUIDAS (que NO tienen organizaciones_id_organizacion):
-- ✗ bateriaobservaciones
-- ✗ correosregistro
-- ✗ encuesta
-- ✗ notificaciones

-- TABLAS CON CASCADE (se eliminan automáticamente):
-- → estadoorganizaciones (ON DELETE CASCADE)
-- → solicitudes (ON DELETE CASCADE)
