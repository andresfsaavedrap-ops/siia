<?php
class InformeActividadesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/**
	 * Traer informeActividades de actividades
	 */
	public function getInformeActividades($id = FALSE) {
		if ($id === FALSE) {
			// Consulta para traer docentes
			$query = $this->db->select("*")->from("informeActividades")->get();
			return $query->result();
		}
		// Traer docentes por ID
		$query = $this->db->get_where('informeActividades', array('organizaciones_id_organizacion' => $id));
		return $query->result();
	}
	// Función del Modelo (OrganizacionesModel)
	public function getInformeActividades2() {
		$this->db->select("
        org.numNIT,
        org.nombreOrganizacion,
        org.sigla,
        inf_gen.nomDepartamentoUbicacion,
        SUM(inf_act.hombres) as total_hombres,
        SUM(inf_act.mujeres) as total_mujeres,
        SUM(
            CASE 
                WHEN asist.edad BETWEEN 5 AND 18 THEN 1 
                ELSE 0 
            END
        ) as personas_5_18,
        SUM(
            CASE 
                WHEN asist.edad BETWEEN 18 AND 26 THEN 1 
                ELSE 0 
            END
        ) as personas_18_26
    ");

		$this->db->from("informeActividades inf_act");
		$this->db->join("organizaciones org", "org.id_organizacion = inf_act.organizaciones_id_organizacion");
		$this->db->join("informacionGeneral inf_gen", "inf_gen.organizaciones_id_organizacion = org.id_organizacion");
		$this->db->join("asistentes asist", "asist.informeActividades_id_informeActividades = inf_act.id_informeActividades", "left");

		$this->db->where("inf_act.estado", "Enviado");
		$this->db->group_by("org.id_organizacion, org.numNIT, org.nombreOrganizacion, org.sigla, inf_gen.nomDepartamentoUbicacion");

		$query = $this->db->get();
		return $query->result();
	}
	// Versión mejorada con totales de asistentes, ubicación y departamento del informe
	public function getInformeActividadesDetallado($anio = null) {
		// Obtener todos los informes individuales con información adicional
		$this->db->select("
       inf_act.id_informeActividades,
       inf_act.fechaInicio,
       inf_act.departamento as departamentoInforme,
       inf_act.municipio as municipioInforme,
       inf_act.hombres,
       inf_act.mujeres,
       org.id_organizacion,
       org.numNIT,
       org.nombreOrganizacion,
       org.sigla,
       inf_gen.nomDepartamentoUbicacion as departamentoOrganizacion
    ");
		$this->db->from("informeActividades inf_act");
		$this->db->join("organizaciones org", "org.id_organizacion = inf_act.organizaciones_id_organizacion");
		$this->db->join("informacionGeneral inf_gen", "inf_gen.organizaciones_id_organizacion = org.id_organizacion");
		$this->db->where("inf_act.estado", "Enviado");
		// Filtro por año si se proporciona
		if ($anio !== null) {
			$this->db->where("YEAR(inf_act.fechaFin)", $anio);
		}
		$this->db->order_by("inf_act.departamento, org.nombreOrganizacion, inf_act.fechaFin");
		$informes = $this->db->get()->result();
		// Para cada informe individual, calcular los rangos de edad y total de asistentes
		foreach ($informes as $key => $informe) {
			// Obtener el total de asistentes para este informe específico
			$this->db->select("COUNT(*) as total_asistentes");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$total_asistentes = $this->db->get()->row()->total_asistentes;
			// Contar personas entre 5-18 años para este informe específico
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->where("asist.edad >=", 5);
			$this->db->where("asist.edad <=", 18);
			$personas_5_18 = $this->db->get()->row()->count;
			// Contar personas entre 18-26 años
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->where("asist.edad >=", 18);
			$this->db->where("asist.edad <=", 26);
			$personas_18_26 = $this->db->get()->row()->count;
			// Contar personas entre 27-40 años
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->where("asist.edad >=", 27);
			$this->db->where("asist.edad <=", 40);
			$personas_27_40 = $this->db->get()->row()->count;
			// Contar personas entre 41-60 años
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->where("asist.edad >=", 41);
			$this->db->where("asist.edad <=", 60);
			$personas_41_60 = $this->db->get()->row()->count;
			// Contar personas mayores de 60 años
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->where("asist.edad >", 60);
			$personas_60 = $this->db->get()->row()->count;
			// Contar personas con edad 0, null o sin definir
			$this->db->select("COUNT(*) as count");
			$this->db->from("asistentes asist");
			$this->db->where("asist.informeActividades_id_informeActividades", $informe->id_informeActividades);
			$this->db->group_start();
			$this->db->where("asist.edad", 0);
			$this->db->or_where("asist.edad IS NULL");
			$this->db->or_where("asist.edad", '');
			$this->db->group_end();
			$ns_nr = $this->db->get()->row()->count;
			// Agregar los datos calculados al objeto
			$informes[$key]->total_asistentes = $total_asistentes;
			$informes[$key]->personas_5_18 = $personas_5_18;
			$informes[$key]->personas_18_26 = $personas_18_26;
			$informes[$key]->personas_27_40 = $personas_27_40;
			$informes[$key]->personas_41_60 = $personas_41_60;
			$informes[$key]->personas_60 = $personas_60;
			$informes[$key]->ns_nr = $ns_nr;
		}
		return $informes;
	}
	// Función adicional para obtener totales por departamento
	public function getTotalesPorDepartamento($anio = null) {
		$this->db->select("
        inf_act.departamento,
        COUNT(DISTINCT inf_act.id_informeActividades) as total_informes,
        SUM(inf_act.hombres) as total_hombres,
        SUM(inf_act.mujeres) as total_mujeres,
        COUNT(asist.id_asistentes) as total_asistentes
    ");
		$this->db->from("informeActividades inf_act");
		$this->db->join("asistentes asist", "asist.informeActividades_id_informeActividades = inf_act.id_informeActividades", "left");
		$this->db->where("inf_act.estado", "Enviado");
		if ($anio !== null) {
			$this->db->where("YEAR(inf_act.fechaInicio)", $anio);
		}
		$this->db->group_by("inf_act.departamento");
		$this->db->order_by("inf_act.departamento");
		return $this->db->get()->result();
	}
	// Función adicional para obtener resumen por organización si lo necesitas
	public function getResumenPorOrganizacion($anio = null) {
		// Obtener datos básicos agrupados por organización
		$this->db->select("
			org.id_organizacion,
			org.numNIT,
			org.nombreOrganizacion,
			org.sigla,
			inf_gen.nomDepartamentoUbicacion,
			COUNT(inf_act.id_informeActividades) as total_informes,
			SUM(inf_act.hombres) as total_hombres,
			SUM(inf_act.mujeres) as total_mujeres,
			MIN(inf_act.fechaInicio) as primera_fecha,
			MAX(inf_act.fechaInicio) as ultima_fecha
    	");
		$this->db->from("informeActividades inf_act");
		$this->db->join("organizaciones org", "org.id_organizacion = inf_act.organizaciones_id_organizacion");
		$this->db->join("informacionGeneral inf_gen", "inf_gen.organizaciones_id_organizacion = org.id_organizacion");
		$this->db->where("inf_act.estado", "Enviado");
		// Filtro por año si se proporciona
		if ($anio !== null) {
			$this->db->where("YEAR(inf_act.fechaInicio)", $anio);
		}
		$this->db->group_by("org.id_organizacion, org.numNIT, org.nombreOrganizacion, org.sigla, inf_gen.nomDepartamentoUbicacion");
		$this->db->order_by("org.nombreOrganizacion");
		$organizaciones = $this->db->get()->result();
		// Para cada organización, calcular totales de rangos de edad
		foreach ($organizaciones as $key => $org) {
			// Obtener todos los informes de esta organización
			$this->db->select("id_informeActividades");
			$this->db->from("informeActividades");
			$this->db->where("organizaciones_id_organizacion", $org->id_organizacion);
			$this->db->where("estado", "Enviado");

			if ($anio !== null) {
				$this->db->where("YEAR(fechaInicio)", $anio);
			}

			$informes_org = $this->db->get()->result();
			$ids_informes = array_column($informes_org, 'id_informeActividades');

			if (!empty($ids_informes)) {
				// Contar por rangos de edad para todos los informes de la organización
				$rangos = [
					'personas_5_18' => [5, 18],
					'personas_18_26' => [18, 26],
					'personas_27_40' => [27, 40],
					'personas_41_60' => [41, 60]
				];

				foreach ($rangos as $campo => $rango) {
					$this->db->select("COUNT(*) as count");
					$this->db->from("asistentes");
					$this->db->where_in("informeActividades_id_informeActividades", $ids_informes);
					$this->db->where("edad >=", $rango[0]);
					$this->db->where("edad <=", $rango[1]);
					$organizaciones[$key]->$campo = $this->db->get()->row()->count;
				}

				// Mayores de 60
				$this->db->select("COUNT(*) as count");
				$this->db->from("asistentes");
				$this->db->where_in("informeActividades_id_informeActividades", $ids_informes);
				$this->db->where("edad >", 60);
				$organizaciones[$key]->personas_60 = $this->db->get()->row()->count;

				// Sin edad definida
				$this->db->select("COUNT(*) as count");
				$this->db->from("asistentes");
				$this->db->where_in("informeActividades_id_informeActividades", $ids_informes);
				$this->db->group_start();
				$this->db->where("edad", 0);
				$this->db->or_where("edad IS NULL");
				$this->db->or_where("edad", '');
				$this->db->group_end();
				$organizaciones[$key]->ns_nr = $this->db->get()->row()->count;
			} else {
				// Si no hay informes, establecer todos los conteos en 0
				$organizaciones[$key]->personas_5_18 = 0;
				$organizaciones[$key]->personas_18_26 = 0;
				$organizaciones[$key]->personas_27_40 = 0;
				$organizaciones[$key]->personas_41_60 = 0;
				$organizaciones[$key]->personas_60 = 0;
				$organizaciones[$key]->ns_nr = 0;
			}
		}
		return $organizaciones;
	}
	/**
	 * Traer informeActividades de actividades enviadas
	 */
	public function getInformeActividadesEnviadas($id = FALSE) {
		$this->db->select("informeActividades.*, organizaciones.nombreOrganizacion, organizaciones.numNIT ");
		$this->db->from("informeActividades");
		$this->db->join("organizaciones", "organizaciones.id_organizacion = informeActividades.organizaciones_id_organizacion");
		$this->db->where("informeActividades.estado", "Enviado");
		if ($id !== FALSE) {
			$this->db->where("informeActividades.organizaciones_id_organizacion", $id);
		}
		$query = $this->db->get();
		return $query->result();
	}
	/**
	 * Traer informe de actividad
	 */
	public function getInformeActividad($id = FALSE) {
		if ($id === FALSE) {
			// Consulta para traer el ultimo informe creado
			$query = $this->db->select("*")->from("informeActividades")->order_by('id_informeActividades', 'desc')->get();
			return $query->row();
		}
		// Traer docentes por ID
		$query = $this->db->get_where('informeActividades', array('id_informeActividades' => $id));
		return $query->row();
	}
	public function updateEstadoInformeActividad($id, $data)
	{
		$this->db->where('id_informeActividades', $id);
		$updated = $this->db->update('informeActividades', array('estado' => $data['estado']));
		if ($updated) {
			// Registrar el cambio en el historial
			$this->db->insert('historico_estado_informe', $data);
		}
		return $updated;
	}
	/**
	 * Traer intencionalidad
	 */
	public function getIntencionalidad($intencionalidades) {
		$result = '';
		foreach (json_decode($intencionalidades) as $intencionalidad):
			$intencionalidad = intval($intencionalidad);
			switch ($intencionalidad):
				case 1:
					$result .= "Promoción, ";
					break;
				case 2:
					$result .= "Creación, ";
					break;
				case 3:
					$result .= "Fortalecimiento, ";
					break;
				case 4:
					$result .= "Desarrollo, ";
					break;
				case 5:
					$result .= "Integración, ";
					break;
				case 6:
					$result .= "in, ";
					break;
				default:
					break;
			endswitch;
		endforeach;
		$result = substr($result, 0, -2);
		return $result;
	}
	/**
	 * Traer cursos
	 */
	public function getCursos($cursos) {
		$result = '';
		foreach (json_decode($cursos) as $curso):
			$curso = intval($curso);
			switch ($curso):
				case 1:
					$result .= "Acreditación Curso Básico de Economía Solidaria, ";
					break;
				case 2:
					$result .= "Aval de Trabajo Asociado, ";
					break;
				case 3:
					$result .= "Acreditación Curso Medio de Economía Solidaria, ";
					break;
				case 4:
					$result .= "Acreditación Curso Avanzado de Economía Solidaria, ";
					break;
				case 5:
					$result .= "Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria, ";
					break;
				default:
					break;
			endswitch;
		endforeach;
		$result = substr($result, 0, -2);
		return $result;
	}
	/**
	 * Traer modalidades
	 */
	public function getModalidades($modalidades) {
		$result = '';
		foreach (json_decode($modalidades) as $modalidad):
			$modalidad = intval($modalidad);
			switch ($modalidad):
				case 1:
					$result .= "Presencial, ";
					break;
				case 2:
					$result .= "Virtual, ";
					break;
				case 3:
					$result .= "En Linea, ";
					break;
				default:
					break;
			endswitch;
		endforeach;
		$result = substr($result, 0, -2);
		return $result;
	}
}


