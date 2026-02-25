<?php
/***
 * @var $organizaciones
 *
 */
?>
<div class="container">
	<div class="row">
		<div class="col-md-12" id="admin_panel_org_inscritas">
			<div class="clearfix"></div>
			<hr/>
			<h4>Organizaciones Inscritas:</h4>
			<br/>
			<div class="table">
				<table id="tabla_organizaciones_inscritas" width="100%" border=0 class="table table-striped table-bordered tabla_form">
					<thead>
					<tr>
						<td>NIT</td>
						<td>Nombre</td>
						<td>Representante Legal</td>
						<td>Dirección E-Mail Org</td>
						<td>Dirección E-Mail Rep</td>
						<td>Estado actual</td>
						<td>Acciones</td>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php foreach ($organizaciones as $organizacion): ?>
						<tr>
							<td><?php echo $organizacion->numNIT ?></td>
							<td><?php echo $organizacion->nombreOrganizacion ?></td>
							<td><?php echo $organizacion->primerNombreRepLegal . " " . $organizacion->primerApellidoRepLegal?></td>
							<td><?php echo $organizacion->direccionCorreoElectronicoOrganizacion ?></td>
							<td><?php echo $organizacion->direccionCorreoElectronicoRepLegal ?></td>
							<td><?php echo $organizacion->estado ?></td>
							<td>
								<div class='btn-group-vertical' role='group' aria-label='acciones'>
									<button class='btn btn-siia btn-sm ver_organizacion_inscrita' data-organizacion='<?php echo $organizacion->id_organizacion; ?>' data-solicitud='<?php echo $organizacion->idSolicitudAcreditado; ?>'>
										Ver Organización <i class='fa fa-eye' aria-hidden='true'></i>
									</button>
									<button class='btn btn-primary btn-sm ver_resolucion_org' data-organizacion='<?php echo $organizacion->id_organizacion; ?>' data-solicitud='<?php echo $organizacion->idSolicitudAcreditado; ?>'>
										Ver Resoluciones <i class='fa fa-eye' aria-hidden='true'></i>
									</button>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<button class="btn btn-danger btn-sm pull-left" id="admin_panel_org_inscritas_volver btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>Volver al panel principal</button>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row" id="datos_organizaciones_inscritas">
		<h4>Datos Básicos de la Organización:</h4>
		<div class="col-12 card" id="datos_basicos" style="padding: 10px">
				<div class="col-4" style="float: left; margin-right: 20px">
					<img class="img-responsive thumbnail" src="" id="inscritas_imagenOrganizacion_organizacion" height="200" width="200">
				</div>
				<div class="col-8" style="display: inline-block; vertical-align:top;">
					<label>Nombre de la organización:</label><br>
					<span id="inscritas_nombre_organizacion"></span>
					<label>NIT Organización:</label><br>
					<span id="inscritas_nit_organizacion"></span>
					<label>Sigla de la Organización:</label><br>
					<span id="inscritas_sigla_organizacion"></span>
					<label>Nombre del Representante Legal de la Organización:</label><br>
					<span id="inscritas_nombreRepLegal_organizacion"></span>
					<label>Correo Electrónico de la Organización:</label><br>
					<span id="inscritas_direccionCorreoElectronicoOrganizacion_organizacion"></span>
					<label>Correo Electrónico del Representante de la Organización:</label><br>
					<span id="inscritas_direccionCorreoElectronicoRepLegal_organizacion"></span>
					<label>Nombre de Usuario:</label><br>
					<span id="inscritas_usuario"></span>
				</div>
				<hr>
				<ul class="nav nav-tabs role="tablist">
				<li class="nav-item" role="presentation">
					<button class="btn btn-siia" id="verSolicitudesRegistradas">Solicitudes Registradas <i class="fa fa-ticket" aria-hidden="true"></i></button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="btn btn-siia" id="verActividadUsuario">Actividad Usuario <i class="fa fa-eye" aria-hidden="true"></i></button>
				</li>
				</ul>
		</div>
		<!-- Tabla Solicitudes realizadas -->
		<div class="col-12" id="solicitudesOrganizacion">
			<hr>
			<h4>Solicitudes Realizadas</h4>
			<p>Aquí se muestran las solicitudes por organización.</p>
			<table id="tabla_solicitudes_organizacion" width="100%" border=0 class="table table-striped table-bordered">
				<thead>
					<tr>
						<td class="col-md-3"><label>ID Solicitud</label></td>
						<td class="col-md-3"><label>Estado</label></td>
						<td class="col-md-3"><label>Fecha Creación</label></td>
						<td class="col-md-3"><label>Evaluador</label></td>
						<td class="col-md-3"><label>Modalidad</label></td>
						<td class="col-md-3"><label>Motivo</label></td>
						<td class="col-md-3"><label>Tipo</label></td>
						<td class="col-md-3"><label>Acción</label></td>
					</tr>
				</thead>
				<tbody id="tbody_solicitudes">
				</tbody>
			</table>
			<hr>
		</div>
		<!-- Tabla Actividad -->
		<div class="col-12" id="actividadOrganizacion">
			<hr>
			<h4>Registro de Actividad</h4>
			<p>Aquí se muestran los últimos 70 registros del usuario.</p>
			<table id="tabla_actividad_inscritas" width="100%" border=0 class="table table-striped table-bordered">
				<thead>
					<tr>
						<td class="col-md-3"><label>Actividad</label></td>
						<td class="col-md-3"><label>Fecha</label></td>
						<td class="col-md-3"><label>Dirección IP</label></td>
						<td class="col-md-3"><label>Explorador</label></td>
					</tr>
				</thead>
				<tbody id="tbody_actividad">
				</tbody>
			</table>
			<hr>
		</div>
		<br>
		<button class="btn btn-danger pull-left btn-sm" id="admin_ver_inscritas_tabla"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
		<!--		<button class="btn btn-siia pull-right btn-sm" id="verTodaInformacion">Ver toda la información registrada <i class="fa fa-eye" aria-hidden="true"></i></button>-->
	</div>
</div>
