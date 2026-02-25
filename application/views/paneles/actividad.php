<!-- Actividad -->
<div id="actividad" class="col-md-12">
	<div>
	<h4>Registro de actividad:</h4>
	<p>Aqui se describen los ultimos 70 registros de las Acciones con Fecha, Direccion IP y Explorador</p>
	<small>Usted puede descargar esta informacion en formato CSV, Imprimirla, abrirla en formato excel, guardar en PDF o Copiarla al portapapeles.</small>
	<br><br>
	<table id="tabla_actividad" width="100%" border=0 class="table table-striped table-bordered">
		<thead>
			<tr>
				<td class="col-md-3"><label>Actividad</label></td>
				<td class="col-md-3"><label>Fecha</label></td>
				<td class="col-md-3"><label>Dirección IP</label></td>
				<td class="col-md-3"><label>Explorador</label></td>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($actividad as $row){	
			?>
				<tr>
				<td><?php echo $row->accion; ?></td>
				<td><?php echo $row->fecha; ?></td>
				<td><?php echo $row->usuario_ip; ?></td>
				<td><?php echo $row->user_agent; ?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
</div>
<!-- Actividad FIN -->