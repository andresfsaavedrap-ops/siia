<?php
/***
 * @var $organizacion
 * @var $docentes
 * @var $solicitudes
 * @var $personasCapacitadas
 * @var $informes
 */
/* * echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!-- Style page -->
<link href="<?= base_url('assets/css/user/panel.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
<!-- Template page -->
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section - Modernizado -->
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="card shadow">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center flex-wrap">
							<div>
								<h3 class="font-weight-bold mb-2">
									<i class="mdi mdi-office-building mr-2 text-primary"></i>
									<?= $organizacion->nombreOrganizacion; ?>
								</h3>
								<h6 class="font-weight-normal text-muted">
									Sistema Integrado de Información de Acreditación
									<!-- Alertas -->
									<!--<span class="badge badge-danger ml-2 pulse-animation">3 alertas sin leer</span>-->
								</h6>
							</div>
							<div class="date-selector d-flex">
								<div class="current-date mr-3 d-none d-md-flex align-items-center">
									<i class="mdi mdi-calendar-today text-primary mr-2"></i>
									<span class="font-weight-medium"><?= date('d M Y'); ?></span>
								</div>
								<!-- <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<i class="mdi mdi-calendar-range mr-2"></i> <span>Periodo</span>
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
									<a class="dropdown-item" href="#">Enero - Marzo</a>
									<a class="dropdown-item" href="#">Marzo - Junio</a>
									<a class="dropdown-item" href="#">Junio - Agosto</a>
									<a class="dropdown-item" href="#">Agosto - Noviembre</a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Panel Principal con Tarjetas de Menú -->
		<div class="row">
			<div class="col-12 mb-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h4 class="card-title mb-4">
							<i class="mdi mdi-view-dashboard mr-2 text-primary"></i>Menu Principal
						</h4>
						<div class="row">
							<!-- Tarjeta Solicitudes -->
							<div class="col-md-6 col-sm-12 mb-4">
								<a href="<?php echo base_url('organizacion/solicitudes'); ?>" class="text-decoration-none">
									<div class="card shadow-sm h-100 border-left-warning">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
													<i class="mdi mdi-file-document"></i>
												</div>
												<div>
													<h5 class="font-weight-medium mb-1">Solicitudes</h5>
													<p class="text-muted mb-0 small">Gestión de solicitudes</p>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<!-- Tarjeta Facilitadores -->
							<div class="col-md-6 col-sm-12 mb-4">
								<a href="<?php echo base_url('organizacion/facilitadores'); ?>" class="text-decoration-none">
									<div class="card shadow-sm h-100 border-left-info">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
													<i class="mdi mdi-account-group"></i>
												</div>
												<div>
													<h5 class="font-weight-medium mb-1">Facilitadores</h5>
													<p class="text-muted mb-0 small">Administración de docentes</p>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<!-- Tarjeta Perfil Organización -->
							<div class="col-md-6 col-sm-12 mb-4">
								<a href="<?php echo base_url('organizacion/perfil'); ?>" class="text-decoration-none">
									<div class="card shadow-sm h-100 border-left-primary">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
													<i class="mdi mdi-domain"></i>
												</div>
												<div>
													<h5 class="font-weight-medium mb-1">Perfil Organización</h5>
													<p class="text-muted mb-0 small">Datos de la organización</p>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<!-- Tarjeta Informe de Actividades -->
							<?php if ($organizacion->estado == "Acreditado"): ?>
							<div class="col-md-6 col-sm-12 mb-4">
								<a href="<?php echo base_url('organizacion/informe-actividades'); ?>" class="text-decoration-none">
									<div class="card shadow-sm h-100 border-left-success">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
													<i class="mdi mdi-domain"></i>
												</div>
												<div>
													<h5 class="font-weight-medium mb-1">Informe de Actividades</h5>
													<p class="text-muted mb-0 small">Datos de la cursos impartidos por la organización</p>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<?php endif; ?>
							<!-- Tarjeta Ayuda -->
							<div class="col-md-6 col-sm-12 mb-4">
								<a href="<?php echo base_url('organizacion/ayuda'); ?>" class="text-decoration-none">
									<div class="card shadow-sm h-100 border-left-danger">
										<div class="card-body">
											<div class="d-flex align-items-center">
												<div class="icon-shape bg-danger text-white rounded-circle p-3 mr-3">
													<i class="mdi mdi-help-circle"></i>
												</div>
												<div>
													<h5 class="font-weight-medium mb-1">Ayuda</h5>
													<p class="text-muted mb-0 small">Soporte y documentación</p>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Estadísticas Resumidas -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow-sm">
					<div class="card-body p-0">
						<div class="row no-gutters">
							<div class="col-md-3 border-right">
								<div class="d-flex align-items-center p-4">
									<div class="icon-shape bg-primary-light rounded-circle mr-3">
										<i class="mdi mdi-clipboard-text text-primary"></i>
									</div>
									<div>
										<h4 class="font-weight-bold text-primary mb-1"><?= count($solicitudes) ?></h4>
										<p class="text-muted mb-0">Solicitudes</p>
									</div>
								</div>
							</div>
							<div class="col-md-3 border-right">
								<div class="d-flex align-items-center p-4">
									<div class="icon-shape bg-info-light rounded-circle mr-3">
										<i class="mdi mdi-account-group text-info"></i>
									</div>
									<div>
										<h4 class="font-weight-bold text-info mb-1"><?= count($docentes) ?></h4>
										<p class="text-muted mb-0">Facilitadores</p>
									</div>
								</div>
							</div>
							<div class="col-md-3 border-right">
								<div class="d-flex align-items-center p-4">
									<div class="icon-shape bg-success-light rounded-circle mr-3">
										<i class="mdi mdi-check-circle text-success"></i>
									</div>
									<div>
										<h4 class="font-weight-bold text-success mb-1"><?= count($informes) ?></h4>
										<p class="text-muted mb-0">Informe de actividades</p>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="d-flex align-items-center p-4">
									<div class="icon-shape bg-warning-light rounded-circle mr-3">
										<i class="mdi mdi-clock-outline text-warning"></i>
									</div>
									<div>
										<h4 class="font-weight-bold text-warning mb-1"><?= count($personasCapacitadas) ?></h4>
										<p class="text-muted mb-0">Personas capacitadas</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- content-wrapper ends -->
</div>
</div>
