<?php

/***
 * @var $title
 * @var $activeLink
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
// /** echo '<pre>';
// var_dump($hora);
// echo '</pre>';
// return null; */
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
	<!-- css BDC -->
	<link href="https://cdn.www.gov.co/layout/v4/all.css" rel="stylesheet">
	<!-- css bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
		rel="stylesheet" crossorigin="anonymous">
	<!-- Styles -->
	<link href="<?= base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link href="<?= base_url('assets/css/govco.css?v=1.0.8.1919') ?>" rel="stylesheet" type="text/css" />
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
	<title> <?= APP_NAME ?> | <?= $title; ?></title>
</head>

<body id="para-mirar">
	<div class="se-pre-con"></div>
	<!-- Cabecera y Navbar -->
	<header>
		<section class="top-nav">
			<!-- Logo gobierno -->
			<nav class="navbar navbar-expand-lg barra-superior-govco" aria-label="Barra superior">
				<a href="https://www.gov.co/" target="_blank" aria-label="Portal del Estado Colombiano - GOV.CO"></a>
				<!-- <button class="idioma-icon-barra-superior-govco float-right" aria-label="Button to change the language of the page to English"></button> -->
			</nav>
			<div class="logo-aut-header-govco">
				<a href="<?= base_url('admin'); ?>" class="link-login-header-govco">Administrador</a>
				<div class="container-logo-header-govco">
					<a href="<?= PAGINA_WEB ?>">
						<span class="logo-header-govco"></span>
					</a>
					<a href="<?= base_url(); ?>">
						<span class="logo-header-siia"></span>
					</a>
					<div class="container-search-header-govco">
						<!-- Search -->
						<div class="search-govco">
							<div class="bar-search-govco">
								<input type="text" placeholder="Buscar por componente" class="input-search-govco" aria-label="Buscador" />
								<button class="icon-search-govco icon-close-search-govco" aria-label="Limpiar"></button>
								<div class="icon-search-govco search-icon-search-govco" aria-hidden="true"></div>
							</div>
							<div class="container-options-search-govco">
								<div class="options-search-govco">
									<ul>
										<li>
											<a href="<?= base_url('estado'); ?>" tabindex="-1">Estado de la solicitud <strong>Estado</strong></a>
										</li>
										<li>
											<a href="<?= base_url('facilitadores'); ?>" tabindex="-1">Facilitadores aprobados por organización <strong>Facilitadores</strong></a>
										</li>
										<li>
											<a href="<?= base_url('login'); ?>" tabindex="-1">Iniciar sesión <strong>Login</strong></a>
										</li>
										<li>
											<a href="<?= base_url('registro'); ?>" tabindex="-1">Registrar organización <strong>Registrarme</strong></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Menu de Navegación -->
			<div class="container-navbar-menu-govco blue-menu-govco">
				<nav class="navbar navbar-expand-lg navbar-menu-govco" role="navigation" aria-label="Menú ejemplo entidad">
					<div class="container-fluid container-second-navbar-menu-govco">
						<a class="navbar-brand navbar-toggler icon-entidad-menu-govco" href="#"></a>
						<button class="navbar-toggler button-responsive-menu-govco collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
							<span class="icon-bars-menu-govco"></span>
						</button>
						<div class="collapse navbar-collapse navbar-collapse-menu-govco" id="navbarScroll">
							<div class="container-search-icon-menu-govco navbar-toggler">
								<!-- SEARCH -->
								<div class="search-govco">
									<div class="bar-search-govco">
										<input type="text" placeholder="Buscar por componente" class="input-search-govco" aria-label="Buscador" />
										<button class="icon-search-govco icon-close-search-govco" aria-label="Limpiar"></button>
										<div class="icon-search-govco search-icon-search-govco" aria-hidden="true"></div>
									</div>
									<div class="container-options-search-govco">
										<div class="options-search-govco">
											<ul>
												<li>
													<a href="#" tabindex="-1">Sugerencia de búsqueda con la palabra <strong>Componente 1</strong></a>
												</li>
												<li>
													<a href="#" tabindex="-1">Sugerencia de búsqueda con la palabra <strong>Componente 1</strong></a>
												</li>
												<li>
													<a href="#" tabindex="-1">Sugerencia de búsqueda con la palabra <strong>Componente 1</strong></a>
												</li>
												<li>
													<a href="#" tabindex="-1">Sugerencia de búsqueda con la palabra <strong>Componente 1</strong></a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- END SEARCH -->
								<a class="icon-user-alt-menu-govco" href="<?= base_url('admin'); ?>"></a>
							</div>
							<ul class="navbar-nav navbar-nav-menu-govco ms-auto">
								<li class="nav-item">
									<a class="nav-link dir-menu-govco <?php if($activeLink == 'home'): echo 'active'; endif; ?>" aria-current="page" href="<?= base_url(); ?>">
										<span class="text-item-menu-govco">
											Inicio
										</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link dir-menu-govco <?php if($activeLink == 'estado'): echo 'active'; endif; ?>" aria-current="page" href="<?= base_url('estado'); ?>">
										<span class="text-item-menu-govco">
											Estado de la solicitud
										</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link dir-menu-govco <?php if($activeLink == 'facilitadores'): echo 'active'; endif; ?>" aria-current="page" href="<?= base_url('facilitadores'); ?>">
										<span class="text-item-menu-govco">
											Docentes válidos
										</span>
									</a>
								</li>
								<!--<li class="nav-item dropdown">
									<a class="nav-link" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										<span class="container-text-icon-menu-govco">
											<span class="text-item-menu-govco">Acreditación</span>
											<span class="icon-caret-menu-govco"></span>
										</span>
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li>
											<a class="dropdown-item dir-menu-govco" href="<?php /*= base_url('estado'); */?>">Estado de la solicitud</a>
										</li>
										<li>
											<a class="dropdown-item dir-menu-govco" href="<?php /*= base_url('facilitadores'); */?>">Facilitadores válidos</a>
										</li>
									</ul>
								</li>-->
							</ul>
							<div class="row justify-content-md-center">
								<div class="dropdown-container-govco">
									<div class="btn-group" role="group" aria-label="Basic example">
										<button type="button" class="btn-govco outline-btn-govco" id="btn-login">
											Iniciar sesión
										</button>
										<button type="button" class="btn-govco fill-btn-govco" id="btn-register">
											Registrarse
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</div>
			<!-- Menu de accesibilidad -->
			<div class="content-example-barra ">
				<div class="barra-accesibilidad-govco">
					<button id="botoncontraste" class="icon-contraste" onclick="cambiarContexto()">
						<span id="titlecontraste">Contraste</span>
					</button>
					<button id="botondisminuir" class="icon-reducir" onclick="disminuirTamanio('disminuir')">
						<span id="titledisminuir">Reducir letra</span>
					</button>
					<button id="botonaumentar" class="icon-aumentar" onclick="aumentarTamanio('aumentar')">
						<span id="titleaumentar">Aumentar letra</span>
					</button>
				</div>
			</div>
	</header>
