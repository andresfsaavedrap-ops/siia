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
/*  echo '<pre>';
var_dump($documentacionLegal);
echo '</pre>';
return null; */
?>
<div id="documentacion_legal" data-form="2">
	<h3 class="card-header">
		<i class="fa fa-book mr-2" aria-hidden="true"></i>
		2. Documentación Legal
	</h3>
	<?php if (!$documentacionLegal): ?>
	<div class="container-fluid mb-5">
		<div class="alert alert-info">
			<i class="fa fa-info-circle mr-2"></i>
			Usted debe marcar la opción que se ajuste a su organización.
			Una vez diligencie todos los campos debe presionar el botón Guardar Datos.
			Los campos marcados con <span class="text-danger">*</span> son obligatorios.
		</div>
		<!-- Camara de comercio -->
		<div class="section-title">2.1. Certificado de Cámara de Comercio</div>
		<div class="form-group">
			<div class="checkbox-group">
				<label>La entidad cuenta con Certificado de Cámara de Comercio:</label>
				<div class="radio-group">
					<?php if ($documentacionLegal): ?>
						<label class="radio-option">
							<input type="radio" class="radio-input camaraComercio" name="camaraComercio" value="Si" disabled>
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input camaraComercio" name="camaraComercio" value="No" disabled>
							<span>No</span>
						</label>
					<?php else: ?>
						<label class="radio-option">
							<input type="radio" class="radio-input camaraComercio" name="camaraComercio" value="Si">
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input camaraComercio" name="camaraComercio" value="No" checked>
							<span>No</span>
						</label>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="div_camara_comercio" class="form-section hidden">
			<?php echo form_open('', array('id' => 'formulario_certificado_existencia')); ?>
			<div class="alert alert-info">
				<p>En caso de que el Certificado de Existencia y Representación Legal sea emitido por Cámara de Comercio, la Unidad Administrativa realizará la verificación de este requisito por medio de consulta directa a la base de datos del Registro Único Empresarial Y Social RUES. Por tal motivo no es necesario anexar el certificado. Es responsabilidad de la entidad mantener renovado el registro mercantil en el certificado.</p>
			</div>
			<button name="guardar_formulario_camara_comercio" id="guardar_formulario_camara_comercio" class="btn btn-primary btn-block" data-id="<?php echo $solicitud->idSolicitud; ?>" data-idOrg="<?php echo $organizacion->id_organizacion; ?>">
				Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
			</button>
			<?php echo form_close(); ?>
		</div>
		<!-- Certificado de existencia y representación legal -->
		<div class="section-title">2.2. Certificado de Existencia y Representación Legal</div>
		<div class="form-group">
			<div class="checkbox-group">
				<label>La entidad presenta Certificado de Existencia y Representación Legal:</label>
				<div class="radio-group">
					<?php if ($documentacionLegal): ?>
						<label class="radio-option">
							<input type="radio" class="radio-input certificadoExistencia" name="certificadoExistencia" value="Si" disabled>
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input certificadoExistencia" name="certificadoExistencia" value="No" disabled>
							<span>No</span>
						</label>
					<?php else: ?>
						<label class="radio-option">
							<input type="radio" class="radio-input certificadoExistencia" name="certificadoExistencia" value="Si">
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input certificadoExistencia" name="certificadoExistencia" value="No" checked>
							<span>No</span>
						</label>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div id="div_certificado_existencia" class="form-section hidden">
			<!-- Alertas informativas -->
			<div class="alert alert-info">
				<strong>Nota:</strong> Los campos marcados con <span class="text-danger">*</span> son obligatorios.
			</div>
			<?php echo form_open_multipart('', array('id' => 'formulario_certificado_existencia_legal')); ?>
			<!-- Entidad -->
			<div class="form-group">
				<label class="required-field" for="entidadCertificadoExistencia">Entidad que expide certificado exístencia:</label>
				<input class="form-control" type="text" name="entidadCertificadoExistencia" id="entidadCertificadoExistencia" placeholder="Entidad que expide certificado existencia" required>
			</div>
			<!-- Fecha de expedición -->
			<div class="form-group">
				<label class="required-field" for="fechaExpedicion">Fecha de Expedición:</label>
				<input type="date" class="form-control" name="fechaExpedicion" id="fechaExpedicion" required>
			</div>
			<div class="row">
				<!-- Departamento -->
				<div class="col-md-6">
					<div class="form-group">
						<label class="required-field" for="departamentos2">Departamento:</label>
						<select name="departamentos2" data-id-dep="2" id="departamentos2" class="form-control selectpicker departamentos" required>
							<?php foreach ($departamentos as $departamento): ?>
								<option id="<?php echo $departamento->id_departamento; ?>" value="<?php echo $departamento->nombre; ?>"><?php echo $departamento->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<!-- Municipio -->
				<div class="col-md-6">
					<div class="form-group" id="div_municipios2">
						<label class="required-field" for="municipios2">Municipio:</label>
						<select name="municipios2" id="municipios2" class="form-control selectpicker" required>
							<?php foreach ($municipios as $municipio): ?>
								<option id="<?php echo $municipio->id_municipio; ?>" value="<?php echo $municipio->nombre; ?>"><?php echo $municipio->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<!-- Archivo adjunto -->
			<div class="form-group">
				<label class="required-field">Certificado de existencia (PDF):</label>
				<div class="file-upload">
					<label class="file-upload-label">
						<i class="fa fa-upload"></i>
						<span>Seleccionar archivo</span>
					</label>
					<input type="file" required accept="application/pdf" class="form-control" name="archivoCertifcadoExistencia" id="archivoCertifcadoExistencia">
				</div>
			</div>
			<!-- Botón guardar -->
			<button name="guardar_formulario_certificado_existencia" id="guardar_formulario_certificado_existencia" class="btn btn-primary btn-block" data-id="<?php echo $solicitud->idSolicitud; ?>">
				Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
			</button>
			<?php echo form_close(); ?>
		</div>
		<!-- Registro educativo -->
		<div class="section-title">
			2.3. Registro Educativo
		</div>
		<div class="form-group">
			<div class="checkbox-group">
				<label>La entidad presenta registro educativo:</label>
				<div class="radio-group">
					<?php if ($documentacionLegal): ?>
						<label class="radio-option">
							<input type="radio" class="radio-input registroEducativo" name="registroEducativo" value="Si" disabled>
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input registroEducativo" name="registroEducativo" value="No" disabled>
							<span>No</span>
						</label>
					<?php else: ?>
						<label class="radio-option">
							<input type="radio" class="radio-input registroEducativo" name="registroEducativo" value="Si">
							<span>Sí</span>
						</label>
						<label class="radio-option">
							<input type="radio" class="radio-input registroEducativo" name="registroEducativo" value="No" checked>
							<span>No</span>
						</label>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div id="div_registro_educativo" class="form-section hidden">
			<div class="alert alert-info">
				Estos datos aplican solamente a Entidades Educativas.
			</div>
			<?php echo form_open_multipart('', array('id' => 'formulario_registro_educativo')); ?>
			<div class="form-group">
				<label class="required-field" for="tipoEducacion">Tipo de educación:</label>
				<select name="tipoEducacion" id="tipoEducacion" class="form-control selectpicker">
					<option id="1" value="Educacion para el trabajo y el desarrollo humano">Educación para el trabajo y el desarrollo humano</option>
					<option id="2" value="Formal">Formal</option>
					<option id="3" value="Informal">Informal</option>
				</select>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="required-field" for="fechaResolucionProgramas">Fecha de resolución:</label>
						<input class="form-control" type="date" name="fechaResolucionProgramas" id="fechaResolucionProgramas">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="required-field" for="numeroResolucionProgramas">Número de Resolución:</label>
						<input class="form-control" type="number" name="numeroResolucionProgramas" id="numeroResolucionProgramas" placeholder="Número de Resolución...">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="required-field" for="nombreProgramaResolucion">Nombre del Programa:</label>
				<input type="text" name="nombreProgramaResolucion" class="form-control" id="nombreProgramaResolucion" placeholder="Nombre del Programa...">
			</div>
			<div class="form-group">
				<label class="required-field" for="objetoResolucionProgramas">Objeto resolución:</label>
				<textarea class="form-control" name="objetoResolucionProgramas" id="objetoResolucionProgramas" placeholder="Objeto resolución..."></textarea>
			</div>
			<div class="form-group">
				<label class="required-field" for="entidadResolucion">Entidad que expide la resolución:</label>
				<select name="entidadResolucion" id="entidadResolucion" class="form-control selectpicker">
					<option id="1" value="Ministerio De Educación">Ministerio De Educación</option>
					<option id="2" value="Secretaria De Educación Departamental">Secretaria De Educación Departamental</option>
					<option id="3" value="Secretaria De Educación Municipal">Secretaria De Educación Municipal</option>
				</select>
			</div>
			<!-- Archivo adjunto -->
			<div class="form-group">
				<label class="required-field">Registro Educativo (PDF):</label>
				<div class="file-upload">
					<label class="file-upload-label">
						<i class="fa fa-upload"></i>
						<span>Seleccionar archivo</span>
					</label>
					<input type="file" required accept="application/pdf" class="form-control" name="archivoRegistroEdu" id="archivoRegistroEdu">
				</div>
			</div>
			<button name="guardar_formulario_registro_educativo" id="guardar_formulario_registro_educativo" class="btn btn-primary btn-block" data-id="<?php echo $solicitud->idSolicitud; ?>">
				Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
			</button>
			<?php echo form_close(); ?>
		</div>
	</div>
	<?php endif; ?>
	<!-- Tabla Documentación Legal -->
	<?php if ($documentacionLegal): ?>
	<div class="container-fluid mb-5">
		<div class="alert alert-success border-left border-success border-4">
			<div class="d-flex">
				<i class="fa fa-check-circle mr-3 fa-2x"></i>
				<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
			</div>
		</div>
		<?php if ($documentacionLegal->entidad): ?>
			<div class="section-title">Datos Certificado existencia</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>Entidad</th>
						<th>Fecha Expedición</th>
						<th>Departamento</th>
						<th>Municipio</th>
						<th>Documento</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php
					echo "<tr><td>" . $documentacionLegal->entidad . "</td>";
					echo "<td>" . $documentacionLegal->fechaExpedicion . "</td>";
					echo "<td>" . $documentacionLegal->departamento . "</td>";
					echo "<td>" . $documentacionLegal->municipio . "</td>";
					echo "<td><button class='btn btn-primary btn-sm verDocCertificadoExistencia' data-id=" . $documentacionLegal->id_certificadoExistencia . ">Ver Documento <i class='fa fa-eye' aria-hidden='true'></i></button></td>";
					if ($nivel != '7'):
						echo "<td><button class='btn btn-danger btn-sm eliminarDatosCertificadoExistencia' data-id=" . $documentacionLegal->id_certificadoExistencia . ">Eliminar <i class='fa-solid fa-trash'></i></button></td>";
					endif;
					echo '</tr>';
					?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		<?php if ($documentacionLegal->numeroResolucion): ?>
			<div class="section-title">Datos Registro Educativo</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>Tipo Educación</th>
						<th>Fecha Resolución</th>
						<th>Numero Resolución</th>
						<th>Nombre Programa</th>
						<th>Objeto</th>
						<th>Entidad</th>
						<th>Documento</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php
					echo "<tr><td>" . $documentacionLegal->tipoEducacion . "</td>";
					echo "<td>" . $documentacionLegal->fechaResolucion . "</td>";
					echo "<td>" . $documentacionLegal->numeroResolucion . "</td>";
					echo "<td>" . $documentacionLegal->nombrePrograma . "</td>";
					echo "<td><textarea class='text-area-ext' readonly>" . $documentacionLegal->objetoResolucion . "</textarea></td>";
					echo "<td>" . $documentacionLegal->entidadResolucion . "</td>";
					echo "<td><button class='btn btn-primary btn-sm verDocRegistro' data-id=" . $documentacionLegal->id_registroEducativoPro . ">Ver Documento <i class='fa-solid fa-file'></i></button></td>";
					if ($nivel != '7'):
						echo "<td><button class='btn btn-danger btn-sm eliminarDatosRegistro' data-id=" . $documentacionLegal->id_registroEducativoPro . ">Eliminar <i class='fa-solid fa-trash'></i></button></td>";
					endif;
					echo '</tr>';
					?>
					</tbody>
				</table>
			</div> 
		<?php endif; ?>
		<?php if ($documentacionLegal->id_tipoDocumentacion): ?>
			<div class="section-title">Registraste Cámara de Comercio</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>Documento</th>
						<th>Acción</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php
					echo "<tr><td>Cámara de comercio <span class='badge badge-success'>Registrado</span></td>";
					if ($nivel != '7'):
						echo "<td><button class='btn btn-danger btn-sm eliminarDatosCamaraComercio' data-id=" . $documentacionLegal->id_tipoDocumentacion . ">Deshacer <i class='fa-solid fa-trash'></i></button></td>";
					endif;
					echo '</tr>';
					?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<?php endif ?>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_2.js?v=1.2.1') . time() ?>" type="module"></script>
