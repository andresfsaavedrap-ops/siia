ValidarFormRegistroLlamadas();
$(".contenedor--menu2").hide();
$(".icono2").click(function () {
	$(".contenedor--menu2").animate({
		width: "toggle",
	});
});
/**
 * Cargar datos de la organización
 */
$("#telefonicoNitOrganizacion").change(function () {
	let html = '';
	let data = {
		id_organizacion: $('#telefonicoNitOrganizacion').val(),
	}
	$.ajax({
		url: baseURL + 'organizaciones/datosOrganzacion',
		type: 'post',
		dataType: 'JSON',
		data: data,
		success: function (response) {
			// Llenar campos
			let funcionario = response.organizacion.primerNombrePersona + ' ' + response.organizacion.primerApellidoPersona;
			$("#telefonicoFuncionario").val(funcionario);
			// Llenar select de la solicitud
			if(response.solicitudes.length > 0) {
				$.each(response.solicitudes, function (key, solicitud) {
					// Guardar opción html en variable
					html += "<option value=" + solicitud.idSolicitud + " data-id=" + solicitud.id_solicitud + ">" + solicitud.idSolicitud + " | " + solicitud.nombre + "</option>";
				});
				// Añadir variable de opción html al select de municipio
				$("#telefonicoIdSolicitud").html(html);
				$("#telefonicoIdSolicitud").prop('disabled', false);
			}
			else {
				html += "<option value=''>N/A</option>";
				$("#telefonicoIdSolicitud").html(html);
				$("#telefonicoIdSolicitud").prop('disabled', true);
			}
		}
	})
});

/**
 * Guardar registro telefónico
 */
$("#guardarRegistroTelefonico").click(function () {
	if ($("#formulario_registro_telefonico").valid()) {
		// Capturar datos formulario
		data = {
			funcionario: $("#telefonicoFuncionario").val(),
			cargo: $("#telefonicoCargo").val(),
			telefono: $("#telefonicoTelefono").val(),
			tipoLlamada: $("#telefonicoTipoLlamada").val(),
			tipoComunicacion: $("#telefonicoTipoComunicacion").val(),
			idSolicitud: $("#telefonicoIdSolicitud").val(),
			fecha: $("#telefonicoFecha").val(),
			duracion: $("#telefonicoDuracion").val(),
			descripcion: $("#telefonicoDescripcion").val(),
			organizaciones_id_organizacion: $("#telefonicoNitOrganizacion").val(),
			administradores_id_administrador: $("#telefonicoIdAdministrador").val(),
		};
		$.ajax({
			url: baseURL + "RegistroTelefonico/create",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend: function () {
				guardando();
			},
			success: function (response) {
				if (response.status === 'success') {
					clearInputs("formulario-registro-telefonico");
					alertaGuardadoRegistro(response.title, response.msg, response.status)
				}
			},
			error: function (ev) {
				alertaErrorGuardado(ev.responseText, 'error');
			},
		});
	}
	else {
		errorValidacionFormulario();
	}
});
// Alertas TODO: Guardar en archivos main alert
function errorValidacionFormulario() {
	Toast.fire({
		icon: 'warning',
		text: 'Registra correctamente los campos obligatorios'
	});
}
// Alerta de formulario guardado
function alertaGuardadoRegistro(title, msg, status){
	msg = msg + '<br> ¿Deseá agregar un nuevo registro?';
	Alert.fire({
		title: title,
		text: msg,
		html: msg,
		icon: status,
		showCancelButton: true,
		confirmButtonText: 'Si',
		cancelButtonText: 'No',
	}).then((result) => {
		if (result.isConfirmed) {
			clearInputs("formulario-registro-telefonico");
		}
		else {
			clearInputs("formulario-registro-telefonico");
			$('#modal_form_registro_llamadas').modal('hide');
		}
	})
}
// Alerta error guardar formulario
function alertaErrorGuardado(msg, status){
	Alert.fire({
		title: 'Error al guardar!',
		text: msg,
		icon: status,
	})
}
// Toast Guardando
function guardando(){
	Toast.fire({
		icon: 'info',
		text: 'Guardando'
	});
}
function ValidarFormRegistroLlamadas () {
	$("form[id='formulario_registro_telefonico']").validate({
		rules: {
			telefonicoNitOrganizacion: {
				required: true,
			},
			telefonicoFuncionario: {
				required: true,
				minlength: 5,
			},
			telefonicoCargo: {
				required: true,
				minlength: 3,
			},
			telefonicoTelefono: {
				required: true,
				minlength: 10,
			},
			telefonicoTipoLlamada: {
				required: true,
			},
			telefonicoTipoComunicacion: {
				required: true,
			},
			telefonicoFecha: {
				required: true,
			},
			telefonicoDuracion: {
				required: true,
			},
			telefonicoDescripcion: {
				required: true,
				minlength: 10,
				maxlength: 800,
			},
		},
		messages: {
			telefonicoNitOrganizacion: {
				required: "NIT Requerido",
			},
			telefonicoFuncionario: {
				required: "Funcionario Requerido.",
				minlength: "Se requieren mas de 5 caracteres en este campo.",
			},
			telefonicoCargo: {
				required: "Cargo requerido.",
				minlength: "Mínimo 3 caracteres.",
			},
			telefonicoTelefono: {
				required: "Teléfono requerido",
				minlength: "Mínimo 10 caracteres",
			},
			telefonicoTipoLlamada: {
				required: "Tipo de llamada requerida",
			},
			telefonicoTipoComunicacion: {
				required: "Tipo de comunicación requerida",
			},
			telefonicoFecha: {
				required: "Fecha requerida",
			},
			telefonicoDuracion: {
				required: "Duración requerida",
			},
			telefonicoDescripcion: {
				required: "Descripción requerida",
				minlength: "Mínimo 10 caracteres",
				maxlength: "Máximo 800 caracteres",
			},
		},
	});
}
