<?php
class EncuestaModel extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}
	// Traer entidades acreditadas
	public function encuestas($id = FALSE)
	{
		if ($id === FALSE) {

			// Consulta para traer organizaciones acreditas
			$query = $this->db->select("*")->from("encuesta")->get();
			return $query->result_array();
		}
		// Traer solicitudes por id
		$query = $this->db->get_where('encuesta', array('id' => $id));
		return $query->row_array();
	}
}
