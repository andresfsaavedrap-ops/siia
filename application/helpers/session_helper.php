<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	Verifica que la sesion exista si no redirecciona a login.
**/
function verify_session(){
	$CI = & get_instance();
	if(!$user = $CI->session->userdata('logged_in'))
    {
        redirect('login');
    }else{
        return true;
    }
}

function verify_session_admin(){
	$CI = & get_instance();
	if(!$user = $CI->session->userdata('logged_in') && $CI->session->userdata('type_user') == 'admin' || $CI->session->userdata('type_user') == 'super')
    {
        redirect('login');
    }else{
        return true;
    }
}

function set_session($userdata){
	$CI = & get_instance();
	$CI->session->set_userdata('userdata', $userdata);
}

function verificar_logged_in($nombre_usuario){
	$CI = & get_instance();

	$fecha_login = $CI->db->query('SELECT MAX(fecha) FROM session_log WHERE nombre_usuario = "'.$nombre_usuario.'" and DATE(fecha)<=CURDATE() and accion = "login"');
	$fecha_logout = $CI->db->query('SELECT MAX(fecha) FROM session_log WHERE nombre_usuario = "'.$nombre_usuario.'" and DATE(fecha)<=CURDATE() and accion = "login"');
	$logged_in_data= $CI->db->select("*")->from("usuarios")->where("usuario", $nombre_usuario)->get()->row();
	$logged_in = $logged_in_data ->logged_in;
	$usuario_id = $logged_in_data ->id_usuario;

	if($fecha_login <= $fecha_logout && $logged_in == "1" || $logged_in == 1){
		$data_update = array(
					'logged_in' => "0"
		);
		$CI->logs_sia->session_log_param('Logout por Inactividad o Cambio de Sesión', $nombre_usuario, $usuario_id);
		$CI->db->where('usuario', $nombre_usuario);
		$CI->db->update('usuarios', $data_update);
		delete_cookie('sia_session');
		$CI->session->sess_destroy();
		return true;
	}else if($logged_in == "0" || $logged_in == 0){
		return false;
	}
}

?>