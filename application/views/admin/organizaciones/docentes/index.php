<?php
/***
 * @var $nivel
 */

// Función para verificar permisos basada en la lógica del sistema
function canAccessDocentes($required_levels, $user_level) {
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
                            <i class="mdi mdi-account-tie text-primary mr-2"></i>
                            Gestión de Docentes
                        </h4>
                        <p class="text-muted mb-0 small">Administración y seguimiento de facilitadores del sistema</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="<?php echo base_url('admin/panel'); ?>" class="btn btn-outline-secondary">
                            <i class="mdi mdi-arrow-left mr-2"></i>Volver al panel principal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estados de Docentes - Niveles con permisos de gestión de docentes -->
        <?php if (canAccessDocentes([0,1,2,4,5,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-account-group mr-2 text-info"></i>Estados de Docentes
                        </h5>
                        <div class="row">
                            <!-- Docentes Inscritos - Todos los niveles con acceso -->
                            <?php if (canAccessDocentes([0,1,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/docentes/inscritos'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-success">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-account-check"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Docentes Inscritos</h6>
                                                    <p class="text-muted mb-0 small">Facilitadores registrados en el sistema</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Docentes Por Asignar - Solo niveles administrativos -->
                            <?php if (canAccessDocentes([0,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/docentes/asignar'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-warning">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-warning text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-account-clock"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">Por Asignar</h6>
                                                    <p class="text-muted mb-0 small">Docentes pendientes de asignación</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <!-- Docentes En Evaluación - Niveles con permisos de evaluación -->
                            <?php if (canAccessDocentes([0,1,2,4,5,6], $nivel)): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <a href="<?php echo base_url('admin/docentes/evaluar'); ?>" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 border-left-info">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                                    <i class="mdi mdi-account-search"></i>
                                                </div>
                                                <div>
                                                    <h6 class="font-weight-medium mb-1">En Evaluación</h6>
                                                    <p class="text-muted mb-0 small">Docentes en proceso de evaluación</p>
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

        <!-- Estadísticas Rápidas - Solo para niveles con acceso a estadísticas -->
        <?php if (canAccessDocentes([0,1,2,4,5,6], $nivel)): ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="mdi mdi-chart-line mr-2 text-primary"></i>Resumen General
                        </h5>
                        <div class="row">
                            <!-- Total de Docentes -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-primary text-white shadow-sm h-100">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="mdi mdi-account-multiple" style="font-size: 2rem;"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-weight-bold mb-0" id="total-docentes">-</h4>
                                                <p class="mb-0 small">Total Docentes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Docentes Activos -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-success text-white shadow-sm h-100">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="mdi mdi-account-check" style="font-size: 2rem;"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-weight-bold mb-0" id="docentes-activos">-</h4>
                                                <p class="mb-0 small">Activos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pendientes de Asignación -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-warning text-white shadow-sm h-100">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="mdi mdi-account-clock" style="font-size: 2rem;"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-weight-bold mb-0" id="docentes-pendientes">-</h4>
                                                <p class="mb-0 small">Por Asignar</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- En Evaluación -->
                            <div class="col-md-3 mb-3">
                                <div class="card bg-info text-white shadow-sm h-100">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="mdi mdi-account-search" style="font-size: 2rem;"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-weight-bold mb-0" id="docentes-evaluacion">-</h4>
                                                <p class="mb-0 small">En Evaluación</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>

<style>
.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.border-left-success {
    border-left: 4px solid #28a745 !important;
}

.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}

.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}

.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}
</style>

<script>
$(document).ready(function() {
    // Cargar estadísticas de docentes
    cargarEstadisticasDocentes();
});

function cargarEstadisticasDocentes() {
    // Aquí puedes hacer una llamada AJAX para obtener las estadísticas reales
    // Por ahora, simulamos los datos
    
    // Ejemplo de implementación:
    /*
    $.ajax({
        url: baseURL + 'admin/docentes/estadisticas',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#total-docentes').text(response.total || 0);
            $('#docentes-activos').text(response.activos || 0);
            $('#docentes-pendientes').text(response.pendientes || 0);
            $('#docentes-evaluacion').text(response.evaluacion || 0);
        },
        error: function() {
            console.log('Error al cargar estadísticas de docentes');
        }
    });
    */
    
    // Datos de ejemplo (reemplazar con llamada AJAX real)
    $('#total-docentes').text('0');
    $('#docentes-activos').text('0');
    $('#docentes-pendientes').text('0');
    $('#docentes-evaluacion').text('0');
}
</script>
