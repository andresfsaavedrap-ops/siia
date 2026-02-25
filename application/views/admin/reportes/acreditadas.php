<?php
/***
 * @var $organizacionesAcreditadas
 */

// Función para verificar permisos basada en la lógica del sistema
function canAccessReportes($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-certificate text-primary mr-2"></i>
							Organizaciones Acreditadas
						</h3>
						<p class="text-muted mb-0">Listado completo de organizaciones con acreditación vigente</p>
					</div>
					<div class="btn-group" role="group">
						<?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
							<a href="<?= base_url(); ?>reportes/exportarExcel" target="_blank" class="btn btn-success btn-sm">
								<i class="fa fa-file-excel" aria-hidden="true"></i>
								Acreditadas
							</a>
						<?php endif; ?>
						<?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
						<a href="<?= base_url(); ?>reportes/exportarExcelConteo" class="btn btn-info btn-sm">
							<i class="fa fa-bar-chart" aria-hidden="true"></i>
							Estadísticas
						</a>
						<?php endif; ?>
						<?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
						<a href="<?= base_url(); ?>reportes/exportarDatosAbiertos" class="btn btn-warning btn-sm">
							<i class="fa fa-database" aria-hidden="true"></i>
							Datos Abiertos
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Statistics Cards -->
		<div class="row mb-4">
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-primary cursor-pointer" onclick="filtrarTabla('todas')">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Acreditadas</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($organizacionesAcreditadas) ?></div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-primary-light rounded-circle">
									<i class="mdi mdi-certificate text-primary"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-success cursor-pointer" onclick="filtrarTabla('vigentes')">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vigentes</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$vigentes = 0;
										foreach($organizacionesAcreditadas as $org) {
											if(isset($org["resoluciones"]->fechaResolucionFinal)) {
												$fecha = new DateTime($org["resoluciones"]->fechaResolucionFinal);
												$hoy = new DateTime();
												if($fecha >= $hoy) $vigentes++;
											}
										}
										echo $vigentes;
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-success-light rounded-circle">
									<i class="mdi mdi-check-circle text-success"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-warning cursor-pointer" onclick="filtrarTabla('por-vencer')">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Por Vencer</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$porVencer = 0;
										foreach($organizacionesAcreditadas as $org) {
											if(isset($org["resoluciones"]->fechaResolucionFinal)) {
												$fecha = new DateTime($org["resoluciones"]->fechaResolucionFinal);
												$hoy = new DateTime();
												$diferencia = $hoy->diff($fecha);
												if($fecha >= $hoy && $diferencia->days <= 90) $porVencer++;
											}
										}
										echo $porVencer;
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-warning-light rounded-circle">
									<i class="mdi mdi-clock-alert text-warning"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-danger cursor-pointer" onclick="filtrarTabla('vencidas')">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vencidas</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$vencidas = 0;
										foreach($organizacionesAcreditadas as $org) {
											if(isset($org["resoluciones"]->fechaResolucionFinal)) {
												$fecha = new DateTime($org["resoluciones"]->fechaResolucionFinal);
												$hoy = new DateTime();
												if($fecha < $hoy) $vencidas++;
											}
										}
										echo $vencidas;
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-danger-light rounded-circle">
									<i class="mdi mdi-alert-circle text-danger"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Filtros adicionales -->
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-body py-3">
						<div class="row align-items-center">
							<div class="col-md-3">
								<label class="form-label mb-1 font-weight-bold">Filtrar por Estado:</label>
								<select id="filtro-estado" class="form-control form-control-sm">
									<option value="">Todos los estados</option>
									<option value="vigente">Vigentes</option>
									<option value="por-vencer">Por vencer (90 días)</option>
									<option value="vencida">Vencidas</option>
								</select>
							</div>
							<div class="col-md-3">
								<label class="form-label mb-1 font-weight-bold">Filtrar por Modalidad:</label>
								<select id="filtro-modalidad" class="form-control form-control-sm">
									<option value="">Todas las modalidades</option>
									<option value="presencial">Presencial</option>
									<option value="virtual">Virtual</option>
									<option value="mixta">Mixta</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label mb-1 font-weight-bold">Buscar Organización:</label>
								<input type="text" id="buscar-organizacion" class="form-control form-control-sm" placeholder="Nombre, NIT o resolución...">
							</div>
							<div class="col-md-2">
								<label class="form-label mb-1">&nbsp;</label>
								<button type="button" id="limpiar-filtros" class="btn btn-outline-secondary btn-sm btn-block">
									<i class="mdi mdi-refresh mr-1"></i>Limpiar
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Tabla de organizaciones acreditadas -->
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card shadow">
					<div class="card-header bg-white border-0">
						<div class="d-flex justify-content-between align-items-center">
							<h4 class="card-title mb-0">
								<i class="mdi mdi-table-large text-primary mr-2"></i>
								Listado de Organizaciones Acreditadas
							</h4>
							<div class="badge badge-primary badge-pill">
								<?= count($organizacionesAcreditadas) ?> registros
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive" style="overflow-x: auto;">
							<table id="tabla_organizaciones_acreditadas" class="table table-hover table-striped" style="table-layout: auto; width: 100%;">
								<thead class="thead-light">
									<tr>
										<th class="border-0">
											<i class="mdi mdi-domain mr-1"></i>Organización
										</th>
										<th class="border-0">
											<i class="mdi mdi-numeric mr-1"></i>NIT
										</th>
										<th class="border-0">
											<i class="mdi mdi-tag mr-1"></i>Tipo
										</th>
										<th class="border-0">
											<i class="mdi mdi-school mr-1"></i>Curso Aprobado
										</th>
										<th class="border-0">
											<i class="mdi mdi-laptop mr-1"></i>Modalidad
										</th>
										<th class="border-0">
											<i class="mdi mdi-file-document mr-1"></i>Resolución
										</th>
										<th class="border-0">
											<i class="mdi mdi-calendar mr-1"></i>Fecha Vencimiento
										</th>
										<th class="border-0">
											<i class="mdi mdi-map-marker mr-1"></i>Departamento
										</th>
										<th class="border-0">
											<i class="mdi mdi-city mr-1"></i>Municipio
										</th>
										<th class="border-0">
											<i class="mdi mdi-home mr-1"></i>Dirección
										</th>
										<th class="border-0">
											<i class="mdi mdi-phone mr-1"></i>Teléfono
										</th>
										<th class="border-0">
											<i class="mdi mdi-web mr-1"></i>URL
										</th>
										<th class="border-0">
											<i class="mdi mdi-email mr-1"></i>Correo
										</th>
									</tr>
								</thead>
								<tbody id="tbody">
								<?php foreach ($organizacionesAcreditadas as $organizacion): ?>
									<tr class="align-middle">
										<td style="max-width: 200px; min-width: 180px;">
											<div class="d-flex align-items-center">
												<div class="avatar-sm bg-primary-light rounded-circle mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
													<i class="mdi mdi-domain text-primary"></i>
												</div>
												<div class="text-truncate" style="max-width: 160px;">
													<h6 class="mb-0 font-weight-bold text-truncate" title="<?php echo (isset($organizacion['data_organizaciones']->nombreOrganizacion)) ? htmlspecialchars($organizacion['data_organizaciones']->nombreOrganizacion) : 'Falta por actualizar datos...'; ?>">
														<?php
															$nombre = (isset($organizacion['data_organizaciones']->nombreOrganizacion)) ? $organizacion['data_organizaciones']->nombreOrganizacion : "Falta por actualizar datos...";
															echo strlen($nombre) > 25 ? substr($nombre, 0, 25) . '...' : $nombre;
														?>
													</h6>
												</div>
											</div>
										</td>
										<td>
											<span class="font-weight-medium"><?php echo (isset($organizacion['data_organizaciones']->numNIT)) ? $organizacion['data_organizaciones']->numNIT : "Falta por actualizar datos...";?></span>
										</td>
										<td>
											<span class="text-muted"><?php echo (isset($organizacion['data_organizaciones_inf']->tipoOrganizacion)) ? $organizacion['data_organizaciones_inf']->tipoOrganizacion : "Falta por actualizar datos...";?></span>
										</td>
										<td style="max-width: 250px;">
											<div class="text-wrap" style="max-width: 250px; word-wrap: break-word;">
												<?php echo (isset($organizacion['resoluciones']->cursoAprobado)) ? $organizacion['resoluciones']->cursoAprobado : "Falta por actualizar datos...";?>
											</div>
										</td>
										<td>
											<?php 
												$modalidad = (isset($organizacion['resoluciones']->modalidadAprobada)) ? $organizacion['resoluciones']->modalidadAprobada : "No definida";
												$badgeClass = 'badge-secondary';
												$modalidadData = 'no-definida';
												if(stripos($modalidad, 'presencial') !== false) {
													$badgeClass = 'badge-success';
													$modalidadData = 'presencial';
												}
												elseif(stripos($modalidad, 'virtual') !== false) {
													$badgeClass = 'badge-info';
													$modalidadData = 'virtual';
												}
												elseif(stripos($modalidad, 'mixta') !== false) {
													$badgeClass = 'badge-warning';
													$modalidadData = 'mixta';
												}
											?>
											<span class="badge <?= $badgeClass ?> px-3 py-2" data-modalidad="<?= $modalidadData ?>">
												<?= $modalidad ?>
											</span>
										</td>
										<td>
											<?php if(isset($organizacion['resoluciones']->resolucion) && isset($organizacion['resoluciones']->numeroResolucion)): ?>
												<a href='<?php echo base_url("uploads/resoluciones/" . $organizacion['resoluciones']->resolucion) ?>'
												   target='_blank'
												   class="btn btn-outline-primary btn-sm">
													<i class="mdi mdi-file-pdf mr-1"></i>
													<?php echo $organizacion['resoluciones']->numeroResolucion ?>
												</a>
											<?php else: ?>
												<span class="text-muted">No disponible</span>
											<?php endif; ?>
										</td>
										<td>
											<?php
												if(isset($organizacion["resoluciones"]->fechaResolucionFinal)) {
													$fecha = $organizacion["resoluciones"]->fechaResolucionFinal;
													$fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
													$hoy = new DateTime();
													$estadoClass = '';
													$estadoTexto = '';
													if($fechaObj && $fechaObj < $hoy) {
														$estadoClass = 'badge-danger';
														$estadoTexto = 'Vencida';
													} elseif($fechaObj && $fechaObj->diff($hoy)->days <= 90) {
														$estadoClass = 'badge-warning';
														$estadoTexto = 'Por vencer';
													} else {
														$estadoClass = 'badge-success';
														$estadoTexto = 'Vigente';
													}
													echo '<span class="badge ' . $estadoClass . ' px-2 py-1" data-estado="' . strtolower(str_replace(' ', '-', $estadoTexto)) . '">' . $estadoTexto . '</span><br>';
													echo '<small class="text-muted">' . $fecha . '</small>';
												} else {
													echo '<span class="text-muted" data-estado="sin-fecha">Falta por actualizar datos...</span>';
												}
											?>
										</td>
										<td>
											<span class="text-muted"><?php echo (isset($organizacion['data_organizaciones_inf']->nomDepartamentoUbicacion)) ? $organizacion['data_organizaciones_inf']->nomDepartamentoUbicacion : "Falta por actualizar datos...";?></span>
										</td>
										<td>
											<span class="text-muted"><?php echo (isset($organizacion['data_organizaciones_inf']->nomMunicipioNacional)) ? $organizacion['data_organizaciones_inf']->nomMunicipioNacional : "Falta por actualizar datos...";?></span>
										</td>
										<td style="max-width: 200px;">
											<div class="text-wrap" style="max-width: 200px; word-wrap: break-word;">
												<?php echo (isset($organizacion['data_organizaciones_inf']->direccionOrganizacion)) ? $organizacion['data_organizaciones_inf']->direccionOrganizacion : "Falta por actualizar datos...";?>
											</div>
										</td>
										<td>
											<span class="font-weight-medium"><?php echo (isset($organizacion['data_organizaciones_inf']->fax)) ? $organizacion['data_organizaciones_inf']->fax : "Falta por actualizar datos...";?></span>
										</td>
										<td>
											<?php if(isset($organizacion['data_organizaciones_inf']->urlOrganizacion) && !empty($organizacion['data_organizaciones_inf']->urlOrganizacion) && $organizacion['data_organizaciones_inf']->urlOrganizacion != "Falta por actualizar datos..."): ?>
												<a href="<?= $organizacion['data_organizaciones_inf']->urlOrganizacion ?>" 
												   target="_blank" 
												   class="btn btn-outline-info btn-sm">
													<i class="mdi mdi-web mr-1"></i>Sitio Web
												</a>
											<?php else: ?>
												<span class="text-muted">No disponible</span>
											<?php endif; ?>
										</td>
										<td style="max-width: 200px;">
											<div class="text-wrap" style="max-width: 200px; word-wrap: break-word;">
												<?php echo (isset($organizacion['data_organizaciones']->direccionCorreoElectronicoOrganizacion)) ? $organizacion['data_organizaciones']->direccionCorreoElectronicoOrganizacion : "Falta por actualizar datos...";?>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a href="<?= base_url() ?>admin/reportes" class="btn btn-secondary">
			<i class="mdi mdi-arrow-left mr-2"></i>
			Volver al panel
		</a>
		</div>
	</div>
</div>
<!-- DataTables JavaScript -->
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
// Variable global para almacenar la referencia de la tabla
var tablaAcreditadas;
// Función para filtrar por estado usando búsqueda directa en DataTable
function filtrarPorEstado(estado) {
	if (!tablaAcreditadas) return;
	// Limpiar filtros anteriores
	tablaAcreditadas.search('').columns().search('').draw();
	if (estado === 'todas') {
		// Mostrar todas las filas
		tablaAcreditadas.search('').draw();
	} else {
		// Filtrar por estado específico usando búsqueda en la columna
		var searchTerm = '';
		switch(estado) {
			case 'vigentes':
				searchTerm = 'Vigente';
				break;
			case 'por-vencer':
				searchTerm = 'Por vencer';
				break;
			case 'vencidas':
				searchTerm = 'Vencida';
				break;
		}
		if (searchTerm) {
			tablaAcreditadas.column(6).search(searchTerm).draw();
		}
	}
	// Actualizar clases activas de las tarjetas
	$('.stat-card').removeClass('active');
	$('.stat-card[data-filter="' + estado + '"]').addClass('active');
}

// Función para filtrar por modalidad
function filtrarPorModalidad() {
	if (!tablaAcreditadas) return;
	var modalidad = $('#filtro-modalidad').val();
	if (modalidad === '') {
		tablaAcreditadas.column(4).search('').draw();
	} else {
		var searchTerm = '';
		switch(modalidad) {
			case 'presencial':
				searchTerm = 'Presencial';
				break;
			case 'virtual':
				searchTerm = 'Virtual';
				break;
			case 'mixta':
				searchTerm = 'Mixta';
				break;
		}
		if (searchTerm) {
			tablaAcreditadas.column(4).search(searchTerm).draw();
		}
	}
}

// Función para filtrar por estado desde dropdown
function filtrarPorEstadoDropdown() {
	if (!tablaAcreditadas) return;
	var estado = $('#filtro-estado').val();
	if (estado === '') {
		tablaAcreditadas.column(6).search('').draw();
	} else {
		var searchTerm = '';
		switch(estado) {
			case 'vigente':
				searchTerm = 'Vigente';
				break;
			case 'por-vencer':
				searchTerm = 'Por vencer';
				break;
			case 'vencida':
				searchTerm = 'Vencida';
				break;
		}
		if (searchTerm) {
			tablaAcreditadas.column(6).search(searchTerm).draw();
		}
	}
}

// Función para buscar organización
function buscarOrganizacion() {
	if (!tablaAcreditadas) return;
	var busqueda = $('#buscar-organizacion').val();
	tablaAcreditadas.search(busqueda).draw();
}

// Función para limpiar todos los filtros
function limpiarFiltros() {
	if (!tablaAcreditadas) return;
	// Limpiar todos los filtros
	tablaAcreditadas.search('').columns().search('').draw();
	// Resetear formularios
	$('#filtro-modalidad').val('');
	$('#filtro-estado').val('');
	$('#buscar-organizacion').val('');
	// Remover clases activas
	$('.stat-card').removeClass('active');
	$('.stat-card[data-filter="todas"]').addClass('active');
}

$(document).ready(function() {
	// Inicializar DataTable usando initSimpleTable del archivo global
	tablaAcreditadas = window.DataTableConfig.initSimpleTable(
		'#tabla_organizaciones_acreditadas',
		'Organizaciones Acreditadas',
		'organizaciones_acreditadas',
		':visible'
	);
	// Configurar opciones específicas después de la inicialización
	tablaAcreditadas.page.len(10).draw();
	tablaAcreditadas.order([[0, "asc"]]).draw();
	// Eventos para las tarjetas de estadísticas
	$('.stat-card').on('click', function() {
		var filtro = $(this).data('filter');
		filtrarPorEstado(filtro);
	});
	// Eventos para los filtros
	$('#filtro-modalidad').on('change', filtrarPorModalidad);
	$('#filtro-estado').on('change', filtrarPorEstadoDropdown);
	$('#buscar-organizacion').on('keyup', buscarOrganizacion);
	$('#limpiar-filtros').on('click', limpiarFiltros);
	// Marcar "Todas" como activo por defecto
	$('.stat-card[data-filter="todas"]').addClass('active');
});
</script>
