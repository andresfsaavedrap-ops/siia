<div class="card">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<div>
				<h4 class="card-title mb-1">Registro de actividad</h4>
				<p class="text-muted font-weight-light">
					<i class="ti-info-alt text-primary mr-1"></i> Últimos 50 registros
				</p>
			</div>
			<div class="dropdown">
				<button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="exportOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="ti-download mr-1"></i> Exportar
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="exportOptions">
					<a class="dropdown-item" href="#"><i class="ti-file-excel text-success mr-2"></i>Excel</a>
					<a class="dropdown-item" href="#"><i class="ti-file text-danger mr-2"></i>PDF</a>
					<a class="dropdown-item" href="#"><i class="ti-clipboard text-info mr-2"></i>CSV</a>
					<a class="dropdown-item" href="#"><i class="ti-layers text-warning mr-2"></i>Copiar</a>
					<a class="dropdown-item" href="#"><i class="ti-printer text-primary mr-2"></i>Imprimir</a>
				</div>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-md-8">
				<div class="input-group">
					<div class="input-group-prepend bg-transparent">
						<span class="input-group-text bg-transparent border-right-0">
							<i class="ti-search text-primary"></i>
						</span>
					</div>
					<input type="text" id="buscar_actividad" class="form-control bg-transparent border-left-0" placeholder="Buscar actividad...">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" id="filtro_actividad">
						<option value="">Todos los registros</option>
						<option value="login">Inicios de sesión</option>
						<option value="logout">Cierres de sesión</option>
						<option value="create">Creaciones</option>
						<option value="update">Actualizaciones</option>
						<option value="delete">Eliminaciones</option>
					</select>
				</div>
			</div>
		</div>

		<div class="table-responsive">
			<!-- <table id="tabla_actividad" class="table table-striped table-hover"> -->
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class="font-weight-medium text-dark"><i class="ti-bookmark-alt text-primary mr-1"></i>Actividad</th>
						<th class="font-weight-medium text-dark"><i class="ti-calendar text-info mr-1"></i>Fecha</th>
						<th class="font-weight-medium text-dark"><i class="ti-desktop text-warning mr-1"></i>Dirección IP</th>
						<th class="font-weight-medium text-dark"><i class="ti-world text-success mr-1"></i>Explorador</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($actividad as $row): ?>
						<tr>
							<td>
								<?php
								$icon_class = '';
								$badge_class = '';

								if (stripos($row->accion, 'login') !== false) {
									$icon_class = 'ti-user text-success';
									$badge_class = 'badge badge-outline-success';
								} elseif (stripos($row->accion, 'logout') !== false) {
									$icon_class = 'ti-power-off text-danger';
									$badge_class = 'badge badge-outline-danger';
								} elseif (stripos($row->accion, 'crear') !== false || stripos($row->accion, 'create') !== false) {
									$icon_class = 'ti-plus text-info';
									$badge_class = 'badge badge-outline-info';
								} elseif (stripos($row->accion, 'actualizar') !== false || stripos($row->accion, 'update') !== false) {
									$icon_class = 'ti-pencil text-warning';
									$badge_class = 'badge badge-outline-warning';
								} elseif (stripos($row->accion, 'eliminar') !== false || stripos($row->accion, 'delete') !== false) {
									$icon_class = 'ti-trash text-danger';
									$badge_class = 'badge badge-outline-danger';
								} else {
									$icon_class = 'ti-info-alt text-primary';
									$badge_class = 'badge badge-outline-primary';
								}
								?>
								<i class="<?php echo $icon_class; ?> mr-1"></i>
								<span class="<?php echo $badge_class; ?>"><?php echo $row->accion; ?></span>
							</td>
							<td class="text-muted">
								<?php
								$fecha = new DateTime($row->fecha);
								echo '<span data-toggle="tooltip" title="' . $row->fecha . '">';
								echo $fecha->format('d/m/Y H:i');
								echo '</span>';
								?>
							</td>
							<td><code><?php echo $row->usuario_ip; ?></code></td>
							<td>
								<?php
								$browser = '';
								$icon = '';

								if (stripos($row->user_agent, 'Chrome') !== false) {
									$browser = 'Chrome';
									$icon = 'ti-chrome text-danger';
								} elseif (stripos($row->user_agent, 'Firefox') !== false) {
									$browser = 'Firefox';
									$icon = 'ti-firefox text-warning';
								} elseif (stripos($row->user_agent, 'Safari') !== false) {
									$browser = 'Safari';
									$icon = 'ti-safari text-info';
								} elseif (stripos($row->user_agent, 'Edge') !== false) {
									$browser = 'Edge';
									$icon = 'ti-edge text-primary';
								} else {
									$browser = 'Navegador';
									$icon = 'ti-world text-secondary';
								}
								?>
								<i class="<?php echo $icon; ?> mr-1"></i>
								<span data-toggle="tooltip" title="<?php echo $row->user_agent; ?>"><?php echo $browser; ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="d-flex justify-content-between align-items-center mt-3">
			<span class="text-muted small">Mostrando <span id="registros_mostrados">0</span> de <span id="total_registros">0</span> registros</span>
			<nav>
				<ul class="pagination pagination-sm">
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1">Anterior</a>
					</li>
					<li class="page-item active"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item">
						<a class="page-link" href="#">Siguiente</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		// Inicializar tooltips
		$('[data-toggle="tooltip"]').tooltip();

		// Contar registros
		var totalRegistros = $('#tabla_actividad tbody tr').length;
		$('#total_registros').text(totalRegistros);
		$('#registros_mostrados').text(totalRegistros);

		// Función de búsqueda
		$("#buscar_actividad").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#tabla_actividad tbody tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});

			var registrosMostrados = $('#tabla_actividad tbody tr:visible').length;
			$('#registros_mostrados').text(registrosMostrados);
		});

		// Filtro por tipo de actividad
		$("#filtro_actividad").on("change", function() {
			var value = $(this).val().toLowerCase();
			if (value === "") {
				$("#tabla_actividad tbody tr").show();
			} else {
				$("#tabla_actividad tbody tr").filter(function() {
					$(this).toggle($(this).find("td:first").text().toLowerCase().indexOf(value) > -1)
				});
			}

			var registrosMostrados = $('#tabla_actividad tbody tr:visible').length;
			$('#registros_mostrados').text(registrosMostrados);
		});
	});
</script>