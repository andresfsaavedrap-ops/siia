import { reload, cargarMunicipios } from "./partials/other-funtions-init.js";
import {
	errorValidacionFormulario,
	toastSimple,
	errorControlador,
	mostrarAlerta,
} from "./partials/alerts-config.js";
// Cargar municipio por departamento
$(".departamentos").change(function () {
	let departamento = $("#departamentos").val();
	let select = $("#municipios");
	cargarMunicipios(departamento, select);
});
// Actualizar imagen perfil
$("#actualizar_imagen").on("click", function () {
	validarFormulariosPerfil();
	if ($("#formulario_actualizar_logo").valid()) {
		let file_data = $("#imagen_perfil").prop("files")[0];
		let form_data = new FormData();
		form_data.append("file", file_data);
		$.ajax({
			url: baseURL + "perfil/actualizarLogoOrganizacion",
			dataType: "text",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			beforeSend: function () {
				toastSimple('info', 'Cargando..')
			},
			success: function (response) {
				response = JSON.parse(response);
				// Verificamos si la respuesta es exitosa y mostramos el alerta
				if (response.status === "success") {
				mostrarAlerta(response.status,"Imagen de perfil actualizada!", response.msg ).then((result) => {
						if (result.isConfirmed) {
							setInterval(function () {
								reload();
							}, 2000);
						}
					});
				} else {
					mostrarAlerta(response.status, 'Error al subir imagen de perfil', response.msg)
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	}
});
// Actualizar información
$("#actualizar_informacion").click(function () {
	validarFormulariosPerfil();
	if ($("#formulario_actualizar_perfil").valid()) {
		let data = {
			organizacion: $("#organizacion").val(),
			nit: $("#nit").val(),
			sigla: $("#sigla").val(),
			nombre: $("#nombre").val(),
			nombre_s: $("#nombre_s").val(),
			apellido: $("#apellido").val(),
			apellido_s: $("#apellido_s").val(),
			correo_electronico: $("#correo_electronico").val(),
			correo_electronico_rep_legal: $("#correo_electronico_rep_legal").val(),
			nombre_p: $("#nombre_p").val(),
			apellido_p: $("#apellido_p").val(),
			tipo_organizacion: $("#tipo_organizacion").val(),
			departamento: $("#departamentos").val(),
			municipio: $("#municipios").val(),
			direccion: $("#direccion").val(),
			fax: $("#fax").val(),
			extension: $("#extension").val(),
			urlOrganizacion: $("#urlOrganizacion").val(),
			actuacion: $("#actuacion").val(),
			educacion: $("#educacion").val(),
			numCedulaCiudadaniaPersona: $("#numCedulaCiudadaniaPersona").val(),
		};
		// Petición ajax para actualizar info
		$.ajax({
			url: baseURL + "Perfil/actualizarInformacionPerfil",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple('info','Espere... Guardando información...');
			},
			success: function (response) {
				if (response.status === "success") {
					mostrarAlerta(response.status, response.title, response.msg).then((result) => {
						if (result.isConfirmed) {
							setInterval(function () {
								reload();
							}, 1000);
						}
					});
				} else {
					mostrarAlerta('warning', 'Error al guardar!', response.msg);
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	}
	else {
		errorValidacionFormulario();
	}
});
// Validar formularios
function validarFormulariosPerfil() {
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
	// Formulario actualizar imagen de perfil
	$("form[id='formulario_actualizar_logo']").validate({
		rules: {
			imagen_perfil: {
				required: true,
				validators: {
					notEmpty: {
						message: "Por favor, seleccione una imagen en JPG, PNG, JPEG.",
					},
					file: {
						extension: "jpeg,jpg,png",
						type: "image/jpeg,image/png",
						maxSize: 20000, // 2048 * 1024 1024 * 2
						message: "La imagen selecionada no es válida, seleccione otra.",
					},
				},
			},
		},
		messages: {
			imagen_perfil: {
				required: "Por favor, seleccione una imagen en JPG, PNG, JPEG.",
			},
		},
	});
	// Formulario Actualizar.
	$("form[id='formulario_actualizar_perfil']").validate({
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
		// Reglas de validación de los campos
		rules: {
			sigla: {
				required: true,
				minlength: 3,
			},
			numCedulaCiudadaniaPersona: {
				required: true,
				minlength: 3,
			},
			primer_nombre_rep_legal: {
				required: true,
				minlength: 3,
			},
			primer_apellido_rep_regal: {
				required: true,
				minlength: 3,
			},
			correo_electronico: {
				required: true,
				minlength: 3,
				email: true,
				//Expresión regular para validar correo y dominio
				regex: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
				remote: {
					url: baseURL + "registro/verificarEmail",
					type: "post",
					data: {
						correo: function () {
							return $("#correo_electronico").val().trim();
						},
					},
					dataFilter: function (response) {
						// El endpoint devuelve un JSON con { existe: 1 } o { existe: 0 }
						var res = JSON.parse(response);
						if (res.existe === 1) {
							// Se retorna un mensaje de error; jQuery Validate lo mostrará
							return '"Este correo ya se encuentra registrado en nuestro sistema para recibir notificaciones, por favor escriba un correo diferente."';
						} else {
							return "true";
						}
					},
				},
			},
			correo_electronico_rep_legal: {
				required: true,
				minlength: 3,
				email: true,
				//Expresión regular para validar correo y dominio
				regex: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
			},
			tipo_organizacion: {
				required: true,
			},
			actuacion: {
				required: true,
			},
			educacion: {
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
			nombre_p: {
				required: true,
				minlength: 3,
			},
			apellido_p: {
				required: true,
				minlength: 3,
			},
			urlOrganizacion: {
				urlCustom: true,
			},
		},
		messages: {
			sigla: {
				required: "Por favor, escriba la Sigla de la organización.",
				minlength:
					"El nombre de la organización debe tener mínimo 3 caracteres.",
			},
			numCedulaCiudadaniaPersona: {
				required: "Por favor, escriba la cédula de ciudadanía.",
				minlength:
					"El nombre de la organización debe tener mínimo 3 caracteres.",
			},
			primer_nombre_rep_legal: {
				required:
					"Por favor, escriba el Primer Nombre del Representante Legal.",
				minlength:
					"El Primer Nombre del Representante Legal debe tener mínimo 3 caracteres.",
			},
			primer_apellido_rep_regal: {
				required:
					"Por favor, escriba el Primer Apellido del Representante Legal.",
				minlength:
					"El Primer Apellido del Representante Legal debe tener mínimo 3 caracteres.",
			},
			correo_electronico: {
				required: "Por favor, escriba un Correo Electrónico válido.",
				minlength:
					"El Correo Electrónico de la organización debe tener mínimo 3 caracteres.",
				email: "Por favor, escriba un Correo Electrónico valido.",
				regex: "<p class='forms-error'>No olvide el @ y el .dominio</p>",
			},
			correo_electronico_rep_legal: {
				required: "Por favor, escriba un Correo Electrónico válido.",
				minlength:
					"El Correo Electrónico del Representante Legal debe tener mínimo 3 caracteres.",
				email: "Por favor, escriba un Correo Electrónico valido.",
				regex: "No olvide el @ y el .dominio",
			},
			tipo_organizacion: {
				required: "Por favor, seleccione el tipo de organización.",
			},
			actuacion: {
				required: "Por favor, seleccione la Actuación.",
			},
			educacion: {
				required: "Por favor, seleccione la Educación.",
			},
			departamentos: {
				required: "Por favor, seleccione el Departamento.",
			},
			municipios: {
				required: "Por favor, seleccione el Municipio.",
			},
			direccion: {
				required: "Por favor, escriba la Dirección.",
				minlength: "La Dirección debe tener mínimo 3 caracteres.",
			},
			fax: {
				required: "Por favor, escriba el Fax.",
				minlength: "El Fax debe tener mínimo 3 caracteres.",
			},
			nombre_p: {
				required: "Por favor, escriba su Primer Nombre.",
				minlength: "Su Primer Nombre debe tener mínimo 3 caracteres.",
			},
			apellido_p: {
				required: "Por favor, escriba su Primer Apellido.",
				minlength: "Su Primer Apellido debe tener mínimo 3 caracteres.",
			},
			urlOrganizacion: {
				urlCustom: "Requiere una url valida Ej: www.ejemplo.com",
			},
		},
	});
}
