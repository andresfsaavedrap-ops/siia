<?php
/***
 * @var $title
 * @var $logged_in
 * @var $tipo_usuario
 * @var $usuario_id
 * @var $nombre_usuario
 * @var $hora
 * @var $fecha
 * @var $nivel
 * @var $municipios
 * @var $departamentos
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta http-equiv="refresh" content="7200" />
	<meta name="application-name" content="Sistema Integrado de Información de Acreditación - SIIA" />
	<meta name="description" content="Sistema Integrado de Información de Acreditación (SIIA) para entidades con interés de acreditarse en cursos de economía solidaria. Unidad Administrativa Especial de Organizaciones Solidarias." />
	<meta name="keywords" content="Organizaciones Solidarias,Sector Solidario,Cooperativas,Economía solidaria,Empresa,Social,Asociatividad,Emprendimiento,Proyectos productivos,Negocios inclusivos,Productores,Empresarios,Campesinos,Asociativo,Comercio justo,Agro,Ley 454" />
	<meta name="author" content="Unidad Solidaria" />
	<meta name="revisit-after" content="30 days" />
	<meta name="distribution" content="web" />
	<meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW" />
	<!-- Styles -->
	<link href="<?= base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link href="<?= base_url('assets/css/styles.css?v=1.0.8.1919') ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/img/favicon16.png') ?>" type="image/png" sizes="16x16" rel="icon" />
	<link href="<?= base_url('assets/img/favicon32.png') ?>" type="image/png" sizes="32x32" rel="icon" />
	<link href="<?= base_url('assets/img/favicon64.png') ?>" type="image/png" sizes="64x64" rel="icon" />
	<link href="<?= base_url('assets/img/favicon128.png') ?>" type="image/png" sizes="128x128" rel="shortcut icon" />
	<link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
	<meta name="theme-color" content="#09476E" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="white-translucent" />
	<meta name="google-site-verification" content="DloHloB2_mQ9o7BPTd9xXEYHUeXrnWQqKGGKeuGrkLk" />
	<!-- Google -->
	<script src="https://www.google.com/recaptcha/api.js?render=6LeTFnYnAAAAAKl5U_RbOYnUbGFGlhG4Ffn52Sef"></script>
	<!-- Title -->
	<title> Sistema Integrado de Información de Acreditación | <?= $title; ?></title>
</head>
<body class="nav-md">
	<div class="se-pre-con"></div>
	<!-- Cabecera y Navbar -->
	<header>
		<section class="top-nav">
			<div class="container">
				<!-- <div class="row">
					<div class="col-md-12">
                    <h3 id="titulo_sistema"></h3>
                </div> -->
				<div class="col-md-12">
					<a href="https://www.gov.co/home/" target="_blank"><img src="<?= base_url(); ?>assets/img/govco.png" class="img-responsive" style="width: 1903px;margin-bottom: 2%;"></a>
				</div>
				<div class="col-md-6">
					<a href="<?= PAGINA_WEB ?>"><img alt="Unidad Solidaria" id="imagen_header" height="190px" width="370px" class="pull-left img-responsive" src="<?= base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png"></a>
				</div>
				<div class="col-md-6">
					<a href="<?= base_url(); ?>"><img alt="SIIA" id="imagen_header_sia" class="pull-right img-responsive" src="<?= base_url(); ?>assets/img/siia_logo.png"></a>
				</div>
			</div>
		</section>
		<div id="tPg" titulo="<?= $title; ?>"></div>
		<!-- Navbar Usuario no registrado //TODO: Navbar de usuario no registrado -->
		<?php if (!$logged_in && $tipo_usuario == "none") {
			echo "<div class='hidden' id='data_logg' data-log='$logged_in'></div>";
		?>
			<nav class="navbar navbar-dark">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a class="active" href="<?= base_url('home'); ?>">Home <i class="fa fa-home" aria-hidden="true"></i></a></li>
							<li><a href="<?= base_url('estado'); ?>">Estado de la solicitud <i class="fa fa-eye" aria-hidden="true"></i></a></li>
							<li><a href="<?= base_url('facilitadores'); ?>">Facilitadores válidos <i class="fa fa-users" aria-hidden="true"></i></a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="<?= base_url('login'); ?>">Iniciar sesión <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
							<li><a href="<?= base_url('registro'); ?>">Registrarme <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		<?php
		} ?>
		<div class="body">
			<div class="main_container" role="main">
				<!-- Navbar Bar Usuario //TODO: Navbar usuario (Orgaizaciones) -->
				<?php
				if ($logged_in && $tipo_usuario == "user") {
					echo "<div class='hidden' id='data_logg' data-log='$logged_in'></div>";
				?>
					<div class="container">
						<ol class="breadcrumb col-md-12"></ol>
					</div>
					<!-- Navbar Contenido -->
					<div class="top_nav container">
						<div class="nav_menu">
							<h3 class="text-center col-md-7"><?= $title; ?></h3>
							<nav>
								<ul class="nav navbar-nav col-md-4 text-center nav-sia-panel">
									<!-- Fecha -->
									<li class="noSpaceLi"><a>| Fecha: <?= $fecha . " " . $hora; ?> |</a></li>
									<!-- Menu -->
									<li class="noSpaceLi">
										<a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">| <?= $nombre_usuario; ?> <span class=" fa fa-angle-down"></span> |</a>
										<ul class="dropdown-menu dropdown-usermenu pull-right">
											<br>
											<li><a>Soporte ID: <strong><?= $usuario_id; ?></strong><br /> Nombre Usuario: <strong><?= $nombre_usuario; ?></strong></a></li>
											<hr />
											<caption> Menú:</caption>
											<li><a href="<?= base_url('panel'); ?>">Panel Principal <i class="fa fa-header" aria-hidden="true"></i></a></li>
											<li><a href="<?= base_url('panel/perfil'); ?>">Perfil <i class="fa fa-address-book-o" aria-hidden="true"></i></a></li>
											<li><a href="<?= base_url('panel/docentes'); ?>">Facilitadores <i class="fa fa-graduation-cap" aria-hidden="true"></i></a></li>
											<!-- <li><a href="javascript:;">Plan de Mejoramiento</a></li>
										<li><a href="javascript:;">Informe de Actividades</a></li> -->
											<li><a href="<?= base_url('panel/contacto/ayuda'); ?>">Ayuda <i class="fa fa-info" aria-hidden="true"></i></a></li>
											<hr />
											<li><a class='center-block' data-toggle='modal' data-target='#cerrar_sesion'>Cerrar Sesión <i class="fa fa-sign-out pull-right"></i></a></li>
											<br>
										</ul>
									</li>
									<!-- Notificaciones -->
									<li role="presentation" class="dropdown notificaciones noSpaceLi">
										<a class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
											|
											<i class="fa fa-envelope-o"></i>
											<span class="badge bg-green">0</span>
											|
										</a>
										<!--<button class="btn btn-danger" data-toggle='modal' data-target='#cerrar_sesion'>Cerrar Sesión <i class="fa fa-sign-out"></i></button>-->
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!-- Menu formulario acreditación //TODO: Menu Formulario para acreditación-->
					<?php if ($tipo_usuario == "user") { ?>
								<!-- <div class="col-md-12">
								<hr />
								<a class="col-md-1 ayuda" title="Ayuda">
									<span class="fa fa-question" aria-hidden="true"></span>
								</a>
								<a class="col-md-1 contacto" title="Contacto">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</a>
								<a class="col-md-1" title="Informe de Actividades">
									<i class="fa fa-file-text" aria-hidden="true"></i>
								</a>
								<a class="col-md-1" title="Plan de Mejoramiento">
									<i class="fa fa-thumbs-up" aria-hidden="true"></i>
								</a>
								<a class="col-md-1" title="Docentes">
									<i class="fa fa-users" aria-hidden="true"></i>
								</a>
								<a class="col-md-1 ver_perfil" title="Perfil">
									<span class="fa fa-user" aria-hidden="true"></span>
								</a>
								<a data-toggle='modal' data-target='#cerrar_sesion' class="col-md-1" title="Cerrar Sesión">
									<span class="fa fa-sign-out" aria-hidden="true"></span>
								</a>
							</div> -->
							</div>
						</div>
					<?php } else {
						/** Nothing to do now **/
					} ?>
					<!-- Administrador   //TODO: Navbar para  Administradores-->
				<?php } else if ($logged_in && $tipo_usuario == "admin") {
					echo "<div class='hidden' id='data_logg' data-log='$logged_in' nvl='$nivel'></div>";
				?>
					<div class="container">
						<ol class="breadcrumb col-md-12"></ol>
					</div>
					<!-- Botón desblear observaciones -->
					<div class="icono--div">
						<a class="btn btn-siia btn-sm icono desOptSiia" role="button" title="Desplegar observaciones" data-toggle="tooltip" data-placement="right">Bateria de observaciones <i class="fa fa-expand" aria-hidden="true"></i></a>
					</div>
					<!-- Botón desblear registro de llamadas -->
					<div class="icono--registro-llamadas">
						<a class="btn btn-siia btn-sm desOptSiia" role="button" title="Registro telefonico" data-toggle='modal' data-target='#modal_form_registro_llamadas' data-placement="right">Registro telefónico <i class="fa fa-phone" aria-hidden="true"></i></a>
					</div>
					<!-- Bateria de Observaciones //TODO: Batería de observaciones para dividir de estar archivo -->
					<div class="contenedor--menu">
						<ul class="menu">
							<h4>Bateria de observaciones:</h4>
							<hr />
							<div class="col-md-12">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Buscar..." id="buscarObsText" />
									<span class="clearInput"><i class="fa fa-times" aria-hidden="true"></i></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<hr />
							<div id="divBateriaObservaciones">
								<li id="1bat"><a class="menu__enlace">1. Información General de la Entidad <i class="fa fa-home" aria-hidden="true"></i></a></li>
								<li id="2bat"><a class="menu__enlace">2. Documentación Legal <i class="fa fa-book" aria-hidden="true"></i></a></li>
								<li id="3bat"><a class="menu__enlace">3. Registros educativos de Programas <i class="fa fa-book" aria-hidden="true"></i></a></li>
								<li id="4bat"><a class="menu__enlace">4. Antecedentes Académicos <i class="fa fa-id-card" aria-hidden="true"></i></a></li>
								<li id="5bat"><a class="menu__enlace">5. Jornadas de actualización <i class="fa fa-handshake-o" aria-hidden="true"></i></a></li>
								<li id="6bat"><a class="menu__enlace">6. Programa básico de economía solidaria <i class="fa fa-server" aria-hidden="true"></i></a></li>
								<li id="7bat"><a class="menu__enlace">7. Programas Aval <i class="fa fa-sitemap" aria-hidden="true"></i></a></li>
								<li id="8bat"><a class="menu__enlace">8. Programas <i class="fa fa-signal" aria-hidden="true"></i></a></li>
								<li id="9bat"><a class="menu__enlace">9. Facilitadores <i class="fa fa-users" aria-hidden="true"></i></a></li>
								<li id="10bat"><a class="menu__enlace">10. Datos Plataforma Virtual <i class="fa fa-globe" aria-hidden="true"></i></a></li>
								<li id="11bat"><a class="menu__enlace">Observaciones Generales</a>
							</div>
						</ul>
					</div>
					<!-- Navbar Administrador //TODO: Navbar para administrador :Corregir permisos según tipo de administrador -->
					<div class="top_nav container">
						<div class="nav_menu">
							<!-- Titulo -->
							<h3 class="text-center col-md-7"><?= $title; ?></h3>
							<nav>
								<ul class="nav navbar-nav col-md-4 text-center nav-sia-panel">
									<!-- Fecha -->
									<li class="noSpaceLi"><a>| Fecha: <?= $fecha . " " . $hora; ?> |</a></li>
									<!-- Menu -->
									<li class="noSpaceLi">
										<a class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">| <?= $nombre_usuario; ?> <span class=" fa fa-angle-down"></span> |</a>
										<ul class="dropdown-menu dropdown-usermenu pull-right">
											<br>
											<li><a>Soporte ID: <strong><?= $usuario_id; ?></strong> <br /> Nombre Usuario: <strong><?= $nombre_usuario; ?></strong></a></li>
											<hr />
											<caption> Menú:</caption>
											<li><a href="<?= base_url('panelAdmin'); ?>">Panel principal</a></li>
											<li><a href="<?= base_url('panelAdmin/reportes'); ?>">Reportes</a></li>
											<li><a href="<?= base_url('panelAdmin/organizaciones'); ?>">Organizaciones</a></li>
											<ul>
												<li><a href="<?= base_url('panelAdmin/organizaciones/inscritas'); ?>">Organizaciones inscritas</a></li>
												<li><a href="<?= base_url('panelAdmin/organizaciones/solicitudes/finalizadas'); ?>">Organizaciones en evaluación</a></li>
												<li><a href="<?= base_url('panelAdmin/organizaciones/solicitudes/observaciones'); ?>">Organizaciones en complementaria</a></li>
												<hr />
												<li><a href="<?= base_url('panelAdmin/organizaciones/docentes'); ?>">Facilitadores</a></li>
												<li><a href="<?= base_url('panelAdmin/organizaciones/estadoOrganizaciones'); ?>">Estado organizaciones</a></li>
												<li><a href="<?= base_url('panelAdmin/organizaciones/inscritas'); ?>">Resoluciones</a></li>
												<li><a href="<?= base_url('panelAdmin/organizaciones/camaraComercio'); ?>">Camara de comercio</a></li>
											</ul>
											<li><a href="<?= base_url('panelAdmin/historico'); ?>">Histórico</a></li>
											<li><a href="<?= base_url('panelAdmin/seguimiento'); ?>">Seguimientos</a></li>
											<li><a href="<?= base_url('panelAdmin/opciones'); ?>">Operaciones</a></li>
											<li><a href="<?= base_url('panelAdmin/socrata'); ?>">Datos abiertos</a></li>
											<li><a href="<?= base_url('panelAdmin/contacto'); ?>">Contacto</a></li>
											<hr />
											<li><a class='center-block logout'>Cerrar Sesión <i class="fa fa-sign-out pull-right"></i></a></li>
											<br>
										</ul>
									</li>
									<!-- Notificaciones -->
									<li role="presentation" class="dropdown notificaciones noSpaceLi">
										<a class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
											|
											<i class="fa fa-envelope-o"></i>
											<span class="badge bg-green">0</span>
											|
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				<?php } ?>
	</header>
