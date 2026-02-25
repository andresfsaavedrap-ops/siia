<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class InformacionGeneral extends CI_Controller
{
    /**
     * Index Page for this controller.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('InformacionGeneralModel');
        verify_session();
    }
    // Formulario 1
    public function create()
    {
        $this->form_validation->set_rules('tipo_organizacion', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('departamento', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('municipio', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('direccion', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('fax', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('actuacion', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('educacion', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('numCedulaCiudadaniaPersona', '', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('presentacion', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('objetoSocialEstatutos', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('mision', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('vision', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('principios', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('fines', '', 'trim|min_length[1]|xss_clean');
        $this->form_validation->set_rules('portafolio', '', 'trim|min_length[1]|xss_clean');
        if ($this->form_validation->run("formulario_informacion_general_entidad") == FALSE) {
            $error = validation_errors();
            echo json_encode(array('msg' => $error, 'status' => 'error'));
        }
        else {
            if ($this->input->post()) {
                $organizacion = $this->db->select("*")->from("organizaciones")->where("usuarios_id_usuario", $this->session->userdata('usuario_id'))->get()->row();
                $datos_informacion_general = $this->db->select("*")->from("informacionGeneral")->where("organizaciones_id_organizacion", $organizacion->id_organizacion)->get()->row();
                $data_informacion_general = array(
                    'tipoOrganizacion' => $this->input->post('tipo_organizacion'),
                    'direccionOrganizacion' => $this->input->post('direccion'),
                    'nomDepartamentoUbicacion' => $this->input->post('departamento'),
                    'nomMunicipioNacional' => $this->input->post('municipio'),
                    'fax' => $this->input->post('fax'),
                    'extension' => $this->input->post('extension'),
                    'urlOrganizacion' => $this->input->post('urlOrganizacion'),
                    'actuacionOrganizacion' => $this->input->post('actuacion'),
                    'tipoEducacion' => $this->input->post('educacion'),
                    'numCedulaCiudadaniaPersona' => $this->input->post('numCedulaCiudadaniaPersona'),
                    'mision' => $this->input->post('mision'),
                    'vision' => $this->input->post('vision'),
                    'portafolio' => $this->input->post('portafolio'),
                    'fecha' => date('Y/m/d H:i:s'),
                    'organizaciones_id_organizacion' => $organizacion->id_organizacion,
                    //'objetoSocialEstatutos' => $this->input->post('objetoSocialEstatutos'),
                    //'objetoSocialEstatutos' => $this->input->post('objetoSocialEstatutos'),
                    //'presentacionInstitucional' => $this->input->post('presentacion'),
                    //'principios' => $this->input->post('principios'),
                    //'fines' => $this->input->post('fines'),
                    //'otros' => $this->input->post('otros'),
                );
				$data_organizacion = array(
					'direccionCorreoElectronicoOrganizacion' => $this->input->post('correoElectronicoOrganizacion'),
					'primerNombreRepLegal' => $this->input->post('primerNombreRepLegal'),
					'segundoNombreRepLegal' => $this->input->post('segundoNombreRepLegal'),
					'primerApellidoRepLegal' => $this->input->post('primerApellidoRepLegal'),
					'segundoApellidoRepLegal' => $this->input->post('segundoApellidoRepLegal'),
					'direccionCorreoElectronicoRepLegal' => $this->input->post('correoElectronicoRepLegal'),
				);
                if ($datos_informacion_general != NULL) {
                    $this->db->where('organizaciones_id_organizacion', $organizacion->id_organizacion);
                    $this->db->update('informacionGeneral', $data_informacion_general);
                    $this->db->where('id_organizacion', $organizacion->id_organizacion);
                    $this->db->update('organizaciones', $data_organizacion);
                    echo json_encode(array('title' => 'Guardo exitoso!.','msg' => "Se actualizó la Información General.", 'status' => 'success'));
                    $this->logs_sia->session_log('Formulario Actualización Información General');
                    $this->logs_sia->logQueries();
                }
                else {
                    $this->db->insert('informacionGeneral', $data_informacion_general);
                    $this->db->where('id_organizacion', $organizacion->id_organizacion);
                    $this->db->update('organizaciones', $data_organizacion);
                    echo json_encode(array('title' => 'Guardo exitoso!.','msg' => "Se guardo la Información General.", 'status' => 'success'));
                    $this->logs_sia->session_log('Formulario Creación Información General');
                    $this->logs_sia->logQueries();
                }
            }
            else {
                echo json_encode(array('title' => 'Error al guardar!.','msg' => "Verifique los datos ingresado, no son correctos.", 'status' => 'error'));
            }
        }
    }
}
