### README - Sistema de Renovaciones SIIA

## 📋 Descripción del Proyecto

Este documento describe las mejoras implementadas en el **Sistema Integral de Información de Acreditaciones (SIIA)** para el módulo de renovaciones de acreditaciones. Las modificaciones corrigen problemas críticos en la lógica de renovación, validación de fechas, integridad de datos y controles de interfaz de usuario.

## 🎯 Objetivos

- ✅ Implementar validaciones robustas para el proceso de renovación
- ✅ Prevenir renovaciones duplicadas
- ✅ Corregir referencias históricas en la base de datos
- ✅ Mejorar la experiencia de usuario con controles apropiados
- ✅ Garantizar integridad de datos y trazabilidad completa

## 🔧 Modificaciones Implementadas

### 1. **Validación de Fechas en Renovaciones**
**Archivo**: `application/controllers/Solicitudes.php`

#### Funcionalidades:
- Validación automática de vigencia de resoluciones
- Actualización dinámica de estados según fechas
- Control de período de renovación (6 meses post-vencimiento)
- Logging detallado de operaciones

#### Código clave:
```php
// Validación de vigencia de resolución
if ($resolucion) {
    $fechaActual = new DateTime();
    $fechaFinResolucion = new DateTime($resolucion->fechaResolucionFinal);
    
    if ($fechaActual > $fechaFinResolucion) {
        $estadoSolicitudOriginal = 'Vencida';
    }
}
```

### 2. **Prevención de Renovaciones Duplicadas**
**Archivos**: 
- `application/models/SolicitudesModel.php`
- `application/views/user/modules/solicitudes/partials/_tabla_solicitudes.php`

#### Funcionalidades:
- Nueva función `solicitudYaRenovada()` en el modelo
- Verificación en tiempo real antes de mostrar botón "Renovar"
- Consulta a tabla `estadoOrganizaciones` usando `idSolicitudAcreditado`

#### Código clave:
```php
public function solicitudYaRenovada($idSolicitud)
{
    $renovacion = $this->db->select("*")
        ->from("estadoOrganizaciones")
        ->where('idSolicitudAcreditado', $idSolicitud)->get()->row();
    
    return $renovacion ? true : false;
}
```

### 3. **Corrección de Referencias Históricas**
**Archivo**: `application/database/scripts/script_fix_idSolicitudAcreditado.sql`

#### Funcionalidades:
- Corrección masiva de campo `idSolicitudAcreditado`
- Separación entre renovaciones y primeras acreditaciones
- Uso de tabla temporal para evitar errores MySQL
- Validaciones de seguridad incluidas

#### Estructura del script:
```sql
-- 1. Identificación de registros a corregir
-- 2. Creación de tabla temporal con valores correctos
-- 3. Actualización masiva de datos
-- 4. Limpieza y verificación
-- 5. Consultas de validación final
```

### 4. **Control de Botones de Interfaz**
**Archivo**: `application/views/user/modules/solicitudes/partials/_tabla_solicitudes.php`

#### Funcionalidades:
- Control granular del botón "Eliminar" según estado
- Separación de lógica para diferentes estados
- Consistencia total en la interfaz de usuario
- **NUEVO**: Validación diferenciada por `motivoSolicitud` para el botón "Renovar"

#### Matriz de control:
| Estado | tipoSolicitudAcreditado | Botón "Eliminar" | Botón "Renovar" |
|--------|------------------------|------------------|-----------------|
| En Proceso | Cualquier valor | ✅ Visible | ❌ No aplica |
| En Renovación | Cualquier valor | ❌ Oculto | ❌ No aplica |
| Finalizado | ≠ 'En Renovación' | ✅ Visible | ❌ No aplica |
| Finalizado | = 'En Renovación' | ❌ Oculto | ❌ No aplica |
| Acreditado | N/A | ❌ No aplica | ✅ Si cumple condiciones |
| Vencida | N/A | ❌ No aplica | ✅ Si cumple condiciones |

