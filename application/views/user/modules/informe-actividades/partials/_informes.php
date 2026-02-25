<?php
/***
 * @var Docentes $docentes
 * @var Solicitudes $dolicitudes
 * @var $departamentos
 * @var $municipios
 * @var InformeActividadesModel $informes
 */
$CI = &get_instance();
$CI->load->model("InformeActividadesModel");
//echo "<pre>";
//var_dump($informes);
//echo "</pre>";
//die();
?>
<div class="col-lg-12 grid-margin stretch-card" id="verSolicitudes">
	<div class="card shadow-sm">
		<div class="card-body">
			<h4 class="card-title text-primary"><i class="mdi mdi-lightbulb mr-2"></i>Información a tener en cuenta | Informe de Actividades</h4>
			<div class="card-description mt-3">
				<p>En este espacio podrás encontrar los informes de actividades creados anteriormente o podrá crear uno nuevo.</p>
				<div class="alert alert-info mb-4">
					<i class="fa fa-info-circle"></i>
					Por favor lea el siguiente manual, que lo guiarán paso a paso en la creación y envío de su solicitud informe de actividades:
				</div>
				<a href="<?= base_url("assets/docs/manuales/usuario/8.informe_actividades.pdf"); ?>" class="btn btn-outline-info btn-sm ml-2" download>
					Manual: Crear y Enviar Informe de Actividades
					<i class="mdi mdi-download ml-1"></i>
				</a>
				<button class="btn btn-info btn-sm ml-2" title="Ayuda informe actividades" data-toggle='modal' data-target='#modal-ayuda-informe-actividades'>
					<i class="fa fa-question" aria-hidden="true"></i> Ayuda
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Tabla y botón de creación de solicitudes -->
<div class="col-lg-12 grid-margin stretch-card" id="tabla_informe_actividades">
	<div class="card shadow-sm">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div>
					<h4 class="card-title mb-0">Informes</h4>
					<p class="text-muted small">Informes <span class="badge badge-primary">registrados</span></p>
				</div>
				<a class="btn btn-primary btn-sm" id="registrar_informe">
					<i class="mdi mdi-file-plus mr-2" aria-hidden="true"></i>Registrar Informe
				</a>
			</div>
			<hr class="mb-4" />
			<?php if ($informes): ?>
				<div class="table-responsive text-center">
					<!-- <table id="tabla_solicitudes" class="table table-striped table-hover"> -->
					<table class="table table-striped table-bordered tabla_form">
						<thead class="bg-light">
						<tr>
							<td>Fecha de registro informe</td>
							<td>Duración curso</td>
							<td>Total asistentes curso</td>
							<td>Detalle informe registrado</td>
							<td>Acciones</td>
						</tr>
						</thead>
						<tbody id="tbody">
						<?php foreach ($informes as $informe): ?>
							<tr>
								<td><?= $informe->created_at ?></td>
								<td><?= $informe->duracion ?> horas</td>
								<td><?= $informe->totalAsistentes ?></td>
								<td>
									<div class="btn-group" role="group" >
										<a type="button" class='btn btn-outline-danger' title="Ver evidencia firmas" href="<?= base_url("uploads/asistentes/" . $informe->archivoAsistencia); ?>" download>
											<i class='mdi mdi-file-pdf' aria-hidden='true'></i>
										</a>
										<?php if ($informe->archivoAsistentes): ?>
											<a type="button" class='btn btn-outline-success' title="Ver excel asistentes curso" href="<?= base_url("uploads/asistentes/" . $informe->archivoAsistentes); ?>" download>
												<i class='mdi mdi-file-excel' aria-hidden='true'></i>
											</a>
										<?php endif; ?>
										<button type="button" class='btn btn btn-outline-primary verCurso' title="Ver detalle Curso" data-toggle='modal' data-id='<?= $informe->id_informeActividades; ?>' data-target='#modal-curso-informe'>
											<i class='fa fa-book' aria-hidden='true'></i>
										</button>
									</div>
								</td>
								<td>
									<div class="btn-group" role="group">
										<button type="button" class='btn btn-success verAsistentes' title="Ver | Editar Asistentes" data-id='<?= $informe->id_informeActividades; ?>'>
											<i class='fa fa-users' aria-hidden='true'></i>
										</button>
										<?php if ($informe->estado == 'Creado' || $informe->estado == 'Observaciones'): ?>
											<button type="button" class='btn btn-primary enviarInforme' title="Enviar Informe" data-id='<?= $informe->id_informeActividades; ?>'>
												<i class='mdi mdi-send' aria-hidden='true'></i>
											</button>
										<?php endif; ?>
										<?php /*if ($informe->estado == 'Observaciones'): */?><!--
											<button type="button" class='btn btn-sm btn-warning verObservacionesInforme' title="Ver Observaciones" data-toggle='modal' data-id='<?php /*= $informe->id_informeActividades; */?>' data-target='#modal-observaciones-informe'>
												<i class='fa fa-eye' aria-hidden='true'></i>
											</button>
										--><?php /*endif; */?>
										<?php if ($informe->estado != 'Aprobado' && $informe->estado != 'Observaciones' && $informe->estado != 'Enviado'): ?>
											<button type="button" class='btn btn-danger eliminar_informe_actividad' title="Eliminar curso" data-id="<?= $informe->id_informeActividades; ?>">
												<i class='fa fa-trash' aria-hidden='true'></i>
											</button>
										<?php endif; ?>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="alert alert-info text-center">
					<i class="mdi mdi-information mb-5"></i>
					<p>No hay informes registradas actualmente. Utilice el botón "Agregar nueva solicitud" para crear una.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Modal ayuda informe de actividades -->
