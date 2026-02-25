
<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';
/**
 * Controlador para gestión de docentes/facilitadores
 * Maneja CRUD de docentes, archivos y validaciones
 */
class BateriaObservaciones extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BateriaObservacionesModel');
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
		$data['title'] = 'Panel Principal / Administrador / Bateria de observaciones';
		$data = $this->datosSesionAdmin();
		$data['activeLink'] = 'operaciones';
		$data['bateria'] = $this->BateriaObservacionesModel->getBateriaObservaciones();
		$this->loadView('admin/operaciones/bateria-observaciones', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
}
