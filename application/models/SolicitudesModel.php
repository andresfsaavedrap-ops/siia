<?php
class SolicitudesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->model('ArchivosModel');
	}
	/** Solicitudes */
	public function solicitudes($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones acreditas
			$query = $this->db->select("*")->from("solicitudes")->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")->get();
			return $query->result();
		}
		// Traer solicitudes por id (asegurar traer el último estado de estadoOrganizaciones)
		$query = $this->db->select("*")
			->from("solicitudes")
			->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")
			->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")
			->where('solicitudes.idSolicitud', $id)
			->order_by('estadoOrganizaciones.fechaUltimaActualizacion', 'DESC')
			->limit(1)
			->get()->row();
		return $query;
	}
	/** Cargar solicitudes y datos de la organización */
	public function getSolicitudesAndOrganizacion($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones acreditas
			$query = $this->db->select("*")->from("organizaciones")->join('solicitudes', 'solicitudes.organizaciones_id_organizacion = organizaciones.id_organizacion')->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")->order_by('solicitudes.fechaCreacion', 'desc')->get();
			return $query->result();
		}
		// Traer solicitudes por id
		$query = $this->db->select("*")->from("solicitudes")->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")->where('solicitudes.idSolicitud', $id)->get()->row();;
		return $query;
	}
	/** Cargar Solicitudes por Organización */
	public function getSolicitudesByOrganizacion($id = FALSE)
	{
		$solicitudes = $this->db->select("*")->from("solicitudes")->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")->where('solicitudes.organizaciones_id_organizacion', $id)->get()->result();
		return $solicitudes;
	}
	/** Cargar solicitudes acreditadas por organización */
	public function getSolicitudesAcreditadasOrganizacion($id = FALSE)
	{
		$solicitudes = $this->db->select("*")->from("solicitudes")->join('tipoSolicitud', "tipoSolicitud.idSolicitud = solicitudes.idSolicitud")->join('estadoOrganizaciones', "estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud")->where('solicitudes.organizaciones_id_organizacion', $id)->where('estadoOrganizaciones.nombre', 'Acreditado')->get()->result();
		return $solicitudes;
	}
	/** Verificar si una solicitud ya fue renovada */
	public function solicitudYaRenovada($idSolicitud)
	{
		// Buscar si existe alguna solicitud que tenga como idSolicitudAcreditado el ID de la solicitud actual
		$renovacion = $this->db->select("*")
			->from("estadoOrganizaciones")
			->where('idSolicitud', $idSolicitud)
			->where('renovada', 'Si')
			->get()->row();
			/* ->where('tipoSolicitudAcreditado', 'Renovación de Acreditación') */
		return $renovacion ? true : false;
	}
	/** Cargar Solicitudes Finalizadas Histórico */
	public function getSolicitudesFinalizadas()
	{
		$solicitudesFinalizadas = array();
		$dataSolicitudesAsignadas = array();
		$dataSolicitudesSinAsignar = array();
		$estados = $this->db->select("*")->from("estadoOrganizaciones")->join('solicitudes', 'estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud')->where("nombre", "Finalizado")->get()->result();
		foreach ($estados as $estado) {
			$idOrg = $estado->organizaciones_id_organizacion;
			$idSolicitud = $estado->idSolicitud;
			if ($estado->asignada != "SIN ASIGNAR"):
				$solicitud = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes, tipoSolicitud")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->where("tipoSolicitud.idSolicitud", $idSolicitud)->get()->row();
				array_push($dataSolicitudesAsignadas, $solicitud);
			else:
				$solicitud = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes, tipoSolicitud")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->where("tipoSolicitud.idSolicitud", $idSolicitud)->get()->row();
				array_push($dataSolicitudesSinAsignar, $solicitud);
			endif;
		}
		array_push($solicitudesFinalizadas, array('solicitudesSinAsignar' => $dataSolicitudesSinAsignar, 'solicitudesAsignadas' => $dataSolicitudesAsignadas));
		return $solicitudesFinalizadas;
		// echo json_encode($organizaciones);
	}
	/** Cargar Solicitudes En Proceso y Proceso de Renovación */
	public function getSolicitudesEnProceso()
	{
		$solicitudesEnProceso = array();
		$estados = $this->db->select("*")->from("estadoOrganizaciones")->join('solicitudes', 'estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud')->where("nombre", "En Proceso")->or_where("nombre", "En Proceso de Renovación")->get()->result();
		foreach ($estados as $estado) {
			$idOrg = $estado->organizaciones_id_organizacion;
			$idSolicitud = $estado->idSolicitud;
			$solicitud = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes, tipoSolicitud")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->where("tipoSolicitud.idSolicitud", $idSolicitud)->get()->row();
			array_push($solicitudesEnProceso, $solicitud);
		}
		return $solicitudesEnProceso;
	}
	/** Cargar Solicitudes En Observación */
	public function getSolicitudesEnObservacion()
	{
		$solicitudesEnObservacion = array();
		$estados = $this->db->select("*")->from("estadoOrganizaciones")->join('solicitudes', 'estadoOrganizaciones.idSolicitud = solicitudes.idSolicitud')->where("nombre", "En Observaciones")->get()->result();
		foreach ($estados as $estado) {
			$idOrg = $estado->organizaciones_id_organizacion;
			$idSolicitud = $estado->idSolicitud;
			$solicitud = $this->db->select("*")->from("organizaciones, estadoOrganizaciones, solicitudes, tipoSolicitud")->where("organizaciones.id_organizacion", $idOrg)->where("estadoOrganizaciones.idSolicitud", $idSolicitud)->where("solicitudes.idSolicitud", $idSolicitud)->where("tipoSolicitud.idSolicitud", $idSolicitud)->get()->row();
			array_push($solicitudesEnObservacion, $solicitud);
		}
		return $solicitudesEnObservacion;
	}
	/** Cargar toda la información de la solicitud */
	public function getAllInformacionSolicitud($idSolicitud, $idOrganizacion)
	{
		$informacionGeneral = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $idOrganizacion)->get()->row();
		$documentacion = $this->db->select("*")->from("documentacion")->where("idSolicitud", $idSolicitud)->get()->row();
		$certificadoExistencia = $this->db->select('*')->from('certificadoExistencia')->where("idSolicitud", $idSolicitud)->get()->row();
		$registroEducativoProgramas = $this->db->select("*")->from("registroEducativoProgramas")->where("idSolicitud", $idSolicitud)->get()->row();
		$antecedentesAcademicos = $this->db->select("*")->from("antecedentesAcademicos")->where("idSolicitud", $idSolicitud)->get()->result();
		$jornadasActualizacion = $this->db->select("*")->from("jornadasActualizacion")->where("idSolicitud", $idSolicitud)->get()->row();
		$datosProgramas = $this->db->select("*")->from("datosProgramas")->where("idSolicitud", $idSolicitud)->get()->result();
		$datosModalidades = $this->db->select("*")->from("datosModalidades")->where("idSolicitud", $idSolicitud)->get()->result();
		$docentes = $this->db->select("*")->from("docentes")->where("organizaciones_id_organizacion", $idOrganizacion)->get()->result();
		$plataforma = $this->db->select("*")->from("datosAplicacion")->where("idSolicitud", $idSolicitud)->get()->result();
		$enLinea = $this->db->select("*")->from("datosEnLinea")->where("idSolicitud", $idSolicitud)->get()->result();
		$tipoSolicitud = $this->db->select("*")->from("tipoSolicitud")->where("idSolicitud", $idSolicitud)->get()->result();
		$solicitudes = $this->db->select("*")->from("solicitudes")->where("idSolicitud", $idSolicitud)->get()->row();
		$estadoOrganizaciones = $this->db->select("*")->from("estadoOrganizaciones")->where("idSolicitud", $idSolicitud)->get()->row();
		$organizaciones = $this->db->select("*")->from("organizaciones")->where("id_organizacion", $idOrganizacion)->get()->row();
		$resoluciones = $this->db->select("*")->from("resoluciones")->where("organizaciones_id_organizacion", $idOrganizacion)->get()->result();
		$archivos = $this->ArchivosModel->getArchivosOrganizacion($idOrganizacion);
		$observaciones = $this->db->select('*')->from('observaciones')->where("organizaciones_id_organizacion", $idOrganizacion)->where('idSolicitud', $idSolicitud)->get()->result();
		echo json_encode(
			array(
				"informacionGeneral" => $informacionGeneral,
				"documentacion" => $documentacion,
				"registroEducativoProgramas" => $registroEducativoProgramas,
				"antecedentesAcademicos" => $antecedentesAcademicos,
				"jornadasActualizacion" => $jornadasActualizacion,
				"datosProgramas" => $datosProgramas,
				"datosModalidades" => $datosModalidades,
				"docentes" => $docentes,
				"plataforma" => $plataforma,
				"enLinea" => $enLinea,
				"tipoSolicitud" => $tipoSolicitud,
				"solicitudes" => $solicitudes,
				"estadoOrganizaciones" => $estadoOrganizaciones,
				"organizaciones" => $organizaciones,
				"archivos" => $archivos,
				"resoluciones" => $resoluciones,
				"observaciones" => $observaciones,
				"certificadoExistencia" => $certificadoExistencia
			)
		);
	}
	/** Traducir motivos */
	public function getMotivo($id)
	{
		switch ($id):
			case '1':
				return 'Acreditación Curso Básico de Economía Solidaria';
				break;
			case '2':
				return 'Aval de Trabajo Asociado';
				break;
			case '3':
				return 'Acreditación Curso Medio de Economía Solidaria';
				break;
			case '4':
				return 'Acreditación Curso Avanzado de Economía Solidaria';
				break;
			case '5':
				return 'Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria';
				break;
			default:
				break;
		endswitch;
	}
	/** Traducir motivos */
	public function getModalidad($id)
	{
		switch ($id):
			case '1':
				return 'Presencial';
				break;
			case '2':
				return 'Virtual';
				break;
			case '3':
				return 'En linea';
				break;
		endswitch;
	}
	// Resumen de una solicitud con los campos esperados por la vista finalizadas
	public function getSolicitudResumen($idOrganizacion, $idSolicitud)
	{
		return $this->db->select("
				organizaciones.nombreOrganizacion,
				organizaciones.numNIT,
				organizaciones.id_organizacion,
				estadoOrganizaciones.idSolicitud,
				estadoOrganizaciones.tipoSolicitudAcreditado as tipoSolicitud,
				estadoOrganizaciones.motivoSolicitudAcreditado as motivoSolicitud,
				estadoOrganizaciones.modalidadSolicitudAcreditado as modalidadSolicitud,
				estadoOrganizaciones.fechaFinalizado,
				estadoOrganizaciones.fechaUltimaActualizacion,
				solicitudes.asignada,
				solicitudes.fechaAsignacion,
				solicitudes.asignada_por
			")
			->from('organizaciones')
			->join('estadoOrganizaciones', 'estadoOrganizaciones.organizaciones_id_organizacion = organizaciones.id_organizacion')
			->join('solicitudes', 'solicitudes.idSolicitud = estadoOrganizaciones.idSolicitud')
			->join('tipoSolicitud', 'tipoSolicitud.idSolicitud = solicitudes.idSolicitud')
			->where('organizaciones.id_organizacion', $idOrganizacion)
			->where('estadoOrganizaciones.idSolicitud', $idSolicitud)
			->order_by('estadoOrganizaciones.fechaUltimaActualizacion', 'DESC')
			->limit(1)
			->get()
			->row();
	}
}
