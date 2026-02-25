<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/BaseController.php';

class Reportes extends BaseController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('AsistentesModel');
		$this->load->model('RegistroTelefonicoModel');
		$this->load->model('InformeActividadesModel');
		$this->load->model('DocentesModel');
	}
	/**
     * Datos de sesión para administradores
     * @return array
     */
    public function datosSesionAdmin()
    {
        return $this->getBaseSessionData(true);
    }
	// Reportes panel principal
	public function index()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal / Administrador / Reportes';
		$data['activeLink'] = 'reportes';
		$this->loadView('admin/reportes/index', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	/** Entidades acreditadas */
	public function entidadesAcreditadas()
	{
		$data = $this->datosSesionAdmin();
		$data['activeLink'] = 'reportes';
		$data['title'] = 'Reportes - Entidades Acreditadas';
		$data['organizacionesAcreditadas'] = $this->OrganizacionesModel->getOrganizacionesAcreditadas();
		$this->loadView('admin/reportes/acreditadas', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
 	// Exportar reporte entidades acreditadas
	/** Registro Solicitudes */
	public function registroSolicitudes()
	{
		$data = $this->datosSession();
		$data['title'] = 'Registro de Solicitudes';
		$data['solicitudes'] = $this->SolicitudesModel->getSolicitudesAndOrganizacion();
		$this->load->view('include/header', $data);
		$this->load->view('admin/reportes/solicitudes', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// Exportar reporte entidades acreditadas
	public function exportarExcel() {
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// Configurar el encabezado con logo y título
		// Fusionar celdas para el logo y el título
		$objPHPExcel->getActiveSheet()->mergeCells('A1:B6');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:N6');

		// Añadir el título
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "LISTADO DE DE ENTIDADES ACREDITADAS POR LA UNIDAD\nPARA IMPARTIR PROCESOS DE FORMACION EN ECONOMIA SOLIDARIA " . date("d/m/y H:i"));

		// Estilo para el título
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);

		// Agregar logo si es necesario (necesitarás ajustar esto)
//		 $objDrawing = new PHPExcel_Worksheet_Drawing();
//		 $objDrawing->setName('Logo');
//		 $objDrawing->setDescription('Logo');
//		 $objDrawing->setPath(base_url() . "assets/img/siia_logo.png");
//		 $objDrawing->setCoordinates('A1');
//		 $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		// Versión, código y fecha
		$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'VERSIÓN 06');

		$objPHPExcel->getActiveSheet()->mergeCells('C7:G7');
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'CODIGO: FO-SC-010');

		$objPHPExcel->getActiveSheet()->mergeCells('H7:N7');
		$objPHPExcel->getActiveSheet()->setCellValue('H7', 'FECHA EDICIÓN 24/06/2024');

		// Estilos para versión, código y fecha
		$objPHPExcel->getActiveSheet()->getStyle('A7:N7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:N7')->getFont()->setBold(true);

		// Configurar borde para el encabezado
		$styleArray = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:N7')->applyFromArray($styleArray);

		// Encabezados de columnas (fila 8)
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getAlignment()->setWrapText(true);

		// Color de fondo para encabezados
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->getFill()->getStartColor()->setRGB('B3D8FF');

		// Establecer altura para la fila de encabezados
		$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(40);

		// Establecer encabezados de columnas
		$objPHPExcel->getActiveSheet()->SetCellValue('A8', 'NOMBRE DE LA ORGANIZACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('B8', 'NÚMERO NIT');
		$objPHPExcel->getActiveSheet()->SetCellValue('C8', 'TIPO DE ORGANIZACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('D8', 'CURSOS APROBADOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('E8', 'MODALIDAD APROBADA PARA EL CURSO');
		$objPHPExcel->getActiveSheet()->SetCellValue('F8', 'RESOLUCIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('G8', 'FECHA DE LA RESOLUCIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('H8', 'FECHA DE VENCIMIENTO DE LA ACREDITACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('I8', 'DEPARTAMENTO');
		$objPHPExcel->getActiveSheet()->SetCellValue('J8', 'MUNICIPIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('K8', 'DIRECCIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('L8', 'TELÉFONO');
		$objPHPExcel->getActiveSheet()->SetCellValue('M8', 'DIRECCIÓN WEB DE LA ENTIDAD ACREDITADA');
		$objPHPExcel->getActiveSheet()->SetCellValue('N8', 'CORREO ELECTRÓNICO ORGANIZACIÓN');

		// Aplicar bordes a los encabezados
		$objPHPExcel->getActiveSheet()->getStyle('A8:N8')->applyFromArray($styleArray);

		// Establecer ancho de columnas manualmente en lugar de autosize
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);

		// Comenzar datos desde la fila 9
		$rowCount = 9;
		$data = $this->OrganizacionesModel->getOrganizacionesAcreditadas();

		foreach ($data as $organizacion) {
			$link = base_url("uploads/resoluciones/" . $organizacion['resoluciones']->resolucion);
			$webSite = $organizacion['data_organizaciones_inf']->urlOrganizacion;
			if ($webSite == 'No Tiene' || $webSite == '') {
				$webSite = 'No Aplica';
			}
			else {
				$webSite = $organizacion['data_organizaciones_inf']->urlOrganizacion;
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $organizacion['data_organizaciones']->nombreOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $organizacion['data_organizaciones']->numNIT);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $organizacion['data_organizaciones_inf']->tipoOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $organizacion['resoluciones']->cursoAprobado);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $organizacion['resoluciones']->modalidadAprobada);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'RESOLUCIÓN NÚMERO ' . $organizacion['resoluciones']->numeroResolucion);
			$objPHPExcel->getActiveSheet()->getCell('F'.$rowCount)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
			$objPHPExcel->getActiveSheet()->getCell('F'.$rowCount)->getHyperlink()->setUrl(strip_tags($link));
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getFont()->setUnderline(true);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLUE));
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $organizacion['resoluciones']->fechaResolucionInicial);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $organizacion['resoluciones']->fechaResolucionFinal);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $organizacion['data_organizaciones_inf']->nomDepartamentoUbicacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $organizacion['data_organizaciones_inf']->nomMunicipioNacional);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $organizacion['data_organizaciones_inf']->direccionOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $organizacion['data_organizaciones_inf']->fax);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $webSite);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $organizacion['data_organizaciones']->direccionCorreoElectronicoOrganizacion);

			// Aplicar bordes a la fila de datos
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray($styleArray);

			// Establecer alineación para los datos
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount.':N'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			// Permitir que el texto se ajuste automáticamente
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->getAlignment()->setWrapText(true);

			$rowCount++;
		}

		// Configurar el título de la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Entidades acreditadas');

		// Configurar encabezados HTTP para la descarga
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="entidades-acreditadas.xlsx"');
		header('Cache-Control: max-age=0');

		// Crear el escritor y guardar el archivo
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		ob_end_clean();
		$objWriter->save('php://output');
	}
	// Exportar reporte entidades acreditadas con estadísticas
	public function check_in_range($start_date, $end_date, $evaluame) {
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$user_ts = strtotime($evaluame);

		return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
	}
	public function exportarExcelConteo() {
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:W1');
		$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray([
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'BDD7EE'] // Cambia 'FF0000' al código de color deseado
			]
		]);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'NOMBRE DE LA ENTIDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'NUMERO NIT');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TIPO DE ENTIDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CURSOS APROBADOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'BASICO');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'AVAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'MEDIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'AVANZADO');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'FINANCI');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'MODALIDAD DE LA SOLICITUD');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'PRESENCIAl');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'VIRTUAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'EN LINEA');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'RESOLUCIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'FECHA INICIO DE LA ACREDITACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'FECHA VENCIMIENTO DE LA ACREDITACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'MUNICIPIO');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'DEPARTAMENTO');
		$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'DIRECCIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'TELÉFONO');
		$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'DIRECCIÓN WEB DE LA ENTIDAD ACREDITADA');
		$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'CORREO ELECTRÓNICO ORGANIZACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'ID SOLICITUD');
		$rowCount = 2;
		$data = $this->OrganizacionesModel->getOrganizacionesAcreditadas();
		// Cursos
		$basico = 0;
		$medio = 0;
		$avanzado = 0;
		$financi = 0;
		$aval = 0;
		// Modalidades
		$presencial = 0;
		$linea = 0;
		$virtual = 0;
		// Organizaciones
		$organizaciones = array();
		foreach ($data as $organizacion) {
			// Conteo de modalidades y cursos
			$motivos = json_decode($organizacion['tipoSolicitud']->motivosSolicitud);
			foreach($motivos as $motivo) {
				switch($motivo) {
					case "1":
						$basico += 1;
						break;
					case "2":
						$aval += 1;
						break;
					case "3":
						$medio += 1;
						break;
					case "4":
						$avanzado += 1;
						break;
					case "5":
						$financi += 1;
						break;
					default:
						break;
				}
			}
			$modalidades = json_decode($organizacion['tipoSolicitud']->modalidadesSolicitud);
			foreach($modalidades as $modalidad) {
				switch($modalidad) {
					case "1":
						$presencial += 1;
						break;
					case "2":
						$virtual += 1;
						break;
					case "3":
						$linea += 1;
						break;
					default:
						break;
				}
			}
			$link = base_url("uploads/resoluciones/" . $organizacion['resoluciones']->resolucion);
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $organizacion['data_organizaciones']->nombreOrganizacion);
			// Si se encuentra el nit igual pinta de azul el dato
			if (in_array($organizacion['data_organizaciones']->numNIT, $organizaciones)) {
				$objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->applyFromArray([
					'fill' => [
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => ['rgb' => 'BDD7EE'] // Cambia 'FF0000' al código de color deseado
					]
				]);
			}
			// Agregar nit a array comparativo
			$organizaciones[$rowCount - 2] = $organizacion['data_organizaciones']->numNIT;
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $organizacion['data_organizaciones']->numNIT);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $organizacion['data_organizaciones_inf']->tipoOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $organizacion['resoluciones']->cursoAprobado);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $basico);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $aval);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $medio);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $avanzado);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $financi);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $organizacion['resoluciones']->modalidadAprobada);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $presencial);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $virtual);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $linea);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'RESOLUCIÓN NÚMERO ' . $organizacion['resoluciones']->numeroResolucion);
			$objPHPExcel->getActiveSheet()->getCell('N'.$rowCount)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
			$objPHPExcel->getActiveSheet()->getCell('N'.$rowCount)->getHyperlink()->setUrl(strip_tags($link));
			$objPHPExcel->getActiveSheet()->getStyle('N'.$rowCount)->getFont()->setUnderline(true);
			$objPHPExcel->getActiveSheet()->getStyle('N'.$rowCount)->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLUE));
			// Si la resolución es de este mes pinta de azul el dato
			$dateStart = new DateTime();
			$dateStart->modify('first day of this month');
			$inicio_mes = $dateStart->format('Y-m-d');
			$dateEnd = new DateTime();
			$dateEnd->modify('last day of this month');
			$fin_mes = $dateEnd->format('Y-m-d');
			$fecha_inicial = new DateTime();
			$fecha_inicial = $dateEnd->format($organizacion['resoluciones']->fechaResolucionInicial);
			if ($this->check_in_range($inicio_mes, $fin_mes, $fecha_inicial)) {
				$objPHPExcel->getActiveSheet()->getStyle('O' . $rowCount)->applyFromArray([
					'fill' => [
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => ['rgb' => 'BDD7EE'] // Cambia 'FF0000' al código de color deseado
					]
				]);
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $organizacion['resoluciones']->fechaResolucionInicial);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $organizacion['resoluciones']->fechaResolucionFinal);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $organizacion['data_organizaciones_inf']->nomMunicipioNacional);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $organizacion['data_organizaciones_inf']->nomDepartamentoUbicacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $organizacion['data_organizaciones_inf']->direccionOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $organizacion['data_organizaciones_inf']->fax);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $organizacion['data_organizaciones_inf']->urlOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $organizacion['data_organizaciones']->direccionCorreoElectronicoOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $organizacion['tipoSolicitud']->idSolicitud);
			foreach(range('A','W') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
					->setAutoSize(true);
			}
			$rowCount ++;
			// Reinició de contadores para el siguiente dato
			// Cursos
			$basico = 0;
			$medio = 0;
			$avanzado = 0;
			$financi = 0;
			$aval = 0;
			// Modalidades
			$presencial = 0;
			$linea = 0;
			$virtual = 0;
		}
		$objPHPExcel->getActiveSheet()->setTitle('Estadisticas');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="entidades-acreditadas-estadisticas.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
	}
	// Exportar datos abiertos en CSV con tildes correctas
	public function exportarDatosAbiertos() {
    	while (ob_get_level()) { ob_end_clean(); }
    	header('Content-Type: text/csv; charset=UTF-16LE');
    	header('Content-Disposition: attachment; filename="datos-abiertos.csv"');
    	header('Pragma: no-cache');
    	header('Expires: 0');
    	$out = fopen('php://output', 'w');
    	fwrite($out, "\xFF\xFE");
    	fwrite($out, mb_convert_encoding("sep=;\r\n", 'UTF-16LE', 'UTF-8'));

		// Array de encabezados con tildes
		$headers = [
			'NOMBRE DE LA ENTIDAD',
			'NÚMERO NIT',
			'SIGLA DE LA ENTIDAD',
			'ESTADO ACTUAL DE LA ENTIDAD',
			'FECHA CAMBIO DE ESTADO',
			'TIPO DE ENTIDAD',
			'DIRECCIÓN DE LA ENTIDAD',
			'DEPARTAMENTO DE LA ENTIDAD',
			'MUNICIPIO DE LA ENTIDAD',
			'TELÉFONO DE LA ENTIDAD',
			'EXTENSIÓN',
			'URL DE LA ENTIDAD',
			'ACTUACIÓN DE LA ENTIDAD',
			'TIPO DE EDUCACIÓN DE LA ENTIDAD',
			'PRIMER NOMBRE REPRESENTANTE LEGAL',
			'SEGUNDO NOMBRE REPRESENTANTE LEGAL',
			'PRIMER APELLIDO REPRESENTANTE LEGAL',
			'SEGUNDO APELLIDO REPRESENTANTE LEGAL',
			'NÚMERO CÉDULA REPRESENTANTE LEGAL',
			'CORREO ELECTRÓNICO ENTIDAD',
			'CORREO ELECTRÓNICO REPRESENTANTE LEGAL',
			'NÚMERO DE LA RESOLUCIÓN',
			'FECHA DE INICIO DE LA RESOLUCIÓN',
			'AÑOS DE LA RESOLUCIÓN',
			'MOTIVO DE LA SOLICITUD',
			'MODALIDAD DE LA SOLICITUD'
		];

		$escape = function ($v) {
			if ($v === null) { $v = ''; }
			$v = (string)$v;
			$enc = mb_detect_encoding($v, ['UTF-8','ISO-8859-1','Windows-1252'], true);
			if ($enc && $enc !== 'UTF-8') { $v = mb_convert_encoding($v, 'UTF-8', $enc); }
			if (strpos($v, '"') !== false) { $v = str_replace('"', '""', $v); }
			if (strpbrk($v, ";\r\n") !== false) { $v = '"' . $v . '"'; }
			return $v;
		};
		$line = implode(';', array_map($escape, $headers)) . "\r\n";
		fwrite($out, mb_convert_encoding($line, 'UTF-16LE', 'UTF-8'));

		// Obtener datos
		$data = $this->OrganizacionesModel->getOrganizacionesAcreditadas();

		// Escribir filas de datos
		foreach ($data as $organizacion) {
			$row = [
				$organizacion['data_organizaciones']->nombreOrganizacion,
				$organizacion['data_organizaciones']->numNIT,
				$organizacion['data_organizaciones']->sigla,
				$organizacion['data_organizaciones']->estado,
				$organizacion['resoluciones']->fechaResolucionInicial,
				$organizacion['data_organizaciones_inf']->tipoOrganizacion,
				$organizacion['data_organizaciones_inf']->direccionOrganizacion,
				$organizacion['data_organizaciones_inf']->nomDepartamentoUbicacion,
				$organizacion['data_organizaciones_inf']->nomMunicipioNacional,
				$organizacion['data_organizaciones_inf']->fax,
				$organizacion['data_organizaciones_inf']->extension,
				$organizacion['data_organizaciones_inf']->urlOrganizacion,
				$organizacion['data_organizaciones_inf']->actuacionOrganizacion,
				$organizacion['data_organizaciones_inf']->tipoEducacion,
				$organizacion['data_organizaciones']->primerNombreRepLegal,
				$organizacion['data_organizaciones']->segundoNombreRepLegal,
				$organizacion['data_organizaciones']->primerApellidoRepLegal,
				$organizacion['data_organizaciones']->segundoApellidoRepLegal,
				$organizacion['data_organizaciones_inf']->numCedulaCiudadaniaPersona,
				$organizacion['data_organizaciones']->direccionCorreoElectronicoOrganizacion,
				$organizacion['data_organizaciones']->direccionCorreoElectronicoRepLegal,
				$organizacion['resoluciones']->numeroResolucion,
				$organizacion['resoluciones']->fechaResolucionInicial,
				$organizacion['resoluciones']->anosResolucion,
				$organizacion['resoluciones']->cursoAprobado,
				$organizacion['resoluciones']->modalidadAprobada
			];

			$line = implode(';', array_map($escape, $row)) . "\r\n";
			fwrite($out, mb_convert_encoding($line, 'UTF-16LE', 'UTF-8'));
		}

		fclose($out);
		exit;
	}
	public function entidadesAcreditadasSin()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal - Administrador - Reportes';
		$data['organizacionesAcreditadas'] = $this->OrganizacionesModel->getOrganizacionesAcreditadas();
		$this->load->view('include/header', $data);
		$this->load->view('admin/reportes/acreditadasSin', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function entidadesHistorico()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal - Administrador - Reportes';
		$data['organizacionesHistorico'] = $this->OrganizacionesModel->getOrganizacionesHistorico();
		$this->load->view('include/header', $data);
		$this->load->view('admin/reportes/historico', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function verAsistentes()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal - Administrador - Reportes Asistentes';
		$data['asistentes'] = $this->AsistentesModel->getAsistentes();
		$this->load->view('include/header', $data);
		$this->load->view('admin/reportes/asistentes', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	public function registroTelefonico()
	{
		$data = $this->datosSesionAdmin();
		$data['title'] = 'Panel Principal - Administrador - Registro telefónico';
		$data['registros'] = $this->RegistroTelefonicoModel->getRegistrosTelefonicos();
		$this->loadView('admin/reportes/telefonicos', $data, 'main');
		$this->logs_sia->logs('PLACE_USER');
	}
	public function docentesHabilitados()
	{
		$data = $this->datosSession();
		$data['title'] = 'Panel Principal - Administrador - Reportes Docentes';
		$data['docentes'] = $this->DocentesModel->getDocentesHabilitados();
		$this->load->view('include/header', $data);
		$this->load->view('admin/reportes/docentes', $data);
		$this->load->view('include/footer', $data);
		$this->logs_sia->logs('PLACE_USER');
	}
	// TODO: Ver información de informe de actividades
	public function verInformacion()
	{
		$data_ = array();
		$informes = $this->db->select("*")->from("informeActividades")->get()->result();
		foreach ($informes as $informe) {
			$id_informe = $informe->id_informeActividades;
			$asistentes = $this->db->select("*")->from("asistentes")->where("informeActividades_id_informeActividades", $id_informe)->get()->result();
			array_push($data_, $asistentes);
		}
		echo json_encode(array("informe" => $informes, "asistentes" => $data_));
	}
	// Exportar reporte de informe de actividades
	public function exportarExcelInformeActividades($anio = null) {
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// Configurar encabezados
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:S1');
		$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray([
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'BDD7EE']
			]
		]);
		// Establecer títulos de columnas (expandidos)
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'NIT');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'NOMBRE ORGANIZACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SIGLA');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'DEPARTAMENTO ORGANIZACIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'DEPARTAMENTO INFORME');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'MUNICIPIO INFORME');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ID INFORME');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'FECHA INFORME');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'NÚMERO DE HOMBRES');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'NÚMERO DE MUJERES');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'TOTAL REPORTADO');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'TOTAL ASISTENTES');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'PERSONAS 5-18 AÑOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'PERSONAS 18-26 AÑOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'PERSONAS 27-40 AÑOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'PERSONAS 41-60 AÑOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'PERSONAS MAYORES 60 AÑOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'PERSONAS SIN EDAD DEFINIDA');
		$rowCount = 2;
		$data = $this->InformeActividadesModel->getInformeActividadesDetallado($_GET['anio'] ? $_GET['anio'] : 2024);
		// Variables para tracking de totales por departamento
		$totalesDepartamento = [];
		$departamentoActual = '';
		foreach ($data as $informe) {
			// Calcular total reportado (hombres + mujeres)
			$totalReportado = $informe->hombres + $informe->mujeres;
			// Si cambió el departamento, agregar fila de totales del departamento anterior
			if ($departamentoActual != '' && $departamentoActual != $informe->departamentoInforme) {
				$this->agregarFilaTotalDepartamento($objPHPExcel, $rowCount, $departamentoActual, $totalesDepartamento[$departamentoActual]);
				$rowCount++;
			}
			// Actualizar departamento actual
			$departamentoActual = $informe->departamentoInforme;
			// Inicializar totales del departamento si no existe
			if (!isset($totalesDepartamento[$departamentoActual])) {
				$totalesDepartamento[$departamentoActual] = [
					'informes' => 0,
					'hombres' => 0,
					'mujeres' => 0,
					'total_reportado' => 0,
					'total_asistentes' => 0,
					'personas_5_18' => 0,
					'personas_18_26' => 0,
					'personas_27_40' => 0,
					'personas_41_60' => 0,
					'personas_60' => 0,
					'ns_nr' => 0
				];
			}
			// Acumular totales del departamento
			$totalesDepartamento[$departamentoActual]['informes']++;
			$totalesDepartamento[$departamentoActual]['hombres'] += $informe->hombres;
			$totalesDepartamento[$departamentoActual]['mujeres'] += $informe->mujeres;
			$totalesDepartamento[$departamentoActual]['total_reportado'] += $totalReportado;
			$totalesDepartamento[$departamentoActual]['total_asistentes'] += $informe->total_asistentes;
			$totalesDepartamento[$departamentoActual]['personas_5_18'] += $informe->personas_5_18;
			$totalesDepartamento[$departamentoActual]['personas_18_26'] += $informe->personas_18_26;
			$totalesDepartamento[$departamentoActual]['personas_27_40'] += $informe->personas_27_40;
			$totalesDepartamento[$departamentoActual]['personas_41_60'] += $informe->personas_41_60;
			$totalesDepartamento[$departamentoActual]['personas_60'] += $informe->personas_60;
			$totalesDepartamento[$departamentoActual]['ns_nr'] += $informe->ns_nr;
			// Llenar datos del informe
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $informe->numNIT);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $informe->nombreOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $informe->sigla);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $informe->departamentoOrganizacion);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $informe->departamentoInforme);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $informe->municipioInforme);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $informe->id_informeActividades);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $informe->fechaInicio);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $informe->hombres);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $informe->mujeres);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totalReportado);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $informe->total_asistentes);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $informe->personas_5_18);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $informe->personas_18_26);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $informe->personas_27_40);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $informe->personas_41_60);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $informe->personas_60);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $informe->ns_nr);
			$rowCount++;
		}
		// Agregar fila de totales del último departamento
		if ($departamentoActual != '' && isset($totalesDepartamento[$departamentoActual])) {
			$this->agregarFilaTotalDepartamento($objPHPExcel, $rowCount, $departamentoActual, $totalesDepartamento[$departamentoActual]);
			$rowCount++;
		}
		// Agregar fila de totales generales
		$this->agregarFilaTotalGeneral($objPHPExcel, $rowCount, $totalesDepartamento);
		// Auto-ajustar columnas
		foreach(range('A','R') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$filename = 'informe-actividades-detallado' . ($_GET['anio'] ? '-' . $_GET['anio'] : '') . '.xlsx';
		$objPHPExcel->getActiveSheet()->setTitle('Informe Actividades Detallado');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		ob_end_clean();
		$objWriter->save('php://output');
	}
	// Función auxiliar para agregar fila de totales por departamento
	private function agregarFilaTotalDepartamento($objPHPExcel, $rowCount, $departamento, $totales) {
		// Aplicar estilo a la fila de totales
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':R'.$rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':R'.$rowCount)->applyFromArray([
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'E2EFDA']
			]
		]);
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'TOTAL ' . strtoupper($departamento));
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $departamento);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totales['informes'] . ' informes');
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totales['hombres']);
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totales['mujeres']);
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totales['total_reportado']);
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totales['total_asistentes']);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totales['personas_5_18']);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totales['personas_18_26']);
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totales['personas_27_40']);
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totales['personas_41_60']);
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $totales['personas_60']);
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $totales['ns_nr']);
	}
	// Función auxiliar para agregar fila de totales generales
	private function agregarFilaTotalGeneral($objPHPExcel, $rowCount, $totalesDepartamento) {
		// Calcular totales generales
		$totalGeneral = [
			'informes' => 0,
			'hombres' => 0,
			'mujeres' => 0,
			'total_reportado' => 0,
			'total_asistentes' => 0,
			'personas_5_18' => 0,
			'personas_18_26' => 0,
			'personas_27_40' => 0,
			'personas_41_60' => 0,
			'personas_60' => 0,
			'ns_nr' => 0
		];
		foreach ($totalesDepartamento as $departamento => $totales) {
			$totalGeneral['informes'] += $totales['informes'];
			$totalGeneral['hombres'] += $totales['hombres'];
			$totalGeneral['mujeres'] += $totales['mujeres'];
			$totalGeneral['total_reportado'] += $totales['total_reportado'];
			$totalGeneral['total_asistentes'] += $totales['total_asistentes'];
			$totalGeneral['personas_5_18'] += $totales['personas_5_18'];
			$totalGeneral['personas_18_26'] += $totales['personas_18_26'];
			$totalGeneral['personas_27_40'] += $totales['personas_27_40'];
			$totalGeneral['personas_41_60'] += $totales['personas_41_60'];
			$totalGeneral['personas_60'] += $totales['personas_60'];
			$totalGeneral['ns_nr'] += $totales['ns_nr'];
		}
		// Aplicar estilo a la fila de totales generales
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':R'.$rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':R'.$rowCount)->applyFromArray([
			'fill' => [
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'FFE699']
			]
		]);
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'TOTAL GENERAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'TODOS');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $totalGeneral['informes'] . ' informes');
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $totalGeneral['hombres']);
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $totalGeneral['mujeres']);
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $totalGeneral['total_reportado']);
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $totalGeneral['total_asistentes']);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $totalGeneral['personas_5_18']);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $totalGeneral['personas_18_26']);
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $totalGeneral['personas_27_40']);
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $totalGeneral['personas_41_60']);
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $totalGeneral['personas_60']);
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $totalGeneral['ns_nr']);
	}
}
