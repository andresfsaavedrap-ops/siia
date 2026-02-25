<!-- Formulario de creación de usuario -->
<div class="col-lg-12 grid-margin stretch-card" id="divAgregarDoc">
	<div class="card shadow-sm">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div>
					<h4 class="card-title font-weight-bold text-primary">Crear Facilitador</h4>
					<p class="card-description text-muted">Diligencia los datos básicos del <span class="badge badge-info">docente</span></p>
				</div>
				<div class="float-right">
					<i class="icon-user-plus text-primary" style="font-size: 2.5rem;"></i>
				</div>
			</div>
			<?php echo form_open('', array('id' => 'formulario_crear_docente', 'class' => 'forms-sample')); ?>
			<div class="row">
				<!-- Número de cédula -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_cedula">
							<i class="icon-id-card text-primary mr-1"></i> Número de cédula o NUIP</>
							<span class="text-danger">*</span>
						</label>
						<input type="number" class="form-control form-control-lg" name="docentes_cedula" id="docentes_cedula"
							placeholder="Ingrese cédula o NUIP" required>
						<small class="form-text text-muted">Documento de identificación oficial</small>
					</div>
				</div>
				<!-- Primer nombre -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_primer_nombre">
							<i class="icon-user text-primary mr-1"></i> Primer nombre
							<span class="text-danger">*</span>
						</label>
						<input type="text" class="form-control form-control-lg" name="docentes_primer_nombre"
							id="docentes_primer_nombre" placeholder="Ingrese primer nombre" required>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Segundo nombre -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_segundo_nombre">
							<i class="icon-user-plus text-primary mr-1"></i> Segundo nombre
						</label>
						<input type="text" class="form-control form-control-lg" name="docentes_segundo_nombre"
							id="docentes_segundo_nombre" placeholder="Ingrese segundo nombre (opcional)">
					</div>
				</div>

				<!-- Primer apellido -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_primer_apellido">
							<i class="icon-user text-primary mr-1"></i> Primer apellido
							<span class="text-danger">*</span>
						</label>
						<input type="text" class="form-control form-control-lg" name="docentes_primer_apellido"
							id="docentes_primer_apellido" placeholder="Ingrese primer apellido" required>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Segundo apellido -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_segundo_apellido">
							<i class="icon-user-plus text-primary mr-1"></i> Segundo apellido
						</label>
						<input type="text" class="form-control form-control-lg" name="docentes_segundo_apellido"
							id="docentes_segundo_apellido" placeholder="Ingrese segundo apellido (opcional)">
					</div>
				</div>

				<!-- Profesión -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_profesion">
							<i class="icon-graduation text-primary mr-1"></i> Profesión
							<span class="text-danger">*</span>
						</label>
						<input type="text" class="form-control form-control-lg" name="docentes_profesion"
							id="docentes_profesion" placeholder="Ej: Sociólogo, Licenciatura en Educación Infantil..." required>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Horas de capacitación -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="docentes_horas">
							<i class="icon-clock text-primary mr-1"></i> Horas de capacitación
							<span class="text-danger">*</span>
						</label>
						<div class="input-group">
							<input type="number" class="form-control form-control-lg" min="60" name="docentes_horas"
								id="docentes_horas" value="60" placeholder="60" required>
							<div class="input-group-append">
								<span class="input-group-text bg-primary text-white">horas</span>
							</div>
						</div>
						<small class="form-text text-muted">Mínimo requerido: 60 horas</small>
					</div>
				</div>
			</div>
			<div class="mt-4 pt-3 border-top">
				<button type="submit" class="btn btn-primary btn-icon-text mr-2" name="añadirNuevoDocente" id="añadirNuevoDocente">
					<i class="ti-check btn-icon-prepend"></i>
					Crear facilitador
				</button>
				<button type="button" class="btn btn-light btn-icon-text verDivAgregarDoc">
					<i class="ti-arrow-left btn-icon-prepend"></i>
					Cancelar
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
