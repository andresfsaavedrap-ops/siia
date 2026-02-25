
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
/**
 * Controlador para gestión de docentes/facilitadores
 * Maneja CRUD de docentes, archivos y validaciones
 */
class Admin extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DocentesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('SolicitudesModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('AdministradoresModel');
		$this->load->model('CorreosRegistroModel');
		$this->load->model('TokenModel');
		$this->load->model('UsuariosModel');
		$this->load->model('ResolucionesModel');
    }
    /**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
    // Panel  para administradores
	public function panel()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal';
		$data['activeLink'] = 'dashboard';
		$this->logs_sia->logs('PLACE_USER');
		$this->loadView('admin/index', $data, 'main');
	}
	// Opciones para administradores
	public function operaciones()
	{
		$data['title'] = 'Panel Principal / Administrador / Opciones';
		$data = $this->datosSesionAdmin();
/* 		$data['opciones'] = $this->cargarOpcionesSistema();
		$data['tiposCursoInformes'] = $this->cargarCursosInforme();
		$data['nits'] = $this->cargarNits();
		$data['encuestas'] = $this->cargarResultadosEncuesta();
		$data['actividad_admin'] = $this->cargarActividadAdmin();
		$data['mis_notificaciones'] = $this->cargarMisNotificaciones();
		$data['bateria'] = $this->cargarBateriaObservaciones(); */

		$this->loadView('admin/operaciones/index', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function cargarCorreos()
	{
		$data = $this->db->select("direccionCorreoElectronicoOrganizacion, direccionCorreoElectronicoRepLegal")->from("organizaciones")->get()->result();
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	public function cargarCorreosAcreditadas()
	{
		$data = $this->db->select("direccionCorreoElectronicoOrganizacion, direccionCorreoElectronicoRepLegal")->from("organizaciones")->join('nits_db', 'nits_db.numNIT = organizaciones.numNIT')->get()->result();
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	// Cargar la batería de observaciones de una organización // TODO Cambiar a controlador BateriaObservaciones
	public function cargarBateriaObservacionesE()
	{
		$bateriaObservaciones = $this->db->select("*")->from("bateriaObservaciones")->get()->result();
		echo json_encode($bateriaObservaciones);
	}
	// Cargar la relación de cambios de una organización // TODO Cambiar por auditorias
	public function verRelacionCambios()
	{
		$id_organizacion = $this->input->post('id_organizacion');
		$organizacion = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
		$id_usuario = $organizacion->usuarios_id_usuario;
		$nombreOrganizacion = $organizacion->nombreOrganizacion;
		$usuarios = $this->db->select("*")->from("usuarios")->where("id_usuario", $id_usuario)->get()->row();
		$usuario = $usuarios->usuario;
		$notificaciones = $this->db->select('*')->from('notificaciones')->where("descripcionNotificacion LIKE '%$nombreOrganizacion%' AND descripcionNotificacion NOT LIKE '%Se actualizaron los docentes.%' AND descripcionNotificacion NOT LIKE '%docentes%' AND descripcionNotificacion NOT LIKE 'Actualizo%'")->or_where("quienEnvia", $usuario)->or_where("quienRecibe", $usuario)->order_by("fechaNotificacion", "desc")->get()->result();
		//$notificaciones = $this->db->select("*")->from("notificaciones")->where("quienEnvia", $usuario)->or_where("quienRecibe", $usuario)->order_by("fechaNotificacion", "desc")->get()->result();
		echo json_encode($notificaciones);
	}
	// Vista para ver la relación de cambios de una organización // TODO Cambiar por auditorias
	public function verRelacionCambiosVista()
	{
		$data = $this->datosSesionAdmin();
		$url = $_SERVER["REQUEST_URI"];
		$id_organizacion_url = explode(":", $url);
		$id_organizacion = $id_organizacion_url[1];
		$organizacion = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
		$id_usuario = $organizacion->usuarios_id_usuario;
		$nombreOrganizacion = $organizacion->nombreOrganizacion;
		$usuarios = $this->db->select("*")->from("usuarios")->where("id_usuario", $id_usuario)->get()->row();
		$usuario = $usuarios->usuario;
		//$notificaciones =  $this->db->query("(SELECT * FROM notificaciones WHERE descripcionNotificacion LIKE '%$nombreOrganizacion%') UNION (SELECT * FROM notificaciones WHERE quienEnvia = 'admin')");
		$notificaciones = $this->db->select('*')->from('notificaciones')->where("descripcionNotificacion LIKE '%$nombreOrganizacion%'")->or_where("quienEnvia", $usuario)->or_where("quienRecibe", $usuario)->order_by("fechaNotificacion", "desc")->get()->result();
		$data['notificaciones'] = $notificaciones;
		$data['title'] = 'Panel Principal / Administrador / Relación de cambios';
		$data['activeLink'] = 'organizaciones';
		$this->logs_sia->logs('PLACE_USER');
		$this->loadView('admin/organizaciones/relacionCambios', $data, 'main');
	}
	// Buscar organización por nombre, sigla, NIT, o nombre del representante legal
	public function buscar_organizacion()
	{
		$nombre = $this->input->post('nombre_organizacion');
		$sigla_organizacion = $this->input->post('sigla_organizacion');
		$nit_organizacion = $this->input->post('nit_organizacion');
		$primer_nombre = $this->input->post('primer_nombre');
		$segundo_nombre = $this->input->post('segundo_nombre');
		$primer_apellido = $this->input->post('primer_apellido');
		$segundo_apellido = $this->input->post('segundo_apellido');

		/**$db_table = 'SELECT * FROM `organizaciones`, `organizacionesHistorial`';
		$add_name = ' WHERE ';
		$or = ' OR ';

		if($nombre != ""){
			$add_name .= "`organizaciones`.`nombreOrganizacion` OR `organizacionesHistorial`.`nombreOrganizacion` LIKE '%$nombre%' ESCAPE '!'";
		}
		if($sigla_organizacion != ""){
			$add_name .= $or."`organizaciones`.`sigla` OR `organizacionesHistorial`.`sigla` LIKE '%$sigla_organizacion%' ESCAPE '!'";
		}
		if($nit_organizacion != ""){
			$add_name .= $or."`organizaciones`.`numNIT` OR `organizacionesHistorial`.`numNIT` LIKE '%$nit_organizacion%' ESCAPE '!'";
		}
		if($primer_nombre != ""){
			$add_name .= $or."`organizaciones`.`primerNombreRepLegal` OR `organizacionesHistorial`.`primerNombreRepLegal` LIKE '%$primer_nombre%' ESCAPE '!'";
		}
		if($segundo_nombre != ""){
			$add_name .= $or."`organizaciones`.`segundoNombreRepLegal` OR `organizacionesHistorial`.`segundoNombreRepLegal` LIKE '%$segundo_nombre%' ESCAPE '!'";
		}
		if($primer_apellido != ""){
			$add_name .= $or."`organizaciones`.`primerApellidoRepLegal` OR `organizacionesHistorial`.`primerApellidoRepLegal` LIKE '%$primer_apellido%' ESCAPE '!'";
		}
		if($segundo_apellido != ""){
			$add_name .= $or."`organizaciones`.`segundoApellidoRepLegal` OR `organizacionesHistorial`.`segundoApellidoRepLegal` LIKE '%$segundo_apellido%' ESCAPE '!'";
		}
		 **/
		$db_table = 'SELECT * FROM `organizaciones`';
		$add_name = ' WHERE ';
		$or = ' OR ';

		if ($nombre != "") {
			$add_name .= "`organizaciones`.`nombreOrganizacion` LIKE '%$nombre%' ESCAPE '!'";
		}
		if ($sigla_organizacion != "") {
			$add_name .= $or . "`organizaciones`.`sigla` LIKE '%$sigla_organizacion%' ESCAPE '!'";
		}
		if ($nit_organizacion != "") {
			$add_name .= $or . "`organizaciones`.`numNIT` LIKE '%$nit_organizacion%' ESCAPE '!'";
		}
		if ($primer_nombre != "") {
			$add_name .= $or . "`organizaciones`.`primerNombreRepLegal` LIKE '%$primer_nombre%' ESCAPE '!'";
		}
		if ($segundo_nombre != "") {
			$add_name .= $or . "`organizaciones`.`segundoNombreRepLegal` LIKE '%$segundo_nombre%' ESCAPE '!'";
		}
		if ($primer_apellido != "") {
			$add_name .= $or . "`organizaciones`.`primerApellidoRepLegal` LIKE '%$primer_apellido%' ESCAPE '!'";
		}
		if ($segundo_apellido != "") {
			$add_name .= $or . "`organizaciones`.`segundoApellidoRepLegal` LIKE '%$segundo_apellido%' ESCAPE '!'";
		}
		$get_res = "";

		$organizaciones = $db_table . $add_name . $get_res;

		$query = $this->db->query($organizaciones);
		echo json_encode(array("organizaciones" => $query->result()));
		$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' buscó una organización con los datos:' . $nombre . ', ' . $sigla_organizacion . ', ' . $nit_organizacion . '.');
	}
	// Contacto
	public function contacto()
	{

		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Contacto';
		$data['activeLink'] = 'Contacto';
		$data['usuarios'] = $this->verUsuarios();
		$data['emails'] = $this->db->select("*")->from("organizaciones")->get()->result();
		$this->loadView('admin/contacto/contacto', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function verUsuarios()
	{
		$usuarios = $this->db->select("*")->from("usuarios")->where("logged_in", 1)->get()->result();
		return $usuarios;
	}
}
