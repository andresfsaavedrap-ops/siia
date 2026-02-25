import { procesando, mostrarAlerta, toastSimple, errorControlador, alertaGuardado } from '../partials/alerts-config.js';
import { getBaseURL } from '../config.js';
let baseURL = getBaseURL();
$(document).ready(() => {
	/** Consultar estados */
	// Al cargar la página, ocultamos los resultados hasta que se realice una consulta
	$("#resConEst").hide();
	// Cuando el usuario hace clic en el botón de consultar
	$("#consultarEstadoID").click(function() {
		limpiarSolicitud();
		if($("#numeroID").val() == "") {
			// Mostrar alerta de GOV.CO
			mostrarAlerta('warning', 'Atención', 'Debe ingresar un número de solicitud para consultar');
			return false;
		}
		if ($("#formulario_estado").valid()) {
			event.preventDefault();
			grecaptcha.ready(function () {
				grecaptcha
					.execute("6LeTFnYnAAAAAKl5U_RbOYnUbGFGlhG4Ffn52Sef", {
						//action: 'submit'
					})
					.then(function (token) {
						// Add input google token
						$("#formulario_estado").prepend(
							'<input type="hidden" id="token" value="' + token + '">'
						);
						let data = {
							idSolicitud: $("#numeroID").val(),
							token: $("#token").val(),
						};
						$.ajax({
							url: baseURL + "home/consultarEstado",
							type: "post",
							dataType: "JSON",
							data: data,
							success: function (response) {
								console.log(response);
								if (response.status == 'success') {
									toastSimple(response.status, response.msg);
									// Mostrar el contenedor de resultados
									$("#resConEst").fadeIn();
									$("#idSol").html(response.solicitud.idSolicitud);
									$("#organizacion").html(response.organizacion.nombreOrganizacion);
									$("#estadoOrg").html('<code> ' + response.solicitud.nombre + '</code>');
									$("#estadoAnterior").html(response.solicitud.estadoAnterior);
									$("#fechaCreacion").html(response.solicitud.fechaCreacion);
									$("#fechaFin").html(response.solicitud.fechaFinalizado);
									$("#revision").html(response.solicitud.fechaUltimaRevision);
									$("#modSol").html(response.solicitud.modalidadSolicitud);
									$("#motSol").html(response.solicitud.motivoSolicitud);
									$("#tipSol").html(response.solicitud.tipoSolicitud);
									$("#asignadoSol").html(response.solicitud.asignada);
									$("#resConEst").slideDown();
									// Mostrar contenedor y limpiar campo
									$("#resConEst").slideDown();
									$("#numeroID").val("");
									// Actualizar la línea de tiempo con los datos de la solicitud
									actualizarTimeline(response.solicitud, response.organizacion);
									// Actualizar color del badge según el estado (según colores de GOV.CO)
									var estado = response.solicitud.nombre;
									if (estado === "Acreditado") {
										$("#estadoOrg").removeClass("error").addClass("completado");
									} else if (estado === "En Observaciones" || estado === "En Proceso" || estado === "Finalizado" || estado === "En Renovación") {
										$("#estadoOrg").removeClass("error").addClass("pendiente");
									} else if (estado === "Rechazado" || estado === 'Negada' || estado === 'Archivada') {
										$("#estadoOrg").removeClass("error").addClass("error");
									}
									// Generar historial de estados
									generarHistorialEstados(response.solicitud);
								} else {
									toastSimple(response.status, response.msg);
								}
							},
							error: function (ev) {
								errorControlador(ev)
							},
						});
					})
			});
		}
	});
	/**
	 * Función principal para actualizar la línea de tiempo basada en la respuesta AJAX
	 */
	function actualizarTimeline(solicitud, organizacion) {
		// Resetear el estado actual
		$(".step-button").removeClass("active completed");
		$(".progress-bar").css("width", "0%");

		// Actualizar fechas en la línea de tiempo
		$("#timeline-fechaCreacion").text(solicitud.fechaCreacion || "-");
		$("#timeline-revision").text(solicitud.fechaUltimaRevision || "-");
		$("#timeline-fechaFin").text(solicitud.fechaFinalizado || "-");

		// Obtener el estado actual
		var estadoActual = solicitud.nombre;

		// Definir la clase para estados completados
		var completedClass = "completed"; // Cambiado de "active done" a "completed" según tu CSS

		// Actualizar estado visual según el estado actual
		if (estadoActual === "Creado") {
			// Solo el primer paso está activo
			$("#step1").addClass("active");
		}
		else if (estadoActual === "En revisión" || estadoActual === "En Observaciones") {
			// Primer paso completado, segundo activo
			$("#step1").addClass(completedClass);
			$("#step2").addClass("active");
			$("#connector1-2").css("width", "100%");
		}
		else if (estadoActual === "Acreditado" || estadoActual === "Rechazado" || estadoActual === "Finalizado") {
			// Primeros dos pasos completados, tercer paso activo
			$("#step1, #step2").addClass(completedClass);
			$("#step3").addClass("active");
			$("#connector1-2, #connector2-3").css("width", "100%");

			// Personalizar el estado final según el resultado
			if (estadoActual === "Acreditado") {
				$("#timeline-decision-title").text("Solicitud Aprobada");
			} else if (estadoActual === "Rechazado") {
				$("#timeline-decision-title").text("Solicitud Rechazada");
				$("#step3 .circle-button").css("background-color", "#A80521"); // Color de error GOV.CO
			} else {
				$("#timeline-decision-title").text("Decisión Final");
			}
		}

		// Si hay fechas de revisión o finalización, asegurarse de que los estados anteriores estén completados
		if (solicitud.fechaUltimaRevision && solicitud.fechaUltimaRevision !== "-") {
			$("#step1").addClass(completedClass);
			$("#connector1-2").css("width", "100%");
		}

		if (solicitud.fechaFinalizado && solicitud.fechaFinalizado !== "-") {
			$("#step1, #step2").addClass(completedClass);
			$("#connector1-2, #connector2-3").css("width", "100%");
		}
	}
	/**
	 * Genera el historial de estados para la solicitud
	 */
	function generarHistorialEstados(solicitud) {
		// Simulación de historial de estados
		var historial = [
			{ fecha: solicitud.fechaCreacion, estado: "Creado", icon: "govco-plus-square-1" }
		];

		// Añadir etapa de revisión si existe fecha
		if(solicitud.fechaUltimaRevision && solicitud.fechaUltimaRevision !== "-") {
			historial.push({
				fecha: solicitud.fechaUltimaRevision,
				estado: "En revisión",
				icon: "govco-search"
			});
		}

		// Añadir etapa final si existe
		if(solicitud.fechaFinalizado && solicitud.fechaFinalizado !== "-") {
			historial.push({
				fecha: solicitud.fechaFinalizado,
				estado: solicitud.nombre,
				icon: "govco-check-square"
			});
		}

		// Llenar el historial usando componentes de GOV.CO
		$("#listaHistorial").empty();
		$.each(historial, function(index, item) {
			$("#listaHistorial").append(
				'<li class="list-group-item d-flex justify-content-between align-items-start">' +
				'<div class="ms-2 me-auto">' +
				'<div class="fw-bold">' + item.estado + '</div>' +
				item.fecha +
				'</div>' +
				'<span class="badge bg-primary rounded-pill "> ' +
				'<span class="' + item.icon + '"><span>' +
				'</span>' +
				'</li>'
			);
		});
	}
	// Limpiar datos de la solicitud
	function limpiarSolicitud () {
		$("#resConEst").hide();
		$("#estadoOrg").removeClass("error").removeClass("completado").removeClass('pendiente');
	}
	$("#limpiarDatosSolitidud").click(() => {
		limpiarSolicitud();
	})
	// También permitir enviar el formulario con Enter
	$("#numeroID").keypress(function(e) {
		if(e.which == 13) {
			$("#consultarEstadoID").click();
			return false;
		}
	});
})
