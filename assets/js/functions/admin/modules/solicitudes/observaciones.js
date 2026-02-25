import { getBaseURL } from "../../../config.js";
import {
	alertaGuardado,
	mostrarAlerta,
	toastSimple,
	errorControlador,
	confirmarAccion
} from "../../../partials/alerts-config.js";
import { reload } from "../../../partials/other-funtions-init.js";
import { bindHistorialObservacionesClick } from "../../../partials/getObsRequest.js";
const baseURL = getBaseURL();
let html;
let obsForm = 0;
let data_orgFinalizada = [];
const bloqueoObservaciones = (typeof window !== "undefined" && window.__bloquearObservaciones === true);

// Mantener deshabilitados los textareas de observación cuando exista bloqueoObservaciones
$(document).ready(function () {
    if (bloqueoObservaciones) {
        // Deshabilitar inputs de observación
        $(".obs_admin_, #observacionesForm1, #observacionesForm2, #observacionesForm3, #observacionesForm4, #observacionesForm5, #observacionesForm6")
            .prop("disabled", true)
            .prop("readonly", true);

        // Deshabilitar botones de guardar observación
        $(".btn-observacion, .guardarObservacionesForm1, .guardarObservacionesForm2, .guardarObservacionesForm3, .guardarObservacionesForm4, .guardarObservacionesForm5, .guardarObservacionesForm6")
            .prop("disabled", true)
            .addClass("disabled");
    }
});

// Refuerzo: si por render dinámico quedaran habilitados, al intentar enfocar los mantenemos deshabilitados
$(document).on("focus", ".obs_admin_, #observacionesForm1, #observacionesForm2, #observacionesForm3, #observacionesForm4, #observacionesForm5, #observacionesForm6", function () {
    if (bloqueoObservaciones) {
        $(this).prop("disabled", true).prop("readonly", true).blur();
        toastSimple("warning", "Edición deshabilitada en vista de Observaciones");
    }
});

// Refuerzo: al cambiar de sección del menú, aplicamos el bloqueo nuevamente
$(document).on("click", "#verInfGenMenuAdmin, #verDocLegalMenuAdmin, #verJorActMenuAdmin, #verProgBasMenuAdmin, #verFaciliMenuAdmin, #verDatModalidades", function () {
    if (bloqueoObservaciones) {
        $(".obs_admin_, [id^='observacionesForm']").prop("disabled", true).prop("readonly", true);
        $(".btn-observacion").prop("disabled", true).addClass("disabled");
    }
});
// Inicialización única para evitar duplicar handlers y conflictos
if (!window.__observacionesInitialized) {
    window.__observacionesInitialized = true;

    // Neutralizar posibles handlers antiguos del toggle personalizado
    $(document).off("click", "#floatingMenuToggle");
    $(document).off("click", "#floatingMenuClose");

    // Si el contenedor no está directamente bajo <body>, muévelo para evitar clipping
    const $menu = $("#floatingMenuContainer");
    if ($menu.length && !$menu.parent().is("body")) {
        $("body").append($menu.detach());
    }

    // Inicializar el dropdown de Bootstrap si está disponible
    try { $("#floatingMenuToggle").dropdown(); } catch (e) { /* noop */ }

    // Actualizar flecha según estado del dropdown (solo una flecha: #floatingMenuChevron)
    $("#floatingMenuContainer").on("show.bs.dropdown", function () {
        $("#floatingMenuChevron").removeClass("fa-chevron-up").addClass("fa-chevron-down");
    });
    $("#floatingMenuContainer").on("hide.bs.dropdown", function () {
        $("#floatingMenuChevron").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    });

    // Cerrar el dropdown al elegir un item
    $(document).on("click", "#floatingMenuPanel .dropdown-item", function () {
        try { $("#floatingMenuToggle").dropdown("hide"); } catch (e) {}
    });
    // Enlace del botón "Historial de observaciones" del ADMIN al modal #verHistObsUs con columnas 'user' (7 columnas)
    bindHistorialObservacionesClick("#hist_org_obs", { modalSelector: "#verHistObsUs", columns: "user" });
}

