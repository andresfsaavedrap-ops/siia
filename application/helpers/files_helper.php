<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper mejorado para manejo de archivos del sistema
 */

/**
 * Función mejorada para crear archivos con validaciones robustas
 * @param array $file - Archivo $_FILES
 * @param array $metadata - Metadatos del archivo
 * @param array $config - Configuración adicional (opcional)
 * @return array - Resultado de la operación
 */
function create_file_enhanced($file, $metadata, $config = array())
{
    $CI = & get_instance();
    // Configuración por defecto
    $default_config = array(
        'max_size' => 10485760, // 10MB por defecto
        'allowed_types' => array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'),
        'create_directories' => true,
        'generate_unique_name' => false, // Cambiado a false para mantener nombres originales
        'save_to_db' => true
    );
	// Configuración personalizada
    $config = array_merge($default_config, $config);
    // Validar archivo
    $validation_result = validate_file($file, $config);
    if ($validation_result['success'] !== true) {
        return $validation_result;
    }
    // Determinar ruta según tipo
    $path_info = get_upload_path($metadata['tipo'], $metadata['nombre'], $config);
    if ($path_info['success'] !== true) {
        return $path_info;
    }
    // Preparar ruta de destino
    $upload_path = $path_info['path'];
    $directory = $path_info['directory'];
    // Crear directorio si no existe
    if ($config['create_directories'] && !is_dir($directory)) {
        if (!mkdir($directory, 0755, true)) {
            return array(
                'success' => false,
                'message' => 'No se pudo crear el directorio de destino'
            );
        }
    }
    // Mover archivo
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Guardar metadatos en BD si está configurado
        if ($config['save_to_db']) {
          /*   $metadata['ruta_archivo'] = $upload_path;
            $metadata['fecha_subida'] = date('Y-m-d H:i:s');
            $metadata['tamano_archivo'] = $file['size']; */
            if (!$CI->db->insert('archivos', $metadata)) {
                // Si falla la BD, eliminar archivo
                unlink($upload_path);
                return array(
                    'success' => false,
                    'message' => 'Error al guardar los metadatos del archivo'
                );
            }
        }
        return array(
            'success' => true,
            'message' => 'Archivo subido exitosamente',
            'file_path' => $upload_path,
            'file_url' => base_url($upload_path)
        );
    } else {
        return array(
            'success' => false,
            'message' => 'No se logró cargar el archivo en la ruta indicada'
        );
    }
}

/**
 * Validar archivo subido
 */
function validate_file($file, $config)
{
    // Verificar errores de subida
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error_messages = array(
            UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido por el servidor',
            UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo permitido por el formulario',
            UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente. Intente nuevamente',
            UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo',
            UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta la carpeta temporal',
            UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se puede escribir el archivo',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo'
        );
        $message = isset($error_messages[$file['error']])
            ? $error_messages[$file['error']]
            : 'Error desconocido al subir el archivo (código: ' . $file['error'] . ')';
        return array('success' => false, 'message' => $message);
    }
    // Validar tamaño
    if ($file['size'] > $config['max_size']) {
        $max_mb = round($config['max_size'] / 1048576, 1);
        return array(
            'success' => false,
            'message' => "El archivo excede el tamaño máximo permitido ({$max_mb}MB)"
        );
    }
    // Validar extensión
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, array_map('strtolower', $config['allowed_types']))) {
        $allowed = implode(', ', $config['allowed_types']);
        return array(
            'success' => false,
            'message' => "Extensión no permitida. Tipos permitidos: {$allowed}"
        );
    }
    return array('success' => true);
}

/**
 * Obtener ruta de subida según tipo de archivo
 */
