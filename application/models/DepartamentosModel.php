<?php
class DepartamentosModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Departamentos */
	public function getDepartamentos()
	{
		$departamentos = $this->db->select("*")->from("departamentos")->get()->result();
		return $departamentos;
	}
}
