<div class="col-md-12">
<div class="clearfix"></div>
<hr/>
	<h3>Registros telefonicos:</h3>
	<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
		<thead>
			<tr>
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
			foreach ($registros as $registro) {
				echo "<tr><td>$registro->telefonicoNombre</td>";
				echo "<td>$registro->telefonicoApellidos</td>";
				echo "<td>$registro->telefonicoCedula</td>";
				echo "<td>$registro->telefonicoNit</td>";
				echo "<td>$registro->telefonicoTipoPersona</td>";
				echo "<td>$registro->telefonicoGenero</td>";
				echo "<td>$registro->telefonicoMunicipio</td>";
				echo "<td>$registro->telefonicoDepartamento</td>";
				echo "<td>$registro->telefonicoNumeroContacto</td>";
				echo "<td>$registro->telefonicoCorreoContacto</td>";
				echo "<td>$registro->telefonicoNombreOrganizacion</td>";
				echo "<td>$registro->telefonicoTipoOrganizacion</td>";
				echo "<td>$registro->telefonicoTemaConsulta</td>";
				echo "<td>$registro->telefonicoDescripcionConsulta</td>";
				echo "<td>$registro->telefonicoTipoSolicitud</td>";
				echo "<td>$registro->telefonicoCanalRecepcion</td>";
				echo "<td>$registro->telefonicoCanalRespuesta</td>";
				echo "<td>$registro->telefonicoFecha</td>";
				echo "<td>$registro->telefonicoDuracion</td>";
				echo "<td>$registro->telefonicoHora</td></tr>";
			}
		?>
		</tbody>
	</table>
	<button class="btn btn-warning volverReporte">Volver</button>
</div>