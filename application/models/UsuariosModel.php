<?php
class UsuariosModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getUsuarios($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("usuarios")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('usuarios', array('id_usuario' => $id));
		return $query->row();
	}
	/**
	 * Traer usuarios para super administrador
	 */
	public function getUsuariosSuperAdmin($id = FALSE) {
		if ($id	=== FALSE):
			$query = $this->db->select('*')->from('usuarios')->join('organizaciones', 'usuarios.id_usuario = organizaciones.usuarios_id_usuario')->join('token', 'usuarios.token_id_token = token.id_token')->get();
			return $query->result();
		else:
			$query = $this->db->select('*')->from('usuarios')->join('organizaciones', 'usuarios.id_usuario = organizaciones.usuarios_id_usuario')->join('token', 'usuarios.token_id_token = token.id_token')->where('usuarios.id_usuario', $id)->get();
			return $query->row();
		endif;
	}
	/** Cargar Actividad Usuario */
	public function getActividadUsuario($usuario)
	{
		$actividad = $this->db->select('*')->from('session_log')->where('usuario_id', $usuario)->order_by("id_session_log", "desc")->limit(70)->get()->result();
		return $actividad;

	}
	/**
	 * @return $password user
	 */
	public function getPassword ($pass) {
		$password = mc_decrypt($pass, KEY_RDEL);
		return $password;
	}
	/**
	 * @return $connect user
	 */
	public function getConnection($connect) {
		switch ($connect):
			case 0:
				return "No";
				break;
			case 1:
				return "Si";
				break;
			default:
				return "";
				break;
		endswitch;
	}
}