## 🎯 Validaciones del Botón "Renovar"

### Condiciones Obligatorias (todas deben cumplirse):

1. **Estado válido**: Solicitud debe estar "Acreditado" o "Vencida"
2. **Resolución existente**: Debe existir resolución asociada
3. **Período válido**: Dentro del período permitido según `motivoSolicitud`
4. **No renovada**: Sin renovación previa existente

### **NUEVA FUNCIONALIDAD**: Validación Diferenciada por Motivo de Solicitud

#### Períodos de Renovación por Tipo:

| Motivo de Solicitud | Período de Renovación | Ejemplo |
|---|---|---|
| **Programa organizaciones y redes SEAS.** (motivo 6) | 3 meses antes hasta 6 meses después del vencimiento | Si vence el 31/12/2024, se habilita desde el 01/10/2024 hasta el 30/06/2025 |
| **Otros motivos** | Hasta 12 meses después del vencimiento | Si vence el 31/12/2024, se habilita hasta el 31/12/2025 |

#### Compatibilidad con Formatos de Datos:
- **JSON array**: `["1", "2", "6"]` - busca el valor "6"
- **String separado por comas**: `"Motivo 1, Programa organizaciones y redes SEAS., Motivo 3"`

### Fórmula de validación:
```php
$mostrarBotonRenovar = $puedeRenovar && $dentroDelPeriodo && !$yaRenovada && $resolucion;
```

### Validaciones específicas implementadas:

#### **A. Validación de Estados**
```php
$estadosPermitidos = ['Acreditado', 'Vencida'];
$puedeRenovar = in_array($solicitud->nombre, $estadosPermitidos);
```

#### **B. Validación de Fechas Diferenciada**
```php
// Verificar si es Programa SEAS
$esProgramaSEAS = false;
if (!empty($solicitud->motivoSolicitud)) {
    $motivosArray = json_decode($solicitud->motivoSolicitud, true);
    if (is_array($motivosArray)) {
        $esProgramaSEAS = in_array('6', $motivosArray);
    } else {
        $esProgramaSEAS = strpos($solicitud->motivoSolicitud, 'Programa organizaciones y redes SEAS.') !== false;
    }
}

// Configurar período según el tipo
if ($esProgramaSEAS) {
    // Ventana ampliada: 3 meses antes hasta 6 meses después del vencimiento
    $fechaInicioRenovacion = clone $fechaFinResolucion;
    $fechaInicioRenovacion->modify('-3 months');
    $fechaLimiteRenovacion = clone $fechaFinResolucion;
    $fechaLimiteRenovacion->modify('+6 months');
    $dentroDelPeriodo = $fechaActual >= $fechaInicioRenovacion && $fechaActual <= $fechaLimiteRenovacion;
} else {
    // 12 meses después del vencimiento
    $fechaLimiteRenovacion = clone $fechaFinResolucion;
    $fechaLimiteRenovacion->modify('+12 months');
    $dentroDelPeriodo = $fechaActual <= $fechaLimiteRenovacion;
}
```

#### **C. Validación de Duplicados**
```php
$yaRenovada = $CI->SolicitudesModel->solicitudYaRenovada($solicitud->idSolicitud);
```

#### **D. Validación de Resolución**
```php
$resolucion = $CI->ResolucionesModel->getResolucionSolicitud($solicitud->idSolicitud);
if($resolucion): // Solo si existe resolución
```

---

## 📁 Estructura de Archivos Modificados

### **Archivos del Sistema Modificados**

```
application/
├── controllers/
│   └── Solicitudes.php          # Función renovarSolicitud() mejorada
├── models/
│   └── SolicitudesModel.php     # Validaciones de renovación
└── views/
    └── paneles/
        └── _tabla_solicitudes.php  # Lógica de botones mejorada
```

### **Scripts de Base de Datos**
```
application/database/scripts/
└── corregir_referencias_renovacion.sql  # Script de corrección histórica
```

---

## 🚀 Instalación y Uso

