<?php
/***
 * @var $organizacion
 * @var $solicitudes
 * @var $informacionGeneral
 */
$CI = &get_instance();
$CI->load->model("ResolucionesModel");
/*echo "<pre>";
var_dump($solicitudes);
die();
echo "</pre>";*/
?>
<script>
	var organizacion = '<?= $organizacion->numNIT ?>';
</script>
<!-- Panel Principal -->
<div id="panel_inicial" class="container center-block">
	<div class="clearfix"></div>
	<hr />
	<!-- Botón Solicitudes -->
	<div class="col-md-3">
		<div class="panel panel-siia verSolicitudes">
			<div class="panel-heading">
				<h3 class="panel-title">Solicitud <i class="fa fa-file" aria-hidden="true"></i></h3>
			</div>
			<div class="panel-body">
				<button class="btn btn-default btn-block form-control verSolicitudes" id="verSolicitudes">IR A SOLICITUDES</button>
			</div>
		</div>
	</div>
	<!-- Botón Perfil -->
	<div class="col-md-3">
		<div class="panel panel-siia ver_perfil">
			<div class="panel-heading">
				<h3 class="panel-title">Perfil <i class="fa fa-user" aria-hidden="true"></i></h3>
			</div>
			<div class="panel-body">
				<button class="btn btn-default btn-block ver_perfil" id="ver_perfil">Perfil de la organización</button>
			</div>
		</div>
	</div>
	<?php if ($informacionGeneral): ?>
		<!-- Botón Facilitadores -->
		<div class="col-md-3">
			<div class="panel panel-siia ver_docentes">
				<div class="panel-heading">
					<h3 class="panel-title">Grupo de facilitadores <i class="fa fa-users" aria-hidden="true"></i></h3>
				</div>
				<div class="panel-body">
					<button class="btn btn-default btn-block ver_docentes" id="ver_docentes">Facilitadores </button>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if($solicitudes): ?>
		<?php
			$estado = array();
			foreach ($solicitudes as $solicitud):
				array_push($estado, $solicitud->nombre);
			endforeach; ?>
		<?php if(in_array("Acreditado", $estado)): ?>
			<!-- Botón Plan Mejoramiento -->
			<div class="col-md-3">
				<div class="panel panel-siia ver_plan_mejoramiento">
					<div class="panel-heading">
						<h3 class="panel-title">Planes de mejoramiento <i class="fa fa-thumbs-up" aria-hidden="true"></i></h3>
					</div>
					<div class="panel-body">
						<button class="btn btn-default btn-block ver_plan_mejoramiento" id="ver_plan_mejoramiento">Plan de mejoramiento </button>
					</div>
				</div>
			</div>
			<!-- Informe de actividades -->
			<div class="col-md-3">
				<div class="panel panel-siia ver_informe_actividades">
					<div class="panel-heading">
						<h3 class="panel-title">Informes <i class="fa fa-flag" aria-hidden="true"></i></h3>
					</div>
					<div class="panel-body">
						<button class="btn btn-default btn-block ver_informe_actividades" id="ver_informe_actividades">Informe de actividades </button>
					</div>
				</div>
			</div>
			<!-- Informe de actividades -->
<!--			<div class="col-md-3">-->
<!--				<div class="panel panel-siia">-->
<!--					<div class="panel-heading">-->
<!--						<h3 class="panel-title">Informes <i class="fa fa-flag" aria-hidden="true"></i></h3>-->
<!--					</div>-->
<!--					<div class="panel-body">-->
<!--						<button class="btn btn-default form-control" data-toggle="modal" data-toggle="modal" data-target="#modalInformeAct2019">Informes de Actividades </button>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
            <!-- Contacto -->
            <!--<div class="col-md-3 hidden">
                <div class="panel panel-siia contacto">
                  <div class="panel-heading">
                    <h3 class="panel-title">Contacto <i class="fa fa-envelope" aria-hidden="true"></i></h3>
                  </div>
                  <div class="panel-body">
                    <button class="btn btn-default btn-block contacto" id="contacto">Contacto </button>
                  </div>
                </div>
            </div>-->
		<?php endif; ?>
	<?php endif; ?>
	<div class="col-md-3">
		<div class="panel panel-siia ayuda">
			<div class="panel-heading">
				<h3 class="panel-title">Ayudas <i class="fa fa-question-circle" aria-hidden="true"></i></h3>
			</div>
			<div class="panel-body">
				<button class="btn btn-default btn-block ayuda" id="ayuda">Ayuda y manuales </button>
			</div>
		</div>
	</div>
