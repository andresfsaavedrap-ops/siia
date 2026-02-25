import {
	confirmarAccion,
	errorControlador,
	mostrarAlerta,
	toastSimple, errorValidacionFormulario
} from "./partials/alerts-config.js";
import { reload, redirect, initSelects, initDatepickers } from "./partials/other-funtions-init.js";

let url = unescape(window.location.href);
let activate = url.split("/");
let baseURL = activate[0] + "//" + activate[2] + "/" + activate[3] + "/";
let funcion = activate[4];
let funcion_ = activate[5];
ValidarFormularioAdministradores();


initSelects();
initDatepickers();

/**
 * Inicio de sesión súper admin
 */
$("#init_sp").click(function () {
	var $ps_sp = $("#tpssp").val();
	$(window).attr("location", baseURL + "super/?sp:" + $ps_sp);
});
if (funcion == "super" && funcion_ != "panel") {
	// Capturar contraseña super
	var sp = url.split("?");
	sp = sp[1];
	// Si esta definida se comprueba
	if (sp != undefined) {
		var spF = sp.split(":");
		var data = {
			sp: spF[1],
		};
		// Inicio de sesión súper administrador
		$.ajax({
			url: baseURL + "super/verify",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				if (response.error === 1) {
					mostrarAlerta(
						"error",
						"Contraseña incorrecta!",
						response.msg
					).then((result) => {
						if (result.isConfirmed) {
							redirect(baseURL + "super?");
						}
					});
				} else {
					mostrarAlerta(
						"success",
						"Bienvenido!",
						response.msg
					).then((result) => {
						if (result.isConfirmed) {
							setInterval(function () {
								redirect(response.url);
							}, 1000);
						}
					});
				}
			},
			error: function (ev) {
			},
		});
	}
}
/**
 * Modal crear/actualizar administrador
 */
