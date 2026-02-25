import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
} from "./partials/alerts-config.js";
import { reload } from "./partials/other-funtions-init.js";
import { getBaseURL } from "./config.js";
const baseURL = getBaseURL();

let correos = [];
let correosAcreditadasList = [];
let correosTodosStr = "";
let correosAcreditadasStr = "";
$.ajax({
	url: baseURL + "Admin/cargarCorreos",
	type: "GET",
	dataType: "json",
	success: function (response) {
		correos = response || [];
	},
});
$.ajax({
	url: baseURL + "Admin/cargarCorreosAcreditadas",
	type: "GET",
	dataType: "json",
	success: function (response) {
		correosAcreditadasList = response || [];
	},
});

$("#enviar_correo_contacto_admin").click(function () {
	const msgHtml = CKEDITOR.instances.contacto_mensaje_admin
		? CKEDITOR.instances.contacto_mensaje_admin.getData()
		: $("#contacto_mensaje_admin").val();
	const asunto = $("#contacto_asunto_admin").val().trim();
	const prioridad = $("#contacto_prioridad_admin").val();
	const correoSel = $("#contacto_correo_electronico_admin").val();

	if (!asunto || !msgHtml || msgHtml.replace(/<[^>]*>/g, "").trim().length === 0) {
		toastSimple("Complete asunto y mensaje.", "warning");
		return;
	}

	let data = {};
	if ($("#contacto_enviar_copia_admin_todos").prop("checked")) {
		data = {
			masivo: correosTodosStr,
			prioridad: prioridad,
			asunto: asunto,
			mensaje: msgHtml,
		};
	} else if ($("#contacto_enviar_copia_admin_todos_acre").prop("checked")) {
		data = {
			masivo: correosAcreditadasStr || (correosAcreditadasList || []).map((c) => c.direccionCorreoElectronicoOrganizacion).filter(Boolean).join(";"),
			prioridad: prioridad,
			asunto: asunto,
			mensaje: msgHtml,
		};
	} else {
		if (!correoSel || correoSel === "Seleccione una opción") {
			toastSimple("Seleccione el correo de la organización.", "warning");
			return;
		}
		data = {
			correo_electronico: correoSel,
			prioridad: prioridad,
			asunto: asunto,
			mensaje: msgHtml,
		};
		if ($("#contacto_copia_admin").is(":visible")) {
			data.correo_electronico_rep = $("#contacto_correo_electronico_rep_admin").val();
		} else {
			data.correo_electronico_rep = "";
		}
	}

	// if ($("#comunicado").is(":visible")) {
	// 	data.todos = "";
	// } else {
	// 	if ($("#contacto_enviar_copia_admin_todos").prop("checked")) {
	// 		data.todos = 1;
	// 	} else if ($("#contacto_enviar_copia_admin_todos_acre").prop("checked")) {
	// 		data.todos = 2;
	// 	} else {
	// 		data.todos = 1;
	// 	}
	// }

	$.ajax({
		url: baseURL + "Admin2/enviomail_contacto",
		type: "POST",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			notificacion("Espere, enviando...", "success");
		},
		success: function (response) {
			notificacion(response.msg, "success");
		},
		error: function (ev) {
			//Do nothing
		},
	});
});
// TODO: Formulario de contacto administrador
$("#enviar_correo_contacto").click(function () {
	$correo_electronico = $("#contacto_correo_electronico").val();
	$nombre = $("#contacto_nombre").val();
	$prioridad = $("#contacto_prioridad").val();
	$asunto = $("#contacto_asunto").val();
	$mensaje = $("#contacto_mensaje").val();
	data = {
		correo_electronico: $correo_electronico,
		nombre: $nombre,
		prioridad: $prioridad,
		asunto: $asunto,
		mensaje: $mensaje,
	};
	if ($("#contacto_copia").is(":visible")) {
		data.correo_electronico_rep = $("#contacto_correo_electronico_rep").val();
	} else {
		data.correo_electronico_rep = "";
	}

	$.ajax({
		url: baseURL + "contacto/enviomail_contacto",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			notificacion("Espere, enviando...", "success");
		},
		success: function (response) {
			notificacion(response.msg, "success");
		},
		error: function (ev) {
			//Do nothing
		},
	});
});

$("#contaco_enviar_copia").click(function () {
	if ($("#contaco_enviar_copia").prop("checked")) {
		$("#contacto_copia").show();
	} else {
		$("#contacto_copia").hide();
	}
});

