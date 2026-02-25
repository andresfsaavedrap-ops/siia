<?php

/***
 * @var $administradores
 * @var $organizaciones
 * @var $usuarios
 * @var $correos
 * @var $logged_in
 * @var $tipo_usuario
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
$CI->load->model("UsuariosModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("CorreosRegistroModel");
$CI->load->model("TokenModel");
?>
<?php if ($logged_in == FALSE && $tipo_usuario == "none"): ?>
	<div class="container">
		<div class="col-md-12">
			<h3>Contraseña:</h3>
			<div class="form-group">
				<input type="password" id="tpssp" class="form-control" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required value="">
			</div>
			<input type="button" class="btn btn-siia" id="init_sp" value="Iniciar">
		</div>
	</div>
<?php endif; ?>
<?php if ($logged_in == TRUE && $tipo_usuario == "super"): ?>
	<!-- Menu super administrador -->
	<div class="container" id="menu-super-admin">
		<hr>
		<h3 class="title">Menu súper administrador</h3>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<!-- Botón ver administradores -->
				<div class="col-md-3">
					<div class="panel panel-siia">
						<div class="panel-heading">
							<h3 class="panel-title">Ver administradores <i class="fa fa-users" aria-hidden="true"></i></h3>
						</div>
						<div class="panel-body">
							<input type="button" class="btn btn-default btn-block" data-toggle="modal" id="super-ver-admins" value="Ver administradores">
						</div>
					</div>
				</div>
				<!-- Botón ver usuarios -->
				<div class="col-md-3">
					<div class="panel panel-siia">
						<div class="panel-heading">
							<h3 class="panel-title">Ver Usuarios<i class="fa fa-users" aria-hidden="true"></i></h3>
						</div>
						<div class="panel-body">
							<input type="button" class="btn btn-default btn-block" data-toggle="modal" id="super-ver-users" value="Ver Usuarios">
						</div>
					</div>
				</div>
				<!-- Botón ver log correos -->
				<div class="col-md-3">
					<div class="panel panel-siia">
						<div class="panel-heading">
							<h3 class="panel-title">Ver Log correos <i class="fa fa-send" aria-hidden="true"></i></h3>
						</div>
						<div class="panel-body">
							<input type="button" class="btn btn-default btn-block" data-toggle="modal" id="super-ver-correos" value="Ver Correos">
						</div>
					</div>
				</div>
				<!-- Botón salir sesión súper -->
				<div class="col-md-3">
					<div class="panel panel-siia">
						<div class="panel-heading">
							<h3 class="panel-title">Crear Solicitud <i class="fa fa-book" aria-hidden="true"></i></h3>
						</div>
						<div class="panel-body">
							<input type="button" data-toggle='modal' data-target='#modal-crear-solicitud' class="btn btn-default btn-block" id="crear-solicitud" value="Crear Solicitud">
						</div>
					</div>
				</div>
				<!-- Botón salir sesión súper -->
				<div class="col-md-3">
					<div class="panel panel-siia">
						<div class="panel-heading">
							<h3 class="panel-title">Salir <i class="fa fa-sign-out" aria-hidden="true"></i></h3>
						</div>
						<div class="panel-body">
							<input type="button" class="btn btn-block btn-danger" id="super_cerrar_sesion" value="Cerrar Sesión Super">
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
	</div>
	<!-- Tabla administradores -->
	<div class="container display-4" id="super-view-admins">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<input type="button" class="btn btn-siia admin-modal pull-right" data-funct="crear" data-toggle="modal" data-target="#modal-admin" value="Crear administrador">
					<h3 class="title">Administradores</h3>
					<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td>Nombre</td>
								<td>Número de cédula</td>
								<td>Nombre usuario</td>
								<td>Correo electrónico</td>
								<td>Rol</td>
								<td>Estado</td>
								<td>Accion</td>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php foreach ($administradores as $administrador):
								echo "<td>$administrador->primerNombreAdministrador" . " " . $administrador->primerApellidoAdministrador . "</td>";
								echo "<td>$administrador->numCedulaCiudadaniaAdministrador</td>";
								echo "<td>$administrador->usuario</td>";
								echo "<td>$administrador->direccionCorreoElectronico</td>";
								echo "<td>";
								echo $CI->AdministradoresModel->getNivel($administrador->nivel);
								echo "</td>";
								echo "<td>";
								if ($administrador->logged_in == 1):
									echo 'Conectado';
								else:
									echo " Desconectado";
								endif;
								echo "</td>";
								echo "<td><button class='btn btn-siia admin-modal' data-funct='actualizar' data-toggle='modal' data-id='$administrador->id_administrador' data-target='#modal-admin'>Ver</button></td></tr>";
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Tabla Usuarios -->
	<div class="container display-4" id="super-view-users">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="title">Usuarios</h3>
					<table id="tabla_super_usuarios" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td>Organización</td>
								<td>NIT</td>
								<td>Usuario</td>
								<td>Contraseña</td>
								<td>Estado</td>
								<td>Conectado</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php
							foreach ($usuarios as $usuario):
								echo "<td> $usuario->sigla </td>";
								echo "<td>$usuario->numNIT</td>";
								echo "<td>$usuario->usuario</td>";
								echo "<td>";
								echo $CI->UsuariosModel->getPassword($usuario->contrasena_rdel);
								echo "</td>";
								echo "<td>";
								echo $CI->TokenModel->getState($usuario->verificado);
								echo "</td>";
								echo "<td>";
								echo $CI->UsuariosModel->getConnection($usuario->logged_in);
								echo "</td>";
								echo "</td>";
								echo "<td><button class='btn btn-siia admin-usuario' data-toggle='modal' data-id='$usuario->id_usuario' data-target='#modal-user'>Ver</button></td></tr>";
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Tabla Correos Logs -->
	<div class="container display-4" id="super-view-correos-log">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="title">Correos Registro</h3>
					<table id="tabla_correos_logs" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td>Fecha de envío</td>
								<td>De</td>
								<td>Para</td>
								<td>Asunto</td>
								<td>Tipo</td>
								<td>Estado</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php
							foreach ($correos as $correo):
								echo "<td> $correo->fecha </td>";
								echo "<td>$correo->de</td>";
								echo "<td>$correo->para</td>";
								echo "<td>$correo->asunto</td>";
								echo "<td>$correo->tipo</td>";
								if ($correo->error != "Enviado"):
									echo "<td><span class='spanRojo'> Error de envío </span></td>";
									echo "<td><button class='btn btn-siia ver-error-envio' data-error='$correo->error'>Ver error</button></td>";
								else:
									echo "<td><span class='spanVerde'> $correo->error </span></td>";
									echo "<td><button class='btn btn-siia disabled' data-error='$correo->error'>Ver error</button></td>";
								endif;
								echo '</tr>';
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal formulario administradores -->
	<div class="modal fade" id="modal-admin" tabindex="-1" role="dialog" aria-labelledby="verAdmin">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="verAdmin">Administrador <label id="super_id_admin_modal"></label> <span id="super_status_adm"></span></h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<?= form_open('', array('id' => 'formulario_super_administradores')); ?>
							<div class="col-md-6">
								<div class="form-group">
									<label>Primer Nombre:</label>
									<input type="text" id="super_primernombre_admin" name="super_primernombre_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Segundo Nombre:</label>
									<input type="text" id="super_segundonombre_admin" name="super_segundonombre_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Primer Apellido:</label>
									<input type="text" id="super_primerapellido_admin" name="super_primerapellido_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Segundo Apellido:</label>
									<input type="text" id="super_segundoapellido_admin" name="super_segundoapellido_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Numero de cédula:</label>
									<input type="number" id="super_numerocedula_admin" name="super_numerocedula_admin" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Extensión:</label>
									<input type="number" id="super_ext_admin" name="super_ext_admin" class="form-control">
								</div>
								<div class="form-group">
									<label>Nivel de acceso:</label><br />
									<select class="custom-select show-tick" name="super_acceso_nvl" id="super_acceso_nvl" required>
										<option value="0">Total 0</option>
										<option value="1">Evaluador 1</option>
										<option value="2">Reportes 2</option>
										<option value="3">Cámaras 3</option>
										<option value="4">Histórico 4</option>
										<option value="5">Seguimientos 5</option>
										<option value="6">Asignación 6</option>
										<option value="7">Atención al ciudadano 7</option>
									</select>
								</div>
								<div class="form-group">
									<label>Nombre usuario:</label>
									<input type="text" id="super_nombre_admin" name="super_nombre_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Contraseña:</label>
									<input type="text" id="super_contrasena_admin" name="super_contrasena_admin" class="form-control" name="" value="">
								</div>
								<div class="form-group">
									<label>Dirección correo eléctronico:</label>
									<input type="text" id="super_correo_electronico_admin" name="super_correo_electronico_admin" class="form-control" name="" value="">
								</div>
							</div>
							<?= form_close(); ?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group" role='group' aria-label='acciones'>
						<button type="button" class="btn btn-info" id="super_desconectar_admin">Desconectar</button>
						<button type="button" class="btn btn-danger" id="super_eliminar_admin">Eliminar</button>
						<button type="button" class="btn btn-siia" id="super_actualizar_admin">Actualizar</button>
						<button type="button" class="btn btn-success" id="super_nuevo_admin">Crear</button>
						<!-- <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal formulario crearsolicitud -->
	<div class="modal fade" id="modal-crear-solicitud" tabindex="-1" role="dialog" aria-labelledby="modal-crear-solicitud">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="verAdmin">Crear solicitud <label id="super_id_admin_modal"></label> <span id="super_status_adm"></span></h4>
				</div>
				<div class="modal-body">
					<?php echo form_open('', array('id' => 'crear_solicitud_sp')); ?>
					<!--Select NIT Organización -->
					<form-group class="col-md-12">
						<label for="nit-organizacion">Nit organización</label><br>
						<select name="nit-organizacion" id="nit-organizacion" class="selectpicker form-control show-tick" required>
							<?php foreach ($organizaciones as $organizacion) : ?>
								<option value="<?= $organizacion->numNIT ?>"><?= $organizacion->numNIT ?> | <?= $organizacion->sigla ?> </option>
							<?php endforeach; ?>
						</select>
					</form-group>
					<!-- CheckBox Motivos de la solicitud -->
					<form-group class="col-md-12">
						<br><label for="motivo_solicitud">Motivo de la solicitud <span class="spanRojo">*</span></label><br>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="1" id="cursoBasico" name="motivos" checked>
							<label class="form-check-label" for="cursoBasico">Acreditación Curso Básico de Economía Solidaria</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="2" id="avalTrabajo" name="motivos">
							<label class="form-check-label" for="avalTrabajo">Aval de Trabajo Asociado</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="3" id="cursoMedio" name="motivos">
							<label class="form-check-label" for="cursoMedio">Acreditación Curso Medio de Economía Solidaria</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="4" id="cursoAvanzado" name="motivos">
							<label class="form-check-label" for="cursoAvanzado">Acreditación Curso Avanzado de Economía Solidaria</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="5" id="finacieraEconomia" name="motivos">
							<label class="form-check-label" for="finacieraEconomia">Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria</label>
						</div>
					</form-group>
					<!-- Modalidad de la solicitud -->
					<form-group class="col-md-6">
						<label for="modalidad_solicitud">Modalidad <span class="spanRojo">*</span></label><br>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="1" id="presencial" name="modalidades" checked>
							<label class="form-check-label" for="presencial">Presencial</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="2" id="virtual" name="modalidades">
							<label class="form-check-label" for="virtual">Virtual</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="checkbox" value="3" id="enLinea" name="modalidades">
							<label class="form-check-label" for="enLinea">En Linea</label>
						</div>
					</form-group>
					<!-- Tipo de la solicitud -->
					<form-group class="col-md-6">
						<label for="tipo_solicitud">Tipo <span class="spanRojo">*</span></label><br>
						<div class="form-check radio">
							<input class="form-check-input" type="radio" value="Solicitud Nueva" id="nueva" name="tipos" checked>
							<label class="form-check-label" for="nueva">Solicitud Nueva</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="radio" value="Renovación de Acreditación" id="renovacion" name="tipos">
							<label class="form-check-label" for="renovacion">Renovación de Acreditación</label>
						</div>
						<div class="form-check radio">
							<input class="form-check-input" type="radio" value="Acreditación Primera vez" id="acreditacion" name="tipos">
							<label class="form-check-label" for="acreditacion">Acreditación Primera vez</label>
						</div>
						<br>
					</form-group>
					<?php echo form_close(); ?>
				</div>
				<br>
				<div class="modal-footer col-md-12">
					<div class="btn-group" role='group' aria-label='acciones'>
						<button id="btn_crear_solicitud_sp" class="btn btn-success">Crear solicitud <i class="fa fa-check" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
