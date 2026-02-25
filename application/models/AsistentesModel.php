<?php

class AsistentesModel extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	/**
	 * Cargar asistentes y por organización
	 */
	public function getAsistentes($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer docentes
			$query = $this->db->select("*")->from("asistentes")->get();
			return $query->result();
		}
		// Traer docentes por ID
		$query = $this->db->get_where('asistentes', array('organizaciones_id_organizacion' => $id));
		return $query->result();
	}
	/**
	 * Cargar Asistentes por cursos
	 */
	public function getAsistentesCurso($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer docentes
			$query = $this->db->select("*")->from("asistentes")->get();
			return $query->result();
		}
		// Traer docentes por ID
		$query = $this->db->get_where('asistentes', array('informeActividades_id_informeActividades' => $id));
		return $query->result();
	}
	/**
	 * Cargar asistente
	 */
	public function getAsistente($id = FALSE)
	{
		// Traer docentes por ID
		$query = $this->db->get_where('asistentes', array('id_asistentes' => $id));
		return $query->row();
	}
}
