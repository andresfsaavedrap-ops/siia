import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
	alertaGuardado,
	showNotification,
	confirmarAccion
} from "./partials/alerts-config.js";
import { redirect } from "./partials/other-funtions-init.js";
import { getBaseURL } from "./config.js";
const baseURL = getBaseURL();
$(document).ready(function() {
	validarFormLogin();
	/** Inicio de sesión usuario. */
	$("#inicio_sesion").click(function (e) {
		// Prevenir comportamiento predeterminado del botón
		e.preventDefault();
		// Deshabilitar el botón para evitar múltiples clics
		$("#inicio_sesion").prop("disabled", true);
		// Eliminar token previo si existe
		$("#token").remove();
		// Validar formulario antes de solicitar el token
		if (!$("#formulario_login").valid()) {
			$("#inicio_sesion").prop("disabled", false);
			return;
		}
		var usuario = $("#usuario").val();
		var password = $("#password").val();
		if (usuario.length <= 0 || password.length <= 0) {
			mostrarAlerta("error",  "Error", "Por favor ingrese usuario y contraseña",);
			$("#inicio_sesion").prop("disabled", false);
			return;
		}
		// Mostrar indicador de carga
		toastSimple("info", "Ingresando");
		// Ejecutar reCAPTCHA
		grecaptcha.ready(function () {
			grecaptcha
				.execute("6LeTFnYnAAAAAKl5U_RbOYnUbGFGlhG4Ffn52Sef", {
					action: 'LOGIN' // Añadir la acción es recomendado
				})
				.then(function (token) {
					// Agregar token al formulario
					$("#formulario_login").prepend(
						'<input type="hidden" id="token" value="' + token + '">'
					);
					// Preparar datos
					var data = {
						usuario: usuario,
						password: password,
						token: token,
					};
					// Enviar solicitud AJAX
					$.ajax({
						url: baseURL + "sesion/login",
						type: "post",
						dataType: "JSON",
						data: data,
						success: function (response) {
							if (response.status === "success") {
								mostrarAlerta(response.status, response.title,response.msg).then((result) => {
									if (result.isConfirmed) {
										window.location.href = baseURL + "organizacion/panel";
									}
								});
							} else {
								mostrarAlerta(response.status, response.title,response.msg);
								$("#inicio_sesion").prop("disabled", false);
							}
						},
						error: function (ev) {
							console.log("Error en la solicitud:", ev);
							errorControlador(ev);
							$("#inicio_sesion").prop("disabled", false);
						},
						complete: function () {
							// Si hay algún error que no se captura en success o error
							setTimeout(function () {
								$("#inicio_sesion").prop("disabled", false);
							}, 2000);
						}
					});
				})
				.catch(function (error) {
					console.error("Error en reCAPTCHA:", error);
					mostrarAlerta("error", "Error", "Error al verificar reCAPTCHA. Por favor, intente nuevamente.");
					$("#inicio_sesion").prop("disabled", false);
				});
		});
	});
	/** Recordar contraseña usuario*/
	$("#recordar_contrasena_login").click(function () {
		const {value: email} = Swal.fire({
			title: "Recordar contraseña",
			icon: "info",
			input: "email",
			inputLabel:
				"Ingresa correo electrónico de notificaciones de la organización",
			inputPlaceholder: "Correo electrónico organización",
			focusConfirm: false,
			showCancelButton: true,
			confirmButtonText: `Enviar datos de acceso`,
			allowOutsideClick: false,
			customClass: {
				confirmButton: "button-swalert",
				popup: "popup-swalert",
				input: "input-swalert",
				inputLabel: "input-label-swalert",
			},
		}).then((result) => {
			if (result.isConfirmed) {
				let data = {
					correo_electronico: result.value,
				};
				$.ajax({
					url: baseURL + "recordar/recordar",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple("info", "Enviando datos");
					},
					success: function (response) {
						alertaGuardado(response.title, response.msg, response.status);
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		});
	});
	/** Inicio de sesión administrador. */
	$("#inicio_sesion_admin").click(function (e) {
		// Prevenir comportamiento predeterminado del botón
		e.preventDefault();
		// Deshabilitar el botón para evitar múltiples clics
		$("#inicio_sesion_admin").prop("disabled", true);
		// Eliminar token previo si existe
		$("#token").remove();
		// Validar formulario antes de solicitar el token
		if (!$("#formulario_login_admin").valid()) {
			$("#inicio_sesion_admin").prop("disabled", false);
			return;
		}
		var usuario = $("#usuario").val();
		var password = $("#password").val();
		if (usuario.length <= 0 || password.length <= 0) {
			mostrarAlerta("error", "Error", "Por favor ingrese usuario y contraseña");
			$("#inicio_sesion_admin").prop("disabled", false);
			return;
		}
		// Mostrar indicador de carga
		toastSimple("info", "Ingresando");
		// Ejecutar reCAPTCHA
		grecaptcha.ready(function () {
			grecaptcha
				.execute("6LeTFnYnAAAAAKl5U_RbOYnUbGFGlhG4Ffn52Sef", {
					action: 'LOGIN_ADMIN' // Añadir la acción es recomendado para identificar el tipo de autenticación
				})
				.then(function (token) {
					// Agregar token al formulario
					$("#formulario_login_admin").prepend(
						'<input type="hidden" id="token" value="' + token + '">'
					);
					// Preparar datos
					var data = {
						usuario: usuario,
						password: password,
						token: token,
					};
					// Enviar solicitud AJAX
					$.ajax({
						url: baseURL + "sesion/log_in_admin",
						type: "post",
						dataType: "JSON",
						data: data,
						success: function (response) {
							if (response.status === "success") {
								mostrarAlerta(response.status, response.title, response.msg).then((result) => {
									if (result.isConfirmed) {
										window.location.href = baseURL + "admin/panel";
									}
								});
							} else {
								mostrarAlerta(response.status, response.title, response.msg);
								$("#inicio_sesion_admin").prop("disabled", false);
							}
						},
						error: function (ev) {
							errorControlador(ev);
							$("#inicio_sesion_admin").prop("disabled", false);
						},
						complete: function () {
							// Si hay algún error que no se captura en success o error
							setTimeout(function () {
								$("#inicio_sesion_admin").prop("disabled", false);
							}, 2000);
						}
					});
				})
				.catch(function (error) {
					mostrarAlerta("error", "Error", "Error al verificar reCAPTCHA. Por favor, intente nuevamente.");
					$("#inicio_sesion_admin").prop("disabled", false);
				});
		});
	});
	/** Validar formularios */
	function validarFormLogin() {
		// Formulario Login.
		$("form[id='formulario_login']").validate({
			// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
			errorElement: "div",
			// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
			errorClass: "invalid-feedback",
			// Configuramos cómo se ubica el mensaje de error para mantener el layout consistente en input-groups
			errorPlacement: function (error, element) {
				// Si el input forma parte de un input-group, insertamos el error después del contenedor
				if (element.closest(".input-group").length) {
					error.insertAfter(element.closest(".input-group"));
				} else {
					error.insertAfter(element);
				}
			},
			// Cuando hay error, agrega la clase 'is-invalid' y remueve 'is-valid'
			highlight: function (element, errorClass, validClass) {
				$(element).addClass("is-invalid").removeClass("is-valid");
			},
			// Cuando el campo es válido, hace lo contrario: agrega 'is-valid' y remueve 'is-invalid'
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass("is-invalid").addClass("is-valid");
			},
			rules: {
				usuario: {
					required: true,
					minlength: 3,
				},
				password: {
					required: true,

					regex: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$",
				},
			},
			messages: {
				usuario: {
					required:
						"<p class='forms-error'>Por favor,escriba el nombre de usuario.</p>",
					minlength:
						"<p class='forms-error'>El nombre de usuario debe tener mínimo 3 caracteres.</p>",
				},
				password: {
					required:
						"<p class='forms-error'>Por favor, escriba la contraseña.</p>",
					regex:
						"<p class='forms-error'>La contraseña debe cumplir con los siguientes requisitos:</p><br>" +
						"<ul class='forms-error'> " +
						"<li>Al menos <strong>un número</strong>.</li>" +
						"<li>Al menos <strong>una mayúscula</strong>.</li>" +
						"<li>Al menos <strong>letras minúsculas</strong>.</li>" +
						"<li>Al menos <strong>un carácter especial (#?!@$%^&*-)</strong>.</li>" +
						"<li>Una longitud mínima de <strong>8 caracteres</strong> sin límite máximo.</li>" +
						"</ul>",
				},
			},
		});
		// Formulario Login Administradores.
		$("form[id='formulario_login_admin']").validate({
			// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
			errorElement: "div",
			// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
			errorClass: "invalid-feedback",
			// Configuramos cómo se ubica el mensaje de error para mantener el layout consistente en input-groups
			errorPlacement: function (error, element) {
				// Si el input forma parte de un input-group, insertamos el error después del contenedor
				if (element.closest(".input-group").length) {
					error.insertAfter(element.closest(".input-group"));
				} else {
					error.insertAfter(element);
				}
			},
			// Cuando hay error, agrega la clase 'is-invalid' y remueve 'is-valid'
			highlight: function (element, errorClass, validClass) {
				$(element).addClass("is-invalid").removeClass("is-valid");
			},
			// Cuando el campo es válido, hace lo contrario: agrega 'is-valid' y remueve 'is-invalid'
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass("is-invalid").addClass("is-valid");
			},
			rules: {
				usuario: {
					required: true,
					minlength: 3,
				},
				password: {
					required: true,
					minlength: 3,
				},
			},
			messages: {
				usuario: {
					required:
						"<p class='forms-error'>Por favor, escriba el Nombre de Usuario.</p>",
					minlength:
						"<p class='forms-error'>El Nombre de Usuario debe tener mínimo 3 caracteres.</p>",
				},
				password: {
					required:
						"<p class='forms-error'>Por favor, escriba la contraseña.</p>",
					minlength:
						"<p class='forms-error'>La Contraseña debe tener mínimo 3 caracteres.</p>",
				},
			},
		});
	}
	/** TODO: Provisional para vista anterior panel 
	 * Click en Salir de Sesion.**/
	$(".logout").click(function () {
		$(this).attr("disabled", true);
		confirmarAccion(
			"Cerrar sesión ",
			"¿Realmente desea cerrar sesión?",
			"question",
			"popup-swalert-lg"
		).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "sesion/logoutAdmin",
					type: "post",
					dataType: "JSON",
					beforeSend: function () {
						toastSimple("info", "Cerrando sesión");
					},
					success: function (response) {
						setInterval(function () {
							redirect(baseURL + "admin");
						}, 2000);
					},
					error: function (ev) {
						//Do nothing
					},
				});
			}
		});
	});
	/** Clic en cerrar sesión. **/
	$("#salir_sesion").click(function () {
		confirmarAccion(
			"Cerrar sesión ",
			"¿Realmente desea cerrar sesión?",
			"question",
			"popup-swalert-lg"
		).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "sesion/logout",
					type: "post",
					dataType: "JSON",
					beforeSend: function () {
						toastSimple("info", "Cerrando sesión");
					},
					success: function (response) {
						redirect(response.url);
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		});
	});
	/** Click en Salir de Sesion Administrador. **/
	$("#salir_admin").click(function () {
		$(this).attr("disabled", true);
		confirmarAccion(
			"Cerrar sesión ",
			"¿Realmente desea cerrar sesión?",
			"question",
			"popup-swalert-lg"
		).then((result) => {
			if (result.isConfirmed) {
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
					error: function (ev) {
						errorControlador(ev);
					},
				});
				}
		});
	});
});
