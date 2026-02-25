import {
	toastSimple,
	errorControlador,
	mostrarAlerta,
} from "./partials/alerts-config.js";
import { reload } from "./partials/other-funtions-init.js";
import { getBaseURL } from "./config.js";
const baseURL = getBaseURL();
let entidades;
let resultado;
let departamentos = [];
let municipios = [];
let tipoOrg = [];
// var domainName = window.location.origin + "/beneficiados/public/";
$.ajax({
	url: baseURL + "Estadisticas",
	type: "GET",
	success: function (data) {
		entidades = JSON.parse(data);
	},
});
//filtro tipo de informacion
$("#tipoInformacion").change(function () {
	tipoOrg = [];
	departamentos = [];
	municipios = [];
	html = "";
	seleccion = $("#tipoInformacion").val();
	dept = $(".departamentoAcreditacion").val();
	mun = $(".municipioAcreditacion").val();

	$(".orgDpto").html("");
	$(".orgTipo").html("");

	if (seleccion == "acreditadas") {
		resultado = entidades["acreditadas"];
	} else if (seleccion == "cursoBasico") {
		resultado = entidades["cursoBasico"];
	} else if (seleccion == "avaladas") {
		resultado = entidades["avaladas"];
	} else if (seleccion == "modalidadVirtual") {
		resultado = entidades["modalidadVirtual"];
	}

	for (i = 0; i < resultado.length; i++) {
		departamentos.push(resultado[i].nomDepartamentoUbicacion);
		tipoOrg.push(resultado[i].tipoOrganizacion);
	}

	let repetidosDpto = {};

	departamentos.forEach(function (numero) {
		repetidosDpto[numero] = (repetidosDpto[numero] || 0) + 1;
	});

	let repetidosTipo = {};

	tipoOrg.forEach(function (numero) {
		repetidosTipo[numero] = (repetidosTipo[numero] || 0) + 1;
	});

	let arrayDepartamentos = departamentos.filter(onlyUnique);
	cargarDepartamentos(arrayDepartamentos);

	let arraytipoOrg = tipoOrg.filter(onlyUnique);
	cargarTipoOrg(arraytipoOrg);

	for (d = 0; d < arrayDepartamentos.length; d++) {
		dept = arrayDepartamentos[d];
		$(".orgDpto").append(
			arrayDepartamentos[d] +
				": " +
				repetidosDpto[dept] +
				" <i class='fa fa-eye verDept' data-name='" +
				arrayDepartamentos[d] +
				"'></i></br>"
		);
	}

	for (d = 0; d < arraytipoOrg.length; d++) {
		tipoOrg = arraytipoOrg[d];
		$(".orgTipo").append(
			arraytipoOrg[d] +
				": " +
				repetidosTipo[tipoOrg] +
				" <i class='fa fa-eye verTipo' data-name='" +
				arraytipoOrg[d] +
				"'></i></br>"
		);
	}

	$(".totalOrgAcreditacion").html(
		resultado.length + " <i class='fa fa-eye verOrg'></i>"
	);
});

