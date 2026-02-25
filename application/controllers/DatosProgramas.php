<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DatosProgramas extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('OrganizacionesModel');
		$this->load->model('DatosProgramasModel');
		verify_session();
	}
	// Formulario 4
	public function create()
	{
		if ($this->input->post()) {
			$data_Programas = $this->DatosProgramasModel->GetDatosProgramas($this->input->post('idSolicitud'));
			$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('organizacion'));
			$data = array(
				'nombrePrograma' => $this->input->post('programa'),
				'aceptarPrograma' => "Si Acepta",
				'fecha' => date("Y/m/d H:i:s"),
				'organizaciones_id_organizacion' => $this->input->post('organizacion'),
				'idSolicitud' => $this->input->post('idSolicitud'),
			);
			/** Comprobar si el programa ya se encuentra aceptado */
			$programas = array();
			foreach ($data_Programas as $programa) {
				array_push($programas, $programa->nombrePrograma);
			}
			$programaIngresado = $this->input->post('programa');
			if (in_array($programaIngresado, $programas)) {
				echo json_encode(array('title' => 'No se guardo','status' => "warning", 'msg' => "Programa: " . $programaIngresado .  " ya registrado."));
			}
			else {
				if ($this->db->insert('datosProgramas', $data)){
					$this->logs_sia->session_log('Formulario 4: Aceptación de programa' . $programaIngresado);
					$this->logs_sia->logQueries();
					$this->enviomail_aceptar_programas($organizacion, $data);
				}
				else {
					echo json_encode(array('title' => 'Error al guardar', 'status' => "error", 'msg' => "Ocurrió un error y no se guardaron los datos del programa seleccionado."));
				}
			}
		} else {
			echo json_encode(array('title' => 'Error al guardar', 'status' => "error", 'msg' => "Verifique los datos ingresado, no se están enviando las variables tipo post necesarios."));
		}
	}
	// Envío de email al momento de aceptar un programa
	function enviomail_aceptar_programas ($organizacion, $data){
		$this->email->from(CORREO_SIA, "Acreditaciones");
		$this->email->to($organizacion->direccionCorreoElectronicoOrganizacion);
		$this->email->cc(CORREO_SIA);
		$this->email->subject('SIIA - Aceptación de programa.');
		$data_email = array (
			'organizacion' => $organizacion,
			'data' => $data
		);
		$email_view = $this->load->view('email/aceptacion_cursos', $data_email, true);
		$this->email->message($email_view);
		if($this->email->send()) {
			//Capturar datos para guardar en base de datos registro del correo enviado.
			$correo_registro = array(
				'fecha' => date('Y/m/d H:i:s'),
				'de' => CORREO_SIA,
				'para' => $organizacion->direccionCorreoElectronicoOrganizacion,
				'cc' => CORREO_SIA,
				'asunto' => "Aceptación Cursos",
				'cuerpo' => json_encode($data),
				'estado' => "1",
				'tipo' => "Notificación externa",
				'error' => $this->email->print_debugger()
			);
			//Comprobar que se guardó o no el registro en la tabla correosRegistro
			if($this->db->insert('correosregistro', $correo_registro)){
				echo json_encode(array('title' => 'Programa aceptado', 'status' => "success", 'msg' => "Se envío un correo a: " . $organizacion->direccionCorreoElectronicoOrganizacion . ", por favor verifíquelo"));
			}
			else {
				echo json_encode(array('title' => 'Error al guardar', 'status'=> 'info','msg' => "Se envío el correo de activación pero no se guardo registro en base de datos"));
			}

		}
		else {
			//Capturar datos para guardar en base de datos registro del correo no enviado.
			$correo_registro = array(
				'fecha' => date('Y/m/d H:i:s'),
				'de' => CORREO_SIA,
				'para' => $organizacion->direccionCorreoElectronicoOrganizacion,
				'cc' => CORREO_SIA,
				'asunto' => "Correo de aceptación cursos no enviado",
				'cuerpo' => json_encode($data),
				'estado' => "0",
				'tipo' => "Notificación interna",
				'error' => $this->email->print_debugger()
			);
			//Comprobar que se guardó o no el registro en la tabla correosRegistro
			if($this->db->insert('correosregistro', $correo_registro)){
				echo json_encode(array('status'=> 'info', 'msg' => "Se han guardado tus datos registrados, pero no se logro enviar correo de activación, sin embargo se registro error en base de datos para verificación por parte del administrador"));
			}
		}
	}
	// Eliminar datos programas
	public function delete()
	{
		$programa = $this->db->select('*')->from('datosProgramas')->where('id', $this->input->post('id'))->get()->row();
		$this->db->where('id', $programa->id);
		if ($this->db->delete('datosProgramas')) {
			echo json_encode(array('title' => "Eliminación exitosa!", 'msg' => "Se eliminaron los datos de aceptación del programa: " . $programa->nombrePrograma, 'status' => "success"));
		} else {
			echo json_encode(array('title' => "Error al eliminar", 'msg' => "No se eliminaron los datos de aceptación del programa: " . $programa->nombrePrograma, 'status' => "error"));
		}
	}
}
