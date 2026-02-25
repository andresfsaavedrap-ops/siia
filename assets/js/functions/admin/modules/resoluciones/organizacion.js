import { procesando, mostrarAlerta, toastSimple, errorControlador, alertaGuardado, showNotification, confirmarAccion } from '../../../partials/alerts-config.js';
import { redirect } from '../../../partials/other-funtions-init.js';
import { getBaseURL } from '../../../config.js';

const baseURL = getBaseURL();

// Configuración base para Toast y Alert (usando SweetAlert2)
const Toast = Swal.mixin({
	toast: true,
	position: "top-end",
	showConfirmButton: false,
	timer: 4000,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener("mouseenter", Swal.stopTimer);
		toast.addEventListener("mouseleave", Swal.resumeTimer);
	},
	customClass: {
		popup: "popup-toast",
	},
});

const Alert = Swal.mixin({
	confirmButtonText: "Aceptar",
	allowOutsideClick: false,
	allowEscapeKey: false,
	customClass: {
		confirmButton: "button-swalert",
		popup: "popup-swalert",
	},
});

// Función para recargar la página
function reload() {
	location.reload();
}

/**
 * Ver resoluciones
 *  */
$(".ver_resolucion_org").click(function () {
	let idOrganizacion = $(this).attr("data-organizacion");
	window.open(baseURL + "resoluciones/organizacion/" + idOrganizacion, '_self');
});
/**
 * Volver a organizaciones inscritas
 */
$("#volver_inscritas").click(function () {
	redirect(baseURL + "panelAdmin/organizaciones/inscritas");
});
/**
 * Acciones de menú
 */
// Ver administradores
$('#verResolucionesRegistradas').click(function () {
	if ($('#tabla_resoluciones_organizacion').css('display') === 'none'){
		$('#tabla_resoluciones_organizacion').show('swing');
		$('#formulario_resolucion_organizacion').hide('linear');
	}
	else {
		$('#tabla_resoluciones_organizacion').hide('linear');
	}
});
// Ver usuarios (formulario de creación)
$('#verFormularioResolucion').click(function () {
	if ($('#formulario_resolucion_organizacion').css('display') == 'none'){
		$('#formulario_resolucion_organizacion').show('swing');
		$('#tabla_resoluciones_organizacion').hide('linear');
		// Evitar duplicidad: mostrar solo creación
		$('#adjuntar_resolucion').show();
		$('#bloque_edicion_resolucion').hide();
		$('#actualizarDatosResolucion').hide();
	} else {
		$('#formulario_resolucion_organizacion').hide('linear');
	}
});
// Habilitar Input Años (creación)
$("#fechaResolucionInicial").change(function () {
    $("#anosResolucion").attr('disabled', false);
});

// Años de resolución automáticos (creación, sin moment)
$("#anosResolucion").change(function () {
    const years = parseInt($("#anosResolucion").val(), 10);
    const start = $("#fechaResolucionInicial").val();
    if (!start || isNaN(years)) {
        $("#fechaResolucionFinal").val("");
        $("#numeroResolucion").attr("disabled", true);
        return;
    }
    const fin = addYearsISO(start, years);
    $("#fechaResolucionFinal").val(fin);
    $("#numeroResolucion").attr("disabled", false);
});

