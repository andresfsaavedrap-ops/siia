<div class="container">
<div class="clearfix"></div>
<hr/>
	<h4>
	<label>Información a tener en cuenta:</label>
	<li>Debe estar pendiente en la hora y la fecha de la visita.</li>
	<li>Disposición con la persona de la Unidad Administrativa Especial de Organizaciones Solidarias.</li>
	</h4>
	<button class="btn btn-danger pull-left volver_al_panel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
</div>
<div class="col-md-12">
<hr/>
<h3>Mis visitas:</h3>
<table id="tabla_visitas" width="100%" border=0 class="table table-striped table-bordered tabla_form">
	<thead>
		<tr>
			<td>Usuario visita</td>
			<td>Fecha</td>
			<td>Hora</td>
			<td>¿Terminada?</td>
		</tr>
	</thead>
	<tbody id="tbody">
	<?php 
		foreach ($visitas as $visita) {
			echo "<tr>";
			echo "<td>$visita->usuarioVisita</td>";
			echo "<td>$visita->fechaVisita</td>";
			echo "<td>$visita->horaVisita</td>";
			if($visita->terminada == '0'){ echo "<td>No</td>"; }else if($visita->terminada == '1'){ echo "<td>Si</td>"; }
			echo "</tr>";
		}	
	?>
	</tbody>
</table>
</div>
<div class="col-md-12">
<hr/>
<h3>Mis seguimientos:</h3>
<table id="tabla_seguimientos" width="100%" border=0 class="table table-striped table-bordered tabla_form">
	<thead>
		<tr>
			<td>Organizacion</td>
			<td>Fecha</td>
			<td>Descripcion</td>
			<td>Respuesta</td>
			<td>¿Cumplio?</td>
			<td>Accion</td>
		</tr>
	</thead>
	<tbody id="tbody">
	<?php 
		foreach ($seguimientos as $seguimiento) {
			echo "<tr><td>$seguimiento->nombreOrganizacion</td>";
			echo "<td>$seguimiento->fechaSeguimiento</td>";
			echo "<td>$seguimiento->descripcionSeguimiento</td>";
			echo "<td>$seguimiento->respuestaSeguimiento</td>";
			if($seguimiento->cumpleSeguimiento == '0'){ echo "<td>No</td>"; }else if($seguimiento->cumpleSeguimiento == '1'){ echo "<td>Si</td>"; }
			if($seguimiento->cumpleSeguimiento == '0'){echo "<td><button class='btn btn-siia respuestaAseguimiento' data-desc='$seguimiento->descripcionSeguimiento' data-idOrg='$seguimiento->organizaciones_id_organizacion' data-toggle='modal' data-fecha='$seguimiento->fechaSeguimiento' data-id='$seguimiento->id_seguimientoSimple' data-target='#darRespuesta'>Dar respuesta</button></td>";}else{ echo "<td>Cumplio</td>";}
			echo "</tr>";
		}	
	?>
	</tbody>
</table>
</div>
<div class="col-md-12">
<hr/>
<h3>Mis planes de mejora:</h3>
<table id="tabla_plan" width="100%" border=0 class="table table-striped table-bordered tabla_form">
	<thead>
		<tr>
			<td>Descripción</td>
			<td>Fecha de Mejora</td>
			<td>¿Cumple?</td>
			<td>Observaciones</td>
		</tr>
	</thead>
	<tbody id="tbody">
	<?php 
		foreach ($planesMejoramiento as $plan) {
			echo "<tr>";
			echo "<td>$plan->descripcionMejora</td>";
			echo "<td>$plan->fechaMejora</td>";
			if($plan->cumple == '0'){ echo "<td>No</td>"; }else if($plan->cumple == '1'){ echo "<td>Si</td>"; }
			echo "<td>$plan->observaciones</td>";
			echo "</tr>";

		}	
	?>
	</tbody>
</table>
</div>
<div class="modal fade" id="darRespuesta" tabindex="-1" role="dialog" aria-labelledby="darrespuesta">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="darrespuesta">Respuesta a seguimiento:</h3>
	        <p>Seguimiento numero <label id="id_segModal"></label>:</p>
	        <p id="modalDescDarRespuesta"></p>
	    </div>
	    <div class="modal-body">
	    	<div class="form-group">
			    <label for="respuestaSeguimiento">Respuesta:</label>
				<textarea class="form-control" name="respuestaSeguimiento" id="respuestaSeguimiento"></textarea>
			</div>
			<button class="btn btn-siia" id="darRespuestaSeguimiento">Dar respuesta</button>
	    </div>
	    <div class="modal-footer">
	    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
	    </div>
	    </div>
  	</div>
</div>