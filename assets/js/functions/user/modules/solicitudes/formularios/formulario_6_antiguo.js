import { cargarArchivos } from "../../../../partials/other-funtions-init.js";
import { errorValidacionFormulario, showNotification, toastSimple, errorControlador, mostrarAlerta, procesando} from "../../../../partials/alerts-config.js";
$(document).ready(function() {
	/**
	 * Formulario 6: Modalidad Virtual
	 * */
	// Aceptar recomendaciones modalidad virtual
	$("#acepto_mod_virtual").click(function () {
		$("#acepta_mod_en_virtual").prop("checked", true);
		$("#modalAceptarVirtual").modal("hide");
		showNotification('Términos aceptados correctamente', 'success');
	});
	// Guardar datos de plataforma
	$("#guardar_formulario_plataforma").click(function () {
		if ($("#formulario_modalidad_virtual").valid()) {
			if ($("#acepta_mod_en_virtual").prop("checked") == true) {
				let data = {
					datos_plataforma_url: $("#datos_plataforma_url").val(),
					datos_plataforma_usuario: $("#datos_plataforma_usuario").val(),
					datos_plataforma_contrasena: $("#datos_plataforma_contrasena").val(),
					idSolicitud: $(this).attr("data-id"),
				};
				event.preventDefault();
				$.ajax({
					url: baseURL + "DatosAplicacion/create",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Guardando')
					},
					success: function (response) {
						if (response.status == "success") {
							alertaGuardado(response.msg, response.status);
						} else {
							alertaErrorGuardado(response.msg, response.status);
						}
					},
					error: function (ev) {
						alertaErrorGuardado(ev.responseText, "error");
					},
				});
			} else {
				Toast.fire({
					icon: "info",
					title: "Acepte modalidad virtual",
				});
				event.preventDefault();
			}
		} else {
			errorValidacionFormulario();
		}
	});
	// Eliminar datos de plataforma
	$(".eliminarDatosPlataforma").click(function () {
		Alert.fire({
			title: "Eliminar datos modalidad virtual",
			text: "¿Realmente desea eliminar este registro?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Si",
			cancelButtonText: "No",
		}).then((result) => {
			if (result.isConfirmed) {
				let id_plataforma = $(this).attr("data-id-datosPlataforma");
				data = {
					id_plataforma: id_plataforma,
				};
				$.ajax({
					url: baseURL + "panel/eliminarDatosPlataforma",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						Toast.fire({
							icon: "info",
							title: "Eliminando",
						});
					},
					success: function (response) {
						Alert.fire({
							title: "Registro eliminado!",
							text: response.msg,
							icon: "success",
						}).then((result) => {
							if (result.isConfirmed) {
								setInterval(function () {
									reload();
								}, 2000);
							}
						});
					},
					error: function (ev) {
						event.preventDefault();
						Toast.fire({
							icon: "error",
							title: "Error en el controlador consulta al administrador",
						});
					},
				});
			}
		});
	});
	$("form[id='formulario_modalidad_virtual']").validate({
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
			datos_plataforma_url: {
				required: true,
				minlength: 10,
				url: true,
			},
			datos_plataforma_usuario: {
				required: true,
				minlength: 5,
			},
			datos_plataforma_contrasena: {
				required: true,
				minlength: 5,
			},
		},
		messages: {
			datos_plataforma_url: {
				required: "Por favor, ingrese la url de la plataforma virtual.",
				minlength: "Mínimo 10 caracteres",
				url: "Requiere una url valida. Ej: http://www.ejemplo.com",
			},
			datos_plataforma_usuario: {
				required:
					"Por favor, ingrese usuario para ingresar a la plataforma.",
				minlength: "Mínimo 5 caracteres",
			},
			datos_plataforma_contrasena: {
				required:
					"Por favor, ingrese contraseña para ingresar a la plataforma.",
				minlength: "Mínimo 5 caracteres",
			},
		},
	});
	// Efecto al hacer hover en filas de la tabla
	$('.table tbody tr').hover(
		function() {
			$(this).addClass('bg-light');
		},
		function() {
			$(this).removeClass('bg-light');
		}
	);
	// Toggle password visibility
	$("#togglePassword").click(function() {
		const passwordField = $("#datos_plataforma_contrasena");
		const icon = $(this).find('i');

		if (passwordField.attr('type') === 'password') {
			passwordField.attr('type', 'text');
			icon.removeClass('fa-eye').addClass('fa-eye-slash');
		} else {
			passwordField.attr('type', 'password');
			icon.removeClass('fa-eye-slash').addClass('fa-eye');
		}
	});
});
