
<?php
/***
 * @var $organizaciones
 */
?>
<script type="module" src="<?= base_url('assets/js/functions/admin/modules/docentes/docentes.js?v=1.1') . time() ?>"></script>
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-account-group text-primary mr-2"></i>
							Docentes inscritos
						</h4>
						<p class="text-muted mb-0 small">Gestiona los docentes inscritos en el sistema</p>
					</div>
					<!-- Botón volver -->
					<?php $this->load->view('admin/organizaciones/docentes/partials/_btn_volver'); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="organizaciones_docentes" class="card shadow-sm">
					<div class="card-body">
						<!-- Estadísticas de Docentes -->
						<div class="row mb-4">
							<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
								<div class="card shadow-sm border-left-primary" style="border-left-width:4px;">
									<div class="card-body py-3">
										<div class="d-flex justify-content-between align-items-center">
											<div>
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Docentes</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">
													<?php
													$totalDocentes = 0;
													if (isset($docentes)) {
														if (is_array($docentes)) $totalDocentes = count($docentes);
														elseif (is_object($docentes)) $totalDocentes = 1;
													}
													echo $totalDocentes;
													?>
												</div>
											</div>
											<div class="icon-shape bg-primary-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
												<i class="mdi mdi-account-multiple text-primary"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
								<div class="card shadow-sm border-left-success" style="border-left-width:4px;">
									<div class="card-body py-3">
										<div class="d-flex justify-content-between align-items-center">
											<div>
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Aprobados</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">
													<?php
													$aprobados = 0;
													if (isset($docentes)) {
														if (is_array($docentes)) {
															foreach ($docentes as $d) {
																if ((string)$d->valido === '1') $aprobados++;
															}
														} elseif (is_object($docentes) && (string)$docentes->valido === '1') {
															$aprobados = 1;
														}
													}
													echo $aprobados;
													?>
												</div>
											</div>
											<div class="icon-shape bg-success-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
												<i class="mdi mdi-check-circle text-success"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
								<div class="card shadow-sm border-left-warning" style="border-left-width:4px;">
									<div class="card-body py-3">
										<div class="d-flex justify-content-between align-items-center">
											<div>
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">No Aprobados</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">
													<?= $totalDocentes - $aprobados ?>
												</div>
											</div>
											<div class="icon-shape bg-warning-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
												<i class="mdi mdi-alert-circle text-warning"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
								<div class="card shadow-sm border-left-info" style="border-left-width:4px;">
									<div class="card-body py-3">
										<div class="d-flex justify-content-between align-items-center">
											<div>
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sin Asignar</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800">
													<?php
													$sinAsignar = 0;
													if (isset($docentes)) {
														if (is_array($docentes)) {
															foreach ($docentes as $d) {
																if (!isset($d->asignado) || $d->asignado === null || $d->asignado === '' || strtoupper($d->asignado) === 'NO') $sinAsignar++;
															}
														} elseif (is_object($docentes) && (!isset($docentes->asignado) || $docentes->asignado === null || $docentes->asignado === '' || strtoupper($docentes->asignado) === 'NO')) {
															$sinAsignar = 1;
														}
													}
													echo $sinAsignar;
													?>
												</div>
											</div>
											<div class="icon-shape bg-info-light rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
												<i class="mdi mdi-account-off text-info"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Listado de todos los docentes -->
						<?php
							// Agrupar docentes por organización
							$listaDocentes = is_array($docentes) ? $docentes : (isset($docentes) ? array($docentes) : array());
							$organizaciones = [];

							foreach ($listaDocentes as $d) {
								$orgId = isset($d->id_organizacion)
									? $d->id_organizacion
									: (isset($d->organizaciones_id_organizacion) ? $d->organizaciones_id_organizacion : null);

								if ($orgId === null) { continue; }

								if (!isset($organizaciones[$orgId])) {
									$organizaciones[$orgId] = [
										'id'         => $orgId,
										'nombre'     => isset($d->nombreOrganizacion) ? $d->nombreOrganizacion : '',
										'nit'        => isset($d->numNIT) ? $d->numNIT : '',
										'total'      => 0,
										'aprobados'  => 0,
										'pendientes' => 0,
									];
								}

								$organizaciones[$orgId]['total']++;
								$esAprobado = isset($d->valido) && (string)$d->valido === '1';
								if ($esAprobado) {
									$organizaciones[$orgId]['aprobados']++;
								} else {
									$organizaciones[$orgId]['pendientes']++;
								}
							}

							$totalOrganizaciones = count($organizaciones);
						?>
						<div id="todos_docentes_card" class="card shadow-sm mt-4">
							<div class="card-header bg-white border-0">
								<div class="d-flex justify-content-between align-items-center">
									<h5 class="font-weight-medium mb-0">
										<i class="mdi mdi-table-large text-primary mr-2"></i>
										Listado de organizaciones con docentes
									</h5>
									<div class="badge badge-primary badge-pill"><?= $totalOrganizaciones ?> organizaciones</div>
								</div>
							</div>
							<div class="card-body">
								<?php if ($totalOrganizaciones > 0): ?>
									<div class="table-responsive">
										<table id="tabla_organizaciones_docentes" width="100%" class="table table-hover table-striped">
											<thead class="thead-light">
												<tr>
													<th class="border-0">Organización</th>
													<th class="border-0">NIT</th>
													<th class="border-0">Docentes registrados</th>
													<th class="border-0">Docentes aprobados</th>
													<th class="border-0">Docentes por aprobar</th>
													<th class="border-0">Acción</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($organizaciones as $org): ?>
													<tr>
														<td>
															<div class="text-truncate d-block" style="max-width: 220px;" title="<?= htmlspecialchars($org['nombre']) ?>">
																<?= strlen($org['nombre']) > 100 ? substr($org['nombre'], 0, 100) . '...' : $org['nombre'] ?>
															</div>
														</td>
														<td><?= $org['nit'] ?></td>
														<td><span class="badge badge-secondary"><?= $org['total'] ?></span></td>
														<td><span class="badge badge-success"><?= $org['aprobados'] ?></span></td>
														<td><span class="badge badge-warning"><?= $org['pendientes'] ?></span></td>
														<td>
															<button class="btn btn-primary btn-sm ver_organizacion_docentes" data-organizacion="<?= $org['id'] ?>">
																<i class="mdi mdi-eye mr-1"></i>Ver facilitadores
															</button>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="text-center py-5">
										<div class="icon-circle bg-info-light mx-auto mb-3" style="width: 60px; height: 60px;">
											<i class="mdi mdi-information text-info" style="font-size: 2rem;"></i>
										</div>
										<h5 class="font-weight-medium text-muted mb-2">No hay docentes registrados</h5>
										<p class="text-muted mb-0">Los docentes registrados aparecerán aquí</p>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<!-- Iframe Docentes -->
						<div id="docentes_organizaciones" class="card shadow-sm mt-4">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
	$(document).ready(function() {
		// Inicializar tabla simple de usuarios
		DataTableConfig.initSimpleTable(
			'#tabla_organizaciones_docentes',
			'Tabla de organizaciones con docentes',
			'tabla_organizaciones_docentes'
		);
	});
</script>
