<?php
class AntecedentesAcademicosModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getAntecedentesAcedemicos($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("antecedentesAcademicos")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('antecedentesAcademicos', array('idSolicitud' => $id));
		return $query->result();
	}
}
