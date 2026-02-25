<?php
/***
 * @var InformeActividadesModel $informes
 */
$CI = &get_instance();
$CI->load->model("InformeActividadesModel");
/*echo "<pre>";
var_dump($informes);
echo "</pre>";
die();*/
?>
<!-- jQuery primero, luego Popper.js, luego Bootstrap JS -->
<script src="<?= base_url('assets/js/functions/user/modules/informe-actividades/informe-actividades.js?v=1.1') . time() ?>" type="module"></script>
<link href="<?= base_url('assets/css/admin/modules/informeActividades/informe-actividades.css?v=1.0') ?>" rel="stylesheet" type="text/css" />
<script>
	var informes = '<?= count($informes) ?>';
</script>
<div class="main-panel">
    <div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-file-document-outline mr-2"></i>
							Informe de Actividades
						</h4>
						<p class="text-muted mb-0 small">Visualización y descarga de reportes</p>
					</div>
					<a href="<?= site_url('admin/reportes');?>" type="button" class="btn btn-outline-secondary btn-sm shadow-sm">
						<i class="mdi mdi-arrow-left mr-1"></i>
						Volver
					</a>
				</div>
				<div class="row mb-4">
					<div class="col-md-6">
						<div class="card border-left-info shadow-sm" style="border-left-width:4px;">
							<div class="card-body py-3 d-flex align-items-center">
								<div class="mr-3"><i class="mdi mdi-format-list-bulleted text-info"></i></div>
								<div>
									<h6 class="text-muted mb-0 small">Total Informes</h6>
									<h4 class="font-weight-bold mb-0"><?= $informes ? count($informes) : 0 ?></h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card border-left-primary shadow-sm" style="border-left-width:4px;">
							<div class="card-body py-3 d-flex align-items-center">
								<div class="mr-3"><i class="mdi mdi-send text-primary"></i></div>
								<div>
									<h6 class="text-muted mb-0 small">Enviados</h6>
									<h4 class="font-weight-bold mb-0">
										<?php 
											$enviados = 0; 
											if ($informes) { foreach ($informes as $inf) { if ($inf->estado == 'Enviado') { $enviados++; } } } 
											echo $enviados;
										?>
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Descarga de reportes filtrados -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="mb-0 text-muted font-weight-bold">
                        <i class="mdi mdi-download-outline mr-1"></i>
                        Descarga de reportes filtrados
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-7">
                            <form id="formExportarReporte" method="get" action="<?= base_url(); ?>reportes/exportarExcelInformeActividades">
                                <div class="form-group mb-2">
                                    <label for="anio" class="form-label">Seleccionar Año:</label>
                                    <select name="anio" id="anio" class="form-control" required>
                                        <option value="">-- Seleccione un año --</option>
                                        <?php $anioActual = date('Y');
                                            for($i = $anioActual; $i >= 2022; $i--): ?>
                                            <option value="<?= $i ?>" <?= ($i == $anioActual) ? 'selected' : '' ?>>
                                                <?= $i ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-download mr-1"></i>
                                    Descargar Reporte
                                </button>
                                <small class="text-muted d-block mt-2">El archivo se descarga con el año seleccionado.</small>
                            </form>
                        </div>
                        <div class="col-md-5 d-flex align-items-end justify-content-md-end mt-3 mt-md-0">
                            <a href="<?= base_url(); ?>reportes/exportarExcelInformeActividades" class="btn btn-outline-primary btn-sm ml-md-2">
                                <i class="mdi mdi-download-multiple mr-1"></i>
                                Reporte Completo
                            </a>
                            <small class="text-muted ml-2 d-none d-md-block">(Todos los años)</small>
                        </div>
                    </div>
                </div>
            </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="tabla_informes" class="mb-4">
					<div class="card shadow-sm">
						<div class="card-body">
							<div class="table-responsive">
                                <table id="tabla_super_admins" width="100%" border=0 class="table table-hover table-striped w-100 text-center">
									<thead class="thead-light">
                                    <tr>
                                        <th>Organización</th>
                                        <th>NIT</th>
                                        <th>Fecha Creación</th>
                                        <th>Fecha de inicio</th>
                                        <th>Fecha de finalización</th>
                                        <th>Ciudad</th>
                                        <th>Duración</th>
                                        <th>Total Asistentes</th>
                                        <th>Asistentes</th>
                                        <th>Acciones</th>
                                    </tr>
									</thead>
									<tbody id="tbody">
									<?php foreach ($informes as $informe): ?>
										<tr>
											<td><?= $informe->nombreOrganizacion ?></td>
											<td><?= $informe->numNIT ?></td>
											<td><?= $informe->created_at ?></td>
											<td><?= $informe->fechaInicio ?></td>
											<td><?= $informe->fechaFin ?></td>
											<td><?= $informe->municipio ?></td>
											<td><?= $informe->duracion ?> horas</td>
											<td><?= $informe->totalAsistentes ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group" >
                                                    <a type="button" class='btn btn-primary btn-sm verAsistentes' style="decorate: none;" title="Ver Asistentes" data-id='<?= $informe->id_informeActividades; ?>'>
                                                        <i class='mdi mdi-account-group'></i>
                                                    </a>
                                                    <a type="button" class='btn btn-outline-danger btn-sm' style="decorate: none;" title="Ver PDF Firmas" href="<?= base_url("uploads/asistentes/" . $informe->archivoAsistencia); ?>" target="_blank">
                                                        <i class='mdi mdi-file-pdf'></i>
                                                    </a>
                                                    <?php if ($informe->archivoAsistentes): ?>
													<a type="button" class='btn btn-outline-success btn-sm' title="Descargar excel" href="<?= base_url("uploads/asistentes/" . $informe->archivoAsistentes); ?>">
														<i class='mdi mdi-file-excel'></i>
													</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class='btn btn-info btn-sm verCurso' title="Ver Detalle Curso" data-toggle='modal' data-id='<?= $informe->id_informeActividades; ?>' data-target='#modal-curso-informe'>
                                                        <i class='mdi mdi-book-open-variant'></i>
                                                    </button>
                                                    <!--<button type="button" class='btn btn-siia crearObservacion' title="Realizar observación" data-toggle="modal" data-target="#modal-crear-observacion" data-id="<?php /*= $informe->id_informeActividades; */?>"> 
                                                        <i class='fa fa-pencil' aria-hidden='true'></i>
                                                    </button>-->
                                                    <?php if ($informe->estado == 'Enviado' || $informe->estado == 'Observaciones'): ?>
                                                        <!--<button type="button" class='btn btn-success aprobarInforme' title="Aprobar informe" data-id="<?php /*= $informe->id_informeActividades; */?>"> 
                                                            <i class='fa fa-check' aria-hidden='true'></i>
                                                        </button>-->
                                                    <?php endif; ?>
                                                </div>
                                            </td>
										</tr>
									<?php endforeach; ?>
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
</div>
<!-- Modal detalle informe -->
<div class="modal fade" id="modal-curso-informe" tabindex="-1" role="dialog" aria-labelledby="modal-curso-informes">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h3 class="text-white mb-0"><i class="mdi mdi-information-outline mr-2"></i>Detalle | Informe de Actividades</h3>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Fecha de inicio</div><input type="text" class="form-control-plaintext" id="informe_fecha_incio_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Fecha de finalización</div><input type="text" class="form-control-plaintext" id="informe_fecha_fin_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Departamento</div><input type="text" class="form-control-plaintext" id="informe_departamento_curso_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Municipio</div><input type="text" class="form-control-plaintext" id="informe_municipio_curso_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Duración (Horas)</div><input type="text" class="form-control-plaintext" id="informe_duracion_curso_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Docente</div><input type="text" class="form-control-plaintext" id="informe_docente_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Intencionalidad del Curso</div><input type="text" class="form-control-plaintext" id="informe_intencionalidad_curso_v" disabled></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Nombre del curso</div><input type="text" class="form-control-plaintext" id="informe_cursos_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Modalidad del curso</div><input type="text" class="form-control-plaintext" id="informe_modalidad_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Estado</div><input type="text" class="form-control-plaintext" id="informe_estado_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Asistentes</div><input type="text" class="form-control-plaintext" id="informe_asistentes_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Número Mujeres</div><input type="text" class="form-control-plaintext" id="informe_numero_mujeres_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">Número Hombres</div><input type="text" class="form-control-plaintext" id="informe_numero_hombres_v" disabled></div></div>
                            <div class="card bg-light mb-2"><div class="card-body py-2"><div class="small text-muted">No Binario</div><input type="text" class="form-control-plaintext" id="informe_numero_no_binario_v" disabled></div></div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- Modal formulario observación -->
