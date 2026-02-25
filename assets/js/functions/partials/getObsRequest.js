// Módulo: getObsRequest.js
// Funciones reutilizables para consultar y mostrar historial de observaciones en el modal #verHistObsUs

import { getBaseURL } from '../config.js';
import { toastSimple, errorControlador } from './alerts-config.js';

/**
 * Escapa HTML para prevenir inyección en celdas de tabla.
 * @param {string} str
 * @returns {string}
 */
function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, (s) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
    }[s]));
}

/**
 * Limpia la tabla dentro del modal objetivo y destruye DataTable si ya está inicializado.
 * @param {string} modalSelector
 */
function resetHistorialTable(modalSelector = "#verHistObsUs") {
    const $modal = $(modalSelector);
    const $table = $modal.find("#tabla_historial_obs");
    try {
        if ($.fn.DataTable && $table.hasClass("dataTable")) {
            $table.DataTable().destroy();
        }
    } catch (_) { /* noop */ }
    $modal.find("#tbody_hist_obs").empty();
}

/**
 * Carga el historial de observaciones y lo muestra en el modal.
 * @param {string|number} idSolicitud
 * @param {{ showModal?: boolean, modalSelector?: string, columns?: 'user'|'admin' }} options
 * @returns {Promise<void>}
 */
export async function openHistorialObservaciones(idSolicitud, { showModal = true, modalSelector = "#verHistObsUs", columns = "user" } = {}) {
    const baseURL = getBaseURL();

    if (!idSolicitud) {
        toastSimple("error", "No se encontró el id de la solicitud.");
        return;
    }

    try {
        if (showModal && modalSelector) {
            $(modalSelector).modal("show");
        }

        resetHistorialTable(modalSelector);
        toastSimple("info", "Cargando historial de observaciones...");

        const response = await $.ajax({
            url: baseURL + "observaciones/verHistorialObservaciones",
            type: "post",
            dataType: "JSON",
            data: { idSolicitud },
        });

        const $modal = $(modalSelector);
        const $tbody = $modal.find("#tbody_hist_obs");
        const $table = $modal.find("#tabla_historial_obs");

        const isUserCols = columns === "user";
        const colspan = isUserCols ? 7 : 5;

        if (Array.isArray(response) && response.length > 0) {
            response.forEach((obs) => {
                const tr = $("<tr></tr>");
                tr.append(`<td>${obs.idForm ?? ""}</td>`);
                tr.append(`<td>${obs.keyForm ?? ""}</td>`);
                tr.append(`<td>${String(obs.observacion ?? "").replace(/[&<>"']/g, (s) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s]))}</td>`);

                if (isUserCols) {
                    const validaText = Number(obs.valida) === 1 ? "Si" : "No";
                    tr.append(`<td>${validaText}</td>`);
                    tr.append(`<td>${String(obs.realizada ?? "").replace(/[&<>"']/g, (s) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s]))}</td>`);
                }

                tr.append(`<td>${obs.fechaObservacion ?? ""}</td>`);
                tr.append(`<td>${obs.numeroRevision ?? ""}</td>`);
                $tbody.append(tr);
            });

            try {
                if ($.fn.DataTable) {
                    $table.DataTable({
                        pageLength: 10,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
                        },
                    });
                }
            } catch (_) { /* noop */ }
        } else {
            $tbody.append(`<tr><td colspan='${colspan}'>Sin datos para mostrar</td></tr>`);
        }

        toastSimple("success", "Historial cargado.");
    } catch (ev) {
        errorControlador(ev);
        const isUserCols = columns === "user";
        const colspan = isUserCols ? 7 : 5;
        const $modal = $(modalSelector);
        $modal.find("#tbody_hist_obs").empty().append(`<tr><td colspan='${colspan}'>No fue posible cargar el historial</td></tr>`);
    }
}

/**
 * Enlaza el evento click en el botón que abre/carga el historial en un modal configurable.
 * @param {string} selector Selector del botón, por defecto "#hist_org_obs"
 * @param {{ modalSelector?: string, columns?: 'user'|'admin' }} options
 */
export function bindHistorialObservacionesClick(selector = "#hist_org_obs", options = {}) {
    $(document).on("click", selector, function (e) {
        e.preventDefault();
        // Busca primero en el botón; si no, fallback al contenedor oculto de la vista admin
        const idSolicitud =
            $(this).attr("data-id-solicitud") ||
            $(this).data("id-solicitud") ||
            $("#id_org_ver_form").attr("data-solicitud");
        openHistorialObservaciones(idSolicitud, { ...options, showModal: true });
    });
}

// Limpieza al cerrar los modals para evitar duplicados usando el contexto del modal
$(document).on("hidden.bs.modal", "#verHistObsUs, #verHistObs", function () {
    const $modal = $(this);
    try {
        const $table = $modal.find("#tabla_historial_obs");
        if ($.fn.DataTable && $table.hasClass("dataTable")) {
            $table.DataTable().destroy();
        }
    } catch (_) { /* noop */ }
    $modal.find("#tbody_hist_obs").empty();
});
