<?php
/***
 * @var $nivel
 */

// Función para verificar permisos basada en la lógica del sistema
function canAccessReportes($required_levels, $user_level) {
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
                            <i class="mdi mdi-chart-box text-primary mr-2"></i>
                            Centro de Reportes
                        </h4>
                        <p class="text-muted mb-0 small">Análisis y reportes del sistema SIIA</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="<?php echo base_url('admin/panel'); ?>" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left mr-2"></i>Volver al panel principal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reportes de Organizaciones - Solo para niveles administrativos -->
        <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-domain mr-2 text-info"></i>Reportes de Organizaciones
                        </h5>
                        <div class="row">
                            <!-- Organizaciones Acreditadas -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/reportes/organizaciones-acreditadas'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-info">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-certificate"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Organizaciones Acreditadas</h6>
                                                    <p class="text-muted mb-0 small">Listado de organizaciones certificadas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Solicitudes de Acreditación -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <!-- <a href="<?php echo base_url('admin/reportes/solicitudes-acreditacion'); ?>" class="text-decoration-none"> -->
								<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Solicitudes de Acreditación">
                                    <div class="card shadow-sm h-100 border-left-warning">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-file-document-outline"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Solicitudes de Acreditación</h6>
                                                    <p class="text-muted mb-0 small">Registro de solicitudes pendientes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Histórico de Organizaciones -->
                            <?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <!-- <a href="<?php echo base_url('admin/reportes/historico-organizaciones'); ?>" class="text-decoration-none"> -->
								<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Histórico de Organizaciones">
                                    <div class="card shadow-sm h-100 border-left-primary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-history"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Histórico de Organizaciones</h6>
                                                    <p class="text-muted mb-0 small">Historial completo de organizaciones</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Reportes Académicos - Acceso según nivel -->
        <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-school mr-2 text-success"></i>Reportes Académicos
                        </h5>
                        <div class="row">
                            <!-- Actividades Pedagógicas -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/reportes/actividades-pedagogicas'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-success">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-book-open-page-variant"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Actividades Pedagógicas</h6>
                                                    <p class="text-muted mb-0 small">Informe de actividades realizadas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Todos los Asistentes -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
								<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Todos los Asistentes">
                                <!-- <a href="<?php echo base_url('admin/reportes/todos-asistentes'); ?>" class="text-decoration-none"> -->
                                    <div class="card shadow-sm h-100 border-left-dark">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-dark text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-account-group"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Todos los Asistentes</h6>
                                                    <p class="text-muted mb-0 small">Listado completo de participantes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Docentes Habilitados -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
								<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Docentes Habilitados">
                                <!-- <a href="<?php echo base_url('admin/reportes/docentes-habilitados'); ?>" class="text-decoration-none"> -->
                                    <div class="card shadow-sm h-100 border-left-secondary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-secondary text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-account-tie"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Docentes Habilitados</h6>
                                                    <p class="text-muted mb-0 small">Registro de docentes certificados</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Reportes Administrativos - Solo para administradores y coordinadores -->
        <?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-file-chart mr-2 text-danger"></i>Reportes Administrativos
                        </h5>
                        <div class="row">
                            <!-- Registros Telefónicos -->
                            <?php if (canAccessReportes([0,1,2,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/reportes/registros-telefonicos'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-danger">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-danger text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-phone"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Registros Telefónicos</h6>
                                                    <p class="text-muted mb-0 small">Historial de comunicaciones</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Ver Reportes Generales -->
                            <?php if (canAccessReportes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
								<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Ver Reportes Generales">
								<!-- <a href="<?php echo base_url('admin/reportes/registros-telefonicos'); ?>" class="text-decoration-none"> -->
                                <div class="card shadow-sm h-100 border-left-info">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                                <i class="mdi mdi-chart-areaspline"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-medium mb-1">Ver Reportes Generales</h6>
                                                <p class="text-muted mb-0 small">Dashboard de estadísticas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
