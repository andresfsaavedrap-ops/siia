<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $departamentos
 * @var $solicitud
 * @var $documentacionLegal
 * @var $nivel
 * @var $informacionGeneral
 * @var $aplicacion
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!-- Formulario Datos Plataforma - VERSIÓN MEJORADA -->
<div id="datos_plataforma" data-form="6" class="formulario_panel">
	<h3 class="card-header mb-0"><i class="fa fa-globe mr-2" aria-hidden="true"></i> 6. Datos modalidad virtual</h3>
	<?php if (!$aplicacion): ?>
	<div class="card-body">
		<div class="alert alert-info" role="alert">
			<i class="fa fa-info-circle mr-2"></i> Relacione los datos para ingresar a la plataforma y verificar su funcionamiento.
		</div>
		<?php echo form_open('', array('id' => 'formulario_modalidad_virtual', 'class' => 'needs-validation')); ?>
		<!-- URL Plataforma -->
		<div class="form-group row">
			<label for="datos_plataforma_url" class="col-sm-3 col-form-label">URL:<span class="text-danger ml-1">*</span></label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-link"></i></span>
					</div>
					<input type="text" class="form-control" name="datos_plataforma_url" id="datos_plataforma_url"
						   placeholder="EJ: https://www.orgsolidarias.gov.co/" required>
					<div class="invalid-feedback">
						Por favor ingrese la URL de la plataforma
					</div>
				</div>
			</div>
		</div>
		<!-- Usuario -->
		<div class="form-group row">
			<label for="datos_plataforma_usuario" class="col-sm-3 col-form-label">Usuario:<span class="text-danger ml-1">*</span></label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-user"></i></span>
					</div>
					<input type="text" class="form-control" name="datos_plataforma_usuario" id="datos_plataforma_usuario"
						   placeholder="EJ: usuario.aplicacion" required>
					<div class="invalid-feedback">
						Por favor ingrese el nombre de usuario
					</div>
				</div>
			</div>
		</div>
		<!-- Contraseña -->
		<div class="form-group row">
			<label for="datos_plataforma_contrasena" class="col-sm-3 col-form-label">Contraseña:<span class="text-danger ml-1">*</span></label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-lock"></i></span>
					</div>
					<input type="password" class="form-control" name="datos_plataforma_contrasena" id="datos_plataforma_contrasena"
						   placeholder="EJ: contraseña123@" required>
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="togglePassword">
							<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
					</div>
					<div class="invalid-feedback">
						Por favor ingrese la contraseña
					</div>
				</div>
			</div>
		</div>
		<!-- Check Aceptar Modalidad Virtual -->
		<div class="form-group row mt-4">
			<div class="col-sm-12">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="acepta_mod_en_virtual" form="formulario_programas"
						   name="acepta_mod_en_virtual" value="Si Acepto" disabled required>
					<label class="custom-control-label" for="acepta_mod_en_virtual">
						<a href="#" data-toggle="modal" data-target="#modalAceptarVirtual" data-backdrop="static" data-keyboard="false" class="text-primary">
							<span class="text-danger">*</span>¿Acepta modalidad virtual?
						</a>
					</label>
				</div>
			</div>
		</div>
		<hr class="my-4" />
		<div class="form-group">
			<button class="btn btn-primary btn-md btn-block" name="guardar_formulario_plataforma" id="guardar_formulario_plataforma"
					data-id="<?php echo $solicitud->idSolicitud; ?>">
				<i class="fa fa fa-save mr-2" aria-hidden="true"></i> Guardar datos
			</button>
		</div>
		<?php echo form_close(); ?>
	</div>
	<?php endif; ?>
	<?php if ($aplicacion): ?>
		<div class="card mt-4 shadow-sm">
			<div class="alert alert-success border-left border-success border-4">
				<div class="d-flex">
					<i class="fa fa-check-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
				</div>
			</div>
			<h5 class="card-header mb-0"><i class="fa fa-server mr-2"></i> Plataforma registrada</h5>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead class="thead-light">
						<tr>
							<th>URL aplicación</th>
							<th>Usuario aplicación</th>
							<th>Contraseña aplicación</th>
							<?php if ($nivel != '7'): ?>
								<th width="120">Acción</th>
							<?php endif; ?>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php for ($i = 0; $i < count($aplicacion); $i++): ?>
							<tr>
								<td><?php echo $aplicacion[$i]->urlAplicacion; ?></td>
								<td><?php echo $aplicacion[$i]->usuarioAplicacion; ?></td>
								<td><?php echo $aplicacion[$i]->contrasenaAplicacion; ?></td>
								<?php if ($nivel != '7'): ?>
									<td>
										<button class="btn btn-danger btn-sm eliminarDatosPlataforma"
												data-id-datosPlataforma="<?php echo $aplicacion[$i]->id_datosAplicacion; ?>">
											<i class='fa-solid fa-trash mr-1'></i> Eliminar
										</button>
									</td>
								<?php endif; ?>
							</tr>
						<?php endfor; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<!-- Modal Aceptar Modalidad Virtual -->
<div class="modal fade" id="modalAceptarVirtual" tabindex="-1" role="dialog" aria-labelledby="modalAceptarVirtual">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title">
					<i class="fa fa-info-circle mr-2"></i> Recomendaciones Modalidad Virtual
				</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center mb-4">
					<img alt="logo" class="img-fluid" style="max-height: 80px;"
						 src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>

				<div class="alert alert-info">
					<p>De acuerdo a lo establecido en el parágrafo número 1 del artículo 6 de la resolución 152 del 23 de junio del 2022,
						las entidades que soliciten la acreditación por la modalidad en línea deben tener en cuenta lo siguiente:</p>
				</div>

				<div class="card mb-4">
					<div class="card-body">
						<p><strong>Parágrafo 1.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad virtual,
							la entidad solicitante deberá demostrar que el proceso educativo se hace en una <strong>plataforma</strong>
							(sesiones clase, materiales de apoyo, actividades, evaluaciones) que propicie un Ambiente Virtual de Aprendizaje - AVA y
							Objetos Virtuales de Aprendizaje - OVAS.</p>
					</div>
				</div>

				<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
				<p>La Unidad Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="acepto_mod_virtual">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Script formulario 6-->
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_6_antiguo.js?v=1.2.1') . time() ?>" type="module"></script>
