<div class="col-md-12">
	<div id="tabla_informes">
		<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">
			<thead>
				<tr>
					<td>Acción</td>
					<td>ID</td>
					<td>Nombre</td>
					<td>Apellidos</td>
					<td>Cedula</td>
					<td>Nit</td>
					<td>Tipo Persona</td>
					<td>Genero</td>
					<td>Municipio</td>
					<td>Departamento</td>
					<td>Numero Contacto</td>
					<td>Correo Contacto</td>
					<td>Nombre Organizacion</td>
					<td>Tipo Organizacion</td>
					<td>Tema Consulta</td>
					<td>Descripcion Consulta</td>
					<td>Tipo Solicitud</td>
					<td>Canal Recepcion</td>
					<td>Canal Respuesta</td>
					<td>Fecha</td>
					<td>Duracion</td>
					<td>Hora</td>
				</tr>
			</thead>
			<tbody id="tbody">
			<?php 
				foreach ($llamadas as $llamada) {
					echo "<tr><td><button class='btn btn-siia adminVerllamada' data-id='$llamada->id_registroTelefonico' data-toggle='modal' data-toggle='modal' data-target='#verLlamada'>Editar <i class='fa fa-pencil' aria-hidden='true'></i></button></td>";
					echo "<td>$llamada->id_registroTelefonico</td>";
					echo "<td>$llamada->telefonicoNombre</td>";
					echo "<td>$llamada->telefonicoApellidos</td>";
					echo "<td>$llamada->telefonicoCedula</td>";
					echo "<td>$llamada->telefonicoNit</td>";
					echo "<td>$llamada->telefonicoTipoPersona</td>";
					echo "<td>$llamada->telefonicoGenero</td>";
					echo "<td>$llamada->telefonicoMunicipio</td>";
					echo "<td>$llamada->telefonicoDepartamento</td>";
					echo "<td>$llamada->telefonicoNumeroContacto</td>";
					echo "<td>$llamada->telefonicoCorreoContacto</td>";
					echo "<td>$llamada->telefonicoNombreOrganizacion</td>";
					echo "<td>$llamada->telefonicoTipoOrganizacion</td>";
					echo "<td>$llamada->telefonicoTemaConsulta</td>";
					echo "<td>$llamada->telefonicoDescripcionConsulta</td>";
					echo "<td>$llamada->telefonicoTipoSolicitud</td>";
					echo "<td>$llamada->telefonicoCanalRecepcion</td>";
					echo "<td>$llamada->telefonicoCanalRespuesta</td>";
					echo "<td>$llamada->telefonicoFecha</td>";
					echo "<td>$llamada->telefonicoDuracion</td>";
					echo "<td>$llamada->telefonicoHora</td></tr>";
				}	
			?>
			</tbody>
		</table>
		<button class="btn btn-danger pull-left" id="admin_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
	</div>
