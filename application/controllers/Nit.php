<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
class Nit extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('NitsModel');
	}
	/**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
	/** NITS Entidades */
	public function index()
	{
		$data = $this->datosSesionAdmin();
		$data['nits'] = $this->NitsModel->getNits();
		$data['activeLink'] = 'operaciones';
		$data['organizaciones'] = $this->OrganizacionesModel->getOrganizacionesEstadoAcreditado();
		$this->loadView('admin/operaciones/nit-entidades', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Cargar datos organizaciones */
	public function cargarDatosOrganizacion()
	{
		$id= $this->input->post('id');
		$organizacion = $this->db->select('*')->from('organizaciones')->where('organizaciones.numNIT', $id)->where('estado', 'Acreditado')->get()->row();
		$solicitudes = $this->db->select('*')->from('estadoOrganizaciones')
			->join('solicitudes', 'solicitudes.organizaciones_id_organizacion = estadoOrganizaciones.organizaciones_id_organizacion')
			->join('tipoSolicitud', 'tipoSolicitud.organizaciones_id_organizacion = estadoOrganizaciones.organizaciones_id_organizacion')
			->where('estadoOrganizaciones.organizaciones_id_organizacion', $id)->get()->result();
		$resoluciones = $this->db->select('*')->from('resoluciones')->where('resoluciones.organizaciones_id_organizacion', $organizacion->id_organizacion)->get()->result();
		echo json_encode(array('msg' => 'Información Cargada' ,'organizacion' => $organizacion, 'solicitudes' => $solicitudes, 'resoluciones' => $resoluciones));
	}
	/** Cargar datos resolución */
	public function cargarDatosResolucion()
	{
		$idResolucion = $this->input->post('idResolucion');
		$resolucion = $this->db->select('*')->from('resoluciones')->where('resoluciones.id_resoluciones', $idResolucion)->get()->row();
		echo json_encode(array('msg' => 'Información Cargada', 'resolucion' => $resolucion));
	}
	/** Guardar NITS */
	public function guardarNitAcreditadas()
	{
		$data_nit_acre = array(
			'numNIT' => $this->input->post('nit_org'),
			'nombreOrganizacion' => $this->input->post('nombreOrganizacion'),
			'numeroResolucion' => $this->input->post('numeroResolucion'),
			'fechaFinalizacion' => $this->input->post('fechaFinalizacion')
		);
		if ($this->db->insert('nits_db', $data_nit_acre)) {
			echo json_encode(array('msg' => "El nit se guardo."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' creo un nit de entidades acreditadas.');
		}
	}
	// Eliminar NIT Acreditado
	public function eliminarNitAcreditadas()
	{
		$id_nit = $this->input->post('id_nit');
		$this->db->where('idnits_db', $id_nit);
		if ($this->db->delete("nits_db")) {
			echo json_encode(array('msg' => "El nit se elimino."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' elimino el nit de una entidad acreditada con id: ' . $id_nit . '.');
		}
	}
	// Verificar si la resolución ya existe en la tabla correspondiente
	public function verificarResolucionExistente()
	{
		$numeroResolucion = $this->input->post('numeroResolucion');
		$numNIT = $this->input->post('numNIT');
		// Consultar si la resolución ya existe en la tabla correspondiente
		$existe = $this->NitsModel->verificarResolucionExiste($numeroResolucion, $numNIT);
		$response = array(
			'existe' => $existe,
			'numeroResolucion' => $numeroResolucion,
			'numNIT' => $numNIT
		);
		echo json_encode($response);
	}
}


