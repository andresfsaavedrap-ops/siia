<!-- Estilos personalizados módulo -->
<link href="<?= base_url('assets/css/admin/modules/organizaciones/custom-organizaciones.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
<?php
/***
 * @var $activeLink
 * @var $nivel
 */
// Función para verificar permisos basada en la lógica del sistema
function canAccessOrganizacion($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section - Más compacto -->
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-office-building text-primary mr-2"></i>
							Gestión de Organizaciones
						</h4>
						<p class="text-muted mb-0 small">Administra las organizaciones y solicitudes del sistema</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Secciones en pestañas para reducir espacio vertical -->
		<div class="row" id="organizacionesTabs">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0 pb-0">
						<ul class="nav nav-tabs card-header-tabs" id="organizacionesTabs" role="tablist">
							<!-- Listados - Niveles que NO son 7 -->
							<?php if (canAccessOrganizacion([0,1,4,5,6, 7], $nivel)): ?>
							<li class="nav-item">
								<a class="nav-link <?php if (!canAccessOrganizacion([0,1,2,3,4,5,6,7], $nivel)) echo 'active'; ?>" id="listados-tab" data-toggle="tab" href="#listados" role="tab">
									<i class="mdi mdi-magnify mr-1"></i>Listados
								</a>
							</li>
							<?php endif; ?>
							<!-- Operaciones - Solo niveles 0,1,6 -->
							<?php if (canAccessOrganizacion([0,1,3,6], $nivel)): ?>
							<li class="nav-item">
								<a class="nav-link" id="operaciones-tab" data-toggle="tab" href="#operaciones" role="tab">
									<i class="mdi mdi-wrench mr-1"></i>Operaciones
								</a>
							</li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="organizacionesTabContent">
							<!-- Listados Tab - Niveles que NO son 7 -->
							<?php if (canAccessOrganizacion([0,1,2,3,4,5,6, 7], $nivel)): ?>
							<div class="tab-pane fade show active" id="listados" role="tabpanel">
								<div class="row">
									<!-- Buscar Organización - Todos los niveles excepto 7 -->
									<div class="col-md-4 mb-2" id="busOrg">
										<div class="card border-left-primary h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-primary-light mr-3">
														<i class="mdi mdi-magnify text-primary"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Buscar Organización</h6>
														<p class="text-muted mb-2 small">Búsqueda avanzada</p>
														<button class="btn btn-primary btn-sm" id="admin_buscar_org">
															<i class="mdi mdi-database-search mr-1"></i>Buscar
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Organizaciones Inscritas - Niveles que NO son 2,3,5,7 -->
									<?php if (canAccessOrganizacion([0,1,4,6,7], $nivel)): ?>
									<div class="col-md-4 mb-2" id="verOrgInscr">
										<div class="card border-left-success h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-success-light mr-3">
														<i class="mdi mdi-book-open text-success"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Organizaciones Inscritas</h6>
														<p class="text-muted mb-2 small">Todas las organizaciones</p>
														<a href="<?= site_url('admin/organizaciones/inscritas');?>" class="btn btn-success btn-sm">
															<i class="mdi mdi-format-list-bulleted mr-1"></i>Ver
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
							<!-- Operaciones Tab - Solo niveles 0,1,6 -->
							<?php if (canAccessOrganizacion([0,1,3,6], $nivel)): ?>
							<div class="tab-pane fade" id="operaciones" role="tabpanel">
								<div class="row">
									<!-- Cambiar Estado - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,1,6], $nivel)): ?>
									<div class="col-md-4 mb-2" id="camEstOrg">
										<div class="card border-left-info h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-info-light mr-3">
														<i class="mdi mdi-information text-info"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Cambiar Estado</h6>
														<p class="text-muted mb-2 small">Modificar estado</p>
														<a href="<?= site_url('admin/organizaciones/estado');?>" class="btn btn-info btn-sm">
															<i class="mdi mdi-swap-horizontal mr-1"></i>Estado
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- Resoluciones - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,1,6], $nivel)): ?>
									<div class="col-md-4 mb-2">
										<div class="card border-left-secondary h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-secondary-light mr-3">
														<i class="mdi mdi-file-document text-secondary"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Resoluciones</h6>
														<p class="text-muted mb-2 small">Documentos oficiales</p>
														<a href="<?= site_url('admin/resoluciones');?>" class="btn btn-secondary btn-sm">
															<i class="mdi mdi-file-plus mr-1"></i>Adjuntar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
									<!-- Cámara de Comercio - Solo niveles 0,1,6 -->
									<?php if (canAccessOrganizacion([0,3], $nivel)): ?>
									<div class="col-md-4 mb-2" id="adjCamara">
										<div class="card border-left-danger h-100" style="border-left-width: 3px;">
											<div class="card-body py-3">
												<div class="d-flex align-items-center">
													<div class="icon-circle bg-danger-light mr-3">
														<i class="mdi mdi-file-pdf-box text-danger"></i>
													</div>
													<div class="flex-grow-1">
														<h6 class="font-weight-medium mb-1">Cámara de Comercio</h6>
														<p class="text-muted mb-2 small">Documentos legales</p>
														<a href="<?= site_url('admin/organizaciones/camara-comercio');?>" class="btn btn-danger btn-sm">
															<i class="mdi mdi-upload mr-1"></i>Adjuntar
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Sección de búsqueda modernizada -->
		<div class="row" id="buscar_org" style="display: none;">
			<div class="col-md-8 mx-auto">
				<div class="card shadow">
					<div class="card-header bg-primary text-white">
						<h4 class="card-title mb-0 text-white">
							<i class="mdi mdi-magnify mr-2"></i>
							Buscar Organización
						</h4>
						<p class="mb-0 text-white-50">Utilice los filtros para encontrar organizaciones específicas</p>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label font-weight-bold">
										<i class="mdi mdi-office-building mr-1"></i>Nombre de la Organización:
									</label>
									<input type="text" class="form-control" name="admin_buscar_nombre" id="admin_buscar_nombre" placeholder="Ingrese el nombre de la organización">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label font-weight-bold">
										<i class="mdi mdi-tag mr-1"></i>Sigla de la Organización:
									</label>
									<input type="text" class="form-control" name="admin_buscar_sigla" id="admin_buscar_sigla" placeholder="Ingrese la sigla">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label font-weight-bold">
										<i class="mdi mdi-identifier mr-1"></i>NIT:
									</label>
									<input type="text" class="form-control" name="admin_buscar_nit" id="admin_buscar_nit" placeholder="Ingrese el NIT">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label font-weight-bold">
										<i class="mdi mdi-account mr-1"></i>Nombre del Representante:
									</label>
									<input type="text" class="form-control" name="admin_buscar_nombre_rep" id="admin_buscar_nombre_rep" placeholder="Ingrese el nombre del representante">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer bg-light">
						<div class="d-flex justify-content-between">
							<button class="btn btn-outline-secondary" id="admin_buscar_org_volver">
								<i class="mdi mdi-arrow-left mr-2"></i>Volver
							</button>
							<button class="btn btn-primary" id="admin_buscar_organizacion" name="admin_buscar_organizacion">
								<i class="mdi mdi-magnify mr-2"></i>Buscar
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Tabla de resultados modernizada -->
		<div class="row" id="organizaciones_encontradas" style="display: none;">
			<div class="col-md-12">
				<div class="card shadow">
					<div class="card-header bg-white border-0">
						<div class="d-flex justify-content-between align-items-center">
							<h4 class="card-title mb-0">
								<i class="mdi mdi-table-large text-primary mr-2"></i>
								Resultados de Búsqueda
							</h4>
							<button class="btn btn-outline-secondary" id="admin_org_encontradas_volver">
								<i class="mdi mdi-arrow-left mr-2"></i>Regresar
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="tabla_buscar_organizacion" class="table table-hover table-striped">
								<thead class="thead-light">
									<tr>
										<th class="border-0">Nombre Org</th>
										<th class="border-0">NIT</th>
										<th class="border-0">Sigla</th>
										<th class="border-0">Correo Org</th>
										<th class="border-0">Correo Rep</th>
										<th class="border-0">Primer Nombre Rep</th>
										<th class="border-0">Segundo Nombre Rep</th>
										<th class="border-0">Primer Apellido Rep</th>
										<th class="border-0">Segundo Apellido Rep</th>
										<th class="border-0">Primer Nombre Per</th>
										<th class="border-0">Primer Apellido Per</th>
									</tr>
								</thead>
								<tbody id="tbody_encontradas">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