</div>
<div class="modal fade" id="verLlamada" tabindex="-1" role="dialog" aria-labelledby="verllamada">
  	<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h3 class="modal-title">Llamada # <span id="llamadaID"></span></h3>
		    </div>
		    <div class="modal-body">
		    	<div class="container">
		    		<div class="row">
		    			<div class="col-md-6">
		    				<div class="form-group">
				                <label>Nombres:</label>
				                <input type="text" class="form-control" name="telefonicoNombre" id="telefonicoNombreModal" placeholder="Nombre...">
				            </div>
				            <div class="form-group">
				                <label>Apellidos:</label>
				                <input type="text" class="form-control" name="telefonicoApellidos" id="telefonicoApellidosModal" placeholder="Apellidos...">
				            </div>
				            <div class="form-group">
				                <label>Cédula:</label>
				                <input type="text" class="form-control" name="telefonicoCedula" id="telefonicoCedulaModal" placeholder="Cédula...">
				            </div>
				            <div class="form-group">
				                <label>Numero NIT:</label>
				                <input type="text" class="form-control" name="telefonicoNit" id="telefonicoNitModal" placeholder="Numero de NIT...">
				            </div>
				            <div class="form-group">
				                <label>Tipo de persona:</label>
				                <select name="telefonicoTipoPersona" id="telefonicoTipoPersonaModal" class="selectpicker form-control show-tick telefonicoTipoPersona" required="">
				                    <option id="1Natural" value="Natural">Natural</option>
				                    <option id="2Juridica" value="Juridica">Juridica</option>
				                </select>
				            </div>
				            <div class="form-group">
				                <label>Genéro:</label>
				                <select name="telefonicoGenero" id="telefonicoGeneroModal" class="selectpicker form-control show-tick telefonicoGenero" required="">
				                    <option id="1Hombre" value="Hombre">Hombre</option>
				                    <option id="2Mujer" value="Mujer">Mujer</option>
				                </select>
				            </div>
				            <div class="form-group">
				                <label>Municipio:</label>
				                <input type="text" class="form-control" name="telefonicoMunicipio" id="telefonicoMunicipioModal" placeholder="Municipio...">
				            </div>
				            <div class="form-group">
				                <label>Departamento:</label>
				                <input type="text" class="form-control" name="telefonicoDepartamento" id="telefonicoDepartamentoModal" placeholder="Departamento...">
				            </div>
				            <div class="form-group">
				                <label>Numero de contacto:</label>
				                <input type="text" class="form-control" name="telefonicoNumeroContacto" id="telefonicoNumeroContactoModal" placeholder="Numero de contacto...">
				            </div>
				            <div class="form-group">
				                <label>Correo de contacto:</label>
				                <input type="text" class="form-control" name="telefonicoCorreoContacto" id="telefonicoCorreoContactoModal" placeholder="Correo de contacto...">
				            </div>
		    			</div>
		    			<div class="col-md-6">
		    				<div class="form-group">
				                <label>Nombre de la organización:</label>
				                <input type="text" class="form-control" name="telefonicoNombreOrganizacion" id="telefonicoNombreOrganizacionModal" placeholder="Nombre de la organización...">
				            </div>
				            <div class="form-group">
				                <label>Tipo de organización:</label>
				                <input type="text" class="form-control" name="telefonicoTipoOrganizacion" id="telefonicoTipoOrganizacionModal" placeholder="Tipo de organización...">
				            </div>
				            <div class="form-group">
				                <label>Tema de consulta:</label>
				                <input type="text" class="form-control" name="telefonicoTemaConsulta" id="telefonicoTemaConsultaModal" placeholder="Tema de consulta...">
				            </div>
				            <div class="form-group">
				                <label>Descripcion de la consulta:</label>
				                <input type="text" class="form-control" name="telefonicoDescripcionConsulta" id="telefonicoDescripcionConsultaModal" placeholder="Descripcion de la consulta...">
				            </div>
				            <div class="form-group">
				                <label>Tipo de solicitud:</label>
				                <input type="text" class="form-control" name="telefonicoTipoSolicitud" id="telefonicoTipoSolicitudModal" placeholder="Tipo de solicitud...">
				            </div>
				            <div class="form-group">
				                <label>Canal de recepción:</label>
				                <input type="text" class="form-control" name="telefonicoCanalRecepcion" id="telefonicoCanalRecepcionModal" placeholder="Canal de recepción...">
				            </div>
				            <div class="form-group">
				                <label>Canal de respuesta:</label>
				                <input type="text" class="form-control" name="telefonicoCanalRespuesta" id="telefonicoCanalRespuestaModal" placeholder="Canal de recepción...">
				            </div>
				            <div class="form-group">
				                <label>Fecha:</label>
				                <input type="date" class="form-control" name="telefonicoFecha" id="telefonicoFechaModal">
				            </div>
				            <div class="form-group">
				                <label>Duración (05 45):</label>
				                <input type="text" class="form-control" name="telefonicoDuracion" id="telefonicoDuracionModal" placeholder="Duración...">
				            </div>
				            <div class="form-group">
				                <label>Hora (10 56 PM):</label>
				                <input type="text" class="form-control" name="telefonicoHora" id="telefonicoHoraModal" placeholder="Hora...">
				            </div>
		    			</div>
		    		</div>
		    	</div>
		    </div>
		    <div class="modal-footer">
		    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
		   		<button type="button" class="btn btn-siia" id="actualizarLlamada" >Actualizar <i class="fa fa-check" aria-hidden="true"></i></button>
		    </div>
	    </div>
  	</div>
</div>