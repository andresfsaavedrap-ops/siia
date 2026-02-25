// Init Select2
export function initSelects() {
	$(".selectpicker").selectpicker({
		size: 9,
		width: "100%", // Cambiar de "fit" a "100%" para que se ajuste al ancho del formulario
		title: "Seleccione una opción...",
		noneSelectedText: "Por favor, seleccione uno.",
		liveSearch: true,
		liveSearchNormalize: true,
		liveSearchPlaceholder: "Buscar...",
	});
	
	// Agregar estilos personalizados después de inicializar
	$(".selectpicker").each(function() {
		$(this).parent('.bootstrap-select').css({
			'width': '100%',
			'max-width': '100%'
		});
	});
}

export function initDatepickers() {
	$(".datepicker").flatpickr({
		enableTime: true,
		dateFormat: "Y/m/d H:i:ss",
		locale: "es",
	});
	
	// Personalizar el estilo del input después de inicializar
	$(".datepicker").each(function() {
		$(this).css({
			'background-color': '#ffffff',
			'background': '#ffffff'
		});
	});
}
// Init Input File
export function initInputFile() {
	// Mostrar el nombre del archivo seleccionado en los input file
	$('.custom-file-input').on('change', function() {
		var fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').html(fileName);
	});
}
// Init Input File
export function initInputFilePoint() {
	// Mostrar el nombre del archivo seleccionado en los input file
	$('.file-upload input[type="file"]').on('change', function() {
		var fileName = $(this).val().split('\\').pop();
		var $label = $(this).siblings('.file-upload-label');
		var $span = $label.find('span');
		if (fileName) {
			// Limitar la longitud del nombre del archivo si es muy largo
			if (fileName.length > 20) {
				var displayName = fileName.substring(0, 17) + '...';
				$span.text(displayName);
				// Añadir un tooltip con el nombre completo
				$label.attr('title', fileName);
			} else {
				$span.text(fileName);
				$label.removeAttr('title');
			}
			// Cambiar el icono y añadir una clase para estilos visuales
			$label.find('i').removeClass('fa-upload').addClass('fa-check');
			$label.addClass('file-selected');
		} else {
			// Restaurar el estado original
			$span.text('Seleccionar archivo');
			$label.removeAttr('title');
			$label.find('i').removeClass('fa-check').addClass('fa-upload');
			$label.removeClass('file-selected');
		}
	});
}
/**
 * Carga la lista de municipios para un departamento específico y los muestra en un select.
 * @param {string|number} departamento - El ID del departamento seleccionado
 * @param {jQuery} select - El elemento select donde se cargarán los municipios
 * @returns {Promise} - Promesa que se resuelve cuando la operación completa
 */
export function cargarMunicipios(departamento, select) {
	if (!departamento || !select) {
		console.warn("Parámetros incompletos para cargar municipios");
		return Promise.reject(new Error("Parámetros incompletos"));
	}
	return $.ajax({
		url: `${baseURL}panel/cargarMunicipios`,
		type: "POST",
		dataType: "JSON",
		data: { departamento },
		beforeSend: function() {
			// Limpiar el select antes de la carga
			select.empty();
			select.selectpicker("refresh");
		}})
		.then(function(municipios) {
			if (!Array.isArray(municipios) || municipios.length === 0) {
				select.append('<option value="">No hay municipios disponibles</option>');
				return municipios;
			}
			// Crear fragment para mejor rendimiento
			const fragment = document.createDocumentFragment();
			municipios.forEach(function(municipio) {
				const option = document.createElement("option");
				option.id = municipio.id_municipio;
				// Mantener el comportamiento original con espacios en blanco
				option.value = municipio.nombreMunicipio.replace(/ /g, "&nbsp;");
				option.textContent = municipio.nombreMunicipio;
				fragment.appendChild(option);
			});
			select.append(fragment);
			select.selectpicker("refresh");
			return municipios;
		})
		.catch(function(error) {
			console.error("Error al cargar municipios:", error);
			select.append('<option value="">Error al cargar municipios</option>');
			select.selectpicker("refresh");
			return Promise.reject(error);
		});
}
/**
 * Cargar tabla de archivos
 */
