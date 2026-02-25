<?php
class DatosProgramasModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getDatosProgramas($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("datosProgramas")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->select('*')->from('datosProgramas')->where('idSolicitud', $id)->get();
		return $query->result();
	}
}
