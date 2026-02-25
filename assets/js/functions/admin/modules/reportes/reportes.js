//$('.g-recaptcha').append('<div id="txt_greca"></div>');
//$('#txt_greca').text("No soy un robot.");
//$('#txt_greca').css({"position":"relative", "width":"160px", "top":"-50px", "left":"53px", "background-color":"#f9f9f9"});
//Reportes
$("#verReportes").click(function () {
	//gene
	var $numeroMujeres = 0;
	var $numeroHombres = 0;
	//edades
	var $ed = "";
	var edT = [];
	var ed_num = [];
	//datos
	var $lgbti = 0;
	var $afro = 0;
	var $cabezaFamilia = 0;
	var $indigena = 0;
	var $palenquero = 0;
	var $privadoLibertad = 0;
	var $prostitucion = 0;
	var $redUnidos = 0;
	var $reintegro = 0;
	var $romGitano = 0;
	var $victima = 0;
	var $raizal = 0;
	var $depRes = "";
	var $munRes = "";
	//mun
	var data_mun = [];
	var $mun = "";
	var data_mun_num = [{ value: 0, name: "" }];
	//dep
	var data_dep = [];
	var $dep = "";
	var data_dep_num = [{ value: 0, name: "" }];

	$.ajax({
		url: baseURL + "reportes/verInformacion",
		type: "post",
		dataType: "JSON",
		beforeSend: function () {
			notificacion("Espere...", "success");
		},
		success: function (response) {
			if (response.informe.length <= 0) {
				$("#rep").slideUp();
				notificacion("No hay datos para mostrar.", "success");
			} else {
				$("#rep").slideDown();
				notificacion("Datos cargados.", "success");
				for (let $i = 0; $i < response.informe.length; $i++) {
					//generos
					$numeroMujeres += parseFloat(response.informe[$i].numeroMujeres);
					$numeroHombres += parseFloat(response.informe[$i].numeroHombres);
					//datos
					for (let $j = 0; $j < response.asistentes[$i].length; $j++) {
						if (response.asistentes[$i][$j].LGTBI == "Si") {
							$lgbti += 1;
						}
						if (response.asistentes[$i][$j].afro == "Si") {
							$afro += 1;
						}
						if (response.asistentes[$i][$j].cabezaFamilia == "Si") {
							$cabezaFamilia += 1;
						}
						if (response.asistentes[$i][$j].indigena == "Si") {
							$indigena += 1;
						}
						if (response.asistentes[$i][$j].palenquero == "Si") {
							$palenquero += 1;
						}
						if (response.asistentes[$i][$j].privadoLibertad == "Si") {
							$privadoLibertad += 1;
						}
						if (response.asistentes[$i][$j].prostitucion == "Si") {
							$prostitucion += 1;
						}
						if (response.asistentes[$i][$j].redUnidos == "Si") {
							$redUnidos += 1;
						}
						if (response.asistentes[$i][$j].reintegro == "Si") {
							$reintegro += 1;
						}
						if (response.asistentes[$i][$j].romGitano == "Si") {
							$romGitano += 1;
						}
						if (response.asistentes[$i][$j].victima == "Si") {
							$victima += 1;
						}
						if (response.asistentes[$i][$j].raizal == "Si") {
							$raizal += 1;
						}
						//edades
						$ed = response.asistentes[$i][$j].edadAsistente;
						edT.push($ed);
						ed_num.push({ value: 1, name: $ed });
					}
					//MunRes
					$mun = response.informe[$i].municipioCurso;
					data_mun.push($mun);
					data_mun_num.push({ value: 1, name: $mun });
					//DepRes
					$dep = response.informe[$i].departamentoCurso;
					data_dep.push($dep);
					data_dep_num.push({ value: 1, name: $dep });

					//Barras Horizontal
					if ($("#echart_bar_horizontal").length) {
						var echartBar = echarts.init(
							document.getElementById("echart_bar_horizontal"),
							theme
						);
						echartBar.setOption({
							title: {
								text: "Géneros",
								subtext:
									"Géneros de Cursos \n\nTotal: " +
									($numeroMujeres + $numeroHombres) +
									" Personas",
							},
							tooltip: {
								trigger: "axis",
							},
							legend: {
								x: "center",
								y: "bottom",
								data: ["Mujeres", "Hombres"],
							},
							toolbox: {
								show: true,
								feature: {
									saveAsImage: {
										show: true,
										title: "Guardar Imagen",
									},
								},
							},
							calculable: true,
							xAxis: [
								{
									type: "value",
									boundaryGap: [0, 0.01],
								},
							],
							yAxis: [
								{
									type: "category",
									data: ["Género"],
								},
							],
							series: [
								{
									name: "Mujeres",
									type: "bar",
									data: [$numeroMujeres],
								},
								{
									name: "Hombres",
									type: "bar",
									data: [$numeroHombres],
								},
							],
						});
					} //Fin barras
					//Donut
					if ($("#echart_donut").length) {
						var echartDonut = echarts.init(
							document.getElementById("echart_donut"),
							theme
						);

						echartDonut.setOption({
							title: {
								text: "Edades",
								subtext: "Edades de los asistentes",
							},
							tooltip: {
								trigger: "item",
								formatter: "{a} <br/>{b} : {c} ({d}%)",
							},
							calculable: true,
							legend: {
								x: "center",
								y: "bottom",
								data: edT,
							},
							toolbox: {
								show: true,
								feature: {
									magicType: {
										show: true,
										type: ["pie", "funnel"],
										option: {
											funnel: {
												x: "25%",
												width: "50%",
												funnelAlign: "left",
												max: response.asistentes.length,
											},
										},
									},
									restore: {
										show: true,
										title: "Restaurar",
									},
									saveAsImage: {
										show: true,
										title: "Guardar Imagen",
									},
								},
							},
							series: [
								{
									name: "Edades",
									type: "pie",
									radius: ["40%", "87%"],
									itemStyle: {
										normal: {
											label: {
												show: true,
											},
											labelLine: {
												show: true,
											},
										},
										emphasis: {
											label: {
												show: true,
												position: "center",
												textStyle: {
													fontSize: "14",
													fontWeight: "normal",
												},
											},
										},
									},
									data: ed_num,
								},
							],
						});
					} //Fin donut
					//echart Pie
					if ($("#echart_pie").length) {
						var echartPie = echarts.init(
							document.getElementById("echart_pie"),
							theme
						);
						echartPie.setOption({
							title: {
								text: "Datos de los asistentes",
								subtext: "Datos",
							},
							tooltip: {
								trigger: "item",
								formatter: "{a} <br/>{b}: {c} ({d}%)",
							},
							legend: {
								x: "center",
								y: "bottom",
								data: [
									"LGBTI",
									"Afro",
									"Cabeza de familia",
									"Raizal",
									"Indígena",
									"Palenquero",
									"Privado de la libertad",
									"Prostitucioón",
									"Prostitución",
									"Red Unidos",
									"Reintegro",
									"Rom o Gitano",
									"Víctima",
								],
							},
							toolbox: {
								show: true,
								feature: {
									magicType: {
										show: true,
										type: ["pie", "funnel"],
										option: {
											funnel: {
												x: "25%",
												width: "50%",
												funnelAlign: "left",
												max: $numeroMujeres + $numeroHombres,
											},
										},
									},
									restore: {
										show: true,
										title: "Restaurar",
									},
									saveAsImage: {
										show: true,
										title: "Guardar Imagen",
									},
								},
							},
							calculable: true,
							series: [
								{
									name: "Minorías",
									type: "pie",
									radius: "70%",
									center: ["50%", "48%"],
									data: [
										{
											value: $lgbti,
											name: "LGBTI",
										},
										{
											value: $afro,
											name: "Afro",
										},
										{
											value: $cabezaFamilia,
											name: "Cabeza de familia",
										},
										{
											value: $raizal,
											name: "Raizal",
										},
										{
											value: $indigena,
											name: "Indígena",
										},
										{
											value: $palenquero,
											name: "Palenquero",
										},
										{
											value: $privadoLibertad,
											name: "Privado de la libertad",
										},
										{
											value: $prostitucion,
											name: "Prostitución",
										},
										{
											value: $redUnidos,
											name: "Red Unidos",
										},
										{
											value: $reintegro,
											name: "Reintegro",
										},
										{
											value: $romGitano,
											name: "Rom o Gitano",
										},
										{
											value: $victima,
											name: "Víctima",
										},
									],
								},
							],
						});
					} // Fin pie
					// Pie 2 _ Depto	   data_mun data_dep
					if ($("#echart_pie2").length) {
						var echartPieCollapse = echarts.init(
							document.getElementById("echart_pie2"),
							theme
						);
						echartPieCollapse.setOption({
							title: {
								text: "Departamentos",
								subtext: "Cursos por departamentos",
							},
							tooltip: {
								trigger: "item",
								formatter: "{a} <br/>{b} : {c} ({d}%)",
							},
							legend: {
								x: "center",
								y: "bottom",
								data: data_dep,
							},
							toolbox: {
								show: true,
								feature: {
									magicType: {
										show: true,
										type: ["pie", "funnel"],
									},
									restore: {
										show: true,
										title: "Restaurar",
									},
									saveAsImage: {
										show: true,
										title: "Guardar Imagen",
									},
								},
							},
							calculable: true,
							series: [
								{
									name: "Departamentos",
									type: "pie",
									radius: [70, 150],
									center: ["50%", 170],
									roseType: "area",
									x: "50%",
									max: response.informe.length,
									sort: "ascending",
									data: data_dep_num,
								},
							],
						});
					}

					// Pie 2 _ Mun
					if ($("#echart_pie2_2").length) {
						var echartPieCollapse = echarts.init(
							document.getElementById("echart_pie2_2"),
							theme
						);
						echartPieCollapse.setOption({
							title: {
								text: "Municipios",
								subtext: "Cursos por municipios",
							},
							tooltip: {
								trigger: "item",
								formatter: "{a} <br/>{b} : {c} ({d}%)",
							},
							legend: {
								x: "center",
								y: "bottom",
								data: data_mun,
							},
							toolbox: {
								show: true,
								feature: {
									magicType: {
										show: true,
										type: ["pie", "funnel"],
									},
									restore: {
										show: true,
										title: "Restaurar",
									},
									saveAsImage: {
										show: true,
										title: "Guardar Imagen",
									},
								},
							},
							calculable: true,
							series: [
								{
									name: "Municipios",
									type: "pie",
									radius: [70, 150],
									center: ["50%", 170],
									roseType: "area",
									x: "50%",
									max: response.informe.length,
									sort: "ascending",
									data: data_mun_num,
								},
							],
						});
					}
				}

				//echart Mini Pie
				if ($("#echart_mini_pie").length) {
					var echartMiniPie = echarts.init(
						document.getElementById("echart_mini_pie"),
						theme
					);

					echartMiniPie.setOption({
						title: {
							text: "Chart #2",
							subtext: "From ExcelHome",
							sublink: "http://e.weibo.com/1341556070/AhQXtjbqh",
							x: "center",
							y: "center",
							itemGap: 20,
							textStyle: {
								color: "#0062AB", //c61f1b
								fontFamily: "微软雅黑",
								fontSize: 35,
								fontWeight: "bolder",
							},
						},
						tooltip: {
							show: true,
							formatter: "{a} <br/>{b} : {c} ({d}%)",
						},
						legend: {
							orient: "vertical",
							x: 170,
							y: 45,
							itemGap: 12,
							data: ["68%Something #1", "29%Something #2", "3%Something #3"],
						},
						toolbox: {
							show: true,
							feature: {
								mark: {
									show: true,
								},
								dataView: {
									show: true,
									title: "Vista Texto",
									lang: ["Text View", "Cerrar", "Actualizar"],
									readOnly: false,
								},
								restore: {
									show: true,
									title: "Restaurar",
								},
								saveAsImage: {
									show: true,
									title: "Guardar Imagen",
								},
							},
						},
						series: [
							{
								name: "1",
								type: "pie",
								clockWise: false,
								radius: [105, 130],
								itemStyle: dataStyle,
								data: [
									{
										value: 68,
										name: "68%Something #1",
									},
									{
										value: 32,
										name: "invisible",
										itemStyle: placeHolderStyle,
									},
								],
							},
							{
								name: "2",
								type: "pie",
								clockWise: false,
								radius: [80, 105],
								itemStyle: dataStyle,
								data: [
									{
										value: 29,
										name: "29%Something #2",
									},
									{
										value: 71,
										name: "invisible",
										itemStyle: placeHolderStyle,
									},
								],
							},
							{
								name: "3",
								type: "pie",
								clockWise: false,
								radius: [25, 80],
								itemStyle: dataStyle,
								data: [
									{
										value: 3,
										name: "3%Something #3",
									},
									{
										value: 97,
										name: "invisible",
										itemStyle: placeHolderStyle,
									},
								],
							},
						],
					});
				}
			}
		},
		error: function (ev) {
			//Do nothing
		},
	});
});