$(".admin-modal").click(function () {
	let funct = $(this).attr("data-funct");
	if (funct === "crear") {
		$("#super_nuevo_admin").show();
		$("#actions-admins").hide();
		$("#super_id_admin_modal").html("");
		$("#super_status_adm").html("");
		$("#super_status_adm").css("background-color", "#ffffff");
		$("#super_primernombre_admin").val("");
		$("#super_segundonombre_admin").val("");
		$("#super_primerapellido_admin").val("");
		$("#super_segundoapellido_admin").val("");
		$("#super_numerocedula_admin").val("");
		$("#super_ext_admin").val("");
		$("#super_nombre_admin").val("");
		$("#super_correo_electronico_admin").val("");
		$("#super_contrasena_admin").val("");
		$("#super_acceso_nvl option[value='seleccione']").prop("selected", true);
		$("#super_id_admin_modal").prop("disabled", false);
		$("#super_eliminar_admin").prop("disabled", false);
		$("#super_actualizar_admin").prop("disabled", false);
		$("#super_primernombre_admin").prop("disabled", false);
		$("#super_segundonombre_admin").prop("disabled", false);
		$("#super_primerapellido_admin").prop("disabled", false);
		$("#super_segundoapellido_admin").prop("disabled", false);
		$("#super_numerocedula_admin").prop("disabled", false);
		$("#super_nombre_admin").prop("disabled", false);
		$("#super_contrasena_admin").prop("disabled", false);
		$("#super_correo_electronico_admin").prop("disabled", false);
		$("#super_acceso_nvl").prop("disabled", false);
	} else {
		$("#super_nuevo_admin").hide();
		$("#actions-admins").show();
		data = {
			id: $(this).attr("data-id"),
		};
		$.ajax({
			url: baseURL + "administradores/cargarDatosAdministrador",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				$("#super_id_admin_modal").html("");
				$("#super_status_adm").html("");
				$("#super_status_adm").css("color", "white");
				$("#super_status_adm").css("padding", "5px");
				$("#super_id_admin_modal").html(
					response.administrador.id_administrador
				);
				$("#super_primernombre_admin").val(
					response.administrador.primerNombreAdministrador
				);
				$("#super_segundonombre_admin").val(
					response.administrador.segundoNombreAdministrador
				);
				$("#super_primerapellido_admin").val(
					response.administrador.primerApellidoAdministrador
				);
				$("#super_segundoapellido_admin").val(
					response.administrador.segundoApellidoAdministrador
				);
				$("#super_numerocedula_admin").val(
					response.administrador.numCedulaCiudadaniaAdministrador
				);
				$("#super_ext_admin").val(response.administrador.ext);
				$("#super_nombre_admin").val(response.administrador.usuario);
				$("#super_correo_electronico_admin").val(
					response.administrador.direccionCorreoElectronico
				);
				$(
					"#super_acceso_nvl option[value='" +
						response.administrador.nivel +
						"']"
				).prop("selected", true);
				$("#super_contrasena_admin").val(response.password);
				// Comprobar conexión de usuario
				if (response.administrador.logged_in == 1) {
					$("#super_status_adm").css("background-color", "#398439");
					$("#super_status_adm").html("Estado: En linea");
					$("#super_id_admin_modal").prop("disabled", true);
					$("#super_eliminar_admin").prop("disabled", true);
					$("#super_actualizar_admin").prop("disabled", true);
					$("#super_primernombre_admin").prop("disabled", true);
					$("#super_segundonombre_admin").prop("disabled", true);
					$("#super_primerapellido_admin").prop("disabled", true);
					$("#super_segundoapellido_admin").prop("disabled", true);
					$("#super_numerocedula_admin").prop("disabled", true);
					$("#super_contrasena_admin").prop("disabled", true);
					$("#super_correo_electronico_admin").prop("disabled", true);
					$("#super_acceso_nvl").prop("disabled", true);
				} else {
					$("#super_status_adm").css("background-color", "#c61f1b");
					$("#super_status_adm").html("Estado: No conectado");
					$("#super_id_admin_modal").prop("disabled", false);
					$("#super_eliminar_admin").prop("disabled", false);
					$("#super_actualizar_admin").prop("disabled", false);
					$("#super_primernombre_admin").prop("disabled", false);
					$("#super_segundonombre_admin").prop("disabled", false);
					$("#super_primerapellido_admin").prop("disabled", false);
					$("#super_segundoapellido_admin").prop("disabled", false);
					$("#super_numerocedula_admin").prop("disabled", false);
					$("#super_nombre_admin").prop("disabled", false);
					$("#super_contrasena_admin").prop("disabled", false);
					$("#super_correo_electronico_admin").prop("disabled", false);
					$("#super_acceso_nvl").prop("disabled", false);
				}
			},
			error: function (ev) {
				//Do nothing
			},
		});
	}
});
/**
 * Crear administrador
 */
