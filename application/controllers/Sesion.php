<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sesion extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}
	/** Vista login usuario */
	public function index()
	{
		$data['title'] = 'Iniciar Sesión';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$this->load->view('include/header/main', $data);
		$this->load->view('user/login');
		$this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Función login usuario */
	public function login()
	{
		// Recaptcha
		$recaptcha = recaptcha_validate($this->input->post('token'));
		// Si el recaptcha es válido, continuar con el login
		// Si el recaptcha no es válido, mostrar mensaje de error
		// Si el recaptcha es válido, continuar con el login
		if ($recaptcha['success'] == true && $recaptcha['score'] >= 0.5):
			// Validación de formulario
			$this->form_validation->set_rules('usuario', 'Username', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|xss_clean');
			// Si el formulario no es válido, mostrar mensaje de error
			// Si el formulario es válido, continuar con el login
			// Si el formulario no es válido, mostrar mensaje de error
			if ($this->form_validation->run("formulario_login") == FALSE) {
				echo json_encode(array('status' => "error", 'msg' => "Verifique los datos del formulario", 'errors' => validation_errors(), 'title' => 'Error'));
			} else {
				// Datos del formulario
				$nombre_usuario = $this->input->post('usuario');
				$password =  $this->input->post('password');
				$user_exist = false;
				// Datos del usuario
				$datos_usuario = $this->db->select('*')->from('usuarios')->where('usuario', $nombre_usuario)->get()->row();
				$datos_token = $this->db->select('*')->from('token')->where('usuario_token', $nombre_usuario)->get()->row();
				$organizacion = $this->db->select('*')->from('organizaciones')->where('usuarios_id_usuario', $datos_usuario->id_usuario)->get()->row();
				// Log de queries
				$this->logs_sia->logQueries();
				// Verificar si existe el usuario en la base de datos
				// Si no existe el usuario, $user_exist = false
				// Si existe el usuario, $user_exist = true
				if ($datos_usuario == "NULL" || $datos_usuario == NULL || $datos_usuario == null) {
					$user_exist = false;
				} else {
					$user_exist = true;
				}
				// IP del usuario
				$usuario_ip = $_SERVER['REMOTE_ADDR'];
				// Si el usuario está detrás de un proxy, obtener la IP real
				if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
					$usuario_ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
				}
				// Si el usuario existe, verificar si está logueado
				if ($user_exist == true) {
					if (verificar_logged_in($nombre_usuario)) {
						// Mensaje de error si el usuario ya inicio sesión
						echo json_encode(array('status' => "info", 'msg' => "Su cuenta tenía una sesión abierta en otro navegador, dicha se acaba de cerrar, por favor ingrese de nuevo.", 'title' => 'Sesión anterior cerrada'));
						$this->logs_sia->logs('URL_TYPE');
					} else {
						// Verificar si el usuario y la contraseña son correctos
						if (verify_login("$nombre_usuario", $password)) {
							// Verificar si el usuario está activo
							if ($datos_token->verificado == 1) {
								// Verificar si el usuario está logueado
								if ($datos_usuario->logged_in == 0) {
									// Datos de sesión
									// Actualizar la base de datos con los datos de sesión
									// Actualizar la base de datos con los datos de sesión
									$datos_sesion = array(
										'usuario_id'     => $datos_usuario->id_usuario,
										'nombre_usuario'  => $datos_usuario->usuario,
										'type_user' => 'user',
										'logged_in' => 1,
										'usuario_ip' => $usuario_ip,
										'usuario_ip_proxy' => $usuario_ip,
										'user_agent' => $_SERVER['HTTP_USER_AGENT']
									);
									$this->session->set_userdata($datos_sesion);
									$nombre_usuario = $this->session->userdata('nombre_usuario');
									$usuario_id = $this->session->userdata('usuario_id');
									// Mensaje de éxito
									echo json_encode(array('status' => "success", 'msg' => "Organización: " . $organizacion->nombreOrganizacion, 'title' => 'Inicio de sesión exitoso'));
									// Log de sesión
									$this->logs_sia->session_log('Login');
									// Actualizar la base de datos con los datos de sesión
									$data_update = array(
										'logged_in' => "1"
									);
									$this->db->where('id_usuario', $usuario_id);
									$this->db->update('usuarios', $data_update);
									$this->logs_sia->logs('LOGIN_TYPE');
									$this->logs_sia->logs('URL_TYPE');
									$this->logs_sia->logQueries();
								} else {
									// Mensaje de error si el usuario ya inicio sesión
									echo json_encode(array('status' => "info", 'msg' => "El usuario ya inicio sesión.", 'title' => 'Sesión abierta'));
									$this->logs_sia->logs('URL_TYPE');
								}
							} else {
								// Mensajes de error si el usuario no está activo
								if ($datos_token->verificado == 2) {
									echo json_encode(array('status' => "warning", 'msg' => "Su cuenta esta bloqueada, por favor contacte con la unidad solidaria para la activación de la cuenta", 'title' => 'Cuenta bloqueada'));
									$this->logs_sia->logs('URL_TYPE');
								} else {
									echo json_encode(array('status' => "warning", 'msg' => "Verifique su cuenta.", 'title' => 'Cuenta no activada'));
									$this->logs_sia->logs('URL_TYPE');
								}
							}
						} else {
							// Mensaje de error si el usuario o la contraseña son incorrectos
							echo json_encode(array('status' => "warning", 'msg' => "Verifique el usuario y la contraseña.", 'title' => 'Datos incorrectos'));
							$this->logs_sia->logs('URL_TYPE');
						}
					}
				} else {
					// Mensaje de error si el usuario no existe
					echo json_encode(array('status' => "error", 'msg' => 'No existe el usuario: ' . $nombre_usuario, 'title' => 'Usuario no encontrado'));
					$this->logs_sia->logs('URL_TYPE');
				}
			}
		endif;
	}
	/** Vista login admin */
	public function login_admin()
	{
		$data['title'] = 'Login Administrador';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$this->load->view('include/header/main', $data);
		$this->load->view('admin/login');
		$this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Función login admin */
	public function log_in_admin()
	{
		// Recaptcha
		$recaptcha = recaptcha_validate($this->input->post('token'));
		// Si el recaptcha es válido, continuar con el login
		// Si el recaptcha no es válido, mostrar mensaje de error
		// Si el recaptcha es válido, continuar con el login
		if ($recaptcha['success'] == true && $recaptcha['score'] >= 0.5):
			// Validación de formulario
			$this->form_validation->set_rules('usuario', 'Username', 'trim|required|min_length[3]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|xss_clean');
			// Si el formulario no es válido, mostrar mensaje de error
			// Si el formulario es válido, continuar con el login
			// Si el formulario no es válido, mostrar mensaje de error
			if ($this->form_validation->run("formulario_login_admin") == FALSE) {
				// Mensaje de error si el formulario no es válido
				echo json_encode(array('status' => "error", 'msg' => "Verifique los datos, no son validos", 'errors' => validation_errors(), 'title' => 'Error'));
			} else {
				// Datos del formulario
				$nombre_usuario = $this->input->post('usuario');
				$password =  $this->input->post('password');
				$user_exist = false;
				$datos_usuario = $this->db->select('*')->from('administradores')->where('usuario', $nombre_usuario)->get()->row();
				// Log de queries
				$this->logs_sia->logQueries();
				// Verificar si existe el usuario en la base de datos
				if ($datos_usuario == "NULL" || $datos_usuario == NULL || $datos_usuario == null) {
					$user_exist = false;
				} else {
					$user_exist = true;
				}
				// IP del usuario
				$usuario_ip = $_SERVER['REMOTE_ADDR'];
				if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
					$usuario_ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
				}
				// Si el usuario existe, verificar si está logueado
				if ($user_exist == true) {
					if (verify_login_admin($nombre_usuario, $password)) {
						if ($datos_usuario->logged_in == 0) {
							// Datos de sesión
							$datos_sesion = array(
								'usuario_id'     => $datos_usuario->id_administrador,
								'nombre_usuario'  => $datos_usuario->usuario,
								'type_user' => 'admin',
								'nivel' => $datos_usuario->nivel,
								'logged_in' => TRUE,
								'usuario_ip' => $usuario_ip,
								'usuario_ip_proxy' => $usuario_ip,
								'user_agent' => $_SERVER['HTTP_USER_AGENT']
							);
							$this->session->set_userdata($datos_sesion);
							$nombre_usuario = $this->session->userdata('nombre_usuario');
							$usuario_id = $this->session->userdata('usuario_id');
							// Respuesta al iniciar sesión administrador
							echo json_encode(array('status' => "success", 'msg' => $datos_usuario->primerNombreAdministrador . " " . $datos_usuario->primerApellidoAdministrador, 'title' => 'Sesión iniciada'));
							// Actualizar logged_in en administradores
							$data_update = array('logged_in' => "1");
							$this->db->where('id_administrador', $usuario_id);
							$this->db->update('administradores', $data_update);
							// Logs de sesión
							$this->logs_sia->session_log('Login Administrador');
							$this->logs_sia->logs('LOGIN_TYPE');
							$this->logs_sia->logs('URL_TYPE');
							$this->logs_sia->logQueries();
						} else {
							echo json_encode(array('status' => "info", 'msg' => "Su cuenta tenía una sesión abierta en otro navegador, dicha se acaba de cerrar, por favor ingrese de nuevo.", 'title' => 'Sesión anterior cerrada'));
							$this->logs_sia->logs('URL_TYPE');
							$data_update = array('logged_in' => "0");
							$this->db->where('usuario', $nombre_usuario);
							$this->db->update('administradores', $data_update);
						}
					} else {
						echo json_encode(array('status' => "warning", 'msg' => "Usuario y/o contraseña incorrectas, por favor verifique.", 'title' => 'Datos incorrectos'));
						$this->logs_sia->logs('URL_TYPE');
					}
				} else {
					echo json_encode(array('status' => "error", 'msg' => "No existe el usuario: " . $nombre_usuario, 'title' => 'Error'));
					$this->logs_sia->logs('URL_TYPE');
				}
			}
		endif;
	}
	/** 
	 * Logout Usuario
	 */
	public function logout()
	{
		$this->performLogout('usuarios', 'id_usuario', 'SIIASession', base_url() . "login");
	}
	/**
	 * Funcion para cerrar la sesion del usuario administrador.
	 * Destruye la sesion actual del usuario y redirecciona a Login.
	 */
	public function logoutAdmin()
	{
		$this->performLogout('administradores', 'id_administrador', 'ci_session', base_url() . "admin", true);
	}
	/**
	 * Método privado para manejar el logout de usuarios y administradores
	 * 
	 * @param string $table Tabla de la base de datos (usuarios o administradores)
	 * @param string $id_field Campo ID en la tabla
	 * @param string $cookie_name Nombre de la cookie a eliminar
	 * @param string $redirect_url URL de redirección
	 * @param bool $is_admin Si es logout de administrador
	 */
	private function performLogout($table, $id_field, $cookie_name, $redirect_url, $is_admin = false)
	{
		// Verificar si hay una sesión activa
		$usuario_id = $this->session->userdata('usuario_id');
		if (!$usuario_id) {
			echo json_encode(array('url' => $redirect_url, 'msg' => "No hay sesión activa."));
			return;
		}
		// Log de sesión
		$this->logs_sia->session_log('Logout');
		// Actualizar estado en base de datos
		$data_update = array('logged_in' => "0");
		$this->db->where($id_field, $usuario_id);
		$this->db->update($table, $data_update);
		// Logs del sistema
		$this->logs_sia->logs('LOGOUT_TYPE');
		$this->logs_sia->logQueries();
		$this->logs_sia->logs('URL_TYPE');
		// Log adicional para administradores (antes de destruir la sesión)
		if ($is_admin) {
			$nombre_usuario = $this->session->userdata('nombre_usuario');
			$this->logs_sia->session_log('Administrador:' . $nombre_usuario . ' cerró sesión.');
		}
		// Eliminar cookie y destruir sesión
		delete_cookie($cookie_name);
		$this->session->sess_destroy();
		// Respuesta JSON
		echo json_encode(array('url' => $redirect_url, 'msg' => "Sesión terminada."));
	}
}
