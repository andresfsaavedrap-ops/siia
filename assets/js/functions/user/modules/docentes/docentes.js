
// Importar funciones predefinidas
import { toastSimple, mostrarAlerta, procesando, alertaGuardado, confirmarAccion, errorControlador, errorValidacionFormulario } from '../../../partials/alerts-config.js';
import { initSelects, initInputFile, initInputFilePoint, cargarMunicipios } from '../../../partials/other-funtions-init.js';
import { datatableInit } from '../../../partials/datatable-init.js';
// Archivo del módulo de usuarios de docentes
$(document).ready(function () {
	$("#divAgregarDoc").hide();
	$("#continuar-docentes").click(function (e) {
		$("#instrucciones-registro-docentes").hide();
		$("#divDocentesRegistrados").show();
	});
	$(document).off('click', '.verDivAgregarDoc').on('click', '.verDivAgregarDoc', function (e) {
		e.preventDefault();
		if ($("#divAgregarDoc").is(":visible")) {
			$("#divAgregarDoc").slideUp(400);
			$("#divDocentesRegistrados").slideDown(400);
			$("#instrucciones-registro-docentes").slideDown(400);
		} else {
			$("#divDocentesRegistrados").slideUp(400);
			$("#instrucciones-registro-docentes").slideUp(400);
			$("#divAgregarDoc").slideDown(400);
		}
	});
	// Añadir nuevo docente
	$("#añadirNuevoDocente").click(function () {
		ValidarFormDocentes("docentes");
		if ($("#formulario_crear_docente").valid()) {
			$(this).attr("disabled", true);
			let data = {
				cedula: $("#docentes_cedula").val(),
				primer_nombre: $("#docentes_primer_nombre").val(),
				segundo_nombre: $("#docentes_segundo_nombre").val(),
				primer_apellido: $("#docentes_primer_apellido").val(),
				segundo_apellido: $("#docentes_segundo_apellido").val(),
				profesion: $("#docentes_profesion").val(),
				horas: $("#docentes_horas").val(),
				valido: 0,
			};
			$.ajax({
				url: baseURL + "docentes/anadirNuevoDocente",
				type: "post",
				dataType: "JSON",
				data: data,
				beforeSend: function () {
					toastSimple("info", "Guardando Información");
				},
				success: function (response) {
					mostrarAlerta("success", "Se creo docente!", response.msg).then((result) => {
						if (result.isConfirmed) {
							setInterval(function () {
								location.reload(false);
							}, 2000);
						}
					});
				},
				error: function (ev) {
					toastSimple("error", "Error al ingresar información.");
				},
			});
		} else {
			toastSimple("warning", "Formulario no validado.");
		}
	});
	// Delegar el clic para abrir modal y cargar datos del docente (funciona después de refrescar listado)
	$(document).on("click", ".verDocenteOrg", function () {
		let nombre_docente = $(this).attr("data-nombre");
		let id_docente = $(this).attr("data-id");
		let data = { id_docente: id_docente };

		$.ajax({
			url: baseURL + "docentes/cargarInformacionDocente",
			type: "post",
			dataType: "JSON",
			data: data,
			success: function (response) {
				$("#nombre_doc").html(nombre_docente);
				$("#nombre_doc").attr("data-id", id_docente);
				$("#siEliminarDocente").attr("data-id", id_docente);

				$("#primer_nombre_doc").val(response.primerNombreDocente);
				$("#segundo_nombre_doc").val(response.segundoNombreDocente);
				$("#primer_apellido_doc").val(response.primerApellidoDocente);
				$("#segundo_apellido_doc").val(response.segundoApellidoDocente);
				$("#numero_cedula_doc").val(response.numCedulaCiudadaniaDocente);
				$("#profesion_doc").val(response.profesion);
				$("#horas_doc").val(response.horaCapacitacion);

				if (response.valido == 1) {
					$("#valido_doc")
						.text("Aprobado")
						.removeClass("badge-pendiente")
						.addClass("badge-aprobado");
				} else {
					$("#valido_doc")
						.text("Pendiente de aprobación")
						.removeClass("badge-aprobado")
						.addClass("badge-pendiente");
				}

				// Observaciones del docente (sección del modal)
				var obs = (response.observacion || "").trim();
				if (obs.length > 0) {
					$("#observacion_doc").html(obs);
					$("#observaciones_docente_wrap").removeClass("d-none");
				} else {
					$("#observacion_doc").html("");
					$("#observaciones_docente_wrap").addClass("d-none");
				}

				// Marcar el docente activo para adjuntos
                $("#docente_arch_id").remove();
                $("body").append("<div data-docente-id='" + id_docente + "' data-valido='" + (response.valido || 0) + "' id='docente_arch_id'></div>");

				cargarArchivosDocente(id_docente);
			},
			error: function (ev) {
				//Do nothing
			},
		});
	});
	// Delegar el clic para actualizar (datos básicos o enviar a evaluación)
	$(document).on("click", ".actualizar_docente", function () {
		let data = {
			id_docente: $("#nombre_doc").attr("data-id"),
			primer_nombre_doc: $("#primer_nombre_doc").val(),
			segundo_nombre_doc: $("#segundo_nombre_doc").val(),
			primer_apellido_doc: $("#primer_apellido_doc").val(),
			segundo_apellido_doc: $("#segundo_apellido_doc").val(),
			numero_cedula_doc: $("#numero_cedula_doc").val(),
			profesion_doc: $("#profesion_doc").val(),
			horas_doc: $("#horas_doc").val(),
			solicitud: $(this).val(), // "No" o "Si"
		};

		$.ajax({
			url: baseURL + "docentes/actualizarDocente",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple("warning", "Actualizando docente");
			},
			success: function (response) {
				toastSimple("success", response.msg);
			},
			error: function (ev) {
				errorControlador(ev);
			},
		});
	});
	// Eliminar docente
	$("#siEliminarDocente").click(function () {
		$(this).attr("disabled", true);
		let data = {
			id_docente: $(this).attr("data-id"),
		};
		$.ajax({
			url: baseURL + "docentes/eliminarDocente",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				toastSimple("warning", "Eliminando docente");
			},
			success: function (response) {
				toastSimple("success", response.msg);
				setInterval(function () {
					location.reload(false);
				}, 2000);
			},
			error: function (ev) {
				//Do nothing
			},
		});
	});
	// Subir archivo HV docente
	$(".archivos_form_hojaVidaDocente").on("click", function () {
		let $data_name = $(".archivos_form_hojaVidaDocente").attr("data-name");
		let $id_docente = $("#docente_arch_id").attr("data-docente-id");
	
		// Validación: solo permitir una Hoja de vida por docente (basado en estado cargado)
		const estado = $("#docente_arch_id").data("estado_documentos");
		if (estado && estado.contadores && estado.contadores.hojas >= 1) {
			mostrarAlerta(
				"warning",
				"Ya existe hoja de vida",
				"El docente ya tiene una Hoja de vida. Para reemplazarla use el botón 'Editar cargue' en la lista de archivos."
			);
			return false;
		}
	
		var file_data = $("#" + $data_name).prop("files")[0];
		var form_data = new FormData();
		form_data.append("file", file_data);
		form_data.append("tipoArchivo", $("#" + $data_name).attr("data-val"));
		form_data.append("append_name", $data_name);
		form_data.append("id_docente", $id_docente);
		$.ajax({
			url: baseURL + "docentes/guardarArchivoHojaVidaDocente",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				toastSimple("info", "Guardando archivo");
			},
			success: function (response) {
				if (response.status === 1) {
					// Limpiar el input de archivo y el campo de texto visible
					$("#" + $data_name).val('');
					$("#" + $data_name).parent().find('.form-control').val('');
					let mensaje = response.msg;
					// Mostrar información adicional si está disponible
					if (response.documentos_status) {
						if (response.documentos_status.completo) {
							mensaje += " ¡Documentación completa!";
							mostrarAlerta("success", "Archivo cargado!", mensaje);
						} else {
							// Mostrar detalles específicos de documentos faltantes
							let detallesFaltantes = response.documentos_status.documentos_faltantes.map(function(doc) {
								return doc.nombre + " (tiene " + doc.tiene + ", requiere " + doc.requiere + ")";
							}).join(", ");
							mensaje += " Aún faltan: " + detallesFaltantes;
							mostrarAlerta("info", "Archivo cargado!", mensaje);
						}
					} else {
						mostrarAlerta("success", "Se cargo archivo!", mensaje);
					}
				} else {
					mostrarAlerta("warning", "No se cargo archivo!", response.msg);
				}
				cargarArchivosDocente($id_docente);
			},
			error: function (ev) {
				toastSimple("success", "Verifique los datos del formulario.");
			},
		});
	});
	// Subir archivo titulo docente
	$(".archivos_form_tituloDocente").on("click", function () {
		let $data_name = $(".archivos_form_tituloDocente").attr("data-name");
		let $id_docente = $("#docente_arch_id").attr("data-docente-id");
		var file_data = $("#" + $data_name).prop("files")[0];
		var form_data = new FormData();
		form_data.append("file", file_data);
		form_data.append("tipoArchivo", $("#" + $data_name).attr("data-val"));
		form_data.append("append_name", $data_name);
		form_data.append("id_docente", $id_docente);
		$.ajax({
			url: baseURL + "docentes/guardarArchivoTituloDocente",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				toastSimple("info", "Guardando archivo");
			},
			success: function (response) {
				if (response.status === 1) {
					// Limpiar el input de archivo y el campo de texto visible
					$("#" + $data_name).val('');
					$("#" + $data_name).parent().find('.form-control').val('');
					let mensaje = response.msg;
					// Mostrar información adicional si está disponible
					if (response.documentos_status) {
						if (response.documentos_status.completo) {
							mensaje += " ¡Documentación completa!";
							mostrarAlerta("success", "Archivo cargado!", mensaje);
						} else {
							// Mostrar detalles específicos de documentos faltantes
							let detallesFaltantes = response.documentos_status.documentos_faltantes.map(function(doc) {
								return doc.nombre + " (tiene " + doc.tiene + ", requiere " + doc.requiere + ")";
							}).join(", ");
							mensaje += " Aún faltan: " + detallesFaltantes;
							mostrarAlerta("info", "Archivo cargado!", mensaje);
						}
					} else {
						mostrarAlerta("success", "Se cargo archivo!", mensaje);
					}
				} else {
					mostrarAlerta("warning", "No se cargo archivo!", response.msg);
				}
				cargarArchivosDocente($id_docente);
			},
			error: function (ev) {
				toastSimple("success", "Verifique los datos del formulario.");
			},
		});
	});
	// Subir archivo certifica exp docente
	$(".archivos_form_certificadoDocente").on("click", function () {
		let data_name = $(".archivos_form_certificadoDocente").attr("data-name");
		let id_docente = $("#docente_arch_id").attr("data-docente-id");
		var form_data = new FormData();
		let count = 0;
		$.each(
			$("#formulario_archivo_docente_certificados input[type='file']"),
			function (obj, v) {
				var file = v.files[0];
				if (file != undefined) {
					form_data.append("file[" + obj + "]", file);
					count++;
				}
			}
		);
		if (count === 3) {
			form_data.append("append_name", data_name);
			form_data.append("tipoArchivo", $("#" + data_name + "1").attr("data-val"));
			form_data.append("append_name", data_name);
			form_data.append("id_docente", id_docente);
			$.ajax({
				url: baseURL + "archivos/uploadFiles",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: "post",
				dataType: "JSON",
				beforeSubmit: function () {
					toastSimple("info", "Guardando archivo");
				},
				success: function (response) {
					if (response.icon === "success") {
						// Limpiar todos los inputs de archivo del formulario de certificados
						$("#formulario_archivo_docente_certificados input[type='file']").val('');
						// Limpiar también los campos de texto visibles
						$("#formulario_archivo_docente_certificados .form-control").val('');
						mostrarAlerta(response.icon, "Se cargo archivo!", response.msg);
					} else {
						mostrarAlerta(response.icon, "No se cargo archivo!", response.msg);
					}
					cargarArchivosDocente(id_docente);
				},
				error: function (ev) {
					toastSimple("success", "Verifique los datos del formulario.");
				},
			});
		} else {
			mostrarAlerta("warning", "Faltan archivos!", count + "/3 Debes cargar 3 archivos para continuar");
		}
	});
	// Subir archivo certifica ECS docente
	$(".archivos_form_certificadoEconomiaDocente").on("click", function () {
		let $data_name = $(".archivos_form_certificadoEconomiaDocente").attr("data-name");
		let $id_docente = $("#docente_arch_id").attr("data-docente-id");
		let $horasCertEcoSol = $("#horasCertEcoSol").val();
		// Validar que las horas sean mínimo 60
		if (!$horasCertEcoSol || parseInt($horasCertEcoSol) < 60) {
			mostrarAlerta("warning", "Horas insuficientes", "Debe ingresar mínimo 60 horas en el certificado de economía solidaria para poder cargar el documento.");
			return false;
		}
		var file_data = $("#" + $data_name).prop("files")[0];
		// Validar que se haya seleccionado un archivo
		if (!file_data) {
			mostrarAlerta("warning", "Archivo requerido", "Debe seleccionar un archivo para cargar.");
			return false;
		}
		var form_data = new FormData();
		form_data.append("file", file_data);
		form_data.append("tipoArchivo", $("#" + $data_name).attr("data-val"));
		form_data.append("append_name", $data_name);
		form_data.append("id_docente", $id_docente);
		form_data.append("horas", $horasCertEcoSol);
		$.ajax({
			url: baseURL + "docentes/guardarArchivoCertificadoEconomiaDocente",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			dataType: "JSON",
			beforeSubmit: function () {
				toastSimple("info", "Guardando archivo");
			},
			success: function (response) {
				if (response.status === 1) {
					// Limpiar el input de archivo y el campo de texto visible
					$("#" + $data_name).val('');
					$("#" + $data_name).parent().find('.form-control').val('');
					// También limpiar el campo de horas
					$("#horasCertEcoSol").val('');
					let mensaje = response.msg;
					// Mostrar información adicional si está disponible
					if (response.documentos_status) {
						if (response.documentos_status.completo) {
							mostrarAlerta("success", "Archivo cargado!", mensaje);
						} else {
							// Mostrar detalles específicos de documentos faltantes
							let detallesFaltantes = response.documentos_status.documentos_faltantes.map(function(doc) {
								return doc.nombre + " (tiene " + doc.tiene + ", requiere " + doc.requiere + ")";
							}).join(", ");
							mensaje += " Aún faltan: " + detallesFaltantes;
							mostrarAlerta("info", "Archivo cargado!", mensaje);
						}
					} else {
						mostrarAlerta("success", "Se cargo archivo!", mensaje);
					}
				} else {
					mostrarAlerta("warning", "No se cargo archivo!", response.msg);
				}
				cargarArchivosDocente($id_docente);
			},
			error: function (ev) {
				toastSimple("error", "Verifique los datos del formulario.");
			},
		});
	});
	// Eliminar archivo docente
	$(document).on("click", ".eliminar_archivo_docente", function () {
		let id_docente = $(this).attr("data-id-docente");
		let data = {
			id_archivoDocente: $(this).attr("data-id-archivoDocente"),
			id_docente: id_docente,
			tipo: $(this).attr("data-id-tipo"),
			nombre: $(this).attr("data-nombre-ar"),
		};
		confirmarAccion("warning", "Eliminar archivo", "Esta acción eliminará el archivo y su observación asociada. ¿Desea continuar?")
			.then(function (result) {
				if (result && result.isConfirmed) {
					$.ajax({
						url: baseURL + "docentes/eliminarArchivoDocente",
						type: "post",
						dataType: "JSON",
						data: data,
						beforeSend: function () {
							toastSimple("warning", "Eliminando archivo");
						},
						success: function (response) {
							if (response.status === 1) {
								mostrarAlerta("success", "Se eliminó archivo!", response.msg);
							} else {
								mostrarAlerta("warning", "Acción no permitida", response.msg || "No se pudo eliminar.");
							}
							cargarArchivosDocente(id_docente);
						},
						error: function () {
							toastSimple("error", "Archivo no eliminado.");
						}
					});
				}
			});
	});

	$(document).on("click", ".editar_archivo_docente", function () {
		const $btn = $(this);
		const id_docente = $btn.attr("data-id-docente");
		const id_archivo = $btn.attr("data-id-archivoDocente");
		const tipo = $btn.attr("data-id-tipo");
		const input = document.createElement("input");
		input.type = "file";
		input.accept = "application/pdf";
		input.style.display = "none";
		input.addEventListener("change", function () {
			const file = input.files && input.files[0];
			if (!file) return;
			const form_data = new FormData();
			form_data.append("file", file);
			form_data.append("id_archivoDocente", id_archivo);
			form_data.append("id_docente", id_docente);
			form_data.append("tipo", tipo);
			form_data.append("append_name", tipo);
			$.ajax({
				url: baseURL + "docentes/reemplazarArchivoDocente",
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: "post",
				dataType: "JSON",
				beforeSend: function () {
					toastSimple("info", "Reemplazando archivo...");
				},
				success: function (response) {
					if (response.status === 1) {
						mostrarAlerta("success", "Archivo actualizado!", response.msg);
					} else {
						mostrarAlerta("warning", "No se actualizó el archivo", response.msg);
					}
					cargarArchivosDocente(id_docente);
				},
				error: function () {
					toastSimple("error", "Error al reemplazar el archivo.");
				}
			});
			document.body.removeChild(input);
		});
		document.body.appendChild(input);
		input.click();
	});
	// Botón: refrescar tabla y resumen de docentes sin recargar la página

	// Limpiar el estado del modal al cerrarse para evitar arrastrar datos del docente anterior
	$("#verDocenteOrg").on("hidden.bs.modal", function () {
        $("#nombre_doc").text("").removeAttr("data-id");
        $("#siEliminarDocente").removeAttr("data-id");
        $("#primer_nombre_doc, #segundo_nombre_doc, #primer_apellido_doc, #segundo_apellido_doc, #numero_cedula_doc, #profesion_doc, #horas_doc").val("");
        $("#valido_doc").text("").removeClass("badge-aprobado badge-pendiente");
        $("#observacion_doc").html("");
        $("#observaciones_docente_wrap").addClass("d-none");
        // Vaciar SOLO la tabla de adjuntos del modal
        $("#tabla_archivos_docentes tbody").empty();
        $("#docente_arch_id").remove();
    });


    $(document).on("click", ".refrescarDocentes", function () {
        $.ajax({
            url: baseURL + "docentes/refrescarDocentesAjax",
            type: "post",
            dataType: "json",
            beforeSend: function () {
                toastSimple("info", "Actualizando facilitadores...");
            },
            success: function (resp) {
                if (resp.status === 1 && resp.html) {
                    // Cargar el HTML en un contenedor temporal
                    const $temp = $("<div>").html(resp.html);

                    // Tomar las secciones que queremos reemplazar del partial
                    const $newInstr = $temp.find("#instrucciones-registro-docentes");
                    const $newList = $temp.find("#divDocentesRegistrados");

                    // Reemplazar en el DOM actual
                    if ($newInstr.length) {
                        $("#instrucciones-registro-docentes").replaceWith($newInstr);
                    }
                    if ($newList.length) {
                        $("#divDocentesRegistrados").replaceWith($newList);
                    }

                    toastSimple("success", "Facilitadores actualizados.");
                } else {
                    mostrarAlerta("warning", "No se pudo actualizar", resp.msg || "Intente nuevamente.");
                }
            },
            error: function () {
                mostrarAlerta("error", "Error de conexión", "No fue posible actualizar en este momento.");
            }
        });
    });
});

