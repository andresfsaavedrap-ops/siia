<div class="clearfix"></div>
<!-- Modales -->
<div class="" id="modals-sia">
	<div class="modal fade in" id="panelPrincipal" tabindex="-1" role="dialog" aria-labelledby="panelprincipalh">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="panelprincipalh">Ayuda <i class="fa fa-info" aria-hidden="true"></i></h4>
				</div>
				<div class="modal-body">
					<img style="margin: 0 auto;" src="<?php echo base_url("assets/img/siia_logo.png"); ?>" class="img-responsive" alt="Banner">
					<hr />
					<?php echo $informacionModal; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="cerrarModalpanelPrincipal" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Informe de actividades -->
	<div class="modal fade in" id="modalInformeAct2019" tabindex="-1" role="dialog" aria-labelledby="modalInformeAct2019j">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalInformeAct2019j">Módulo de informe de actividades <i class="fa fa-flag" aria-hidden="true"></i></h4>
				</div>
				<div class="modal-body">
					<p><strong>¡Este módulo estará disponible en el 2023, espéralo!</strong></p>
					<p><small>En cumplimiento de la circular 001 de 2018 este módulo se activará en enero de 2019. En 2018 se emitirán las certificaciones de cursos como tradicionalmente se ha venido realizando.” Esto con el fin de evitar que se emitan certificaciones este año."</small></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" id="cerrarModalpanelPrincipal" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para batería de observaciones -->
	<div class="modal fade in" id="modalBateriaObservaciones" tabindex="-1" role="dialog" aria-labelledby="modalBateriaObservaciones">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4>Observaciones</h4>
					<div class="form-group">
						<label>Tipo de observación:</label>
						<br>
						<select name="tipoBateriaObservacion" id="tipoBateriaObservacion" data-id-dep="1" class="selectpicker form-control show-tick">
							<option id="0" value="1" selected>1. Información General de la Entidad </option>
							<option id="1" value="2">2. Documentación Legal </option>
							<option id="1" value="3">3. Registros educativos de Programas </option>
							<option id="2" value="4">4. Antecedentes Académicos </option>
							<option id="3" value="5">5. Jornadas de actualización </option>
							<option id="4" value="6">6. Programa básico de economía solidaria </option>
							<option id="5" value="7">7. Programas Aval </option>
							<option id="6" value="8">8. Programas </option>
							<option id="7" value="9">9. Facilitadores </option>
							<option id="8" value="10">10. Datos Plataforma Virtual </option>
							<option id="9" value="11">Observaciones Generales </option>
						</select>
					</div>
					<div class="form-group">
						<label>Titulo:</label>
						<input type="text" class="form-control" id="tituloBateriaObservacion" placeholder="Titulo...">
					</div>
					<div class="form-group">
						<label>Observación:</label>
						<textarea class="form-control" id="observacionBateriaObservacion" placeholder="Observación..." rows="7"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-siia btn-sm" id="crearBateriaObservacion">Crear observación <i class="fa fa-check" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-warning btn-sm" id="actualizarBateriaObservacion">Actualizar observación <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- //Modal relación de cambios -->
	<div class="modal fade" id="modalRelacionCambios" tabindex="-1" role="dialog" aria-labelledby="relacionCambios">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<div class="d-flex justify-content-between align-items-center w-100">
						<h4 class="modal-title mb-0" id="relacionCambios">Relación de cambios</h4>
						<div class="d-flex align-items-center">
							<a id="verRelacionFiltrada" href="#" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm mr-2">Ver tabla de relación de cambios para filtrar y descargar <i class="fa fa-table" aria-hidden="true"></i></a>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-white">&times;</span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="tabla_relacionCambio" width="100%" border=0 class="table table-striped table-bordered tabla_form">
							<thead>
								<tr>
									<td>Titulo</td>
									<td class="col-md-6">Descripcion</td>
									<td>Fecha</td>
								</tr>
							</thead>
							<tbody id="tbody_relacionCambios">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal pedir cámara -->
	<div class="modal fade" id="modalPedirCamara" tabindex="-1" role="dialog" aria-labelledby="pedircamara">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="pedircamara">¿Realmente quiere pedir la cámara de comercio? </h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal">No, cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-success btn-sm pull-right" id="">Si, estoy seguro de pedir la cámara <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Link terminos -->
	<div class="modal fade" id="terminosCondiciones" tabindex="-1" role="dialog" aria-labelledby="terminosCondiciones">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="terminosCondiciones">Términos, condiciones y características de uso del trámite</h3>
				</div>
				<div class="modal-body">
					<p>El trámite no tiene costo.</p>
					<hr />
					<label>Características de los anexos:</label>
					<p>Los archivos deben estar en <strong>formato/extensión</strong> (<span class="spanRojo">pdf</span>) en <strong>minúscula</strong>.</p>
					<p>Las imagenes deben estar en <strong>formato/extensión</strong> (<span class="spanRojo">jpg/png/jpeg</span>) en <strong>minúscula</strong>.</p>
					<p>Los archivos deben tener un <strong>tamaño maximo</strong> de (<span class="spanRojo">~ 10</span>) Mb (megabytes).</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Servicio de atención -->
	<div class="modal fade" id="servicioAtencion" tabindex="-1" role="dialog" aria-labelledby="servicioAtencion">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="servicioAtencion">Servicio de atención</h3>
				</div>
				<div class="modal-body">
					<ul>
						<li><a href="<?php echo PAGINA_WEB ?>" target="_blank">Página web de la Unidad Administrativa Especial de Organizaciones Solidarias</a></li>
						<li><a href="mailto:<?php echo CORREO_ATENCION ?>" target="_blank"><?php echo CORREO_ATENCION ?></a></li>
						<li>Atención telefónica al <strong>3275252</strong> Ext. <strong>192-301</strong> (Bogotá); línea gratuita nacional <strong>018000122020</strong></li>
						<li>Atención personalizada: <strong>Carrera 10 No. 15 - 22</strong> Lunes a viernes de <strong>8 a.m. a 5:00 p.m.</strong>, en la ciudad de Bogotá.</li>
						<li>A través del Chat en la página web los días <strong>martes y jueves</strong> de <strong>9 am a 12 pm</strong></li>
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para ver historial de observaciones -->
	<div class="modal fade" id="verHistObsUs" tabindex="-1" role="dialog" aria-labelledby="verhistobsus">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					<h3 class="modal-title" id="verhistobsus">Observaciones</h3>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<label>Historial de observaciones:</label>
							<table id="tabla_historial_obs" width="100%" border=0 class="table table-striped table-bordered tabla_form">
								<thead>
									<tr>
										<td class="col-md-2">Formulario</td>
										<td class="col-md-2">Campo del formulario</td>
										<td class="col-md-2">Observación</td>
										<!--<td class="col-md-2">Valor del usuario</td>-->
										<td class="col-md-2">Fecha de Observación</td>
										<td class="col-md-1">Número de Revision</td>
										<!--<td class="col-md-1">Id de Solicitud</td>-->
									</tr>
								</thead>
								<!-- //TODO: Se cargan todas las observaciones -->
								<tbody id="tbody_hist_obs">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" id="crr_hist_obs" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Formulario Registro Llamadas -->
	<div class="modal fade" id="modal_form_registro_llamadas" tabindex="-1" role="dialog" aria-labelledby="ayudaLogin">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="ayudaLogin">Registrar Llamada </h4>
				</div>
				<div class="modal-body">
					<p>Por favor completa los datos </p>
					<?= validation_errors('formulario_registro'); ?>
					<?= form_open_multipart('', array('id' => 'formulario_registro_telefonico')); ?>
					<input type="hidden" name="telefonicoIdAdministrador" id="telefonicoIdAdministrador" value="<?= $usuario_id ?>">
					<div class="container-fluid p-2" id="formulario-registro-telefonico">
						<!-- Organización -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="telefonicoNitOrganizacion">Organización <span class="spanRojo">*</span></label>
									<select name="telefonicoNitOrganizacion" id="telefonicoNitOrganizacion" class="selectpicker form-control" required>
										<?php foreach ($organizaciones as $organizacion) : ?>
											<option value="<?= $organizacion->id_organizacion ?>"><?= $organizacion->numNIT ?> | <?= $organizacion->sigla ?> </option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div><br>
						<!-- Funcionario y Cargo -->
						<div class="row">
							<div class="col-md-6">
								<!-- Funcionario -->
								<div class="form-group">
									<label>Funcionario con el que se habló: <span class="spanRojo">*</span></label>
									<input type="text" class="form-control" name="telefonicoFuncionario" id="telefonicoFuncionario" placeholder="Nombre completo funcionario" required>
								</div>
							</div>
							<div class="col-md-6">
								<!-- Cargo -->
								<div class="form-group">
									<label>Cargo: <span class="spanRojo">*</span></label>
									<input type="text" class="form-control" name="telefonicoCargo" id="telefonicoCargo" placeholder="Cargo" required>
								</div>
							</div>
						</div>
						<!-- Teléfono y Tipo Llamada -->
						<div class="row">
							<!-- Teléfono -->
							<div class="col-md-6">
								<div class="form-group">
									<label>Teléfono: <span class="spanRojo">*</span></label>
									<input type="number" class="form-control" name="telefonicoTelefono" id="telefonicoTelefono" placeholder="Teléfono" required>
								</div>
							</div>
							<!-- Tipo Llamada -->
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de llamada: <span class="spanRojo">*</span></label>
									<select name="telefonicoTipoLlamada" id="telefonicoTipoLlamada" class="form-control show-tick telefonicoTipoLlamada" required>
										<option value="" selected>Seleccione tipo</option>
										<option value="Entrante">Entrante</option>
										<option value="Saliente">Saliente</option>
									</select>
								</div>
							</div>
						</div>
						<!-- Tipo Comunicación ID Solicitud -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de comunicación: <span class="spanRojo">*</span></label>
									<select name="telefonicoTipoComunicacion" id="telefonicoTipoComunicacion" class="form-control show-tick telefonicoTipoComunicacion" required>
										<option value="" selected>Seleccione tipo</option>
										<option value="Técnica">Asistencia Técnica</option>
										<option value="Plataforma">Asistencia Plataforma</option>
										<option value="Otra">Otra</option>
									</select>
								</div>
							</div>
							<!-- Id Solicitud -->
							<div class="col-md-6">
								<div class="form-group">
									<label>ID Solicitud:</label>
									<select name="telefonicoIdSolicitud" id="telefonicoIdSolicitud" class="form-control show-tick" disabled>
									</select>
								</div>
							</div>
						</div><br>
						<!-- Fecha y Duración-->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Fecha: <span class="spanRojo">*</span></label>
									<input type="date" class="form-control" name="telefonicoFecha" id="telefonicoFecha" value="<?= date('Y-m-d'); ?>" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Duración:</label>
									<select name="telefonicoDuracion" id="telefonicoDuracion" class="form-control show-tick telefonicoDuracion" required>
										<option value="1-10">1 - 10 minutos</option>
										<option value="10-30">10 - 30 minutos</option>
										<option value="30 - 1">30 - 1 hora</option>
										<option value="1+">Mas 1 hora</option>
									</select>
								</div>
							</div>
						</div>
						<!-- Descripción -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Descripción de la consulta: <span class="spanRojo">*</span></label>
									<textarea class="form-control" name="telefonicoDescripcion" id="telefonicoDescripcion" rows="4" placeholder="Descripción de la llamada" required></textarea>
								</div>
							</div>
						</div>
					</div>
					<?= form_close() ?>
				</div>
				<div class="modal-footer">
					<button id="guardarRegistroTelefonico" class="btn btn-siia btn-sm btn-block">Guardar Registro <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal - FIN -->
