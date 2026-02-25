<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Enviar correo desde súper admin
 */
function send_email_super($type, $administrador)
{
	$CI = & get_instance();
	switch ($type):
		case 'creacionAdministrador':
				$CI->load->model('AdministradoresModel');
				$subject = 'Creación administrador';
				$message = '<strong><h4>Se ha creado un usuario administrador!</h4></strong>
							<p>Buen día, ' . $administrador->primerNombreAdministrador . ' ' . $administrador->primerApellido . 'La unidad solidaria le informa que se le ha asignado un usuario administrador con los siguientes datos:</p><br />
							<strong><label>Usuario:</label></strong>
							<p>' . $administrador->usuario .  '</p>
							<strong><label>Contraseña:</label></strong>
							<p>' . $CI->AdministradoresModel->getPassword($administrador->contrasena_rdel) . '</p>
							<strong><label>Correo electrónico:</label></strong>
							<p>' . $administrador->direccionCorreoElectronico . '</p>
							<strong><label>Rol:</label></strong>
							<p>' . $CI->AdministradoresModel->getNivel($administrador->nivel)  . '</p>
							<a target="_blank" style="font-family: Arial, sans-serif; background: #0071b9; color:white; display: inline-block; text-decoration: none; line-height:40px; font-size: 18px; width:200px; box-shadow: 2px 3px #e2e2e2; font-weight: bold;" href='. base_url() . 'admin/>Ingresar</a>';
				$response = array("status" => 1, "title" => "Administrador creado!", "icon" => "success", 'msg' => "Se envío un correo a: " . $administrador->direccionCorreoElectronico . " y a la supervisión con la información de acceso.");
			break;
		default:
			break;
	endswitch;
	$emailCoordinador = $CI->AdministradoresModel->getCoordinador()->direccionCorreoElectronico;
	/** Datos de correo */
	$CI->email->from(CORREO_SIA, "Acreditaciones");
	$CI->email->to($administrador->direccionCorreoElectronico);
	$CI->email->cc($emailCoordinador);
	$CI->email->subject('SIIA: ' . $subject);
	$msg['mensaje'] = $message;
	$email_view = $CI->load->view('email/contacto', $msg, true);
	$CI->email->message($email_view);
	/** Envió de correo */
	if ($CI->email->send()):
		$error = 'Enviado';
		save_log_email($administrador->direccionCorreoElectronico, $subject, $message, $type, $error, $response);
	else:
		$error = $CI->email->print_debugger();
		$response = array("status" => 1, "title" => "Administrador creado!", "icon" => "info", 'msg' => "Se creo administrador, pero no se logro enviar correo a : " . $administrador->direccionCorreoElectronico . " Error: " . $error , );
		save_log_email($administrador->direccionCorreoElectronico, $subject, $message, $type, $error, $response);
	endif;

}
/**
 * Datos para envío de Email al administrador
 * Prioridad
1 => '1 (Highest)',
2 => '2 (High)',
3 => '3 (Normal)',
4 => '4 (Low)',
5 => '5 (Lowest)'
 **/