$("#super_nuevo_admin").click(function () {
	if ($("#formulario_super_administradores").valid()) {
		//Datos formulario modal
		var data = {
			super_primernombre_admin: $("#super_primernombre_admin").val(),
			super_segundonombre_admin: $("#super_segundonombre_admin").val(),
			super_primerapellido_admin: $("#super_primerapellido_admin").val(),
			super_segundoapellido_admin: $("#super_segundoapellido_admin").val(),
			super_numerocedula_admin: $("#super_numerocedula_admin").val(),
			super_ext_admin: $("#super_ext_admin").val(),
			super_correo_electronico_admin: $(
				"#super_correo_electronico_admin"
			).val(),
			super_nombre_admin: $("#super_nombre_admin").val(),
			super_contrasena_admin: $("#super_contrasena_admin").val(),
			super_acceso_nvl: $("#super_acceso_nvl").val(),
		};
		$.ajax({
			url: baseURL + "administradores/create",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple("info", "Guardando datos");
			},
			success: function (response) {
				if (response.status === 0) {
					mostrarAlerta(
						response.icon,
						response.title,
						response.msg
					);
				} else if (response.status === 1) {
					mostrarAlerta(
						response.icon,
						response.title,
						response.msg
					).then((result) => {
						if (result.isConfirmed) {
							reload();
						}
					});
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	} else {
		toastSimple("warning", "Por favor, llene los datos requeridos.");
	}
});
/**
 * Actualizar administrador
 */
$("#super_actualizar_admin").click(function () {
	if ($("#formulario_super_administradores").valid()) {
		let lbl_adm = $("#verAdmin>label").attr("id");
		let id_adm = $("#" + lbl_adm).html();
		var data = {
			id_adm: id_adm,
			super_primernombre_admin: $("#super_primernombre_admin").val(),
			super_segundonombre_admin: $("#super_segundonombre_admin").val(),
			super_primerapellido_admin: $("#super_primerapellido_admin").val(),
			super_segundoapellido_admin: $("#super_segundoapellido_admin").val(),
			super_numerocedula_admin: $("#super_numerocedula_admin").val(),
			super_ext_admin: $("#super_ext_admin").val(),
			super_correo_electronico_admin: $(
				"#super_correo_electronico_admin"
			).val(),
			super_nombre_admin: $("#super_nombre_admin").val(),
			super_contrasena_admin: $("#super_contrasena_admin").val(),
			super_acceso_nvl: $("#super_acceso_nvl").val(),
		};
		$.ajax({
			url: baseURL + "administradores/update",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple("info", "Actualizando datos");
			},
			success: function (response) {
				mostrarAlerta(
					"success",
					"Administrador actualizado!",
					response.msg
				).then((result) => {
					if (result.isConfirmed) {
						reload();
					}
				});
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	} else {
		toastSimple("warning", "Por favor, llene los datos requeridos.");
	}
});
/**
 * Eliminar Administrador
 */
$("#super_eliminar_admin").click(function () {
	let lbl_adm = $("#verAdmin>label").attr("id");
	let id = $("#" + lbl_adm).html();
	let name = $("#super_nombre_admin").val();
	let data = {
		id_adm: id,
	};
	confirmarAccion(
		"Borrar administrador!",
		"Esta acción no se puede deshacer, realmente desea eliminar al usuario: " +
			name +
			"?",
		"warning"
	).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "administradores/delete",
				type: "post",
				dataType: "JSON",
				data: data,
				success: function (response) {
					mostrarAlerta(
						"success",
						"Administrador eliminado!",
						response.msg
					).then((result) => {
						if (result.isConfirmed) {
							reload();
						}
					});
				},
				error: function (ev) {
					errorControlador(ev);
				},
			});
		}
	});
});
/**
 * Desconectar Administrador
 */
