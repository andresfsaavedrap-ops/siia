<div class="main-panel">
	<div class="content-wrapper">
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-email text-primary mr-2"></i>
							Contacto y Comunicados
						</h4>
						<p class="text-muted mb-0 small">Envía comunicaciones a organizaciones registradas y acreditadas</p>
					</div>
					<a href="<?php echo base_url('admin/panel'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0">
						<h5 class="mb-0"><i class="mdi mdi-email-send-outline mr-2"></i>Enviar comunicado</h5>
					</div>
					<div class="card-body">
						<form id="form_contacto_admin" novalidate>
							<div class="row">
								<div class="col-md-12">
									<div class="checkbox">
										<label><input type="checkbox" id="contacto_enviar_copia_admin_todos" name="contaco_enviar"> Enviar comunicado a todas las entidades en el SIIA</label>
										<br>
										<label><input type="checkbox" id="contacto_enviar_copia_admin_todos_acre" name="contaco_enviar"> Enviar comunicado a todas las entidades acreditadas</label>
										<br>
										<label><input type="checkbox" disabled id="envioHTML" name="envioHTML" checked> Copiar correo con HTML</label>
									</div>
								</div>
							</div>
							<div id="comunicado">
								<div class="row">
									<div class="form-group col-md-6">
										<label>Correo electrónico de la organización:</label>
										<select class="selectpicker form-control show-tick" data-live-search="true" aria-label="contacto_correo_electronico_admin" id="contacto_correo_electronico_admin" name="contacto_correo_electronico_admin" required title="Seleccione una opción">
											<option disabled selected>Seleccione una opción</option>
											<?php foreach ($emails as $email) : ?>
												<option value="<?php echo $email->direccionCorreoElectronicoOrganizacion ?>"><?php echo $email->direccionCorreoElectronicoOrganizacion ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-md-6">
										<div class="checkbox">
											<label><input type="checkbox" id="contacto_enviar_copia_admin" name="contacto_enviar_copia_admin" disabled> Enviar copia al representante legal</label>
										</div>
										<div id="contacto_copia_admin" class="form-group" style="display:none;">
											<label>Correo electrónico del representante legal:</label>
											<input type="text" id="contacto_correo_electronico_rep_admin" class="form-control" placeholder="Correo del representante legal">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label>Prioridad:*</label>
									<select id="contacto_prioridad_admin" class="selectpicker form-control show-tick" required>
										<option value="Urgente">Urgente</option>
										<option value="Importante">Importante</option>
										<option value="Ninguna" selected>Ninguna</option>
									</select>
								</div>
								<div class="form-group col-md-8">
									<label>Asunto:*</label>
									<input class="form-control" id="contacto_asunto_admin" type="text" placeholder="Asunto..." required>
								</div>
							</div>
							<div class="form-group">
								<label>Mensaje:*</label>
								<textarea id="contacto_mensaje_admin" class="form-control" placeholder="Redacte el mensaje..."></textarea>
								<div class="text-right"><small id="contacto_mensaje_count">0 caracteres</small></div>
							</div>
							<script>
								(function(){
									if (window.CKEDITOR) {
										if (!CKEDITOR.instances.contacto_mensaje_admin) {
											if (typeof initCK === 'function') { initCK(); } else { CKEDITOR.replace('contacto_mensaje_admin'); }
										}
									}
								})();
							</script>
							<div class="text-right">
								<button type="button" class="btn btn-primary btn-sm" id="enviar_correo_contacto_admin">Enviar <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-md-12">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0">
						<h5 class="mb-0"><i class="mdi mdi-account-multiple-outline mr-2"></i>Usuarios en línea</h5>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="tabla_super_admins" class="table table-hover table-striped" width="100%">
								<thead class="thead-light">
									<tr>
										<th class="border-0">Id Usuario</th>
										<th class="border-0">Usuario</th>
									</tr>
								</thead>
								<tbody id="tbody">
									<?php
									foreach ($usuarios as $usuario) {
										echo "<tr><td>$usuario->id_usuario</td>";
										echo "<td>$usuario->usuario</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
