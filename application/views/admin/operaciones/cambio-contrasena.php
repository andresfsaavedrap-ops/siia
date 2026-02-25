<script src="<?= base_url('assets/js/functions/admin/operaciones/opciones.js?v=1.5.1') . time() ?>" type="module"></script>
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-lock-reset text-primary mr-2"></i>
                            Cambiar Contraseña
                        </h4>
                        <p class="text-muted mb-0 small">Actualización segura de credenciales de acceso</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3 mr-3">
                                <i class="mdi mdi-shield-key text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white font-weight-bold">Actualizar Contraseña</h5>
                                <p class="mb-0 text-white-50 small">Modifica tus credenciales de acceso de forma segura</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <!-- Información de seguridad -->
                        <div class="alert alert-info border-left-info mb-4" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-shield-check text-info fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <h6 class="alert-heading font-weight-bold">Política de Seguridad</h6>
                                    <ul class="mb-2 small">
                                        <li>La contraseña debe tener al menos 8 caracteres</li>
                                        <li>Se recomienda usar una combinación de letras, números y símbolos</li>
                                        <li>Evita usar información personal fácil de adivinar</li>
                                        <li>Tu sesión se cerrará automáticamente después del cambio</li>
                                    </ul>
                                    <hr class="my-2">
                                    <small class="text-muted">
                                        <i class="mdi mdi-help-circle mr-1"></i>
                                        ¿Necesitas ayuda? Contacta con la 
                                        <a href="#" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Mesa de Ayuda" class="text-info font-weight-medium">Mesa de Ayuda</a>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de cambio de contraseña -->
                        <form id="formCambioContrasena" class="needs-validation" novalidate>
                            <div class="row">
                                <!-- Contraseña actual -->
                                <div class="col-md-12 mb-4">
                                    <label for="contrasenaActual" class="form-label font-weight-medium">
                                        <i class="mdi mdi-lock-outline mr-2 text-warning"></i>Contraseña Actual
                                    </label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">
                                                <i class="mdi mdi-key-variant text-warning"></i>
                                            </span>
                                        </div>
                                        <input type="password" 
                                               id="contrasenaActual" 
                                               name="contrasenaActual"
                                               class="form-control form-control-lg" 
                                               placeholder="Ingrese su contraseña actual..."
                                               required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                                <i class="mdi mdi-eye" id="eyeIconCurrent"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" style="margin-top: -8px;">
                                        Por favor, ingrese su contraseña actual.
                                    </div>
                                </div>

                                <!-- Nueva contraseña -->
                                <div class="col-md-6 mb-4">
                                    <label for="nuevaContrasena" class="form-label font-weight-medium">
                                        <i class="mdi mdi-lock mr-2 text-success"></i>Nueva Contraseña
                                    </label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">
                                                <i class="mdi mdi-key text-success"></i>
                                            </span>
                                        </div>
                                        <input type="password" 
                                               id="nuevaContrasena" 
                                               name="nuevaContrasena"
                                               class="form-control form-control-lg" 
                                               placeholder="Ingrese la nueva contraseña..."
                                               minlength="8"
                                               required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                                <i class="mdi mdi-eye" id="eyeIconNew"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" style="margin-top: -8px;">
                                        La contraseña debe tener al menos 8 caracteres.
                                    </div>
                                    <!-- Indicador de fortaleza -->
                                    <div class="mt-2">
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-muted" id="strengthText">Ingrese una contraseña</small>
                                    </div>
                                </div>

                                <!-- Confirmar nueva contraseña -->
                                <div class="col-md-6 mb-4">
                                    <label for="confirmarContrasena" class="form-label font-weight-medium">
                                        <i class="mdi mdi-lock-check mr-2 text-info"></i>Confirmar Nueva Contraseña
                                    </label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">
                                                <i class="mdi mdi-key-plus text-info"></i>
                                            </span>
                                        </div>
                                        <input type="password" 
                                               id="confirmarContrasena" 
                                               name="confirmarContrasena"
                                               class="form-control form-control-lg" 
                                               placeholder="Confirme la nueva contraseña..."
                                               required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="mdi mdi-eye" id="eyeIconConfirm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" style="margin-top: -8px;">
                                        Las contraseñas no coinciden.
                                    </div>
                                    <!-- Indicador de coincidencia -->
                                    <div class="mt-2" id="matchIndicator" style="display: none;">
                                        <small class="text-success">
                                            <i class="mdi mdi-check-circle mr-1"></i>Las contraseñas coinciden
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="<?php echo base_url('admin/operaciones'); ?>" class="btn btn-outline-secondary btn-md">
                                            <i class="mdi mdi-arrow-left mr-2"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-md px-5" id="guardarContrasenaAdmin">
                                            <i class="mdi mdi-content-save mr-2"></i>Actualizar Contraseña
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
