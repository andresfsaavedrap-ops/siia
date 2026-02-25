<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InformeActividades extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welco7me
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
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
		$this->load->model('AdministradoresModel');
		$this->load->model('InformeActividadesModel');
		$this->load->model('ObservacionesInformeModel');
		$this->load->model('AsistentesModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('SolicitudesModel');
		$this->load->model('DocentesModel');
		$this->load->model('DepartamentosModel');
	}
	/**
	 * Datos sesión usuarios
	 */
	public function dataSessionUsuario() {
		date_default_timezone_set("America/Bogota");
		verify_session();
		$data = array(
			'logged_in' => $this->session->userdata('logged_in'),
			'tipo_usuario' => $this->session->userdata('type_user'),
			'nivel' => $this->session->userdata('nivel'),
			'nombre_usuario' => $this->session->userdata('nombre_usuario'),
			'usuario_id' => $this->session->userdata('usuario_id'),
			'hora' => date("H:i", time()),
			'fecha' => date('Y/m/d'),
		);
		return $data;
	}
	public function index()
	{
		$data = $this->dataSessionUsuario();
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($data['usuario_id']);
		$data['title'] = 'Panel Principal - Informe de Actividades';
		$data['organizaciones'] = $this->OrganizacionesModel->getOrganizacionesAcreditadas();
		$data['docentes'] = $this->DocentesModel->getDocentesValidos($organizacion->id_organizacion);
		$data['solicitudes'] = $this->SolicitudesModel->getSolicitudesAcreditadasOrganizacion($organizacion->id_organizacion);
		$data['informes'] = $this->InformeActividadesModel->getInformeActividades($organizacion->id_organizacion);
		$data['organizacion'] = $organizacion;
		$data['departamentos'] = $this->DepartamentosModel->getDepartamentos();
		$this->load->view('include/header/main', $data);
		$this->load->view('user/modules/informe-actividades/index', $data);
		$this->load->view('include/footer/main', $data);
	}
	/**
	 * Crear Informe Actividades
	 */
	public function create()
	{
		// Traer datos organización
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		//die(var_dump($_POST));
		// Capturar datos de formulario
		$data_curso = array(
			"fechaInicio" => $this->input->post("informe_fecha_incio"),
			"fechaFin" => $this->input->post("informe_fecha_fin"),
			"departamento" => $this->input->post("informe_departamento_curso"),
			"municipio" => $this->input->post("informe_municipio_curso"),
			"duracion" => $this->input->post("informe_duracion_curso"),
			"intencionalidad" => json_encode($this->input->post("informe_intencionalidad_curso")),
			"cursos" => json_encode($this->input->post("informe_cursos")),
			"modalidades" => json_encode($this->input->post("informe_modalidad")),
			"totalAsistentes" => $this->input->post("informe_asistentes"),
			"mujeres" => $this->input->post("informe_numero_mujeres"),
			"hombres" => $this->input->post("informe_numero_hombres"),
			"noBinario" => $this->input->post("informe_numero_no_binario"),
			"created_at" => date('Y-m-d H:i:s'),
			"docentes_id_docente" => $this->input->post("informe_docente"),
			"organizaciones_id_organizacion" => $organizacion->id_organizacion
		);
		// Insertar datos de curso dictado
		if ($this->db->insert('informeActividades', $data_curso)) {
			$data_status = [
				"descripcion" => "Estado actualizado a creado",
				"estado" => "Creado",
				"changed_at" => date('Y-m-d H:i:s'),
				"changed_by" => $this->session->userdata('usuario_id'),
				"informeActividades_id_informeActividades" => intval($this->cargarUltimoInformeActividadArray()->id_informeActividades),
			];
			$this->update_status($data_status);
			echo json_encode(array('title' =>'Guardado exitoso!', "msg" => "El curso se ha registrado exitosamente.", 'status' => 'success'));
			$this->logs_sia->session_log('Informe de actividad');
			$this->notif_sia->notification('Informe', 'admin', $organizacion->nombreOrganizacion);
		}
	}
	/**
	 * Actualizar estado informe
	 */
	public function update_status($data_status) {
		$informe = $this->InformeActividadesModel->getInformeActividad((int)$data_status['informeActividades_id_informeActividades']);
		if ($informe) {
			$valid_statuses = array('Creado', 'Enviado', 'Observaciones', 'Aprobado');
			if (in_array($data_status['estado'], $valid_statuses)) {
				$this->InformeActividadesModel->updateEstadoInformeActividad(intval($informe->id_informeActividades), $data_status);
			}
		}
	}
	/**
	 * Cargar archivo asistentes pdf
	 */
	public function archivoAsistencia()
	{
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		$append_name = $this->input->post('append_name');
		$name_random = random(10);
		$name =  $append_name . "_" . $name_random . "_" . $_FILES['file']['name'];
		$tipo_archivo = pathinfo($name, PATHINFO_EXTENSION);
		$ruta = 'uploads/asistentes/';
		$size = 60000000;
		if (0 < $_FILES['file']['error']) {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "Hubo un error al actualizar, intente de nuevo."));
		} else if ($_FILES['file']['size'] > $size) {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "El tamaño supera las 50 Mb, intente con otro pdf."));
		} else if ($tipo_archivo != "pdf") {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "La extensión de la imagen no es correcta, debe ser PDF"));
		} else if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta . $name)) {
			$id_curso = $this->db->select_max("id_informeActividades")->from("informeActividades")->where("organizaciones_id_organizacion", $organizacion->id_organizacion)->get()->row()->id_informeActividades;
			$data_insert = array('archivoAsistencia' => $name);
			$this->db->where('id_informeActividades', $id_curso);
			if ($this->db->update('informeActividades', $data_insert)) {
				echo json_encode(array('title' =>'Archivo asistencia cargado','status' =>'success','msg' => "Se ingreso la asistencia."));
				$this->logs_sia->session_log('Ingreso de archivo de asistencia curso');
			}
		}
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	/**
	 * Cargar datos ultimo informe de actividades registrado
	 */
	public function cargarUltimoInformeActividadArray(){
		$informe = $this->InformeActividadesModel->getInformeActividad();
		return $informe;
	}
	/**
	 * Verificar si los asistentes están completos antes del envío
	 */
	public function verificarAsistentes() {
		$id = $this->input->post('id');
		$curso = $this->InformeActividadesModel->getInformeActividad((int)$id);
		$asistentes_registrados = count($this->AsistentesModel->getAsistentesCurso((int)$id));
		$response = [
			'total_reportado' => $curso->totalAsistentes,
			'total_registrado' => $asistentes_registrados,
			'faltantes' => $curso->totalAsistentes - $asistentes_registrados,
			'asistentes_completos' => ($asistentes_registrados == $curso->totalAsistentes)
		];
		echo json_encode($response);
	}
	/**
	 * Enviar informe de actividades
	 */
	public function send(){
		$id = $this->input->post('id');
		// Insertar datos de curso dictado
		$curso = $this->InformeActividadesModel->getInformeActividad((int)$this->input->post("id"));
		$asistentes = count($this->AsistentesModel->getAsistentesCurso((int)$this->input->post("id")));
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		// Comprobar si ya los registros de asistentes están completos
		if ($asistentes == $curso->totalAsistentes) {
			$data_status = [
				"descripcion" => "Estado actualizado a enviado",
				"estado" => "Enviado",
				"changed_at" => date('Y-m-d H:i:s'),
				"changed_by" => $this->session->userdata('usuario_id'),
				"informeActividades_id_informeActividades" => intval($curso->id_informeActividades),
			];
			$this->update_status($data_status);
			send_email_admin('enviarInforme', 1, CORREO_SIA, null, $organizacion, $curso->id_informeActividades);
			echo json_encode(array('title' => "Informe Enviado", 'status' => 'success', 'msg' => "El informe se ha enviado exitosamente.<br> Se le informará cuando sea aprobado o tenga alguna observación por corregir <br><br>Gracias por su participación"));
		}
		else {
			echo json_encode(array('title' => "Error al enviar", 'status' => 'warning', 'msg' => "Número de asistentes registrados incompletos. <br><br><strong>Asistentes reportados:</strong> " . $curso->totalAsistentes . "<br><strong>Registrados en el sistema: </strong>" . $asistentes . '<br><br> Por favor registra el numero de asistentes faltantes y vuelve a intentar'));
		}
	}
	/**
	 * Actualizar datos informe de actividades
	 */
	public function update(){
		$id = $this->input->post('id_adm');
		$pass = $this->input->post('super_contrasena_admin');
		$password_rdel = mc_encrypt($pass, KEY_RDEL);
		$password_hash = generate_hash($pass);
		$administrador = $this->AdministradoresModel->getAdministradores($id);
		if($administrador->logged_in == 1){
			echo json_encode(array("msg" => "El administador esta en linea."));
		}else{
			$data_admin = array(
				'primerNombreAdministrador' => $this->input->post('super_primernombre_admin'),
				'segundoNombreAdministrador' => $this->input->post('super_segundonombre_admin'),
				'primerApellidoAdministrador' => $this->input->post('super_primerapellido_admin'),
				'segundoApellidoAdministrador' => $this->input->post('super_segundoapellido_admin'),
				'numCedulaCiudadaniaAdministrador' =>  $this->input->post('super_numerocedula_admin'),
				'ext' =>  $this->input->post('super_ext_admin'),
				'direccionCorreoElectronico' => $this->input->post('super_correo_electronico_admin'),
				'user' => $this->input->post('super_nombre_admin'),
				'contrasena' => $password_hash,
				'contrasena_rdel' => $password_rdel,
				'nivel' => $this->input->post('super_acceso_nvl')
			);
			$this->db->where('id_administrador', $id);
			if($this->db->update('administradores', $data_admin)){
				echo json_encode(array("msg" => "El administador ha sido actualizado."));
			}
		}
	}
	/**
	 * Eliminar informe de actividades
	 */
	public function delete(){
		$id = $this->input->post('id');
		$informe = $this->InformeActividadesModel->getInformeActividad($id);
		// Eliminar archivos cargados
		$ruta = 'uploads/asistentes/';
		unlink($ruta . $informe->archivoAsistentes);
		unlink($ruta . $informe->archivoAsistencia);
		$this->db->where('informeActividades_id_informeActividades', $id);
		if ($this->db->delete('asistentes')) {
			$this->db->where('informeActividades_id_informeActividades', $id);
			if ($this->db->delete('historico_estado_informe')) {
				$this->db->where('informeActividades_id_informeActividades', $id);
				if ($this->db->delete('observaciones_informe')) {
					$this->db->where('id_informeActividades', $id);
					if ($this->db->delete('informeActividades')) {
						echo json_encode(array("title" => "Informe eliminado", "status" => "success", "msg" => "Se ha eliminado informe de manera correcta"));
					}
					else {
						echo json_encode(array("title" => "Error", "status" => "error", "msg" => "No se ha eliminado informe de manera correcta"));
					}
				}
				else {
					echo json_encode(array("title" => "Error", "status" => "error", "msg" => "No se ha eliminado informe de manera correcta"));
				}
			}
			else {
				echo json_encode(array("title" => "Error", "status" => "error", "msg" => "No se ha eliminado informe de manera correcta"));
			}
		}
		else {
			echo json_encode(array("title" => "Error","status" => "error", "msg" => "No se ha eliminado informe de manera correcta"));
		}
	}
	/**
	 * Ajax: Cargar datos ultimo informe de actividades registrado
	 */
	public function cargarUltimoInformeActividad(){
		$informe = $this->InformeActividadesModel->getInformeActividad();
		echo json_encode($informe);
	}
	/**
	 * Ajax: Cargar datos informe de actividades
	 */
	public function cargarInformeActividad(){
		$informe = $this->InformeActividadesModel->getInformeActividad($this->input->post('id'));
		echo json_encode($informe);
	}
	/**
	 * Ajax: Cargar datos observación informe de actividades
	 */
	public function cargarObservacionesInforme(){
		$observaciones = $this->ObservacionesInformeModel->getObservacionesInforme($this->input->post('id'));
		echo json_encode($observaciones);
	}
	/**
	 * Acciones Administrador
	 */
	// Ver informes de actividades enviados a la unidad
	public function enviados()
	{
		$data = $this->dataSessionUsuario();
		$data['title'] = 'Panel Principal - Informe de Actividades';
		$data['informes'] = $this->InformeActividadesModel->getInformeActividadesEnviadas();
		$this->load->view('include/header/main', $data);
		$this->load->view('admin/informeActividades/index', $data);
		$this->load->view('include/footer/main', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Aprobar informe de actividades
	public function approved(){
		$id = $this->input->post('id');
		// Insertar datos de curso dictado
		$curso = $this->InformeActividadesModel->getInformeActividad((int)$this->input->post("id"));
		$organizacion = $this->OrganizacionesModel->getOrganizacion($curso->organizaciones_id_organizacion);
		// Capturar datos para actualización de estado informe
		$data_status = [
			"descripcion" => "Estado actualizado a aprobado",
			"estado" => "Aprobado",
			"changed_at" => date('Y-m-d H:i:s'),
			"changed_by" => $this->session->userdata('usuario_id'),
			"informeActividades_id_informeActividades" => intval($curso->id_informeActividades),
		];
		$this->update_status($data_status);
		send_email_user($organizacion->direccionCorreoElectronicoOrganizacion,'informeAprobado', $organizacion,null, null, $curso->id_informeActividades);
	}
	// Aprobar informe de actividades
	public function crearObservacion(){
		$id = $this->input->post('id');
		// Insertar datos de curso dictado
		$curso = $this->InformeActividadesModel->getInformeActividad((int)$this->input->post("id"));
		$organizacion = $this->OrganizacionesModel->getOrganizacion($curso->organizaciones_id_organizacion);
		$data = [
			"descripcion" => $this->input->post('descripcion'),
			"created_at" => date('Y-m-d H:i:s'),
			"administradores_id_administrador" => $this->session->userdata('usuario_id'),
			"informeActividades_id_informeActividades" => intval($curso->id_informeActividades),
		];
		if ($this->db->insert('observaciones_informe', $data)) {
			// Capturar datos para actualización de estado informe
			$data_status = [
				"descripcion" => "Estado actualizado a observaciones",
				"estado" => "Observaciones",
				"changed_at" => date('Y-m-d H:i:s'),
				"changed_by" => $this->session->userdata('usuario_id'),
				"informeActividades_id_informeActividades" => intval($curso->id_informeActividades),
			];
			$this->update_status($data_status);
			send_email_user($organizacion->direccionCorreoElectronicoOrganizacion,'observacionesInforme', $organizacion,null, null, $curso->id_informeActividades);
		}
	}
}


