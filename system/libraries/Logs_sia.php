<?php
// Name of Class as mentioned in $hook['post_controller]
class CI_Logs_sia {
 
    private $CI;
    private $_log_path;

    function __construct() {
       $this->CI = & get_instance();
       $this->_log_path = APPPATH.'logs/';
    }
 
    // Name of function same as mentioned in Hooks Config
    public function logQueries() {
 
        $CI = & get_instance();

        $filepath = $this->_log_path.'logs-queries-'.date('Y-m-d').'.php'; // Creating Query Log file with today's date in application/logs folder
        $handle = fopen($filepath, "a+");                 // Opening file with pointer at the end of the file
 
        $times = $CI->db->query_times;                   // Get execution time of all the queries executed by controller
        foreach ($CI->db->queries as $key => $query) { 
            $sql = $query . " \n Tiempo de ejecucion:" . $times[$key]; // Generating SQL file alongwith execution time
            fwrite($handle, $sql . "\n\n");              // Writing it in the log file
        }
 
        fclose($handle);      // Close the file
    }

    /**
        Crea un log dependiendo del tipo de mensaje.  
    **/
    public function logs($type){
        $data = $this->get_user_data();
        switch ($type) {
            case 'URL_TYPE':
                $this->log_message('URL_TYPE', current_url().' USUARIO: '.$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '.$data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: '.$data['user_agent'], 'url');
                break;
            case 'LOGIN_TYPE':
                $this->log_message('LOGIN_TYPE', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'sesiones');
                break;
            case 'LOGOUT_TYPE':
                $this->log_message('LOGOUT_TYPE', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'sesiones');
                break;
            case 'REGISTER_TYPE':
                $this->log_message('REGISTER_TYPE', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'registros');
                break;
            case 'REMEMBER_PASSWORD':
                $this->log_message('REMEMBER_PASSWORD', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'recordar');
                break;
            case 'ACTIVATION_ACCOUNT':
                $this->log_message('ACTIVATION_ACCOUNT', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'activacion');
                break;
            case 'PLACE_USER':
                $this->log_message('PLACE_USER', current_url(). ' USUARIO: ' .$data['nombre_usuario'].' - ID: '.$data['usuario_id'].' - IP: '. $data['usuario_ip'].' - IP-PROXY: '.$data['usuario_ip_proxy'].' - AGENT: ' .$data['user_agent'], 'lugar');
                break;
        }
    }

    /** 
    Escribe en el archivo del log correspondiente el mensaje.
    **/
    private function log_message($log_type, $msg, $type){
        $filepath = '';

        switch ($type) {
            case 'sesiones':
                $filepath = $this->_log_path.'logs-sesiones-'.date('Y-m-d').'.php';
                break;
            case 'url':
                $filepath = $this->_log_path.'logs-urls-'.date('Y-m-d').'.php';
                break;
            case 'registros':
                $filepath = $this->_log_path.'logs-registros-'.date('Y-m-d').'.php';
                break;
            case 'recordar':
                $filepath = $this->_log_path.'logs-recordar-'.date('Y-m-d').'.php';
                break;
            case 'activacion':
                $filepath = $this->_log_path.'logs-activacion-'.date('Y-m-d').'.php';
                break;
            case 'lugar':
                $filepath = $this->_log_path.'logs-lugaresUsuario-'.date('Y-m-d').'.php';
                break;
        }

        $message  = '';

        if ( ! file_exists($filepath))
        {
            $message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
        }

        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        $message .= $log_type.' - '.date('Y-m-d H:i:s'). ' --> '.$msg."\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($filepath, FILE_WRITE_MODE);
        return TRUE;
    }


    /** Obtiene datos de sesión para agregarlos al log: Id de usuario (si existe), IP y datos del navegador **/
    private function get_user_data(){
        $nombre_usuario = $this->CI->session->userdata('nombre_usuario');
        $usuario_id = $this->CI->session->userdata('usuario_id');
        $usuario_ip = $this->CI->session->userdata('usuario_ip');
        $usuario_ip_proxy = $this->CI->session->userdata('usuario_ip_proxy');
        $user_agent = $this->CI->session->userdata('user_agent');

        if($nombre_usuario == "" && $usuario_id == "" && $usuario_ip == "" && $usuario_ip_proxy == "" && $user_agent == ""){
            $nombre_usuario = 'Intento de usuario';
            $usuario_id = '0';

            $usuario_ip = $_SERVER['REMOTE_ADDR'];

            if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
                $usuario_ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
            }

            $usuario_ip_proxy = $usuario_ip;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $data = array(
            'nombre_usuario' => $nombre_usuario,
            'usuario_id' => $usuario_id,
            'usuario_ip' => $usuario_ip,
            'usuario_ip_proxy' => $usuario_ip_proxy,
            'user_agent' => $user_agent
        );
        return $data;
    }
 
    public function session_log($accion){
        $usuario_ip = $_SERVER['REMOTE_ADDR'];

        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$array = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$usuario_ip = array_pop($array);
        }

        $nombre_usuario = $this->CI->session->userdata('nombre_usuario');
        $usuario_id = $this->CI->session->userdata('usuario_id');

        $this->CI->db->insert('session_log', array('usuario_id'=> $usuario_id, 'nombre_usuario' => $nombre_usuario, 'accion' => $accion, 'fecha'=> date('Y/m/d H:i:s'), 'usuario_ip' => $usuario_ip, 'usuario_ip_proxy' => $usuario_ip, 'user_agent' => $_SERVER['HTTP_USER_AGENT']));    
    }

    public function session_log_param($accion, $nombre_usuario, $usuario_id){
        $usuario_ip = $_SERVER['REMOTE_ADDR'];

        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $usuario_ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        
        $this->CI->db->insert('session_log', array('usuario_id'=> $usuario_id, 'nombre_usuario' => $nombre_usuario, 'accion' => $accion, 'fecha'=> date('Y/m/d H:i:s'), 'usuario_ip' => $usuario_ip, 'usuario_ip_proxy' => $usuario_ip, 'user_agent' => $_SERVER['HTTP_USER_AGENT']));    
    }
}
?>
