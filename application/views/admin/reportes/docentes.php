<div class="container">
	<div class="clearfix"></div>
	<hr/>
		<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
			<thead>
				<tr>
					<td>Nombres y Apellidos</td>
					<td>Número de documento</td>
					<td>Profesión</td>
					<td>Horas</td>
				</tr>
			</thead>
			<tbody id="tbody">
			<?php
				for ($i=0; $i < count($docentes); $i++) {
					echo "<tr>";
					echo "<td>".$docentes[$i] ->primerNombreDocente." ".$docentes[$i] ->segundoNombreDocente." ".$docentes[$i] ->primerApellidoDocente." ".$docentes[$i] ->segundoApellidoDocente."</td>";
					echo "<td>".$docentes[$i] ->numCedulaCiudadaniaDocente."</td>";
					echo "<td>".$docentes[$i] ->profesion."</td>";
					echo "<td>".$docentes[$i] ->horaCapacitacion."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
		<button class="btn btn-warning volverReporte">Volver a reportes</button>
	</div>