function get_upload_path($tipo, $nombre, $config)
{
    $paths = array(
        'jornadaAct' => 'uploads/jornadas/',
        'carta' => 'uploads/cartaRep/',
        'autoevaluacion' => 'uploads/autoevaluaciones/',
        'certificadoExistencia' => 'uploads/certificadoExistencia/',
        'registroEdu' => 'uploads/registrosEducativos/',
        'system_logo' => 'uploads/system_logos/',
        'organizacion_logo' => 'uploads/logosOrganizaciones/',
        'documentos_generales' => 'uploads/documentos/',
        'resoluciones' => 'uploads/resoluciones/',
        'certificaciones' => 'uploads/certificaciones/'
    );
    if (!isset($paths[$tipo])) {
        return array(
            'success' => false,
            'message' => 'Tipo de archivo no soportado: ' . $tipo
        );
    }
    $directory = $paths[$tipo];
    // Generar nombre único si está configurado
    if ($config['generate_unique_name']) {
        $ext = pathinfo($nombre, PATHINFO_EXTENSION);
        $base_name = pathinfo($nombre, PATHINFO_FILENAME);
        $nombre = $base_name . '_' . uniqid() . '.' . $ext;
    }
    return array(
        'success' => true,
        'path' => $directory . $nombre,
        'directory' => $directory,
        'filename' => $nombre
    );
}

/**
 * Cargar archivo - Función original mejorada (mantener compatibilidad)
 */
function create_file($file, $metadata)
{
    // Usar la nueva función con configuración por defecto para PDFs
    $config = array(
        'max_size' => 10485760, // 10MB
        'allowed_types' => array('pdf'),
        'save_to_db' => true
    );
    return create_file_enhanced($file, $metadata, $config);
}

/**
 * Borrar archivo
 */
function delete_file($tipo, $nombre, $id_archivo, $id_formulario)
{
	$CI = & get_instance();
	// Eliminar archivo físico
	switch ($tipo) {
		case "carta":
			if (file_exists('uploads/cartaRep/' . $nombre)) {
				unlink('uploads/cartaRep/' . $nombre);
			}
			break;
		case "certificaciones":
			if (file_exists('uploads/certificaciones/' . $nombre)) {
				unlink('uploads/certificaciones/' . $nombre);
			}
			break;
		case "lugar":
			if (file_exists('uploads/lugarAtencion/' . $nombre)) {
				unlink('uploads/lugarAtencion/' . $nombre);
			}
			break;
		case "autoevaluacion":
			if (file_exists('uploads/autoevaluaciones/' . $nombre)) {
				unlink('uploads/autoevaluaciones/' . $nombre);
			}
			break;
		case "registroEdu":
			if (file_exists('uploads/registrosEducativos/' . $nombre)) {
				unlink('uploads/registrosEducativos/' . $nombre);
			}
			break;
		case "jornadaAct":
			if (file_exists('uploads/jornadas/' . $nombre)) {
				unlink('uploads/jornadas/' . $nombre);
			}
			break;
		case "materialDidacticoProgBasicos":
			if (file_exists('uploads/materialDidacticoProgBasicos/' . $nombre)) {
				unlink('uploads/materialDidacticoProgBasicos/' . $nombre);
			}
			break;
		case "materialDidacticoAvalEconomia":
			if (file_exists('uploads/materialDidacticoAvalEconomia/' . $nombre)) {
				unlink('uploads/materialDidacticoAvalEconomia/' . $nombre);
			}
			break;
		case "formatosEvalProgAvalar":
			if (file_exists('uploads/formatosEvalProgAvalar/' . $nombre)) {
				unlink('uploads/formatosEvalProgAvalar/' . $nombre);
			}
			break;
		case "materialDidacticoProgAvalar":
			if (file_exists('uploads/materialDidacticoProgAvalar/' . $nombre)) {
				unlink('uploads/materialDidacticoProgAvalar/' . $nombre);
			}
			break;
		case "instructivoPlataforma":
			if (file_exists('uploads/instructivosPlataforma/' . $nombre)) {
				unlink('uploads/instructivosPlataforma/' . $nombre);
			}
			break;
		case "certificadoExistencia":
			if (file_exists('uploads/certificadoExistencia/' . $nombre)) {
				unlink('uploads/certificadoExistencia/' . $nombre);
			}
			break;
		case "resoluciones":
			if (file_exists('uploads/resoluciones/' . $nombre)) {
				unlink('uploads/resoluciones/' . $nombre);
			}
			break;
	}
	// Eliminar registro de base de datos, solo si se reciben IDs válidos
	if (!empty($id_archivo) && !empty($id_formulario)) {
		if (method_exists($CI, 'load')) {
			$CI->load->database();
		}
		$CI->db->where('id_archivo', $id_archivo)->where('id_formulario', $id_formulario);
		if ($CI->db->delete('archivos')) {
			echo json_encode(array('msg' => "Se elimino el archivo."));
		}
	}
}
?>