</div>
<!-- Crear Solicitud-->
<div id="crearSolicitudes" class="container center-block">
	<div class="container-fluid">
		<h3>Solicitudes registradas</h3>
		<p>Para crear una nueva solicitud por favor pulsa en el botón "Crear Nueva". Si cuentas con solicitudes, aquí puedes revisar su estado. </p>
		<hr />
		<button class="btn btn-danger btn-sm volverPanel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
		<div class="form-group">
			<button data-toggle="modal" data-target="#contingenciaSIIA" id='nuevaSolicitud2' class='btn btn-siia btn-md pull-right'>
				Crear Nueva  <i class='fa fa-plus' aria-hidden='true'></i>
			</button>
		</div>
		<hr />
		<br>
	</div>
</div>
<!-- Formulario Crear Solicitud  -->
<div id="tipoSolicitud" class="col-md-5 center-block">
	<?php echo form_open('', array('id' => 'formulario_crear_solicitud')); ?>
	<div class="clearfix"></div>
	<hr>
	<label for="motivo_solicitud">Motivo de la solicitud:<span class="spanRojo">*</span></label><br>
	<!-- CheckBox Motivos de la solicitud -->
	<form-group>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="1" id="cursoBasico" name="motivos" checked>
			<label class="form-check-label" for="cursoBasico">Acreditación Curso Básico de Economía Solidaria</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="2" id="avalTrabajo" name="motivos">
			<label class="form-check-label" for="avalTrabajo">Aval de Trabajo Asociado</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="3" id="cursoMedio" name="motivos">
			<label class="form-check-label" for="cursoMedio">Acreditación Curso Medio de Economía Solidaria</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="4" id="cursoAvanzado" name="motivos">
			<label class="form-check-label" for="cursoAvanzado">Acreditación Curso Avanzado de Economía Solidaria</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="5" id="finacieraEconomia" name="motivos">
			<label class="form-check-label" for="finacieraEconomia">Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria</label>
		</div>
	</form-group>
	<hr>
	<!-- Modalidad de la solicitud -->
	<label for="modalidad_solicitud">Modalidad:<span class="spanRojo">*</span></label><br>
	<!-- Ayuda para modalidad virtual -->
	<form-group>
		<i data-toggle="modal" data-target="#ayudaModalidad" class="fa fa-question-circle pull-right" aria-hidden="true"></i>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="1" id="presencial" name="modalidades" checked>
			<label class="form-check-label" for="presencial">Presencial</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="2" id="virtual" name="modalidades">
			<label class="form-check-label" for="virtual">Virtual</label>
		</div>
		<div class="form-check radio">
			<input class="form-check-input" type="checkbox" value="3" id="enLinea" name="modalidades">
			<label class="form-check-label" for="enLinea">En Linea</label>
		</div>
	</form-group>
	<hr>
	<br>
	<?php echo form_close(); ?>
	<button id="guardar_formulario_tipoSolicitud" class="btn btn-siia btn-sm pull-right">Crear solicitud <i class="fa fa-check" aria-hidden="true"></i></button>
	<button class="btn btn-danger btn-sm volverSolicitudes"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a solicitudes</button>
	<!-- Modal Ayuda Modalidad Virtual  -->
	<div class="modal fade" id="ayudaModalidadVirtual" tabindex="-1" role="dialog" aria-labelledby="ayudaModalidadVirtual" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xs" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">¿Está seguro de presentar la modalidad virtual?</h4>
				</div>
				<div class="modal-body">
					<p>De acuerdo a lo establecido en el parágrafo número 1 del artículo 6 de la resolución 152 del 23 de junio del 2022, las entidades que soliciten la acreditación por la modalidad en línea deben tener en cuenta lo siguiente:</p>
					<p><strong>Parágrafo 1.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad virtual, la entidad solicitante deberá demostrar que el proceso educativo se hace en una <stron>plataforma</stron> (sesiones clase, materiales de apoyo, actividades, evaluaciones) que propicie un Ambiente Virtual de Aprendizaje - AVA y Objetos Virtuales de Aprendizaje- OVAS. </p>
					<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
					<p>La Unidad Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
					<!--				<a class="pull-right" target="_blank" href="https://www.orgsolidarias.gov.co/sites/default/files/archivos/Res_110%20del%2031%20de%20marzo%20de%202016.pdf">Recurso de la resolución 110</a>-->
				</div>
				<div class="modal-footer">
					<button type="button" id="noModVirt" class="btn btn-danger btn-sm pull-left">No, quizá mas adelante <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" id="siModVirt" class="btn btn-siia btn-sm pull-right" data-dismiss="modal">Si, esto seguro de presentar la modalidad virtual <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Ayuda Modalidad En Línea  -->
	<div class="modal fade" id="ayudaModalidadEnLinea" tabindex="-1" role="dialog" aria-labelledby="ayudaModalidadEnLinea" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xs" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">¿Está seguro de presentar la modalidad en Línea?</h4>
				</div>
				<div class="modal-body">
					<p>De acuerdo a lo establecido en el parágrafo número 2 del artículo 6 de la resolución 152 del 23 de junio del 2022, las entidades que soliciten la acreditación por la modalidad en línea, deben tener en cuenta lo siguiente:</p>
					<p><strong>Parágrafo 2.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad línea, aquella donde los docentes y participantes interactúan a través de recursos tecnológicos. La mediación tecnológica puede ser a través de herramientas tecnológica (Zoom, Teams, Meet, Good Meet, entre otras) plataformas de comunicación, chats, foros, videoconferencias, grupos de discusión, caracterizadas por encuentros sincrónicos.</strong> </p>
					<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
					<p>La Unidad Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
					<!--				<a class="pull-right" target="_blank" href="https://www.orgsolidarias.gov.co/sites/default/files/archivos/Res_110%20del%2031%20de%20marzo%20de%202016.pdf">Recurso de la resolución 110</a>-->
				</div>
				<div class="modal-footer">
					<button type="button" id="noModEnLinea" class="btn btn-danger btn-sm pull-left">No, quizá más adelante <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" id="siModEnLinea" class="btn btn-siia btn-sm pull-right" data-dismiss="modal">Si, esto seguro de presentar la modalidad en linea <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Solicitudes Registradas -->
