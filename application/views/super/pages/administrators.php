<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $administradores
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
$CI->load->model("UsuariosModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("CorreosRegistroModel");
$CI->load->model("TokenModel");
if($logged_in == TRUE && $tipo_usuario == "super"): ?>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-account-supervisor-circle text-primary mr-2"></i>
								Gestión de Administradores
							</h3>
							<p class="text-muted mb-0">Administra los usuarios con permisos administrativos del sistema</p>
						</div>
						<button type="button" class="btn btn-primary btn-lg admin-modal shadow-sm" data-funct="crear" data-toggle="modal" data-target="#modal-admin">
							<i class="mdi mdi-account-plus mr-2"></i>
							Crear Administrador
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
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Administradores</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($administradores) ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-primary-light rounded-circle">
										<i class="mdi mdi-account-group text-primary"></i>
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
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Conectados</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$conectados = 0;
											foreach($administradores as $admin) {
												if($admin->logged_in == 1) $conectados++;
											}
											echo $conectados;
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-success-light rounded-circle">
										<i class="mdi mdi-account-check text-success"></i>
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
									<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Desconectados</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($administradores) - $conectados ?></div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-warning-light rounded-circle">
										<i class="mdi mdi-account-off text-warning"></i>
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
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Niveles de Acceso</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$niveles = array();
											foreach($administradores as $admin) {
												$niveles[$admin->nivel] = true;
											}
											echo count($niveles);
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-info-light rounded-circle">
										<i class="mdi mdi-security text-info"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Tabla de administradores -->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Listado de Administradores
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($administradores) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="tabla_super_admins" class="table table-hover table-striped">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-account mr-1"></i>Nombre Completo
											</th>
											<th class="border-0">
												<i class="mdi mdi-card-account-details mr-1"></i>Cédula
											</th>
											<th class="border-0">
												<i class="mdi mdi-email mr-1"></i>Correo Electrónico
											</th>
											<th class="border-0">
												<i class="mdi mdi-security mr-1"></i>Nivel de Acceso
											</th>
											<th class="border-0">
												<i class="mdi mdi-connection mr-1"></i>Estado
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
									<?php foreach ($administradores as $administrador): ?>
										<tr class="align-middle">
											<td>
												<div class="d-flex align-items-center">
													<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
														<i class="mdi mdi-account text-primary"></i>
													</div>
													<div>
														<h6 class="mb-0 font-weight-bold">
															<?= $administrador->primerNombreAdministrador . " " . $administrador->primerApellidoAdministrador ?>
														</h6>
														<small class="text-muted"><?= $administrador->nombreUsuarioAdministrador ?></small>
													</div>
												</div>
											</td>
											<td>
												<span class="font-weight-medium"><?= $administrador->numCedulaCiudadaniaAdministrador ?></span>
											</td>
											<td>
												<span class="text-muted"><?= $administrador->direccionCorreoElectronico ?></span>
											</td>
											<td>
												<span class="badge badge-outline-primary px-3 py-2">
													<?= $CI->AdministradoresModel->getNivel($administrador->nivel) ?>
												</span>
											</td>
											<td>
												<?php if($administrador->logged_in == 1): ?>
													<span class="badge badge-success px-3 py-2">
														<i class="mdi mdi-check-circle mr-1"></i>Conectado
													</span>
												<?php else: ?>
													<span class="badge badge-secondary px-3 py-2">
														<i class="mdi mdi-minus-circle mr-1"></i>Desconectado
													</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button class="btn btn-outline-primary btn-sm admin-modal" 
														data-funct="actualizar" 
														data-toggle="modal" 
														data-id="<?= $administrador->id_administrador ?>" 
														data-target="#modal-admin"
														title="Ver detalles del administrador">
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
	<!-- Modal formulario administradores mejorado -->
	<div class="modal fade" id="modal-admin" tabindex="-1" role="dialog" aria-labelledby="verAdmin">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white border-0">
					<h4 class="modal-title text-white" id="verAdmin">
						<i class="mdi mdi-account-cog mr-2"></i>
						Administrador <label id="super_id_admin_modal"></label> 
						<span id="super_status_adm"></span>
					</h4>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="container-fluid">
						<?= form_open('', array('id' => 'formulario_super_administradores')); ?>
						
						<!-- Información Personal -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-account-details mr-2"></i>Información Personal
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Primer Nombre:</label>
											<input class="form-control" type="text" id="super_primernombre_admin" name="super_primernombre_admin" placeholder="Ingrese el primer nombre">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Segundo Nombre:</label>
											<input class="form-control" type="text" id="super_segundonombre_admin" name="super_segundonombre_admin" placeholder="Ingrese el segundo nombre (opcional)">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Primer Apellido:</label>
											<input class="form-control" type="text" id="super_primerapellido_admin" name="super_primerapellido_admin" placeholder="Ingrese el primer apellido">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Segundo Apellido:</label>
											<input class="form-control" type="text" id="super_segundoapellido_admin" name="super_segundoapellido_admin" placeholder="Ingrese el segundo apellido (opcional)">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Número de Cédula:</label>
											<input class="form-control" type="number" id="super_numerocedula_admin" name="super_numerocedula_admin" placeholder="Ingrese el número de cédula">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Extensión:</label>
											<input class="form-control" type="number" id="super_ext_admin" name="super_ext_admin" placeholder="Extensión telefónica">
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Información de Acceso -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-security mr-2"></i>Información de Acceso
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Nivel de Acceso:</label>
											<select class="form-control" name="super_acceso_nvl" id="super_acceso_nvl" required>
												<option value="0">Total 0</option>
												<option value="1">Evaluador 1</option>
												<option value="2">Reportes 2</option>
												<option value="3">Cámaras 3</option>
												<option value="4">Histórico 4</option>
												<option value="5">Seguimientos 5</option>
												<option value="6">Asignación 6</option>
												<option value="7">Atención al ciudadano 7</option>
												<option value="8">Dirección Técnica 8</option>
												<option value="9">Jurídica 9</option>
												<option value="10">Dirección Nacional 10</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Nombre de Usuario:</label>
											<input class="form-control" type="text" id="super_nombre_admin" name="super_nombre_admin" placeholder="Nombre de usuario para el sistema">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Contraseña:</label>
											<input class="form-control" type="password" id="super_contrasena_admin" name="super_contrasena_admin" placeholder="Contraseña de acceso">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Correo Electrónico:</label>
											<input class="form-control" type="email" id="super_correo_electronico_admin" name="super_correo_electronico_admin" placeholder="correo@ejemplo.com">
										</div>
									</div>
								</div>
							</div>
						</div>
						<?= form_close(); ?>
					</div>
				</div>
				<div class="modal-footer bg-light border-0">
					<div class="d-flex justify-content-between w-100">
						<div class="btn-group" role="group" aria-label="acciones" id="actions-admins">
							<button type="button" class="btn btn-outline-danger" id="super_eliminar_admin">
								<i class="mdi mdi-delete mr-1"></i>Eliminar
							</button>
							<button type="button" class="btn btn-outline-warning" id="super_desconectar_admin">
								<i class="mdi mdi-logout mr-1"></i>Desconectar
							</button>
							<button type="button" class="btn btn-outline-info" id="super_actualizar_admin">
								<i class="mdi mdi-update mr-1"></i>Actualizar
							</button>
						</div>
						<button type="button" class="btn btn-success" id="super_nuevo_admin">
							<i class="mdi mdi-check mr-1"></i>Crear Administrador
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
	<script>
	$(document).ready(function() {
		// Inicializar tabla simple de administradores
		DataTableConfig.initSimpleTable(
			'#tabla_administradores',
			'Administradores SEAS',
			'administradores_seas'
		);
	});
	</script>
<?php endif; ?>
</div>

