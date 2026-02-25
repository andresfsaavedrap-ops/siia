<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-bell text-primary mr-2"></i>
                            Historial de Notificaciones
                        </h4>
                        <p class="text-muted mb-0 small">Consulta todas las notificaciones recibidas y enviadas</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/panel'); ?>">Panel</a>
                            </li>
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/operaciones'); ?>">Operaciones</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Notificaciones</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Tabla de notificaciones -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-history mr-2 text-info"></i>
                                Notificaciones Anteriores
                            </h5>
                            <span class="badge badge-info">
                                <?php echo count($mis_notificaciones); ?> notificaciones
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($mis_notificaciones)): ?>
                            <div class="table-responsive">
                                <table id="tabla_notificaciones" class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" width="5%">
                                                <i class="mdi mdi-bell-outline"></i>
                                            </th>
                                            <th width="20%">
                                                <i class="mdi mdi-format-title mr-1"></i>Título
                                            </th>
                                            <th width="30%">
                                                <i class="mdi mdi-text mr-1"></i>Descripción
                                            </th>
                                            <th width="15%">
                                                <i class="mdi mdi-calendar mr-1"></i>Fecha
                                            </th>
                                            <th width="15%">
                                                <i class="mdi mdi-account-arrow-right mr-1"></i>Remitente
                                            </th>
                                            <th width="15%">
                                                <i class="mdi mdi-account-arrow-left mr-1"></i>Destinatario
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($mis_notificaciones as $index => $notificacion): ?>
                                        <tr>
                                            <td class="text-center">
                                                <div class="notification-icon">
                                                    <i class="mdi mdi-bell text-primary"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="notification-title">
                                                    <strong><?php echo htmlspecialchars($notificacion->tituloNotificacion); ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="notification-description">
                                                    <span class="text-muted">
                                                        <?php 
                                                        $descripcion = htmlspecialchars($notificacion->descripcionNotificacion);
                                                        echo strlen($descripcion) > 100 ? substr($descripcion, 0, 100) . '...' : $descripcion;
                                                        ?>
                                                    </span>
                                                    <?php if (strlen($notificacion->descripcionNotificacion) > 100): ?>
                                                        <button class="btn btn-link btn-sm p-0 ml-1" 
                                                                data-toggle="tooltip" 
                                                                title="<?php echo htmlspecialchars($notificacion->descripcionNotificacion); ?>">
                                                            <i class="mdi mdi-information-outline"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="notification-date">
                                                    <i class="mdi mdi-clock-outline mr-1 text-muted"></i>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y H:i', strtotime($notificacion->fechaNotificacion)); ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="notification-sender">
                                                    <i class="mdi mdi-account-circle mr-1 text-success"></i>
                                                    <span class="text-success"><?php echo htmlspecialchars($notificacion->quienEnvia); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="notification-receiver">
                                                    <i class="mdi mdi-account-circle mr-1 text-info"></i>
                                                    <span class="text-info"><?php echo htmlspecialchars($notificacion->quienRecibe); ?></span>
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
                                    <i class="mdi mdi-bell-off-outline text-muted" style="font-size: 4rem;"></i>
                                </div>
                                <h5 class="text-muted">No hay notificaciones</h5>
                                <p class="text-muted mb-0">No se encontraron notificaciones en el historial</p>
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
.notification-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 50%;
}

.notification-title strong {
    color: #495057;
    font-size: 0.95rem;
}

.notification-description {
    font-size: 0.9rem;
    line-height: 1.4;
}

.notification-date small {
    font-size: 0.8rem;
}

.notification-sender,
.notification-receiver {
    font-size: 0.9rem;
}

#tabla_notificaciones {
    font-size: 0.9rem;
}

#tabla_notificaciones th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
}

#tabla_notificaciones td {
    vertical-align: middle;
    border-color: #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>

<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#tabla_notificaciones').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "responsive": true,
        "pageLength": 25,
        "order": [[3, "desc"]], // Ordenar por fecha descendente
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });

    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

