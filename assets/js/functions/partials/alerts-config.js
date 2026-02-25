// Configuración base para Toast
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
// Configuración base para modales
const Alert = Swal.mixin({
	confirmButtonText: "Aceptar",
	allowOutsideClick: false,
	allowEscapeKey: false,
	customClass: {
		confirmButton: "button-swalert",
		popup: "popup-swalert",
	},
});
// Función para mostrar alertas con el estilo de GOV.CO
export function toastSimple(status, msg) {
	return Toast.fire({
		icon: status,
		text: msg,
	});
}
// Función para mostrar alertas con el estilo de GOV.CO
export function mostrarAlerta(status, title, msg) {
	return Alert.fire({
		title: title,
		text: msg,
		html: msg,
		icon: status,
		customClass: {
			confirmButton: "button-swalert",
			popup: "popup-swalert-list",
		},
	});
}
// Función para estados de carga/proceso
export function procesando(status = 'info', msg = 'Procesando...') {
	return Swal.fire({
		icon: status,
		title: 'Espere por favor',
		html: msg,
		allowOutsideClick: false,
		allowEscapeKey: false,
		showConfirmButton: false,
		didOpen: () => {
			Swal.showLoading();
		}
	});
}
// Función para alertas de éxito/éxito diferido
export function alertaGuardado(title = 'Operación exitosa', msg, status = 'success') {
	return Alert.fire({
		title: title,
		html: msg,
		icon: status,
		showConfirmButton: false,
		timer: 5000,
		timerProgressBar: true
	});
}
// Función para alertas de éxito/éxito diferido
export function confirmarAccion(title, msg, status = 'success', popup = 'none') {
	return Alert.fire({
		title: title,
		html: msg,
		icon: status,
		showCancelButton: true,
		confirmButtonText: 'Si',
		cancelButtonText: 'No',
		customClass: {
			popup: popup,
			confirmButton: "button-swalert",
		},
	});
}
// Función para manejo de errores HTTP
export function errorControlador(jqXHR) {
	const statusCode = jqXHR.status || 500;
	let errorTitle = 'Error inesperado';
	let errorContent = 'Ocurrió un error en la solicitud';

	// Manejar diferentes tipos de respuestas
	if (jqXHR.responseJSON) {
		errorContent = jqXHR.responseJSON.error || jqXHR.responseJSON.message;
	} else if (jqXHR.responseText) {
		errorContent = jqXHR.responseText.substring(0, 200); // Limitar longitud
	}

	// Personalizar según código de estado
	switch (statusCode) {
		case 400:
			errorTitle = 'Solicitud incorrecta';
			break;
		case 401:
			errorTitle = 'No autorizado';
			break;
		case 404:
			errorTitle = 'Recurso no encontrado';
			break;
		case 500:
			errorTitle = 'Error del servidor';
			break;
	}

	return Alert.fire({
		title: errorTitle,
		html: `<div class="error-content">${errorContent}</div>`,
		icon: "error",
		customClass: {
			popup: "popup-swalert-list",
			confirmButton: "button-swalert",
		},
	});
}
// Error de validación
export function errorValidacionFormulario() {
	$("html, body").animate(
		{
			scrollTop: 300,
		},
		3000
	);
	Toast.fire({
		icon: "warning",
		text: "Registra correctamente los campos obligatorios",
	});
}
// Función para mostrar notificaciones
export function showNotification(message, type) {
	var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
	var bgColor = type === 'success' ? '#28a745' : '#dc3545';
	$('body').append(
		'<div class="notification" style="position: fixed; top: 20px; right: 20px; z-index: 9999; ' +
		'background-color: ' + bgColor + '; color: white; padding: 15px 25px; border-radius: 5px; ' +
		'box-shadow: 0 4px 8px rgba(0,0,0,0.2); display: flex; align-items: center;">' +
		'<i class="fa ' + icon + ' mr-2" style="font-size: 20px;"></i>' +
		'<span>' + message + '</span>' +
		'</div>'
	);
	setTimeout(function() {
		$('.notification').fadeOut(500, function() {
			$(this).remove();
		});
	}, 3000);
}
