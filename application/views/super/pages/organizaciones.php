<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $solicitudes
 * @var $organizaciones
 */
$CI = &get_instance();
$CI->load->model("SolicitudesModel");
$CI->load->model("UsuariosModel");
if($logged_in == TRUE && ($tipo_usuario == "super" || $tipo_usuario == "admin")): ?>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
$(document).ready(function() {
	// Inicializar tabla simple de organizaciones
	DataTableConfig.initSimpleTable(
		'#tabla_super_organizaciones',
		'Organizaciones SEAS',
		'organizaciones_seas'
	);
});
</script>
<script src="<?php echo base_url('assets/js/functions/organizaciones.js?v=1.1.0') . time() ?>" type="module"></script>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-domain text-primary mr-2"></i>
								Gestión de Organizaciones
							</h3>
							<p class="text-muted mb-0">Administra las organizaciones registradas en el sistema</p>
						</div>
						<?php $this->load->view('admin/solicitudes/partials/_btn_volver'); ?>
						<?php if($tipo_usuario == "super"): ?>
						<button type="button" class="btn btn-primary btn-lg solicitudes-modal shadow-sm" data-toggle="modal" data-target="#modal-crear-solicitud">
							<i class="mdi mdi-plus mr-2"></i>
							Crear Organización
						</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<!-- Statistics Cards -->
			<div class="row mb-4">
				<div class="col-xl-6 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-primary">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($organizaciones) ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-primary-light rounded-circle">
										<i class="mdi mdi-domain text-primary"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-sm-6 grid-margin stretch-card">
					<div class="card shadow-sm border-left-success">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Con Usuario Activo</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$activas = 0;
											foreach($organizaciones as $org) {
												if($org->usuarios_id_usuario) $activas++;
											}
											echo $activas;
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
			</div>
			<!-- Tabla de organizaciones -->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Listado de Organizaciones
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($organizaciones) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive" style="overflow-x: auto;">
								<table id="tabla_super_organizaciones" class="table table-hover table-striped" style="table-layout: auto; width: 100%;">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-domain mr-1"></i>Organización
											</th>
											<th class="border-0">
												<i class="mdi mdi-numeric mr-1"></i>NIT
											</th>
											<th class="border-0">
												<i class="mdi mdi-email mr-1"></i>Correo Notificaciones
											</th>
											<th class="border-0">
												<i class="mdi mdi-account mr-1"></i>Usuario
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
									<?php foreach ($organizaciones as $organizacion): ?>
										<tr class="align-middle">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary-light rounded-circle mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
                                                        <i class="mdi mdi-domain text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1" style="min-width: 0;">
                                                        <h6 class="mb-0 font-weight-bold" style="white-space: normal; word-break: break-word;" title="<?= htmlspecialchars($organizacion->nombreOrganizacion) ?>">
                                                            <?= htmlspecialchars($organizacion->nombreOrganizacion) ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
											<td>
												<span class="font-weight-medium"><?= $organizacion->numNIT ?></span>
											</td>
											<td>
												<span class="text-muted"><?= $organizacion->direccionCorreoElectronicoOrganizacion ?></span>
											</td>
											<td>
												<?php if($organizacion->usuarios_id_usuario): ?>
													<span class="badge badge-success px-3 py-2">
														<i class="mdi mdi-check-circle mr-1"></i>
														<?= $CI->UsuariosModel->getUsuarios($organizacion->usuarios_id_usuario)->usuario ?>
													</span>
												<?php else: ?>
													<span class="badge badge-secondary px-3 py-2">
														<i class="mdi mdi-minus-circle mr-1"></i>Sin usuario
													</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button class="btn btn-outline-primary btn-sm organizacion-modal-detalle" 
														data-funct="ver" 
														data-toggle="modal" 
														data-id="<?= $organizacion->id_organizacion ?>" 
														data-target="#modal-organizaciones-detalle"
														title="Ver detalles de la organización">
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
	<!-- Modal formulario organizaciones mejorado -->
	<div class="modal fade" id="modal-organizaciones-detalle" tabindex="-1" role="dialog" aria-labelledby="modal-organizaciones-detalle">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white border-0">
					<h4 class="modal-title text-white" id="verOrganizacion">
						<i class="mdi mdi-domain mr-2"></i>
						Detalle de Organización
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="container-fluid">
						<!-- Información de la Organización -->
						<div class="card border-0 shadow-sm mb-3">
							<div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-information mr-2"></i>Información de la Organización
								</h6>
								<div class="btn-group btn-group-sm" role="group" aria-label="toggle">
									<button class="btn btn-outline-primary" id="verSolicitudesRegistradas" title="Ver solicitudes registradas">
										<i class="mdi mdi-file-document-outline mr-1"></i>Solicitudes
									</button>
									<button class="btn btn-outline-secondary" id="verActividadUsuario" title="Ver actividad del usuario">
										<i class="mdi mdi-history mr-1"></i>Actividad
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-label font-weight-bold">Organización:</label>
											<input class="form-control" type="text" id="organizacion" name="organizacion" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-label font-weight-bold">NIT:</label>
											<input class="form-control" type="text" id="nit" name="nit" readonly>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-label font-weight-bold">Sigla:</label>
											<input class="form-control" type="text" id="sigla" name="sigla" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Información General -->
						<div class="card border-0 shadow-sm mb-3">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-file-document-box-outline mr-2"></i>Información General
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<p class="mb-1 text-muted">Dirección</p>
										<p class="font-weight-medium" id="info_direccionOrganizacion">—</p>
									</div>
									<div class="col-md-3">
										<p class="mb-1 text-muted">Departamento</p>
										<p class="font-weight-medium" id="info_nomDepartamentoUbicacion">—</p>
									</div>
									<div class="col-md-3">
										<p class="mb-1 text-muted">Municipio</p>
										<p class="font-weight-medium" id="info_nomMunicipioNacional">—</p>
									</div>
									<div class="col-md-4">
										<p class="mb-1 text-muted">Tipo de organización</p>
										<p class="font-weight-medium" id="info_tipoOrganizacion">—</p>
									</div>
									<div class="col-md-4">
										<p class="mb-1 text-muted">Tipo de educación</p>
										<p class="font-weight-medium" id="info_tipoEducacion">—</p>
									</div>
									<div class="col-md-4">
										<p class="mb-1 text-muted">Actuación</p>
										<p class="font-weight-medium" id="info_actuacionOrganizacion">—</p>
									</div>
									<div class="col-md-6">
										<p class="mb-1 text-muted">Misión</p>
										<p class="font-weight-medium" id="info_mision">—</p>
									</div>
									<div class="col-md-6">
										<p class="mb-1 text-muted">Visión</p>
										<p class="font-weight-medium" id="info_vision">—</p>
									</div>
									<div class="col-md-12">
										<p class="mb-1 text-muted">Sitio web</p>
										<p class="font-weight-medium">
											<a href="#" target="_blank" id="info_urlOrganizacion">—</a>
										</p>
									</div>
								</div>
							</div>
						</div>

						<!-- Datos de contacto -->
						<div class="card border-0 shadow-sm mb-3">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-card-account-phone-outline mr-2"></i>Datos de contacto
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<p class="mb-1 text-muted">Correo de la organización</p>
										<p class="font-weight-medium" id="contacto_correoOrganizacion">—</p>
									</div>
									<div class="col-md-4">
										<p class="mb-1 text-muted">Correo del representante legal</p>
										<p class="font-weight-medium" id="contacto_correoRepLegal">—</p>
									</div>
									<div class="col-md-4">
										<p class="mb-1 text-muted">Representante legal</p>
										<p class="font-weight-medium" id="contacto_representante">—</p>
									</div>
									<div class="col-md-6">
										<p class="mb-1 text-muted">Teléfono</p>
										<p class="font-weight-medium" id="contacto_telefonoOrganizacion">—</p>
									</div>
									<div class="col-md-6">
										<p class="mb-1 text-muted">Sitio web</p>
										<p class="font-weight-medium">
											<a href="#" target="_blank" id="contacto_urlOrganizacion">—</a>
										</p>
									</div>
								</div>
							</div>
						</div>

						<!-- Lista de Solicitudes de la Organización -->
						<div id="solicitudesOrganizacion" class="card border-0 shadow-sm mb-3" style="display: none;">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-file-document-outline mr-2"></i>Solicitudes registradas
								</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="tabla_solicitudes_organizacion" class="table table-hover table-striped" style="width: 100% !important;">
										<thead class="thead-light">
											<tr>
												<th>ID</th>
												<th>Estado</th>
												<th>Fecha creación</th>
												<th>Asignada</th>
												<th>Modalidad</th>
												<th>Motivo</th>
												<th>Tipo</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody id="tbody_solicitudes"></tbody>
									</table>
								</div>
							</div>
						</div>

						<!-- Actividad del Usuario -->
						<div id="actividadOrganizacion" class="card border-0 shadow-sm mb-3" style="display: none;">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-history mr-2"></i>Actividad del usuario
								</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="tabla_actividad_inscritas" class="table table-hover table-striped" style="width: 100% !important;" 	>
										<thead class="thead-light">
											<tr>
												<th>Acción</th>
												<th>Fecha</th>
												<th>IP</th>
												<th>User Agent</th>
											</tr>
										</thead>
										<tbody id="tbody_actividad"></tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer bg-light border-0">
					<div class="d-flex justify-content-end w-100">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							<i class="mdi mdi-close mr-1"></i>Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php endif; ?>
</div>
