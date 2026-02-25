<?php
class DatosEnLineaModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getDatosEnLinea($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("datosEnLinea")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('datosEnLinea', array('idSolicitud' => $id));
		return $query->result();
	}
}
