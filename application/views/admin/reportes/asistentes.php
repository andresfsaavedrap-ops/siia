<div class="col-md-12">
	<div class="clearfix"></div>
	<hr/>
		<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
			<thead>
				<tr>
					<td>Nombres y Apellidos</td>
					<td>Número de documento</td>
					<td>Departamento de residencia</td>
					<td>Municipio de residencia</td>
					<td>Teléfono</td>
					<td>Dirección</td>
					<td>Correo electrónico</td>
					<td>Edad</td>
					<td>Género</td>
					<td>Nivel de formación</td>
				</tr>
			</thead>
			<tbody id="tbody">
			<?php
				for ($i=0; $i < count($asistentes); $i++) {
					echo "<tr>";
					echo "<td>".$asistentes[$i] ->primerNombreAsistente." ".$asistentes[$i] ->segundoNombreAsistente." ".$asistentes[$i] ->primerApellidoAsistente." ".$asistentes[$i] ->segundoApellidoAsistente."</td>";
					echo "<td>".$asistentes[$i] ->numeroDocumentoAsistente."</td>";
					echo "<td>".$asistentes[$i] ->departamentoResidencia."</td>";
					echo "<td>".$asistentes[$i] ->municipioResidencia."</td>";
					echo "<td>".$asistentes[$i] ->faxAsistente."</td>";
					echo "<td>".$asistentes[$i] ->direccionAsistente."</td>";
					echo "<td>".$asistentes[$i] ->direccionCorreoElectronicoAsistente."</td>";
					echo "<td>".$asistentes[$i] ->edadAsistente."</td>";
					echo "<td>".$asistentes[$i] ->sexoAsistente."</td>";
					echo "<td>".$asistentes[$i] ->nivelFormacion."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
		<button class="btn btn-warning volverReporte">Volver a reportes</button>
	</div>