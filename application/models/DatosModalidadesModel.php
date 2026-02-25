<?php
class DatosModalidadesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getDatosModalidades($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("datosModalidades")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('datosModalidades', array('idSolicitud' => $id));
		return $query->result();
	}
	public function getDatosModalidad($id = FALSE)
	{
		// Traer organizaciones por ID
		$query = $this->db->get_where('datosModalidades', array('id' => $id));
		return $query->row();
	}
}
