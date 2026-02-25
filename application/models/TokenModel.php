<?php
class TokenModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getToken($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("token")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('token', array('id_token' => $id));
		return $query->row();
	}
	/** Cargar token por usuario */
	public function getTokenUsuario($id){
		$query = $this->db->get_where('token', array('usuario_token' => $id));
		return $query->row();
	}
	/**
	 * @return $state user
	 */
	public function getState($state) {
		switch ($state):
			case "0":
				return "No Verificado";
				break;
			case "1":
				return "Verificado";
				break;
			case "2":
				return "Bloqueado";
				break;
			default:
				break;
		endswitch;
	}
}
