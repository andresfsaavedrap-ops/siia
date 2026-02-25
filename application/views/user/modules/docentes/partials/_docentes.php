<?php
/***
 * @var $docentes
 */
?>
<div class="col-lg-12 grid-margin stretch-card" id="instrucciones-registro-docentes">
	<div class="card shadow-sm">
		<div class="card-body">
			<h4 class="card-title text-primary"><i class="mdi mdi-lightbulb mr-2"></i>Información a tener en cuenta</h4>
			<div class="card-description mt-3">
				<p>En este espacio podrás encontrar y administrar los facilitadores creados anteriormente, así como crear nuevos.
				<i data-toggle="modal" data-target="#ayudaDocentes" class="mdi mdi-help-circle text-info pull-right" aria-hidden="true" style="cursor: pointer;" title="Ayuda sobre registro docentes"></i>
				</p>
				<div class="alert alert-info mb-4">
					<i class="fa fa-info-circle"></i>
					Ingrese solo la información del equipo de facilitadores que desarrollará los cursos. Este debe ser de
					<span class="badge badge-warning">3 facilitadores o más</span>. Anexe los soportes de estudios y de experiencia solicitados.
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Tabla y botón de creación de facilitadores -->
<div class="col-lg-12 grid-margin stretch-card" id="divDocentesRegistrados">
	<div class="card shadow-sm">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div>
					<h4 class="card-title mb-0">Facilitadores</h4>
					<p class="text-muted font-weight-light">
						Listado de facilitadores <span class="badge badge-primary">registrados</span>
					</p>
				</div>
				<div>
					<button class="btn btn-primary btn-icon-text verDivAgregarDoc">
						<i class="ti-user btn-icon-prepend"></i>
						Nuevo facilitador
					</button>
					<!-- Botón para refrescar tabla y resumen sin recargar página -->
					<button class="btn btn-outline-secondary btn-icon-text ml-2 refrescarDocentes">
						<i class="ti-reload btn-icon-prepend"></i>
						Actualizar
					</button>
				</div>
			</div>
			<?php if ($docentes): ?>
			<!-- Resumen de estado de documentos -->
			<div class="alert alert-info mb-3">
				<?php 
					$docentes_completos = 0;
					$docentes_incompletos = 0;
					$docentes_con_faltantes = array();
					// NUEVO: lista de no válidos con observaciones
					$docentes_no_validos_con_observacion = array();
					
					foreach ($docentes as $docente) {
						if ($docente->documentos_completos) {
							$docentes_completos++;
						} else {
							$docentes_incompletos++;
							$docentes_con_faltantes[] = $docente->primerNombreDocente . ' ' . $docente->primerApellidoDocente;
						}
						// NUEVO: condición solicitada
						if ($docente->valido == 0 && !empty($docente->observacion)) {
							$docentes_no_validos_con_observacion[] = $docente->primerNombreDocente . ' ' . $docente->primerApellidoDocente;
						}
					}
				?>
				<div class="row align-items-center">
						<div class="col-md-8">
							<div class="d-flex align-items-center">
								<i class="ti-info-alt mr-3" style="font-size: 1.5rem;"></i>
								<div>
									<strong>Estado de documentación:</strong>
									<span class="badge badge-success ml-2"><?= $docentes_completos ?> completos</span>
									<?php if ($docentes_incompletos > 0): ?>
										<span class="badge badge-warning ml-1"><?= $docentes_incompletos ?> incompletos</span>
									<?php endif; ?>
									<?php if (!empty($docentes_con_faltantes)): ?>
										<div class="mt-2">
											<small class="text-muted">
												<strong>Facilitadores con documentación pendiente:</strong> 
												<?= implode(', ', array_slice($docentes_con_faltantes, 0, 3)) ?>
												<?php if (count($docentes_con_faltantes) > 3): ?>
													<span class="text-primary">y <?= count($docentes_con_faltantes) - 3 ?> más...</span>
												<?php endif; ?>
											</small>
										</div>
									<?php endif; ?>

									<?php if (!empty($docentes_no_validos_con_observacion)): ?>
										<div class="mt-2">
											<small class="text-danger">
												<strong>Facilitadores pendientes por aprobación con observaciones:</strong>
												<?= implode(', ', array_slice($docentes_no_validos_con_observacion, 0, 3)) ?>
												<?php if (count($docentes_no_validos_con_observacion) > 3): ?>
													<span class="text-primary">y <?= count($docentes_no_validos_con_observacion) - 3 ?> más...</span>
												<?php endif; ?>
											</small>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col-md-4 text-right">
							<small class="text-muted">Total: <?= count($docentes) ?> facilitador(es)</small>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<!-- <table id="tabla_docentes" class="table table-hover"> -->
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="pl-3">Foto</th>
								<th>Nombre</th>
								<th>Nº cédula</th>
								<th>Profesión</th>
								<th class="text-center">Estado de Aprobación</th>
								<th class="text-center">Estado de Documentación</th>
								<th class="text-right pr-3">Acciones</th>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php foreach ($docentes as $docente): ?>
								<tr class="align-middle">
									<td class="py-2 pl-3">
										<img src="<?= base_url('assets/img/default.png') ?>"
											alt="Foto de <?= $docente->primerNombreDocente ?>"
											class="rounded-circle" width="40" height="40" />
									</td>
									<td class="font-weight-medium">
										<?= $docente->primerNombreDocente . " " . $docente->primerApellidoDocente ?>
									</td>
									<td>
										<?= $docente->numCedulaCiudadaniaDocente ?>
									</td>
									<td>
										<span class="text-muted">
											<i class="ti-medall-alt text-primary mr-1"></i>
											<?= $docente->profesion ?>
										</span>
									</td>
									<!-- Columna de Estado de Aprobación -->
									<td class="text-center">
										<?php if ($docente->valido == '0'): ?>
											<span class="badge badge-danger py-1 px-2">
												<i class="ti-clock mr-1"></i>Pendiente
											</span>
										<?php else: ?>
											<span class="badge badge-success py-1 px-2">
												<i class="ti-check mr-1"></i>Aprobado
											</span>
										<?php endif; ?>
									</td>
									<!-- Columna de Estado de Documentación -->
									<td class="text-center">
										<?php if ($docente->documentos_completos): ?>
											<span class="badge badge-success py-1 px-2">
												<i class="ti-files mr-1"></i>Completa
											</span>
										<?php else: ?>
											<span class="badge badge-warning py-1 px-2" 
												  title="<?php 
													$detalles = array();
													foreach ($docente->documentos_faltantes as $faltante) {
														$detalles[] = $faltante['nombre'] . ': ' . $faltante['faltante'] . ' faltante(s)';
													}
													echo implode(', ', $detalles);
												?>">
												<i class="ti-alert mr-1"></i>Incompleta (<?= $docente->total_documentos_faltantes ?>)
											</span>
											<div class="mt-1">
												<small class="text-muted">
													<?php 
														$resumen_faltantes = array();
														foreach ($docente->documentos_faltantes as $faltante) {
															switch($faltante['tipo']) {
																case 'hojas':
																	$resumen_faltantes[] = 'HV';
																	break;
																case 'titulos':
																	$resumen_faltantes[] = 'Título';
																	break;
																case 'certs':
																	$resumen_faltantes[] = 'Cert. Exp.';
																	break;
																case 'certEcos':
																	$resumen_faltantes[] = 'Cert. Eco.';
																	break;
															}
														}
														echo implode(', ', $resumen_faltantes);
													?>
												</small>
											</div>
										<?php endif; ?>
									</td>
									<td class="text-right pr-3">
										<button class="btn btn-outline-primary btn-sm verDocenteOrg"
											data-toggle="modal"
											data-nombre="<?= $docente->primerNombreDocente ?> <?= $docente->primerApellidoDocente ?>"
											data-id="<?= $docente->id_docente ?>"
											data-target="#verDocenteOrg">
											<i class="ti-pencil mr-1"></i> Actualizar / Cargar Archivos
											<?php if (!$docente->documentos_completos): ?>
												<span class="ml-1 badge badge-warning badge-sm">
													<?= $docente->total_documentos_faltantes ?>
												</span>
											<?php else: ?>
												<span class="ml-1 badge badge-success badge-sm">
													<i class="ti-check"></i>
												</span>
											<?php endif; ?>
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- Paginación -->
				<div class="mt-4 d-flex justify-content-between align-items-center">
					<div class="text-muted small">
						Mostrando <span class="font-weight-medium"><?= count($docentes) ?></span> facilitadores
					</div>
					<!--<nav>
						<ul class="pagination pagination-sm">
							<li class="page-item"><a class="page-link" href="#"><i class="ti-angle-double-left"></i></a></li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#"><i class="ti-angle-double-right"></i></a></li>
						</ul>
					</nav>-->
				</div>
			<?php else: ?>
				<div class="text-center py-5">
					<i class="mdi mdi-account-group text-gray" style="font-size: 4rem;"></i>
					<p class="mt-3 text-muted">No hay facilitadores registrados actualmente</p>
					<button class="btn btn-outline-primary mt-2 verDivAgregarDoc" href="#divAgregarDoc">
						<i class="ti-plus mr-1"></i> Registrar primer facilitador
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Modal Ayuda Docentes -->
<div class="modal fade" id="ayudaDocentes" tabindex="-1" role="dialog" aria-labelledby="ayudaDocentes">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información Importante Para Registrar Docentes</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="color: white">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<!-- Tarjeta de información de facilitadores -->
						<div class="card bg-light mb-4">
							<div class="card-header bg-secondary text-white">
								<h5 class="mb-0"><i class="ti-files mr-2"></i>Documentos requeridos por cada docente</h5>
								<span class="badge badge-info mt-2">mínimos</span>
							</div>
							<div class="card-body">
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex align-items-center">
										<i class="ti-file text-primary mr-3"></i>
										<span>Hoja de vida </span> <span class="badge badge-info ml-2">1</span>
									</li>
									<li class="list-group-item d-flex align-items-center">
										<i class="ti-crown text-primary mr-3"></i>
										<span>Título de técnico, tecnólogo o profesional</span> <span class="badge badge-info ml-2">1</span>
									</li>
									<li class="list-group-item d-flex align-items-center">
										<i class="ti-medall text-primary mr-3"></i>
										<span>Certificados que acrediten experiencia en actividades formativas, capacitación, como docente, facilitador, capacitador o instructor, en mínimo<span class="badge badge-warning ml-2"> tres procesos formativos</span></span>
										<span class="badge badge-info ml-2">3</span>
									</li>
									<li class="list-group-item d-flex align-items-center">
										<i class="ti-timer text-primary mr-3"></i>
										<span>Certificados que acrediten haber recibido capacitación en economía solidaria por mínimo <span class="badge badge-danger">60 Horas</span></span>
										<span class="badge badge-info ml-2">1</span>
									</li>
								</ul>
							</div>
						</div>
						<div class="alert alert-warning">
							<h6 class="font-weight-bold"><i class="ti-alert mr-2"></i>Importante:</h6>
							<p class="mb-2">Recuerde que, si no cumple con los requisitos (documentos, certificados, horas), el facilitador no será válido, para dar continuidad con el trámite en caso de que solo registre tres (3) docentes.</p>
							<p class="mb-0">Su organización podrá visualizar el estado del docente si es válido o no, si no lo es, deberá subsanar las observaciones realizadas.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					<i class="fa fa-check mr-1"></i> Entendido
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Estilo adicional a incluir en la sección de estilos -->
<style>
	.table-hover tbody tr:hover {
		background-color: rgba(0, 0, 0, 0.02);
	}
	.badge {
		font-weight: 500;
		padding: 5px 10px;
	}
	.table td,
	.table th {
		vertical-align: middle;
	}
	.pagination .page-link {
		border-radius: 3px;
		margin: 0 2px;
	}
	td span.text-muted {
		display: inline-block;
		max-width: 450px;
		white-space: normal;
		word-break: break-word;
	}

</style>