// Cargar Archivos Docentes
function cargarArchivosDocente(id) {
	$(".tabla_form > #tbody").empty();
	let id_docente = id;
	let data = {
		id_docente: id_docente,
	};
	$.ajax({
		url: baseURL + "Docentes/cargarDatosArchivosDocente",
		type: "post",
		dataType: "JSON",
		data: data,
		success: function (response) {
			// Verificar si la respuesta tiene la nueva estructura
			let archivos = response.archivos || response; // Compatibilidad con formato anterior
			let documentos_status = response.documentos_status || null;
			let url;
			let carpeta;
			if (archivos.length == 0) {
				// Mostrar tabla y colocar mensaje de vacío
				$("#tabla_archivos_docentes").show();
				$(".tabla_form > tbody").empty();
				$(".tabla_form > tbody").append(
					"<tr><td colspan='3' class='text-center text-muted'>No hay archivos cargados para este docente</td></tr>"
				);
			} else {
				// Mostrar tabla y renderizar archivos
				$("#tabla_archivos_docentes").show();
				$(".tabla_form > tbody").empty();
				for (let i = 0; i < archivos.length; i++) {
					// URLs archivos
					if (archivos[i].tipo == "docenteHojaVida") {
						carpeta = "docentes/hojasVida";
						url = "uploads/" + carpeta + "/";
					}
					if (archivos[i].tipo == "docenteTitulo") {
						carpeta = "docentes/titulos";
						url = "uploads/" + carpeta + "/";
					}
					if (archivos[i].tipo == "docenteCertificados") {
						carpeta = "docentes/certificados";
						url = "uploads/" + carpeta + "/";
					}
					if (archivos[i].tipo == "docenteCertificadosEconomia") {
						carpeta = "docentes/certificadosEconomia";
						url = "uploads/" + carpeta + "/";
					}
					$("<tr>").appendTo(".tabla_form > tbody");
					const nombre_r = archivos[i].nombre.replace('"', "").replace('"', "");
					const tipo_r = archivos[i].tipo.replace('"', "").replace('"', "");
					let $tipo = '';
					switch (tipo_r) {
						case "docenteHojaVida":
							$tipo = "Hoja de vida";
							break;
						case "docenteTitulo":
							$tipo = "Titulo profesional";
							break;
						case "docenteCertificadosEconomia":
							$tipo = "Certificado de economía solidaria";
							break;
						case "docenteCertificados":
							$tipo = "Certificado de experiencia";
							break;
					}
					$("<td>" + $tipo + "</td>").appendTo(".tabla_form > tbody");
					$(
						'<td><textarea class="form-control" rows="4" disabled>' +
						archivos[i].observacionArchivo +
						"</textarea></td>"
					).appendTo(".tabla_form > tbody");
                    (function(){
                        const validoDoc = parseInt($("#docente_arch_id").attr("data-valido"), 10) || 0;
                        let botones = "<td class='text-center'>" +
                            '<div class="btn-group">' +
                            '<a class="btn btn-success btn-sm" target="_blank" href="' + baseURL + url + archivos[i].nombre + '"><i class="ti-eye" aria-hidden="true"></i> Ver</a>' +
                            '<button type="button" class="btn btn-warning btn-sm editar_archivo_docente" data-id-tipo="' + archivos[i].tipo + '" data-nombre-ar="' + archivos[i].nombre + '" data-id-archivoDocente="' + archivos[i].id_archivosDocente + '" data-id-docente="' + archivos[i].docentes_id_docente + '"><i class="ti-pencil" aria-hidden="true"></i> Editar cargue</button>';
                        if (validoDoc !== 1) {
                            botones += '<button type="button" class="btn btn-danger btn-sm eliminar_archivo_docente" title="Eliminará también la observación" data-id-tipo="' + archivos[i].tipo + '" data-nombre-ar="' + archivos[i].nombre + '" data-id-archivoDocente="' + archivos[i].id_archivosDocente + '" data-id-docente="' + archivos[i].docentes_id_docente + '"><i class="ti-trash" aria-hidden="true"></i> Eliminar</button>';
                        }
                        botones += "</div></td>";
                        $(botones).appendTo(".tabla_form > tbody");
                    })();
					$("</tr>").appendTo(".tabla_form > tbody");
				}
			}
			// Mostrar estado de documentos si está disponible
			if (documentos_status) {
				// Guardar estado para validaciones posteriores (ej. Hoja de vida única)
				$("#docente_arch_id").data("estado_documentos", documentos_status);
				mostrarEstadoDocumentos(documentos_status);
			}
		},
		error: function (ev) {
			//Do nothing
		},
	});
}
// Nueva función para mostrar el estado de documentos
function mostrarEstadoDocumentos(status) {
	// Remover alertas anteriores
	$('.estado-documentos-alert').remove();
	let alertHtml = '';
	if (status.completo) {
		alertHtml = '<div class="alert alert-success estado-documentos-alert mt-3">' +
					'<i class="fa fa-check"></i> <strong>Documentación completa</strong>' +
					'</div>';
		// Habilitar solo el botón cuyo value es "Si"
		$(".actualizar_docente[value='Si']").prop("disabled", false).attr("title", "");
	} else {
		alertHtml = '<div class="alert alert-warning estado-documentos-alert mt-3">' +
					'<i class="fa fa-exclamation-triangle"></i> <strong>Documentos faltantes:</strong>' +
					'<ul class="mb-0 mt-2">';
		status.documentos_faltantes.forEach(function(faltante) {
			alertHtml += '<li>' + faltante.nombre + ': tiene ' + faltante.tiene + ', requiere ' + faltante.requiere + '</li>';
		});
		alertHtml += '</ul></div>';
		// Deshabilitar solo el botón cuyo value es "Si"
		$(".actualizar_docente[value='Si']")
			.prop("disabled", true)
			.attr("title", "Deshabilitado: documentación incompleta");
	}
	// Insertar después de la tabla de archivos
	$("#instrucciones_docente").after(alertHtml);
}
// Validar Formularios Modulo Docentes
function ValidarFormDocentes(form) {
	switch (form) {
		case "docentes":
			$("form[id='formulario_crear_docente']").validate({
				errorElement: "div",
				errorClass: "invalid-feedback",
				errorPlacement: function (error, element) {
					if (element.closest(".input-group").length) {
						error.insertAfter(element.closest(".input-group"));
					} else {
						error.insertAfter(element);
					}
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function (element, errorClass, validClass) {
					$(element).removeClass("is-invalid").addClass("is-valid");
				},
				rules: {
					docentes_cedula: {
						required: true,
						minlength: 3,
					},
					docentes_primer_nombre: {
						required: true,
						minlength: 3,
					},
					docentes_primer_apellido: {
						required: true,
						minlength: 3,
					},
					docentes_profesion: {
						required: true,
						minlength: 3,
					},
					docentes_horas: {
						required: true,
					},
				},
				messages: {
					docentes_cedula: {
						required: "Por favor, escriba la cedula del facilitador.",
						minlength: "La Cedula debe tener mínimo 3 caracteres.",
					},
					docentes_primer_nombre: {
						required: "Por favor, escriba el primer nombre del facilitador.",
						minlength: "El primer nombre debe tener mínimo 3 caracteres.",
					},
					docentes_primer_apellido: {
						required: "Por favor, escriba el primer apellido del facilitador.",
						minlength: "El primer apellido debe tener mínimo 3 caracteres.",
					},
					docentes_profesion: {
						required:
							"Por favor, escriba la profesión del facilitador sin abreviación alguna.",
						minlength: "La profesion debe tener mínimo 3 caracteres.",
					},
					docentes_horas: {
						required:
							"Por favor, escriba las horas que tiene de capacitación el facilitador.",
						min: "Por favor, debe tener mínimo 60 horas de capacitación.",
					},
				},
			});
			break;
		default:
	}
}
// Abrir modal y cargar historial de observaciones del facilitador (lado usuarios)
$(document).on("click", "#verHistObsDocente", function (e) {
    e.preventDefault();
    const idDocente =
        $("#nombre_doc").attr("data-id") ||
        $("#docente_arch_id").attr("data-docente-id");
    if (!idDocente) {
        toastSimple("error", "No se encontró el identificador del facilitador.");
        return;
    }
    // Mostrar el modal
    $("#modalHistObservacionesDocente").modal("show");
    // Limpiar tabla previa
    const $table = $("#tabla_obs_docente");
    const $tbody = $table.find("tbody");
    $tbody.empty();
    // Cargar historial por AJAX
    $.ajax({
        url: baseURL + "docentes/observacionesDocenteAjax",
        type: "post",
        dataType: "JSON",
        data: { id_docente: idDocente },
        beforeSend: function () {
            toastSimple("info", "Cargando historial de observaciones...");
        },
        success: function (rows) {
            if (Array.isArray(rows) && rows.length > 0) {
                rows.forEach(function (r) {
                    const fecha = r.created_at || "";
                    const obs = r.observacion || "";
                    const tr = $("<tr></tr>");
                    tr.append("<td>" + fecha + "</td>");
                    tr.append("<td>" + obs + "</td>");
                    $tbody.append(tr);
                });
            } else {
                const tr = $("<tr></tr>");
                tr.append('<td colspan="2" class="text-center text-muted">Sin observaciones registradas</td>');
                $tbody.append(tr);
            }
        },
        error: function () {
            toastSimple("error", "No se pudo cargar el historial.");
        },
    });
});
