<?php
/***
 * @var $nivel
 */

// Función para verificar permisos basada en la lógica del sistema
function canAccessOperaciones($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-settings text-primary mr-2"></i>
                            Opciones del Sistema
                        </h4>
                        <p class="text-muted mb-0 small">Configuración y administración general del sistema</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="<?php echo base_url('admin/panel'); ?>" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left mr-2"></i>Volver al panel principal
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Configuración de Usuario - Todos los niveles -->
        <?php if (canAccessOperaciones([0,1,2,3,4,5,6,7], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-account-settings mr-2 text-info"></i>Configuración de Usuario
                        </h5>
                        <div class="row">
                            <!-- Notificaciones - Todos los niveles -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Notificaciones">
                                    <div class="card shadow-sm h-100 border-left-info">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-bell"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Notificaciones</h6>
                                                    <p class="text-muted mb-0 small">Ver notificaciones del sistema</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Cambio de contraseña - Todos los niveles -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/cambiar-contrasena'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-warning">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-lock-reset"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Cambio de contraseña</h6>
                                                    <p class="text-muted mb-0 small">Actualizar credenciales</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Registro de actividad - Todos los niveles -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Registro de Actividad">
                                    <div class="card shadow-sm h-100 border-left-primary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-history"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Registro de actividad</h6>
                                                    <p class="text-muted mb-0 small">Historial de acciones</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Configuración del Sistema - Solo niveles administrativos superiores -->
        <?php if (canAccessOperaciones([0,1,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-cog mr-2 text-success"></i>Configuración del Sistema
                        </h5>
                        <div class="row">
                            <!-- Opciones del sistema - Solo niveles 0,1,6 -->
							<?php if (canAccessOperaciones([0], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/opciones-sistema'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-success">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-settings"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Opciones del sistema</h6>
                                                    <p class="text-muted mb-0 small">Configuración general</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
							<?php endif; ?>
                            <!-- Tipos de cursos - Solo niveles 0,1,6 -->
                           <!--  <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/tipos-cursos'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-info">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-school"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Tipos de cursos</h6>
                                                    <p class="text-muted mb-0 small">Gestión de categorías</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> -->
                            <!-- NIT de entidades - Solo niveles 0,1,6 -->
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/nit-entidades'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-dark">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-dark text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-domain"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">NIT de entidades acreditadas</h6>
                                                    <p class="text-muted mb-0 small">Registro de entidades</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Herramientas y Reportes - Niveles con permisos específicos -->
        <?php if (canAccessOperaciones([0,1,2,4,5,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-tools mr-2 text-warning"></i>Herramientas y Reportes
                        </h5>
                        <div class="row">
                            <!-- Batería de observaciones - Niveles 0,1,2,4,5,6 -->
                            <?php if (canAccessOperaciones([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/bateria-observaciones'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-warning">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-table-edit"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Batería de observaciones</h6>
                                                    <p class="text-muted mb-0 small">Gestión de observaciones</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                            <!-- Resultados de encuestas - Solo niveles 0,1,6 -->
                            <?php if (canAccessOperaciones([0,1,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Resultados de Encuestas">
                                    <div class="card shadow-sm h-100 border-left-success">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-chart-bar"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Resultados de encuestas</h6>
                                                    <p class="text-muted mb-0 small">Encuestas de satisfacción</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                            <!-- Modal de información - Solo niveles 0,1,6 -->
                            <?php if (canAccessOperaciones([0,1,6], $nivel)): ?>
                            <!-- <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/operaciones/modal-informacion'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-primary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-information"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Modal de información</h6>
                                                    <p class="text-muted mb-0 small">Configurar mensajes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
</script>
