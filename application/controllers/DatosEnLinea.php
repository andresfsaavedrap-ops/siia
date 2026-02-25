<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DatosEnLinea extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('OrganizacionesModel');
		$this->load->model('DatosEnLineaModel');
		verify_session();
	}
	// Formulario 7
	public function create()
	{
		$organizaciones = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		// Datos formulario
		$data = array(
			'nombreHerramienta' => $this->input->post("nombreHerramienta"),
			'descripcionHerramienta' => $this->input->post("descripcionHerramienta"),
			'fecha' => date('Y/m/d H:i:s'),
			'aceptacion' => $this->input->post("aceptacion"),
			'organizaciones_id_organizacion' => $organizaciones->id_organizacion,
			'idSolicitud' => $this->input->post('idSolicitud'),
		);
		// Guardar datos.
		if($this->db->insert('datosEnLinea', $data)) {
			echo json_encode(array('title' => 'Guardado Exitoso!', 'status' => "success", 'msg' => "Se guardo correctamente la información"));
		}
	}
}
