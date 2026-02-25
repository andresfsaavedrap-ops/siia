<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Solicitudes extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("America/Bogota");
        $this->load->model('EstadisticasModel');
        $this->load->model('SolicitudesModel');
        $this->load->model('DepartamentosModel');
        $this->load->model('AdministradoresModel');
        $this->load->model('OrganizacionesModel');
        $this->load->model('InformacionGeneralModel');
        $this->load->model('DocumentacionLegalModel');
        $this->load->model('AntecedentesAcademicosModel');
        $this->load->model('JornadasActualizacionModel');
        $this->load->model('ArchivosModel');
        $this->load->model('DatosAplicacionModel');
        $this->load->model('DatosEnLineaModel');
        $this->load->model('DatosModalidadesModel');
        $this->load->model('DatosProgramasModel');
        $this->load->model('DocentesModel');
        $this->load->model('ObservacionesModel');
        $this->load->model('ResolucionesModel');
    }
    /**
     * Funciones Administrador
     */
    // Datos de sesión administrador
    public function datosSesionAdmin()
    {
        verify_session_admin();
        $data = array(
            'logged_in' => $this->session->userdata('logged_in'),
            'nombre_usuario' => $this->session->userdata('nombre_usuario'),
            'usuario_id' => $this->session->userdata('usuario_id'),
            'tipo_usuario' => $this->session->userdata('type_user'),
            'nivel' => $this->session->userdata('nivel'),
            'hora' => date("H:i", time()),
            'fecha' => date('Y/m/d'),
            'departamentos' => $this->DepartamentosModel->getDepartamentos(),
        );
        return $data;
    }
	/** Vista de panel de solicitudes */
	public function index()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Tramite';
		$data['activeLink'] = 'tramite';
		$this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/index', $data);
        $this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
    /**
     * Solicitudes inscritas
     */
    public function inscritas()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Panel Principal / Tramite / Inscritas';
        $data['solicitudes'] = $this->SolicitudesModel->getSolicitudesFinalizadas()[0]['solicitudesSinAsignar'];
        $this->load->view('include/header/main', $data);
        $this->load->view('super/pages/requests', $data);
        $this->load->view('include/footer/main');
        $this->logs_sia->logs('PLACE_USER');
    }	// Cargar solicitud
    public function cargarDatosSolicitud()
    {
        $solicitud = $this->SolicitudesModel->solicitudes($this->input->post('idSolicitud'));
        $resolucion = $this->ResolucionesModel->getResolucionSolicitud($this->input->post('idSolicitud'));
        echo json_encode(array('solicitud' => $solicitud, 'resolucion' => $resolucion));
    }
    // Cargar todos los datos de una solicitud
    public function cargarInformacionCompletaSolicitud()
    {
        $idSolicitud = $this->input->post('idSolicitud');
        $idOrganizacion = $this->input->post('id_organizacion');
        $solicitud = $this->SolicitudesModel->getAllInformacionSolicitud($idSolicitud, $idOrganizacion);
        echo $solicitud;
    }
    public function asignar()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Tramite / Asignar';
        $data['solicitudesSinAsignar'] = $this->SolicitudesModel->getSolicitudesFinalizadas()[0]['solicitudesSinAsignar'];
        $data['solicitudesAsignadas'] = $this->SolicitudesModel->getSolicitudesFinalizadas()[0]['solicitudesAsignadas'];
        $data['administradores'] = $this->AdministradoresModel->getAdministradores();
        $this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/asignar', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    // Asignar en proceso
    public function asignarEvaluadorSolicitud()
    {
        $organizacion = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $this->input->post('id_organizacion'))->get()->row();
        $evaluador = $this->db->select("*")->from("administradores")->where("usuario", $this->input->post('evaluadorAsignar'))->get()->row();
        $nombreEvaluador = $evaluador->primerNombreAdministrador . " " .  $evaluador->primerApellidoAdministrador;
        $data_asignar = array(
            'asignada' => $this->input->post('evaluadorAsignar'),
            'fechaAsignacion' => date('Y/m/d H:i:s'),
            'asignada_por' => $this->session->userdata('nombre_usuario'),
        );
        $this->db->where('idSolicitud', $this->input->post('idSolicitud'));
        if ($this->db->update('solicitudes', $data_asignar)) {
            $this->logs_sia->session_log('Se asigno ' . $organizacion->nombreOrganizacion . ' a ' . $nombreEvaluador . ' en la fecha ' . date("Y/m/d H:m:s") . '.');
            send_email_admin('asignarSolicitud', '2', $evaluador->direccionCorreoElectronico, null, $organizacion, $this->input->post('idSolicitud'));
            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'asignarEvaluador', $organizacion, $evaluador, null, $this->input->post('idSolicitud'));
        }
    }
    // Solicitudes finalizadas
    public function finalizadas()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Panel Principal / Administrador / En evaluación';
        $data['solicitudesAsignadas'] = $this->SolicitudesModel->getSolicitudesFinalizadas()[0]['solicitudesAsignadas'];
        $this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/finalizadas', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    // Solicitudes en observaciones
    public function observaciones()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Panel Principal / Administrador / En observaciones';
        $data['solicitudesEnObservaciones'] = $this->SolicitudesModel->getSolicitudesEnObservacion();
        // Reusar la vista finalizadas: mapear colección al nombre esperado y marcar modo/bloqueos
        $data['solicitudesAsignadas'] = $data['solicitudesEnObservaciones'];
        $data['vista_modo'] = 'observaciones';
        $data['bloquearObservaciones'] = true;
        $this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/finalizadas', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    // Cargar información SolicitudesModel
    public function informacionSolicitud()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Panel Principal - Administrador - Información';
        $data['idSolicitud'] = $this->input->get('idSolicitud');
        $data['idOrganizacion'] = $this->input->get('idOrganizacion');
        // Modo “observaciones” y bloqueo de edición
        $data['vista_modo'] = 'observaciones';
        $data['bloquearObservaciones'] = true;
        // Cargar solo la solicitud solicitada en el formato que espera la vista
        $data['solicitudesAsignadas'] = $this->SolicitudesModel->getSolicitudResumen(
            $data['idOrganizacion'],
            $data['idSolicitud']
        );
        // Señal para autocargar el panel de detalles vía JS
        $data['autocargarSolicitud'] = true;
        $this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/finalizadas', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    // Solicitudes en proceso
    public function proceso()
    {
        $data = $this->datosSesionAdmin();
        $data['title'] = 'Panel Principal / Administrador / En proceso';
        $data['solicitudesEnProceso'] = $this->SolicitudesModel->getSolicitudesEnProceso();
        $this->load->view('include/header/main', $data);
        $this->load->view('admin/solicitudes/proceso', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    /**
     * Funciones Usuario
     */
    // Datos inicio de sesión Usuario
    public function datosSesionUsuario()
    {
        verify_session();
        date_default_timezone_set("America/Bogota");
        $data = array(
            'logged_in' => $this->session->userdata('logged_in'),
            'nombre_usuario' => $this->session->userdata('nombre_usuario'),
            'usuario_id' => $this->session->userdata('usuario_id'),
            'tipo_usuario' => $this->session->userdata('type_user'),
            'nivel' => $this->session->userdata('nivel'),
            'hora' => date("H:i", time()),
            'fecha' => date('Y/m/d'),
            'departamentos' => $this->DepartamentosModel->getDepartamentos(),
        );
        return $data;
    }
    // Crear solicitud
    public function crearSolicitud()
    {
        if (!$this->input->post('api'))
            $this->datosSesionUsuario();
        if ($this->input->post()) {
            $estado = 'En Proceso';
            // Comprobar si la solicitud se crea desde el super administrador o desde el usuario
            if ($this->input->post('nit_organizacion')):
                $organizacion = $this->OrganizacionesModel->getOrganizaciones($this->input->post('nit_organizacion'));
            else:
                $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
            endif;
            $solicitudes = $this->SolicitudesModel->getSolicitudesByOrganizacion($organizacion->id_organizacion);
            // Comprobar si la solicitud se crea desde el super administrador o desde el usuario
            if ($this->input->post('nit_organizacion')):
                $comprobarSolicitud = 'true';
            else:
                $comprobarSolicitud = $this->comprobarSolicitud($solicitudes, $this->input->post('motivos_solicitud'), $this->input->post('modalidades_solicitud'));
            endif;
            if ($comprobarSolicitud == 'true'):
                $idSolicitud = date('YmdHis') . $organizacion->nombreOrganizacion[3] . random(2);
                $numeroSolicitudes = count($solicitudes);
                // Comprobar si la solicitud se crea desde el super administrador o desde el usuario
                if ($this->input->post('tipo_solicitud')):
                    $tipoSolicitud = $this->input->post('tipo_solicitud');
                else:
                    // Comprobar y asignar estado a la solicitud
                    if ($numeroSolicitudes > 0):
                        // TODO: Corregir estados no traer de la organizacion sino de la solicitud o solicitudes
                        if ($organizacion->estado == "Acreditado"):
                            $estado = 'En Renovación';
                            $tipoSolicitud = "Renovación de Acreditación";
                        else:
                            $tipoSolicitud = 'Solicitud Nueva';
                        endif;
                    else:
                        $tipoSolicitud = 'Acreditación Primera vez';
                    endif;
                endif;
                if ($this->input->post('fecha_creacion'))
                    $fecha = date($this->input->post('fecha_creacion'));
                else
                    $fecha = date('Y/m/d H:i:s');
                // Datos para crear solicitud
                $data_solicitud = array(
                    'numeroSolicitudes' => $numeroSolicitudes += 1,
                    'fechaCreacion' =>  $fecha,
                    'idSolicitud' => $idSolicitud,
                    'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                );
                $data_tipoSolicitud = array(
                    'tipoSolicitud' => $tipoSolicitud,
                    'motivoSolicitud' => $this->input->post('motivo_solicitud'),
                    'modalidadSolicitud' => $this->input->post('modalidad_solicitud'),
                    'idSolicitud' => $idSolicitud,
                    'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                    'motivosSolicitud' => json_encode($this->input->post('motivos_solicitud')),
                    'modalidadesSolicitud' => json_encode($this->input->post('modalidades_solicitud'))
                );
                $data_estado = array(
                    'nombre' => $estado,
                    'fechaUltimaActualizacion' => $fecha,
                    'estadoAnterior' => $organizacion->estado,
                    'tipoSolicitudAcreditado' => $tipoSolicitud,
                    'motivoSolicitudAcreditado' => $this->input->post('motivo_solicitud'),
                    'modalidadSolicitudAcreditado' => $this->input->post('modalidad_solicitud'),
                    'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                    'idSolicitud' => $idSolicitud,
                
                );
                // Guardar datos iniciales de la solicitud
                if ($this->db->insert('solicitudes', $data_solicitud)):
                    if ($this->db->insert('tipoSolicitud', $data_tipoSolicitud)):
                        if ($this->db->insert('estadoOrganizaciones', $data_estado)):
                            // Comprobar si lo hace el super
                            if (!$this->input->post('nit_organizacion'))
                                $this->logs_sia->session_log('Formulario Motivo Solicitud - Tipo Solicitud: ' . '. Motivo Solicitud: ' . $this->input->post('motivo_solicitud') . '. Modalidad Solicitud: ' . $this->input->post('modalidad_solicitud') . '. ID: ' . $idSolicitud . '. Fecha: ' . date('Y/m/d') . '.');
                            $this->logs_sia->logQueries();
                            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'crearSolicitud', $organizacion, null, null, $idSolicitud);
                        endif;
                    endif;
                endif;
            else:
                echo json_encode(array('status' => 'error', 'title' => 'Datos no guardados', 'msg' => "Conflictos en la creación de la solicitud: <br><br><ul class='list-popup'>" . $comprobarSolicitud . "</ul><br>Debes modificar la creación actual. Si cuentas con solicitudes en estado de <strong> Observaciones </strong> o <strong>Finalizado</strong> puedes consultar el estado y/o eliminar las solicitudes en conflicto para continuar"));
            endif;
        }
    }
    // Comprobar solicitud a crear
    public function comprobarSolicitud($solicitudes, $motivosSolicitud, $modalidadesSolicitud)
    {
        $solicitudesFinalizadas = true;
        $motivo = true;
        $modalidad = true;
        $return = '';
        // Recorrer las solicitudes de la organización
        foreach ($solicitudes as $solicitud):
            // Comprobar que la solicitud no se encuentré acreditada, negada o archívada.
            if ($solicitud->nombre != 'Archivada'):
                if ($solicitud->nombre != 'Negada'):
                    if ($solicitud->nombre != 'Revocada'):
                        // Comprobar si la solicitud se encuentra en estado de observaciones o finalizado
                        if ($solicitud->nombre == 'Finalizado' || $solicitud->nombre == 'En Observaciones'):
                            $solicitudesFinalizadas = false;
                            $return .= "<li>La solicitud con ID: <strong>" . $solicitud->idSolicitud .  "</strong> se escuentra en estado " . $solicitud->nombre . " <i class='fa fa-times spanRojo' aria-hidden='true'></i></li><br><br>";
                        endif;
                        if ($solicitud->nombre == 'Acreditado'):
                            $return .= "<li>La solicitud con ID: <strong>" . $solicitud->idSolicitud .  "</strong> se escuentra en estado " . $solicitud->nombre . " <i class='fa fa-check spanVerde' aria-hidden='true'></i>Si esta habilitada la opción por favor de clic en renovar a esta solicitud.</li><br><br>";
                        endif;
                        // Capturas mótivos y modalidades de la solicitud
                        $motivos = json_decode($solicitud->motivosSolicitud);
                        $modalidades = json_decode($solicitud->modalidadesSolicitud);
                        // Comprobar datos similares en la solicitud
                        $compararMotivo = array_merge(array_intersect($motivos, $motivosSolicitud));
                        $compararModalidad = array_merge(array_intersect($modalidades, $modalidadesSolicitud));
                        if (!empty($compararMotivo)):
                            $motivos = '';
                            for ($i = 0; $i < count($compararMotivo); $i++):
                                $motivos .= $this->SolicitudesModel->getMotivo($compararMotivo[$i]) . ', ';
                            endfor;
                            $motivos = substr($motivos, 0, -2);
                            $motivo = false;
                            $return .= "<li>La solicitud con ID: <strong> " . $solicitud->idSolicitud . " </strong>tiene los siguientes motivos identicos: " . $motivos . " <i class='fa fa-times spanRojo' aria-hidden='false'></i></li><br><br>";
                        endif;
                        if (!empty($compararModalidad)):
                            $modalidades = '';
                            for ($i = 0; $i < count($compararModalidad); $i++):
                                $modalidades .= $this->SolicitudesModel->getModalidad($compararModalidad[$i]) . ', ';
                            endfor;
                            $modalidades = substr($modalidades, 0, -2);
                            $modalidad = false;
                            $return .= "<li>La solicitud con ID: <strong>" . $solicitud->idSolicitud . " </strong>tiene las siguientes modalidades: " . $modalidades . " <i class='fa fa-times spanRojo' aria-hidden='false'></i></li><br>";
                        endif;
                    endif;
                endif;
            endif;
        endforeach;
        if ($solicitudesFinalizadas == true && $motivo == true && $modalidad == true):
            return 'true';
        else:
            return $return;
        endif;
    }
    // Solicitud
    public function solicitud($idSolicitud)
    {
        $data = $this->datosSesionUsuario();
        $data['title'] = 'Solicitud: ' . $idSolicitud;
        $data['activeLink'] = 'solicitud';
        $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($data['usuario_id']);
        $data['organizacion'] = $organizacion;
        $data['solicitud'] = $this->SolicitudesModel->solicitudes($idSolicitud);
        $this->load->view('include/header/main', $data);
        $this->load->view('user/modules/solicitudes/solicitud', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    /**
     * Función para cargar dinámicamente los formularios
     */
    public function cargarFormulario() {
        // Comprueba si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            show_error('No se permite el acceso directo al script.');
        }
        $data = $this->datosSesionUsuario();
        $idFormulario = $this->input->post('idFormulario');
        $nombreFormulario = $this->input->post('nombreFormulario');
        $idSolicitud = $this->input->post('idSolicitud');
        $solicitud = $this->SolicitudesModel->solicitudes($idSolicitud);
        $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($data['usuario_id']);
        $data['solicitud'] = $solicitud;
        // Verifica que la solicitud exista
        if (!$solicitud) {
            echo '<div class="alert alert-danger">La solicitud no existe.</div>';
            return;
        }
        // Según el formulario solicitado, carga la vista correspondiente
        switch ($nombreFormulario) {
            case 'informacion_general':
                $data['informacionGeneral'] = $this->InformacionGeneralModel->getInformacionGeneral($organizacion->id_organizacion);
                $data['organizacion'] = $organizacion;
                $this->load->view('user/modules/solicitudes/forms/_informacion_general', $data);
                break;
            case 'documentacion_legal':
                $data['documentacionLegal'] = $this->DocumentacionLegalModel->getDocumentacionLegal($idSolicitud);
                $this->load->view('user/modules/solicitudes/forms/_documentacion_legal', $data);
                break;
            case 'jornadas_actualizacion':
                $data['jornadasActualizacion'] = $this->JornadasActualizacionModel->getJornadasActualizacion($idSolicitud);
                $archivoJornadaResult = $this->ArchivosModel->getArchivos($organizacion->id_organizacion, 3, $idSolicitud);
                $data['archivoJornada'] = !empty($archivoJornadaResult) ? $archivoJornadaResult[0] : null;
                $this->load->view('user/modules/solicitudes/forms/_jornadas_actualizacion', $data);
                break;
            case 'programas':
                $data['datosProgramas'] = $this->DatosProgramasModel->getDatosProgramas($idSolicitud);
                $this->load->view('user/modules/solicitudes/forms/_programas', $data);
                break;
            case 'equipo_docente':
                $data['docentes'] = $this->DocentesModel->getDocentes($organizacion->id_organizacion);
                $this->load->view('user/modules/solicitudes/forms/_equipo_docente', $data);
                break;
            case 'plataforma':
                $data['aplicacion'] = $this->DatosAplicacionModel->getDatosAplicacion($idSolicitud);
                $this->load->view('user/modules/solicitudes/forms/_plataforma', $data);
                break;
            case 'modalidades':
                $data['datosModalidades'] = $this->DatosModalidadesModel->getDatosModalidades($idSolicitud);
                $this->load->view('user/modules/solicitudes/forms/_modalidades', $data);
                break;
            case 'finalizar_proceso':
                $this->load->view('user/modules/solicitudes/forms/_finalizar_proceso', $data);
                break;
            case 'inicio':
                $this->load->view('user/modules/solicitudes/forms/_resumen_solicitud', $data);
                break;
            default:
                echo '<div class="alert alert-warning">Formulario no disponible.</div>';
                break;
        }
    }
    // Enviar solicitud
    public function enviarSolicitud()
    {
        $this->datosSesionUsuario();
        $idSolicitud = $this->input->post('idSolicitud');
        $formularios = $this->verificarFormularios($idSolicitud);
        $emailCoordinador = $this->AdministradoresModel->getCoordinador()->direccionCorreoElectronico;
        if (count($formularios) === 0) {
            $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
            $solicitud = $this->SolicitudesModel->solicitudes($idSolicitud);
            if ((int)$solicitud->numeroRevisiones === 0) {
                $file = $organizacion->camaraComercio;
                if ($file != 'default.pdf') {
                    @unlink('uploads/camaraComercio/' . $file);
                }
                $camaraComercio = array('camaraComercio' => "default.pdf");
                $this->db->where('id_organizacion', $organizacion->id_organizacion);
                $this->db->update('organizaciones', $camaraComercio);
                $usuarioCamara = $this->db->select("*")->from("administradores")->where("nivel", 3)->get()->row();
                $toCamara = $usuarioCamara ? $usuarioCamara->direccionCorreoElectronico : null;
                if ($toCamara) {
                    send_email_admin('solicitarCamara', 1, $toCamara, null, $organizacion, null, true);
                }
            }
            if ($solicitud->nombre  != 'Finalizado'):
                $updateEstado = array(
                    'nombre' => "Finalizado",
                    'fechaUltimaActualizacion' => date('Y/m/d H:i:s'),
                    'estadoAnterior' => $solicitud->nombre,
                    'fechaFinalizado' => date('Y/m/d H:i:s')
                );
            endif;
            if ($solicitud->nombre == 'En Observaciones'):
                $updateEstado = array(
                    'nombre' => "Finalizado",
                    'fechaUltimaActualizacion' => date('Y/m/d H:i:s'),
                    'estadoAnterior' => $solicitud->nombre
                );
                send_email_admin('actualizacionSolicitud', 1, $this->AdministradoresModel->getEmail($solicitud->asignada), null, $organizacion, $solicitud->idSolicitud);
            endif;
            $this->db->where('idSolicitud', $idSolicitud);
            $this->db->update('estadoOrganizaciones', $updateEstado);
            if ($solicitud->asignada == "SIN ASIGNAR")
                send_email_admin('enviarSolicitd', 1, $emailCoordinador, null, $organizacion, $idSolicitud);
            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'enviarSolicitd', $organizacion, null, null, $idSolicitud);
            $this->logs_sia->session_log('Finalizada la Solicitud ' . $idSolicitud);
            $this->notif_sia->notification('Finalizada', 'admin', $organizacion->nombreOrganizacion);
            $this->logs_sia->logQueries();
        } else {
            echo json_encode(
                array(
                    'title' => 'Complete los formularios faltantes',
                    'status' => 'info',
                    'msg' => '<p>Solicitud: <strong>' .  $idSolicitud . '</strong><br>Continue diligenciando los formularios: <hr></p>',
                    'formularios' => $formularios,
                    'solicitud' => $this->SolicitudesModel->solicitudes($idSolicitud),
                    'motivos' => $this->cargarMotivosSolicitud($idSolicitud),
                    'programas' => $this->DatosProgramasModel->getDatosProgramas($idSolicitud)
                )
            );
        }
    }
    //Cargar estado de la solicitud
    public function cargarEstadoSolicitud()
    {
        $idSolicitud = $this->input->post('solicitud');
        $solicitud = $this->SolicitudesModel->solicitudes($idSolicitud);
        $programas = $this->DatosProgramasModel->getDatosProgramas($idSolicitud);
        $motivos = $this->cargarMotivosSolicitud($idSolicitud);
        $observaciones = $this->ObservacionesModel->getObservaciones($idSolicitud);
        $formularios = $this->verificarFormularios($idSolicitud);
        switch ($solicitud->nombre) {
            case "En Proceso":
                if (count($formularios) === 0):
                    $title = 'Solicitud diligenciada!';
                    $icon = 'success';
                    $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong> cuenta con los formularios diligenciados. <br><br>Por favor de clic en <strong>Finaliza Proceso</strong> para enviar la solicitud a la Unidad Solidaria. <br>Gracias!</p>';
                else:
                    $title = 'Complete los formularios';
                    $icon = 'info';
                    $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong><br></p><h5>Continue diligenciando los formularios:</h5> <hr>';
                endif;
                echo json_encode(
                    array(
                        'title' => $title,
                        'icon' => $icon,
                        'msg' => $msg,
                        'formularios' => $formularios,
                        'solicitud' => $solicitud,
                        'motivos' => $motivos,
                        'programas' => $programas
                    )
                );
                break;
            case "En Observaciones":
                if (count($formularios) === 0):
                    $listaFormularios = '';
                    if ($observaciones['formulario1'])
                        $listaFormularios .= '<li>Formulario 1 información general.</li>';
                    if ($observaciones['formulario2'])
                        $listaFormularios .= '<li>Formulario 2 documentación legal.</li>';
                    if ($observaciones['formulario3'])
                        $listaFormularios .= '<li>Formulario 3 Jornadas de actualización.</li>';
                    if ($observaciones['formulario4'])
                        $listaFormularios .= '<li>Formulario 4 datos básicos programas.</li>';
                    if ($observaciones['formulario5'])
                        $listaFormularios .= '<li>Formulario 5 docentes.</li>';
                    if ($observaciones['formulario6'])
                        $listaFormularios .= '<li>Formulario 6 plataforma virtual.</li>';
                    if ($observaciones['formulario7'])
                        $listaFormularios .= '<li>Formulario 7 modalidad en línea.</li>';
                    if ($listaFormularios != ''):
                        $title = '¡Tramite verificado!';
                        $icon = 'info';
                        $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong> 
                                <br><br>El evaluador realizó observaciones para los formularios: <br><br>
                                <ul>' . $listaFormularios . '</ul>
                                <br><br>Por favor, revise las observaciones y de clic en <strong>Actualizar</strong> la solicitud una vez realizados los ajustes y <strong>Finalice el proceso</strong>  <br><br>
                                <br><br>Volverá a llegarle un mensaje con la finalización de la solicitud ajustada.
                                <br><br>Si ya realizó los cambios y recibió un correo de finalización, por favor cierre este cuadro y espere una nueva confirmación
                                <br><br>¡Gracias!</p>';
                    else:
                        $title = '¡Tramite verificado!';
                        $icon = 'success';
                        $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong>. 
                                <br><br>El evaluador verificó los datos registrados en la solicitud y se cumplen los requisitos establecidos en el marco normativo del trámite.
                                <br><br>Su trámite pasa a revisión por parte del área jurídica para emitir acto administrativo.
                                <br><br>¡Gracias!</p>';
                    endif;
                else:
                    $title = 'Complete los formularios faltantes';
                    $icon = 'info';
                    $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong><br>Continue diligenciando los formularios: <hr></p>';
                endif;
                echo json_encode(
                    array(
                        'title' => $title,
                        'icon' => $icon,
                        'msg' => $msg,
                        'formularios' => $formularios,
                        'solicitud' => $solicitud,
                        'motivos' => $motivos,
                        'programas' => $programas
                    )
                );
                break;
                break;
            case "En Renovación":
                if (count($formularios) === 0):
                    $title = 'Solicitud diligenciada!';
                    $icon = 'success';
                    $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong> cuenta con los formularios diligenciados. <br><br>Por favor de clic en <strong>Finaliza Proceso</strong> para enviar la solicitud a la Unidad Solidaria. <br>Gracias!</p>';
                else:
                    $title = 'Complete los formularios faltantes';
                    $icon = 'info';
                    $msg = '<p>Solicitud: <strong>' .  $idSolicitud . '</strong></p><br><h4>Continue diligenciando los formularios:</h4><hr>';
                endif;
                echo json_encode(
                    array(
                        'title' => $title,
                        'icon' => $icon,
                        'msg' => $msg,
                        'formularios' => $formularios,
                        'solicitud' => $solicitud,
                        'motivos' => $motivos,
                        'programas' => $programas
                    )
                );
                break;
            default:
                break;
        }
    }
    // Cargar motivos de la solicitud para el estado
    public function cargarMotivosSolicitud($idSolicitud)
    {
        $motivosSolicitud = $this->db->select("motivosSolicitud")->from("tipoSolicitud")->where("idSolicitud", $idSolicitud)->get()->row()->motivosSolicitud;
        return json_decode($motivosSolicitud);
    }
    // Validad formularios de la solicitud para el estado TODO: Arreglar verificación
    public function verificarFormularios($idSolicitud)
    {
        $usuario_id = $this->session->userdata('usuario_id');
        $datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
        $id_organizacion = $datos_organizacion->id_organizacion;
        $certificacionesForm = NULL;
        $lugar = NULL;
        $autoevaluacion = NULL;
        $carta = NULL;
        $jornada = NULL;
        $materialProgBasicos = NULL;
        $materialAvalEcon = NULL;
        $formatosEval = NULL;
        $materialProgEval = NULL;
        $instructivo = NULL;
        $icert = 0;
        $datosBasicosProg = TRUE;
        $datosAvalEcon = TRUE;
        $tipoSolicitud = $this->db->select("*")->from("tipoSolicitud")->where("idSolicitud", $idSolicitud)->get()->row();
        $motivoSolicitud = json_decode($tipoSolicitud->motivosSolicitud);
        $modalidadSolicitud = $tipoSolicitud->modalidadSolicitud;
        $archivosBD = $this->db->select("*")->from("archivos")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
        $strFormulario1 = '';
        /** Comprobar archivos en formularios */
        foreach ($archivosBD as $archivo) {
            $tipo = $archivo->tipo;
            $formulario = $archivo->id_formulario;
            switch ($formulario) {
                case 1:
                    switch ($tipo) {
                        case 'certificaciones':
                            $icert += 1;
                            if ($icert >= 3)
                                $certificacionesForm = TRUE;
                            break;
                        case 'lugar':
                            $lugar = TRUE;
                            break;
                        case 'autoevaluacion':
                            $autoevaluacion = TRUE;
                            break;
                        case 'carta':
                            $carta = TRUE;
                            break;
                        default:
                            $certificacionesForm = FALSE;
                            $lugar = FALSE;
                            $carta = FALSE;
                            $autoevaluacion = FALSE;
                            break;
                    }
                    break;
                case 3:
                    if ($tipo == "jornadaAct")
                        $jornada = TRUE;
                    break;
                case 6:
                    if ($tipo == "materialDidacticoProgBasicos")
                        $materialProgBasicos = TRUE;
                    break;
                case 7:
                    if ($tipo == "materialDidacticoAvalEconomia")
                        $materialAvalEcon = TRUE;
                    break;
                case 8:
                    if ($tipo == "formatosEvalProgAvalar")
                        $formatosEval = TRUE;
                    if ($tipo == "materialDidacticoProgAvalar")
                        $materialProgEval = TRUE;
                    break;
                case 10:
                    if ($tipo == "instructivoPlataforma" || $tipo == "observacionesPlataformaVirtual")
                        $instructivo = TRUE;
                    break;
                default:
                    break;
            }
        }
        if ($certificacionesForm == FALSE)
            $strFormulario1 .= "<span class='upper'>Certificaciones </span><i class='fa fa-times spanRojo' aria-hidden='true'></i><br/>";
        if ($carta == FALSE)
            $strFormulario1 .= "<span class='upper'>Carta de solicitud </span><i class='fa fa-times spanRojo' aria-hidden='true'></i><br/>";
        if ($this->SolicitudesModel->solicitudes($idSolicitud)->nombre == 'En Renovación') {
            if ($autoevaluacion == FALSE)
                $strFormulario1 .= "<span class='upper'>Autoevaluación </span><i class='fa fa-times spanRojo' aria-hidden='true'></i><br/>";
        } else {
            $autoevaluacion = TRUE;
        }
        /** Variables Formularios */
        $informacionGeneral = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
        $documentacion = $this->db->select("*")->from("documentacion")->where("idSolicitud", $idSolicitud)->get()->row();
        $registroEducativoProgramas = $this->db->select("*")->from("registroEducativoProgramas")->where("idSolicitud", $idSolicitud)->get()->row();
        $antecedentesAcademicos = $this->db->select("*")->from("antecedentesAcademicos")->where("idSolicitud", $idSolicitud)->get()->row();
        $jornadasActualizacion = $this->db->select("*")->from("jornadasActualizacion")->where("idSolicitud", $idSolicitud)->get()->row();
        $datosProgramas = $this->db->select("*")->from("datosProgramas")->where("idSolicitud", $idSolicitud)->get()->row();
        $aplicacion = $this->db->select("*")->from("datosAplicacion")->where("idSolicitud", $idSolicitud)->get()->row();
        // TODO: Arreglar
        $datosModalidades = $this->DatosModalidadesModel->getDatosModalidades($idSolicitud);
        $datosEnLinea = $this->db->select("*")->from("datosEnLinea")->where("idSolicitud", $idSolicitud)->get()->row();
        // Comprobación docentes
        $docentes = $this->db->select("*")->from("docentes")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
        $strDocentes = "";
        foreach ($docentes as $docente):
            $documentosFaltantes = array();
            $contadores = array(
                'hojas' => 0,
                'titulos' => 0,
                'certEcos' => 0,
                'certs' => 0
            );
            $archivos = $this->cargarDatosArchivosDocentes($docente->id_docente);
            // Contar documentos por tipo
            foreach ($archivos as $archivo):
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
            endforeach;
            // Verificar documentos faltantes
            if ($contadores['hojas'] < 1) {
                $documentosFaltantes[] = "Hoja de vida (tiene {$contadores['hojas']}, requiere 1)";
            }
            if ($contadores['titulos'] < 1) {
                $documentosFaltantes[] = "Título académico (tiene {$contadores['titulos']}, requiere 1)";
            }
            if ($contadores['certEcos'] < 1) {
                $documentosFaltantes[] = "Certificado de economía (tiene {$contadores['certEcos']}, requiere 1)";
            }
            if ($contadores['certs'] < 3) {
                $documentosFaltantes[] = "Certificados generales (tiene {$contadores['certs']}, requiere 3)";
            }
            // Generar mensaje solo si faltan documentos
            if (!empty($documentosFaltantes)) {
                $strDocentes .= "<div class='alert alert-warning mb-2'>";
                $strDocentes .= "<strong>Docente: <span class='upper'>" . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . "</span></strong>";
                $strDocentes .= "<i class='fa fa-exclamation-triangle text-warning ml-2' aria-hidden='true'></i><br/>";
                $strDocentes .= "<small>Documentos faltantes:</small><ul class='mb-0'>";
                foreach ($documentosFaltantes as $faltante) {
                    $strDocentes .= "<li>{$faltante}</li>";
                }
                $strDocentes .= "</ul></div>";
            }
        endforeach;
        /**
         * Comprobación Formularios
         * @var  $formularios
         */
        $formularios = array();
        $solicitud = $this->db->select('*')->from('solicitudes')->where("idSolicitud", $idSolicitud)->get()->row();
        $totalProgramas = $this->db->select('*')->from('datosProgramas')->where("idSolicitud", $idSolicitud)->get()->result();
        // Contar programas seleccionados por medio de campo mótivos
        $cantProgramasSeleccionados = count(json_decode($tipoSolicitud->motivosSolicitud));
        // Asignar variable para la cantidad de programas actualmente registrados en la solicitud
        $cantProgramasAceptados = count($totalProgramas);
        // Comparar si la cantidad de motivos seleccionados conincide con la cantidad de programas aceptados en la solicitud.
        if ($cantProgramasSeleccionados == $cantProgramasAceptados) {
            $datosProgramasAceptados = 'TRUE';
        }
        /**
         * Comprobar todos los formularios
         */
        //if ($informacionGeneral == NULL || $certificacionesForm == NULL || $lugar == NULL || $carta == NULL) {
        if ($informacionGeneral == NULL || $certificacionesForm == NULL || $carta == NULL || $autoevaluacion == NULL) {
            array_push($formularios, "<strong>1. Informacion General.</strong>");
        }
        if ($documentacion == NULL) {
            array_push($formularios, "<strong>2. Documentacion Legal.</strong>");
        }
        if ($antecedentesAcademicos == NULL) {
            //array_push($formularios, "3. Falta el formulario de Antecedentes Academicos.");
        }
        if ($jornadasActualizacion == NULL || $jornada == NULL) {
            array_push($formularios, "<strong>3. Jornadas Actualización.</strong>");
        }
        if ($datosProgramasAceptados == NULL) {
            array_push($formularios, "<strong>4. Programa organizaciones y redes SEAS.</strong>");
        }
        if ($docentes == NULL || count($docentes) < 3) {
            array_push($formularios, "<strong>5. Facilitadores:</strong><br><br>Por favor registrar los docentes y/o archivos, en el formulario<br>Deben ser tres (3) docentes con sus respectivos documentos.");
        }
        if (empty($datosModalidades) || count($datosModalidades) < 4) {
            array_push($formularios, "<strong>6. Modalidades.</strong><br><p>Por favor registrar todas las modalidades, en el formulario<br>Deben ser cuatro (4) modalidades.</p><hr>");
        }

        if (stripos($modalidadSolicitud, 'a distancia') !== false || stripos($modalidadSolicitud, 'hibrida') && is_null($datosEnLinea)) {
            //array_push($formularios, "7. Por desarrollar formulario de datos otras modalidadades.<hr>");
        }
        if (!empty($strFormulario1)) {
            array_push($formularios, "<strong>1. Información General</strong> | Debes cargar los documentos: <br><br><strong><small><i>" . $strFormulario1 . "</i></small></strong>");
        }
        if (!empty($strDocentes)) {
            array_push($formularios, "<strong>5. Facilitadores </strong> | Por favor adjunte los documentos de los docentes:<br><br><strong><small><i>" . $strDocentes . "</i></small></strong>");
        }
        return $formularios;
    }
    // Cargar datos archivos docentes
    public function cargarDatosArchivosDocentes($id)
    {
        $data_archivos = $this->db->select("*")->from("archivosDocente")->where('docentes_id_docente', $id)->get()->result();
        return $data_archivos;
    }
    // Eliminar Solicitud
    public function eliminarSolicitud()
    {
        // TODO: Eliminar archivos de la solicitud
        $this->db->where('idSolicitud', $this->input->post('idSolicitud'));
        $tables = array(
            'estadoOrganizaciones',
            'solicitudes',
            'tipoSolicitud',
            'documentacion',
            'certificadoExistencia',
            'registroEducativoProgramas',
            'jornadasActualizacion',
            'datosProgramas',
            'datosEnLinea',
            'datosAplicacion'
        );
        $this->db->delete($tables);
        $msg = 'Se elimino la solicitud: <strong>' . $this->input->post('idSolicitud') . '<strong>';
        echo json_encode(array('status' => "success", 'msg' => $msg));
    }
    // Estado de la solicitud
    public function estadoSolicitud($idSolicitud)
    {
        $data = $this->datosSesionUsuario();
        $data['title'] = 'Panel Principal - Estado de la Solicitud';
        $data['organizacion'] = $this->OrganizacionesModel->getOrganizacion($data['usuario_id']);
        $data['observaciones'] = $this->ObservacionesModel->getObservaciones($idSolicitud);
        $data['solicitud'] = $this->SolicitudesModel->solicitudes($idSolicitud);
        $this->load->view('include/header/main', $data);
        $this->load->view('user/modules/solicitudes/estado', $data);
        $this->load->view('include/footer/main', $data);
        $this->logs_sia->logs('PLACE_USER');
    }
    // Actualizar estado de la solicitud
    public function actualizarEstadoSolicitud()
    {
        $organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('idOrganizacion'));
        $estadoSolicitud = $this->input->post('estadoSolicitud');
        $idSolicitud = $this->input->post('idSolicitud');
        $justificacionCambioEstado = $this->input->post('justificacionCambioEstado'); // NUEVO
        $solicitud = $this->SolicitudesModel->solicitudes($idSolicitud);

        $nivelUsuario = (string)$this->session->userdata('nivel'); // NIVEL en sesión
        $estadosSinJustificacionParaNivel0 = ['Inscrito','En Proceso','Finalizado','En Observaciones','En Renovación'];
        // Estados en los que no se debe enviar email
        $estadosSinEmail = ['Inscrito','En Proceso','Finalizado','En Observaciones','En Renovación'];

        // Determina si requiere justificación
        $requiereJustificacion = ($estadoSolicitud != 'Acreditado')
            && !($nivelUsuario === "0" && in_array($estadoSolicitud, $estadosSinJustificacionParaNivel0));

        $dataEstado = array(
            'nombre' => $estadoSolicitud,
            'fechaUltimaActualizacion' => date('Y/m/d H:i:s'),
            'estadoAnterior' => $solicitud->nombre,
            'idSolicitudAcreditado' => $idSolicitud,
            'justificacionCambioEstado' => $requiereJustificacion ? trim($justificacionCambioEstado) : null,
        );
        // Validación: si requiere justificación y está vacía
        if ($requiereJustificacion && (is_null($justificacionCambioEstado) || trim($justificacionCambioEstado) === '')) {
            echo json_encode(array('title'=> 'Información incompleta', 'status' => 'warning', 'msg' => "Debe escribir la justificación del cambio de estado."));
            return;
        }
        // Validación: si el estado es el mismo que el actual
        if ($estadoSolicitud == $solicitud->nombre):
            echo json_encode(array('title'=> 'Error al guardar', 'status' => 'warning', 'msg' => "Seleccione un estado diferente al actual."));
            return;
        elseif ($estadoSolicitud == "Acreditado"):
            $this->db->where('idSolicitud', $idSolicitud);
            if ($this->db->update('estadoOrganizaciones', $dataEstado)):
                $dataOrganizacion = array('estado' => $estadoSolicitud,);
                $this->db->where('id_organizacion', $organizacion->id_organizacion);
                if ($this->db->update('organizaciones', $dataOrganizacion))
                    $this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó el estado de la organización con id: ' . $organizacion->id_organizacion . ' y el estado: ' . $estadoSolicitud . '.');
            endif;
            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'cambioEstadoSolicitud', $organizacion, null, null, $idSolicitud);
            return;
        else:
            $this->db->where('idSolicitud', $idSolicitud);
            if ($this->db->update('estadoOrganizaciones', $dataEstado)):
                $this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó el estado de la organización con id: ' . $organizacion->id_organizacion . ' y el estado: ' . $estadoSolicitud . '.');
            endif;
            // Suprimir envío de correo para los últimos estados creados
            if (in_array($estadoSolicitud, $estadosSinEmail)) {
                echo json_encode(array('title'=> 'Actualización', 'status' => 'success', 'msg' => 'Estado actualizado correctamente.'));
                return;
            }
            // Enviar correo solo si NO está en la lista de estados sin email
            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'cambioEstadoSolicitud', $organizacion, null, null, $idSolicitud);
            return;
        endif;
    }
    // Renovación solicitud
    public function renovarSolicitud()
    {
        if ($this->input->post()) {
            $solicitud = $this->SolicitudesModel->solicitudes($this->input->post('idSolicitud'));
            $organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
            
            // Obtener la resolución de la solicitud original para validar vigencia
            $resolucion = $this->ResolucionesModel->getResolucionSolicitud($this->input->post('idSolicitud'));
            
            // Determinar el estado que debe tener la solicitud original
            $estadoSolicitudOriginal = $solicitud->nombre; // Por defecto mantener el estado actual
            
            if ($resolucion) {
                $fechaActual = new DateTime();
                $fechaFinResolucion = new DateTime($resolucion->fechaResolucionFinal);
                
                // Si la resolución ya venció, marcar como vencida
                if ($fechaActual > $fechaFinResolucion) {
                    $estadoSolicitudOriginal = 'Vencida';
                }
            }
            
            $idSolicitud = date('YmdHis') . $organizacion->nombreOrganizacion[3] . random(2);
            $data_solicitud = array(
                'numeroSolicitudes' => $solicitud->numeroSolicitudes += 1,
                'fechaCreacion' =>  date('Y/m/d H:i:s'),
                'idSolicitud' => $idSolicitud,
                'organizaciones_id_organizacion' => $organizacion->id_organizacion,
            );
            $data_tipoSolicitud = array(
                'tipoSolicitud' => 'Renovación de Acreditación',
                'motivoSolicitud' => 'Programa organizaciones y redes SEAS.',
                'modalidadSolicitud' => 'Presencial, Virtual, A Distancia, Híbrida',
                'idSolicitud' => $idSolicitud,
                'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                'motivosSolicitud' => json_encode(["6"]) ,
                'modalidadesSolicitud' => json_encode(["1", "2", "3", "4"])
            );
            $data_estado = array(
                'nombre' => "En Renovación",
                'fechaUltimaActualizacion' => date('Y/m/d H:i:s'),
                'estadoAnterior' => $organizacion->estado,
                'tipoSolicitudAcreditado' => 'Renovación de Acreditación',
                'motivoSolicitudAcreditado' => 'Programa organizaciones y redes SEAS.',
                'modalidadSolicitudAcreditado' => 'Presencial, Virtual, A Distancia, Híbrida',
                'idSolicitudAcreditado' => $solicitud->idSolicitud,
                'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                'idSolicitud' => $idSolicitud,
            );
            
            // Actualizar el estado de la solicitud original según la validación de vigencia
            $data_update = array(
                'nombre' => $estadoSolicitudOriginal,
                'renovada' => 'Si',
            );
            
            $this->db->where('idSolicitud', $this->input->post('idSolicitud'));
            if ($this->db->update('estadoOrganizaciones', $data_update)):
                // Guardar datos iniciales de la solicitud
                $this->db->where('idSolicitud', $idSolicitud);
                if ($this->db->insert('solicitudes', $data_solicitud)):
                    if ($this->db->insert('tipoSolicitud', $data_tipoSolicitud)):
                        if ($this->db->insert('estadoOrganizaciones', $data_estado)):
                            $this->logs_sia->session_log('Creación de solicitud renovación' . '. Motivo Solicitud: ' . 'Programa organizaciones y redes SEAS.' . '. Modalidad Solicitud: ' . 'Presencial, Virtual, A Distancia, Híbrida' . '. ID: ' . $idSolicitud . '. Fecha: ' . date('Y/m/d H:i:s') . '. Estado solicitud original: ' . $estadoSolicitudOriginal . '.');
                            $this->logs_sia->logQueries();
                            send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'crearSolicitud', $organizacion, null, null, $idSolicitud);
                        endif;
                    endif;
                endif;
            endif;
        }
    }
}
function var_dump_pre($mixed = null)
{
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
    return null;
}