<div id="solicitudesRegistradas2" class="container center-block">
	<!-- Tabla herramientas -->
	<?php if($solicitudes): ?>
		<table id="" width="100%" border=0 class="table table-striped table-bordered">
			<thead>
			<tr>
				<td colspan="8"><h4 style="text-align: center">SOLICITUDES</h4></td>
			</tr>
			<tr>
				<td>IDSolicitud</td>
				<td>Creada</td>
				<td>Estado</td>
				<td>Motivo</td>
				<td>Modalidad</td>
				<td>Acciones</td>
			</tr>
			</thead>
			<tbody id="tbody">
				<?php foreach ($solicitudes as $solicitud): ?>
					<tr>
						<td><?= $solicitud->idSolicitud ?></td>
						<td><?= $solicitud->fechaCreacion ?></td>
						<td><?= $solicitud->nombre ?></td>
						<td><?= $solicitud->motivoSolicitudAcreditado ?></td>
						<td><?= $solicitud->modalidadSolicitudAcreditado ?></td>
						<?php if($solicitud->nombre == "En Proceso" || $solicitud->nombre == "En Renovación"): ?>
						<td>
							<div class='btn-group-vertical' role='group' aria-label='acciones'>
								<button type='button' class='btn btn-siia btn-sm verSolicitud' data-id="<?= $solicitud->idSolicitud ?>" title='Continuar Solicitud'>
									Continuar <i class='fa fa-check' aria-hidden='true'></i>
								</button>
								<button type='button' class='btn btn-danger btn-sm eliminarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Eliminar Solicitud'>
									Eliminar <i class='fa fa-trash' aria-hidden='true'></i>
								</button>
								<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
									Detalle <i class='fa fa-info' aria-hidden='true'></i>
								</button>
								<button type='button' data-toggle="modal" data-target="#contingenciaSIIARenovacion" class='btn btn-success btn-sm renovarrSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Continuar Solicitud'>
									Renovar <i class='fa fa-check' aria-hidden='true'></i>
								</button>
							</div>
						</td>
						<?php endif; ?>
						<?php if($solicitud->nombre == "Acreditado" || $solicitud->nombre == "Archivada" || $solicitud->nombre == "Negada" || $solicitud->nombre == "Revocada" || $solicitud->nombre == "Vencida" ): ?>
						<td>
							<div class='btn-group-vertical' role='group' aria-label='acciones'>
								<?php $resolucion = $CI->ResolucionesModel->getResolucionSolicitud($solicitud->idSolicitud) ?>
								<?php if($resolucion): ?>
								<a class="btn btn-sm btn-siia" style="text-decoration: none; color: #951919;" href="<?= base_url() . 'uploads/resoluciones/' . $resolucion->resolucion; ?>" target='_blank'>
									Resolución <i class='fa fa-eye' aria-hidden='true'></i>
								</a>
								<?php
									// Capturar datos de fechas para comprobación
									$fechaActual = new DateTime();
									$fechaFinResolucion = new DateTime($resolucion->fechaResolucionFinal);
									$diferencia = $fechaFinResolucion->diff($fechaActual)->days;
									$fechaLimiteRenovacion = $fechaFinResolucion->modify('+2 months');
									//$date =	strtotime('-1 month', strtotime($resolucion->fechaResolucionFinal));
									//$date = date('Y-m-d', $date);
									// Comprobar que la fecha actual no sea mayor a la fecha límite y tampoco se pueda renovar con mas de dos meses antes de veces la resolución
									if($diferencia <= 60 && $solicitud->nombre == 'Acreditado' && $fechaActual <= $fechaLimiteRenovacion): ?>
										<button type='button' class='btn btn-success btn-sm renovarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Continuar Solicitud'>
											Renovar <i class='fa fa-check' aria-hidden='true'></i>
										</button>
									<?php endif; ?>
								<?php endif; ?>
								<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
									Detalle <i class='fa fa-info' aria-hidden='true'></i>
								</button>
							</div>
						</td>
						<?php endif; ?>
						<?php if($solicitud->nombre == "Finalizado"): ?>
						<td>
							<div class='btn-group-vertical' role='group' aria-label='acciones'>
								<button class='btn btn-siia btn-sm verObservaciones' data-id="<?= $solicitud->idSolicitud ?>" title='Ver Estado'>
									Estado <i class='fa fa-eye' aria-hidden='true'></i>
								</button>
								<button type='button' class='btn btn-danger btn-sm eliminarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Eliminar Solicitud'>
									Eliminar <i class='fa fa-trash' aria-hidden='true'></i>
								</button>
								<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
									Detalle <i class='fa fa-info' aria-hidden='true'></i>
								</button>
							</div>
						</td>
						<?php endif; ?>
						<?php if($solicitud->nombre == "En Observaciones"): ?>
						<td>
							<div class='btn-group-vertical' role='group' aria-label='acciones'>
								<button class='btn btn-warning btn-sm verObservaciones' data-id="<?= $solicitud->idSolicitud ?>" title='Ver Observaciones'>
									Observaciones <i class='fa fa-eye' aria-hidden='true'></i>
								</button>
								<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
									Detalle <i class='fa fa-info' aria-hidden='true'></i>
								</button>
							</div>
						</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- Modal Detalle Solicitud -->
		<div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="modalVerDetalle">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="row">
							<div id="header_politicas" class="col-md-12">
								<img alt="logo" id="imagen_header_politicas" height="" class="img-responsive" src="<?php echo base_url() ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
							</div>
							<div class="clearfix"></div>
							<hr />
							<div class="col-md-12">
								<h4>Detalles de la solicitud</h4>
							</div>
						</div>
					</div>
					<div class="modal-body">
						<div class="card">
							<div class="card-body">
								<div class="container-fluid">
									<div class="row">
										<div class="col-lg-6" style="text-align: left;" id="informacionSolicitudBasico">
										</div>
										<div class="col-lg-6" style="text-align: left;" id="informacionSolicitudFechas">
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="col-lg-12" style="text-align: left;" id="informacionSolicitudEstado"></div>
										<div class="col-lg-6" style="text-align: left;" id="informacionResolucion"></div>
									</div>
								</div>
							</div>
						</div>
						<hr />
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar. <i class="fa fa-times" aria-hidden="true"></i></button>
<!--							<button type="button" class="btn btn-siia btn-sm pull-right" id="">Sí, acepto. <i class="fa fa-check"></i></button>-->
					</div>
				</div>
			</div>
		</div>
	<?php endif	?>
