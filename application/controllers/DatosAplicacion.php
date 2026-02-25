<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DatosAplicacion extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('OrganizacionesModel');
		$this->load->model('DatosAplicacionModel');
		verify_session();
	}
	// Formulario 6
	public function create()
	{
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		$datos_plataforma_url = $this->input->post("datos_plataforma_url");
		$datos_plataforma_usuario = $this->input->post("datos_plataforma_usuario");
		$datos_plataforma_contrasena = $this->input->post("datos_plataforma_contrasena");
		$data_aplicacion = array(
			'urlAplicacion' => $datos_plataforma_url,
			'usuarioAplicacion' => $datos_plataforma_usuario,
			'contrasenaAplicacion' => $datos_plataforma_contrasena,
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
			'idSolicitud' => $this->input->post('idSolicitud'),
		);
		$this->db->insert('datosAplicacion', $data_aplicacion);
		echo json_encode(array('status' => "success", 'msg' => "Se guardo la información de la plataforma."));
	}
}
