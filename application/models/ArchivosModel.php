<?php
class ArchivosModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function getArchivos($id = FALSE, $form = FALSE, $idSolicitud = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer administradores
			$query = $this->db->select("*")->from("archivos")->get();
			return $query->result();
		}
		if ($idSolicitud !== FALSE) {
			$query = $this->db->get_where('archivos', array('organizaciones_id_organizacion' => $id,'id_formulario' => $form, 'id_registro' => $idSolicitud));
			return $query->result();
		}
		// Traer archivos por id organización y formulario
		//$query = $this->db->get_where('archivos', array('id_formulario' => $form, 'id_registro' => $id));
		$query = $this->db->get_where('archivos', array('organizaciones_id_organizacion' => $id,'id_formulario' => $form));
		return $query->result();
	}
	/**
	 * Cargar archivos por organización
	 */
	public function getArchivosOrganizacion($id) {

		if ($id === FALSE) {
			$query = $this->db->select('*')->from('archivos')->get();
			return $query->result();
		}
		$query = $this->db->get_where('archivos', array('organizaciones_id_organizacion' => $id));
		return $query->result();
	}
	/**
	 *  Comprobar extensiones de archivos
	 */
	public function checkExtensionImagenes($extension)
	{
		// Aquí podemos añadir las extensiones que deseemos permitir
		$extensiones = array("jpg", "png", "jpeg");
		if (in_array(strtolower($extension), $extensiones)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function checkExtensionPDF($extension)
	{
		// Aquí podemos añadir las extensiones que deseemos permitir
		$extensiones = array("pdf", "PDF");
		if (in_array(strtolower($extension), $extensiones)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
