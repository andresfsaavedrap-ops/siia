// Importaciones necesarias
import { toastSimple, mostrarAlerta, procesando, errorControlador, confirmarAccion, errorValidacionFormulario } from '../../partials/alerts-config.js';
import { redirect, reload } from '../../partials/other-funtions-init.js';
import { getBaseURL } from '../../config.js';

// Configurar baseURL
const baseURL = getBaseURL();

// Inicializar validación del formulario cuando el DOM esté listo
$(document).ready(function() {
    // Inicializar validación del formulario
    ValidarFormCambioContrasena();
    // Toggle para mostrar/ocultar contraseña actual
    $('#toggleCurrentPassword').click(function() {
        togglePasswordVisibility('#contrasenaActual', '#eyeIconCurrent');
    });
    // Toggle para mostrar/ocultar nueva contraseña
    $('#toggleNewPassword').click(function() {
        togglePasswordVisibility('#nuevaContrasena', '#eyeIconNew');
    });
    // Toggle para mostrar/ocultar confirmar contraseña
    $('#toggleConfirmPassword').click(function() {
        togglePasswordVisibility('#confirmarContrasena', '#eyeIconConfirm');
    });
    // Validar fortaleza de contraseña en tiempo real
    $('#nuevaContrasena').on('input', function() {
        const password = $(this).val();
        checkPasswordStrength(password);
        checkPasswordMatch();
    });
    // Validar coincidencia de contraseñas
    $('#confirmarContrasena').on('input', function() {
        checkPasswordMatch();
    });

    // Manejar envío del formulario
    $('#formCambioContrasena').on('submit', function(e) {
        e.preventDefault();
        // Validar formulario antes de proceder
        if (!$(this)[0].checkValidity()) {
            $(this).addClass('was-validated');
            errorValidacionFormulario();
            return;
        }
        // Validar que las contraseñas coincidan
        if ($('#nuevaContrasena').val() !== $('#confirmarContrasena').val()) {
            mostrarAlerta('warning', 'Contraseñas no coinciden', 'Las contraseñas nueva y de confirmación deben ser iguales.');
            return;
        }
        // Confirmar cambio de contraseña
        confirmarAccion(
            'Cambiar Contraseña',
            '¿Está seguro de que desea cambiar su contraseña? Su sesión se cerrará automáticamente.',
            'warning'
        ).then((result) => {
            if (result.isConfirmed) {
                cambiarContrasena();
            }
        });
    });
});

/**
 * Función para alternar visibilidad de contraseña
 */
function togglePasswordVisibility(inputSelector, iconSelector) {
    const passwordField = $(inputSelector);
    const eyeIcon = $(iconSelector);

    if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
        eyeIcon.removeClass('mdi-eye').addClass('mdi-eye-off');
    } else {
        passwordField.attr('type', 'password');
        eyeIcon.removeClass('mdi-eye-off').addClass('mdi-eye');
    }
}

/**
 * Función para verificar fortaleza de contraseña
 */
function checkPasswordStrength(password) {
    const strengthBar = $('#passwordStrength');
    const strengthText = $('#strengthText');

    let strength = 0;
    let text = '';
    let color = '';

    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 12.5;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;

    if (strength < 25) {
        text = 'Muy débil';
        color = 'bg-danger';
    } else if (strength < 50) {
        text = 'Débil';
        color = 'bg-warning';
    } else if (strength < 75) {
        text = 'Buena';
        color = 'bg-info';
    } else {
        text = 'Excelente';
        color = 'bg-success';
    }

    strengthBar.removeClass('bg-danger bg-warning bg-info bg-success').addClass(color);
    strengthBar.css('width', strength + '%');
    strengthText.text(text);
}

/**
 * Función para verificar coincidencia de contraseñas
 */
