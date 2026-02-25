<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $departamentos
 * @var $solicitud
 * @var $documentacionLegal
 * @var $nivel
 * @var $informacionGeneral
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!-- Formulario Datos Modalidad híbrida -->
<div id="datos_en_linea" data-form="7" class="formulario_panel">
	<h3 class="card-header mb-0"><i class="fa fa-globe mr-2" aria-hidden="true"></i> 7. Datos otras modalidades </h3>
	<div class="card-body">
		<?php if (empty($datosEnLinea)): ?>
			<div class="alert alert-info" role="alert">
				<i class="fa fa-info-circle mr-2"></i> Ingrese los datos de las herramientas a utilizar en esta modalidad dentro del curso.
			</div>
			<?php echo form_open('', array('id' => 'formulario_modalidad_en_linea', 'class' => 'needs-validation')); ?>
			<!-- Nombre de la herramienta-->
			<div class="form-group row">
				<label for="nombre_herramienta" class="col-sm-3 col-form-label">Nombre de la herramienta:<span class="text-danger ml-1">*</span></label>
				<div class="col-sm-9">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-desktop"></i></span>
						</div>
						<input type="text" class="form-control" name="nombre_herramienta" id="nombre_herramienta"
							   placeholder="Ej: MSTeams, Meet, Zoom, Skype, WhatsApp, entre otros..." required>
					</div>
					<small class="form-text text-muted">Indique el nombre de la plataforma de comunicación a utilizar</small>
				</div>
			</div>
			<!-- Descripción de la herramienta-->
			<div class="form-group row">
				<label for="descripcion_herramienta" class="col-sm-3 col-form-label">Descripción de uso:<span class="text-danger ml-1">*</span></label>
				<div class="col-sm-9">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa-solid fa-file-lines"></i></span>
						</div>
						<textarea class="form-control" name="descripcion_herramienta" id="descripcion_herramienta"
								  placeholder="Registre la descripción de la utilización educativa de la herramienta en línea"
								  rows="4" required></textarea>
					</div>
					<small class="form-text text-muted">Explique cómo utilizará la herramienta para facilitar el aprendizaje</small>
				</div>
			</div>
			<!-- Check Aceptar Modalidad En Linea -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="acepta_mod_en_linea" form="formulario_programas" name="acepta_mod_en_linea" value="Si Acepto" required>
						<label class="custom-control-label" for="acepta_mod_en_linea">
							<a href="#" data-toggle="modal" data-target="#modalAceptarEnLinea" data-backdrop="static" data-keyboard="false">
								<span class="text-danger">*</span> ¿Acepta modalidad en línea?
							</a>
						</label>
					</div>
				</div>
			</div>
			<hr class="my-4">
			<!-- Botón para guardar datos -->
			<div class="form-group row">
				<div class="col-sm-12">
					<button class="btn btn-primary btn-md btn-block" type="button" name="guardar_formulario_modalidad_en_linea"
							id="guardar_formulario_modalidad_en_linea" data-id="<?php echo $solicitud->idSolicitud; ?>">
						<i class="fa fa-save mr-2"></i> Guardar datos
					</button>
				</div>
			</div>
			<?php echo form_close() ?>
		</div>
		<?php endif; ?>
		<!-- Tabla herramientas -->
		<?php if (isset($datosEnLinea) && $datosEnLinea): ?>
			<div class="alert alert-success border-left border-success border-4">
				<div class="d-flex">
					<i class="fa fa-check-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
				</div>
			</div>
			<h5 class="mb-3"><i class="fa fa-list-alt mr-2"></i> Datos de herramientas registradas:</h5>
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-striped">
					<thead>
					<tr>
						<th width="20%">Herramienta</th>
						<th width="50%">Descripción</th>
						<th width="15%">Fecha de registro</th>
						<th width="15%">Acción</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php for ($i = 0; $i < count($datosEnLinea); $i++): ?>
						<tr>
							<td class="align-middle font-weight-bold"><?php echo $datosEnLinea[0]->nombreHerramienta; ?></td>
							<td>
								<div class="text-area-ext" style="width: 500px; overflow-y: auto;">
									<?php echo nl2br($datosEnLinea[0]->descripcionHerramienta); ?>
								</div>
							</td>
							<td class="align-middle text-center">
							  <span class="badge badge-info p-2">
								<i class="fa fa-calendar mr-1"></i> <?php echo $datosEnLinea[0]->fecha; ?>
							  </span>
							</td>
							<td class="align-middle text-center">
								<?php if ($nivel != '7'): ?>
									<button class="btn btn-danger btn-sm eliminarDatosEnlinea" data-id="<?php echo $datosEnLinea[0]->id; ?>">
										<i class='fa-solid fa-trash mr-1'></i> Eliminar
									</button>
								<?php else: ?>
									<span class="text-muted"><i class="fa fa-lock mr-1"></i> Sin acciones</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<!-- Botones de navegación -->
		<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
	</div>
</div>
<!-- Modal Aceptar Modalidad En Línea -->
<div class="modal fade" id="modalAceptarEnLinea" tabindex="-1" role="dialog" aria-labelledby="modalAceptarEnLineaLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<div class="row w-100">
					<div id="header_politicas" class="col-md-12 text-center mb-2">
						<img alt="logo" id="imagen_header_politicas" class="img-fluid" style="max-height: 80px;"
							 src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
					</div>
					<div class="col-md-12">
						<h5 class="modal-title" id="modalAceptarEnLineaLabel">
							<i class="fa fa-info-circle mr-2"></i> Recomendaciones Modalidad En Línea
						</h5>
					</div>
				</div>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="card border-info mb-3">
					<div class="card-body">
						<p>De acuerdo a lo establecido en el parágrafo número 2 del artículo 6 de la resolución 152 del 23 de junio del 2022, las entidades que soliciten la acreditación por la modalidad en línea, deben tener en cuenta lo siguiente:</p>

						<div class="alert alert-secondary">
							<p><strong>Parágrafo 2.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad línea, aquella donde los docentes y participantes interactúan a través de recursos tecnológicos. La mediación tecnológica puede ser a través de herramientas tecnológica (Zoom, Teams, Meet, Good Meet, entre otras) plataformas de comunicación, chats, foros, videoconferencias, grupos de discusión, caracterizadas por encuentros sincrónicos.</p>
						</div>

						<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
						<p>La Unida Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
					</div>
				</div>

				<div class="d-flex justify-content-between mt-4">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times mr-2"></i> No, declino
					</button>
					<button type="button" class="btn btn-success" id="acepto_mod_en_linea" value="Si Acepta">
						<i class="fa fa-check mr-2"></i> Sí, acepto
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_7.js?v=1.2.1') . time() ?>" type="module"></script>
