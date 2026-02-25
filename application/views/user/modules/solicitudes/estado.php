<?php
/***
 * @var $solicitud
 * @var $organizacion
 * @var $observaciones
 *
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
/*echo '<pre>';
die(var_dump($solicitud));
echo '</pre>';*/
?>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/estado.js?v=1.0.8.61219') . time() ?>" type="module"></script>
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Tarjeta con información de la solicitud -->
		<?php if ($solicitud->nombre == "Finalizado"): ?>
			<div class="row mb-4">
				<div class="col-12">
					<div class="card card-modern shadow-lg">
						<div class="card-header gradient-header">
							<div class="d-flex align-items-center">
								<div class="card-icon">
									<i class="mdi mdi-check-circle-outline mt-1"></i>
								</div>
								<div>
									<h3 class="card-title mb-1 text-white">Solicitud Finalizada</h3>
									<p class="card-subtitle mb-0">Información completa del proceso</p>
								</div>
								<div class="ml-auto">
									<span class="status-badge status-success">
										<i class="mdi mdi-check"></i> Completado
									</span>
								</div>
							</div>
						</div>
						<div class="card-body p-4">
							<div class="row">
								<!-- Columna izquierda -->
								<div class="col-lg-6">
									<div class="info-section">
										<h5 class="section-title">Información Temporal</h5>
										<div class="info-grid">
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-calendar-plus text-success"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Fecha de Creación</span>
													<span class="info-value"><?php echo date('d/m/Y H:i', strtotime($solicitud->fechaCreacion)); ?></span>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-calendar-check text-primary"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Fecha de Finalización</span>
													<span class="info-value"><?php echo date('d/m/Y H:i', strtotime($solicitud->fechaFinalizado)); ?></span>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-clock-outline text-warning"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Última Revisión</span>
													<span class="info-value">
														<?php
														if ($solicitud->fechaUltimaRevision != null || empty(!$solicitud->fechaUltimaRevision)):
															echo date('d/m/Y H:i', strtotime($solicitud->fechaUltimaRevision));
														else:
															echo 'Aún sin revisión';
														endif;
														?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="info-section mt-4">
										<h5 class="section-title">Estado y Clasificación</h5>
										<div class="info-grid">
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-flag-outline text-info"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Estado Actual</span>
													<?php if ($solicitud->nombre == "En Observaciones"): ?>
														<span class="status-badge status-warning">
															<i class="mdi mdi-alert-circle-outline"></i> <?php echo $solicitud->nombre; ?>
														</span>
													<?php else: ?>
														<span class="status-badge status-success">
															<i class="mdi mdi-check-circle-outline"></i> <?php echo $solicitud->nombre; ?>
														</span>
													<?php endif; ?>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-file-document-outline text-purple"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Tipo de Solicitud</span>
													<span class="info-value"><?php echo $solicitud->tipoSolicitud; ?></span>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-format-list-bulleted text-secondary"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Modalidad</span>
													<span class="info-value"><?php echo $solicitud->modalidadSolicitud; ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Columna derecha -->
								<div class="col-lg-6">
									<div class="info-section">
										<h5 class="section-title">Detalles de Proceso</h5>
										<div class="info-grid">
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-identifier text-dark"></i>
												</div>
												<div class="info-content">
													<span class="info-label">ID de Solicitud</span>
													<span class="badge badge-primary-soft"><?php echo $solicitud->idSolicitud; ?></span>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-counter text-info"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Número de Revisiones</span>
													<span class="badge badge-info-soft"><?php echo $solicitud->numeroRevisiones; ?></span>
												</div>
											</div>
											<div class="info-item">
												<div class="info-icon">
													<i class="mdi mdi-account-outline text-success"></i>
												</div>
												<div class="info-content">
													<span class="info-label">Evaluador Asignado</span>
													<span class="info-value"><?php echo $solicitud->asignada; ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="info-section mt-4">
										<h5 class="section-title">Motivo de la Solicitud</h5>
										<div class="motivo-card">
											<div class="motivo-icon">
												<i class="mdi mdi-text-box-outline"></i>
											</div>
											<div class="motivo-content">
												<p><?php echo $solicitud->motivoSolicitud; ?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Botones de acción -->
							<div class="action-section mt-4">
								<div class="d-flex flex-wrap gap-2 align-items-center">
									<button class="btn btn-outline-secondary volver_solicitudes">
										<i class="mdi mdi-arrow-left mr-2"></i> Volver
									</button>
									<button class="btn btn-info verHistObsUs" id="hist_org_obs"
										data-toggle='modal' data-id-solicitud='<?= $solicitud->idSolicitud; ?>' data-id-org="<?= $organizacion->id_organizacion; ?>"
										data-target='#verHistObsUs'>
										<i class="mdi mdi-history mr-2"></i> Historial de Observaciones
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ($solicitud->nombre == "En Observaciones" && $observaciones): ?>
			<!-- Alert de observaciones -->
			<div class="row mb-4">
				<div class="col-12">
					<div class="alert alert-warning-modern shadow-sm">
						<div class="alert-icon">
							<i class="mdi mdi-alert-circle-outline" style="margin-left: 20px"></i>
						</div>
						<div class="alert-content">
							<h4 class="alert-title">Solicitud con Observaciones</h4>
							<p class="alert-description">
								Esta solicitud tiene observaciones pendientes que deben ser atendidas.
								Revisa cada formulario marcado y realiza las correcciones necesarias.
							</p>
							<div class="alert-actions mt-3">
								<span class="badge badge-warning-soft">
									<i class="mdi mdi-eye-outline"></i>Revisión Requerida
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Formularios con observaciones -->
			<div class="row">
				<div class="col-12">
					<div class="card card-tabs shadow-lg">
						<div class="card-header p-0">
							<ul class="nav nav-tabs-modern" id="formulariosTab" role="tablist">
								<?php
								$active = "active";
								$formularios_nombres = [
									1 => "1. Información General",
									2 => "2. Documentación Legal",
									3 => "3. Jornadas de Actualización",
									4 => "4. Programas de Educación",
									5 => "5. Equipo de Facilitadores",
									6 => "6. Modalidades",
									7 => "7. Modalidad en Línea"
								];

								for ($i = 1; $i <= 7; $i++):
									if (isset($observaciones['formulario' . $i]) && $observaciones['formulario' . $i]):
										$obs_count = count($observaciones['formulario' . $i]);
								?>
										<li class="nav-item">
											<a class="nav-link <?php echo $active; ?>" id="form<?php echo $i; ?>-tab"
												data-toggle="tab" href="#form<?php echo $i; ?>" role="tab">
												<div class="tab-content-wrapper">
													<div class="tab-icon">
														<i class="mdi mdi-file-document-outline"></i>
													</div>
													<div class="tab-text">
														<span class="tab-title"><?php echo $formularios_nombres[$i]; ?></span>
														<span class="tab-badge">
															<span class="obs-count"><?php echo $obs_count; ?></span> observaciones
														</span>
													</div>
												</div>
											</a>
										</li>
								<?php
										$active = "";
									endif;
								endfor;
								?>
							</ul>
						</div>
						<div class="card-body p-0">
							<div class="tab-content" id="formulariosTabContent">
								<?php
								$active = "show active";
								for ($i = 1; $i <= 7; $i++):
									if (isset($observaciones['formulario' . $i]) && $observaciones['formulario' . $i]):
								?>
										<div class="tab-pane fade <?php echo $active; ?>" id="form<?php echo $i; ?>" role="tabpanel">
											<div class="tab-pane-header">
												<h3 class="tab-pane-title">
													<i class="mdi mdi-file-document-outline text-primary"></i>
													<?php echo $formularios_nombres[$i]; ?>
												</h3>
												<span class="obs-summary">
													<?php echo count($observaciones['formulario' . $i]); ?> observaciones registradas
												</span>
											</div>

											<div class="table-container">
												<div class="table-responsive">
													<table class="table table-modern" id="tttabla_observaciones_form<?php echo $i; ?>">
														<thead>
															<tr>
																<th>
																	<i class="mdi mdi-calendar-outline mr-1"></i>
																	Fecha
																</th>
																<th>
																	<i class="mdi mdi-counter mr-1"></i>
																	Revisión
																</th>
																<th>
																	<i class="mdi mdi-form-select mr-1"></i>
																	Formulario
																</th>
																<th>
																	<i class="mdi mdi-comment-text-outline mr-1"></i>
																	Observación
																</th>
																<th>
																	<i class="mdi mdi-account-outline mr-1"></i>
																	Evaluador
																</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($observaciones['formulario' . $i] as $index => $observacion): ?>
																<tr class="table-row-modern">
																	<td>
																		<div class="date-display">
																			<span class="date-main"><?php echo date('d/m/Y', strtotime($observacion->fechaObservacion)); ?></span>
																			<span class="date-time"><?php echo date('H:i', strtotime($observacion->fechaObservacion)); ?></span>
																		</div>
																	</td>
																	<td>
																		<span class="revision-badge">
																			Rev. <?php echo $observacion->numeroRevision; ?>
																		</span>
																	</td>
																	<td>
																		<span class="form-badge">
																			<?php echo $observacion->keyForm; ?>
																		</span>
																	</td>
																	<td>
																		<div class="observation-text long-observation" title="<?php echo htmlspecialchars($observacion->observacion); ?>">
																			<?php echo $observacion->observacion; ?>
																		</div>
																	</td>
																	<td>
																		<div class="evaluator-info">
																			<i class="mdi mdi-account-circle text-muted mr-1"></i>
																			<span><?php echo $CI->AdministradoresModel->getNameComplete($observacion->realizada); ?></span>
																		</div>
																	</td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
								<?php
										$active = "";
									endif;
								endfor;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Botón de actualización -->
			<div class="row mt-3 mb-4">
				<div class="col-12">
					<div class="update-section">
						<div class="update-card">
							<div class="update-icon">
								<i class="mdi mdi-refresh mt-1"></i>
							</div>
							<div class="update-content">
								<h4>¿Listo para actualizar?</h4>
								<p>Una vez que hayas revisado todas las observaciones, puedes proceder a actualizar la solicitud.</p>
							</div>
							<div class="update-action">
								<button class="btn btn-success btn-update" id="actualizar_solicitud"
									data-solicitud="<?php echo $solicitud->idSolicitud ?>">
									<i class="mdi mdi-check-circle-outline mr-2"></i>
									Actualizar Solicitud #<?php echo $solicitud->idSolicitud ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
