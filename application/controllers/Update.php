<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welco7me
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();	
	}
	public function update_password(){
		$this->form_validation->set_rules('contrasena_anterior','','trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('contrasena_nueva','','trim|required|min_length[3]|xss_clean');

		if($this->form_validation->run("formulario_actualizar_contrasena") == FALSE)
		{
			echo json_encode(array('url'=>"perfil", 'msg'=>"Verifique los datos."));
		}
		else
		{
			$usuario_id = $this->session->userdata('usuario_id');
			$datos_usuario = $this->db->select('usuario')->from('usuarios')->where('id_usuario', $usuario_id)->get()->row();
			$nombre_usuario = $datos_usuario ->usuario;

			$contrasena_anterior = $this->input->post('contrasena_anterior');
			$contrasena_nueva = $this->input->post('contrasena_nueva');

			if(verify_login($nombre_usuario, $contrasena_anterior)){
				$password_rdel = mc_encrypt($contrasena_nueva, KEY_RDEL);
				$password_hash = generate_hash($contrasena_nueva);

				$data_update = array(
								'contrasena' => $password_hash,
								'contrasena_rdel' => $password_rdel
				);
				$this->db->where('id_usuario', $usuario_id);
				$this->db->update('usuarios', $data_update);

				$this->logs_sia->session_log('Actualizacion de Contraseña');
				echo json_encode(array('url'=>"perfil", 'msg'=>"Se actualizó la contraseña."));
			}else{
				echo json_encode(array('url'=>"perfil", 'msg'=>"La contraseña ingresada no concide con la actual."));
			}
		}
		$this->logs_sia->logQueries();
		$this->logs_sia->logs('URL_TYPE');
	}
	public function update_user(){
		$this->form_validation->set_rules('usuario_nuevo','','trim|required|min_length[3]|xss_clean');
		if($this->form_validation->run("formulario_actualizar_usuario") == FALSE){
			echo json_encode(array('url'=>"perfil", 'msg'=>"Verifique los datos."));
		}else{
			$usuario_nuevo = $this->input->post('usuario_nuevo');
			$usuario_id = $this->session->userdata('usuario_id');

			$nombre_usuarios = $this->db->select("*")->from("usuarios")->where("usuario", $usuario_nuevo)->get()->row();

			if($nombre_usuarios == NULL){
				$data_update = array(
								'usuario' => $usuario_nuevo
				);
				$this->db->where('id_usuario', $usuario_id);
				$this->db->update('usuarios', $data_update);

				$data_update_token = array(
								'usuario_token' => $usuario_nuevo
				);
				$nombre_usuario = $this->session->userdata('nombre_usuario');
				$this->db->where('usuario_token', $nombre_usuario);
				$this->db->update('token', $data_update_token);

				$this->logs_sia->session_log('Actualizacion de Nombre de Usuario');
				echo json_encode(array('url'=>"perfil", 'msg'=>"Se actualizó el Nombre de Usuario."));
			}else{
				echo json_encode(array('url'=>"perfil", 'msg'=>"El nombre de usuario ya existe, elija otro."));
			}
		}
		$this->logs_sia->logQueries();
		$this->logs_sia->logs('URL_TYPE');
	}
}
