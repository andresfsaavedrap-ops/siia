<!-- Sección Logo -->
<div class="card border-0 shadow-sm mb-4">
	<div class="card-header bg-transparent">
		<h5 class="card-title mb-0">
			🖼️ Cambio de logo de la organización
		</h5>
	</div>
	<div class="card-body">
		<p class="card-description text-muted mb-3">
			<i class="mdi mdi-information-outline mr-1"></i>La imagen tiene que ser de máximo 240px x 240px (Ancho x Alto). Formato jpeg y png.
		</p>
		<div class="row align-items-center mb-4">
			<div class="col-md-3 text-center mb-3 mb-md-0">
				<!-- Vista previa de la imagen actual -->
				<div class="border rounded p-2 d-inline-block">
					<img id="preview-imagen" src="<?= base_url('uploads/logosOrganizaciones/' . $organizacion->imagenOrganizacion) ?>"
						class="img-fluid" style="max-height: 120px; width: auto;" alt="Logo actual">
				</div>
			</div>
			<div class="col-md-9">
				<?= form_open_multipart('', array('id' => 'formulario_actualizar_logo', 'class' => 'needs-validation')); ?>
				<div class="form-group">
					<input type="file" class="file-upload-default" form="imagen_perfil" name="imagen" id="imagen_perfil" accept="image/jpeg, image/png" required>
					<div class="input-group col-xs-12">
						<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar logo">
						<span class="input-group-append">
							<button class="file-upload-browse btn btn-primary" type="button">
								Buscar
							</button>
						</span>
					</div>
					<div class="invalid-feedback">
						Por favor seleccione una imagen válida.
					</div>
				</div>
				<!-- Botones de acción -->
				<div class="mt-3">
					<!-- Botón de subir imagen -->
					<div class="btn-group">
						<button type="button" class="btn btn-primary btn-sm" id="actualizar_imagen">
							<i class="mdi mdi-upload"></i>Subir logo
						</button>
						<button type="reset" class="btn btn-outline-secondary btn-sm ms-2">
							<i class="mdi mdi-close me-1"></i>Cancelar
						</button>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>

		<!-- Información adicional o alertas -->
		<div class="alert alert-info" role="alert">
			<i class="mdi mdi-lightbulb-on-outline me-2"></i>
			<small>El cambio de logo se reflejará inmediatamente en todo el sistema y documentos generados.</small>
		</div>
	</div>
</div>
<script>
	// Script para mostrar vista previa de la imagen seleccionada
	document.getElementById('imagen_perfil').addEventListener('change', function(e) {
		const file = e.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(event) {
				document.getElementById('preview-imagen').src = event.target.result;
			}
			reader.readAsDataURL(file);
		}
	});

	// Script para validación del formulario
	(function() {
		'use strict';

		const forms = document.querySelectorAll('.needs-validation');

		Array.from(forms).forEach(form => {
			form.addEventListener('submit', event => {
				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();
				}

				form.classList.add('was-validated');
			}, false);
		});
	})();
</script>
