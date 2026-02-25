<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DatosModalidades extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('OrganizacionesModel');
		$this->load->model('DatosModalidadesModel');
		verify_session();
	}
	// Formulario 6
	public function create()
	{
		if ($this->input->post()) {
			$modalidadesRegistradas = $this->DatosModalidadesModel->getDatosModalidades($this->input->post('idSolicitud'));
			$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('organizacion'));
			$data = array(
				'nombreModalidad' => $this->input->post('modalidad'),
				'aceptarModalidad' => "Si Acepta",
				'fecha' => date("Y/m/d H:i:s"),
				'organizaciones_id_organizacion' => $this->input->post('organizacion'),
				'idSolicitud' => $this->input->post('idSolicitud'),
			);
			/** Comprobar si la modalidad ya se encuentra aceptada */
			$modalidades = array();
			foreach ($modalidadesRegistradas as $modalidad) {
				array_push($modalidades, $modalidad->nombreModalidad);
			}
			$modalidadIngresada = $this->input->post('modalidad');
			if (in_array($modalidadIngresada, $modalidades)) {
				echo json_encode(array('title' => 'No se guardo','status' => "warning", 'msg' => "Programa: " . $modalidadIngresada .  " ya registrado."));
			}
			else {
				if ($this->db->insert('datosModalidades', $data)){
					$this->logs_sia->session_log('Formulario 6: Aceptación de modalidad' . $modalidadIngresada);
					$this->logs_sia->logQueries();
					echo json_encode(array('title' => 'Modalidad aceptada', 'status' => "success", 'msg' => "Se ha aceptado la modalidad: " . $modalidadIngresada . ", con éxito"));

					//$this->enviomail_aceptar_programas($organizacion, $data);
				}
				else {
					echo json_encode(array('title' => 'Error al guardar', 'status' => "error", 'msg' => "Ocurrió un error y no se guardaron los datos de la modalidad seleccionado."));
				}
			}
		} else {
			echo json_encode(array('title' => 'Error al guardar', 'status' => "error", 'msg' => "Verifique los datos ingresado, no se están enviando las variables tipo post necesarios."));
		}
	}
	// TODO: modificar en caso de que se requiere | Envío de email al momento de aceptar una modalidad
	function enviomail_modalidades ($organizacion, $data){
		$this->email->from(CORREO_SIA, "Acreditaciones");
		$this->email->to($organizacion->direccionCorreoElectronicoOrganizacion);
		$this->email->cc(CORREO_SIA);
		$this->email->subject('SIIA - Aceptación de modalidad.');
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
		$modalidad = $this->DatosModalidadesModel->getDatosModalidad($this->input->post('id'));
		$this->db->where('id', $modalidad->id);
		if ($this->db->delete('datosModalidades')) {
			echo json_encode(array('title' => "Eliminación exitosa!", 'msg' => "Se elimino dato de la modalidad: " . $modalidad->nombreModalidad, 'status' => "success"));
		} else {
			echo json_encode(array('title' => "Error al eliminar", 'msg' => "No se elimino dato en modalidad: " . $modalidad->nombreModalidad, 'status' => "error"));
		}
	}
}
