<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuarios extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welco7me
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('UsuariosModel');
		$this->load->model('OrganizacionesModel');
		$this->load->model('TokenModel');
	}
	/**
	 * Cargar datos usuario
	 */
	public function cargarDatosUsuario(){
		$usuario = $this->UsuariosModel->getUsuariosSuperAdmin($this->input->post('id'));
		$contrasena_rdel = $usuario->contrasena_rdel;
		$password = mc_decrypt($contrasena_rdel, KEY_RDEL);
		$datos = array(
			'usuario' => $usuario,
			'password' => $password
		);
		echo json_encode($datos);
	}
	/**
	 * Crear administrador
	 */
	public function create(){
		$pass = $this->input->post('super_contrasena_admin');
		$password_rdel = mc_encrypt($pass, KEY_RDEL);
		$password_hash = generate_hash($pass);
		$administrador = $this->db->select("usuario")->from("administradores")->where("usuario", $this->input->post('super_nombre_admin'))->get()->row();
		if($administrador == ""){
			$data_admin = array(
				'primerNombreAdministrador' => $this->input->post('super_primernombre_admin'),
				'segundoNombreAdministrador' => $this->input->post('super_segundonombre_admin'),
				'primerApellidoAdministrador' => $this->input->post('super_primerapellido_admin'),
				'segundoApellidoAdministrador' => $this->input->post('super_segundoapellido_admin'),
				'numCedulaCiudadaniaAdministrador' => $this->input->post('super_numerocedula_admin'),
				'direccionCorreoElectronico' => $this->input->post('super_correo_electronico_admin'),
				'usuario' => $this->input->post('super_nombre_admin'),
				'nivel' => $this->input->post('super_acceso_nvl'),
				'contrasena' => $password_hash,
				'contrasena_rdel' => $password_rdel,
			);
			if($this->db->insert('administradores', $data_admin)){
				$usuario = $this->input->post('super_nombre_admin');
				$administrador = $this->AdministradoresModel->getAdministrador($usuario);
				$type = "creacionAdministrador";
				if($administrador)
					send_email_super($type, $administrador);
			}
			else{
				echo json_encode(array("status" => 0,"title" => "Administrador no creado!", "icon" => "error","msg" => "Administador no agregado. Error en base de datos"));
			}
		}else{
			echo json_encode(array("status" => 0, "title" => "Administrador no creado!", "icon" => "error","msg" => "El nombre de usuario ya esta en uso."
			));
		}
	}
	/**
	 * Actualizar datos usuarios
	 */
	public function update(){
		$id = $this->input->post('id');
		$pass = $this->input->post('password');
		$password_rdel = mc_encrypt($pass, KEY_RDEL);
		$password_hash = generate_hash($pass);
		$usuario = $this->UsuariosModel->getUsuarios($id);
		if($usuario->logged_in == 1){
			echo json_encode(array("status" => "info","msg" => "El usuario esta en linea."));
		}else{
			$data_organizacion = array(
				'direccionCorreoElectronicoOrganizacion' => $this->input->post('correo_electronico_usuario'),
			);
			$data_usuario = array(
				'usuario' => $this->input->post('username'),
				'contrasena' => $password_hash,
				'contrasena_rdel' => $password_rdel,
			);
			$data_token = array(
				'verificado' => $this->input->post('estado_usuario'),
				'usuario_token' => $data_usuario['usuario'],
			);
			$this->db->where('usuarios_id_usuario', $usuario->id_usuario);
			$this->db->update('organizaciones', $data_organizacion);
			$this->db->where('usuario_token', $data_usuario['usuario']);
			$this->db->update('token', $data_token);
			$this->db->where('id_usuario', $id);
			if($this->db->update('usuarios', $data_usuario)){
				echo json_encode(array("status" => "success", "msg" => "Usuario actualizado"));
			}
		}
	}
	/**
	 * Eliminar usuario completamente
	 */
	public function delete() {
		$id = $this->input->post('id');
		$usuario = $this->UsuariosModel->getUsuarios($id);
		if($usuario->logged_in == 1) {
			echo json_encode(array("title" => 'Usuario conectado', 'status' => 'warning',"msg" => "El usuario " . $usuario->usuario . " esta en linea."));
			return;
		}
		$organizacion = $this->OrganizacionesModel->getOrganizacionUsuario($usuario->id_usuario);
		// Validar que la organización existe y tiene ID válido
		if(!$organizacion || empty($organizacion->id_organizacion)) {
			echo json_encode(array("title" => 'Error', 'status' => 'error', "msg" => "No se encontró una organización válida para el usuario " . $usuario->usuario));
			return;
		}
		// Iniciar transacción para garantizar integridad
		$this->db->trans_start();
		try {
			// Deshabilitar temporalmente las verificaciones de foreign key
			$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
			// Lista completa de tablas relacionadas
			$tables_with_org_fk = array(
				'antecedentesAcademicos',
				'archivos',
				'docentes',
				'informeActividades',
				'registroEducativoProgramas',
				'datosAplicacion',
				'datosBasicosProgramas',
				'datosModalidades',
				'datosProgramas',
				'documentacion',
				'documentacionLegal',
				'estadoOrganizaciones',
				'informacionGeneral',
				'jornadasActualizacion',
				'observaciones',
				'planMejoramiento',
				'programasAvalar',
				'programasAvalEconomia',
				'registroTelefonico',
				'resoluciones',
				'visitas',
				'seguimientoSimple',
				'solicitudes',
				'tipoSolicitud'
			);
			// Eliminar registros de tablas relacionadas directamente
			foreach($tables_with_org_fk as $table) {
				// Verificar si la tabla existe antes de intentar borrar
				$table_exists = $this->db->table_exists($table);
				if ($table_exists) {
					$this->db->where('organizaciones_id_organizacion', $organizacion->id_organizacion);
					// Intentar borrar sin importar si existen registros
					$this->db->delete($table);
				}
			}
			// Eliminar registros de tablas relacionadas indirectamente
			$org_id = intval($organizacion->id_organizacion);
			if($org_id > 0) {
				// Para historialresoluciones - necesitamos verificar si existe la tabla historial
				$historial_query = $this->db->query("SELECT id_historial FROM historial WHERE organizaciones_id_organizacion = {$org_id}");
				if($historial_query && $historial_query->num_rows() > 0) {
					$historial_ids = array();
					foreach($historial_query->result() as $row) {
						$historial_ids[] = $row->id_historial;
					}
					if(!empty($historial_ids)) {
						$historial_ids_str = implode(',', $historial_ids);
						$this->db->query("DELETE FROM historialresoluciones WHERE historial_id_historial IN ({$historial_ids_str})");
					}
				}
				// Para certificaciones - a través de programasavalar
				$programas_query = $this->db->query("SELECT id_programasavalar FROM programasAvalar WHERE organizaciones_id_organizacion = {$org_id}");
				if($programas_query && $programas_query->num_rows() > 0) {
					$programas_ids = array();
					foreach($programas_query->result() as $row) {
						$programas_ids[] = $row->id_programasavalar;
					}
					if(!empty($programas_ids)) {
						$programas_ids_str = implode(',', $programas_ids);
						$this->db->query("DELETE FROM certificaciones WHERE programasavalar_id_programasavalar IN ({$programas_ids_str})");
					}
				}
				// Para certificadoexistencia - usando idSolicitud
				$solicitudes_query = $this->db->query("SELECT idSolicitud FROM solicitudes WHERE organizaciones_id_organizacion = {$org_id} AND idSolicitud IS NOT NULL");
				if($solicitudes_query && $solicitudes_query->num_rows() > 0) {
					$solicitudes_ids = array();
					foreach($solicitudes_query->result() as $row) {
						$solicitudes_ids[] = "'" . $row->idSolicitud . "'";
					}
					if(!empty($solicitudes_ids)) {
						$solicitudes_ids_str = implode(',', $solicitudes_ids);
						$this->db->query("DELETE FROM certificadoexistencia WHERE idSolicitud IN ({$solicitudes_ids_str}) AND organizaciones_id_organizacion = {$org_id}");
					}
				}
				// Para datosmodalidades - a través de datosprogramas
				$datos_programas_query = $this->db->query("SELECT id FROM datosProgramas WHERE organizaciones_id_organizacion = {$org_id}");
				if($datos_programas_query && $datos_programas_query->num_rows() > 0) {
					$datos_programas_ids = array();
					foreach($datos_programas_query->result() as $row) {
						$datos_programas_ids[] = $row->id;
					}
					if(!empty($datos_programas_ids)) {
						$datos_programas_ids_str = implode(',', $datos_programas_ids);
						$this->db->query("DELETE FROM datosmodalidades WHERE datosprogramas_id_datosprogramas IN ({$datos_programas_ids_str})");
					}
				}
				// Para organizacioneshistorial - a través de estadoorganizaciones
				$estado_org_query = $this->db->query("SELECT id_estadoOrganizacion FROM estadoOrganizaciones WHERE organizaciones_id_organizacion = {$org_id}");
				if($estado_org_query && $estado_org_query->num_rows() > 0) {
					$estado_org_ids = array();
					foreach($estado_org_query->result() as $row) {
						$estado_org_ids[] = $row->id_estadoOrganizacion;
					}
					if(!empty($estado_org_ids)) {
						$estado_org_ids_str = implode(',', $estado_org_ids);
						$this->db->query("DELETE FROM organizacioneshistorial WHERE estadoorganizaciones_id_estadoorganizaciones IN ({$estado_org_ids_str})");
					}
				}
				// Para registrotelefonico_historico - a través de registrotelefonico
				$reg_tel_query = $this->db->query("SELECT id_registroTelefonico FROM registroTelefonico WHERE organizaciones_id_organizacion = {$org_id}");
				if($reg_tel_query && $reg_tel_query->num_rows() > 0) {
					$reg_tel_ids = array();
					foreach($reg_tel_query->result() as $row) {
						$reg_tel_ids[] = $row->id_registroTelefonico;
					}
					if(!empty($reg_tel_ids)) {
						$reg_tel_ids_str = implode(',', $reg_tel_ids);
						$this->db->query("DELETE FROM registrotelefonico_historico WHERE registrotelefonico_id_registrotelefonico IN ({$reg_tel_ids_str})");
					}
				}
				// Para seguimiento - a través de visitas
				$visitas_query = $this->db->query("SELECT id_visitas FROM visitas WHERE organizaciones_id_organizacion = {$org_id}");
				if($visitas_query && $visitas_query->num_rows() > 0) {
					$visitas_ids = array();
					foreach($visitas_query->result() as $row) {
						$visitas_ids[] = $row->id_visitas;
					}
					if(!empty($visitas_ids)) {
						$visitas_ids_str = implode(',', $visitas_ids);
						$this->db->query("DELETE FROM seguimiento WHERE visitas_id_visitas IN ({$visitas_ids_str})");
					}
				}
			}
			// Eliminar token del usuario (si existe)
			if(!empty($usuario->usuario)) {
				$this->db->where('usuario_token', $usuario->usuario);
				$this->db->delete('token');
			}
			// Eliminar Organización
			$this->db->where('id_organizacion', $organizacion->id_organizacion);
			$org_deleted = $this->db->delete('organizaciones');
			if($org_deleted) {
				// Eliminar Usuario
				$this->db->where('id_usuario', $usuario->id_usuario);
				$user_deleted = $this->db->delete('usuarios');
				if($user_deleted) {
					// Rehabilitar verificaciones de foreign key
					$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
					// Completar transacción
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						echo json_encode(array("title" => 'Error en transacción', 'status' => 'error', "msg" => "Error durante la eliminación del usuario " . $usuario->usuario));
					} else {
						echo json_encode(array("title" => 'Usuario eliminado', 'status' => 'success', "msg" => "El usuario " . $usuario->usuario . " y todos sus datos en el sistema han sido eliminados completamente."));
					}
				} else {
					throw new Exception("Error al eliminar el usuario");
				}
			} else {
				throw new Exception("Error al eliminar la organización");
			}
		} catch (Exception $e) {
			// Rehabilitar verificaciones de foreign key en caso de error
			$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
			// Rollback de la transacción
			$this->db->trans_rollback();
			$error = $this->db->error();
			echo json_encode(array("title" => 'Error', 'status' => 'error', "msg" => "El usuario " . $usuario->usuario . " no fue eliminado. Error: " . $e->getMessage() . " - DB Error: " . $error['message']));
		}
	}
	/**
	 * Desconectar usuario
	 */
	public function disconnect(){
		$id = $this->input->post('id');
		$usuario = $this->UsuariosModel->getUsuarios($id);
		if($usuario->logged_in == 1){
			$update = array('logged_in' => 0);
			$this->db->where('id_usuario', $id);
			if($this->db->update('usuarios', $update)) {
				echo json_encode(array("status" => "success", "msg" => "El usuario " . $usuario->usuario . " se ha desconectado del sistema con éxito."));
			}
		}else{
			echo json_encode(array("status" => "info",  "msg"=> "El usuario " . $usuario->usuario . " esta desconectado."));
		}
	}
}
