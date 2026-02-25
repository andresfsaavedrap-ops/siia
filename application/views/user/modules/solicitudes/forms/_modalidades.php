<?php
/***
 * @var $organizacion
 * @var $datosModalidades
 * @var $solicitud
 * @var $nivel
 */

/*echo '<pre>';
var_dump($datosModalidades);
echo '</pre>';
return null;*/

$modalidadesMarcadas = [];
if (isset($datosModalidades) && is_array($datosModalidades)) {
	foreach ($datosModalidades as $modalidad) {
		$modalidadesMarcadas[] = $modalidad->nombreModalidad;
	}
}
?>
<!-- Formulario modalidades nueva resolución -->
<div id="modalidades" data-form="4" class="formulario_panel">
	<h3 class="card-header mb-0"><i class="fa fa-server mr-2" aria-hidden="true"></i> 6. Modalidades</h3>
	<div class="card-body">
		<?php if (count($datosModalidades) != 4): ?>
			<div class="alert alert-info mb-4">
				<p class="mb-2">
					De clic en <strong>Ver Detalles</strong> por cada modalidad, lea y acepte para continuar.
				</p>
				<p class="mb-0 font-weight-bold">
					<i class="fa fa-exclamation-circle mr-1" aria-hidden="true"></i> Recuerde que al aceptar cada modalidad se registrará automáticamente el compromiso y este quedará en nuestra base de datos.
				</p>
			</div>
			<!-- Grupo de check con los diferentes cursos -->
			<div class="container-fluid mb-2">
				<div class="row">
					<div class="col-12">
						<div class="card shadow-sm">
							<div class="card-header bg-light">
								<h5 class="mb-0"><i class="fa fa-check-circle mr-2" aria-hidden="true"></i>
									Seleccione las Modalidades de Formación</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<!-- Check Modalidad Presencial -->
									<div class="col-md-6 col-lg-6 mb-3">
										<div class="card h-100 border-primary hover-shadow-lg">
											<div class="card-header bg-primary text-white text-center py-2">
												<h6 class="mb-0"><i class="fa fa-users text-white mr-2"></i>Presencial</h6>
											</div>
											<div class="card-body d-flex flex-column align-items-center justify-content-between">
												<div class="text-center mb-3">
													<i class="fa fa-chalkboard-teacher fa-3x text-primary mb-2"></i>
													<p class="small text-muted mb-0">Encuentros en espacios físicos</p>
												</div>
												<div class="custom-control custom-checkbox" id="modalidad_presencial">
													<input type="checkbox" class="custom-control-input" id="check_modalidad_presencial" form="formulario_modalidades" name="modalidad_presencial" value="* Modalidad Presencial" disabled <?= in_array('Presencial', $modalidadesMarcadas) ? 'checked' : ''; ?>>
													<label class="custom-control-label" for="check_modalidad_presencial"></label>
												</div>
											</div>
											<div class="card-footer bg-light text-center p-2">
												<a href="#" class="btn btn-sm btn-outline-primary w-100" data-toggle="modal" data-target="#modalModalidadPresencial" data-backdrop="static" data-keyboard="false">
													Ver detalles
												</a>
											</div>
										</div>
									</div>
									<!-- Check Modalidad Virtual -->
									<div class="col-md-6 col-lg-6 mb-3">
										<div class="card h-100 border-info hover-shadow-lg">
											<div class="card-header bg-info text-white text-center py-2">
												<h6 class="mb-0"><i class="fa fa-laptop mr-2"></i>Virtual</h6>
											</div>
											<div class="card-body d-flex flex-column align-items-center justify-content-between">
												<div class="text-center mb-3">
													<i class="fa fa-video fa-3x text-info mb-2"></i>
													<p class="small text-muted mb-0">Videoconferencias sincrónicas</p>
												</div>
												<div class="custom-control custom-checkbox" id="modalidad_virtual">
													<input type="checkbox" class="custom-control-input" id="check_modalidad_virtual" form="formulario_modalidades" name="modalidad_virtual" value="* Modalidad Presencial Virtual" disabled <?= in_array('Virtual', $modalidadesMarcadas) ? 'checked' : ''; ?>>
													<label class="custom-control-label" for="check_modalidad_virtual"></label>
												</div>
											</div>
											<div class="card-footer bg-light text-center p-2">
												<a href="#" class="btn btn-sm btn-outline-info w-100" data-toggle="modal" data-target="#modalModalidadVirtual" data-backdrop="static" data-keyboard="false">
													Ver detalles
												</a>
											</div>
										</div>
									</div>
									<!-- Check Modalidad A Distancia -->
									<div class="col-md-6 col-lg-6 mb-3">
										<div class="card h-100 border-success hover-shadow-lg">
											<div class="card-header bg-success text-white text-center py-2">
												<h6 class="mb-0"><i class="fa fa-book mr-2"></i>A Distancia</h6>
											</div>
											<div class="card-body d-flex flex-column align-items-center justify-content-between">
												<div class="text-center mb-3">
													<i class="fa fa-tasks fa-3x text-success mb-2"></i>
													<p class="small text-muted mb-0">Aprendizaje autónomo asincrónico</p>
												</div>
												<div class="custom-control custom-checkbox" id="modalidad_distancia">
													<input type="checkbox" class="custom-control-input" id="check_modalidad_distancia" form="formulario_modalidades" name="modalidad_distancia" value="* Modalidad A Distancia" disabled <?= in_array('A Distancia', $modalidadesMarcadas) ? 'checked' : ''; ?>>
													<label class="custom-control-label" for="check_modalidad_distancia"></label>
												</div>
											</div>
											<div class="card-footer bg-light text-center p-2">
												<a href="#" class="btn btn-sm btn-outline-success w-100" data-toggle="modal" data-target="#modalModalidadDistancia" data-backdrop="static" data-keyboard="false">
													Ver detalles
												</a>
											</div>
										</div>
									</div>
									<!-- Check Modalidad Híbrida -->
									<div class="col-md-6 col-lg-6 mb-3">
										<div class="card h-100 border-warning hover-shadow-lg">
											<div class="card-header bg-warning text-dark text-center py-2">
												<h6 class="mb-0"><i class="fa fa-exchange-alt mr-2"></i>Híbrida</h6>
											</div>
											<div class="card-body d-flex flex-column align-items-center justify-content-between">
												<div class="text-center mb-3">
													<i class="fa fa-sync fa-3x text-warning mb-2"></i>
													<p class="small text-muted mb-0">Combinación de modalidades</p>
												</div>
												<div class="custom-control custom-checkbox" id="modalidad_hibrida">
													<input type="checkbox" class="custom-control-input" id="check_modalidad_hibrida" form="formulario_modalidades" name="modalidad_hibrida" value="* Modalidad Híbrida" disabled <?= in_array('Híbrida', $modalidadesMarcadas) ? 'checked' : ''; ?>>
													<label class="custom-control-label" for="check_modalidad_hibrida"></label>
												</div>
											</div>
											<div class="card-footer bg-light text-center p-2">
												<a href="#" class="btn btn-sm btn-outline-warning w-100" data-toggle="modal" data-target="#modalModalidadHibrida" data-backdrop="static" data-keyboard="false">
													Ver detalles
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Campo oculto con ID de la organización -->
			<input type="hidden" name="id_organizacion" id="id_organizacion" value="<?php echo $solicitud->organizaciones_id_organizacion; ?>">
		<?php endif; ?>
		<?php if (count($datosModalidades) == 4): ?>
			<div class="alert alert-success border-left border-success border-4">
				<div class="d-flex">
					<i class="fa fa-check-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
				</div>
			</div>
		<?php endif; ?>
		<!-- Tabla programas aceptados -->
		<?php if ($datosModalidades): ?>
			<div class="card shadow-sm mt-4">
				<div class="card-header bg-light d-flex justify-content-between align-items-center">
					<h5 class="mb-0"><i class="fa fa-table mr-2" aria-hidden="true"></i> Datos Modalidades Aceptadas</h5>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0">
							<thead class="thead-light">
							<tr>
								<th>Nombre Modalidad</th>
								<th>Acepta</th>
								<th>Fecha</th>
								<th>Acción</th>
							</tr>
							</thead>
							<tbody id="tbody">
							<?php
							foreach ($datosModalidades as $data) {
								echo "<tr>";
								echo "<td>" . $data->nombreModalidad . "</td>";
								echo "<td>";
								if($data->aceptarModalidad == "Si Acepta") {
									echo "<span class='badge badge-success'>" . $data->aceptarModalidad . "</span>";
								} else {
									echo "<span class='badge badge-secondary'>" . $data->aceptarModalidad . "</span>";
								}
								echo "</td>";
								echo "<td>" . $data->fecha . "</td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-outline-danger btn-sm eliminarDatosModalidad' data-id=" . $data->id . "><i class='fa-solid fa-trash mr-2'></i> Eliminar</button></td>";
								else:
									echo "<td>-</td>";
								endif;
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<!-- Formulario de programas de educación en economía solidaria - FIN -->
<!-- Modal Modalidad Presencial -->
<div class="modal fade" id="modalModalidadPresencial" tabindex="-1" role="dialog" aria-labelledby="modalModalidadPresencial">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información Modalidad Presencial</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white" ">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="header_politicas" class="col-md-12 text-center bg-light mb-3">
					<img alt="logo" id="imagen_header_politicas" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>
				<!-- Contenido modalidad -->
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>MODALIDADES DE FORMACIÓN</strong></h5>
							<p>Las organizaciones tienen la flexibilidad de elegir entre diferentes modalidades para impartir el programa de organizaciones y redes, adaptándose a sus necesidades específicas y a las características de su comunidad educativa. Cada modalidad ofrece diferentes ventajas en términos de accesibilidad, interacción y metodología de enseñanza-aprendizaje.</p>
							<p>A continuación se describen las diferentes modalidades disponibles para la implementación del programa:</p>
						</div>
					</div>
					<!-- Modalidad Presencial -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-users mr-2 text-white"></i>Presencial</h5>
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
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="aceptar_modalidad_presencial" data-modalidad="Presencial" data-modal="modalModalidadPresencial" data-check="check_modalidad_presencial" data-id="<?= $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Modalidad Virtual -->
<div class="modal fade" id="modalModalidadVirtual" tabindex="-1" role="dialog" aria-labelledby="modalModalidadVirtual">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información Modalidad Virtual</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white" ">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="header_politicas" class="col-md-12 text-center bg-light mb-3">
					<img alt="logo" id="imagen_header_politicas" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>
				<!-- Contenido modalidad -->
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>MODALIDADES DE FORMACIÓN</strong></h5>
							<p>Las organizaciones tienen la flexibilidad de elegir entre diferentes modalidades para impartir el programa de organizaciones y redes, adaptándose a sus necesidades específicas y a las características de su comunidad educativa. Cada modalidad ofrece diferentes ventajas en términos de accesibilidad, interacción y metodología de enseñanza-aprendizaje.</p>
							<p>A continuación se describen las diferentes modalidades disponibles para la implementación del programa:</p>
						</div>
					</div>
					<!-- Modalidad Virtual -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-laptop mr-2 text-white"></i>Virtual</h5>
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
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="aceptar_modalidad_virtual" data-modalidad="Virtual" data-modal="modalModalidadVirtual" data-check="check_modalidad_virtual" data-id="<?= $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Modalidad A Distancia -->
<div class="modal fade" id="modalModalidadDistancia" tabindex="-1" role="dialog" aria-labelledby="modalModalidadDistancia">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información Modalidad A Distancia</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white" ">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="header_politicas" class="col-md-12 text-center bg-light mb-3">
					<img alt="logo" id="imagen_header_politicas" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>
				<!-- Contenido modalidad -->
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>MODALIDADES DE FORMACIÓN</strong></h5>
							<p>Las organizaciones tienen la flexibilidad de elegir entre diferentes modalidades para impartir el programa de organizaciones y redes, adaptándose a sus necesidades específicas y a las características de su comunidad educativa. Cada modalidad ofrece diferentes ventajas en términos de accesibilidad, interacción y metodología de enseñanza-aprendizaje.</p>
							<p>A continuación se describen las diferentes modalidades disponibles para la implementación del programa:</p>
						</div>
					</div>
					<!-- Modalidad A Distancia -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-book mr-2 text-white"></i>A Distancia</h5>
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
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="aceptar_modalidad_distancia" data-modalidad="A Distancia" data-modal="modalModalidadDistancia" data-check="check_modalidad_distancia" data-id="<?= $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Modalidad Híbrida -->
<div class="modal fade" id="modalModalidadHibrida" tabindex="-1" role="dialog" aria-labelledby="modalModalidadHibrida">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información Modalidad Híbrida</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white" ">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="header_politicas" class="col-md-12 text-center bg-light mb-3">
					<img alt="logo" id="imagen_header_politicas" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>
				<!-- Contenido modalidad -->
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>MODALIDADES DE FORMACIÓN</strong></h5>
							<p>Las organizaciones tienen la flexibilidad de elegir entre diferentes modalidades para impartir el programa de organizaciones y redes, adaptándose a sus necesidades específicas y a las características de su comunidad educativa. Cada modalidad ofrece diferentes ventajas en términos de accesibilidad, interacción y metodología de enseñanza-aprendizaje.</p>
							<p>A continuación se describen las diferentes modalidades disponibles para la implementación del programa:</p>
						</div>
					</div>
					<!-- Modalidad Híbrida -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="fa fa-exchange mr-2 text-white"></i>Híbrida</h5>
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
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="aceptar_modalidad_hibrida" data-modalidad="Híbrida" data-modal="modalModalidadHibrida" data-check="check_modalidad_hibrida" data-id="<?= $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_6.js?v=1.2.1') . time() ?>" type="module"></script>
