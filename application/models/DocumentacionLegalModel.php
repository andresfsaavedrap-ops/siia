<?php
class DocumentacionLegalModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar documentación legal */
	public function getDocumentacionLegal($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("documentacion")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$documentacion = $this->db->select('*')->from('documentacion')->where('idSolicitud', $id)->get()->row();
		if ($documentacion->tipo == 1) {
			return $documentacion;
		}
		else if ($documentacion->tipo == 2) {
			$CertificadosExistencias = $this->db->select('*')->from('certificadoExistencia')->where('idSolicitud', $id)->get()->row();
			return $CertificadosExistencias;
		}
		else if ($documentacion->tipo == 3) {
			$registrosEducativos =  $this->db->select('*')->from('registroEducativoProgramas')->where('idSolicitud', $id)->get()->row();
			return $registrosEducativos;
		}
	}
}