// Cargar una solicitud en modo observaciones y abrir el panel de detalles
function cargarSolicitudObservaciones(idOrganizacion, idSolicitud) {
    $("#id_org_ver_form").remove();
    $("body").append(
        "<div id='id_org_ver_form' class='hidden' data-id='" + idOrganizacion + "' data-solicitud='" + idSolicitud + "'>"
    );
    const data = { id_organizacion: idOrganizacion, idSolicitud: idSolicitud };
    obsForm = 0;
    html = "";

    // Mostrar menús flotantes
    $("#floatingMenuContainer").fadeIn(150);
    $("#floatingMenuToggle").removeClass("show");
    $("#floatingMenuPanel").removeClass("show");
    $("#floatingObservacionesContainer").fadeIn(150);
    $("#floatingObservacionesToggle").removeClass("show");
    $("#floatingObservacionesPanel").removeClass("show");

    $.ajax({
        url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
        type: "post",
        dataType: "JSON",
        data: data,
        success: function (response) {
            $(".icono--div3").show();
            $(".icono--div4").show();
            $("#hist_org_obs").attr("data-id-org", idOrganizacion);
            $("#hist_org_obs").attr("data-id-solicitud", idSolicitud);
            data_orgFinalizada = [response];

            if (data_orgFinalizada["0"]["plataforma"].length == 0) $("#verDatPlatMenuAdmin").hide();
            if (data_orgFinalizada["0"]["enLinea"].length == 0) $("#verDataEnLinea").hide();
            if (data_orgFinalizada["0"]["datosModalidades"].length == 0) $("#verDatModalidades").hide();

            // Ocultar listado, header y stats; mostrar el panel de detalles
            $("#admin_ver_finalizadas").slideUp();
            $("#admin_ver_stats").slideUp();
            $("#admin_ver_header").slideUp();
            $("#admin_panel_ver_finalizada").slideDown();

            // Mostrar Información General por defecto
            $("#informacion").show();
            $("#documentacion, #registroEducativoProgramas, #antecedentesAcademicos, #jornadasActualizacion, #datosBasicosProgramas, #docentes, #datosModalidades, #plataforma, #enLinea").hide();

            // Poblar encabezado de solicitud
            $("#fechaSol").html(response.solicitudes.fechaCreacion);
            $("#idSol").html(response.solicitudes.idSolicitud);
            $("#tipoSol").html(response.estadoOrganizaciones.tipoSolicitudAcreditado);
            $("#modSol").html(response.estadoOrganizaciones.modalidadSolicitudAcreditado);
            $("#motSol").html(response.estadoOrganizaciones.motivoSolicitudAcreditado);
            $("#numeroSol").html(response.solicitudes.numeroSolicitudes);
            $("#revFechaFin").html(response.estadoOrganizaciones.fechaFinalizado);
            $("#revFechaUltimaActualizacion").html(response.estadoOrganizaciones.fechaUltimaActualizacion);
            $("#revSol").html(response.solicitudes.numeroRevisiones);
            $("#revFechaSol").html(response.solicitudes.fechaUltimaRevision);
            $("#estOrg").html(response.estadoOrganizaciones.nombre);
            $("#asignada_por").html(response.solicitudes.asignada_por);
            $("#fechaAsignacion").html(response.solicitudes.fechaAsignacion);
			if (response.organizaciones.camaraComercio === "default.pdf") {
				$("#camaraComercio_org")
					.removeAttr("href")
					.removeClass("disabled")
					.css("pointer-events", "auto")
					.attr("data-camara", "default.pdf");
			} else {
				$("#camaraComercio_org")
					.attr("href", baseURL + "uploads/camaraComercio/" + response.organizaciones.camaraComercio)
					.attr("target", "_blank")
					.attr("data-camara", response.organizaciones.camaraComercio)
					.removeClass("disabled")
					.css("pointer-events", "auto");
			}
            $("#nOrgSol").html(response.organizaciones.nombreOrganizacion);
            $("#sOrgSol").html(response.organizaciones.sigla);
            $("#nitOrgSol").html(response.organizaciones.numNIT);
            $("#nrOrgSol").html(response.organizaciones.primerNombreRepLegal + " " + response.organizaciones.primerApellidoRepLegal);
            $("#telOrgSol").html(response.informacionGeneral.fax);
            $("#cOrgSol").html(response.organizaciones.direccionCorreoElectronicoOrganizacion);
			$("#cRepOrgSol").html(response.organizaciones.direccionCorreoElectronicoRepLegal);
            // Poblar Información General (form 1)
            $("#actuacionOrganizacion").html(response.informacionGeneral.actuacionOrganizacion);
            $("#direccionOrganizacion").html(response.informacionGeneral.direccionOrganizacion);
            $("#extension").html(response.informacionGeneral.extension);
            $("#fax").html(response.informacionGeneral.fax);
            $("#mision").html(response.informacionGeneral.mision);
            $("#nomDepartamentoUbicacion").html(response.informacionGeneral.nomDepartamentoUbicacion);
            $("#nomMunicipioNacional").html(response.informacionGeneral.nomMunicipioNacional);
            $("#numCedulaCiudadaniaPersona").html(response.informacionGeneral.numCedulaCiudadaniaPersona);
            $("#portafolio").html(response.informacionGeneral.portafolio);
            $("#tipoEducacion").html(response.informacionGeneral.tipoEducacion);
            $("#tipoOrganizacion").html(response.informacionGeneral.tipoOrganizacion);
            $("#urlOrganizacion").html(response.informacionGeneral.urlOrganizacion);
            $("#vision").html(response.informacionGeneral.vision);
			$("#actuacionOrganizacion")
				.parent()
				.next()
				.attr(response.informacionGeneral.actuacionOrganizacion);
			$("#direccionOrganizacion")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.direccionOrganizacion);
			$("#extension")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.extension);
			$("#fax")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.fax);
			$("#fines")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.fines);
			$("#mision")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.mision);
			$("#nomDepartamentoUbicacion")
				.parent()
				.next()
				.attr(
					"data-text",
					response.informacionGeneral.nomDepartamentoUbicacion
				);
			$("#nomMunicipioNacional")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.nomMunicipioNacional);
			$("#numCedulaCiudadaniaPersona")
				.parent()
				.next()
				.attr(
					"data-text",
					response.informacionGeneral.numCedulaCiudadaniaPersona
				);
			$("#objetoSocialEstatutos")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.objetoSocialEstatutos);
			$("#otros")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.otros);
			$("#portafolio")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.portafolio);
			$("#presentacionInstitucional")
				.parent()
				.next()
				.attr(
					"data-text",
					response.informacionGeneral.presentacionInstitucional
				);
			$("#principios")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.principios);
			$("#tipoEducacion")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.tipoEducacion);
			$("#tipoOrganizacion")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.tipoOrganizacion);
			$("#urlOrganizacion")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.urlOrganizacion);
			$("#vision")
				.parent()
				.next()
				.attr("data-text", response.informacionGeneral.vision);
			// Archivos formulario 1.
			let $carpeta = "";
			// Utilidad para truncar nombres muy largos con elipsis en el medio (no destruye el original)
			const truncMiddle = (str, maxLen = 60) => {
				try { str = String(str || ""); } catch (e) {}
				if (str.length <= maxLen) return str;
				const head = Math.ceil((maxLen - 3) / 2);
				const tail = Math.floor((maxLen - 3) / 2);
				return str.slice(0, head) + "..." + str.slice(-tail);
			};

			let archivosHTML = '<div class="archivos-container"><h5><i class="mdi mdi-file-multiple"></i> Archivos de Información General</h5>';
			// Agrupar archivos por tipo
			let archivosPorTipo = {
				carta: [],
				certificaciones: [],
				lugar: [],
				autoevaluacion: []
			};
			for (let $a = 0; $a < data_orgFinalizada["0"].archivos.length; $a++) {
				if (data_orgFinalizada["0"].archivos[$a].id_formulario == "1") {
					let archivo = data_orgFinalizada["0"].archivos[$a];
					if (archivosPorTipo[archivo.tipo]) {
						archivosPorTipo[archivo.tipo].push(archivo);
					}
				}
			}
			// Generar pestañas por tipo de archivo
			const tiposArchivo = {
				carta: { nombre: 'Carta del Representante Legal', icono: 'mdi-email-outline', carpeta: 'cartaRep/' },
				certificaciones: { nombre: 'Certificaciones', icono: 'mdi-certificate', carpeta: 'certificaciones/' },
				lugar: { nombre: 'Lugar de Atención', icono: 'mdi-map-marker', carpeta: 'lugarAtencion/' },
				autoevaluacion: { nombre: 'Autoevaluación', icono: 'mdi-clipboard-check', carpeta: 'autoevaluaciones/' }
			};
			// Tipos presentes con al menos un archivo
			const tiposPresentes = Object.keys(archivosPorTipo).filter(t => archivosPorTipo[t].length > 0);
			// Construir navegación de pestañas y contenedores
			if (tiposPresentes.length > 0) {
				archivosHTML += `
					<ul class="nav nav-tabs" id="archivosTabs" role="tablist">
				`;
				tiposPresentes.forEach((tipo, idx) => {
					const activeClass = idx === 0 ? 'active' : '';
					const count = archivosPorTipo[tipo].length;
					archivosHTML += `
						<li class="nav-item" role="presentation">
							<a class="nav-link ${activeClass}" id="tab-${tipo}" href="#pane-${tipo}" role="tab"
							data-toggle="tab" data-bs-toggle="tab" aria-controls="pane-${tipo}" aria-selected="${idx === 0}">
								<i class="mdi ${tiposArchivo[tipo].icono}"></i> ${tiposArchivo[tipo].nombre}
								<span class="badge badge-light">${count}</span>
							</a>
						</li>
					`;
				});
				archivosHTML += `</ul><div class="tab-content" id="archivosTabsContent">`;
				tiposPresentes.forEach((tipo, idx) => {
					const showActive = idx === 0 ? 'show active' : '';
					archivosHTML += `
						<div class="tab-pane fade ${showActive}" id="pane-${tipo}" role="tabpanel" aria-labelledby="tab-${tipo}">
							<div class="archivo-tipo-grupo">
								<h6><i class="mdi ${tiposArchivo[tipo].icono}"></i> ${tiposArchivo[tipo].nombre}</h6>
								<div class="archivos-lista">
					`;
					archivosPorTipo[tipo].forEach(archivo => {
						let fileActive = archivo.activo == 0 ? "checked disabled" : "";
						let estadoClase = archivo.activo == 0 ? "archivo-revisado" : "archivo-pendiente";
						let estadoTexto = archivo.activo == 0 ? "Revisado" : "Pendiente";
						let estadoIcono = archivo.activo == 0 ? "mdi-check-circle" : "mdi-clock-outline";
						archivosHTML += `
							<div class="archivo-item ${estadoClase}">
								<div class="archivo-info">
									<i class="mdi mdi-file-document-outline archivo-icono"></i>
									<div class="archivo-detalles">
										<a href="${baseURL}uploads/${tiposArchivo[tipo].carpeta}${archivo.nombre}"
								target="_blank"
								class="archivo-nombre"
								title="${archivo.nombre}"
								data-toggle="tooltip" data-bs-toggle="tooltip">
									${truncMiddle(archivo.nombre, 60)}
								</a>
										<small class="archivo-estado">
											<i class="mdi ${estadoIcono}"></i> ${estadoTexto}
										</small>
									</div>
								</div>
								<div class="archivo-acciones">
									<label class="checkbox-container">
										<input class="revisarArchivo" type="checkbox" 
											name="revisarArchivo" ${fileActive}
											data-id="${archivo.id_archivo}">
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
						`;
					});
					archivosHTML += `
								</div>
							</div>
						</div>
					`;
				});
				archivosHTML += `</div>`;
			}
			// Cierre del contenedor principal
			archivosHTML += '</div>';
			// Inicializar tooltip para mostrar el nombre completo al pasar el mouse (sin romper si no está Bootstrap)
			try { $('[data-toggle="tooltip"], [data-bs-toggle="tooltip"]').tooltip(); } catch (e) { /* noop */ }
			// Inyectar en el DOM
			$("#archivos_informacionGeneral").html(archivosHTML);
			// Fallback de tabs por si el plugin de Bootstrap no está disponible
			(function activarTabsArchivos() {
				const $tabs = $("#archivosTabs");
				const $panes = $("#archivosTabsContent .tab-pane");
				if ($tabs.length && $panes.length) {
					$tabs.on("click", "a.nav-link", function (e) {
						e.preventDefault();
						const target = $(this).attr("href");
						// Activar enlace
						$tabs.find("a.nav-link").removeClass("active").attr("aria-selected", "false");
						$(this).addClass("active").attr("aria-selected", "true");
						// Mostrar pane
						$panes.removeClass("show active");
						$(target).addClass("show active");
						// Si existe el plugin .tab() de Bootstrap, usarlo
						try { $(this).tab && $(this).tab("show"); } catch (err) { /* noop */ }
					});
				}
			})();
			// Mantener tu lógica existente de observaciones y resto del flujo
			$("#archivos_informacionGeneral").append(
				'<div class="form-group" id="documentacionLegal-observacionesGeneral' + i + '">'
			);
            // Cargar observaciones del Form 1 por defecto
            verObservaciones(1);
			// Validación de clic para Cámara de Comercio (mostrar mensaje si no hay archivo cargado)
			$(document).off("click", "#camaraComercio_org").on("click", "#camaraComercio_org", function (e) {
				const camara = $(this).attr("data-camara");
				if (!camara || camara === "default.pdf") {
					e.preventDefault();
					toastSimple("warning", "Aún no se ha cargado el documento de cámara de comercio.");
					return;
				}
			});
			/** Formulario 6 Docentes **/
			for (var i = 0; i < response.docentes.length; i++) {
				if (i == 0) {
					$(".txtOrgDocen").append(
						"<p id='cantidadDocentesOrg'>Número de facilitadores: <span class='ml-2 badge badge-success'>" +
							response.docentes.length +
						"</span></p>"
					);
					$("#irAEvaluarDocente").attr(
						"href",
						baseURL +
							"panelAdmin/organizaciones/docentes#organizacion:" +
							response.organizaciones.numNIT
					);

					// Cargar el componente embebido de evaluación dentro del contenedor
					const nit = response.organizaciones.numNIT;
					const $embed = $("#evaluacion_docentes_embed");
					$embed.html('<div class="text-center text-muted py-3"><i class="fa fa-spinner fa-spin mr-2"></i>Cargando evaluación de facilitadores…</div>');
					$.ajax({
						url: baseURL + "AdminDocentes/evaluacionEmbed",
						type: "post",
						dataType: "html",
						data: { nit: nit },
						success: function (html) {
							$embed.html(html);
							// Guardar el NIT en el contenedor para refrescos posteriores al guardar
							$embed.attr("data-nit", nit);
							// Opcional: ocultar el botón externo cuando se incrusta
							$("#irAEvaluarDocente").hide();
						},
						error: function () {
							$embed.html('<div class="alert alert-danger">No se pudo cargar el componente de evaluación. Use el botón "Evaluar docentes".</div>');
						},
					});
					setTimeout(function () {
					const frameDocentes = document.getElementById("frameDocentes");
					if (frameDocentes && frameDocentes.contentDocument) {
						try {
							frameDocentes.contentDocument.location.reload(true);
						} catch (error) {
							console.warn('No se pudo recargar el iframe frameDocentes:', error);
						}
					}
				}, 2000);
					//$("#docentes").append('<div class="form-group" id="docentes-observacionesGeneral0">');
					//$("#docentes>#docentes-observacionesGeneral0").append("<p>Observaciones de los docentes en general:</label>");
					//$("#docentes>#docentes-observacionesGeneral0").append("<textarea class='form-control obs_admin_' placeholder='Observación...' data-title='Observaciones de los docentes en general' data-text='Observaciones de los docentes en general' data-type='docentes' id='obs-docen-gen-0' rows='3'></textarea>");
					$("#docentes").append("</div>");
				}
			}
        },
        error: function (ev) {
            errorControlador(ev);
        },
    });
}