</div>
<!-- Estilos CSS modernos -->
<style>
	/* Variables CSS para consistencia */
	:root {
		--primary-color: #004884;
		--success-color: #10b981;
		--warning-color: #f59e0b;
		--danger-color: #ef4444;
		--info-color: #3b82f6;
		--secondary-color: #6b7280;
		--light-bg: #f8fafc;
		--border-color: #e5e7eb;
		--text-primary: #111827;
		--text-secondary: #6b7280;
		--shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
		--shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
		--shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
		--border-radius: 0.5rem;
		--border-radius-lg: 0.75rem;
	}

	.breadcrumb-item a {
		color: rgba(255, 255, 255, 0.8);
		text-decoration: none;
	}

	.breadcrumb-item a:hover {
		color: white;
	}

	/* Tarjetas modernas */
	.card-modern {
		border: none;
		border-radius: var(--border-radius-lg);
		overflow: hidden;
	}

	.gradient-header {
		background: linear-gradient(135deg, var(--primary-color) 0%, #0961a8 100%);
		color: white;
		border: none;
		padding: 1.5rem 2rem;
	}

	.card-icon {
		width: 48px;
		height: 48px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 1rem;
	}

	.card-icon i {
		font-size: 1.5rem;
	}

	.card-title {
		font-size: 1.25rem;
		font-weight: 600;
		margin: 0;
	}

	.card-subtitle {
		opacity: 0.9;
		font-size: 0.875rem;
	}

	/* Status badges */
	.status-badge {
		display: inline-flex;
		align-items: center;
		gap: 0.25rem;
		padding: 0.5rem 1rem;
		border-radius: 9999px;
		font-size: 0.875rem;
		font-weight: 500;
	}

	.status-success {
		background: rgba(16, 185, 129, 0.1);
		color: var(--success-color);
		border: 1px solid rgba(16, 185, 129, 0.2);
	}

	.status-warning {
		background: rgba(245, 158, 11, 0.1);
		color: var(--warning-color);
		border: 1px solid rgba(245, 158, 11, 0.2);
	}

	/* Secciones de información */
	.info-section {
		margin-bottom: 1.5rem;
	}

	.section-title {
		font-size: 1rem;
		font-weight: 600;
		color: var(--text-primary);
		margin-bottom: 1rem;
		padding-bottom: 0.5rem;
		border-bottom: 2px solid var(--border-color);
	}

	.info-grid {
		display: flex;
		flex-direction: column;
		gap: 1rem;
	}

	.info-item {
		display: flex;
		align-items: flex-start;
		gap: 0.75rem;
		padding: 1rem;
		background: var(--light-bg);
		border-radius: var(--border-radius);
		border: 1px solid var(--border-color);
	}

	.info-icon {
		width: 40px;
		height: 40px;
		background: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: var(--shadow-sm);
		flex-shrink: 0;
	}

	.info-icon i {
		font-size: 1.25rem;
	}

	.info-content {
		display: flex;
		flex-direction: column;
		gap: 0.25rem;
		flex: 1;
	}

	.info-label {
		font-size: 0.875rem;
		font-weight: 500;
		color: var(--text-secondary);
	}

	.info-value {
		font-size: 1rem;
		font-weight: 600;
		color: var(--text-primary);
	}

	/* Tarjeta de motivo */
	.motivo-card {
		display: flex;
		gap: 1rem;
		padding: 1.5rem;
		background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
		border-radius: var(--border-radius);
		border: 1px solid var(--border-color);
	}

	.motivo-icon {
		width: 40px;
		height: 40px;
		background: var(--primary-color);
		color: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}

	.motivo-content p {
		margin: 0;
		line-height: 1.6;
		color: var(--text-primary);
	}

	/* Badges suaves */
	.badge-primary-soft {
		background: rgba(79, 70, 229, 0.1);
		color: var(--primary-color);
		border: 1px solid rgba(79, 70, 229, 0.2);
	}

	.badge-info-soft {
		background: rgba(59, 130, 246, 0.1);
		color: var(--info-color);
		border: 1px solid rgba(59, 130, 246, 0.2);
	}

	.badge-warning-soft {
		background: rgba(245, 158, 11, 0.1);
		color: var(--warning-color);
		border: 1px solid rgba(245, 158, 11, 0.2);
	}

	/* Alert moderno */
	.alert-warning-modern {
		display: flex;
		gap: 1rem;
		padding: 1.5rem;
		background: linear-gradient(135deg, #fefbf3 0%, #fef3c7 100%);
		border: 1px solid #f59e0b;
		border-radius: var(--border-radius-lg);
		border-left: 4px solid var(--warning-color);
	}

	.alert-icon {
		width: 48px;
		height: 48px;
		background: var(--warning-color);
		color: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}

	.alert-content {
		flex: 1;
	}

	.alert-title {
		font-size: 1.125rem;
		font-weight: 600;
		color: #92400e;
		margin-bottom: 0.5rem;
	}

	.alert-description {
		color: #b45309;
		margin-bottom: 0;
		line-height: 1.6;
	}

	/* Tabs modernos */
	.card-tabs {
		border: none;
		border-radius: var(--border-radius-lg);
		overflow: hidden;
	}

	.nav-tabs-modern {
		background: #f8fafc;
		border: none;
		padding: 0.5rem;
		display: flex;
		flex-wrap: wrap;
		gap: 0.25rem;
	}

	.nav-tabs-modern .nav-item {
		margin-bottom: 0;
	}

	.nav-tabs-modern .nav-link {
		border: none;
		border-radius: var(--border-radius);
		padding: 1rem;
		background: white;
		color: var(--text-secondary);
		transition: all 0.2s;
		margin-right: 0;
	}

	.nav-tabs-modern .nav-link:hover {
		background: #e2e8f0;
		color: var(--text-primary);
	}

	.nav-tabs-modern .nav-link.active {
		background: var(--primary-color);
		color: white;
		box-shadow: var(--shadow-md);
	}

	.tab-content-wrapper {
		display: flex;
		align-items: center;
		gap: 0.75rem;
	}

	.tab-icon {
		width: 32px;
		height: 32px;
		background: rgba(255, 255, 255, 0.1);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.nav-tabs-modern .nav-link.active .tab-icon {
		background: rgba(255, 255, 255, 0.2);
	}

	.tab-text {
		display: flex;
		flex-direction: column;
		gap: 0.125rem;
	}

	.tab-title {
		font-weight: 500;
		font-size: 0.875rem;
	}

	.tab-badge {
		font-size: 0.75rem;
		opacity: 0.8;
	}

	.obs-count {
		font-weight: 600;
	}

	/* Contenido de tabs */
	.tab-pane-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 2rem 2rem 1rem 2rem;
		border-bottom: 1px solid var(--border-color);
	}

	.tab-pane-title {
		font-size: 1.25rem;
		font-weight: 600;
		margin: 0;
		display: flex;
		align-items: center;
		gap: 0.5rem;
	}

	.obs-summary {
		font-size: 0.875rem;
		color: var(--text-secondary);
		background: var(--light-bg);
		padding: 0.375rem 0.75rem;
		border-radius: 9999px;
	}

	/* Tabla moderna */
	.table-container {
		padding: 2rem;
	}

	.table-modern {
		border: none;
		margin-bottom: 0;
	}

	.table-modern thead th {
		background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
		border: none;
		padding: 1rem;
		font-weight: 600;
		color: var(--text-primary);
		font-size: 0.875rem;
	}

	.table-modern tbody td {
		padding: 1rem;
		border-top: 1px solid var(--border-color);
		vertical-align: middle;
	}

	.table-row-modern:hover {
		background: var(--light-bg);
	}

	.date-display {
		display: flex;
		flex-direction: column;
		gap: 0.125rem;
	}

	.date-main {
		font-weight: 500;
		color: var(--text-primary);
	}

	.date-time {
		font-size: 0.75rem;
		color: var(--text-secondary);
	}

	.revision-badge {
		background: rgba(59, 130, 246, 0.1);
		color: var(--info-color);
		padding: 0.25rem 0.75rem;
		border-radius: 9999px;
		font-size: 0.75rem;
		font-weight: 500;
	}

	.form-badge {
		background: rgba(107, 114, 128, 0.1);
		color: var(--secondary-color);
		padding: 0.25rem 0.75rem;
		border-radius: 0.375rem;
		font-size: 0.75rem;
		font-weight: 500;
		font-family: monospace;
	}

	.observation-text {
		line-height: 1.5;
		max-width: 300px;
	}

	.evaluator-info {
		display: flex;
		align-items: center;
		gap: 0.25rem;
		font-size: 0.875rem;
	}

	/* Sección de actualización */
	.update-section {
		padding: 2rem 0;
	}

	.update-card {
		display: flex;
		align-items: center;
		gap: 1.5rem;
		padding: 2rem;
		background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
		border: 1px solid var(--success-color);
		border-radius: var(--border-radius-lg);
		box-shadow: var(--shadow-lg);
	}

	.update-icon {
		width: 64px;
		height: 64px;
		background: var(--success-color);
		color: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		animation: pulse 2s infinite;
	}

	.update-icon i {
		font-size: 1.75rem;
	}

	.update-content {
		flex: 1;
	}

	.update-content h4 {
		font-size: 1.125rem;
		font-weight: 600;
		color: #065f46;
		margin-bottom: 0.5rem;
	}

	.update-content p {
		color: #047857;
		margin: 0;
		line-height: 1.5;
	}

	.btn-update {
		padding: 0.75rem 2rem;
		font-weight: 600;
		border-radius: var(--border-radius);
		box-shadow: var(--shadow-md);
		transition: all 0.2s;
	}

	.btn-update:hover {
		transform: translateY(-1px);
		box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
	}

	/* Sección de acciones */
	.action-section {
		border-top: 1px solid var(--border-color);
		padding-top: 1.5rem;
	}

	.gap-2 {
		gap: 0.5rem;
	}

	/* Animaciones */
	@keyframes pulse {

		0%,
		100% {
			opacity: 1;
		}

		50% {
			opacity: 0.7;
		}
	}

	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(20px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.card-modern,
	.alert-warning-modern,
	.card-tabs {
		animation: fadeInUp 0.6s ease-out;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.page-header {
			padding: 1.5rem;
		}

		.page-title {
			font-size: 1.5rem;
		}

		.info-item {
			flex-direction: column;
			align-items: flex-start;
		}

		.tab-content-wrapper {
			flex-direction: column;
			align-items: flex-start;
			gap: 0.25rem;
		}

		.tab-pane-header {
			flex-direction: column;
			align-items: flex-start;
			gap: 1rem;
		}

		.update-card {
			flex-direction: column;
			text-align: center;
			gap: 1rem;
		}

		.table-responsive {
			font-size: 0.875rem;
		}

		.observation-text {
			max-width: none;
		}
	}

	@media (max-width: 576px) {
		.nav-tabs-modern {
			flex-direction: column;
		}

		.nav-tabs-modern .nav-link {
			width: 100%;
		}

		.info-grid {
			gap: 0.75rem;
		}

		.info-item {
			padding: 0.75rem;
		}
	}

	/* Hover effects */
	.info-item:hover {
		background: #f1f5f9;
		border-color: var(--primary-color);
		transform: translateY(-1px);
		transition: all 0.2s;
	}

	.table-row-modern {
		transition: background-color 0.2s;
	}

	/* Print styles */
	@media print {

		.action-section,
		.nav-tabs-modern,
		.update-section {
			display: none;
		}

		.card-modern,
		.alert-warning-modern,
		.card-tabs {
			box-shadow: none;
			border: 1px solid #ccc;
		}

		.page-header {
			background: #f8f9fa !important;
			color: #333 !important;
		}
	}

	/* Accesibilidad */
	.nav-tabs-modern .nav-link:focus {
		outline: 2px solid var(--primary-color);
		outline-offset: 2px;
	}

	.btn:focus {
		outline: 2px solid var(--primary-color);
		outline-offset: 2px;
	}

	/* Estados de carga */
	.loading {
		opacity: 0.6;
		pointer-events: none;
	}

	.loading::after {
		content: '';
		position: absolute;
		top: 50%;
		left: 50%;
		width: 20px;
		height: 20px;
		margin: -10px 0 0 -10px;
		border: 2px solid #f3f3f3;
		border-top: 2px solid var(--primary-color);
		border-radius: 50%;
		animation: spin 1s linear infinite;
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	/* Mejoras adicionales para iconos */
	.mdi {
		vertical-align: middle;
	}

	/* Tooltips personalizados */
	[data-toggle="tooltip"] {
		cursor: help;
	}

	/* Badges adicionales */
	.badge {
		font-size: 0.75rem;
		padding: 0.375rem 0.75rem;
		border-radius: 9999px;
		font-weight: 500;
	}

	/* Espaciado consistente */
	.mb-4 {
		margin-bottom: 1.5rem !important;
	}

	.mt-4 {
		margin-top: 1.5rem !important;
	}

	.p-4 {
		padding: 1.5rem !important;
	}

	/* Colores de texto */
	.text-primary {
		color: var(--primary-color) !important;
	}

	.text-success {
		color: var(--success-color) !important;
	}

	.text-warning {
		color: var(--warning-color) !important;
	}

	.text-muted {
		color: var(--text-secondary) !important;
	}

	.long-observation {
		max-width: 350px;
		max-height: 120px;
		overflow: auto;
		white-space: pre-line;
		word-break: break-word;
		background: #f8fafc;
		border-radius: 0.375rem;
		padding: 0.5rem;
		font-size: 0.95em;
		line-height: 1.5;
		box-sizing: border-box;
	}
</style>
