<?php
// Name of Class as mentioned in $hook['post_controller]
class CI_Notif_sia {
 
    private $CI;

    function __construct() {
       $this->CI = & get_instance();
    }

    /**
        TODO: Crear notificaciones para el usuario
    **/ 
    public function notification($type, $quienRecibe, $org){
        $nombre_usuario = $this->CI->session->userdata('nombre_usuario');
        $usuario_id = $this->CI->session->userdata('usuario_id');

         switch ($type) {
            case 'OBSERVACIONES':
                $titulo = "Administrador ".$nombre_usuario.":";
                $descripcion = $org.": Se hicieron obsevaciones sobre los formularios por favor revisar estado de solicitud.";
                $user = 'user';
                break;
            case 'CORREO_CONTACTO_USUARIO':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Envio un correo electronico de contacto.";
                $user = 'admin';
                break;
            case 'Docente':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Se actualizaron los docentes.";
                $user = 'user';
                break;
            case 'Docentes':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Se actualizaron los docentes de ".$org.".";
                $user = 'admin';
                break;
            case 'Informe':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Informe de Actividad de ".$org.".";
                $user = 'admin';
                break;
            case 'Finalizada':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = $org." termino la solicitud.";
                $user = 'admin';
                break;
            case 'Visita':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Por favor verifique el Plan de Mejoramiento, tiene una visita.";
                $user = 'user';
                break;
            case 'Seguimiento':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Por favor verifique el Plan de Mejoramiento, tiene un seguimiento.";
                $user = 'user';
                break;
            case 'ACTUALIZAR_DATOS':
                $titulo = "Usuario ".$nombre_usuario.":";
                $descripcion = "Actualizo los datos ".$org.".";
                $user = 'admin';
                break;
        }

        $notif = array(
            'tituloNotificacion '=> $titulo, 
            'descripcionNotificacion ' => $descripcion, 
            'fechaNotificacion' => date('Y/m/d H:i:s'), 
            'quienEnvia'=> $nombre_usuario,
            'quienRecibe' => $quienRecibe,
            'isRead' => 1,
            'tipoUsuario' => $user
        );

        $this->CI->db->insert('notificaciones', $notif);    
    }
}
