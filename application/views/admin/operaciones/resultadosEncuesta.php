<div class="container">
	<div class="clearfix"></div>
	<hr/>
	<h4>Resultados de las encuestas de satisfacción</h4>
	<div class="tabla_encuesta">
		<table id="tabla_encuestas" width="100%" border=0 class="table table-striped table-bordered">
			<thead>
				<tr>
					<td>Estrellas</td>
					<td>Comentario</td>
				</tr>
			</thead>
			<tbody id="tbody">
			<?php 
				foreach ($encuestas as $resultado) {
					echo "<tr><td>".$resultado->estrellas."</td>";
					echo "<td>".$resultado->comentario."</td><tr/>";
				}
			?>
			</tbody>
		</table>
	</div>
	<a href="<?php echo base_url('panelAdmin/opciones'); ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
</div>

