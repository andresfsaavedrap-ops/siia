
<?php
/***
 * @var $organizaciones
 */
?>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<link href="<?= base_url('assets/css/admin/modules/solicitudes/asignacion.css?v=1.0') ?>" rel="stylesheet" type="text/css" />
<script type="module" src="<?= base_url('assets/js/functions/admin/modules/docentes/docentes.js?v=1.1') . time() ?>"></script>
<div class="col-md-12">
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Header Section -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold text-primary mb-0">
                                <i class="mdi mdi-account-arrow-right text-primary mr-2"></i>
                                Asignación de Docentes
                            </h4>
                            <p class="text-muted mb-0 small">Gestiona la asignación de facilitadores a evaluadores</p>
                        </div>
						<!-- Botón volver -->
						<?php $this->load->view('admin/organizaciones/docentes/partials/_btn_volver'); ?>
                    </div>
                </div>
            </div>

            <!-- Contenido en pestañas -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="sin-asignar-tab" data-toggle="tab" href="#sin-asignar" role="tab">
                                        <i class="mdi mdi-clock-outline mr-1"></i>
                                        Sin Asignar
                                        <?php if (isset($docentes) && is_array($docentes)): ?>
                                            <span class="badge badge-warning ml-1">
                                                <?= count(array_filter($docentes, function($d){ return $d->asignado == "No"; })) ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="asignadas-tab" data-toggle="tab" href="#asignadas" role="tab">
                                        <i class="mdi mdi-account-check mr-1"></i>
                                        Asignadas
                                        <?php if (isset($docentes) && is_array($docentes)): ?>
                                            <span class="badge badge-success ml-1">
                                                <?= count(array_filter($docentes, function($d){ return $d->asignado != "No" && $d->asignado != null; })) ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Tab Docentes Sin Asignar -->
                                <div class="tab-pane fade show active" id="sin-asignar" role="tabpanel">
                                    <?php if (!empty($docentes) && count(array_filter($docentes, function($d){ return $d->asignado == "No"; })) > 0): ?>
                                        <div class="table-responsive">
                                            <table id="tabla_organizaciones_docentes_sin_asignar" class="table table-hover table-striped" width="100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="border-0">Organización</th>
                                                        <th class="border-0">NIT Org</th>
                                                        <th class="border-0">Cédula Docente</th>
                                                        <th class="border-0">Nombre</th>
                                                        <th class="border-0">Apellido</th>
                                                        <th class="border-0">Horas de Capacitación</th>
                                                        <th class="border-0">Aprobado</th>
                                                        <th class="border-0">Asignado</th>
                                                        <th class="border-0">Observaciones</th>
                                                        <th class="border-0">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <?php foreach ($docentes as $docente): ?>
                                                        <?php if ($docente->asignado == "No"): ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="text-truncate d-block" style="max-width: 260px;" title="<?= htmlspecialchars($docente->nombreOrganizacion) ?>">
                                                                        <?= strlen($docente->nombreOrganizacion) > 100 ? substr($docente->nombreOrganizacion, 0, 100) . '...' : $docente->nombreOrganizacion ?>
                                                                    </div>
                                                                </td>
                                                                <td><?= $docente->numNIT ?></td>
                                                                <td><?= $docente->numCedulaCiudadaniaDocente ?></td>
                                                                <td><?= $docente->primerNombreDocente ?></td>
                                                                <td><?= $docente->primerApellidoDocente ?></td>
                                                                <td><?= $docente->horaCapacitacion ?></td>
                                                                <td>
                                                                    <span class="badge <?= $docente->valido == 1 ? 'badge-success' : 'badge-secondary' ?>">
                                                                        <?= $docente->valido == 1 ? 'Sí' : 'No' ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= $docente->asignado ?></td>
                                                                <td>
                                                                    <div class="text-truncate d-block" style="max-width: 260px;" title="<?= htmlspecialchars($docente->observacion) ?>">
                                                                        <?= strlen($docente->observacion) > 50 ? substr($docente->observacion, 0, 50) . '...' : $docente->observacion ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-primary btn-sm"
                                                                            id="verModalAsignarDocente"
                                                                            data-id="<?= $docente->id_docente ?>"
                                                                            data-docente="<?= $docente->numCedulaCiudadaniaDocente ?>"
                                                                            data-nombre="<?= $docente->primerNombreDocente ?>"
                                                                            data-apellido="<?= $docente->primerApellidoDocente ?>"
                                                                            data-toggle="modal"
                                                                            data-target="#asignarDocente">
                                                                        <i class="mdi mdi-account-plus mr-1"></i>Asignar
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
                                            <p class="text-muted mb-0">No hay docentes pendientes por asignar</p>
                                            <small class="text-muted">Los nuevos registros aparecerán aquí</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tab Docentes Asignados -->
                                <div class="tab-pane fade" id="asignadas" role="tabpanel">
                                    <?php if (!empty($docentes) && count(array_filter($docentes, function($d){ return $d->asignado != "No" && $d->asignado != null; })) > 0): ?>
                                        <div class="table-responsive">
                                            <table id="tabla_organizaciones_docentes_asignadas" class="table table-hover table-striped" width="100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="border-0">Organización</th>
                                                        <th class="border-0">NIT Org</th>
                                                        <th class="border-0">Cédula Docente</th>
                                                        <th class="border-0">Nombre</th>
                                                        <th class="border-0">Apellido</th>
                                                        <th class="border-0">Horas de Capacitación</th>
                                                        <th class="border-0">Aprobado</th>
                                                        <th class="border-0">Asignado</th>
                                                        <th class="border-0">Observaciones</th>
                                                        <th class="border-0">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                    <?php for ($i = 0; $i < count($docentes); $i++): ?>
                                                        <?php if ($docentes[$i]->asignado != "No" && $docentes[$i]->asignado != NULL): ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="text-truncate d-block" style="max-width: 260px;" title="<?= htmlspecialchars($docentes[$i]->nombreOrganizacion) ?>">
                                                                        <?= strlen($docentes[$i]->nombreOrganizacion) > 100 ? substr($docentes[$i]->nombreOrganizacion, 0, 100) . '...' : $docentes[$i]->nombreOrganizacion ?>
                                                                    </div>
                                                                </td>
                                                                <td><?= $docentes[$i]->numNIT ?></td>
                                                                <td><?= $docentes[$i]->numCedulaCiudadaniaDocente ?></td>
                                                                <td><?= $docentes[$i]->primerNombreDocente ?></td>
                                                                <td><?= $docentes[$i]->primerApellidoDocente ?></td>
                                                                <td><?= $docentes[$i]->horaCapacitacion ?></td>
                                                                <td>
                                                                    <span class="badge <?= $docentes[$i]->valido == '1' ? 'badge-success' : 'badge-secondary' ?>">
                                                                        <?= $docentes[$i]->valido == '1' ? 'Sí' : 'No' ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= $docentes[$i]->asignado ?></td>
                                                                <td>
                                                                    <div class="text-truncate d-block" style="max-width: 260px;" title="<?= htmlspecialchars($docentes[$i]->observacion) ?>">
                                                                        <?= strlen($docentes[$i]->observacion) > 50 ? substr($docentes[$i]->observacion, 0, 50) . '...' : $docentes[$i]->observacion ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm"
                                                                            id="verModalAsignarDocente"
                                                                            data-id="<?= $docentes[$i]->id_docente ?>"
                                                                            data-docente="<?= $docentes[$i]->numCedulaCiudadaniaDocente ?>"
                                                                            data-nombre="<?= $docentes[$i]->primerNombreDocente ?>"
                                                                            data-apellido="<?= $docentes[$i]->primerApellidoDocente ?>"
                                                                            data-toggle="modal"
                                                                            data-target="#asignarDocente">
                                                                        <i class="mdi mdi-account-switch mr-1"></i>Reasignar
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <div class="icon-circle bg-info-light mx-auto mb-3" style="width: 60px; height: 60px;">
                                                <i class="mdi mdi-information text-info" style="font-size: 2rem;"></i>
                                            </div>
                                            <h5 class="font-weight-medium text-muted mb-2">Sin docentes asignados</h5>
                                            <p class="text-muted mb-0">No hay docentes asignados actualmente</p>
                                            <small class="text-muted">Los docentes asignados aparecerán aquí</small>
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
    <!-- Modol Asignar Evaluador a Docente -->
    <div class="modal fade" id="asignarDocente" tabindex="-1" role="dialog" aria-labelledby="ariaAsignar">
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
                                        <i class="mdi mdi-information-outline mr-1"></i>Información del Docente
                                    </h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">ID Docente:</small>
                                            <p class="mb-1 font-weight-medium" id="idDocente">-</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Cédula:</small>
                                            <p class="mb-1 font-weight-medium" id="cedulaDocente">-</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Nombre:</small>
                                        <p class="mb-1 font-weight-medium" id="nombreDocente">-</p>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Apellido:</small>
                                        <p class="mb-0 font-weight-medium" id="apellidoDocente">-</p>
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
                            <li>Se enviará un correo electrónico al evaluador con la información del docente</li>
                            <li>Solo el evaluador asignado podrá acceder a revisar esta evaluación</li>
                            <li>El estado del docente cambiará a "Asignado"</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close mr-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-success" id="asignarDocenteEvaluador">
                        <i class="mdi mdi-check mr-1"></i>Confirmar Asignación
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
			'#tabla_organizaciones_docentes_asignadas',
			'Tabla de organizaciones con docentes asignadas',
			'tabla_organizaciones_docentes_asignadas'
		);
		// Inicializar tabla simple de usuarios
		DataTableConfig.initSimpleTable(
			'#tabla_organizaciones_docentes_sin_asignar',
			'Tabla de organizaciones con docentes sin asignar',
			'tabla_organizaciones_docentes_sin_asignar'
		);
	});
</script>