function checkPasswordMatch() {
    const newPassword = $('#nuevaContrasena').val();
    const confirmPassword = $('#confirmarContrasena').val();
    const matchIndicator = $('#matchIndicator');

    if (confirmPassword.length > 0) {
        if (newPassword === confirmPassword) {
            matchIndicator.show().removeClass('text-danger').addClass('text-success');
            matchIndicator.html('<i class="mdi mdi-check-circle mr-1"></i>Las contraseñas coinciden');
        } else {
            matchIndicator.show().removeClass('text-success').addClass('text-danger');
            matchIndicator.html('<i class="mdi mdi-close-circle mr-1"></i>Las contraseñas no coinciden');
        }
    } else {
        matchIndicator.hide();
    }
}

/**
 * Función para cambiar contraseña
 */
function cambiarContrasena() {
    const data = {
        contrasenaActual: $('#contrasenaActual').val(),
        nuevaContrasena: $('#nuevaContrasena').val(),
        confirmarContrasena: $('#confirmarContrasena').val()
    };
    $.ajax({
        url: baseURL + "Operaciones/cambiarContrasenaAdmin",
        type: "post",
        dataType: "JSON",
        data: data,
        beforeSend: function() {
            $('#guardarContrasenaAdmin').prop('disabled', true);
            $('#guardarContrasenaAdmin').html('<i class="mdi mdi-loading mdi-spin mr-2"></i>Cambiando contraseña...');
            toastSimple("info", "Procesando cambio de contraseña...");
        },
        success: function(response) {
            if (response.success) {
                mostrarAlerta('success', 'Contraseña actualizada', 
                    'Su contraseña ha sido cambiada exitosamente. La sesión se cerrará en 3 segundos.')
                .then(() => {
                    // Cerrar sesión automáticamente
                    $.ajax({
						url: baseURL + "sesion/logoutAdmin",
						type: "post",
						dataType: "JSON",
						beforeSend: function () {
							toastSimple("info", "Cerrando sesión");
						},
						success: function (response) {
							redirect(response.url);
						},
					});
                });
            } else {
                mostrarAlerta('error', 'Error al cambiar contraseña', response.msg || 'Ocurrió un error inesperado');
            }
        },
        error: function(ev) {
            errorControlador(ev);
        },
        complete: function() {
            $('#guardarContrasenaAdmin').prop('disabled', false);
            $('#guardarContrasenaAdmin').html('<i class="mdi mdi-content-save mr-2"></i>Actualizar Contraseña');
        }
    });
}

/**
 * Validar formulario de cambio de contraseña
 */
function ValidarFormCambioContrasena() {
    $("form[id='formCambioContrasena']").validate({
        errorElement: "div",
        errorClass: "invalid-feedback",
        errorPlacement: function(error, element) {
            // Para campos dentro de input-group, colocar el error después del contenedor padre
            if (element.closest(".input-group").length) {
                error.insertAfter(element.closest(".col-md-12, .col-md-6"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },
        rules: {
            contrasenaActual: {
                required: true,
                minlength: 1
            },
            nuevaContrasena: {
                required: true,
                minlength: 8
            },
            confirmarContrasena: {
                required: true,
                minlength: 8,
                equalTo: "#nuevaContrasena"
            }
        },
        messages: {
            contrasenaActual: {
                required: "<p class='forms-error'>Por favor, ingrese su contraseña actual.</p>",
                minlength: "<p class='forms-error'>Por favor, ingrese su contraseña actual.</p>"
            },
            nuevaContrasena: {
                required: "<p class='forms-error'>Por favor, ingrese la nueva contraseña.</p>",
                minlength: "<p class='forms-error'>La contraseña debe tener al menos 8 caracteres.</p>"
            },
            confirmarContrasena: {
                required: "<p class='forms-error'>Por favor, confirme la nueva contraseña.</p>",
                minlength: "<p class='forms-error'>La contraseña debe tener al menos 8 caracteres.</p>",
                equalTo: "<p class='forms-error'>Las contraseñas no coinciden.</p>"
            }
        }
    });
}
