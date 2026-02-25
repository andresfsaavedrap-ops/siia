<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RegistroTelefonico extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welco7me
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('RegistroTelefonicoModel');
	}
	/** Datos Sesión */
	public function datosSession()
	{
		verify_session_admin();
		date_default_timezone_set("America/Bogota");
		$data = array(
			'logged_in' => $this->session->userdata('logged_in'),
			'nombre_usuario' => $this->session->userdata('nombre_usuario'),
			'usuario_id' => $this->session->userdata('usuario_id'),
			'tipo_usuario' => $this->session->userdata('type_user'),
			'nivel' => $this->session->userdata('nivel'),
			'hora' => date("H:i", time()),
			'fecha' => date('Y/m/d'),
		);
		return $data;
	}
	public function index()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal - Administrador - Registro telefónico';
		$data['registros'] = $this->RegistroTelefonicoModel->getRegistrosTelefonicos();
		$this->load->view('include/header/main', $data);
		$this->load->view('admin/pages/reportes/telefonico', $data);
		$this->load->view('include/footer/main', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	/**
	 * Crear registro telefónico
	 */
	public function create()
	{
		$data = array(
			"funcionario" => $this->input->post('funcionario'),
			"cargo" => $this->input->post('cargo'),
			"telefono" => $this->input->post('telefono'),
			"tipoLlamada" => $this->input->post('tipoLlamada'),
			"tipoComunicacion" => $this->input->post('tipoComunicacion'),
			"idSolicitud" => $this->input->post('idSolicitud'),
			"fecha" => $this->input->post('fecha'),
			"duracion" => $this->input->post('duracion'),
			"descripcion" => $this->input->post('descripcion'),
			"organizaciones_id_organizacion" => $this->input->post('organizaciones_id_organizacion'),
			"administradores_id_administrador" => $this->input->post('administradores_id_administrador'),
		);

		if ($this->db->insert('registroTelefonico', $data)) {
			echo json_encode(array('title' => 'Guardado', 'status' => 'success', 'msg' => "Se ingreso el registro telefónico."));
			$this->logs_sia->session_log('Se ingreso el registro telefónico con NIT:' . $data['organizacion_id_organizacion'] . ' nombre:' . $data['funcionario'] . ' y teléfono:' . $data['teléfono']);
		}
	}
	/**
	 * Traer registro de llamadas completo
	 */
	// Cargar información organización inscrita
	public function getRegistrosTelefonicos()
	{
		$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('id_organizacion'));
		$usuario = $this->UsuariosModel->getUsuarios($organizacion->usuarios_id_usuario);
		$actividad = $this->UsuariosModel->getActividadUsuario($organizacion->usuarios_id_usuario);
		$solicitudes = $this->SolicitudesModel->getSolicitudesByOrganizacion($organizacion->id_organizacion);
		echo json_encode(array('organizacion' => $organizacion, 'actividad' => $actividad, 'usuario' => $usuario, 'solicitudes' => $solicitudes));
	}

}
