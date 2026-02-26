<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $departamentos
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!-- Formulario de información general de la entidad 1 -->
<div id="informacion_general_entidad" data-form="1" class=" formulario_panel">
	<?php echo form_open('', array('id' => 'formulario_informacion_general_entidad', 'class' => 'needs-validation')); ?>
		<h3 class="card-header">
			<i class="fa-solid fa-circle-info mr-2"></i>
			1. Información General de la Entidad
		</h3>
		<div class="card-body">
			<div class="alert alert-info font-weight-500">
				<i class="fa fa-info-circle mr-2"></i> Usted debe llenar todos y cada uno de los campos requeridos y posteriormente presionar el botón Guardar y Continuar. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
			</div>
			<div class="row">
				<!-- Primera columna -->
				<div class="col-md-4">
					<div class="card-header bg-light">
						<h5 class="mb-0">1.1. Información General</h5>
					</div>
					<div class="card-body">
						<!-- Nombre organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="nombre_organizacion">Nombre de la Organización:<span class="text-danger">*</span></label>
							<input type="text" class="form-control" value="<?php echo $organizacion->nombreOrganizacion; ?>" disabled>
						</div>
						<!-- Sigla -->
						<div class="form-group">
							<label class="font-weight-bold" for="sigla">Sigla:<span class="text-danger">*</span></label>
							<input type="text" class="form-control" value="<?php echo $organizacion->sigla; ?>" disabled>
						</div>
						<!-- NIT organización -->
						<div class="form-group">
							<label class="font-weight-bold">NIT organización:<span class="text-danger">*</span></label>
							<input type="text" class="form-control" disabled value="<?php echo $organizacion->numNIT; ?>">
						</div>
						<!-- Tipo organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="tipo_organizacion">Tipo de Organización:<span class="text-danger">*</span></label>
							<select name="tipo_organizacion" id="tipo_organizacion" class="selectpicker form-control show-tick" required>
								<optgroup label="Actual">
									<option id="0" value="<?php echo $informacionGeneral->tipoOrganizacion; ?>" selected><?php echo $informacionGeneral->tipoOrganizacion; ?></option>
								</optgroup>
								<optgroup label="Actualizar">
									<option id="1" value="Asociación">Asociación</option>
									<option id="2" value="Asociación Mutual">Asociación Mutual</option>
									<option id="4" value="Cooperativa">Cooperativa</option>
									<option id="5" value="Cooperativa de Trabajo Asociado">Cooperativa de Trabajo Asociado</option>
									<option id="6" value="Cooperativa Especializada">Cooperativa Especializada</option>
									<option id="7" value="Cooperativa Integral">Cooperativa Integral</option>
									<option id="8" value="Cooperativa Multiactiva">Cooperativa Multiactiva</option>
									<option id="9" value="Cooperativa de Ahorro y Credito">Cooperativa de Ahorro y Credito</option>
									<option id="10" value="Corporación">Corporación</option>
									<option id="11" value="Empresa asociativa de trabajo">Empresa asociativa de trabajo</option>
									<option id="12" value="Empresa Comunitaria">Empresa Comunitaria</option>
									<option id="13" value="Empresa de servicios en forma de administración pública">Empresa de servicios en forma de administración pública</option>
									<option id="14" value="Empresa Solidaria de Salud">Empresa Solidaria de Salud</option>
									<option id="15" value="Federación y Confederación">Federación y Confederación</option>
									<option id="16" value="Fondo de empleados">Fondo de empleados</option>
									<option id="17" value="Fundación">Fundación</option>
									<option id="18" value="Institución Universitaria">Institución Universitaria</option>
									<option id="19" value="Instituciones auxiliares de Economía Solidaria">Instituciones auxiliares de Economía Solidaria</option>
									<option id="20" value="Precooperativa">Precooperativa</option>
								</optgroup>
							</select>
						</div>
						<!-- Departamento organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="departamentos">Departamento:<span class="text-danger">*</span></label>
							<select name="departamentos" id="departamentos" data-id-dep="1" class="selectpicker form-control show-tick departamentos" required="">
								<optgroup label="Actual">
									<option id="0" value="<?php echo $informacionGeneral->nomDepartamentoUbicacion; ?>" selected><?php echo $informacionGeneral->nomDepartamentoUbicacion; ?></option>
								</optgroup>
								<optgroup label="Actualizar">
									<?php foreach ($departamentos as $departamento) { ?>
										<option id="<?php echo $departamento->id_departamento; ?>" value="<?php echo $departamento->nombre; ?>"><?php echo $departamento->nombre; ?></option>
									<?php } ?>
								</optgroup>
							</select>
						</div>
						<!-- Municipio organización -->
						<div class="form-group">
							<div id="div_municipios">
								<label class="font-weight-bold" for="municipios">Municipio:<span class="text-danger">*</span></label>
								<select name="municipios" id="municipios" class="selectpicker form-control show-tick municipios" required>
									<optgroup label="Actual">
										<option id="0" value="<?php echo $informacionGeneral->nomMunicipioNacional; ?>" selected><?php echo $informacionGeneral->nomMunicipioNacional; ?></option>
									</optgroup>
									<optgroup label="Actualizar">
										<?php foreach ($municipios as $municipio) { ?>
											<option id="<?php echo $municipio->id_municipio; ?>" value="<?php echo $municipio->nombre; ?>"><?php echo $municipio->nombre; ?></option>
										<?php } ?>
									</optgroup>
								</select>
							</div>
						</div>
						<!-- Dirección organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="direccion">Dirección:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-map-marker"></i></span>
								</div>
								<input type="text" class="form-control" name="direccion" id="direccion" required="" placeholder="Dirección" value="<?php echo $informacionGeneral->direccionOrganizacion; ?>">
							</div>
						</div>
						<!-- Teléfono organización -->
						<div class="form-group">
							<label class="font-weight-bold">Teléfono de Contacto:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-phone"></i></span>
								</div>
								<input type="number" name="fax" id="fax" class="form-control" required placeholder="Teléfono" ondrop="return false;" onpaste="return false;" value="<?php echo $informacionGeneral->fax; ?>">
							</div>
						</div>
						<!-- Extensión teléfono organización -->
						<div class="custom-control custom-checkbox mb-2">
							<input type="checkbox" class="custom-control-input" name="extension_checkbox" id="extension_checkbox">
							<label class="custom-control-label" for="extension_checkbox">¿Tiene Extensión?</label>
						</div>
						<div class="form-group">
							<div id="div_extension" style="display:none;">
								<label class="font-weight-bold" for="extension">Extensión:<span class="text-danger">*</span></label>
								<input type="number" name="extension" id="extension" class="form-control" placeholder="Extensión" value="<?php echo $informacionGeneral->extension; ?>">
							</div>
						</div>
						<!-- Correo electrónico organización -->
						<div class="form-group">
							<label class="font-weight-bold">Correo electrónico de la organización:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-envelope"></i></span>
								</div>
								<input type="email" name="correoElectronicoOrganizacion" id="correoElectronicoOrganizacion" class="form-control" placeholder="Correo electrónico" value="<?php echo $organizacion->direccionCorreoElectronicoOrganizacion; ?>">
							</div>
						</div>
					</div>
				</div>
				<!-- Segunda columna -->
				<div class="col-md-4">
					<div class="card-header bg-light">
						<h5 class="mb-0">1.2. Información Adicional</h5>
					</div>
					<div class="card-body">
						<!-- URL organización -->
						<div class="form-group">
							<label class="font-weight-bold">Dirección Web:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-globe"></i></span>
								</div>
								<input type="text" name="urlOrganizacion" id="urlOrganizacion" placeholder="www.ejemplo.com" class="form-control" value="<?php echo $informacionGeneral->urlOrganizacion; ?>">
							</div>
						</div>

						<!-- Actuación organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="actuacion">Ámbito de Actuación:<span class="text-danger">*</span></label>
							<select name="actuacion" id="actuacion" class="selectpicker form-control show-tick" required="">
								<optgroup label="Actual">
									<option id="0" value="<?php echo $informacionGeneral->actuacionOrganizacion; ?>" selected><?php echo $informacionGeneral->actuacionOrganizacion; ?></option>
								</optgroup>
								<optgroup label="Actualizar">
									<option id="1" value="Departamental">Departamental</option>
									<option id="2" value="Municipal">Municipal</option>
									<option id="3" value="Nacional">Nacional</option>
									<option id="4" value="Regional">Regional</option>
								</optgroup>
							</select>
						</div>

						<!-- Educación organización -->
						<div class="form-group">
							<label class="font-weight-bold" for="educacion">Tipo de Educación:<span class="text-danger">*</span></label>
							<select name="educacion" id="educacion" class="selectpicker form-control show-tick" required="">
								<optgroup label="Actual">
									<option id="0" value="<?php echo $informacionGeneral->tipoEducacion; ?>" selected><?php echo $informacionGeneral->tipoEducacion; ?></option>
								</optgroup>
								<optgroup label="Actualizar">
									<option id="1" value="Educacion para el trabajo y el desarrollo humano">Educación para el trabajo y el desarrollo humano</option>
									<option id="2" value="Formal">Formal</option>
									<option id="3" value="Informal">Informal</option>
								</optgroup>
							</select>
						</div>
					</div>
					<div class="card-header bg-light">
						<h5 class="mb-0">1.3. Representante Legal</h5>
					</div>
					<div class="card-body">
						<div class="row">
							<!-- Primer nombre representante legal -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="font-weight-bold" for="primerNombreRepLegal">Primer Nombre:<span class="text-danger">*</span></label>
									<input type="text" name="primerNombreRepLegal" id="primerNombreRepLegal" class="form-control" value="<?php echo $organizacion->primerNombreRepLegal; ?>">
								</div>
							</div>
							<!-- Segundo nombre representante legal -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="font-weight-bold" for="segundoNombreRepLegal">Segundo Nombre:</label>
									<input type="text" name="segundoNombreRepLegal" id="segundoNombreRepLegal" class="form-control" value="<?php echo $organizacion->segundoNombreRepLegal; ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<!-- Primer apellido representante legal -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="font-weight-bold" for="primerApellidoRepLegal">Primer Apellido:<span class="text-danger">*</span></label>
									<input type="text" name="primerApellidoRepLegal" id="primerApellidoRepLegal" class="form-control" value="<?php echo $organizacion->primerApellidoRepLegal; ?>">
								</div>
							</div>
							<!-- Segundo apellido representante legal -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="font-weight-bold" for="segundoApellidoRepLegal">Segundo Apellido:</label>
									<input type="text" name="segundoApellidoRepLegal" id="segundoApellidoRepLegal" class="form-control" value="<?php echo $organizacion->segundoApellidoRepLegal; ?>">
								</div>
							</div>
						</div>

						<!-- Correo Electrónico del representante legal -->
						<div class="form-group">
							<label class="font-weight-bold">Correo Electrónico del Representante Legal:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-envelope"></i></span>
								</div>
								<input type="email" name="correoElectronicoRepLegal" id="correoElectronicoRepLegal" class="form-control" value="<?php echo $organizacion->direccionCorreoElectronicoRepLegal; ?>">
							</div>
						</div>

						<!-- Cédula del representante legal -->
						<div class="form-group">
							<label class="font-weight-bold" for="numCedulaCiudadaniaPersona">Número de Cédula:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-id-card"></i></span>
								</div>
								<input type="number" name="numCedulaCiudadaniaPersona" id="numCedulaCiudadaniaPersona" class="form-control" required="" value="<?php echo $informacionGeneral->numCedulaCiudadaniaPersona; ?>">
							</div>
						</div>
					</div>
				</div>
				<!-- Tercera columna -->
				<div class="col-md-4">
					<div class="card-header bg-light">
						<h5 class="mb-0">1.4. Presentación Institucional</h5>
					</div>
					<div class="card-body">
						<!-- Misión -->
						<div class="form-group">
							<label class="font-weight-bold" for="mision">Misión:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-bullseye"></i></span>
								</div>
								<textarea class="form-control" id="mision" name="mision" rows="4" placeholder="Misión..."><?php echo $informacionGeneral->mision; ?></textarea>
							</div>
						</div>
						<!-- Visión -->
						<div class="form-group">
							<label class="font-weight-bold" for="vision">Visión:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-eye"></i></span>
								</div>
								<textarea class="form-control" id="vision" name="vision" rows="4" placeholder="Visión..."><?php echo $informacionGeneral->vision; ?></textarea>
							</div>
						</div>
						<!-- Portafolio -->
						<div class="form-group">
							<label class="font-weight-bold" for="portafolio">Portafolio de Servicios:<span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-briefcase"></i></span>
								</div>
								<textarea class="form-control" id="portafolio" name="portafolio" rows="5" placeholder="Portafolio de Servicios..."><?php echo $informacionGeneral->portafolio; ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
	<!-- Cargar archivos anexos -->
	<?php if ($nivel != '7'): ?>
		<div class="card shadow-sm mb-4">
			<div class="card-header">
				<h4><i class="fa fa-paperclip mr-2"></i> Documentos Requeridos</h4>
			</div>
			<div class="card-body">
				<div class="alert alert-warning font-weight-500">
					<i class="fa fa-exclamation-triangle mr-2"></i>
					Anexar la carta de solitud firmada por representante legal y las 3 certificaciones emitidas a nombre de la entidad solicitante, recuerde adjuntar
					<strong>Solamente se admiten formatos PDF</strong>
				</div>
				<div class="row">
					<!-- Carta de solicitud -->
					<div class="col-md-6">
						<div class="card border mb-4">
							<div class="card-header bg-light">
								<h5 class="mb-0"><i class="fa-solid fa-file-pdf mr-2"></i> Carta de solicitud firmada por el representante legal <span class="badge badge-primary">PDF (1)</span></h5>
							</div>
							<div class="card-body">
								<?php echo form_open_multipart('', array('id' => 'formulario_carta', 'class' => 'upload-form')); ?>
								<div class="custom-file mb-3">
									<input type="file" required accept="application/pdf" class="custom-file-input" data-val="carta" name="carta" id="carta">
									<label class="custom-file-label" for="carta">Seleccionar archivo...</label>
								</div>
								<button type="button" class="btn btn-primary btn-block archivos_form_carta" data-name="carta" data-form="1" data-solicitud="<?php echo $solicitud->idSolicitud ?>" name="cartaRep" id="cartaRep">
									<i class="fa fa-save mr-2"></i> Guardar archivo
								</button>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<!-- Certificaciones -->
					<div class="col-md-6">
						<div class="card border mb-4">
							<div class="card-header bg-light">
								<h5 class="mb-0"><i class="fa fa-certificate mr-2"></i> Certificaciones <span class="badge badge-primary">PDF (3)</span></h5>
							</div>
							<div class="card-body">
								<?php echo form_open_multipart('', array('id' => 'formulario_certificaciones', 'class' => 'upload-form')); ?>
								<div class="custom-file mb-2">
									<input type="file" required accept="application/pdf" class="custom-file-input" data-val="certificaciones" name="certificaciones[]" id="certificaciones1">
									<label class="custom-file-label" for="certificaciones1">Certificación 1...</label>
								</div>
								<div class="custom-file mb-2">
									<input type="file" required accept="application/pdf" class="custom-file-input" data-val="certificaciones" name="certificaciones[]" id="certificaciones2">
									<label class="custom-file-label" for="certificaciones2">Certificación 2...</label>
								</div>
								<div class="custom-file mb-3">
									<input type="file" required accept="application/pdf" class="custom-file-input" data-val="certificaciones" name="certificaciones[]" id="certificaciones3">
									<label class="custom-file-label" for="certificaciones3">Certificación 3...</label>
								</div>
								<button type="button" class="btn btn-primary btn-block archivos_form_certificacion" data-name="certificaciones" data-solicitud="<?= $solicitud->idSolicitud ?>" name="certificaciones_organizacion" id="certificaciones_organizacion">
									<i class="fa fa-save mr-2"></i> Guardar archivos
								</button>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
					<?php if ($solicitud->nombre == 'En Renovación'): ?>
						<!-- Carta de autoevaluación -->
						<div class="col-md-12">
							<div class="card border mb-4">
								<div class="card-header bg-light">
									<h5 class="mb-0"><i class="fa fa-file-text-o mr-2"></i> Documento de autoevaluación cualitativa <span class="badge badge-primary">PDF (1)</span></h5>
								</div>
								<div class="card-body">
									<?php echo form_open_multipart('', array('id' => 'formulario_autoevaluacion', 'class' => 'upload-form')); ?>
									<p class="text-muted mb-3">Adjunte documento de autoevaluación cualitativa del desarrollo del curso para el que solicita renovación</p>
									<div class="custom-file mb-3">
										<input type="file" required accept="application/pdf" class="custom-file-input" data-val="autoevaluacion" name="autoevaluacion" id="autoevaluacion">
										<label class="custom-file-label" for="autoevaluacion">Seleccionar archivo...</label>
									</div>
									<button type="button" class="btn btn-primary btn-block archivos_form_autoevaluacion" data-name="autoevaluacion" data-form="1" data-solicitud="<?php echo $solicitud->idSolicitud ?>" name="autoevaluacion" id="autoevaluacion">
										<i class="fa fa-save mr-2"></i> Guardar archivo
									</button>
									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<!-- Tabla de archivos anexados -->
	<div class="card shadow-sm">
		<div class="card-header bg-light d-flex justify-content-between align-items-center">
			<h5 class="mb-0"><i class="fa fa-file mr-2" aria-hidden="true"></i></i> Archivos Anexados</h5>
			<button class="btn btn-sm btn-outline-primary dataReload">
				<i class="fa fa-refresh mr-1"></i> Recargar
			</button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="tabla_archivos_formulario" class="table table-striped table-hover tabla_form">
					<thead class="thead-light">
					<tr>
						<th width="40%">Nombre</th>
						<th width="30%">Tipo</th>
						<th width="30%">Acción</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<!-- Los datos se cargarán dinámicamente -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Guardar formulario 1 -->
	<div class="text-center col-12">
		<button type="button" class="btn btn-success btn-md col-12" name="guardar_formulario_informacion_general_entidad" id="guardar_formulario_informacion_general_entidad">
			<i class="fa fa-save mr-2"></i> Guardar y validar formulario
		</button>
	</div>
	<!-- Botones de navegación -->
	<?php $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_1.js?v=1.2.1') . time() ?>" type="module"></script>
