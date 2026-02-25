<div class="container">
	<div class="row">
		<!-- Menu Formularios -->
		<div class="col-md-3 formularios side_main_menu">
			<div class="left_col scroll-view">
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu sidebar-menu">
					<div class="menu_section">
						<a data-form="inicio" data-id="<?php echo $solicitud->idSolicitud ?>">
							<h3 class="underlined text-center">Inicio - Ver solicitud <i class="fa fa-home" aria-hidden="true"></i></h3>
						</a>
						<div id="wizard_verticle" class="form_wizard wizard_verticle">
							<ul class="nav side-menu list-unstyled wizard_steps">
								<li class="step-no"><a data-form="1" data-form-name="informacion_general"><span id="1" class="step_no menu-sel">1</span> Información General de la Entidad <i class="fa fa-home" aria-hidden="true"></i></a></li>
								<li class="step-no"><a data-form="2" data-form-name="documentacion_legal"><span id="2" class="step_no menu-sel">2</span> Documentación Legal <i class="fa fa-book" aria-hidden="true"></i></a></li>
								<!--								<li class="step-no"><a data-form="3" data-form-name="antecedentes_academicos"><span id="3" class="step_no menu-sel">3</span> Antecedentes Académicos <i class="fa fa-id-card" aria-hidden="true"></i></a></li>-->
								<li class="step-no"><a data-form="3" data-form-name="jornadas_actualizacion"><span id="3" class="step_no menu-sel">3</span> Jornadas de Actualización <i class="fa fa-handshake-o" aria-hidden="true"></i></a></li>
								<li class="step-no"><a data-form="4" data-form-name="programa_economia"><span id="4" class="step_no menu-sel">4</span> Programa organizaciones y redes SEAS. <i class="fa fa-server" aria-hidden="true"></i></a></li>
								<li class="step-no"><a data-form="5" data-form-name="equipo_docente"><span id="5" class="step_no menu-sel">5</span> Equipo de Facilitadores <i class="fa fa-users" aria-hidden="true"></i></a></li>
								<li class="step-no" id="itemPlataforma"><a data-form="6" data-form-name="plataforma"><span id="6" class="step_no menu-sel">6</span> Datos modalidad virtual <i class="fa fa-globe" aria-hidden="true"></i></a></li>
								<li class="step-no" id="itemEnLinea"><a data-form="7" data-form-name="en_linea"><span id="7" class="step_no menu-sel">7</span> Datos modalidad hibrida<i class="fa fa-globe" aria-hidden="true"></i></a></li>
								<?php if ($nivel != '7'): ?>
									<li id="act_datos_sol_org" class="step-no">
										<a data-form="0" data-form-name="finalizar_proceso">
											<span class="step_no"><i class="fa fa-check" aria-hidden="true"></i></span>
											Finalizar Proceso <i class="fa fa-check" aria-hidden="true"></i>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<hr />
			</div>
		</div>
		<!-- Botón cerrar/abrir menu formularios -->
		<a id="hide-sidevar" class="btn btn-siia btn-sm hide-sidevar" role="button" title="Ocultar Menú" data-toggle="tooltip" data-placement="left"><i class="fa fa-window-close-o" aria-hidden="true"></i>
			<v>OCULTAR MENÚ</v>
		</a>
		<!-- Formularios -->
		<div class="col-md-9 formularios" role="main">
			<!-- Inicio del Panel Inicial -->
			<div id="estado_solicitud">
				<hr />
				<div class="form-group">
					<h3>Datos de la solicitud: <small>Los archivos y campos marcados en los formularios con asterisco (<span class="spanRojo">*</span>) son requeridos en la solicitud.</small></h3>
					<label>ID Solicitud:</label>
					<p><?php echo $solicitud->idSolicitud ?></p>
					<label>Estado de la organización:</label>
					<p><?php echo $solicitud->nombre ?></p>
					<label>Tipo de Solicitud:</label>
					<p><?php echo $solicitud->tipoSolicitud ?></p>
					<label>Motivo de Solicitud:</label>
					<p><?php echo $solicitud->motivoSolicitudAcreditado ?></p>
					<label>Modalidad de Solicitud:</label>
					<p><?php echo $solicitud->modalidadSolicitudAcreditado ?></p>
					<hr />
					<label>Estado anterior:</label>
					<p><?php echo $solicitud->estadoAnterior ?></p>

					<hr />
					<button class="btn btn-siia btn-sm verHistObsUs pull-right" id="hist_org_obs" data-toggle='modal' data-id-org="<?php echo $solicitud->organizaciones_id_organizacion; ?>" data-target='#verHistObsUs'>Historial de observaciones <i class="fa fa-history" aria-hidden="true"></i></button>
					<hr />
				</div>
				<div class="form-group">
					<button class="btn btn-danger btn-sm pull-left volver_al_panel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
				</div>
				<div class="clearfix"></div>
				<hr />
				<div class="form-group">
					<label>Formularios por completar:</label>
					<div id="formulariosFaltantes"></div>
				</div>
				<hr />
			</div>
			<!-- Formulario de información general de la entidad 1 -->
			<div id="informacion_general_entidad" data-form="1" class=" formulario_panel">
				<?php echo form_open('', array('id' => 'formulario_informacion_general_entidad')); ?>
				<h3>1. Información General de la Entidad <i class="fa fa-home" aria-hidden="true"></i></h3>
				<p>Usted debe llenar todos y cada uno de los campos requeridos y posteriormente presionar el botón Guardar y Continuar, los Campos marcados con (*) son obligatorios</p>
				<div class="col-md-4">
					<hr />
					<label>1. Información General:</label>
					<br>
					<!-- Nombre organización -->
					<div class="form-group">
						<label class="" for="nombre_organizacion">Nombre de la Organización:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" value="<?php echo $organizacion->nombreOrganizacion; ?>" disabled>
					</div>
					<!-- Sigla -->
					<div class="form-group">
						<label for="sigla">Sigla:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" value="<?php echo $organizacion->sigla; ?>" disabled>
					</div>
					<!-- NIT organización -->
					<div class="form-group">
						<label>NIT organización:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" disabled value="<?php echo $organizacion->numNIT; ?>">
					</div>
					<!-- Tipo organización -->
					<div class="form-group">
						<label for="tipo_organizacion">Tipo de Organización:<span class="spanRojo">*</span></label>
						<br>
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
						<label for="departamentos">Departamento:<span class="spanRojo">*</span></label>
						<br>
						<select name="departamentos" id="departamentos" data-id-dep="1" class="selectpicker form-control show-tick departamentos" required="">
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
					<!-- Municipio organización -->
					<div class="form-group">
						<div id="div_municipios">
							<label for="municipios">Municipio:<span class="spanRojo">*</span></label>
							<br>
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
						<label for="direccion">Dirección:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" name="direccion" id="direccion" required="" placeholder="Dirección" value="<?php echo $informacionGeneral->direccionOrganizacion; ?>">
					</div>
					<!-- Teléfono organización -->
					<div class="form-group">
						<label>Teléfono de Contacto:<span class="spanRojo">*</span></label>
						<input type="number" name="fax" id="fax" class="form-control" required placeholder="Fax - Teléfono" ondrop="return false;" onpaste="return false;" value="<?php echo $informacionGeneral->fax; ?>">
					</div>
					<!-- Extensión teléfono organización -->
					<div class="checkbox">
						<label for="extension_checkbox"><input type="checkbox" name="extension_checkbox" id="extension_checkbox"> ¿Tiene Extensión?</label>
					</div>
					<div class="form-group">
						<div id="div_extension">
							<label for="extension">Extensión:<span class="spanRojo">*</span></label>
							<input type="number" name="extension" id="extension" class="form-control" placeholder="Extensión" value="<?php echo $informacionGeneral->extension; ?>">
						</div>
					</div>
					<!-- Correo electrónico organización -->
					<div class="form-group">
						<label>Correo electrónico de la organización:<span class="spanRojo">*</span></label>
						<input type="text" name="correoElectronicoOrganizacion" id="correoElectronicoOrganizacion" class="form-control" placeholder="Correo electrónico de la organización" value="<?php echo $organizacion->direccionCorreoElectronicoOrganizacion; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<hr />
					<!-- URL organización -->
					<div class="form-group">
						<label>Dirección Web:</label>
						<input type="text" name="urlOrganizacion" id="urlOrganizacion" placeholder="www.orgsolidarias.gov.co" class="form-control" value="<?php echo $informacionGeneral->urlOrganizacion; ?>">
					</div>
					<!-- Actuación organización -->
					<div class="form-group">
						<label for="actuacion">Ámbito de Actuación de la Entidad:<span class="spanRojo">*</span></label>
						<br>
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
						<label for="educacion">Tipo de Educación:<span class="spanRojo">*</span></label>
						<br>
						<select name="educacion" id="educacion" class="selectpicker form-control show-tick" required="">
							<optgroup label="Actual">
								<option id="0" value="<?php echo $informacionGeneral->tipoEducacion; ?>" selected><?php echo $informacionGeneral->tipoEducacion; ?></option>
							</optgroup>
							<optgroup label="Actualizar">
								<option id="1" value="Educacion para el trabajo y el desarrollo humano">Educacion para el trabajo y el desarrollo humano</option>
								<option id="2" value="Formal">Formal</option>
								<option id="3" value="Informal">Informal</option>
							</optgroup>
						</select>
					</div>
					<hr />
					<label>Información Representante Legal:</label>
					<!-- Primer nombre representante legal -->
					<div class="form-group">
						<label for="primerNombreRepLegal">Primer Nombre:<span class="spanRojo">*</span></label>
						<input type="text" name="primerNombreRepLegal" id="primerNombreRepLegal" class="form-control" value="<?php echo $organizacion->primerNombreRepLegal; ?>">
					</div>
					<!-- Segundo nombre representante legal -->
					<div class="form-group">
						<label for="segundoNombreRepLegal">Segundo Nombre:</label>
						<input type="text" name="segundoNombreRepLegal" id="segundoNombreRepLegal" class="form-control" value="<?php echo $organizacion->segundoNombreRepLegal; ?>">
					</div>
					<!-- Primer apellido representante legal -->
					<div class="form-group">
						<label for="primerApellidoRepLegal">Primer Apellido:<span class="spanRojo">*</span></label>
						<input type="text" name="primerApellidoRepLegal" id="primerApellidoRepLegal" class="form-control" value="<?php echo $organizacion->primerApellidoRepLegal; ?>">
					</div>
					<!-- Segundo apellido representante legal -->
					<div class="form-group">
						<label for="segundoApellidoRepLegal">Segundo Apellido:</label>
						<input type="text" name="segundoApellidoRepLegal" id="segundoApellidoRepLegal" class="form-control" value="<?php echo $organizacion->segundoApellidoRepLegal; ?>">
					</div>
					<!-- Correo Electrónico del representante legal -->
					<div class="form-group">
						<label>Correo Electrónico del Representante Legal:<span class="spanRojo">*</span></label>
						<input type="text" name="correoElectronicoRepLegal" id="correoElectronicoRepLegal" class="form-control" value="<?php echo $organizacion->direccionCorreoElectronicoRepLegal; ?>">
					</div>
					<!-- Cédula del representante legal -->
					<div class="form-group">
						<label for="numCedulaCiudadaniaPersona">Numero de Cédula:<span class="spanRojo">*</span></label>
						<input type="number" name="numCedulaCiudadaniaPersona" id="numCedulaCiudadaniaPersona" class="form-control" required="" value="<?php echo $informacionGeneral->numCedulaCiudadaniaPersona; ?>">
					</div>
				</div>
				<div class="col-md-4">
					<hr />
					<label>1.2. Identificación y Presentación Institucional</label>
					<!-- Presentación institucional
                        <div class="form-group">
                            <label for="presentacion">Presentación Institucional:<span class="spanRojo">*</span></label>
                            <textarea class="form-control" name="presentacion" id="presentacion" placeholder="Presentación Institucional..."><?php echo $informacionGeneral->presentacionInstitucional; ?></textarea>
                        </div>
                        -->
					<!-- Objeto social
                        <div class="form-group">
                            <label for="objetoSocialEstatutos">Objeto Social Segun Estatutos:<span class="spanRojo">*</span></label>
                            <textarea class="form-control" name="objetoSocialEstatutos" id="objetoSocialEstatutos" placeholder="Objeto Social Segun Estatutos..."><?php echo $informacionGeneral->objetoSocialEstatutos; ?></textarea>
                        </div>
                        -->
					<!-- Misión -->
					<div class="form-group">
						<label for="mision">Misión:<span class="spanRojo">*</span></label>
						<textarea class="form-control" id="mision" name="mision" placeholder="Misión..."><?php echo $informacionGeneral->mision; ?></textarea>
					</div>
					<!-- Visión -->
					<div class="form-group">
						<label for="vision">Visión:<span class="spanRojo">*</span></label>
						<textarea class="form-control" id="vision" name="vision" placeholder="Visión..."><?php echo $informacionGeneral->vision; ?></textarea>
					</div>
					<!-- Principios
                        <div class="form-group">
                            <label for="principios">Principios:<span class="spanRojo">*</span></label>
                            <textarea class="form-control" id="principios" name="principios" placeholder="Principios..."><?php echo $informacionGeneral->principios; ?></textarea>
                        </div>
                        -->
					<!-- Fines
                        <div class="form-group">
                            <label for="fines">Fines:<span class="spanRojo">*</span></label>
                            <textarea class="form-control" id="fines" name="fines" placeholder="Fines..."><?php echo $informacionGeneral->fines; ?></textarea>
                        </div>
                        -->
					<!-- Portafolio -->
					<div class="form-group">
						<label for="portafolio">Portafolio de Servicios:<span class="spanRojo">*</span></label>
						<textarea class="form-control" id="portafolio" name="portafolio" placeholder="Portafolio de Servicios..."><?php echo $informacionGeneral->portafolio; ?></textarea>
					</div>
					<!-- Otros
                        <div class="form-group">
                            <label for="otros">Otros:</label>
                            <textarea class="form-control" id="otros" name="otros" placeholder="Otros..."><?php echo $informacionGeneral->otros; ?></textarea>
                        </div>
						-->
				</div>
				<?php echo  form_close(); ?>
				<?php if ($nivel != '7'): ?>
					<div class="col-md-12">
						<hr />
						<label>Anexar Solicitud de representante legal, fotografías de lugar de atención al público y 3 certificaciones de procesos educativos realizados por la entidad solicitante.* (Solamente se admiten formatos PDF, PNG, JPG)</label>
						<p>Anexar las certificaciones emitidas a nombre de la entidad solicitante, para verificar el requisito de experiencia y adjuntar fotografías del espacio físico de operación y atención al público.</p>
						<!-- Carta de solicitud -->
						<div class="form-group col-md-6">
							<?php echo form_open_multipart('', array('id' => 'formulario_carta')); ?>
							<h4>Carta de solicitud firmada por el representante legal <small>PDF (1)</small></h4>
							<input type="file" required accept="application/pdf" class="form-control" data-val="carta" name="carta" id="carta">
							<a type="submit" class="btn btn-siia btn-sm archivos_form_carta fa-fa center-block" data-name="carta" data-form="1" data-solicitud="<?php echo $solicitud->idSolicitud ?>" name="cartaRep" id="cartaRep" value="Guardar archivo(s) &#xf0c7">
								Guardar archivo(s) &#xf0c7
							</a>
							<?php echo form_close(); ?>
						</div>
						<!-- Certificaciones -->
						<div class="form-group div_certificaciones col-md-6">
							<?php echo form_open_multipart('', array('id' => 'formulario_certificaciones')); ?>
							<h4>Certificaciones <small>PDF (3)</small></h4>
							<input type="file" required accept="application/pdf" class="form-control" data-val="certificaciones" name="certificaciones[]" id="certificaciones1">
							<input type="file" required accept="application/pdf" class="form-control" data-val="certificaciones" name="certificaciones[]" id="certificaciones2">
							<input type="file" required accept="application/pdf" class="form-control" data-val="certificaciones" name="certificaciones[]" id="certificaciones3">
							<a type="submit" class="btn btn-siia btn-sm archivos_form_certificacion fa-fa center-block" data-name="certificaciones" data-solicitud="<?= $solicitud->idSolicitud ?>" name="certificaciones_organizacion" id="certificaciones_organizacion">
								Guardar archivo(s) &#xf0c7
							</a>
							<?php echo form_close(); ?>
						</div>
						<?php if ($solicitud->nombre == 'En Renovación'): ?>
							<!-- Carta de autoevaluación -->
							<div class="form-group col-md-12">
								<?php echo form_open_multipart('', array('id' => 'formulario_autoevaluacion')); ?>
								<h4>Adjunte documento de autoevaluación cualitativa del desarrollo del curso para el que solicita renovación <small>PDF (1)</small></h4>
								<input type="file" required accept="application/pdf" class="form-control" data-val="autoevaluacion" name="autoevaluacion" id="autoevaluacion">
								<a type="submit" class="btn btn-siia btn-sm archivos_form_autoevaluacion fa-fa center-block" data-name="autoevaluacion" data-form="1" data-solicitud="<?php echo $solicitud->idSolicitud ?>" name="autoevaluacion" id="autoevaluacion" value="Guardar archivo(s) &#xf0c7">
									Guardar archivo(s) &#xf0c7
								</a>
								<?php echo form_close(); ?>
							</div>
						<?php endif; ?>
						<!-- Imagenes
						<div class="form-group div_imagenes_lugar col-md-4">
							<h4>Imagenes <small>PNG, JPG (Max:10)</small> <a id="mas_files_imagenes"><i class="fa fa-plus" aria-hidden="true"></i></a><a id="menos_files_imagenes"> <i class="fa fa-minus" aria-hidden="true"></i></a></h4>
							<?php echo form_open_multipart('', array('id' => 'formulario_lugar')); ?>
								<div id="div_imagenes">
									<input type="file" required accept="image/jpeg, image/png" class="form-control" data-val="lugar" name="lugar[]" id="lugar1">
								</div>
								<a type="submit" class="btn btn-siia btn-sm fa-fa center-block archivos_form_lugar" data-name="lugar" name="lugar_organizacion" id="lugar_organizacion">
									Guardar archivo(s) &#xf0c7
								</a>
							<?php echo form_close(); ?>
						</div> -->
						<div class="clearfix"></div>
						<hr />
					</div>
					<a type="submit" class="btn btn-siia btn-md" style="width: 100%" name="guardar_formulario_informacion_general_entidad" id="guardar_formulario_informacion_general_entidad">Guardar/Actualizar/Verificar Formulario 1.<i class="fa fa-check" aria-hidden="true"></i></a>
				<?php endif; ?>
				<div class="table col-md-12">
					<hr />
					<label>Archivos:</label>
					<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>
					<table id="tabla_archivos_formulario" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
						<tr>
							<td class="col-md-4">Nombre</td>
							<td class="col-md-4">Tipo</td>
							<td class="col-md-4">Acción</td>
						</tr>
						</thead>
						<tbody id="tbody">
						</tbody>
					</table>
				</div>
				<hr />
			</div>
			<!-- Formulario de documentación legal 2 -->
			<div id="documentacion_legal" data-form="2" class=" formulario_panel">
				<h3>2. Documentación Legal <i class="fa fa-book" aria-hidden="true"></i></h3>
				<p>Los Campos marcados con (*) son obligatorios.</p>
				<small>Si no tiene el registro educativo, seleccione la opción "No", y de clic en guardar.</small>
				<!-- Camara de comercio -->
				<div class="col-md-12">
					<hr />
					<label>2.1. Certificado de Camara de Comercio.</label>
					<div class="checkbox">
						<label for="camaraComercio">La entidad cuenta con Certificado de Camara de Comercio:</label>
						<?php if ($documentacionLegal): ?>
							<label><input type="radio" class="camaraComercio" name="camaraComercio" id="camaraComercio" value="Si" disabled> Si</label>
							<label><input type="radio" class="camaraComercio" name="camaraComercio" id="camaraComercio" value="No" disabled> No</label>
						<?php else: ?>
							<label><input type="radio" class="camaraComercio" name="camaraComercio" id="camaraComercio" value="Si"> Si</label>
							<label><input type="radio" class="camaraComercio" name="camaraComercio" id="camaraComercio" value="No" checked> No</label>
						<?php endif; ?>
					</div>
					<div id="div_camara_comercio" hidden>
						<?php echo form_open('', array('id' => 'formulario_certificado_existencia')); ?>
						<hr />
						<p>En caso de que el Certificado de Existencia y Representación Legal sea emitido por Cámara de Comercio, la Unidad Administrativa realizará la verificación de este requisito por medio de consulta directa a la base de datos del Registro Único Empresarial Y Social RUES. Por tal motivo no es necesario anexar el certificado. Es responsabilidad de la entidad mantener renovado el registro mercantil en el certificado. Los Campos marcados con (*) son obligatorios.</p>
						</hr>
						<button name="guardar_formulario_camara_comercio" id="guardar_formulario_camara_comercio" class="btn btn-siia btn-md" style="width: 100%" data-id="<?php echo $solicitud->idSolicitud; ?>" data-idOrg="<?php echo $organizacion->id_organizacion; ?>">
							Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
						</button>
						<hr /> <br>
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- Certificado de existencia y representación legal -->
				<div class="col-md-12">
					<label>2.2. Certificado de Existencia y Representación Legal.</label>
					<div class="checkbox">
						<label for="certificadoExistencia">La entidad presenta Certificado de Existencia y Representación Legal:</label>
						<!-- Opciones radio -->
						<?php if ($documentacionLegal): ?>
							<label><input type="radio" class="certificadoExistencia" name="certificadoExistencia" id="certificadoExistencia" value="Si" disabled> Si</label>
							<label><input type="radio" class="certificadoExistencia" name="certificadoExistencia" id="certificadoExistencia" value="No" disabled> No</label>
						<?php else: ?>
							<label><input type="radio" class="certificadoExistencia" name="certificadoExistencia" id="certificadoExistencia" value="Si"> Si</label>
							<label><input type="radio" class="certificadoExistencia" name="certificadoExistencia" id="certificadoExistencia" value="No" checked> No</label>
						<?php endif ?>
					</div>
					<!-- Formulario: Certificado de Existencia y Representación Legal -->
					<div id="div_certificado_existencia">
						<?php echo form_open_multipart('', array('id' => 'formulario_certificado_existencia_legal')); ?>
						<!-- Entidad -->
						<div class="form-group">
							<hr /><label for="entidadCertificadoExistencia">Entidad que expide certificado éxistencia:<span class="spanRojo">*</span></label>
							<input class="form-control" type="text" name="entidadCertificadoExistencia" id="entidadCertificadoExistencia" placeholder="Entidad que expide certificado existencia" required>
						</div>
						<!-- Fecha de expedición-->
						<div class="form-group">
							<label for="fechaExpedicion">Fecha de Expedición:<span class="spanRojo">*</span></label>
							<input type="date" class="form-control" name="fechaExpedicion" id="fechaExpedicion" required>
						</div>
						<!-- Departamento-->
						<div class="form-group">
							<label for="departamentoCertificado">Departamento:<span class="spanRojo">*</span></label>
							<br>
							<select name="departamentos2" data-id-dep="2" id="departamentos2" class="selectpicker form-control show-tick departamentos" required="">
								<?php foreach ($departamentos as $departamento): ?>
									<option id="<?php echo $departamento->id_departamento; ?>" value="<?php echo $departamento->nombre; ?>"><?php echo $departamento->nombre; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<!-- Municicipio -->
						<div class="form-group">
							<div id="div_municipios2">
								<label for="municipios2">Municipio:<span class="spanRojo">*</span></label>
								<br>
								<select name="municipios2" id="municipios2" class="selectpicker form-control show-tick municipios" required>
									<?php foreach ($municipios as $municipio): ?>
										<option id="<?php echo $municipio->id_municipio; ?>" value="<?php echo $municipio->nombre; ?>"><?php echo $municipio->nombre; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<!-- Archivo adjunto -->
						<div class="form-group">
							</br><label>Certificado de existencia (PDF):<span class="spanRojo"> *</span></label>
							</br>
							<div class="col-md-4">
								<input type="file" required accept="application/pdf" class="form-control" name="archivoCertifcadoExistencia" id="archivoCertifcadoExistencia" required>
							</div>
							</br></br>
						</div>
						<!-- Botón guardar -->
						<button name="guardar_formulario_certificado_existencia" id="guardar_formulario_certificado_existencia" class="btn btn-siia btn-md" style="width: 100%" data-id="<?php echo $solicitud->idSolicitud; ?>">
							Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
						</button>
						<br>
						<hr />
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- Registro educativo -->
				<div class="col-md-12">
					<label>2.3. Registro Educativo.</label>
					<small> Estos datos aplican solamente a Entidades Educativas (Opcional)*.</small>
					<!-- Opciones radio -->
					<div class="checkbox">
						<label for="registroEducativo">La entidad presenta registro educativo:</label>
						<?php if ($documentacionLegal): ?>
							<label><input type="radio" class="registroEducativo" name="registroEducativo" id="registroEducativo" value="Si" disabled>Si</label>
							<label><input type="radio" class="registroEducativo" name="registroEducativo" id="" value="No" disabled>No</label>
						<?php else: ?>
							<label><input type="radio" class="registroEducativo" name="registroEducativo" id="registroEducativo" value="Si">Si</label>
							<label><input type="radio" class="registroEducativo" name="registroEducativo" id="" value="No" checked>No</label>
						<?php endif ?>
					</div>
					<!-- Formulario: Registro educativo -->
					<div id="div_registro_educativo">
						<?php echo form_open_multipart('', array('id' => 'formulario_registro_educativo')); ?>
						<!-- Entidad -->
						<hr />
						<div class="form-group">
							<label for="tipoEducacion">Tipo de educación:<span class="spanRojo">*</span></label>
							<br>
							<select name="tipoEducacion" id="tipoEducacion" class="selectpicker form-control show-tick">
								<option id="1" value="Educacion para el trabajo y el desarrollo humano">Educacion para el trabajo y el desarrollo humano</option>
								<option id="2" value="Formal">Formal</option>
								<option id="3" value="Informal">Informal</option>
							</select>
						</div>
						<br>
						<div class="form-group">
							<label for="fechaResolucionProgramas">Fecha de resolución:<span class="spanRojo">*</span></label>
							<input class="form-control" type="date" name="fechaResolucionProgramas" id="fechaResolucionProgramas">
						</div>
						<div class="form-group">
							<label for="numeroResolucionProgramas">Número de Resolución:<span class="spanRojo">*</span></label>
							<input class="form-control" type="number" name="numeroResolucionProgramas" id="numeroResolucionProgramas" placeholder="Número de Resolución...">
						</div>
						<div class="form-group">
							<label for="nombrePrograma">Nombre del Programa:<span class="spanRojo">*</span></label>
							<input type="text" name="nombreProgramaResolucion" class="form-control" id="nombreProgramaResolucion" placeholder="Nombre del Programa...">
						</div>
						<div class="form-group">
							<label for="objetoResolucionProgramas">Objeto resolución:<span class="spanRojo">*</span></label>
							<textarea class="form-control" name="objetoResolucionProgramas" id="objetoResolucionProgramas" placeholder="Objeto resolución..."></textarea>
						</div>
						<div class="form-group">
							<label for="entidadResolucion">Entidad que expide la resolución:<span class="spanRojo">*</span></label>
							<br>
							<select name="entidadResolucion" id="entidadResolucion" class="selectpicker form-control show-tick">
								<option id="1" value="Ministerio De Educación">Ministerio De Educación</option>
								<option id="2" value="Secretaria De Educación Departamental">Secretaria De Educación Departamental</option>
								<option id="3" value="Secretaria De Educación Municipal">Secretaria De Educación Municipal</option>
							</select>
						</div>
						<!-- Archivo adjunto -->
						<div class="form-group">
							<br><label>Registro Educativo (PDF):<span class="spanRojo"> *</span></label>
							<br>
							<div class="col-md-4">
								<input type="file" required accept="application/pdf" class="form-control" name="archivoRegistroEdu" id="archivoRegistroEdu">
							</div>
							<br><br>
						</div>
						<button name="guardar_formulario_registro_educativo" id="guardar_formulario_registro_educativo" class="btn btn-siia btn-md" style="width: 100%" data-id="<?php echo $solicitud->idSolicitud; ?>">
							Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
						</button>
						<hr />
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- Tabla Documentación Legal -->
				<?php if ($documentacionLegal): ?>
					<?php if ($documentacionLegal->entidad): ?>
						<div class="col-md-12">
							<hr />
							<label>Datos Certificado existencia:</label>
							<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
							<table id="" width="100%" border=0 class="table table-striped table-bordered">
								<thead>
								<tr>
									<td>Entidad</td>
									<td>Fecha Expedición</td>
									<td>Departamento</td>
									<td>Municipio</td>
									<td>Documento</td>
									<td>Acción</td>
								</tr>
								</thead>
								<tbody id="tbody">
								<?php
								echo "<tr><td>" . $documentacionLegal->entidad . "</td>";
								echo "<td>" . $documentacionLegal->fechaExpedicion . "</td>";
								echo "<td>" . $documentacionLegal->departamento . "</td>";
								echo "<td>" . $documentacionLegal->municipio . "</td>";
								echo "<td><button class='btn btn-primary btn-sm verDocCertificadoExistencia' data-id=" . $documentacionLegal->id_certificadoExistencia . ">Ver Documento <i class='fa fa-file-o' aria-hidden='true'></i></button></td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-danger btn-sm eliminarDataTabla eliminarDatosCertificadoExistencia' data-id=" . $documentacionLegal->id_certificadoExistencia . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								endif;
								echo '</tr>';
								?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
					<?php if ($documentacionLegal->numeroResolucion): ?>
						<div class="col-md-12">
							<hr />
							<label>Datos Registro Educativo:</label>
							<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
							<table id="" width="100%" border=0 class="table table-striped table-bordered">
								<thead>
								<tr>
									<td>Tipo Educación</td>
									<td>Fecha Resolución</td>
									<td>Numero Resolución</td>
									<td>Nombre Programa</td>
									<td>Objeto</td>
									<td>Entidad</td>
									<td>Documento</td>
									<td>Acción</td>
								</tr>
								</thead>
								<tbody id="tbody">
								<?php
								echo "<tr><td>" . $documentacionLegal->tipoEducacion . "</td>";
								echo "<td>" . $documentacionLegal->fechaResolucion . "</td>";
								echo "<td>" . $documentacionLegal->numeroResolucion . "</td>";
								echo "<td>" . $documentacionLegal->nombrePrograma . "</td>";
								echo "<td><textarea style='width: 282px; height: 110px; resize: none' readonly>" . $documentacionLegal->objetoResolucion . "</textarea></td>";
								echo "<td>" . $documentacionLegal->entidadResolucion . "</td>";
								echo "<td><button class='btn btn-primary btn-sm verDocRegistro' data-id=" . $documentacionLegal->id_registroEducativoPro . ">Ver Documento <i class='fa fa-file-o' aria-hidden='true'></i></button></td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-danger btn-sm eliminarDataTabla eliminarDatosRegistro' data-id=" . $documentacionLegal->id_registroEducativoPro . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								endif;
								echo '</tr>';
								?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
					<?php if ($documentacionLegal->id_tipoDocumentacion): ?>
						<div class="col-md-12">
							<hr />
							<label>Registraste Camara de Comercio:</label>
							<!--<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
							<table id="" width="100%" border=0 class="table table-striped table-bordered">
								<thead>
								<tr>
									<td>Documento</td>
									<td>Acción</td>
								</tr>
								</thead>
								<tbody id="tbody">
								<?php
								echo "<tr><td>Camara de comercio </td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-danger btn-sm eliminarDataTabla eliminarDatosCamaraComercio' data-id=" . $documentacionLegal->id_tipoDocumentacion . ">Deshacer <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								endif;
								echo '</tr>';
								?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				<?php endif	?>
			</div>
			<!-- Formulario de antecedentes academicos 3 (Anterior) -->
			<div id="antecedentes_academicos" data-form="10000" class=" formulario_panel">
				<?php echo form_open('', array('id' => 'formulario_antecedentes_academicos')); ?>
				<h3>3. Antecedentes Académicos <i class="fa fa-id-card" aria-hidden="true"></i></h3>
				<p>Relacione la experiencia en materia educativa, formativa y pedagógica. Los Campos marcados con (*) son obligatorios</p>
				<div class="form-group">
					<label for="descripcionProceso">Describa de manera cualitativa los procesos de formación que ha realizado:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="descripcionProceso" id="descripcionProceso" placeholder="Descripción cualitativa de los procesos de formación que ha realizado..."></textarea>
				</div>
				<div class="form-group">
					<label for="justificacionAcademicos">Justificación:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="justificacionAcademicos" id="justificacionAcademicos" placeholder="Justificación..."></textarea>
				</div>
				<div class="form-group">
					<label for="objetivosAcademicos">Objetivos:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="objetivosAcademicos" id="objetivosAcademicos" placeholder="Objetivos..."></textarea>
				</div>
				<div class="form-group">
					<label for="metodologiaAcademicos">Metodología:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="metodologiaAcademicos" id="metodologiaAcademicos" placeholder="Metodología..."></textarea>
				</div>
				<div class="form-group">
					<label for="materialDidacticoAcademicos">Describa el material didáctico y las ayudas educativas utilizadas:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="materialDidacticoAcademicos" id="materialDidacticoAcademicos" placeholder="Material didáctico y ayudas Educativas incorporadas..."></textarea>
				</div>
				<div class="form-group">
					<label for="bibliografiaAcademicos">Bibliografia:<span class="spanRojo">*</span></label>
					<textarea class="form-control" name="bibliografiaAcademicos" id="bibliografiaAcademicos" placeholder="Bibliografia..."></textarea>
				</div>
				<div class="form-group">
					<label for="duracionCursoAcademicos">Duración del curso:<span class="spanRojo">*</span> (Horas)</label>
					<input type="number" class="form-control" name="duracionCursoAcademicos" id="duracionCursoAcademicos" placeholder="40">
				</div>
				<button class="btn btn-siia btn-md" style="width: 100%" name="guardar_formulario_antecedentes_academicos" id="guardar_formulario_antecedentes_academicos" data-id="<?php echo $solicitud->idSolicitud; ?>">Guardar datos y verificar solicitud<i class="fa fa-check" aria-hidden="true"></i></button>
				<?php echo form_close(); ?>
				<div class="clearfix"></div>
				<?php if ($antecedentesAcademicos): ?>
					<hr />
					<label>Antecedentes:</label>
					<table id="" width="100%" border=0 class="table table-striped table-bordered ">
						<thead>
						<tr>
							<td>Descripción proceso</td>
							<td>Justificación</td>
							<td>Objetivos</td>
							<td>Metodología</td>
							<td>Material didactíco</td>
							<td>Bibliografía</td>
							<td>Duración cursó</td>
							<td>Acción</td>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php
						for ($i = 0; $i < count($antecedentesAcademicos); $i++):
							echo "<tr><td>" . $antecedentesAcademicos[$i]->descripcionProceso . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->justificacion . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->objetivos . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->metodologia . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->materialDidactico . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->bibliografia . "</td>";
							echo "<td>" . $antecedentesAcademicos[$i]->duracionCurso . "</td>";
							echo "<td><button class='btn btn-danger btn-sm eliminarDataTabla eliminarAntecedentes' data-id-antecedentes=" . $antecedentesAcademicos[$i]->id_antecedentesAcademicos . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td></tr>";
						endfor;
						?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
			<!-- Formulario de jornadas de actualización 3 -->
			<div id="jornadas_de_actualizacion" data-form="3" class=" formulario_panel">
				<h3>3. Jornada de actualización pedagógica <i class="fa fa-handshake-o" aria-hidden="true"></i></h3>
				<?php if (empty($jornadasActualizacion)): ?>
					<p>Registre los datos de la última jornada de actualización, organizada por Unidad Solidaria, a la que asistió. Si selecciona 'No', adjunte por favor una carta de compromiso y de clic en guardar.</p>
					<br>
					<?php echo form_open_multipart('', array('id' => 'formulario_jornadas_actualizacion')); ?>
					<!-- Participación en jornadas -->
					<div class="form-group">
						<label for="">3.1 ¿Participó en la última jornada de actualización pedagógica, organizada por la Unidad Solidaria?</label>
						<div class="checkbox">
							<label for="jornaSelect">La entidad participo en la jornada de actualización pedagógica:</label>
							<label><input type="radio" class="jornaSelect" name="jornaSelect" value="Si">Si</label>
							<label><input type="radio" class="jornaSelect" name="jornaSelect" value="No" checked>No</label>
						</div>
					</div>
					<br>
					<!-- Archivo -->
					<div class="form-group">
						<label>Documento de la Jornada de Actualización o carta de compromiso (PDF) </label>
						<ul>
							<li>En caso de haber participado en la jornada de actualización adjunté el certificado.</li>
							<li>En caso de no haber participado adjunté una carta de compromiso de participación en la jornada de actualización pedagógica.</li>
						</ul>
						<br />
						<label>Archivo (PDF):<span class="spanRojo">*</span></label>
						<div class="col-md-4">
							<input type="file" required accept="application/pdf" class="form-control" id="fileJornadas" name="fileJornadas">
						</div>
						<hr />
					</div>
					<button class="btn btn-siia btn-md guardar_formulario_jornadas_actualizacion" style="width: 100%" data-name="jornadaAct" data-id="<?php echo $solicitud->idSolicitud; ?>">
						Guardar datos <i class="fa fa-check" aria-hidden="true"></i>
					</button>
					<?php echo form_close() ?>
				<?php endif; ?>
				<!-- Tabla jornadas -->
				<?php if ($jornadasActualizacion): ?>
					<p>Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine primero el archivo cargado, seguido a ello elimine el registro realizado.</p>
					<hr />
					<label>Jornadas:</label>
					<table id="tabla_jornada_actualizacion" width="100%" border=0 class="table table-striped table-bordered">
						<thead>
						<tr>
							<td>Participó en Jornadas</td>
							<td>Acciones</td>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php
						echo "<tr><td>" . $jornadasActualizacion->asistio . "</td>";
						if ($nivel != '7'):
							echo "<td>
											<button class='btn btn-danger btn-sm eliminarJornadaActualizacion' 
												data-id-jornada=" . $jornadasActualizacion->idSolicitud . " 
												data-id-formulario=" . $archivoJornada[0]->id_formulario . "
												data-id-archivo=" . $archivoJornada[0]->id_archivo . "
												data-id-tipo=" . $archivoJornada[0]->tipo . "
												data-nombre-ar=" . $archivoJornada[0]->nombre . ">
												Eliminar 
												<i class='fa fa-trash-o' aria-hidden='true'></i>
											</button>
												<a target='_blank' href='" . base_url() . "uploads/jornadas/" . $archivoJornada[0]->nombre . "'<button class='btn btn-success btn-sm'>Ver documento </button><i class='fa fa-eye' aria-hidden='true'></i></a>
											</td>";
						endif;
						echo '</tr>';
						?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
			<!-- Formulario de programas de educación en economía solidaria 5 - INICIO -->
			<div id="programa_basico_de_economia_solidaria" data-form="4" class=" formulario_panel">
				<?php // echo form_open('', array('id' => 'formulario_programa_basico'));
				?>
				<h3>4. Programa organizaciones y redes SEAS. <i class="fa fa-server" aria-hidden="true"></i></h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora magni vel soluta non aliquid illo facilis libero aut maxime earum fugit, fugiat provident quia doloremque beatae enim autem eveniet amet.
				</p>
				<p>Recuerde que al aceptar el contenido el programa organizaciones y redes SEAS se registrara automáticamente el compromiso y este quedara en nuestra base de datos.</p>
				<hr />
				<!-- Grupo de check con los diferentes cursos -->
				<div class="container">
					<div class="row">
						<div class="col">
							<!-- Check Curso Básico -->
							<div class="form-group" id="curso_basico_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_basico_es" form="formulario_programas" name="curso_basico_es" value="* Acreditación Curso Básico de Economía Solidaria" disabled>
									<label for="modalCursoBasico">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoBasico" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Básico de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Aval -->
							<div class="form-group" id="curso_basico_aval" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_basico_aval" form="formulario_programas" name="curso_basico_aval" value="* Acreditación Aval de Trabajo Asociado" disabled required>
									<label for="modalAval">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalAval" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Aval de Trabajo Asociado
									</a>
								</label>
							</div>
							<!-- Check Curso Medio -->
							<div class="form-group" id="curso_medio_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_medio_aval" form="formulario_programas" name="check_curso_medio_aval" value="* Acreditación Curso Medio de Economía Solidaria" disabled required>
									<label for="modalCursoMedio">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoMedio" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Medio de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Avanzando -->
							<div class="form-group" id="curso_avanzado_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_avanzado_es" form="formulario_programas" name="check_curso_avanzado_es" value="* Acreditación Curso Avanzado de Economía Solidaria" disabled required>
									<label for="modalCursoAvanzado">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoAvanzado" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Avanzado de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Economía Financiera -->
							<div class="form-group" id="curso_economia_financiera" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_economia_financiera" form="formulario_programas" name="check_curso_economia_financiera" value="* Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" disabled required>
									<label for="modalCursoFinanciera">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoFinanciera" data-backdrop="static" data-keyboard="false" data-programa="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" data-id="<?php echo $solicitud->idSolicitud; ?>">
										<span class="spanRojo">*</span> Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria
									</a>
							</div>
							<!-- Campo oculto con ID de la organización -->
							<input type="text" name="id_organizacion" id="id_organizacion" value="<?php echo $organizacion->id_organizacion; ?>" style="display: none">
						</div>
					</div>
				</div>
				<!-- Tabla programas aceptados -->
				<?php if ($datosProgramas): ?>
					<div class="">
						<label>Datos programas aceptados</label>
						<a class="dataReload">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>
						<table id="" width="100%" border=0 class="table table-striped table-bordered">
							<thead>
							<tr>
								<td>Nombre programa</td>
								<td>Acepta</td>
								<td>Fecha</td>
								<td>Acción</td>
							</tr>
							</thead>
							<tbody id="tbody">
							<?php
							foreach ($datosProgramas as $data) {
								echo "<tr><td>" . $data->nombrePrograma . "</td>";
								echo "<td>" . $data->aceptarPrograma . "</td>";
								echo "<td>" . $data->fecha . "</td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-danger btn-sm eliminarDataTabla eliminarDatosProgramas' data-id=" . $data->id . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								endif;
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				<?php endif	?>
			</div>
			<!-- Formulario de docentes 5 -->
			<div id="docentes" data-form="5" class=" formulario_panel mt-2">
				<h3>5. Facilitadores <i class="fa fa-users" aria-hidden="true"></i></h3>
				<div class="jumbotron">
					<h3>Facilitadores</h3>
					<p>Para crear facilitadores y actualizar o adjuntar archivos como hojas de vida, certificaciones, por favor, de <a href="" id="irDocentes">clic aquí.</a></p>
				</div>
			</div>
			<!-- Formulario Datos Plataforma 7 -->
			<div id="datos_plataforma" data-form="6" class=" formulario_panel">
				<h3>6. Datos modalidad virtual<i class="fa fa-globe" aria-hidden="true"></i></h3>
				<p>Relacione los datos para ingresar a la plataforma y verificar su funcionamiento.</p>
				<?php echo form_open('', array('id' => 'formulario_modalidad_virtual')); ?>
				<!-- URL Plataforma -->
				<div class="form-group">
					<label for="datos_plataforma_url">URL:<span class="spanRojo">*</span></label>
					<input type="text" class="form-control" name="datos_plataforma_url" id="datos_plataforma_url" placeholder="EJ: https://www.orgsolidarias.gov.co/" required>
				</div>
				<!-- Usuario -->
				<div class="form-group">
					<label for="datos_plataforma_usuario">Usuario:<span class="spanRojo">*</span></label>
					<input type="text" class="form-control" name="datos_plataforma_usuario" id="datos_plataforma_usuario" placeholder="EJ: usuario.aplicacion" required>
				</div>
				<!-- Contraseña -->
				<div class="form-group">
					<label for="datos_plataforma_contrasena">Contraseña:<span class="spanRojo">*</span></label>
					<input type="text" class="form-control" name="datos_plataforma_contrasena" id="datos_plataforma_contrasena" placeholder="EJ: contraseña123@" required>
				</div>
				<!-- Check Aceptar Modalidad Virtual -->
				<div class="form-group">
					<label class="underlined">
						<input type="checkbox" id="acepta_mod_en_virtual" form="formulario_programas" name="acepta_mod_en_virtual" value="Si Acepto" disabled required>
						<label for="acepta_mod_en_linea">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalAceptarVirtual" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span>¿Acepta modalidad virtual?
						</a>
					</label>
				</div>
				<hr />
				<button class="btn btn-siia btn-md" style="width: 100%" name="guardar_formulario_plataforma" id="guardar_formulario_plataforma" data-id="<?php echo $solicitud->idSolicitud; ?>">Guardar datos <i class="fa fa-check" aria-hidden="true"></i></button>
				<?php echo form_close(); ?>
				<!-- Modal Aceptar Modalidad Virtual -->
				<div class="modal fade" id="modalAceptarVirtual" tabindex="-1" role="dialog" aria-labelledby="modalAceptarVirtual">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<div class="row">
									<div id="header_politicas" class="col-md-12">
										<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
									</div>
									<div class="clearfix"></div>
									<hr />
									<div class="col-md-12">
										Recomendaciones Modalidad Virtual
									</div>
								</div>
							</div>
							<div class="modal-body">
								<p>De acuerdo a lo establecido en el parágrafo número 1 del artículo 6 de la resolución 152 del 23 de junio del 2022, las entidades que soliciten la acreditación por la modalidad en línea deben tener en cuenta lo siguiente:</p>
								<p><strong>Parágrafo 1.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad virtual, la entidad solicitante deberá demostrar que el proceso educativo se hace en una <stron>plataforma</stron> (sesiones clase, materiales de apoyo, actividades, evaluaciones) que propicie un Ambiente Virtual de Aprendizaje - AVA y Objetos Virtuales de Aprendizaje- OVAS. </p>
								<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
								<p>La Unidad Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
								<!--				<a class="pull-right" target="_blank" href="https://www.orgsolidarias.gov.co/sites/default/files/archivos/Res_110%20del%2031%20de%20marzo%20de%202016.pdf">Recurso de la resolución 110</a>-->
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
								<button type="button" class="btn btn-siia btn-sm pull-right" id="acepto_mod_virtual">Sí, acepto. <i class="fa fa-check"></i></button>
							</div>
						</div>
					</div>
				</div>
				<?php if ($aplicacion): ?>
					<hr />
					<label>Plataforma:</label>
					<table id="" width="100%" border=0 class="table table-striped table-bordered">
						<thead>
						<tr>
							<td>URL aplicación</td>
							<td>Usuario aplicación</td>
							<td>Contraseña aplicación</td>
							<td>Acción</td>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php
						for ($i = 0; $i < count($aplicacion); $i++):
							echo "<tr><td>" . $aplicacion[$i]->urlAplicacion . "</td>";
							echo "<td>" . $aplicacion[$i]->usuarioAplicacion . "</td>";
							echo "<td>" . $aplicacion[$i]->contrasenaAplicacion . "</td>";
							if ($nivel != '7'):
								echo "<td><button class='btn btn-danger btn-sm eliminarDatosPlataforma' data-id-datosPlataforma=" . $aplicacion[$i]->id_datosAplicacion . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
							endif;
							echo "</tr>";
						endfor;
						?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
			<!-- Formulario Datos En Lina 8 -->
			<div id="datos_en_linea" data-form="7" class="formulario_panel">
				<h3>7. Datos modalidad hibrida<i class="fa fa-globe" aria-hidden="true"></i></h3>
				<p>Ingrese los datos de las herramientas a utilizar en esta modalidad dentro del curso.</p>
				<?php echo form_open('', array('id' => 'formulario_modalidad_en_linea')); ?>
				<!-- Nombre de la herramienta-->
				<!-- <div class="form-group">
					<label for="nombre_herramienta">Nombre de la herramienta:<span class="spanRojo">*</span></label>
					<input type="text" class="form-control" name="nombre_herramienta" id="nombre_herramienta" placeholder="Ej: MSTeams, Meet, Zoom, Skype, WhastApp, entre otros..." required>
				</div> -->
				<!-- Descripción de la herramienta-->
				<!-- <div class="form-group">
					<label for="descripcion_herramienta">Breve descripción de la utilización educativa de la herramienta en línea:<span class="spanRojo">*</span></label>
					<textarea type="text" class="form-control" name="descripcion_herramienta" id="descripcion_herramienta" placeholder="Registre la descripción de la herramienta" required></textarea>
				</div> -->
				<!-- Check Aceptar Modalidad En Linea -->
				<!-- <div class="form-group">
					<label class="underlined">
						<input type="checkbox" id="acepta_mod_en_linea" form="formulario_programas" name="acepta_mod_en_linea" value="Si Acepto" disabled required>
						<label for="acepta_mod_en_linea">&nbsp;</label>
						<a data-toggle="modal" data-target="#modalAceptarEnLinea" data-backdrop="static" data-keyboard="false">
							<span class="spanRojo">*</span>¿Acepta modalidad en línea?
						</a>
					</label>
				</div>
				<hr /> -->

				<!-- Botón para guardar datos -->
				<!-- <button class="btn btn-siia btn-md" style="width: 100%" name="guardar_formulario_modalidad_en_linea" id="guardar_formulario_modalidad_en_linea" data-id="<?php echo $solicitud->idSolicitud; ?>">Guardar datos <i class="fa fa-check" aria-hidden="true"></i></button>
				<hr /> -->
				<?php echo form_close() ?>
				<!-- Modal Aceptar Modalidad En Línea -->
				<div class="modal fade" id="modalAceptarEnLinea" tabindex="-1" role="dialog" aria-labelledby="modalAceptarEnLinea">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<div class="row">
									<div id="header_politicas" class="col-md-12">
										<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
									</div>
									<div class="clearfix"></div>
									<hr />
									<div class="col-md-12">
										Recomendaciones Modalidad En Línea
									</div>
								</div>
							</div>
							<div class="modal-body">
								<p>De acuerdo a lo establecido en el parágrafo número 2 del artículo 6 de la resolución 152 del 23 de junio del 2022, las entidades que soliciten la acreditación por la modalidad en línea, deben tener en cuenta lo siguiente:</p>
								<p><strong>Parágrafo 2.</strong> Para la acreditación de los programas de educación en economía solidaria bajo modalidad línea, aquella donde los docentes y participantes interactúan a través de recursos tecnológicos. La mediación tecnológica puede ser a través de herramientas tecnológica (Zoom, Teams, Meet, Good Meet, entre otras) plataformas de comunicación, chats, foros, videoconferencias, grupos de discusión, caracterizadas por encuentros sincrónicos.</strong> </p>
								<p>Recuerde desarrollar el proceso formativo acorde a lo establecido en el anexo técnico.</p>
								<p>La Unida Solidaria realizará seguimiento a las organizaciones acreditadas en el cumplimiento de los programas de educación solidaria acreditados.</p>
								<!--				<a class="pull-right" target="_blank" href="https://www.orgsolidarias.gov.co/sites/default/files/archivos/Res_110%20del%2031%20de%20marzo%20de%202016.pdf">Recurso de la resolución 110</a>-->
								<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
								<button type="button" class="btn btn-siia btn-sm pull-right" id="acepto_mod_en_linea" value="Si Acepta">Sí, acepto. <i class="fa fa-check"></i></button>
							</div>
						</div>
					</div>
				</div>
				<!-- Tabla herramientas -->
				<?php if ($datosEnLinea): ?>
					<label>Datos de herramientas:</label>
					<table id="" width="100%" border=0 class="table table-striped table-bordered">
						<thead>
						<tr>
							<td>Herramienta</td>
							<td>Descripción</td>
							<td>Fecha de registro</td>
							<td>Acción</td>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php for ($i = 0; $i < count($datosEnLinea); $i++):
							echo "<tr><td>" . $datosEnLinea[0]->nombreHerramienta . "</td>";
							echo "<td> <textarea style='width: 282px; height: 110px; resize: none; border: hidden' ' readonly> " . $datosEnLinea[0]->descripcionHerramienta . "</textarea></td>";
							echo "<td>" . $datosEnLinea[0]->fecha . "</td>";
							if ($nivel != '7'):
								echo "<td><button class='btn btn-danger btn-sm eliminarDatosEnlinea' data-id=" . $datosEnLinea[0]->id . ">Eliminar <i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
							endif;
							echo '</tr>';
						endfor; ?>
						</tbody>
					</table>
				<?php endif	?>
			</div>
			<!-- Continuar para finalizar Acreditación -->
			<div id="finalizar_proceso" data-form="0" class="formulario_panel mt-5">
				<div id="verificacion_formularios"></div>
				<div class="jumbotron" id="verificar_btn">
					<h4>¿Desea finalizar el proceso?</h4>
					<p>Si ya adjunto todos los documentos e información necesaria para la solicitud, de clic en sí, y espere a las observaciones si existen por parte del evaluador.</p>
					<button class="btn btn-danger btn-sm" id="finalizar_no">No, voy a verificar <i class="fa fa-times" aria-hidden="true"></i></button>
					<button class="btn btn-siia btn-sm" id="finalizar_si" data-id="<?php echo $solicitud->idSolicitud ?>">Si, terminar <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
				</div>
			</div>
			<!-- Modal Cursos -->
			<div class="modal fade" id="modalCursoBasico" tabindex="-1" role="dialog" aria-labelledby="modalCursoBasico">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div id="header_politicas" class="col-md-12">
									<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
								</div>
								<div class="clearfix"></div>
								<hr />
								<div class="col-md-12" style="text-align: center">
									<object data="<?php echo base_url(); ?>assets/metodologiaResolucion/CursoBasico.html" type="text/html" width="750" height="1220"></object>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-siia btn-sm pull-right" id="aceptar_curso_basico_es" data-programa="Acreditación Curso Básico de Economía Solidaria" data-modal="modalCursoBasico" data-check="check_curso_basico_es" data-id="<?php echo $solicitud->idSolicitud; ?>">Sí, acepto. <i class="fa fa-check"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalAval" tabindex="-1" role="dialog" aria-labelledby="modalAval">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div id="header_politicas" class="col-md-12">
									<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
								</div>
								<div class="clearfix"></div>
								<hr />
								<div class="col-md-12" style="text-align: center">
									<object data="<?php echo base_url(); ?>assets/metodologiaResolucion/CursoAval.html" type="text/html" width="750" height="1220"></object>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-siia btn-sm pull-right" id="aceptar_aval_trabajo" data-programa="Acreditación Aval de Trabajo Asociado" data-modal="modalAval" data-check="check_curso_basico_aval" data-id="<?php echo $solicitud->idSolicitud; ?>">Sí, acepto. <i class="fa fa-check"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalCursoMedio" tabindex="-1" role="dialog" aria-labelledby="modalCursoMedio">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div id="header_politicas" class="col-md-12">
									<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
								</div>
								<div class="clearfix"></div>
								<hr />
								<!-- Tablas de cursos -->
								<div class="col-md-12" style="text-align: center">
									<object data="<?php echo base_url(); ?>assets/metodologiaResolucion/CursoMedio.html" type="text/html" width="750" height="1100"></object>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-siia btn-sm pull-right" id="aceptar_curso_medio_es" data-programa="Acreditación Curso Medio de Economía Solidaria" data-modal="modalCursoMedio" data-check="check_curso_medio_es" data-id="<?php echo $solicitud->idSolicitud; ?>">Sí, acepto. <i class="fa fa-check"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalCursoAvanzado" tabindex="-1" role="dialog" aria-labelledby="modalCursoAvanzado">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div id="header_politicas" class="col-md-12">
									<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
								</div>
								<div class="clearfix"></div>
								<hr />
								<!-- Tablas de cursos -->
								<div class="col-md-12" style="text-align: center">
									<object data="<?php echo base_url(); ?>assets/metodologiaResolucion/CursoAvanzado.html" type="text/html" width="750" height="1220"></object>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-siia btn-sm pull-right" id="aceptar_avanzado_medio_es" data-programa="Acreditación Curso Avanzado de Economía Solidaria" data-modal="modalCursoAvanzado" data-check="check_curso_avanzado_es" data-id="<?php echo $solicitud->idSolicitud; ?>">Sí, acepto. <i class="fa fa-check"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modalCursoFinanciera" tabindex="-1" role="dialog" aria-labelledby="modalCursoFinanciera">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="row">
								<div id="header_politicas" class="col-md-12">
									<img alt="logo" id="imagen_header_politicas" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">

								</div>
								<div class="clearfix"></div>
								<hr />
								<!-- Tablas de cursos -->
								<div class="col-md-12" style="text-align: center">
									<object data="<?php echo base_url(); ?>assets/metodologiaResolucion/CursoFinanciera.html" type="text/html" width="750" height="1000"></object>
								</div>
							</div>
						</div>
						<div class="modal-body">
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, declino. <i class="fa fa-times" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-siia btn-sm pull-right" id="aceptar_educacion_financiera" data-programa="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" data-modal="modalCursoFinanciera" data-check="check_curso_economia_financiera" data-id="<?php echo $solicitud->idSolicitud; ?>">Sí, acepto. <i class="fa fa-check"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
