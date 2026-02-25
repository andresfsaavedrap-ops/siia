<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('SolicitudesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('UsuariosModel');
		$this->load->model('InformacionGeneralModel');
	}
	/** Datos Sesión */
	public function datosSession()
	{
		verify_session();
		date_default_timezone_set("America/Bogota");
		$data = array(
			'logged_in' => $this->session->userdata('logged_in'),
			'nombre_usuario' => $this->session->userdata('nombre_usuario'),
			'usuario_id' => $this->session->userdata('usuario_id'),
			'tipo_usuario' => $this->session->userdata('type_user'),
			'nivel' => $this->session->userdata('nivel'),
			'hora' => date("H:i", time()),
			'fecha' => date('Y/m/d'),
			'activeLink' => 'reportes',
			'departamentos' => $this->DepartamentosModel->getDepartamentos(),
		);
		return $data;
	}
	public function index()
	{
		$data = $this->datosSession();
		$usuario = $this->UsuariosModel->getUsuarios($data['usuario_id']);
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($usuario->id_usuario);
		$informacionGeneral = $this->InformacionGeneralModel->getInformacionGeneral($organizacion->id_organizacion);
		$actividades = $this->UsuariosModel->getActividadUsuario($usuario->id_usuario);
		$data['organizacion'] = $organizacion;
		$data['usuario'] = $usuario;
		$data['informacionGeneral'] = $informacionGeneral;
		$data['actividades'] = $actividades;
		$this->load->view('include/header/main', $data);
		$this->load->view('user/modules/perfil/index', $data);
		//$this->load->view('paneles/actividad', $data_actividad);
		$this->load->view('include/footer/main');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function actividad()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_actividad = $this->db->select('*')->from('session_log')->where('usuario_id', $usuario_id)->order_by("id_session_log", "desc")->limit(70)->get()->result();
		return $datos_actividad;
	}
	public function idSolicitud()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$idSolicitud = $this->db->select("idSolicitud")->from("tipoSolicitud")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$id_Solicitud = $idSolicitud->idSolicitud;
		return $id_Solicitud;
	}
	public function estadoOrganizaciones()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$estado = $this->db->select("nombre")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$nombreEstado = $estado->nombre;
		return $nombreEstado;
	}
	public function cargarMunicipios()
	{
		$departamento = $this->input->post('departamento');

		$data_departamento = $this->db->select("id_departamento")->from("departamentos")->where('nombre', $departamento)->get()->row();
		$id_departamento = $data_departamento->id_departamento;
		$municipios = $this->db->select("*")->from("municipios")->where('departamentos_id_departamento', $id_departamento)->get()->result();
		echo json_encode($municipios);
	}
	public function cargarDatos_formulario_informacion_general_entidad()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;
		$datos_formulario = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		return $datos_formulario;
	}
	public function estadoAnteriorOrganizaciones()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$estado = $this->db->select("estadoAnterior")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$nombreEstado = $estado->estadoAnterior;
		return $nombreEstado;
	}
	public function numeroSolicitudes()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$solicitudes = $this->db->select("numeroSolicitudes")->from("solicitudes")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		$numeroSolicitudes = $solicitudes->numeroSolicitudes;
		return $numeroSolicitudes;
	}
	public function cargarMisNotificaciones()
	{
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$tipo_usuario = $this->session->userdata('type_user');

		$notificaciones = $this->db->select("*")->from("notificaciones")->where("quienRecibe", $nombre_usuario)->get()->result();
		return $notificaciones;
	}
	public function cargarResolucion()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$resolucion = $this->db->select("*")->from("resoluciones")->where("organizaciones_id_organizacion", $id_organizacion)->get()->row();
		return $resolucion;
	}
	public function cargarCamaraComercio()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;

		$resolucion = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
		return $resolucion;
	}
	// Cargar logo organización
	public function actualizarLogoOrganizacion()
	{
		if (!empty($_FILES)):
			$usuario_id = $this->session->userdata('usuario_id');
			$name_random = random(10);
			$size = 10000000;
			$organizacion = $this->db->select('*')->from('organizaciones')->where('usuarios_id_usuario', $usuario_id)->get()->row();
			$nombre_imagen =  "logo_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
			if (0 < $_FILES['file']['error']):
				echo json_encode(array('status' => "error", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			elseif ($_FILES['file']['size'] > $size):
				echo json_encode(array('status' => "warning", 'msg' => "El tamaño supera las 10 Mb, intente con otra imagen."));
			elseif ($tipo_imagen != "jpeg" &&  $tipo_imagen != "png" &&  $tipo_imagen != "jpg"):
				echo json_encode(array('status' => "warning", 'msg' => "La extensión de la imagen no es correcta, debe ser JPG, PNG"));
			elseif (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/logosOrganizaciones/' . $nombre_imagen)):
				if ($organizacion->imagenOrganizacion != 'default.png'):
					unlink('uploads/logosOrganizaciones/' . $organizacion->imagenOrganizacion);
				endif;
				$data_update = array('imagenOrganizacion' => $nombre_imagen);
				$this->db->where('usuarios_id_usuario', $usuario_id);
				$this->db->update('organizaciones', $data_update);
				echo json_encode(array('status' => "success", 'msg' => "Se actualizo la imagen de perfil correctamente."));
			endif;
		else:
			echo json_encode(array('status' => "warning", 'msg' => "Por favor busque y seleccióne una imagen."));
		endif;
	}
	// Actualizar datos de la organización
	public function actualizarInformacionPerfil()
	{
		$this->form_validation->set_rules('organizacion', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('nit', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('sigla', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('nombre', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('nombre_s', '', 'trim|xss_clean');
		$this->form_validation->set_rules('apellido', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('apellido_s', '', 'trim|xss_clean');
		$this->form_validation->set_rules('correo_electronico', '', 'trim|required|min_length[3]|valid_email|xss_clean');
		$this->form_validation->set_rules('correo_electronico_rep_legal', '', 'trim|required|min_length[3]|valid_email|xss_clean');
		$this->form_validation->set_rules('nombre_p', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('apellido_p', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('tipo_organizacion', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('departamento', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('municipio', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('direccion', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('fax', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('extension', '', 'trim|min_length[1]|xss_clean');
		$this->form_validation->set_rules('actuacion', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('educacion', '', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('numCedulaCiudadaniaPersona', '', 'trim|required|min_length[3]|xss_clean');
		if ($this->form_validation->run("formulario_actualizar") == FALSE):
			$error = validation_errors();
			echo json_encode(array('msg' => $error, 'status' => 'error'));
		else:
			$organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $this->session->userdata('usuario_id'))->get()->row();
			$informacionGeneral = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $organizacion->id_organizacion)->get()->row();
			// Datos actualizar organización
			$data_update = array(
				'nombreOrganizacion' => $this->input->post('organizacion'),
				'numNIT' => $this->input->post('nit'),
				'sigla' => $this->input->post('sigla'),
				'primerNombreRepLegal' => $this->input->post('nombre'),
				'segundoNombreRepLegal' => $this->input->post('nombre_s'),
				'primerApellidoRepLegal' => $this->input->post('apellido'),
				'segundoApellidoRepLegal' => $this->input->post('apellido_s'),
				'direccionCorreoElectronicoOrganizacion' => $this->input->post('correo_electronico'),
				'direccionCorreoElectronicoRepLegal' => $this->input->post('correo_electronico_rep_legal'),
				'primerNombrePersona' => $this->input->post('nombre_p'),
				'primerApellidoPersona' => $this->input->post('apellido_p'),
			);
			// Datos actualizar información general
			$data_informacion_general = array(
				'tipoOrganizacion' => $this->input->post('tipo_organizacion'),
				'direccionOrganizacion' => $this->input->post('direccion'),
				'nomDepartamentoUbicacion' => $this->input->post('departamento'),
				'nomMunicipioNacional' => $this->input->post('municipio'),
				'fax' => $this->input->post('fax'),
				'extension' => $this->input->post('extension'),
				'urlOrganizacion' =>  $this->input->post('urlOrganizacion'),
				'actuacionOrganizacion' => $this->input->post('actuacion'),
				'tipoEducacion' =>  $this->input->post('educacion'),
				'numCedulaCiudadaniaPersona' => $this->input->post('numCedulaCiudadaniaPersona'),
				'fecha' => date('Y/m/d H:i:s'),
				'organizaciones_id_organizacion' => $organizacion->id_organizacion
			);
			// Actualizar datos de la organización
			$this->db->where('usuarios_id_usuario', $this->session->userdata('usuario_id'));
			if ($this->db->update('organizaciones', $data_update)):
				// Comprobar si existen datos de información general
				if ($informacionGeneral == NULL || $informacionGeneral == ""):
					// Crear datos si no existen
					$this->db->insert('informacionGeneral', $data_informacion_general);
				else:
					// Actualizar datos si existen
					$this->db->where('organizaciones_id_organizacion', $organizacion->id_organizacion);
					$this->db->update('informacionGeneral', $data_informacion_general);
				endif;
				// Guardar logs y notificaciones.
				$this->logs_sia->session_log('Actualización de datos básicos');
				$this->logs_sia->logQueries();
				$this->logs_sia->logs('URL_TYPE');
				$this->notif_sia->notification('ACTUALIZAR_DATOS', 'admin', $this->input->post('organizacion'));
				// Enviar email.
				send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'actualizarPerfil', $organizacion, null, null, null);
			endif;
		endif;
	}
	public function upload_firma()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$firma_contrasena = $this->input->post('firmaContrasena');

		$name_random = random(10);
		$size = 10000000;

		$imagen_db = $this->db->select('firmaRepLegal')->from('organizaciones')->where('usuarios_id_usuario', $usuario_id)->get()->row();
		$imagen_db_nombre = $imagen_db->firmaRepLegal;

		if ($imagen_db_nombre != 'default.png') {
			$nombre_imagen =  "firma_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "perfil", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "perfil", 'msg' => "El tamaño supera las 10 Mb, intente con otra imagen."));
			} else if ($tipo_imagen != "jpeg" &&  $tipo_imagen != "png" &&  $tipo_imagen != "jpg") {
				echo json_encode(array('url' => "perfil", 'msg' => "La extensión de la imagen no es correcta, debe ser JPG, PNG"));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/logosOrganizaciones/firma/' . $nombre_imagen)) {
				unlink('uploads/logosOrganizaciones/firma/' . $imagen_db_nombre);
				$data_update = array(
					'firmaRepLegal' => $nombre_imagen,
					'contrasena_firma' => $firma_contrasena
				);

				$this->db->where('usuarios_id_usuario', $usuario_id);
				$this->db->update('organizaciones', $data_update);

				echo json_encode(array('url' => "perfil", 'msg' => "Se actualizo la firma."));
				$this->logs_sia->session_log('Actualización de Firma');
			}
		} else {
			$nombre_imagen =  "firma_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "perfil", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "perfil", 'msg' => "El tamaño supera las 10 Mb, intente con otra imagen."));
			} else if ($tipo_imagen != "jpeg" &&  $tipo_imagen != "png" &&  $tipo_imagen != "jpg") {
				echo json_encode(array('url' => "perfil", 'msg' => "La extensión de la imagen no es correcta, debe ser JPG, PNG"));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/logosOrganizaciones/firma/' . $nombre_imagen)) {
				$data_update = array(
					'firmaRepLegal' => $nombre_imagen,
					'contrasena_firma' => $firma_contrasena
				);

				$this->db->where('usuarios_id_usuario', $usuario_id);
				$this->db->update('organizaciones', $data_update);

				echo json_encode(array('url' => "perfil", 'msg' => "Se actualizo la firma."));
				$this->logs_sia->session_log('Actualización de la Firma');
			}
		}
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	public function upload_firma_certifi()
	{
		$usuario_id = $this->session->userdata('usuario_id');

		$name_random = random(10);
		$size = 10000000;

		$imagen_db = $this->db->select('firmaCert')->from('organizaciones')->where('usuarios_id_usuario', $usuario_id)->get()->row();
		$imagen_db_nombre = $imagen_db->firmaCert;

		if ($imagen_db_nombre != 'default.png') {
			$nombre_imagen =  "firmaCert_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "perfil", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "perfil", 'msg' => "El tamaño supera las 10 Mb, intente con otra imagen."));
			} else if ($tipo_imagen != "png") {
				echo json_encode(array('url' => "perfil", 'msg' => "La extensión de la imagen no es correcta, debe ser PNG."));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/logosOrganizaciones/firmaCert/' . $nombre_imagen)) {
				unlink('uploads/logosOrganizaciones/firmaCert/' . $imagen_db_nombre);
				$data_update = array(
					'firmaCert' => $nombre_imagen
				);

				$this->db->where('usuarios_id_usuario', $usuario_id);
				$this->db->update('organizaciones', $data_update);

				echo json_encode(array('url' => "perfil", 'msg' => "Se actualizo la firma para certificados."));
				$this->logs_sia->session_log('Actualización de la Firma Certificados');
			}
		} else {
			$nombre_imagen =  "firmaCert_" . $name_random . $_FILES['file']['name'];
			$tipo_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);

			if (0 < $_FILES['file']['error']) {
				echo json_encode(array('url' => "perfil", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
			} else if ($_FILES['file']['size'] > $size) {
				echo json_encode(array('url' => "perfil", 'msg' => "El tamaño supera las 10 Mb, intente con otra imagen."));
			} else if ($tipo_imagen != "png") {
				echo json_encode(array('url' => "perfil", 'msg' => "La extensión de la imagen no es correcta, debe ser PNG."));
			} else if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/logosOrganizaciones/firmaCert/' . $nombre_imagen)) {
				$data_update = array(
					'firmaCert' => $nombre_imagen
				);

				$this->db->where('usuarios_id_usuario', $usuario_id);
				$this->db->update('organizaciones', $data_update);

				echo json_encode(array('url' => "perfil", 'msg' => "Se actualizo la firma para certificados."));
				$this->logs_sia->session_log('Actualización de la Firma Certificados');
			}
		}
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	public function actualizar_nombreCargo()
	{
		$usuario_id = $this->session->userdata('usuario_id');
		$datos_organizacion = $this->db->select("id_organizacion")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		$id_organizacion = $datos_organizacion->id_organizacion;
		$usuario_id = $this->session->userdata('usuario_id');

		$nombrePersonaCert = $this->input->post('nombrePersonaCert');
		$cargoPersonaCert = $this->input->post('cargoPersonaCert');

		$data_update = array(
			'personaCert' => $nombrePersonaCert,
			'cargoCert' => $cargoPersonaCert
		);

		$this->db->where('id_organizacion', $id_organizacion);
		if ($this->db->update('organizaciones', $data_update)) {
			echo json_encode(array('url' => "perfil", 'msg' => "Se actualizaron los datos de nombre y cargo."));
			$this->logs_sia->session_log('Actualizacion de Nombre y Cargo Certificados');
			$this->logs_sia->logQueries();
		}
	}
	public function eliminar_firma_certifi()
	{
		$usuario_id = $this->session->userdata('usuario_id');

		$data_update = array(
			'firmaCert' => 'default.png'
		);

		$this->db->where('usuarios_id_usuario', $usuario_id);
		$this->db->update('organizaciones', $data_update);

		echo json_encode(array('url' => "perfil", 'msg' => "Se elimino la firma para certificados."));
		$this->logs_sia->session_log('Actualización de la Firma Certificados');

		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
}
