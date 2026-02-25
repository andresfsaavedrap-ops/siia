import { initSelects,  cargarMunicipios,  cargarArchivos, initInputFile, reload, clearInputs } from "../../../../partials/other-funtions-init.js";
import {
	errorValidacionFormulario,
	toastSimple,
	errorControlador,
	mostrarAlerta,
	procesando,
	alertaGuardado, confirmarAccion
} from "../../../../partials/alerts-config.js";
import { getBaseURL } from "../../../../config.js";
// Configurar baseURL
const baseURL = getBaseURL();
$(document).ready(function() {
	cargarArchivos(1);
	initSelects();
	initInputFile();
	// Cargar municipio por departamento
	$(".departamentos").change(function () {
		let departamento = $("#departamentos").val();
		let select = $("#municipios");
		cargarMunicipios(departamento, select)
	});
	/**
	 * Formulario 1: formulario información general
	 * */
	// Guardar formulario 1
	$("#guardar_formulario_informacion_general_entidad").click(function () {
		if ($("#formulario_informacion_general_entidad").valid()) {
			$(this).attr("disabled", true);
			let data = {
				tipo_organizacion: $("#tipo_organizacion").val(),
				departamento: $("#departamentos").val(),
				municipio: $("#municipios").val(),
				direccion: $("#direccion").val(),
				fax: $("#fax").val(),
				extension: $("#extension").val(),
				correoElectronicoOrganizacion: $("#correoElectronicoOrganizacion").val(),
				urlOrganizacion: $("#urlOrganizacion").val(),
				actuacion: $("#actuacion").val(),
				educacion: $("#educacion").val(),
				primerNombreRepLegal: $("#primerNombreRepLegal").val(),
				segundoNombreRepLegal: $("#segundoNombreRepLegal").val(),
				primerApellidoRepLegal: $("#primerApellidoRepLegal").val(),
				segundoApellidoRepLegal: $("#segundoApellidoRepLegal").val(),
				correoElectronicoRepLegal: $("#correoElectronicoRepLegal").val(),
				numCedulaCiudadaniaPersona: $("#numCedulaCiudadaniaPersona").val(),
				presentacion: $("#presentacion").val(),
				objetoSocialEstatutos: $("#objetoSocialEstatutos").val(),
				mision: $("#mision").val(),
				vision: $("#vision").val(),
				principios: $("#principios").val(),
				fines: $("#fines").val(),
				portafolio: $("#portafolio").val(),
				otros: $("#otros").val(),
			};
			$.ajax({
				url: baseURL + "InformacionGeneral/create",
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
		} else {
			errorValidacionFormulario();
		}
	});
	// Eliminar archivos
	$(document).on("click", ".eliminar_archivo", function () {
		confirmarAccion('Eliminar archivo', '¿Realmente desea eliminar este archivo?', 'warning', 'popup-swalert-lg').then((result) => {
			if (result.isConfirmed) {
				let data = {
					id_formulario: $(this).attr("data-id-formulario"),
					id_archivo: $(this).attr("data-id-archivo"),
					tipo: $(this).attr("data-id-tipo"),
					nombre: $(this).attr("data-nombre-ar"),
				};
				$.ajax({
					url: baseURL + "Archivos/delete",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple('info', 'Eliminando')
					},
					success: function (response) {
						alertaGuardado('Archivo eliminado', response.msg)
						cargarArchivos(1);
					},
					error: function (ev) {
						errorControlador()
					},
				});
			}
		});
	});
	// Guardar archivos tipo carta
	$(".archivos_form_carta").on("click", function () {
		let data_name = $(".archivos_form_carta").attr("data-name");
		let form_data = new FormData();
		form_data.append("file", $("#" + data_name).prop("files")[0]);
		form_data.append("tipoArchivo", $("#" + data_name).attr("data-val"));
		form_data.append("append_name", data_name);
		form_data.append("id_form", $(".archivos_form_carta").attr("data-form"));
		form_data.append(
			"idSolicitud",
			$(".archivos_form_carta").attr("data-solicitud")
		);
		$.ajax({
			url: baseURL + "Archivos/create",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				toastSimple('info', 'Guardando')
			},
			success: function (response) {
				cargarArchivos(1);
				if (response.icon === "success") {
					// Borra todo el contenido interno del label
					$("#" + data_name).val("");
					$('label.custom-file-label[for="carta"]').empty();
					$('label.custom-file-label[for="carta"]').text('Seleccionar archivo...');
					alertaGuardado('Archivo guardado', response.msg)
				} else {
					mostrarAlerta(response.icon, 'Error al guardar', response.msg)
				}
			},
			error: function (ev) {
				errorControlador(ev)
			},
		});
	});
	// Guardar archivos tipo certificaciones
	$(".archivos_form_certificacion").on("click", function () {
		let data_name = $(this).attr("data-name");
		var form_data = new FormData();
		let count = 0;
		$.each(
			$("#formulario_certificaciones input[type='file']"),
			function (obj, v) {
				var file = v.files[0];
				if (file !== undefined) {
					form_data.append("file[" + obj + "]", file);
					count++;
				}
			}
		);
		if (count === 3)  {
			form_data.append("tipoArchivo", $("#" + data_name + "1").attr("data-val"));
			form_data.append("append_name", data_name);
			form_data.append("idSolicitud", $(this).attr("data-solicitud"));
			$.ajax({
				url: baseURL + "archivos/uploadFiles",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: "post",
				dataType: "JSON",
				beforeSubmit: function () {
					toastSimple('info', 'Cargando archivos')
				},
				success: function (response) {
					if (response.icon === "success") {
						$("#formulario_certificaciones input[type='file']").val('');
						$.each($("#formulario_certificaciones input[type='file']"), function (obj, v) {
								obj++;
								$('label.custom-file-label[for="certificaciones' + obj + '"]').empty().text('Certificación ' + obj + '...');
							}
						);
						alertaGuardado("Archivos guardados!", response.msg)
						cargarArchivos(1);
					} else if (response.icon === "error") {
						alertaGuardado("Error al guardar!", response.msg, response.icon)
					}
				},
				error: function (ev) {
					errorControlador(ev)
				},
			});

		} else {
			mostrarAlerta('warning', "Faltan archivos!", count + "/3 Debes cargar 3 archivos para continuar")
		}
	});
	// Guardar autoevaluacion
	$(".archivos_form_autoevaluacion").on("click", function () {
		let data_name = $(".archivos_form_autoevaluacion").attr("data-name");
		let form_data = new FormData();
		form_data.append("file", $("#" + data_name).prop("files")[0]);
		form_data.append("tipoArchivo", $("#" + data_name).attr("data-val"));
		form_data.append("append_name", data_name);
		form_data.append(
			"id_form",
			$(".archivos_form_autoevaluacion").attr("data-form")
		);
		form_data.append(
			"idSolicitud",
			$(".archivos_form_autoevaluacion").attr("data-solicitud")
		);
		$.ajax({
			url: baseURL + "Archivos/create",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				toastSimple('info', 'Guardando')
			},
			success: function (response) {
				if (response.icon === "success") {
					alertaGuardado('Archivo guardado', response.msg)
				} else {
					alertaGuardado('Error al guardar', response.msg, response.icon)
				}
				cargarArchivos(1);
			},
			error: function (ev) {
				errorControlador(ev)
			},
		});
	});
	// Guardar imágenes del lugar
	$(".archivos_form_lugar").on("click", function () {
		let data_name = $(".archivos_form_lugar").attr("data-name");
		var form_data = new FormData();
		let count = 0;
		$.each($("#formulario_lugar input[type='file']"), function (obj, v) {
			var file = v.files[0];
			if (file != undefined) {
				form_data.append("file[" + obj + "]", file);
				count++;
			}
		});
		if (count > 0) {
			form_data.append("tipoArchivo", $("#" + data_name + "1").attr("data-val"));
			form_data.append("append_name", data_name);
			$.ajax({
				url: baseURL + "archivos/uploadFiles",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: "post",
				dataType: "JSON",
				beforeSubmit: function () {
					procesando();
				},
				success: function (response) {
					if (response.icon === "success") {
						alertaGuardado('Archivos guardados', response.msg)
					} else {
						mostrarAlerta(response.icon,'Error al guardar', response.msg)
					}
					clearInputs("formulario_lugar");
					cargarArchivos(1);
				},
				error: function (ev) {
					errorControlador(ev)
				},
			});
		} else {
			errorValidacionFormulario()
		}
	});
	// Actualizar la tabla cuando se hace clic en recargar
	$('.dataReload').on('click', function() {
		cargarArchivos(1);
		toastSimple("success", "Archivos actualizados");
	});
	// Validador personalizado URL
	$.validator.addMethod("urlCustom", function(value, element) {
		if (this.optional(element)) {
			return true;
		}
		// Si ya tiene el protocolo, usar el validador estándar de URL
		if (value.match(/^https?:\/\//i)) {
			return /^(?:(?:(?:https?):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(value);
		}
		// Si no tiene el protocolo, añadir 'http://' temporalmente y validar
		return /^(?:(?:(?:https?):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test('http://' + value);
	}, "Por favor, ingresa una URL válida (con o sin http://)");
	// Formulario Información General
	$("form[id='formulario_informacion_general_entidad']").validate({
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
			tipo_organizacion: {
				required: true,
			},
			departamentos: {
				required: true,
			},
			municipios: {
				required: true,
			},
			direccion: {
				required: true,
				minlength: 3,
			},
			fax: {
				required: true,
				minlength: 3,
			},
			correoElectronicoOrganizacion: {
				required: true,
				email: true,
			},
			urlOrganizacion: {
				urlCustom: true,
			},
			actuacion: {
				required: true,
			},
			educacion: {
				required: true,
			},
			primerNombreRepLegal: {
				required: true,
			},
			primerApellidoRepLegal: {
				required: true,
			},
			correoElectronicoRepLegal: {
				required: true,
			},
			numCedulaCiudadaniaPersona: {
				required: true,
				minlength: 3,
			},
			/**
					presentacion: {
						required: true,
						minlength: 20,
					},
					objetoSocialEstatutos: {
						required: true,
						minlength: 20,
					},
			 */
			mision: {
				required: true,
				minlength: 50,
				maxlength: 800,
			},
			vision: {
				required: true,
				minlength: 50,
				maxlength: 800,
			},
			/**
					principios: {
						required: true,
						minlength: 20,
					},
					fines: {
						required: true,
						minlength: 20,
					},
			 */
			portafolio: {
				required: true,
				minlength: 50,
				maxlength: 1400,
			},
		},
		messages: {
			tipo_organizacion: {
				required: "Por favor, seleccione un tipo de la lista.",
			},
			departamentos: {
				required: "Por favor, seleccione un departamento de la lista.",
			},
			municipios: {
				required: "Por favor, seleccione un municipio de la lista.",
			},
			direccion: {
				required: "Por favor, escriba la direccion.",
				minlength: "La dirección debe tener mínimo 3 caracteres.",
			},
			fax: {
				required: "Por favor, escriba el fax/numero.",
				minlength: "El numero debe tener mínimo 3 caracteres.",
			},
			correoElectronicoOrganizacion: {
				required: "Por favor, escriba un correo electrónico.",
				email: "Ingrese un correo electrónico valido.",
			},
			urlOrganizacion: {
				urlCustom: "Requiere una url valida. (www.ejemplo.com)",
			},
			actuacion: {
				required: "Por favor, seleccione una actuación de la lista.",
			},
			educacion: {
				required: "Por favor, seleccione un tipo de la lista.",
			},
			primerNombreRepLegal: {
				required: "Por favor, ingrese primero nombre.",
			},
			primerApellidoRepLegal: {
				required: "Por favor, ingrese primer apellido.",
			},
			correoElectronicoRepLegal: {
				required:
					"Por favor, ingrese correo electrónico representante legal.",
			},
			numCedulaCiudadaniaPersona: {
				required: "Por favor, escriba la cédula del Representante Legal.",
				minlength: "La cédula debe tener mínimo 3 caracteres.",
			},
			presentacion: {
				required: "Por favor, escriba la presentación institucional.",
				minlength:
					"La presentación institucional debe tener mínimo 20 caracteres.",
			},
			objetoSocialEstatutos: {
				required: "Por favor, escriba el objeto social.",
				minlength: "El objeto social  debe tener mínimo 20 caracteres.",
			},
			mision: {
				required: "Por favor, escriba la misión.",
				minlength: "La misión debe tener mínimo 50 caracteres.",
				maxlength: "La misión debe tener máximo 800 caracteres.",
			},
			vision: {
				required: "Por favor, escriba la visión.",
				minlength: "La visión debe tener mínimo 50 caracteres.",
				maxlength: "La visión debe tener máximo 800 caracteres.",
			},
			principios: {
				required: "Por favor, escriba los principios.",
				minlength: "Los principios deben tener mínimo 50 caracteres.",
			},
			fines: {
				required: "Por favor, escriba los fines.",
				minlength: "Los fines deben tener mínimo 20 caracteres.",
			},
			portafolio: {
				required: "Por favor, escriba el portafolio.",
				minlength: "El portafolio  debe tener mínimo 20 caracteres.",
				maxlength: "El portafolio  debe tener máximo 1400 caracteres.",
			},
		},
	});
});
