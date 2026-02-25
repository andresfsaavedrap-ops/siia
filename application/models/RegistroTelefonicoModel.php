<?php

class RegistroTelefonicoModel extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Registros Telefónicos */
	public function getRegistrosTelefonicos()
	{
		$reportes = $this->db->select("*")->from("registroTelefonico")->get()->result();
		return $reportes;
	}
	public function getAdministradores($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer administradores
			$query = $this->db->select("*")->from("administradores")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('administradores', array('id_administrador' => $id));
		return $query->row();
	}
	public function getAdministrador($usuario)
	{
		// Traer administrador por usuario
		$query = $this->db->get_where('administradores', array('usuario' => $usuario));
		return $query->row();
	}

	/**
	 * Traer nombre de nivel administradores
	 */
	public function getNivel($id) {
		switch ($id):
			case 0:
				return "Total";
				break;
			case 1:
				return "Evaluador";
				break;
			case 2:
				return "Reportes";
				break;
			case 3:
				return "Cámaras";
				break;
			case 4:
				return "Histório";
				break;
			case 5:
				return "Segumiendo";
				break;
			case 6:
				return "Asignación";
				break;
			default:
				break;
		endswitch;
	}

	/**
	 * @return $password administrator
	 */
	public function getPassword ($pass) {
		$password = mc_decrypt($pass, KEY_RDEL);
		return $password;
	}

	/**
	 * Get name complete
	 * @param $user
	 * @return void
	 */
	public function getNameComplete($user){
		$user = $this->db->select('*')->from('administradores')->where('usuario', $user)->get()->row();
		$name = $user->primerNombreAdministrador . ' ' . $user->primerApellidoAdministrador;
		return $name;
	}
	/**
	 * Get email administrador
	 * @param $user
	 * @return void
	 */
	public function getEmail($user){
		$user = $this->db->select('*')->from('administradores')->where('usuario', $user)->get()->row();
		return $user->direccionCorreoElectronico;
	}
	/**
	 * Get email coordinador
	 */
	public function getCoordinador(){
		$user = $this->db->select('*')->from('administradores')->where('nivel', 6)->get()->row();
		return $user->direccionCorreoElectronico;
	}
}
