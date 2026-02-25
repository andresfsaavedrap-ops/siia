<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
if ($this->config->item('mantenimiento') == TRUE) {
	$route['default_controller'] = "Home/mantenimiento";
	$route['(:any)'] = "Home/mantenimiento";
} else {
	$route['default_controller'] = 'Home';
}
// HOME
$route['estado'] = 'Home/estadoSolicitud';
$route['encuesta'] = 'Encuesta/index';
$route['facilitadores'] = 'Home/facilitadores';
/**
 * Todas las rutas super administrador
 */
// Super Administrador
$route['super/?'] = 'Super';
$route['super/panel'] = 'Super/panel';
$route['super/perfil'] = 'Super/perfil';
$route['super/administradores'] = 'Super/administradores';
$route['super/usuarios'] = 'Super/usuarios';
$route['super/correos'] = 'Super/correos';
$route['super/solicitudes'] = 'Super/solicitudes';
$route['super/resoluciones'] = 'Super/resoluciones';
$route['configcontroller'] = 'configcontroller/index';
$route['configcontroller/update_constants'] = 'configcontroller/update_constants';
/**
 * Todas las rutas organizaciones
 */
// Inicio y registro
$route['login'] = 'Sesion';
$route['registro'] = 'Registro';
// Activar cuenta con token
$route['activate'] = 'Activate';
// Panel Organizaciones
$route['organizacion/panel'] = 'Panel';
// Perfil usuario
$route['organizacion/perfil'] = 'Perfil';
// Solicitudes organización
$route['organizacion/solicitudes'] = 'Panel/solicitudes';
$route['organizacion/solicitudes/solicitud/(:any)'] = 'Solicitudes/solicitud/$1';
$route['organizacion/solicitudes/solicitud/estado/(:any)'] = 'Solicitudes/estadoSolicitud/$1';
// Docentes organización
$route['organizacion/facilitadores'] = 'Docentes';
// Informe de actividades organización
$route['organizacion/informe-actividades'] = 'InformeActividades/index';
$route['organizacion/informe-actividades/asistentes/(:any)'] = 'Asistentes/curso/$1';
$route['organizacion/ayuda'] = 'Panel/ayuda';
// TODO: Bk Panel anterior: borrar luego
$route['panel/solicitudes'] = 'Panel/panel';
//Recodar Contraseña
$route['recordar'] = 'Recordar';
$route['panel/contacto'] = 'Contacto';
$route['Certificado'] = 'Certificaciones/crearCertificacion';
// $route['panel/obtenerCertificado'] = 'Certificaciones/obtenerCertificado';
$route['panel/docentes'] = 'Docentes/index';
$route['panel/planMejora'] = 'Panel/planMejora';
//Recordar para cron por si existe algún error
$route['tiempo'] = 'Recordar/calculo_tiempo';
$route['tiempoAdmin'] = 'Recordar/recordarToAdmin';
$route['tiempoUser'] = 'Recordar/recordarToUser';
$route['tiempoUserActivation'] = 'Recordar/recordarToUserActivation';
$route['socrata'] = 'Admin/socrata';
$route['clean_socrata'] = 'Admin/clean_socrata';
$route['get_socrata'] = 'Admin/get_socrata';
$route['llamadas'] = 'Admin/llamadas';
/**
 * Todas las rutas Administrador
 */
$route['admin'] = 'Sesion/login_admin';
$route['admin/panel'] = 'Admin/panel';
$route['admin/socrata'] = 'Admin/socrataPanel';
$route['admin/reportes'] = 'Reportes';
/** Administrador Organizaciones */
$route['admin/organizaciones'] = 'Organizaciones';
$route['admin/organizaciones/asignar'] = 'Organizaciones/asignar';
$route['admin/organizaciones/inscritas'] = 'Organizaciones/inscritas';
// Solicitudes
$route['admin/tramite'] = 'Solicitudes';
$route['admin/tramite/solicitudes/inscritas'] = 'Solicitudes/inscritas';
$route['admin/tramite/solicitudes/asignar'] = 'Solicitudes/asignar';
$route['admin/tramite/solicitudes/finalizadas'] = 'Solicitudes/finalizadas';
$route['admin/tramite/solicitudes/proceso'] = 'Solicitudes/proceso';
$route['admin/tramite/solicitudes/observaciones'] = 'Solicitudes/observaciones';
$route['admin/tramite/solicitudes/informacionSolicitud'] = 'Solicitudes/informacionSolicitud';
// Resoluciones
$route['admin/resoluciones'] = 'Resoluciones';
// Facilitadores
$route['admin/docentes'] = 'AdminDocentes';
$route['admin/docentes/inscritos'] = 'AdminDocentes/inscritos';
$route['admin/docentes/asignar'] = 'AdminDocentes/asignar';
$route['admin/docentes/evaluar'] = 'AdminDocentes/evaluar';
$route['admin/contacto'] = 'Admin/contacto';
// Operaciones del sistema
$route['admin/operaciones'] = 'Operaciones';
$route['admin/operaciones/notificaciones'] = 'Operaciones/notificaciones';
$route['admin/operaciones/cambiar-contrasena'] = 'Operaciones/cambiarContrasena';
$route['admin/operaciones/bateria-observaciones'] = 'BateriaObservaciones';
$route['admin/operaciones/registro-actividad'] = 'Operaciones/registroActividad';
$route['admin/operaciones/opciones-sistema'] = 'Operaciones/opcionesSistema';
$route['admin/operaciones/tipos-cursos'] = 'Operaciones/tiposCursos';
$route['admin/operaciones/nit-entidades'] = 'Nit';
$route['admin/operaciones/resultados-encuesta'] = 'Operaciones/resultadosEncuesta';
$route['admin/operaciones/modalInformacion'] = 'Operaciones/modalInformacion';
$route['admin/operaciones/historico'] = 'Operaciones/historico';
// Reportes
$route['admin/reportes/actividades-pedagogicas'] = 'InformeActividades/enviados';
$route['admin/reportes/organizaciones-acreditadas'] = 'Reportes/entidadesAcreditadas';
$route['admin/reportes/solicitudes'] = 'Reportes/registroSolicitudes';
$route['admin/reportes/historico'] = 'Reportes/entidadesHistorico';
$route['admin/reportes/asistentes'] = 'Reportes/verAsistentes';
$route['admin/reportes/docentesHabilitados'] = 'Reportes/docentesHabilitados';
$route['admin/reportes/registros-telefonicos'] = 'RegistroTelefonico/index';
$route['admin/organizaciones/solodocentes'] = 'Admin/solodocentes';
$route['admin/organizaciones/camara-comercio'] = 'Organizaciones/camara';
$route['admin/organizaciones/resoluciones/(:any)'] = 'Resoluciones/organizacion/$1';
$route['admin/organizaciones/estado'] = 'Organizaciones/estado';
$route['admin/seguimiento'] = 'Admin/seguimiento';
// Estadísticas
$route['admin/estadisticas'] = 'Estadisticas/panel';
$route['admin/estadisticas/acreditacion'] = 'Estadisticas/acreditacion';
//Mapa Gestion
$route['mapa'] = 'home/mapa';
// 404 ...
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
