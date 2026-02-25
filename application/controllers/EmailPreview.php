<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controlador para vista previa de templates de email
 * Permite visualizar los templates de email en el navegador
 */
class EmailPreview extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Verificar que el usuario tenga permisos (opcional)
        // verify_session_admin();
    }

    /**
     * Vista previa del template de contacto
     */
    public function contacto()
    {
        // Datos de ejemplo para la vista previa
        $data = array(
            'mensaje' => '
                <p><strong>Estimado usuario,</strong></p>
                <p>Le informamos que su solicitud ha sido procesada exitosamente en el Sistema Integrado de Información de Acreditación (SIIA).</p>
                <p>A continuación encontrará los detalles de su solicitud:</p>
                <ul>
                    <li><strong>Número de solicitud:</strong> SOL-2024-001</li>
                    <li><strong>Fecha de solicitud:</strong> ' . date('d/m/Y H:i:s') . '</li>
                    <li><strong>Estado:</strong> En proceso</li>
                    <li><strong>Organización:</strong> Ejemplo de Organización</li>
                </ul>
                <p>Si tiene alguna pregunta o necesita información adicional, no dude en contactarnos a través de los medios indicados en este correo.</p>
                <p>Gracias por utilizar nuestros servicios.</p>
                <p><strong>Cordialmente,</strong><br>Equipo SIIA - UAEOS</p>
            ',
            'boton_url' => base_url('panel'),
            'boton_texto' => 'Acceder al Sistema'
        );

        // Cargar la vista del email
        $this->load->view('email/contacto', $data);
    }

    /**
     * Vista previa del template de aceptación de cursos
     */
    public function aceptacion_cursos()
    {
        // Datos de ejemplo para la vista previa
        $data = array(
            'mensaje' => '
                <p><strong>Estimado participante,</strong></p>
                <p>Nos complace informarle que su inscripción al curso de capacitación ha sido aceptada exitosamente.</p>
                <p><strong>Detalles del curso:</strong></p>
                <ul>
                    <li><strong>Nombre del curso:</strong> Gestión de Organizaciones Solidarias</li>
                    <li><strong>Fecha de inicio:</strong> ' . date('d/m/Y', strtotime('+7 days')) . '</li>
                    <li><strong>Modalidad:</strong> Virtual</li>
                    <li><strong>Duración:</strong> 40 horas académicas</li>
                </ul>
                <p>En los próximos días recibirá información adicional sobre el acceso a la plataforma y los materiales del curso.</p>
                <p>¡Esperamos contar con su participación!</p>
                <p><strong>Cordialmente,</strong><br>Equipo de Capacitación - UAEOS</p>
            ',
            'boton_url' => base_url('cursos'),
            'boton_texto' => 'Ver Mis Cursos'
        );

        // Cargar la vista del email
        $this->load->view('email/aceptacion_cursos', $data);
    }

    /**
     * Lista de templates disponibles para vista previa
     */
    public function index()
    {
        $data = array(
            'title' => 'Vista Previa de Templates de Email',
            'templates' => array(
                array(
                    'name' => 'Template de Contacto',
                    'description' => 'Template general para comunicaciones del sistema',
                    'url' => base_url('emailpreview/contacto'),
                    'file' => 'contacto.php'
                ),
                array(
                    'name' => 'Template de Aceptación de Cursos',
                    'description' => 'Template para notificaciones de aceptación en cursos',
                    'url' => base_url('emailpreview/aceptacion_cursos'),
                    'file' => 'aceptacion_cursos.php'
                )
            )
        );

        $this->load->view('email/preview_emails', $data);
    }
}
