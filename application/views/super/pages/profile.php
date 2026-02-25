<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin">
				<div class="row">
					<!-- Perfil INICIO -->
					<div class="col-md-12">
						<div class="col-md-12">
							<div class="card mb-3" style="max-width: 540px;">
								<div class="row no-gutters">
									<div class="col-md-4">
										<img height="160" width="160"  src="<?php echo base_url('uploads/logosOrganizaciones/' . $imagen . '')?>" class="rounded center-block img-responsive" id="imagen_organizacion" alt="Logo Organización"></div>
									<div class="col-md-8">
										<div class="card-body">
											<h5 class="card-title"><?php echo $nombre_usuario; ?></h5>
											<p class="card-text"><?php echo $nombreOrganizacion; ?></p>
											<p class="card-text"><?php echo $direccionCorreoElectronicoOrganizacion; ?></p>
											<p class="card-text"><small class="text-muted">NIT. <?php echo $numNIT; ?></small></p>
										</div>
									</div>
								</div>
							</div>
							<hr/>
							<!-- Menu Tabs -->
							<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
								<!-- Btn Info Básica -->
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Información Básica</button>
								</li>
								<!-- Btn Firma RL -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Firma Representante Legal</button>
								</li>
								<!-- Btn Datos Inicio -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Datos inicio de sesión</button>
								</li>
								<!-- Btn Datos Certificados -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-certificados-tab" data-toggle="pill" data-target="#pills-certificados" type="button" role="tab" aria-controls="pills-certificados" aria-selected="false">Certificados</button>
								</li>
								<!-- Actividad reciente -->
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-actividad-tab" data-toggle="pill" data-target="#pills-actividad" type="button" role="tab" aria-controls="pills-actividad" aria-selected="false">Actividad</button>
								</li>
							</ul>
							<!-- Contenido Tabs -->
							<div class="tab-content" id="pills-tabContent">
								<!-- Contenido Tab Información Básica -->
								<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
									<!-- Imagen Logo -->
									<div class="row">
										<div class="col-md-12 grid-margin stretch-card">
											<div class="card">
												<div class="card-body">
													<h4 class="card-title">Cambio de logo de la organización</h4>
													<p class="card-description">
														La imagen tiene que ser de máximo 240px x 240px (Ancho x Alto). Formato jpeg y png.
													</p>
													<hr />
													<?php echo form_open_multipart('', array('id' => 'formulario_actualizar_imagen')); ?>
													<div class="form-group">
														<input type="file" class="file-upload-default" form="formulario_actualizar_usuario" name="imagen" id="imagen_perfil" accept="image/jpeg, image/png" required>
														<div class="input-group col-xs-12">
															<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar logo">
															<span class="input-group-append">
																<button class="file-upload-browse btn btn-primary" type="button">Buscar</button>
															</span>
														</div>
													</div>
													<button class="btn btn-primary btn-sm" id="cargar_imagen_perfil">Cargar logo<i class="fa fa-check" aria-hidden="true"></i></button>
													</form>
												</div>
											</div>
										</div>
									</div>
									<!-- Información básica -->
									<div class="row">
										<div class="col-md-12 grid-margin stretch-card">
											<div class="card">
												<div class="card-body">
													<h4 class="card-title">Información Básica</h4>
													<p class="card-description">
														Información Organización
													</p>
													<hr />
													<?php echo form_open('', array('id' => 'formulario_actualizar_perfil')); ?>
													<!-- Campos de formulario información básica -->
													<div class="row">
														<!-- Organización -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Organización</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="organizacion" id="organizacion" placeholder="Nombre Organización" value="<?php echo $nombreOrganizacion; ?>" readonly>
																</div>
															</div>
														</div>
														<!-- NIT -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">NIT Organización</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="nit" id="nit" placeholder="Numero NIT" value="<?php echo $numNIT;?>" readonly>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!-- Sigla -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Siglas</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="sigla" id="sigla" placeholder="Sigla de la organización"  value="<?php echo $sigla;?>" readonly>
																</div>
															</div>
														</div>
														<!-- Cédula -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Numero de cédula representante legal</label>
																	<input type="text" name="numCedulaCiudadaniaPersona" form="formulario_actualizar_perfil" id="numCedulaCiudadaniaPersona" placeholder="Numero de cédula..." class="form-control" required value="<?php echo $data_informacion_general ->numCedulaCiudadaniaPersona; ?>">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!-- 1er Nombre RL -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Primer Nombre representante legal</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="primer_nombre_rep_legal" id="nombre" placeholder="Primer nombre representante" required="" value="<?php echo $primerNombreRepLegal; ?>">
																</div>
															</div>
														</div>
														<!-- 2do nombre RL -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Segundo nombre del representante legal</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="segundo_nombre_rep_legal" id="nombre_s" placeholder="Segundo nombre representante" value="<?php echo $segundoNombreRepLegal; ?>">
																</div>
															</div>
														</div>

													</div>
													<div class="row">
														<!-- 1er apellido RL -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Primer apellido del representante legal</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="primer_apellido_rep_regal" id="apellido" placeholder="Primer apellido representante" required="" value="<?php echo $primerApellidoRepLegal; ?>">
																</div>
															</div>
														</div>
														<!-- 2do apellido RL -->
														<div class="col-md-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label"">Segundo apellido del representante legal</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="segundo_apellido_rep_regal" id="apellido_s" placeholder="Segundo apellido representante" value="<?php echo $segundoApellidoRepLegal; ?>">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!-- Correo electrónico representante legal -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Correo electrónico representante legal </label>
																	<input type="email" class="form-control" form="formulario_actualizar_perfil" name="correo_electronico_rep_legal" id="correo_electronico_rep_legal" placeholder="Correo electrónico del representante legal" required="" value="<?php echo $direccionCorreoElectronicoRepLegal ?>">
																</div>
															</div>
														</div>
														<!-- Correo Electrónico -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Correo electrónico (Notificaciones) </label>
																	<input type="email" class="form-control" form="formulario_actualizar_perfil" name="correo_electronico" id="correo_electronico" placeholder="Correo electrónico de la organización" required="" value="<?php echo $direccionCorreoElectronicoOrganizacion ?>">
																</div>
															</div>
														</div>

													</div>
													<div class="row">
														<!-- Tipo de Organización-->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Tipo de Organización</label>
																	<select name="tipo_organizacion" form="formulario_actualizar_perfil" id="tipo_organizacion" class="selectpicker form-control show-tick" required="">
																		<optgroup label="Actual">
																			<option id="0" value="<?php echo $data_informacion_general->tipoOrganizacion; ?>" selected><?php echo $data_informacion_general->tipoOrganizacion; ?></option>
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
														</div>
														<!-- Ámbito -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Ámbito de Actuación de la Entidad</label>
																	<br>
																	<select name="actuacion" form="formulario_actualizar_perfil" id="actuacion" class="selectpicker form-control show-tick" required="">
																		<optgroup label="Actual">
																			<option id="0" value="<?php echo $data_informacion_general->actuacionOrganizacion; ?>" selected><?php echo $data_informacion_general->actuacionOrganizacion; ?></option>
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
													</div>
													<div class="row">
														<!-- Tipo Educación -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Tipo de Educación</span></label>
																	<select name="educacion" form="formulario_actualizar_perfil" id="educacion" class="selectpicker form-control show-tick" required="">
																		<optgroup label="Actual">
																			<option id="0" value="<?php echo $data_informacion_general->tipoEducacion; ?>" selected><?php echo $data_informacion_general->tipoEducacion; ?></option>
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
													</div>
													<hr />
													<p class="card-description">
														Información de Contacto
													</p>
													<hr/>
													<div class="row">
														<!-- Departamento -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Departamento</label>
																	<select name="departamentos" form="formulario_actualizar_perfil" id="departamentos" data-id-dep="1" class="selectpicker form-control show-tick departamentos" required="">
																		<optgroup label="Actual">
																			<option id="0" value="<?php echo $data_informacion_general->nomDepartamentoUbicacion; ?>" selected><?php echo $data_informacion_general->nomDepartamentoUbicacion; ?></option>
																		</optgroup>
																		<optgroup label="Actualizar">
																			<?php
																			foreach($departamentos as $departamento){
																				?>
																				<option id="<?php echo $departamento->id_departamento; ?>" value="<?php echo $departamento->nombre; ?>"><?php echo $departamento->nombre; ?></option>
																				<?php
																			}
																			?>
																		</optgroup>
																	</select>
																</div>
															</div>
														</div>
														<!-- Municipios -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<div id="div_municipios">
																		<label class="col-sm-12 col-form-label">Municipio: <span class="spanRojo">*</span></label>
																		<select name="municipios" id="municipios" form="formulario_actualizar_perfil" class="selectpicker form-control show-tick municipios" required=>
																			<optgroup label="Actual">
																				<option id="0" value="<?php echo $data_informacion_general->nomMunicipioNacional; ?>" selected><?php echo $data_informacion_general->nomMunicipioNacional; ?></option>
																			</optgroup>
																			<optgroup label="Actualizar">
																				<?php
																				foreach($municipios as $municipio){
																					?>
																					<option id="<?php echo $municipio->id_municipio; ?>" value="<?php echo $municipio->nombre; ?>"><?php echo $municipio->nombre; ?></option>
																					<?php
																				}
																				?>
																			</optgroup>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!-- Dirección -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Dirección: <span class="spanRojo">*</span></label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="direccion" id="direccion" required="" placeholder="Dirección" value="<?php echo $data_informacion_general ->direccionOrganizacion; ?>">
																</div>
															</div>
														</div>
														<!-- Dirección Web -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Dirección Web</label>
																	<input type="text" name="urlOrganizacion" form="formulario_actualizar_perfil" id="urlOrganizacion" placeholder="www.orgsolidarias.gov.co" class="form-control" value="<?php echo $data_informacion_general ->urlOrganizacion; ?>">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<!-- Teléfono -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Teléfono - Celular</label>
																	<input type="text" name="fax" id="fax" form="formulario_actualizar_perfil" class="form-control" required="" placeholder="Fax - Teléfono" value="<?php echo $data_informacion_general ->fax; ?>">
																	<div class="checkbox">
																		<label class="col-sm-12 col-form-label"><input type="checkbox" name="extension_checkbox" id="extension_checkbox" class=""> ¿Tiene Extensión?</label>
																	</div>
																</div>
															</div>
														</div>
														<!-- Extensión -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<div  id="div_extension">
																		<label class="col-sm-12 col-form-label">Extensión</label>
																		<input type="text" name="extension" form="formulario_actualizar_perfil" id="extension" class="form-control" placeholder="Extensión" value="<?php echo $data_informacion_general->extension; ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
													<hr />
													<h4>¿Quien actualiza la información?</h4>
													<hr />
													<div class="row">
														<!-- Primer nombre quien actualiza -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Primer nombre</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="nombre_p" id="nombre_p" placeholder="Primer Nombre" required>
																</div>
															</div>
														</div>
														<!-- Primer nombre quien actualiza -->
														<div class="col-sm-6">
															<div class="form-group row">
																<div class="col-sm-12">
																	<label class="col-sm-12 col-form-label">Primer apellido</label>
																	<input type="text" class="form-control" form="formulario_actualizar_perfil" name="apellido_p" id="apellido_p" placeholder="Primer Apellido" required>
																</div>
															</div>
														</div>
													</div>
													<button class="btn btn-primary btn-sm submit" name="actualizar_informacion" id="actualizar_informacion">Actualizar información <i class="fa fa-check" aria-hidden="true"></i></button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Contenido Tab Firma RL -->
								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Firma Representante legal</h4>
											<p class="card-description">
												Contraseña de la firma
											</p>
											<hr />
											<div class="col-md-12">
												<div class="form-group">
													<input type="password" class="form-control" form="" name="contrasena_firma_rep" id="contrasena_firma_rep" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required=""><br>
													<button class="btn btn-primary btn-sm pull-right" id="ver_fir_rep_legal">Ver firma representante <i class="fa fa-check" aria-hidden="true"></i></button>
													<img src="<?php echo base_url('uploads/logosOrganizaciones/firma/'.$firma.'')?>" class="center-block img-responsive thumbnail" id="firma_rep_legal">
												</div>
											</div>
										</div>
									</div>
									<br><br>
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Cambio de firma del representante legal</h4>
											<p class="card-description">
												La imagen actual se reemplazará con la nueva, asimismo la contraseña.
											</p>
											<hr />
											<div class="col-md-12">
												<?php echo form_open_multipart('', array('id' => 'formulario_actualizar_firma')); ?>
												<div class="form-group">
													<input type="file" class="file-upload-default" form="formulario_actualizar_firma" name="firma" id="firma" required="" accept="image/jpeg, image/png">
													<div class="input-group col-xs-12">
														<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar imagen de firma representante legal">
														<span class="input-group-append">
														  <button class="file-upload-browse btn btn-primary" type="button">Buscar</button>
														</span>
													</div>
												</div>
												<div class="form-group">
													<label>Contraseña de la firma: <span class="spanRojo">*</span></label>
													<input type="password" class="form-control" form="" name="contrasena_firma" id="contrasena_firma" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="">
												</div>
												<div class="form-group">
													<label>Vuelva a escribir la contraseña de la firma: <span class="spanRojo">*</span></label><br>
													<input type="password" class="form-control" form="" name="re_contrasena_firma" id="re_contrasena_firma" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="">
												</div>
												<button class="btn btn-primary btn-sm pull-right submit" name="actualizar_firma" id="actualizar_firma">Actualizar firma representante <i class="fa fa-check" aria-hidden="true"></i></button>
												</form>
												<hr/>
											</div>
										</div>
									</div>
								</div>
								<!-- Contenido Tab Cambio de datos de inicio -->
								<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Cambio de contraseña</h4>
											<hr />
											<?php echo form_open('', array('id' => 'formulario_actualizar_contrasena')); ?>
											<div class="form-group">
												<label for="contrasena_anterior">Contraseña anterior</label>
												<div class="pw-cont">
													<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="contrasena_anterior" id="contrasena_anterior" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="">
													<span id="show-pass4"><i class="fa fa-eye" aria-hidden="true"></i></span>
												</div>
											</div>
											<div class="form-group">
												<label for="contrasena_nueva">Contraseña nueva</label>
												<div class="pw-cont">
													<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="contrasena_nueva" id="contrasena_nueva" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="">
													<span id="show-pass5"><i class="fa fa-eye" aria-hidden="true"></i></span>
												</div>
											</div>
											<div class="form-group">
												<label for="re_contrasena_nueva">Vuelva a escribir la contraseña nueva</label>
												<div class="pw-cont">
													<input type="password" class="form-control" form="formulario_actualizar_contrasena" name="re_contrasena_nueva" id="re_contrasena_nueva" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="">
													<span id="show-pass6"><i class="fa fa-eye" aria-hidden="true"></i></span>
												</div>
											</div>
											<button class="btn btn-primary btn-sm submit" name="actualizar_contrasena" id="actualizar_contrasena">Actualizar contraseña <i class="fa fa-check" aria-hidden="true"></i></button>
											<hr/>
											</form>
										</div>
									</div>
									<br><br>
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Cambio de nombre de usuario</h4>
											<hr />
											<?php echo form_open('', array('id' => 'formulario_actualizar_usuario')); ?>
											<h4></h4>
											<div class="form-group">
												<label for="usuario_nuevo">Usuario nuevo</label>
												<input type="text" class="form-control" form="formulario_actualizar_usuario" name="usuario_nuevo" id="usuario_nuevo" placeholder="Nuevo Nombre de Usuario" required="">
											</div>
											<button class="btn btn-primary btn-sm submit" name="actualizar_usuario" id="actualizar_usuario">Actualizar nombre de usuario <i class="fa fa-check" aria-hidden="true"></i></button>
											<hr/>
											</form>
										</div>
									</div>
								</div>
								<!-- Contenido Certificados -->
								<div class="tab-pane fade" id="pills-certificados" role="tabpanel" aria-labelledby="pills-certificados-tab">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Firma de certificados:</h4>
											<p class="card-description">
												Solamente se aceptan imágenes en formato png (fondo transparente), con 450px x 300px (Ancho x Alto) para el certificado.
											</p>
											<hr />
											<?php echo form_open_multipart('', array('id' => 'formulario_firma_certifi')); ?>
											<div class="form-group">
												<input type="file" class="file-upload-default" form="formulario_firma_certifi" name="firmaCert" id="firmaCert" required="" accept="image/png">
												<div class="input-group col-xs-12">
													<input type="text" class="form-control file-upload-info" disabled="" placeholder="Cargar imagen de firma para certificados">
													<span class="input-group-append">
													  <button class="file-upload-browse btn btn-primary" type="button">Buscar</button>
													</span>
												</div>
											</div>
											<button class="btn btn-danger btn-sm pull-left submit" name="eliminar_firma_certifi" id="eliminar_firma_certifi">Eliminar firma certificados <i class="fa fa-check" aria-hidden="true"></i></button>
											<button class="btn btn-primary btn-sm pull-right submit" name="actualizar_firma_certifi" id="actualizar_firma_certifi">Actualizar firma certificados <i class="fa fa-check" aria-hidden="true"></i></button>
											</form>
										</div>
									</div>
									<hr/>
									<a href="<?php echo base_url("uploads/logosOrganizaciones/firmaCert/$firmaCert"); ?>" target="_blank">Ver firma de certificados</a>
									<hr/>
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Persona que firmara los certificados</h4>
											<hr />
											<div class="form-group">
												<label for="nombrePersonaCert">Nombre y apellido<span class="spanRojo">*</span></label>
												<input type="text" class="form-control" name="nombrePersonaCert" id="nombrePersonaCert" placeholder="Nombre..." value="<?php echo $personaCert; ?>">
											</div>
											<div class="form-group">
												<label for="cargoPersonaCert">Cargo en la organización: <span class="spanRojo">*</span></label>
												<input type="text" class="form-control" name="cargoPersonaCert" id="cargoPersonaCert" placeholder="Cargo..." value="<?php echo $cargoCert; ?>">
											</div>
											<button class="btn btn-primary btn-sm pull-right" name="actualizar_nombreCargo" id="actualizar_nombreCargo">Actualizar nombre y cargo <i class="fa fa-check" aria-hidden="true"></i></button>
										</div>
									</div>
								</div>
								<!-- Contenido Actividad -->
								<div class="tab-pane fade" id="pills-actividad" role="tabpanel" aria-labelledby="pills-actividad-tab">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Registro de actividad</h4>
											<p class="card-description">
												Aquí se describen los últimos 70 registros de las acciones con fecha, dirección IP y explorador
											</p>
											<p class="card-description">
												Usted puede descargar esta información en formato CSV, Imprimirla, abrirla en formato excel, guardar en PDF o Copiarla al portapapeles.
											</p>
											<hr />
											<!-- Actividad -->
											<div id="actividad" class="col-md-12">
												<div class="table-responsive">
													<table id="tabla_actividad" class="ttable table-striped">
														<thead>
														<tr>
															<th class="col-md-3"><label>Actividad</label></th>
															<th class="col-md-3"><label>Fecha</label></th>
															<th class="col-md-3"><label>Dirección IP</label></th>
															<th class="col-md-3"><label>Explorador</label></th>
														</tr>
														</thead>
														<tbody><?php foreach($actividad as $row): ?>
															<tr>
																<td><?php echo $row->accion; ?></td>
																<td><?php echo $row->fecha; ?></td>
																<td><?php echo $row->usuario_ip; ?></td>
																<td><?php echo $row->user_agent; ?></td>
															</tr>
														<?php endforeach; ?>

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--	</div>-->
	<!--<hr/>-->
	<!--<div class="col-md-12">-->
	<!--<h4 id="n">Notificaciones antiguas:</h4>-->
	<!--<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">-->
	<!--	<thead>-->
	<!--		<tr>-->
	<!--			<td>Titulo</td>-->
	<!--			<td>Descripcion</td>-->
	<!--			<td>Fecha</td>-->
	<!--			<td>Quien la Envia</td>-->
	<!--			<td>Quien la Recibe</td>-->
	<!--		</tr>-->
	<!--	</thead>-->
	<!--	<tbody id="tbody">-->
	<!--	--><?php
	//		foreach ($mis_notificaciones as $notificacion) {
	//			echo "<tr><td>$notificacion->tituloNotificacion</td>";
	//			echo "<td>$notificacion->descripcionNotificacion</td>";
	//			echo "<td>$notificacion->fechaNotificacion</td>";
	//			echo "<td>$notificacion->quienEnvia</td>";
	//			echo "<td>$notificacion->quienRecibe</td></tr>";
	//		}
	//	?>
	<!--	</tbody>-->
	<!--</table>-->
	<!--</div>-->
	<!--<hr/>-->
	<!-- Perfil FIN -->
