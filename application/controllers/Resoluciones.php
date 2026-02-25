<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';

class Resoluciones extends BaseController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SolicitudesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('AdministradoresModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('UsuariosModel');
		$this->load->model('ResolucionesModel');
	}
	    /**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
	/**
	 * Datos Sesión
	 */
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
			'departamentos' => $this->DepartamentosModel->getDepartamentos(),
		);
		return $data;
	}
	/**
	 * Vista de panel de organizaciones
	 */
	public function index()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Resoluciones';
		$data['activeLink'] = 'resoluciones';
		$data['organizaciones'] = $this->OrganizacionesModel->getOrganizaciones();
		$data['resoluciones'] = $this->ResolucionesModel->getResolucionAndOrganizacion();
		$this->loadView('admin/resoluciones/index', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/**
	 * Resoluciones por organización
	 */
	public function organizacion($idOrganizacion)
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Organización / Resoluciones';
		$data['activeLink'] = 'resoluciones';
		$data['organizacion'] = $this->OrganizacionesModel->getOrganizacion($idOrganizacion);
		$data['resoluciones'] = $this->ResolucionesModel->getResoluciones($idOrganizacion);
		$data['solicitudes'] = $this->SolicitudesModel->getSolicitudesAcreditadasOrganizacion($idOrganizacion);
		$this->loadView('admin/resoluciones/organizacion', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/**
	 * Cargar resolución a organización
	 */
	public function cargarResolucionOrganizacion()
	{
		$tipoResolucion = $this->input->post('tipoResolucion');
		if ($tipoResolucion == 'vieja'):
			$cursoAprobado = $this->input->post('cursoAprobado');
			$modalidadAprobada = $this->input->post('modalidadAprobada');
		else:
			$solicitud = $this->SolicitudesModel->solicitudes($this->input->post('idSolicitud'));
			$cursoAprobado = $solicitud->motivoSolicitud;
			$modalidadAprobada = $solicitud->modalidadSolicitud;
		endif;
		$organizacion = $this->OrganizacionesModel->getOrganizacion($this->input->post('id_organizacion'));
		$random = random(10);
		$size = 100000000;
		$resolucion =  "resolucion_" . $random . $_FILES['file']['name'];
		$tipo_imagen = pathinfo($resolucion, PATHINFO_EXTENSION);
		if (0 < $_FILES['file']['error']):
			echo json_encode(array('status' => "error", 'msg' => "Hubo un error al actualizar, intente de nuevo."));
		elseif ($_FILES['file']['size'] > $size):
			echo json_encode(array('status' => "warning", 'msg' => "El tamaño supera 10 MB, intente con otro pdf."));
		elseif ($tipo_imagen != "pdf"):
			echo json_encode(array('status' => "warning", 'msg' => "La extensión de la resolución no es correcta, debe ser PDF (archivo.pdf)"));
		elseif (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/resoluciones/' . $resolucion)):
			$data_update = array(
				'fechaResolucionInicial' => $this->input->post('fechaResolucionInicial'),
				'fechaResolucionFinal' => $this->input->post('fechaResolucionFinal'),
				'anosResolucion' => $this->input->post('anosResolucion'),
				'resolucion' => $resolucion,
				'numeroResolucion' => $this->input->post('numeroResolucion'),
				'cursoAprobado' => $cursoAprobado,
				'modalidadAprobada' => $modalidadAprobada,
				'organizaciones_id_organizacion' => $organizacion->id_organizacion,
				'idSolicitud' => $this->input->post('idSolicitud')
			);
			$this->db->insert('resoluciones', $data_update);
			$this->logs_sia->session_log('Resolución Adjuntada');
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó la resolución de la organización id: ' . $organizacion->id_organizacion . '.');
			$this->logs_sia->logs('URL_TYPE');
			$this->logs_sia->logQueries();
			send_email_user($organizacion->direccionCorreoElectronicoOrganizacion, 'resolucionCargada', $organizacion, $resolucion, $tipoResolucion, $solicitud->idSolicitud);
		endif;
	}
	public function actualizarResolucion()
	{
		$data_update = array(
			'fechaResolucionInicial' => $this->input->post('res_fech_inicio'),
			'fechaResolucionFinal' => $this->input->post('res_fech_fin'),
			'anosResolucion' => $this->input->post('res_anos'),
			'numeroResolucion' => $this->input->post('num_res_org'),
			'cursoAprobado' => $this->input->post('cursoAprobado'),
			'modalidadAprobada' => $this->input->post('modalidadAprobada'),
		);
		$this->db->where('id_resoluciones', $this->input->post('id_res'));
		if ($this->db->update('resoluciones', $data_update)) {
			echo json_encode(array('msg' => "Resolucion Actualizada"));
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' actualizó resolucion.');
		}
	}
	/**
	 * Eliminar resolución
	 */
	public function eliminarResolucion()
	{
		$resolucion = $this->ResolucionesModel->getResolucion($this->input->post('id_resolucion'));
		unlink('uploads/resoluciones/' . $resolucion->resolucion);
		$this->db->where('id_resoluciones', $resolucion->id_resoluciones);
		if ($this->db->delete("resoluciones")) {
			echo json_encode(array('title' => 'Eliminación resolución', 'status' => "success", 'msg' => "Se elimino la resolución."));
			$this->logs_sia->session_log('Resolución eliminada');
			$this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' elimino la resolución de la organización id: ' . $this->input->post('id_organizacion') . '.');
			$this->logs_sia->logs('URL_TYPE');
			$this->logs_sia->logQueries();
		}
	}
	/**
	 *
	 */
	/**
	 * Cargar solicitudes acreditadas por organización (JSON)
	 */
	public function getSolicitudesAcreditadasOrganizacion()
	{
		verify_session_admin();
		$idOrganizacion = $this->input->post('id_organizacion');
		if (!$idOrganizacion) {
			echo json_encode([]);
			return;
		}
		$solicitudes = $this->SolicitudesModel->getSolicitudesAcreditadasOrganizacion($idOrganizacion);
		echo json_encode($solicitudes);
	}
	/**
	 * Editar resolución
	 */
	public function editarResolucion()
	{
		$id_resolucion = $this->input->post('id_resolucion');

		$resolucion = $this->db->select('*')->from('resoluciones')->where('id_resoluciones', $id_resolucion)->get()->row();
		echo json_encode(array('resolucion' => $resolucion));
	}
    /**
     * Marcar resolución como vencida (no altera fecha fin ni borra el PDF)
     */
    public function vencerResolucion()
    {
        verify_session_admin();

        $idResolucion = $this->input->post('id_resolucion');
        if (!$idResolucion) {
            echo json_encode(array('title' => 'Vencer resolución', 'status' => 'warning', 'msg' => 'ID de resolución no proporcionado.'));
            return;
        }

        $resolucion = $this->ResolucionesModel->getResolucion($idResolucion);
        if (!$resolucion) {
            echo json_encode(array('title' => 'Vencer resolución', 'status' => 'warning', 'msg' => 'Resolución no encontrada.'));
            return;
        }

        $hoy = new DateTime();
        $fechaFin = new DateTime($resolucion->fechaResolucionFinal);

        // Si aún está vigente (fecha fin hoy o futuro), no permitir marcar como vencida
        if ($fechaFin >= $hoy) {
            echo json_encode(array('title' => 'Resolución vigente', 'status' => 'warning', 'msg' => 'La resolución aún está vigente y no puede marcarse como vencida.'));
            return;
        }

        // No se cambia la fecha fin; solo se confirma la operación y se registran logs
        echo json_encode(array('title' => 'Resolución vencida', 'status' => 'success', 'msg' => 'La resolución fue marcada como vencida.'));
        $this->logs_sia->session_log('Resolución marcada como vencida');
        $this->logs_sia->session_log('Administrador:' . $this->session->userdata('nombre_usuario') . ' marcó vencida la resolución id: ' . $resolucion->id_resoluciones . '.');
        $this->logs_sia->logs('URL_TYPE');
        $this->logs_sia->logQueries();
    }
	/**
	 * Eliminar solo el archivo PDF de la resolución (mantiene registro)
	 */
	public function eliminarArchivoResolucion()
	{
		verify_session_admin();
		$this->load->helper('files');

		$idResolucion = $this->input->post('id_resolucion');
		if (!$idResolucion) {
			echo json_encode(array('title' => 'Eliminar archivo', 'status' => 'warning', 'msg' => 'ID de resolución no proporcionado.'));
			return;
		}

		$resolucion = $this->ResolucionesModel->getResolucion($idResolucion);
		if (!$resolucion) {
			echo json_encode(array('title' => 'Eliminar archivo', 'status' => 'warning', 'msg' => 'Resolución no encontrada.'));
			return;
		}

		if (!empty($resolucion->resolucion)) {
			// Borra el archivo físico usando el helper
			delete_file('resoluciones', $resolucion->resolucion, null, null);
		}

		// Limpia el nombre del archivo en BD, mantiene el registro
		$this->db->where('id_resoluciones', $idResolucion);
		$this->db->update('resoluciones', array('resolucion' => null));

		echo json_encode(array('title' => 'Eliminar archivo', 'status' => 'success', 'msg' => 'Archivo de resolución eliminado.'));
		$this->logs_sia->session_log('Archivo de resolución eliminado');
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}

	/**
	 * Reemplazar el archivo PDF de la resolución (sube nuevo y actualiza el nombre)
	 */
	public function reemplazarArchivoResolucion()
	{
		verify_session_admin();
		$this->load->helper('files');

		$idResolucion = $this->input->post('id_resolucion');
		if (!$idResolucion) {
			echo json_encode(array('title' => 'Reemplazar archivo', 'status' => 'warning', 'msg' => 'ID de resolución no proporcionado.'));
			return;
		}

		if (!isset($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
			echo json_encode(array('title' => 'Reemplazar archivo', 'status' => 'warning', 'msg' => 'No se adjuntó ningún archivo.'));
			return;
		}

		// Validar y subir con helper (solo PDF, 10MB, nombre único, sin guardar en tabla archivos)
		$originalName = $_FILES['file']['name'];
		$metadata = array('tipo' => 'resoluciones', 'nombre' => $originalName);
		$config = array(
			'allowed_types' => array('pdf'),
			'max_size' => 10485760, // 10MB
			'generate_unique_name' => true,
			'save_to_db' => false
		);
		$result = create_file_enhanced($_FILES['file'], $metadata, $config);

		if (empty($result['success']) || $result['success'] !== true) {
			$msg = isset($result['message']) ? $result['message'] : 'No se pudo subir el archivo';
			echo json_encode(array('title' => 'Reemplazar archivo', 'status' => 'warning', 'msg' => $msg));
			return;
		}

		// Obtener registro actual
		$resolucion = $this->ResolucionesModel->getResolucion($idResolucion);
		if (!$resolucion) {
			// Si por alguna razón no existe, borra el archivo recién subido para evitar huérfanos
			@unlink($result['file_path']);
			echo json_encode(array('title' => 'Reemplazar archivo', 'status' => 'warning', 'msg' => 'Resolución no encontrada.'));
			return;
		}

		// Borrar archivo anterior si existe
		if (!empty($resolucion->resolucion)) {
			delete_file('resoluciones', $resolucion->resolucion, null, null);
		}

		// Actualizar nombre del archivo en BD con el nuevo nombre
		$nuevoNombre = basename($result['file_path']);
		$this->db->where('id_resoluciones', $idResolucion);
		$this->db->update('resoluciones', array('resolucion' => $nuevoNombre));

		echo json_encode(array(
			'title' => 'Reemplazar archivo',
			'status' => 'success',
			'msg' => 'Archivo de resolución reemplazado correctamente.',
			'file_url' => isset($result['file_url']) ? $result['file_url'] : base_url('uploads/resoluciones/' . $nuevoNombre)
		));
		$this->logs_sia->session_log('Archivo de resolución reemplazado');
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
}
// Validación de errores
function var_dump_pre($mixed = null) {
	echo '<pre>';
	var_dump($mixed);
	echo '</pre>';
	return null;
}
