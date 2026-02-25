<div class="col-md-12">
<div class="clearfix"></div>
<hr/>
	<h3>Organizaciones en Historico:</h3>
	<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
		<thead>
			<tr>
				<td>NOMBRE DE LA ENTIDAD</td>
				<td>NÚMERO NIT</td>
				<td>SIGLA DE LA ENTIDAD</td>
				<td>PRIMER NOMBRE REPRESENTANTE LEGAL</td>
				<td>SEGUNDO NOMBRE REPRESENTANTE LEGAL</td>
				<td>PRIMER APELLIDO REPRESENTANTE LEGAL</td>
				<td>SEGUNDO APELLIDO REPRESENTANTE LEGAL</td>
				<td>CORREO ELECTRÓNICO ENTIDAD</td>
				<td>CORREO ELECTRÓNICO REPRESENTANTE LEGAL</td>
			</tr>
		</thead>
		<tbody id="tbody">
		<?php
			foreach ($organizacionesHistorico as $historico) {
				echo "<tr><td>$historico->nombreOrganizacion</td>";
				echo "<td>$historico->numNIT</td>";
				echo "<td>$historico->sigla</td>";
				echo "<td>$historico->primerNombreRepLegal</td>";
				echo "<td>$historico->segundoNombreRepLegal</td>";
				echo "<td>$historico->primerApellidoRepLegal</td>";
				echo "<td>$historico->segundoApellidoRepLegal</td>";
				echo "<td>$historico->direccionCorreoElectronicoOrganizacion</td>";
				echo "<td>$historico->direccionCorreoElectronicoRepLegal</td></tr>";
			}
		?>
		</tbody>
	</table>
	<button class="btn btn-warning volverReporte">Volver</button>
</div>