### **Prerrequisitos**
- PHP 7.4 o superior
- MySQL 5.7 o superior
- CodeIgniter 3.x
- Acceso a la base de datos SIIA

### **Pasos de Implementación**

1. **Backup de la Base de Datos**
   ```bash
   mysqldump -u usuario -p siia_db > backup_antes_renovaciones.sql
   ```

2. **Ejecutar Script de Corrección**
   ```sql
   -- Ejecutar en MySQL
   source application/database/scripts/corregir_referencias_renovacion.sql
   ```

3. **Verificar Archivos Modificados**
   - `application/controllers/Solicitudes.php`
   - `application/models/SolicitudesModel.php`
   - `application/views/paneles/_tabla_solicitudes.php`

4. **Pruebas de Funcionalidad**
   - Verificar botón "Renovar" en solicitudes acreditadas
   - Confirmar ocultación de botón "Eliminar" en renovaciones
   - Validar prevención de renovaciones duplicadas

---

## 🧪 Casos de Prueba

### **Caso 1: Renovación Exitosa**
- **Condición**: Solicitud "Acreditado" con resolución vigente
- **Resultado Esperado**: Botón "Renovar" visible y funcional
- **Validación**: Nueva solicitud creada con estado "En Renovación"

### **Caso 2: Prevención de Duplicados**
- **Condición**: Solicitud ya renovada anteriormente
- **Resultado Esperado**: Botón "Renovar" oculto
- **Validación**: Mensaje informativo sobre renovación existente

### **Caso 3: Validación de Fechas Diferenciada**
- **Condición A**: Programa SEAS - dentro de la ventana de 3 meses antes hasta 6 meses después del vencimiento
- **Resultado Esperado A**: Botón "Renovar" visible en toda la ventana de renovación
- **Condición B**: Otros programas - resolución vencida hace menos de 12 meses
- **Resultado Esperado B**: Botón "Renovar" visible hasta 12 meses post-vencimiento
- **Validación**: Comportamiento diferenciado según `motivoSolicitud`

## **Versión 2.2.0** - Validación Diferenciada por Motivo

### **Caso 5: Validación Específica Programa SEAS**
- **Condición**: Solicitud con motivo "Programa organizaciones y redes SEAS." a 2 meses del vencimiento
- **Resultado Esperado**: Botón "Renovar" visible
- **Validación**: Detección correcta del motivo 6 en JSON o string
- **Condición**: Solicitud con estado "En Renovación"
- **Resultado Esperado**: Botón "Eliminar" oculto
- **Validación**: Solo botones "Continuar" y "Detalle" visibles

---

## 📊 Métricas y Monitoreo

### **Indicadores de Rendimiento**
- **Renovaciones Exitosas**: Contador de renovaciones completadas
- **Duplicados Prevenidos**: Intentos de renovación bloqueados
- **Correcciones Históricas**: Registros corregidos por el script

### **Logs de Actividad**
```php
// Ejemplo de log en renovación
log_message('info', 'Renovación iniciada - ID Original: ' . $idSolicitud);
log_message('info', 'Nueva solicitud creada - ID: ' . $nuevoId);
```

### **Consultas de Monitoreo**
```sql
-- Solicitudes en renovación
SELECT COUNT(*) FROM solicitudes s 
JOIN tipoSolicitud ts ON s.idSolicitud = ts.idSolicitud 
WHERE ts.nombre = 'En Renovación';

-- Referencias corregidas
SELECT COUNT(*) FROM solicitudes 
WHERE idSolicitudAcreditado IS NOT NULL;
```

---

## 🔒 Seguridad y Validaciones

### **Validaciones de Entrada**
- Verificación de permisos de usuario
- Validación de existencia de solicitud original
- Comprobación de integridad de datos

### **Prevención de Errores**
- Transacciones de base de datos para operaciones críticas
- Validación de estados antes de permitir acciones
- Logs detallados para auditoría

