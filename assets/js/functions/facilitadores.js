import {toastSimple, errorControlador, mostrarAlerta} from "./partials/alerts-config.js";
import { reload } from "./partials/other-funtions-init.js";

let url = unescape(window.location.href);
let activate = url.split("/");
let baseURL = activate[0] + "//" + activate[2] + "/" + activate[3] + "/";
$(document).ready(() => {
	validarFormConsultaFacilitadores();
	// Asignar evento al botón de consulta
	$("#consultarFacilitadores").click(() => {
		consultarFacilitadores();
	});
	// Permitir cerrar el contenedor de resultados
	$("#resConEst").on("click", ".btn-cerrar", function() {
		$("#resConEst").slideUp();
	});
	// Limpiar datos de la solicitud
	function limpiarConsultaFacilitadores () {
		$("#resConEst").hide();
		$("#facilitadoresNIT").val();
		//$("#estadoOrg").removeClass("error").removeClass("completado").removeClass('pendiente');
	}
	$("#limpiarConsultaFacilitadores").click(() => {
		limpiarConsultaFacilitadores();
	})
})

/**
 * Función para mostrar facilitadores usando Bootstrap 5.0
 * @param {Array} facilitadores - Array de objetos con datos de facilitadores
 */
function mostrarFacilitadores(facilitadores) {
	// Limpiar el contenedor de resultados
	$("#resConEst").empty();
	// Mostrar el contenedor con animación
	$("#resConEst").slideDown();
	// Crear el encabezado con Bootstrap 5
	const header = `
        <div class="card shadow-sm p-3 mb-4">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Lista de facilitadores válidos</h4>
                    <span class="badge bg-primary rounded-pill">${facilitadores.length} facilitadores encontrados</span>
                </div>
            </div>
        </div>
    `;
	$("#resConEst").append(header);
	// Crear contenedor de tarjetas para facilitadores
	$("#resConEst").append('<div class="row row-cols-1 row-cols-md-3 g-4" id="facilitadoresContainer"></div>');
	// Si no hay facilitadores, mostrar mensaje
	if (facilitadores.length === 0) {
		$("#facilitadoresContainer").append(`
            <div class="col-12">
                <div class="card p-4 text-center">
                    <div class="mb-3">
                        <i style="font-size: 48px; color: #dc3545;">
                        	<span class="govco-search"></span>
						</i>
                    </div>
                    <p class="card-text">Ningún facilitador encontrado ó válido hasta el momento para la organización consultada.</p>
                </div>
            </div>
        `);
		return;
	}
	// Recorrer y mostrar cada facilitador en una tarjeta
	facilitadores.forEach(facilitador => {
		// Crear nombre completo formateado (evitando "null" cuando no hay segundo nombre/apellido)
		const nombreCompleto = [
			facilitador.primerNombreDocente || "",
			facilitador.segundoNombreDocente || "",
			facilitador.primerApellidoDocente || "",
			facilitador.segundoApellidoDocente || ""
		].filter(Boolean).join(" ");

		// Crear tarjeta para el facilitador usando Bootstrap 5
		const facilitadorCard = `
            <div class="col">
                <div class="card h-100 shadow-sm" id="doc${facilitador.id_docente}">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-primary mb-0">${nombreCompleto}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Identificación</h6>
                            <p class="card-text">${facilitador.numCedulaCiudadaniaDocente}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Horas de capacitación</h6>
                            <p class="card-text">
                                <span class="badge bg-success rounded-pill">${facilitador.horaCapacitacion} horas</span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Profesión</h6>
                            <p class="card-text">${facilitador.profesion || "No especificada"}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

		$("#facilitadoresContainer").append(facilitadorCard);
	});
	// Añadir paginación si hay muchos facilitadores (opcional)
	if (facilitadores.length > 9) {
		const paginacion = `
            <div class="col-12 mt-4">
                <nav aria-label="Paginación de facilitadores">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        `;
		$("#resConEst").append(paginacion);
	}
}

/**
 * Función para manejar la consulta de facilitadores
 */
function consultarFacilitadores() {
	// Obtener el NIT ingresado
	const nit = $("#facilitadoresNIT").val().trim();
	// Validar que se haya ingresado un NIT
	if (!nit) {
		// Toast con Bootstrap 5
		const toastEl = `
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Por favor ingrese el NIT de la organización
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `;
		$('body').append(toastEl);
		const toastElement = document.querySelector('.toast');
		const toast = new bootstrap.Toast(toastElement);
		toast.show();
		setTimeout(() => {
			toastElement.remove();
		}, 3000);
		return;
	}
	// Mostrar indicador de carga
	$("#resConEst").empty().html(`
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3">Consultando facilitadores...</p>
        </div>
    `).slideDown();
	// Realizar la petición AJAX
	grecaptcha.ready(function () {
		grecaptcha
			.execute("6LeTFnYnAAAAAKl5U_RbOYnUbGFGlhG4Ffn52Sef", {
				//action: 'submit'
			})
			.then(function (token) {
				// Add input google token
				$("#formulario_consultar_facilitadores").prepend(
					'<input type="hidden" id="token" value="' + token + '">'
				);
				let data = {
					nit: $("#facilitadoresNIT").val(),
					token: $("#token").val(),
				};
				if ($("#formulario_consultar_facilitadores").valid()) {
					$.ajax({
						url: baseURL + "home/consultarFacilitadores",
						type: "post",
						dataType: "JSON",
						data: data,
						success: function (response) {
							// Limpiar el campo de NIT para próximas consultas
							//$("#facilitadoresNIT").val("");
							// Mostrar los facilitadores
							mostrarFacilitadores(response.facilitadores || []);
							// Opcional: Desplazarse al contenedor de resultados
							/*$('html, body').animate({
								scrollTop: $("#resConEst").offset().top - 100
							}, 500);*/
						},
						error: function (ev) {
							// Mostrar mensaje de error
							$("#resConEst").empty().html(`
								<div class="card p-4">
									<div class="text-center">
										<div class="mb-3">
											<i class="fas fa-exclamation-circle" style="font-size: 48px; color: #dc3545;"></i>
										</div>
										<h5>Error en la consulta</h5>
										<p>No fue posible obtener la información de facilitadores. Por favor intente nuevamente.</p>
										<button class="btn btn-secondary mt-3" onclick="$('#resConEst').slideUp();">Cerrar</button>
									</div>
								</div>
							`);
							// Llamar a la función de manejo de errores existente
							errorControlador(ev);
						}
					});
				}
			})
	});
}
function validarFormConsultaFacilitadores () {
	// Formulario Login.
	$("form[id='formulario_consultar_facilitadores']").validate({
		// Elemento que contendrá el mensaje de error (Bootstrap recomienda <div> con invalid-feedback)
		errorElement: "div",
		// Clase que usará el mensaje de error (ya posee estilos de Bootstrap)
		errorClass: "invalid-feedback",
		// Configuramos cómo se ubica el mensaje de error para mantener el layout consistente en input-groups
		errorPlacement: function (error, element) {
			// Si el input forma parte de un input-group, insertamos el error después del contenedor
			if (element.closest(".input-group").length) {
				error.insertAfter(element.closest(".input-group"));
			} else {
				error.insertAfter(element);
			}
		},
		// Cuando hay error, agrega la clase 'is-invalid' y remueve 'is-valid'
		highlight: function (element, errorClass, validClass) {
			$(element).addClass("error").removeClass("success");
		},
		// Cuando el campo es válido, hace lo contrario: agrega 'is-valid' y remueve 'is-invalid'
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("error").addClass("success");
		},
		rules: {
			facilitadoresNIT: 	{
				required: true,
				minlength: 8,
			},
		},
		messages: {
			facilitadoresNIT: {
				required: "Por favor, digite su numero de NIT.",
				minlength: "El numero de NIT debe tener 8 dígitos o mas.",
			},
		},
	});
}
