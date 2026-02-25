<?php
class JornadasActualizacionModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getJornadasActualizacion($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("jornadasActualizacion")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('jornadasActualizacion', array('idSolicitud' => $id));
		return $query->row();
	}
}
