<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DocumentacionLegal extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('InformacionGeneralModel');
		$this->load->helper('files'); // Cargar el helper de archivos
		verify_session();
	}
	// Crear documentación legal
	public function create()
	{
		$tipoForm = $this->input->post('tipo');
		$organizacion = $this->db->select("*")->from("organizaciones")->where("usuarios_id_usuario", $this->session->userdata('usuario_id'))->get()->row();
		switch ($tipoForm) {
			case 1:
				$data = array(
					'tipo' => $this->input->post('tipo'),
					'organizaciones_id_organizacion' => $organizacion->id_organizacion,
					'idSolicitud' => $this->input->post('idSolicitud')
				);
				if ($this->db->insert('documentacion', $data)):
					echo json_encode(array('title' => 'Guardo exitoso!', 'status' => "success", 'msg' => "Datos de camara de comercio guardados"));
				else:
					echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => "Verifique los datos ingresado, no son correctos."));
				endif;
				break;
			case 2:
				$this->_procesarCertificadoExistencia($organizacion);
				break;
			case 3:
				$this->_procesarRegistroEducativo($organizacion);
				break;
			default:
				break;
		}
	}
	/**
	 * Procesar certificado de existencia
	 */
	private function _procesarCertificadoExistencia($organizacion)
	{
		// Validar fecha de expedición
		$date = date('Y-m-d');
		$dateExp = strtotime('-1 month', strtotime($date));
		$dateExp = date('Y-m-d', $dateExp);
		if ($this->input->post('fechaExpedicion') > $date || $this->input->post('fechaExpedicion') < $dateExp) {
			echo json_encode(array('status' => "info", 'msg' => "La fecha de expedición no es correcta, el certificado debe ser de los últimos 30 días."));
			return;
		}
		// Procesar archivo PRIMERO
		$name_random = random(10);
		$nombreArchivo = $this->input->post('append_name') . "_" . $name_random . "_" . $_FILES['file']['name'];
		$dataArchivo = array(
			'tipo' => 'certificadoExistencia',
			'nombre' => $nombreArchivo,
			'id_formulario' => 2,
			'id_registro' => $this->input->post('idSolicitud'),
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
		);
		// Usar el helper para guardar el archivo
		$resultadoArchivo = create_file($_FILES['file'], $dataArchivo);
		if ($resultadoArchivo['success'] !== true) {
			echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => $resultadoArchivo['message']));
			return;
		}
		// Solo si el archivo se guardó exitosamente, proceder con BD
		$dataDocumentacion = array(
			'tipo' => $this->input->post('tipo'),
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
			'idSolicitud' => $this->input->post('idSolicitud')
		);
		if ($this->db->insert('documentacion', $dataDocumentacion)) {
			$dataCertificadoExistencia = array(
				'entidad' => $this->input->post('entidadCertificadoExistencia'),
				'fechaExpedicion' => $this->input->post('fechaExpedicion'),
				'departamento' => $this->input->post('departamentoCertificado'),
				'municipio' => $this->input->post('municipioCertificado'),
				'organizaciones_id_organizacion' => $organizacion->id_organizacion,
				'idSolicitud' => $this->input->post('idSolicitud')
			);
			if ($this->db->insert('certificadoExistencia', $dataCertificadoExistencia)) {
				$registro = $this->db->select('*')->from('certificadoExistencia')->where('idSolicitud', $this->input->post('idSolicitud'))->get()->row();
				// Actualizar el registro del archivo con el ID correcto
				$this->db->where('nombre', $nombreArchivo)->update('archivos', array('id_registro' => $registro->id_certificadoExistencia));
				echo json_encode(array('title' => 'Guardo exitoso!', 'status' => "success", 'msg' => "Se guardo el " . $this->input->post('append_name')));
				$this->logs_sia->logs('URL_TYPE');
				$this->logs_sia->logQueries();
			} else {
				// Si falla la inserción, eliminar el archivo guardado
				$this->_eliminarArchivo($nombreArchivo);
				echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => "Error al guardar los datos del certificado."));
			}
		} else {
			// Si falla la inserción, eliminar el archivo guardado
			$this->_eliminarArchivo($nombreArchivo);
			echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => "Verifique los datos ingresado, no son correctos."));
		}
	}
	/**
	 * Procesar registro educativo
	 */
	private function _procesarRegistroEducativo($organizacion) 
	{
		// Procesar archivo PRIMERO
		$name_random = random(10);
		$nombreArchivo = $this->input->post('append_name') . "_" . $name_random . "_" . $_FILES['file']['name'];
		$dataArchivo = array(
			'tipo' => 'registroEdu',
			'nombre' => $nombreArchivo,
			'id_formulario' => 2,
			'id_registro' => $this->input->post('idSolicitud'),
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
		);
		// Usar el helper para guardar el archivo
		$resultadoArchivo = create_file($_FILES['file'], $dataArchivo);
		if ($resultadoArchivo['success'] !== true) {
			echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => $resultadoArchivo));
			return;
		}
		// Solo si el archivo se guardó exitosamente, proceder con BD
		$dataDocumentacion = array(
			'tipo' => $this->input->post('tipo'),
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
			'idSolicitud' => $this->input->post('idSolicitud')
		);
		if ($this->db->insert('documentacion', $dataDocumentacion)) {
			$dataRegistro = array(
				'tipoEducacion' => $this->input->post('tipoEducacion'),
				'fechaResolucion' => $this->input->post('fechaResolucionProgramas'),
				'numeroResolucion' => $this->input->post('numeroResolucionProgramas'),
				'nombrePrograma' => $this->input->post('nombrePrograma'),
				'objetoResolucion' => $this->input->post('objetoResolucionProgramas'),
				'entidadResolucion' => $this->input->post('entidadResolucion'),
				'organizaciones_id_organizacion' => $organizacion->id_organizacion,
				'idSolicitud' => $this->input->post('idSolicitud')
			);
			if ($this->db->insert('registroEducativoProgramas', $dataRegistro)) {
				$registro = $this->db->select('*')->from('registroEducativoProgramas')->where('numeroResolucion', $this->input->post('numeroResolucionProgramas'))->get()->row();
				// Actualizar el registro del archivo con el ID correcto
				$this->db->where('nombre', $nombreArchivo)->update('archivos', array('id_registro' => $registro->id_registroEducativoPro));
				echo json_encode(array('title' => 'Guardo exitoso!', 'status' => "success", 'msg' => "Se guardo el " . $this->input->post('append_name')));
				$this->logs_sia->logs('URL_TYPE');
				$this->logs_sia->logQueries();
			} else {
				// Si falla la inserción, eliminar el archivo guardado
				$this->_eliminarArchivo($nombreArchivo);
				echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => "Error al guardar los datos del registro educativo."));
			}
		} else {
			// Si falla la inserción, eliminar el archivo guardado
			$this->_eliminarArchivo($nombreArchivo);
			echo json_encode(array('title' => 'Error al guardar!', 'status' => "error", 'msg' => "Verifique los datos ingresado, no son correctos."));
		}
	}
	/**
	 * Método para eliminar archivo y registro en caso de error
	 */
	private function _eliminarArchivo($nombreArchivo) 
	{
		// Eliminar registro de la tabla archivos
		$this->db->where('nombre', $nombreArchivo)->delete('archivos');
		// Eliminar archivo físico
		$archivo = $this->db->select('*')->from('archivos')->where('nombre', $nombreArchivo)->get()->row();
		if ($archivo) {
			$ruta = '';
			switch ($archivo->tipo) {
				case 'certificadoExistencia':
					$ruta = "assets/docs/certificados/" . $nombreArchivo;
					break;
				case 'registroEdu':
					$ruta = "assets/docs/registros/" . $nombreArchivo;
					break;
			}
			if (file_exists($ruta)) {
				unlink($ruta);
			}
		}
	}
	// Eliminar documentación legal
	public function delete()
	{
		$archivo = $this->db->select('*')->from('archivos')->where('id_registro', $this->input->post('id'))->get()->row();
		$this->db->where('id_archivo', $archivo->id_archivo);
		if ($this->db->delete('archivos')) {
			unlink($this->input->post('ruta') . $archivo->nombre);
			switch ($this->input->post('tipo')) {
				case 2:
					$documentacion = $this->db->select('*')->from('documentacion')->where('id_tipoDocumentacion', $this->input->post('id'))->get()->row();
					$this->db->where('id_tipoDocumentacion', $documentacion->id_tipoDocumentacion);
					if ($this->db->delete('documentacion')) {
						echo json_encode(array('title' => "Eliminación exitosa!", 'status' => 'success','msg' => "Se eliminaron los datos de camara de comercio."));
					} else {
						echo json_encode(array('title' => "Error al eliminar", 'status' => 'error', 'msg' => "No se eliminaron los datos de camara de comercio."));
					}
					break;
				case 2.1:
					$certificadoExistencia = $this->db->select('*')->from('certificadoExistencia')->where('id_certificadoExistencia', $this->input->post('id'))->get()->row();
					$documentacion = $this->db->select('*')->from('documentacion')->where('idSolicitud', $certificadoExistencia->idSolicitud)->get()->row();
					$this->db->where('id_tipoDocumentacion', $documentacion->id_tipoDocumentacion);
					if ($this->db->delete('documentacion')) {
						$this->db->where('id_certificadoExistencia', $certificadoExistencia->id_certificadoExistencia);
						if ($this->db->delete('certificadoExistencia')) {
							echo json_encode(array('title' => "Eliminación exitosa!", 'status' => 'success', 'msg' => "Se eliminaron los datos del certificado existencia."));
						} else {
							echo json_encode(array('title' => "Error al eliminar", 'status' => 'error', 'msg' => "No se eliminaron los datos del certificado existencia."));
						}
					} else {
						echo json_encode(array('title' => "Error al eliminar", 'status' => 'error',  'msg' => "No se eliminaron los datos de la documentación legal."));
					}
					break;
				case 2.2:
					$registroEducativo = $this->db->select('*')->from('registroEducativoProgramas')->where('id_registroEducativoPro', $this->input->post('id'))->get()->row();
					$documentacion = $this->db->select('*')->from('documentacion')->where('idSolicitud', $registroEducativo->idSolicitud)->get()->row();
					$this->db->where('id_tipoDocumentacion', $documentacion->id_tipoDocumentacion);
					if ($this->db->delete('documentacion')) {
						$this->db->where('id_registroEducativoPro', $registroEducativo->id_registroEducativoPro);
						if ($this->db->delete('registroEducativoProgramas')) {
							echo json_encode(array('title' => "Eliminación exitosa!", 'status' => 'success', 'msg' => "Se eliminaron los datos del registro educativo."));
						} else {
							echo json_encode(array('title' => "Error al eliminar", 'status' => 'error',  'msg' => "No se eliminaron los datos del registro educativo."));
						}
					} else {
						echo json_encode(array('title' => "Error al eliminar", 'status' => 'error',  'msg' => "No se eliminaron los datos de la documentación legal."));
					}
					break;
				default:
			}
		} else {
			echo json_encode(array('title' => "Error al eliminar", 'status' => 'error',  'msg' => "No se eliminaron los archivos, vuelve a intentar o comunicate con el administrador."));
		}
	}
}
?>
