import { procesando, mostrarAlerta, toastSimple, errorControlador, alertaGuardado } from '../../../partials/alerts-config.js';
import { getBaseURL } from '../../../config.js';
let baseURL = getBaseURL();
$(document).ready(() => {
	validarFormEstado();

	// Control de UI para estado y justificación
	const $estadoSelect = $("#estadoSolicitud");
	const $btnActualizar = $("#actualizarEstadoOrganizacion");
	const $justificacionWrapper = $("#justificacion_wrapper");
	const $justificacion = $("#justificacionCambioEstado");

	const nivelUsuario = String(window.__nivelUsuario || "");
	const estadosExentosNivel0 = Array.isArray(window.__estadosSinJustificacionNivel0) ? window.__estadosSinJustificacionNivel0 : [];

	// Deshabilitar botón inicialmente hasta que el usuario seleccione un estado
	$btnActualizar.prop("disabled", true);

	function requiereJustificacion(estado) {
		if (!estado || estado === "Acreditado") return false;
		// Exento si es nivel 0 y el estado está en la lista de exentos
		if (nivelUsuario === "0" && estadosExentosNivel0.includes(estado)) return false;
		// Para el resto de estados (no acreditado, no exentos), sí requiere justificación
		return true;
	}

	function reevaluarHabilitacion() {
		const estado = $estadoSelect.val();

		if (!estado) {
			$justificacionWrapper.hide();
			$btnActualizar.prop("disabled", true);
			return;
		}

		if (requiereJustificacion(estado)) {
			$justificacionWrapper.slideDown();
			const texto = $.trim($justificacion.val());
			$btnActualizar.prop("disabled", texto.length === 0);
		} else {
			$justificacionWrapper.slideUp();
			$justificacion.val("");
			$btnActualizar.prop("disabled", false);
		}
	}

	$estadoSelect.on("change", reevaluarHabilitacion);
	$justificacion.on("input", reevaluarHabilitacion);

	/**
	 * Actualizar estado de la solicitud
	 */
	$("#actualizarEstadoOrganizacion").click(function () {
		const estadoSel = $estadoSelect.val();

		// Validaciones de UI
		if (!estadoSel) {
			mostrarAlerta('warning', 'Estado requerido', 'Seleccione un estado antes de actualizar');
			return;
		}
		const necesitaJustificacion = requiereJustificacion(estadoSel);
		if (necesitaJustificacion && $.trim($justificacion.val()) === '') {
			mostrarAlerta('warning', 'Justificación requerida', 'Debe escribir la justificación del cambio de estado');
			return;
		}

		let data = {
			idOrganizacion: $(this).attr("data-id-organizacion"),
			idSolicitud: $(this).attr("data-id-solicitud"),
			estadoSolicitud: estadoSel,
			justificacionCambioEstado: necesitaJustificacion ? $.trim($justificacion.val()) : ""
		};

		$.ajax({
			url: baseURL + "Solicitudes/actualizarEstadoSolicitud",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple('info', 'Cambiando estado');
			},
			success: function (response) {
				if(response.status === 'success') {
					alertaGuardado(response.title, response.msg, response.status).then(() => {
						location.reload();
					});
				}
				else {
					mostrarAlerta(response.status,response.title, response.msg).then(() => {
						location.reload();
					});
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
	$("#tabla_enProceso_organizacion tbody").on("click", '.ver_estado_org', function () {
		let id_org = $(this).attr("data-organizacion");
		$("#id_org_ver_form").remove();
		$("body").append("<div id='id_org_ver_form' class='hidden' data-id='" + id_org + "'>");
		let data = {
			id_organizacion: id_org,
			idSolicitud: $(this).attr("data-solicitud")
		};
		$.ajax({
			url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				console.log(response);
				$("#admin_ver_finalizadas").slideUp();
				$("#v_estado_org").slideDown();
				$("#actualizarEstadoOrganizacion").attr("data-id-organizacion", id_org);
				$("#actualizarEstadoOrganizacion").attr("data-id-solicitud", data["idSolicitud"]);
				$("#resolucion_nombre_org").html(response.organizaciones.nombreOrganizacion);
				$("#nit_organizacion").html(response.organizaciones.numNIT);
				$("#id_solicitud").html(response.estadoOrganizaciones.idSolicitud);
				$("#estado_actual_org").html(response.estadoOrganizaciones.nombre);
				$("#modalidad_solicitud").html(response.estadoOrganizaciones.modalidadSolicitudAcreditado);
				$("#motivo_solicitud").html(response.estadoOrganizaciones.motivoSolicitudAcreditado);
				$("#fecha_finalización").html(response.estadoOrganizaciones.fechaFinalizado);
			},
			error: function (ev) {
				//Do nothing
			},
		});
	});
	/** Validar formularios */
	function validarFormEstado () {
		// Formulario Login.
		$("form[id='formulario_estado']").validate({
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
				$(element).addClass("error").removeClass("success");
			},
			// Cuando el campo es válido, hace lo contrario: agrega 'is-valid' y remueve 'is-invalid'
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass("error").addClass("success");
			},
			rules: {
				numeroID: 	{
					required: true,
					minlength: 10,
				},
			},
			messages: {
				numeroID: {
					required: "Por favor, digite su numero de solicitud.",
					minlength: "El numero de solicitud tiene 10 dígitos o mas.",
				},
			},
		});
	}
})
