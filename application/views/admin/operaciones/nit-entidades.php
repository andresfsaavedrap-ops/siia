<?php
/***
 * @var $nits
 * @var $organizaciones
 * @var $nivel
 */
// Función para verificar permisos de acceso a NIT de entidades
function canAccessNitEntidades($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<script src="<?= base_url('assets/js/functions/admin/operaciones/nits.js?v=1.5.1') . time() ?>" type="module"></script>
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-domain text-primary mr-2"></i>
                            NIT de Entidades Acreditadas
                        </h3>
                        <p class="text-muted mb-0">Gestión de organizaciones con acreditación previa</p>
                    </div>
                    <a href="<?= base_url('admin/operaciones') ?>" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left mr-2"></i>
                        Volver a Operaciones
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario de Registro -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="text-white">
                            <i class="mdi mdi-plus-circle mr-2 text-white"></i>
                            Registrar Nueva Organización Acreditada
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="mdi mdi-information mr-2"></i>
                            <strong>Información:</strong> Registre los NIT de organizaciones que ya están acreditadas.
                            Al hacer el registro quedarán automáticamente con estado "Acreditado".
                        </div>
                        <form id="formNitEntidades">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nit_acre_org" class="font-weight-medium">
                                            <i class="mdi mdi-card-account-details mr-1"></i>
                                            NIT de la Organización
                                        </label>
                                        <select name="nit_acre_org" id="nit_acre_org" class="form-control selectpicker show-tick nit_acre_org" data-live-search="true">
                                            <option value="">Seleccione una organización</option>
                                            <?php foreach ($organizaciones as $organizacion) : ?>
                                                <option value="<?= $organizacion->numNIT ?>">
                                                    <?= $organizacion->numNIT ?> | <?= $organizacion->sigla ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre_acre_org" class="font-weight-medium">
                                            <i class="mdi mdi-office-building mr-1"></i>
                                            Nombre de la Organización
                                        </label>
                                        <input type="text" class="form-control" id="nombre_acre_org" disabled
                                               placeholder="Se completará automáticamente">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="res_acre_org" class="font-weight-medium">
                                            <i class="mdi mdi-file-document mr-1"></i>
                                            Número de Resolución
                                        </label>
                                        <select name="res_acre_org" id="res_acre_org" class="form-control" disabled>
                                            <option value="">Seleccione una resolución</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fech_fin_acre_org" class="font-weight-medium">
                                            <i class="mdi mdi-calendar mr-1"></i>
                                            Fecha de Finalización
                                        </label>
                                        <input type="date" class="form-control" id="fech_fin_acre_org" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary btn-md" id="guardar_nit_org_acre">
                                    <i class="mdi mdi-content-save mr-2"></i>
                                    Guardar Registro
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Organizaciones Acreditadas -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="mdi mdi-table-large text-primary mr-2"></i>
                                Organizaciones Acreditadas Registradas
                            </h5>
                            <div class="badge badge-primary badge-pill">
                                <?= count($nits) ?> registros
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (count($nits) > 0): ?>
                            <div class="table-responsive">
                                <table id="tabla_nit_entidades" class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">
                                                <i class="mdi mdi-card-account-details mr-1"></i>
                                                NIT
                                            </th>
                                            <th class="border-0">
                                                <i class="mdi mdi-office-building mr-1"></i>
                                                Organización
                                            </th>
                                            <th class="border-0">
                                                <i class="mdi mdi-file-document mr-1"></i>
                                                Resolución
                                            </th>
                                            <th class="border-0">
                                                <i class="mdi mdi-calendar mr-1"></i>
                                                Fecha Finalización
                                            </th>
                                            <th class="border-0 text-center">
                                                <i class="mdi mdi-cog mr-1"></i>
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($nits as $nit): ?>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-medium text-primary">
                                                        <?= $nit['numNIT'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;" title="<?= $nit['nombreOrganizacion'] ?>">
                                                        <?= $nit['nombreOrganizacion'] ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?= $nit['numeroResolucion'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        <?= date('d/m/Y', strtotime($nit['fechaFinalizacion'])) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-danger btn-sm eliminarNitAcreOrg"
                                                            data-id-nit="<?= $nit['idnits_db'] ?>"
                                                            title="Eliminar registro">
                                                        <i class="mdi mdi-delete ml-2"></i> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="mdi mdi-database-off text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="text-muted">No hay organizaciones acreditadas registradas</h6>
                                <p class="text-muted small">
                                    Utilice el formulario superior para registrar la primera organización acreditada.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
	$(document).ready(function() {
		// Inicializar tabla simple de organizaciones
		DataTableConfig.initSimpleTable(
			'#tabla_nit_entidades',
			'NITS Entidades',
			'tabla_nit_entidades'
		);
	});
</script>
