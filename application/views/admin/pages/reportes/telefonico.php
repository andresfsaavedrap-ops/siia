<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $solicitudes
 * @var $registros
 */
$CI = &get_instance();
$CI->load->model("RegistroTelefonicoModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("AdministradoresModel");

?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-phone text-primary mr-2"></i>
							Registro de Llamadas Telefónicas
						</h3>
						<p class="text-muted mb-0">Gestión y seguimiento de comunicaciones telefónicas con organizaciones</p>
					</div>
					<button type="button" class="btn btn-primary btn-lg shadow-sm" data-toggle="modal" data-target="#modal-crear-registro">
						<i class="mdi mdi-phone-plus mr-2"></i>
						Nuevo Registro
					</button>
				</div>
			</div>
		</div>

		<!-- Statistics Cards -->
		<div class="row mb-4">
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-primary">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Llamadas</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($registros) ?></div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-primary-light rounded-circle">
									<i class="mdi mdi-phone text-primary"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-success">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Organizaciones Contactadas</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$organizaciones = array();
										foreach($registros as $registro) {
											$organizaciones[$registro->organizaciones_id_organizacion] = true;
										}
										echo count($organizaciones);
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-success-light rounded-circle">
									<i class="mdi mdi-office-building text-success"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-warning">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Evaluadores Activos</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$evaluadores = array();
										foreach($registros as $registro) {
											$evaluadores[$registro->administradores_id_administrador] = true;
										}
										echo count($evaluadores);
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-warning-light rounded-circle">
									<i class="mdi mdi-account-group text-warning"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
				<div class="card shadow-sm border-left-info">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Llamadas Hoy</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">
									<?php 
										$hoy = date('Y-m-d');
										$llamadas_hoy = 0;
										foreach($registros as $registro) {
											if(date('Y-m-d', strtotime($registro->fecha)) == $hoy) {
												$llamadas_hoy++;
											}
										}
										echo $llamadas_hoy;
									?>
								</div>
							</div>
							<div class="col-auto">
								<div class="icon-shape bg-info-light rounded-circle">
									<i class="mdi mdi-calendar-today text-info"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Tabla de registros telefónicos -->
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card shadow">
					<div class="card-header bg-white border-0">
						<div class="d-flex justify-content-between align-items-center">
							<h4 class="card-title mb-0">
								<i class="mdi mdi-table-large text-primary mr-2"></i>
								Registro de Llamadas Telefónicas
							</h4>
							<div class="badge badge-primary badge-pill">
								<?= count($registros) ?> registros
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="tabla_reportes_telefonico" class="table table-hover table-striped">
								<thead class="thead-light">
									<tr>
										<th class="border-0">
											<i class="mdi mdi-office-building mr-1"></i>Organización
										</th>
										<th class="border-0">
											<i class="mdi mdi-card-account-details mr-1"></i>NIT
										</th>
										<th class="border-0">
											<i class="mdi mdi-account mr-1"></i>Con quien se habló
										</th>
										<th class="border-0">
											<i class="mdi mdi-briefcase mr-1"></i>Cargo
										</th>
										<th class="border-0">
											<i class="mdi mdi-phone mr-1"></i>Teléfono
										</th>
										<th class="border-0">
											<i class="mdi mdi-phone-classic mr-1"></i>Tipo Llamada
										</th>
										<th class="border-0">
											<i class="mdi mdi-message mr-1"></i>Tipo Comunicación
										</th>
										<th class="border-0">
											<i class="mdi mdi-file-document mr-1"></i>ID Solicitud
										</th>
										<th class="border-0">
											<i class="mdi mdi-calendar mr-1"></i>Fecha
										</th>
										<th class="border-0">
											<i class="mdi mdi-clock mr-1"></i>Duración
										</th>
										<th class="border-0">
											<i class="mdi mdi-text mr-1"></i>Descripción
										</th>
										<th class="border-0">
											<i class="mdi mdi-account-check mr-1"></i>Evaluador
										</th>
										<th class="border-0 text-center">
											<i class="mdi mdi-cog mr-1"></i>Acciones
										</th>
									</tr>
								</thead>
								<tbody id="tbody">
								<?php foreach ($registros as $registro): ?>
									<tr class="align-middle">
										<td>
											<div class="d-flex align-items-center">
												<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
													<i class="mdi mdi-office-building text-primary"></i>
												</div>
												<div>
													<h6 class="mb-0 font-weight-bold">
														<?= $CI->OrganizacionesModel->getOrganizacion($registro->organizaciones_id_organizacion)->nombreOrganizacion ?>
													</h6>
												</div>
											</div>
										</td>
										<td>
											<span class="font-weight-medium"><?= $CI->OrganizacionesModel->getOrganizacion($registro->organizaciones_id_organizacion)->numNIT ?></span>
										</td>
										<td>
											<span class="text-muted"><?= $registro->funcionario ?></span>
										</td>
										<td>
											<span class="badge badge-outline-info px-3 py-2"><?= $registro->cargo ?></span>
										</td>
										<td>
											<span class="font-weight-medium"><?= $registro->telefono ?></span>
										</td>
										<td>
											<span class="badge badge-outline-primary px-3 py-2"><?= $registro->tipoLlamada ?></span>
										</td>
										<td>
											<span class="badge badge-outline-secondary px-3 py-2"><?= $registro->tipoComunicacion ?></span>
										</td>
										<td>
											<span class="font-weight-medium"><?= $registro->idSolicitud ?></span>
										</td>
										<td>
											<span class="text-muted"><?= date('d/m/Y H:i', strtotime($registro->fecha)) ?></span>
										</td>
										<td>
											<span class="badge badge-outline-success px-3 py-2"><?= $registro->duracion ?></span>
										</td>
										<td>
											<div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($registro->descripcion) ?>">
												<?= substr($registro->descripcion, 0, 50) . (strlen($registro->descripcion) > 50 ? '...' : '') ?>
											</div>
										</td>
										<td>
											<div class="d-flex align-items-center">
												<div class="avatar-sm bg-success-light rounded-circle mr-2 d-flex align-items-center justify-content-center">
													<i class="mdi mdi-account text-success"></i>
												</div>
												<small class="text-muted">
													<?= $CI->AdministradoresModel->getAdministradores($registro->administradores_id_administrador)->primerNombreAdministrador . ' ' . $CI->AdministradoresModel->getAdministradores($registro->administradores_id_administrador)->primerApellidoAdministrador ?>
												</small>
											</div>
										</td>
										<td class="text-center">
											<button class="btn btn-outline-primary btn-sm admin-modal" 
													data-funct="actualizar" 
													data-toggle="modal" 
													data-id="<?= $registro->id_registroTelefonico ?>" 
													data-target="#modal-detalle"
													title="Ver detalles del registro">
												<i class="mdi mdi-eye"></i>
											</button>
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
	</div>
</div>

<!-- Modal formulario detalle mejorado -->
<div class="modal fade" id="modal-detalle" tabindex="-1" role="dialog" aria-labelledby="modal-detalle">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content shadow-lg border-0">
			<div class="modal-header bg-primary text-white border-0">
				<h4 class="modal-title text-white" id="verAdmin">
					<i class="mdi mdi-phone-in-talk mr-2"></i>
					Detalle de la Llamada Telefónica
				</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<div class="container-fluid">
					<!-- Contenido del modal se cargará dinámicamente -->
					<div class="row">
						<div class="col-12">
							<div class="card border-0 shadow-sm">
								<div class="card-header bg-light border-0">
									<h6 class="mb-0 text-primary">
										<i class="mdi mdi-information mr-2"></i>Información de la Llamada
									</h6>
								</div>
								<div class="card-body" id="detalle-contenido">
									<!-- El contenido se cargará aquí dinámicamente -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-light border-0">
				<div class="btn-group" role="group" aria-label="acciones">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
						<i class="mdi mdi-close mr-1"></i>Cerrar
					</button>
					<button type="button" class="btn btn-outline-primary">
						<i class="mdi mdi-pencil mr-1"></i>Editar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Script para inicializar DataTables -->
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
$(document).ready(function() {
    // Verificar si la tabla ya está inicializada
    if (!$.fn.DataTable.isDataTable('#tabla_reportes_telefonico')) {
        // Inicializar tabla simple de registros telefónicos
        DataTableConfig.initSimpleTable(
            '#tabla_reportes_telefonico',
            'Registro Telefónico Mesas de Ayuda',
            'registro_telefonico'
        );
    } else {
        // Si ya está inicializada, obtener la instancia existente
        var table = $('#tabla_reportes_telefonico').DataTable();
        // Aquí puedes aplicar configuraciones adicionales si es necesario
    }
});
</script>
</div>
