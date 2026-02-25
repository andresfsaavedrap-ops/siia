import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
	alertaGuardado,
	showNotification,
	confirmarAccion,
	procesando
} from "../../../partials/alerts-config.js";
import { 
	initSelects,
	reload 
} from "../../../partials/other-funtions-init.js";
import { datatableInit } from "../../../partials/datatable-init.js";

$(document).ready(function() {
	validarFormAsistente();
	/**
	 * Modal crear/actualizar administrador
	 */
	$(".asistente-modal").click(function () {
		let funct = $(this).attr('data-funct');
		if (funct === 'crear') {
			$('#title-modal-asistentes').text('Crear asistente');
			$('#guardarAsistente').html('Crear Asistente <i class="fa fa-check" aria-hidden="true"></i>');
			$('#guardarAsistente').attr('data-func', 'crear');
			$("#primerApellidoAsistente").val('');
			$("#segundoApellidoAsistente").val('');
			$("#primerNombreAsistente").val('');
			$("#segundoNombreAsistente").val('');
			$("#numeroDocumentoAsistente").val('');
			$("#numNITOrganizacion").val('');
			$("#nombreOrganizacion").val('');
			$("#informe_departamento_curso option[value='']").prop('selected', true);
			$("#informe_municipio_curso option[value='']").prop('selected', true);
			$("#telefono").val('');
			$("#correoElectronico").val('');
			$("#edad").val('');
			$("#genero option[value='']").prop('selected', true);
			$("#escolaridad option[value='']").prop('selected', true);
			$("#enfoqueDiferencial option[value='']").prop('selected', true);
			$("#condicionVulnerabilidad option[value='']").prop('selected', true);
			$("#discapacidad option[value='']").prop('selected', true);
		}
		else {
			$('#title-modal-asistentes').text('Actualizar asistente');
			$('#guardarAsistente').html('Actualizar Asistente <i class="fa fa-check" aria-hidden="true"></i>');
			$('#guardarAsistente').attr('data-func', 'actualizar');
			$('#guardarAsistente').attr('data-id', $(this).attr("data-id"));
			// Data asistente
			let data = {
				id: $(this).attr("data-id"),
			};
			$.ajax({
				url: baseURL + "Asistentes/cargarDatosAsistente",
				type: "post",
				dataType: "JSON",
				data: data,
				success: function (response) {
					console.log(response);
					$("#primerApellidoAsistente").val(response.primerApellidoAsistente);
					$("#segundoApellidoAsistente").val(response.segundoApellidoAsistente);
					$("#primerNombreAsistente").val(response.primerNombreAsistente);
					$("#segundoNombreAsistente").val(response.segundoNombreAsistente);
					$("#numeroDocumentoAsistente").val(response.numeroDocumentoAsistente);
					$("#numNITOrganizacion").val(response.numNITOrganizacion);
					$("#nombreOrganizacion").val(response.nombreOrganizacion);
					$("#informe_departamento_curso option[value='" + response.departamentoResidencia + "']").prop("selected", true);
					$("#telefono").val(response.telefono);
					$("#correoElectronico").val(response.correoElectronico);
					$("#edad").val(response.edad);
					$("#genero option[value='" + response.genero + "']").prop("selected", true);
					$("#escolaridad option[value='" + response.escolaridad + "']").prop("selected", true);
					$("#enfoqueDiferencial option[value='" + response.enfoqueDiferencial + "']").prop("selected", true);
					$("#condicionVulnerabilidad option[value='" + response.condicionVulnerabilidad + "']").prop("selected", true);
					$("#discapacidad option[value='" + response.discapacidad + "']").prop("selected", true);
				},
				error: function (ev) {
					errorControlador(ev)
				},
			});
		}
	});
	/**
	 * Crear administrador
	 */
	$("#guardarAsistente").click(function () {
		if ($("#formulario_asistente").valid()) {
			//Datos formulario
			var data = {
				primerApellidoAsistente: $("#primerApellidoAsistente").val(),
				segundoApellidoAsistente: $("#segundoApellidoAsistente").val(),
				primerNombreAsistente: $("#primerNombreAsistente").val(),
				segundoNombreAsistente: $("#segundoNombreAsistente").val(),
				numeroDocumentoAsistente: $("#numeroDocumentoAsistente").val(),
				numNITOrganizacion: $("#numNITOrganizacion").val(),
				nombreOrganizacion: $("#nombreOrganizacion").val(),
				departamentoResidencia: $("#informe_departamento_curso").val(),
				municipioResidencia: $("#informe_municipio_curso").val(),
				telefono: $("#telefono").val(),
				correoElectronico: $("#correoElectronico").val(),
				edad: $("#edad").val(),
				genero: $("#genero").val(),
				escolaridad: $("#escolaridad").val(),
				enfoqueDiferencial: $("#enfoqueDiferencial").val(),
				condicionVulnerabilidad: $("#condicionVulnerabilidad").val(),
				discapacidad: $("#discapacidad").val(),
				id_informe: curso_id,
			};
			let funct = $(this).attr('data-func');
			if (funct === 'crear') {
				$.ajax({
					url: baseURL + "Asistentes/create",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Guardando datos');
					},
					success: function (response) {
						if(response.status === 'success') {
							mostrarAlerta(response.status, response.title, response.msg).then((result) => {
								if (result.isConfirmed) {
									reload();
								}
							})
						}
						else {
							alertaGuardado(response.title ,response.msg, response.status)
						}
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
			else {
				data['id_asistente'] = $(this).attr('data-id');
				$.ajax({
					url: baseURL + "Asistentes/update",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Guardando datos');
					},
					success: function (response) {
						if(response.status === 'success') {
							mostrarAlerta(response.status, response.title, response.msg).then((result) => {
								if (result.isConfirmed) {
									reload();
								}
							})
						}
						else {
							alertaGuardado(response.title ,response.msg, response.status)
						}
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		}
		else {
			showNotification('Por favor, llene los datos requeridos.',  'warning')
		}
	});
	// Validar formulario
	function validarFormAsistente () {
		// Formulario Login.
		$("form[id='formulario_asistente']").validate({
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
				primerApellidoAsistente: {
					required: true,
				},
				primerNombreAsistente: {
					required: true,
				},
				numeroDocumentoAsistente: {
					required: true,
				},
				informe_departamento_curso: {
					required: true,
				},
				informe_municipio_curso: {
					required: true,
				},
				edad: {
					required: true,
					maxlength: 2,
				},
				genero: {
					required: true,
				},
				escolaridad: {
					required: true,
				},
				enfoqueDiferencial: {
					required: true,
				},
				condicionVulnerabilidad: {
					required: true,
				},
				discapacidad: {
					required: true,
				},
			},
			messages: {
				primerApellidoAsistente: {
					required: 'Ingrese primer apellido'
				},
				primerNombreAsistente: {
					required: "Ingrese primer nombre",
				},
				numeroDocumentoAsistente: {
					required: "Ingrese número de documento",
				},
				informe_departamento_curso: {
					required: "Ingrese el departamento de residencia",
				},
				informe_municipio_curso: {
					required: "Ingrese el municipio de residencia",
				},
				edad: {
					required: "Ingrese la edad",
					maxlength: "Solo se permiten 2 dígitos"
				},
				genero: {
					required: "Ingrese genero",
				},
				escolaridad: {
					required: "Ingrese escolaridad",
				},
				enfoqueDiferencial: {
					required: "Ingrese enfoque diferencial",
				},
				condicionVulnerabilidad: {
					required: "Ingrese condición",
				},
				discapacidad: {
					required: "Ingrese discapacidad",
				},
			},
		});

	}
	// Ver asistente a cursos
	$("#cargar_archivo_excel_asistentes").click(function () {
		var data_name = $(".archivoAsistentes").attr("data-name");
		var file_data = $("#" + data_name).prop("files")[0];
		var form_data = new FormData();
		form_data.append("file", file_data);
		form_data.append("append_name", data_name);
		form_data.append("curso_id", curso_id);
		$.ajax({
			url: baseURL + "Asistentes/excelAsistentes",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				procesando("info", 'Cargando asistentes')
			},
			success: function (response) {
				if(response.status === 'success') {
					mostrarAlerta(response.status, response.title, response.msg).then((result) => {
						if (result.isConfirmed) {
							reload();
						}
					})
				}
				else {
					alertaGuardado(response.title ,response.msg, response.status);
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
	/**
	 * Eliminar asistente
	 */
	$(".eliminar_asistente").click(function () {
		let data = {
			id: $(this).attr("data-id"),
		};
		confirmarAccion('Borrar Asistente!', 'Esta acción no se puede deshacer, eliminara el asistente al curso, desea borrar realmente ?', 'warning').then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "Asistentes/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSubmit: function () {
						procesando("info", 'Eliminado asistente')
					},
					success: function (response) {
						if(response.status === 'success') {
							mostrarAlerta(response.status, response.title, response.msg).then((result) => {
								if (result.isConfirmed) {
									reload();
								}
							})
						}
						else {
							alertaGuardado(response.title ,response.msg, response.status)
						}
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		})
	});
	/**
	 * Editar asistente
	 */
	$(".editar_asistente").click(function () {
		let data = {
			id: $(this).attr("data-id"),
		};
		$.ajax({
			url: baseURL + "Asistentes/delete",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSubmit: function () {
				procesando("info", 'Eliminado curso')
			},
			success: function (response) {
				if(response.status === 'success') {
					alertaGuardado(response.title ,response.msg, response.status)
					reload();
				}
				else {
					alertaGuardado(response.title ,response.msg, response.status)
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
	// TODO: Terminar edición informe
	$(document).on("click", ".editarAsistente", function () {
		$id_asistente = $(this).attr("data-id-ass");
		data = {
			id_asistente: $id_asistente,
		};
		$.ajax({
			url: baseURL + "panel/cargar_informacionAsistente",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				$("#editarAsistenteDiv").slideUp();
				$("#EdasisID").html("");
				$("#editarAsisPN").val("");
				$("#editarAsisSN").val("");
				$("#editarAsisPA").val("");
				$("#editarAsisPA").val("");
				$("#editarAsisNumero").val("");
				$("#editarAsisDireccion").val("");
				//*******
				$("#EdasisID").html(response.informacion.id_asistentes);
				$("#editarAsisPN").val(response.informacion.primerNombreAsistente);
				$("#editarAsisSN").val(response.informacion.segundoNombreAsistente);
				$("#editarAsisPA").val(response.informacion.primerApellidoAsistente);
				$("#editarAsisSA").val(response.informacion.segundoApellidoAsistente);
				$("#editarAsisTipo").selectpicker(
					"val",
					response.informacion.tipoDocumentoAsistente
				);
				$("#editarAsisNumero").val(
					response.informacion.numeroDocumentoAsistente
				);
				$("#editarAsisDireccion").val(
					response.informacion.direccionCorreoElectronicoAsistente
				);
				$("#editarAsistenteDiv").slideDown();
			},
			error: function (ev) {
				//Do nothing
			},
		});
	});
});
