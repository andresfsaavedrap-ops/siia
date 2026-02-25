
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
/**
 * Controlador para gestión de docentes/facilitadores
 * Maneja CRUD de docentes, archivos y validaciones
 */
class Docentes extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // Cargar modelos específicos del controlador
        $this->load->model('DocentesModel');
        $this->load->model('InformacionGeneralModel');
    }
    /**
     * Datos de sesión para usuarios regulares
     * @return array
     */
    public function datosSession()
    {
        $baseData = $this->getBaseSessionData(false);
        $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
        // Obtener docentes
        $docentes = $this->DocentesModel->getDocentes($organizacion->id_organizacion);
        // Agregar información de documentos faltantes a cada docente
        foreach ($docentes as $docente) {
            $documentos_status = $this->verificarDocumentosFaltantes($docente->id_docente, true);
            $docente->documentos_completos = $documentos_status['completo'];
            $docente->documentos_faltantes = $documentos_status['documentos_faltantes'];
            $docente->total_documentos_faltantes = count($documentos_status['documentos_faltantes']);
        }
        $additionalData = array('docentes' => $docentes);
        return $this->addControllerSpecificData($baseData, $additionalData);
    }
    /**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
    /**
     * Vista principal de docentes
     */
    public function index()
    {
        $data = $this->datosSession();
        $data['informacionGeneral'] = $this->InformacionGeneralModel->getInformacionGeneral(($data['organizacion']->id_organizacion));
        $data['title'] = 'Panel Principal - Facilitadores';
        $data['activeLink'] = 'facilitadores';
        $this->loadView('user/modules/docentes/index', $data, 'main');
    }
    /**
     * Crear nuevo docente
     */
    public function anadirNuevoDocente()
    {
        $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
        $data_docentes = array(
            'primerNombreDocente' => $this->input->post("primer_nombre"),
            'segundoNombreDocente' => $this->input->post("segundo_nombre"),
            'primerApellidoDocente' => $this->input->post("primer_apellido"),
            'segundoApellidoDocente' => $this->input->post("segundo_apellido"),
            'numCedulaCiudadaniaDocente' => $this->input->post("cedula"),
            'profesion' => $this->input->post("profesion"),
            'horaCapacitacion' => $this->input->post("horas"),
            'valido' => 0,
            'organizaciones_id_organizacion' => $organizacion->id_organizacion
        );
        if ($this->db->insert('docentes', $data_docentes)) {
            echo json_encode(array('status' => "success", 'msg' => "Información de docente guardada exitosamente."));
        };
    }
    /**
     * Actualizar información de docente
     */
    public function actualizarDocente()
    {
        // Obtener datos de organización
        $usuario_id = $this->session->userdata('usuario_id');
        $datos_organizacion = $this->db->select("*")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
        $id_organizacion = $datos_organizacion->id_organizacion;
        $nombreOrganizacion = $datos_organizacion->nombreOrganizacion;
        // Datos del docente
        $id_docente = $this->input->post("id_docente");
        $solicitud = $this->input->post("solicitud");
        $informacionDocente = $this->db->select("*")->from("docentes")->where("id_docente", $id_docente)->get()->row();
        // Gestionar estado de asignación
        $asignado = $informacionDocente->asignado;
        if ($asignado == NULL && $informacionDocente->valido == "0") {
            $asignado = "No";
        }
        // Datos para actualización
        $data_update = array(
            'primerNombreDocente' => $this->input->post("primer_nombre_doc"),
            'segundoNombreDocente' => $this->input->post("segundo_nombre_doc"),
            'primerApellidoDocente' => $this->input->post("primer_apellido_doc"),
            'segundoApellidoDocente' => $this->input->post("segundo_apellido_doc"),
            'numCedulaCiudadaniaDocente' => $this->input->post("numero_cedula_doc"),
            'profesion' => $this->input->post("profesion_doc"),
            'horaCapacitacion' => $this->input->post("horas_doc"),
            //'observacion' => "Facilitador actualizado.",
            'observacionAnterior' => $informacionDocente->observacion,
            'asignado' => $asignado,
        );

        $where = array('organizaciones_id_organizacion' => $id_organizacion, 'id_docente' => $id_docente);
        $this->db->where($where);
        if ($this->db->update('docentes', $data_update)) {
            $this->logs_sia->session_log('Docentes Actualizados');
            // Enviar solicitud si es requerido
            if ($solicitud == "Si") {
                if ($informacionDocente->valido == "0") {
                    $this->notif_sia->notification('Docentes', 'admin', $nombreOrganizacion);
                    if ($asignado != NULL || $asignado == "No") {
                        $this->envilo_mailadmin("actualizacion", "2", $numero_cedula_doc);
                    }
                }
            } else {
                echo json_encode(array("msg" => "Docente " . $data_update['primerNombreDocente'] . " " . $data_update['primerApellidoDocente'] . " Actualizado."));
            }
        }
    }
    /**
     * Eliminar docente y sus archivos
     */
    public function eliminarDocente()
    {
        $id_docente = $this->input->post("id_docente");
        $archivos = $this->db->select("*")->from("archivosDocente")->where("docentes_id_docente", $id_docente)->get()->result();
        // Eliminar archivos físicos
        foreach ($archivos as $archivo) {
            $nombre = $archivo->nombre;
            $tipo = $archivo->tipo;
            $id_archivosDocente = $archivo->id_archivosDocente;
            $rutas = array(
                "docenteHojaVida" => 'uploads/docentes/hojasVida/',
                "docenteTitulo" => 'uploads/docentes/titulos/',
                "docenteCertificados" => 'uploads/docentes/certificados/',
                "docenteCertificadosEconomia" => 'uploads/docentes/certificadosEconomia/'
            );
            if (isset($rutas[$tipo])) {
                unlink($rutas[$tipo] . $nombre);
                $this->db->where('id_archivosDocente', $id_archivosDocente)->where('docentes_id_docente', $id_docente);
                $this->db->delete('archivosDocente');
            }
        }
        $this->db->where("id_docente", $id_docente);
        if ($this->db->delete('docentes')) {
            echo json_encode(array("msg" => "Docente eliminado de su organización."));
        }
    }
    /**
     * Guardar archivo hoja de vida
     */
    public function guardarArchivoHojaVidaDocente()
    {
        $this->procesarArchivoDocente('docenteHojaVida', 'uploads/docentes/hojasVida');
    }
    /**
     * Guardar archivo título profesional
     */
    public function guardarArchivoTituloDocente()
    {
        $this->procesarArchivoDocente('docenteTitulo', 'uploads/docentes/titulos');
    }
    /**
     * Guardar archivo certificados
     */
    public function guardarArchivoCertificadosDocente()
    {
        $this->procesarArchivoDocente('docenteCertificados', 'uploads/docentes/certificados');
    }
    /**
     * Guardar archivo certificados economía
     */
    public function guardarArchivoCertificadoEconomiaDocente()
    {
        $this->procesarArchivoDocente('docenteCertificadosEconomia', 'uploads/docentes/certificadosEconomia');
    }
    /**
     * Procesar subida de archivos (método auxiliar mejorado)
     */
    private function procesarArchivoDocente($tipoArchivo, $ruta)
    {
        $append_name = $this->input->post('append_name');
        $id_docente = $this->input->post('id_docente');
        $name_random = random(10);
        $size = 100000000; // 100MB
        $nombre_imagen = $append_name . "_" . $name_random . "_" . $_FILES['file']['name'];
        $tipo_archivo = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

        // Validación: solo permitir una Hoja de vida por docente
        if ($tipoArchivo === 'docenteHojaVida') {
            $existeHV = $this->db->select("COUNT(*) as cnt")
                ->from("archivosDocente")
                ->where("docentes_id_docente", $id_docente)
                ->where("tipo", "docenteHojaVida")
                ->get()->row()->cnt;
            if ($existeHV >= 1) {
                echo json_encode(array(
                    'url' => "",
                    'msg' => "El docente ya tiene una Hoja de vida. Debe eliminar el archivo existente antes de subir uno nuevo.",
                    'status' => 0
                ));
                return; // No continuar con inserción ni movimiento de archivo
            }
        }

        $data_update = array(
            'tipo' => $tipoArchivo,
            'nombre' => $nombre_imagen,
            'docentes_id_docente' => $id_docente
        );
        // Validaciones
        if (0 < $_FILES['file']['error']) {
            echo json_encode(array('url' => "", 'msg' => "Hubo un error al actualizar, intente de nuevo.", "status" => 0));
        } else if ($_FILES['file']['size'] > $size) {
            echo json_encode(array('url' => "", 'msg' => "El tamaño supera las 10 Mb, intente con otro archivo PDF.", "status" => 0));
        } else if ($tipo_archivo != "pdf") {
            echo json_encode(array('url' => "", 'msg' => "La extensión del archivo no es correcta, debe ser PDF. (archivo.pdf)", "status" => 0));
        } else if ($this->db->insert('archivosDocente', $data_update)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta . '/' . $nombre_imagen)) {
                // Verificar documentos faltantes después de guardar
                $verificacion = $this->verificarDocumentosFaltantes($id_docente, true);
                $mensaje = "Se guardó el " . $append_name;
                if (!$verificacion['completo']) {
                    $mensaje .= ". Aún faltan documentos por cargar.";
                } else {
                    $mensaje .= ". ¡Documentación completa!";
                }
                echo json_encode(array(
                    'url' => "",
                    'msg' => $mensaje,
                    "status" => 1,
                    'documentos_status' => $verificacion
                ));
            } else {
                echo json_encode(array('url' => "", 'msg' => "No se guardó el archivo(s).", "status" => 0));
            }
        }
        $this->logs_sia->logs('URL_TYPE');
        $this->logs_sia->logQueries();
    }
    /**
     * Eliminar archivo de docente
     */
    public function eliminarArchivoDocente()
    {
        $id_docente = $this->input->post('id_docente');
        $docente = $this->db->select('valido')->from('docentes')->where('id_docente', (int)$id_docente)->get()->row();
        if ($docente && (string)$docente->valido === '1') {
            echo json_encode(array('url' => "", 'msg' => 'No se puede eliminar: el facilitador está validado. Use “Editar cargue”.', 'status' => 0));
            return;
        }
        $tipo = $this->input->post('tipo');
        $nombre = $this->input->post('nombre');
        $rutas_tipos = array(
            "docenteHojaVida" => array('ruta' => 'uploads/docentes/hojasVida/', 'msg' => 'hoja de vida'),
            "docenteTitulo" => array('ruta' => 'uploads/docentes/titulos/', 'msg' => 'titulo profesional'),
            "docenteCertificados" => array('ruta' => 'uploads/docentes/certificados/', 'msg' => 'certificado experiencia'),
            "docenteCertificadosEconomia" => array('ruta' => 'uploads/docentes/certificadosEconomia/', 'msg' => 'certificado economía solidaria')
        );
        if (isset($rutas_tipos[$tipo])) {
            unlink($rutas_tipos[$tipo]['ruta'] . $nombre);
            $msg = "Se elimino el archivo de tipo " . $rutas_tipos[$tipo]['msg'] . " con éxito";
        }
        $this->db->where('id_archivosDocente', $this->input->post('id_archivoDocente'))->where('docentes_id_docente', $this->input->post('id_docente'));
        if ($this->db->delete('archivosDocente')) {
            echo json_encode(array('url' => "", 'msg' => $msg, 'status' => 1));
        }
    }

    public function reemplazarArchivoDocente()
    {
        $id_archivo = $this->input->post('id_archivoDocente');
        $id_docente = $this->input->post('id_docente');
        $tipo = $this->input->post('tipo');
        $append_name = $this->input->post('append_name');
        $size = 100000000;

        if (!$id_archivo || !$id_docente || !isset($_FILES['file'])) {
            echo json_encode(array('url' => "", 'msg' => 'Datos incompletos para reemplazar el archivo.', 'status' => 0));
            return;
        }

        $rutas_tipos = array(
            "docenteHojaVida" => array('ruta' => 'uploads/docentes/hojasVida/'),
            "docenteTitulo" => array('ruta' => 'uploads/docentes/titulos/'),
            "docenteCertificados" => array('ruta' => 'uploads/docentes/certificados/'),
            "docenteCertificadosEconomia" => array('ruta' => 'uploads/docentes/certificadosEconomia/')
        );

        $registro = $this->db->select("*")
            ->from("archivosDocente")
            ->where("id_archivosDocente", $id_archivo)
            ->where("docentes_id_docente", $id_docente)
            ->get()->row();

        if (!$registro) {
            echo json_encode(array('url' => "", 'msg' => 'No se encontró el archivo a reemplazar.', 'status' => 0));
            return;
        }

        if (!$tipo) {
            $tipo = $registro->tipo;
        }
        if (!isset($rutas_tipos[$tipo])) {
            echo json_encode(array('url' => "", 'msg' => 'Tipo de archivo inválido.', 'status' => 0));
            return;
        }

        $ruta = $rutas_tipos[$tipo]['ruta'];

        if (0 < $_FILES['file']['error']) {
            echo json_encode(array('url' => "", 'msg' => 'Hubo un error al actualizar, intente de nuevo.', 'status' => 0));
            return;
        }
        if ($_FILES['file']['size'] > $size) {
            echo json_encode(array('url' => "", 'msg' => 'El tamaño supera las 10 Mb, intente con otro archivo PDF.', 'status' => 0));
            return;
        }

        $name_random = random(10);
        $append = $append_name ? $append_name : $tipo;
        $nuevo_nombre = $append . "_" . $name_random . "_" . $_FILES['file']['name'];
        $extension = pathinfo($nuevo_nombre, PATHINFO_EXTENSION);
        if (strtolower($extension) !== 'pdf') {
            echo json_encode(array('url' => "", 'msg' => 'La extensión del archivo no es correcta, debe ser PDF. (archivo.pdf)', 'status' => 0));
            return;
        }

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $ruta . $nuevo_nombre)) {
            echo json_encode(array('url' => "", 'msg' => 'No se pudo guardar el nuevo archivo.', 'status' => 0));
            return;
        }

        if (!empty($registro->nombre)) {
            @unlink($ruta . $registro->nombre);
        }

        $this->db->where('id_archivosDocente', $id_archivo)
            ->where('docentes_id_docente', $id_docente)
            ->update('archivosDocente', array('nombre' => $nuevo_nombre));

        $verificacion = $this->verificarDocumentosFaltantes((int)$id_docente, true);
        echo json_encode(array(
            'url' => "",
            'msg' => 'Archivo reemplazado correctamente.',
            'status' => 1,
            'documentos_status' => $verificacion
        ));
    }
    /**
     * Cargar archivos de un docente específico con verificación de documentos
     */
    public function cargarDatosArchivosDocente()
    {
        $id_docente = $this->input->post('id_docente');
        $data_archivos = $this->db->select("*")->from("archivosDocente")->where('docentes_id_docente', $id_docente)->get()->result();
        // Incluir verificación de documentos faltantes
        $verificacion = $this->verificarDocumentosFaltantes($id_docente, true);
        echo json_encode(array(
            'archivos' => $data_archivos,
            'documentos_status' => $verificacion
        ));
    }
    /**
     * Cargar información de un docente específico
     */
    public function cargarDocente()
    {
        $docente = $this->DocentesModel->getDocente($this->input->post("id_docente"));
        echo json_encode($docente);
    }
    /** Cargar información completa del docente */
    public function cargarInformacionDocente()
    {
        $usuario_id = $this->session->userdata('usuario_id');
        $datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
        $id_docente = $this->input->post('id_docente');
        $informacionDocente = $this->db->select("*")->from("docentes")->where("id_docente", $id_docente)->get()->row();
        echo json_encode($informacionDocente);
    }
    /** Cargar información general de la organización */
    public function cargarDatos_informacion_general()
    {
        $usuario_id = $this->session->userdata('usuario_id');
        $datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
        $id_organizacion = $datos_organizacion->id_organizacion;
        return $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
    }
	/** Verificar documentos faltantes por docente
     * @param int $id_docente ID del docente a verificar
     * @param bool $return_array Si true retorna array, si false retorna HTML
     * @return array|string Array con información o HTML formateado
     */
    public function verificarDocumentosFaltantes($id_docente = null, $return_array = false)
    {
        // Si no se proporciona ID, usar el del POST
        if ($id_docente === null) {
            $id_docente = $this->input->post('id_docente');
        }
        $contadores = array(
            'hojas' => 0,
            'titulos' => 0,
            'certEcos' => 0,
            'certs' => 0
        );
        // Obtener archivos del docente
        $archivos = $this->db->select("*")
            ->from("archivosDocente")
            ->where('docentes_id_docente', $id_docente)
            ->get()->result();
        
        // Contar documentos por tipo
        foreach ($archivos as $archivo) {
            switch ($archivo->tipo) {
                case "docenteHojaVida":
                    $contadores['hojas']++;
                    break;
                case 'docenteTitulo':
                    $contadores['titulos']++;
                    break;
                case 'docenteCertificadosEconomia':
                    $contadores['certEcos']++;
                    break;
                case 'docenteCertificados':
                    $contadores['certs']++;
                    break;
            }
        }
        // Verificar documentos faltantes
        $documentosFaltantes = array();
        $requerimientos = array(
            'hojas' => array('nombre' => 'Hoja de vida', 'requerido' => 1),
            'titulos' => array('nombre' => 'Título académico', 'requerido' => 1),
            'certEcos' => array('nombre' => 'Certificado de economía', 'requerido' => 1),
            'certs' => array('nombre' => 'Certificados generales', 'requerido' => 3)
        );
        foreach ($requerimientos as $key => $req) {
            if ($contadores[$key] < $req['requerido']) {
                $documentosFaltantes[] = array(
                    'tipo' => $key,
                    'nombre' => $req['nombre'],
                    'tiene' => $contadores[$key],
                    'requiere' => $req['requerido'],
                    'faltante' => $req['requerido'] - $contadores[$key]
                );
            }
        }
        // Retornar según el parámetro
        if ($return_array) {
            return array(
                'contadores' => $contadores,
                'documentos_faltantes' => $documentosFaltantes,
                'completo' => empty($documentosFaltantes)
            );
        } else {
            // Retornar HTML formateado
            if (empty($documentosFaltantes)) {
                return "<div class='alert alert-success'><i class='fa fa-check'></i> Documentación completa</div>";
            } else {
                $html = "<div class='alert alert-warning'>";
                $html .= "<i class='fa fa-exclamation-triangle'></i> <strong>Documentos faltantes:</strong><ul class='mb-0 mt-2'>";
                foreach ($documentosFaltantes as $faltante) {
                    $html .= "<li>{$faltante['nombre']}: tiene {$faltante['tiene']}, requiere {$faltante['requiere']}</li>";
                }
                $html .= "</ul></div>";
                return $html;
            }
        }
    }
    /**
     * Endpoint AJAX para verificar documentos faltantes
     */
    public function verificarDocumentosAjax()
    {
        $id_docente = $this->input->post('id_docente');
        $resultado = $this->verificarDocumentosFaltantes($id_docente, true);
        echo json_encode($resultado);
    }
    /**
     * Refrescar lista de docentes y resumen (AJAX)
     * Devuelve el partial 'user/modules/docentes/partials/_docentes' renderizado.
     */
    public function refrescarDocentesAjax()
    {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(['status' => 0, 'msg' => 'Petición inválida']);
            return;
        }
    
        // Cargar datos de sesión y docentes como en index
        $data = $this->datosSession();
    
        // Renderizar el partial a HTML
        $html = $this->load->view('user/modules/docentes/partials/_docentes', $data, true);
    
        echo json_encode(['status' => 1, 'html' => $html]);
    }
	 /**
     * Enviar notificación por email al administrador
     */

    function envilo_mailadmin($type, $prioridad, $docente)
	{
        $usuario_id = $this->session->userdata('usuario_id');
        $organizacion = $this->db->select("*")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
        $docente = $this->db->select("*")->from("docentes")->where("numCedulaCiudadaniaDocente", $docente)->get()->row();
        switch ($type) {
            case 'actualizacion':
                $asunto = "Actualización Docente";
                $mensaje = "La organización <strong>" . $organizacion->nombreOrganizacion . "</strong>: Realizo una solicitud para actualización del facilitador <strong>" . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . "</strong>, por favor ingrese al sistema para asignar dicha solicitud, gracias. 
					<br/><br/>
					<label>Datos de recepción:</label> <br/>
					Fecha de recepcion de solicitud: <strong>" . date("Y-m-d h:m:s") . "</strong>. <br/>";
                break;
            default:
                $asunto = "";
                $mensaje = "";
                break;
        }
        // Configurar y enviar email
        $this->email->from(CORREO_SIA, "Acreditaciones");
        $this->email->to(CORREO_SIA);
        $this->email->cc(CORREO_SIA);
        $this->email->subject('SIIA: ' . $asunto);
        $this->email->set_priority($prioridad);
        $data_msg['mensaje'] = $mensaje;
        $email_view = $this->load->view('email/contacto', $data_msg, true);
        $this->email->message($email_view);
        if ($this->email->send()) {
            echo json_encode(array("msg" => "Docente " . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . " Actualizado. Se ha enviado correo para asignar solicitud"));
        } else {
            echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envío el correo."));
        }
    }
    // Método: observacionesDocenteAjax
    public function observacionesDocenteAjax()
    {
        // Solo POST
        if (strtolower($this->input->method(true)) !== 'post') {
            echo json_encode([]); return;
        }

        $id_docente = $this->input->post('id_docente', true);
        if (!$id_docente || !is_numeric($id_docente)) {
            echo json_encode([]); return;
        }

        // Consultar historial
        $this->db->where('docentes_id_docente', (int)$id_docente);
        $this->db->order_by('created_at', 'DESC');
        $rows = $this->db->get('observacionesDocente')->result_array();

        // Escapar contenido para seguridad en el lado cliente
        foreach ($rows as &$r) {
            $r['observacion'] = htmlspecialchars((string)($r['observacion'] ?? ''), ENT_QUOTES, 'UTF-8');
            $r['created_at'] = isset($r['created_at']) ? (string)$r['created_at'] : '';
        }
        unset($r);

        echo json_encode($rows);
    }
}
