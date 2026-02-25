<?php

/***
 * @var $nivel
 * @var $tipo_usuario
 * @var $logged_in
 * @var $activeLink
 * @var $organizacion
 */
?>
<script src="<?= base_url('assets/js/functions/perfil.js?v=1.0.1.61342') . time() ?>" type="module"></script>
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<!-- Resumen del perfil -->
							<?php $this->load->view('user/modules/perfil/partials/_resumen'); ?>
							<!-- Menu Tabs -->
							<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								<!-- Btn Info Básica -->
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Información Básica</button>
								</li>
								<!-- Btn Firma RL -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Firma Representante Legal</button>
								</li>
								<!-- Btn Datos Inicio -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Datos inicio de sesión</button>
								</li>
								<!-- Btn Datos Certificados -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-certificados-tab" data-toggle="pill" data-target="#pills-certificados" type="button" role="tab" aria-controls="pills-certificados" aria-selected="false">Certificados</button>
								</li>
								<!-- Actividad reciente -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-actividad-tab" data-toggle="pill" data-target="#pills-actividad" type="button" role="tab" aria-controls="pills-actividad" aria-selected="false">Actividad</button>
								</li>
							</ul>
							<!-- Contenido Tabs -->
							<div class="tab-content" id="pills-tabContent">
								<!-- Contenido Tab Información Básica -->
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									<!-- Imagen Logo -->
									<?php $this->load->view('user/modules/perfil/partials/_logo_organizacion'); ?>
									<!-- Información Básica -->
									<?php $this->load->view('user/modules/perfil/partials/_informacion_basica'); ?>
								</div>
								<!-- Contenido Tab Firma RL -->
								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									<?php $this->load->view('user/modules/perfil/partials/_firma_rl'); ?>
								</div>
								<!-- Contenido Tab Cambio de datos de inicio -->
								<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
									<?php $this->load->view('user/modules/perfil/partials/_cambiar_datos_inicio'); ?>
								</div>
								<!-- Contenido Certificados -->
								<div class="tab-pane fade" id="pills-certificados" role="tabpanel" aria-labelledby="pills-certificados-tab">
									<?php $this->load->view('user/modules/perfil/partials/_certificados'); ?>
								</div>
								<!-- Contenido Actividad -->
								<div class="tab-pane fade" id="pills-actividad" role="tabpanel" aria-labelledby="pills-actividad-tab">
									<?php $this->load->view('user/modules/perfil/partials/_actividad'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
