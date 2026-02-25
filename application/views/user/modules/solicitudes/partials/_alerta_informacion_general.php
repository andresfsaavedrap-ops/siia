<!-- Tarjeta si no existe información en formulario 1 -->
<div class="col-lg-12 grid-margin stretch-card">
	<div class="card shadow-sm">
		<div class="card-body text-center">
			<h4 class="card-title mb-4"><i class="mdi mdi-information text-primary mr-2"></i>Completa la información de la organización</h4>
			<div class="alert alert-warning">
				<p class="card-description mb-4">
					Por favor complete los datos de la organización, en la sección
					<strong>
						<a href="<?= base_url('organizacion/perfil'); ?>">
							<span class="mdi mdi-account"></span>Perfil
						</a>
					</strong>
					en la pestaña
					<strong>
						Información Básica
					</strong>
					para continuar con la creación de la solicitud de acreditación. Una vez completada la información, podrás crear una solicitud de acreditación.
				</p>
				<p class="card-description mb-4">
					Si ya completaste la información, por favor ingresa a tu perfil para actualizarla si es necesario.
				</p>
				<p class="card-description mb-4">
					Si tienes alguna duda, por favor contacta al correo electrónico
					<a href="mailto:<?= CORREO_ATENCION ?>"><?= CORREO_ATENCION; ?></a> o escribe a nuestro chat en línea.
				</p>
			</div>
			<a href="<?= base_url('organizacion/perfil'); ?>" class="btn btn-primary btn-sm">
				<i class="mdi mdi-account mr-2" aria-hidden="true"></i>
				Ir a actualizar mis datos
			</a>
		</div>
	</div>
</div>
