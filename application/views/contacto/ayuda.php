<!-- Página de Ayuda Mejorada -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<!-- Sección de Archivos y Recursos -->
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card shadow-sm">
					<div class="card-body">
						<h4 class="card-title text-primary mb-4">Recursos y Documentos</h4>
						<div class="row">
							<!-- Manual de usuario - Ahora abre modal -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100 card-hover" style="transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; cursor: pointer;" data-toggle="modal" data-target="#manualesModal">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-primary text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-book-open-page-variant"></i>
										</div>
										<h5 class="mb-0">Manuales de usuario</h5>
									</div>
									<p class="text-muted mb-3">Guías completas sobre cómo utilizar el sistema SIIA.</p>
									<div class="btn btn-outline-primary btn-sm">
										<i class="mdi mdi-folder-open mr-1"></i> Ver manuales (8)
									</div>
								</div>
							</div>

							<!-- Archivo de asistentes -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-success text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-file-excel"></i>
										</div>
										<h5 class="mb-0">Archivo de asistentes</h5>
									</div>
									<p class="text-muted mb-3">Plantilla para reportar asistentes a los cursos de su organización.</p>
									<a href="<?php echo base_url("assets/manuales/AsistentesCursosOrganizacion.xlsx"); ?>" target="_blank" class="btn btn-outline-success btn-sm">
										<i class="mdi mdi-download mr-1"></i> Descargar
									</a>
								</div>
							</div>

							<!-- PQRD -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-warning text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-message-text"></i>
										</div>
										<h5 class="mb-0">PQRD</h5>
									</div>
									<p class="text-muted mb-3">Sistema de Preguntas, Quejas, Reclamos y Denuncias.</p>
									<a href="http://sitios.uaeos.gov.co/portal/pqr/index.php?idcategoria=6" target="_blank" class="btn btn-outline-warning btn-sm">
										<i class="mdi mdi-open-in-new mr-1"></i> Acceder
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal para Manuales -->
			<div class="modal fade" id="manualesModal" tabindex="-1" role="dialog" aria-labelledby="manualesModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h5 class="modal-title" id="manualesModalLabel">
								<i class="mdi mdi-book-open-page-variant"></i>
								Manuales de Usuario - Sistema Integrado
							</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="list-group list-group-flush">
								<div class="row">
									<div class="col-lg-6 col-md-12">
										<!-- Manual 1 -->
										<a href="<?php echo base_url('assets/manuales/Manual_General_SIIA.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual General del Sistema SIIA</h6>
												<p class="mb-0 text-muted small">Guía completa sobre el funcionamiento del sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 2 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Registro.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Registro</h6>
												<p class="mb-0 text-muted small">Cómo registrarse y crear cuenta en el sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 3 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Cursos.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Gestión de Cursos</h6>
												<p class="mb-0 text-muted small">Administración y gestión de cursos</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 4 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Reportes.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Reportes</h6>
												<p class="mb-0 text-muted small">Generación de reportes y estadísticas</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
									</div>
									<div class="col-lg 6 col-md-12">
										<!-- Manual 5 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Administrativo.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual Administrativo</h6>
												<p class="mb-0 text-muted small">Funciones administrativas del sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 6 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Configuracion.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Configuración</h6>
												<p class="mb-0 text-muted small">Configuraciones y personalización del sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 7 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Seguridad.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Seguridad</h6>
												<p class="mb-0 text-muted small">Políticas y procedimientos de seguridad</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 8 -->
										<a href="<?php echo base_url('assets/manuales/Manual_Soporte.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">Manual de Soporte Técnico</h6>
												<p class="mb-0 text-muted small">Guía de resolución de problemas y soporte</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
									</div>
								</div>
							</div>
							<!-- Botón para descargar todos -->
							<div class="text-center mt-4">
								<hr>
								<button class="btn btn-primary" onclick="descargarTodosManuales()">
									<i class="mdi mdi-download-multiple mr-2"></i>
									Descargar todos los manuales
								</button>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								<i class="mdi mdi-close mr-1"></i> Cerrar
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Sección de Ayuda -->
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card shadow-sm">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h3 class="card-title text-primary">Centro de Ayuda</h3>
							<span class="badge badge-info p-2">SIIA</span>
						</div>
						<p class="card-description mb-4">Preguntas frecuentes sobre la acreditación y el sistema SIIA</p>
						<div id="accordion" class="accordion">
							<!-- Notificaciones -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingOne">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											<span>Notificaciones</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>La Unidad Administrativa Especial de Organizaciones Solidarias puede notificar la Resolución de acreditación por medios electrónicos siempre y cuando la entidad solicitante de la acreditación manifieste su voluntad de utilizar este medio para la diligencia respectiva. Por tal razón es necesario que la entidad solicitante manifieste expresamente en su carta de solicitud la intención de ser notificado por medios electrónicos y relacione la cuenta de correo electrónico oficial para enviar la resolución de acreditación. La resolución de acreditación notificada vía electrónica solo quedará en firme una vez se reciba por parte de la entidad solicitante comunicación en donde se acepte los términos escritas en la misma.</p>
									</div>
								</div>
							</div>
							<!-- Acreditación -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingTwo">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											<span>¿Qué es la Acreditación?</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>Es el proceso mediante el cual la Unidad Administrativa Especial de Organizaciones Solidarias avala la calidad y pertinencia de los programas en educación solidaria. Con la acreditación, la Unidad Administrativa Especial de Organizaciones Solidarias autoriza a las instituciones jurídicas sin ánimo de lucro y a las entidades públicas en cuyo objeto se encuentre determinada la prestación de servicios educativos la posibilidad de impartir programas de educación solidaria.</p>
										<p>La Acreditación es necesaria para impartir los Cursos Básicos de Economía Solidaria. La Coordinación de Educación e Investigación de la Unidad Administrativa Especial de Organizaciones Solidarias realiza una evaluación, emite el concepto respectivo y expide el acto administrativo correspondiente para la Acreditación.</p>
										<p>Con la Acreditación, se busca que las instituciones acreditadas cumplan con requisitos de calidad en la formación impartida y desarrollen los fines propios de la educación. También se busca fortalecer los procesos de formación que adelantan las instituciones para impartir educación solidaria y cualificar su gestión en aspectos básicos referidos a la enseñanza, desempeño profesional de los docentes vinculados, eficacia de los métodos pedagógicos, prestación del servicio, organización administrativa, infraestructura física e implementación del modelo solidario.</p>
									</div>
								</div>
							</div>
							<!-- SIIA -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingThree">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											<span>¿Qué es el SIIA?</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>Se denomina Sistema Integrado de Información de Acreditación -SIIA- al aplicativo virtal que permite realizar la captura de la información requerida por la Unidad Administrativa Especial de Organizaciones Solidarias para el desarrollo del trámite de Acreditación; es decir permite el proceso de Acreditación a través de Internet.</p>
										<p>Es importante resaltar que la Unidad Administrativa Especial de Organizaciones Solidarias implementa este trámite en línea para realizar el proceso de Acreditación y también para obtener datos básicos sobre las características de las entidades que se están acreditando. El SIIA permite el desarrollo del trámite de una manera ágil reduciendo tiempos en la evaluación y la retroalimentación de ésta, además de concretar los contenidos y requisitos que se exigen dentro del proceso.</p>
									</div>
								</div>
							</div>
							<!-- Costo de la Acreditación -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingFour">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
											<span>¿Cuál es el costo de la Acreditación?</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
									<div class="card-body bg-light">
										<p class="text-success font-weight-bold">El proceso de Acreditación no tienen ningún costo y no requiere de intermediarios para su realización.</p>
									</div>
								</div>
							</div>
							<!-- Guía Académica -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingFive">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
											<span>Guía académica para la Acreditación</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>La Guía académica es un documento que lleva al interesado en acreditarse paso a paso a través del proceso explicando los contenidos que se deben ingresar y aquellos requisitos que serán verificados por la Unidad Administrativa Especial de Organizaciones Solidarias. Le expone al interesado lo que se espera encontrar en el desarrollo de sus contenidos al realizar la evaluación para obtener así un respuesta favorable a la solicitud.</p>
									</div>
								</div>
							</div>
							<!-- Actividades pedagógicas -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingSix">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
											<span>Actividades pedagógicas</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>Registro de las actividades pedagógicas que se realizan por semestre por las entidades acreditadas, lo cual permite reconocer el número de personas que tienen acceso a la formación solidaria en Colombia, es una obligación de las entidades y se deben presentar de manera semestral con los respectivos soportes.</p>
									</div>
								</div>
							</div>
							<!-- Reporte de Actividades pedagógicas -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingSeven">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
											<span>Reporte de Actividades pedagógicas</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>La Unidad Administrativa Especial de Organizaciones Solidarias recuerda a las entidades acreditadas que tienen la obligación de realizar un reporte bimestral, dando cuenta de sus actividades pedagógicas durante el periodo correspondiente.</p>
									</div>
								</div>
							</div>
							<!-- Listado de Acreditadas y con Aval -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingEigth">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseEigth" aria-expanded="false" aria-controls="collapseEigth">
											<span>Listado de Acreditadas y con Aval</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseEigth" class="collapse" aria-labelledby="headingEigth" data-parent="#accordion">
									<div class="card-body bg-light">
										<div class="row">
											<div class="col-md-6">
												<div class="alert alert-info">
													<h6 class="font-weight-bold">Entidades Acreditadas</h6>
													<p>Registro de las entidades que están facultadas para dictar el curso básico de economía solidaria</p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="alert alert-info">
													<h6 class="font-weight-bold">Entidades con Aval</h6>
													<p>Listado de entidades avaladas en curso básico de economía solidaria con énfasis en trabajo asociado. Es un registró de las entidades que están facultadas para dictar curso básico de economía solidaria con énfasis en trabajo asociado con el objeto de cumplir el requisito del decreto 4588 el 2006. Requisito para ser trabajo asociado.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Normatividad del trámite de la Acreditación -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingNine">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
											<span>Normatividad del trámite de la Acreditación</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
									<div class="card-body bg-light">
										<div class="row">
											<div class="col-md-6">
												<ul class="list-group">
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Resolución 221 de 2007
													</li>
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Resolución 110 de 2016
													</li>
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Resolución 332 de 2017
													</li>
												</ul>
											</div>
											<div class="col-md-6">
												<ul class="list-group">
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Circular 1 Acreditación 2008
													</li>
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Circular 001 Acreditación 2020
													</li>
													<li class="list-group-item d-flex align-items-center">
														<i class="mdi mdi-file-document text-primary mr-3"></i>Guía para entidades acreditadas
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Mesas regionales de educación solidaria -->
							<div class="card mb-2 border-0 shadow-sm">
								<div class="card-header bg-white" id="headingTen">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark d-flex justify-content-between w-100" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
											<span>Mesas regionales de educación solidaria</span>
											<i class="mdi mdi-chevron-down"></i>
										</button>
									</h5>
								</div>
								<div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion">
									<div class="card-body bg-light">
										<p>La Unidad Administrativa Especial de Organizaciones Solidarias, promoverá la realización de Mesas Regionales de Educación Solidaria, como escenarios de participación y articulación para el diseño de planes, programas y proyectos educativos para el sector solidario.</p>
										<p>Podrán participar en las Mesas Regionales de Educación Solidaria: los comités de educación de las organizaciones solidarias, los organismos de integración de las organizaciones solidarias, instituciones auxiliares de la economía solidaria, las entidades acreditadas para impartir educación solidaria, los colegios cooperativos, las instituciones de educación superior que tengan programas de economía solidaria y representantes de las entidades públicas y del sector educativo.</p>
										<p class="mb-0"><strong>Parágrafo:</strong> Las Mesas de Educación Solidaria serán convocadas por la Unidad Administrativa Especial de Organizaciones Solidarias, cuando se considere necesario.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		/* Estilos adicionales */
		.icon-circle {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 20px;
		}
		.avatar {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
		}
		/* Mejora visual para el acordeón */
		.btn-link {
			text-decoration: none;
			font-weight: 500;
			padding: 0.75rem 0;
		}
		.btn-link:hover {
			text-decoration: none;
			color: #3f51b5;
		}
		.card-header {
			padding: 0.5rem 1rem;
			border-bottom: 1px solid rgba(0, 0, 0, 0.05);
		}
		/* Animación para los iconos del acordeón */
		.collapse.show+.card-header .mdi-chevron-down {
			transform: rotate(180deg);
			transition: transform 0.3s;
		}
		.mdi-chevron-down {
			transition: transform 0.3s;
		}
		/* Hover en las filas de la tabla */
		.table-hover tbody tr:hover {
			background-color: rgba(63, 81, 181, 0.05);
		}
	</style>
	<script>
		function descargarTodosManuales() {
			const manuales = [
				'<?php echo base_url("assets/manuales/Manual_General_SIIA.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Registro.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Cursos.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Reportes.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Administrativo.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Configuracion.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Seguridad.pdf"); ?>',
				'<?php echo base_url("assets/manuales/Manual_Soporte.pdf"); ?>'
			];

			// Mostrar mensaje de descarga
			const button = event.target;
			const originalText = button.innerHTML;
			button.innerHTML = '<i class="mdi mdi-loading mdi-spin mr-2"></i>Descargando...';
			button.disabled = true;

			// Descargar cada manual con un pequeño delay
			manuales.forEach((url, index) => {
				setTimeout(() => {
					const link = document.createElement('a');
					link.href = url;
					link.target = '_blank';
					link.download = '';
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);

					// Restaurar botón cuando termine
					if (index === manuales.length - 1) {
						setTimeout(() => {
							button.innerHTML = originalText;
							button.disabled = false;
						}, 1000);
					}
				}, index * 500);
			});
		}
		// Script para mejorar la interacción con el acordeón
		$(document).ready(function() {
			// Función para rotar el icono cuando se abre/cierra el acordeón
			$('.btn-link').on('click', function() {
				var icon = $(this).find('.mdi-chevron-down');
				if ($(this).attr('aria-expanded') === 'true') {
					icon.css('transform', 'rotate(0deg)');
				} else {
					icon.css('transform', 'rotate(180deg)');
				}
			});
		});
	</script>
