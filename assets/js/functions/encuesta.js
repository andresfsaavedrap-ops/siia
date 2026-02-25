
import { procesando, mostrarAlerta, toastSimple, errorControlador, alertaGuardado, showNotification, confirmarAccion, errorValidacionFormulario } from './partials/alerts-config.js';
import { initSelects, redirect, reload } from './partials/other-funtions-init.js';
import { getBaseURL } from './config.js';
const baseURL = getBaseURL();let encuestas;

$.ajax({
	url: baseURL + "Encuesta/cargar",
	type: "GET",
	dataType: "json",
	success: function (response) {
		encuestas = response;
	},
});
$("#enviarEcuesta").click(function () {
    const nit = $("#nitOrg").val().trim();
    const calificacion_general = $(".calificacion_general").val();
    const calificacion_evaluador = $(".calificacion_evaluador").val();
    const comentario = $("#comentario").val().trim();
    const idSolicitud = $("#idSolicitudAcreditada").val();

    const nitRegex = /^\d{9,10}-\d$/;
    const camposValidos = (
        nitRegex.test(nit) &&
        calificacion_general && calificacion_general !== "Elija una opción" &&
        calificacion_evaluador && calificacion_evaluador !== "Elija una opción" &&
        comentario.length > 0 &&
        idSolicitud && idSolicitud !== ""
    );

    if (!camposValidos) {
        mostrarAlerta('warning', 'Validación', 'Registra correctamente los campos obligatorios. Formato NIT: 123456789-0');
        return;
    }

    const data = {
        nit: nit,
        calificacion_general: calificacion_general,
        calificacion_evaluador: calificacion_evaluador,
        comentario: comentario,
        idSolicitud: idSolicitud,
    };

    procesando('info', 'Validando NIT y enviando encuesta...');

    $.ajax({
        url: baseURL + "Encuesta/enviarEncuesta",
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (response) {
            if (response.estado === 1) {
                alertaGuardado('Encuesta enviada', response.msg, 'success');
            } else if (response.estado === 2) {
                mostrarAlerta('warning', 'Encuesta enviada', response.msg);
            } else {
                mostrarAlerta('error', 'Encuesta no enviada', response.msg);
            }
        },
        error: function (jqXHR) {
            errorControlador(jqXHR);
        },
    });
});

$("#nitOrg").on("change blur", function () {
    const nit = $(this).val().trim();
    const nitRegex = /^\d{9,10}-\d$/;
    const $sel = $("#idSolicitudAcreditada");
    if (!nitRegex.test(nit)) {
        $sel.empty().append('<option value="">Primero ingrese un NIT válido</option>').prop('disabled', true);
        return;
    }
    procesando('info', 'Cargando solicitudes acreditadas...');
    $.ajax({
        url: baseURL + "Encuesta/solicitudesAcreditadasPorNit",
        type: "POST",
        dataType: "JSON",
        data: { nit },
        success: function (resp) {
            Swal.close();
            $sel.empty();
            if (resp.estado === 1 && resp.solicitudes && resp.solicitudes.length) {
                $sel.append('<option value="">Seleccione una solicitud</option>');
                resp.solicitudes.forEach(function (id) {
                    $sel.append('<option value="' + id + '">' + id + '</option>');
                });
                $sel.prop('disabled', false);
            } else {
                $sel.append('<option value="">No hay solicitudes acreditadas</option>').prop('disabled', true);
                mostrarAlerta('warning', 'Sin solicitudes', 'La organización no tiene solicitudes acreditadas.');
            }
        },
        error: function (jqXHR) {
            Swal.close();
            errorControlador(jqXHR);
        }
    });
});