<a id="back-to-top" class="btn btn-siia back-to-top" role="button" title="Volver arriba" data-toggle="tooltip" data-placement="left"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
<!-- Footer Content -->
<footer>
	<div class="clearfix"></div>
	<br>
	<div class="container" id="footer">
		<div class="row">
			<div class="container">
				<div>
					<div class="col-md-8 center-block">
						<p id="text-footer">Unidad Administrativa Especial de Organizaciones Solidarias</p>
					</div>
					<div class="pull-right col-md-4" id="icons-redes">
						<a target="_blank" class="icon-fb-footer" title="Facebook" href="https://www.facebook.com/USolidariaCo/?ref=page_internal"></a>
						<a target="_blank" class="icon-flickr-footer" title="Flickr" href="https://www.flickr.com/photos/orgsolidarias"></a>
						<a target="_blank" class="icon-twitter-footer" title="Twitter" href="https://twitter.com/USolidariaCo?s=20"></a>
						<a target="_blank" class="icon-youtube-footer" title="Youtube" href="https://www.youtube.com/user/Orgsolidariastv"></a>
						<a target="_blank" class="icon-rss-footer" title="Fuente RSS" href="<?php echo PAGINA_WEB ?>RSS"></a>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<div class="col-md-2">
						<i class="fa fa-home icon-footer" aria-hidden="true"></i>
					</div>
					<div class="col-md-10 text-footer-l-i">
						<p>Carrera 10 No 15-22, Bogotá, D.C</p>
						<label>Horario de atención:</label>
						<p> 8:00 a.m. - 5:00 p.m.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="col-md-2">
						<i class="fa fa-phone icon-footer" aria-hidden="true"></i>
					</div>
					<div class="col-md-10 text-footer-l-i">
						<label>PBX:</label>
						<p> 57+1 3275252</p>
						<label>Fax:</label>
						<p> 3275248</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="col-md-2">
						<i class="fa fa-envelope-o icon-footer" aria-hidden="true"></i>
					</div>
					<div class="col-md-10 text-footer-l-i">
						<label><a href="" target="_blank" title="Contáctenos">Contáctenos</a></label>
						<br /><br />
						<p><a href="mailto:<?php echo CORREO_ATENCION ?>" target="_blank" id="mailto_org" title="<?php echo CORREO_ATENCION ?>"><?php echo CORREO_ATENCION ?></a></p>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<div>
						<small id="small_footer">Para la mejor experiencia de usuario en la aplicación SIIA por favor usar <a title="Explorador Google Chrome" href="https://www.google.es/chrome/browser/desktop/index.html" target="_blank">Google Chrome</a> con una versión mínima de 56 ó <a title="Explorador Mozilla Firefox" href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank">Mozilla Firefox</a> con una versión mínima de 52 y habilitar <a href="https://get.adobe.com/es/flashplayer/" target="_blank">Flash Player</a>. Para que sus contraseñas sean seguras por favor verificarlas <a href="https://password.kaspersky.com/es/" target="_blank" title="Verificar la Contraseña">Aquí</a>.</small>
					</div>
					<br />
				</div>
			</div>
		</div>
	</div>
	<div class="container" id="sub-footer">
		<div class="row">
			<div id="col-md-12" class="text-center">
				<small>
					<p title="Unidad Solidaria">Copyright © <?php echo date('Y'); ?> Unidad Solidaria |
						<a target="_blank" title="Politicas de Privacidad y Condiciones de Uso" href="<?php echo PAGINA_WEB ?>sites/default/files/archivos/terminos%20de%20uso.pdf">Politicas de Privacidad y Condiciones de Uso</a> | <a title="Administrador" href="<?php echo base_url() ?>admin">Administrador</a> | SIIA v1.0.8.181022-Prod
					</p>
				</small>
			</div>
		</div>
	</div>
