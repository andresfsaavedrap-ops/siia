/**
 * Finalizar Solicitud
 *
 */
import {confirmarAccion, errorControlador, mostrarAlerta, toastSimple} from "../../../../partials/alerts-config.js";
import { redirect } from "../../../../partials/other-funtions-init.js";
import { getBaseURL } from "../../../../config.js";
// Configurar baseURL
const baseURL = getBaseURL();
$("#finalizar_si").click(function () {
	confirmarAccion("Finalizar solicitud", "¿Realmente desea enviar solicitud a la unidad solidaría?", "info", 'popup-swalert-lg').then((result) => {
		if (result.isConfirmed) {
			let idSolicitud = $(this).attr("data-id");
			let data = {
				idSolicitud: idSolicitud,
			};
			$.ajax({
				url: baseURL + "Solicitudes/enviarSolicitud",
				type: "post",
				dataType: "JSON",
				data: data,
				beforeSend: function () {
					toastSimple('info', 'Enviando solicitud a unidad Solidaria.')
				},
				success: function (response) {
					if (response.status === "success") {
						confirmarAccion(response.title, response.msg, response.status, 'popup-swalert-lg').then((result) => {
							if (result.isConfirmed) {
								setInterval(function () {
									redirect(
										baseURL + "solicitudes/estadoSolicitud/" + idSolicitud
									);
								}, 2000);
							}
							else {
								setInterval(function () {
									redirect(
										baseURL + "organizacion/solicitudes"
									);
								}, 2000);
							}
						});
					} else {
						$(".home-link").click();
					}
				},
				error: function (ev) {
					errorControlador(ev)
				},
			});
		}
	});
});
$('#finalizar_no').click(function () {
	$('.home-link').click();
});