<div class="modal fade" id="modal-ayuda-informe-actividades" tabindex="-1" role="dialog" aria-labelledby="modal-ayuda-informe-actividades">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ayuda Informe de actividad</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<embed src="<?= base_url('assets/docs/manuales/usuario/8.informe_actividades.pdf'); ?>" type="application/pdf" width="100%" height="540" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" />
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal detalle informe -->
<div class="modal fade" id="modal-curso-informe" tabindex="-1" role="dialog" aria-labelledby="modal-curso-informes">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Detalle | Informe de Actividades</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<!-- Fecha de inicio -->
						<div class="form-group">
							<label for="informe_fecha_incio_v">Fecha de inicio</label>
							<input type="text" class="form-control" name="informe_fecha_incio_v" id="informe_fecha_incio_v" disabled>
						</div>
						<!-- Fecha de fin -->
						<div class="form-group">
							<label for="informe_fecha_fin_v">Fecha de finalización</label>
							<input type="text" class="form-control" name="informe_fecha_fin_v" id="informe_fecha_fin_v" disabled>
						</div>
						<!-- Departamentos -->
						<div class="form-group">
							<label for="informe_departamento_curso_v">Departamento*</label>
							<input type="text" class="form-control" name="informe_departamento_curso_v" id="informe_departamento_curso_v" disabled>
						</div>
						<!-- Municipios -->
						<div class="form-group">
							<label for="informe_municipio_curso_v">Municipio:*</label>
							<input type="text" class="form-control" name="informe_municipio_curso_v" id="informe_municipio_curso_v" disabled>
						</div>
						<!-- Duración Curso -->
						<div class="form-group">
							<label for="informe_duracion_curso_v">Duracion del Curso: <small>Horas</small></label>
							<input type="number" name="informe_duracion_curso_v" class="form-control" id="informe_duracion_curso_v" disabled>
						</div>
						<!-- Docente -->
						<div class="form-group">
							<label for="informe_docente_v">Docente:</label><br>
							<input type="text" class="form-control" name="informe_docente_v" id="informe_docente_v" disabled>
						</div>
						<!-- Intencionalidad Curso -->
						<div class="form-group">
							<label for="informe_intencionalidad_curso_v">Intencionalidad del Curso:</label><br>
							<input type="text" class="form-control" name="informe_intencionalidad_curso_v" id="informe_intencionalidad_curso_v" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<!-- Curso -->
						<div class="form-group">
							<label for="informe_cursos_v">Nombre del curso:</label>
							<input type="text" class="form-control" name="informe_cursos_v" id="informe_cursos_v" disabled>
						</div>
						<!-- Tipo Curso -->
						<div class="form-group">
							<label for="informe_modalidad_v">Modalidad del curso:</label><br>
							<input type="text" class="form-control" name="informe_modalidad_v" id="informe_modalidad_v" disabled>
						</div>
						<!-- Asistentes Curso -->
						<div class="form-group">
							<label for="informe_asistentes_v">Asistentes:</label>
							<input type="number" class="form-control" name="informe_asistentes_v" id="informe_asistentes_v" disabled>
						</div>
						<!-- Asistentes Mujeres Curso -->
						<div class="form-group">
							<label for="informe_numero_mujeres_v">Numero Mujeres:</label>
							<input type="number" class="form-control" name="informe_numero_mujeres_v" id="informe_numero_mujeres_v" disabled>
						</div>
						<!-- Asistentes Hombres Curso -->
						<div class="form-group">
							<label for="informe_numero_hombres_v">Numero Hombres:</label>
							<input type="number" class="form-control" name="informe_numero_hombres_v" id="informe_numero_hombres_v" disabled>
						</div>
						<!-- Asistentes No Binario Curso -->
						<div class="form-group">
							<label for="informe_numero_no_binario_v">No Binario:</label>
							<input type="number" class="form-control" name="informe_numero_no_binario_v" id="informe_numero_no_binario_v" disabled>
						</div>
					</div>
				</div>
				<p class="tipoLeer">
					Si los datos aquí registrado no son correctos, por favor dar clic en <strong>Eliminar  </strong><span class="spanRojo"><i class='fa fa-trash' aria-hidden='true'></i></span>
					Y vuelve a crear tu informe
				</p>
			</div>
		</div>
	</div>
</div>
<!-- Modal observaciones informe | Se deja de usar -->
<div class="modal fade" id="modal-observaciones-informe" tabindex="-1" role="dialog" aria-labelledby="modal-observaciones-informe">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Observaciones | Informe de Actividades</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="tipoLeer">
					Por favor lee la observación realizada a su informe, realice la corrección indicada y envíe nuevamente dando clic en <strong>Enviar </strong><span class="spanAzul"><i class='fa fa-send' aria-hidden='true'></i></span>
				</p>
				<div class="container-fluid text-center" id="observaciones_informe_actividades">
				</div>
			</div>
		</div>
	</div>
</div>
