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
	$("#aceptar_modalidad_presencial").click(function () {
		let modalidad = $(this).attr("data-modalidad");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosModalidades(modalidad, modal, check, idSolicitud);
	});
	$("#aceptar_modalidad_virtual").click(function () {
		let modalidad = $(this).attr("data-modalidad");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosModalidades(modalidad, modal, check, idSolicitud);
	});
	$("#aceptar_modalidad_distancia").click(function () {
		let modalidad = $(this).attr("data-modalidad");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosModalidades(modalidad, modal, check, idSolicitud);
	});
	$("#aceptar_modalidad_hibrida").click(function () {
		let modalidad = $(this).attr("data-modalidad");
		let modal = $(this).attr("data-modal");
		let check = $(this).attr("data-check");
		let idSolicitud = $(this).attr("data-id");
		guardarDatosModalidades(modalidad, modal, check, idSolicitud);
	});

	// Función para guardar datos al aceptar programa
	function guardarDatosModalidades(modalidad, modal, check, idSolicitud) {
		$("#" + modal).modal("toggle");
		$("#" + check).prop("checked", true);
		$(this).attr("disabled", true);
		let data = {
			modalidad: modalidad,
			organizacion: $("#id_organizacion").val(),
			idSolicitud: idSolicitud,
		};
		$.ajax({
			url: baseURL + "DatosModalidades/create",
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
	// Eliminar datos modalidad
	$(".eliminarDatosModalidad").click(function () {
		confirmarAccion("Eliminar Modalidad Registrada", "¿Realmente desea eliminar este registro?", 'question', 'popup-swalert-lg').then((result) => {
			if (result.isConfirmed) {
				// Declarar correctamente la variable data
				let data = {
					id: $(this).attr("data-id"),
				};
				$.ajax({
					url: baseURL + "DatosModalidades/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Eliminando...');
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
						errorControlador(ev.responseText);
					},
				});
			}
		});
	});
});
