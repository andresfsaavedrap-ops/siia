
<!-- Información General Organización -->
<div class="col-md-12" id="informacion">
	<h3>1. Información General.</h3><br>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6">
				<!-- Tipo Organización -->
				<h5>Tip Organización: </h5>
				<p class="tipoLeer" id='tipoOrganizacion'></p>
				<!-- Departamento -->
				<h5>Departamento: </h5>
				<p class="tipoLeer" id='nomDepartamentoUbicacion'></p>
				<!-- Municipio -->
				<h5>Municipio: </h5>
				<p class="tipoLeer" id='nomMunicipioNacional'></p>
				<!-- Dirección -->
				<h5>Dirección: </h5>
				<p class="tipoLeer" id='direccionOrganizacion'></p>
				<!-- Teléfono - Fax -->
				<h5>Teléfono - Fax: </h5>
				<p class="tipoLeer" id='fax'></p>
				<!-- Extensión -->
				<h5>Extensión: </h5>
				<p class="tipoLeer" id='extension'></p>
				<!-- URL de la Organización -->
				<h5>URL de la Organización: </h5>
				<p class="tipoLeer" id='urlOrganizacion'></p>
				<!-- Actuación -->
				<h5>Actuación: </h5>
				<p class="tipoLeer" id='actuacionOrganizacion'></p>
				<!-- Tipo Educación -->
				<h5>Tipo de educación: </h5>
				<p class="tipoLeer" id='tipoEducacion'></p>
			</div>
			<div class="col-lg-6">
				<!-- Cédula Representante Legal -->
				<h5>Cédula del representante Legal: </h5>
				<p class="tipoLeer" id='numCedulaCiudadaniaPersona'></p>
				<!-- Presentación Institucional
				<h5>Presentación institucional: </h5><p class="tipoLeer" id='presentacionInstitucional'></p>-->
				<!-- Objeto Social
				<h5>Objeto social: </h5><p class="tipoLeer" id='objetoSocialEstatutos'></p>-->
				<!-- Misión -->
				<h5>Misión: </h5>
				<p class="tipoLeer" id='mision'></p>
				<!-- Visión -->
				<h5>Visión: </h5>
				<p class="tipoLeer" id='vision'></p>
				<!-- Principios
				<h5>Principios: </h5><p class="tipoLeer" id='principios'></p>-->
				<!-- Fines
				<h5>Fines: </h5><p class="tipoLeer" id='fines'></p>-->
				<!-- Portafolio -->
				<h5>Portafolio: </h5>
				<p class="tipoLeer" id='portafolio'></p>
				<!-- Otros
				<h5>Otros: </h5><p class="tipoLeer" id='otros'></p>-->
			</div>
		</div>
		<hr />
		<div id="archivos_informacionGeneral">
	</div>
	</div>
	<!-- Formulario Observación form1 -->
	<div class="col-12">
		<hr />
		<div class="formulario-observacion-container">
			<?php echo form_open('', array('id' => 'formulario_observacion_form1', 'class' => 'formulario-observacion')); ?>
			<div class="form-group">
				<label for="observacionesForm1" class="form-label">
					<i class="mdi mdi-comment-edit"></i> Nueva Observación - Información General
				</label>
				<textarea class="form-control obs_admin_" name="observacionesForm1" id="observacionesForm1" 
						  cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-siia btn-observacion guardarObservacionesForm1">
					<i class="mdi mdi-content-save"></i> Guardar Observación
				</button>
			</div>
			<?php echo form_close(); ?>
			<hr />
			<div class="observaciones_realizadas_form1"></div>
			<hr />
		</div>
	</div>
</div>
<!-- Documentación Legal -->
<div class="col-md-12" id="documentacion">
	<h3>2. Documentación Legal</h3>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-2">
				<label>Datos Documentación Legal:</label>
				<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
				<table id="tabla_datos_documentacion_legal" width="100%" border=0 class="table table-striped table-bordered">
					<thead class="head_tabla_datos_documentacion_legal">
					</thead>
					<tbody id="tbody" class="tabla_datos_documentacion_legal"></tbody>
				</table>
			</div>
		</div>
		<hr />
	</div>
	<!-- Formulario Observación form2 -->
	<div class="col-12">
		<div class="formulario-observacion-container">
			<?php echo form_open('', array('id' => 'formulario_observacion_form2', 'class' => 'formulario-observacion')); ?>
			<div class="form-group">
				<label for="observacionesForm2" class="form-label">
					<i class="mdi mdi-comment-edit"></i> Nueva Observación - Documentación Legal
				</label>
				<textarea class="form-control obs_admin_" name="observacionesForm2" id="observacionesForm2" 
						  cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-siia btn-observacion guardarObservacionesForm2">
					<i class="mdi mdi-content-save"></i> Guardar Observación
				</button>
			</div>
			<?php echo form_close(); ?>
			<hr />
			<div class="observaciones_realizadas_form2"></div>
			<hr />
		</div>
	</div>
