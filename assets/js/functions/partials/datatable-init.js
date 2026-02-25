/**
 * Tablas a inicializar con DataTable, si se van añadir mas tablas a inicializar escribir el id sin el # en el array "tablas".
 **/
export function datatableInit() {
	if (typeof $.fn.DataTable === "undefined") {
		return;
	}
	// Tablas inicializadas
	var tablas = [
		"tabla_archivos_formulario",
	];
	// Iniciar tablas
	for (i = 0; i < tablas.length; i++) {
		var handleDataTableButtons = function () {
			if ($("#" + tablas[i] + "").length) {
				$("#" + tablas[i] + "").DataTable({
					dom: "Bfrtip",
					buttons: [
						{
							extend: "pageLength",
							className: "btn-sm btn-danger",
							text: "Ver Filas",
						},
						{
							extend: "copy",
							className: "btn-sm",
							text: "Copiar Tabla",
						},
						/**{
							extend: "csv",
							className: "btn-sm",
							text: "Descargar a CSV",
						},*/
						/*{
					  	extend: "print",
					  	className: "btn-sm",
					  	text: "Imprimir Todo"
					},*/
						{
							extend: "excelHtml5",
							autoFilter: true,
							className: "btn-sm",
							text: "Descargar a Excel",
							/* header: "Unidad Administrativa especial de organizaciones Solidarias",
								footer: "Unidad Administrativa especial de organizaciones Solidarias",*/
							//messageBottom: "Unidad Administrativa Especial de Organizaciones Solidarias | SIIA",
							messageTop:
								"Registro de ____________________________ por la Unidad Administrativa Especial de Organizaciones Solidarias | SIIA ",
							sheetName: "Datos SIIA",
							//title: "Datos",
							filename: document.title,
							customize: function (xlsx) {
								var sheet = xlsx.xl.worksheets["sheet1.xml"];
								$("row n", sheet).each(function () {
									// if cell starts with http
									if ($("is t", this).text().indexOf("http") === 0) {
										// (2.) change the type to `str` which is a formula
										$(this).attr("t", "str");
										//append the formula
										$(this).append(
											"<f>" +
											'HYPERLINK("' +
											$("is t", this).text() +
											'","' +
											$("is t", this).text() +
											'")' +
											"</f>"
										);
										//remove the inlineStr
										$("is", this).remove();
										// (3.) underline
										$(this).attr("s", "4");
									}
								});
								$("row:nth-child(3) c", sheet).attr("s", "7");
								$("row:nth-child(2) a", sheet).attr("s", "55");
							},
							exportOptions: {
								stripHtml: true,
							},
						},
						{
							extend: "pdfHtml5",
							className: "btn-sm",
							text: "PDF",
							orientation: "landscape",
							pageSize: "A0",
							exportOptions: {
								stripHtml: true,
							},
							customize: function (doc) {
								doc.defaultStyle.fontSize = 12; //2,3,4,etc
								doc.styles.tableHeader.fontSize = 14; //2, 3, 4, etc
								doc.content.splice(1, 0, {
									margin: [0, 0, 0, 12],
									alignment: "center",
									image:
										"data:image/png;base64,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",
								});
								// Image Data URL generada en http://dataurl.net/#dataurlmaker SIIA
							},
						},
						/*{
					  	extend: "pdf",
					  	className: "btn-sm",
					  	text: "PDF"
					},*/
					],
					lengthMenu: [
						[10, 25, 50, -1],
						["10 filas - ", "25 filas - ", "50 filas -", "Mostrar todo"],
					],
					language: {
						url: "https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json",
					},
					order: [[0, "desc"]],
					rowGroup: {
						dataSrc: 0,
					},
					responsive: {
						details: {
							type: 'column',
							target: 'tr'
						}
					},
					columnDefs: [
						{
							className: 'dtr-control',
							orderable: false,
							targets: 0
						}
					],
					//autoFill: true,
					//fixedColumns: true,
					//colReorder: true,
					//rowReorder: true,
					select: true,
					fixedHeader: {
						header: false,
						footer: false,
					},
				});
			}
		};
		TableManageButtons = (function () {
			"use strict";
			return {
				init: function () {
					handleDataTableButtons();
				},
			};
		})();
		TableManageButtons.init();
	}
}
