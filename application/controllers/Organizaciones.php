<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';

class Organizaciones extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SolicitudesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('AdministradoresModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('InformacionGeneralModel');
		$this->load->model('UsuariosModel');
	}
	/**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
	/** Datos Sesión */
	public function datosSession()
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
		);
		return $data;
	}
	/** Vista de panel de organizaciones */
	public function index()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Organizaciones';
		$data['activeLink'] = 'organizaciones';
		$this->loadView('admin/organizaciones/index', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Organizaciones Inscritas  */
	public function inscritas()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Inscritas';
		$data['activeLink'] = 'organizaciones-inscritas';
		$this->loadView('super/pages/organizaciones', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	// Cargar información organización inscrita
	public function datosOrganzacion()
	{
		$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('id_organizacion'));
		$usuario = $this->UsuariosModel->getUsuarios($organizacion->usuarios_id_usuario);
		$actividad = $this->UsuariosModel->getActividadUsuario($organizacion->usuarios_id_usuario);
		$solicitudes = $this->SolicitudesModel->getSolicitudesByOrganizacion($organizacion->id_organizacion);
		$informacionGeneral = $this->InformacionGeneralModel->getInformacionGeneral($organizacion->id_organizacion);
		echo json_encode(array(
			'organizacion' => $organizacion,
			'actividad' => $actividad,
			'usuario' => $usuario,
			'solicitudes' => $solicitudes,
			'informacionGeneral' => $informacionGeneral
		));
	}
	/** Camara de comercio */
	public function camara()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal / Administrador / Cámara de Comercio';
		$data['activeLink'] = 'organizaciones-inscritas'; // ← Agregar esta línea
		$data['organizaciones'] = $this->OrganizacionesModel->getOrganizaciones();
		$this->load->view('include/header/main', $data);
		$this->load->view('admin/organizaciones/camara', $data);
		$this->load->view('include/footer/main', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Solicitar Camara de Comercio
	public function solicitarCamara($idOrganizacion = null)
	{
		//Buscar y borrar camara de comercio
		$idOrg = $idOrganizacion ? $idOrganizacion : $this->input->post('id_organizacion');
		$organizacion = $this->db->select("*")->from("organizaciones")->where('id_organizacion', $idOrg)->get()->row();
		$file = $organizacion->camaraComercio;
		unlink('uploads/camaraComercio/' . $file);
		// Actualización camara de comercio por default file
		$camaraComercio = array('camaraComercio' => "default.pdf");
		$this->db->where('id_organizacion', $organizacion->id_organizacion);
		if ($this->db->update('organizaciones', $camaraComercio)) {
			// Session data
			$this->logs_sia->session_log('Organización:' . $this->session->userdata('nombre_usuario') . ' pidió nueva camara de comercio a la organización con ID: ' . $organizacion->id_organizacion . '.');
			// Usuario cámaras de comercio
			$usuarioCamara = $this->db->select("*")->from("administradores")->where("nivel", 3)->get()->row();
			$to = $usuarioCamara->direccionCorreoElectronico;
			// Enviar correo
			send_email_admin('solicitarCamara', 1, $to, null, $organizacion, null);
		}
		// LogQueries
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	// Recordar Camara de Comercio
	public function organizacionesSinCamaraDeComercio()
	{
		$usuarioCamara = $this->db->select("*")->from("administradores")->where("nivel", 3)->get()->row();
		$nombre = $usuarioCamara->primerNombreAdministrador;
		$apellido = $usuarioCamara->primerApellidoAdministrador;
		$correoCamara = $usuarioCamara->direccionCorreoElectronico;
		$inicio = "Buen día " . $nombre . " " . $apellido . ", <br>Las siguientes organizaciones están pendientes por subir la camara de comercio:<br><br>";
		$orgTotales = "Organizaciones inscritas en la aplicación (todas): <br><br>";
		$orgFinalizadas = "Organizaciones que finalizaron, en observaciones o requieren nueva camara de comercio <strong>(prioritarias)</strong>: <br><br>";
		$dataOrganizaciones = $this->db->select("organizaciones_id_organizacion")->from("estadoOrganizaciones")->get()->result();
		foreach ($dataOrganizaciones as $organizacionDB) {
			$id_organizacion = $organizacionDB->organizaciones_id_organizacion;
			$data_organizaciones = $this->db->select("nombreOrganizacion, numNIT, camaraComercio, id_organizacion")->from("organizaciones")->where("id_organizacion", $id_organizacion)->get()->row();
			$id_org = $data_organizaciones->id_organizacion;
			$camaraComercio = $data_organizaciones->camaraComercio;
			$data_organizaciones_inf = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $id_org)->get()->row();
			$documentacionLegal = $this->db->select("*")->from("documentacionLegal")->where("organizaciones_id_organizacion", $id_org)->get()->row();
			$data_organizaciones_est = $this->db->select("*")->from("estadoOrganizaciones")->where("organizaciones_id_organizacion", $id_org)->get()->row();
			$estadoOrganizacion = $data_organizaciones_est->nombre;
			$registro = $documentacionLegal->registroEducativo;
			if (($estadoOrganizacion == "Finalizado" || $estadoOrganizacion == "En Observaciones") && $camaraComercio == "default.pdf" && $registro == "No Tiene") {
				$texto1 .= "Nombre: " . $data_organizaciones->nombreOrganizacion . " con NIT: <strong>" . $data_organizaciones->numNIT . "</strong><br>";
			}
			if ($data_organizaciones != NULL && $camaraComercio == "default.pdf") {
				$texto .= "Nombre: " . $data_organizaciones->nombreOrganizacion . " con NIT: <strong>" . $data_organizaciones->numNIT . "</strong><br>";
			}
		}
		echo $inicio;
		echo "Correo de notificaciones: " . $correoCamara;
		echo "<br><br>";
		echo $orgFinalizadas;
		echo $texto1;
		echo "<br>";
		echo $orgTotales;
		echo $texto;
	}
	// Subir Camara de Comercio
	public function subirCamara()
	{
		$organizacion = $this->db->select('*')->from('organizaciones')->where('id_organizacion', $this->input->post('id_organizacion'))->get()->row();
		$random = random(10);
		$tamano = 100000000;
		$archivo = $organizacion->camaraComercio;
		$nombreArchivo = "camara_comercio_" . $random . $_FILES['file']['name'];
		$tipoArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
		// Comprobación de errores de archivo
		if ($archivo != 'default.pdf')
			unlink('uploads/camaraComercio/' . $archivo);
		if (0 < $_FILES['file']['error']):
			echo json_encode(array('msg' => "Hubo un error al actualizar, intente de nuevo."));
		elseif ($_FILES['file']['size'] > $tamano):
			echo json_encode(array('msg' => "El tamaño supera 10 MB, intente con otro pdf."));
		elseif ($tipoArchivo != "pdf"):
			echo json_encode(array('msg' => "La extensión de la cámara no es correcta, debe ser PDF"));
		elseif (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/camaraComercio/' . $nombreArchivo)):
			$data_update = array('camaraComercio' => $nombreArchivo);
			$this->db->where('id_organizacion', $organizacion->id_organizacion);
			if ($this->db->update('organizaciones', $data_update)):
				echo json_encode(array('url' => "camaraComercio", 'msg' => "Se actualizó la cámara de comercio con éxito.", 'estado' => 'cargado'));
				$this->logs_sia->session_log('Camara de Comercio Adjuntada');
				$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó la camara de la organización id: ' . $organizacion->id_organizacion . '.');
			else:
				echo json_encode(array('url' => "camaraComercio", 'msg' => "Se cargo el archivo pero no se actualizo en la organización, por favor informe con el administrador.", 'estado' => 'cargado'));
			endif;
			// Envío de correo
			//$this->envio_mail("camara", $id_organizacion, 2, $nombre_imagen);
			// Log session
		endif;
		// Log system
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	public function estado()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal / Administrador / Organizaciones';
		$data['solicitudes'] = $this->cargarSolicitudesRegistradas();
		$this->load->view('include/header/main', $data);
		$this->load->view('admin/organizaciones/estado', $data);
		$this->load->view('include/footer/main', $data);
		$this->logs_sia->logs('PLACE_USER');
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
}
// Validación de errores
function var_dump_pre($mixed = null) {
	echo '<pre>';
	var_dump($mixed);
	echo '</pre>';
	return null;
}
