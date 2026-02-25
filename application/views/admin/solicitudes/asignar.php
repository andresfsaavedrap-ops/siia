<?php
/***
 * @var $solicitudesSinAsignar
 * @var $solicitudesAsignadas
 * @var $administradores
 * @var $nivel
 */

// Función para verificar permisos (consistente con el sistema)
function canAccessAsignacion($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script src="<?= base_url('assets/js/functions/admin/modules/solicitudes/asignacion.js?v=1.0.1') . time() ?>" type="module"></script>
<link href="<?= base_url('assets/css/admin/modules/solicitudes/asignacion.css?v=1.0') ?>" rel="stylesheet" type="text/css" />
<!-- partial -->
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-account-arrow-right text-primary mr-2"></i>
							Asignación de Solicitudes
						</h4>
						<p class="text-muted mb-0 small">Gestiona la asignación de solicitudes a evaluadores</p>
					</div>
					<a href="<?= site_url('admin/organizaciones');?>" type="button" class="btn btn-outline-secondary btn-sm shadow-sm">
						<i class="mdi mdi-arrow-left mr-1"></i>
						Volver
					</a>
				</div>
			</div>
		</div>
		<!-- Estadísticas rápidas -->
		<div class="row mb-4">
			<div class="col-md-6">
				<div class="card border-left-warning shadow-sm" style="border-left-width: 4px;">
					<div class="card-body py-3">
						<div class="d-flex align-items-center">
							<div class="icon-circle bg-warning-light mr-3">
								<i class="mdi mdi-clock-outline text-warning"></i>
							</div>
							<div>
								<h6 class="font-weight-medium text-muted mb-0 small">Sin Asignar</h6>
								<h4 class="font-weight-bold mb-0"><?= $solicitudesSinAsignar ? count(array_filter($solicitudesSinAsignar, function($s) { return $s->asignada == "SIN ASIGNAR"; })) : 0 ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card border-left-success shadow-sm" style="border-left-width: 4px;">
					<div class="card-body py-3">
						<div class="d-flex align-items-center">
							<div class="icon-circle bg-success-light mr-3">
								<i class="mdi mdi-account-check text-success"></i>
							</div>
							<div>
								<h6 class="font-weight-medium text-muted mb-0 small">Asignadas</h6>
								<h4 class="font-weight-bold mb-0"><?= $solicitudesAsignadas ? count(array_filter($solicitudesAsignadas, function($s) { return $s->asignada != "SIN ASIGNAR"; })) : 0 ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Contenido en pestañas -->
		<div class="row">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0 pb-0">
						<ul class="nav nav-tabs card-header-tabs" id="asignacionTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="sin-asignar-tab" data-toggle="tab" href="#sin-asignar" role="tab">
									<i class="mdi mdi-clock-outline mr-1"></i>
									Sin Asignar
									<?php if ($solicitudesSinAsignar): ?>
										<span class="badge badge-warning ml-1"><?= count(array_filter($solicitudesSinAsignar, function($s) { return $s->asignada == "SIN ASIGNAR"; })) ?></span>
									<?php endif; ?>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="asignadas-tab" data-toggle="tab" href="#asignadas" role="tab">
									<i class="mdi mdi-account-check mr-1"></i>
									Asignadas
									<?php if ($solicitudesAsignadas): ?>
										<span class="badge badge-success ml-1"><?= count(array_filter($solicitudesAsignadas, function($s) { return $s->asignada != "SIN ASIGNAR"; })) ?></span>
									<?php endif; ?>
								</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content" id="asignacionTabContent">
							<!-- Tab Solicitudes Sin Asignar -->
							<div class="tab-pane fade show active" id="sin-asignar" role="tabpanel">
								<?php if ($solicitudesSinAsignar && count(array_filter($solicitudesSinAsignar, function($s) { return $s->asignada == "SIN ASIGNAR"; })) > 0): ?>
									<div class="table-responsive">
                                        <table id="tabla_sinasignar" class="table table-hover table-striped w-100">
											<thead class="thead-light">
                                            <tr>
                                                <th class="border-0">NIT</th>
                                                <th class="border-0">Organización</th>
                                                <th class="border-0">ID Solicitud</th>
                                                <th class="border-0">Fecha Finalización</th>
                                                <th class="border-0">Estado</th>
                                                <th class="border-0">Acción</th>
                                            </tr>
											</thead>
											<tbody>
												<?php foreach ($solicitudesSinAsignar as $solicitud): ?>
													<?php if ($solicitud->asignada == "SIN ASIGNAR"): ?>
                                                        <tr>
                                                            <td class="font-weight-medium"><?= $solicitud->numNIT ?></td>
                                                            <td style="width: 40px;"><?= $solicitud->nombreOrganizacion ?></td> 
                                                            <td>
                                                                <span class="badge badge-primary"><?= $solicitud->idSolicitud ?></span>
                                                            </td>
                                                            <td><?= date('d/m/Y', strtotime($solicitud->fechaFinalizado)) ?></td>
                                                            <td>
                                                                <span class="badge badge-warning">Sin Asignar</span>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm"
                                                                        id="verModalAsignar"
                                                                        data-organizacion="<?= $solicitud->id_organizacion ?>"
                                                                        data-nombre="<?= $solicitud->nombreOrganizacion ?>"
                                                                        data-nit="<?= $solicitud->numNIT ?>"
                                                                        data-solicitud="<?= $solicitud->idSolicitud ?>"
                                                                        data-toggle="modal"
                                                                        data-target="#asignarOrganizacion">
                                                                    <i class="mdi mdi-account-plus mr-1"></i>Asignar
                                                                </button>
                                                                <button class="btn btn-outline-info btn-sm verDetalleSolicitud ml-1"
                                                                        data-toggle="modal"
                                                                        data-target="#detalleSolicitud"
                                                                        data-id="<?= $solicitud->idSolicitud ?>"
                                                                        data-organizacion="<?= htmlspecialchars($solicitud->nombreOrganizacion) ?>"
                                                                        data-nit="<?= $solicitud->numNIT ?>"
                                                                        data-tipo="<?= htmlspecialchars($solicitud->tipoSolicitud) ?>"
                                                                        data-motivo="<?= htmlspecialchars($solicitud->motivoSolicitud) ?>"
                                                                        data-modalidad="<?= htmlspecialchars($solicitud->modalidadSolicitud) ?>"
                                                                        data-fecha="<?= date('d/m/Y', strtotime($solicitud->fechaFinalizado)) ?>"
                                                                        data-estado="Sin Asignar">
                                                                    <i class="mdi mdi-information-outline mr-1"></i>Detalle
                                                                </button>
                                                                <button class="btn btn-outline-secondary btn-sm toggle-detalles d-md-none ml-1" aria-expanded="false">
                                                                    <i class="mdi mdi-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
													<?php endif; ?>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="text-center py-5">
										<div class="icon-circle bg-success-light mx-auto mb-3" style="width: 60px; height: 60px;">
											<i class="mdi mdi-check-circle text-success" style="font-size: 2rem;"></i>
										</div>
										<h5 class="font-weight-medium text-muted mb-2">¡Excelente!</h5>
										<p class="text-muted mb-0">No hay solicitudes pendientes por asignar</p>
										<small class="text-muted">Las nuevas solicitudes aparecerán aquí cuando se finalicen</small>
									</div>
								<?php endif; ?>
							</div>
							<!-- Tab Solicitudes Asignadas -->
							<div class="tab-pane fade" id="asignadas" role="tabpanel">
								<?php if ($solicitudesAsignadas && count(array_filter($solicitudesAsignadas, function($s) { return $s->asignada != "SIN ASIGNAR"; })) > 0): ?>
									<div class="table-responsive">
                                        <table id="tabla_asignadas" class="table table-hover table-striped w-100">
											<thead class="thead-light">
                                            <tr>
                                                <th class="border-0">NIT</th>
                                                <th class="border-0">Organización</th>
                                                <th class="border-0">ID Solicitud</th>
                                                <th class="border-0">Fecha Finalización</th>
                                                <th class="border-0">Asignada a</th>
                                                <th class="border-0">Acción</th>
                                            </tr>
											</thead>
											<tbody>
												<?php foreach ($solicitudesAsignadas as $solicitud): ?>
													<?php if ($solicitud->asignada != "SIN ASIGNAR"): ?>
                                                    <tr>
                                                        <td class="font-weight-medium"><?= $solicitud->numNIT ?></td>
                                                            <td><div style="white-space: normal; word-break: break-word;"><?= htmlspecialchars($solicitud->nombreOrganizacion) ?></div></td> 
                                                        <td>
                                                            <span class="badge badge-primary"><?= $solicitud->idSolicitud ?></span>
                                                        </td>
                                                        <td><?= date('d/m/Y', strtotime($solicitud->fechaFinalizado)) ?></td>
                                                        <td>
                                                            <span class="badge badge-success"><?= $solicitud->asignada ?></span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm"
                                                                    id="verModalAsignar"
                                                                    data-organizacion="<?= $solicitud->id_organizacion ?>"
                                                                    data-nombre="<?= $solicitud->nombreOrganizacion ?>"
                                                                    data-nit="<?= $solicitud->numNIT ?>"
                                                                    data-solicitud="<?= $solicitud->idSolicitud ?>"
                                                                    data-toggle="modal"
                                                                    data-target="#asignarOrganizacion">
                                                                <i class="mdi mdi-account-switch mr-1"></i>Reasignar
                                                            </button>
                                                            <button class="btn btn-outline-info btn-sm verDetalleSolicitud ml-1"
                                                                    data-toggle="modal"
                                                                    data-target="#detalleSolicitud"
                                                                    data-id="<?= $solicitud->idSolicitud ?>"
                                                                    data-organizacion="<?= htmlspecialchars($solicitud->nombreOrganizacion) ?>"
                                                                    data-nit="<?= $solicitud->numNIT ?>"
                                                                    data-tipo="<?= htmlspecialchars($solicitud->tipoSolicitud) ?>"
                                                                    data-motivo="<?= htmlspecialchars($solicitud->motivoSolicitud) ?>"
                                                                    data-modalidad="<?= htmlspecialchars($solicitud->modalidadSolicitud) ?>"
                                                                    data-fecha="<?= date('d/m/Y', strtotime($solicitud->fechaFinalizado)) ?>"
                                                                    data-estado="<?= htmlspecialchars($solicitud->asignada) ?>">
                                                                <i class="mdi mdi-information-outline mr-1"></i>Detalle
                                                            </button>
                                                            <button class="btn btn-outline-secondary btn-sm toggle-detalles d-md-none ml-1" aria-expanded="false">
                                                                <i class="mdi mdi-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
													<?php endif; ?>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="text-center py-5">
										<div class="icon-circle bg-info-light mx-auto mb-3" style="width: 60px; height: 60px;">
											<i class="mdi mdi-information text-info" style="font-size: 2rem;"></i>
										</div>
										<h5 class="font-weight-medium text-muted mb-2">Sin solicitudes asignadas</h5>
										<p class="text-muted mb-0">No hay solicitudes asignadas actualmente</p>
										<small class="text-muted">Las solicitudes asignadas aparecerán aquí</small>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal de Asignación Modernizado -->
<div class="modal fade" id="asignarOrganizacion" tabindex="-1" role="dialog" aria-labelledby="ariaAsignar">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title text-white" id="ariaAsignar">
					<i class="mdi mdi-account-arrow-right mr-2"></i>
					Asignar Evaluador
				</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					<i class="mdi mdi-information mr-2"></i>
					<strong>Información:</strong> Si no encuentra el evaluador que busca, puede que esté deshabilitado o tenga otro rol. Contacte con soporte TICS.
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label font-weight-bold">
								<i class="mdi mdi-account-search mr-1"></i>Seleccionar Evaluador:
							</label>
							<select name="evaluadorAsignar" id="evaluadorAsignar" class="form-control" required>
								<option value="">-- Seleccione un evaluador --</option>
								<?php foreach ($administradores as $administrador): ?>
									<?php if ($administrador->nivel == 1): ?>
										<option value="<?= $administrador->usuario ?>" data-id="<?= $administrador->id_administrador ?>">
											<?= $administrador->primerNombreAdministrador . " " . $administrador->primerApellidoAdministrador ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card bg-light">
							<div class="card-body py-3">
								<h6 class="card-title mb-2">
									<i class="mdi mdi-information-outline mr-1"></i>Información de la Solicitud
								</h6>
								<div class="row">
									<div class="col-6">
										<small class="text-muted">ID Organización:</small>
										<p class="mb-1 font-weight-medium" id="idAsigOrg">-</p>
									</div>
									<div class="col-6">
										<small class="text-muted">ID Solicitud:</small>
										<p class="mb-1 font-weight-medium" id="idSolicitud">-</p>
									</div>
								</div>
								<div class="mt-2">
									<small class="text-muted">Organización:</small>
									<p class="mb-1 font-weight-medium" id="nombreAsigOrg">-</p>
								</div>
								<div class="mt-2">
									<small class="text-muted">NIT:</small>
									<p class="mb-0 font-weight-medium" id="nitAsigOrg">-</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="alert alert-warning mt-3" role="alert">
					<h6 class="alert-heading">
						<i class="mdi mdi-alert-circle mr-2"></i>¿Qué sucederá al asignar?
					</h6>
					<ul class="mb-0">
						<li>Se enviará un correo electrónico al evaluador con la información de la organización</li>
						<li>Solo el evaluador asignado podrá acceder a revisar esta solicitud</li>
						<li>La solicitud cambiará su estado a "Asignada"</li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<i class="mdi mdi-close mr-1"></i>Cancelar
				</button>
				<button type="button" class="btn btn-success" id="asignarOrganizacionEvaluador">
					<i class="mdi mdi-check mr-1"></i>Confirmar Asignación
				</button>
			</div>
		</div>
	</div>
</div>
</div>
<!-- Modal Detalle de Solicitud -->
<div class="modal fade" id="detalleSolicitud" tabindex="-1" role="dialog" aria-labelledby="ariaDetalleSolicitud">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-detalle">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white" id="ariaDetalleSolicitud">
                    <i class="mdi mdi-information-outline mr-2"></i>Detalle de la Solicitud
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-card mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-2 mb-md-0">
                            <div class="section-title"><i class="mdi mdi-domain mr-1"></i>Organización</div>
                            <p class="font-weight-medium mb-1" id="detalleOrganizacion">-</p>
                            <span class="badge badge-info" id="detalleNit">-</span>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <div class="small text-muted">ID Solicitud</div>
                                <div class="font-weight-medium" id="detalleIdSolicitud">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Tipo</div>
                            <div id="detalleTipo">-</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Modalidad</div>
                            <div id="detalleModalidad">-</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Asignada</div>
                            <span class="badge badge-success" id="detalleEstado">-</span>
                        </div>
                    </div>
                </div>

                <div class="detail-card mt-2">
                    <div class="small text-muted">Motivo</div>
                    <p class="mb-0" id="detalleMotivo">-</p>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="small text-muted">Fecha Finalización</div>
                            <div id="detalleFecha">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
