<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Super extends CI_Controller {
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
		$this->load->model('AdministradoresModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('SolicitudesModel');
		$this->load->model('CorreosRegistroModel');
		$this->load->model('TokenModel');
		$this->load->model('UsuariosModel');
		$this->load->model('ResolucionesModel');
	}
	public function index()
	{
		$data['title'] = 'Super | Inició de Sesión';
		$data['tipo_usuario'] = "none";
		$data['logged_in'] = FALSE;
		$this->load->view('include/header/main', $data);
		$this->load->view('super/index');
		$this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/**
	 * Inició de sesión súper administrador
	 */
	public function verify(){
		$ps = $this->input->post('sp');
		if($ps == SUPER_PS){
			$data_update = array('valor' => 'TRUE');
			$this->db->where('nombre', 'super');
			if($this->db->update('opciones', $data_update)){
				$usuario_ip = $_SERVER['REMOTE_ADDR'];
				echo json_encode(array("url"=>"panel", 'error' => 0, "msg" => "Inicio de sesión super administrador!"));
				$datos_sesion = array(
					'usuario_id'     => "1-666-1", // Number of the beast #-#
					'nombre_usuario'  => "super",
					'type_user' => 'super',
					'logged_in' => 1,
					'usuario_ip' => $usuario_ip,
					'usuario_ip_proxy' => $usuario_ip,
					'user_agent' => $_SERVER['HTTP_USER_AGENT']
				);
				$this->session->set_userdata($datos_sesion);
			}
		}else if($ps == "" || $ps == NULL || $ps != SUPER_PS){
			$data_update = array('valor' => 'FALSE');
			$this->db->where('nombre', 'super');
			if($this->db->update('opciones', $data_update)){
				echo json_encode(array('url' => 'super','error' => 1, 'msg' => 'Ingrese una contraseña valida'));
			}
		}
	}
	/**
	 * Datos sesión súper administrador
	 */
	public function dataSessionSuper() {
		$data = array(
			'logged_in' => $this->session->userdata('logged_in'),
			'title' => 'Super | Panel de Control',
			'tipo_usuario' => $this->session->userdata('type_user'),
			'nivel' => $this->session->userdata('nivel'),
			'usuario_id' => 666,
			'hora' => date("H:i", time()),
			'fecha' => date('Y/m/d'),
			'administradores' => $this->AdministradoresModel->getAdministradores(),
			'organizaciones' => $this->OrganizacionesModel->getOrganizaciones(),
			'correos' => $this->CorreosRegistroModel->getCorreosRegistro(),
			'usuarios' => $this->UsuariosModel->getUsuariosSuperAdmin(),
			'solicitudes' => $this->SolicitudesModel->getSolicitudesAndOrganizacion(),
			'resoluciones' => $this->ResolucionesModel->getResolucionAndOrganizacion()
		);
		return $data;
	}
	/**
	 * Panel súper administrador
	 */
	public function Panel(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/panel', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Perfil súper administrador
	 */
	public function Perfil(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/profile', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Administradores
	 */
	public function Administradores(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/administrators', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Usuarios
	 */
	public function Usuarios(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/users', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Correos
	 */
	public function Correos(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/emails', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Solicitudes
	 */
	public function Solicitudes(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/requests', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Resoluciones
	 */
	public function Resoluciones(){
		verify_session_admin();
		$is = $this->db->select("valor")->from("opciones")->where("nombre","super")->get()->row()->valor;
		if($is == "TRUE"):
			$data = $this->dataSessionSuper();
			$this->load->view('include/header/main', $data);
			$this->load->view('super/pages/resolutions', $data);
			$this->load->view('include/footer/main');
			$this->logs_sia->logs('PLACE_USER');
		endif;
	}
	/**
	 * Enviar datos usuario
	 */
	public function enviarDatosUsuario(){
		$usuario = $this->UsuariosModel->getUsuarios($this->input->post('id'));
		$token = $this->TokenModel->getTokenUsuario($usuario->usuario);
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($usuario->id_usuario);
		if($this->input->post('category') == 'info'):
			send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, $this->input->post('type'), $organizacion, $usuario, $token);
		else:
			send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, $this->input->post('type'), $organizacion, $usuario->usuario, $token->token);
		endif;
	}
	/**
	 * Cerrar sesión
	 */
	public function logout(){
		$data_update = array('valor' => 'FALSE');
		$this->db->where('nombre', 'super');
		if($this->db->update('opciones', $data_update)){
			echo json_encode(array('status' => 'ok'));
			delete_cookie('siia_session');
			$this->session->sess_destroy();
		}
	}
}