function send_email_admin($tipo, $prioridad = null, $to = null, $docente = null, $organizacion = null, $solicitud = null, $silent = false)
{
	$CI = & get_instance();
	/** Asuntos y correos emails */
	switch ($tipo):
		// Actualización de facilitadores
		case 'solicitudDocente':
			$subject = 'Actualización Docente';
			$message = 'La organización <strong>' . $organizacion->nombreOrganizacion . '</strong> Realizo una solicitud para actualización del facilitador <strong>' . $docente->primerNombreDocente . ' ' . $docente->primerApellidoDocente . '</strong>, por favor ingrese al sistema para asignar dicha solicitud, gracias. 
					<br/><br/>
					<label>Datos de recepción:</label> <br/>
					Fecha de recepcion de solicitud: <strong>' . date("Y-m-d H:i:s") . '</strong>. <br/>';
			break;
		// Asignar solicitudes a evaluadores
		case 'asignarSolicitud':
			$subject = 'Asignación de organización';
			$message = 'Se le ha asignado la solicitud: <strong>' . $solicitud . '</strong> de la organización <strong>' . $organizacion->nombreOrganizacion . '</strong> para que pueda ver la solicitud y la información, este correo es informativo y debe ingresar a la aplicación SIIA, en organizaciones y luego en evaluación para poder ver la solicitud.';
			//$response = array('url' => 'panelAdmin/solicitudes/asignar', 'msg' => 'Se asigno la solicitud: ' . $solicitud . ' de la organización: ' . $organizacion->nombreOrganizacion .   ' correctamente en la fecha ' . date("Y-m-d H:i:s") . '.');
			break;
		// Llegada de solicitudes para asignar evaluadores
		case 'enviarSolicitd':
			$subject = 'Finalización de solicitud';
			$message = 'La organización <strong>' . $organizacion->nombreOrganizacion . '</strong> ha finalizado el informe de actividades: <strong>' . $solicitud . '</strong>.Para que pueda asignar la solicitud y/o ver la información, debe ingresar a la aplicación <a href='. base_url() . '>. Ir a organizaciones y dar clic en botón <strong>ASIGNAR</strong>.';
			break;
		// Envió informe de actividades
		case 'enviarInforme':
			$subject = 'Finalización de informe';
			$message = 'La organización <strong>' . $organizacion->nombreOrganizacion . '</strong> ha finalizado la solicitud: <strong>' . $solicitud . '</strong>.  El cual ya se puede revisar. <a href='. base_url() . '>. Ir a informe de actividades y buscarlo';
			break;
		case 'actualizacionSolicitud':
			$subject = 'Actualización de la solicitud - ' . $solicitud;
			$message = 'La organización: <strong>' . $organizacion->nombreOrganizacion . '</strong> ha realizado los ajustes requeridos para la solicitud: <strong>' . $solicitud . '</strong>, por favor ingresar a la aplicación SIIA, en organizaciones y luego en complementaria para poder ver la solicitud.';
			break;
		case 'solicitarCamara':
			$subject = "Solicitud cámara de comercio: " . $organizacion->sigla;
			$head = "Buen día, esta es una notificación del sistema:, <br><br>Se ha enviado una solicitud para cargar/actualizar la camara de comercio de la siguiente organización:<br><br>";
			$body = "<li> Nombre: " . $organizacion->nombreOrganizacion . " con NIT: <strong>" . $organizacion->numNIT . "</strong></li>";
			$message = $head . " " . $body;
			$response = $silent ? null : (array('url' => "panel", 'msg' => "Correo enviado a funcionario encargado de subir cámaras de comercio."));
			break;
		// Asignación de facilitador a un evaluador
		case 'asignarDocente':
			$nombreDocente = $docente ? ($docente->primerNombreDocente . ' ' . $docente->primerApellidoDocente) : 'facilitador';
			$orgNombre = ($organizacion && isset($organizacion->nombreOrganizacion)) ? $organizacion->nombreOrganizacion : null;
			$subject = 'Asignación de facilitador para evaluación';
			if ($orgNombre) {
				$message = 'Se le ha asignado el facilitador <strong>' . $nombreDocente . '</strong> de la organización <strong>' . $orgNombre . '</strong> para su evaluación. Por favor ingrese a la aplicación SIIA para ver la información y continuar con el proceso.';
			} else {
				$message = 'Se le ha asignado el facilitador <strong>' . $nombreDocente . '</strong> para su evaluación. Por favor ingrese a la aplicación SIIA para ver la información y continuar con el proceso.';
			}
			$message .= '<br/><br/><label>Datos de recepción:</label><br/>Fecha de asignación: <strong>' . date("Y-m-d H:i:s") . '</strong>.';
			$response = array('status' => 'success', 'title' => $subject, 'msg' => 'Notificación enviada al evaluador.');
			break;
		// Notificación de actualización de facilitador (basado en envilo_mailadmin->actualizacion)
		case 'actualizacion':
			$subject = "Actualización Docente";
			// Soporta tanto con docente como sin docente (si viene solo el ID de la solicitud)
			if ($docente) {
				$message = "La organización <strong>" . ($organizacion ? $organizacion->nombreOrganizacion : 'N/A') . "</strong> realizó una solicitud para actualización del facilitador <strong>" . $docente->primerNombreDocente . " " . $docente->primerApellidoDocente . "</strong>, por favor ingrese al sistema para asignar dicha solicitud, gracias.
					<br/><br/>
					<label>Datos de recepción:</label> <br/>
					Fecha de recepción de solicitud: <strong>" . date("Y-m-d H:i:s") . "</strong>. <br/>";
			} else {
				$message = "La organización <strong>" . ($organizacion ? $organizacion->nombreOrganizacion : 'N/A') . "</strong> realizó una solicitud de actualización del facilitador asociado a la solicitud <strong>" . ($solicitud ?? 'N/A') . "</strong>, por favor ingrese al sistema para asignar dicha solicitud, gracias.
					<br/><br/>
					<label>Datos de recepción:</label> <br/>
					Fecha de recepción de solicitud: <strong>" . date("Y-m-d H:i:s") . "</strong>. <br/>";
			}
			$response = array('status' => 'success', 'title' => $subject, 'msg' => 'Notificación de actualización enviada.');
			break;
		default:
			$subject = "";
			$mensaje = "";
			break;
	endswitch;
	/** Datos de correo */
	$CI->email->from(CORREO_SIA, "Acreditaciones");
	$CI->email->to($to);
	$CI->email->cc(CORREO_SIA);
	$CI->email->subject('SIIA: ' . $subject);
	$CI->email->set_priority($prioridad);
	$data_msg['mensaje'] = $message;
	$email_view = $CI->load->view('email/contacto', $data_msg, true);
	$CI->email->message($email_view);
	/** Envió de correo */
	if ($CI->email->send()):
		$error = 'Enviado';
		//Capturar datos para guardar en base de datos registro del correo enviado.
		save_log_email($to, $subject, $message, $tipo, $error, $response);
	else:
		$error = $CI->email->print_debugger();
		//Capturar datos para guardar en base de datos registro del correo enviado.
		save_log_email($to, $subject, $message, $tipo, $error, $response);
	endif;
}
/**
 * Enviar correo a usuarios
 */
