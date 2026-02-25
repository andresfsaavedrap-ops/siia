<?php
class CorreosRegistroModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Organizaciones */
	public function getCorreosRegistro($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("correosregistro")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('correosregistro', array('id_correosRegistro' => $id));
		return $query->row();
	}
}
