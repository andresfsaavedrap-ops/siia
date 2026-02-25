// Importaciones necesarias
import { toastSimple, mostrarAlerta, procesando, errorControlador, confirmarAccion, errorValidacionFormulario } from '../../partials/alerts-config.js';
import { redirect, reload } from '../../partials/other-funtions-init.js';
import { getBaseURL } from '../../config.js';

// Configurar baseURL
const baseURL = getBaseURL();

// Inicializar validación del formulario cuando el DOM esté listo
$(document).ready(function() {
    ValidarFormNitEntidades();
});
// Cargar Datos Organización por NIT
$("#nit_acre_org").change( function (){
	let html = "";
	let data = {
		id: $("#nit_acre_org").val()
	};
	$.ajax({
		url: baseURL + "Nit/cargarDatosOrganizacion",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			toastSimple("success", response.msg);
			let nombreOrganizacion = response.organizacion.nombreOrganizacion;
			let resoluciones = response.resoluciones;
			$("#nombre_acre_org").val(nombreOrganizacion);
			html += "<option value='' selected>Seleccionar Resolución</option>"
			// Recorrer respuesta del controlador
			$.each(resoluciones, function (key, resolucion) {
				// Guardar opción html en variable
				html += "<option value=" + resolucion.numeroResolucion + " data-id=" + resolucion.id_resoluciones + ">" + resolucion.numeroResolucion + "</option>";
			});
			// Añadir variable de opción html al select de municipio
			$("#res_acre_org").html(html);
			$("#res_acre_org").prop('disabled', false);
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
// Cargar Fecha Fin Resolución Acreditada
$("#res_acre_org").change( function (){
	$("#fech_fin_acre_org").val('');
	let data = {
		idResolucion: $("#res_acre_org option:selected").attr('data-id')
	};
	$.ajax({
		url: baseURL + "Nit/cargarDatosResolucion",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			toastSimple("success", response.msg);
			if(response.resolucion.fechaResolucionFinal){
				$("#fech_fin_acre_org").val(response.resolucion.fechaResolucionFinal);
			}else {
				toastSimple("warning", "Resolución sin fecha de finalización");
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
// Guardar NIT Acreditado
$("#guardar_nit_org_acre").click(function () {
	// Validar formulario antes de proceder
	if (!$("#formNitEntidades").valid()) {
		errorValidacionFormulario();
		return;
	}

	// Validar que la resolución no esté ya registrada
	let numeroResolucion = $("#res_acre_org").val();
	let numNIT = $("#nit_acre_org").val();
	// Verificar si la resolución ya existe
	$.ajax({
		url: baseURL + "nit/verificarResolucionExistente",
		type: "post",
		dataType: "JSON",
		data: { numeroResolucion: numeroResolucion, numNIT: numNIT },
		success: function (response) {
			if (response.existe) {
				mostrarAlerta("warning", 'Resolución ya registrada', 
					`La resolución ${numeroResolucion} ya está registrada en el sistema para la organización con NIT ${numNIT}. Por favor, seleccione una resolución diferente.`);
				return;
			}
			// Si la resolución no existe, proceder con el guardado
			guardarNitAcreditado();
		},
		error: function (ev) {
			errorControlador(ev);
		}
	});
});

// Función para guardar el NIT acreditado
function guardarNitAcreditado() {
	let data = {
		nit_org: $("#nit_acre_org").val(),
		nombreOrganizacion: $("#nombre_acre_org").val(),
		numeroResolucion: $("#res_acre_org").val(),
		fechaFinalizacion: $("#fech_fin_acre_org").val(),
	};
	$.ajax({
		url: baseURL + "nit/guardarNitAcreditadas",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			$("#guardar_nit_org_acre").attr("disabled", true);
			toastSimple("info", "Guardando información...");
		},
		success: function (response) {
			mostrarAlerta("success", 'NIT Acreditado guardado exitosamente', response.msg).then(() => {
				reload();
			});
		},
		error: function (ev) {
			errorControlador(ev);
		},
		complete: function () {
			$("#guardar_nit_org_acre").attr("disabled", false);
		}
	});
}
// Eliminar NIT Acreditado
$(".eliminarNitAcreOrg").click(function () {
	confirmarAccion(
		"Eliminar NIT Acreditado",
		"¿Está seguro de eliminar el NIT Acreditado?",
		"warning",
		"popup-swalert-lg"
	).then((result) => {
		if (!result.isConfirmed) return;
		let data = {
			id_nit: $(this).attr("data-id-nit"),
		};
		$.ajax({
			url: baseURL + "Nit/eliminarNitAcreditadas",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				mostrarAlerta("success", 'NIT Acreditado eliminado exitosamente', response.msg).then(() => {
					reload();
				});
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
});

/**
 * Validar formulario de NIT Entidades
 */
function ValidarFormNitEntidades() {
	$("form[id='formNitEntidades']").validate({
		// Elemento que contendrá el mensaje de error
		errorElement: "div",
		// Clase que usará el mensaje de error
		errorClass: "invalid-feedback",
		// Mensaje de error para mantener el layout consistente
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
		// Cuando el campo es válido, hace lo contrario
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid").addClass("is-valid");
		},
		rules: {
			nit_acre_org: {
				required: true
			},
			res_acre_org: {
				required: true,
				minlength: 1
			},
			fech_fin_acre_org: {
				required: true,
				date: true
			}
		},
		messages: {
			nit_acre_org: {
				required: "<p class='forms-error'>Por favor, seleccione una organización.</p>"
			},
			res_acre_org: {
				required: "<p class='forms-error'>Por favor, seleccione una resolución.</p>"
			},
			fech_fin_acre_org: {
				required: "<p class='forms-error'>Por favor, ingrese la fecha de finalización.</p>",
				date: "<p class='forms-error'>Por favor, ingrese una fecha válida.</p>"
			}
		}
	});
}
