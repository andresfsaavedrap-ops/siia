<!-- SECCIÓN DE FIRMA REPRESENTANTE LEGAL -->
<div class="row">
	<div class="col-md-6">
		<!-- Tarjeta para visualizar firma -->
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h4 class="card-title mb-0">
						<i class="mdi mdi-account-check text-primary mr-2"></i>
						Firma Representante Legal
					</h4>
				</div>
				<div class="card-description text-muted mb-3">
					<small><i class="mdi mdi-lock-outline mr-1"></i>Ingrese la contraseña para visualizar la firma</small>
				</div>
				<hr class="mt-0 mb-4" />

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary btn-sm text-white">
								<i class="mdi mdi-key-variant" style="font-size: 14px;"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="" name="contrasena_firma_rep" id="contrasena_firma_rep" placeholder="Contraseña de firma" required>
						<div class="input-group-append">
							<button class="btn btn-primary  btn-sm" type="button" id="toggle_password_rep">
								<i class="mdi mdi-eye-off"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="text-center mt-4 mb-3">
					<button class="btn btn-primary btn-rounded" id="ver_fir_rep_legal">
						<i class="mdi mdi-eye mr-1" style="font-size: 14px;"></i> Ver firma
					</button>
				</div>

				<div class="firma-container mt-4 text-center">
					<div class="imagen-firma-wrapper p-3 border rounded">
						<img src="<?php echo base_url('uploads/logosOrganizaciones/firma/' . $firma . '') ?>" class="img-fluid" id="firma_rep_legal" style="max-height: 150px; display: none;">
						<div class="firma-placeholder text-muted" id="firma_placeholder">
							<i class="mdi mdi-signature-image" style="font-size: 60px;"></i>
							<p>Ingrese la contraseña para visualizar la firma</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<!-- Tarjeta para actualizar firma -->
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h4 class="card-title mb-0">
						<i class="mdi mdi-pencil-box text-primary mr-2" style="font-size: 18px;"></i>
						Actualizar Firma
					</h4>
				</div>
				<div class="card-description text-muted mb-3">
					<small><i class="mdi mdi-information-outline mr-1"></i>La imagen y contraseña actuales serán reemplazadas</small>
				</div>
				<hr class="mt-0 mb-4" />

				<?php echo form_open_multipart('', array('id' => 'formulario_actualizar_firma')); ?>
				<div class="form-group">
					<label class="text-primary font-weight-medium">Imagen de firma <span class="text-danger">*</span></label>
					<input type="file" class="file-upload-default" form="formulario_actualizar_firma" name="firma" id="firma" required accept="image/jpeg, image/png">
					<div class="input-group">
						<input type="text" class="form-control file-upload-info" disabled placeholder="Seleccione una imagen">
						<div class="input-group-append">
							<button class="file-upload-browse btn btn-primary btn-sm" type="button">
								<i class="mdi mdi-upload mr-1"></i>Cargar
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Formatos permitidos: JPG, PNG</small>
				</div>

				<div class="form-group">
					<label class="text-primary font-weight-medium">Contraseña de firma <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary text-white">
								<i class="mdi mdi-lock" style="font-size: 14px;"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="" name="contrasena_firma" id="contrasena_firma" placeholder="Nueva contraseña" required>
						<div class="input-group-append">
							<button class="btn btn-primary btn-sm" type="button" id="toggle_password1">
								<i class="mdi mdi-eye-off"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="text-primary font-weight-medium">Confirmar contraseña <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary btn-sm text-white">
								<i class="mdi mdi-lock"></i>
							</span>
						</div>
						<input type="password" class="form-control" form="" name="re_contrasena_firma" id="re_contrasena_firma" placeholder="Confirmar contraseña" required>
						<div class="input-group-append">
							<button class="btn btn-primary btn-sm" type="button" id="toggle_password2">
								<i class="mdi mdi-eye-off"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="text-right mt-4">
					<button type="button" class="btn btn-light mr-2">Cancelar</button>
					<button class="btn btn-primary submit" name="actualizar_firma" id="actualizar_firma">
						<i class="mdi mdi-content-save mr-1" style="font-size: 14px;"></i>
						Actualizar firma
					</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Script jQuery para funcionalidad adicional -->
<script>
	$(function() {
		// Función para mostrar/ocultar contraseña
		$("#toggle_password_rep, #toggle_password1, #toggle_password2").click(function() {
			var $button = $(this);
			var $icon = $button.find('i');
			var $input = $button.closest('.input-group').find('input');

			if ($input.attr("type") === "password") {
				$input.attr("type", "text");
				$icon.removeClass("mdi-eye-off").addClass("mdi-eye");
			} else {
				$input.attr("type", "password");
				$icon.removeClass("mdi-eye").addClass("mdi-eye-off");
			}
		});

		// Función para mostrar la firma al hacer clic en el botón Ver firma
		$("#ver_fir_rep_legal").click(function() {
			// Aquí iría la validación real de la contraseña
			if ($("#contrasena_firma_rep").val().length > 0) {
				$("#firma_placeholder").hide();
				$("#firma_rep_legal").show();
			} else {
				// Mostrar error en caso de contraseña vacía
				alert("Por favor ingrese la contraseña para visualizar la firma");
			}
		});

		// Validar que las contraseñas coincidan
		$("#actualizar_firma").click(function(e) {
			if ($("#contrasena_firma").val() !== $("#re_contrasena_firma").val()) {
				e.preventDefault();
				alert("Las contraseñas no coinciden");
			}
		});
	});
</script>