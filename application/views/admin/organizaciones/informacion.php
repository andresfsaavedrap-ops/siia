<?php
/***
 *
 * @var $idSolicitud
 * @var $idOrganizacion
 *
 */
?>
<div id="idSolicitudInfo" style="display: none"><?= $idSolicitud; ?></div>
<div id="idOrganizacion" style="display: none"><?= $idOrganizacion; ?></div>
<!-- Registro de observaciones por formulario -->
<div class="container" id="">
	<div class="panel-group" id="datos_org_final">
		<hr />
		<button id="desplInfoOrg" class="btn btn-sm btn-success btn-block">Desplegar información de la solicitud <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
		<button id="plegInfoOrg" class="btn btn-sm btn-danger btn-block">Plegar información de la solicitud <i class="fa fa-chevron-circle-up" aria-hidden="true"></i></button>
		<div id="verInfoOrg">
			<hr />
			<div class="col-md-4">
				<div class="form-group">
					<p>Nombre de la organización:</p><label class="tipoLeer" id='nOrgSol'></label>
				</div>
				<div class="form-group">
					<p>Sigla:</p><label class="tipoLeer" id='sOrgSol'></label>
				</div>
				<div class="form-group">
					<p>Número NIT:</p><label class="tipoLeer" id='nitOrgSol'></label>
				</div>
				<div class="form-group">
					<p>Nombre del representante:</p><label class="tipoLeer" id='nrOrgSol'></label>
				</div>
				<div class="form-group">
					<p>Teléfono de la organización:</p><label class="tipoLeer" id='telOrgSol'></label>
				</div>
				<div class="form-group">
					<p>Correo de la organización:</p><label class="tipoLeer" id='cOrgSol'></label>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p>Fecha de creación:</p><label class="tipoLeer" id='fechaSol'></label>
				</div>
				<div class="form-group">
					<p>ID de la solicitud:</p><label class="tipoLeer" id='idSol'></label>
				</div>
				<div class="form-group">
					<p>Tipo de solicitud:</p><label class="tipoLeer" id='tipoSol'></label>
				</div>
				<div class="form-group">
					<p>Modalidad de la solicitud:</p><label class="tipoLeer" id='modSol'></label>
				</div>
				<div class="form-group">
					<p>Motivo de la solicitud:</p><textarea style="height: 182px; width: 284px; resize: none;" class="tipoLeer" id='motSol' readonly></textarea>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p>Fecha de finalización:</p><label class="tipoLeer" id='revFechaFin'></label>
				</div>
				<div class="form-group">
					<p>Número de solicitud:</p><label class="tipoLeer" id='numeroSol'></label>
				</div>
				<div class="form-group">
					<p>Revisión #:</p><label class="tipoLeer" id='revSol'></label>
				</div>
				<div class="form-group">
					<p>Fecha de última revisión:</p><label class="tipoLeer" id='revFechaSol'></label>
				</div>
				<div class="form-group">
					<p>Estado de la organización:</p><label class="tipoLeer" id='estOrg'></label>
				</div>
				<div class="form-group">
					<p>Asignada por :</p><label class="tipoLeer" id='asignada_por'></label>
				</div>
				<div class="form-group">
					<p>Fecha de asignación:</p><label class="tipoLeer" id='fechaAsignacion'></label>
				</div>
				<hr>
				<div class="clearfix"></div>
				<div class="form-group">
					<p>Cámara de comercio: <a href="" id="camaraComercio_org" target="_blank">Clic aquí para ver la cámara de comercio</a></p>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<hr />
		<button class="btn btn-danger btn-sm pull-left" id="admin_ver_finalizadas_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
		<button class="btn btn-sm btn-warning pull-right" id="verRelacionCambios" data-toggle='modal' data-target='#modalRelacionCambios'>Ver relacion de cambios <i class="fa fa-eye" aria-hidden="true"></i></button>
		<button class="btn btn-sm btn-info pull-right" id='actualizar_solicitud' data-solicitud="<?= $idSolicitud ?>" disabled>Ir a la solicitud de usuario <i class="fa fa-refresh" aria-hidden="true"></i></button>
		<button class="btn btn-siia btn-sm pull-right verHistObs" id="hist_org_obs" data-backdrop="false" data-toggle='modal' data-target='#verHistObs'>Historial de observaciones <i class="fa fa-history" aria-hidden="true"></i></button>
		<div class="clearfix"></div>
		<hr />
		<div id="anclaInicio"></div>
		<!-- Información General Organización -->
		<div class="col-md-12" id="informacion">
			<h3>1. Información General.</h3><br>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6">
						<!-- Tipo Organización -->
						<h5>Tip Organización: </h5><p class="tipoLeer" id='tipoOrganizacion'></p>
						<!-- Departamento -->
						<h5>Departamento: </h5><p class="tipoLeer" id='nomDepartamentoUbicacion'></p>
						<!-- Municipio -->
						<h5>Municipio: </h5><p class="tipoLeer" id='nomMunicipioNacional'></p>
						<!-- Dirección -->
						<h5>Dirección: </h5><p class="tipoLeer" id='direccionOrganizacion'></p>
						<!-- Teléfono - Fax -->
						<h5>Teléfono - Fax: </h5><p class="tipoLeer" id='fax'></p>
						<!-- Extensión -->
						<h5>Extensión: </h5><p class="tipoLeer" id='extension'></p>
						<!-- URL de la Organización -->
						<h5>URL de la Organización: </h5><p class="tipoLeer" id='urlOrganizacion'></p>
						<!-- Actuación -->
						<h5>Actuación: </h5><p class="tipoLeer" id='actuacionOrganizacion'></p>
						<!-- Tipo Educación -->
						<h5>Tipo de educación: </h5><p class="tipoLeer" id='tipoEducacion'></p>
					</div>
					<div class="col-lg-6">
						<!-- Cédula Representante Legal -->
						<h5>Cédula del representante Legal: </h5><p class="tipoLeer" id='numCedulaCiudadaniaPersona'></p>
						<!-- Presentación Institucional
						<h5>Presentación institucional: </h5><p class="tipoLeer" id='presentacionInstitucional'></p>-->
						<!-- Objeto Social
						<h5>Objeto social: </h5><p class="tipoLeer" id='objetoSocialEstatutos'></p>-->
						<!-- Misión -->
						<h5>Misión: </h5><p class="tipoLeer" id='mision'></p>
						<!-- Visión -->
						<h5>Visión: </h5><p class="tipoLeer" id='vision'></p>
						<!-- Principios
						<h5>Principios: </h5><p class="tipoLeer" id='principios'></p>-->
						<!-- Fines
						<h5>Fines: </h5><p class="tipoLeer" id='fines'></p>-->
						<!-- Portafolio -->
						<h5>Portafolio: </h5><p class="tipoLeer" id='portafolio'></p>
						<!-- Otros
						<h5>Otros: </h5><p class="tipoLeer" id='otros'></p>-->
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr />
			<div class="col-md-12" id="archivos_informacionGeneral">
				<p>Archivos:</p>
			</div>
			<div class="clearfix"></div>
			<hr />
		</div>
		<div class="col-md-12" id="documentacion">
			<h3>2. Documentación Legal</h3>
			<div class="">
				<label>Datos Documentación Legal:</label>
				<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
				<table id="tabla_datos_documentacion_legal" width="100%" border=0 class="table table-striped table-bordered">
					<thead class="head_tabla_datos_documentacion_legal">
					</thead>
					<tbody id="tbody" class="tabla_datos_documentacion_legal"></tbody>
				</table>
			</div>
			<hr />
			<div class="clearfix"></div>
			<hr />
		</div>
		<div class="col-md-12" id="antecedentesAcademicos">
			<h3>3. Antecedentes Académicos</h3>
			<!-- Tabla Antecedentes Académicos -->
			<label>Datos de Antecedentes Educativos y Académicos:</label>
			<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
			<table id="" width="100%" border=0 class="table table-striped table-bordered">
				<thead>
				<tr>
					<td>Descripción Proceso</td>
					<td>justificación</td>
					<td>Objetivos</td>
					<td>Metodología</td>
					<td>Material Didáctico</td>
					<td>Bibliografía</td>
					<td>Duración Curso</td>
				</tr>
				</thead>
				<tbody id="tbody" class="tabla_datos_antecedentes"></tbody>
			</table>
			<hr />
		</div>
		<div class="col-md-12" id="jornadasActualizacion">
			<h3>3. Jornadas de Actualización</h3>
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
			<!-- Formulario Observación form3 -->
			<div class="col-12">
				<?php echo form_open('', array('id' => 'formulario_observacion_form3')); ?>
				<div class="form-group">
					<label for="observacionesForm3">Observaciones Jornadas de Actualización</label>
					<textarea class="form-control obs_admin_" name="observacionesForm3" id="observacionesForm3" cols="30" rows="5" required></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-siia guardarObservacionesForm3" id="sigInf">Guardar Observación <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
				</div>
				<?php echo form_close(); ?>
			</div>
			<hr />
			<label>Observaciones Realizadas</label>
			<div class="observaciones_realizadas_form3"></div>
		</div>
		<div class="col-md-12" id="datosBasicosProgramas">
			<h3>4. Datos Básicos de Programas</h3><br>
			<p>A continuación se relaciona el motivo de la solicitud registrado por la organización.</p><br><br>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="form-group" id="curso_basico_es" style="display: none;" >
							<label class="underlined">
								<input type="checkbox" id="programa" form="formulario_programas" name="curso_basico_es" value="* Acreditación Curso Básico de Economía Solidaria" disabled required checked>
								<label for="modalCursoBasico">&nbsp;</label>
								<a data-toggle="modal" data-target="#modalCursoBasico" data-backdrop="static" data-keyboard="false">
									<span class="spanRojo">*</span> Acreditación Curso Básico de Economía Solidaria
								</a>
							</label>
						</div>
						<br>
						<div class="form-group" id="curso_basico_aval" style="display: none;" >
							<label class="underlined">
								<input type="checkbox" id="curso_basico_aval" form="formulario_programas" name="curso_basico_aval" value="* Acreditación, Aval de Trabajo Asociado" disabled required checked>
								<label for="modalAval">&nbsp;</label>
								<a data-toggle="modal" data-target="#modalAval" data-backdrop="static" data-keyboard="false">
									<span class="spanRojo">*</span> Acreditación, Aval de Trabajo Asociado
								</a>
							</label>
						</div>
						<br>
						<div class="form-group" id="curso_medio_es" style="display: none;" >
							<label class="underlined">
								<input type="checkbox" id="curso_basico_aval" form="formulario_programas" name="curso_basico" value="* Acreditación Curso Medio de Economía Solidaria" disabled required checked>
								<label for="modalCursoMedio">&nbsp;</label>
								<a data-toggle="modal" data-target="#modalCursoMedio" data-backdrop="static" data-keyboard="false">
									<span class="spanRojo">*</span> Acreditación Curso Medio de Economía Solidaria
								</a>
							</label>
						</div>
						<br>
						<div class="form-group" id="curso_avanzado_es" style="display: none;" >
							<label class="underlined">
								<input type="checkbox" id="curso_avanzado_es" form="formulario_programas" name="curso_avanzado_es" value="* Acreditación Curso Avanzado de Economía Solidaria" disabled required checked>
								<label for="modalCursoAvanzado">&nbsp;</label>
								<a data-toggle="modal" data-target="#modalCursoAvanzado" data-backdrop="static" data-keyboard="false">
									<span class="spanRojo">*</span> Acreditación Curso Avanzado de Economía Solidaria
								</a>
							</label>
						</div>
						<br>
						<div class="form-group" id="curso_economia_financiera" style="display: none;" >
							<label class="underlined">
								<input type="checkbox" id="curso_economia_financiera" form="formulario_programas" name="curso_economia_financiera" value="* Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" disabled required checked>
								<label for="modalCursoFinanciera">&nbsp;</label>
								<a data-toggle="modal" data-target="#modalCursoFinanciera" data-backdrop="static" data-keyboard="false" data-programa="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria">
									<span class="spanRojo">*</span> Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria
								</a>
						</div>
						<br>
					</div>
					<hr />
					<label>Registro de programas aceptados</label>
					<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
					<table width="100%" border=0 class="table table-striped table-bordered" id="tabla_registro_programas">
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
			</div>
			<hr />
		</div>
		<div class="col-md-12" id="docentes">
			<h3>5. Docentes</h3>
			<!-- <button id="verFrameDocentes" class="btn btn-siia btn-sm pull-left">Ver docentes aquí <i class="fa fa-eye" aria-hidden="true"></i></button> -->
			<hr />
			<div class="txtOrgDocen"></div>
			<!-- <div id="frameDocDiv" class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" id="frameDocentes" frameborder="0" allowfullscreen></iframe>
			</div>-->
			<div class="clearfix"></div>
			<hr />
			<a href="" target="_blank" id="irAEvaluarDocente" class="btn btn-siia">Evaluar docentes <i class="fa fa-eye" aria-hidden="true"></i></a>
			<div class="clearfix"></div>
			<hr />
		</div>
		<div class="col-md-12" id="plataforma">
			<h3>6. Datos modalidad virtual</h3>
			<label>Datos de herramientas:</label>
			<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
			<table id="tabla_datos_plataforma" width="100%" border=0 class="table table-striped table-bordered">
				<thead>
				<tr>
					<td>UrlAplicación</td>
					<td>Usuario</td>
					<td>Contraseña</td>
				</tr>
				</thead>
				<tbody id="tbody" class="tabla_datos_plataforma"></tbody>
			</table>
			<hr />
		</div>
		<div class="col-md-12" id="enLinea">
			<h3>7. Datos modalidad en línea</h3>
			<!-- Tabla herramientas -->
			<label>Datos de herramientas:</label>
			<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
			<table id="" width="100%" border=0 class="table table-striped table-bordered">
				<thead>
				<tr>
					<td>Herramienta</td>
					<td>Descripción</td>
					<td>Fecha de registro</td>
				</tr>
				</thead>
				<tbody id="tbody" class="datos_herramientas"></tbody>
			</table>
			<hr />
		</div>
	</div>
