<?php
/***
 * @var $solicitudes
 * @var $organizacion
 *
 */
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="clearfix"></div>
			<hr />
			<h3>Registro de solicitudes:</h3>
			<div class="form-group">
				<label>Fecha Inicio </label>
				<input class="form-control" type="date" id="min" name="min">
				<br>
				<label>Fecha Fin </label>
				<input class="form-control" type="date" id="max" name="max">
			</div>
			<br>
			<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
				<thead>
					<tr>
						<td class="col-md-1">NOMBRE DE LA ENTIDAD</td>
						<td class="col-md-1">REVISIONES</td>
						<td class="col-md-1">SIGLA</td>
						<td class="col-md-1">NÚMERO NIT</td>
						<td class="col-md-1">ID SOLICITUD</td>
						<td class="col-md-1">FECHA DE RECIBIDA</td>
						<td class="col-md-1">FECHA DE ASIGNACIÓN</td>
						<td class="col-md-1">TIPO DE SOLICITUD</td>
						<td class="col-md-1">PROGRAMA</td>
						<td class="col-md-1">MODALIDAD</td>
						<td class="col-md-1">FECHA DE OBSERVACIONES</td>
						<td class="col-md-1">VENCIMIENTO DE OBSERVACIONES</td>
						<td class="col-md-1">FECHA DE ULTIMA ACTUALIZACIÓN</td>
						<td class="col-md-1">RESOLUCIÓN</td>
						<td class="col-md-1">FECHA DE NOTIFICACIÓN</td>
						<td class="col-md-1">ESTADO</td>
						<td class="col-md-1">EVALUADOR</td>
						<td class="col-md-1">DIAS DE EVALUACIÓN</td>
						<td class="col-md-1">OBSERVACIONES</td>
					</tr>
				</thead>
				<tbody id="tbody">
					<?php
					foreach ($solicitudes as $solicitud): ?>
						<tr>
							<td><?php echo (isset($solicitud->nombreOrganizacion)) ? strtoupper($solicitud->nombreOrganizacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->numeroRevisiones)) ? strtoupper($solicitud->numeroRevisiones) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->sigla)) ? strtoupper($solicitud->sigla) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->numNIT)) ? strtoupper($solicitud->numNIT) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->idSolicitud)) ? strtoupper($solicitud->sigla) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->fechaCreacion)) ? strtoupper($solicitud->fechaCreacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->fechaAsignacion)) ? strtoupper($solicitud->fechaAsignacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->tipoSolicitud)) ? strtoupper($solicitud->tipoSolicitud) : strtoupper("Falta por actualizar datos");?></td>
							<td><textarea class='text-area-ext' readonly><?php echo (isset($solicitud->motivoSolicitud)) ? strtoupper($solicitud->motivoSolicitud) : strtoupper("Falta por actualizar datos");?></textarea></td>
							<td><?php echo (isset($solicitud->modalidadSolicitud)) ? strtoupper($solicitud->modalidadSolicitud) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->fechaUltimaRevision)) ? strtoupper($solicitud->fechaUltimaRevision) : strtoupper("Sin revisiones");?></td>
							<td><?php echo (isset($solicitud->vencimientoRevision)) ? strtoupper($solicitud->vencimientoRevision) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->fechaUltimaActualizacion)) ? strtoupper($solicitud->fechaUltimaActualizacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><a href='<?php echo base_url("uploads/resoluciones/" . $organizacion['resoluciones']->resolucion) ?>' target='_blank'>RESOLUCIÓN NÚMERO " <?php echo $organizacion['resoluciones']->numeroResolucion ?>"</a></td>
		<!--					<td>--><?php //echo strtoupper(date('d-m-Y', strtotime("+" . $organizacion["resoluciones"]->añosResolucion . " year", strtotime($organizacion["resoluciones"]->fechaResolucionInicial))))?><!--</td>-->
							<td><?php echo (isset($solicitud->fechaNotificacion)) ? strtoupper($solicitud->fechaNotificacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->nombre)) ? strtoupper($solicitud->nombre) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($solicitud->asignada)) ? strtoupper($solicitud->asignada) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($diasEvaluacion)) ? strtoupper($diasEvaluacion) : strtoupper("Falta por actualizar datos");?></td>
							<td><?php echo (isset($observaciones)) ? strtoupper($observaciones) : strtoupper("Falta por actualizar datos");?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button class="btn btn-danger btn-sm volverReporte">Volver al panel</button>
		</div>
	</div>
</div>
