<?php
/***
 * @var $nivel
 */

// Función para verificar permisos (igual que en el menú)
function canAccessCard($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
?>
<!-- Panel Principal con Tarjetas de Menú -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-view-dashboard mr-2 text-primary"></i>Panel de Administración
                </h4>
                <div class="row">
					<!-- Tarjeta Reportes - Niveles: 0,1,2,4,5 -->
                    <?php if (canAccessCard([0,1,2,6,8,9,10], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/reportes') ?>" class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-info text-white rounded-circle p-3 mr-3">
                                            <i class="icon-folder"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Reportes</h5>
                                            <p class="text-muted mb-0 small">Telefónico y estadísticas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					<?php endif; ?>
					<!-- Tarjeta Tramite - Niveles 0,5 -->
                    <?php if (canAccessCard([0,1,2,3,6,5], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/tramite') ?>"  class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-dark">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-dark text-white rounded-circle p-3 mr-3">
                                            <i class="ti-clipboard"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Tramite</h5>
                                            <p class="text-muted mb-0 small">Tramite de solicitud</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Organizaciones - Todos excepto nivel 7 -->
                    <?php if (canAccessCard([0,1,6,8,9,10], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/organizaciones') ?>" class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-success text-white rounded-circle p-3 mr-3">
                                            <i class="ti-home"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Organizaciones</h5>
                                            <p class="text-muted mb-0 small">Gestión de organizaciones</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
					<!-- Tarjeta Docentes - Todos -->
                    <?php if (canAccessCard([0,1,6,7,8,9,10], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/docentes') ?>" class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
                                            <i class="ti-user"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Docentes</h5>
                                            <p class="text-muted mb-0 small">Gestión de docentes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Histórico - Niveles 0,4,5 -->
                    <?php if (canAccessCard([0,1,4,5,6], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Históricos">
                            <div class="card shadow-sm h-100 border-left-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-secondary text-white rounded-circle p-3 mr-3">
                                            <i class="ti-time"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Histórico</h5>
                                            <p class="text-muted mb-0 small">Registros históricos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Seguimientos - Niveles 0,5 -->
                    <?php if (canAccessCard([0,1,5,6], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Seguimientos">
                            <div class="card shadow-sm h-100 border-left-dark">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-dark text-white rounded-circle p-3 mr-3">
                                            <i class="ti-thumb-up"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Seguimientos</h5>
                                            <p class="text-muted mb-0 small">Control de seguimientos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Resoluciones del Sistema - Solo nivel 0 -->
                    <?php if (canAccessCard([0, 1, 6], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/operaciones') ?>" class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-orange">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-orange text-white rounded-circle p-3 mr-3">
                                            <i class="ti-settings"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Operaciones</h5>
                                            <p class="text-muted mb-0 small">Operaciones del sistema</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Operaciones del Sistema - Solo nivel 0 -->
                    <?php if (canAccessCard([0, 1, 6], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Datos Abiertos">
                            <div class="card shadow-sm h-100 border-left-danger">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-danger text-white rounded-circle p-3 mr-3">
                                            <i class="ti-upload"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Datos Abiertos</h5>
                                            <p class="text-muted mb-0 small">Gestion de datos abiertos</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <!-- Tarjeta Contacto - Solo nivel 0 -->
                    <?php if (canAccessCard([0,1,6], $nivel)): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="<?= base_url('admin/contacto') ?>" class="text-decoration-none">
                            <div class="card shadow-sm h-100 border-left-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-primary text-white rounded-circle p-3 mr-3">
                                            <i class="ti-email"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-medium mb-1">Contacto</h5>
                                            <p class="text-muted mb-0 small">Gestión de contactos</p>
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
<!-- Script para manejar el modal dinámico -->
<script>
$(document).ready(function() {
    // Manejar el clic en las funcionalidades próximamente
    $('[data-target="#modalProximamente"]').on('click', function(e) {
        e.preventDefault();
        var funcionalidad = $(this).data('funcionalidad');
        $('#nombreFuncionalidad').text(funcionalidad);
    });
});
</script>
