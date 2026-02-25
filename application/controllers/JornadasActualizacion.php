<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JornadasActualizacion extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('JornadasActualizacionModel');
	}
	/**
	 * Guardar datos jornadas de actualización
	 */
	public function create()
	{
		// Traer datos organizaciones
		$usuario_id = $this->session->userdata('usuario_id');
		$organizacion = $this->db->select("*")->from("organizaciones")->where("usuarios_id_usuario", $usuario_id)->get()->row();
		// Capturar datos de archivo
		$file = $_FILES['file'];
		$metadata = array(
			'tipo' => $this->input->post('tipoArchivo'),
			'nombre' => $this->input->post('append_name') . "_" . random(10) . "_" . $file['name'],
			'id_formulario' => 3,
			'id_registro' => $this->input->post('idSolicitud'),
			'organizaciones_id_organizacion' => $organizacion->id_organizacion,
			'fechaCreacion' => date('Y/m/d H:i:s')
		);
		// Crear y cargar archivo
		$fileCreated = create_file($file, $metadata);
		// Comprobar si el archivo se cargó correctamente
		if ($fileCreated['success'] == true):
			// Comprobar si se traen datos por post
			if ($this->input->post()) {
				// Datos de creación de la jornada.
				$datos = array(
					'asistio' => $this->input->post('asistio'),
					'fechaAsistencia' => $this->input->post('fechaAsistencia') ? $this->input->post('fechaAsistencia') : date('Y/m/d H:i:s'),
					'organizaciones_id_organizacion' => $organizacion->id_organizacion,
					'idSolicitud' => $this->input->post('idSolicitud')
				);
				if ($this->db->insert('jornadasActualizacion', $datos)):
					echo json_encode(array('title' => 'Registro guardado!', "msg" => "Se guardo formulario 4: Jornada de actualización.", "status" => "success"));
				else:
					echo json_encode(array('title' => 'Error al guardar',"msg" => "No se guardo la Jornada de actualización.", "status" => "error"));
				endif;
				$this->logs_sia->session_log("Formulario Jornadas Actualización");
				$this->logs_sia->logQueries();
			} else {
				echo json_encode(array('title' => 'Error al guardar',"msg" => "Verifique los datos ingresado, no son correctos.", "status" => "error"));
			}
		else:
			echo json_encode(array('title' => 'Error al guardar', "msg" => $fileCreated, "status" => "error",));
		endif;
	}
	/**
	 * Eliminar datos jornadas actualización
	 */
	public function delete(){
		$id = $this->input->post('id_jornada');
		$this->db->where('idSolicitud', $id);
		if($this->db->delete('jornadasActualizacion'))
			delete_file($this->input->post('tipo'), $this->input->post('nombre'), $this->input->post('id_archivo'), $this->input->post('id_formulario'));
	}
}
