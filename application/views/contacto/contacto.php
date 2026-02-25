<div class="container">
	<div class="col-md-4">
		<h3>Información de la organización.</h3>
		<hr/>
		<div class="form-group">
			<label>Nombre de la organización:</label> <p><?php echo $nombreOrganizacion; ?></p>
		</div>
		<div class="form-group">
			<label>Correo electrónico de la organización:</label> <p><?php echo $direccionCorreoElectronicoOrganizacion; ?></p>
		</div>
		<div class="form-group">
			<label>Correo electrónico del representante legal:</label> <p><?php echo $direccionCorreoElectronicoRepLegal; ?></p>
		</div>
		<div class="form-group">
			<label>Nombre del representante legal:</label> <p><?php echo $primerNombreRepLegal." ".$segundoNombreRepLegal." ".$primerApellidoRepLegal." ".$segundoApellidoRepLegal; ?></p>
		</div>
		<button class="btn btn-danger volver_al_panel"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
		<div class="clearfix"></div>
		<hr/>
	</div>
	<div class="col-md-8">
		<h4>Seleccione la prioridad del mensaje, escriba el asunto del mensaje y por ultimo escriba el mensaje.</h4>
		<hr/>
		<div class="form-group">
			<label>Correo electrónico de la organización:</label>
			<input type="text" id="contacto_correo_electronico" class="form-control" disabled name="" value="<?php echo $direccionCorreoElectronicoOrganizacion; ?>">
		</div>
		<div class="checkbox">
			<label><input type="checkbox" id="contaco_enviar_copia" class="" name=""> Enviar con copia al correo del representante legal</label>
		</div>
		<div id="contacto_copia" class="form-group">
			<label>Correo electrónico del representante legal:</label>
			<input type="text" id="contacto_correo_electronico_rep" class="form-control" disabled name="" value="<?php echo $direccionCorreoElectronicoRepLegal; ?>">
		</div>
		<div class="form-group">
			<label>Nombre</label>
			<input type="text" id="contacto_nombre" class="form-control" disabled name="" value=" <?php echo $primerNombreRepLegal." ".$segundoNombreRepLegal." ".$primerApellidoRepLegal." ".$segundoApellidoRepLegal; ?>">
		</div>
		<div class="form-group">
			<label>Prioridad:*</label>
			<br>
			<select id="contacto_prioridad" class="form-control selectpicker form-control show-tick">
				<option value="Urgente">Urgente</option>
				<option value="Importante">Importante</option>
				<option value="Ninguna">Ninguna</option>
			</select>
		</div>
		<div class="form-group">
			<label>Asunto:*</label>
			<input class="form-control" id="contacto_asunto" type="text" name="" placeholder="Asunto...">
		</div>
		<div class="form-group">
			<label>Mensaje:*</label>
			<textarea id="contacto_mensaje" class="form-control" placeholder="Mensaje..."></textarea>
		</div>
		<button class="btn btn-siia pull-right" id="enviar_correo_contacto" name="">Enviar <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
	</div>
</div>
<div class="container">
<div class="clearfix"></div>
<hr/>
	<h3>Administradores en línea:</h3>
	<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">
		<thead>
			<tr>
				<td>Nombre y Apellidos</td>
				<td>Nombre de Usuario</td>
				<td>Numero de Cedula</td>
			</tr>
		</thead>
		<tbody id="tbody">
		<?php 
			foreach ($administradores as $administrador) {
				echo "<tr><td>$administrador->primerNombreAdministrador $administrador->segundoNombreAdministrador $administrador->primerApellidoAdministrador $administrador->segundoApellidoAdministrador</td>";
				echo "<td>$administrador->usuario</td>";
				echo "<td>$administrador->numCedulaCiudadaniaAdministrador</td></tr>";
			}	
		?>
		</tbody>
	</table>
</div>