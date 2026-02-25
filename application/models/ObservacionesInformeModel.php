<?php
class ObservacionesInformeModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/**
	 * Traer observaciones informe de actividades
	 */
	public function getObservacionesInforme($id = FALSE) {
		if ($id === FALSE) {
			// Consulta para traer docentes
			$query = $this->db->select("*")->from("observaciones_informe")->get();
			return $query->result();
		}
		// Traer docentes por ID
		$query = $this->db->get_where('observaciones_informe', array('informeActividades_id_informeActividades' => $id));
		return $query->result();
	}
}


