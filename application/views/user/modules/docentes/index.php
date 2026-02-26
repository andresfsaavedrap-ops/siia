<?php
/***
 * @var $organizacion
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 * @var $docentes
 */
/*echo '<pre>';
var_dump($informacionGeneral);
echo '</pre>';
return null;*/
?>
<script src="<?= base_url('assets/js/functions/user/modules/docentes/docentes.js?v=1.1') . time() ?>" type="module"></script>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<?php if(!$informacionGeneral): ?>
				<?php $this->load->view('user/modules/solicitudes/partials/_alerta_informacion_general'); ?>
			<?php else: ?>
				<?php $this->load->view('user/modules/docentes/partials/_agregar_docente'); ?>
				<?php $this->load->view('user/modules/docentes/partials/_docentes'); ?>
			<?php endif; ?>
		</div>
	</div>
	<!-- Modal: Ver Docente -->
	<div class="modal" id="verDocenteOrg" tabindex="-1" role="dialog" aria-labelledby="verdocenteorg">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="verdocenteorg">
						<i class="ti-user mr-2"></i>Facilitador: <span id="nombre_doc" class="font-weight-bold"></span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Estado del facilitador -->
					<div class="d-flex justify-content-between mb-3">
						<div>
							<h6 class="mb-0">
								Estado:
								<span id="valido_doc" class="badge badge-pill" style="font-size: 90%;"></span>
							</h6>
						</div>
						<div>
							<button type="button" class="btn btn-outline-danger btn-sm" data-toggle='modal' data-target='#eliminarDocente'>
								<i class="ti-trash mr-1"></i> Eliminar facilitador
							</button>
						</div>
					</div>
					<!-- Instrucciones -->
					<div class="alert alert-info p-3" id='instrucciones_docente'>
						<div class="d-flex">
							<div class="mr-3">
								<i class="ti-info-alt text-info" style="font-size: 24px;"></i>
							</div>
							<div>
								<h6 class="text-info mb-2">Información importante</h6>
								<ul class="pl-3 mb-0" style="list-style-type: none;">
									<li><i class="ti-angle-right text-info mr-2"></i>Los campos marcados con <code class="bg-light px-1">*</code> son <strong>requeridos</strong>.</li>
									<li><i class="ti-angle-right text-info mr-2"></i>Los archivos deben estar en formato <code class="bg-light px-1">PDF</code> (minúscula).</li>
									<li><i class="ti-angle-right text-info mr-2"></i>Tamaño máximo por archivo: <code class="bg-light px-1">10 MB</code>.</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- Tabs para organizar las secciones -->
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos-content" role="tab" aria-controls="datos-content" aria-selected="true">
								<i class="ti-user mr-1"></i> Datos Básicos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="documentos-tab" data-toggle="tab" href="#documentos-content" role="tab" aria-controls="documentos-content" aria-selected="false">
								<i class="ti-clip mr-1"></i> Cargar Documentos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="adjuntos-tab" data-toggle="tab" href="#adjuntos-content" role="tab" aria-controls="adjuntos-content" aria-selected="false">
								<i class="ti-file mr-1"></i> Documentos Cargados
							</a>
						</li>
					</ul>
					<div class="tab-content py-3">
						<!-- Tab Datos Básicos -->
						<div class="tab-pane fade show active" id="datos-content" role="tabpanel" aria-labelledby="datos-tab">
							<?php echo form_open_multipart('', array('id' => 'formulario_actualizar_docente', 'class' => 'forms-sample')); ?>
							<div class="card">
								<div class="card-body">
									<div id="observaciones_docente_wrap" class="alert alert-warning mb-3 d-none">
										<div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Observación actual:</strong>
                                                <div id="observacion_doc"></div>
                                            </div>
                                            <!-- Botón para ver historial en modal -->
                                            <button type="button" id="verHistObsDocente" class="btn btn-sm btn-outline-primary ml-3">
                                                <i class="ti-agenda mr-1"></i> Ver historial
                                            </button>
                                        </div>
									</div>
									<div class="row">
										<!-- Primer Nombre -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Primer Nombre <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="primer_nombre_doc" placeholder="Ingrese primer nombre">
											</div>
										</div>
										<!-- Segundo Nombre -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Segundo Nombre</label>
												<input type="text" class="form-control" id="segundo_nombre_doc" placeholder="Ingrese segundo nombre">
											</div>
										</div>
									</div>
									<div class="row">
										<!-- Primer Apellido -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Primer Apellido <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="primer_apellido_doc" placeholder="Ingrese primer apellido">
											</div>
										</div>
										<!-- Segundo Apellido -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Segundo Apellido</label>
												<input type="text" class="form-control" id="segundo_apellido_doc" placeholder="Ingrese segundo apellido">
											</div>
										</div>
									</div>
									<div class="row">
										<!-- Número de Cédula -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Número de Cédula <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="numero_cedula_doc" placeholder="Ingrese número de cédula">
											</div>
										</div>
										<!-- Profesión -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Profesión <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="profesion_doc" placeholder="Ingrese profesión">
											</div>
										</div>
									</div>
									<div class="row">
										<!-- Horas de Capacitación -->
										<div class="col-md-6">
											<div class="form-group">
												<label>Horas de Capacitación <span class="text-danger">*</span></label>
												<input type="text" class="form-control" id="horas_doc" placeholder="Ingrese horas de capacitación">
											</div>
										</div>
									</div>
									<div class="text-right">
										<button type="button" class="btn btn-primary actualizar_docente" value="No">
											<i class="ti-save mr-1"></i> Actualizar datos básicos
										</button>
									</div>
								</div>
							</div>
							</form>
						</div>
						<!-- Tab Documentos -->
						<div class="tab-pane fade" id="documentos-content" role="tabpanel" aria-labelledby="documentos-tab">
							<div class="row">
								<div class="col-md-6">
									<!-- Hoja de vida -->
									<div class="card mb-4">
										<div class="card-header bg-light">
											<h6 class="mb-0"><i class="ti-id-badge mr-1"></i> Hoja de vida <span class="text-danger">*</span></h6>
										</div>
										<div class="card-body">
											<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_hojavida')); ?>
											<small class="text-muted">Solo adjuntar la hoja de vida <strong>sin soporte alguno</strong>.</small>
											<div class="form-group">
												<input type="file" form="formulario_archivo_docente_hojavida" required accept="application/pdf" class="file-upload-default" data-val="docenteHojaVida" name="docenteHojaVida" id="docenteHojaVida">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar hoja de vida">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="text-right">
												<button type="button" class="btn btn-primary btn-sm archivos_form_hojaVidaDocente" data-name="docenteHojaVida" name="hojaVidaDocente" id="hojaVidaDocente">
													<i class="ti-cloud-up mr-1"></i> Cargar archivo
												</button>
											</div>
											</form>
										</div>
									</div>

									<!-- Certificados exp -->
									<div class="card">
										<div class="card-header bg-light">
											<h6 class="mb-0"><i class="ti-medall mr-1"></i> Certificados de experiencia (3) <span class="text-danger">*</span></h6>
										</div>
										<div class="card-body">
											<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_certificados')); ?>
											<small class="text-muted">Solo adjuntar certificados como <strong>conferensista</strong>, <strong>docente</strong>, <strong>tallerista</strong>, <strong>instructor</strong>, entre otros. Evitar relacionar como <strong>asesor</strong>, <strong>cargos directivos</strong>, etc.</small>
											<div class="form-group">
												<input type="file" required accept="application/pdf" class="file-upload-default" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados1">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar certificado experiencia">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="form-group">
												<input type="file" required accept="application/pdf" class="file-upload-default" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados2">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar certificado experiencia">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="form-group">
												<input type="file" required accept="application/pdf" class="file-upload-default" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados3">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar certificado experiencia">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="text-right">
												<button type="button" class="btn btn-primary btn-sm archivos_form_certificadoDocente" data-name="docenteCertificados" name="certificadoDocente" id="certificadoDocente">
													<i class="ti-cloud-up mr-1"></i> Cargar archivo
												</button>
											</div>
											</form>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<!-- Certificado título -->
									<div class="card mb-4">
										<div class="card-header bg-light">
											<h6 class="mb-0"><i class="ti-crown mr-1"></i> Título Profesional <span class="text-danger">*</span></h6>
										</div>
										<div class="card-body">
											<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_titulo')); ?>
											<small class="text-muted">Solo adjuntar el <strong>diploma ó acta de grado</strong>.</small>
											<div class="form-group">
												<input type="file" required accept="application/pdf" class="file-upload-default" data-val="docenteTitulo" name="docenteTitulo" id="docenteTitulo">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar titulo profesional">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="text-right">
												<button type="button" class="btn btn-primary btn-sm archivos_form_tituloDocente" data-name="docenteTitulo" name="tituloDocente" id="tituloDocente">
													<i class="ti-cloud-up mr-1"></i> Cargar archivo
												</button>
											</div>
											</form>
										</div>
									</div>

									<!-- Certificados economía solidaria -->
									<div class="card">
										<div class="card-header bg-light">
											<h6 class="mb-0"><i class="ti-wallet mr-1"></i> Certificados de economía solidaria <span class="text-danger">*</span></h6>
										</div>
										<div class="card-body">
											<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_certificados')); ?>
											<small class="text-muted">Solo adjuntar certificados de <strong>economía solidaria, verificando las horas</strong>.</small>
											<div class="form-group">
												<input type="file" required accept="application/pdf" class="file-upload-default" data-val="docenteCertificadosEconomia" name="docenteCertificadosEconomia" id="docenteCertificadosEconomia">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar certificado economía">
													<span class="input-group-append">
														<button class="file-upload-browse btn btn-sm btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>¿Horas que tiene el certificado?:<code>*</code></label><br>
												<div class="input-group">
													<input type="number" id="horasCertEcoSol" class="form-control" name="horasCertEcoSol" min="60" placeholder="60" required>
													<div class="input-group-append">
														<span class="input-group-text">horas</span>
													</div>
												</div>
											</div>
											<div class="text-right">
												<button type="button" class="btn btn-primary btn-sm archivos_form_certificadoEconomiaDocente" data-name="docenteCertificadosEconomia" name="certificadoDocenteEconomia" id="certificadoDocenteEconomia">
													<i class="ti-cloud-up mr-1"></i> Cargar archivo
												</button>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Tab Archivos Adjuntos -->
						<div class="tab-pane fade" id="adjuntos-content" role="tabpanel" aria-labelledby="adjuntos-tab">
							<div class="card">
								<div class="card-header bg-light d-flex justify-content-between align-items-center">
									<h6 class="mb-0"><i class="ti-files mr-1"></i> Archivos adjuntos al facilitador</h6>
									<button class="btn btn-outline-primary btn-sm dataReloadDocente">
										<i class="ti-reload mr-1"></i> Recargar
									</button>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="tabla_archivos_docentes" width="100%" class="table table-hover tabla_form">
											<thead>
												<tr>
													<th>Tipo</th>
													<th>Observación</th>
													<th class="text-center">Acción</th>
												</tr>
											</thead>
											<tbody id="tbody">
												<!-- Los archivos se cargarán dinámicamente aquí -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="ti-close mr-1"></i> Cerrar
						</button>
						<button type="button" class="btn btn-success actualizar_docente" value="Si">
							<i class="ti-share mr-1"></i> Enviar a evaluación
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal: Eliminar Docente -->
	<div class="modal fade" id="eliminarDocente" tabindex="-2" role="dialog" aria-labelledby="eliminardocente">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="eliminardocente">¿Está seguro de eliminar el facilitador?</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Por favor, confirmar la eliminación del facilitador. Esta acción no se puede revertir, se eliminarán todos los datos registrados del facilitador incluyendo los documentos cargados para él</p><br>
					<div class="btn-group">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No borrar facilitador <i class="fa fa-times" aria-hidden="true"></i></button>
						<button type="button" class="btn btn-success btn-sm" id="siEliminarDocente">Si, estoy seguro, confirmo la eliminación<i class="fa fa-check" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Historial de Observaciones del Docente (Usuarios) -->
	<div class="modal fade" id="modalHistObservacionesDocente" tabindex="-1" role="dialog" aria-labelledby="modalHistObsDocenteLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-dark text-white">
					<h5 class="modal-title" id="modalHistObsDocenteLabel">
						<i class="ti-agenda mr-2"></i> Historial de observaciones
					</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="tabla_obs_docente" class="table table-sm table-striped table-hover">
							<thead class="thead-light">
								<tr>
									<th style="width: 120px;">Fecha</th>
									<th>Observación</th>
								</tr>
							</thead>
							<tbody>
								<!-- Se llena por JS -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<!-- <script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
	$(document).ready(function() {
		// Inicializar tabla simple de usuarios
		DataTableConfig.initSimpleTable(
			'#tabla_obs_docente',
			'Historial de observaciones',
			'tabla_obs_docente'
		);
	});
</script>
 -->
