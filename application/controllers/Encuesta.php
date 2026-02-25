<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Encuesta extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('EncuestaModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('SolicitudesModel');
	}
	//Función de inicio.
	public function index()
	{
		$data = array(
			'title' => 'Encuesta de Satisfacción',
			'logged_in' => false,
			'tipo_usuario' => "none",
			'nombre_usuario' => "none",
		);
		$this->load->view('include/header/guest', $data);
		$this->load->view('encuesta');
		$this->load->view('include/footer/guest');
		$this->logs_sia->logs('PLACE_USER');
	}
	//Cargar todas las encuestas registradas
	public function cargar()
	{
		$data = array(
			'encuestas' => $this->EncuestaModel->encuestas(),
		);
		// Json datos encuestas
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
	// TODO: Terminar Almacenar y enviar encuesta.
	public function enviarEncuesta()
	{
		$nit = $this->input->post('nit');
		$idSolicitud = $this->input->post('idSolicitud');
		$general = $this->input->post('calificacion_general');
		$evaluador = $this->input->post('calificacion_evaluador');
		$comentario = $this->input->post('comentario');
		if (empty($nit) || empty($idSolicitud) || empty($general) || empty($evaluador) || empty($comentario)) {
			echo json_encode(array('estado' => 0, 'msg' => "Registre correctamente los campos obligatorios."));
			return;
		}
		if (!preg_match('/^\d{9,10}-\d$/', $nit)) {
			echo json_encode(array('estado' => 0, 'msg' => "El NIT debe tener el formato 123456789-0"));
			return;
		}
		$nitNumero = explode('-', $nit)[0];
		$org = $this->db->select('id_organizacion')->from('organizaciones')->where('(numNIT = '.$this->db->escape($nit).' OR numNIT = '.$this->db->escape($nitNumero).')')->get()->row();
		if (!$org) {
			echo json_encode(array('estado' => 0, 'msg' => "El NIT ingresado no existe en la base de datos de organizaciones."));
			return;
		}
		$solAcred = $this->db->select('idSolicitud')
			->from('estadoOrganizaciones')
			->where('idSolicitud', $idSolicitud)
			->where('organizaciones_id_organizacion', $org->id_organizacion)
			->where('nombre', 'Acreditado')
			->get()->row();
		if (!$solAcred) {
			echo json_encode(array('estado' => 0, 'msg' => "El ID de solicitud no corresponde a una solicitud acreditada de la organización."));
			return;
		}
		$nitColumn = null;
		if ($this->db->field_exists('numNIT', 'encuesta')) {
			$nitColumn = 'numNIT';
		} else if ($this->db->field_exists('nit', 'encuesta')) {
			$nitColumn = 'nit';
		}
		//Captura datos de encuesta
		$data = array(
			'general' => $general,
			'evaluador' => $evaluador,
			'comentario' => $comentario,
			'fecha' => date('Y/m/d'),
		);
		if ($nitColumn) {
			$data[$nitColumn] = $nit;
		}
		if ($this->db->field_exists('idSolicitud', 'encuesta')) {
			$data['idSolicitud'] = $idSolicitud;
		} else if ($this->db->field_exists('solicitudes_id_solicitud', 'encuesta')) {
			$data['solicitudes_id_solicitud'] = $idSolicitud;
		}
		//Guardar y comprobar datos guardados en tabla encuesta
		if ($this->db->insert('encuesta', $data)) {
			//Capturar datos para envío de correo electrónico a administrador del sistema
			$this->email->from(CORREO_SIA, "Acreditaciones");
			$this->email->to(CORREO_PRUEBAS);
			$this->email->subject('Correo de información del SIIA - Asunto: Se ha registrado una encuesta');
			//Declarar vista de correo y enviar datos de la encuesta a plantilla para ser trabajada desde allí.
			$email_view = $this->load->view('email/encuesta', $data, true);
			$this->email->message($email_view);
			//Enviar y comprobar el envío del correo electrónico de notificación.
			if ($this->email->send()) {
				//Capturar datos para guardar en base de datos registro del correo enviado.
				$correo_registro = array(
					'fecha' => date('Y/m/d H:i:s'),
					'de' => CORREO_SIA,
					'para' => CORREO_PRUEBAS,
					'asunto' => "Encuesta enviada",
					'cuerpo' => json_encode($data),
					'estado' => "1",
					'tipo' => "Notificación interna"
				);
				//Comprobar que se guardó o no el registro en la tabla correosRegistro
				if ($this->db->insert('correosRegistro', $correo_registro)) {
					echo json_encode(array('estado' => 1, 'msg' => "Se registró la encuesta correctamente."));
				} else {
					echo json_encode(array('estado' => 2, 'msg' => "Tu encuesta fue registrada, pero no se guardó el registro del correo de notificación."));
				}
			} else {
				//Capturar datos para guardar en base de datos registro del correo no enviado.
				$correo_registro = array(
					'fecha' => date('Y/m/d H:i:s'),
					'de' => CORREO_SIA,
					'para' => CORREO_PRUEBAS,
					'asunto' => "Encuesta no enviada",
					'cuerpo' => json_encode($data),
					'estado' => "0",
					'tipo' => "Notificación interna",
					'error' => $this->email->print_debugger()
				);
				//Comprobar que se guardó o no el registro en la tabla correosRegistro
				if ($this->db->insert('correosRegistro', $correo_registro)) {
					echo json_encode(array('estado' => 2, 'msg' => "Se han guardado tus respuestas, pero no se logró notificar por correo al administrador."));
				}
			}
		} else {
			echo json_encode(array('estado' => 0, 'msg' => "No se ha logrado registrar tu respuesta, por favor intenta de nuevo."));
		}
	}

	public function solicitudesAcreditadasPorNit()
	{
		$nit = $this->input->post('nit');
		if (empty($nit) || !preg_match('/^\d{9,10}-\d$/', $nit)) {
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('estado' => 0, 'msg' => 'NIT inválido', 'solicitudes' => []));
			return;
		}
		$nitNumero = explode('-', $nit)[0];
		$org = $this->db->select('id_organizacion')->from('organizaciones')->where('(numNIT = '.$this->db->escape($nit).' OR numNIT = '.$this->db->escape($nitNumero).')')->get()->row();
		if (!$org) {
			$this->output->set_header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('estado' => 0, 'msg' => 'Organización no encontrada', 'solicitudes' => []));
			return;
		}
		$solicitudes = $this->SolicitudesModel->getSolicitudesAcreditadasOrganizacion($org->id_organizacion);
		$ids = array_map(function($s){ return $s->idSolicitud; }, $solicitudes);
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode(array('estado' => 1, 'solicitudes' => $ids));
	}
}