</div>
<!-- Div cerrado de abajo Arregla que no exista footer cuando no hay solicitudes-->
</div>
<!-- Modal contingencia -->
<div class="modal fade" id="contingenciaSIIA" tabindex="-1" role="dialog" aria-labelledby="contingenciaSIIA" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Atención!
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button></h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" role="alert">
					<p>
						<strong>¡La plataforma ya está lista!</strong> Ahora puede presentar su solicitud en la siguiente dirección:
						<a href="https://acreditacion.unidadsolidaria.gov.co/siia-resolucion-078/" target="_self">
							<strong>Acceder a la plataforma</strong>
						</a>.
					</p>
					<p>
						Le sugerimos realizar la lectura de la <strong>Resolución No. 078 del 7 de abril de 2025</strong> y su documento anexo,
						así como preparar los documentos requeridos para agilizar el proceso de ingreso de información.
					</p>
				</div>

				<div class="row justify-content-center mt-4">
					<div class="col-md-12 text-center">
						<h5>Descargar Resolución</h5>
						<div class="d-flex justify-content-around mt-3">
							<a href="<?= base_url("assets/docs/resolucion078/RESOLUCIÓN_078_DE_2025.pdf"); ?>" target="_blank" class="btn btn-siia" title="Descargar Word">
								<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
								<span class="d-block mt-1"> Resolución No. 078 del 7 de abril de 2025.</span>
							</a>
						</div>
					</div>

					<div class="col-md-12 text-center">
						<div class="d-flex justify-content-around mt-3">
							<a href="<?= base_url("assets/docs/resolucion078/Anexo_técnico _Resolucion_078_de_2025.pdf"); ?>" target="_blank" class="btn btn-primary" title="Descargar Word">
								<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
								<span class="d-block mt-1">Anexo técnico</span>
							</a>
							<a href="<?= base_url("assets/docs/resolucion078/malla-seas.pdf"); ?>" target="_blank" class="btn btn-danger" title="Descargar PDF">
								<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
								<span class="d-block mt-1">Malla Programa Organizaciones y Redes</span>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
					<i class="fa fa-check mr-2" aria-hidden="true"></i> Entendido
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal contingencia renovación -->
<div class="modal fade" id="contingenciaSIIARenovacion" tabindex="-1" role="dialog" aria-labelledby="contingenciaSIIARenovacion" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Atención!
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</h4>
			</div>
			<div class="modal-body">
				<div class="modal-body">
					<div class="alert alert-warning" role="alert">
						<p>
							La renovación de su solicitud ahora debe realizarse en la nueva plataforma.
							Por favor, acceda a través del siguiente enlace:
							<a href="https://acreditacion.unidadsolidaria.gov.co/siia-resolucion-078/" target="_self">
								<strong>Renovar solicitud aquí</strong>
							</a>.
						</p>
						<p>
							Asegúrese de contar con todos los documentos requeridos antes de proceder con la renovación.
						</p>
					</div>
					<div class="row justify-content-center mt-4">
						<div class="col-md-12 text-center">
							<h5>Descargar Resolución</h5>
							<div class="d-flex justify-content-around mt-3">
								<a href="<?= base_url("assets/docs/resolucion_078.pdf"); ?>" target="_blank" class="btn btn-siia" title="Descargar Word">
									<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i>
									<span class="d-block mt-1"> Resolución No. 078 del 7 de abril de 2025.</span>
								</a>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<div class="d-flex justify-content-around mt-3">
								<a href="<?= base_url("assets/docs/anexo_resolucion_078_.docx"); ?>" target="_blank" class="btn btn-primary" title="Descargar Word">
									<i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i>
									<span class="d-block mt-1">Anexo técnico</span>
								</a>
								<a href="<?= base_url("assets/docs/malla-seas.pdf"); ?>" target="_blank" class="btn btn-danger" title="Descargar PDF">
									<i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
									<span class="d-block mt-1">Malla Programa Organizaciones y Redes</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
					<i class="fa fa-check mr-2" aria-hidden="true"></i> Entendido
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Estilo adicional para mejorar la apariencia -->
<style>
	#contingenciaSIIA .modal-content {
		border-radius: 8px;
		box-shadow: 0 5px 15px rgba(0,0,0,.3);
	}

	#contingenciaSIIA .modal-header {
		border-top-left-radius: 8px;
		border-top-right-radius: 8px;
		padding: 15px 20px;
	}

	#contingenciaSIIA .modal-body {
		padding: 20px;
	}

	#contingenciaSIIA .btn-danger,
	#contingenciaSIIA .btn-primary {
		padding: 10px 15px;
		margin: 0 10px;
		border-radius: 5px;
		transition: all 0.3s ease;
	}

	#contingenciaSIIA .btn-danger:hover,
	#contingenciaSIIA .btn-primary:hover {
		transform: translateY(-3px);
		box-shadow: 0 4px 8px rgba(0,0,0,.2);
	}

	#contingenciaSIIA .alert-success {
		background-color: #cbfdcb;
		border-left: 4px solid #17b824;
		border-radius: 0;
		padding: 15px;
		color: #495057;
	}

	#contingenciaSIIA .modal-footer {
		border-top: 1px solid #e9ecef;
		padding: 15px 20px;
	}

	#contingenciaSIIA .btn-success {
		padding: 8px 20px;
		font-weight: 500;
	}
</style>
