<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $solicitudes
 * @var $organizaciones
 */
$CI = &get_instance();
$CI->load->model("SolicitudesModel");
$CI->load->model("OrganizacionesModel");
if($logged_in == TRUE && ($tipo_usuario == "super" || $tipo_usuario == "admin")): ?>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-file-document-multiple text-primary mr-2"></i>
								Gestión de Solicitudes
							</h3>
							<p class="text-muted mb-0">Administra las solicitudes del programa SEAS registradas en el sistema</p>
						</div>
						<?php if($tipo_usuario == "super"): ?>
						<button type="button" class="btn btn-primary btn-lg shadow-sm" data-toggle="modal" data-target="#modal-crear-solicitud">
							<i class="mdi mdi-plus mr-2"></i>
							Crear Solicitud
						</button>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Statistics Cards -->
			<div class="row mb-4">
				<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-primary">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Solicitudes</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($solicitudes) ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-primary-light rounded-circle">
										<i class="mdi mdi-file-document text-primary"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-success">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Asignadas</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$asignadas = 0;
											foreach($solicitudes as $solicitud) {
												if($solicitud->asignada != 'No asignada') $asignadas++;
											}
											echo $asignadas;
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-success-light rounded-circle">
										<i class="mdi mdi-account-check text-success"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-warning">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendientes</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($solicitudes) - $asignadas ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-warning-light rounded-circle">
										<i class="mdi mdi-clock-alert text-warning"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-info">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Organizaciones</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$orgs_solicitudes = array();
											foreach($solicitudes as $solicitud) {
												$orgs_solicitudes[$solicitud->numNIT] = true;
											}
											echo count($orgs_solicitudes);
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-info-light rounded-circle">
										<i class="mdi mdi-domain text-info"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Tabla de solicitudes -->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Registro de Solicitudes
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($solicitudes) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="tabla_super_solicitudes" class="table table-hover table-striped">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-identifier mr-1"></i>ID Solicitud
											</th>
											<th class="border-0">
												<i class="mdi mdi-domain mr-1"></i>Organización
											</th>
											<th class="border-0">
												<i class="mdi mdi-card-account-details mr-1"></i>NIT
											</th>
											<th class="border-0">
												<i class="mdi mdi-calendar mr-1"></i>Fecha Creación
											</th>
											<th class="border-0">
												<i class="mdi mdi-check-circle mr-1"></i>Estado
											</th>
											<th class="border-0">
												<i class="mdi mdi-account-supervisor mr-1"></i>Asignada
											</th>
											<th class="border-0">
												<i class="mdi mdi-tag mr-1"></i>Tipo
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php foreach ($solicitudes as $solicitud): 
											// Obtener información de la organización
											$organizacion = null;
											foreach($organizaciones as $org) {
												if($org->numNIT == $solicitud->numNIT) {
													$organizacion = $org;
													break;
												}
											}
											$nombreOrg = $organizacion ? $organizacion->sigla . ' - ' . $organizacion->nombreOrganizacion : 'Sin información';
										?>
											<tr class="align-middle">
												<td>
													<div class="d-flex align-items-center">
														<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
															<i class="mdi mdi-file-document text-primary"></i>
														</div>
														<span class="font-weight-bold"><?= $solicitud->idSolicitud ?></span>
													</div>
												</td>
												<td><?= $nombreOrg ?></td>
												<td>
													<span class="font-weight-medium"><?= $solicitud->numNIT ?></span>
												</td>
												<td>
													<span class="text-muted"><?= $solicitud->fechaCreacion ?></span>
												</td>
												<td>
													<span class="badge badge-outline-primary px-3 py-2">
														<?= $solicitud->nombre ?>
													</span>
												</td>
												<td>
													<?php if($solicitud->asignada != 'No asignada'): ?>
														<span class="badge badge-success px-3 py-2">
															<i class="mdi mdi-account-check mr-1"></i><?= $solicitud->asignada ?>
														</span>
													<?php else: ?>
														<span class="badge badge-warning px-3 py-2">
															<i class="mdi mdi-clock-alert mr-1"></i>No asignada
														</span>
													<?php endif; ?>
												</td>
												<td>
													<span class="badge badge-outline-info px-3 py-2">
														<?= $solicitud->tipoSolicitud ?>
													</span>
												</td>
												<td class="text-center">
													<button class="btn btn-outline-primary btn-sm verDetalleSolicitud" 
															data-id="<?= $solicitud->idSolicitud ?>" 
															data-toggle="modal" 
															data-target="#modal-detalle-solicitud"
															title="Ver detalles de la solicitud">
														<i class="mdi mdi-eye"></i>
													</button>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal formulario crear solicitud -->
	<div class="modal fade" id="modal-crear-solicitud" tabindex="-1" role="dialog" aria-labelledby="modal-crear-solicitud">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white border-0">
					<h4 class="modal-title text-white" id="verAdmin">
						<i class="mdi mdi-file-document-plus mr-2"></i>
						Crear Nueva Solicitud SEAS
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="container-fluid">
						<?php echo form_open('', array('id' => 'crear_solicitud_sp')); ?>
						<!-- Información de la Organización -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-domain mr-2"></i>Información de la Organización
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="form-label font-weight-bold">Organización <span class="text-danger">*</span></label><br>
											<select name="nit_organizacion" id="nit_organizacion" class="form-control selectpicker" required style="width: 100% !important;">
												<option value="">Seleccione una organización...</option>
												<?php foreach ($organizaciones as $organizacion) : ?>
													<option value="<?= $organizacion->numNIT ?>"><?= $organizacion->numNIT ?> | <?= $organizacion->sigla ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Información de la Solicitud -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-file-document mr-2"></i>Datos de la Solicitud
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Tipo de Solicitud <span class="text-danger">*</span></label>
											<select name="tipo_solicitud" id="tipo_solicitud" class="form-control" required>
												<option value="">Seleccione un tipo...</option>
												<option value="Solicitud Nueva">Solicitud Nueva</option>
												<option value="Renovación de Acreditación">Renovación de Acreditación</option>
												<option value="Renovación de Acreditación, Solicitud Nueva">Renovación de Acreditación, Solicitud Nueva</option>
												<option value="Acreditación Primera vez">Acreditación Primera vez</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Fecha de Creación <span class="text-danger">*</span></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="mdi mdi-calendar" style="font-size: 12px;"></i></span>
												</div>
												<input class="form-control datepicker" placeholder="Selecciona la fecha" type="text" id="fecha-creacion">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Programa SEAS -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-school mr-2"></i>Programa SEAS
								</h6>
							</div>
							<div class="card-body">
								<div class="alert alert-info border-0 shadow-sm">
									<div class="d-flex align-items-center">
										<div class="icon-shape bg-info-light rounded-circle mr-3">
											<i class="mdi mdi-information text-info ml-3"></i>
										</div>
										<div>
											<h6 class="mb-1 font-weight-bold">Programa Organizaciones y Redes SEAS</h6>
											<p class="mb-0 text-muted">Este programa está preseleccionado para todas las solicitudes nuevas</p>
										</div>
									</div>
								</div>
								<div class="card border-primary">
									<div class="card-body p-3">
										<div class="form-check form-check-flat form-check-primary">
											<label class="form-check-label font-weight-bold" for="SEAS">
												<input class="form-check-input" type="checkbox" value="6" id="SEAS" name="motivos" checked disabled>
												<i class="mdi mdi-school mr-2 text-primary"></i>Programa organizaciones y redes SEAS
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Modalidades -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-laptop mr-2"></i>Modalidades de Formación
								</h6>
							</div>
							<div class="card-body">
								<div class="alert alert-success border-0 shadow-sm mb-3">
									<div class="d-flex align-items-center">
										<div class="icon-shape bg-success-light rounded-circle mr-3">
											<i class="mdi mdi-check-circle text-success ml-3"></i>
										</div>
										<div>
											<h6 class="mb-1 font-weight-bold">Modalidades Preseleccionadas</h6>
											<p class="mb-0 text-muted">Todas las modalidades están habilitadas por defecto</p>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="card mb-3 border shadow-sm">
											<div class="card-body p-3">
												<div class="form-check form-check-flat form-check-primary">
													<label class="form-check-label" for="presencial">
														<input class="form-check-input" type="checkbox" value="1" id="presencial" name="modalidades" checked disabled>
														<i class="mdi mdi-account-group mr-2 text-primary"></i>Presencial
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="card mb-3 border shadow-sm">
											<div class="card-body p-3">
												<div class="form-check form-check-flat form-check-primary">
													<label class="form-check-label" for="virtualCheck">
														<input class="form-check-input" type="checkbox" value="2" id="virtualCheck" name="modalidades" checked disabled>
														<i class="mdi mdi-laptop mr-2 text-primary"></i>Virtual
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="card mb-3 border shadow-sm">
											<div class="card-body p-3">
												<div class="form-check form-check-flat form-check-primary">
													<label class="form-check-label" for="aDistancia">
														<input class="form-check-input" type="checkbox" value="3" id="aDistancia" name="modalidades" checked disabled>
														<i class="mdi mdi-video mr-2 text-primary"></i>A Distancia
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="card mb-3 border shadow-sm">
											<div class="card-body p-3">
												<div class="form-check form-check-flat form-check-primary">
													<label class="form-check-label" for="hibridaCheck">
														<input class="form-check-input" type="checkbox" value="4" id="hibridaCheck" name="modalidades" checked disabled>
														<i class="mdi mdi-swap-horizontal mr-2 text-primary"></i>Híbrida
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<div class="modal-footer bg-light border-0">
					<div class="d-flex justify-content-between w-100">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							<i class="mdi mdi-close mr-1"></i>Cancelar
						</button>
						<button id="btn_crear_solicitud_sp" class="btn btn-success">
							<i class="mdi mdi-check mr-1"></i>Crear Solicitud
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para ver detalles de solicitud -->
	<div class="modal fade" id="modal-detalle-solicitud" tabindex="-1" role="dialog" aria-labelledby="modal-detalle-solicitud">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white border-0">
					<h4 class="modal-title text-white">
						<i class="mdi mdi-file-document-outline mr-2"></i>
						Detalles de la Solicitud
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="row">
						<!-- Información Básica -->
						<div class="col-md-6">
							<div class="card border-left-primary shadow-sm mb-3">
								<div class="card-header bg-primary-light">
									<h6 class="m-0 font-weight-bold text-primary">
										<i class="mdi mdi-information-outline mr-2"></i>
										Información Básica
									</h6>
								</div>
								<div class="card-body" id="informacionSolicitudBasico">
									<!-- Contenido cargado dinámicamente -->
								</div>
							</div>
						</div>
						
						<!-- Información de Fechas -->
						<div class="col-md-6">
							<div class="card border-left-info shadow-sm mb-3">
								<div class="card-header bg-info-light">
									<h6 class="m-0 font-weight-bold text-info">
										<i class="mdi mdi-calendar-clock mr-2"></i>
										Fechas Importantes
									</h6>
								</div>
								<div class="card-body" id="informacionSolicitudFechas">
									<!-- Contenido cargado dinámicamente -->
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<!-- Información de Estado -->
						<div class="col-md-12">
							<div class="card border-left-success shadow-sm">
								<div class="card-header bg-success-light">
									<h6 class="m-0 font-weight-bold text-success">
										<i class="mdi mdi-check-circle-outline mr-2"></i>
										Estado y Asignación
									</h6>
								</div>
								<div class="card-body" id="informacionSolicitudEstado">
									<!-- Contenido cargado dinámicamente -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light border-0">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<i class="mdi mdi-close mr-1"></i>Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Estilos adicionales para mantener consistencia -->
	<style>
		/* Estilos adicionales para mantener consistencia */
		.avatar-sm {
			width: 40px;
			height: 40px;
		}
		
		.icon-shape {
			width: 3rem;
			height: 3rem;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.25rem;
		}
		
		/* Arreglar centrado de iconos */
		.icon-shape i {
			line-height: 1;
			vertical-align: middle;
		}
		
		/* Arreglar checkboxes invisibles */
		.form-check-input {
			position: relative !important;
			margin-left: 0 !important;
			margin-right: 0.5rem !important;
			opacity: 1 !important;
			visibility: visible !important;
			width: 1.25rem !important;
			height: 1.25rem !important;
		}
		
		.form-check-label {
			display: flex !important;
			align-items: center !important;
			padding-left: 0 !important;
		}
		
		/* Estilos para agrupación de DataTables */
		.group {
			background-color: #f8f9fa;
			font-weight: bold;
			color: #495057;
			padding: 10px;
			border-bottom: 2px solid #dee2e6;
		}
		
		.group:hover {
			background-color: #e9ecef;
		}
		
		.bg-primary-light {
			background-color: rgba(78, 115, 223, 0.1) !important;
		}
		
		.bg-success-light {
			background-color: rgba(28, 200, 138, 0.1) !important;
		}
		
		.bg-warning-light {
			background-color: rgba(246, 194, 62, 0.1) !important;
		}
		
		.bg-info-light {
			background-color: rgba(54, 185, 204, 0.1) !important;
		}
		
		.border-left-primary {
			border-left: 0.25rem solid #4e73df !important;
		}
		
		.border-left-success {
			border-left: 0.25rem solid #1cc88a !important;
		}
		
		.border-left-warning {
			border-left: 0.25rem solid #f6c23e !important;
		}
		
		.border-left-info {
			border-left: 0.25rem solid #36b9cc !important;
		}
		
		.table-hover tbody tr:hover {
			background-color: rgba(0, 0, 0, 0.02);
		}
		
		.badge {
			font-size: 0.75em;
		}
		
		.card {
			border-radius: 0.35rem;
		}
		
		.btn {
			border-radius: 0.35rem;
		}
		
		.form-control {
			border-radius: 0.35rem;
		}
		
		.modal-content {
			border-radius: 0.5rem;
		}
		
		.text-xs {
			font-size: 0.7rem;
		}
		
		.font-weight-bold {
			font-weight: 700 !important;
		}
		
		.text-gray-800 {
			color: #5a5c69 !important;
		}
	</style>
	<!-- Script para inicializar DataTables con agrupación y exportación -->
	<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
	<script>
	$(document).ready(function() {
	    // Inicializar tabla con agrupación por organización
	    DataTableConfig.initGroupedTable(
	        '#tabla_super_solicitudes',
	        'Solicitudes SEAS',
	        'solicitudes_seas',
	        8, // Total de columnas
	        1, // Columna de agrupación (organización)
	        [0, 2, 3, 4, 5, 6, 7] // Columnas para exportación (excluir columna oculta)
	    );
	});
	</script>
<?php endif; ?>
</div>
