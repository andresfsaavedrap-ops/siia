// Importaciones necesarias
import { toastSimple, mostrarAlerta, procesando, errorControlador, showNotification, confirmarAccion } from './partials/alerts-config.js';
import { redirect, reload } from './partials/other-funtions-init.js';
import { getBaseURL } from './config.js';
// Configurar baseURL
const baseURL = getBaseURL();
/** Organizaciones inscritas */
// Acciones de botones
$("#verSolicitudesRegistradas").click(function () {
	$("#actividadOrganizacion").slideUp();
	$("#solicitudesOrganizacion").slideDown();
});
$("#verActividadUsuario").click(function () {
	$("#solicitudesOrganizacion").slideUp();
	$("#actividadOrganizacion").slideDown();
});
$("#admin_ver_inscritas_tabla").click(function () {
	$("#solicitudesOrganizacion").hide();
	$("#actividadOrganizacion").hide();
	$("#admin_panel_org_inscritas").slideDown();
	$("#datos_organizaciones_inscritas").slideUp();
});

$(document).on("click", ".verSolicitudAdmin", function () {
    let idSolicitud = $(this).attr("data-id");
    let idOrganizacion = $(this).attr("data-id-org");
    // Redirigir a la vista de una sola solicitud en modo observaciones (solo lectura)
    window.open(
        baseURL + "admin/tramite/solicitudes/informacionSolicitud?idSolicitud=" + idSolicitud + "&idOrganizacion=" + idOrganizacion,
        "_blank"
    );
});

/**
 * Modal detalle organización
 */
