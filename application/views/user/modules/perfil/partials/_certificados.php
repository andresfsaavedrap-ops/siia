<div class="row">
	<!-- Sección de Carga de Firma -->
	<div class="col-lg-6 grid-margin">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h4 class="card-title mb-0">Firma de Certificados</h4>
					<?php if (isset($firmaCert) && !empty($firmaCert)): ?>
						<a href="<?php echo base_url("uploads/logosOrganizaciones/firmaCert/$firmaCert"); ?>"
							class="btn btn-outline-info btn-sm" target="_blank">
							<i class="ti-eye mr-1"></i> Ver firma actual
						</a>
					<?php endif; ?>
				</div>

				<div class="alert alert-info py-2">
					<i class="ti-info-alt mr-2"></i>
					Se aceptan imágenes en formato PNG (fondo transparente), con dimensiones de 450px × 300px.
				</div>

				<?php echo form_open_multipart('', array('id' => 'formulario_firma_certifi')); ?>
				<div class="form-group">
					<div class="custom-file-upload">
						<input type="file" class="file-upload-default" form="formulario_firma_certifi"
							name="firmaCert" id="firmaCert" required="" accept="image/png">
						<div class="input-group">
							<input type="text" class="form-control file-upload-info" disabled=""
								placeholder="Seleccione archivo de firma...">
							<div class="input-group-append">
								<button class="file-upload-browse btn btn-primary" type="button">
									<i class="ti-upload mr-1"></i> Examinar
								</button>
							</div>
						</div>
					</div>
					<small class="form-text text-muted mt-2">
						La imagen se utilizará como firma oficial en todos los certificados generados.
					</small>
				</div>

				<div class="d-flex justify-content-between mt-4">
					<button class="btn btn-danger" name="eliminar_firma_certifi" id="eliminar_firma_certifi">
						<i class="ti-trash mr-1"></i> Eliminar firma
					</button>
					<button class="btn btn-primary" name="actualizar_firma_certifi" id="actualizar_firma_certifi">
						<i class="ti-save mr-1"></i> Actualizar firma
					</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Sección de Datos del Firmante -->
	<div class="col-lg-6 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title mb-4">Datos del Firmante</h4>

				<form id="form_datos_firmante">
					<div class="form-group">
						<label for="nombrePersonaCert" class="font-weight-medium">
							Nombre y apellido <span class="text-danger">*</span>
						</label>
						<input type="text" class="form-control form-control-lg" name="nombrePersonaCert"
							id="nombrePersonaCert" placeholder="Ej: Juan Pérez"
							value="<?php echo $personaCert; ?>">
						<small class="form-text text-muted">
							Nombre completo de la persona autorizada para firmar los certificados.
						</small>
					</div>

					<div class="form-group">
						<label for="cargoPersonaCert" class="font-weight-medium">
							Cargo en la organización <span class="text-danger">*</span>
						</label>
						<input type="text" class="form-control form-control-lg" name="cargoPersonaCert"
							id="cargoPersonaCert" placeholder="Ej: Director Académico"
							value="<?php echo $cargoCert; ?>">
						<small class="form-text text-muted">
							Cargo o posición oficial dentro de la institución.
						</small>
					</div>

					<div class="text-right mt-4">
						<button class="btn btn-primary" name="actualizar_nombreCargo" id="actualizar_nombreCargo">
							<i class="ti-save mr-1"></i> Actualizar información
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Vista previa del certificado (opcional) -->
<div class="row mt-3">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Vista Previa</h4>
				<p class="card-description">
					Así se visualizará la firma en los certificados generados.
				</p>

				<div class="text-center p-4 bg-light border rounded">
					<?php if (isset($firmaCert) && !empty($firmaCert)): ?>
						<div class="certificate-preview">
							<div class="certificate-signature">
								<img src="<?php echo base_url("uploads/logosOrganizaciones/firmaCert/$firmaCert"); ?>"
									alt="Firma" class="img-fluid mb-2" style="max-height: 100px;">
								<div class="signature-info">
									<div class="signature-name"><?php echo $personaCert; ?></div>
									<div class="signature-title text-muted"><?php echo $cargoCert; ?></div>
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="alert alert-warning">
							<i class="ti-alert mr-2"></i>
							No hay una firma configurada actualmente. Por favor, cargue una imagen de firma.
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	/* Estilos personalizados */
	.custom-file-upload {
		position: relative;
		width: 100%;
	}

	.certificate-preview {
		max-width: 600px;
		margin: 0 auto;
		padding: 20px;
		border: 1px dashed #ccc;
		background-color: #fff;
	}

	.certificate-signature {
		display: inline-block;
		text-align: center;
		padding: 15px;
	}

	.signature-name {
		font-weight: bold;
		font-size: 16px;
		margin-top: 5px;
	}

	.signature-title {
		font-size: 14px;
	}

	/* Mejora visual de los formularios */
	.form-control-lg {
		font-size: 0.9rem;
	}

	.btn i {
		font-size: 12px;
	}
</style>

<script>
	$(document).ready(function() {
		// Código existente para file upload
		$('.file-upload-browse').on('click', function() {
			var file = $(this).parent().parent().parent().find('.file-upload-default');
			file.trigger('click');
		});

		$('.file-upload-default').on('change', function() {
			var filename = $(this).val().split('\\').pop();
			$(this).parent().find('.form-control').val(filename);

			// Validación de tipo y tamaño de archivo
			var fileInput = document.getElementById('firmaCert');
			if (fileInput.files.length > 0) {
				var fileType = fileInput.files[0].type;
				if (fileType !== 'image/png') {
					alert('Error: Solo se permiten archivos PNG');
					$(this).val('');
					$(this).parent().find('.form-control').val('');
				}
			}
		});
	});
</script>