export function cargarArchivos(id) {
	$(".tabla_form > #tbody").empty();
	let data = {
		id_form: id,
	};
	$.ajax({
		url: baseURL + "Archivos/cargarDatosArchivos",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			let url;
			let carpeta;
			if (response.length === 0) {
				$("<tr>").appendTo(".tabla_form > tbody");
				$("<td>Ningún dato</td>").appendTo(".tabla_form > tbody");
				$("<td>Ningún dato</td>").appendTo(".tabla_form > tbody");
				$("<td>Ningún dato</td>").appendTo(".tabla_form > tbody");
				$(".tabla_form > tbody > tr.odd").remove();
			} else {
				for (var i = 0; i < response.length; i++) {
					if (response[i].tipo === "carta") {
						carpeta = "cartaRep";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "certificaciones") {
						carpeta = "certificaciones";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "lugar") {
						carpeta = "lugarAtencion";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "autoevaluacion") {
						carpeta = "autoevaluaciones";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "registroEdu") {
						carpeta = "registrosEducativos";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "jornadaAct") {
						carpeta = "jornadas";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "materialDidacticoProgBasicos") {
						carpeta = "materialDidacticoProgBasicos";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "materialDidacticoAvalEconomia") {
						carpeta = "materialDidacticoAvalEconomia";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "formatosEvalProgAvalar") {
						carpeta = "formatosEvalProgAvalar";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "materialDidacticoProgAvalar") {
						carpeta = "materialDidacticoProgAvalar";
						url = baseURL + "uploads/" + carpeta + "/";
					}
					if (response[i].tipo === "instructivoPlataforma") {
						carpeta = "instructivosPlataforma";
						url = baseURL + "uploads/" + carpeta + "/";
					}

					$("<tr>").appendTo(".tabla_form > tbody");
					var nombre_r = response[i].nombre.replace('"', "").replace('"', "");
					var tipo_r = response[i].tipo.replace('"', "").replace('"', "");
					let tipo;
					switch (tipo_r) {
						case "carta":
							tipo = "Carta de solicitud";
							break;
						case "certificaciones":
							tipo = "Certificado de procesos educativos";
							break;
						case "lugar":
							tipo = "Lugar de atención";
							break;
						case "autoevaluacion":
							tipo = "Autoevaluación para renovación";
							break;
						case "registroEdu":
							tipo = "Registro educativo";
							break;
						case "materialDidacticoProgBasicos":
							tipo = "Material didactico P. Básicos";
							break;
						case "materialDidacticoAvalEconomia":
							tipo = "Material didactico P. Aval";
							break;
						case "formatosEvalProgAvalar":
							tipo = "Formato de evaluación de P. Aval";
							break;
						case "materialDidacticoProgAvalar":
							tipo = "Material didactico P. Aval";
							break;
						case "instructivoPlataforma":
							tipo = "Instructivo de plataforma";
							break;
						case "jornadaAct":
							tipo = "Archivo de jornada ó Carta de compromiso";
							break;
					}
					$("<td><small>" + nombre_r + "</small></td>").appendTo(
						".tabla_form > tbody"
					);
					$("<td>" + tipo + "</td>").appendTo(".tabla_form > tbody");
					// Estado del botón eliminar: habilitado si activo === 1, deshabilitado si activo === 0
					const isActivo = Number(response[i].activo) === 1;
					const eliminarAttrs = isActivo
						? ""
						: 'disabled title="Ya fue aprobado el documento"';

					$(
						"<td>" +
						'<div class="btn-group" role="group" aria-label="acciones">' +
						'<a class="btn btn-success btn-sm" target="_blank" href="' +
						url +
						response[i].nombre +
						'">Ver <i class="fa fa-eye" aria-hidden="true"></i></a>' +
						// botón eliminar como hijo directo de .btn-group para no romper el estilo
						'<button class="btn btn-danger btn-sm eliminar_archivo" data-id-tipo="' +
						response[i].tipo +
						'" data-nombre-ar="' +
						response[i].nombre +
						'" data-id-formulario="' +
						response[i].id_formulario +
						'" data-id-archivo="' +
						response[i].id_archivo +
						'" data-activo="' +
						response[i].activo +
						'" ' +
						eliminarAttrs +
						'>Eliminar <i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
						"</div></td>"
					).appendTo(".tabla_form > tbody");
					$("</tr>").appendTo(".tabla_form > tbody");
				}
				$(".tabla_form > tbody > tr.odd").remove();
			}
		},
		error: function (ev) {
			//Do nothing
		},
	});
}
export function redirect(response) {
	let url = response.replace('"', "").replace('"', "");
	$(window).attr("location", url);
}
/**
	Recargar la página, en false para cache, en true para cargar desde 0.
 **/
export function reload() {
	location.reload(false);
}
export function clearInputs(id) {
	$("#" + id + " :input").each(function () {
		$(this).val("");
	});
}
