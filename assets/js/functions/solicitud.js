import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
} from "./partials/alerts-config.js";
import { initSelects } from "./partials/other-funtions-init.js";
import { datatableInit } from "./partials/datatable-init.js";
import { bindHistorialObservacionesClick } from "./partials/getObsRequest.js";
$(document).ready(function () {
	let url = unescape(window.location.href);
	if (url.includes("?")) {
		url = url.split("?")[0];
	}
	const solicitud = url.substr(url.lastIndexOf("/") + 1);
	const activate = url.split("/");
	const baseURL = activate[0] + "//" + activate[2] + "/" + activate[3] + "/";
	const siValidadForm = solicitud.substring(0, 2);
	// Variable para almacenar el paso actual
	let currentStep = 1;
	// Función para actualizar la barra de progreso
	function updateProgressBar(stepNumber) {
		// Obtener el número total de pasos
		const totalSteps = $(".step").length;
		// Calcular el porcentaje para la barra de progreso
		let percentage;
		if (stepNumber === 0) {
			percentage = 0; // Inicia proceso
		} else if (stepNumber === 100) {
			percentage = 100; // Finalizar proceso
		} else {
			percentage = ((stepNumber - 1) / (totalSteps - 1)) * 100;
		}
		// Animar la barra de progreso
		$(".progress-bar").animate(
			{
				width: percentage + "%",
			},
			300
		);
		// Actualizar las clases de los pasos
		$(".step").each(function () {
			const stepNum = $(this).data("step");
			// Eliminar todas las clases de estado
			$(this).removeClass("active completed incomplete");
			// Si el paso es menor que el actual, lo marcamos como completado
			if (stepNum < stepNumber) {
				$(this).addClass("completed");
			}
			// Si el paso es igual al actual, lo marcamos como activo
			else if (stepNum == stepNumber) {
				$(this).addClass("active");
			}
		});
		// Actualizar la variable de paso actual
		currentStep = stepNumber;
	}
	// Función para cargar el contenido del formulario
	function loadFormContent(formId, formName) {
		// Mostrar indicador de carga
		$("#main-content").html(
			'<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i><p class="mt-3">Cargando formulario...</p></div>'
		);
		// Realizar la petición AJAX para cargar el formulario
		$.ajax({
			url: baseURL + "solicitudes/cargarFormulario", // Ajusta esta URL según tu estructura de controladores
			type: "POST",
			data: {
				idFormulario: formId,
				nombreFormulario: formName,
				idSolicitud: $("#id_solicitud").val(), // Campo ocúlto en solicitud.php
			},
			dataType: "html",
			success: function (response) {
				// Insertar el contenido del formulario en el contenedor principal
				$("#main-content").html(response);
				// Función para verificar si estamos en la URL deseada
				function isDesiredURL(urlPattern) {
					// Obtén la URL actual
					const currentURL = window.location.href;
					// Verifica si la URL actual coincide con el patrón deseado
					// Puedes usar includes() para una coincidencia simple o expresiones regulares para algo más complejo
					return currentURL.includes(urlPattern);
				}
				if (isDesiredURL(baseURL + "solicitudes/solicitud/" + solicitud)) {
					if (history.pushState) {
						const newUrl = updateURLParameter(
							window.location.href,
							"form",
							formId
						);
						window.history.pushState(
							{ formId: formId, formName: formName },
							"",
							newUrl
						);
					}
				}
			},
			error: function (xhr, status, error) {
				// Manejar errores
				$("#main-content").html(
					'<div class="alert alert-danger">' +
						"<h4>Error al cargar el formulario</h4>" +
						"<p>Por favor, intente nuevamente o contacte al administrador.</p>" +
						"<p>Detalle: " +
						error +
						"</p>" +
						"</div>"
				);
			},
		});
	}
	// Función para actualizar parámetros en la URL (para historial)
	function updateURLParameter(url, param, paramVal) {
		let newAdditionalURL = "";
		let tempArray = url.split("?");
		let baseURL = tempArray[0];
		let additionalURL = tempArray[1];
		let temp = "";
		if (additionalURL) {
			tempArray = additionalURL.split("&");
			for (let i = 0; i < tempArray.length; i++) {
				if (tempArray[i].split("=")[0] != param) {
					newAdditionalURL += temp + tempArray[i];
					temp = "&";
				}
			}
		}
		let rows_txt = temp + "" + param + "=" + paramVal;
		return baseURL + "?" + newAdditionalURL + rows_txt;
	}
	// Manejador de clic en los pasos del menú
	$(".step-icon").on("click", function () {
		const formId = $(this).data("form");
		const formName = $(this).data("form-name");
		// Actualizar la barra de progreso
		updateProgressBar(parseInt(formId));
		// Cargar el contenido del formulario
		loadFormContent(formId, formName);
		// Menú colapsable en móvil
		if (
			$(window).width() < 768 &&
			$(".progress-container").hasClass("expanded")
		) {
			$(".progress-container").removeClass("expanded");
		}
	});
	// Manejador para el botón de inicio (ver solicitud)
	$(".home-link").on("click", function (e) {
		e.preventDefault();
		const solicitudId = $(this).data("id");
		// Resetear progreso y mostrar página de inicio
		updateProgressBar(0); // O el valor que corresponda al inicio
		// Cargar la vista de resumen de solicitud
		loadFormContent("inicio", "inicio");
		// Verificar formularios
		verificarFormularios(solicitud);
	});
	// Botón explícito para validar solicitud en el encabezado
	$("#btn-validar-solicitud").on("click", function (e) {
		e.preventDefault();
		$(".home-link").trigger("click");
	});
	// Manejador para el botón de ocultar/mostrar menú
	$("#hide-sidevar").on("click", function (e) {
		e.preventDefault();
		var content = $(".sidebar-content");
		var btn = $(this);
		// Alterna la animación
		content.stop(true, true).slideToggle(300, function () {
			// Cuando termine la animación, cambiamos icono/texto
			if (content.is(":hidden")) {
				btn.html(
					'<i class="fa fa-window-maximize" aria-hidden="true"></i><v>MOSTRAR MENÚ</v>'
				);
			} else {
				btn.html(
					'<i class="fa fa-times" aria-hidden="true"></i><v>OCULTAR MENÚ</v>'
				);
			}
		});
	});
	// Función para avanzar al siguiente paso desde un botón dentro del formulario
	window.nextStep = function () {
		if (currentStep < $(".step").length) {
			const nextStepElement = $(
				'.step[data-step="' + (currentStep + 1) + '"] .step-icon'
			);
			nextStepElement.trigger("click");
		}
	};
	// Función para retroceder al paso anterior desde un botón dentro del formulario
	window.prevStep = function () {
		if (currentStep > 1) {
			const prevStepElement = $(
				'.step[data-step="' + (currentStep - 1) + '"] .step-icon'
			);
			prevStepElement.trigger("click");
		}
	};
	// Detectar si hay un parámetro de formulario en la URL para cargar directamente
	const urlParams = new URLSearchParams(window.location.search);
	const formParam = urlParams.get("form");
	if (formParam) {
		// Si hay un parámetro de formulario, intentar cargar ese formulario
		const stepElement = $('.step-icon[data-form="' + formParam + '"]');
		if (stepElement.length) {
			// Simular clic en ese paso
			stepElement.trigger("click");
		} else {
			// Si no existe el paso, cargar el primer formulario
			// Resetear progreso y mostrar página de inicio
			updateProgressBar(0); // O el valor que corresponda al inicio
			// Cargar la vista de resumen de solicitud
			loadFormContent("inicio", "inicio");
			// Validar que seán formularios de los años 2000 para delante
			if (siValidadForm === "20") {
				verificarFormularios(solicitud);
			}
		}
	} else {
		// Cargar el primer formulario por defecto
		// Resetear progreso y mostrar página de inicio
		updateProgressBar(0); // O el valor que corresponda al inicio
		// Cargar la vista de resumen de solicitud
		loadFormContent("inicio", "inicio");
		// Validar que seán formularios de los años 2000 para delante
		if (siValidadForm === "20") {
			verificarFormularios(solicitud);
		}
	}
	// Manejador para botones de navegación dentro de los formularios
	$(document).on("click", ".btn-next", function () {
		// Validar el formulario actual antes de avanzar
		const currentForm = $("#form-" + currentStep);
		if (currentForm.length && typeof currentForm.valid === "function") {
			if (currentForm.valid()) {
				// Si el formulario es válido, guardar y avanzar
				saveFormData(currentStep, function () {
					nextStep();
				});
			}
		} else {
			// Si no hay validación, simplemente avanzar
			nextStep();
		}
	});
	$(document).on("click", ".btn-prev", function () {
		prevStep();
	});
	// Función para guardar datos del formulario mediante AJAX
	function saveFormData(formId, callback) {
		const formElement = $("#form-" + formId);
		if (formElement.length) {
			$.ajax({
				url: formElement.attr("action"),
				type: "POST",
				data: formElement.serialize(),
				dataType: "json",
				success: function (response) {
					if (response.success) {
						// Mostrar mensaje de éxito
						showNotification(
							"success",
							"Los datos se han guardado correctamente"
						);

						// Marcar el paso como completado
						$('.step[data-step="' + formId + '"]').addClass("completed");

						// Ejecutar callback si existe
						if (typeof callback === "function") {
							callback();
						}
					} else {
						// Mostrar errores
						showNotification(
							"error",
							response.message || "Error al guardar los datos"
						);
					}
				},
				error: function () {
					showNotification("error", "Error de conexión. Intente nuevamente.");
				},
			});
		} else if (typeof callback === "function") {
			// Si no hay formulario, ejecutar callback de todas formas
			callback();
		}
	}
	// Función para mostrar notificaciones
	function showNotification(type, message) {
		const iconClass =
			type === "success" ? "fa-check-circle" : "fa-exclamation-circle";
		const alertClass = type === "success" ? "alert-success" : "alert-danger";
		const notification = $(
			'<div class="alert ' +
				alertClass +
				' alert-dismissible fade show">' +
				'<i class="fa ' +
				iconClass +
				' mr-2"></i>' +
				message +
				'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
				"</div>"
		);
		$("#notification-container").html(notification);
		// Auto-ocultar después de 5 segundos
		setTimeout(function () {
			notification.alert("close");
		}, 5000);
	}
	/**
	 * Verificar solicitud
	 */
	function verificarFormularios(solicitud) {
		$("#formulariosFaltantes").empty();
		let data = {
			solicitud: solicitud,
		};
		$.ajax({
			url: baseURL + "solicitudes/cargarEstadoSolicitud",
			data: data,
			type: "post",
			dataType: "JSON",
			success: function (response) {
				// 1. Limpiamos clases
				$(".step").removeClass("completed current");
				// 2. Recorremos formularios para marcar pasos
				response.formularios.forEach(function (formItem) {
					// Añadir formularios faltantes a DIV
					$("#formulariosFaltantes").append("<p>" + formItem + "</p>");
					// Eliminar etiquetas <strong> (y su contenido) usando una expresión regular
					formItem = formItem.replace(/^<strong>|<\/strong>$/g, "");
					let stepNumber = parseInt(formItem.split(".")[0], 10);
					// 3. Marcamos incompleto si no es el paso actual
					$('.step[data-step="' + stepNumber + '"]').addClass("incomplete");
				});
				// Si la solicitud esta en observaciones muestra un modal diferente
				if (response.solicitud.nombre === "En Observaciones") {
					if (response.icon === "success") {
						$("#actualizar_solicitud").hide();
					}
					mostrarAlerta(response.icon, response.title, response.msg);
				} else {
					mostrarAlerta(
						response.icon,
						response.title,
						response.msg + $("#formulariosFaltantes").html()
					);
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	}
	// Enlazar el botón de historial de observaciones del usuario
	bindHistorialObservacionesClick("#hist_org_obs");
});