//filtro por departamento
$(".selectDepartamentoAcreditacion").change(function () {
	html = "";
	tipoOrg = [];
	departamentos = [];
	municipios = [];
	seleccion = $(".departamentoAcreditacion").val();
	$(".orgDpto").html("");
	$(".orgTipo").html("");

	resultadoParcial = resultado.filter(function (el) {
		return el.nomDepartamentoUbicacion == seleccion;
	});

	for (i = 0; i < resultadoParcial.length; i++) {
		municipios.push(resultadoParcial[i].nomMunicipioNacional);
		tipoOrg.push(resultadoParcial[i].tipoOrganizacion);
	}

	let repetidosMun = {};

	municipios.forEach(function (numero) {
		repetidosMun[numero] = (repetidosMun[numero] || 0) + 1;
	});

	let repetidosTipo = {};

	tipoOrg.forEach(function (numero) {
		repetidosTipo[numero] = (repetidosTipo[numero] || 0) + 1;
	});

	let arrayMunicipio = municipios.filter(onlyUnique);
	cargarMunicipios(arrayMunicipio);

	let arraytipoOrg = tipoOrg.filter(onlyUnique);
	cargarTipoOrg(arraytipoOrg);

	for (d = 0; d < arrayMunicipio.length; d++) {
		mun = arrayMunicipio[d];
		$(".orgDpto").append(
			arrayMunicipio[d] +
				": " +
				repetidosMun[mun] +
				" <i class='far fa-eye verMun' data-name='" +
				arrayMunicipio[d] +
				"'></i></br>"
		);
	}

	for (d = 0; d < arraytipoOrg.length; d++) {
		tipoOrg = arraytipoOrg[d];
		$(".orgTipo").append(
			arraytipoOrg[d] +
				": " +
				repetidosTipo[tipoOrg] +
				" <i class='far fa-eye verTipo' data-name='" +
				arraytipoOrg[d] +
				"'></i></br>"
		);
	}

	$(".totalOrgAcreditacion").html(
		resultadoParcial.length + " <i class='far fa-eye verOrg'></i>"
	);
});

//filtro por Municipio
$(".selectMunicipioAcreditacion").change(function () {
	$(".fichaUno").removeClass("col-lg-6");
	$(".fichaUno").addClass("col-lg-12");
	$(".fichaDos").hide();
	html = "";
	tipoOrg = [];
	seleccion = $(".municipioAcreditacion").val();
	departamento = $(".departamentoAcreditacion").val();
	$(".orgDpto").html("");
	$(".orgTipo").html("");

	resultadoParcial = resultado.filter(function (el) {
		return (
			el.nomDepartamentoUbicacion == departamento &&
			el.nomMunicipioNacional == seleccion
		);
	});

	for (i = 0; i < resultadoParcial.length; i++) {
		tipoOrg.push(resultadoParcial[i].tipoOrganizacion);
	}

	let repetidosTipo = {};

	tipoOrg.forEach(function (numero) {
		repetidosTipo[numero] = (repetidosTipo[numero] || 0) + 1;
	});

	let arraytipoOrg = tipoOrg.filter(onlyUnique);
	cargarTipoOrg(arraytipoOrg);

	for (d = 0; d < arraytipoOrg.length; d++) {
		tipoOrg = arraytipoOrg[d];
		$(".orgTipo").append(
			tipoOrg +
				": " +
				repetidosTipo[tipoOrg] +
				" <i class='far fa-eye verTipo' data-name='" +
				tipoOrg +
				"'></i></br>"
		);
	}

	$(".totalOrgAcreditacion").html(
		resultadoParcial.length + " <i class='far fa-eye verOrg'></i>"
	);
});

