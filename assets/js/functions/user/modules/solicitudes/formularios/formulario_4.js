import { reload } from "../../../../partials/other-funtions-init.js";
import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
	alertaGuardado, confirmarAccion
} from "../../../../partials/alerts-config.js";
import { getBaseURL } from "../../../../config.js";
// Configurar baseURL
const baseURL = getBaseURL();
$(document).ready(function() {
	/**
	 * Formulario 4: Programas de Educación
	 * */
	// Acciones de cada modal de aceptación
	$("#aceptar_programa_seas").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	$("#aceptar_curso_basico_es").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	$("#aceptar_aval_trabajo").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	$("#aceptar_curso_medio_es").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	$("#aceptar_avanzado_medio_es").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	$("#aceptar_educacion_financiera").click(function () {
		let curso = $(this).attr("data-programa");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosProgramas(curso, modal, check, idSolicitud);
	});
	// Función para guardar datos al aceptar programa
	function guardarDatosProgramas(curso, modal, check, idSolicitud) {
		$("#" + modal).modal("toggle");
		$("#" + check).prop("checked", true);
		$(this).attr("disabled", true);
		// Declarar correctamente la variable data
		let data = {
			programa: curso,
			organizacion: $("#id_organizacion").val(),
			idSolicitud: idSolicitud,
		};
		$.ajax({
			url: baseURL + "DatosProgramas/create",
			type: "post",
			dataType: "JSON",
			data: data,
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
	}
	
	// Eliminar datos plataforma
	$(".eliminarDatosProgramas").click(function () {
		confirmarAccion('Eliminar programa de acreditación', '¿Realmente desea eliminar este registro?', 'question', 'popup-swalert-lg').then((result) => {
			if (result.isConfirmed) {
				// Declarar correctamente la variable data
				let data = {
					id: $(this).attr("data-id"),
				};
				$.ajax({
					url: baseURL + "DatosProgramas/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Eliminando...');
					},
					success: function (response) {
						if (response.status === "success") {
							alertaGuardado(response.title, response.msg, response.status);
							$('.eliminarDataTabla').click();
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
			}
		});
	});
});
