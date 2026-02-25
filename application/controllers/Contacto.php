<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacto extends CI_Controller
{

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
	function __construct()
	{
		parent::__construct();
		verify_session();
	}

	public function index()
	{
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Contacto';
		$data['logged_in'] = $logged;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;

		$datos_registro = $this->db->select('*')->from('organizaciones')->where('usuarios_id_usuario', $usuario_id)->get()->row();
		$datos_usuario = $this->db->select('usuario')->from('usuarios')->where('id_usuario', $usuario_id)->get()->row();
		$data['nombre_usuario'] = $datos_usuario->usuario;

		$data_registro = array(
			'nombreOrganizacion' => $datos_registro->nombreOrganizacion,
			'numNIT' => $datos_registro->numNIT,
			'sigla' => $datos_registro->sigla,
			'primerNombreRepLegal' => $datos_registro->primerNombreRepLegal,
			'segundoNombreRepLegal' => $datos_registro->segundoNombreRepLegal,
			'primerApellidoRepLegal' => $datos_registro->primerApellidoRepLegal,
			'segundoApellidoRepLegal' => $datos_registro->segundoApellidoRepLegal,
			'direccionCorreoElectronicoOrganizacion' => $datos_registro->direccionCorreoElectronicoOrganizacion,
			'direccionCorreoElectronicoRepLegal' => $datos_registro->direccionCorreoElectronicoRepLegal,
			'primerNombrePersona' => $datos_registro->primerNombrePersona,
			'primerApellidoPersona' => $datos_registro->primerApellidoPersona,
			'nombre_usuario' => $datos_usuario->usuario,
			'imagen' => $datos_registro->imagenOrganizacion
		);
		$data['administradores'] = $this->verAdministradores();
		$this->load->view('include/header', $data);
		$this->load->view('contacto/contacto', $data_registro);
		$this->load->view('include/footer');
		$this->logs_sia->logs('PLACE_USER');
	}

	/**
		Funcion para enviar un correo electronico.
	 **/
	function enviomail_contacto()
	{
		$correo_electronico = $this->input->post('correo_electronico');
		$correo_electronico_rep = $this->input->post('correo_electronico_rep');
		$prioridad = $this->input->post('prioridad');
		$asunto = $this->input->post('asunto');
		$mensaje = $this->input->post('mensaje');
		$to = CORREO_SIA;

		if ($correo_electronico_rep != null || $correo_electronico_rep != "") {
			$cc = $correo_electronico_rep;
		} else {
			$cc = "";
		}
		/**
		1 => '1 (Highest)',
		2 => '2 (High)',
		3 => '3 (Normal)',
		4 => '4 (Low)',
		5 => '5 (Lowest)'
		 **/
		switch ($prioridad) {
			case 'Urgente':
				$num_prioridad = 1;
				break;
			case 'Importante':
				$num_prioridad = 2;
				break;
			case 'Ninguna':
				$num_prioridad = 3;
				break;
			default:
				$num_prioridad = 3;
				break;
		}
		$this->email->from($to, "Acreditaciones");
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->subject('Correo de información del SIIA - Asunto: ' . $asunto . " de " . $correo_electronico);
		$this->email->set_priority($num_prioridad);

		$data_msg['mensaje'] = $mensaje;

		$email_view = $this->load->view('email/contacto', $data_msg, true);

		$this->email->message($email_view);

		if ($this->email->send()) {
			echo json_encode(array('url' => "login", 'msg' => "Se envio el correo, por favor esperar la respuesta."));
		} else {
			echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envio el correo."));
		}
	}

	public function guardarEncuesta()
	{
		$estrellas = $this->input->post('estrellas');
		$comentario = $this->input->post('comentario');

		$data_encuesta = array(
			'estrellas' => $estrellas,
			'comentario' => $comentario
		);
		if ($this->db->insert('encuesta', $data_encuesta)) {
			echo json_encode(array('msg' => "¡Gracias!"));
		}
	}

	public function verAdministradores()
	{
		$administradores = $this->db->select("*")->from("administradores")->where("logged_in", 1)->get()->result();
		return $administradores;
	}
}
