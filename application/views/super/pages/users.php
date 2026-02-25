<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $usuarios
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
								<i class="mdi mdi-account-multiple text-primary mr-2"></i>
								Gestión de Usuarios
							</h3>
							<p class="text-muted mb-0">Administra los usuarios registrados en el sistema</p>
						</div>
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
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Usuarios</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($usuarios) ?></div>
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
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Verificados</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$verificados = 0;
											foreach($usuarios as $usuario) {
												if($usuario->verificado == 1) $verificados++;
											}
											echo $verificados;
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
									<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Conectados</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$conectados = 0;
											foreach($usuarios as $usuario) {
												if($usuario->logged_in == 1) $conectados++;
											}
											echo $conectados;
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-warning-light rounded-circle">
										<i class="mdi mdi-account-network text-warning"></i>
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
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Organizaciones</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
											$organizaciones = array();
											foreach($usuarios as $usuario) {
												$organizaciones[$usuario->sigla] = true;
											}
											echo count($organizaciones);
										?>
									</div>
								</div>
								<div class="col-auto">
									<div class="icon-shape bg-info-light rounded-circle">
										<i class="mdi mdi-domain text-info"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Tabla de usuarios -->
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Listado de Usuarios
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($usuarios) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="tabla_super_usuarios" class="table table-hover table-striped">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-domain mr-1"></i>Organización
											</th>
											<th class="border-0">
												<i class="mdi mdi-card-account-details mr-1"></i>NIT
											</th>
											<th class="border-0">
												<i class="mdi mdi-account mr-1"></i>Usuario
											</th>
											<th class="border-0">
												<i class="mdi mdi-lock mr-1"></i>Contraseña
											</th>
											<th class="border-0">
												<i class="mdi mdi-check-circle mr-1"></i>Estado
											</th>
											<th class="border-0">
												<i class="mdi mdi-connection mr-1"></i>Conectado
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php foreach ($usuarios as $usuario): ?>
											<tr class="align-middle">
												<td>
													<div class="d-flex align-items-center">
														<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
															<i class="mdi mdi-domain text-primary"></i>
														</div>
														<span class="font-weight-medium"><?= $usuario->sigla ?></span>
													</div>
												</td>
												<td>
													<span class="font-weight-medium"><?= $usuario->numNIT ?></span>
												</td>
												<td>
													<div class="d-flex align-items-center">
														<div class="avatar-sm bg-primary-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
															<i class="mdi mdi-account text-primary"></i>
														</div>
														<span class="font-weight-medium"><?= $usuario->usuario ?></span>
													</div>
												</td>
												<td>
													<span class="text-muted"><?= $CI->UsuariosModel->getPassword($usuario->contrasena_rdel) ?></span>
												</td>
												<td>
													<?php 
														$estado = $CI->TokenModel->getState($usuario->verificado);
														if($usuario->verificado == 1) {
															echo '<span class="badge badge-success px-3 py-2"><i class="mdi mdi-check-circle mr-1"></i>' . $estado . '</span>';
														} elseif($usuario->verificado == 2) {
															echo '<span class="badge badge-danger px-3 py-2"><i class="mdi mdi-close-circle mr-1"></i>' . $estado . '</span>';
														} else {
															echo '<span class="badge badge-outline-primary px-3 py-2">' . $estado . '</span>';
														}
													?>
												</td>
												<td>
													<?php if($usuario->logged_in == 1): ?>
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
													<button class="btn btn-outline-primary btn-sm admin-usuario" 
															data-toggle="modal" 
															data-id="<?= $usuario->id_usuario ?>" 
															data-target="#modal-user"
															title="Ver detalles del usuario">
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
	<!-- Modal formulario usuarios -->
	<div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="verUsuarios">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white border-0">
					<h4 class="modal-title text-white" id="verUser">
						<i class="mdi mdi-account-cog mr-2"></i>
						Usuario: <label id="super_usuario_modal"></label> 
						<span id="super_status_usr"></span>
					</h4>
					<input type="hidden" id="super_id_user">
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<div class="container-fluid">
						<?php echo form_open('', array('id' => 'formulario_super_usuario')); ?>
						
						<!-- Información de la Organización -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-domain mr-2"></i>Información de la Organización
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Organización:</label>
											<input type="text" id="nombre_organizacion" name="nombre_organizacion" class="form-control" disabled>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">NIT:</label>
											<input type="text" id="nit_organizacion" name="nit_organizacion" class="form-control" disabled>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Información del Usuario -->
						<div class="card border-0 shadow-sm mb-4">
							<div class="card-header bg-light border-0">
								<h6 class="mb-0 text-primary">
									<i class="mdi mdi-account mr-2"></i>Datos del Usuario
								</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Correo electrónico:</label>
											<input type="text" id="correo_electronico_usuario" name="correo_electronico_usuario" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Usuario:</label>
											<input type="text" id="username" name="username" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Contraseña:</label>
											<input type="text" id="password" name="password" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-label font-weight-bold">Estado:</label>
											<select class="form-control custom-select" name="estado_usuario" id="estado_usuario" required>
												<option value="0">No Verificado</option>
												<option value="1">Verificado</option>
												<option value="2">Bloqueado</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<div class="modal-footer bg-light border-0">
					<div class="d-flex justify-content-between w-100">
						<div class="btn-group" role="group" aria-label="acciones" id="actions_users">
							<button type="button" class="btn btn-outline-danger" id="super_eliminar_cuenta">
								<i class="mdi mdi-delete mr-1"></i>Eliminar
							</button>
							<button type="button" class="btn btn-outline-warning" id="super_desconectar_user">
								<i class="mdi mdi-logout mr-1"></i>Desconectar
							</button>
							<button type="button" class="btn btn-outline-info" id="super_actualizar_user">
								<i class="mdi mdi-update mr-1"></i>Actualizar
							</button>
						</div>
						<div class="btn-group" role="group">
							<button type="button" class="btn btn-success" id="super_enviar_activacion_cuenta">
								<i class="mdi mdi-email mr-1"></i>Enviar Activación
							</button>
							<button type="button" class="btn btn-info" id="super_enviar_info_usuer">
								<i class="mdi mdi-information mr-1"></i>Enviar Información
							</button>
						</div>
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
			'#tabla_usuarios',
			'Usuarios SEAS',
			'usuarios_seas'
		);
	});
	</script>
<?php endif; ?>
</div>
