import {initSelects, cargarMunicipios, cargarArchivos, initInputFilePoint, reload} from "../../../../partials/other-funtions-init.js";
import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
	procesando,
	alertaGuardado,
	errorValidacionFormulario,
	showNotification, confirmarAccion
} from "../../../../partials/alerts-config.js";
import { getBaseURL } from "../../../../config.js";

// Configurar baseURL
const baseURL = getBaseURL();

$(document).ready(function() {
	cargarArchivos(2);
	initSelects();
	initInputFilePoint();
	// Cargar municipio por departamento
	$(".departamentos").change(function () {
		let departamento = $("#departamentos2").val();
		let select = $("#municipios2");
		cargarMunicipios(departamento, select)
	});
	/**
	 * Formulario 2: Formularios documentación legal
	 * */
	// Acciones check
	$(".camaraComercio").click(function () {
		if ($("input:radio[name=camaraComercio]:checked").val() == "Si") {
			$("#div_camara_comercio").show();
			$("#reg_doc_cond").show();
			$("#reg_doc_cond>a").removeAttr("style");
			$("#reg_doc_cond>a").html(
				'<span id="3" class="step_no">3</span> Camara de Comercio Entidad <i class="fa fa-newspaper-o" aria-hidden="true"></i>'
			);
			$("input:radio[name=registroEducativo]").attr("disabled", true);
			$("#div_registro_educativo").hide();
			$("input:radio[name=certificadoExistencia]").attr("disabled", true);
			$("#div_certificado_existencia").hide();
		} else {
			$("input:radio[name=registroEducativo]").attr("disabled", false);
			$("input:radio[name=certificadoExistencia]").attr("disabled", false);
			$("#div_camara_comercio").hide();
			$("#reg_doc_cond").hide();
		}
	});
	$(".certificadoExistencia").click(function () {
		if ($("input:radio[name=certificadoExistencia]:checked").val() == "Si") {
			$("#div_certificado_existencia").show();
			$("#reg_doc_cond").show();
			$("#reg_doc_cond>a").removeAttr("style");
			$("#reg_doc_cond>a").html(
				'<span id="3" class="step_no">3</span> Certificado Existencia <i class="fa fa-newspaper-o" aria-hidden="true"></i>'
			);
			$("input:radio[name=registroEducativo]").attr("disabled", true);
			$("#div_registro_educativo").hide();
			$("input:radio[name=camaraComercio]").attr("disabled", true);
			$("#div_camara_comercio").hide();
		} else {
			$("input:radio[name=registroEducativo]").attr("disabled", false);
			$("input:radio[name=camaraComercio]").attr("disabled", false);
			$("#div_certificado_existencia").hide();
			$("#reg_doc_cond").hide();
		}
	});
	$(".registroEducativo").click(function () {
		if ($("input:radio[name=registroEducativo]:checked").val() == "Si") {
			$("#div_registro_educativo").show();
			$("#reg_doc_cond").show();
			$("#reg_doc_cond>a").removeAttr("style");
			$("#reg_doc_cond>a").html(
				'<span id="3" class="step_no">3</span> Registros Educativos de Programas <i class="fa fa-newspaper-o" aria-hidden="true"></i>'
			); //('<small>(Finalizado)</small> <i class="fa fa-check" aria-hidden="true"></i>');
			$("input:radio[name=camaraComercio]").attr("disabled", true);
			$("#div_camara_comercio").hide();
			$("input:radio[name=certificadoExistencia]").attr("disabled", true);
			$("#div_certificado_existencia").hide();
		} else {
			$("input:radio[name=camaraComercio]").attr("disabled", false);
			$("input:radio[name=certificadoExistencia]").attr("disabled", false);
			$("#div_registro_educativo").hide();
			$("#reg_doc_cond").hide();
		}
	});
	// Guardar formulario certificado camara de comercio
	$("#guardar_formulario_camara_comercio").click(function () {
		// Capturar datos formulario
		let data = {
			tipo: 1,
			idSolicitud: $(this).attr("data-id"),
			id_organizacion: $(this).attr("data-idOrg"),
		};
		event.preventDefault();
		// Petición para guardar datos
		$.ajax({
			url: baseURL + "DocumentacionLegal/create",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple('info', 'Guardando..');
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
	});
	// Eliminar datos camara de comercio
	$(".eliminarDatosCamaraComercio").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			ruta: "uploads/camaraComercio/",
			tipo: 2,
		};
		eliminarFormularioDocumentacionLegal(data);
	});
	// Guardar certificado de existencia
	$("#guardar_formulario_certificado_existencia").click(function () {
		//$(this).attr("disabled", true);
		if ($("#formulario_certificado_existencia_legal").valid()) {
			let formData = new FormData();
			formData.append("file", $("#archivoCertifcadoExistencia").prop("files")[0]);
			formData.append("append_name", "CertificadoExistencia");
			formData.append(
				"entidadCertificadoExistencia",
				$("#entidadCertificadoExistencia").val()
			);
			formData.append("fechaExpedicion", $("#fechaExpedicion").val());
			formData.append("departamentoCertificado", $("#departamentos2").val());
			formData.append("municipioCertificado", $("#municipios2").val());
			formData.append("tipo", 2);
			formData.append("idSolicitud", $(this).attr("data-id"));
			event.preventDefault();
			console.log(formData);
			// Petición para guardar datos
			$.ajax({
				url: baseURL + "DocumentacionLegal/create",
				cache: false,
				contentType: false,
				processData: false,
				type: "post",
				dataType: "JSON",
				data: formData,
				beforeSend: function () {
					toastSimple('info', 'Guardando..');
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
		} else {
			errorValidacionFormulario();
		}
	});
	// Ver Documento Certificado Existencia
	$(".verDocCertificadoExistencia").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			formulario: 2.1,
		};
		verDocumentos(data);
	});
	// Eliminar datos certificado existencia
	$(".eliminarDatosCertificadoExistencia").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			ruta: "uploads/certificadoExistencia/",
			tipo: 2.1,
		};
		eliminarFormularioDocumentacionLegal(data);
	});
	// Guardar registro educativo
	$("#guardar_formulario_registro_educativo").click(function () {
		//$(this).attr("disabled", true);
		if ($("#formulario_registro_educativo").valid()) {
			let formData = new FormData();
			formData.append("tipoEducacion", $("#tipoEducacion").val());
			formData.append("fechaResolucionProgramas", $("#fechaResolucionProgramas").val());
			formData.append("numeroResolucionProgramas", $("#numeroResolucionProgramas").val());
			formData.append("nombrePrograma", $("#nombreProgramaResolucion").val());
			formData.append("objetoResolucionProgramas", $("#objetoResolucionProgramas").val());
			formData.append("entidadResolucion", $("#entidadResolucion").val());
			formData.append("file", $("#archivoRegistroEdu").prop("files")[0]);
			formData.append("append_name", "registroEdu");
			formData.append("tipo", 3);
			formData.append("idSolicitud", $(this).attr("data-id"));
			event.preventDefault();
			// Petición para guardar datos
			$.ajax({
				url: baseURL + "DocumentacionLegal/create",
				cache: false,
				contentType: false,
				processData: false,
				type: "post",
				dataType: "JSON",
				data: formData,
				beforeSend: function () {
					toastSimple('info', 'Guardando..');
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
					errorControlador(ev)
				},
			});
		} else {
			errorValidacionFormulario();
		}
	});
	// Ver Documento Registro Educativo
	$(".verDocRegistro").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			formulario: 2.2,
		};
		verDocumentos(data);
	});
	// Eliminar datos registro educativo
	$(".eliminarDatosRegistro").click(function () {
		let data = {
			id: $(this).attr("data-id"),
			ruta: "uploads/registrosEducativos/",
			tipo: 2.2,
		};
		eliminarFormularioDocumentacionLegal(data);
	});
	// Funciones formulario 2
	// Función Ver Documentos
	function verDocumentos(data) {
		event.preventDefault();
		$.ajax({
			url: baseURL + "panel/verDocumento",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				window.open(response.file, "_blank");
			},
		});
	}
	// Función Eliminar Datos Form 2
	function eliminarFormularioDocumentacionLegal(data) {
		confirmarAccion("¿Realmente desea eliminar este registro?", "Eliminar documentación legal", "warning", 'popup-swalert-lg').then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "DocumentacionLegal/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Eliminando..');
					},
					success: function (response) {
						if (response.status === "success") {
							alertaGuardado(response.title, response.msg, response.status);
							$('.eliminarDataTabla').click
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
	}
	// Formulario Certificado de existencia
	$("form[id='formulario_certificado_existencia_legal']").validate({
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
			entidadCertificadoExistencia: {
				required: true,
			},
			fechaExpedicion: {
				required: true,
			},
			departamentos2: {
				required: true,
			},
			municipios2: {
				required: true,
			},
			archivoCertifcadoExistencia: {
				required: true,
			},
		},
		messages: {
			entidadCertificadoExistencia: {
				required: "Entidad requerida, por favor ingresarlo.",
			},
			fechaExpedicion: {
				required: "Fecha requerida, por favor ingresarlo.",
			},
			departamentos2: {
				required: "Departamento requerido, por favor ingresarlo.",
			},
			municipios2: {
				required: "Municipio requerido, por favor ingresarlo.",
			},
			archivoCertifcadoExistencia: {
				required: "Archivo requerido, por favor ingresarlo.",
			},
		},
	});
	// Formulario registro educativo
	$("form[id='formulario_registro_educativo']").validate({
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
			tipoEducacion: {
				required: true,
			},
			fechaResolucionProgramas: {
				required: true,
			},
			numeroResolucionProgramas: {
				required: true,
			},
			nombreProgramaResolucion: {
				required: true,
			},
			objetoResolucionProgramas: {
				required: true,
			},
			entidadResolucion: {
				required: true,
			},
			archivoRegistroEdu: {
				required: true,
			},
		},
		messages: {
			tipoEducacion: {
				required: "Tipo educación requerida, por favor ingresarla.",
			},
			fechaResolucionProgramas: {
				required: "Fecha requerida, por favor ingresarla.",
			},
			numeroResolucionProgramas: {
				required: "Numero de resolución requerida, por favor ingresarlo.",
			},
			nombreProgramaResolucion: {
				required: "Nombre del programa requerido, por favor ingresarlo.",
			},
			objetoResolucionProgramas: {
				required:
					"Objeto de la resolución requerida, por favor ingresarlo.",
			},
			entidadResolucion: {
				required:
					"Entidad quien emite la resolución requerida, por favor ingresarla.",
			},
			archivoRegistroEdu: {
				required: "Archivo requerido, por favor adjuntarlo.",
			},
		},
	});
});
