<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigController extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Load any necessary libraries or helpers
		$this->load->helper('url');
		$this->load->library('form_validation');
	}

	public function index() {
		$this->load->view('super/pages/config_form');
	}

	public function update_constants() {
		$this->form_validation->set_rules('constant_name', 'Constant Name', 'required');
		$this->form_validation->set_rules('constant_value', 'Constant Value', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('config_form');
		} else {
			$constant_name = $this->input->post('constant_name');
			$constant_value = $this->input->post('constant_value');

			// Lógica para actualizar el archivo constants.php
			$constants_file = APPPATH . 'config/constants.php';
			$contents = file_get_contents($constants_file);

			$pattern = "/define\\('".preg_quote($constant_name, '/')."',\\s*'.*?'\\);/";
			$replacement = "define('$constant_name', '$constant_value');";

			$contents = preg_replace($pattern, $replacement, $contents);

			file_put_contents($constants_file, $contents);

			$this->session->set_flashdata('message', 'Constant updated successfully');
			redirect('configcontroller/index');
		}
	}
}
?>
