<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller
{
    protected $sessionData = array();
    
    public function __construct()
    {
        parent::__construct();
        // Cargar modelos base comunes
		$this->load->model('OrganizacionesModel');
		$this->load->model('DepartamentosModel');
		$this->load->model('DocentesModel');
		$this->load->model('SolicitudesModel');
        date_default_timezone_set("America/Bogota"); // Configurar zona horaria
    }
    /**
     * Obtener datos base de sesión
     * @param bool $isAdmin - Si es administrador o usuario regular
     * @return array
     */
    protected function getBaseSessionData($isAdmin = false)
    {
        // Verificar sesión según el tipo de usuario
        if ($isAdmin) {
            verify_session_admin();
        } else {
            verify_session();
        }
        // Datos base de sesión
        $baseData = array(
            'logged_in' => $this->session->userdata('logged_in'),
            'nombre_usuario' => $this->session->userdata('nombre_usuario'),
            'usuario_id' => $this->session->userdata('usuario_id'),
            'tipo_usuario' => $this->session->userdata('type_user'),
            'nivel' => $this->session->userdata('nivel'),
            'hora' => date("H:i", time()),
            'fecha' => date('Y/m/d'),
        );
        if ($isAdmin) {
            // Cargar modelos adicionales para admin
	        $this->load->model('AdministradoresModel');
            $this->load->model('CorreosRegistroModel');
            $this->load->model('UsuariosModel');
            $this->load->model('SolicitudesModel');
            $this->load->model('ResolucionesModel');
			$this->load->model('TokenModel');
            // TODO: Revisar Datos específicos de administrador
            $baseData = array_merge($baseData, array(
                'departamentos' => $this->DepartamentosModel->getDepartamentos(),
                'organizaciones' => $this->OrganizacionesModel->getOrganizaciones(),
                'correos' => $this->CorreosRegistroModel->getCorreosRegistro(),
                'usuarios' => $this->UsuariosModel->getUsuariosSuperAdmin(),
                'solicitudes' => $this->SolicitudesModel->solicitudes(),
                'resoluciones' => $this->ResolucionesModel->getResolucionAndOrganizacion(),
				'administradores' => $this->AdministradoresModel->getAdministradores()
            ));
        } else {
            // Datos específicos de usuario regular
            $baseData['organizacion'] = $this->OrganizacionesModel->getOrganizacionUsuario($this->session->userdata('usuario_id'));
        }
        return $baseData;
    }
    
    /**
     * Agregar datos específicos del controlador
     * @param array $baseData - Datos base de sesión
     * @param array $additionalData - Datos adicionales específicos
     * @return array
     */
    protected function addControllerSpecificData($baseData, $additionalData = array())
    {
        return array_merge($baseData, $additionalData);
    }
    /**
     * Método para cargar vista con estructura común
     * @param string $viewPath - Ruta de la vista principal
     * @param array $data - Datos para la vista
     * @param string $headerType - Tipo de header ('main' para usuarios, 'admin' para admin)
     */
    protected function loadView($viewPath, $data, $headerType = 'main')
    {
        $headerView = ($headerType === 'main') ? 'include/header/main' : 'include/header';
        $footerView = ($headerType === 'main') ? 'include/footer/main' : 'include/footer';
        $this->load->view($headerView, $data);
        $this->load->view($viewPath, $data);
        $this->load->view($footerView, $data);
        // Log de acceso
        $this->logs_sia->logs('PLACE_USER');
    }
}
