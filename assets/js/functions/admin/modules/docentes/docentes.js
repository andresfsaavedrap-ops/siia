import { getBaseURL } from "../../../config.js";
import {
	alertaGuardado,
	mostrarAlerta,
	toastSimple,
	errorControlador,
	confirmarAccion,
	errorValidacionFormulario,
	procesando,
	showNotification
} from "../../../partials/alerts-config.js";
import { 
	reload,
	redirect,
	initSelects,
	initInputFile,
	initInputFilePoint,
	cargarMunicipios
} from "../../../partials/other-funtions-init.js";
import { datatableInit } from "../../../partials/datatable-init.js";
const baseURL = getBaseURL();
let $dataDocentes = [];
let $dataArchivos = [];
// Cambiar: Ver docentes por organización -> cargar componente HTML server-side
$(document).on('click', '.ver_organizacion_docentes', function (e) {
    e.preventDefault();
    var $btn = $(this);
    var idOrganizacion = $btn.data('id') || $btn.attr('data-organizacion');
    // Loader visual mientras llega el componente
    $('#docentes_organizaciones').html(
        '<div class="text-center p-4"><img src="' + baseURL + 'assets/img/loading_siia.gif" alt="Cargando..." /></div>'
    );

    $.get(baseURL + 'AdminDocentes/componenteEvaluacionOrganizacion', { idOrganizacion: idOrganizacion })
        .done(function (html) {
            $('#docentes_organizaciones').html(html);
            // Oculta el card de la tabla con animación
            $('#todos_docentes_card').slideUp(200);
        })
        .fail(function (xhr) {
            var msg = 'Error cargando el componente de evaluación de la organización.';
            if (xhr && xhr.responseText) msg += ' ' + xhr.responseText;
            $('#docentes_organizaciones').html('<div class="alert alert-danger">' + msg + '</div>');
        });
});
// Event handler: .verEsteDocente click -> cargar SOLO el componente_docente sin opacidad
$(document).on('click', '.verEsteDocente', function (e) {
    e.preventDefault();
    const idDocente = $(this).data('id') || $(this).attr('data-id');
    if (!idDocente) {
        toastSimple('error', 'No se pudo identificar el docente seleccionado.');
        return;
    }
    // Si estamos dentro de componente_evaluacion existe #informacion_docentes; en evaluar.php usamos #docentes_organizaciones
    const $container = $('#informacion_docentes').length ? $('#informacion_docentes') : $('#docentes_organizaciones');
    // Loader sin cambiar opacidad (remueve fadeTo para evitar “gris”)
    const loader = '<div class="text-center p-4"><img src="' + baseURL + 'assets/img/loading_siia.gif" alt="Cargando docente..." /></div>';
    $container.html(loader);

    $.get(baseURL + 'AdminDocentes/componenteDocente', { idDocente: idDocente })
        .done(function (html) {
            if ($container.is('#informacion_docentes')) {
                // Contexto componente_evaluacion: reemplazo suave
                $container.fadeOut(120, function () {
                    $(this).replaceWith(html);
                    const $nuevo = $('#informacion_docentes');
                    $nuevo.hide().fadeIn(180);
                });
            } else {
                // Contexto evaluar.php (individual)
                $container.hide().html(html).fadeIn(180);

                // Ocultar el listado
                $('#docentes_evaluar_card').slideUp(200);

                // Insertar botón “Volver al listado” SOLO en modo individual
                const $nuevo = $('#informacion_docentes');
                if ($nuevo.length && !$nuevo.find('.volver_docente_evaluar').length) {
                    $nuevo.prepend(
                        '<div class="text-right mb-3">' +
                            '<button class="btn btn-outline-secondary btn-sm volver_docente_evaluar">' +
                                '<i class="mdi mdi-arrow-left mr-1"></i> Volver al listado' +
                            '</button>' +
                        '</div>'
                    );
                }
            }
        })
        .fail(function (xhr) {
            const msg = 'Error cargando el componente del docente.' + (xhr && xhr.responseText ? (' ' + xhr.responseText) : '');
            $container.html('<div class="alert alert-danger">' + msg + '</div>');
        });
});

