<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welco7me
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$data['title'] = 'Activación de Cuenta';
		$data['logged_in'] = false;
		$data['tipo_usuario'] = "none";
		$this->load->view('include/header/guest', $data);
		$this->load->view('activate/activate');
		$this->load->view('include/footer/guest');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function verification()
	{
		try {
			// Validar entrada
			$token = $this->input->post('tk', TRUE);
			$user = $this->input->post('user', TRUE);
			if (empty($token) || empty($user)) {
				return $this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => 'error',
						'title' => '¡Error!',
						'msg' => 'Parámetros inválidos',
					]));
			}
			// Buscar token con validación de existencia
			$tokenRecord = $this->db->select('*')
				->from('token')
				->where('usuario_token', $user)
				->get()
				->row();
			if (!$tokenRecord) {
				$this->logs_sia->logs('INVALID_VERIFICATION_ATTEMPT', 'Intento de activación con usuario inexistente: ' . $user);

				return $this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode([
						'url' => base_url('registro'),
						'title' => '¡Cuenta no encontrada!',
						'msg' => 'Cuenta no encontrada, por favor contacte con el administrador del sistema.',
						'status' => 'warning'
					]));
			}
			// Verificar expiración del token (ejemplo para 24 horas)
			$tokenCreationTime = strtotime($tokenRecord->created_at);
			$expirationTime = $tokenCreationTime + (24 * 3600);
			if (time() > $expirationTime) {
				$this->logs_sia->logs('EXPIRED_TOKEN', 'Token expirado para usuario: ' . $user);
				return $this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode([
						'url' => base_url('registro'),
						'title' => '¡Enlace expirado!',
						'msg' => 'El enlace de activación ha expirado, por favor solicite un nuevo enlace.',
						'status' => 'warning'
					]));
			}
			// Verificar coincidencia segura de tokens
			if (!hash_equals($tokenRecord->token, $token)) {
				$this->logs_sia->logs('TOKEN_MISMATCH', 'Intento de activación con token inválido para usuario: ' . $user);
				return $this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode([
						'url' => base_url('registro'),
						'title' => '¡Token invalido!',
						'msg' => 'Token de activación inválido, consulte con el administrador.',
						'status' => 'warning'
					]));
			}
			// Si ya está verificado
			if ($tokenRecord->verificado == 1) {
				return $this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode([
						'url' => base_url('login'),
						'title' => '¡Cuenta activada!',
						'msg' => 'La cuenta ya estaba activada',
						'status' => 'info'
					]));
			}
			// Transacción para asegurar integridad de datos
			$this->db->trans_start();
			$this->db->where('usuario_token', $user)
				->update('token', [
					'verificado' => 1,
					'fechaActivacion' => date('Y-m-d H:i:s')
				]);
			// Ejecutar transacción
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Error en la transacción de base de datos');
			}
			$this->logs_sia->logQueries();
			$this->logs_sia->logs('ACCOUNT_ACTIVATED', 'Usuario: ' . $user);
			return $this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode([
					'url' => base_url('login'),
					'title' => '¡Activación exitosa!',
					'msg' => '¡Cuenta activada exitosamente, por favor inicie sesión!',
					'status' => 'success'
				]));

		} catch (Exception $e) {
			$this->db->trans_rollback();

			log_message('error', 'Error en verificación: ' . $e->getMessage());

			return $this->output
				->set_status_header(500)
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'msg' => 'Error interno del servidor'
				]));
		}
	}

}
