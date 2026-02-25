<!-- Consultar estado solicitud -->
<script src="<?= base_url('assets/js/functions/home/estado-solicitud.js?v=1.2.1') . time() ?>"  type="module"></script>
<div class="container">
	<!-- Breadcrumb GOV.CO -->
	<div class="row">
		<div class="col mt-2">
			<nav class="breadcrumb-govco" aria-label="Breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item-govco"><a href="<?= base_url(); ?>>">Inicio</a></li>
					<li class="breadcrumb-item-govco active" aria-current="page">Consulta de estado</li>
				</ol>
			</nav>
		</div>
	</div>
	<!-- Consultar estado solicitud-->
	<div class="row">
		<div class="col-12">
			<!-- Título de la sección con estilo GOV.CO -->
			<div class="govco-title">
				<h3 class="titulos-govco">
					<span class="govco-search"></span>
					Consulta de Estado de la Solicitud
				</h3>
			</div>
			<!-- Tarjeta informativa GOV.CO -->
			<div class="card mb-5">
				<div class="card-body">
					<p class="parrafo-govco">Aquí puede consultar el estado actual de la solicitud. Ingrese el número de solicitud para visualizar su progreso.</p>
					<!-- Formulario de búsqueda estilo GOV.CO -->
					<div class="govco-form-container mb-5">
						<div class="row">
							<div class="col-12">
								<?= form_open('', array('id' => 'formulario_estado')); ?>
								<div class="entradas-de-texto-govco">
									<label for="numeroID">Número de Solicitud*</label>
									<input type="text" id="numeroID" name="numeroID"  aria-describedby="contador max-lenght" placeholder="Ingrese el ID de la solicitud" maxlength="25" typeData="accountant" autofocus/>
									<span class="visually-hidden-focusable info-entradas-de-texto-govco" id="max-lenght">Caracteres permitidos:25</span>
									<div class="counter-entradas-de-texto-govco" id="contador" role="status">
										<span class="number-entradas-de-texto-govco">0</span>
										<span> de 25</span>
									</div>
									<small class="form-text text-muted">Escriba el número de solicitud asignado</small>
								</div>
								<div class="btn-group" role="group" aria-label="consultarEstadoID">
									<button type="button" class="btn-govco outline-btn-govco" id="consultarEstadoID">
										Consultar
									</button>
									<button type="reset" class="btn-govco fill-btn-govco" id="limpiarDatosSolitidud">
										Limpiar
									</button>
								</div>
								<?= form_close(); ?>
							</div>
						</div>
					</div>
					<!-- Contenedor de resultados -->
					<div id="resConEst" class="mt-4 mb-4">
						<!-- Tarjeta horizontal izquierda -->
						<div class="tarjeta-govco horizontal-tarjeta-govco" style="cursor: pointer;" title="descripción donde redirige el enlace">
							<div class="container-img-tarjeta-govco">
								<img class="image-tarjeta-govco" src="https://govco-prod-webutils.s3.amazonaws.com/uploads/2022-04-22/82bf860a-0581-4689-97cc-e8b996d5ff07-pexels-christina-morillo-1181681.jpg" alt="descripción de la imagen">
							</div>
							<div class="body-tarjeta-govco">
								<h4>Resultados de la consulta</h4>
								<!-- Información básica de la solicitud -->
								<div class="row">
									<div class="col-12 col-12 col-md-6">
										<div class="info-item mb-3">
											<label class="form-label-govco">ID de Solicitud:</label>
											<span id="idSol" class="form-text-govco">-</span>
										</div>
										<div class="info-item mb-3">
											<label class="form-label-govco">Organización Solicitante:</label>
											<span id="organizacion" class="form-text-govco">-</span>
										</div>
										<div class="info-item mb-3">
											<label class="form-label-govco">Tipo:</label>
											<span id="tipSol" class="form-text-govco">-</span>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="info-item mb-3">
											<label class="form-label-govco">Modalidad:</label>
											<span id="modSol" class="form-text-govco">-</span>
										</div>
										<div class="info-item mb-3">
											<label class="form-label-govco">Asignado a:</label>
											<span id="asignadoSol" class="form-text-govco">-</span>
										</div>
										<div class="info-item mb-3">
											<label class="form-label-govco">Estado Actual:</label>
											<span id="estadoOrg" class="etiqueta-govco error">-</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br/>
						<!-- Stepper de GOV.CO para la línea de tiempo -->
						<div class="row">
							<div class="col-md-12">
								<h5 class="form-label-govco mb-3">Progreso de la Solicitud</h5>
								<div class="govco-progress-bar" id="timelineProcess">
									<div class="step">
										<button class="step-button active" id="step1">
											<div class="circle-button">
												<span class="govco-plus-square-1"></span>
											</div>
										</button>
										<div class="step-title">
											<p>Creación</p>
											<small id="timeline-fechaCreacion">-</small>
										</div>
									</div>

									<div class="connector">
										<div class="progress">
											<div class="progress-bar bg-success" id="connector1-2" style="width: 0%"></div>
										</div>
									</div>

									<div class="step">
										<button class="step-button" id="step2">
											<div class="circle-button">
												<span class="govco-search"></span>
											</div>
										</button>
										<div class="step-title">
											<p>En Revisión</p>
											<small id="timeline-revision">-</small>
										</div>
									</div>

									<div class="connector">
										<div class="progress">
											<div class="progress-bar bg-success" id="connector2-3" style="width: 0%"></div>
										</div>
									</div>

									<div class="step">
										<button class="step-button" id="step3">
											<div class="circle-button">
												<span class="govco-check-square"></span>
											</div>
										</button>
										<div class="step-title">
											<p id="timeline-decision-title">Decisión Final</p>
											<small id="timeline-fechaFin">-</small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Detalles adicionales en un acordeón (GOV.CO) -->
						<div class="row mt-4">
							<div class="col-md-12">
								<div class="accordion-govco" id="accordionExampleTwo">
									<div class="item-accordion-govco">
										<h2 class="accordion-header" id="accordionIconoPanels-exampleOne">
											<button class="button-accordion-govco" type="button" data-bs-toggle="collapse" data-bs-target="#accordionIconoPanels-collapseOne" aria-expanded="true" aria-controls="accordionIconoPanels-collapseOne">
												<span class="icon-button-accordion-govco govco-info-circle"></span>
												<span class="text-button-accordion-govco">Detalles adicionales</span>
											</button>
										</h2>
										<div id="accordionIconoPanels-collapseOne" class="accordion-collapse collapse show" aria-labelledby="accordionIconoPanels-exampleOne" data-bs-parent="#accordionExampleTwo">
											<div class="body-accordion-govco">
												<div class="row">
													<div class="col-md-6">
														<div class="info-item mb-3">
															<label class="form-label-govco">Estado Anterior:</label>
															<span id="estadoAnterior" class="etiqueta-govco">-</span>
														</div>
														<div class="info-item mb-3">
															<label class="form-label-govco">Fecha de Creación:</label>
															<span id="fechaCreacion" class="form-text-govco">-</span>
														</div>
														<div class="info-item mb-3">
															<label class="form-label-govco">Fecha de Finalización:</label>
															<span id="fechaFin" class="form-text-govco">-</span>
														</div>
													</div>
													<div class="col-md-6">
														<div class="info-item mb-3">
															<label class="form-label-govco">Última Revisión:</label>
															<span id="revision" class="form-text-govco">-</span>
														</div>
														<div class="info-item mb-3">
															<label class="form-label-govco">Motivo:</label>
															<div id="motSol" class="govco-text-area-readonly">-</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="item-accordion-govco">
										<h2 class="accordion-header" id="accordionIconoPanels-exampleTwo">
											<button class="button-accordion-govco collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionIconoPanels-collapseTwo" aria-expanded="false" aria-controls="accordionIconoPanels-collapseTwo">
												<span class="icon-button-accordion-govco govco-history"></span>
												<span class="text-button-accordion-govco">Historial de estados</span>
											</button>
										</h2>
										<div id="accordionIconoPanels-collapseTwo" class="accordion-collapse collapse" aria-labelledby="accordionIconoPanels-exampleTwo" data-bs-parent="#accordionExampleTwo">
											<div class="body-accordion-govco">
												<ol class="list-group list-group-numbered" id="listaHistorial">
													<!-- Se llenará dinámicamente -->
												</ol>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
