<?php
class BateriaObservacionesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/**
     * Cargar datos información general
     */
	public function getBateriaObservaciones($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("bateriaObservaciones")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('bateriaObservaciones', array('organizaciones_id_organizacion' => $id));
		return $query->row();
	}
}
