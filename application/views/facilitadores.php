<div class="container">
	<!-- Breadcrumb GOV.CO -->
	<div class="row">
		<div class="col mt-2">
			<nav class="breadcrumb-govco" aria-label="Breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item-govco"><a href="<?= base_url(); ?>>">Inicio</a></li>
					<li class="breadcrumb-item-govco active" aria-current="page">Docentes validos</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- Título de la sección con estilo GOV.CO -->
			<div class="govco-title">
				<h3 class="titulos-govco">
					<span class="govco-search"></span>
					Consultar docentes por organización
				</h3>
			</div>
			<div class="card mb-5">
				<div class="card-body">
					<p>Aquí puede consultar los facilitadores de organizaciones inscritas en el Sistema Integrado de Información de Acreditación.</p>
					<p>Debe ingresar el número NIT registrado en el SIIA con número de verificación DV (Si tiene).</p>
					<?= form_open('', array('id' => 'formulario_consultar_facilitadores')); ?>
						<div class="form-group">
							<div class="entradas-de-texto-govco">
								<label for="numeroID">NIT Organización*</label>
								<input type="text" id="facilitadoresNIT" name="facilitadoresNIT"  aria-describedby="contador max-lenght" placeholder="Número NIT..." maxlength="12" typeData="accountant" autofocus/>
								<span class="visually-hidden-focusable info-entradas-de-texto-govco" id="max-lenght">Caracteres permitidos:12</span>
								<div class="counter-entradas-de-texto-govco" id="contador" role="status">
									<span class="number-entradas-de-texto-govco">0</span>
									<span> de 12</span>
								</div>
							</div>
							<div class="btn-group" role="group" aria-label="consultarFacilitadores">
								<button type="button" class="btn-govco outline-btn-govco" id="consultarFacilitadores">
									Consultar
								</button>
								<button type="reset" class="btn-govco fill-btn-govco" id="limpiarConsultaFacilitadores">
									Limpiar
								</button>
							</div>
						</div>
					<?= form_close(); ?>
					<!-- Información de facilitadores cargada desde ajax -->
					<div id="resConEst" class="mt-5"></div>
				</div>
			</div>
		</div>
	</div>
</div>