$(".organizacion-modal-detalle").click(function () {
	// Mostrar información de carga
	toastSimple("info", "Cargando datos de la organización");
	const data = {
		id_organizacion: $(this).attr("data-id"),
	};
	$.ajax({
		url: baseURL + "organizaciones/datosOrganzacion",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Datos básicos
			$("#organizacion").val(response.organizacion?.nombreOrganizacion || "");
			$("#nit").val(response.organizacion?.numNIT || "");
			$("#sigla").val(response.organizacion?.sigla || "");
			// Información General
			const ig = response.informacionGeneral || {};
			$("#info_direccionOrganizacion").text(ig.direccionOrganizacion || "—");
			$("#info_nomDepartamentoUbicacion").text(ig.nomDepartamentoUbicacion || "—");
			$("#info_nomMunicipioNacional").text(ig.nomMunicipioNacional || "—");
			$("#info_tipoOrganizacion").text(ig.tipoOrganizacion || "—");
			$("#info_tipoEducacion").text(ig.tipoEducacion || "—");
			$("#info_actuacionOrganizacion").text(ig.actuacionOrganizacion || "—");
			$("#info_mision").text(ig.mision || "—");
			$("#info_vision").text(ig.vision || "—");
			const urlOrg = ig.urlOrganizacion || "";
			$("#info_urlOrganizacion").attr("href", urlOrg || "#").text(urlOrg || "—");
			// Contacto
			const org = response.organizacion || {};
			const rep = [
				org.primerNombreRepLegal || "",
				org.segundoNombreRepLegal || "",
				org.primerApellidoRepLegal || "",
				org.segundoApellidoRepLegal || ""
			].filter(Boolean).join(" ");
			$("#contacto_correoOrganizacion").text(org.direccionCorreoElectronicoOrganizacion || "—");
			$("#contacto_correoRepLegal").text(org.direccionCorreoElectronicoRepLegal || "—");
			$("#contacto_representante").text(rep || "—");
			$("#contacto_urlOrganizacion").attr("href", urlOrg || "#").text(urlOrg || "—");
			$("#contacto_telefonoOrganizacion").text(ig.fax || "—");
			// Limpiar y construir tablas de solicitudes y actividad (como ya estaba)
			$("#tabla_solicitudes_organizacion  #tbody_solicitudes").empty().html("");
			$("#tabla_actividad_inscritas  #tbody_actividad").empty().html("");
			if (response.solicitudes && response.solicitudes.length > 0) {
				for (var i = 0; i < response.solicitudes.length; i++) {
					$("#tbody_solicitudes").append("<tr id=" + i + ">");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].idSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].nombre + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].fechaCreacion + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].asignada + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].modalidadSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td><textarea style='width: 300px; height: 140px; resize: none; border: hidden' readonly>" + (response.solicitudes[i].motivoSolicitud || "") + "</textarea></td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].tipoSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td><button class='btn btn-success btn-sm verSolicitudAdmin' data-id='"
						+ response.solicitudes[i].idSolicitud + "' data-id-org='" 
						+ response.organizacion.id_organizacion + "'>Ver Solicitud <i class='fa fa-eye' aria-hidden='true'></i></button></td>");
					$("#tbody_solicitudes").append("</tr>");
				}
				if (!$.fn.DataTable.isDataTable("#tabla_solicitudes_organizacion")) {
					// Inicializar tabla simple de organizaciones
					$("#tabla_solicitudes_organizacion").DataTable({
						pageLength: 10,
						language: {
							url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
						},
					});
				}
			} else {
				$("#tbody_solicitudes").append("<tr><td colspan='8'>Sin datos para mostrar</td></tr>");
			}
			if (response.actividad && response.actividad.length > 0) {
				for (var j = 0; j < response.actividad.length; j++) {
					$("#tbody_actividad").append("<tr id=" + j + ">");
					const accionFull = response.actividad[j].accion || "";
					const uaFull = response.actividad[j].user_agent || "";
					const accionCell = accionFull.length > 80 ? accionFull.substring(0, 80) + "…" : accionFull;
					const uaCell = uaFull.length > 80 ? uaFull.substring(0, 80) + "…" : uaFull;
					$("#tbody_actividad>tr#" + j + "").append("<td title=\"" + accionFull.replace(/"/g, "&quot;") + "\">" + accionCell + "</td>");
					$("#tbody_actividad>tr#" + j + "").append("<td>" + (response.actividad[j].fecha || "") + "</td>");
					$("#tbody_actividad>tr#" + j + "").append("<td>" + (response.actividad[j].usuario_ip || "") + "</td>");
					$("#tbody_actividad>tr#" + j + "").append("<td title=\"" + uaFull.replace(/"/g, "&quot;") + "\">" + uaCell + "</td>");
					$("#tbody_actividad").append("</tr>");
				}
				if (!$.fn.DataTable.isDataTable("#tabla_actividad_inscritas")) {
					// Inicializar DataTable para paginación
					$("#tabla_actividad_inscritas").DataTable({
						"pageLength": 10,
						"language": {
							"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
						}
					});
				}
			} else {
				$("#tbody_actividad").append("<tr><td colspan='4'>Sin datos para mostrar</td></tr>");
			}
			// Mostrar por defecto la sección de Solicitudes
			$("#verSolicitudesRegistradas").trigger("click");
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
// Utilidad: truncar texto con elipsis para celdas
function truncateText(text, max = 80) {
    if (!text) return "";
    return text.length > max ? text.slice(0, max) + "…" : text;
}






// Traer datos de la organización inscrita
$(".ver_organizacion_inscrita").click(function () {
	var nit = $(this).attr("data-organizacion");
	var data = {
		id_organizacion: nit,
	};
	$.ajax({
		url: baseURL + "organizaciones/datosOrganzacion",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			console.log(response)
			$("#admin_panel_org_inscritas").slideUp();
			$("#datos_organizaciones_inscritas").slideDown();
			$("#datos_organizaciones_inscritas #datos_basicos span").empty();
			$("#tabla_actividad_inscritas  #tbody_actividad").empty();
			$("#tabla_actividad_inscritas  #tbody_actividad").html("");
			$("#tabla_solicitudes_organizacion  #tbody_solicitudes").empty();
			$("#tabla_solicitudes_organizacion  #tbody_solicitudes").html("");
			$("#inscritas_nombre_organizacion").append("<p>" + response.organizacion.nombreOrganizacion + "</p>");
			$("#inscritas_nit_organizacion").append("<p>" + response.organizacion.numNIT + "</p>");
			$("#inscritas_sigla_organizacion").append("<p>" + response.organizacion.sigla + "</p>");
			$("#inscritas_nombreRepLegal_organizacion").append(
				"<p>" +
				response.organizacion.primerNombreRepLegal +
				" " +
				response.organizacion.segundoNombreRepLegal +
				" " +
				response.organizacion.primerApellidoRepLegal +
				" " +
				response.organizacion.segundoApellidoRepLegal +
				"</p>"
			);
			$("#inscritas_direccionCorreoElectronicoOrganizacion_organizacion").append("<p>" + response.organizacion.direccionCorreoElectronicoOrganizacion + "</p>");
			$("#inscritas_direccionCorreoElectronicoRepLegal_organizacion").append("<p>" + response.organizacion.direccionCorreoElectronicoRepLegal + "</p>");
			$("#inscritas_usuario").append("<p>" + response.usuario.usuario + "</p>");
			$("#inscritas_imagenOrganizacion_organizacion").attr("src", baseURL + "uploads/logosOrganizaciones/" + response.organizacion.imagenOrganizacion);
			// Construir tablas
			$("#tbody_solicitudes .odd").remove();
			if(response.solicitudes.length > 0) {
				for (var i = 0; i < response.solicitudes.length; i++) {
					$("#tbody_solicitudes").append("<tr id=" + i + ">");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].idSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].nombre + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].fechaCreacion + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].asignada + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].modalidadSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td><textarea style='width: 300px; height: 140px; resize: none; border: hidden' readonly>" + response.solicitudes[i].motivoSolicitud + "</textarea></td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td>" + response.solicitudes[i].tipoSolicitud + "</td>");
					$("#tbody_solicitudes>tr#" + i + "").append("<td> <button class='btn btn-success btn-sm verSolicitudAdmin' data-id='"
						+ response.solicitudes[i].idSolicitud
						+ "' data-id-org='" + response.organizacion.id_organizacion + "'>Ver Solicitud<i class='fa fa-eye' aria-hidden='true' </button></td>");
					$("#tbody_solicitudes").append("</tr>");
				}
				// Inicializar DataTable para paginación
				$("#tabla_solicitudes_organizacion").DataTable({
					"pageLength": 10,
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
					}
				});
			}
			else {
				$("#tbody_solicitudes").append("<tr>");
					$("#tbody_solicitudes>tr").append("<td colspan='8'> Sin datos para mostrar </td>");
				$("#tbody_solicitudes").append("</tr>");
			}
			if(response.actividad.length > 0) {
				$("#tbody_actividad .odd").remove();
				for (var i = 0; i < response.actividad.length; i++) {
					$("#tbody_actividad").append("<tr id=" + i + ">");
					const accionFull = response.actividad[i].accion || "";
					const fecha = response.actividad[i].fecha || "";
					const ip = response.actividad[i].usuario_ip || "";
					const uaFull = response.actividad[i].user_agent || "";
					$("#tbody_actividad>tr#" + i + "").append("<td title='" + accionFull.replace(/'/g, "&apos;") + "'>" + truncateText(accionFull, 80) + "</td>");
					$("#tbody_actividad>tr#" + i + "").append("<td>" + fecha + "</td>");
					$("#tbody_actividad>tr#" + i + "").append("<td>" + ip + "</td>");
					$("#tbody_actividad>tr#" + i + "").append("<td title='" + uaFull.replace(/'/g, "&apos;") + "'>" + truncateText(uaFull, 80) + "</td>");
					$("#tbody_actividad").append("</tr>");
				}
				// Inicializar DataTable para paginación
				$("#tabla_actividad_inscritas").DataTable({
					"pageLength": 10,
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
					}
				});
			}
			else {
				$("#tbody_actividad").append("<tr>");
					$("#tbody_actividad>tr").append("<td colspan='4'> Sin datos para mostrar </td>");
				$("#tbody_actividad").append("</tr>");
			}
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
