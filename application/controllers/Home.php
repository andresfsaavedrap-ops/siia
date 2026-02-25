<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('SolicitudesModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('DocentesModel');
		setlocale(LC_ALL, 'es_CO.UTF-8');
	}

	/**
		Funcion Index para cargar las vistas necesarias.
	 **/
	public function index()
	{
		$data['title'] = 'Inicio';
		$data['activeLink'] = 'home';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";
		$this->load->view('include/header/guest', $data);
		$this->load->view('home');
		$this->load->view('include/footer/guest');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function cargarOpcionesSistema()
	{
		$opciones = $this->db->select("*")->from("opciones")->get()->result();
		echo json_encode($opciones);
	}

	public function construccion()
	{
		$data['title'] = 'En contrucción';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";

		$this->load->view('404_r');
		$this->logs_sia->logs('PLACE_USER');
	}

	public function ejemploCorreos()
	{
		$this->load->view('email/contacto');
		$this->load->view('email/recordar_contrasena');
		$this->load->view('email/verificacion_cuenta');
	}

	public function mantenimiento()
	{
		$data['title'] = 'En mantenimiento';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";

		$this->load->view('mantenimiento');
		$this->logs_sia->logs('PLACE_USER');
	}

	public function mapa()
	{
		$data['title'] = 'Mapa Gestión';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";

		$this->load->view('include/header', $data);
		$this->load->view('mapagestion/mapa');
		$this->load->view('include/footer');
		$this->logs_sia->logs('PLACE_USER');
	}

	public function estadoSolicitud()
	{
		$data['title'] = 'Estado de la organización - solicitud';
		$data['activeLink'] = 'estado';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";
		$this->load->view('include/header/guest', $data);
		$this->load->view('estadoSolicitud');
		$this->load->view('include/footer/guest');
		$this->logs_sia->logs('PLACE_USER');
	}

	public function facilitadores()
	{
		$data['title'] = 'Facilitadores válidos';
		$data['activeLink'] = 'facilitadores';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$data['nombre_usuario'] = "none";
		$this->load->view('include/header/guest', $data);
		$this->load->view('facilitadores');
		$this->load->view('include/footer/guest');
		$this->logs_sia->logs('PLACE_USER');
	}

	public function consultarEstado()
	{
		// Recaptcha
		$recaptcha = recaptcha_validate($this->input->post('token'));
		if ($recaptcha['success'] == true && $recaptcha['score'] >= 0.5):
			$solicitud = $this->SolicitudesModel->solicitudes($this->input->post('idSolicitud'));
			$organizacion = $this->OrganizacionesModel->getOrganizacion($solicitud->organizaciones_id_organizacion);
			if($solicitud):
				echo json_encode(array('status' => 'success', 'msg' => 'Solicitud encontrada, verifique el estado en el siguiente detalle', 'solicitud' => $solicitud, 'organizacion' => $organizacion));
			else:
				echo json_encode(array('status' => 'error', 'msg' => 'Numero de solicitud no encontrado, por favor verífique'));
			endif;
		endif;
	}
	public function consultarFacilitadores()
	{
		// Recaptcha
		$recaptcha = recaptcha_validate($this->input->post('token'));
		if ($recaptcha['success'] == true && $recaptcha['score'] >= 0.5):
			$organizacion =$this->OrganizacionesModel->getOrganizaciones($this->input->post('nit'));
			if ($organizacion != "") {
				$facilitadores = $this->DocentesModel->getDocentesValidos($organizacion->id_organizacion);
			}
			echo json_encode(array("status" => "success", "facilitadores" => $facilitadores));
		endif;
	}

	public function verificarUsuario()
	{
		// Comprobar que el nombre de usuario y el nit no se encuentre en la base de datos. 
		// $nitOrganizacion = $this->db->select("numNIT")->from("organizaciones")->where("numNIT", $this->input->post('nit'))->get()->row()->numeroNIT;
		$nombreUsuario = $this->db->select("usuario")->from("usuarios")->where("usuario", $this->input->post('nombre'))->get()->row()->usuario;

		if ($nombreUsuario != NULL || $nombreUsuario != "") {
			echo json_encode(array("existe" => 1));
		} else {
			echo json_encode(array("existe" => 0));
		}
	}
}