<div class="modal fade" id="modal-crear-observacion" tabindex="-1" role="dialog" aria-labelledby="modal-crear-observacion">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Crear Observación</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<?= form_open('', array('id' => 'formulario_crear_observacion_informe')); ?>
					<div class="col-md-12">
						<p class="tipoLeer">Realice una breve descripción de la observación para ser enviada a la organización</p>
						<div class="form-group">
							<label for="descripcion_observacion_informe_actividades">Realiza la observación:</label>
							<textarea class="form-control" name="descripcion_observacion_informe_actividades" id="descripcion_observacion_informe_actividades" required></textarea>
						</div>
					</div>
					<?= form_close(); ?>
				</div>
				<div class="modal-footer">
					<div class="btn-group" role='group' aria-label='acciones'>
						<button type="button" class="btn btn-md btn-siia" id="crear_observacion_informe">Guardar y Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('formExportarReporte').addEventListener('submit', function(e) {
		const anio = document.getElementById('anio').value;

		if (!anio) {
			e.preventDefault();
			alert('Por favor seleccione un año para generar el reporte.');
			return false;
		}

		// Mostrar mensaje de procesamiento
		const btnSubmit = this.querySelector('button[type="submit"]');
		const originalText = btnSubmit.innerHTML;
		btnSubmit.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generando...';
		btnSubmit.disabled = true;

		// Restaurar botón después de 3 segundos (tiempo estimado de descarga)
		setTimeout(function() {
			btnSubmit.innerHTML = originalText;
			btnSubmit.disabled = false;
		}, 3000);
	});
</script>
