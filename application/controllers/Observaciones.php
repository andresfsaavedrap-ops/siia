<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Observaciones extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ObservacionesModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('SolicitudesModel');
		$this->load->model('UsuariosModel');
	}
	// Variables de Session
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
		);
		return $data;
	}
	// Guardar observación
	public function create()
	{
		$this->datosSession();
		$organizacion = $this->db->select('*')->from('organizaciones')->where('id_organizacion', $this->input->post('id'))->get()->row();
		$solicitud = $this->db->select('*')->from('solicitudes')->where('idSolicitud', $this->input->post('idSolicitud'))->get()->row();
		$tipoSolicitud = $this->db->select('*')->from('tipoSolicitud')->where('idSolicitud', $this->input->post('idSolicitud'))->get()->row();
		$fechaObservacion = new DateTime();
		$fechaVencimiento = (clone $fechaObservacion)->modify('+1 month');
		$data_observacion = array(
			'idForm' => $this->input->post('id_formulario'),
			'keyForm' => $this->input->post('formulario'),
			'valueForm' => $this->input->post('valueForm'),
			'observacion' => $this->input->post('observacion'),
			'fechaObservacion' => $fechaObservacion->format('Y-m-d H:i:s'),
			'fechaVencimiento' => $fechaVencimiento->format('Y-m-d H:i:s'),
			'numeroRevision' => $solicitud->numeroRevisiones += 1,
			'idSolicitud' => $this->input->post('idSolicitud'),
			'organizaciones_id_organizacion' => $this->input->post('id'),
			'realizada' => $this->session->userdata('nombre_usuario')
		);
		if ($this->db->insert('observaciones', $data_observacion)) {
			echo json_encode(array('status' => "success", 'msg' => "Se guardaron las observaciones. Formulario: " . $data_observacion['idForm']));
		}
	}
	// Cambiar estado de la solicitud
	public function cambiarEstadoSolicitud()
	{
		$this->datosSession();
		$idSolicitud = $this->input->post('idSolicitud');
		$observaciones = $this->ObservacionesModel->getObservacionesInvalidas($idSolicitud);
		$solicitud = $this->SolicitudesModel->solicitudes($idSolicitud);
		$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('id_organizacion'));
		$usuario = $this->UsuariosModel->getUsuarios($organizacion->usuarios_id_usuario);
		$data_update = array(
			'numeroRevisiones' => ($solicitud->numeroRevisiones + 1),
			'fechaUltimaRevision' =>  date('Y/m/d H:i:s')
		);
		if ($solicitud->nombre == "En Observaciones") {
			$this->db->where('idSolicitud', $idSolicitud);
			if ($this->db->update('solicitudes', $data_update)) {
				$this->notif_sia->notification('OBSERVACIONES', $usuario->usuario, $organizacion->usuario);
				$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' cambio el estado de la organización id: ' . $organizacion->id_organizacion . '.');
				send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'enviarObservaciones', $organizacion, $usuario, null, $idSolicitud);
			}
		}
		else {
			$this->db->where('idSolicitud', $idSolicitud);
			if ($this->db->update('solicitudes', $data_update)) {
				$data_estado = array(
					'nombre' => "En Observaciones",
					'estadoAnterior' => $solicitud->nombre,
					'organizaciones_id_organizacion' => $organizacion->id_organizacion
				);
				$this->db->where('idSolicitud', $idSolicitud);
				if ($this->db->update('estadoOrganizaciones', $data_estado)) {
					$this->notif_sia->notification('OBSERVACIONES', $usuario->usuario, $organizacion->nombreOrganizacion);
					$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' cambio el estado de la organización id: ' . $organizacion->id_organizacion . '.');
					send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'enviarObservaciones', $organizacion, $usuario, null, $idSolicitud);
				}
			}
		}
	}
	// Eliminar observacion
	public function eliminarObservacion()
	{
		$this->db->where('id_observacion', $this->input->post('idObservacion'));
		$this->db->delete('observaciones');
		echo json_encode(array('status' => "success", 'msg' => "Se elimino la observación."));
	}
	// Aprobar observación
	public function validarObservacion(){
		$data = array(
			'valida' => $this->input->post('valida')
		);
		$this->db->where('id_observacion', $this->input->post('idObservacion'));
		$this->db->update('observaciones', $data);
		echo json_encode(array('status' => "success", 'msg' => "Se aprobó la observación."));
	}
	// Ver historial de observaciones de una solicitud
	public function verHistorialObservaciones()
	{
		$idSolicitud = $this->input->post('idSolicitud');
		$observaciones = $this->db->select('*')->from('observaciones')->where('idSolicitud', $idSolicitud)->order_by('fechaObservacion', 'desc')->get()->result();
		echo json_encode($observaciones);
	}
}
function var_dump_pre($mixed = null) {
	echo '<pre>';
	var_dump($mixed);
	echo '</pre>';
	return null;
}
