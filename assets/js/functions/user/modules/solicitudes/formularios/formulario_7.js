import { cargarArchivos, reload } from "../../../../partials/other-funtions-init.js";
import {
	errorValidacionFormulario,
	showNotification,
	toastSimple,
	errorControlador,
	mostrarAlerta,
	procesando,
	alertaGuardado
} from "../../../../partials/alerts-config.js";
import { getBaseURL } from "../../../config.js";

// Configurar baseURL
const baseURL = getBaseURL();
const Toast = window.Toast || {
	fire: function(options) {
		toastSimple(options.icon, options.text || options.title);
	}
};
const Alert = window.Alert || {
	fire: function(options) {
		return mostrarAlerta(options.icon, options.title, options.text);
	}
};
$(document).ready(function() {
	/**
	 * Formulario 7: Modalidad En Línea
	 * */
	// Aceptar recomendaciones modalidad en línea
	$("#acepto_mod_en_linea").click(function () {
		$("#acepta_mod_en_linea").prop("checked", true);
		$("#modalAceptarEnLinea").modal("hide");
		showNotification('Términos aceptados correctamente', 'success');
	});
	// Guardar formulario
	$("#guardar_formulario_modalidad_en_linea").click(function () {
		if ($("#formulario_modalidad_en_linea").valid()) {
			event.preventDefault();
			if ($("#acepta_mod_en_linea").prop("checked") == true) {
				// Capturar datos formulario
				let form_data = new FormData();
				form_data.append(
					"tipoArchivo",
					$("#instructivoEnLinea").attr("data-val")
				);
				form_data.append(
					"append_name",
					$("#instructivoEnLinea").attr("data-val")
				);
				form_data.append("nombreHerramienta", $("#nombre_herramienta").val());
				form_data.append(
					"descripcionHerramienta",
					$("#descripcion_herramienta").val()
				);
				form_data.append("aceptacion", $("#acepta_mod_en_linea").val());
				form_data.append("idSolicitud", $(this).attr("data-id"));
				// Petición para guardar datos
				$.ajax({
					url: baseURL + "DatosEnLinea/create",
					cache: false,
					contentType: false,
					processData: false,
					type: "post",
					dataType: "JSON",
					data: form_data,
					beforeSend: function () {
						toastSimple('info', 'Guardando...')
					},
					success: function (response) {
						if (response.status === "success") {
							alertaGuardado(response.title, response.msg, response.status);
							setInterval(function () {
								reload();
							}, 2000)
						} else {
							mostrarAlerta(response.status, response.title, response.msg);
						}
					},
					error: function (ev) {
						errorControlador(ev.responseText, "error");
					},
				});
			} else {
				Toast.fire({
					icon: "info",
					title: "Acepte modalidad en línea",
				});
			}
		} else {
			errorValidacionFormulario();
		}
	});
	// Ver Documento
	$(".verDocDatosEnlinea").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			formulario: 8,
		};
		$.ajax({
			url: baseURL + "panel/verDocumento",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				window.open(response.file, "_blank");
			},
		});
	});
	// Eliminar datos en línea
	$(".eliminarDatosEnlinea").click(function () {
		Alert.fire({
			title: "Eliminar datos programa en línea",
			text: "¿Realmente desea eliminar este registro?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Si",
			cancelButtonText: "No",
		}).then((result) => {
			if (result.isConfirmed) {
				data = {
					id: $(this).attr("data-id"),
				};
				$.ajax({
					url: baseURL + "panel/eliminarDatosEnLinea",
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
	// Validación
	$("form[id='formulario_modalidad_en_linea']").validate({
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
			nombre_herramienta: {
				required: true,
				minlength: 5,
			},
			descripcion_herramienta: {
				required: true,
				minlength: 210,
				maxlength: 420,
			},
		},
		messages: {
			nombre_herramienta: {
				required: "Por favor, ingrese el nombre de la herramienta.",
				minlength: "Mínimo 5 caracteres",
			},
			descripcion_herramienta: {
				required: "Por favor, ingrese descripción de la herramienta.",
				minlength: "Mínimo 210 caracteres",
				maxlength: "Máximo 420 caracteres",
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
});