</div>
<!-- Botón Menu de formulario -->
<div class="icono--div4">
	<a class="btn btn-siia btn-sm icono3 desOptSiia" role="button" title="Menu Formulario" data-toggle="tooltip" data-placement="right">Menu Formulario <i class="fa fa-bars" aria-hidden="true"></i></a>
</div>
<!-- Menu de formularios -->
<div class="contenedor--menu3">
	<div class="icono--div3">
		<div class="center-block" id="menuObsAdmin">
			<label>Menú de formularios:</label>
			<a class="icono3 desOptSiia pull-right" role="button" title="Menu Formulario"><i class="fa fa-times" aria-hidden="true"></i></a>
			<hr />
			<a class="toAncla" id="verInfGenMenuAdmin">1. Información General de la Entidad <i class="fa fa-home" aria-hidden="true"></i></a><br />
			<a class="toAncla" id="verDocLegalMenuAdmin">2. Documentación Legal <i class="fa fa-book" aria-hidden="true"></i></a><br />
			<!--			<a class="toAncla" id="verRegAcaMenuAdmin">3. Registros educativos de Programas <i class="fa fa-newspaper-o" aria-hidden="true"></i></a><br />-->
			<!-- <a class="toAncla" id="verAntAcaMenuAdmin">3. Antecedentes Académicos <i class="fa fa-id-card" aria-hidden="true"></i></a><br /> -->
			<a class="toAncla" id="verJorActMenuAdmin">3. Jornadas de actualización <i class="fa fa-handshake-o" aria-hidden="true"></i></a><br />
			<a class="toAncla" id="verProgBasMenuAdmin">4. Programa básico de economía solidaria <i class="fa fa-server" aria-hidden="true"></i></a><br />
			<!--			<a class="toAncla" id="verProgAvaMenuAdmin">7. <small>Prog. de Economía Solidaria con Énfasis en Trabajo Asociado</small> <i class="fa fa-sitemap" aria-hidden="true"></i></a><br />-->
			<!--			<a class="toAncla" id="verProgsMenuAdmin">8. Programas <i class="fa fa-signal" aria-hidden="true"></i></a><br />-->
			<a class="toAncla" id="verFaciliMenuAdmin">5. Facilitadores <i class="fa fa-users" aria-hidden="true"></i></a><br />
			<a class="toAncla" id="verDatPlatMenuAdmin">6. Datos Plataforma Virtual <i class="fa fa-globe" aria-hidden="true"></i></a><br />
			<a class="toAncla" id="verDataEnLinea">7. Datos Plataforma En Linéa <i class="fa fa-globe" aria-hidden="true"></i></a><br />
			<hr />
		</div>
	</div>
