import { initInputFile, reload } from "../../../../partials/other-funtions-init.js";
import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
	procesando,
	alertaGuardado, confirmarAccion
} from "../../../../partials/alerts-config.js";
import { getBaseURL } from "../../../../config.js";
// Configurar baseURL
const baseURL = getBaseURL();
$(document).ready(function() {
	initInputFile();
	/**
	 * Formulario 3: Jornadas de actualización
	 * */
	// Guardar formulario jórnada de actualización
	$(".guardar_formulario_jornadas_actualizacion").click(function (event) {
		event.preventDefault();
		if (!$("#fileJornadas").prop("files")[0]) {
			mostrarAlerta("error", "Por favor, selecciona un archivo.");
			return;
		}
		//$(this).attr("disabled", true);
		var form_data = new FormData();
		form_data.append("file", $("#fileJornadas").prop("files")[0]);
		form_data.append("tipoArchivo", $(this).attr("data-name"));
		form_data.append("append_name", $(this).attr("data-name"));
		form_data.append("asistio", $("input:radio[name=jornaSelect]:checked").val());
		form_data.append("idSolicitud", $(this).attr("data-id"));
		$.ajax({
			url: baseURL + "JornadasActualizacion/create", // guardarArchivoJornada
			dataType: "text",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "POST",
			beforeSend: function () {
				toastSimple('info', 'Guardando')
			},
			success: function (response) {
				response = JSON.parse(response);
				if (response.status === "success") {
					alertaGuardado(response.title, response.msg, response.status);
					setInterval(function () {
						reload();
					}, 2000)
				} else {
					mostrarAlerta(response.status, response.msg);
				}
			},
			error: function (ev) {
				errorControlador(ev.responseText);
			},
		});
	});
	// Eliminar jornada actualización
	$(".eliminarJornadaActualizacion").click(function () {
		confirmarAccion("Eliminar jornada de actualización", "¿Realmente desea eliminar este registro?","question", 'popup-swalert-lg')
			.then((result) => {
			if (result.isConfirmed) {
				let data = {
					id_jornada: $(this).attr("data-id-jornada"),
					id_formulario: $(this).attr("data-id-formulario"),
					id_archivo: $(this).attr("data-id-archivo"),
					tipo: $(this).attr("data-id-tipo"),
					nombre: $(this).attr("data-nombre-ar"),
				};
				$.ajax({
					url: baseURL + "JornadasActualizacion/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('warning', 'Eliminando')
					},
					success: function (response) {
						// Eliminar archivo
						$.ajax({
							url: baseURL + "Archivos/delete",
							type: "post",
							dataType: "JSON",
							data: data,
							error: function (ev) {
								errorControlador(ev)
							},
						});
						alertaGuardado('Registro eliminado', response.msg)
						setInterval(function () {
							reload();
						}, 2000)
					},
					error: function (ev) {
						errorControlador(ev)
					},
				});
			}
		});
	});
});
