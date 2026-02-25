<!-- Estilos personalizados módulo -->
<link href="<?= base_url('assets/css/admin/modules/organizaciones/custom-organizaciones.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
<?php
/***
 * @var $activeLink
 * @var $nivel
 */
// Función para verificar permisos basada en la lógica del sistema
function canAccessOrganizacion($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section - Más compacto -->
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-office-building text-primary mr-2"></i>
							Gestión del Trámite
						</h4>
						<p class="text-muted mb-0 small">Administra las solicitudes en trámite del sistema</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Secciones en pestañas para reducir espacio vertical -->
		<div class="row">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0 pb-0">
						<ul class="nav nav-tabs card-header-tabs" id="organizacionesTabs" role="tablist">
							<!-- Solicitudes - Niveles que NO son 7 -->
							<?php if (canAccessOrganizacion([0,1,4,5,6, 7], $nivel)): ?>
							<li class="nav-item">
								<a class="nav-link active" id="solicitudes-tab" data-toggle="tab" href="#solicitudes" role="tab">
									<i class="mdi mdi-file-multiple mr-1"></i>Solicitudes
								</a>
							</li>
							<?php endif; ?>
							<!-- Operaciones - Solo niveles 0,1,6 -->
							<?php if (canAccessOrganizacion([0,1,3,6], $nivel)): ?>
							<li class="nav-item">
								<a class="nav-link" id="operaciones-tab" data-toggle="tab" href="#operaciones" role="tab">
									<i class="mdi mdi-wrench mr-1"></i>Acciones de cierre
								</a>
							</li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="organizacionesTabContent">
							<!-- Solicitudes Tab - Niveles que NO son 7 -->
							<?php if (canAccessOrganizacion([0,1,4,5,6], $nivel)): ?>
							<div class="tab-pane fade show active" id="solicitudes" role="tabpanel">
								<div class="row">
									<!-- Asignar Solicitudes - Solo niveles 0,6 -->
									<?php if (canAccessOrganizacion([0,6], $nivel)): ?>
									<div class="col-md-4 mb-2" id="asigOrg">
										<div class="card border-left-warning h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-warning-light mr-3">
														<i class="mdi mdi-hand-pointing-right text-warning"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Asignar Solicitudes</h6>
														<p class="text-muted mb-2 small">Asignar evaluadores</p>
														<a href="<?= site_url('admin/tramite/solicitudes/asignar') ?>" class="btn btn-warning btn-sm">
															<i class="mdi mdi-account-plus mr-1"></i>Asignar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- En Evaluación - Niveles que NO son 5,7 -->
									<?php if (canAccessOrganizacion([0,1,4,6], $nivel)): ?>
									<div class="col-md-4 mb-2" id="verOrgFin">
										<div class="card border-left-success h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-success-light mr-3">
														<i class="mdi mdi-flag-checkered text-success"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">En Evaluación</h6>
														<p class="text-muted mb-2 small">Siendo evaluadas</p>
														<a href="<?= site_url('admin/tramite/solicitudes/finalizadas');?>" class="btn btn-success btn-sm">
															<i class="mdi mdi-clipboard-check mr-1"></i>Ver
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- Complementaria - Niveles que NO son 5,7 -->
									<?php if (canAccessOrganizacion([0,1,2,3,4,6], $nivel)): ?>
									<div class="col-md-4 mb-2" id="verOrgObs">
										<div class="card border-left-info h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-info-light mr-3">
														<i class="mdi mdi-eye text-info"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">En Observaciones</h6>
														<p class="text-muted mb-2 small">Con observaciones</p>
														<a href="<?= site_url('admin/tramite/solicitudes/observaciones');?>" class="btn btn-info btn-sm">
															<i class="mdi mdi-comment-text mr-1"></i>Ver
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- En Proceso - Nivel 0 -->
									<?php if (canAccessOrganizacion([0,], $nivel)): ?>
									<div class="col-md-4 mb-2" id="verOrgPro">
										<div class="card border-left-warning h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-warning-light mr-3">
														<i class="mdi mdi-progress-clock text-warning"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">En Proceso</h6>
														<p class="text-muted mb-2 small">En trámite</p>
														<a href="<?= site_url('admin/organizaciones/solicitudes/proceso');?>" class="btn btn-warning btn-sm">
															<i class="mdi mdi-clock-outline mr-1"></i>Ver
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<!-- Operaciones Tab - Solo niveles 0,1,6 -->
							<?php if (canAccessOrganizacion([0,1,3,6], $nivel)): ?>
							<div class="tab-pane fade" id="operaciones" role="tabpanel">
								<div class="row">
									<!-- Cambiar Estado - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,1,6], $nivel)): ?>
									<div class="col-md-4 mb-2" id="camEstOrg">
										<div class="card border-left-info h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-info-light mr-3">
														<i class="mdi mdi-information text-info"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Cambiar Estado</h6>
														<p class="text-muted mb-2 small">Modificar estado</p>
														<a href="<?= site_url('admin/organizaciones/estado');?>" class="btn btn-info btn-sm">
															<i class="mdi mdi-swap-horizontal mr-1"></i>Estado
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- Resoluciones - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,1,6], $nivel)): ?>
									<div class="col-md-4 mb-2">
										<div class="card border-left-secondary h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-secondary-light mr-3">
														<i class="mdi mdi-file-document text-secondary"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Resoluciones</h6>
														<p class="text-muted mb-2 small">Documentos oficiales</p>
														<a href="<?= site_url('admin/resoluciones');?>" class="btn btn-secondary btn-sm">
															<i class="mdi mdi-file-plus mr-1"></i>Adjuntar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- NIT Entidades - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,1,6], $nivel)): ?>
									<div class="col-md-4 mb-2">
										<div class="card border-left-dark h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-dark-light mr-3">
														<i class="mdi mdi-identifier text-dark"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">NIT Entidades</h6>
														<p class="text-muted mb-2 small">Gestionar NIT de entidades</p>
														<a href="<?= site_url('admin/operaciones/nit-entidades');?>" class="btn btn-dark btn-sm">
															<i class="mdi mdi-open-in-new mr-1"></i>Gestionar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- Cámara de Comercio - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,3], $nivel)): ?>
									<div class="col-md-4 mb-2" id="adjCamara">
										<div class="card border-left-danger h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-danger-light mr-3">
														<i class="mdi mdi-file-pdf-box text-danger"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Cámara de Comercio</h6>
														<p class="text-muted mb-2 small">Documentos legales</p>
														<a href="<?= site_url('admin/organizaciones/camara-comercio');?>" class="btn btn-danger btn-sm">
															<i class="mdi mdi-upload mr-1"></i>Adjuntar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
