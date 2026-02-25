
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
/**
 * Controlador para gestión de docentes/facilitadores
 * Maneja CRUD de docentes, archivos y validaciones
 */
class Operaciones extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DocentesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('SolicitudesModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('AdministradoresModel');
		$this->load->model('CorreosRegistroModel');
		$this->load->model('TokenModel');
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
	// Opciones para administradores
	public function index()
	{
		/* 	$data['opciones'] = $this->cargarOpcionesSistema();
			$data['tiposCursoInformes'] = $this->cargarCursosInforme();
			$data['nits'] = $this->cargarNits();
			$data['encuestas'] = $this->cargarResultadosEncuesta();
			$data['actividad_admin'] = $this->cargarActividadAdmin();
			$data['mis_notificaciones'] = $this->cargarMisNotificaciones();
			$data['bateria'] = $this->cargarBateriaObservaciones(); */
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Operaciones';
		$data['activeLink'] = 'operaciones';
		$this->loadView('admin/operaciones/index', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	// Cambio de contraseña para administradores (vista)
	public function cambiarContrasena()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Operaciones / Cambio de contraseña';
		$data['activeLink'] = 'operaciones';
		$this->loadView('admin/operaciones/cambio-contrasena', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	// Guardar cambio de contraseña para administradores
	public function cambiarContrasenaAdmin()
	{
		try {
			$id_usuario = $this->session->userdata('usuario_id');
			$contrasenaActual = $this->input->post('contrasenaActual');
			$nuevaContrasena = $this->input->post('nuevaContrasena');
			$confirmarContrasena = $this->input->post('confirmarContrasena');
			// Validar que todos los campos estén presentes
			if (empty($contrasenaActual) || empty($nuevaContrasena) || empty($confirmarContrasena)) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Todos los campos son obligatorios.'
				));
				return;
			}
			// Validar que las contraseñas nuevas coincidan
			if ($nuevaContrasena !== $confirmarContrasena) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Las contraseñas nueva y de confirmación no coinciden.'
				));
				return;
			}
			// Validar longitud mínima de la nueva contraseña
			if (strlen($nuevaContrasena) < 8) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'La nueva contraseña debe tener al menos 8 caracteres.'
				));
				return;
			}
			// Obtener la contraseña actual del usuario
			$this->db->select('contrasena');
			$this->db->where('id_administrador', $id_usuario);
			$query = $this->db->get('administradores');
			if ($query->num_rows() == 0) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Usuario no encontrado.'
				));
				return;
			}
			$usuario = $query->row();
			// Verificar la contraseña actual
			if (!password_verify($contrasenaActual, $usuario->contrasena)) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'La contraseña actual es incorrecta.'
				));
				return;
			}
			// Generar hash de la nueva contraseña
			$password_rdel = mc_encrypt($nuevaContrasena, KEY_RDEL);
			$password_hash = generate_hash($nuevaContrasena);
			$data_update = array(
				'contrasena' => $password_hash,
				'contrasena_rdel' => $password_rdel
			);
			// Actualizar la contraseña
			$this->db->where('id_administrador', $id_usuario);
			if ($this->db->update('administradores', $data_update)) {
				echo json_encode(array(
					'success' => true,
					'msg' => 'Contraseña actualizada exitosamente.'
				));
			} else {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Error al actualizar la contraseña. Intente nuevamente.'
				));
			}

		} catch (Exception $e) {
			echo json_encode(array(
				'success' => false,
				'msg' => 'Error interno del servidor. Contacte al administrador.'
			));
		}
	}
	// Opciones del sistema para administradores
	public function opcionesSistema()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Operaciones / Opciones del sistema';
		$data['activeLink'] = 'operaciones';
		$this->loadView('admin/operaciones/opciones-sistema', $data, 'main');
		$data['opciones'] = $this->db->select("*")->from("opciones")->get()->result();
	}
	// Función consolidada para subir logos del sistema usando files_helper
	public function uploadSystemLogo()
	{
		$this->load->helper('files');
		
		try {
			$usuario_id = $this->session->userdata('usuario_id');
			$logo_type = $this->input->post('logo_type');
			
			// Validar tipo de logo
			$allowed_types = ['logo', 'logo_app'];
			if (!in_array($logo_type, $allowed_types)) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Tipo de logo no válido.'
				));
				return;
			}
			
			// Validar que se haya subido un archivo
			if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'No se ha seleccionado ningún archivo o hubo un error en la subida.'
				));
				return;
			}
			
			// Obtener configuración actual del logo
			$logo_config = $this->db->select('*')
				->from('opciones')
				->where('nombre', $logo_type)
				->get()
				->row();
			
			if (!$logo_config) {
				echo json_encode(array(
					'success' => false,
					'msg' => 'Configuración de logo no encontrada.'
				));
				return;
			}
			
			// Preparar metadatos para el helper
			$file = $_FILES['file'];
			$name_random = uniqid();
			$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
			$new_filename = "logo_" . $logo_type . "_" . $name_random . "." . $file_extension;
			
			$metadata = array(
				'tipo' => 'system_logo',
				'nombre' => $new_filename,
				'descripcion' => 'Logo del sistema - ' . $logo_type,
				'usuario_id' => $usuario_id
			);
			
			// Configuración para el helper
			$config = array(
				'max_size' => 10485760, // 10MB
				'allowed_types' => array('jpg', 'jpeg', 'png'),
				'create_directories' => true,
				'generate_unique_name' => false, // Ya generamos nombre único
				'save_to_db' => false // Manejamos la BD manualmente para opciones
			);
			
			// Usar el helper mejorado
			$upload_result = create_file_enhanced($file, $metadata, $config);
			
			if ($upload_result['success']) {
				// Eliminar archivo anterior si existe
				$old_file = $logo_config->valor;
				if (!empty($old_file) && file_exists($old_file) && $old_file !== $upload_result['file_path']) {
					unlink($old_file);
				}
				
				// Actualizar base de datos
				$data_update = array(
					'valor' => $upload_result['file_path']
				);
				
				$this->db->where('nombre', $logo_type);
				if ($this->db->update('opciones', $data_update)) {
					echo json_encode(array(
						'success' => true,
						'msg' => 'Logo actualizado exitosamente.',
						'image_url' => $upload_result['file_path']
					));
					
					// Log de la acción
					$this->logs_sia->session_log('Actualización de Logo del Sistema');
					$this->logs_sia->session_log('Administrador: ' . $this->session->userdata('nombre_usuario') . ' actualizó el ' . $logo_type);
				} else {
					// Si falla la actualización de BD, eliminar archivo subido
					if (file_exists($upload_result['file_path'])) {
						unlink($upload_result['file_path']);
					}
					echo json_encode(array(
						'success' => false,
						'msg' => 'Error al actualizar la configuración en la base de datos.'
					));
				}
			} else {
				echo json_encode(array(
					'success' => false,
					'msg' => $upload_result['message']
				));
			}
			
		} catch (Exception $e) {
			echo json_encode(array(
				'success' => false,
				'msg' => 'Error interno del servidor. Contacte al administrador.'
			));
		}
		
		$this->logs_sia->logs('URL_TYPE');
		$this->logs_sia->logQueries();
	}
	// Historico
	public function historico()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Operaciones / Historico';
		$data['activeLink'] = 'operaciones';
		$this->loadView('admin/historico/historico', $data, 'main');

		$data['opciones'] = $this->db->select("*")->from("opciones")->get()->result();
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$nivel = $this->session->userdata('nivel');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Panel Principal / Administrador / Historico';
		$data['logged_in'] = $logged;
		$data['nombre_usuario'] = $nombre_usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['nivel'] = $nivel;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		$data['departamentos'] = $this->cargarDepartamentos();
		$data['organizacionesHistoricas'] = $this->cargarOrganizacionesHistoricas();

		$this->load->view('include/header', $data);
		$this->load->view('admin/historico/historico', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
}
