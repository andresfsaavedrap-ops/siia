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
						<div class="auth-form-light text-left py-5 px-4 px-sm-5">
							<div class="brand-logo">
								<img src="<?= base_url('assets/img/siia_logo.png') ?>" alt="logo">
							</div>
							<h4>Módulo super administrador </h4>
							<h6 class="font-weight-light">Inicia sesión para continuar.</h6>
							<form class="pt-3">
								<div class="form-group">
									<input type="password" id="tpssp" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required value="" class="form-control form-control-lg">
								</div>
								<div class="mt-3">
									<a class="btn btn-block btn-primary" id="init_sp">
										Iniciar Sesión
										<i class="mdi mdi-login ml-1" aria-hidden="true"></i>
									</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- Corrección footer -->
</div>