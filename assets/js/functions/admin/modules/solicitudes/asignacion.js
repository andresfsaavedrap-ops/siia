import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
} from "../../../partials/alerts-config.js";
import { reload } from "../../../partials/other-funtions-init.js";
import { getBaseURL } from "../../../config.js";
const baseURL = getBaseURL();

/**
 * Acciones administrador
 */

// Inicialización de DataTables
$(document).ready(function() {
    // Verificar si las tablas ya están inicializadas
    if (!$.fn.DataTable.isDataTable('#tabla_sinasignar')) {
        // Inicializar tabla de solicitudes sin asignar
        DataTableConfig.initSimpleTable(
            '#tabla_sinasignar',
            'Solicitudes Sin Asignar',
            'solicitudes_sin_asignar'
        );
    }
    if (!$.fn.DataTable.isDataTable('#tabla_asignadas')) {
        // Inicializar tabla de solicitudes asignadas
        DataTableConfig.initSimpleTable(
            '#tabla_asignadas',
            'Solicitudes Asignadas',
            'solicitudes_asignadas'
        );
    }
});

// Modal Asignar Evaluador Organización
$(document).on("click", "#verModalAsignar", function () {
	let id_organizacion = $(this).attr("data-organizacion");
	let nombreOrganizacion = $(this).attr("data-nombre");
	let numNIT = $(this).attr("data-nit");
	let idSolicitud = $(this).attr("data-solicitud");
	$("#idAsigOrg").html(id_organizacion);
	$("#nombreAsigOrg").html(nombreOrganizacion);
	$("#nitAsigOrg").html(numNIT);
	$("#idSolicitud").html(idSolicitud);
});

// Ver detalle de solicitud (modal)
$(document).on("click", ".verDetalleSolicitud", function() {
    const $btn = $(this);
    $("#detalleIdSolicitud").text($btn.data("id") || "-");
    $("#detalleOrganizacion").text($btn.data("organizacion") || "-");
    $("#detalleNit").text($btn.data("nit") || "-");
    $("#detalleTipo").text($btn.data("tipo") || "-");
    $("#detalleMotivo").text($btn.data("motivo") || "-");
    $("#detalleModalidad").text($btn.data("modalidad") || "-");
    $("#detalleFecha").text($btn.data("fecha") || "-");
    $("#detalleEstado").text($btn.data("estado") || "-");
    if (typeof $ !== 'undefined' && $("#detalleSolicitud").length) {
        $("#detalleSolicitud").modal('show');
    }
});

// Expandir/colapsar fila de detalles en móvil usando DataTables child rows
$(document).on("click", ".toggle-detalles", function() {
    const $btn = $(this);
    const $tr = $btn.closest("tr");
    const $table = $tr.closest("table");
    const table = $table.DataTable ? $table.DataTable() : null;
    const row = table ? table.row($tr) : null;

    const $detailBtn = $tr.find(".verDetalleSolicitud");
    const tipo = $detailBtn.data("tipo") || "-";
    const motivo = $detailBtn.data("motivo") || "-";
    const modalidad = $detailBtn.data("modalidad") || "-";

    const buildDetails = () => (
        '<div class="p-2">' +
            '<div><strong>Tipo:</strong> ' + tipo + '</div>' +
            '<div><strong>Motivo:</strong> ' + motivo + '</div>' +
            '<div><strong>Modalidad:</strong> ' + modalidad + '</div>' +
        '</div>'
    );

    const expanded = $btn.attr("aria-expanded") === "true";
    if (row && row.child) {
        if (row.child.isShown() && expanded) {
            row.child.hide();
            $btn.attr("aria-expanded", "false");
            $btn.find("i").removeClass("mdi-minus").addClass("mdi-plus");
        } else {
            row.child(buildDetails()).show();
            $btn.attr("aria-expanded", "true");
            $btn.find("i").removeClass("mdi-plus").addClass("mdi-minus");
        }
    } else {
        let $inline = $tr.next(".details-inline");
        if ($inline.length && expanded) {
            $inline.remove();
            $btn.attr("aria-expanded", "false");
            $btn.find("i").removeClass("mdi-minus").addClass("mdi-plus");
        } else {
            const html = '<tr class="details-inline"><td colspan="6">' + buildDetails() + '</td></tr>';
            $tr.after(html);
            $btn.attr("aria-expanded", "true");
            $btn.find("i").removeClass("mdi-plus").addClass("mdi-minus");
        }
    }
});

// Asignar evaluador a solicitud
$("#asignarOrganizacionEvaluador").click(function () {
	let data = {
		id_organizacion: $("#idAsigOrg").html(),
		idSolicitud: $("#idSolicitud").html(),
		evaluadorAsignar: $("#evaluadorAsignar").val(),
	};
	$.ajax({
		url: baseURL + "solicitudes/asignarEvaluadorSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			console.log(data);
			if (data.evaluadorAsignar === "") {
				toastSimple("warning", "Debe seleccionar un evaluador");
				return false;
			}
			toastSimple("info", "Asignando evaluador a la solicitud");
			$("#asignarOrganizacionEvaluador").attr("disabled", true);
		},
		success: function (response) {
			$("#asignarOrganizacion").toggle();
			mostrarAlerta(response.status, response.title, response.msg).then(
				(result) => {
					if (result.isConfirmed) {
						setInterval(function () {
							reload();
						}, 2000);
					}
				}
			);
			$("#asignarOrganizacionEvaluador").attr("disabled", false);
		},
		error: function (ev) {
			errorControlador(ev).then((result) => {
				if (result.isConfirmed) {
					reload();
				}
			});
			$("#asignarOrganizacionEvaluador").attr("disabled", false);
		},
	});
});
