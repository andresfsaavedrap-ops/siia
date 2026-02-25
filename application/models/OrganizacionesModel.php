<?php
class OrganizacionesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Organizaciones */
	public function getOrganizaciones($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("organizaciones")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('organizaciones', array('numNIT' => $id));
		return $query->row();
	}
	/** Cargar organización por ID */
	public function getOrganizacion($id){
		$query = $this->db->get_where('organizaciones', array('id_organizacion' => $id));
		return $query->row();
	}
	/** Cargar organización por usuario */
	public function getOrganizacionUsuario($id){
		$query = $this->db->get_where('organizaciones', array('usuarios_id_usuario' => $id));
		return $query->row();
	}
	/** Cargar organización por email */
	public function getOrganizacionEmail($id){
		$query = $this->db->get_where('organizaciones', array('direccionCorreoElectronicoOrganizacion' => $id));
		return $query->row();
	}
	/** Cargar Organizaciones Acreditadas */
	public function getOrganizacionesAcreditadas()
	{
		$organizaciones = array();
		$nits = $this->db->select(("distinct(numNIT), numNIT"))->from("nits_db")->get()->result();
		foreach ($nits as $nit) {
			$organizacion = $this->db->select("*")->from("organizaciones")->where("numNIT", $nit->numNIT)->get()->row();
			$informacion = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $organizacion->id_organizacion)->get()->row();
			$resoluciones = $this->db->select("*")->from("resoluciones")->where("organizaciones_id_organizacion", $organizacion->id_organizacion)->get()->result();
			foreach ($resoluciones as $resolucion) {
				$organizacion_resolucion = $this->db->select("*")->from("resoluciones")->where("id_resoluciones", $resolucion->id_resoluciones)->get()->row();
				// Sacar tipo de la solicitud para conteó.
				$tipoSolicitud = $this->db->select('*')->from('tipoSolicitud')->where('idSolicitud', $organizacion_resolucion->idSolicitud)->get()->row();
				// Capturar fecha actual y límite para bajar la resolución
				$fechaActual = new DateTime();
				$fechaLimiteResolucion = new DateTime($organizacion_resolucion->fechaResolucionFinal);
				//$fechaLimiteResolucion = $fechaLimiteResolucion->modify('+2 months');
				// Guardar organización si la fecha límite es menor a la fecha actual.
				if($fechaActual <= $fechaLimiteResolucion):
					array_push($organizaciones, array("data_organizaciones" => $organizacion, "data_organizaciones_inf" => $informacion, "resoluciones" => $organizacion_resolucion, "tipoSolicitud" => $tipoSolicitud));
				endif;
			}
		}
		return $organizaciones;
	}
	/** Cargar organizaciones con estado "Acreditado" */
	public function getOrganizacionesEstadoAcreditado()
	{
		$organizaciones = $this->db->select('*')->from('organizaciones')->where('estado', 'Acreditado')->get()->result();
		return $organizaciones;
	}
	/** Cargar Organizaciones Histórico */
	public function getOrganizacionesHistorico()
	{
		$data_organizaciones = $this->db->select("*")->from("organizacionesHistorial")->get()->result();
		return $data_organizaciones;
	}
	/** Cargar Organizaciones finalizadas */
	public function getOrganizacionesFinalizadas()
	{
		$organizaciones = array();
		$solicitudes = $this->db->select("*")->from("estadoOrganizaciones")->where("nombre", "Finalizado")->get()->result();
		foreach ($solicitudes as $idSolicitud) {
			$idOrg = $idSolicitud->organizaciones_id_organizacion;
			$idSolicitud = $idSolicitud->idSolicitud;
			$data_organizaciones = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->get()->row();
			array_push($organizaciones, $data_organizaciones);
		}
		return $organizaciones;
		// echo json_encode($organizaciones);
	}
}