function send_email_user($to, $type, $organizacion, $usuario = null, $token = null, $idSolicitud = null){
	$CI = & get_instance();
	$CI->load->model('SolicitudesModel');
	$CI->load->model('UsuariosModel');
	$CI->load->model('ObservacionesModel');
	/** Asuntos y correos emails */
	switch ($type):
		// Actualización de facilitadores
		case 'registroUsuario':
			$subject = 'Activación de Cuenta';
			$message = '<strong><label>Nombre de la organización:</label></strong>
						<p>' . $organizacion->nombreOrganizacion . '</p>
						<strong><label>Número NIT:</label></strong>
						<p>' . $organizacion->numNIT .  '</p>
						<strong><label>Correo de contacto:</label></strong>
						<p>' . $to . '</p>
						<strong><label>Representante legal:</label></strong>
						<p>' . $organizacion->primerNombreRepLegal . ' ' . $organizacion->primerApellidoRepLegal . '</p>
						<strong><label>Nombre de usuario:</label></strong>
						<p>' . $usuario . '</p>
						<p>Unidad Solidaria le recuerda que es importante mantener la información básica de contacto de la entidad actualizada, para facilitar el desarrollo procesos derivados de la acreditación. Le recomendamos cada vez que se realice algún cambio sea reportado por medio del SIIA. En razón a la política de manejo de datos institucional y para verificar la identidad de la organización, es necesario activar su cuenta en el siguiente link:</p><br />
						<a class="btn btn-primary" target="_blank" href='. base_url() . 'activate/?tk:' . $token . ':' . $usuario . '>Activar mi cuenta</a>';
			$response = array('status' => 'success', 'title' => 'Cuenta registrada', 'msg' => "Se envío un correo a: <strong> " . $to . "</strong>, por favor verifíquelo para activar su cuenta.");
			break;
		case 'RecordarContraseña':
			$subject = 'Datos de la Cuenta';
			$message = '<table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
						<tr><td align="center" valign="top">
						<strong><label>Correo de contacto:</label></strong>
						<p>' . $to . '</p>
						<strong><label>Nombre de usuario:</label></strong>
						<p>' . $usuario->usuario . '</p>
						<strong><label>Contraseña:</label></strong>
						<p>' . $token . '</p>
						<p>&nbsp;</p
						<small>Por favor, tenga en cuenta que su usuario y contraseña son <strong>privados</strong> no comparta esta información.</small>
						</td>
						</tr>
						</table>';
			$response = array('status' => 'success', 'title' => 'Correo enviado', 'msg' => "Se envío un correo a: <strong> " . $to . "</strong>, con los datos de inicio de sesión.");
			break;
		case 'crearSolicitud':
			$subject = "Inicia el diligenciamiento de la solicitud";
			$message = "Organización " . $organizacion->nombreOrganizacion . ": Unidad Solidaria le informa que ha iniciado el diligenciamiento de su solicitud de acreditación con ID: " . $idSolicitud . "
			 <br><br>Recuerde diligenciar todos los formularios, ingresando la información en los campos requeridos, los archivos adjuntos deben ser PDF con las extensiones admitidas (archivo.pdf, archivo.PDF) y con un peso no mayor a 15 MB cada archivo. 
			 <br><br>Al final de cada formulario guardé la información dando clic en el botón 'Guardar' <strong>(Es importante que valide si el formulario queda en color verde)</strong> 
			 <br><br>Cuando concluya con el ingreso de información en todos los formularios y archivos adjuntos requeridos <strong>(Todos los formularios deben estar en verde)</strong>, favor enviar la solicitud para su evaluación dando clic en el botón <strong>FINALIZAR</strong>.
			 <br><br>Si está en proceso de renovación recuerde que es importante mantener actualizada la información básica de contacto, así como documentos, docentes, entre otros, esto con el fin de facilitar el desarrollo procesos de acreditación. 
			 <br><br>Le recomendamos cada vez que se realice algún cambio sea reportado por medio del SIIA.
			 <br><br>Gracias!.";
			$response = array('status' => 'success', 'title' => 'Solicitud creada!', 'msg' => "Se créo nueva solicitud: <strong>" . $idSolicitud . "</strong> Será redireccionado a la página para diligenciar los formularios de esta solicitud.", 'id' => $idSolicitud);
			break;
		case 'enviarSolicitd':
			$subject = "Finaliza el diligenciamiento de la solicitud";
			$message = "<p>Buen día, <strong>" . $organizacion->nombreOrganizacion . "</strong>
 					<br><br>La Unidad Solidaria le informa que su solicitud de acreditación ha sido recibida.
					<br><br>En este momento no puede visualizarla en el aplicativo SIIA hasta que se realice la verificación de requisitos, por parte de profesional evaluador de la Unidad Solidaria.
					<br><br>Recibirá correo electrónico donde se informará el profesional designado para la evaluación de su solicitud.
					<br><br>De ser necesario, el evaluador le devolverá la solicitud con las observaciones pertinentes, dentro de los siguientes cinco (5) días hábiles.</p> 
					<br/><br/>
					<label>Datos de recepción:</label> <br/><br/>
					Fecha de envío solicitud: <strong>" . date("Y-m-d h:m:s") . "</strong>. <br/> 
					Fecha de creación de solicitud: <strong>" . $CI->SolicitudesModel->solicitudes($idSolicitud)->fechaCreacion . "</strong>. <br/> 
					Número ID de la solicitud: <strong>" . $idSolicitud . "</strong><br><br> ¡Muchas Gracias!
					<br><br>¿Desea ir al estado de la solicitud " . $idSolicitud . "?";
			$response = array('status' => "success", 'title' => 'Solicitud enviada!' ,'msg' => $message);
			break;
		case 'actualizarPerfil':
			$subject = "Actualización de perfil";
			$message = "Organización " . $organizacion->nombreOrganizacion . ": Unidad Solidaria le informa que la información básica de contacto de la entidad se ha actualizado satisfactoriamente y será publicada en el listado de entidades acreditadas si está acreditada durante los primeros cinco días del siguiente mes. Lo invitamos a actualizar su información cada vez que lo sea necesario.";
			$response = array('status' => "success", 'title' => 'Actualización de perfil correcta!' ,'msg' => "Su información de perfil ha sido actualizada con éxito");
			break;
		case 'EnviarDatosUsuario':
			$subject = "Información de usuario SIIA";
			$message = "Buen día, <strong>" . $organizacion->nombreOrganizacion . " </strong><br>A continuación se relacionan los datos de usuario para inicio de sesión en el sistema integrado de acreditación SIIA:
			<br><br><h3>Datos de usuario </h3><br>
			<strong>Usuario: </strong>" . $usuario->usuario . "<br><br>
			<strong>Contraseña: </strong>" . $CI->UsuariosModel->getPassword($usuario->contrasena_rdel);
			$response = array('status' => "success", 'title' => "Información enviada",'msg' =>  "Correo enviado a " . $organizacion->direccionCorreoElectronicoOrganizacion . " correctamente!");
			break;
		case 'asignarEvaluador':
			$subject = "Asignación de evaluador a su solicitud";
			$message = "Buen día, <strong>" . $organizacion->nombreOrganizacion . " </strong><br> A continuación se relacionan los datos del evaluador que está a cargo de su solicitud: <strong>" . $idSolicitud .
			"</strong><br><br><h3>Datos de evaluador </h3><br>
			<strong>Evaluador: </strong>" . $usuario->primerNombreAdministrador . " " . $usuario->primerApellidoAdministrador . "<br><br>
			<strong>PBX: </strong>57+1 3275252 ext " . $usuario->ext . "<br><br>
			<strong>Correo electronico: </strong>" . $usuario->direccionCorreoElectronico;
			$response = array('status' => "success", 'title' => "Solicitud asignada correctamente",'msg' =>  "Se a notificado a <strong> " . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong> y a <strong>" . $usuario->direccionCorreoElectronico . "</strong>");
			break;
		case 'enviarObservaciones':
			$observaciones = $CI->ObservacionesModel->getObservacionesInvalidas($idSolicitud);
			if (!empty($observaciones)):
				if ($CI->SolicitudesModel->solicitudes($idSolicitud)->numeroRevisiones > 1):
					$subject = "Observaciones actualizadas";
				else:
					$subject = "Observaciones realizadas";
				endif;
				$message = "<p>Buen día, <strong>" . $organizacion->nombreOrganizacion . " </strong><br><br> Organizaciones Solidarias le informa que se realizó la revisión de su solicitud de acreditación:
						<br><br>Por favor, revise las observaciones y de clic en <strong>Actualizar</strong> la solicitud una vez realizados los ajustes y <strong>Finalice el proceso</strong>  <br><br>
						<br><br>Volverá a llegarle un mensaje con la finalización de la solicitud ajustada.
						<br><br>Si ya realizó los cambios y recibió un correo de finalización, por favor cierre este cuadro y espere una nueva confirmación
						<br><br>¡Gracias!</p>";
			else:
				$subject = "¡Tramite Verificado!";
				$message = "<p>Buen día, <strong>" . $organizacion->nombreOrganizacion . " </strong><br> Organizaciones Solidarias le informa que se realizó la revisión de su solicitud de acreditación:
							<br><br>El evaluador verificó los datos registrados en la solicitud y se cumplen los requisitos establecidos en el marco normativo del trámite.
							<br><br>Su trámite pasa a revisión por parte del área jurídica para emitir acto administrativo.
							<br><br>¡Gracias!</p>";
			endif;
			$response = array('status' => "success", 'title' => $subject,'msg' =>  "Se han enviado las observaciones a <strong>" . $organizacion->nombreOrganizacion . "</strong>. Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'cambioEstadoSolicitud':
			$subject = "Cambio de estado solicitud - " . $idSolicitud;
			if ($CI->SolicitudesModel->solicitudes($idSolicitud)->nombre == "Acreditado"):
				$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que su solicitud ya cuenta con acto administrativo firmado por la dirección nacional. <br>Estamos en proceso de actualización de la nueva resolución en el SIIA, en próximos días le será enviado correo electrónico de notificación, junto con la resolución.";
			else:
				$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que la entidad solicitante no cumple con la totalidad de los requisitos establecidos en la Resolución 152 de 2022, que unifica y actualiza la reglamentación sobre el trámite de acreditación. Por lo anterior, la revisión de la solicitud de acreditación presentada no es procedente de evaluación por parte de la Unidad.
							<br><br>De mantenerse el interés por la acreditación, es necesario que se reúna la documentación requerida de acuerdo con lo dispuesto en el artículo 7 de la Resolución 152 de 2022 y se presente una nueva solicitud a través del Sistema Integrado de Información de Acreditación (SIIA).";
			endif;
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'resolucionCargada':
			if ($token == 'vieja'):
				$subject = "Resolución antigua cargada a la solicitud - " . $idSolicitud;
				$message = "<p>Buen día. <br><strong> " . $organizacion->nombreOrganizacion . "</strong><br><br> La Unidad Solidaria le informa que se ha vinculado una resolución de acreditación en el SIIA de años anterioes, la cual podrá ver ingresando con su usuario y contraseña a la plataforma SIIA.</p>";
			else:
				$subject = "Resolución cargada a la solicitud - " . $idSolicitud;
				$message = "<p>Buen día. <br><strong> " . $organizacion->nombreOrganizacion . "</strong><br><br> La Unidad Solidaria le informa que se ha vinculado la nueva resolución de acreditación en el SIIA, la cual podrá ver ingresando con su usuario y contraseña a la plataforma SIIA. <br><br> En próximos días le será enviado correo electrónico de notificación.</p>";
			endif;
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'informeAprobado':
			$subject = "Informe de actividades aprobado - " . $idSolicitud;
			$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que su informe de actividades ha sido revisado y aprobado. <br>Gracias por su participación.";
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. <br>Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'observacionesInforme':
			$subject = "Informe de actividades: " . $idSolicitud . " en observaciones" ;
			$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que su informe de actividades ha sido revisado y cuenta con observaciones pendientes por revisar. <br>Por favor ingrese a la sección de informe de actividades para revisar.";
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. <br>Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'docenteAprobado':
			$subject = "Docente aprobado";
			$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que su docente: <strong>" . $usuario->primerNombreDocente . " " . $usuario->segundoNombreDocente . " " . $usuario->primerApellidoDocente . " " . $usuario->segundoApellidoDocente . "</strong> ha sido aprobado. <br>Gracias por su participación.";
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. <br>Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		case 'observacionesDocente':
			$subject = "Observaciones docente";
			$message = "Buen día. <br> " . $organizacion->nombreOrganizacion . "<br><br> La Unidad Solidaria le informa que su docente: <strong>" . $usuario->primerNombreDocente . " " . $usuario->segundoNombreDocente . " " . $usuario->primerApellidoDocente . " " . $usuario->segundoApellidoDocente . "</strong> ha sido evaluado y cuenta con observaciones pendientes por revisar. <br><br> 	<strong> Observaciones:</strong> <br><br><em>" . $token . "</em><br><br>Por favor ingrese a la sección de docentes para revisar.";
			$response = array('status' => "success", 'title' => $subject, 'msg' =>  "Se ha enviado una notificación a <strong>" . $organizacion->nombreOrganizacion . "</strong>. <br>Se envío notificación al correo  <strong>" . $organizacion->direccionCorreoElectronicoOrganizacion . "</strong>");
			break;
		default:
			$asunto = "";
			$message = "";
			break;
	endswitch;
	/** Datos de correo */
	$CI->email->from(CORREO_SIA, "Acreditaciones");
	$CI->email->to($to);
	$CI->email->cc(CORREO_SIA);
	$CI->email->subject('SIIA: ' . $subject);
	$msg['mensaje'] = $message;
	$email_view = $CI->load->view('email/contacto', $msg, true);
	$CI->email->message($email_view);
	/** Envió de correo */
	if ($CI->email->send()):
		$error = 'Enviado';
		save_log_email($to, $subject, $message, $type, $error, $response);
	else:
		$error = $CI->email->print_debugger();
		save_log_email($to, $subject, $message, $type, $error, $response);
	endif;
}
/**
 * Guardar logs correos
 */
function save_log_email($to, $subject, $msg, $type, $error, $response = null) {
	$CI = & get_instance();
	$email_details = array(
		'fecha' => date("Y-m-d H:i:s"),
		'de' => CORREO_SIA,
		'para' => $to,
		'cc' => CORREO_SIA,
		'asunto' => $subject,
		'cuerpo' => json_encode($msg),
		'estado' => 1,
		'tipo' => $type,
		'error' => $error
	);
	if($CI->db->insert('correosregistro', $email_details)):
		if($response != null):
			echo json_encode($response);
		endif;
	else:
		if($response != null):
			echo json_encode($response);
		endif;
	endif;
}
?>

