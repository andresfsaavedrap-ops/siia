<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificaciones extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		setlocale(LC_ALL, 'es_CO.UTF-8');
	}

	public function index()
	{
		date_default_timezone_set("America/Bogota");
		$logged = $this->session->userdata('logged_in');
		$nombre_usuario = $this->session->userdata('nombre_usuario');
		$usuario_id = $this->session->userdata('usuario_id');
		$tipo_usuario = $this->session->userdata('type_user');
		$hora = date("H:i", time());
		$fecha = date('Y/m/d');

		$data['title'] = 'Certificados';
		$data['logged_in'] = $logged;
		$datos_usuario = $this->db->select('usuario')->from('usuarios')->where('id_usuario', $usuario_id)->get()->row();
		$data['nombre_usuario'] = $datos_usuario->usuario;
		$data['usuario_id'] = $usuario_id;
		$data['tipo_usuario'] = $tipo_usuario;
		$data['hora'] = $hora;
		$data['fecha'] = $fecha;
		// $data['nombreAsistente'] = $nombreAsistente;
		// $data['nombreOrganizacion'] = $nombreOrganizacion;
		// $data['numNIT'] = $numNIT;
		// $data['correoElectronicoOrg'] = $correoElectronicoOrg;

		$this->load->view('include/header', $data);
		$this->load->view('certificados/certificado', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function crearCertificacion()
	{
		//URL
		$url = $_SERVER["REQUEST_URI"];
		$id_asistente_url = explode(":", $url);
		$id_asistente = $id_asistente_url[1];
		//Datos a consultar->
		$data_asistente = $this->db->select("*")->from("asistentes")->where("id_asistentes", $id_asistente)->get()->row();
		$id_curso = $data_asistente->informeActividades_id_informeActividades;
		$data_curso = $this->db->select("*")->from("informeActividades")->where("id_informeActividades", $id_curso)->get()->row();
		$id_org = $data_curso->organizaciones_id_organizacion;
		$datos_registro = $this->db->select('*')->from('organizaciones')->where('id_organizacion', $id_org)->get()->row();
		$datos_estado = $this->db->select('*')->from('estadoOrganizaciones')->where('organizaciones_id_organizacion', $id_org)->get()->row();
		$datos_resoluciones = $this->db->select('*')->from('resoluciones')->where('organizaciones_id_organizacion', $id_org)->get()->row();
		//Obtener Datos
		//Asistente
		$pnombre = $data_asistente->primerNombreAsistente;
		$snombre = $data_asistente->segundoNombreAsistente;
		$papellido = $data_asistente->primerApellidoAsistente;
		$sapellido = $data_asistente->segundoApellidoAsistente;
		$tipoDocumento = $data_asistente->tipoDocumentoAsistente;
		if ($tipoDocumento == "CC") {
			$tipoDocumento = "cédula de ciudadanía";
		} else if ($tipoDocumento == "CE") {
			$tipoDocumento = "cédula de extranjería";
		} else if ($tipoDocumento == "TI") {
			$tipoDocumento = "tarjeta de identidad";
		} else if ($tipoDocumento == "PS") {
			$tipoDocumento = "pasaporte";
		}
		$numDocumento = $data_asistente->numeroDocumentoAsistente;
		$correo = $data_asistente->direccionCorreoElectronicoAsistente;

		$numeroCertificado = $data_asistente->numCertificado;
		if ($numeroCertificado == NULL || $numeroCertificado == "NULL" || $numeroCertificado == "") {
			$numeroCertificado = random(10);
			$data_update_asistente = array(
				'numCertificado' => $numeroCertificado
			);
			$this->db->where('id_asistentes', $id_asistente);
			$this->db->update('asistentes', $data_update_asistente);
			$this->enviomail_cert($id_asistente, $correo);
		}
		//Curso
		$nombre_curso = $data_curso->nombreCurso;
		$nombre_curso = $data_curso->nombreCurso;
		$dep = $data_curso->departamentoCurso;
		$mun = $data_curso->municipioCurso;
		strtolower($mun);
		ucfirst($mun);
		$fechaCurso = $data_curso->fechaCurso;
		$fechaCurso = new DateTime($fechaCurso);
		$ano = $fechaCurso->format('Y');
		$mes = $fechaCurso->format('m');
		$dia = $fechaCurso->format('d');
		$_mes = strftime('%B', $mes);
		$_ano = strftime('Y', $ano);
		$duracionCurso = $data_curso->duracionCurso;
		//Organizacion del curso
		$nombreOrganizacion = $datos_registro->nombreOrganizacion;
		$numNIT = $datos_registro->numNIT;
		$sigla = $datos_registro->sigla;
		$primerNombrePersona = $datos_registro->primerNombreRepLegal;
		$segundoNombreRepLegal = $datos_registro->segundoNombreRepLegal;
		$primerApellidoPersona = $datos_registro->primerApellidoRepLegal;
		$segundoApellidoRepLegal = $datos_registro->segundoApellidoRepLegal;
		$rep = $primerNombrePersona . " " . $segundoNombreRepLegal . " " . $primerApellidoPersona . " " . $segundoApellidoRepLegal;
		$correoElectronicoOrg = $datos_registro->direccionCorreoElectronicoOrganizacion;
		$correoElectronicoRep = $datos_registro->direccionCorreoElectronicoRepLegal;
		//$variable = $datos_registro ->primerNombrePersona;
		//$variable = $datos_registro ->primerApellidoPersona;
		$imagen = $datos_registro->imagenOrganizacion;
		$firmaCert = $datos_registro->firmaCert;
		$personaCert = $datos_registro->personaCert;
		$cargoCert = $datos_registro->cargoCert;
		/**
			Se expide en Bogotá, D.C., a los escriba los días en letras (días en número) días del mes de escriba en letras el mes del año escriba el año en números
		 **/
		$nombreAsistente = "" . strtoupper($pnombre) . " " . strtoupper($snombre) . " " . strtoupper($papellido) . " " . strtoupper($sapellido);
		$documento = " con " . $tipoDocumento . " No. " . $numDocumento . "";
		$datosCurso_ = 'Participó y aprobó el programa de capacitación denominado "' . strtoupper($nombre_curso) . '"';
		$datosCurso =  "realizado en el municipo de " . strtoupper($mun) . " - " . $dep . ". En la fecha de " . $_mes . " " . $dia . " de " . $ano . ", con una intensidad de " . $duracionCurso . " horas.";
		$cuidad = "Se expide en Bogotá, D.C., a los " . date('d') . " días del mes de " . strftime("%B") . " del " . date('Y') . ".";
		$uaeos1 = "La Unidad Solidaria, de conformidad con el numeral 5.8";
		$uaeos2 = "del capítulo V del Decreto 4904 de 2009 y artículo 2.6.6.8 del Decreto 1075 de 2015";
		$estado = $datos_estado->nombre;
		$motivo = $datos_estado->motivoSolicitudAcreditado;
		$numeroResolucion = $datos_resoluciones->numeroResolucion;
		$num = 0;
		/*
		Estados:
			Acreditación Curso Basico de Economia Solidaria
			Acreditación, Aval de Trabajo Asociado
			Acreditación, Aval a otros Programas
			Acreditación, Aval de Trabajo Asociado, Aval a otros Programas

		Aval:
			"REPUBLICA DE COLOMBIA "$nombreOrganizacion" con NIT $numNIT, ACREDITADA Y AUTORIZADA PARA IMPARTIR
			EDUCACION EN ECONOMIA SOLIDARIA, CON AVAL AL PROGRAMA DE EDUCACIÓN SOLIDARIA CON ÉNFASIS
			EN TRABAJO ASOCIADO, POR LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDIARIAS,
			MEDIANTE RESOLUCIÓN No. $numeroResolucion."

		Sin aval:
			"REPUBLICA DE COLOMBIA "$nombreOrganizacion" con NIT $numNIT, ACREDITADA Y AUTORIZADA, 
			POR LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDARIAS
			MEDIANTE RESOLUCIÓN No. $numeroResolucion."
		*/
		// Se carga la libreria fpdf
		// Creacion del PDF

		/*
	     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
	     * heredó todos las variables y métodos de fpdf
	     */
		if ($numeroResolucion != null) {
			$this->load->library('pdf');

			$this->pdf = new Pdf('L', 'cm');
			// Agregamos una página
			$this->pdf->AddPage('L');
			$this->pdf->AddFont('Franklin', 'B', 'franklin.php');
			$this->pdf->AddFont('Franklin', 'U', 'franklin.php');
			$this->pdf->AddFont('Franklin', 'I', 'franklin.php');
			$this->pdf->Image(APPPATH . '../assets/img/certificados/marco.png', 0, 0, 295);
			if ($imagen != "default.png") {
				$this->pdf->Image(APPPATH . '../uploads/logosOrganizaciones/' . $imagen, 185, 13, 64, 26);
			}
			$this->pdf->SetTitle("Certificado - " . $numeroCertificado);
			$this->pdf->SetLeftMargin(40);
			$this->pdf->SetRightMargin(40);
			$this->pdf->SetFont('Franklin', 'I', 13);
			if ($sigla == "UAEOS" && $numNIT == "899999050-8") {
				$num = 30;
				$this->pdf->MultiCell(0, 38, '', 0);
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', $uaeos1), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', $uaeos2), 0, 'C');
			} else if ($motivo == "Acreditación Curso Basico de Economia Solidaria") {
				$num = 25;
				$this->pdf->MultiCell(0, 38, '', 0);
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', '"REPÚBLICA DE COLOMBIA "' . $nombreOrganizacion . '" con NIT ' . $numNIT . ', ACREDITADA Y AUTORIZADA, POR'), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDARIAS MEDIANTE RESOLUCIÓN No. " . $numeroResolucion . ""), 0, 'C');
			} else if ($motivo == "Acreditación, Aval de Trabajo Asociado") {
				$num = 20;
				$this->pdf->MultiCell(0, 38, '', 0);
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', 'REPÚBLICA DE COLOMBIA "' . $nombreOrganizacion . '" con NIT ' . $numNIT . ', PARA IMPARTIR EDUCACIÓN EN ECONOMÍA'), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "SOLIDARIA, CON AVAL AL PROGRAMA DE EDUCACIÓN SOLIDARIA CON ÉNFASIS EN TRABAJO ASOCIADO, POR"), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDIARIAS MEDIANTE RESOLUCIÓN No. " . $numeroResolucion . "."), 0, 'C');
			} else if ($motivo == "Acreditación, Aval a otros Programas") {
				$num = 20;
				$this->pdf->MultiCell(0, 38, '', 0);
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', 'REPÚBLICA DE COLOMBIA "' . $nombreOrganizacion . '" con NIT ' . $numNIT . ', PARA IMPARTIR EDUCACIÓN EN ECONOMÍA'), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "SOLIDARIA, CON AVAL AL PROGRAMA DE EDUCACIÓN SOLIDARIA CON ÉNFASIS EN TRABAJO ASOCIADO, POR"), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDIARIAS MEDIANTE RESOLUCIÓN No. " . $numeroResolucion . "."), 0, 'C');
			} else if ($motivo == "Acreditación, Aval de Trabajo Asociado, Aval a otros Programas") {
				$num = 20;
				$this->pdf->MultiCell(0, 38, '', 0);
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', 'REPÚBLICA DE COLOMBIA "' . $nombreOrganizacion . '" con NIT ' . $numNIT . ', PARA IMPARTIR EDUCACIÓN EN ECONOMÍA'), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "SOLIDARIA, CON AVAL AL PROGRAMA DE EDUCACIÓN SOLIDARIA CON ÉNFASIS EN TRABAJO ASOCIADO, POR"), 0, 'C');
				$this->pdf->MultiCell(0, 5, iconv('UTF-8', 'ISO-8859-1', "LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDIARIAS MEDIANTE RESOLUCIÓN No. " . $numeroResolucion . "."), 0, 'C');
			}
			$this->pdf->SetFont('Franklin', 'B', 13);
			$this->pdf->MultiCell(0, 1, '', 0);
			$this->pdf->MultiCell(0, 14, iconv('UTF-8', 'ISO-8859-1', 'Hace(n) CONSTAR QUE:'), 0, 'C');
			$this->pdf->SetFont('Franklin', 'B', 30);
			$this->pdf->MultiCell(0, 6, iconv('UTF-8', 'ISO-8859-1', $nombreAsistente), 0, 'C');
			$this->pdf->SetFont('Franklin', 'B', 19);
			$this->pdf->MultiCell(0, 12, iconv('UTF-8', 'ISO-8859-1', $documento), 0, 'C');
			$this->pdf->SetFont('Franklin', 'B', 14);
			$this->pdf->MultiCell(0, 6, '', 0);
			$this->pdf->MultiCell(0, 7, iconv('UTF-8', 'ISO-8859-1', $datosCurso_), 0, 'C');
			$this->pdf->SetFont('Franklin', 'B', 14);
			$this->pdf->MultiCell(0, 7, iconv('UTF-8', 'ISO-8859-1', $datosCurso), 0, 'C');
			$this->pdf->SetFont('Franklin', 'I', 14);
			$this->pdf->MultiCell(0, 10, '', 0);
			$this->pdf->MultiCell(0, 8, iconv('UTF-8', 'ISO-8859-1', $cuidad), 0, 'C');
			$this->pdf->MultiCell(0, $num, '', 0);
			$startx = $this->pdf->GetX();
			$starty = $this->pdf->GetY();
			//$this->pdf->Rect(40, 160, 100, 0, 'F');
			//$this->pdf->Rect(99, 165, 100, 0, 'F');
			//$this->pdf->MultiCell(100,5,iconv('UTF-8', 'ISO-8859-1','NOMBRE DEL COORDINADOR(A) DEL GRUPO DE'),0,'C');
			//$this->pdf->MultiCell(100,5,iconv('UTF-8', 'ISO-8859-1','EDUCACIÓN E INVESTIGACIÓN'),0,'C');
			//$this->pdf->MultiCell(100,5,iconv('UTF-8', 'ISO-8859-1','Coordinador(a) del Grupo de Educación e Investigación'),0,'C');
			//$this->pdf->MultiCell(100,5,iconv('UTF-8', 'ISO-8859-1','Unidad Administrativa Especial de Organizaciones Solidarias'),0,'C');
			//
			$this->pdf->SetXY($startx, $starty);
			$this->pdf->MultiCell(220, 6, iconv('UTF-8', 'ISO-8859-1', $personaCert), 0, 'C');
			$this->pdf->MultiCell(220, 6, iconv('UTF-8', 'ISO-8859-1', $cargoCert), 0, 'C');
			//$this->pdf->MultiCell(220,5,iconv('UTF-8', 'ISO-8859-1','Nombre de otra entidad (sólo cuando la capacitación se)'),0,'C');
			//$this->pdf->MultiCell(220,5,iconv('UTF-8', 'ISO-8859-1','realizó de manera compartida)'),0,'C');
			if ($firmaCert != "default.png") {
				$this->pdf->RotatedImage(APPPATH . '../uploads/logosOrganizaciones/firmaCert/' . $firmaCert, 115, 140, 60, 60, 10);
			}
			$this->pdf->SetFont('Franklin', 'B', 9);
			$this->pdf->MultiCell(0, 8, '', 0);
			$this->pdf->MultiCell(440, 0, iconv('UTF-8', 'ISO-8859-1', "Código de emisión: " . $numeroCertificado), 0, 'C');

			/* Se define el titulo, márgenes izquierdo, derecho y
		     * el color de relleno predeterminado
		     */
			/*
		     * Se manda el pdf al navegador
		     *
		     * $this->pdf->Output(nombredelarchivo, destino);
		     *
		     * I = Muestra el pdf en el navegador
		     * D = Envia el pdf para descarga
		     *
		     */

			$this->pdf->SetAuthor("Unidad Administrativa Especial de Organizaciones Solidarias", true);
			$this->pdf->SetSubject("Certificado de curso", true);
			$this->pdf->SetCreator("Sistema Integrado de Información de Acreditación", true);
			$this->pdf->SetKeywords("Certificado, SIIA, Acreditación", true);
			$this->pdf->SetTitle("Certificado: " . $nombreAsistente, true);
			$pdf = $this->pdf->Output();
			//shell_exec(pdftk '$pdf' output '$pdf' user_pw $numDocumento owner_pw siia);
		} else {
			date_default_timezone_set("America/Bogota");
			$logged = $this->session->userdata('logged_in');
			$nombre_usuario = $this->session->userdata('nombre_usuario');
			$usuario_id = $this->session->userdata('usuario_id');
			$tipo_usuario = $this->session->userdata('type_user');
			$hora = date("H:i", time());
			$fecha = date('Y/m/d');

			$data['title'] = 'Certificados';
			$data['logged_in'] = $logged;
			$datos_usuario = $this->db->select('usuario')->from('usuarios')->where('id_usuario', $usuario_id)->get()->row();
			$data['nombre_usuario'] = $datos_usuario->usuario;
			$data['usuario_id'] = $usuario_id;
			$data['tipo_usuario'] = $tipo_usuario;
			$data['hora'] = $hora;
			$data['fecha'] = $fecha;
			$data['nombreAsistente'] = $nombreAsistente;
			$data['nombreOrganizacion'] = $nombreOrganizacion;
			$data['numNIT'] = $numNIT;
			$data['correoElectronicoOrg'] = $correoElectronicoOrg;

			$this->load->view('include/header', $data);
			$this->load->view('paneles/errinforme', $data);
			$this->load->view('include/footer', $data);
			$this->logs_sia->logs('PLACE_USER');
		}
	}

	function enviomail_cert($id, $correo)
	{
		$correo_electronico = CORREO_SIA;
		$num_prioridad = 3;
		$to = $correo;

		$this->email->from($correo_electronico, "Acreditaciones");
		$this->email->to($to);
		$this->email->subject('SIIA: Certificado');
		$this->email->set_priority($num_prioridad);
		$mensaje = "Su certificación esta lista, puede consultarla dando click <a href='" . base_url() . "Certificado/?id:" . $id . "' target='_blank'>aquí</a> y descargarla.";
		$data_msg['mensaje'] = $mensaje;

		$email_view = $this->load->view('email/contacto', $data_msg, true);

		$this->email->message($email_view);

		if ($this->email->send()) {
			//echo json_encode(array('url'=>"login", 'msg'=>"Se envio el correo, por favor esperar la respuesta."));
		} else {
			echo json_encode(array('url' => "login", 'msg' => "Lo sentimos, hubo un error y no se envio el correo."));
		}
	}
}
