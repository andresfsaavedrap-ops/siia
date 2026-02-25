<?php

/***
 * @var $solicitudesAsignadas
 * @var Solicitudes $this
 * @var $nombre_usuario
 * @var $nivel
 */
// echo '<pre>';
// var_dump($solicitudesAsignadas);
// echo '</pre>';
// return null;
?>
<!-- Solicitudes a evaluar-->
<div class="container-fluid m-3">
	<div class="row">
		<div class="col-md-12" id="admin_ver_finalizadas">
			<div class="clearfix"></div>
			<hr />
			<h3>Solicitudes en evaluación:</h3>
			<br>
			<!-- Tabla de solicitudes en evaluación	-->
			<div class="table">
				<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
					<thead>
						<tr>
							<td class="col-md-2">Nombre</td>
							<td class="col-md-2">NIT</td>
							<td class="col-md-2">ID Solicitud</td>
							<td class="col-md-2">Tipo</td>
							<td class="col-md-2">Motivo</td>
							<td class="col-md-2">Modalidad</td>
							<td class="col-md-2">Fecha de finalización</td>
							<td class="col-md-2">Fecha Ultima Actualización</td>
							<td class="col-md-2">Asignada a</td>
							<td class="col-md-2">Fecha de asignación</td>
							<td class="col-md-2">Asignada Por:</td>
							<td class="col-md-2">Acción</td>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php
						if (is_array($solicitudesAsignadas)) {
							foreach ($solicitudesAsignadas as $solicitud) :
								if (($solicitud->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6)):
									echo "<tr>";
									echo "<td>" . $solicitud->nombreOrganizacion . "</td>";
									echo "<td>" . $solicitud->numNIT . "</td>";
									echo "<td>" . $solicitud->idSolicitud . "</td>";
									echo "<td>" . $solicitud->tipoSolicitud . "</td>";
									echo "<td><textarea class='text-area-ext' readonly>" . $solicitud->motivoSolicitud . "</textarea></td>";
									echo "<td>" . $solicitud->modalidadSolicitud . "</td>";
									echo "<td>" . $solicitud->fechaFinalizado . "</td>";
									echo "<td>" . $solicitud->fechaUltimaActualizacion . "</td>";
									echo "<td>" . $solicitud->asignada . "</td>";
									echo "<td>" . $solicitud->fechaAsignacion . "</td>";
									echo "<td>" . $solicitud->asignada_por . "</td>";
									echo "<td class='verFinOrgInf'><button class='btn btn-siia btn-sm ver_organizacion_finalizada' id='' data-organizacion='" . $solicitud->id_organizacion . "' data-solicitud='" . $solicitud->idSolicitud . "'>Ver información <i class='fa fa-eye' aria-hidden='true'></i></a></td>";
									echo "</tr>";
								endif;
							endforeach;
						} elseif (is_object($solicitudesAsignadas)) {
							$solicitud = $solicitudesAsignadas;
							if (($solicitud->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6)):
								echo "<tr>";
								echo "<td>" . $solicitud->nombreOrganizacion . "</td>";
								echo "<td>" . $solicitud->numNIT . "</td>";
								echo "<td>" . $solicitud->idSolicitud . "</td>";
								echo "<td>" . $solicitud->tipoSolicitud . "</td>";
								echo "<td><textarea class='text-area-ext' readonly>" . $solicitud->motivoSolicitud . "</textarea></td>";
								echo "<td>" . $solicitud->modalidadSolicitud . "</td>";
								echo "<td>" . $solicitud->fechaFinalizado . "</td>";
								echo "<td>" . $solicitud->fechaUltimaActualizacion . "</td>";
								echo "<td>" . $solicitud->asignada . "</td>";
								echo "<td>" . $solicitud->fechaAsignacion . "</td>";
								echo "<td>" . $solicitud->asignada_por . "</td>";
								echo "<td class='verFinOrgInf'><button class='btn btn-siia btn-sm ver_organizacion_finalizada' id='' data-organizacion='" . $solicitud->id_organizacion . "' data-solicitud='" . $solicitud->idSolicitud . "'>Ver información <i class='fa fa-eye' aria-hidden='true'></i></a></td>";
								echo "</tr>";
							endif;
						}
						?>
					</tbody>
				</table>
				<button class="btn btn-danger btn-sm pull-left" id="admin_ver_org_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
			</div>
		</div>
	</div>
</div>
<!-- Registro de observaciones por formulario -->
<div class="container" id="admin_panel_ver_finalizada">
	<div class="panel-group" id="datos_org_final">
		<!-- Despliegue de resumen de información solicitud -->
		<?php $this->load->view('admin/solicitudes/partials/_info'); ?>
		<!-- Formularios solicitud -->
		<?php $this->load->view('admin/solicitudes/partials/_forms'); ?>

	</div>
</div>
<!-- Botón y menu de navegación -->
<?php $this->load->view('admin/solicitudes/partials/_menu'); ?>
<!-- Modales con historial de observaciones -->
<?php $this->load->view('admin/solicitudes/partials/_observaciones'); ?>
