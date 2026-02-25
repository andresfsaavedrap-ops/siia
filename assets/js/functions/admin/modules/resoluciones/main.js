import { procesando, mostrarAlerta, toastSimple, errorControlador, alertaGuardado, showNotification, confirmarAccion } from '../../../partials/alerts-config.js';
import { initSelects, redirect, reload } from '../../../partials/other-funtions-init.js';
import { getBaseURL } from '../../../config.js';
const baseURL = getBaseURL();
$(document).ready(function() {
	initSelects();
	// Navegar a gestión por organización
	$(document).on("click", ".ver_resolucion_org", function () {
		const idOrganizacion = $(this).attr("data-organizacion");
		window.open(baseURL + "resoluciones/organizacion/" + idOrganizacion, '_self');
	});
	// Eliminar resolución
	$(document).on("click", ".eliminarResolucion", function () {
		const idResolucion = $(this).attr("data-id-res");
		const idOrganizacion = $(this).attr("data-id-org");
		const data = { id_resolucion: idResolucion, id_organizacion: idOrganizacion };
		confirmarAccion("Eliminar resolución", "¿Quieres eliminar esta resolución?", "warning", 'popup-swalert').then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: baseURL + "resoluciones/eliminarResolucion",
					type: "post",
					dataType: "JSON",
					data,
					beforeSend: function () { procesando('info', 'Espere...'); },
					success: function (response) {
						if(response.status === 'success') {
							mostrarAlerta(response.status, response.title, response.msg).then(() => reload());
						} else {
							procesando(response.status, response.msg);
						}
					},
					error: errorControlador,
				});
			}
		});
	});
	// Modo crear
	$(".resoluciones-modal[data-funct='crear']").on("click", function () {
		$("#modal-title-resolucion").text("Crear Resolución");
		$("#btn_crear_resolucion_sp").show();
		$("#btn_actualizar_resolucion_sp").hide();
		resetModal();
	});
	// Modo editar
	$(document).on("click", ".editarResolucion", function () {
		$("#modal-title-resolucion").text("Actualizar Resolución");
		$("#btn_crear_resolucion_sp").hide();
		$("#btn_actualizar_resolucion_sp").show();
		resetModal();
		const idRes = $(this).attr("data-id-res");
		const idOrg = $(this).attr("data-id-org");
		$("#btn_actualizar_resolucion_sp").attr("data-id-res", idRes);
		$("#btn_actualizar_resolucion_sp").attr("data-id-org", idOrg);
		$.ajax({
			url: baseURL + "resoluciones/editarResolucion",
			type: "post",
			dataType: "JSON",
			data: { id_resolucion: idRes, id_organizacion: idOrg },
			success: function (response) {
				const r = response.resolucion || {};
				// 1) Bloquear Organización
				$("#id-organizacion").val(idOrg).prop("disabled", true);
				// 2) Determinar tipo y bloquear radio + secciones
				const esVigente = !!r.idSolicitud;
				$("input[name=tipoResolucionSuper]").prop("disabled", true);
				if (esVigente) {
					$("input[name=tipoResolucionSuper][value='nueva']").prop("checked", true);
					$("#resolucionViejaSuper").hide();
					$("#resolucionVigenteSuper").show();
					// Cargar solicitudes y seleccionar la vinculada, luego bloquear
					$.ajax({
						url: baseURL + "resoluciones/getSolicitudesAcreditadasOrganizacion",
						type: "post",
						dataType: "JSON",
						data: { id_organizacion: idOrg },
						success: function (solicitudes) {
							const select = $("#idSolicitudSuper");
							select.empty().append('<option value="">Seleccione una solicitud...</option>');
							if (Array.isArray(solicitudes)) {
								solicitudes.forEach(s => {
									select.append(`<option value="${s.idSolicitud}">${s.idSolicitud} | ${s.tipoSolicitudAcreditado || s.tipoSolicitud || 'Solicitud'}</option>`);
								});
							}
							select.val(r.idSolicitud || '').prop("disabled", true);
						},
						error: errorControlador,
					});
				} else {
					$("input[name=tipoResolucionSuper][value='vieja']").prop("checked", true);
					$("#resolucionViejaSuper").show();
					$("#resolucionVigenteSuper").hide();
					// Mostrar cursos/modalidades aprobadas y bloquear checkboxes
					const cursos = (r.cursoAprobado || '').split(',').map(s => s.trim()).filter(Boolean);
					const modalidades = (r.modalidadAprobada || '').split(',').map(s => s.trim().toLowerCase()).filter(Boolean);
					// Marcar y deshabilitar los checks
					$("input[name='motivosSuper']").each(function() {
						const map = {
							'1': 'Acreditación Curso Básico de Economía Solidaria',
							'2': 'Aval de Trabajo Asociado',
							'3': 'Acreditación Curso Medio de Economía Solidaria',
							'4': 'Acreditación Curso Avanzado de Economía Solidaria',
							'5': 'Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria',
						};
						const label = map[$(this).val()];
						if (label && cursos.includes(label)) $(this).prop('checked', true);
						$(this).prop('disabled', true);
					});
					$("input[name='modalidadesSuper']").each(function() {
						const map = { '1': 'presencial', '2': 'virtual', '3': 'en línea' };
						const label = map[$(this).val()];
						if (label && modalidades.includes(label)) $(this).prop('checked', true);
						$(this).prop('disabled', true);
					});
				}

				// 3) Rellenar datos de la resolución (editables)
				$("#numero-resolucion-super").val(r.numeroResolucion);
				$("#anos-resolucion-super").val(r.anosResolucion).prop("disabled", false);
				$("#fecha-inicio-super").val(r.fechaResolucionInicial);
				$("#fecha-fin-super").val(r.fechaResolucionFinal).prop("disabled", true); // se recalcula con años

				// 4) Mostrar PDF actual y preparar reemplazo
				const archivo = r.resolucion;
				if (archivo) {
					$("#archivoActualSuperWrapper").show();
					$("#linkPdfActualSuper")
						.attr("href", baseURL + "uploads/resoluciones/" + archivo)
						.text("Ver PDF actual");
					$("#btn_reemplazar_archivo_sp")
						.attr("data-id-res", idRes)
						.attr("data-id-org", idOrg)
						.show();
				} else {
					$("#archivoActualSuperWrapper").hide();
					$("#btn_reemplazar_archivo_sp").hide();
				}

				// Abrir modal
				$("#modal-resolucion").modal("show");
			},
			error: errorControlador,
		});
	});
	// Actualiza el label del input file con el nombre seleccionado (Super)
	$(document).on('change', '#resolucion_super', function (e) {
		var fileName = e.target.files && e.target.files.length ? e.target.files[0].name : 'Selecciona PDF...';
		// Si usas el input con .form-control, no tiene label adyacente; mostramos el nombre como placeholder
		$(this).attr('data-filename', fileName);
	});
	// Reemplazar PDF en modo editar (Super)
	$(document).on("click", "#btn_reemplazar_archivo_sp", function () {
		const idRes = $(this).attr("data-id-res");
		const idOrg = $(this).attr("data-id-org");
		const file = $("#resolucion_super").prop("files")[0];
		if (!file) {
			toastSimple('warning', 'Selecciona un archivo PDF para reemplazar');
			return;
		}
		if (file.type !== 'application/pdf') {
			toastSimple('warning', 'El archivo debe ser un PDF');
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
						mostrarAlerta(response.status, response.title || 'Reemplazo de archivo', response.msg).then(() => reload());
					} else {
						procesando(response.status, response.msg || 'No se pudo reemplazar el archivo');
					}
				},
				error: errorControlador,
			});
		});
	});
	// Cargar solicitudes acreditadas al seleccionar organización (para tipo vigente)
	$("#id-organizacion").on("change", function () {
		const idOrganizacion = $(this).val();
		if (!idOrganizacion) return;
		$.ajax({
			url: baseURL + "resoluciones/getSolicitudesAcreditadasOrganizacion",
			type: "post",
			dataType: "JSON",
			data: { id_organizacion: idOrganizacion },
			success: function (solicitudes) {
				const select = $("#idSolicitudSuper");
				select.empty().append('<option value="">Seleccione una solicitud...</option>');
				if (Array.isArray(solicitudes)) {
					solicitudes.forEach(s => {
						select.append(`<option value="${s.idSolicitud}">${s.idSolicitud} | ${s.tipoSolicitudAcreditado || s.tipoSolicitud || 'Solicitud'}</option>`);
					});
				}
			},
			error: errorControlador,
		});
	});
	// Toggle tipo resolución
	$("input[name=tipoResolucionSuper]").change(function () {
		if($(this).val() === 'vieja') {
			$('#resolucionViejaSuper').show('swing');
			$('#resolucionVigenteSuper').hide('linear');
		} else {
			$('#resolucionVigenteSuper').show('swing');
			$('#resolucionViejaSuper').hide('linear');
		}
	});
	// Habilitar años tras seleccionar fecha inicio
	$("#fecha-inicio-super").change( function () {
		$("#anos-resolucion-super").attr('disabled', false);
	});
	// Calcular fecha fin por años
	$("#anos-resolucion-super").change( function () {
		const years = parseInt($("#anos-resolucion-super").val(), 10);
		const start = $("#fecha-inicio-super").val();
		if (!start || isNaN(years)) return;
		const fin = addYearsISO(start, years);
		$("#fecha-fin-super").val(fin);
	});
	// Crear resolución
	$("#btn_crear_resolucion_sp").on("click", function () {
		if (!validarCrear()) return;
		const file = $("#resolucion_super").prop("files")[0];
		const tipoResolucion = $("input:radio[name=tipoResolucionSuper]:checked").val();
		const idOrganizacion = $("#id-organizacion").val();
		const formData = new FormData();
		formData.append("file", file);
		formData.append("fechaResolucionInicial", $("#fecha-inicio-super").val());
		formData.append("fechaResolucionFinal", $("#fecha-fin-super").val());
		formData.append("anosResolucion", $("#anos-resolucion-super").val());
		formData.append("numeroResolucion", $("#numero-resolucion-super").val());
		formData.append("tipoResolucion", tipoResolucion);
		formData.append("id_organizacion", idOrganizacion);
		if (tipoResolucion === 'vieja') {
			const cursos_aprobados = collectCheckedText($("input[name='motivosSuper']"), {
				1: 'Acreditación Curso Básico de Economía Solidaria',
				2: 'Aval de Trabajo Asociado',
				3: 'Acreditación Curso Medio de Economía Solidaria',
				4: 'Acreditación Curso Avanzado de Economía Solidaria',
				5: 'Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria',
			});
			const modalidades = collectCheckedText($("input[name='modalidadesSuper']"), {
				1: 'Presencial',
				2: 'Virtual',
				3: 'En Linea',
			});
			formData.append("cursoAprobado", cursos_aprobados);
			formData.append("modalidadAprobada", modalidades);
		} else {
			formData.append("idSolicitud", $("#idSolicitudSuper").val() || '');
		}

		$.ajax({
			url: baseURL + "resoluciones/cargarResolucionOrganizacion",
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			type: "post",
			dataType: "html",
			beforeSend: function () { procesando("info", "Espere..."); },
			success: function (response) {
				response = JSON.parse(response);
				if(response.status === 'success') {
					confirmarAccion(response.title || 'Resolución creada', response.status,  response.msg).then(() => reload());
				} else {
					procesando(response.status, response.msg);
				}
			},
			error: errorControlador,
		});
	});
	// Actualizar resolución
	$("#btn_actualizar_resolucion_sp").on("click", function () {
		const idRes = $(this).attr("data-id-res");
		const idOrg = $(this).attr("data-id-org");

		const data = {
			id_res: idRes,
			id_organizacion: idOrg,
			res_fech_inicio: $("#fecha-inicio-super").val(),
			res_fech_fin: $("#fecha-fin-super").val(),
			res_anos: $("#anos-resolucion-super").val(),
			num_res_org: $("#numero-resolucion-super").val(),
			cursoAprobado: null,
			modalidadAprobada: null,
		};

		$.ajax({
			url: baseURL + "resoluciones/actualizarResolucion",
			type: "post",
			dataType: "JSON",
			data,
			success: function (response) {
				showNotification(response.msg || 'Resolución actualizada', "success");
				reload();
			},
			error: errorControlador,
		});
	});
	// Cargar datos resolución
	$(".resoluciones-modal").click(function () {
		let funct = $(this).attr('data-funct');
		if (funct === 'crear') {
			$('#super_nuevo_admin').show();
			$('#actions-admins').hide();
			$("#super_id_admin_modal").html("");
			$("#super_status_adm").html("");
			$("#super_status_adm").css("background-color", "#ffffff");
			$("#super_primernombre_admin").val('');
			$("#super_segundonombre_admin").val('');
			$("#super_primerapellido_admin").val('');
			$("#super_segundoapellido_admin").val('');
			$("#super_numerocedula_admin").val('');
			$("#super_ext_admin").val('');
			$("#super_nombre_admin").val('');
			$("#super_correo_electronico_admin").val('');
			$("#super_contrasena_admin").val('');
			$("#super_acceso_nvl option[value='seleccione']").prop('selected', true);
			$("#super_id_admin_modal").prop("disabled", false);
			$("#super_eliminar_admin").prop("disabled", false);
			$("#super_actualizar_admin").prop("disabled", false);
			$("#super_primernombre_admin").prop("disabled", false);
			$("#super_segundonombre_admin").prop("disabled", false);
			$("#super_primerapellido_admin").prop("disabled", false);
			$("#super_segundoapellido_admin").prop("disabled", false);
			$("#super_numerocedula_admin").prop("disabled", false);
			$("#super_nombre_admin").prop("disabled", false);
			$("#super_contrasena_admin").prop("disabled", false);
			$("#super_correo_electronico_admin").prop("disabled", false);
			$("#super_acceso_nvl").prop("disabled", false);
		}
		else {
			$('#super_nuevo_admin').hide();
			$('#actions-admins').show();
			data = {
				id: $(this).attr("data-id"),
			};
			$.ajax({
				url: baseURL + "resoluciones/cargarDatosAdministrador",
				type: "post",
				dataType: "JSON",
				data: data,
				success: function (response) {
					console.log(response);
					$("#super_id_admin_modal").html("");
					$("#super_status_adm").html("");
					$("#super_status_adm").css("color", "white");
					$("#super_status_adm").css("padding", "5px");
					$("#super_id_admin_modal").html(response.administrador.id_administrador);
					$("#super_primernombre_admin").val(response.administrador.primerNombreAdministrador);
					$("#super_segundonombre_admin").val(response.administrador.segundoNombreAdministrador);
					$("#super_primerapellido_admin").val(response.administrador.primerApellidoAdministrador);
					$("#super_segundoapellido_admin").val(response.administrador.segundoApellidoAdministrador);
					$("#super_numerocedula_admin").val(response.administrador.numCedulaCiudadaniaAdministrador);
					$("#super_ext_admin").val(response.administrador.ext);
					$("#super_nombre_admin").val(response.administrador.usuario);
					$("#super_correo_electronico_admin").val(response.administrador.direccionCorreoElectronico);
					$("#super_acceso_nvl option[value='" + response.administrador.nivel + "']").prop("selected", true);
					$("#super_contrasena_admin").val(response.password);
					// Comprobar conexión de usuario
					if (response.administrador.logged_in == 1) {
						$("#super_status_adm").css("background-color", "#398439");
						$("#super_status_adm").html("Estado: En linea");
						$("#super_id_admin_modal").prop("disabled", true);
						$("#super_eliminar_admin").prop("disabled", true);
						$("#super_actualizar_admin").prop("disabled", true);
						$("#super_nombre_admin_modal").prop("disabled", true);
						$("#super_primernombre_admin").prop("disabled", true);
						$("#super_segundonombre_admin").prop("disabled", true);
						$("#super_primerapellido_admin").prop("disabled", true);
						$("#super_segundoapellido_admin").prop("disabled", true);
						$("#super_numerocedula_admin").prop("disabled", true);
						$("#super_contrasena_admin").prop("disabled", true);
						$("#super_correo_electronico_admin").prop("disabled", true);
						$("#super_acceso_nvl").prop("disabled", true);
					} else {
						$("#super_status_adm").css("background-color", "#c61f1b");
						$("#super_status_adm").html("Estado: No conectado");
						$("#super_id_admin_modal").prop("disabled", false);
						$("#super_eliminar_admin").prop("disabled", false);
						$("#super_actualizar_admin").prop("disabled", false);
						$("#super_primernombre_admin").prop("disabled", false);
						$("#super_segundonombre_admin").prop("disabled", false);
						$("#super_primerapellido_admin").prop("disabled", false);
						$("#super_segundoapellido_admin").prop("disabled", false);
						$("#super_numerocedula_admin").prop("disabled", false);
						$("#super_nombre_admin").prop("disabled", false);
						$("#super_contrasena_admin").prop("disabled", false);
						$("#super_correo_electronico_admin").prop("disabled", false);
						$("#super_acceso_nvl").prop("disabled", false);
					}
				},
				error: function (ev) {
					//Do nothing
				},
			});
		}

	});
	// Marcar resolución como vencida (valida fecha fin; no modifica fecha)
	$(document).on("click", ".vencerResolucion", function () {
		const idResolucion = $(this).attr("data-id-res");
		const idOrganizacion = $(this).attr("data-id-org");
		const fechaFin = $(this).attr("data-fecha-fin"); // YYYY-MM-DD

		// Normalizar fechas (comparación a nivel de día)
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
		// Construcción baseURL simple desde la URL actual
		let url = unescape(window.location.href);
		if (url.includes("?")) url = url.split("?")[0];
		const parts = url.split("/");
		const baseURL = parts[0] + "//" + parts[2] + "/" + parts[3] + "/";
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
						mostrarAlerta(response.status, response.title, response.msg).then(() => {
							location.reload();
						});
					} else {
						procesando(response.status, response.msg);
					}
				},
				error: errorControlador,
			});
		});
	});
});
// Helpers
function resetModal() {
	$("#form_resoluciones_super")[0].reset();
	// Rehabilitar organización y limpiar selección
	$("#id-organizacion").prop("disabled", false).val('');
	// Rehabilitar tipo de resolución y poner por defecto "Vigente"
	$("input[name=tipoResolucionSuper]").prop("disabled", false);
	$("input[name=tipoResolucionSuper][value='nueva']").prop("checked", true);
	// Secciones por tipo
	$("#resolucionViejaSuper").hide();
	$("#resolucionVigenteSuper").show();
	// Rehabilitar y resetear la solicitud
	$("#idSolicitudSuper")
		.prop("disabled", false)
		.empty()
		.append('<option value="">Seleccione una solicitud...</option>');
	// Limpiar campos de resolución y estados de bloqueo por defecto
	$("#numero-resolucion-super").val('');
	$("#anos-resolucion-super").val('').prop("disabled", true);
	$("#fecha-inicio-super").val('');
	$("#fecha-fin-super").val('').prop("disabled", true);
	// Limpiar input de archivo y ocultar vista del PDF actual
	$("#resolucion_super").val('').removeAttr('data-filename');
	$("#archivoActualSuperWrapper").hide();
	$("#linkPdfActualSuper").attr("href", "#").text("Ver PDF actual");
	$("#btn_reemplazar_archivo_sp").hide().removeAttr("data-id-res").removeAttr("data-id-org");
	// Limpiar referencias de actualización por seguridad
	$("#btn_actualizar_resolucion_sp").removeAttr("data-id-res").removeAttr("data-id-org");
}
// Validar formulario crear resolución
function validarCrear() {
	const idOrg = $("#id-organizacion").val();
	const numRes = $("#numero-resolucion-super").val();
	const anos = $("#anos-resolucion-super").val();
	const fin = $("#fecha-fin-super").val();
	const ini = $("#fecha-inicio-super").val();
	const file = $("#resolucion_super").prop("files")[0];
	const tipo = $("input:radio[name=tipoResolucionSuper]:checked").val();
	if (!idOrg || !numRes || !anos || !ini || !fin || !file) {
		toastSimple('warning', 'Completa todos los campos obligatorios');
		return false;
	}
	if (tipo === 'nueva' && !$("#idSolicitudSuper").val()) {
		toastSimple('warning', 'Selecciona la solicitud acreditada');
		return false;
	}
	return true;
}
// Añadir años a una fecha en formato ISO (YYYY-MM-DD)
function addYearsISO(dateStr, years) {
	const d = new Date(dateStr);
	d.setFullYear(d.getFullYear() + years);
	const month = String(d.getMonth() + 1).padStart(2, '0');
	const day = String(d.getDate()).padStart(2, '0');
	return `${d.getFullYear()}-${month}-${day}`;
}
// Recoger texto de inputs checkados basados en un mapeo
function collectCheckedText($inputs, map) {
	let result = [];
	$inputs.each(function () {
		if (this.checked) {
			const val = $(this).val();
			if (map[val]) result.push(map[val]);
		}
	});
	return result.join(', ');
}
