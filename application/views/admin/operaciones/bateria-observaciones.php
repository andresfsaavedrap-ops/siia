<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-clipboard-text text-primary mr-2"></i>
                            Batería de Observaciones
                        </h4>
                        <p class="text-muted mb-0 small">Gestión de observaciones del sistema</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary mr-2" data-toggle='modal' data-target='#modalBateriaObservaciones'>
                            <i class="mdi mdi-plus mr-2"></i>Crear nueva observación
                        </button>
                        <a href="<?php echo base_url('admin/operaciones'); ?>" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left mr-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-format-list-bulleted mr-2 text-info"></i>
                            Lista de Observaciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla_bateriaObs" class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">
                                            <i class="mdi mdi-pound mr-1"></i>ID
                                        </th>
                                        <th>
                                            <i class="mdi mdi-tag mr-1"></i>Tipo
                                        </th>
                                        <th>
                                            <i class="mdi mdi-format-title mr-1"></i>Título
                                        </th>
                                        <th>
                                            <i class="mdi mdi-text mr-1"></i>Observación
                                        </th>
                                        <th class="text-center" style="width: 200px;">
                                            <i class="mdi mdi-cog mr-1"></i>Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bateria as $observacion): ?>
                                    <tr>
                                        <td class="text-center font-weight-medium">
                                            <span class="badge badge-light"><?= $observacion->id_bateriaObservaciones ?></span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><?= $observacion->tipo ?></span>
                                        </td>
                                        <td class="font-weight-medium">
                                            <?= $observacion->titulo ?>
                                        </td>
                                        <td class="text-muted">
                                            <?= strlen($observacion->observacion) > 100 ?
                                                substr($observacion->observacion, 0, 100) . '...' :
                                                $observacion->observacion ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary editarBateriaObservacion"
                                                        data-toggle='modal'
                                                        data-target='#modalBateriaObservaciones'
                                                        data-id='<?= $observacion->id_bateriaObservaciones ?>'
                                                        title="Editar observación">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger eliminarObservacion"
                                                        data-id='<?= $observacion->id_bateriaObservaciones ?>'
                                                        title="Eliminar observación">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (empty($bateria)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="mdi mdi-clipboard-text-outline text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-muted">No hay observaciones registradas</h5>
                            <p class="text-muted mb-3">Comienza creando tu primera observación</p>
                            <button class="btn btn-primary" data-toggle='modal' data-target='#modalBateriaObservaciones'>
                                <i class="mdi mdi-plus mr-2"></i>Crear primera observación
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
