<?php

/***
 * @var $nivel
 * @var $tipo_usuario
 * @var $logged_in
 * @var $activeLink
 * @var $organizacion
 */
/*echo '<pre>';
var_dump($nivel);
echo '</pre>';
return null;*/
// Cargar imagen de perfil
if ($organizacion != null):
	$imagen = 'uploads/logosOrganizaciones/' . $organizacion->imagenOrganizacion;
else:
	$imagen = 'assets/img/default.png';
endif;
// Comprobar tipo de usuario
switch ($tipo_usuario) {
	case 'user':
		$panel = 'organizacion/panel';
		$perfil = 'organizacion/perfil';
		$logout = 'salir_sesion';
		break;
	case 'super':
		$panel = 'super/panel';
		$perfil = 'super/perfil';
		$logout = 'super_cerrar_sesion';
		break;
	case 'admin':
		$panel = 'admin/panel';
		$perfil = 'admin/perfil';
		$logout = 'salir_admin';
		break;
	default:
		$panel = 'admin/panel';
		$perfil = 'admin/perfil';
		$logout = 'salir_sesion';
		break;
}
?>
<!-- partial:../../partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
		<a class="navbar-brand brand-logo mr-5" href="<?= base_url($panel) ?>"><img src="<?= base_url('assets/img/siia_logo.png') ?>" class="mr-2" alt="logo" /></a>
		<a class="navbar-brand brand-logo-mini" href="<?= base_url($panel) ?>"><img src="<?= base_url('assets/img/siia_logo_ico.png') ?>" class="mr-2" alt="logo" /></a>
	</div>
	<!-- Botón responsive -->
	<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
		<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
			<span class="icon-menu"></span>
		</button>
		<!-- Perfil y cerrar sesión -->
		<ul class="navbar-nav navbar-nav-right">
			<?php if ($tipo_usuario != 'user' && $nivel == '0'): ?>
				<!-- Notifications TODO: Validar según usuario -->
				<li class="nav-item dropdown">
					<!-- Icon -->
					<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
						<i class="icon-bell mx-0"></i> 3
						<span class="count"></span>
					</a>
					<!-- Items TODO: Realizar foreach con notificaciones y tipo -->
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
						<p class="mb-0 font-weight-normal float-left dropdown-header">Notificaciones</p>
						<a class="dropdown-item preview-item">
							<div class="preview-thumbnail">
								<div class="preview-icon bg-success">
									<i class="ti-info-alt mx-0"></i>
								</div>
							</div>
							<div class="preview-item-content">
								<h6 class="preview-subject font-weight-normal">Solicitudes terminadas</h6>
								<p class="font-weight-light small-text mb-0 text-muted">
									Hace 5 minutos
								</p>
							</div>
						</a>
						<a class="dropdown-item preview-item">
							<div class="preview-thumbnail">
								<div class="preview-icon bg-warning">
									<i class="ti-settings mx-0"></i>
								</div>
							</div>
							<div class="preview-item-content">
								<h6 class="preview-subject font-weight-normal">Alertas</h6>
								<p class="font-weight-light small-text mb-0 text-muted">
									Solicitudes pendientes por evaluar
								</p>
							</div>
						</a>
						<a class="dropdown-item preview-item">
							<div class="preview-thumbnail">
								<div class="preview-icon bg-info">
									<i class="ti-user mx-0"></i>
								</div>
							</div>
							<div class="preview-item-content">
								<h6 class="preview-subject font-weight-normal">Usuarios nuevos</h6>
								<p class="font-weight-light small-text mb-0 text-muted">
									Hace 2 días
								</p>
							</div>
						</a>
					</div>
				</li>
			<?php endif; ?>
			<!-- Profile -->
			<li class="nav-item nav-profile dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
					<img src="<?= base_url($imagen); ?>" alt="profile" />
				</a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
					<?php if ($nivel != '7'): ?>
						<a href="<?= base_url($perfil) ?>" class="dropdown-item">
							<i class="ti-user text-primary"></i>
							<?= $nombre_usuario ?>
						</a>
					<?php endif; ?>
					<a class="dropdown-item" id="<?= $logout ?>">
						<i class="ti-power-off text-primary"></i>
						Cerrar Sesión
					</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
			<span class="icon-menu"></span>
		</button>
	</div>
</nav>