// Si viene una solicitud específica, abrirla automáticamente
$(document).ready(function () {
    if (typeof window.__autocargarSolicitud !== "undefined" &&
        window.__autocargarSolicitud &&
        window.__idSolicitud &&
        window.__idOrganizacion) {
        cargarSolicitudObservaciones(window.__idOrganizacion, window.__idSolicitud);
    }
});

// Ver organización finalizada (redirigido a la función común)
$(document).on("click", ".ver_organizacion_finalizada", function () {
    const idOrg = $(this).attr("data-organizacion");
    const idSolicitud = $(this).attr("data-solicitud");
    cargarSolicitudObservaciones(idOrg, idSolicitud);
});

/** Solicitud camara de comercio organización. */
$(document).on("click", "#solicitarCamara", function (e) {
	e.preventDefault();
	if (bloqueoObservaciones) {
		e.preventDefault();
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
    const data = {
        id_organizacion: $("#id_org_ver_form").attr("data-id"),
    };
    confirmarAccion(
        "Solicitar Camara de Comercio",
        "¿Está seguro de solicitar la cámara de comercio?",
        "info",
        "popup-swalert-lg"
    ).then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
            url: baseURL + "organizaciones/solicitarCamara",
            type: "post",
            dataType: "JSON",
            data: data,
            beforeSend: function () {
                toastSimple("success", "Un momento... Registrando solicitud");
                $("#solicitarCamara").attr("disabled", true);
            },
            success: function (response) {
				mostrarAlerta('success', 'Solicitud enviada', response.msg);
            },
            error: function (ev) {
                errorControlador(ev);
            },
        });
    });
});
// Función para ver las observaciones de cada formulario
// Ver formulario 1: Información General
$("#verInfGenMenuAdmin").click(function () {
	$("#informacion").show();
	$("#documentacion").hide();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").hide();
	$("#datosBasicosProgramas").hide();
	$("#datosModalidades").hide();
	$("#docentes").hide();
	$("#plataforma").hide();
	$("#enLinea").hide();
	/** Formulario 1 Tablas **/
	verObservaciones(1);
});
// Ver formulario 2: Documentación Legal
$("#verDocLegalMenuAdmin").click(function () {
	$("#informacion").hide();
	$("#documentacion").show();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").hide();
	$("#datosBasicosProgramas").hide();
	$("#datosModalidades").hide();
	$("#docentes").hide();
	$("#plataforma").hide();
	$("#enLinea").hide();
	// Formulario 2 Tablas
	html = "";
	obsForm = 0;
	let data = {
		id_organizacion: data_orgFinalizada["0"].organizaciones["id_organizacion"],
		idSolicitud: data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
	};
	// Consultar datos por ajax
	$.ajax({
		url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Llenar tabla de datos documentación legal
			if (response.documentacion["tipo"] == 1) {
				html = "";
				html += "<td>La organización registro Cámara de Comercio </td></tr>";
				$(".tabla_datos_documentacion_legal").html(html);
			}
			if (response.documentacion["tipo"] == 2) {
				html = "";
				html +=
					"<tr><td colspan='5'>Certificado de existencia y representación legal</td></tr>";
				html += "<tr><td>Entidad</td>";
				html += "<td>Fecha Expedición</td>";
				html += "<td>Departamento</td>";
				html += "<td>Municipio</td>";
				html += "<td>Documento</td></tr>";
				$(".head_tabla_datos_documentacion_legal").html(html);
				html = "";
				html +=
					"<tr><td>" + response.certificadoExistencia["entidad"] + "</td>";
				html +=
					"<td>" + response.certificadoExistencia["fechaExpedicion"] + "</td>";
				html +=
					"<td>" + response.certificadoExistencia["departamento"] + "</td>";
				html += "<td>" + response.certificadoExistencia["municipio"] + "</td>";
				html +=
					"<td><button class='btn btn-success btn-sm verDocumentoLegal' data-form='2.1' data-id=" +
					response.certificadoExistencia["id_certificadoExistencia"] +
					">Ver Documento <i class='fa fa-file-o' aria-hidden='true'></i></button></td></tr>";
				$(".tabla_datos_documentacion_legal").html(html);
			}
			if (response.documentacion["tipo"] == 3) {
				html = "";
				html += "<tr><td colspan='7'>Registro Educativo</td></tr>";
				html += "<tr><td>Entidad</td>";
				html += "<td>Fecha Expedición</td>";
				html += "<td>Nombre Programa</td>";
				html += "<td>Numero Resolución</td>";
				html += "<td>Objeto</td>";
				html += "<td>Tipo Educación</td>";
				html += "<td>Documento</td></tr>";
				$(".head_tabla_datos_documentacion_legal").html(html);
				html = "";
				html +=
					"<tr><td>" +
					response.registroEducativoProgramas["entidadResolucion"] +
					"</td>";
				html +=
					"<td>" +
					response.registroEducativoProgramas["fechaResolucion"] +
					"</td>";
				html +=
					"<td>" +
					response.registroEducativoProgramas["nombrePrograma"] +
					"</td>";
				html +=
					"<td>" +
					response.registroEducativoProgramas["numeroResolucion"] +
					"</td>";
				html +=
					"<td>" +
					"<textarea class='form-control' style='width: 100%; min-height: 80px; max-height: 120px; resize: vertical; font-size: 0.875rem; border: 1px solid #e3e6f0;' readonly>" +
					response.registroEducativoProgramas["objetoResolucion"] +
					"</textarea>" +
					"</td>";
				html +=
					"<td>" +
					response.registroEducativoProgramas["tipoEducacion"] +
					"</td>";
				html +=
					"<td><button class='btn btn-success btn-sm verDocumentoLegal' data-form='2.2' data-id=" +
					response.registroEducativoProgramas["id_registroEducativoPro"] +
					">Ver Documento <i class='fa fa-file-o' aria-hidden='true'></i></button></td></tr>";
				$(".tabla_datos_documentacion_legal").html(html);
			}
			verObservaciones(2);
		},
	});
});
// Ver documento formulario 2
$(document).on("click", ".verDocumentoLegal", function () {
	let data = {
		id: $(this).attr("data-id"),
		formulario: $(this).attr("data-form"),
	};
	verDocumentos(data);
});
// Ver formulario 3: Antecedentes Académicos
$("#verJorActMenuAdmin").click(function () {
	$("#informacion").hide();
	$("#documentacion").hide();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").show();
	$("#datosBasicosProgramas").hide();
	$("#docentes").hide();
	$("#datosModalidades").hide();
	$("#plataforma").hide();
	$("#enLinea").hide();
	/** Formulario 2 Tablas **/
	let html = "";
	let data = {
		id_organizacion: data_orgFinalizada["0"].organizaciones["id_organizacion"],
		idSolicitud: data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
		keyForm: 4,
	};
	// Consultar datos por ajax
	$.ajax({
		url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Llenar tabla de datos antecedentes académicos
			if (response.jornadasActualizacion.length == 0) {
				html += "<td colspan='4'>No hay datos </td></tr>";
			} else {
				html +=
					"<tr><td>" + response.jornadasActualizacion["asistio"] + "</td>";
				for (let $i = 0; $i < response.archivos.length; $i++) {
					if (
						response.archivos[$i].id_formulario == "3" &&
						response.archivos[$i].id_registro == data.idSolicitud
					) {
						html +=
							"<td><a class='btn btn-sm btn-siia' href='" +
							baseURL +
							"uploads/jornadas/" +
							response.archivos[$i]["nombre"] +
							"' target='_blank'> Ver documento </td></tr>";
					}
				}
			}
			$(".tabla_datos_jornadas").html(html);
			verObservaciones(3);
		},
	});
});
// Ver formulario 4: Datos Básicos de los Programas
$("#verProgBasMenuAdmin").click(function () {
	$("#informacion").hide();
	$("#documentacion").hide();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").hide();
	$("#datosBasicosProgramas").show();
	$("#docentes").hide();
	$("#datosModalidades").hide();
	$("#plataforma").hide();
	$("#enLinea").hide();
	/** Formulario 6 Tablas **/
	let html = "";
	let data = {
		id_organizacion: data_orgFinalizada["0"].organizaciones["id_organizacion"],
		idSolicitud: data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
		keyForm: 5,
	};
	// Consultar datos por ajax
	$.ajax({
		url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Llenar tabla de datos en línea registrados
			if (response.datosProgramas.length == 0) {
				html += "<td colspan='4'>No hay datos </td></tr>";
			} else {
				for (let i = 0; i < response.datosProgramas.length; i++) {
					html +=
						"<tr><td>" +
						response.organizaciones["nombreOrganizacion"] +
						"</td>";
					html += "<td>" + response.organizaciones["numNIT"] + "</td>";
					html +=
						"<td>" + response.datosProgramas[i]["nombrePrograma"] + "</td>";
					html +=
						"<td>" + response.datosProgramas[i]["aceptarPrograma"] + "</td>";
					html += "<td>" + response.datosProgramas[i]["fecha"] + "</td>";
					switch (response.datosProgramas[i]["nombrePrograma"]) {
						case "Programa organizaciones y redes SEAS":
							$("#programa_seas").show();
							break;
						case "Acreditación Curso Básico de Economía Solidaria":
							$("#curso_basico_es").show();
							break;
						case "Acreditación Aval de Trabajo Asociado":
							$("#curso_basico_aval").show();
							break;
						case "Acreditación Curso Medio de Economía Solidaria":
							$("#curso_medio_es").show();
							break;
						case "Acreditación Curso Avanzado de Economía Solidaria":
							$("#curso_avanzado_es").show();
							break;
						case "Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria":
							$("#curso_economia_financiera").show();
							break;
						default:
					}
				}
			}
			$(".tabla_registro_programas").html(html);
			verObservaciones(4);
		},
	});
});
// Ver formulario 5: Facilitadores
$("#verFaciliMenuAdmin").click(function () {
	$("#informacion").hide();
	$("#documentacion").hide();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").hide();
	$("#datosBasicosProgramas").hide();
	$("#docentes").show();
	$("#datosModalidades").hide();
	$("#plataforma").hide();
	$("#enLinea").hide();
	// Cargar observaciones de Docentes (Form 5)
	verObservaciones(5);
});
// Ver formulario 6: Modalidades
$("#verDatModalidades").click(function () {
	$("#informacion").hide();
	$("#documentacion").hide();
	$("#registroEducativoProgramas").hide();
	$("#antecedentesAcademicos").hide();
	$("#jornadasActualizacion").hide();
	$("#datosBasicosProgramas").hide();
	$("#docentes").hide();
	$("#datosModalidades").show();
	$("#plataforma").hide();
	$("#enLinea").hide();
	/** Formulario 6 Tablas **/
	let html = "";
	let data = {
		id_organizacion: data_orgFinalizada["0"].organizaciones["id_organizacion"],
		idSolicitud: data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
		keyForm: 6,
	};
	// Consultar datos por ajax
	$.ajax({
		url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Llenar tabla de datos en línea registrados
			if (response.datosModalidades.length === 0) {
				html += "<td colspan='4'>No hay datos </td></tr>";
			} else {
				for (let i = 0; i < response.datosModalidades.length; i++) {
					html +=
						"<tr><td>" +
						response.organizaciones["nombreOrganizacion"] +
						"</td>";
					html += "<td>" + response.organizaciones["numNIT"] + "</td>";
					html +=
						"<td>" + response.datosModalidades[i]["nombreModalidad"] + "</td>";
					html +=
						"<td>" + response.datosModalidades[i]["aceptarModalidad"] + "</td>";
					html += "<td>" + response.datosModalidades[i]["fecha"] + "</td>";
				}
			}
			$(".tabla_registro_modalidades").html(html);
			verObservaciones(6);
		},
	});
});
// Terminar proceso de observación
$(document).on("click", "#terminar_proceso_observacion", function (e) {
	if (bloqueoObservaciones) {
		e.preventDefault();
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	let msg =
		"¿Está seguro de terminar el proceso de observación de la solicitud <strong>" +
		data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"] +
		"</strong>?<br><br>Esto cambiará el estado de la solicitud y ahora pasará a la bandeja de <strong>complementaria</strong>.<br><br>Se enviará un correo a la organización.";
	confirmarAccion("Enviar observaciones", msg, "question").then(
		(result) => {
			if (result.isConfirmed) {
				let data = {
					id_organizacion:
						data_orgFinalizada["0"].organizaciones["id_organizacion"],
					idSolicitud:
						data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
				};
				$("#terminar_proceso_observacion").attr("disabled", true);
				toastSimple("info", "Enviando observaciones");
				$.ajax({
					url: baseURL + "observaciones/cambiarEstadoSolicitud",
					type: "post",
					dataType: "JSON",
					data: data,
					success: function (response) {
						mostrarAlerta(response.status, response.title, response.msg).then(
							(result) => {
								if (result.isConfirmed) {
									setInterval(function () {
										reload();
									}, 2000);
								}
							}
						);
					},
					error: function (ev) {
						errorControlador(ev);
					},
				});
			}
		}
	);
});
// Funciones para guardar las observaciones de cada formulario
$(".guardarObservacionesForm1").click(() => guardarObservacionForm(1, "#observacionesForm1", "Observaciones Información General", "datosInformacionGeneral"));
$(".guardarObservacionesForm2").click(() => guardarObservacionForm(2, "#observacionesForm2", "Documentación Legal", "datosDocumentacionLegal"));
$(".guardarObservacionesForm3").click(() => guardarObservacionForm(3, "#observacionesForm3", "Jornadas de Actualización", "datosJornadasActualizacion"));
$(".guardarObservacionesForm4").click(() => guardarObservacionForm(4, "#observacionesForm4", "Observaciones Programas Básicos", "datosProgramasBasicos"));
$(".guardarObservacionesForm5").click(() => guardarObservacionForm(5, "#observacionesForm5", "Observaciones Docentes", "datosDocentes"));
$(".guardarObservacionesForm6").click(() => guardarObservacionForm(6, "#observacionesForm6", "Observaciones Modalidades", "datosModalidades"));
// Aprobar archivo
$(document).on("click", ".revisarArchivo", function (e) {
	const checkbox = $(this);
	const isChecked = checkbox.is(":checked");
	if (bloqueoObservaciones) {
		e.preventDefault();
		// revertir estado visual si alcanzó a cambiar
		checkbox.prop("checked", !isChecked);
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	if (isChecked) {
		let data = {
			idArchivo: checkbox.attr("data-id"),
			activo: 0,
		};
		let text =
			"¿Desea marcar como revisado el documento? <br><br> Una vez se recargue la pagína y/o se finalice el proceso de observaciones, esta acción no podrá ser revertida y el documento no podrá ser modificado ni eliminado del sistema.";
		confirmarAccion("Revisar documento", text, "question").then(
			(result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: baseURL + "Archivos/revisarArchivo",
						type: "post",
						dataType: "JSON",
						data: data,
						beforeSend: function () {
							toastSimple("info", "Cambiando estado al archivo");
						},
						success: function (response) {
							toastSimple(response.status, response.msg);
						},
						error: function (ev) {
							errorControlador(ev);
							checkbox.prop("checked", false);
						},
					});
				} else {
					checkbox.prop("checked", false);
				}
			}
		);
	} else {
		let data = {
			idArchivo: checkbox.attr("data-id"),
			activo: 1,
		};
		$.ajax({
			url: baseURL + "Archivos/revisarArchivo",
			type: "post",
			dataType: "JSON",
			data: data,
		});
	}
});
// Aprobar observación con confirmación
$(document).on("click", ".validarObservacion", function (e) {
	const checkbox = $(this);
	const isChecked = checkbox.is(":checked");
	if (bloqueoObservaciones) {
		e.preventDefault();
		// revertir estado visual si alcanzó a cambiar
		checkbox.prop("checked", !isChecked);
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	if (isChecked) {
		let data = {
			idObservacion: checkbox.attr("data-id"),
			idForm: checkbox.attr("data-idform"),
			valida: 1,
		};
		confirmarAccion(
			"Aprobar Observación",
			"¿Está seguro de aprobar esta observación?<br><br>Si aprueba la observación, no será visible para la organización.",
			"question"
		).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "Observaciones/validarObservacion",
					type: "post",
					dataType: "JSON",
					data: data,
					beforeSend: function () {
						toastSimple("info", "Aprobando observación...");
					},
					success: function (response) {
						toastSimple(response.status, response.msg);
						verObservaciones(data["idForm"]);
					},
					error: function (ev) {
						errorControlador(ev);
						checkbox.prop("checked", false);
					},
				});
			} else {
				checkbox.prop("checked", false);
			}
		});
	} else {
		let data = {
			idObservacion: checkbox.attr("data-id"),
			idForm: checkbox.attr("data-idform"),
			valida: 0,
		};
		$.ajax({
			url: baseURL + "Observaciones/validarObservacion",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				toastSimple(response.status, response.msg);
				verObservaciones(data["idForm"]);
			},
			error: function (ev) {
				errorControlador(ev);
				checkbox.prop("checked", true);
			},
		});
	}
});
// Eliminar observación con confirmación
$(document).on("click", ".eliminarObservacionForm", function (e) {
	const button = $(this);
	if (bloqueoObservaciones) {
		e.preventDefault();
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	let data = {
		idObservacion: button.attr("data-id"),
		idForm: button.attr("data-idform"),
	};
	confirmarAccion(
		"Eliminar Observación",
		"¿Está seguro de eliminar esta observación?<br><br>Esta acción no se puede deshacer.",
		"warning"
	).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: baseURL + "Observaciones/eliminarObservacion",
				type: "post",
				dataType: "JSON",
				data: data,
				beforeSend: function () {
					toastSimple("info", "Eliminando observación...");
				},
				success: function (response) {
					toastSimple(response.status, response.msg);
					verObservaciones(data["idForm"]);
				},
				error: function (ev) {
					errorControlador(ev);
				},
			});
		}
	});
});
// Guardar observación
function guardarObservacionForm(idFormulario,campoObservacion,formulario,valueForm) {
	if (bloqueoObservaciones) {
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	const data = {
		observacion: $(campoObservacion).val(),
		id_formulario: idFormulario,
		formulario: formulario,
		valueForm: valueForm,
		idSolicitud: $("#id_org_ver_form").attr("data-solicitud"),
		id: $("#id_org_ver_form").attr("data-id"),
	};
	guardarObservacion(data);
	$(campoObservacion).val("");
}
function guardarObservacion(data) {
	event.preventDefault();
	if (bloqueoObservaciones) {
		toastSimple("warning", "Acción deshabilitada en vista de Observaciones");
		return;
	}
	// Validar campos
	if (data.observacion == "" || data.observacion == null) {
		toastSimple("error", "Debe ingresar una observación");
		return false;
	}
	$.ajax({
		url: baseURL + "Observaciones/create",
		type: "post",
		dataType: "JSON",
		data: data,
		beforeSend: function () {
			toastSimple("info", "Guardando");
		},
		success: function (response) {
			alertaGuardarObservacionFormulario(
				response.msg,
				response.status,
				data.id_formulario
			);
		},
		error: function (ev) {
			errorControlador(ev);
		},
	});
}
// Cargar observaciones de un formulario específico
// idForm: 1, 2, 3, 4, 6
function verObservaciones(idForm) {
	html = "";
	obsForm = 0;
	let data = {
		id_organizacion: data_orgFinalizada["0"].organizaciones["id_organizacion"],
		idSolicitud: data_orgFinalizada["0"].tipoSolicitud["0"]["idSolicitud"],
	};
	// Consultar datos por ajax
	$.ajax({
		url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Contar observaciones para este formulario
			for (let i = 0; i < response.observaciones.length; i++) {
				if (response.observaciones[i]["idForm"] == idForm) {
					obsForm += 1;
				}
			}
			if (obsForm != 0) {
				// Destruir DataTable existente si existe
				if ($.fn.DataTable.isDataTable("#tabla_observaciones_form" + idForm)) {
					$("#tabla_observaciones_form" + idForm).DataTable().destroy();
				}
				// Usar las clases estándar del sistema
				html += '<div class="form-table-container">';
				// Título rápido para la tabla de observaciones
				html += '<h5 class="mb-3 font-weight-bold"><i class="fa fa-comments mr-2"></i>Historial de observaciones formulario ' + idForm + '</h5>';
				html += '<table id="tabla_observaciones_form' + idForm + '" class="table table-striped table-bordered">';
				html += '<thead>';
				html += '<tr>';
				html += '<th>Fecha</th>';
				html += '<th>Revisión</th>';
				html += '<th>Observación</th>';
				if (response.solicitudes["numeroRevisiones"] > 0 && response.estadoOrganizaciones["nombre"] == "Finalizado") {
					html += '<th>Verificar</th>';
				}
				if (response.estadoOrganizaciones["nombre"] === "Finalizado") {
					html += '<th>Acciones</th>';
				}
				html += '</tr>';
				html += '</thead>';
				html += '<tbody>';
				// Generar filas de la tabla
				for (let i = 0; i < response.observaciones.length; i++) {
					if (response.observaciones[i]["idForm"] == idForm) {
						// Formatear fecha
						let fecha = new Date(response.observaciones[i]["fechaObservacion"]);
						let fechaFormateada = fecha.toLocaleDateString('es-ES', {
							year: 'numeric',
							month: 'short',
							day: 'numeric',
							hour: '2-digit',
							minute: '2-digit'
						});
						html += '<tr>';
						html += '<td>' + fechaFormateada + '</td>';
						html += '<td>#' + response.observaciones[i]["numeroRevision"] + '</td>';
						html += '<td><textarea class="form-control" readonly rows="3">' + response.observaciones[i]["observacion"] + '</textarea></td>';
						// Checkbox para verificar observación con confirmación
						if (response.solicitudes["numeroRevisiones"] > 0 && response.estadoOrganizaciones["nombre"] == "Finalizado") {
							let isChecked = response.observaciones[i]["valida"] == 1 ? 'checked' : '';
							html += '<td><input type="checkbox" class="validarObservacion" data-idform="' + idForm + '" data-id="' + response.observaciones[i]["id_observacion"] + '" ' + isChecked + '></td>';
						}
						// Botón eliminar con confirmación
						if (response.estadoOrganizaciones["nombre"] === "Finalizado") {
							html += '<td><button class="btn btn-danger btn-sm eliminarObservacionForm" data-id="' + response.observaciones[i]["id_observacion"] + '" data-idform="' + idForm + '" title="Eliminar observación"><i class="fa fa-trash"></i></button></td>';
						}
						html += '</tr>';
					}
				}
				html += '</tbody>';
				html += '</table>';
				html += '</div>';
				$(".observaciones_realizadas_form" + idForm).html(html);
				// Verificar si la tabla ya está inicializada
				if (!$.fn.DataTable.isDataTable('#tabla_observaciones_form' + idForm)) {
					// Inicializar tabla simple de registros telefónicos
					DataTableConfig.initSimpleTable(
						'#tabla_observaciones_form' + idForm,
						'Registro Observaciones',
						'registro_observaciones'
					);
				} else {
					// Si ya está inicializada, obtener la instancia existente
					var table = $('#tabla_reportes_telefonico').DataTable();
					// Aquí puedes aplicar configuraciones adicionales si es necesario
				}
			} else {
				// No hay observaciones - mensaje simple usando clases existentes
				html = '<div class="observaciones-empty-message">';
				html += '<i class="mdi mdi-comment-remove-outline"></i>';
				html += '<p><strong>Sin observaciones</strong></p>';
				html += '<p>No se han registrado observaciones para este formulario.</p>';
				html += '</div>';
				$(".observaciones_realizadas_form" + idForm).html(html);
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al cargar observaciones:', error);
			html = '<div class="observaciones-empty-message">';
			html += '<i class="mdi mdi-alert-circle-outline"></i>';
			html += '<p><strong>Error al cargar</strong></p>';
			html += '<p>No se pudieron cargar las observaciones. Intente nuevamente.</p>';
			html += '</div>';
			$(".observaciones_realizadas_form" + idForm).html(html);
		}
	});
}
// Todas las notificaciones
function alertaGuardarObservacionFormulario(msg, status, form) {
	toastSimple(status, msg);
	if (form !== undefined) verObservaciones(form);
}
// Ver documentos
function verDocumentos(data) {
	event.preventDefault();
	$.ajax({
		url: baseURL + "panel/verDocumento",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			window.open(response.file, "_blank");
		},
	});
}
// Eliminar observación
function eliminarObservacion(data) {
	event.preventDefault();
	$.ajax({
		url: baseURL + "observaciones/eliminarObservacion",
		type: "post",
		data: data,
		dataType: "JSON",
		beforeSend: function () {
			$(this).attr("disabled", true);
			toastSimple("warning", "Eliminando");
		},
		success: function (response) {
			alertaGuardarObservacionFormulario(
				response.msg,
				response.status,
				data["idForm"]
			);
		},
		error: function (ev) {
			errorControlador(ev);
			event.preventDefault();
		},
	});
}

// Ocultar el menú al volver
$(document).on("click", "#admin_ver_finalizadas_volver", function () {
    $("#floatingMenuContainer").fadeOut(150);
    $("#floatingMenuToggle").removeClass("show");
    $("#floatingMenuPanel").removeClass("show");
    $("#floatingObservacionesContainer").fadeOut(150);
    $("#floatingObservacionesToggle").removeClass("show");
    $("#floatingObservacionesPanel").removeClass("show");
});
