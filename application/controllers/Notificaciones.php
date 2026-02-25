<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {
	
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
		verify_session();
	}


	public function cargarNotificaciones(){
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$hora = date ("H:i",time());
		$fecha = date('Y/m/d');
		
		if($tipo_usuario == "admin"){
			$notificaciones = $this->db->select("*")->from("notificaciones")->where("quienRecibe", $tipo_usuario)->where("isRead", 1)->where("tipoUsuario", $tipo_usuario)->get()->result();
			$notificaciones_tit = array();
			$notificaciones_desc = array();
			$notificaciones_fecha = array();

			foreach ($notificaciones as $quienEnvia) {
				array_push($notificaciones_tit, $quienEnvia->quienEnvia);
			}
			foreach ($notificaciones as $descripcionNotificacion) {
				array_push($notificaciones_desc, $descripcionNotificacion->descripcionNotificacion);
			}
			foreach ($notificaciones as $fechaNotificacion) {
				array_push($notificaciones_fecha, $fechaNotificacion->fechaNotificacion);
			}
			$notificaciones = array("notificaciones_tit" => $notificaciones_tit, "notificaciones_desc" => $notificaciones_desc, "count" => count($notificaciones_tit), "fecha" => $notificaciones_fecha);
			echo json_encode($notificaciones);
		}else if($tipo_usuario == "user"){
			$notificaciones = $this->db->select("*")->from("notificaciones")->where("quienRecibe", $nombre_usuario)->where("isRead", 1)->where("tipoUsuario", $tipo_usuario)->get()->result();
			$notificaciones_tit = array();
			$notificaciones_desc = array();
			$notificaciones_fecha = array();

			foreach ($notificaciones as $quienEnvia) {
				array_push($notificaciones_tit, $quienEnvia->quienEnvia);
			}
			foreach ($notificaciones as $descripcionNotificacion) {
				array_push($notificaciones_desc, $descripcionNotificacion->descripcionNotificacion);
			}
			foreach ($notificaciones as $fechaNotificacion) {
				array_push($notificaciones_fecha, $fechaNotificacion->fechaNotificacion);
			}
			$notificaciones = array("notificaciones_tit" => $notificaciones_tit, "notificaciones_desc" => $notificaciones_desc, "count" => count($notificaciones_tit), "fecha" => $notificaciones_fecha);
			echo json_encode($notificaciones);
		}
	}

	public function leerNotificaciones(){
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$tipo_usuario = $this->session->userdata('type_user');
		
		if($tipo_usuario == 'admin'){
			$nombre_usuario = 'admin';
		}

		$data_notificacion = array(
			"isRead" => 0
		);

		$this->db->where('quienRecibe', $nombre_usuario);
		$this->db->where('tipoUsuario', $tipo_usuario);
		$this->db->where('isRead', 1);
		$this->db->update('notificaciones', $data_notificacion);
		echo json_encode(array("msg" => "Notificaciones leídas."));
	}
}