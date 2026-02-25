<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('OrganizacionesModel');
		$this->load->model('UsuariosModel');
		$this->load->model('TokenModel');
	}
	/** Vista formulario registro */
	public function index()
	{
		$data = array(
			'title' => 'Registro',
			'loggen_in' => false,
			'tipo_usuario' => "none",
			'activeLink' => "register"
		);
		$this->load->view('include/header/main', $data);
		$this->load->view('user/register');
		$this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Verificar si existe usuario */
	public function verificarUsuario()
	{
		// Comprobar que el nombre de usuario no se encuentre en la base de datos.
		if ($this->input->post('id')) {
			$usuario = $this->UsuariosModel->getUsuarios($this->input->post('id'));
			if (!empty($usuario)) {
				if ($usuario->usuario === $this->input->post('nombre_usuario')) {
					echo json_encode(array('existe' => 0));
					exit();
				}
			}
		}
		$nombreUsuario = $this->db->select("usuario")->from("usuarios")->where("usuario", $this->input->post('nombre_usuario'))->get()->row()->usuario;
		if ($nombreUsuario != NULL || $nombreUsuario != "") {
			echo json_encode(array("existe" => 1));
		} else {
			echo json_encode(array("existe" => 0));
		}
	}
	/** Verificar si existe nit */
	public function verificarNIT()
	{
		// Comprobar que el nit no se encuentre en la base de datos.
		$nit = $this->db->select("numNIT")->from("organizaciones")->where("numNIT", $this->input->post('nit'))->get()->row()->numNIT;
		if ($nit != NULL || $nit != "") {
			echo json_encode(array("existe" => 1));
		} else {
			echo json_encode(array("existe" => 0));
		}
	}
	/** Verificar si existe email */
	public function verificarEmail()
	{
		// Comprobar que el nit no se encuentre en la base de datos.
		$organizacion = $this->db->select("*")->from("organizaciones")->where("direccionCorreoElectronicoOrganizacion", $this->input->post('correo'))->get()->row();
		if ($organizacion->usuarios_id_usuario == $this->session->userdata('usuario_id')) {
			echo json_encode(array("existe" => 0));
		} else {
			$correo = $organizacion->direccionCorreoElectronicoOrganizacion;
			if ($correo != NULL || $correo != "") {
				echo json_encode(array("existe" => 1));
			} else {
				echo json_encode(array("existe" => 0));
			}
		}
	}
	/** Registro de información  */
	public function registrar_info()
	{
		$recaptcha = recaptcha_validate($this->input->post('token'));
		if ($recaptcha['success'] == true && $recaptcha['score'] >= 0.5):
			/** Reglas de validación formulario */
			$this->form_validation->set_rules('organizacion', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('nit', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('sigla', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('nombre', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('nombre_s', '', 'trim|xss_clean');
			$this->form_validation->set_rules('apellido', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('apellido_p', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('apellido_s', '', 'trim|xss_clean');
			$this->form_validation->set_rules('correo_electronico', '', 'trim|required|min_length[3]|valid_email|xss_clean');
			$this->form_validation->set_rules('correo_electronico_rep_legal', '', 'trim|required|min_length[3]|valid_email|xss_clean');
			$this->form_validation->set_rules('nombre_p', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('nombre_usuario', '', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('password', '', 'trim|required|min_length[3]|xss_clean');
			/** Correr validación de formulario */
			if ($this->form_validation->run("formulario_registro") == FALSE) {
				// Capturar error si la validación falsa
				$error = validation_errors();
				// Imprimir error de validación
				echo json_encode(array('url' => "registro", 'msg' => $error));
			} else {
				/**	@var $nombreUsuario
				 * Capturar nombre de usuario
				 */
				$nombreUsuario = $this->db->select("usuario")->from("usuarios")->where("usuario", $this->input->post('nombre_usuario'))->get()->row()->usuario;
				/**	@var $nit
				 * Capturar nit organización
				 */
				$nit = $this->db->select("numNIT")->from("organizaciones")->where("numNIT", $this->input->post('nit'))->get()->row()->numNIT;
				/** Comprobar que usuario existe */
				if ($nombreUsuario != NULL || $nombreUsuario != "") {
					echo json_encode(array('url' => "registro", "msg" => "Usuario existente, intente de nuevo"));
				}
				/** Comprobar que NIT existe */
				elseif ($nit != NULL || $nit != "") {
					echo json_encode(array('url' => "registro", "msg" => "NIT existente, intente de nuevo"));
				}
				/** Acción si no existe ni usuario ni nit */
				else {
					/** Capturar Data Tabla Usuario */
					$data_registro_user = array(
						'usuario' => $this->input->post('nombre_usuario'),
						'contrasena' => generate_hash($this->input->post('password')),
						'contrasena_rdel' => mc_encrypt($this->input->post('password'), KEY_RDEL),
						'logged_in' => 0,
						'created_at' => date('Y/m/d H:i:s'),
					);
					/** Guardar data de usuario y comprobar que se hubiese guardado */
					if ($this->db->insert('usuarios', $data_registro_user)) {
						$this->logs_sia->logQueries();
						/**  Capturar id del usuario registrado */
						$usuario = $this->db->select('id_usuario')->from('usuarios')->where('usuario', $data_registro_user['usuario'])->get()->row();
						/** @var $data_token  Capturar Data Tabla Token */
						$data_token = array(
							'token' => generate_token(),
							'verificado' => 0,
							'usuario_token' => $data_registro_user['usuario'],
							'created_at' => date('Y/m/d H:i:s'),
						);
						/** Guardar datos en tabla token */
						$this->db->insert('token', $data_token);
						//Capturar data de token registrado
						$token = $this->db->select('id_token')->from('token')->where('usuario_token', $data_token['usuario_token'])->get()->row();
						//Crear variable de token
						$update_usuario['token_id_token'] = $token->id_token;
						//Buscar registro de usuario
						$this->db->where('id_usuario', $usuario->id_usuario);
						/**  Actualizar y comprobar usuario con token registrado. */
						if ($this->db->update('usuarios', $update_usuario)) {
							$this->logs_sia->logQueries();
							/** @var  $data_registro_org
						Capturar datos de organización
							 */
							$data_registro_org = array(
								'nombreOrganizacion' => $this->input->post('organizacion'),
								'numNIT' => $this->input->post('nit'),
								'sigla' => $this->input->post('sigla'),
								'primerNombreRepLegal' => $this->input->post('nombre'),
								'segundoNombreRepLegal' => $this->input->post('nombre_s'),
								'primerApellidoRepLegal' => $this->input->post('apellido'),
								'segundoApellidoRepLegal' => $this->input->post('apellido'),
								'direccionCorreoElectronicoOrganizacion' => $this->input->post('correo_electronico'),
								'direccionCorreoElectronicoRepLegal' => $this->input->post('correo_electronico_rep_legal'),
								'primerNombrePersona' => $this->input->post('nombre_p'),
								'primerApellidoPersona' => $this->input->post('apellido_p'),
								'estado' => "Inscrito",
								'usuarios_id_usuario' => $usuario->id_usuario,
								'created_at' => date('Y/m/d H:i:s'),
							);
							//Guardar datos en la tabla de usuarios y comprobar.
							if ($this->db->insert('organizaciones', $data_registro_org)) {
								$this->logs_sia->logQueries();
								$token = $this->db->select('token')->from('token')->where('usuario_token', $data_registro_user['usuario'])->get()->row();
								$fromSIA = "Unidad Solidaria - Aplicación SIIA.";
								$this->logs_sia->logs('REGISTER_TYPE');
								$this->logs_sia->logs('URL_TYPE');
								$this->logs_sia->logQueries();
								//Enviar email activación
								$tipo = 'registroUsuario';
								$organizacion = $this->OrganizacionesModel->getOrganizaciones($this->input->post('nit'));
								send_email_user($data_registro_org['direccionCorreoElectronicoOrganizacion'], $tipo, $organizacion, $data_registro_user['usuario'], $token->token);
							} else {
								echo json_encode(array('url' => "registro", 'msg' => "No se logro crear organización"));
							}
						} else {
							echo json_encode(array('url' => "registro", 'msg' => "No se logro crear token"));
						}
					} else {
						echo json_encode(array('url' => "registro", 'msg' => "No se logro crear usuario"));
					}
				}
			}
		endif;
	}
	/** Reenvio de correo activación */
	public function reenvio()
	{
		$tipo = 'registroUsuario';
		$correo_electronico = $this->input->post('to');
		$organizacion = $this->OrganizacionesModel->getOrganizaciones($this->input->post('nit'));
		$usuario = $this->UsuariosModel->getUsuarios($organizacion->usuarios_id_usuario);
		$token = $this->TokenModel->getToken($usuario->token_id_token);
		$usuario = $usuario->usuario;
		$token = $token->token;
		send_email_user($correo_electronico, $tipo, $organizacion, $usuario, $token);
	}
}