// Botón para volver a ver la lista en evaluar.php (mostrar #docentes_evaluar_card)
$(document).on('click', '.volver_docente_evaluar', function (e) {
    e.preventDefault();
    $('#docentes_organizaciones').fadeOut(100, function () {
        $(this).empty().show();
    });
    $('#docentes_evaluar_card').slideDown(200);
});
// Botón para volver a ver la lista de todos los docentes
$(document).on('click', '.volver_lista_docentes', function (e) {
    e.preventDefault();
    // Vacía el contenedor del componente y muestra la lista con animación
    $('#docentes_organizaciones').fadeOut(100, function () {
        $(this).empty().show();
    });
    $('#todos_docentes_card').slideDown(200);
});
// Modal Asignar Evaluador Docente
$(document).on("click", "#verModalAsignarDocente", function () {
	toastSimple("success", "Cargando información...");
	let $idDocente = $(this).attr("data-id");
	let $cedulaDocente = $(this).attr("data-docente");
	let $nombreDocente = $(this).attr("data-nombre");
	let $apellidoDocente = $(this).attr("data-apellido");
	let $nombre = $nombreDocente + " " + $apellidoDocente;
	$("#idDocente").html($idDocente);
	$("#cedulaDocente").html($cedulaDocente);
	$("#nombreDocente").html($nombre);
});
// Asignar evaluador a docente
$("#asignarDocenteEvaluador").click(function () {
	let $id_docente = $("#idDocente").html();
	let $evaluadorAsignar = $("#evaluadorAsignar").val();
	if (!$evaluadorAsignar) {
		toastSimple("error", "Debe seleccionar un evaluador.");
		return;
	}
	let data = {
		id_docente: $id_docente,
		evaluadorAsignar: $evaluadorAsignar,
	};
	$.ajax({
		url: baseURL + "AdminDocentes/asignarDocente",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			toastSimple("success", "Espere, asignando...");
			$("#asignarDocenteEvaluador").attr("disabled", true);
		},
		success: function (response) {
			$("#asignarDocente").toggle();
			mostrarAlerta("success", "Asignación exitosa", response.msg).then(() => {
				reload();
			});
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
// Ver archivo docente ojo
$(document).on("click", ".docVistoArch", function () {
	// Verificar si el ícono del ojo ya existe para evitar duplicados
	$(this).append(' - <i class="fa fa-eye" aria-hidden="true" style="background-color:orange;color:white;font-size:0.7rem;padding:2px;"></i>');
});

// Ver frame docentes
$("#verFrameDocentes").click(function () {
	//$("#frameDocDiv").slideDown();
	//document.getElementById("frameDocentes").contentDocument.location.reload(true);
});
// Cambio de estado docente
$(document).on('change', '.validoDocente', function () {
	if ($(this).val() == "0") {
		$("#observacionDocente").slideDown();
		$("#divValidoDocente").removeClass("col-md-12");
		$("#divValidoDocente").addClass("col-md-4");
	} else {
		$("#observacionDocente").slideUp();
		$("#divValidoDocente").removeClass("col-md-4");
		$("#divValidoDocente").addClass("col-md-12");
	}
});
// Guardar aprobación docente (delegado para elementos dinámicos)
$(document).on('click', '.guardarValidoDocente', function () {
    // Prevenir el envío por defecto del formulario
    event.preventDefault();
    $(this).attr("disabled", true);
    // Obtener el valor del radio button seleccionado
    let validoSeleccionado = $("input:radio[name=validoDocente]:checked").val();
    let observacion = $("#docente_val_obs").val();
    // Validar si es "No" (0), debe tener observación
    if (validoSeleccionado === "0" && (!observacion || observacion.trim() === "")) {
        toastSimple("error", "Debe ingresar una observación cuando el docente no es válido");
        return; // No continuar con el guardado
    }
    let data = {
        id_docente: $(this).attr("data-id"),
        valido: validoSeleccionado,
        docente_val_obs: observacion ? observacion.trim() : "",
    };
    $.ajax({
        url: baseURL + "AdminDocentes/validarDocentes",
        type: "post",
        dataType: "JSON",
        data: data,
        success: function (response) {
            mostrarAlerta("success", "Operación exitosa", response.msg).then(() => {
                // Si estamos en el formulario con el componente embebido, refrescar solo ese bloque
                const $embed = $("#evaluacion_docentes_embed");
                if ($embed.length) {
                    const nit = $embed.attr("data-nit") || $embed.find("[data-nit]").attr("data-nit") || "";
                    recargarEvaluacionDocentesEmbed(nit);
                } else {
                    // Fallback para otras vistas ya existentes
                    reload();
                }
            });
        },
        error: function (ev) {
            errorControlador(ev);
        },
    });
});

// Recargar el componente embebido de evaluación sin refrescar toda la página
function recargarEvaluacionDocentesEmbed(nit) {
    const $embed = $("#evaluacion_docentes_embed");
    if (!$embed.length) return;
    $embed.html('<div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin mr-2"></i>Actualizando facilitadores…</div>');
    $.ajax({
        url: baseURL + "AdminDocentes/evaluacionEmbed",
        type: "post",
        dataType: "html",
        data: nit ? { nit: nit } : {},
        success: function (html) {
            $embed.html(html);
        },
        error: function () {
            $embed.html('<div class="alert alert-danger">No se pudo actualizar el componente de evaluación.</div>');
        },
    });
}
// Delegado: botón “Recargar” solo en embed
$(document).on('click', '.btnRecargarEmbed', function () {
    const nit =
        $(this).attr('data-nit') ||
        $("#evaluacion_docentes_embed").attr('data-nit') ||
        $("#evaluacion_docentes_embed").find("[data-nit]").attr("data-nit") ||
        "";
    recargarEvaluacionDocentesEmbed(nit);
});
// Guardar observación en archivos docentes (ya delegado)
$(document).on("click", ".guardarObsArchivoDoc", function () {
	let id_archivoDocente = $(this).attr("data-id");
	let observacionArchivo = $(this)
		.parent("td")
		.siblings("td")
		.children("textarea#archivoDoc" + id_archivoDocente)
		.val();
	// Validar que el campo no esté vacío
	if (!observacionArchivo || observacionArchivo.trim() === "") {
		toastSimple("error", "El campo de observación no puede estar vacío");
		return; // No continuar con el guardado
	}
	let data = {
		id_archivoDocente: id_archivoDocente,
		observacionArchivo: observacionArchivo.trim(),
	};
	$.ajax({
		url: baseURL + "AdminDocentes/actualizarArchivoDocente",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			toastSimple("success", response.msg);
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
});
