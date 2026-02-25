<?php
class ObservacionesModel extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	/** Cargar Usuarios */
	public function getObservaciones($id = FALSE)
	{
		if ($id === FALSE) {
			// Consulta para traer organizaciones
			$query = $this->db->select("*")->from("observaciones")->get();
			return $query->result();
		}
		// Traer organizaciones por ID
		$query = $this->db->get_where('observaciones', array('idSolicitud' => $id))->result();
		$form1 = array();
		$form2 = array();
		$form3 = array();
		$form4 = array();
		$form5 = array();
		$form6 = array();
		$form7 = array();
		foreach ($query as $observacion):
			switch ($observacion->idForm):
				case 1:
					if ($observacion->valida == 0)
						array_push($form1, $observacion);
					break;
				case 2:
					if ($observacion->valida == 0)
						array_push($form2, $observacion);
					break;
				case 3:
					if ($observacion->valida == 0)
						array_push($form3, $observacion);
					break;
				case 4:
					if ($observacion->valida == 0)
						array_push($form4, $observacion);
					break;
				case 5:
					if ($observacion->valida == 0)
						array_push($form5, $observacion);
					break;
				case 6:
					if ($observacion->valida == 0)
						array_push($form6, $observacion);
					break;
				case 7:
					if ($observacion->valida == 0)
						array_push($form7, $observacion);
					break;
			endswitch;
		endforeach;
		$observaciones = array(
			'formulario1' => $form1,
			'formulario2' => $form2,
			'formulario3' => $form3,
			'formulario4' => $form4,
			'formulario5' => $form5,
			'formulario6' => $form6,
			'formulario7' => $form7,
		);
		return $observaciones;
	}
	public function getObservacionesInvalidas($idSolicitud)
	{
		$observaciones = $this->db->get_where("observaciones", array("idSolicitud" => $idSolicitud, "valida" => 0))->result();
		return $observaciones;
	}
	public function cargarObservaciones($idSolicitud)
	{
		$observaciones = $this->db->select("*")->from("observaciones")->where("idSolicitud", $idSolicitud)->order_by("valueForm", "asc")->get()->result();
		return $observaciones;
	}
}