function addYearsISO(dateStr, years) {
    const parts = dateStr.split("-");
    const d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
    d.setFullYear(d.getFullYear() + years);
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${d.getFullYear()}-${month}-${day}`;
}
// Normaliza diferencias menores (acentos/sin acentos) para modalidades
function canonicalModalidad(val) {
    const v = (val || '').toString().trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    if (v.includes('linea')) return 'En Línea';
    if (v.includes('semipresencial')) return 'Semipresencial';
    if (v.includes('presencial')) return 'Presencial';
    if (v.includes('virtual')) return 'Virtual';
    if (v.includes('distancia')) return 'A distancia';
    return val;
}
// Acciones si es resolución vieja o vigente
$("input[name=tipoResolucion]").change(function () {
	if($(this).val() == 'vieja') {
		$('#resolucionVieja').show('swing');
		$('#resolucionVigente').hide('linear');
	}
	else {
		$('#resolucionVigente').show('swing');
		$('#resolucionVieja').hide('linear');
	}
})
/**
 * Adjuntar Resolución
 * */
$("#cargarResolucion").on("click", function () {
	validarFormularios();
	//if($("#formulario_resolucion_organizacion").valid()){
		var file = $("#resolucion").prop("files")[0];
		var formData = new FormData();
		// Si es resolución antigua
		if($("input:radio[name=tipoResolucion]:checked").val() == 'vieja') {
			let cursos_aprobados = '';
			let modalidades = '';
			// Recorrer motivos de la solicitud y guardar variables
			$("#formulario_resoluciones_organizacion input[name=motivos]").each(function (){
				if (this.checked){
					switch ($(this).val()) {
						case '1':
							cursos_aprobados += 'Acreditación Curso Básico de Economía Solidaria' + ', ';
							break;
						case '2':
							cursos_aprobados += 'Aval de Trabajo Asociado' + ', ';
							break;
						case '3':
							cursos_aprobados += 'Acreditación Curso Medio de Economía Solidaria' + ', ';
							break;
						case '4':
							cursos_aprobados += 'Acreditación Curso Avanzado de Economía Solidaria' + ', ';
							break;
						case '5':
							cursos_aprobados += 'Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria' + ', ';
							break;
						default:
					}
				}
			});
			// Recorrer motivos de la solicitud y guardar variables
			$("#formulario_resoluciones_organizacion input[name=modalidades]").each(function (){
				if (this.checked){
					switch ($(this).val()) {
						case '1':
							modalidades += 'Presencial' + ', ';
							break;
						case '2':
							modalidades += 'Virtual' + ', ';
							break;
						case '3':
							modalidades += 'En Linea' + ', ';
							break;
						default:
					}
				}
			});
			formData.append("cursoAprobado", cursos_aprobados.substring(0, cursos_aprobados.length -2));
			formData.append("modalidadAprobada", modalidades.substring(0, modalidades.length -2));
		}
		formData.append("file", file);
		formData.append("fechaResolucionInicial", $("#fechaResolucionInicial").val());
		formData.append("fechaResolucionFinal", $("#fechaResolucionFinal").val());
		formData.append("anosResolucion",$("#anosResolucion").val());
		formData.append("numeroResolucion", $("#numeroResolucion").val());
		formData.append("tipoResolucion", $("input:radio[name=tipoResolucion]:checked").val());
		formData.append("id_organizacion", $(this).attr("data-id-org"));
		formData.append("idSolicitud", $("#idSolicitud").val());
		$.ajax({
			url: baseURL + "resoluciones/cargarResolucionOrganizacion",
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			type: "post",
			dataType: "html",
			beforeSend: function () {
				procesando("info", "Espere...");
			},
			success: function (response) {
				response = JSON.parse(response);
				if(response.status == 'success') {
					 mostrarAlerta(response.status, response.title, response.msg).then(() => location.reload());
				}
				else {
					procesando(response.status, response.msg)
				}
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	//}
});
/**
 * Eliminar resolución
 */
$(document).on("click", ".eliminarResolucion", function () {
    const idResolucion = $(this).attr("data-id-res");
    const idOrganizacion = $(this).attr("data-id-org");
    const data = { id_resolucion: idResolucion, id_organizacion: idOrganizacion };
    confirmarAccion("Eliminar resolución", "¿Quieres eliminar esta resolución?", "warning", 'popup-swalert').then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
            url: baseURL + "resoluciones/eliminarResolucion",
            type: "post",
            dataType: "JSON",
            data,
            beforeSend: function () {
                procesando('info', 'Espere...');
            },
            success: function (response) {
                if(response.status === 'success') {
                    mostrarAlerta(response.status, response.title, response.msg).then(() => location.reload());
                } else {
                    procesando(response.status, response.msg);
                }
            },
            error: errorControlador,
        });
    });
});

// Marcar resolución como vencida (valida fecha fin; no modifica fecha)
$(document).on("click", ".vencerResolucion", function () {
    const idResolucion = $(this).attr("data-id-res");
    const idOrganizacion = $(this).attr("data-id-org");
    const fechaFin = $(this).attr("data-fecha-fin"); // YYYY-MM-DD

    // Validación de fecha fin
    const hoy = new Date();
    const hoyISO = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
    const finParts = fechaFin ? fechaFin.split("-") : null;
    const finDate = finParts ? new Date(parseInt(finParts[0], 10), parseInt(finParts[1], 10) - 1, parseInt(finParts[2], 10)) : null;

    if (!finDate) {
        mostrarAlerta('warning', 'Fecha fin no disponible', 'No se pudo validar la fecha de la resolución.');
        return;
    }

    // Si aún está vigente (fecha fin hoy o futura), no permitir vencer
    if (finDate >= hoyISO) {
        mostrarAlerta('warning', 'Resolución vigente', 'La resolución aún está vigente y no puede marcarse como vencida.');
        return;
    }

    confirmarAccion("Marcar como vencida", "¿Quieres marcar esta resolución como vencida?", "warning", 'popup-swalert').then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: baseURL + "resoluciones/vencerResolucion",
            type: "post",
            dataType: "JSON",
            data: {
                id_resolucion: idResolucion,
                id_organizacion: idOrganizacion,
            },
            beforeSend: function () {
                procesando('info', 'Espere...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    mostrarAlerta(response.status, response.title, response.msg).then(() => location.reload());
                } else {
                    procesando(response.status, response.msg);
                }
            },
            error: errorControlador,
        });
    });
});
/**
 * Editar resolución
 */
$(document).on("click", ".editarResolucion", function () {
    const idRes = $(this).attr("data-id-res");
    const idOrg = $(this).attr("data-id-org");
    const data = { id_resolucion: idRes, id_organizacion: idOrg };

    $.ajax({
        url: baseURL + "resoluciones/editarResolucion",
        type: "post",
        dataType: "JSON",
        data,
        success: function (response) {
            // Mostrar formulario y alternar a modo edición
            $("#formulario_resolucion_organizacion").show();
            $("#tabla_resoluciones_organizacion").hide();
            $("#adjuntar_resolucion").hide();
            $("#bloque_edicion_resolucion").show();
            $("#actualizarDatosResolucion").show().attr("id-res", idRes).attr("id-org", idOrg);

            // Prellenar datos
            $("#res_fech_inicio").val(response.resolucion.fechaResolucionInicial);
            $("#res_fech_fin").val(response.resolucion.fechaResolucionFinal).prop("disabled", true);
            $("#res_anos").val(response.resolucion.anosResolucion).prop("disabled", true);
            $("#num_res_org").val(response.resolucion.numeroResolucion).prop("disabled", true);

            // Cursos/modalidades: CSV -> arreglo, normalización y selección múltiple
            const cursos = (response.resolucion.cursoAprobado || '')
                .split(',').map(s => s.trim()).filter(Boolean);
            const modalidades = (response.resolucion.modalidadAprobada || '')
                .split(',').map(s => canonicalModalidad(s)).filter(Boolean);

            $("#cursoAprobado").selectpicker("val", cursos).selectpicker("refresh");
            $("#modalidadAprobada").selectpicker("val", modalidades).selectpicker("refresh");

            // Link al PDF actual
            const archivo = response.resolucion.resolucion; // nombre de archivo
            if (archivo) {
                $("#linkArchivoActual")
                    .attr("href", baseURL + "uploads/resoluciones/" + archivo)
                    .css("display", "inline-flex")
                    .text("Ver archivo actual");
                // Setear ids para acciones archivo
                $("#eliminarArchivoResolucion, #reemplazarArchivoResolucion")
                    .attr("data-id-res", idRes)
                    .attr("data-id-org", idOrg);
            }
        },
        error: errorControlador,
    });
});
// Edición: habilitar años tras cambiar fecha inicio
$("#res_fech_inicio").on("change", function () {
    $("#res_anos").prop("disabled", false);
    $("#res_fech_fin").val("").prop("disabled", true);
    $("#num_res_org").prop("disabled", true);
});
// Edición: calcular fecha fin por años y habilitar número
$("#res_anos").on("change", function () {
    const years = parseInt($("#res_anos").val(), 10);
    const start = $("#res_fech_inicio").val();
    if (!start || isNaN(years)) {
        $("#res_fech_fin").val("").prop("disabled", true);
        $("#num_res_org").prop("disabled", true);
        return;
    }
    const fin = addYearsISO(start, years);
    $("#res_fech_fin").val(fin).prop("disabled", false);
    $("#num_res_org").prop("disabled", false);
});
// Validación edición (similar a creación)
function validarEditar() {
    const ini = $("#res_fech_inicio").val();
    const anos = $("#res_anos").val();
    const fin = $("#res_fech_fin").val();
    const num = $("#num_res_org").val();
    if (!ini || !anos || !fin || !num) {
        toastSimple('warning', 'Completa los campos obligatorios de edición');
        return false;
    }
    return true;
}
// Actualizar datos de la resolución: envía multiselección como CSV
$(document).on("click", "#actualizarDatosResolucion", function () {
    if (!validarEditar()) return;

    const idRes = $(this).attr("id-res");
    const idOrg = $(this).attr("id-org");
    const data = {
        id_res: idRes,
        id_organizacion: idOrg,
        res_fech_inicio: $("#res_fech_inicio").val(),
        res_fech_fin: $("#res_fech_fin").val(),
        res_anos: $("#res_anos").val(),
        num_res_org: $("#num_res_org").val(),
        cursoAprobado: ($("#cursoAprobado").val() || []).join(', '),
        modalidadAprobada: ($("#modalidadAprobada").val() || []).join(', '),
    };

    $.ajax({
        url: baseURL + "resoluciones/actualizarResolucion",
        type: "post",
        dataType: "JSON",
        data,
        success: function (response) {
            showNotification(response.msg, "success");
            reload();
        },
        error: errorControlador,
    });
});
// Reemplazar archivo (edición)
// Actualiza el label del input file con el nombre del PDF seleccionado
$(document).on('change', '#resolucion_editar', function (e) {
    var fileName = e.target.files && e.target.files.length ? e.target.files[0].name : 'Selecciona PDF...';
    $(this).next('.custom-file-label').addClass('selected').text(fileName);
});
$(document).on("click", "#reemplazarArchivoResolucion", function () {
    const idRes = $(this).attr("data-id-res");
    const idOrg = $(this).attr("data-id-org");
    const file = $("#resolucion_editar").prop("files")[0];
    if (!file) {
        toastSimple('warning', 'Selecciona un archivo PDF para reemplazar');
        return;
    }
    const formData = new FormData();
    formData.append("file", file);
    formData.append("id_resolucion", idRes);
    formData.append("id_organizacion", idOrg);

    confirmarAccion("Reemplazar archivo", "¿Quieres reemplazar el PDF de esta resolución?", "warning", 'popup-swalert').then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
            url: baseURL + "resoluciones/reemplazarArchivoResolucion",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: "post",
            dataType: "JSON",
            beforeSend: function () { procesando("info", "Espere..."); },
            success: function (response) {
                if (response.status === 'success') {
                    mostrarAlerta(response.status, response.title, response.msg).then(() => reload());
                } else {
                    procesando(response.status, response.msg);
                }
            },
            error: errorControlador,
        });
    });
});

// Botón alternativo dentro del bloque de edición: reutiliza el mismo flujo
$(document).on("click", "#btn_actualizar_resolucion_sp", function () {
	$("#actualizarDatosResolucion").trigger("click");
});
/**
 * Validar formularios
 */
function validarFormularios(){
	$("form[id='formulario_resoluciones_organizacion']").validate({
		rules: {
			fechaResolucionInicial: { required: true },
			anosResolucion: { required: true },
			numeroResolucion: { required: true },
			resolucion: { required: true },
		},
		messages: {
			fechaResolucionInicial: { required: "Por favor, ingrese una fecha de inicio." },
			anosResolucion: { required: "Por favor, ingrese cantidad de años." },
			numeroResolucion: { required: "Por favor, ingrese un numero de resolución" },
			resolucion: { required: "Por favor, cargar archivo" },
		},
	});
}