### **Control de Acceso**
```php
// Verificación de permisos en renovación
if (!$this->session->userdata('logged_in')) {
    redirect('login');
}
```

---

## 🛠️ Mantenimiento

### **Tareas Periódicas**
1. **Revisión de Logs**: Monitorear errores en renovaciones
2. **Limpieza de Datos**: Verificar integridad de referencias
3. **Actualización de Estados**: Revisar solicitudes vencidas

### **Comandos de Mantenimiento**
```sql
-- Verificar integridad de renovaciones
SELECT s1.idSolicitud, s1.idSolicitudAcreditado, s2.idSolicitud as original
FROM solicitudes s1 
LEFT JOIN solicitudes s2 ON s1.idSolicitudAcreditado = s2.idSolicitud
WHERE s1.idSolicitudAcreditado IS NOT NULL;

-- Actualizar estados vencidos
UPDATE solicitudes s
JOIN tipoSolicitud ts ON s.idSolicitud = ts.idSolicitud
JOIN resoluciones r ON s.idSolicitud = r.idSolicitud
SET ts.nombre = 'Vencida'
WHERE ts.nombre = 'Acreditado' 
AND DATE_ADD(r.fechaFin, INTERVAL 6 MONTH) < CURDATE();
```

---

## 📞 Soporte y Contacto

### **Equipo de Desarrollo**
- **Desarrollador Principal**: Camilo Ríos
- **Email de Soporte**: soportetics@unidadsolidaria.gov.co
- **Documentación**: [URL de documentación interna]

### **Resolución de Problemas**
1. **Revisar logs** en `application/logs/`
2. **Verificar permisos** de base de datos
3. **Consultar documentación** técnica
4. **Contactar soporte** si persisten los problemas

---

## 📝 Notas de Versión

### **Versión 2.3.0** - Ampliación Ventana Programa SEAS
**Fecha**: Diciembre 2024

### **Nuevas Funcionalidades**
- **Ventana ampliada para Programa SEAS**: Extensión del período de renovación para "Programa organizaciones y redes SEAS." desde 3 meses antes hasta 6 meses después del vencimiento
- **Flexibilidad temporal mejorada**: Mayor margen para renovaciones del programa SEAS, facilitando la gestión administrativa

### **Mejoras Técnicas**
- Actualización de la lógica de validación temporal en `_tabla_solicitudes.php`
- Mantenimiento de compatibilidad con formatos JSON y string para `motivoSolicitud`
- Preservación de la validación de 12 meses post-vencimiento para otros programas

### **Impacto**
- Reducción de solicitudes perdidas por vencimiento en el programa SEAS
- Mayor flexibilidad operativa para organizaciones del programa SEAS
- Mantenimiento de controles estrictos para otros tipos de acreditación

--- de Solicitud**
- ✅ Validación de fechas diferenciada según `motivoSolicitud`
- ✅ Programa SEAS: renovación 3 meses antes del vencimiento
- ✅ Otros programas: renovación hasta 12 meses post-vencimiento
- ✅ Compatibilidad con formatos JSON y string separado por comas
- ✅ Detección automática del motivo 6 (Programa SEAS)
- ✅ Preparación para futuros motivos especiales

### **Versión 2.1.0 - Sistema de Renovaciones Mejorado**
- ✅ Validación de fechas de resolución
- ✅ Prevención de renovaciones duplicadas
- ✅ Corrección de referencias históricas
- ✅ Control mejorado de botones UI
- ✅ Logs detallados de actividad
- ✅ Script de corrección automática

### **Próximas Mejoras**
- [ ] Notificaciones automáticas de vencimiento diferenciadas por motivo
- [ ] Dashboard de métricas de renovación por programa
- [ ] API REST para renovaciones con validación de motivos
- [ ] Integración con sistema de alertas específicas por tipo
- [ ] Configuración dinámica de períodos de renovación por motivo

---

**© 2025 SIIA - Sistema Integral de Información de Acreditación**  
*Desarrollado para mejorar la gestión de renovaciones de acreditación*
