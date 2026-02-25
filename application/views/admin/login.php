<?php

/***
 * @var $logged_in
 * @var $tipo_usuario
 */
if ($logged_in == FALSE && $tipo_usuario == "none"): ?>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-center auth px-0 admin-login">
				<div class="row w-100 mx-0">
					<div class="col-lg-4 mx-auto">
						<div class="auth-form-light text-left py-5 px-4 px-sm-5 bordered">
							<div class="brand-logo">
								<a href="<?= base_url() ?>"><img src="<?= base_url('assets/img/siia_logo.png') ?>" alt="logo"></a>
							</div>
							<h4>Módulo Administradores </h4>
							<h6 class="font-weight-light">Inicia sesión para continuar.</h6>
							<?= form_open('', array('id' => 'formulario_login_admin', 'class' => 'pt-3')); ?>
							<div class="col-12 mb-2">
								<label for="validationServerUsername" class="form-label">
									Usuario<span class="spanRojo">*</span>
								</label>
								<div class="input-group has-validation">
									<input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required placeholder="Nombre de usuario..." size="10" autofocus>
								</div>
							</div>
							<div class="col-12 mb-2">
								<label for="password" class="form-label">
									Contraseña: <span class="spanRojo">*</span>
								</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required size="10" autocomplete="off">
									<span class="input-group-text hover-cursor" id="show-pass3">
										<i class="icon-eye" style="color: blue;" title="Ver contraseña"></i>
									</span>
								</div>
							</div>
							<div class="col-12 mb-2 mt-3">
								<button class="btn btn-block btn-primary btn-sm" id="inicio_sesion_admin">
									Iniciar Sesión
									<i class="mdi mdi-login ml-1" aria-hidden="true"></i>
								</button>
							</div>
							<div class="my-2 d-flex justify-content-between align-items-center">
								<div class="form-check">
									<label class="form-check-label text-muted">
										<input type="checkbox" class="form-check-input">
										Recordarme
									</label>
								</div>
								<!-- <a href="#" class="auth-link text-black">Recordar contraseña?</a> -->
							</div>
							<!-- <div class="text-center mt-4 font-weight-light">
									No tienes cuenta? <a href="<?= base_url('registro') ?>" class="text-primary">Registrate</a>
								</div> -->
							<?= form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- Corrección footer -->
</div>
