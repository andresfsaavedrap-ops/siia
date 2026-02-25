<?php

/***
 * @var $solicitudesSinAsignar
 * @var $solicitudesAsignadas
 * @var $administradores
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<script src="<?= base_url('assets/js/functions/admin/modules/solicitudes/asignacion.js?v=1.0.1') . time() ?>" type="module"></script>
<div class="container">
	<div class="row">
		<div class="col-md-12" id="admin_ver_finalizadas">
			<div class="clearfix"></div>
			<hr />
			<!-- Tablas -->
			<!-- Tabla solicitudes sin asignar -->
			<?php if ($solicitudesSinAsignar): ?>
				<h3>Solicitudes sin asignar:</h3>
				<br>
				<div class="table">
					<table id="tabla_sinasignar" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td class="col-md-2">NIT</td>
								<td class="col-md-2">Organización</td>
								<td class="col-md-2">ID Solicitud</td>
								<td class="col-md-2">Tipo</td>
								<td class="col-md-2">Motivo</td>
								<td class="col-md-2">Modalidad</td>
								<td class="col-md-2">Fecha de finalización</td>
								<td class="col-md-2">Asignada a</td>
								<td class="col-md-2">Acción</td>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php
							foreach ($solicitudesSinAsignar as $solicitud) {
								if ($solicitud->asignada == "SIN ASIGNAR") {
									echo "<tr>";
									echo "<td>" . $solicitud->numNIT . "</td>";
									echo "<td>" . $solicitud->nombreOrganizacion . "</td>";
									echo "<td>" . $solicitud->idSolicitud . "</td>";
									echo "<td>" . $solicitud->tipoSolicitud . "</td>";
									echo "<td><textarea class='text-area-ext'>" . $solicitud->motivoSolicitud . "</textarea></td>";
									echo "<td>" . $solicitud->modalidadSolicitud . "</td>";
									echo "<td>" . $solicitud->fechaFinalizado . "</td>";
									echo "<td>" . $solicitud->asignada . "</td>";
									echo "<td class='verFinOrgInf'><button class='btn btn-siia btn-sm' id='verModalAsignar' data-organizacion='" . $solicitud->id_organizacion . "' data-nombre='" . $solicitud->nombreOrganizacion . "' data-nit='" . $solicitud->numNIT . "' data-solicitud='" . $solicitud->idSolicitud . "' data-toggle='modal' data-target='#asignarOrganizacion'>Asignar <i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="clearfix"></div>
				<hr />
			<?php else: ?>
				<div class="container">
					<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="alert-heading">Solicitudes Sin Asignar: </h4>
						<p>En este momento no existen solicitudes pendientes por asignar a los evaluadores</p>
						<hr>
						<p class="mb-0">En el momento que se finalicen nuevas solicitudes, se mostrarán en este espacio para ser asignadas.</p>
					</div>
				</div>
			<?php endif; ?>
			<!-- Tabla solicitudes sin asignar -->
			<?php if ($solicitudesAsignadas): ?>
				<h3>Solicitudes Asignadas:</h3>
				<br>
				<div class="table">
					<table id="tabla_asginadas" width="100%" border=0 class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td class="col-md-2">NIT</td>
								<td class="col-md-2">Organización</td>
								<td class="col-md-2">ID Solicitud</td>
								<td class="col-md-2">Tipo</td>
								<td class="col-md-2">Motivo</td>
								<td class="col-md-2">Modalidad</td>
								<td class="col-md-2">Fecha de finalización</td>
								<td class="col-md-2">Asignada a</td>
								<td class="col-md-2">Acción</td>
							</tr>
						</thead>
						<tbody id="tbody">
							<?php
							foreach ($solicitudesAsignadas as $solicitud) {
								if ($solicitud->asignada != "SIN ASIGNAR") {
									echo "<tr>";
									echo "<td>" . $solicitud->numNIT . "</td>";
									echo "<td>" . $solicitud->nombreOrganizacion . "</td>";
									echo "<td>" . $solicitud->idSolicitud . "</td>";
									echo "<td>" . $solicitud->tipoSolicitud . "</td>";
									echo "<td><textarea class='text-area-ext'>" . $solicitud->motivoSolicitud . "</textarea></td>";
									echo "<td>" . $solicitud->modalidadSolicitud . "</td>";
									echo "<td>" . $solicitud->fechaFinalizado . "</td>";
									echo "<td>" . $solicitud->asignada . "</td>";
									echo "<td class='verFinOrgInf'><button class='btn btn-siia btn-sm' id='verModalAsignar' data-organizacion='" . $solicitud->id_organizacion . "' data-nombre='" . $solicitud->nombreOrganizacion . "' data-nit='" . $solicitud->numNIT . "' data-solicitud='" . $solicitud->idSolicitud . "' data-toggle='modal' data-target='#asignarOrganizacion'>Asignar <i class='fa fa-pencil' aria-hidden='true'></i></a></td>";
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="container">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert alert-success" role="alert">
						<h4 class="alert-heading">Solicitudes Asignadas: </h4>
						<p>En este momento no existen solicitudes asignadas a los evaluadores</p>
						<hr>
						<p class="mb-0">En el momento que se asignen solicitudes, se mostrarán en este espacio.</p>
					</div>
				</div>
			<?php endif; ?>
			<button class="btn btn-danger btn-sm pull-left" id="admin_ver_org_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
			<!-- Modal asignación-->
			<div class="modal fade" id="asignarOrganizacion" tabindex="-1" role="dialog" aria-labelledby="ariaAsignar">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="ariaAsignar">Asignar evaluador a está solicitud</h3>
							<small>Si no encuentra el evaluador que busca, puede que exista en el sistema y este deshabilitado o tenga otro rol. En ese caso debe comunicarse con soporte TICS.</small>
						</div>
						<div class="modal-body">
							<p>Seleccione de la siguiente lista los usuarios que tienen el rol de evaluadores para que pueda asignarlo a una organización y que pueda verificar la solicitud.</p>
							<hr />
							<select name="evaluadorAsignar" id="evaluadorAsignar" class="selectpicker form-control show-tick" required="">
								<?php foreach ($administradores as $administrador):
									if ($administrador->nivel == 1): ?>
										<option id="<?php echo $administrador->id_administrador; ?>" value="<?php echo $administrador->usuario; ?>"><?php echo $administrador->primerNombreAdministrador . " " . $administrador->primerApellidoAdministrador; ?></option>
								<?php endif;
								endforeach; ?>
							</select>
							<div class="clearfix"></div>
							<hr />
							<p>ID de la organización:</p><label id="idAsigOrg"></label>
							<p>Nombre de la organización:</p><label id="nombreAsigOrg"></label>
							<p>Número NIT:</p><label id="nitAsigOrg"></label>
							<p>ID Solicitud:</p><label id="idSolicitud"></label>
							<hr />
							<p>Luego haber seleccionado al usuario, puede dar clic en asignar para que se haga lo siguiente:</p>
							<ul>
								<li>Se le enviará un correo a la persona con la información de la organización.</li>
								<li>Solamente esa persona podrá acceder a ver la solicitud de la organización.</li>
							</ul>
							<div class="clearfix"></div>
							<hr />
							<button type="button" class="btn btn-sm btn-success btn-block" id="asignarOrganizacionEvaluador">Asignar... <i class="fa fa-check" aria-hidden="true"></i></button>
							<div class="clearfix"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-danger pull-left" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