//filtro tipo de organizacion
$(".tipoOrgAcreditacion").change(function () {
	$(".cardFichaTipoOrg").hide();
	tipoOrg = [];
	departamentos = [];
	municipios = [];
	html = "";
	seleccion = $(".tipoOrgAcreditacion").val();
	dept = $(".departamentoAcreditacion").val();
	mun = $(".municipioAcreditacion").val();

	$(".orgDpto").html("");
	$(".orgTipo").html("");

	if (dept == "" && mun == "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.tipoOrganizacion == seleccion;
		});
	} else if (dept != "" && mun == "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.tipoOrganizacion == seleccion && el.nomDepartamentoUbicacion == dept
			);
		});
	} else if (dept != "" && mun != "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.tipoOrganizacion == seleccion &&
				el.nomDepartamentoUbicacion == dept &&
				el.nomMunicipioNacional == mun
			);
		});
	}

	for (i = 0; i < resultadoParcial.length; i++) {
		departamentos.push(resultadoParcial[i].nomDepartamentoUbicacion);
		tipoOrg.push(resultadoParcial[i].tipoOrganizacion);
	}

	let repetidosDpto = {};

	departamentos.forEach(function (numero) {
		repetidosDpto[numero] = (repetidosDpto[numero] || 0) + 1;
	});

	let repetidosTipo = {};

	tipoOrg.forEach(function (numero) {
		repetidosTipo[numero] = (repetidosTipo[numero] || 0) + 1;
	});

	let arrayDepartamentos = departamentos.filter(onlyUnique);
	cargarDepartamentos(arrayDepartamentos);

	let arraytipoOrg = tipoOrg.filter(onlyUnique);
	cargarTipoOrg(arraytipoOrg);

	for (d = 0; d < arrayDepartamentos.length; d++) {
		dept = arrayDepartamentos[d];
		$(".orgDpto").append(
			arrayDepartamentos[d] +
				": " +
				repetidosDpto[dept] +
				" <i class='far fa-eye verDept' data-name='" +
				arrayDepartamentos[d] +
				"'></i></br>"
		);
	}

	for (d = 0; d < arraytipoOrg.length; d++) {
		tipoOrg = arraytipoOrg[d];
		$(".orgTipo").append(
			arraytipoOrg[d] +
				": " +
				repetidosTipo[tipoOrg] +
				" <i class='far fa-eye verTipo' data-name='" +
				arraytipoOrg[d] +
				"'></i></br>"
		);
	}

	$(".totalOrgAcreditacion").html(
		resultadoParcial.length + " <i class='far fa-eye verOrg'></i>"
	);
});

//especificacion organizaciones
$(document).on("click", ".verOrg", function () {
	deptSeleccionado = $(".departamentoAcreditacion").val();
	munSeleccionado = $(".municipioAcreditacion").val();
	tipoOrg = $(".tipoOrgAcreditacion").val();

	if (deptSeleccionado == "" && tipoOrg == "") {
		resultadoParcial = resultado;
	} else if (deptSeleccionado != "" && munSeleccionado == "" && tipoOrg == "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.nomDepartamentoUbicacion == deptSeleccionado;
		});
	} else if (deptSeleccionado != "" && munSeleccionado != "" && tipoOrg == "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.nomDepartamentoUbicacion == deptSeleccionado &&
				el.nomMunicipioNacional == munSeleccionado
			);
		});
	} else if (tipoOrg != "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.tipoOrganizacion == tipoOrg;
		});
	}

	cargarModal(resultadoParcial);
});

//especificacion por departamento
$(document).on("click", ".verDept", function () {
	html = "";
	seleccion = $(this).attr("data-name");
	deptSeleccionado = $(".departamentoAcreditacion").val();
	tipoOrg = $(".tipoOrgAcreditacion").val();

	if (deptSeleccionado == "" && tipoOrg == "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.nomDepartamentoUbicacion == seleccion;
		});
	} else if (deptSeleccionado != "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.nomDepartamentoUbicacion == seleccion &&
				el.nomDepartamentoUbicacion == deptSeleccionado
			);
		});
	} else if (tipoOrg != "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.nomDepartamentoUbicacion == seleccion &&
				el.tipoOrganizacion == tipoOrg
			);
		});
	}

	cargarModal(resultadoParcial);
});

//ver especificacion por municipio
$(document).on("click", ".verMun", function () {
	html = "";
	seleccion = $(this).attr("data-name");
	deptSeleccionado = $(".departamentoAcreditacion").val();
	if (deptSeleccionado == "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.nomDepartamentoUbicacion == seleccion;
		});
	} else {
		resultadoParcial = resultado.filter(function (el) {
			return el.nomMunicipioNacional == seleccion;
		});
		tipo = "municipio";
	}

	cargarModal(resultadoParcial);
});

