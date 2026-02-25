<!-- Contenedor principal con estilos mejorados -->
<div class="row">
	<div class="col-md-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center mb-3">
					<i class="mdi mdi-key-change text-primary icon-md mr-2"></i>
					<h4 class="card-title mb-0">Cambio de contraseña</h4>
				</div>
				<p class="card-description">Actualiza tu contraseña para mantener segura tu cuenta</p>
				<hr class="mb-4" />

				<?php echo form_open('', array('id' => 'formulario_actualizar_contrasena', 'class' => 'forms-sample')); ?>
				<div class="form-group">
					<label for="contrasena_anterior">Contraseña anterior</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary">
								<i class="mdi mdi-lock-outline text-white"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="contrasena_anterior" id="contrasena_anterior" placeholder="Ingresa tu contraseña actual" required="">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary btn-sm password-toggle" type="button" data-toggle="password" data-target="#contrasena_anterior">
								<i class="mdi mdi-eye" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="contrasena_nueva">Contraseña nueva</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary">
								<i class="mdi mdi-lock-plus text-white"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="contrasena_nueva" id="contrasena_nueva" placeholder="Ingresa tu nueva contraseña" required="">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary btn-sm password-toggle" type="button" data-toggle="password" data-target="#contrasena_nueva">
								<i class="mdi mdi-eye" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres</small>
				</div>

				<div class="form-group">
					<label for="re_contrasena_nueva">Confirmar contraseña</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary">
								<i class="mdi mdi-lock-plus text-white"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="re_contrasena_nueva" id="re_contrasena_nueva" placeholder="Confirma tu nueva contraseña" required="">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary btn-sm password-toggle" type="button" data-toggle="password" data-target="#re_contrasena_nueva">
								<i class="mdi mdi-eye" aria-hidden="true"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="mt-4">
					<button type="submit" class="btn btn-primary mr-2" name="actualizar_contrasena" id="actualizar_contrasena">
						<i class="mdi mdi-content-save mr-1"></i> Actualizar contraseña
					</button>
					<button type="reset" class="btn btn-light">Cancelar</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center mb-3">
					<i class="mdi mdi-account-edit text-success icon-md mr-2"></i>
					<h4 class="card-title mb-0">Cambio de nombre de usuario</h4>
				</div>
				<p class="card-description">Modifica tu nombre de usuario según tus preferencias</p>
				<hr class="mb-4" />

				<?php echo form_open('', array('id' => 'formulario_actualizar_usuario', 'class' => 'forms-sample')); ?>
				<div class="form-group">
					<label for="usuario_actual">Usuario actual</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-success">
								<i class="mdi mdi-account text-white"></i>
							</span>
						</div>
						<input type="text" class="form-control" value="<?= $this->session->userdata('nombre_usuario'); ?>" disabled>
					</div>
				</div>

				<div class="form-group">
					<label for="usuario_nuevo">Usuario nuevo</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-success">
								<i class="mdi mdi-account-plus text-white"></i>
							</span>
						</div>
						<input type="text" class="form-control" form="formulario_actualizar_usuario" name="usuario_nuevo" id="usuario_nuevo" placeholder="Ingresa tu nuevo nombre de usuario" required="">
					</div>
					<small class="form-text text-muted">El nombre de usuario debe ser único en el sistema</small>
				</div>

				<div class="mt-4">
					<button type="submit" class="btn btn-success mr-2" name="actualizar_usuario" id="actualizar_usuario">
						<i class="mdi mdi-content-save mr-1"></i> Actualizar nombre de usuario
					</button>
					<button type="reset" class="btn btn-light">Cancelar</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Script para la funcionalidad de mostrar/ocultar contraseña -->
<script>
	$(document).ready(function() {
		// Función para mostrar/ocultar contraseña
		$('.password-toggle').on('click', function() {
			const targetId = $(this).data('target');
			const passwordInput = $(targetId);
			const icon = $(this).find('i');

			if (passwordInput.attr('type') === 'password') {
				passwordInput.attr('type', 'text');
				icon.removeClass('fa-eye').addClass('fa-eye-slash');
			} else {
				passwordInput.attr('type', 'password');
				icon.removeClass('fa-eye-slash').addClass('fa-eye');
			}
		});

		// Validación del formulario de contraseña
		$('#formulario_actualizar_contrasena').on('submit', function(e) {
			const nuevaPass = $('#contrasena_nueva').val();
			const confirmaPass = $('#re_contrasena_nueva').val();

			if (nuevaPass !== confirmaPass) {
				e.preventDefault();
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Las contraseñas no coinciden',
					confirmButtonClass: 'btn btn-primary'
				});
			}

			if (nuevaPass.length < 8) {
				e.preventDefault();
				Swal.fire({
					icon: 'warning',
					title: 'Contraseña insegura',
					text: 'La contraseña debe tener al menos 8 caracteres',
					confirmButtonClass: 'btn btn-primary'
				});
			}
		});
	});
</script>