$("#super_desconectar_admin").click(function () {
	let lbl_adm = $("#verAdmin>label").attr("id");
	let id = $("#" + lbl_adm).html();
	let data = {
		id: id,
	};
	$.ajax({
		url: baseURL + "administradores/disconnect",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			if (response.status == 1) {
				mostrarAlerta(
					"success",
					"Administrador desconectado!",
					response.msg
				).then((result) => {
					if (result.isConfirmed) {
						reload();
					}
				});
			} else {
				toastSimple("error", response.msg);
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
/**
 * Modal actions users
 */
$(".admin-usuario").click(function () {
	$("#super_nuevo_admin").hide();
	$("#super_eliminar_admin").show();
	$("#super_desconectar_admin").show();
	$("#super_actualizar_admin").show();
	let data = {
		id: $(this).attr("data-id"),
	};
	$.ajax({
		url: baseURL + "usuarios/cargarDatosUsuario",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			$("#super_usuario_modal").html("");
			$("#super_status_usr").html("");
			$("#super_status_usr").css("color", "white");
			$("#super_status_usr").css("padding", "5px");
			$("#super_usuario_modal").html(response.usuario.usuario);
			$("#super_id_user").val(response.usuario.id_usuario);
			$("#nombre_organizacion").val(response.usuario.nombreOrganizacion);
			$("#nit_organizacion").val(response.usuario.numNIT);
			$("#correo_electronico_usuario").val(
				response.usuario.direccionCorreoElectronicoOrganizacion
			);
			$("#username").val(response.usuario.usuario);
			$("#password").val(response.password);
			$(
				"#estado_usuario option[value='" + response.usuario.verificado + "']"
			).prop("selected", true);
			// Comprobar conexión de usuario
			if (response.usuario.logged_in == 1) {
				$("#super_status_usr").css("background-color", "#398439");
				$("#super_status_usr").html("Estado: En linea");
				$("#username").prop("disabled", true);
				$("#password").prop("disabled", true);
				$("#estado_usuario").prop("disabled", true);
				$("#super_actualizar_user").prop("disabled", true);
				$("#super_desconectar_user").prop("disabled", false);
			} else {
				$("#super_status_usr").css("background-color", "#c61f1b");
				$("#super_status_usr").html("Estado: Desconectado");
				$("#username").prop("disabled", false);
				$("#password").prop("disabled", false);
				$("#estado_usuario").prop("disabled", false);
				$("#super_actualizar_user").prop("disabled", false);
				$("#super_desconectar_user").prop("disabled", true);
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
/**
 * Actualizar usuario
 */
$("#super_actualizar_user").click(function () {
	if ($("#formulario_super_usuario").valid()) {
		let usuario = {
			id: $("#super_id_user").val(),
			nombre_usuario: $("#username").val(),
		};
		$.ajax({
			url: baseURL + "registro/verificarUsuario",
			type: "post",
			dataType: "JSON",
			data: usuario,
			success: function (response) {
				let className = $("#username").attr("class");
				if (response.existe === 1) {
					toastSimple(
						"error",
						"El nombre de usuario ya existe. Puede usar números."
					);
					if ((className = "form-control valid")) {
						$("#username").removeClass("valid");
						$("#username").toggleClass("invalid");
					}
				} else {
					if ((className = "form-control invalid valid")) {
						$("#username").removeClass("invalid");
					}
					let data = {
						id: $("#super_id_user").val(),
						correo_electronico_usuario: $("#correo_electronico_usuario").val(),
						username: $("#username").val(),
						password: $("#password").val(),
						estado_usuario: $("#estado_usuario").val(),
					};
					$.ajax({
						url: baseURL + "usuarios/update",
						type: "post",
						dataType: "JSON",
						data: data,
						beforeSend: function () {
							toastSimple("info", "Actualizando datos");
						},
						success: function (response) {
							confirmarAccion(
								response.msg,
								"¿Desea enviar datos de usuario a la organización?",
								response.status
							).then((result) => {
								if (result.isConfirmed) {
									$("#super_enviar_info_usuer").click();
								}
							});
						},
						error: function (ev) {
							errorControlador(ev);
						},
					});
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	} else {
		toastSimple("warning", "Por favor, llene los datos requeridos.");
	}
});
/**
 * Botón enviar datos
 */
$("#super_enviar_info_usuer").click(function () {
	let data = {
		id: $("#super_id_user").val(),
		type: "EnviarDatosUsuario",
		category: "info",
	};
	EnviarInformacionOrganizacion(data);
});
/**
 * Botón enviar correo activación
 */
$("#super_enviar_activacion_cuenta").click(function () {
	let data = {
		id: $("#super_id_user").val(),
		type: "registroUsuario",
		category: "activate",
	};
	EnviarInformacionOrganizacion(data);
});
/**
 * Desconectar usuario
 */
$("#super_desconectar_user").click(function () {
	data = {
		id: $("#super_id_user").val(),
	};
	$.ajax({
		url: baseURL + "usuarios/disconnect",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			if (response.status === "success") {
				mostrarAlerta(
					response.status,
					"Usuario desconectado!",
					response.msg
				).then((result) => {
					if (result.isConfirmed) {
						reload();
					}
				});
			} else {
				toastSimple(response.status, response.msg);
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
/**
 * Eliminar usuario
 */
$("#super_eliminar_cuenta").click(function () {
	data = {
		id: $("#super_id_user").val(),
	};
	confirmarAccion(
		"Eliminar usuario!",
		"Realmente desea eliminar el usuario, esta acción eliminara todo registro del usuario en el sistema.",
		"question"
	).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "usuarios/delete",
				type: "post",
				dataType: "JSON",
				data: data,
				success: function (response) {
					if (response.status === "success") {
						mostrarAlerta(
							response.status,
							response.title,
							response.msg
						).then((result) => {
							if (result.isConfirmed) {
								reload();
							}
						});
					} else {
						mostrarAlerta(
							response.status,
							response.title,
							response.msg
						);
					}
				},
				error: function (ev) {
					errorControlador(ev);
				},
			});
		}
	});
});
/**
 * Cerrar sesión súper administrador
 */
$("#super_cerrar_sesion").click(function () {
	$.ajax({
		url: baseURL + "super/logout",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			if (response.status == "ok") {
				redirect(baseURL);
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
/**
 * Crear solicitud de acreditación
 */
$("#btn_crear_solicitud_sp").click(function () {
	if ($("#crear_solicitud_sp").valid()) {
		// Declaración de variables
		let motivos_solicitud = [];
		let motivo_solicitud = "";
		let modalidad_solicitud = "";
		let modalidades_solicitud = [];
		// Recorrer motivos de la solicitud y guardar variables
		$("#crear_solicitud_sp input[name=motivos]").each(function () {
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
							"Programa organizaciones y redes SEAS." +
							", ";
						break;
					default:
				}
				motivos_solicitud.push($(this).val());
			}
		});
		// Recorrer motivos de la solicitud y guardar variables
		$("#crear_solicitud_sp input[name=modalidades]").each(function () {
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
		});
		// Datos a enviar
		let data = {
			nit_organizacion: $("#nit_organizacion").val(),
			tipo_solicitud: $("#tipo_solicitud").val(),
			fecha_creacion: $("#fecha-creacion").val(),
			motivo_solicitud: motivo_solicitud.substring(0,motivo_solicitud.length - 2),
			modalidad_solicitud: modalidad_solicitud.substring(0,modalidad_solicitud.length - 2),
			motivos_solicitud: motivos_solicitud,
			modalidades_solicitud: modalidades_solicitud,
		};
		//Si la data es validada se envía al controlador para guardar con ajax
		$.ajax({
			url: baseURL + "Solicitudes/crearSolicitud",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple("info", "Guardando Información");
			},
			success: function (response) {
				if (response.status == "success") {
					mostrarAlerta(
						response.status,
						response.title,
						"Se créo nueva solicitud:<strong>" + response.id + "</strong>"
					).then((result) => {
						if (result.isConfirmed) {
							setInterval(function () {
								reload();
							}, 1000);
						}
					});
				} else if ((response.status = "error")) {
					mostrarAlerta(
						response.status,
						response.title,
						response.msg
					);
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
/**
 * Ver detalle de solicitud
 */
$(".verDetalleSolicitud").click(function () {
	let html = "";
	let estado = "badge-danger";
	let data = {
		idSolicitud: $(this).attr("data-id"),
	};
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
			$("#informacionSolicitudEstado").html(html);
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
/**
 * Enviar Datos Organización
 * @param data
 * @constructor
 */
function EnviarInformacionOrganizacion(data) {
	$.ajax({
		url: baseURL + "super/enviarDatosUsuario",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			toastSimple("info", "Enviando información a la organización");
		},
		success: function (response) {
			mostrarAlerta(response.status, response.title, response.msg);
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
}
/**
 * Validar formulario registro
 */
function ValidarFormularioAdministradores() {
	$("form[id='crear_solicitud_sp']").validate({
		// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
		errorElement: "div",
		// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
		errorClass: "invalid-feedback",
		// Mensaje de error para mantener el layout consistente en input-groups
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
			nit_organizacion: {
				required: true,
			},
			tipo_solicitud: {
				required: true,
			},
		},
		messages: {
			nit_organizacion: {
				required: "Ingrese NIT de la organización.",
			},
			tipo_solicitud: {
				required: "Ingrese tipo de solicitud.",
			},
		},
	});
	$("form[id='formulario_super_administradores']").validate({
		// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
		errorElement: "div",
		// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
		errorClass: "invalid-feedback",
		// Mensaje de error para mantener el layout consistente en input-groups
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
			super_primernombre_admin: {
				required: true,
			},
			super_primerapellido_admin: {
				required: true,
			},
			super_numerocedula_admin: {
				required: true,
				minlength: 4,
				maxlength: 10,
			},
			super_ext_admin: {
				minlength: 1,
				maxlength: 5,
			},
			super_correo_electronico_admin: {
				required: true,
			},
			super_nombre_admin: {
				required: true,
			},
			super_contrasena_admin: {
				required: true,
			},
			super_acceso_nvl: {
				required: true,
			},
		},
		messages: {
			super_primernombre_admin: {
				required: "Digite primer nombre del administrador.",
			},
			super_primerapellido_admin: {
				required: "Digite primer apellido del administrador.",
			},
			super_numerocedula_admin: {
				required: "Digite numero de cédula.",
				minlength: "El numero cédula debe tener mínimo 3 caracteres.",
				maxlength: "El numero cédula debe tener máximo 10 caracteres.",
			},
			super_numerocedula_admin: {
				minlength: "El numero cédula debe tener mínimo 7 caracteres.",
				maxlength: "El numero cédula debe tener máximo 12 caracteres.",
			},
			super_correo_electronico_admin: {
				required: "Digite correo electrónico.",
			},
			super_nombre_admin: {
				required: "Digite usuario para el administrador.",
			},
			super_contrasena_admin: {
				required: "Digite una contraseña.",
			},
			super_acceso_nvl: {
				required: "Seleccione un nivel de la lista.",
			},
		},
	});
	$("form[id='formulario_super_usuario']").validate({
		// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
		errorElement: "div",
		// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
		errorClass: "invalid-feedback",
		// Mensaje de error para mantener el layout consistente en input-groups
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
			correo_electronico_usuario: {
				required: true,
				minlength: 3,
				email: true,
				regex: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
			},
			username: {
				required: true,
				minlength: 3,
			},
			password: {
				required: true,
				regex: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?)(?=.*?[#?!@$%^&*-]).{8,}$",
			},
			estado_usuario: {
				required: true,
			},
		},
		messages: {
			correo_electronico_usuario: {
				required:
					"Por favor, escriba un correo electrónico del representante legal válido.",
				minlength: "El correo electrónico debe tener mínimo 3 caracteres.",
				email: "Por favor, escriba un correo electrónico valido.",
				regex: "No olvide el @ y el .dominio",
			},
			username: {
				required: "Por favor, escriba el Nombre de Usuario.",
				minlength: "El Nombre de Usuario debe tener mínimo 3 caracteres.",
			},
			password: {
				required: "Por favor, escriba la Contraseña.",
				regex:
					"La contraseña debe cumplir con los siguientes requisitos: <br><br>" +
					"<ul>" +
					"<li>Al menos <strong>un número</strong>.</li>" +
					"<li>Al menos <strong>una mayúscula</strong>.</li>" +
					"<li>Al menos <strong>letras minúsculas</strong>.</li>" +
					"<li>Al menos <strong>un cáracter especial (#?!@$%^&*-)</strong>.</li>" +
					"<li>Una longitud mínima de <strong>8 caracteres</strong> sin límite máximo.</li>" +
					"</ul>",
			},
			estado_usuario: {
				required: "Ingrese estado.",
			},
		},
	});
}

