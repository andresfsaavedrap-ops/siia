<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $correos
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
$CI->load->model("UsuariosModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("CorreosRegistroModel");
$CI->load->model("TokenModel");

if($logged_in == TRUE && $tipo_usuario == "super"): ?>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-email-multiple text-primary mr-2"></i>
								Registro de Correos
							</h3>
							<p class="text-muted mb-0">Monitorea el estado de los correos enviados por el sistema</p>
						</div>
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
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Correos</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($correos) ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-primary-light rounded-circle">
										<i class="mdi mdi-email text-primary"></i>
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
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Enviados</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$enviados = 0;
											foreach($correos as $correo) {
												if($correo->error == "Enviado") $enviados++;
											}
											echo $enviados;
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-success-light rounded-circle">
										<i class="mdi mdi-email-check text-success"></i>
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
									<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Con Errores</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($correos) - $enviados ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-warning-light rounded-circle">
										<i class="mdi mdi-email-alert text-warning"></i>
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
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tipos de Correo</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$tipos = array();
											foreach($correos as $correo) {
												$tipos[$correo->tipo] = true;
											}
											echo count($tipos);
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-info-light rounded-circle">
										<i class="mdi mdi-email-variant text-info"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Tabla de correos -->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Registro de Correos Electrónicos
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($correos) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="tabla_correos_logs" class="table table-hover table-striped">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-calendar mr-1"></i>Fecha de Envío
											</th>
											<th class="border-0">
												<i class="mdi mdi-email-outline mr-1"></i>Destinatario
											</th>
											<th class="border-0">
												<i class="mdi mdi-tag mr-1"></i>Tipo
											</th>
											<th class="border-0">
												<i class="mdi mdi-check-circle mr-1"></i>Estado
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php foreach ($correos as $correo): ?>
											<tr class="align-middle">
												<td>
													<div class="d-flex align-items-center">
														<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
															<i class="mdi mdi-calendar text-primary"></i>
														</div>
														<span class="font-weight-medium"><?= $correo->fecha ?></span>
													</div>
												</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
															<i class="mdi mdi-email text-primary"></i>
														</div>
														<span class="text-muted"><?= $correo->para ?></span>
													</div>
												</td>
												<td>
													<span class="badge badge-outline-primary px-3 py-2">
														<?= $correo->tipo ?>
													</span>
												</td>
												<td>
													<?php if($correo->error == "Enviado"): ?>
														<span class="badge badge-success px-3 py-2">
															<i class="mdi mdi-check-circle mr-1"></i>Enviado
														</span>
													<?php else: ?>
														<span class="badge badge-warning px-3 py-2">
															<i class="mdi mdi-alert-circle mr-1"></i>Error de Envío
														</span>
													<?php endif; ?>
												</td>
												<td class="text-center">
													<?php if($correo->error != "Enviado"): ?>
														<button class="btn btn-outline-warning btn-sm ver-error-envio" 
																data-error="<?= $correo->error ?>"
																title="Ver detalles del error">
															<i class="mdi mdi-alert-circle"></i>
														</button>
													<?php else: ?>
														<button class="btn btn-outline-success btn-sm disabled"
																title="Correo enviado exitosamente">
															<i class="mdi mdi-check-circle"></i>
														</button>
													<?php endif; ?>
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
	<!-- Modal para mostrar errores -->
	<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="verError">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-warning text-white border-0">
					<h4 class="modal-title text-white" id="verError">
						<i class="mdi mdi-alert-circle mr-2"></i>
						Detalles del Error de Envío
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="alert alert-warning border-0 shadow-sm">
						<div class="d-flex align-items-center">
							<div class="icon-shape bg-warning-light rounded-circle mr-3">
								<i class="mdi mdi-alert-triangle text-warning"></i>
							</div>
							<div>
								<h6 class="mb-1 font-weight-bold">Error detectado en el envío</h6>
								<p class="mb-0 text-muted">A continuación se muestra el detalle del error:</p>
							</div>
						</div>
					</div>
					<div class="card border-0 shadow-sm">
						<div class="card-body">
							<pre id="error-content" class="bg-light p-3 rounded border-0 text-dark"></pre>
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
	<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
	<script>
	$(document).ready(function() {
		// Manejar clic en botón ver error
		$('.ver-error-envio').on('click', function() {
			var error = $(this).data('error');
			$('#error-content').text(error);
			$('#modal-error').modal('show');
		});
		// Inicializar tabla simple de emails
		DataTableConfig.initSimpleTable(
			'#tabla_emails',
			'Emails SEAS',
			'emails_seas'
			);
	});
	</script>
<?php endif; ?>
</div>
