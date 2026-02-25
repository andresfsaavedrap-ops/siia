<?php
class EstadisticasModel extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}
	// Traer entidades acreditadas
	public function organizacionesAcreditadas($id = FALSE)
	{
		if ($id === FALSE) {

			// Consulta para traer organizaciones acreditas
			$query = $this->db->select("*")->from("viewOrganizacionesAcreditadas")->get();
			return $query->result_array();
		}
		// Traer solicitudes por id
		$query = $this->db->get_where('viewOrganizacionesAcreditadas', array('id' => $id));
		return $query->row_array();
	}
	// Traer entidades curso basico
	public function organizacionesBasico($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones curso basico
			$query = $this->db->select("*")->from("viewOrganizacionesBasico")->get();
			return $query->result_array();
		}
		// Traer solicitudes por id
		$query = $this->db->get_where('viewOrganizacionesBasico', array('id' => $id));
		return $query->row_array();
	}
	// Traer entidades avaladas
	public function organizacionesAvaladas($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones avaladas
			$query = $this->db->select("*")->from("viewOrganizacionesAvaladas")->get();
			return $query->result_array();
		}
		// Traer solicitudes por id
		$query = $this->db->get_where('viewOrganizacionesAvaladas', array('id' => $id));
		return $query->row_array();
	}
	// Traer entidades con modalidad virtual
	public function organizacionesVirtual($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones acreditadas con modalidad virtual
			$query = $this->db->select("*")->from("viewOrganizacionesVirtual")->get();
			return $query->result_array();
		}
		// Traer solicitudes por id
		$query = $this->db->get_where('viewOrganizacionesVirtual', array('id' => $id));
		return $query->row_array();
	}
}


// get_where('solicitudes', array('fecha' => "solicitudes"));
	// Variables para consultas del tramite
	// $años  = ->join('solicitudes', 'solicitudes.organizaciones_id_organizacion = organizaciones.id_organizacion')->join('tipoSolicitud', 'tipoSolicitud.organizaciones_id_organizacion', 'organizaciones.id_organizacion')
	// $data_organizaciones = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes")->where("organizaciones.id_organizacion", $id_org)->where("estadoOrganizaciones.organizaciones_id_organizacion", $id_org)->where("solicitudes.organizaciones_id_organizacion", $id_org)->get()->row();
	// Retornar resultas en forma de array
	// foreach ($id_organizaciones as $id_organizacion) {
	// 	$id_org = $id_organizacion->organizaciones_id_organizacion;
	// 	array_push($organizaciones, $data_organizaciones);
	// }
	// return $organizaciones;
	// echo json_encode($organizaciones);
	// var_dump($data);
