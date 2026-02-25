<!-- Formulario de creación de solicitud -->
<div class="col-lg-12 grid-margin stretch-card" id="formCrearSolicitud" style="display: none;">
	<div class="card shadow-sm">
		<div class="card-body">
			<h4 class="card-title text-primary mb-4"><i class="mdi mdi-file mr-2"></i>Crear solicitud</h4>
			<p class="card-description">Marca el motivo y la modalidad de la <span class="badge badge-primary">solicitud</span></p>
			<div class="container">
				<?php echo form_open('', array('id' => 'formulario_crear_solicitud')); ?>
				<hr />
				<!-- Motivo de la solicitud -->
				<h5 class="mb-3">
					<i class="mdi mdi-checkbox-marked-circle text-info mr-2"></i>Motivo de la solicitud <span class="text-danger">*</span>
					<i data-toggle="modal" data-target="#ayudaProgramaSeas" class="mdi mdi-help-circle text-info pull-right" aria-hidden="true" style="cursor: pointer;" title="Ayuda sobre programa SEAS"></i>
				</h5>

				<!-- CheckBox motivos de la solicitud -->
				<div class="form-group">
					<div class="row">
						<!-- <div class="col-md-6">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="cursoBasico">
											<input class="form-check-input" type="checkbox" value="1" id="cursoBasico" name="motivos" checked>
											Acreditación Curso Básico de Economía Solidaria
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="avalTrabajo">
											<input class="form-check-input" type="checkbox" value="2" id="avalTrabajo" name="motivos">
											Aval de Trabajo Asociado
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="cursoMedio">
											<input class="form-check-input" type="checkbox" value="3" id="cursoMedio" name="motivos">
											Acreditación Curso Medio de Economía Solidaria
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="cursoAvanzado">
											<input class="form-check-input" type="checkbox" value="4" id="cursoAvanzado" name="motivos">
											Acreditación Curso Avanzado de Economía Solidaria
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="finacieraEconomia">
											<input class="form-check-input" type="checkbox" value="5" id="finacieraEconomia" name="motivos">
											Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria
										</label>
									</div>
								</div>
							</div>
						</div> -->
						<div class="col-md-12">
							<div class="card mb-3 border">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="SEAS">
											<input class="form-check-input" type="checkbox" value="6" id="SEAS" name="motivos" checked>
											Programa organizaciones y redes SEAS.
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr />
				<!-- Modalidad de la solicitud -->
				<h5 class="mb-3">
					<i class="mdi mdi-laptop mr-2 text-primary"></i>Modalidad <span class="text-danger">*</span>
					<i data-toggle="modal" data-target="#ayudaModalidad" class="mdi mdi-help-circle text-info pull-right" aria-hidden="true" style="cursor: pointer;" title="Ayuda sobre modalidades"></i>
				</h5>
				<!-- CheckBox modalidades de la solicitud -->
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<div class="card mb-3 border shadow-sm">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="presencial">
											<input class="form-check-input" type="checkbox" value="1" id="presencial" name="modalidades"  checked disabled>
											Presencial
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border shadow-sm">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="virtual">
											<input class="form-check-input" type="checkbox" value="2" id="virtualCheck" name="modalidades" checked disabled>
											Virtual
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border shadow-sm">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="aDistancia">
											<input class="form-check-input" type="checkbox" value="3" id="aDistancia" name="modalidades" checked disabled>
											A Distancia
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card mb-3 border shadow-sm">
								<div class="card-body p-3">
									<div class="form-check form-check-flat form-check-primary">
										<label class="form-check-label" for="hibrida">
											<input class="form-check-input" type="checkbox" value="4" id="hibridaCheck" name="modalidades" checked disabled>
											Hibrida
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr />
				<br>
				<?= form_close(); ?>
				<!-- Botones crear y volver -->
				<div class="text-center">
					<button class="btn btn-success mr-2" id="guardar_formulario_tipoSolicitud">
						<i class="mdi mdi-check"></i> Crear solicitud
					</button>
					<button class="btn btn-secondary volverSolicitudes">
						<i class="mdi mdi-arrow-left"></i> Volver a solicitudes
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Ayuda Programa SEAS -->
<div class="modal fade" id="ayudaProgramaSeas" tabindex="-1" role="dialog" aria-labelledby="ayudaProgramaSeas">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información sobre Programa Organizaciones y Redes SEAS</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="color: white">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>Programa Organizaciones y Redes</strong></h5>
							<p>ARTÍCULO 1° OBJETO. La presente Resolución tiene por objeto, actualizar la reglamentación
								del trámite de acreditación que otorga la Unidad Administrativa Especial de Organizaciones
								Solidarias, a partir del Sistema de Educación para la Asociatividad Solidaria-SEAS y de su
								Programa Organizaciones y Redes</p>
							<div class="text-center mt-3">
								<a href="<?= base_url("assets/docs/resolucion_078.pdf"); ?>" class="btn btn-sm btn-danger mr-2" download>
									<i class="mdi mdi-file-pdf-box mr-1"></i> Descargar Resolución 078 de 2025(PDF)
								</a>
								<a href="<?= base_url("assets/docs/anexo_resolucion_078_.docx"); ?>" class="btn btn-sm btn-info" download>
									<i class="mdi mdi-file-word mr-1"></i> Descargar Anexo Técnico (Word)
								</a>
							</div>
						</div>
					</div>
					<!-- Malla SEAS -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="mdi mdi-view-grid mr-2"></i>Malla Curricular SEAS</h5>
							</div>
							<div class="card-body">
								<div class="text-center">
									<img src="<?= base_url("assets/img/malla_seas.jpg"); ?>" alt="Malla Curricular SEAS" class="img-fluid">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					<i class="fa fa-check mr-1"></i> Entendido
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Ayuda Modalidad -->
<div class="modal fade" id="ayudaModalidad" tabindex="-1" role="dialog" aria-labelledby="ayudaModalidad">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-comment-question-outline mr-2"></i>Información sobre modalidades</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="color: white">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>MODALIDADES DE FORMACIÓN</strong></h5>
							<p>Las organizaciones tienen la flexibilidad de elegir entre diferentes modalidades para impartir el programa de organizaciones y redes, adaptándose a sus necesidades específicas y a las características de su comunidad educativa. Cada modalidad ofrece diferentes ventajas en términos de accesibilidad, interacción y metodología de enseñanza-aprendizaje.</p>
							<p>A continuación se describen las diferentes modalidades disponibles para la implementación del programa:</p>
						</div>
					</div>
					<!-- Modalidad Presencial -->
					<div class="col-md-6">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-users mr-2"></i>Presencial</h5>
							</div>
							<div class="card-body">
								<p>
									<strong>15.1. Educación en modalidad presencial:</strong> Es la modalidad en la que la comunidad
									participante asiste regularmente a un espacio físico, en donde desarrollan su proceso de aprendizaje en un contexto grupal y/o individual y en interacción sincrónica con profesores, compañeros y recursos educativos de diversa índole, complementado en tiempo y espacio, con el trabajo autónomo que desarrollan.
								</p>
								<p>
									Para certificar la modalidad presencial del programa se deberá realizar el 100% de los encuentros y del desarrollo de contenidos de manera presencial.
								</p>

							</div>
						</div>
					</div>
					<!-- Modalidad Virtual -->
					<div class="col-md-6">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-desktop mr-2"></i>Virtual</h5>
							</div>
							<div class="card-body">
								<p>
									<strong>15.2. Educación en modalidad virtual:</strong> Es la modalidad en la que la interacción entre los
									actores y los recursos educativos (sesiones de clase, materiales de apoyo, actividades, evaluaciones, etc.)
									se da en el ciberespacio y no en un lugar físico y la temporalidad de la interacción puede ser síncrona o asíncrona.
									El proceso educative se desarrolla a través de una plataforma educativa que garantice un Ambiente Virtual de Aprendizaje (AVA),
									permitiendo el acceso a sesiones de clase, materiales de apoyo, actividades y evaluaciones. Además, deberá incorporar Objetos
									Virtuales de Aprendizaje (OVAs) que faciliten la adquisición de conocimientos de manera autónoma e interactiva.
								</p>
								<p>
									Para certificar la modalidad virtual del programa se deberá realizar el 100% de los encuentros y del desarrollo de contenidos de manera virtual a través de una plataforma educativa.
								</p>
							</div>
						</div>
					</div>
					<!-- Modalidad A Distancia -->
					<div class="col-md-6">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-video-camera mr-2"></i>A Distancia</h5>
							</div>
							<div class="card-body">
								<p>
									<strong>15.3. Educación en modalidad a distancia:</strong> Conforme a Io dispuesto en la Resolución No 15177 de 2022 Ministerio de Educación Nacional
									esta modalidad implica encuentros simultáneos desarrollados en espacios físicos, así como en espacios virtuales mediados por herramientas y Tecnologías
									de la Información y las Comunicaciones (TIC), además de actividades no simultaneas de carácter autónomo que no necesariamente correspondan a herramientas
									tecnológicas. (...). Se deberá garantizar el acceso a materiales de estudio y actividades formativas que permitan a los participantes desarrollar su
									aprendizaje de manera autónoma, con apoyo de herramientas tecnológicas y estrategias de acompañamiento. Esta modalidad deberá ofrecer tutorías periódicas,
									ya sean presenciales o virtuales, así como mecanismos de seguimiento y evaluación que aseguren el cumplimiento de los objetivos formativos.
								</p>
								<p>
									Para certificar la modalidad a distancia del programa se deberá realizar el 20% de los encuentros de forma presencial y 80 % a distancia.
								</p>
							</div>
						</div>
					</div>
					<!-- Modalidad Hibrida -->
					<div class="col-md-6">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa-brands fa-teamspeak mr-2"></i>Hibrida</h5>
							</div>
							<div class="card-body">
								<p>
									<strong>5.4. Educación en modalidad hibrida:</strong> Es la modalidad que identifica la combination de
									diferentes modalidades de enseñanza, tales como la presencial, a distancia o dual, con la
									modalidad virtual. Este enfoque pedagógico se basa en el uso de tecnologías educativas
									conectadas a internet, Io que permite una enseñanza mixta que puede ser síncrona (en tiempo
									real), asíncrona (no simultánea) o no presencial. El proceso educative combina actividades
									presenciales con el uso de herramientas digitales. La mediation tecnológica debe incluir
									plataformas de comunicación, chats, foros, webinars entre otros.
									y grupos de discusión, con encuentros sincrónicos y asincrónicos, asegurando la integración
									efectiva entre los espacios de aprendizaje presencial y virtual.
								</p>
								<p>
									Para certificar la modalidad hibrida del programa se debera realizar el 50% de los encuentros
									de forma presencial y 50 % a distancia.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					<i class="fa fa-check mr-1"></i> Entendido
				</button>
			</div>
		</div>
	</div>
</div>