//especificacion por tipo de organizacion
$(document).on("click", ".verTipo", function () {
	html = "";
	seleccion = $(this).attr("data-name");
	deptSeleccionado = $(".departamentoAcreditacion").val();
	munSeleccionado = $(".municipioAcreditacion").val();

	if (deptSeleccionado == "") {
		resultadoParcial = resultado.filter(function (el) {
			return el.tipoOrganizacion == seleccion;
		});
		tipo = "departamento";
	} else if (deptSeleccionado != "" && munSeleccionado == "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.tipoOrganizacion == seleccion &&
				el.nomDepartamentoUbicacion == deptSeleccionado
			);
		});
		tipo = "municipio";
	} else if (deptSeleccionado != "" && munSeleccionado != "") {
		resultadoParcial = resultado.filter(function (el) {
			return (
				el.tipoOrganizacion == seleccion &&
				el.nomDepartamentoUbicacion == deptSeleccionado &&
				el.nomMunicipioNacional == munSeleccionado
			);
		});
		tipo = "municipio";
	}

	cargarModalDept(resultadoParcial, tipo);
});

//reinicio de filtros
$(".reinciarFiltro").click(function () {
	$("#tipoInformacion").val("");
	$(".selectDepartamentoAcreditacion").html(
		"<option value=''>Seleccione una opción</option>"
	);
	$(".municipioAcreditacion").html(
		"<option value=''>Seleccione una opción</option>"
	);
	$(".tipoOrgAcreditacion").html(
		"<option value=''>Seleccione una opción</option>"
	);

	$(".fichaUno").removeClass("col-lg-12");
	$(".fichaUno").addClass("col-lg-6");
	$(".fichaDos").show();
	$(".cardFichaTipoOrg").show();

	$(".totalOrgAcreditacion").html("");
	$(".orgTipo").html("");
	$(".orgDpto").html("");
});

//filtrar elementos unicos
function onlyUnique(value, index, self) {
	return self.indexOf(value) === index;
}

//cargar departamentos existentes
function cargarDepartamentos(departamentos) {
	for (i = 0; i < departamentos.length; i++) {
		$(".selectDepartamentoAcreditacion").append(
			"<option value=''>" + departamentos[i] + "</option>"
		);
	}
}

//cargar municipios existentes
function cargarMunicipios(municipios) {
	for (i = 0; i < municipios.length; i++) {
		$(".selectMunicipioAcreditacion").append(
			"<option>" + municipios[i] + "</option>"
		);
	}
}

//cargar tipos de organizaciones existentes
function cargarTipoOrg(tipoOrg) {
	for (i = 0; i < tipoOrg.length; i++) {
		$(".tipoOrgAcreditacion").append("<option>" + tipoOrg[i] + "</option>");
	}
}

function cargarModal(arrayData) {
	html = "";

	html = "<table class='table'>";
	html += "<thead>";
	html += "<tr>";
	html += "<th>Nombre Organización</th>";
	html += "</tr>";
	html += "</thead>";
	html += "<tbody class='tableStats'>";

	for (i = 0; i < arrayData.length; i++) {
		html += "<tr>";
		html += "<td>" + arrayData[i].nombreOrganizacion + "</td></tr>";
	}

	html += "</tbody>";
	html += "</table>";

	$(".modal-body").html(html);
	$("#myModal").modal("show");
}

function cargarModalDept(arrayData, tipo) {
	html = "";

	html += "<table class='table'>";
	html += "<thead>";
	html += "<tr>";
	html += "<th>Nombre Organización</th>";
	if ($(".municipioAcreditacion").val() == "") {
		html += "<th>Ubicación</th>";
	}
	html += "</tr>";
	html += "</thead>";
	html += "<tbody class='tableStats'>";

	for (i = 0; i < arrayData.length; i++) {
		html += "<tr>";
		html += "<td>" + arrayData[i].nombreOrganizacion + "</td>";
		if (tipo == "departamento") {
			html += "<td>" + arrayData[i].nomDepartamentoUbicacion + "</td></tr>";
		} else if (tipo == "municipio" && $(".municipioAcreditacion").val() == "") {
			html += "<td>" + arrayData[i].nomMunicipioNacional + "</td></tr>";
		}
	}

	html += "</tbody>";
	html += "</table>";

	$(".modal-body").html(html);
	$("#myModal").modal("show");
}
