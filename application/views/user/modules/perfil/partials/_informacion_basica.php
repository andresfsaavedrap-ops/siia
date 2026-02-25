<div class="card border-0 shadow-sm mb-4">
	<div class="card-header bg-transparent">
		<h5 class="card-title mb-0">
			🏛️ Actualización de Perfil Organizacional
		</h5>
	</div>
	<div class="card-body">
		<?= form_open('', array('id' => 'formulario_actualizar_perfil', 'class' => 'form-sample')); ?>
		<!-- Título del formulario -->
		<p class="card-description text-muted mb-3">
			<i class="mdi mdi-information-outline mr-1"></i>
			Actualización de la información general de la organización. Esto es un requisito para presentar la acreditación.
		</p>
		<div class="section-header">
			<h5><i class="ti-id-badge text-primary mr-2"></i>Información Básica</h5>
			<hr class="separator-line" />
		</div>
		<!-- Organización -->
		<!-- NIT -->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Organización</label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="organizacion" id="organizacion" placeholder="Nombre Organización" value="<?= $organizacion->nombreOrganizacion; ?>" readonly>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>NIT Organización</label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="nit" id="nit" placeholder="Numero NIT" value="<?= $organizacion->numNIT; ?>" readonly>
				</div>
			</div>
		</div>
		<!-- Sigla -->
		<!-- Cédula Rep Legal -->
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Sigla</label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="sigla" id="sigla" placeholder="Sigla de la organización" value="<?= $organizacion->sigla; ?>">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Número de cédula representante legal <span class="text-danger">*</span></label>
					<input type="text" name="numCedulaCiudadaniaPersona" form="formulario_actualizar_perfil" id="numCedulaCiudadaniaPersona" placeholder="Numero de cédula..." class="form-control" required value="<?php echo $informacionGeneral->numCedulaCiudadaniaPersona; ?>">
				</div>
			</div>
		</div>
		<!-- Sección de datos del representante legal -->
		<div class="section-header mt-4">
			<h5><i class="ti-user text-primary mr-2"></i>Datos del Representante Legal</h5>
			<hr class="separator-line" />
		</div>
		<div class="row">
			<!-- 1er Nombre RL -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Primer Nombre <span class="text-danger">*</span></label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="primer_nombre_rep_legal" id="nombre" placeholder="Primer nombre representante" required value="<?= $organizacion->primerNombreRepLegal; ?>">
				</div>
			</div>
			<!-- 2do nombre RL -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Segundo Nombre</label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="segundo_nombre_rep_legal" id="nombre_s" placeholder="Segundo nombre representante" value="<?= $organizacion->segundoNombreRepLegal; ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<!-- 1er apellido RL -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Primer Apellido <span class="text-danger">*</span></label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="primer_apellido_rep_regal" id="apellido" placeholder="Primer apellido representante" required value="<?= $organizacion->primerApellidoRepLegal; ?>">
				</div>
			</div>
			<!-- 2do apellido RL -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Segundo Apellido</label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="segundo_apellido_rep_regal" id="apellido_s" placeholder="Segundo apellido representante" value="<?= $organizacion->segundoApellidoRepLegal; ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Correo electrónico representante legal -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Correo electrónico representante legal <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-email"></i></span>
						</div>
						<input type="email" class="form-control" form="formulario_actualizar_perfil" name="correo_electronico_rep_legal" id="correo_electronico_rep_legal" placeholder="Correo electrónico del representante legal" required value="<?= $organizacion->direccionCorreoElectronicoRepLegal ?>">
					</div>
				</div>
			</div>

		</div>
		<!-- Sección de clasificación -->
		<div class="section-header mt-4">
			<h5><i class="ti-tag text-primary mr-2"></i>Clasificación de la Organización</h5>
			<hr class="separator-line" />
		</div>
		<div class="row">
			<!-- Tipo de Organización-->
			<div class="col-md-6">
				<div class="form-group">
					<label>Tipo de Organización <span class="text-danger">*</span></label>
					<select name="tipo_organizacion" form="formulario_actualizar_perfil" id="tipo_organizacion" class="form-control select2" required>
						<optgroup label="Actual">
							<option id="0" value="<?php echo $informacionGeneral->tipoOrganizacion; ?>" selected><?php echo $informacionGeneral->tipoOrganizacion; ?></option>
						</optgroup>
						<optgroup label="Actualizar">
							<option id="1" value="Asociación">Asociación</option>
							<option id="2" value="Asociación Mutual">Asociación Mutual</option>
							<option id="3" value="Cooperativa de Trabajo Asociado">Cooperativa de Trabajo Asociado</option>
							<option id="4" value="Cooperativa Especializada">Cooperativa Especializada</option>
							<option id="5" value="Cooperativa Integral">Cooperativa Integral</option>
							<option id="6" value="Cooperativa Multiactiva">Cooperativa Multiactiva</option>
							<option id="7" value="Corporación">Corporación</option>
							<option id="8" value="Empresa asociativa de trabajo">Empresa asociativa de trabajo</option>
							<option id="9" value="Empresa Comunitaria">Empresa Comunitaria</option>
							<option id="10" value="Empresa de servicios en forma de administración pública">Empresa de servicios en forma de administración pública</option>
							<option id="11" value="Empresa Solidaria de Salud">Empresa Solidaria de Salud</option>
							<option id="12" value="Federación y Confederación">Federación y Confederación</option>
							<option id="13" value="Fondo de empleados">Fondo de empleados</option>
							<option id="14" value="Fundación">Fundación</option>
							<option id="15" value="Institución Universitaria">Institución Universitaria</option>
							<option id="16" value="Instituciones auxiliares de Economía Solidaria">Instituciones auxiliares de Economía Solidaria</option>
							<option id="17" value="Precooperativa">Precooperativa</option>
						</optgroup>
					</select>
				</div>
			</div>
			<!-- Ámbito -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Ámbito de Actuación de la Entidad <span class="text-danger">*</span></label>
					<select name="actuacion" form="formulario_actualizar_perfil" id="actuacion" class="form-control select2" required>
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
			</div>
		</div>
		<div class="row">
			<!-- Tipo Educación -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Tipo de Educación <span class="text-danger">*</span></label>
					<select name="educacion" form="formulario_actualizar_perfil" id="educacion" class="form-control select2" required>
						<optgroup label="Actual">
							<option id="0" value="<?php echo $informacionGeneral->tipoEducacion; ?>" selected><?php echo $informacionGeneral->tipoEducacion; ?></option>
						</optgroup>
						<optgroup label="Actualizar">
							<option id="1" value="Educación para el trabajo y el desarrollo humano">Educación para el trabajo y el desarrollo humano</option>
							<option id="2" value="Formal">Formal</option>
							<option id="3" value="Informal">Informal</option>
						</optgroup>
					</select>
				</div>
			</div>
		</div>
		<!-- Sección de información de contacto -->
		<div class="section-header mt-4">
			<h5><i class="ti-location-pin text-primary mr-2"></i>Información de Contacto</h5>
			<hr class="separator-line" />
		</div>
		<!-- Correo Electrónico -->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Correo electrónico (Notificaciones) <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-email"></i></span>
						</div>
						<input type="email" class="form-control" form="formulario_actualizar_perfil" name="correo_electronico" id="correo_electronico" placeholder="Correo electrónico de la organización" required value="<?= $organizacion->direccionCorreoElectronicoOrganizacion ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Departamento -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Departamento <span class="text-danger">*</span></label>
					<select name="departamentos" form="formulario_actualizar_perfil" id="departamentos" data-id-dep="1" class="form-control select2 departamentos" required>
						<optgroup label="Actual">
							<option id="0" value="<?php echo $informacionGeneral->nomDepartamentoUbicacion; ?>" selected><?php echo $informacionGeneral->nomDepartamentoUbicacion; ?></option>
						</optgroup>
						<optgroup label="Actualizar">
							<?php
							foreach ($departamentos as $departamento) {
							?>
								<option id="<?php echo $departamento->id_departamento; ?>" value="<?php echo $departamento->nombre; ?>"><?php echo $departamento->nombre; ?></option>
							<?php
							}
							?>
						</optgroup>
					</select>
				</div>
			</div>
			<!-- Municipios -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Municipio <span class="text-danger">*</span></label>
					<select name="municipios" id="municipios" form="formulario_actualizar_perfil" class="form-control select2 municipios" required>
						<optgroup label="Actual">
							<option id="0" value="<?php echo $informacionGeneral->nomMunicipioNacional; ?>" selected><?php echo $informacionGeneral->nomMunicipioNacional; ?></option>
						</optgroup>
						<optgroup label="Actualizar">
							<?php foreach ($municipios as $municipio): ?>
								<option id="<?php echo $municipio->id_municipio; ?>" value="<?php echo $municipio->nombre; ?>"><?php echo $municipio->nombre; ?></option>
							<?php endforeach; ?>
						</optgroup>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Dirección -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Dirección <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-home"></i></span>
						</div>
						<input type="text" class="form-control" form="formulario_actualizar_perfil" name="direccion" id="direccion" required placeholder="Dirección" value="<?php echo $informacionGeneral->direccionOrganizacion; ?>">
					</div>
				</div>
			</div>
			<!-- Dirección Web -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Dirección Web</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-world"></i></span>
						</div>
						<input type="text" name="urlOrganizacion" form="formulario_actualizar_perfil" id="urlOrganizacion" placeholder="www.orgsolidarias.gov.co" class="form-control" value="<?php echo $informacionGeneral->urlOrganizacion; ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Teléfono -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Teléfono - Celular <span class="text-danger">*</span></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text mdi mdi-cellphone"></span>
						</div>
						<input type="text" name="fax" id="fax" form="formulario_actualizar_perfil" class="form-control" required placeholder="Teléfono o celular" value="<?php echo $informacionGeneral->fax; ?>">
					</div>
					<div class="form-check mt-2">
						<label class="form-check-label">
							<input type="checkbox" name="extension_checkbox" id="extension_checkbox" class="form-check-input">
							¿Tiene Extensión?
						</label>
					</div>
				</div>
			</div>
			<!-- Extensión -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Extensión</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="ti-panel"></i></span>
						</div>
						<input type="text" name="extension" form="formulario_actualizar_perfil" id="extension" class="form-control" placeholder="Extensión" value="<?php echo $informacionGeneral->extension; ?>">
					</div>
				</div>
			</div>
		</div>
		<!-- Sección de quien actualiza -->
		<div class="section-header mt-4">
			<h5><i class="ti-pencil-alt text-primary mr-2"></i>¿Quién actualiza la información?</h5>
			<hr class="separator-line" />
		</div>
		<div class="row">
			<!-- Primer nombre quien actualiza -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Primer Nombre <span class="text-danger">*</span></label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="nombre_p" id="nombre_p" placeholder="Primer Nombre" value="<?= $organizacion->primerNombrePersona; ?>" required>
				</div>
			</div>
			<!-- Primer apellido quien actualiza -->
			<div class="col-md-6">
				<div class="form-group">
					<label>Primer Apellido <span class="text-danger">*</span></label>
					<input type="text" class="form-control" form="formulario_actualizar_perfil" name="apellido_p" id="apellido_p" placeholder="Primer Apellido" value="<?= $organizacion->primerApellidoPersona; ?>" required>
				</div>
			</div>
		</div>
		<?= form_close(); ?>
		<div class="row mt-4">
			<div class="col-12 text-center">
				<button type="button" class="btn btn-primary" name="actualizar_informacion" id="actualizar_informacion">
					<i class="ti-save mr-2"></i> Actualizar información
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Estilos adicionales -->
<style>
	.section-header {
		margin-top: 1.5rem;
		margin-bottom: 1rem;
	}

	.section-header h5 {
		color: #4B49AC;
		font-weight: 600;
	}

	.separator-line {
		border-top: 1px solid #ebedf2;
		margin-bottom: 1.5rem;
	}

	.text-danger {
		color: #FF4747 !important;
	}

	.select2-container .select2-selection--single {
		height: 38px;
		border: 1px solid #ced4da;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 38px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 36px;
	}
</style>
