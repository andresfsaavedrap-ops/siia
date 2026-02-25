<div class="container">
<div class="clearfix"></div>
<hr/>
	<h4>
	<label>Información a tener en cuenta:</label>
	<li>Despúes de haber hecho la visita debe hacer click en </li> 
	<li>Debe ingresar la fecha y hora de la visita. <small>DIA/MES/AÑO HORA:MINUTOS PM/AM</small></li> 
	<li>Al momento de dar click en el boton <button class="btn btn-siia">Crear Visita</button>, se le informara a la organización.</li>
	</h4>
	<div class="clearfix"></div>
	<hr/>
	<h4>Crear una visita a una organizacion:</h4>
	<div class="form-group col-md-4">
		<label for="organizacionVisita">Seleccione la organizacion a visitar:*</label>
		<select name="organizacionVisita" id="organizacionVisita" class="selectpicker form-control show-tick" required="">
		<?php
		foreach($organizaciones as $organizacion){	
		?>
			<option class="organizaciones" data-id="<?php echo $organizacion->id_organizacion; ?>" value="<?php echo $organizacion->nombreOrganizacion; ?>"><?php echo $organizacion->nombreOrganizacion; ?></option>
		<?php
		}
		?>
		</select>
	</div>
	<div class="form-group col-md-4">
	    <label for="fechaVisita">Fecha-Hora de la visita:</label>
		<input type="datetime-local" class="form-control" id="fechaVisita">
	</div>
	<div class="form-group col-md-4">
	    <label for="encargadoVisita">Encargado de la visita:</label>
		<select name="encargadoVisita" id="encargadoVisita" class="selectpicker form-control show-tick" required="">
		<?php
		foreach($administradores as $administrador){	
		?>
			<option id="<?php echo $administrador->id_administrador; ?>" value="<?php echo $administrador->usuario; ?>"><?php echo $administrador->primerNombreAdministrador." ".$administrador->primerApellidoAdministrador; ?></option>
		<?php
		}
		?>
		</select>
	</div>
	<div class="col-md-12">
		<button class="btn btn-danger pull-left" id="admin_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
		<button class="btn btn-siia pull-right" id="adminCrearVisita">Crear visita <i class="fa fa-check" aria-hidden="true"></i></button>
	</div>
</div>
<div class="container">
<hr/>
<h3>Mis visitas:</h3>
<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">
	<thead>
		<tr>
			<td>Organizacion</td>
			<td>Fecha</td>
			<td>Hora</td>
			<td>Terminada</td>
			<td>Accion</td>
		</tr>
	</thead>
	<tbody id="tbody">
	<?php 
		foreach ($visitas as $visita) {
			echo "<tr><td>$visita->nombreOrganizacionVisita</td>";
			echo "<td>$visita->fechaVisita</td>";
			echo "<td>$visita->horaVisita</td>";
			if($visita->terminada == '0'){ echo "<td>No</td>"; }else if($visita->terminada == '1'){ echo "<td>Si</td>"; }
			echo "<td><button class='btn btn-siia adminVerVisita' data-idOrg='$visita->organizaciones_id_organizacion' data-toggle='modal' data-fecha='$visita->fechaVisita' data-hora='$visita->horaVisita' data-id='$visita->id_visitas' data-terminada='$visita->terminada' data-target='#verVisita'>Detalles</button></td></tr>";
		}	
	?>
	</tbody>
</table>
</div>
<div class="container">
<hr/>
	<h3>Crear seguimiento</h3>
	<div class="form-group col-md-6">
		<label for="organizacionSeguimiento">Seleccione la organización del seguimiento:*</label>
		<select name="organizacionSeguimiento" id="organizacionSeguimiento" class="selectpicker form-control show-tick" required="">
		<?php
		foreach($organizaciones as $organizacion){	
		?>
			<option class="organizaciones" data-id="<?php echo $organizacion->id_organizacion; ?>" value="<?php echo $organizacion->nombreOrganizacion; ?>"><?php echo $organizacion->nombreOrganizacion; ?></option>
		<?php
		}
		?>
		</select>
	</div>
	<div class="form-group col-md-6">
	    <label for="descripcionSeguimiento">Descripción de seguimiento:</label>
		<textarea class="form-control" name="descripcionSeguimiento" id="descripcionSeguimiento"></textarea>
	</div>
	<div class="col-md-12">
		<button class="btn btn-siia pull-right" id="adminCrearSeguimiento">Crear seguimiento <i class="fa fa-check" aria-hidden="true"></i></button>
	</div>
</div>
<div class="container-fluid">
<hr/>
<h3>Seguimientos:</h3>
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
			if($seguimiento->cumpleSeguimiento == '0'){echo "<td><button class='btn btn-siia adminrespuestaAseguimiento' data-resp='$seguimiento->respuestaSeguimiento' data-idOrg='$seguimiento->organizaciones_id_organizacion' data-toggle='modal' data-fecha='$seguimiento->fechaSeguimiento' data-id='$seguimiento->id_seguimientoSimple' data-target='#darRespuesta'>Dar cumplimiento</button></td>";}else{echo "<td>Cumplio</td>";}
			echo "</tr>";
		}	
	?>
	</tbody>
</table>
</div>
<div class="modal fade" id="verVisita" tabindex="-1" role="dialog" aria-labelledby="vervisita">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h3 class="modal-title" id="vervisita">Detalles de visita:</h3>
	    </div>
	    <div class="modal-body">
	    	<div class="row">
	    		<div class="col-md-6">
	    			<div class="form-group">
	    				<h4>Fecha: <label id="modalFechaVisita"></label></h4>
					</div>
					<div class="form-group">
	    				<h4>Hora: <label id="modalHoraVisita"></label></h4>
					</div>
					<div class="form-group">
	    				<h4>Dirección: <label id="modalDirecionOrg"></label></h4>
					</div>
	    		</div>
		    	<div class="col-md-6" id="div_btn_comenzar">
		    	<h4>
				<label>Información a tener en cuenta:</label>
				<li>Si comienza la evaluacion debe terminarla.</li>
				</h4>
		    		<button class="btn btn-siia" id="comenzarEval">Comenzar evaluación <i class="fa fa-play" aria-hidden="true"></i></button>
		    	</div>
		    	<div class="clearfix"></div>
		    	<hr/>
		    	<div class="col-md-6">
		    		<h4 id="noHayResultados_seg">No hay Resultados...</h4>
		    		<div id="resultados_seguimiento">
		    		</div>
		    	</div>
		    	<div class="col-md-6">
		    		<h4 id="noHayResultados_plan">No hay Resultados...</h4>
		    		<div id="resultados_plan">
		    		</div>
		    	</div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
	    </div>
	    </div>
  	</div>
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
			    <label for="preguntaSeguimiento">Pregunta:</label>
				<textarea class="form-control" name="preguntaSeguimiento" id="preguntaSeguimiento"></textarea>
			</div>
			<div class="form-group">
				<label for="cumpleSeguimiento">¿Cumple?:</label><br>
				<div class="radio">
					<label><input type="radio" name="cumpleSeguimiento" id="Si" class="" value="1">Si</label>
					<label><input type="radio" name="cumpleSeguimiento" id="No" class="" value="0" checked>No</label>
				</div>
			</div>
			<button class="btn btn-siia" id="darRespuestaSeguimientoAdmin">Actualizar seguimiento</button>
	    </div>
	    <div class="modal-footer">
	    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
	    </div>
	    </div>
  	</div>
</div>