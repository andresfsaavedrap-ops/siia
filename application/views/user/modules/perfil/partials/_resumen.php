<!-- Resumen del perfil -->
<div class="card shadow-sm mb-4">
	<div class="row g-0">
		<div class="col-md-4 d-flex align-items-center justify-content-center p-3">
			<div class="border rounded p-2 d-inline-block">
				<img src="<?= base_url('uploads/logosOrganizaciones/' . $organizacion->imagenOrganizacion) ?>"
					class="img-fluid rounded"
					alt="Logo <?php echo htmlspecialchars($organizacion->nombreOrganizacion); ?>"
					style="max-height: 180px; width: auto;">
			</div>
		</div>
		<div class="col-md-8">
			<div class="card-body">
				<h4 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($nombre_usuario); ?></h4>
				<h6 class="card-subtitle mb-2 text-primary"><?php echo htmlspecialchars($organizacion->nombreOrganizacion); ?></h6>
				<div class="mt-3">
					<p class="card-text mb-1">
						<i class="bi bi-envelope-fill me-2 text-muted"></i>
						<a href="mailto:<?php echo htmlspecialchars($organizacion->direccionCorreoElectronicoOrganizacion); ?>" class="text-decoration-none">
							<?php echo htmlspecialchars($organizacion->direccionCorreoElectronicoOrganizacion); ?>
						</a>
					</p>
					<p class="card-text">
						<i class="bi bi-building me-2 text-muted"></i>
						<small>NIT: <?php echo htmlspecialchars($organizacion->numNIT); ?></small>
					</p>
					<p class="card-text">
						<i class="bi bi-building me-2 text-muted"></i>
						<small>Teléfono: <?php echo htmlspecialchars($informacionGeneral->fax); ?></small>
					</p>
					<p class="card-text">
						<i class="bi bi-building me-2 text-muted"></i>
						<small>Dirección: <?php echo htmlspecialchars($informacionGeneral->direccionOrganizacion); ?></small>
					</p>
					<p class="card-text">
						<i class="bi bi-building me-2 text-muted"></i>
						<small>Rep. Legal: <?php echo htmlspecialchars($organizacion->primerNombreRepLegal . " " . $organizacion->segundoNombreRepLegal . " " . $organizacion->primerApellidoRepLegal . " " . $organizacion->segundoApellidoRepLegal); ?></small>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
