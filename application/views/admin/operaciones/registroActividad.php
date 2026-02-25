<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-history text-primary mr-2"></i>
                            Registro de Actividad
                        </h4>
                        <p class="text-muted mb-0 small">Monitoreo de acciones realizadas en el sistema</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/panel'); ?>">Panel</a>
                            </li>
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/operaciones'); ?>">Operaciones</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Registro de Actividad</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-white-75 small">Total de Actividades</div>
                                <div class="h5 mb-0 font-weight-bold text-white"><?php echo count($actividad_admin); ?></div>
                            </div>
                            <div class="text-white-25">
                                <i class="mdi mdi-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-white-75 small">Actividades Hoy</div>
                                <div class="h5 mb-0 font-weight-bold text-white">
                                    <?php 
                                    $hoy = date('Y-m-d');
                                    $actividadesHoy = 0;
                                    foreach($actividad_admin as $row) {
                                        if (strpos($row->fecha, $hoy) !== false) {
                                            $actividadesHoy++;
                                        }
                                    }
                                    echo $actividadesHoy;
                                    ?>
                                </div>
                            </div>
                            <div class="text-white-25">
                                <i class="mdi mdi-calendar-today fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-white-75 small">IPs Únicas</div>
                                <div class="h5 mb-0 font-weight-bold text-white">
                                    <?php 
                                    $ips_unicas = array_unique(array_column($actividad_admin, 'usuario_ip'));
                                    echo count($ips_unicas);
                                    ?>
                                </div>
                            </div>
                            <div class="text-white-25">
                                <i class="mdi mdi-ip-network fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-warning text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-white-75 small">Última Actividad</div>
                                <div class="h6 mb-0 font-weight-bold text-white">
                                    <?php 
                                    if (!empty($actividad_admin)) {
                                        $ultima = $actividad_admin[0]->fecha;
                                        echo date('H:i', strtotime($ultima));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="text-white-25">
                                <i class="mdi mdi-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de actividades -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-format-list-bulleted mr-2 text-info"></i>
                                Historial de Actividades
                            </h5>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-outline-primary btn-sm mr-2" id="exportarActividad">
                                    <i class="mdi mdi-download mr-1"></i>Exportar
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" id="actualizarActividad">
                                    <i class="mdi mdi-refresh mr-1"></i>Actualizar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($actividad_admin)): ?>
                            <div class="table-responsive">
                                <table id="tabla_actividad_admin" class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%" class="text-center">
                                                <i class="mdi mdi-pound"></i>
                                            </th>
                                            <th width="35%">
                                                <i class="mdi mdi-cog mr-1"></i>Actividad
                                            </th>
                                            <th width="20%">
                                                <i class="mdi mdi-calendar-clock mr-1"></i>Fecha y Hora
                                            </th>
                                            <th width="15%">
                                                <i class="mdi mdi-ip-network mr-1"></i>Dirección IP
                                            </th>
                                            <th width="25%">
                                                <i class="mdi mdi-web mr-1"></i>Navegador
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($actividad_admin as $index => $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge badge-light"><?php echo $index + 1; ?></span>
                                            </td>
                                            <td>
                                                <div class="activity-item">
                                                    <i class="mdi mdi-play-circle text-success mr-2"></i>
                                                    <span class="font-weight-medium"><?php echo htmlspecialchars($row->accion); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-time-info">
                                                    <div class="font-weight-medium text-dark">
                                                        <i class="mdi mdi-calendar mr-1 text-primary"></i>
                                                        <?php echo date('d/m/Y', strtotime($row->fecha)); ?>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-clock mr-1"></i>
                                                        <?php echo date('H:i:s', strtotime($row->fecha)); ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="ip-info">
                                                    <span class="badge badge-outline-info">
                                                        <i class="mdi mdi-ip mr-1"></i>
                                                        <?php echo htmlspecialchars($row->usuario_ip); ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="browser-info">
                                                    <small class="text-muted" title="<?php echo htmlspecialchars($row->user_agent); ?>">
                                                        <i class="mdi mdi-web mr-1"></i>
                                                        <?php 
                                                        $user_agent = $row->user_agent;
                                                        if (strpos($user_agent, 'Chrome') !== false) {
                                                            echo '<i class="mdi mdi-google-chrome text-warning"></i> Chrome';
                                                        } elseif (strpos($user_agent, 'Firefox') !== false) {
                                                            echo '<i class="mdi mdi-firefox text-danger"></i> Firefox';
                                                        } elseif (strpos($user_agent, 'Safari') !== false) {
                                                            echo '<i class="mdi mdi-apple-safari text-info"></i> Safari';
                                                        } elseif (strpos($user_agent, 'Edge') !== false) {
                                                            echo '<i class="mdi mdi-microsoft-edge text-primary"></i> Edge';
                                                        } else {
                                                            echo '<i class="mdi mdi-web text-muted"></i> Otro';
                                                        }
                                                        ?>
                                                    </small>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="mdi mdi-history text-muted" style="font-size: 4rem;"></i>
                                </div>
                                <h5 class="text-muted">No hay actividades registradas</h5>
                                <p class="text-muted mb-0">No se encontraron actividades en el registro</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de navegación -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?php echo base_url('admin/operaciones'); ?>" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left mr-2"></i>Volver al Panel de Operaciones
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.activity-item {
    display: flex;
    align-items: center;
}

.date-time-info {
    line-height: 1.3;
}

.ip-info .badge {
    font-size: 0.8rem;
}

.browser-info {
    font-size: 0.9rem;
}

#tabla_actividad_admin {
    font-size: 0.9rem;
}

#tabla_actividad_admin th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

#tabla_actividad_admin td {
    vertical-align: middle;
    border-color: #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.badge-outline-info {
    color: #17a2b8;
    border: 1px solid #17a2b8;
    background-color: transparent;
}
</style>

<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#tabla_actividad_admin').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "responsive": true,
        "pageLength": 25,
        "order": [[2, "desc"]], // Ordenar por fecha descendente
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });

    // Exportar actividad
    $('#exportarActividad').click(function() {
        // Aquí iría la lógica para exportar
        Swal.fire({
            icon: 'info',
            title: 'Exportar Actividad',
            text: 'Funcionalidad de exportación en desarrollo'
        });
    });

    // Actualizar actividad
    $('#actualizarActividad').click(function() {
        location.reload();
    });

    // Inicializar tooltips
    $('[title]').tooltip();
});
</script>