</div>
<!-- Jornadas de Actualización -->
<div class="col-md-12" id="jornadasActualizacion">
	<h3>3. Jornadas de Actualización</h3>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-2">
				<!-- Tabla Jornadas de Actualización -->
				<label>Datos de Jornadas de Actualización:</label>
				<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
				<table id="" width="100%" border=0 class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>Participó en jornadas</td>
							<td>Acciones</td>
						</tr>
					</thead>
					<tbody id="tbody" class="tabla_datos_jornadas"></tbody>
				</table>
				<hr />
			</div>
		</div>
	</div>	<!-- Formulario Observación form3 -->
	<div class="col-12">
		<div class="formulario-observacion-container">
			<?php echo form_open('', array('id' => 'formulario_observacion_form3', 'class' => 'formulario-observacion')); ?>
			<div class="form-group">
				<label for="observacionesForm3" class="form-label">
					<i class="mdi mdi-comment-edit"></i> Nueva Observación - Jornadas de Actualización
				</label>
				<textarea class="form-control obs_admin_" name="observacionesForm3" id="observacionesForm3"
						  cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-siia btn-observacion guardarObservacionesForm3">
					<i class="mdi mdi-content-save"></i> Guardar Observación
				</button>
			</div>
			<?php echo form_close(); ?>
			<hr />
			<div class="observaciones_realizadas_form3"></div>
			<hr />
		</div>
	</div>
</div>
<!-- Datos Básicos de Programas -->
<div class="col-md-12" id="datosBasicosProgramas">
	<h3>4. Datos Básicos de Programas</h3><br>
	<p>A continuación se relaciona el motivo de la solicitud registrado por la organización.</p><br><br>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-2">
				<div class="form-group" id="programa_seas" style="display: none;">
					<label class="underlined">
						<input type="checkbox" id="programa_seas" form="formulario_programas" name="programa_seas" value="* Programa organizaciones y redes SEAS" disabled required checked>
						<label for="modalProgramaSEAS">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalProgramaSEAS" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span> Programa organizaciones y redes SEAS
						</a>
					</label>
					<hr />
					<label>Registro de programas aceptados</label>
					<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
					<div class="table-resposive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<td>Organización</td>
									<td>Numero NIT</td>
									<td>Nombre Programa</td>
									<td>Acepta</td>
									<td>fecha</td>
								</tr>
							</thead>
							<tbody id="tbody" class="tabla_registro_programas"></tbody>
						</table>
					</div>
					<hr />
				</div>
				<!-- 				<br>
				<div class="form-group" id="curso_basico_aval" style="display: none;">
					<label class="underlined">
						<input type="checkbox" id="curso_basico_aval" form="formulario_programas" name="curso_basico_aval" value="* Acreditación, Aval de Trabajo Asociado" disabled required checked>
						<label for="modalAval">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalAval" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span> Acreditación, Aval de Trabajo Asociado
						</a>
					</label>
				</div>
				<br>
				<div class="form-group" id="curso_medio_es" style="display: none;">
					<label class="underlined">
						<input type="checkbox" id="curso_basico_aval" form="formulario_programas" name="curso_basico" value="* Acreditación Curso Medio de Economía Solidaria" disabled required checked>
						<label for="modalCursoMedio">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalCursoMedio" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span> Acreditación Curso Medio de Economía Solidaria
						</a>
					</label>
				</div>
				<br>
				<div class="form-group" id="curso_avanzado_es" style="display: none;">
					<label class="underlined">
						<input type="checkbox" id="curso_avanzado_es" form="formulario_programas" name="curso_avanzado_es" value="* Acreditación Curso Avanzado de Economía Solidaria" disabled required checked>
						<label for="modalCursoAvanzado">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalCursoAvanzado" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span> Acreditación Curso Avanzado de Economía Solidaria
						</a>
					</label>
				</div>
				<br>
				<div class="form-group" id="curso_economia_financiera" style="display: none;">
					<label class="underlined">
						<input type="checkbox" id="curso_economia_financiera" form="formulario_programas" name="curso_economia_financiera" value="* Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" disabled required checked>
						<label for="modalCursoFinanciera">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalCursoFinanciera" data-backdrop="static" data-keyboard="false" data-programa="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria">
							<span class="spanRojo">*</span> Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria
						</a>
				</div>
				<br> -->
			</div>
			<!-- Observaciones Datos Básicos de Programas -->
			<div class="col-12">
				<div class="formulario-observacion-container">
					<?php echo form_open('', array('id' => 'formulario_observacion_form4', 'class' => 'formulario-observacion')); ?>
					<div class="form-group">
						<label for="observacionesForm4" class="form-label">
							<i class="mdi mdi-comment-edit"></i> Nueva Observación - Datos Básicos de Programas
						</label>
						<textarea class="form-control obs_admin_" name="observacionesForm4" id="observacionesForm4" 
								  cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-siia btn-observacion guardarObservacionesForm4">
							<i class="mdi mdi-content-save"></i> Guardar Observación
						</button>
					</div>
					<?php echo form_close(); ?>
					<div class="observaciones_realizadas_form4"></div>
					<hr />
				</div>
			</div>
		</div>
	</div>
	<hr />
