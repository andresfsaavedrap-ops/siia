<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PersonasCapacitadas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PersonasModel');
	}
	// Traer datos estadisticos
	public function index()
	{
		$data = array(
			'personasCapacitadas' => $this->PersonasModel->personasCapacitadas(),
		);
		// Json datos estadisticos
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	// Variables de Session
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
	// Panel Estadistico
	public function panel()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal / Administrador / Estadisticas / Panel';
		$this->load->view('include/header', $data);
		$this->load->view('admin/estadisticas/estadisticas', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Estdisticas del acreditacion
	public function acreditacion()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal / Administrador / Estadisticas / Tramite';
		$this->load->view('include/header', $data);
		$this->load->view('admin/estadisticas/acreditacion', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// public function view($id = NULL)
	// {
	// 	$data['estadisticasmodel'] = $this->EstadisticasModel->get_solicitudes($id);
	// }
}
