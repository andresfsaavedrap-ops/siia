<!-- Division -->
<div class="container">
	<div class="clearfix"></div>
	<hr />
</div>
<!-- Dashboard Menu -->
<div class="container center-block">
	<!-- Filtros para consulta de estadisticas -->
	<div class="col-lg-12">
		<div class="row" style="text-align: justify;">
			<div class="filtrosAcreditacion row">
				<div class="form-group col-lg-3">
					<label>Tipo de información</label>
					<select name="tipoInformacion" class="form-control show-tick" id="tipoInformacion">
						<option value="">Seleccione una opción</option>
						<option value="acreditadas">Acreditadas</option>
						<option value="cursoBasico">Curso Basico</option>
						<option value="avaladas">Avaladas</option>
						<option value="modalidadVirtual">Modalidad Virtual</option>
					</select>
				</div>
				<div class="form-group col-lg-3">
					<label>Departamento</label>
					<select name="selectDepartamentoAcreditacion" class="form-control show-tick selectDepartamentoAcreditacion">
						<option value="">Seleccione una opción</option>
					</select>
				</div>
				<div class="form-group col-lg-3">
					<label>Municipio</label>
					<select name="municipioAcreditacion" class="form-control show-tick selectMunicipioAcreditacion">
						<option value="">Seleccione una opción</option>
					</select>
				</div>
				<div class="form-group col-lg-3">
					<label>Tipo Organización</label>
					<select name="tipoOrgAcreditacion" class="form-control show-tick tipoOrgAcreditacion">
						<option value="">Seleccione una opción</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<button class="btn btn-siia reinciarFiltro" style="margin-top:30px;">Reiniciar Filtros</button>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<section class="col-sm-12">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<a class="verOrganizaciones" style="color: #d6e0f5 !important;">Datos</a>
							</h3>
						</div><!-- /.card-header -->
						<div class="bodyChart row card-body">
							<section class="fichaUno col-lg-6">
								<div class="card">
									<div class="card-header" style="background: #d6e0f5 !important;"><strong>Total Organizaciones</strong></div>
									<div class="card-body">
										<p class="textoStats totalOrgAcreditacion"></p>
									</div>
								</div>

								<div class="card cardFichaTipoOrg">
									<div class="card-header" style="background: #d6e0f5 !important;"><strong>Tipo de Organización</strong></div>
									<div class="card-body orgTipo"></div>
								</div>
							</section>

							<section class="col-lg-6 fichaDos">
								<div class="card">
									<div class="card-header" style="background: #d6e0f5 !important;"><strong>Organizaciones por Ubicación</strong></div>
									<div class="card-body orgDpto"></div>
								</div>
							</section>

						</div>
					</div>
				</section>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
						<table class="table">
							<thead>
								<tr>
									<th>Nombre Organización</th>
								</tr>
							</thead>
							<tbody class="tableStats">

							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>



	</div>
</div>
<!-- <canvas id="myChart" width="40" height="40"></canvas>
<script>
	var ctx = document.getElementById('myChart');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: ['2018', '2019', '2020', '2021'],
			datasets: [{
				label: '# of Votes',
				data: [2, 4, 3, 5],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script> -->