</div>
<!-- Docentes -->
<div class="col-md-12" id="docentes">
	<h3>5. Docentes</h3>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<hr />
				<div class="txtOrgDocen"></div>
				<!-- Contenedor para incrustar la evaluación de docentes -->
				<div id="evaluacion_docentes_embed" class="mt-3"></div>
				<!-- Carga de handlers para el componente (ver docente, volver a lista, etc.) -->
				<script type="module" src="<?= base_url('assets/js/functions/admin/modules/docentes/docentes.js?v=1.1') . time() ?>"></script>
			</div>
		</div>
	</div>
	<a href="" target="_blank" id="irAEvaluarDocente" class="btn btn-siia">Evaluar docentes <i class="fa fa-eye" aria-hidden="true"></i></a>
	<hr />
	<div class="col-12">
		<div class="formulario-observacion-container">
			<?php echo form_open('', array('id' => 'formulario_observacion_form5', 'class' => 'formulario-observacion')); ?>
				<div class="form-group">
					<label for="observacionesForm5" class="form-label">
						<i class="mdi mdi-comment-edit"></i> Nueva Observación - Docentes
					</label>
					<textarea class="form-control obs_admin_" name="observacionesForm5" id="observacionesForm5" 
							cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-siia btn-observacion guardarObservacionesForm5">
						<i class="mdi mdi-content-save"></i> Guardar Observación
					</button>
				</div>
			<?php echo form_close(); ?>
			<hr />
			<div class="observaciones_realizadas_form5"></div>
			<hr />
		</div>
	</div>
</div>
<!-- Datos Modalidades -->
<div class="col-md-12" id="datosModalidades">
	<h3>6. Datos Modalidades</h3><br>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-2">
				<p>A continuación se relaciona las modalidades registradas por la organización en la solicitud.</p><br><br>
				<div class="row pb-2">
					<div class="col-md-6">
						<div class="form-group mb-2" id="presencial">
							<label class="underlined">
								<input type="checkbox" id="presencial" form="formulario_programas" name="presencial" value="* Presencial" disabled required checked>
								<label for="modalProgramaSEAS">&nbsp;</label>
								<a><span class="spanRojo">*</span> Presencial
								</a>
							</label>
						</div>
						<div class="form-group mb-2" id="virtual">
							<label class="underlined">
								<input type="checkbox" id="virtual" form="formulario_programas" name="virtual" value="* Virtual" disabled required checked>
								<label for="modalProgramaSEAS">&nbsp;</label>
								<a><span class="spanRojo">*</span> Virtual
								</a>
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mb-2" id="presencial">
							<label class="underlined">
								<input type="checkbox" id="hibrida" form="formulario_programas" name="hibrida" value="* Híbrida" disabled required checked>
								<label for="modalProgramaSEAS">&nbsp;</label>
								<a><span class="spanRojo">*</span> Híbrida
								</a>
							</label>
						</div>
						<div class="form-group mb-2" id="a_distancia">
							<label class="underlined">
								<input type="checkbox" id="a_distancia" form="formulario_programas" name="a_distancia" value="* A Distancia" disabled required checked>
								<label for="modalProgramaSEAS">&nbsp;</label>
								<a><span class="spanRojo">*</span> A Distancia
								</a>
							</label>
						</div>
					</div>
				</div>
				<hr />
				<label>Registro de modalidades aceptadas</label>
				<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
				<table width="100%" border=0 class="table table-striped table-bordered" id="tabla_registro_modalidades">
					<thead>
						<tr>
							<td>Organización</td>
							<td>Numero NIT</td>
							<td>Modalidad</td>
							<td>Acepta</td>
							<td>Fecha</td>
						</tr>
					</thead>
					<tbody id="tbody" class="tabla_registro_modalidades"></tbody>
				</table>
				<hr />
			</div>
			<!-- Observaciones Datos Modalidades -->
			<div class="col-12">
				<div class="formulario-observacion-container">
					<?php echo form_open('', array('id' => 'formulario_observacion_form6', 'class' => 'formulario-observacion')); ?>
					<div class="form-group">
						<label for="observacionesForm6" class="form-label">
							<i class="mdi mdi-comment-edit"></i> Nueva Observación - Modalidades
						</label>
						<textarea class="form-control obs_admin_" name="observacionesForm6" id="observacionesForm6" 
								  cols="30" rows="4" required placeholder="Escriba aquí su observación..."></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-siia btn-observacion guardarObservacionesForm6">
							<i class="mdi mdi-content-save"></i> Guardar Observación
						</button>
					</div>
					<?php echo form_close(); ?>
					<hr />
					<div class="observaciones_realizadas_form6"></div>
					<hr />
				</div>
			</div>
		</div>
	</div>
</div>
