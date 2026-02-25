import {
	confirmarAccion,
	errorControlador,
	mostrarAlerta,
	toastSimple
} from "../../../partials/alerts-config.js";
import { reload, redirect } from "../../../partials/other-funtions-init.js";
$(document).ready(function() {
// Definición de duración de animaciones
	const duracionAnimacion = 400; // duración en milisegundos
// Función para volver al panel inicial con animaciones
	$(".volverSolicitudes").click(function () {
		// Ocultar modal sin animación (los modales de Bootstrap ya tienen su propia animación)
		$("#ayudaModalidad").modal("hide");
		// Animar la desaparición de los paneles actuales
		$("#formCrearSolicitud").fadeOut(duracionAnimacion, function () {
			// Animar la aparición del panel inicial - usando solo slideDown sin easing
			$("#verSolicitudes").slideDown(duracionAnimacion);
		});
	});
	/**
	 * Crear Solicitud con animaciones
	 * */
	$("#nuevaSolicitud").click(function () {
		// Ocultar modal
		$("#ayudaModalidad").modal("hide");
		// Animar la desaparición de paneles actuales
		$("#verSolicitudes").fadeOut(duracionAnimacion, function () {
			// Animar la aparición del panel de tipo de solicitud con un efecto de deslizamiento
			$("#formCrearSolicitud").hide().slideDown(duracionAnimacion);
		});
	});
	/**
	 * Guardar solicitud
	 * */
	$("#guardar_formulario_tipoSolicitud").click(function () {
		mostrarAlerta(
			"question",
			"¿Está seguro de crear la solicitud?",
			"Verifique la modalidad y los motivos registrados en la solicitud. Tenga en cuenta que una vez creada la solicitud no modificarla.",
		).then((result) => {
			if (result.isConfirmed) {
				if ($("#formulario_crear_solicitud").valid()) {
					// Declaración de variables
					let motivos_solicitud = [];
					let motivo_solicitud = "";
					let modalidad_solicitud = "";
					let modalidades_solicitud = [];
					let seleccionModalidad = 0;
					let seleccionMotivo = 0;
					// Recorrer motivos de la solicitud y guardar variables
					$("#formulario_crear_solicitud input[name=motivos]").each(function () {
						if (this.checked) {
							switch ($(this).val()) {
								case "1":
									motivo_solicitud +=
										"Acreditación Curso Básico de Economía Solidaria" + ", ";
									break;
								case "2":
									motivo_solicitud += "Aval de Trabajo Asociado" + ", ";
									break;
								case "3":
									motivo_solicitud +=
										"Acreditación Curso Medio de Economía Solidaria" + ", ";
									break;
								case "4":
									motivo_solicitud +=
										"Acreditación Curso Avanzado de Economía Solidaria" + ", ";
									break;
								case "5":
									motivo_solicitud +=
										"Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" +
										", ";
									break;
								case "6":
									motivo_solicitud +=
										"Programa organizaciones y redes SEAS. " + ", ";
									break;
								default:
							}
							motivos_solicitud.push($(this).val());
						}
					});
					// Recorrer motivos de la solicitud y guardar variables
					$("#formulario_crear_solicitud input[name=modalidades]").each(
						function () {
							if (this.checked) {
								switch ($(this).val()) {
									case "1":
										modalidad_solicitud += "Presencial" + ", ";
										break;
									case "2":
										modalidad_solicitud += "Virtual" + ", ";
										break;
									case "3":
										modalidad_solicitud += "A Distancia" + ", ";
										break;
									case "4":
										modalidad_solicitud += "Híbrida" + ", ";
										break;
									default:
								}
								modalidades_solicitud.push($(this).val());
							}
						}
					);
					// Datos a enviar
					let data = {
						tipo_solicitud: $("input:radio[name=tipo_solicitud]:checked").val(),
						motivo_solicitud: motivo_solicitud.substring(
							0,
							motivo_solicitud.length - 2
						),
						modalidad_solicitud: modalidad_solicitud.substring(
							0,
							modalidad_solicitud.length - 2
						),
						motivos_solicitud: motivos_solicitud,
						modalidades_solicitud: modalidades_solicitud,
					};
					// Contar la cantidad de motivos y solicitudes
					$("input[name=modalidades]:checked").each(function () {
						seleccionModalidad += 1;
					});
					$("input[name=motivos]:checked").each(function () {
						seleccionMotivo += 1;
					});
					// Comprobar que si se seleccione algún motivo y/o modalidad
					if (seleccionMotivo === "") {
						mostrarAlerta('warning', 'Motivo no seleccionado', 'Debe seleccionar un motivo para continuar');
					} else if (seleccionModalidad === 0) {
						mostrarAlerta('warning', 'Modalidad no seleccionado', 'Debe seleccionar una modalidad para continuar');
					} else {
						//Si la data es validada se envía al controlador para guardar con ajax
						$.ajax({
							url: baseURL + "Solicitudes/crearSolicitud",
							type: "post",
							dataType: "JSON",
							data: data,
							beforeSend: function () {
								toastSimple('info', 'Guardando información')
							},
							success: function (response) {
								if (response.status === "success") {
									mostrarAlerta(response.status, response.title, response.msg, ).then((result) => {
										if (result.isConfirmed) {
											setInterval(function () {
												redirect(
													baseURL + "solicitudes/solicitud/" + response.id
												);
											}, 2000);
										}
									});
								} else {
									mostrarAlerta(
										'info',
										'Verifique lo siguiente: ',
										response.msg
									)
								}
							},
							error: function (ev) {
								errorControlador(ev);
							},
						});
					}
				}
			}
		});
	});
	/**
	 * Modales modalidades
	 * */
	$("#virtual").click(function () {
		if (this.checked) {
			$("#ayudaModalidadVirtual").modal("toggle");
		}
	});
	$("#enLinea").click(function () {
		if (this.checked) {
			$("#ayudaModalidadEnLinea").modal("toggle");
		}
	});
	/**
	 * Opciones modales modalidades
	 * */
	$("#noModVirt").click(function () {
		$("#virtual").prop("checked", false);
		$("#ayudaModalidadVirtual").modal("hide");
	});
	$("#siModVirt").click(function () {
		$("#virtual").prop("checked", true);
		$("#ayudaModalidadVirtual").modal("hide");
	});
	$("#noModEnLinea").click(function () {
		$("#enLinea").prop("checked", false);
		$("#ayudaModalidadEnLinea").modal("hide");
	});
	$("#siModEnLinea").click(function () {
		$("#enLinea").prop("checked", true);
		$("#ayudaModalidadEnLinea").modal("hide");
	});
	/**
	 * Ver Solicitud
	 *  */
	$(".verSolicitud").click(function () {
		let idSolicitud = $(this).attr("data-id");
		redirect(baseURL + "solicitudes/solicitud/" + idSolicitud)
	});
	/**
	 * Eliminar solicitud
	 * */
	$(".eliminarSolicitud").click(function () {
		let idSolicitud = $(this).attr("data-id");
		let text =
			"¿Estás seguro de eliminar la solicitud:<strong>" +
			idSolicitud +
			"</strong>? <br><br> Esta acción no se puede revertir y eliminará el contenido de todos los formularios a excepción de los formularios: " +
			"<br><br> <strong>1. Información General </strong>" +
			"<br> <strong>5. Facilitadores.</strong>";
		confirmarAccion(
			"Eliminar solicitud",
			text,
			"question",
			'popup-swalert-list'
		).then((result) => {
			if (result.isConfirmed) {
				let data = {
					idSolicitud: idSolicitud,
				};
				$.ajax({
					url: baseURL + "Solicitudes/eliminarSolicitud",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Eliminando solicitud ' + idSolicitud)
					},
					success: function (response) {
						mostrarAlerta(response.status, "Solicitud eliminada!", response.msg ).then((result) => {
							if (result.isConfirmed) {
								setInterval(function () {
									reload();
								}, 2000);
							}
						});
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		});
		$("#eliminarSolicitud").attr("data-id", idSolicitud);
		$("#solicitudAEliminar").html();
	});
	/**
	 * Ver Solicitud
	 * */
	$(".verDetalleSolicitud").click(function () {
		// Limpia contenido previo para evitar 'estado residual' entre clics
		$("#informacionSolicitudBasico, #informacionSolicitudFechas, #informacionSolicitudEstado, #informacionResolucion").html("");
		// Asegura abrir el modal (si ya lo abre en otra parte, no afecta)
		$("#modalVerDetalle").modal("show");

		let html = "";
		let estado = "badge-danger";
		let data = {
			idSolicitud: $(this).attr("data-id"),
		};
		// Helper para escapar HTML en textos dinámicos
		function escapeHtml(text) {
			const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
			return String(text).replace(/[&<>"']/g, (m) => map[m]);
		}
		$.ajax({
			url: baseURL + "solicitudes/cargarDatosSolicitud",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				html +=
					"<p>" +
					"<label class='font-weight-bold'>Solicitud Número: </label> " +
					response.solicitud["idSolicitud"] +
					"</p>";
				html +=
					"<p>" +
					"<label class='font-weight-bold'>Tipo: </label> " +
					response.solicitud["tipoSolicitud"] +
					"</p>";
				html +=
					"<p>" +
					"<label class='font-weight-bold'>Motivo: </label> " +
					response.solicitud["motivoSolicitud"] +
					"</p>";
				html +=
					"<p>" +
					"<label class='font-weight-bold'>Modalidad: </label> " +
					response.solicitud["modalidadSolicitud"] +
					"</p>";
				$("#informacionSolicitudBasico").html(html);
				html = "";
				html +=
					"<p><label class='font-weight-bold'>Fecha de Creación: </label> " +
					response.solicitud["fechaCreacion"] +
					"</p>";
				html +=
					"<p><label class='font-weight-bold'>Fecha de Finalización: </label> " +
					(response.solicitud["fechaFinalizado"] ? response.solicitud["fechaFinalizado"] : "") +
					"</p>";
				html +=
					"<p><label class='font-weight-bold'>Fecha Ultima Revisión: </label> " +
					(response.solicitud["fechaUltimaRevision"] ? response.solicitud["fechaUltimaRevision"] : "") +
					"</p>";
				html +=
					"<p><label class='font-weight-bold'>Estado Anterior: </label> " +
					response.solicitud["estadoAnterior"] +
					"</p>";
				$("#informacionSolicitudFechas").html(html);
				html = "";
				if (response.solicitud["nombre"] === "Acreditado")
					estado = "badge-success";
				if (response.solicitud["nombre"] === "En Proceso" || response.solicitud["nombre"] === "Finalizado")
					estado = "badge-info";
				if (response.solicitud["nombre"] === "En Observaciones")
					estado = "badge-warning";
				html +=
					"<p><label class='font-weight-bold'>Estado:  </label><span class='badge " +
					estado +
					"'>" +
					response.solicitud["nombre"] +
					"</span></p>";
				html +=
					"<p><label class='font-weight-bold'>Asignada: </label> " +
					response.solicitud["asignada"] +
					"</p>";
				html +=
					"<p><label class='font-weight-bold'>Revisiones: </label> " +
					response.solicitud["numeroRevisiones"] +
					"</p>";
				// Mostrar justificación si existe (solo se guarda cuando era requerida)
				const justificacion = response.solicitud["justificacionCambioEstado"];
				const estadoActual = response.solicitud["nombre"];
				if (justificacion && String(justificacion).trim() !== "") {
					html += "<div class='mt-3 p-3 position-relative' style='background:#f9fafb;border-left:4px solid #17a2b8;border-radius:8px;'>"
						+ "<div class='d-flex align-items-center mb-2'>"
						+ "<i class='ti-comment-alt text-info mr-2' style='font-size:1.2rem;'></i>"
						+ "<span class='text-info font-weight-600'>Justificación del cambio</span>"
						+ "</div>"
						+ "<blockquote class='mb-0' style='font-style:italic;color:#555;'>"
						+ "<span style='font-size:1.6rem;line-height:0;vertical-align:top;'>“</span>"
						+ escapeHtml(justificacion)
						+ "<span style='font-size:1.6rem;line-height:0;vertical-align:bottom;'>”</span>"
						+ "</blockquote>"
						+ "<div class='mt-2'>"
						+ "<span class='badge badge-info mr-2'>Requirió justificación</span>"
						+ "<span class='badge badge-light border'>" + escapeHtml(estadoActual) + "</span>"
						+ "</div>"
						+ "</div>";
				}
				$("#informacionSolicitudEstado").html(html);
				console.log(response.resolucion);
				if (response.resolucion) {
					$("#informacionResolucionDiv").show(); // contenedor correcto
					$("#informacionSolicitudEstado").removeClass("col-lg-12");
					$("#informacionSolicitudEstado").addClass("col-lg-6");
					html = "";
					html = "<h5 class='text-success mb-3'>Resolución</h5>";
					html +=
						"<p><label class='font-weight-bold'>Fecha Inicial Resolución:</label>" +
						response.resolucion["fechaResolucionInicial"] +
						"</p>";
					html +=
						"<p><label class='font-weight-bold'>Fecha Final Resolución: </label> " +
						response.resolucion["fechaResolucionFinal"] +
						"</p>";
					html +=
						"<p><label class='font-weight-bold'>Años Resolución: </label> " +
						response.resolucion["anosResolucion"] +
						"</p>";
					html +=
						"<p><label class='font-weight-bold'>Resolución: </label><a href='" +
						baseURL +
						"uploads/resoluciones/" +
						response.resolucion["resolucion"] +
						"' target='_blank'> " +
						response.resolucion["numeroResolucion"] +
						"</p>";
					$("#informacionResolucion").html(html);
				} else {
					$("#informacionResolucion").html(""); // limpieza del contenido
					$("#informacionResolucionDiv").hide();
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
	/**
	 * Ver estado de la solicitud
	 * */
	$(".verObservaciones").click(function () {
		let idSolicitud = $(this).attr("data-id");
		window.open(baseURL + "solicitudes/estadoSolicitud/" + idSolicitud, "_self");
	});
	/**
	 * Renovar solicitud
	 * */
	$(".renovarSolicitud").click(function () {
		let text =
			"<p>Al continuar: <br>  Se creará una nueva solicitud, que conservará la información registrada anteriormente en los formularios:" +
			"<br><br> <strong>1. Información General </strong>" +
			"<br> <strong>5. Facilitadores.</strong>" +
			"<br><br>Debe revisar que los datos allí almacenados sean correctos y actualizar e ingresar la información de los demás formularios según el programa educativo y modalidad a renovar</p>";
			confirmarAccion("Recuerde que esta opción sólo aplica para RENOVACIÓN de la acreditación", text, 'warning').then((result) => {
			if (result.isConfirmed) {
				let data = {
					idSolicitud: $(this).attr("data-id"),
				};
				$.ajax({
					url: baseURL + "Solicitudes/renovarSolicitud",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple("info", "Copiando Información");
					},
					success: function (response) {
						if (response.status === "success") {
							confirmarAccion(response.title, response.msg, response.status).then((result) => {
								if (result.isConfirmed) {
									setInterval(function () {
										redirect(baseURL + "solicitudes/solicitud/" + response.id);
									}, 2000);
								}
							});
						} else if ((response.status = "error")) {
							mostrarAlerta(response.status, response.title, response.msg)
						}
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		});
	});
	$(".volver_solicitudes").click(function () {
		redirect(baseURL + "organizacion/solicitudes");
	});
});
