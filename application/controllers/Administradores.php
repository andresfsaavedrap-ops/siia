<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Administradores extends CI_Controller
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
		$this->load->model('AdministradoresModel');
	}
	public function index()
	{
		$data['title'] = 'SUP';
		$data['tipo_usuario'] = "none";
		$data['logged_in'] = FALSE;
		$this->load->view('include/header', $data);
		$this->load->view('admin/super/super');
		$this->load->view('include/footer');
		$this->logs_sia->logs('PLACE_USER');
	}
	/**
	 * Cargar datos administrador
	 */
	public function cargarDatosAdministrador(){
		$administrador = $this->AdministradoresModel->getAdministradores($this->input->post('id'));
		$contrasena_rdel = $administrador->contrasena_rdel;
		$password = mc_decrypt($contrasena_rdel, KEY_RDEL);
		$datos = array(
			'administrador' => $administrador,
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
				'ext' =>  $this->input->post('super_ext_admin'),
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
				echo json_encode(array("status" => 0,"title" => "Administrador no creado!", "icon" => "error","msg" => "Administrador no agregado. Error en base de datos"));
			}
		}else{
			echo json_encode(array("status" => 0, "title" => "Administrador no creado!", "icon" => "error","msg" => "El nombre de usuario ya esta en uso."
			));
		}
	}
	/**
	 * Actualizar datos administrador
	 */
	public function update(){
		$id = $this->input->post('id_adm');
		$pass = $this->input->post('super_contrasena_admin');
		$password_rdel = mc_encrypt($pass, KEY_RDEL);
		$password_hash = generate_hash($pass);
		$administrador = $this->AdministradoresModel->getAdministradores($id);
		if($administrador->logged_in == 1){
			echo json_encode(array("msg" => "El administador esta en linea."));
		}else{
			$data_admin = array(
				'primerNombreAdministrador' => $this->input->post('super_primernombre_admin'),
				'segundoNombreAdministrador' => $this->input->post('super_segundonombre_admin'),
				'primerApellidoAdministrador' => $this->input->post('super_primerapellido_admin'),
				'segundoApellidoAdministrador' => $this->input->post('super_segundoapellido_admin'),
				'numCedulaCiudadaniaAdministrador' =>  $this->input->post('super_numerocedula_admin'),
				'ext' =>  $this->input->post('super_ext_admin'),
				'direccionCorreoElectronico' => $this->input->post('super_correo_electronico_admin'),
				'usuario' => $this->input->post('super_nombre_admin'),
				'contrasena' => $password_hash,
				'contrasena_rdel' => $password_rdel,
				'nivel' => $this->input->post('super_acceso_nvl')
			);
			$this->db->where('id_administrador', $id);
			if($this->db->update('administradores', $data_admin)){
				echo json_encode(array("msg" => "El administador ha sido actualizado."));
			}
		}
	}
	/**
	 * Eliminar administrador
	 */
	public function delete(){
		$id = $this->input->post('id_adm');
		$administrador = $this->AdministradoresModel->getAdministradores($id);
		if($administrador->logged_in == 1){
			echo json_encode(array("msg" => "El administrador " . $administrador->usuario . " esta en linea."));
		}else{
			$this->db->where('id_administrador', $id);
			if($this->db->delete('administradores')){
				echo json_encode(array("msg" => "El administador " . $administrador->usuario . " ha sido eliminado."));
			}
		}
	}
	/**
	 * Desconectar administrador
	 */
	public function disconnect(){
		$id = $this->input->post('id');
		$administrador = $this->AdministradoresModel->getAdministradores($id);
		if($administrador->logged_in == 1){
			$update = array('logged_in' => 0);
			$this->db->where('id_administrador', $id);
			if($this->db->update('administradores', $update)) {
				echo json_encode(array("status" => 1, "msg" => "El administrador " . $administrador->usuario . " se ha desconectado del sistema con éxito."));
			}
		}else{
			echo json_encode(array("status" => 0, "msg" => "El administador " . $administrador->usuario . " esta desconectado."));
		}
	}
}
