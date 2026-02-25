
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
/**
 * Controlador para gestión de docentes/facilitadores
 * Maneja CRUD de docentes, archivos y validaciones
 */
class AdminDocentes extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // Cargar modelos específicos del controlador
        $this->load->model('DocentesModel');
        $this->load->model('InformacionGeneralModel');
    }
    /**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }

	/* Panel administrativo de docentes */
    public function index()
    {
        $data = $this->datosSesionAdmin();
		$data['activeLink'] = 'docentes';
        $data['title'] = 'Administrador / Facilitadores / Panel';
		$data['docentes'] = $this->DocentesModel->getDocentes();
        $this->loadView('admin/organizaciones/docentes/index', $data);
    }

    /* Panel administrativo de docentes */
    public function inscritos()
    {
        $data = $this->datosSesionAdmin();
		$data['activeLink'] = 'docentes';
        $data['title'] = 'Administrador / Facilitadores / Panel';
		$data['docentes'] = $this->DocentesModel->getDocentes();
        $this->loadView('admin/organizaciones/docentes/inscritos', $data);
    }
    /** Asignar docentes para evaluación */
    public function asignar()
    {
        $data = $this->datosSesionAdmin();
		$data['activeLink'] = 'docentes-asignaciones';
        $data['title'] = 'Panel Principal / Administrador / Facilitadores / Asignar';
        $data['docentes'] = $this->DocentesModel->getDocentes();
        $this->loadView('admin/organizaciones/docentes/asignar', $data);
    }
	/** Asignar docente a un evaluador */
	public function asignarDocente()
	{
		$id_docente = $this->input->post('id_docente');
		$docente = $this->db->select("*")->from("docentes")->where("id_docente", $id_docente)->get()->row();
		$evaluador = $this->db->select("*")->from("administradores")->where("usuario", $this->input->post('evaluadorAsignar'))->get()->row();
		$organizacion = $this->OrganizacionesModel->getOrganizacion($docente->organizaciones_id_organizacion);
		$data_asignar = array(
			'asignado' => $this->input->post('evaluadorAsignar')
		);
		$this->db->where('id_docente', $id_docente);
		if ($this->db->update('docentes', $data_asignar)) {
			$this->logs_sia->session_log('Se asigno ' . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . ' a ' . $evaluador->primerNombreAdministrador . ' en la fecha ' . date("Y/m/d H:m:s") . '.');
			// Enviar correo al evaluador usando el helper de emails
			send_email_admin('asignarDocente', 2, $evaluador->direccionCorreoElectronico, $docente, $organizacion);
		}
	}
    /**  Evaluar docentes */
    public function evaluar()
	{
        $data = $this->datosSesionAdmin();
		$data['activeLink'] = 'docentes-evaluacion';
        $data['title'] = 'Panel Principal / Administrador / Facilitadores / Evaluar';
        $data['docentes'] = $this->DocentesModel->getDocentes();
        $this->loadView('admin/organizaciones/docentes/evaluar', $data);
    }
	/** Validar estado de docentes (aprobar/rechazar)
	 * Actualiza el estado de validación de un docente y registra la acción
	 * @return void Retorna respuesta JSON con el resultado de la operación
	 */
	public function validarDocentes()
	{
	    // Obtener parámetros de entrada
	    $observacion = $this->input->post('docente_val_obs');
		$docente = $this->DocentesModel->getDocente($this->input->post('id_docente'));
		$organizacion = $this->OrganizacionesModel->getOrganizacion($docente->organizaciones_id_organizacion);
	    // Preparar datos de actualización según el estado de validación
	    if ($this->input->post('valido') == 1) {
	        // Docente válido - limpiar asignación
	        $data_update = array(
	            'valido' => $this->input->post('valido'),
	            'asignado' => ''
	        );
	    } else {
	        $data_update = array(
	            'valido' => $this->input->post('valido'),
	            'observacion' => $observacion,
	            'observacionAnterior' => $docente->observacion,
	            'asignado' => $docente->asignado
	        );
			$observacionDocente = array(
				'observacion' => $observacion,
				'docentes_id_docente' => $docente->id_docente,
				'administradores_id_administrador' => $this->session->userdata('usuario_id'),
				'created_at' => date("Y/m/d H:m:s"),
			);
			// Insertar observación en la tabla de observaciones
		 	$this->db->insert('observacionesDocente', $observacionDocente);
	    }
	    // Actualizar registro del docente
	    $this->db->where('id_docente', $docente->id_docente);
	    if ($this->db->update('docentes', $data_update)) {
			if(!empty($observacionDocente)){
				// Enviar correo al usuario usando el helper de emails
				send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'observacionesDocente', $organizacion, $docente, $observacion );
			}
			else{
				send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'docenteAprobado', $organizacion, $docente);
			}
			// TODO: Notificaciones
	        // Enviar notificación al usuario de la organización
	        /* $this->notif_sia->notification('Docente', $nombre_usuario, ""); */
	        // Opción para envío de email (comentada)
	        // $this->envio_mail("docentes", $id_organizacion, 2, "");
	    }
	}
    /** Componente: Evaluación de docentes por organización (renderiza HTML) */
    public function componenteEvaluacionOrganizacion()
    {
        $id_org = $this->input->get('idOrganizacion');
        $organizacion = $this->OrganizacionesModel->getOrganizacion($id_org);
        $docentes = $this->DocentesModel->getDocentes($id_org);
		// Docente inicial para evaluación
        $docenteInicial = null;
        $archivosInicial = [];
        if (!empty($docentes)) {
            $docenteInicial = $docentes[0];
            $archivosInicial = $this->db->select("*")->from("archivosDocente")->where("docentes_id_docente", $docenteInicial->id_docente)->get()->result();
        }
		// Agregar datos de sesión para control de permisos
        $sessionData = $this->datosSesionAdmin();
		// Data para renderizar HTML
        $data = array(
            'organizacion'   => $organizacion,
            'docentes'       => $docentes,
            'docenteInicial' => $docenteInicial,
            'archivosInicial'=> $archivosInicial,
			'nivel'         => $sessionData['nivel'], // Pasar el nivel del usuario
        );
        $html = $this->load->view('admin/organizaciones/docentes/componente_evaluacion', $data, true);
        echo $html;
    }
    /** Componente parcial: Información + Archivos de un docente */
    public function componenteDocente()
    {
        $id_docente = $this->input->get('idDocente');
        $docente = $this->db->select('*')->from('docentes')->where('id_docente', $id_docente)->get()->row();
        $archivos = $this->db->select('*')->from('archivosDocente')->where('docentes_id_docente', $id_docente)->get()->result();
        // Observaciones históricas del docente
        $observaciones = $this->db->select('*')
            ->from('observacionesDocente')
            ->where('docentes_id_docente', $id_docente)
            ->order_by('created_at', 'DESC')
            ->get()->result();
        // Agregar datos de sesión para control de permisos
        $sessionData = $this->datosSesionAdmin();
        $data = array(
            'docente'       => $docente,
            'archivos'      => $archivos,
            'observaciones' => $observaciones,
            'nivel'         => $sessionData['nivel'], // Pasar el nivel del usuario
        );
        $this->load->view('admin/organizaciones/docentes/componente_docente', $data);
    }
    /** Render embebido del componente de evaluación según NIT de la organización */
    public function evaluacionEmbed()
    {
        // Acepta POST o GET
        $nit = $this->input->post('nit', true) ?: $this->input->get('nit', true);
        if (!$nit) {
            echo ''; return;
        }

        // Buscar organización por NIT
        $organizacion = $this->db->select('*')->from('organizaciones')->where('numNIT', $nit)->get()->row();
        if (!$organizacion) {
            echo '<div class="alert alert-warning">No se encontró la organización con NIT ' . htmlspecialchars($nit, ENT_QUOTES, 'UTF-8') . '.</div>';
            return;
        }
		// Agregar datos de sesión para control de permisos
        $sessionData = $this->datosSesionAdmin();
        // Cargar docentes de la organización
        $docentes = $this->db->select('*')
            ->from('docentes')
            ->where('organizaciones_id_organizacion', $organizacion->id_organizacion)
            ->get()->result();

        // Docente inicial (primero si existe)
        $docenteInicial = !empty($docentes) ? $docentes[0] : null;

        // Archivos del docente inicial
        $archivosInicial = array();
        if ($docenteInicial) {
            $archivosInicial = $this->db->select('*')
                ->from('archivosDocente')
                ->where('docentes_id_docente', $docenteInicial->id_docente)
                ->get()->result();
        }

        // Renderizar componente y devolver HTML
        $html = $this->load->view(
            'admin/organizaciones/docentes/componente_evaluacion',
            [
                'organizacion'  => $organizacion,
                'docentes'      => $docentes,
                'docenteInicial'=> $docenteInicial,
                'archivosInicial'=> $archivosInicial,
				'nivel'         => $sessionData['nivel'], // Pasar el nivel del usuario
            ],
            true
        );
        echo $html;
    }
    public function actualizarArchivoDocente()
    {
        $id = (int)$this->input->post('id_archivoDocente');
        $observacion = trim((string)$this->input->post('observacionArchivo'));
        if ($id <= 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['ok' => false, 'msg' => 'ID de archivo inválido']));
            return;
        }
        $this->db->where('id_archivosDocente', $id);
        $ok = $this->db->update('archivosDocente', ['observacionArchivo' => $observacion]);
        if ($ok) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['ok' => true, 'msg' => 'Observación actualizada']));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(['ok' => false, 'msg' => 'No se pudo actualizar la observación']));
        }
    }
}
