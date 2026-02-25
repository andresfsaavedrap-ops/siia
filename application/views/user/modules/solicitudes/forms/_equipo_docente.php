<?php
/***
 * @var $organizacion
 * @var $docentes
 * @var $departamentos
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 */
/* echo '<pre>';
var_dump($docentes);
echo '</pre>';
return null;*/
?>
<!-- Formulario de docentes 5 -->
<div id="docentes" data-form="5" class="formulario_panel">
	<h3 class="card-header mb-0">
		<i class="fa fa-users mr-2"></i> 5. Facilitadores
	</h3>
	<div class="card-body">
		<div class="row">
			<div class="col-md-8">
				<h4 class="font-weight-medium mb-3">Gestión de Facilitadores</h4>
				<p class="text-muted">
					En esta sección puede gestionar la información de los facilitadores, incluyendo:
				</p>
				<ul class="list-arrow">
					<li>Hojas de vida</li>
					<li>Certificaciones profesionales</li>
					<li>Información de contacto</li>
				</ul>
			</div>
			<div class="col-md-4 text-center d-flex align-items-center justify-content-center">
				<img alt="Facilitadores" class="img-fluid" style="max-height: 250px;" src="<?= base_url(); ?>assets/img/pages/docentes/docentes.png">
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<div class="alert alert-info d-flex align-items-center" role="alert">
					<i class="ti-info-alt mr-3 font-weight-bold" style="font-size: 1.5rem;"></i>
					<div>
						Para crear facilitadores y actualizar o adjuntar archivos como hojas de vida, certificaciones, por favor haga
						<a href="#" class="alert-link font-weight-bold irDocentes">clic aquí</a>. O en el botón <strong>"Ir a módulo facilitadores" en la parte inferior. </strong>
						Una vez sea registrada correctamente la información de los docentes recarga esta página para continuar.
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-md-6">
				<div class="border rounded p-3 d-flex align-items-center bg-light">
					<span class="badge badge-primary badge-pill mr-3"><?= count($docentes); ?></span>
					<div>
						<h6 class="mb-1">Facilitadores Registrados</h6>
						<small>Total de facilitadores en el sistema</small>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="border rounded p-3 d-flex align-items-center bg-light">
					<span class="badge badge-warning badge-pill mr-3">0</span>
					<div>
						<h6 class="mb-1">Certificaciones Pendientes</h6>
						<small>Facilitadores con documentación pendiente</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<button class="btn btn-primary irDocentes">
			<i class="fa fa-users mr-3"></i> Ir al modulo facilitadores
		</button>
	</div>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<!-- Agrega este script para funcionalidad básica -->
<script>
	$(document).ready(function() {
		// Enlace para ir a la sección de docentes
		$(".irDocentes").on("click", function(e) {
			e.preventDefault();
			window.open(baseURL + "panel/docentes/", "_blank");
		});
	});
</script>
