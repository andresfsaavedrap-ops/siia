import { procesando, alertaGuardado, errorControlador } from './partials/alerts-config.js';
$(document).ready( () => {
	const url = unescape(window.location.href);
	const activate = url.split("/");
	const funcion = activate[4];
	const baseURL = activate[0] + "//" + activate[2] + "/" + activate[3] + "/";
	// Función de redirección (mover fuera del ready si se usa en otros lugares)
	const redirect = (url) => {
		window.location.href = url;
	};
	// Acciones de la barra de navegación
	$("#btn-login").click(function () {
		redirect(baseURL + "login");
	});
	$("#btn-register").click(function () {
		redirect(baseURL + "registro");
	});
	// Función de activación de cuenta.
	if (funcion === "activate") {
		let token = url.split("?");
		token = token[1];
		token = token.split(":");
		let data = {
			tk: token[1], // Token
			user: token[2], // User
		};
		// Mostrar loader
		$("#loading").show();
		$.ajax({
			url: "verification",
			type: "post",
			dataType: "JSON",
			data: data,
			beforeSend:  () => {
				// Mostrar SweetAlert2 de "procesando"
				procesando('info', 'Espere mientras verificamos su cuenta...' );
			},
			success: (response) => {
				console.log(response.status);
				// Ocultar loader
				if (response.status === 'success') {
					$("#loading").hide();
					// Mostrar SweetAlert2 con mensaje de éxito
					alertaGuardado(
						response.title,
						response.msg + '<br><br>Será redireccionado en 5 segundos, por favor espere...',
						response.status)
					// Redireccionar después de 5 segundos
					setTimeout(function() {
						redirect(response.url);
					}, 5000);
				}
				else {
					alertaGuardado(
						response.title,
						response.msg,
						response.status
					)
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Ocultar loader
				$("#loading").hide();
				errorControlador(jqXHR);
			},
		});
	} else {
		/** No hay nada que hacer aquí. **/
	}
});
// Cargar el preloader
$(window).on("load", function () {
	$(".se-pre-con").fadeOut("slow");
	initTopBar();
});
// Init top bar
function initTopBar() {
	const translateElement = document.querySelector(
		".idioma-icon-barra-superior-govco"
	);
	translateElement.addEventListener("click", translate, false);

	function translate() {
		// ... // Implementar traducción
	}
}
// Función para detectar la tecla tab
document.addEventListener("keyup", detectTabKey);
function detectTabKey(e) {
	if (e.keyCode == 9) {
		if (
			document
				.getElementById("botoncontraste")
				.classList.contains("active-barra-accesibilidad-govco")
		) {
			document
				.getElementById("botoncontraste")
				.classList.toggle("active-barra-accesibilidad-govco");
		}
		if (
			document
				.getElementById("botonaumentar")
				.classList.contains("active-barra-accesibilidad-govco")
		) {
			document
				.getElementById("botonaumentar")
				.classList.toggle("active-barra-accesibilidad-govco");
		}
		if (
			document
				.getElementById("botondisminuir")
				.classList.contains("active-barra-accesibilidad-govco")
		) {
			document
				.getElementById("botondisminuir")
				.classList.toggle("active-barra-accesibilidad-govco");
		}
	}
}
// Función para cambiar el contraste
function cambiarContexto() {
	var botoncontraste = document.getElementById("botoncontraste");
	var botonaumentar = document.getElementById("botonaumentar");
	var botondisminuir = document.getElementById("botondisminuir");
	if (!botoncontraste.classList.contains("active-barra-accesibilidad-govco")) {
		botoncontraste.classList.toggle("active-barra-accesibilidad-govco");
		document.getElementById("titleaumentar").style.display = "";
		document.getElementById("titledisminuir").style.display = "";
		document.getElementById("titlecontraste").style.display = "none";
	}
	if (botondisminuir.classList.contains("active-barra-accesibilidad-govco")) {
		botondisminuir.classList.remove("active-barra-accesibilidad-govco");
	}
	if (botonaumentar.classList.contains("active-barra-accesibilidad-govco")) {
		botonaumentar.classList.remove("active-barra-accesibilidad-govco");
	}
	var element = document.getElementById("para-mirar");
	if (element.className == "modo_oscuro-govco") {
		var element = document.getElementById("para-mirar");
		element.className = "modo_claro-govco";
	} else {
		var element = document.getElementById("para-mirar");
		element.className = "modo_oscuro-govco";
	}
}
// Función para disminuir el tamaño de la fuente
function disminuirTamanio(operador) {
	var botoncontraste = document.getElementById("botoncontraste");
	var botonaumentar = document.getElementById("botonaumentar");
	var botondisminuir = document.getElementById("botondisminuir");
	if (!botondisminuir.classList.contains("active-barra-accesibilidad-govco")) {
		botondisminuir.classList.toggle("active-barra-accesibilidad-govco");
		document.getElementById("titleaumentar").style.display = "";
		document.getElementById("titledisminuir").style.display = "none";
		document.getElementById("titlecontraste").style.display = "";
	}
	if (botonaumentar.classList.contains("active-barra-accesibilidad-govco")) {
		botonaumentar.classList.remove("active-barra-accesibilidad-govco");
	}
	if (botoncontraste.classList.contains("active-barra-accesibilidad-govco")) {
		botoncontraste.classList.remove("active-barra-accesibilidad-govco");
	}
	var div1 = document.getElementById("para-mirar");
	var texto = div1.getElementsByTagName("p");
	for (let element of texto) {
		const total = tamanioElemento(element);
		const nuevoTamanio =
			(operador === "aumentar" ? total + 1 : total - 1) + "px";
		element.style.fontSize = nuevoTamanio;
	}
}
// Función para aumentar el tamaño de la fuente
function aumentarTamanio(operador) {
	var botoncontraste = document.getElementById("botoncontraste");
	var botonaumentar = document.getElementById("botonaumentar");
	var botondisminuir = document.getElementById("botondisminuir");
	if (!botonaumentar.classList.contains("active-barra-accesibilidad-govco")) {
		botonaumentar.classList.toggle("active-barra-accesibilidad-govco");
		document.getElementById("titleaumentar").style.display = "none";
		document.getElementById("titledisminuir").style.display = "";
		document.getElementById("titlecontraste").style.display = "";
	}
	if (botondisminuir.classList.contains("active-barra-accesibilidad-govco")) {
		botondisminuir.classList.remove("active-barra-accesibilidad-govco");
	}
	if (botoncontraste.classList.contains("active-barra-accesibilidad-govco")) {
		botoncontraste.classList.remove("active-barra-accesibilidad-govco");
	}
	var div1 = document.getElementById("para-mirar");
	var texto = div1.getElementsByTagName("p");
	for (let element of texto) {
		const total = tamanioElemento(element);
		if (total <= 64) {
			const nuevoTamanio =
				(operador === "aumentar" ? total + 1 : total - 1) + "px";
			element.style.fontSize = nuevoTamanio;
		}
	}
}
// Función para obtener el tamaño de la fuente
function tamanioElemento(element) {
	const tamanioParrafo = window
		.getComputedStyle(element, null)
		.getPropertyValue("font-size");
	return parseFloat(tamanioParrafo);
}
