<script type="module" src="<?= base_url('assets/js/functions/admin/modules/docentes/docentes.js?v=1.1') . time() ?>"></script>
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-check-circle text-primary mr-2"></i>
							Docentes en Evaluación
						</h4>
						<p class="text-muted mb-0 small">Gestiona y revisa las evaluaciones de facilitadores</p>
					</div>
					<!-- Botón volver -->
					<?php $this->load->view('admin/organizaciones/docentes/partials/_btn_volver'); ?>
				</div>
			</div>
		</div>
		<!-- Docentes -->
		<div class="card shadow-sm" id="docentes_evaluar_card">
			<div class="card-body">
				<h5 class="font-weight-medium mb-3">
					<i class="mdi mdi-table mr-2 text-primary"></i>
					Listado de Docentes en evaluación
				</h5>
				<div class="table-responsive">
					<table id="tabla_organizaciones_docentes_evaluar" width="100%" class="table table-hover table-striped">
						<thead class="thead-light">
							<tr>
								<th class="border-0">Organización</th>
								<th class="border-0">NIT Organización</th>
								<th class="border-0">Cédula Docente</th>
								<th class="border-0">Nombre</th>
								<th class="border-0">Horas De Capacitación</th>
								<th class="border-0">Aprobado</th>
								<th class="border-0">Asignado</th>
								<th class="border-0">Observaciones</th>
								<th class="border-0">Acción</th>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php
							foreach ($docentes as $docente) {
								if ($docente->asignado == $nombre_usuario && $nivel == 1) {
									echo "<tr>";
									// Truncar nombre de organización con tooltip
									echo "<td><span class='d-inline-block text-truncate' style='max-width: 220px;' title='" . htmlspecialchars($docente->nombreOrganizacion, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($docente->nombreOrganizacion, ENT_QUOTES, 'UTF-8') . "</span></td>";
									echo "<td>" . $docente->numNIT . "</td>";
									echo "<td>" . $docente->numCedulaCiudadaniaDocente . "</td>";
									echo "<td>" . $docente->primerNombreDocente . " " . $docente->segundoNombreDocente . " " . $docente->primerApellidoDocente . " " . $docente->segundoApellidoDocente . "</td>";
									echo "<td>" . $docente->horaCapacitacion . "</td>";
									if ($docente->valido == '0') {
										echo "<td><span class='badge badge-secondary'>No</span></td>";
									} else if ($docente->valido == '1') {
										echo "<td><span class='badge badge-success'>Sí</span></td>";
									}
									echo "<td>" . $docente->asignado . "</td>";
									echo "<td><span class='d-inline-block text-truncate' style='max-width: 220px;' title='" . htmlspecialchars($docente->observacion, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($docente->observacion, ENT_QUOTES, 'UTF-8') . "</span></td>";
									echo "<td><button class='btn btn-primary btn-sm verEsteDocente' data-id='" . $docente->id_docente . "'><i class='mdi mdi-eye mr-1'></i>Ver facilitador</button></td>";
									echo "</tr>";
								} else if ($nivel == 0 || $nivel == 6) {
									if ($docente->asignado != "No" && $docente->asignado != NULL) {
										echo "<tr>";
										// Truncar nombre de organización con tooltip
										echo "<td><span class='d-inline-block text-truncate' style='max-width: 220px;' title='" . htmlspecialchars($docente->nombreOrganizacion, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($docente->nombreOrganizacion, ENT_QUOTES, 'UTF-8') . "</span></td>";
										echo "<td>" . $docente->numNIT . "</td>";
										echo "<td>" . $docente->numCedulaCiudadaniaDocente . "</td>";
										echo "<td>" . $docente->primerNombreDocente . " " . $docente->segundoNombreDocente . " " . $docente->primerApellidoDocente . " " . $docente->segundoApellidoDocente . "</td>";
										echo "<td>" . $docente->horaCapacitacion . "</td>";
										if ($docente->valido == '0') {
											echo "<td><span class='badge badge-secondary'>No</span></td>";
										} else if ($docente->valido == '1') {
											echo "<td><span class='badge badge-success'>Sí</span></td>";
										}
										echo "<td>" . $docente->asignado . "</td>";
										echo "<td><span class='d-inline-block text-truncate' style='max-width: 220px;' title='" . htmlspecialchars($docente->observacion, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($docente->observacion, ENT_QUOTES, 'UTF-8') . "</span></td>";
										// Agregar data-id con el id del docente
										echo "<td><button class='btn btn-primary btn-sm verEsteDocente' data-id='" . $docente->id_docente . "' data-organizacion='" . $docente->id_organizacion . "'><i class='mdi mdi-eye mr-1'></i>Ver facilitador</button></td>";
										echo "</tr>";
									}
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Iframe Docentes -->
		<div id="docentes_organizaciones" class="card shadow-sm mt-4 p-4">
			<div class="p-4 text-center text-muted">
				Selecciona “Ver facilitador” en el listado para cargar el detalle aquí.
			</div>
		</div>
	</div>
</div>
</div>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
	$(document).ready(function() {
		// Inicializar tabla simple de usuarios
		DataTableConfig.initSimpleTable(
			'#tabla_organizaciones_docentes_evaluar',
			'Tabla de organizaciones con docentes en evaluación',
			'tabla_organizaciones_docentes_evaluar'
		);
	});
</script>
