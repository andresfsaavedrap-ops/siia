<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin2 extends CI_Controller
{
	//ALTER TABLE administradores AUTO_INCREMENT=99999999;
	function __construct()
	{
		parent::__construct();
		verify_session_admin();
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
	// Función para la creación de idSolicitud
	private function createIDSolicitud($nit)
	{
		$organizacion = $this->OrganizacionesModel->getOrganizaciones($nit);
		if ($organizacion != null):
			$idSolicitud = date('YmdHis') . $organizacion->nombreOrganizacion[3] . random(2);
			echo $idSolicitud;
		else:
			echo 'La organización no esta registrada, por favor verificar el NIT';
		endif;
	}
	// Funciones de actualización contraseñas
	private function mcdec()
	{
		$password = "J/lsnBNyPMAE5VLpxc7qOMHOAjOgRuRSurWRQXupW8bZU3PbhnFe/NZ6+dMPNzFAfOQaYThGKzNUsmklfWSuobOJCJ5jWUMSvxuIMEuUyIXQ1Cj1S4FLqJ+/5PJMUO5I|z6VTI1mY2JKEmK+wwX7z9u52OEIloIM7tLj4h3qhDk4=";
		$passwor2 = mc_decrypt($password, KEY_RDEL);
		echo json_encode($passwor2);
	}
	private function mcenc()
	{
		$password = "Clave*21";
		$passwor2 = mc_encrypt($password, KEY_RDEL);
		echo json_encode($passwor2);
	}
	private function enchash()
	{
		$password = "Clave*21";
		$passwor2 = generate_hash($password);
		echo json_encode($passwor2);
	}
	/**
	 * @return $data
	 * Datos de sesión administrador.
	 */
	public function datosSesionAdmin()
	{
		verify_session_admin();
		date_default_timezone_set("America/Bogota");
		$data = array(
			'logged_in' => $this->session->userdata('logged_in'),
			'nombre_usuario' => $this->session->userdata('nombre_usuario'),
			'usuario_id' => $this->session->userdata('usuario_id'),
			'tipo_usuario' => $this->session->userdata('type_user'),
			'nivel' => $this->session->userdata('nivel'),
			'hora' => date("H:i", time()),
			'fecha' => date('Y/m/d'),
			'departamentos' => $this->DepartamentosModel->getDepartamentos(),
			'administradores' => $this->AdministradoresModel->getAdministradores(),
			'organizaciones' => $this->OrganizacionesModel->getOrganizaciones(),
			'correos' => $this->CorreosRegistroModel->getCorreosRegistro(),
			'usuarios' => $this->UsuariosModel->getUsuariosSuperAdmin(),
			'solicitudes' => $this->SolicitudesModel->solicitudes(),
			'resoluciones' => $this->ResolucionesModel->getResolucionAndOrganizacion()
		);
		return $data;
	}
	// Socrata
	public function socrata()
	{
		$data_organizaciones = array();
		$socrata = new CI_Socrata(APP_URL_DATOS, APP_DATOS_TOKEN, APP_DATOS_USER, APP_DATOS_PASSWORD);

		$estado_acreditadas = $this->db->select("*")->from("estadoOrganizaciones")->where("nombre", "Acreditado")->or_where("estadoAnterior", "Acreditado")->get()->result();
		$organizacionesNITDB = $this->db->select(("distinct(numNIT), numNIT"))->from("nits_db")->get()->result();

		foreach ($organizacionesNITDB as $organizacionDB) {
			$numNIT = $organizacionDB->numNIT;
			$datas_organizaciones = $this->db->select("*")->from("organizaciones")->where("numNIT", $numNIT)->get()->row();
			$id_organizacion = $datas_organizaciones->id_organizacion;

			if ($id_organizacion != null || $id_organizacion != "") {
				//foreach ($estado_acreditadas as $organizaciones) {
				//$id_organizacion = $organizaciones->organizaciones_id_organizacion;
				$org_estado_acreditadas = $this->db->select("*")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
				$organizaciones_acreditadas = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
				$organizaciones_data = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
				$resoluciones = $this->db->select("*")->from("resoluciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();

				if ($organizaciones_data->urlOrganizacion == null || $organizaciones_data->urlOrganizacion == "") {
					$url = "No Tiene";
				} else {
					$url = $organizaciones_data->urlOrganizacion;
				}

				if ($url == "No Tiene") {
					$url = "www.orgsolidarias.gov.co";
				}

				if (!preg_match('#^http(s)?://#', $url)) {
					$url = 'http://' . $url;
				}

				$nombre = $organizaciones_acreditadas->nombreOrganizacion;
				$nit = $organizaciones_acreditadas->numNIT;
				$sigla = $organizaciones_acreditadas->sigla;
				$estado = $org_estado_acreditadas->nombre;
				$fecha = $org_estado_acreditadas->fecha;
				$tipo = $organizaciones_data->tipoOrganizacion;
				$direcc = $organizaciones_data->direccionOrganizacion;
				$dep = $organizaciones_data->nomDepartamentoUbicacion;
				$mun = $organizaciones_data->nomMunicipioNacional;
				$tel = $organizaciones_data->fax;
				$ext = $organizaciones_data->extension;
				$url = $url;
				$act = $organizaciones_data->actuacionOrganizacion;
				$tipoE = $organizaciones_data->tipoEducacion;
				$pnomb = $organizaciones_acreditadas->primerNombreRepLegal;
				$snomb = $organizaciones_acreditadas->segundoNombreRepLegal;
				$papell = $organizaciones_acreditadas->primerApellidoRepLegal;
				$sapell = $organizaciones_acreditadas->segundoApellidoRepLegal;
				$ced = $organizaciones_data->numCedulaCiudadaniaPersona;
				$dircor = $organizaciones_acreditadas->direccionCorreoElectronicoOrganizacion;
				$dircre = $organizaciones_acreditadas->direccionCorreoElectronicoRepLegal;
				$nres = $resoluciones->numeroResolucion;
				$fres = $resoluciones->fechaResolucionInicial;
				$ares = $resoluciones->añosResolucion;
				$tiposol = $org_estado_acreditadas->tipoSolicitudAcreditado;
				$motivsol = $org_estado_acreditadas->motivoSolicitudAcreditado;
				$modalisol = $org_estado_acreditadas->modalidadSolicitudAcreditado;

				$data_as_json = array(
					'nombre_de_la_entidad' => $nombre,
					'n_mero_nit' => $nit,
					'sigla_de_la_entidad' => $sigla,
					'estado_actual_de_la_entidad' => $estado,
					'fecha_cambio_de_estado' => $fecha,
					'tipo_de_entidad' => $tipo,
					'direcci_n_de_la_entidad' => $direcc,
					'departamento_de_la_entidad' => $dep,
					'municipio_de_la_entidad' => $mun,
					'tel_fono_de_la_entidad' => $tel,
					'extensi_n' => $ext,
					'url_de_la_entidad' => $url,
					'actuaci_n_de_la_entidad' => $act,
					'tipo_de_educaci_n_de_la_entidad' => $tipoE,
					'primer_nombre_representante_legal' => $pnomb,
					'segundo_nombre_representante_legal' => $snomb,
					'primer_apellido_representante_legal' => $papell,
					'segundo_apellido_representante_legal' => $sapell,
					'n_mero_c_dula_representante_legal' => $ced,
					'correo_electr_nico_entidad' => $dircor,
					'correo_electr_nico_representante_legal' => $dircre,
					'n_mero_de_la_resoluci_n' => $nres,
					'fecha_de_inicio_de_la_resoluci_n' => $fres,
					'a_os_de_la_resoluci_n' => $ares,
					'tipo_de_solicitud' => 'En proceso de actualización de base de datos', //$tiposol,
					'motivo_de_la_solicitud' => 'En proceso de actualización de base de datos', //$motivsol,
					'modalidad_de_la_solicitud' => 'En proceso de actualización de base de datos', //$modalisol
				);

				$data_as_json = json_encode($data_as_json);
				// Publish data via 'upsert'
				$response = $socrata->post(APP_DATOS_VIEWIUD, $data_as_json);
				$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó los datos en la pagina de Datos Abiertos.');
				//}
			}
		}
		echo json_encode($response);
	}
	// Clean Socrata
	public function clean_socrata()
	{
		$socrata = new CI_Socrata(APP_URL_DATOS, APP_DATOS_TOKEN, APP_DATOS_USER, APP_DATOS_PASSWORD);

		$data_as_json = array(
			'nombre_de_la_entidad' => "",
			'n_mero_nit' => "",
			'sigla_de_la_entidad' => "",
			'estado_actual_de_la_entidad' => "",
			'fecha_cambio_de_estado' => "",
			'tipo_de_entidad' => "",
			'direcci_n_de_la_entidad' => "",
			'departamento_de_la_entidad' => "",
			'municipio_de_la_entidad' => "",
			'tel_fono_de_la_entidad' => "",
			'extensi_n' => "",
			'url_de_la_entidad' => "",
			'actuaci_n_de_la_entidad' => "",
			'tipo_de_educaci_n_de_la_entidad' => "",
			'primer_nombre_representante_legal' => "",
			'segundo_nombre_representante_legal' => "",
			'primer_apellido_representante_legal' => "",
			'segundo_apellido_representante_legal' => "",
			'n_mero_c_dula_representante_legal' => "",
			'correo_electr_nico_entidad' => "",
			'correo_electr_nico_representante_legal' => "",
			'n_mero_de_la_resoluci_n' => "",
			'fecha_de_inicio_de_la_resoluci_n' => "",
			'a_os_de_la_resoluci_n' => "",
			'tipo_de_solicitud' => "",
			'motivo_de_la_solicitud' => "",
			'modalidad_de_la_solicitud' => ""
		);
		$data_as_json = json_encode($data_as_json);
		// Publish data via 'replace'
		$response = $socrata->put(APP_DATOS_VIEWIUD, $data_as_json);
		echo json_encode($response);
	}
	// Get Socrata
	public function get_socrata()
	{
		$socrata = new CI_Socrata(APP_URL_DATOS, APP_DATOS_TOKEN, APP_DATOS_USER, APP_DATOS_PASSWORD);

		$params = array("\$select" => "nombre_de_la_entidad,n_mero_nit,sigla_de_la_entidad,estado_actual_de_la_entidad,fecha_cambio_de_estado,tipo_de_entidad,direcci_n_de_la_entidad,departamento_de_la_entidad,municipio_de_la_entidad,tel_fono_de_la_entidad,extensi_n,url_de_la_entidad,actuaci_n_de_la_entidad,tipo_de_educaci_n_de_la_entidad,primer_nombre_representante_legal,segundo_nombre_representante_legal,primer_apellido_representante_legal,segundo_apellido_representante_legal,n_mero_c_dula_representante_legal,correo_electr_nico_entidad,correo_electr_nico_representante_legal,n_mero_de_la_resoluci_n,fecha_de_inicio_de_la_resoluci_n,a_os_de_la_resoluci_n,tipo_de_solicitud,motivo_de_la_solicitud,modalidad_de_la_solicitud");

		$response = $socrata->get(APP_DATOS_VIEWIUD, $params);
		echo json_encode($response);
	}
	// Socrata Panel
	public function socrataPanel()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Socrata';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();

		$this->load->view('include/header', $data);
		$this->load->view('admin/datos/datos', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Panel Admin 
	public function panel()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal';
		$data['activeLink'] = 'dashboard';
		// TODO: If provisional para mostrar panel atención al ciudadano
		if ($data['nivel'] == '7'):
			$this->load->view('include/header/main', $data);
			$this->load->view('admin/index', $data);
			$this->load->view('include/footer/main', $data);
		else:
			$this->load->view('include/header', $data);
			$this->load->view('admin/paneles/panel', $data);
			$this->load->view('include/footer', $data);
		endif;
		$this->logs_sia->logs('PLACE_USER');
	}
	// Contacto
	public function contacto()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Contacto';
		$data['usuarios'] = $this->verUsuarios();
		$data['emails'] = $this->db->select("*")->from("organizaciones")->get()->result();
		$this->load->view('include/header', $data);
		$this->load->view('admin/contacto/contacto', $data);
		$this->load->view('include/footer', $data);
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
	// Seguimiento
	public function seguimiento()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador /Seguimiento';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['administradores'] = $this->cargar_administradores();
		$data['organizaciones'] = $this->cargar_organizacionesInscritas();
		$data['visitas'] = $this->cargar_visitas();
		$data['seguimientos'] = $this->cargar_seguimientos();

		$this->load->view('include/header', $data);
		$this->load->view('admin/seguimiento/seguimiento', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function estadoOrg()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Estados';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['solicitudes'] = $this->cargarSolicitudesRegistradas();

		$this->load->view('include/header', $data);
		$this->load->view('admin/organizaciones/estado', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Vista docentes
	public function docentes()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Facilitadores';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['organizaciones'] = $this->cargar_organizacionesconDocentes();
		$data['administradores'] = $this->cargar_administradores();


		$this->load->view('include/header', $data);
		$this->load->view('admin/organizaciones/docentes', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function solodocentes()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Facilitadores';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['organizaciones'] = $this->cargar_organizacionesconDocentes();

		$this->load->view('include/header_doc', $data);
		$this->load->view('admin/organizaciones/docentes', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function llamadas()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Llamadas';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['llamadas'] = $this->cargar_llamadas();

		$this->load->view('include/header', $data);
		$this->load->view('admin/llamadas/editar', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}

	public function notificacionesAntiguas()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Opciones / Notificaciones';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['mis_notificaciones'] = $this->cargarMisNotificaciones();

		$this->load->view('include/header', $data);
		$this->load->view('admin/opciones/notificaciones', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function registroActividad()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Opciones / Registro de actividad';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['actividad_admin'] = $this->cargarActividadAdmin();

		$this->load->view('include/header', $data);
		$this->load->view('admin/opciones/registroActividad', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function tiposCursos()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Opciones / Tipos de cursos';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['tiposCursoInformes'] = $this->cargarCursosInforme();

		$this->load->view('include/header', $data);
		$this->load->view('admin/opciones/tiposCursos', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function resultadosEncuesta()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Opciones / Nit de entidades';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['encuestas'] = $this->cargarResultadosEncuesta();

		$this->load->view('include/header', $data);
		$this->load->view('admin/opciones/resultadosEncuesta', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function cargar_administradores()
	{
		$administradores = $this->db->select("*")->from("administradores")->get()->result();
		return $administradores;
	}
	public function cargarBateriaObservaciones()
	{
		$bateriaObservaciones = $this->db->select("*")->from("bateriaObservaciones")->get()->result();
		return $bateriaObservaciones;
	}
	public function cargarBateriaObservacionesE()
	{
		$bateriaObservaciones = $this->db->select("*")->from("bateriaObservaciones")->get()->result();
		echo json_encode($bateriaObservaciones);
	}
	public function cargar_visitas()
	{
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$visitas = $this->db->select("*")->from("visitas")->where("usuarioVisita", $nombre_usuario)->get()->result();
		return $visitas;
	}
	public function cargar_seguimientos()
	{
		$seguimientos = $this->db->select("*")->from("seguimientoSimple")->get()->result();
		return $seguimientos;
	}
	public function cargar_informacionVisita()
	{
		$id_organizacion = $this->input->post('id_organizacion');
		$id_visita = $this->input->post('id_visita');

		$informacion = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$datos_visita = $this->db->select("*")->from("visitas")->where("id_visitas", $id_visita)->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$datos_seguimiento = $this->db->select("*")->from("seguimiento")->where("visitas_id_visitas", $id_visita)->get()->result();
		$datos_plan = $this->db->select("*")->from("planMejoramiento")->where("visitas_id_visitas", $id_visita)->get()->result();

		echo json_encode(array("informacion" => $informacion, "visita" => $datos_visita, "seguimiento" => $datos_seguimiento, "plan" => $datos_plan));
	}
	public function cargarDepartamentos()
	{
		$departamentos = $this->db->select("*")->from("departamentos")->get()->result();
		return $departamentos;
	}
	public function actualizarPlanMejoramiento()
	{
		$observaciones_plan = $this->input->post('observaciones_plan');
		$id_visita = $this->input->post('id_visita');
		$id_plan = $this->input->post('id_plan');
		$cumple_plan = $this->input->post('cumple_plan');

		$data_update_plan = array(
			'observaciones' => $observaciones_plan,
			'cumple' => $cumple_plan
		);

		$this->db->where('id_planMejoramiento', $id_plan);
		if ($this->db->update('planMejoramiento', $data_update_plan)) {
			echo json_encode(array("msg" => "Se actualizó el plan de mejoramiento."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó el plan de mejora.');
		}
	}
	public function crearBateriaObservacion()
	{
		$tipoBateriaObservacion = $this->input->post('tipoBateriaObservacion');
		$tituloBateriaObservacion = $this->input->post('tituloBateriaObservacion');
		$observacionBateriaObservacion = $this->input->post('observacionBateriaObservacion');

		$data_visita = array(
			'tipo' => $tipoBateriaObservacion,
			'titulo' => $tituloBateriaObservacion,
			'observacion' => $observacionBateriaObservacion,
		);

		if ($this->db->insert('bateriaObservaciones', $data_visita)) {
			echo json_encode(array("msg" => "Se creo la observación."));
		}
	}
	public function actualizarBateriaObservacion()
	{
		$id_observacion = $this->input->post('id_observacion');
		$tipoBateriaObservacion = $this->input->post('tipoBateriaObservacion');
		$tituloBateriaObservacion = $this->input->post('tituloBateriaObservacion');
		$observacionBateriaObservacion = $this->input->post('observacionBateriaObservacion');

		$data_update = array(
			'tipo' => $tipoBateriaObservacion,
			'titulo' => $tituloBateriaObservacion,
			'observacion' => $observacionBateriaObservacion,
		);

		$this->db->where('id_bateriaObservaciones', $id_observacion);
		if ($this->db->update('bateriaObservaciones', $data_update)) {
			echo json_encode(array("msg" => "Se actualizó la observación."));
		}
	}
	public function crearVisita()
	{
		$id_organizacion = $this->input->post('id_organizacion');
		$nombreOrganizacion = $this->input->post('nombreOrganizacion');
		$fechaVisita = $this->input->post('fechaVisita');
		$horaVisita = $this->input->post('horaVisita');
		$encargadoVisita = $this->input->post('encargadoVisita');

		$data_visita = array(
			'nombreOrganizacionVisita' => $nombreOrganizacion,
			'fechaVisita' => $fechaVisita,
			'horaVisita' => $horaVisita,
			'usuarioVisita' => $encargadoVisita,
			'terminada' => 0,
			'organizaciones_id_organizacion' => $id_organizacion
		);

		if ($this->db->insert('visitas', $data_visita)) {
			$id_usuario = $this->db->select("usuarios_id_usuario")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row()->usuarios_id_usuario;
			$nombre_usuario = $this->db->select("usuario")->from("usuarios")->where("id_usuario", $id_usuario)->get()->row()->usuario;
			$this->notif_sia->notification('Visita', $nombre_usuario, "");
			echo json_encode(array('url' => "", 'msg' => "La visita se creo, se informo a la organización."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' creo una visita a: ' . $nombreOrganizacion . ', a las: ' . $fechaVisita . ' - ' . $horaVisita . ' el usuario de la visita es: ' . $encargadoVisita . '.');
		}
	}
	public function crearSeguimiento()
	{
		$id_organizacion = $this->input->post('id_organizacion');
		$nombreOrganizacion = $this->input->post('nombreOrganizacion');
		$descripcionSeguimiento = $this->input->post('descripcionSeguimiento');

		$data_seguimiento = array(
			'fechaSeguimiento' => date('Y/m/d'),
			'descripcionSeguimiento' => $descripcionSeguimiento,
			'nombreOrganizacion' => $nombreOrganizacion,
			'organizaciones_id_organizacion' => $id_organizacion,
		);

		if ($this->db->insert('seguimientoSimple', $data_seguimiento)) {
			$id_usuario = $this->db->select("usuarios_id_usuario")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row()->usuarios_id_usuario;
			$nombre_usuario = $this->db->select("usuario")->from("usuarios")->where("id_usuario", $id_usuario)->get()->row()->usuario;
			$this->notif_sia->notification('Seguimiento', $nombre_usuario, "");
			echo json_encode(array('url' => "", 'msg' => "El seguimiento se creo, se informo a la organización."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' creo un seguimiento a: ' . $nombreOrganizacion . '.');
		}
	}
	public function darRespuestaSeguimiento()
	{
		$id_seguimiento = $this->input->post("id_seguimiento");
		$preguntaSeguimiento = $this->input->post("preguntaSeguimiento");
		$cumpleSeguimiento = $this->input->post("cumpleSeguimiento");

		$data_respuesta = array(
			'descripcionSeguimiento' => $preguntaSeguimiento,
			'cumpleSeguimiento' => $cumpleSeguimiento
		);

		$this->db->where('id_seguimientoSimple', $id_seguimiento);
		if ($this->db->update('seguimientoSimple', $data_respuesta)) {
			echo json_encode(array('url' => "panel", 'msg' => "Se respondio al seguimiento."));
		}
	}
	public function cargar_organizacionesFinalizadasObs()
	{
		$organizaciones = array();
		$id_organizaciones = $this->db->select("organizaciones_id_organizacion")->from("estadoOrganizaciones")->where("nombre", "Finalizado")->or_where("nombre", "En Observaciones")->get()->result();

		foreach ($id_organizaciones as $id_organizacion) {
			$id_org = $id_organizacion->organizaciones_id_organizacion;
			$data_organizaciones = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes")->where("organizaciones.id_organizacion", $id_org)->where("estadoOrganizaciones.organizaciones_id_organizacion", $id_org)->where("solicitudes.organizaciones_id_organizacion", $id_org)->get()->row();
			array_push($organizaciones, $data_organizaciones);
		}

		return $organizaciones;
	}
	public function modalInformacion()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$get = $this->input->get();
		$idOrg = $get['id'];

		$data['title'] = 'Panel Principal - Administrador - Información';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['informacionModal'] = $this->cargar_informacionModal();

		$this->load->view('include/header', $data);
		$this->load->view('admin/opciones/modalInformacion', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function cargar_todaInformacionInf($id)
	{
		$id_organizacion = $id;

		$informacionGeneral = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$documentacionLegal = $this->db->select("*")->from("documentacionLegal")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$registroEducativoProgramas = $this->db->select("*")->from("registroEducativoProgramas")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$antecedentesAcademicos = $this->db->select("*")->from("antecedentesAcademicos")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$jornadasActualizacion = $this->db->select("*")->from("jornadasActualizacion")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$datosBasicosProgramas = $this->db->select("*")->from("datosBasicosProgramas")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$programasAvalEconomia = $this->db->select("*")->from("programasAvalEconomia")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$programasAvalar = $this->db->select("*")->from("programasAvalar")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$docentes = $this->db->select("*")->from("docentes")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$plataforma = $this->db->select("*")->from("datosAplicacion")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();

		$tipoSolicitud = $this->db->select("*")->from("tipoSolicitud")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$solicitudes = $this->db->select("*")->from("solicitudes")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$estadoOrganizaciones = $this->db->select("*")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$organizaciones = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->result();
		$resoluciones = $this->db->select("*")->from("resoluciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();
		$archivos = $this->db->select("*")->from("archivos")->where("organizaciones_id_organizacion", $id_organizacion)->get()->result();

		return json_encode(array("informacionGeneral" => $informacionGeneral, "documentacionLegal" => $documentacionLegal, "registroEducativoProgramas" => $registroEducativoProgramas, "antecedentesAcademicos" => $antecedentesAcademicos, "jornadasActualizacion" => $jornadasActualizacion, "datosBasicosProgramas" => $datosBasicosProgramas, "programasAvalEconomia" => $programasAvalEconomia, "programasAvalar" => $programasAvalar, "docentes" => $docentes, "plataforma" => $plataforma, "tipoSolicitud" => $tipoSolicitud, "solicitudes" => $solicitudes, "estadoOrganizaciones" => $estadoOrganizaciones, "organizaciones" => $organizaciones, "archivos" => $archivos, "resoluciones" => $resoluciones));
	}
	public function cargarSolicitudesRegistradas()
	{
		$solicitudesRegistradas = array();
		$solicitudes = $this->db->select("*")->from("estadoOrganizaciones")->get()->result();

		foreach ($solicitudes as $solicitud) {
			$idOrg = $solicitud->organizaciones_id_organizacion;
			$idSolicitud = $solicitud->idSolicitud;
			$data = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->get()->row();
			array_push($solicitudesRegistradas, $data);
		}
		return $solicitudesRegistradas;
		// echo json_encode($organizaciones);
	}
	public function cargar_docentesDeshabilitados()
	{
		// $docentes = $this->db->select("*")->from("docentes")->where("valido", 0)->where("asignado !=", "")->get()->result();
		$docentes = $this->db->select("*")->from("organizaciones")->join("docentes", "docentes.organizaciones_id_organizacion = organizaciones.id_organizacion")->where("docentes.valido", 0)->where("docentes.asignado", "No")->get()->result();
		// echo json_encode($docentes);
		return $docentes;
	}
	// Cargar docentes 
	public function cargar_organizacionesconDocentes()
	{
		$data_organizacionesBD = $this->db->select("DISTINCT(docentes.organizaciones_id_organizacion), organizaciones.*", null, false)->from("organizaciones, docentes")->where("docentes.organizaciones_id_organizacion = organizaciones.id_organizacion")->get()->result();
		return $data_organizacionesBD;
	}
	public function cargar_llamadas()
	{
		$registroTelefonico = $this->db->select("*")->from("registroTelefonico")->get()->result();

		return $registroTelefonico;
	}
	public function obtenerLlamada()
	{
		$idLlamada = $this->input->post('idLlamada');
		$registroTelefonico = $this->db->select("*")->from("registroTelefonico")->where("id_registroTelefonico", $idLlamada)->get()->row();

		echo json_encode(array('llamada' => $registroTelefonico));
	}
	public function actualizarLlamada()
	{
		$idLlamada = $this->input->post("idLlamada");
		$telefonicoNombre = $this->input->post("telefonicoNombre");
		$telefonicoApellidos = $this->input->post("telefonicoApellidos");
		$telefonicoCedula = $this->input->post("telefonicoCedula");
		$telefonicoNit = $this->input->post("telefonicoNit");
		$telefonicoTipoPersona = $this->input->post("telefonicoTipoPersona");
		$telefonicoGenero = $this->input->post("telefonicoGenero");
		$telefonicoMunicipio = $this->input->post("telefonicoMunicipio");
		$telefonicoDepartamento = $this->input->post("telefonicoDepartamento");
		$telefonicoNumeroContacto = $this->input->post("telefonicoNumeroContacto");
		$telefonicoCorreoContacto = $this->input->post("telefonicoCorreoContacto");
		$telefonicoNombreOrganizacion = $this->input->post("telefonicoNombreOrganizacion");
		$telefonicoTipoOrganizacion = $this->input->post("telefonicoTipoOrganizacion");
		$telefonicoTemaConsulta = $this->input->post("telefonicoTemaConsulta");
		$telefonicoDescripcionConsulta = $this->input->post("telefonicoDescripcionConsulta");
		$telefonicoTipoSolicitud = $this->input->post("telefonicoTipoSolicitud");
		$telefonicoCanalRecepcion = $this->input->post("telefonicoCanalRecepcion");
		$telefonicoCanalRespuesta = $this->input->post("telefonicoCanalRespuesta");
		$telefonicoFecha = $this->input->post("telefonicoFecha");
		$telefonicoDuracion = $this->input->post("telefonicoDuracion");
		$telefonicoHora = $this->input->post("telefonicoHora");

		$data_update = array(
			'telefonicoNombre' => $telefonicoNombre,
			'telefonicoApellidos' => $telefonicoApellidos,
			'telefonicoCedula' => $telefonicoCedula,
			'telefonicoNit' => $telefonicoNit,
			'telefonicoTipoPersona' => $telefonicoTipoPersona,
			'telefonicoGenero' => $telefonicoGenero,
			'telefonicoMunicipio' => $telefonicoMunicipio,
			'telefonicoDepartamento' => $telefonicoDepartamento,
			'telefonicoNumeroContacto' => $telefonicoNumeroContacto,
			'telefonicoCorreoContacto' => $telefonicoCorreoContacto,
			'telefonicoNombreOrganizacion' => $telefonicoNombreOrganizacion,
			'telefonicoTipoOrganizacion' => $telefonicoTipoOrganizacion,
			'telefonicoTemaConsulta' => $telefonicoTemaConsulta,
			'telefonicoDescripcionConsulta' => $telefonicoDescripcionConsulta,
			'telefonicoTipoSolicitud' => $telefonicoTipoSolicitud,
			'telefonicoCanalRecepcion' => $telefonicoCanalRecepcion,
			'telefonicoCanalRespuesta' => $telefonicoCanalRespuesta,
			'telefonicoFecha' => $telefonicoFecha,
			'telefonicoDuracion' => $telefonicoDuracion,
			'telefonicoHora' => $telefonicoHora,
		);
		$this->db->where('id_registroTelefonico', $idLlamada);
		if ($this->db->update('registroTelefonico', $data_update)) {
			echo json_encode(array('url' => "admin", 'msg' => "Se actualizó la llamada."));
			$this->logs_sia->session_log('Se actualizó la llamada con id: ' . $idLlamada);
		}
	}
	public function cargar_informacionInforme()
	{
		$id_curso = $this->input->post('id_curso');
		$curso = $this->db->select("*")->from("informeActividades")->where("id_informeActividades", $id_curso)->get()->result();
		$asistentes = $this->db->select("*")->from("asistentes")->where("informeActividades_id_informeActividades", $id_curso)->get()->result();
		echo json_encode(array("curso" => $curso, "asistentes" => $asistentes));
	}
	public function cargar_todaActividadUsuario()
	{
		$url = $_SERVER["REQUEST_URI"];
		$id_org_url = explode(":", $url);
		$id = $id_org_url[1];
		$datos_actividad = $this->db->select('*')->from('session_log')->where('usuario_id', $id)->order_by("id_session_log", "desc")->get()->result();
		echo json_encode($datos_actividad);
	}
	public function cargarOrganizacionesHistoricas()
	{
		$data_organizaciones = $this->db->select("organizacionesHistorial.*, historial.*")->from("organizacionesHistorial, historial")->where("historial.organizaciones_id_organizacion = organizacionesHistorial.id_organizacionHistorial", false, false)->get()->result();

		return $data_organizaciones;
	}
	public function informacionOrganizacionHistorial()
	{
		$id_organizacion_historial = $this->input->post('id_organizacion_historial');
		$id_historial = $this->input->post('id_historial');

		$datos_organizacion = $this->db->select("*")->from("organizacionesHistorial")->where("id_organizacionHistorial", $id_organizacion_historial)->get()->result();
		$datos_historial_res = $this->db->select("*")->from("historialResoluciones")->where("historial_id_historial", $id_historial)->order_by("fechaResolucionInicial", "asc")->get()->result();
		$datos_historial_org = $this->db->select("*")->from("historial")->where("id_historial", $id_historial)->get()->result();

		echo json_encode(array("organizacion" => $datos_organizacion, "resolucion_historial" => $datos_historial_res, "historial" => $datos_historial_org));
	}
	public function guardar_organizacionHistorial()
	{
		$personeria = $this->input->post('personeria');
		$nombresSeries = $this->input->post('nombresSeries');
		$regional = $this->input->post('regional');
		$fechaExtremaInicial = $this->input->post('fechaExtremaInicial');
		$fechaExtremaFinal = $this->input->post('fechaExtremaFinal');
		$caja = $this->input->post('caja');
		$carpeta = $this->input->post('carpeta');
		$tomo = $this->input->post('tomo');
		$otro = $this->input->post('otro');
		$numeroFolios = $this->input->post('numeroFolios');
		$soporte = $this->input->post('soporte');
		$observaciones = $this->input->post('observaciones');

		$organizacion = $this->input->post('organizacion');
		$nit = $this->input->post('nit');
		$sigla = $this->input->post('sigla');
		$nombre = $this->input->post('nombre');
		$nombre_s = $this->input->post('nombre_s');
		$apellido = $this->input->post('apellido');
		$apellido_s = $this->input->post('apellido_s');
		$correo_electronico = $this->input->post('correo_electronico');
		$correo_electronico_rep_legal = $this->input->post('correo_electronico_rep_legal');

		$hist_fech_inicio = $this->input->post('hist_fech_inicio');
		$hist_fech_fin = $this->input->post('hist_fech_fin');
		$hist_anos = $this->input->post('hist_anos');
		$hist_num_res = $this->input->post('hist_num_res');

		$name_random = random(10);
		$size = 100000000;

		$nombre_imagen =  "resolucionHistorial_" . $name_random . $_FILES['file']['name'];
		$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

		if (0 < $_FILES['file']['error']) {
			echo json_encode(array('url' => "admin", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
		} else if ($_FILES['file']['size'] > $size) {
			echo json_encode(array('url' => "admin", 'msg' => "El tamaño supera 10 MB, intente con otro pdf."));
		} else if ($tipo_imagen != "pdf") {
			$data_insert_organizacion = array(
				'nombreOrganizacion' => $organizacion,
				'numNIT' => $nit,
				'sigla' => $sigla,
				'primerNombreRepLegal' => $nombre,
				'segundoNombreRepLegal' => $nombre_s,
				'primerApellidoRepLegal' => $apellido,
				'segundoApellidoRepLegal' => $apellido_s,
				'direccionCorreoElectronicoOrganizacion' => $correo_electronico,
				'direccionCorreoElectronicoRepLegal' => $correo_electronico_rep_legal
			);
			if ($this->db->insert('organizacionesHistorial', $data_insert_organizacion)) {
				$id_organizacionHistorial = $this->db->select("id_organizacionHistorial")->from("organizacionesHistorial")->where("nombreOrganizacion", $organizacion)->get()->row()->id_organizacionHistorial;

				$data_insert_historial = array(
					'personeriaJuridica' => $personeria,
					'nombresSeriesAsuntos' => $nombresSeries,
					'regional' => $regional,
					'fechaExtremaInicial' => $fechaExtremaInicial,
					'fechaExtremaFinal' => $fechaExtremaFinal,
					'caja' => $caja,
					'carpeta' => $carpeta,
					'tomo' => $tomo,
					'otros' => $otro,
					'numeroFolios' => $numeroFolios,
					'soporte' => $soporte,
					'observaciones' => $observaciones,
					'organizaciones_id_organizacion' => $id_organizacionHistorial
				);
				if ($this->db->insert('historial', $data_insert_historial)) {
					echo json_encode(array('url' => "admin", 'msg' => "Se ingreso la organización historica sin archivo de resolucion."));
					$this->logs_sia->session_log('Se creo una organización historica.');
				}
			}
		} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/resoluciones/' . $nombre_imagen)) {
			$data_insert_organizacion = array(
				'nombreOrganizacion' => $organizacion,
				'numNIT' => $nit,
				'sigla' => $sigla,
				'primerNombreRepLegal' => $nombre,
				'segundoNombreRepLegal' => $nombre_s,
				'primerApellidoRepLegal' => $apellido,
				'segundoApellidoRepLegal' => $apellido_s,
				'direccionCorreoElectronicoOrganizacion' => $correo_electronico,
				'direccionCorreoElectronicoRepLegal' => $correo_electronico_rep_legal
			);
			if ($this->db->insert('organizacionesHistorial', $data_insert_organizacion)) {
				$id_organizacionHistorial = $this->db->select("id_organizacionHistorial")->from("organizacionesHistorial")->where("nombreOrganizacion", $organizacion)->get()->row()->id_organizacionHistorial;

				$data_insert_historial = array(
					'personeriaJuridica' => $personeria,
					'nombresSeriesAsuntos' => $nombresSeries,
					'regional' => $regional,
					'fechaExtremaInicial' => $fechaExtremaInicial,
					'fechaExtremaFinal' => $fechaExtremaFinal,
					'caja' => $caja,
					'carpeta' => $carpeta,
					'tomo' => $tomo,
					'otros' => $otro,
					'numeroFolios' => $numeroFolios,
					'soporte' => $soporte,
					'observaciones' => $observaciones,
					'organizaciones_id_organizacion' => $id_organizacionHistorial
				);
				if ($this->db->insert('historial', $data_insert_historial)) {
					$id_historial = $this->db->select("id_historial")->from("historial")->where("organizaciones_id_organizacion", $id_organizacionHistorial)->get()->row()->id_historial;

					$data_insert_historial_res = array(
						'fechaResolucionInicial' => $hist_fech_inicio,
						'fechaResolucionFinal' => $hist_fech_fin,
						'añosResolucion' => $hist_anos,
						'resolucion' => $nombre_imagen,
						'numeroResolucion' => $hist_num_res,
						'historial_id_historial' => $id_historial
					);
					if ($this->db->insert('historialResoluciones', $data_insert_historial_res)) {
						echo json_encode(array('url' => "admin", 'msg' => "Se ingreso la organización historica."));
						$this->logs_sia->session_log('Se creo una organización historica.');
					}
				}
			}
		}
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	public function cargarObservaciones()
	{
		$id_organizacion = $this->input->post('id_organizacion');

		$observaciones = $this->db->select("*")->from("observaciones")->where("organizaciones_id_organizacion", $id_organizacion)->order_by("numeroRevision", "desc")->get()->result();

		$archivos = $this->db->select("*")->from("archivos")->where("organizaciones_id_organizacion", $id_organizacion)->where("tipo", "observacionesPlataformaVirtual")->where("id_formulario", 10)->get()->result();

		echo json_encode(array("observaciones" => $observaciones, "archivosPlataforma" => $archivos));
	}
	public function cargarObservacionesExportar()
	{
		$url = $_SERVER["REQUEST_URI"];
		$id_organizacion_url = explode(":", $url);
		$id_organizacion = $id_organizacion_url[1];

		$observaciones = $this->db->select("*")->from("observaciones")->where("organizaciones_id_organizacion", $id_organizacion)->order_by("numeroRevision", "desc")->get()->result();
		$archivos = $this->db->select("*")->from("archivos")->where("organizaciones_id_organizacion", $id_organizacion)->where("tipo", "observacionesPlataformaVirtual")->where("id_formulario", 10)->get()->result();


		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Observaciones';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['observaciones'] = $observaciones;
		$data['archivos'] = $archivos;

		$this->load->view('include/header', $data);
		$this->load->view('admin/organizaciones/observacionesExportar', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function actualizar_organizacionHistorial()
	{
		$id_historial = $this->input->post('id_historial');
		$id_organizacion = $this->input->post('id_organizacion');

		$personeria = $this->input->post('personeria');
		$nombresSeries = $this->input->post('nombresSeries');
		$regional = $this->input->post('regional');
		$fechaExtremaInicial = $this->input->post('fechaExtremaInicial');
		$fechaExtremaFinal = $this->input->post('fechaExtremaFinal');
		$caja = $this->input->post('caja');
		$carpeta = $this->input->post('carpeta');
		$tomo = $this->input->post('tomo');
		$otro = $this->input->post('otro');
		$numeroFolios = $this->input->post('numeroFolios');
		$soporte = $this->input->post('soporte');
		$observaciones = $this->input->post('observaciones');

		$organizacion = $this->input->post('organizacion');
		$nit = $this->input->post('nit');
		$sigla = $this->input->post('sigla');
		$nombre = $this->input->post('nombre');
		$nombre_s = $this->input->post('nombre_s');
		$apellido = $this->input->post('apellido');
		$apellido_s = $this->input->post('apellido_s');
		$correo_electronico = $this->input->post('correo_electronico');
		$correo_electronico_rep_legal = $this->input->post('correo_electronico_rep_legal');

		$hist_fech_inicio = $this->input->post('hist_fech_inicio');
		$hist_fech_fin = $this->input->post('hist_fech_fin');
		$hist_anos = $this->input->post('hist_anos');
		$res_num_res = $this->input->post('res_num_res');
		$ver_hist_tipo_org = $this->input->post('ver_hist_tipo_org');

		$name_random = random(10);
		$size = 100000000;

		$imagen_db = $this->db->select('resolucion')->from('historialResoluciones')->where('historial_id_historial', $id_historial)->get()->row();

		$imagen_db_nombre = $imagen_db->resolucion;

		if ($ver_hist_tipo_org != NULL || $ver_hist_tipo_org != '' || $ver_hist_tipo_org != "") {
			$nombre_imagen =  "resolucionHistorial_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "admin", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "admin", 'msg' => "El tamaño supera 10 MB, intente con otro pdf."));
			} else if ($tipo_imagen != "pdf") {
				echo json_encode(array('url' => "admin", 'msg' => "La extensión de la resolución no es correcta, debe ser PDF (archivo.pdf)"));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/resoluciones/' . $nombre_imagen)) {

				$data_insert_historial_res = array(
					'fechaResolucionInicial' => $hist_fech_inicio,
					'fechaResolucionFinal' => $hist_fech_fin,
					'añosResolucion' => $hist_anos,
					'resolucion' => $nombre_imagen,
					'numeroResolucion' => $res_num_res,
					'tipoResolucion' => $ver_hist_tipo_org,
					'historial_id_historial' => $id_historial
				);
				if ($this->db->insert('historialResoluciones', $data_insert_historial_res)) {
					echo json_encode(array('url' => "admin", 'msg' => "Se ingreso otra resolución historica."));
					$this->logs_sia->session_log('Se ingreso otra resolución historica.');
				}
			}
		} else if ($imagen_db_nombre == NULL || $imagen_db_nombre == "" || $imagen_db_nombre == null) {
			$data_insert_organizacion = array(
				'nombreOrganizacion' => $organizacion,
				'numNIT' => $nit,
				'sigla' => $sigla,
				'primerNombreRepLegal' => $nombre,
				'segundoNombreRepLegal' => $nombre_s,
				'primerApellidoRepLegal' => $apellido,
				'segundoApellidoRepLegal' => $apellido_s,
				'direccionCorreoElectronicoOrganizacion' => $correo_electronico,
				'direccionCorreoElectronicoRepLegal' => $correo_electronico_rep_legal
			);
			$this->db->where('id_organizacionHistorial', $id_organizacion);
			if ($this->db->update('organizacionesHistorial', $data_insert_organizacion)) {
				$data_insert_historial = array(
					'personeriaJuridica' => $personeria,
					'nombresSeriesAsuntos' => $nombresSeries,
					'regional' => $regional,
					'fechaExtremaInicial' => $fechaExtremaInicial,
					'fechaExtremaFinal' => $fechaExtremaFinal,
					'caja' => $caja,
					'carpeta' => $carpeta,
					'tomo' => $tomo,
					'otros' => $otro,
					'numeroFolios' => $numeroFolios,
					'soporte' => $soporte,
					'observaciones' => $observaciones
				);
				$this->db->where('organizaciones_id_organizacion', $id_organizacion);
				if ($this->db->update('historial', $data_insert_historial)) {
					echo json_encode(array('url' => "admin", 'msg' => "Se actualizó la organización historica sin resolucion."));
					$this->logs_sia->session_log('Se actualizó una organización historica.');
				}
			}
		} else {
			$nombre_imagen =  "resolucionHistorial_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if ($nombre_imagen == NULL || ($_FILES['file']['tmp_name'] == NULL || $_FILES['file']['tmp_name'] == '')) {
				$data_insert_organizacion = array(
					'nombreOrganizacion' => $organizacion,
					'numNIT' => $nit,
					'sigla' => $sigla,
					'primerNombreRepLegal' => $nombre,
					'segundoNombreRepLegal' => $nombre_s,
					'primerApellidoRepLegal' => $apellido,
					'segundoApellidoRepLegal' => $apellido_s,
					'direccionCorreoElectronicoOrganizacion' => $correo_electronico,
					'direccionCorreoElectronicoRepLegal' => $correo_electronico_rep_legal
				);
				$this->db->where('id_organizacionHistorial', $id_organizacion);
				if ($this->db->update('organizacionesHistorial', $data_insert_organizacion)) {
					$data_insert_historial = array(
						'personeriaJuridica' => $personeria,
						'nombresSeriesAsuntos' => $nombresSeries,
						'regional' => $regional,
						'fechaExtremaInicial' => $fechaExtremaInicial,
						'fechaExtremaFinal' => $fechaExtremaFinal,
						'caja' => $caja,
						'carpeta' => $carpeta,
						'tomo' => $tomo,
						'otros' => $otro,
						'numeroFolios' => $numeroFolios,
						'soporte' => $soporte,
						'observaciones' => $observaciones
					);
					$this->db->where('organizaciones_id_organizacion', $id_organizacion);
					if ($this->db->update('historial', $data_insert_historial)) {
						echo json_encode(array('url' => "admin", 'msg' => "Se actualizó la organización historica."));
						$this->logs_sia->session_log('Se actualizó una organización historica.');
					}
				}
			} else if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "admin", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "admin", 'msg' => "El tamaño supera 10 MB, intente con otro pdf."));
			} else if ($tipo_imagen != "pdf") {
				echo json_encode(array('url' => "admin", 'msg' => "La extensión de la resolución no es correcta, debe ser PDF (archivo.pdf)"));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/resoluciones/' . $nombre_imagen)) {
				$data_insert_organizacion = array(
					'nombreOrganizacion' => $organizacion,
					'numNIT' => $nit,
					'sigla' => $sigla,
					'primerNombreRepLegal' => $nombre,
					'segundoNombreRepLegal' => $nombre_s,
					'primerApellidoRepLegal' => $apellido,
					'segundoApellidoRepLegal' => $apellido_s,
					'direccionCorreoElectronicoOrganizacion' => $correo_electronico,
					'direccionCorreoElectronicoRepLegal' => $correo_electronico_rep_legal
				);
				$this->db->where('id_organizacionHistorial', $id_organizacion);
				if ($this->db->update('organizacionesHistorial', $data_insert_organizacion)) {
					$data_insert_historial = array(
						'personeriaJuridica' => $personeria,
						'nombresSeriesAsuntos' => $nombresSeries,
						'regional' => $regional,
						'fechaExtremaInicial' => $fechaExtremaInicial,
						'fechaExtremaFinal' => $fechaExtremaFinal,
						'caja' => $caja,
						'carpeta' => $carpeta,
						'tomo' => $tomo,
						'otros' => $otro,
						'numeroFolios' => $numeroFolios,
						'soporte' => $soporte,
						'observaciones' => $observaciones
					);
					$this->db->where('organizaciones_id_organizacion', $id_organizacion);
					if ($this->db->update('historial', $data_insert_historial)) {
						$imagen_db = $this->db->select('resolucion')->from('historialResoluciones')->where('historial_id_historial', $id_historial)->get()->row();
						$imagen_db_nombre = $imagen_db->resolucion;

						unlink('uploads/resoluciones/' . $imagen_db_nombre);

						$data_insert_historial_res = array(
							'fechaResolucionInicial' => $hist_fech_inicio,
							'fechaResolucionFinal' => $hist_fech_fin,
							'añosResolucion' => $hist_anos,
							'resolucion' => $nombre_imagen,
							'numeroResolucion' => $res_num_res,
							'historial_id_historial' => $id_historial
						);
						$this->db->where('historial_id_historial', $id_historial);
						if ($this->db->update('historialResoluciones', $data_insert_historial_res)) {
							echo json_encode(array('url' => "admin", 'msg' => "Se actualizó la organización historica."));
							$this->logs_sia->session_log('Se actualizó una organización historica.');
						}
					}
				}
			}
		}
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	public function guardarSeguimiento()
	{
		$certificadoExistencia = $this->input->post('certificadoExistencia');
		$matriculaMercantil = $this->input->post('matriculaMercantil');
		$actividadesEducacion = $this->input->post('actividadesEducacion');
		$domicilio = $this->input->post('domicilio');
		$datosRepLegal = $this->input->post('datosRepLegal');
		$fechaVigenciaCertificado = $this->input->post('fechaVigenciaCertificado');
		$metodologiaAcreditada = $this->input->post('metodologiaAcreditada');
		$materialDidactico = $this->input->post('materialDidactico');
		$contenidosEducativo = $this->input->post('contenidosEducativo');
		$socializacionConceptos = $this->input->post('socializacionConceptos');
		$contextoSocioEconomico = $this->input->post('contextoSocioEconomico');
		$tiposOrganizacionesSolidarias = $this->input->post('tiposOrganizacionesSolidarias');
		$entesControlyApoyo = $this->input->post('entesControlyApoyo');
		$avalCursos = $this->input->post('avalCursos');
		$otrosProgramas = $this->input->post('otrosProgramas');
		$contenidosProgramas = $this->input->post('contenidosProgramas');
		$actualizacionDatosUnidad = $this->input->post('actualizacionDatosUnidad');
		$suministroInformacionVisitas = $this->input->post('suministroInformacionVisitas');
		$entregaInformesActividades = $this->input->post('entregaInformesActividades');
		$docentesHabilitados = $this->input->post('docentesHabilitados');
		$archivoHistoricoEducacion = $this->input->post('archivoHistoricoEducacion');
		$cursosSolidaridadEducativa = $this->input->post('cursosSolidaridadEducativa');
		$subcontratacionTerceros = $this->input->post('subcontratacionTerceros');
		$cotejoCertificacionesCurso = $this->input->post('cotejoCertificacionesCurso');
		$actualizacionHojaVidaDocentes = $this->input->post('actualizacionHojaVidaDocentes');
		$hallazgos = $this->input->post('hallazgos');
		$id_visita = $this->input->post('id_visita');

		$data_seguimiento = array(
			'certificadoExistencia' => $certificadoExistencia,
			'matriculaMercantil' => $matriculaMercantil,
			'actividadesEducacion' => $actividadesEducacion,
			'domicilio' => $domicilio,
			'datosRepLegal' => $datosRepLegal,
			'fechaVigenciaCertificado' => $fechaVigenciaCertificado,
			'metodologiaAcreditada' => $metodologiaAcreditada,
			'materialDidactico' => $materialDidactico,
			'contenidosEducativo' => $contenidosEducativo,
			'socializacionConceptos' => $socializacionConceptos,
			'contextoSocioEconomico' => $contextoSocioEconomico,
			'tiposOrganizacionesSolidarias' => $tiposOrganizacionesSolidarias,
			'entesControlyApoyo' => $entesControlyApoyo,
			'avalCursos' => $avalCursos,
			'otrosProgramas' => $otrosProgramas,
			'contenidosProgramas' => $contenidosProgramas,
			'actualizacionDatosUnidad' => $actualizacionDatosUnidad,
			'suministroInformacionVisitas' => $suministroInformacionVisitas,
			'entregaInformesActividades' => $entregaInformesActividades,
			'docentesHabilitados' => $docentesHabilitados,
			'archivoHistoricoEducacion' => $archivoHistoricoEducacion,
			'cursosSolidaridadEducativa' => $cursosSolidaridadEducativa,
			'subcontratacionTerceros' => $subcontratacionTerceros,
			'cotejoCertificacionesCurso' => $cotejoCertificacionesCurso,
			'actualizacionHojaVidaDocentes' => $actualizacionHojaVidaDocentes,
			'hallazgos' => $hallazgos,
			'visitas_id_visitas' => $id_visita
		);

		if ($this->db->insert('seguimiento', $data_seguimiento)) {
			echo json_encode(array('url' => "", 'msg' => "Se guardo el seguimiento."));
			$this->logs_sia->session_log('Se guardo el seguimiento.');
		}
	}
	public function guardarPlanMejoramiento()
	{
		$txt_descripcion = $this->input->post('txt_descripcion');
		$txt_fecha = $this->input->post('txt_fecha');
		$id_organizacion = $this->input->post('id_organizacion');
		$id_visita = $this->input->post('id_visita');

		$data_plan = array(
			'descripcionMejora' => $txt_descripcion,
			'fechaMejora' => $txt_fecha,
			'cumple' => 0,
			'observaciones' => "",
			'visitas_id_visitas' => $id_visita,
			'organizaciones_id_organizacion' => $id_organizacion
		);

		$data_update = array(
			'terminada' => 1
		);

		if ($this->db->insert('planMejoramiento', $data_plan)) {
			$this->db->where('organizaciones_id_organizacion', $id_organizacion);
			if ($this->db->update('visitas', $data_update)) {
				echo json_encode(array('url' => "", 'msg' => "Se guardo el seguimiento, espere 5 segundos la ventana se cerrará."));
				$this->envio_mail("plan", $id_organizacion, 2, "");
			}
		}
	}
	public function cargarActividadAdmin()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_actividad = $this->db->select('*')->from('session_log')->where('usuario_id', $usuario_id)->order_by("id_session_log", "desc")->get()->result();
		return $datos_actividad;
	}
	public function cargarMisNotificaciones()
	{
		$notificaciones = $this->db->select("*")->from("notificaciones")->where("quienRecibe", "admin")->get()->result();
		return $notificaciones;
	}
	public function verBateriaObservacion()
	{
		$id_observacion = $this->input->post('id_observacion');

		$observacion = $this->db->select("*")->from("bateriaObservaciones")->where("id_bateriaObservaciones", $id_observacion)->get()->row();

		echo json_encode($observacion);
	}
	public function cargarCursosInforme()
	{
		$tiposCursoInformes = $this->db->select("*")->from("tiposCursoInformes")->get()->result();
		return $tiposCursoInformes;
	}
	public function actualizarTiposCursoInforme()
	{
		$id_tiposCursoInformes = $this->input->post('id_tiposCursoInformes');
		$nombre = $this->input->post('nombre');

		$data_update = array(
			'nombre' => $nombre
		);

		$this->db->where('id_tiposCursoInformes', $id_tiposCursoInformes);
		if ($this->db->update('tiposCursoInformes', $data_update)) {
			echo json_encode(array('msg' => "Cursos Actualizados"));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó los cursos del informe de actividades.');
		}
	}
	public function eliminarCursoInforme()
	{
		$id_curso = $this->input->post('id_curso');

		$this->db->where('id_tiposCursoInformes', $id_curso);
		if ($this->db->delete("tiposCursoInformes")) {
			echo json_encode(array('msg' => "El curso se elimino."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' elimino el cruso de informeActividades.');
		}
	}
	public function crearTiposCursoInforme()
	{
		$nombre = $this->input->post('nombre');

		$data_crear = array(
			'nombre' => $nombre
		);

		if ($this->db->insert('tiposCursoInformes', $data_crear)) {
			echo json_encode(array('url' => "", 'msg' => "Se creo el curso."));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' creo un curso de informe de actividades.');
		}
	}
	/**
		Funcion para enviar un correo electronico.
	 **/
	function enviomail_contacto()
	{
		$correo_electronico = CORREO_SIA;
		$to = $this->input->post('correo_electronico');
		$bcc = $this->input->post('masivo');
		$cc = $this->input->post('correo_electronico_rep');
		$prioridad = $this->input->post('prioridad');
		$asunto = $this->input->post('asunto');
		$mensaje = $this->input->post('mensaje');
		// $todos = $this->input->post('todos');
		// $nombre = $this->input->post('nombre');

		if ($correo_electronico != null || $correo_electronico != "") {
			$to = $correo_electronico;
		} else {
			$to = "";
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
		$this->email->from($correo_electronico, "Acreditaciones");
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->bcc($bcc);
		$this->email->subject('SIIA - Asunto: ' . $asunto);
		$this->email->set_priority($num_prioridad);

		$data_msg['mensaje'] = $mensaje;

		$email_view = $this->load->view('email/contacto', $data_msg, true);

		$this->email->message($email_view);

		if ($this->email->send()) {
			echo json_encode(array('url' => "login", 'msg' => "Se envio el correo, por favor esperar la respuesta."));
		} else {
			echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envio el correo."));
			//$this->email->print_debugger();
		}
	}
	public function cargarNits()
	{
		$nits = $this->db->select("*")->from("nits_db")->get()->result();
		return $nits;
	}
	public function cargarResultadosEncuesta()
	{
		$resultados = $this->db->select("*")->from("encuesta")->get()->result();
		return $resultados;
	}
	// Actualizar Opciones
	public function actualizarOpciones()
	{
		$titulo = $this->input->post('titulo');

		$data_update = array(
			'valor' => $titulo
		);

		$this->db->where('nombre', 'titulo');
		if ($this->db->update('opciones', $data_update)) {
			echo json_encode(array('msg' => "Nombre de la aplicación actualizado"));
		}
	}
	public function guardarArchivoObsPlataforma()
	{
		//$this->form_validation->set_rules('tipoArchivo','','trim|required|min_length[3]|xss_clean');
		$tipoArchivo = $this->input->post('tipoArchivo');
		$append_name = $this->input->post('append_name');
		$id_organizacion = $this->input->post('id_organizacion');

		//$usuario_id = $this->session->userdata('usuario_id');
		$name_random = random(10);
		$size = 100000000;

		/*$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion ->id_organizacion;

		$archivos = $this->db->select('*')->from('archivos')->where('organizaciones_id_organizacion', $id_organizacion)->get()->row();*/

		//if($tipoArchivo == "obsPlataforma"){
		$ruta = 'uploads/observacionesPlataforma';
		$mensaje = "Se guardo archivo...";
		//}

		$nombre_imagen_ =  $append_name . "_" . $name_random . "_" . $_FILES['file']['name'];
		$nombre_imagen = preg_replace('/\s+/', '', $nombre_imagen_);
		$tipo_archivo = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

		$data_update = array(
			'tipo' => $tipoArchivo,
			'nombre' => $nombre_imagen,
			'id_formulario' => 10,
			'organizaciones_id_organizacion' => $id_organizacion
		);

		if (0 < $_FILES['file']['error']) {
			echo json_encode(array('url' => "", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
		} else if ($_FILES['file']['size'] > $size) {
			echo json_encode(array('url' => "", 'msg' => "El tamaño supera las 10 Mb, intente con otro archivo PDF."));
		} else if ($tipo_archivo != "pdf") {
			echo json_encode(array('url' => "", 'msg' => "La extensión del archivo no es correcta, debe ser PDF. (archivo.pdf)"));
		} else if ($this->db->insert('archivos', $data_update)) {
			if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta . '/' . $nombre_imagen)) {
				echo json_encode(array('url' => "", 'msg' => $mensaje));
				//$this->notif_sia->notification('OBSERVACIONES', $nombre_usuario, "");
				//$this->logs_sia->session_log('Actualizacion de Imagen / Logo');){
			} else {
				echo json_encode(array('url' => "", 'msg' => "No se guardo el archivo(s)."));
			}
		}

		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	/**
		Funcion para enviar un correo electronico.
		$this->envio_mail("obs", $id_organizacion, 1);
	 **/
	function envio_mail($type, $id_organizacion, $prioridad, $adj)
	{
		$fromSIA = "Unidad Solidaria - Aplicación SIIA.";

		$to_correo = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
		$estadoOrganizaciones = $this->db->select("*")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$est = $estadoOrganizaciones->nombre;

		switch ($type) {
			case 'plan':
				$asunto = "Plan de mejoramiento";
				$mensaje = "Organización " . $to_correo->nombreOrganizacion . ", se le creo un plan de mejora el cual debe completar según las fechas acordadas por la persona que le hizo la evaluación.";
				break;
			case 'docentes':
				$asunto = "Docentes";
				$mensaje = "Organización " . $to_correo->nombreOrganizacion . ": Organizaciones Solidarias le informa que se ha realizado la revisión de las hojas de vida presentadas, verificando los requisitos establecidos en el numeral 6 del artículo 4 de la resolución 110 de 2016 y se  actualizó la relación de facilitadores de la entidad acreditada. Le recomendamos revisar este listado donde podrá identificar las hojas de vida aprobadas y aquellas que están pendientes por aprobación dado que no cumplen con algún requisito. Favor verificar en el aplicativo las observaciones  e ingresar la información solicitada en cada caso para proceder a aprobarlas.";
				break;
			case 'camara':
				$asunto = "Cámara de comercio";
				$mensaje = "Organización " . $to_correo->nombreOrganizacion . ", su cámara ha sido actualizada, por favor verifique su perfil en la aplicación SIIA o puede la puede mirar dando click aqui <a href='" . base_url() . "uploads/camaraComercio/" . $adj . "' target='_blank'>Ver cámara</a>.";
				break;
			default:
				$asunto = "";
				$mensaje = "";
				break;
		}
		/**
		1 => '1 (Highest)',
		2 => '2 (High)',
		3 => '3 (Normal)',
		4 => '4 (Low)',
		5 => '5 (Lowest)'
		 **/
		switch ($prioridad) {
			case 1:
				$num_prioridad = 1;
				break;
			case 2:
				$num_prioridad = 2;
				break;
			case 3:
				$num_prioridad = 3;
				break;
			default:
				$num_prioridad = 3;
				break;
		}

		$this->email->from(CORREO_SIA, "Acreditaciones");
		$this->email->to($to_correo->direccionCorreoElectronicoOrganizacion);
		$this->email->subject('SIIA - : ' . $asunto);
		$this->email->set_priority($num_prioridad);

		$data_msg['mensaje'] = $mensaje;

		$email_view = $this->load->view('email/contacto', $data_msg, true);

		$this->email->message($email_view);

		if ($this->email->send()) {
			// Do nothing.
		} else {
			echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envio el correo."));
		}
	}
	function envio_mail_admin($tipo, $correoAdmin, $prioridad, $docente)
	{
		$fromSIA = "Unidad Solidarias - Aplicación SIIA.";

		switch ($tipo) {
			case 'asignar':
				$asunto = "Asignación de organización";
				$mensaje = "Se le ha asignado una organización para que pueda ver la solicitud y la información, este correo es informativo y debe ingresar a la aplicación SIIA, en organizaciones y luego en evaluación para poder ver la solicitud.";
				break;
			case 'asignarDocente':
				$asunto = "Asignación de docente";
				$mensaje = "Se le ha asignado el docente <strong>" . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . "</strong> para que pueda ver la solicitud y la información, este correo es informativo y debe ingresar a la aplicación SIIA, en facilitadores y luego en evaluación para poder ver la solicitud.";
				break;
			default:
				$asunto = "";
				$mensaje = "";
				break;
		}
		/**
		1 => '1 (Highest)',
		2 => '2 (High)',
		3 => '3 (Normal)',
		4 => '4 (Low)',
		5 => '5 (Lowest)'
		 **/
		$this->email->from(CORREO_SIA, "Acreditaciones");
		//$this->email->to(CORREO_SIA); // Pruebas
		$this->email->to($correoAdmin);
		$this->email->subject('SIIA: ' . $asunto);
		$this->email->set_priority($prioridad);

		$data_msg['mensaje'] = $mensaje;

		$email_view = $this->load->view('email/contacto', $data_msg, true);

		$this->email->message($email_view);

		if ($this->email->send()) {
			// Do nothing.
		} else {
			echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envio el correo."));
		}
	}
	public function modalInformacionUpdate()
	{
		$habilitarModal = $this->input->post('habilitarModal');
		$mensajeInformativo = $this->input->post('mensajeInformativo');

		$id_opcion = $this->db->select("id_opcion")->from("opciones")->where("nombre", "modal")->get()->row()->id_opcion;
		$informacionModalDB = $this->db->select("id_opcion")->from("opciones")->where("nombre", "informacionModal")->get()->row()->id_opcion;

		$data_opcioneValor = array(
			'valor' => $habilitarModal,
		);

		$data_opcionMensaje = array(
			'valor' => $mensajeInformativo,
		);

		$this->db->where('id_opcion', $id_opcion);
		if ($this->db->update('opciones', $data_opcioneValor)) {
			$this->db->where('id_opcion', $informacionModalDB);
			if ($this->db->update('opciones', $data_opcionMensaje)) {
				echo json_encode(array('url' => "login", 'msg' => "Se actualizo la configuración del modal informativo."));
			}
		}
	}
	public function cargar_informacionModal()
	{
		$informacionModal = $this->db->select("valor")->from("opciones")->where("nombre", "informacionModal")->get()->row()->valor;
		return $informacionModal;
	}
}
function var_dump_pre($mixed = null)
{
	echo '<pre>';
	var_dump($mixed);
	echo '</pre>';
	return null;
}