</footer>
<div class="hidden" id="scripts-siia">
	<!-- Sweetalert2 -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!--<link href="<?php echo base_url('assets/css/styles.min.css') ?>" rel="stylesheet" type="text/css" />-->
	<link href="<?php echo base_url('assets/css/notifIt.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-select.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/animate.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-dropdownhover.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/mdb.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/vis.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Scripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
	<script src="<?php echo base_url('assets/js/modernizr.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-3.1.1.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/notifIt.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-select.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/langs/selector-i18n/defaults-es_ES.js') ?>" type="text/javascript"></script>
	<!-- Data Tables -->
	<script src="<?php echo base_url('assets/js/popper.min.js') ?>" type="text/javascript"></script>
	<!-- <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script> -->
	<script src="<?php echo base_url('assets/js/jquery.dataTables.nuevo.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/dataTables.buttons.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.html5.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.print.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.flash.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.colVis.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jszip.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/pdfmake.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/vfs_fonts.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.bootstrap.min.js') ?>" type="text/javascript"></script>
	<!-- Fin Data Tables -->
	<script src="<?php echo base_url('assets/js/sidebar-menu.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/paging.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-dropdownhover.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/echarts.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/map/js/world.js') ?>"></script>
	<!--<script src="<?php echo base_url('assets/js/mdbs.min.js') ?>"></script>-->
	<script src="<?php echo base_url('assets/js/ckeditor.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/initck.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/vis.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/functions/main.js?v=1.0.8.61219') . time() ?>" type="module"></script>
	<script type="module" src="<?= base_url('assets/js/functions/login.js?v=1.0.7.61342') . time() ?>"></script>
	<script src="<?php echo base_url('assets/js/functions/perfil.js?v=1.1.0') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/organizaciones.js?v=1.1.0') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/admin/modules/solicitudes/observaciones.js?v=1.1.1') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/estados.js?v=1.2.1') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/resoluciones.js?v=1.4.1') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/nits.js?v=1.5.1') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/solicitud.js?v=1.0.0') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/contacto.js?v=1.0.8.61') . time() ?>" type="module"></script>
	<script src="<?php echo base_url('assets/js/functions/estadisticas.js?v=1.0.8.62') . time() ?>" type="module"></script>
	<!--<script src="<?php echo base_url('assets/js/main.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/script.js') ?>" type="text/javascript"></script>-->
	<script type="text/javascript">
		$(window).on('load', function() {
			$(".se-pre-con").fadeOut("slow");
		});
	</script>
	<!--Add the following script at the bottom of the web page (immediately before the </body> tag)-->
	<!--<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=49054954"></script>-->
</div>
</body>

</html>