// Cheked Correo a todas las entidades.
$("#contacto_enviar_copia_admin_todos").click(function () {
	// Si está check
	if ($("#contacto_enviar_copia_admin_todos").prop("checked")) {
		// Deshabilitar y deschequear el envio a todas las entidades
		$("#contacto_enviar_copia_admin_todos_acre").prop("checked", false);
		$("#contacto_enviar_copia_admin_todos_acre").prop("disabled", true);
		// Ocultar select de emails
		$("#comunicado").hide();
		// Asignar asunto automaticamente
		$("#contacto_asunto_admin").val("Comunicado SIIA: ");
		// Capturar todos los correos de las organizaciones y convertirlo en archivo separado por ;
		correosTodosStr = (correos || [])
			.map((c) => c.direccionCorreoElectronicoOrganizacion)
			.filter(Boolean)
			.join(";");
	} else {
		// Habilitar checkbox de envio correo a todas las entidades acreditadas
		$("#contacto_enviar_copia_admin_todos_acre").prop("disabled", false);
		// Ver seccion comunicado
		$("#comunicado").show();
		// Dejar asunto en blanco
		$("#contacto_asunto_admin").val("");
		correosTodosStr = "";
	}
});
// Cheked a todas las entidades acreditadas.
$("#contacto_enviar_copia_admin_todos_acre").click(function () {
	// Si está check
	if ($("#contacto_enviar_copia_admin_todos_acre").prop("checked")) {
		// Deshabilitar y deschequear el envio a todas las entidades
		$("#contacto_enviar_copia_admin_todos").prop("checked", false);
		$("#contacto_enviar_copia_admin_todos").prop("disabled", true);
		// Ocultar select de emails
		$("#comunicado").hide();
		// Asignar asunto automaticamente
		$("#contacto_asunto_admin").val("Entidades acreditadas en el SIIA: ");
		// Capturar todos los correos de las organizaciones y convertirlo en archivo separado por ;
		correosAcreditadasStr = (correosAcreditadasList || []).map((c) => c.direccionCorreoElectronicoOrganizacion).filter(Boolean).join(";");
	} else {
		// Habilitar checkbox de envio correo a todas las entidades
		$("#contacto_enviar_copia_admin_todos").prop("disabled", false);
		// Ver seccion comunicado
		$("#comunicado").show();
		// Dejar asunto en blanco
		$("#contacto_asunto_admin").val("");
		correosAcreditadasStr = "";
	}
});
// TODO: Falta por comentar
$("#contacto_correo_electronico_admin").change(function () {
	$("#contacto_enviar_copia_admin").prop("checked", false);
	$("#contacto_copia_admin").hide();
	if (
		$("#contacto_correo_electronico_admin").val() == "Seleccione una opción"
	) {
		$("#contacto_enviar_copia_admin").prop("disabled", true);
		$("#contacto_enviar_copia_admin").prop("checked", false);
		$("#contacto_enviar_copia_admin_todos").prop("checked", false);
		$("#contacto_enviar_copia_admin_todos").prop("disabled", false);
		$("#contacto_enviar_copia_admin_todos_acre").prop("checked", false);
		$("#contacto_enviar_copia_admin_todos_acre").prop("disabled", false);
		$("#contacto_copia_admin").hide();
	} else {
		$("#contacto_enviar_copia_admin").prop("disabled", false);
		$("#contacto_enviar_copia_admin_todos").prop("disabled", true);
		$("#contacto_enviar_copia_admin_todos_acre").prop("disabled", true);
	}
});
// TODO: Buscar correo representante legal por medio de checked box
$("#contacto_enviar_copia_admin").click(function () {
	if ($("#contacto_enviar_copia_admin").prop("checked")) {
		// Variable correo admin
		$correoAdmin = $("#contacto_correo_electronico_admin").val();
		// Mostrar campo con representante legal
		$("#contacto_copia_admin").show();
		// Buscar Correo Rep Legal por medio de variable correos (ajax)
		for (i = 0; i < correos.length; i++) {
			if (correos[i].direccionCorreoElectronicoOrganizacion == $correoAdmin) {
				$correoRepLegal = correos[i].direccionCorreoElectronicoRepLegal;
			}
		}
		// Llevar valor de correo Rep Legal a campo input y deshabilitar campo
		$("#contacto_correo_electronico_rep_admin").val($correoRepLegal);
		$("#contacto_correo_electronico_rep_admin").prop("disabled", true);
		// Pruebas
		console.log(correos);
		console.log($("#contacto_correo_electronico_rep_admin").val());
	} else {
		$("#contacto_copia_admin").hide();
	}
});

// Contador de caracteres del mensaje CKEditor
if (window.CKEDITOR) {
	CKEDITOR.on("instanceReady", function (evt) {
		if (evt.editor && evt.editor.name === "contacto_mensaje_admin") {
			const updateCount = () => {
				const text = evt.editor.getData().replace(/<[^>]*>/g, "").trim();
				$("#contacto_mensaje_count").text(`${text.length} caracteres`);
			};
			evt.editor.on("change", updateCount);
			updateCount();
		}
	});
}
