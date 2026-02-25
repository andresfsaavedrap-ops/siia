<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $nivel
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
if($logged_in == TRUE && $tipo_usuario == "admin"): ?>
	<!-- Style page -->
	<link href="<?= base_url('assets/css/admin/panel.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
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
										<i class="mdi mdi-shield-account mr-2 text-primary"></i>
										Bienvenido <?= ucfirst($CI->AdministradoresModel->getNameComplete($nombre_usuario)) ?>
									</h3>
									<h6 class="font-weight-normal text-muted">
										Sistema Integrado de Información de Acreditación
										<!-- Dashboard Summary Stats -->
										<?php if($nivel == '0'):?>
										<span class="badge badge-warning ml-2 pulse-animation">3 alertas sin leer</span>
										<?php endif; ?>
									</h6>
								</div>
								<div class="date-selector d-flex">
									<div class="current-date mr-3 d-none d-md-flex align-items-center">
										<i class="mdi mdi-calendar-today text-primary mr-2"></i>
										<span class="font-weight-medium"><?= date('d M Y'); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Dashboard Summary Stats -->
			<?php if($nivel == '0'): ?>
				<div class="row">
					<div class="col-12 mb-4">
						<div class="card bg-white shadow">
							<div class="card-body py-3">
								<div class="row align-items-center">
									<!-- Administradores -->
									<div class="col-md-3 col-sm-6 border-right">
										<div class="d-flex align-items-center mb-2 mb-md-0">
											<div class="icon-container bg-primary-light rounded-circle mr-3">
												<i class="mdi mdi-shield-account text-primary"></i>
											</div>
											<div>
												<h6 class="font-weight-normal text-muted mb-0 small">Administradores</h6>
												<h4 class="font-weight-bold mb-0"><?= count($administradores) ?></h4>
											</div>
										</div>
									</div>
									<!-- Usuarios -->
									<div class="col-md-3 col-sm-6 border-right">
										<div class="d-flex align-items-center mb-2 mb-md-0">
											<div class="icon-container bg-info-light rounded-circle mr-3">
												<i class="mdi mdi-account-group text-info"></i>
											</div>
											<div>
												<h6 class="font-weight-normal text-muted mb-0 small">Usuarios</h6>
												<h4 class="font-weight-bold mb-0"><?= count($usuarios) ?></h4>
											</div>
										</div>
									</div>
									<!-- Organizaciones -->
									<div class="col-md-3 col-sm-6 border-right">
										<div class="d-flex align-items-center mb-2 mb-md-0">
											<div class="icon-container bg-success-light rounded-circle mr-3">
												<i class="mdi mdi-office-building text-success"></i>
											</div>
											<div>
												<h6 class="font-weight-normal text-muted mb-0 small">Organizaciones</h6>
												<h4 class="font-weight-bold mb-0"><?= count($organizaciones) ?></h4>
											</div>
										</div>
									</div>
									<!-- Correos -->
									<div class="col-md-3 col-sm-6">
										<div class="d-flex align-items-center">
											<div class="icon-container bg-warning-light rounded-circle mr-3">
												<i class="mdi mdi-email text-warning"></i>
											</div>
											<div>
												<h6 class="font-weight-normal text-muted mb-0 small">Registro de correos</h6>
												<h4 class="font-weight-bold mb-0"><?= count($correos) ?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<!-- Incluir las tarjetas del dashboard con control de niveles -->
			<?php $this->load->view('admin/partials/_dashboard_cards', ['nivel' => $nivel]); ?>
			<!-- Main Content Section -->
			 <!-- Dashboard Summary Stats -->
			<?php if($nivel == '0'): ?>
			<div class="row">
				<!-- Left Side - Location/Weather Card -->
				<!-- Actividades Recientes -->
				<div class="col-lg-8 grid-margin">
					<div class="card shadow">
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
										<i class="mdi mdi-account-plus"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Nuevo administrador registrado</h6>
										<p class="text-muted mb-0 small">
											<i class="mdi mdi-clock-outline mr-1"></i>Hace 2 horas
										</p>
									</div>
								</div>

								<div class="timeline-item d-flex pb-3 pt-3 border-bottom">
									<div class="timeline-icon bg-success text-white rounded-circle">
										<i class="mdi mdi-office-building"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Nueva organización aprobada</h6>
										<p class="text-muted mb-0 small">
											<i class="mdi mdi-clock-outline mr-1"></i>Hace 5 horas
										</p>
									</div>
								</div>

								<div class="timeline-item d-flex pb-3 pt-3">
									<div class="timeline-icon bg-warning text-white rounded-circle">
										<i class="mdi mdi-email"></i>
									</div>
									<div class="timeline-content ml-3">
										<h6 class="font-weight-medium mb-1">Correo de notificación enviado</h6>
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
								<img src="<?= base_url('assets/img/background-login.png') ?>" alt="people" class="w-100">
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
									<h6 class="font-weight-medium mb-1">Usuarios pendientes de aprobación</h6>
									<p class="text-muted mb-0 small">Revise las solicitudes de registro pendientes</p>
								</div>
							</div>

							<div class="alert-item d-flex align-items-center mb-3 p-3 bg-light rounded">
								<div class="alert-icon bg-danger text-white rounded-circle mr-3">
									<i class="mdi mdi-calendar-alert"></i>
								</div>
								<div>
									<h6 class="font-weight-medium mb-1">Organizaciones por vencer</h6>
									<p class="text-muted mb-0 small">3 organizaciones requieren renovación</p>
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
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<!-- content-wrapper ends -->
	</div>
<?php endif; ?>
</div>
