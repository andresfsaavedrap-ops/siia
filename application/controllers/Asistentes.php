<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Asistentes extends CI_Controller
{
	/**
	 * Iniciar modelos y helpers
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('AdministradoresModel');
		$this->load->model('InformeActividadesModel');
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
	/**
	 * Index | Tabla de asistentes general | Administrador
	 */
	public function index()
	{
		$data = $this->dataSessionUsuario();
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($data['usuario_id']);
		$data['title'] = 'Panel Principal - Asistentes';
		$data['asistentes'] = $this->AsistentesModel->getAsistentes();
		$data['departamentos'] = $this->DepartamentosModel->getDepartamentos();
		$this->load->view('include/header/main', $data);
		$this->load->view('paneles/InformeActividades/index', $data);
		$this->load->view('include/footer/main', $data);
	}
	/**
	 * Crear asistente
	 */
	public function create()
	{
		// Capturar datos de formulario
		$data = array(
			"primerApellidoAsistente" => $this->input->post("primerApellidoAsistente"),
			"segundoApellidoAsistente" => $this->input->post("segundoApellidoAsistente"),
			"primerNombreAsistente" => $this->input->post("primerNombreAsistente"),
			"segundoNombreAsistente" => $this->input->post("segundoNombreAsistente"),
			"numeroDocumentoAsistente" => $this->input->post("numeroDocumentoAsistente"),
			"numNITOrganizacion" => $this->input->post("numNITOrganizacion"),
			"nombreOrganizacion" => $this->input->post("nombreOrganizacion"),
			"departamentoResidencia" => $this->input->post("departamentoResidencia"),
			"municipioResidencia" => $this->input->post("municipioResidencia"),
			"telefono" => $this->input->post("telefono"),
			"correoElectronico" => $this->input->post("correoElectronico"),
			"edad" => $this->input->post("edad"),
			"genero" => $this->input->post("genero"),
			"escolaridad" => $this->input->post("escolaridad"),
			"enfoqueDiferencial" => $this->input->post("enfoqueDiferencial"),
			"condicionVulnerabilidad" => $this->input->post("condicionVulnerabilidad"),
			"discapacidad" => $this->input->post("discapacidad"),
			"informeActividades_id_informeActividades" => $this->input->post("id_informe"),
		);
		// Insertar datos de curso dictado
		$curso = $this->InformeActividadesModel->getInformeActividad((int)$this->input->post("id_informe"));
		$asistentes = count($this->AsistentesModel->getAsistentesCurso((int)$this->input->post("id_informe")));
		// Comprobar si ya los registros de asistentes están completos
		if ($asistentes == $curso->totalAsistentes) {
			echo json_encode(array('title' => "Error al guardar", 'status' => 'info', 'msg' => "Número de asistentes registrados completos. <br><br><strong>Asistentes reportados:</strong> " . $curso->totalAsistentes . "<br><strong>Registrados en el sistema: </strong>" . $asistentes));
		}
		else {
			if ($this->db->insert('asistentes', $data)) {
				echo json_encode(array('title' =>'Guardado exitoso!','status' => 'success', "msg" => "El asistente se registro con éxito." ));
				$this->logs_sia->session_log('Guardar asistentes');
				//$this->notif_sia->notification('Registro asistentes', 'admin', $organizacion->nombreOrganizacion);
			}
		}
	}
	/**
	 * Cargar datos asistente
	 */
	public function cargarDatosAsistente(){
		$asistente = $this->AsistentesModel->getAsistente($this->input->post('id'));
		echo json_encode($asistente);
	}
	/**
	 * Actualizar datos asistentes
	 */
	public function update(){
		$asistente = $this->AsistentesModel->getAsistente($this->input->post('id_asistente'));
		// Capturar datos de formulario
		$data = array(
			"primerApellidoAsistente" => $this->input->post("primerApellidoAsistente"),
			"segundoApellidoAsistente" => $this->input->post("segundoApellidoAsistente"),
			"primerNombreAsistente" => $this->input->post("primerNombreAsistente"),
			"segundoNombreAsistente" => $this->input->post("segundoNombreAsistente"),
			"numeroDocumentoAsistente" => $this->input->post("numeroDocumentoAsistente"),
			"numNITOrganizacion" => $this->input->post("numNITOrganizacion"),
			"nombreOrganizacion" => $this->input->post("nombreOrganizacion"),
			"departamentoResidencia" => $this->input->post("departamentoResidencia"),
			"municipioResidencia" => $this->input->post("municipioResidencia"),
			"telefono" => $this->input->post("telefono"),
			"correoElectronico" => $this->input->post("correoElectronico"),
			"edad" => $this->input->post("edad"),
			"genero" => $this->input->post("genero"),
			"escolaridad" => $this->input->post("escolaridad"),
			"enfoqueDiferencial" => $this->input->post("enfoqueDiferencial"),
			"condicionVulnerabilidad" => $this->input->post("condicionVulnerabilidad"),
			"discapacidad" => $this->input->post("discapacidad"),
			"informeActividades_id_informeActividades" => $this->input->post("id_informe"),
		);
		// Actualizar datos asistente
		$this->db->where('id_asistentes', $asistente->id_asistentes);
		if($this->db->update('asistentes', $data)){
			echo json_encode(array('title' =>'Guardado exitoso!','status' => 'success', "msg" => "El asistente se actualizo con éxito." ));
			$this->logs_sia->session_log('Actualizar asistentes');
			//$this->notif_sia->notification('Registro asistentes', 'admin', $organizacion->nombreOrganizacion);
		}
	}
	/**
	 * Eliminar asistente
	 */
	public function delete(){
		$id = $this->input->post('id');
		$asistente = $this->AsistentesModel->getAsistente($id);
		$this->db->where('id_asistentes', $id);
		if ($this->db->delete('asistentes')) {
			echo json_encode(array("title" => "Asistente eliminado","status" => "success", "msg" => "Se ha eliminado asistente al curso de manera correcta"));
		}
		else {
			echo json_encode(array("title" => "Error","status" => "error", "msg" => "No se ha eliminado informe de manera correcta"));
		}
	}
	/**
	 * Cargar asistentes por curso
	 */
	public function curso($curso)
	{
		$data = $this->dataSessionUsuario();
		$data['title'] = 'Panel Principal - Asistentes curso';
		$data['asistentes'] = $this->AsistentesModel->getAsistentesCurso($curso);
		$data['curso'] = $this->InformeActividadesModel->getInformeActividad($curso);
		$data['departamentos'] = $this->DepartamentosModel->getDepartamentos();
		$this->load->view('include/header/main', $data);
		$this->load->view('user/modules/informe-actividades/asistentes', $data);
		$this->load->view('include/footer/main', $data);
	}
	/**
	 * Cargar archivo masivo excel
	 */
	public function excelAsistentes()
	{
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
		$append_name = $this->input->post('append_name');
		$name_random = random(10);
		$name =  $append_name . "_" . $name_random . "_" . $_FILES['file']['name'];
		$tipo_archivo = pathinfo($name, PATHINFO_EXTENSION);
		$this->load->library('PHPExcel'); // Load PHPExcel library
		$ruta = 'uploads/asistentes/';
		$size = 60000000;
		if (0 < $_FILES['file']['error']) {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "Hubo un error al actualizar, intente de nuevo."));
		} else if ($_FILES['file']['size'] > $size) {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "El tamaño supera las 60 Mb, intente con otro archivo xlsx."));
		} else if ($tipo_archivo != "xlsx") {
			echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "La extensión del archivo no es correcta, debe ser xlsx. (archivo.xlsx)"));
		} else if (1 == 1) {
			$fileName = $ruta . $name;
			$curso = $this->InformeActividadesModel->getInformeActividad((int)$this->input->post('curso_id'));
			$asistentes = count($this->AsistentesModel->getAsistentesCurso((int)$this->input->post('curso_id')));
			if (move_uploaded_file($_FILES['file']['tmp_name'], $fileName)) {
				$excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);
				$excelObj = $excelReader->load($fileName);
				$worksheet = $excelObj->getSheet(0);
				$lastRow = $worksheet->getHighestRow();
				$registrosReales = $lastRow - 4;
				// Recorrer excel y capturar data para guardar
				$data = array();
				// Comprobar si ya los registros de asistentes están completos
				if ($asistentes == $curso->totalAsistentes) {
					echo json_encode(array('title' => "No se cargo el archivo", 'status' => 'warning', 'msg' => "Número de asistentes registrados completos. <br><br><strong>Asistentes reportados:</strong> " . $curso->totalAsistentes . "<br><strong>Registrados en el sistema: </strong>" . $asistentes));
				}
				// Si se han registrado o borrado registros
				else if ($asistentes > 0) {
					echo json_encode(array('title' => "No se cargo el archivo", 'status' => 'warning', 'msg' => "Registros manuales detectados, por favor elimine todos los registros manuales para usar esta opción. <br><br><strong>Registrados en el sistema de manera manual: </strong>" . $asistentes));
				}
				// Cumple los requisitos para usar la funcionalidad
				else if ($registrosReales == $curso->totalAsistentes) {
					for ($row = 5; $row <= $lastRow; $row++) {
						$data[] = [
							'primerApellidoAsistente' => $worksheet->getCell('A' . $row)->getValue(),
							'segundoApellidoAsistente' => $worksheet->getCell('B' . $row)->getValue(),
							'primerNombreAsistente' => $worksheet->getCell('C' . $row)->getValue(),
							'segundoNombreAsistente' => $worksheet->getCell('D' . $row)->getValue(),
							'numeroDocumentoAsistente' => $worksheet->getCell('E' . $row)->getValue(),
							'numNITOrganizacion' => $worksheet->getCell('F' . $row)->getValue(),
							'nombreOrganizacion' => $worksheet->getCell('G' . $row)->getValue(),
							'departamentoResidencia' => $worksheet->getCell('H' . $row)->getValue(),
							'municipioResidencia' => $worksheet->getCell('I' . $row)->getValue(),
							'telefono' => $worksheet->getCell('J' . $row)->getValue(),
							'correoElectronico' => $worksheet->getCell('K' . $row)->getValue(),
							'edad' => $worksheet->getCell('L' . $row)->getValue(),
							'genero' => $worksheet->getCell('M' . $row)->getValue(),
							'escolaridad' => $worksheet->getCell('N' . $row)->getValue(),
							'enfoqueDiferencial' => $worksheet->getCell('O' . $row)->getValue(),
							'condicionVulnerabilidad' => $worksheet->getCell('P' . $row)->getValue(),
							'discapacidad' => $worksheet->getCell('Q' . $row)->getValue(),
							'informeActividades_id_informeActividades' => $curso->id_informeActividades,
						];
					}
					// Eliminar archivo anterior cargado
					if($curso->archivoAsistentes != null)
						unlink($ruta . $curso->archivoAsistentes);
					// Actualizar dato de archivo en informe de actividades
					$data_archivoAsistentes = ['archivoAsistentes' => $name];
					$this->db->where('id_informeActividades', $curso->id_informeActividades);
					if ($this->db->update('informeActividades', $data_archivoAsistentes)) {
						// Insertar datos a tabla de asistentes
						foreach ($data as $row) {
							$this->db->insert('asistentes', $row);
						}
						echo json_encode(array('title' => 'Archivos cargados','status' => "success", 'msg' => "Se guardaron los asistentes del curso."));
						//unlink('././uploads/excel/'.$file_name); //File Deleted After uploading in database .
					} else {
						echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "No se actualizo la tabla."));
					}
				}
				// Si no coinciden los registros del excel con lo reportado
				else {
					echo json_encode(array('title' => "No se cargo el archivo", 'status' => 'warning', 'msg' => "Número de asistentes no coincide con lo registrado en el curso. <br><br><strong>Asistentes reportados:</strong> " . $curso->totalAsistentes . "<br><strong>Registrados en el excel: </strong>" . $registrosReales));
				}
			} else {
				echo json_encode(array('title' => "Error", 'status' => 'error', 'msg' => "No se guardo el archivo(s)."));
			}
		}
	}

}