</div>
<!-- Modal ver historial de observaciones -->
<div class="modal fade" id="verHistObs" tabindex="-1" role="dialog" aria-labelledby="verhistobs">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h3 class="modal-title" id="verhistobs">Observaciones</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label>Historial de observaciones:</label>
						<!--						<label><a id="verObsFiltrada" target="_blank" class="pull-right">Ver tabla de observaciones para filtrar y descargar <i class="fa fa-table" aria-hidden="true"></i></a></label>-->
						<!--						<div class="input-group">-->
						<!--							<input type="text" class="form-control" placeholder="Buscar una observación..." id="buscarObsTextOrg" />-->
						<!--							<div class="clearfix"></div>-->
						<!--							<br />-->
						<!--						</div>-->
						<!--						<table id="tabla_historial_obsPlataforma" width="100%" border=0 class="table table-striped table-bordered tabla_form">-->
						<!--							<thead>-->
						<!--								<tr>-->
						<!--									<td class="col-md-12">Archivos de observaciones de la plataforma</td>-->
						<!--								</tr>-->
						<!--							</thead>-->
						<!--							<tbody id="tbody_hist_obsPlataforma">-->
						<!--							</tbody>-->
						<!--						</table>-->
						<div class="clearfix"></div>
						<br />
						<table id="tabla_historial_obs" width="100%" border=0 class="table table-striped table-bordered tabla_form">
							<thead>
							<tr>
								<td class="col-md-3">Formulario</td>
								<td class="col-md-1">Campo de formulario</td>
								<td class="col-md-6">Observación del campo</td>
								<!--<td class="col-md-2">Valor del usuario</td>-->
								<td class="col-md-1">Fecha de Observacion</td>
								<td class="col-md-1">Número de Revision</td>
								<!--<td class="col-md-1">Id de Solicitud</td>-->
							</tr>
							</thead>
							<tbody id="tbody_hist_obs">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm pull-left" id="crr_hist_obs" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
