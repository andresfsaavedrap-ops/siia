<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $administradores
 * @var $usuarios
 * @var $organizaciones
 * @var $correos
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
$CI->load->model("UsuariosModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("CorreosRegistroModel");
$CI->load->model("TokenModel");

if($logged_in == TRUE && $tipo_usuario == "super"): ?>
	<!-- Style page -->
	<link href="<?= base_url('assets/css/super/panel.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
	<!-- Template page -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section - Modernizado -->
			<div class="row mb-2">
				<div class="col-md-12 grid-margin">
					<div class="card shadow">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center flex-wrap">
								<div>
									<h3 class="font-weight-bold mb-2">
										<i class="mdi mdi-office-building mr-2 text-primary"></i>
										<?= $tipo_usuario; ?>
									</h3>
									<h6 class="font-weight-normal text-muted">
										Sistema Integrado de Información de Acreditación
										<span class="badge badge-danger ml-2 pulse-animation">3 alertas sin leer</span>
									</h6>
								</div>
								<div class="date-selector d-flex">
									<div class="current-date mr-3 d-none d-md-flex align-items-center">
										<i class="mdi mdi-calendar-today text-primary mr-2"></i>
										<span class="font-weight-medium"><?= date('d M Y'); ?></span>
									</div>
									<button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<i class="mdi mdi-calendar-range mr-2"></i> <span>Periodo</span>
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
										<a class="dropdown-item" href="#">Enero - Marzo</a>
										<a class="dropdown-item" href="#">Marzo - Junio</a>
										<a class="dropdown-item" href="#">Junio - Agosto</a>
										<a class="dropdown-item" href="#">Agosto - Noviembre</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Dashboard Summary Stats - Diseño mejorado -->
			<div class="row">
				<div class="col-12 mb-4">
					<div class="card bg-white shadow">
						<div class="card-body py-3">
							<div class="row align-items-center">
								<!-- Numero docentes -->
								<div class="col-md-3 col-sm-6 border-right">
									<div class="d-flex align-items-center mb-2 mb-md-0">
										<div class="icon-container bg-primary-light rounded-circle mr-3">
											<i class="mdi mdi-account-group text-primary"></i>
										</div>
										<div>
											<h6 class="font-weight-normal text-muted mb-0 small">Total de facilitadores</h6>
											<h4 class="font-weight-bold mb-0"><?= count($docentes) ?></h4>
										</div>
									</div>
								</div>
								<!-- Numero solicitudes -->
								<div class="col-md-3 col-sm-6 border-right">
									<div class="d-flex align-items-center mb-2 mb-md-0">
										<div class="icon-container bg-success-light rounded-circle mr-3">
											<i class="mdi mdi-clipboard-text text-success"></i>
										</div>
										<div>
											<h6 class="font-weight-normal text-muted mb-0 small">Total Solicitudes</h6>
											<h4 class="font-weight-bold mb-0"><?= count($solicitudes) ?></h4>
										</div>
									</div>
								</div>
								<!-- Numero personas capacitadas -->
								<div class="col-md-3 col-sm-6 border-right">
									<div class="d-flex align-items-center mb-2 mb-md-0">
										<div class="icon-container bg-warning-light rounded-circle mr-3">
											<i class="mdi mdi-account-multiple text-warning"></i>
										</div>
										<div>
											<h6 class="font-weight-normal text-muted mb-0 small">Personas capacitadas</h6>
											<h4 class="font-weight-bold mb-0"><?= count($personasCapacitadas) ?></h4>
										</div>
									</div>
								</div>
								<!-- Numero informe de actividades -->
								<div class="col-md-3 col-sm-6">
									<div class="d-flex align-items-center">
										<div class="icon-container bg-info-light rounded-circle mr-3">
											<i class="mdi mdi-chart-line text-info"></i>
										</div>
										<div>
											<h6 class="font-weight-normal text-muted mb-0 small">Informe de actividades</h6>
											<h4 class="font-weight-bold mb-0"><?= count($informe) ?></h4>
										</div>
									</div>
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
								<i class="mdi mdi-view-dashboard mr-2 text-primary"></i>Panel de Administración
							</h4>
							<div class="row">
								<?php if($nivel != '7'): ?>
								<!-- Tarjeta Administradores -->
								<div class="col-md-6 col-lg-3 mb-4">
									<a href="<?= base_url('super/administradores') ?>" class="text-decoration-none">
										<div class="card shadow-sm h-100 border-left-primary">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
														<i class="mdi mdi-shield-account"></i>
													</div>
													<div>
														<h5 class="font-weight-medium mb-1">Administradores</h5>
														<p class="text-muted mb-0 small">Gestión de administradores</p>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<!-- Tarjeta Usuarios -->
								<div class="col-md-6 col-lg-3 mb-4">
									<a href="<?= base_url('super/usuarios') ?>" class="text-decoration-none">
										<div class="card shadow-sm h-100 border-left-info">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
														<i class="mdi mdi-account-group"></i>
													</div>
													<div>
														<h5 class="font-weight-medium mb-1">Usuarios</h5>
														<p class="text-muted mb-0 small">Administración de usuarios</p>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<!-- Tarjeta Organizaciones -->
								<div class="col-md-6 col-lg-3 mb-4">
									<a href="<?= base_url('super/organizaciones') ?>" class="text-decoration-none">
										<div class="card shadow-sm h-100 border-left-success">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
														<i class="mdi mdi-office-building"></i>
													</div>
													<div>
														<h5 class="font-weight-medium mb-1">Organizaciones</h5>
														<p class="text-muted mb-0 small">Gestión de organizaciones</p>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<!-- Tarjeta Correos -->
								<div class="col-md-6 col-lg-3 mb-4">
									<a href="<?= base_url('super/correos') ?>" class="text-decoration-none">
										<div class="card shadow-sm h-100 border-left-warning">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
														<i class="mdi mdi-email"></i>
													</div>
													<div>
														<h5 class="font-weight-medium mb-1">Registro de Correos</h5>
														<p class="text-muted mb-0 small">Historial de correos</p>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Main Content Section - Rediseñado -->
			<div class="row">
				<!-- Left Side - Weather/Image Card -->
				<div class="col-lg-8 grid-margin">
					<!-- Gráficas y estadísticas -->
					<div class="card shadow">
						<div class="card-header bg-white py-3">
							<div class="d-flex justify-content-between align-items-center">
								<h5 class="mb-0 font-weight-medium">Estadísticas del sistema</h5>
								<div class="dropdown">
									<button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownStats" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="mdi mdi-calendar mr-1"></i>Este mes
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownStats">
										<a class="dropdown-item" href="#">Últimos 7 días</a>
										<a class="dropdown-item" href="#">Este mes</a>
										<a class="dropdown-item" href="#">Último trimestre</a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="chart-container" style="position: relative; height:300px;">
								<canvas id="statsChart"></canvas>
							</div>
						</div>
					</div>
					<!-- Actividades Recientes -->
					<div class="card shadow mt-4">
						<div class="card-header bg-white py-3">
							<div class="d-flex justify-content-between align-items-center">
								<h5 class="mb-0 font-weight-medium">
									<i class="mdi mdi-history mr-2 text-primary"></i>Actividades Recientes
								</h5>
								<div class="dropdown">
									<button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="mdi mdi-filter mr-1"></i>Filtrar
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="#">Hoy</a>
										<a class="dropdown-item" href="#">Semana</a>
										<a class="dropdown-item" href="#">Mes</a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body py-0">
							<div class="timeline">
								<div class="timeline-item d-flex pb-3 pt-3 border-bottom">
									<div class="timeline-icon bg-primary text-white rounded-circle">
										<i class="mdi mdi-file-document"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Solicitud #<?= rand(1000, 9999) ?> ha sido aprobada</h6>
										<p class="text-muted mb-0 small">
											<i class="mdi mdi-clock-outline mr-1"></i>Hace 2 horas
										</p>
									</div>
								</div>

								<div class="timeline-item d-flex pb-3 pt-3 border-bottom">
									<div class="timeline-icon bg-success text-white rounded-circle">
										<i class="mdi mdi-account-check"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Nuevo facilitador registrado</h6>
										<p class="text-muted mb-0 small">
											<i class="mdi mdi-clock-outline mr-1"></i>Hace 5 horas
										</p>
									</div>
								</div>

								<div class="timeline-item d-flex pb-3 pt-3">
									<div class="timeline-icon bg-warning text-white rounded-circle">
										<i class="mdi mdi-bell-ring"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Nueva alerta del sistema</h6>
										<p class="text-muted mb-0 small">
											<i class="mdi mdi-clock-outline mr-1"></i>Hace 1 día
										</p>
									</div>
								</div>
							</div>

							<div class="text-center mt-4 pb-2">
								<button class="btn btn-outline-primary">
									<i class="mdi mdi-arrow-right-circle mr-1"></i>Ver todas las actividades
								</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Right Side - Info Cards -->
				<div class="col-lg-4 grid-margin">
					<!-- Localización Card -->
					<div class="card shadow mb-4">
						<div class="card-header bg-white py-3">
							<h5 class="mb-0 font-weight-medium">
								<i class="mdi mdi-map-marker mr-2 text-danger"></i>Localización
							</h5>
						</div>
						<div class="card-body p-0">
							<div class="position-relative">
								<img src="<?php echo base_url('assets/img/pages/img.png') ?>" alt="people" class="w-100">
								<div class="weather-info position-absolute" style="bottom: 20px; right: 20px;">
									<div class="d-flex align-items-center bg-white p-3 rounded shadow-sm">
										<div>
											<h2 class="mb-0 font-weight-bold"><i class="icon-sun mr-2 text-warning"></i>24<sup>C</sup></h2>
										</div>
										<div class="ml-3 border-left pl-3">
											<h5 class="location font-weight-medium mb-1">Bogotá D.C</h5>
											<h6 class="font-weight-normal text-muted mb-0">Colombia</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Alertas y Notificaciones -->
					<div class="card shadow">
						<div class="card-header bg-white py-3">
							<h5 class="mb-0 font-weight-medium">
								<i class="mdi mdi-bell mr-2 text-warning"></i>Alertas pendientes
							</h5>
						</div>
						<div class="card-body">
							<div class="alert-item d-flex align-items-center mb-3 p-3 bg-light rounded">
								<div class="alert-icon bg-warning text-white rounded-circle mr-3">
									<i class="mdi mdi-alert"></i>
								</div>
								<div>
									<h6 class="font-weight-medium mb-1">Documentación pendiente</h6>
									<p class="text-muted mb-0 small">Revise los documentos pendientes antes del vencimiento</p>
								</div>
							</div>

							<div class="alert-item d-flex align-items-center mb-3 p-3 bg-light rounded">
								<div class="alert-icon bg-danger text-white rounded-circle mr-3">
									<i class="mdi mdi-calendar-alert"></i>
								</div>
								<div>
									<h6 class="font-weight-medium mb-1">Evaluación próxima</h6>
									<p class="text-muted mb-0 small">La evaluación de calidad está programada para mañana</p>
								</div>
							</div>

							<div class="alert-item d-flex align-items-center p-3 bg-light rounded">
								<div class="alert-icon bg-info text-white rounded-circle mr-3">
									<i class="mdi mdi-information"></i>
								</div>
								<div>
									<h6 class="font-weight-medium mb-1">Actualización del sistema</h6>
									<p class="text-muted mb-0 small">Nueva versión disponible, revisar cambios</p>
								</div>
							</div>

							<div class="text-center mt-4">
								<button class="btn btn-outline-warning">
									<i class="mdi mdi-bell-outline mr-1"></i>Ver todas las alertas
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Add Chart.js script -->
		</div>
		<!-- content-wrapper ends -->
	</div>
	</div>
</div>
<!-- Scrip page -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Datos para el gráfico
		var ctx = document.getElementById('statsChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep'],
				datasets: [{
					label: 'Solicitudes',
					data: [65, 59, 80, 81, 56, 55, 40, 58, 62],
					backgroundColor: 'rgba(78, 115, 223, 0.1)',
					borderColor: 'rgba(78, 115, 223, 1)',
					borderWidth: 2,
					tension: 0.4
				}, {
					label: 'Facilitadores',
					data: [28, 48, 40, 19, 26, 27, 45, 50, 55],
					backgroundColor: 'rgba(28, 200, 138, 0.1)',
					borderColor: 'rgba(28, 200, 138, 1)',
					borderWidth: 2,
					tension: 0.4
				}]
			},
			options: {
				maintainAspectRatio: false,
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							drawBorder: false
						}
					},
					x: {
						grid: {
							display: false
						}
					}
				},
				plugins: {
					legend: {
						position: 'top',
					}
				}
			}
		});
	});
</script>
<?php endif; ?>
