<?php
/***
 * @var $organizacion
 * @var $resoluciones
 * @var $solicitudes
 */
$CI = &get_instance();
$CI->load->model("AdministradoresModel");
$CI->load->model("UsuariosModel");
$CI->load->model("OrganizacionesModel");
$CI->load->model("ResolucionesModel");
?>
<script type="module" src="<?= base_url('assets/js/functions/admin/modules/resoluciones/organizacion.js?v=1.1') . time() ?>" ></script>
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-domain text-primary mr-2"></i>
								Gestión de resoluciones
							</h3>
							<p class="text-muted mb-0">Administra las resoluciones registradas en el sistema para la organización: <br> <?= $organizacion->nombreOrganizacion; ?></p>
						</div>
						<a href="<?= site_url('admin/resoluciones');?>" type="button" class="btn btn-outline-primary btn-sm">
							<i class="mdi mdi-arrow-left mr-1"></i>
							Volver
						</a>
					</div>
				</div>
			</div>
		<div class="row">
			<!-- Encabezado / resumen de organización -->
			<div class="col-md-12">
				<div class="card shadow-sm mb-4" id="datos_basicos">
					<div class="card-body">
						<div class="row align-items-center">
							<div class="col-md-3 text-center">
								<img class="img-fluid rounded" src="<?php echo base_url(); ?>uploads/logosOrganizaciones/<?php echo $organizacion->imagenOrganizacion; ?>" alt="Logo de la organización">
							</div>
							<div class="col-md-4">
								<p class="mb-1"><span class="font-weight-bold">Organización:</span><br><?= $organizacion->nombreOrganizacion; ?></p>
								<p class="mb-1"><span class="font-weight-bold">NIT:</span><br><?= $organizacion->numNIT; ?></p>
								<p class="mb-1"><span class="font-weight-bold">Sigla:</span><br><?= $organizacion->sigla; ?></p>
								<p class="mb-0"><span class="font-weight-bold">Representante legal:</span><br><?= $organizacion->primerNombreRepLegal; ?> <?= $organizacion->primerApellidoRepLegal; ?></p>
							</div>
							<div class="col-md-5">
								<p class="mb-1"><span class="font-weight-bold">Correo organización:</span><br><?= $organizacion->direccionCorreoElectronicoOrganizacion; ?></p>
								<p class="mb-0"><span class="font-weight-bold">Correo representante:</span><br><?= $organizacion->direccionCorreoElectronicoRepLegal; ?></p>
							</div>
						</div>
					</div>
					<div class="card-footer bg-white border-0 pt-0">
						<div class="btn-group" role="group" aria-label="acciones">
							<button class="btn btn-outline-primary btn-sm" id="verResolucionesRegistradas">
								Resoluciones cargadas <i class="mdi mdi-table-large ml-1"></i>
							</button>
							<button class="btn btn-outline-primary btn-sm" id="verFormularioResolucion">
								Cargar resolución <i class="mdi mdi-file-document ml-1"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Formulario de resolución -->
			<div class="col-md-12" id="formulario_resolucion_organizacion" style="display:none">
				<div class="card shadow-sm mb-4">
					<div class="card-header bg-white border-0">
						<h6 class="mb-0 text-primary">
							<i class="mdi mdi-file-document mr-2"></i>Adjuntar / Actualizar resolución
						</h6>
					</div>
					<div class="card-body">
						<?php echo form_open_multipart('', array('id' => 'formulario_resoluciones_organizacion')); ?>
						<div id="adjuntar_resolucion">
							<!-- Tipo de resolución -->
							<div class="form-group">
								<label class="font-weight-bold">Tipo de resolución*</label><br>
								<label class="mr-3"><input type="radio" name="tipoResolucion" id="tipo1" value="nueva" checked> Vigente</label>
								<label><input type="radio" name="tipoResolucion" id="tipo2" value="vieja"> Vieja</label>
							</div>
							<!-- Fechas y número -->
							<div class="form-row">
								<div class="form-group col-md-3">
									<label>Fecha inicio</label>
									<input type="date" id="fechaResolucionInicial" class="form-control" name="fechaResolucionInicial">
								</div>
								<div class="form-group col-md-3">
									<label>Años</label>
									<input type="number" id="anosResolucion" class="form-control" name="anosResolucion" disabled>
								</div>
								<div class="form-group col-md-3">
									<label>Fecha final</label>
									<input type="date" id="fechaResolucionFinal" class="form-control" name="fechaResolucionFinal" disabled>
								</div>
								<div class="form-group col-md-3">
									<label>Número resolución</label>
									<input type="number" id="numeroResolucion" class="form-control" name="numeroResolucion" disabled>
								</div>
							</div>
							<!-- Si es resolución vieja: motivos y modalidades -->
							<div id="resolucionVieja" style="display:none">
								<div class="form-group">
									<label class="font-weight-bold">Curso aprobado</label>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="1" id="cursoBasico" name="motivos" checked><label class="form-check-label" for="cursoBasico">Acreditación Curso Básico de Economía Solidaria</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="2" id="avalTrabajo" name="motivos"><label class="form-check-label" for="avalTrabajo">Aval de Trabajo Asociado</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="3" id="cursoMedio" name="motivos"><label class="form-check-label" for="cursoMedio">Acreditación Curso Medio de Economía Solidaria</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="4" id="cursoAvanzado" name="motivos"><label class="form-check-label" for="cursoAvanzado">Acreditación Curso Avanzado de Economía Solidaria</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="5" id="finacieraEconomia" name="motivos"><label class="form-check-label" for="finacieraEconomia">Acreditación Educación Económica y Financiera</label></div>
								</div>
								<div class="form-group">
									<label class="font-weight-bold">Modalidad aprobada</label>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="1" id="presencial" name="modalidades" checked><label class="form-check-label" for="presencial">Presencial</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="2" id="virtual" name="modalidades"><label class="form-check-label" for="virtual">Virtual</label></div>
									<div class="form-check"><input class="form-check-input" type="checkbox" value="3" id="enLinea" name="modalidades"><label class="form-check-label" for="enLinea">En línea</label></div>
								</div>
							</div>
							<!-- Si es resolución vigente: solicitud -->
							<div id="resolucionVigente" class="mb-3">
								<div class="form-group">
									<label class="font-weight-bold">Solicitud</label>
									<select class="form-control" name="idSolicitud" id="idSolicitud" required>
										<option selected>Seleccione una opción</option>
										<?php foreach ($solicitudes as $solicitud): ?>
											<option value="<?= $solicitud->idSolicitud ?>"><?= $solicitud->idSolicitud ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<!-- Adjuntar PDF y acciones -->
							<div class="form-group">
								<label class="font-weight-bold">Adjuntar resolución (PDF)</label>
								<input type="file" class="form-control" name="resolucion" id="resolucion" required accept="application/pdf"><br />
								<a class="btn btn-primary btn-md btn-block" name="cargarResolucion" id="cargarResolucion" data-id-org="<?= $organizacion->id_organizacion; ?>">
									Ingresar resolución <i class="mdi mdi-check"></i>
								</a>
								<a class="btn btn-success btn-md btn-block" name="actualizarDatosResolucion" id="actualizarDatosResolucion" style="display:none">
									Actualizar datos resolución <i class="mdi mdi-check-circle"></i>
								</a>
							</div>
						</div>
						<!-- Bloque de edición (IDs requeridos por el JS para editar) -->
						<div id="bloque_edicion_resolucion" class="border-top pt-3 mt-3" style="display:none">
							<div class="form-row">
								<div class="form-group col-md-3">
									<label class="font-weight-bold">Fecha inicio (edición)</label>
									<input type="date" id="res_fech_inicio" class="form-control">
								</div>
								<div class="form-group col-md-3">
									<label class="font-weight-bold">Fecha final (edición)</label>
									<input type="date" id="res_fech_fin" class="form-control" disabled>
								</div>
								<div class="form-group col-md-3">
									<label class="font-weight-bold">Años (edición)</label>
									<input type="number" id="res_anos" class="form-control" disabled>
								</div>
								<div class="form-group col-md-3">
									<label class="font-weight-bold">Número (edición)</label>
									<input type="number" id="num_res_org" class="form-control" disabled>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label class="font-weight-bold">Curso aprobado (edición)</label>
									<select class="form-control selectpicker" id="cursoAprobado" data-live-search="true" multiple>
										<option value="Acreditación Curso Básico de Economía Solidaria">Acreditación Curso Básico de Economía Solidaria</option>
										<option value="Aval de Trabajo Asociado">Aval de Trabajo Asociado</option>
										<option value="Acreditación Curso Medio de Economía Solidaria">Acreditación Curso Medio de Economía Solidaria</option>
										<option value="Acreditación Curso Avanzado de Economía Solidaria">Acreditación Curso Avanzado de Economía Solidaria</option>
										<option value="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria">Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label class="font-weight-bold">Modalidad aprobada (edición)</label>
									<select class="form-control selectpicker" id="modalidadAprobada" data-live-search="true" multiple>
										<option value="Presencial">Presencial</option>
										<option value="Virtual">Virtual</option>
										<option value="En Línea">En Línea</option>
										<option value="Semipresencial">Semipresencial</option>
										<option value="A distancia">A distancia</option>
									</select>
								</div>
							</div>

							<!-- Archivo actual -->
							<div class="form-row">
								<div class="form-group col-md-12">
									<a id="linkArchivoActual" class="btn btn-outline-info btn-sm" href="#" target="_blank" style="display:none">
										Ver archivo actual <i class="mdi mdi-file-pdf-box"></i>
									</a>
								</div>
							</div>

							<!-- Gestión de archivo (eliminar / reemplazar) -->
							<div class="form-row">
								<div class="form-group col-md-12">
									<label class="font-weight-bold">Archivo de la resolución (edición)</label>
									<div class="d-flex flex-wrap align-items-center">
										<div class="custom-file mr-2" style="max-width: 340px;">
											<input type="file" class="custom-file-input" id="resolucion_editar" accept="application/pdf">
											<label class="custom-file-label" for="resolucion_editar">Selecciona PDF...</label>
										</div>
										<button class="btn btn-outline-primary btn-sm" id="reemplazarArchivoResolucion">
											Reemplazar archivo <i class="mdi mdi-file-replace"></i>
										</button>
									</div>
								</div>
							</div>

							<a class="btn btn-warning btn-md btn-block" id="btn_actualizar_resolucion_sp" data-id-res="" data-id-org="">
								Guardar edición <i class="mdi mdi-content-save"></i>
							</a>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<!-- Tabla de resoluciones -->
			<div class="col-md-12" id="tabla_resoluciones_organizacion">
				<div class="card shadow-sm">
					<div class="card-header bg-white border-0">
						<h6 class="mb-0 text-primary">
							<i class="mdi mdi-table-large mr-2"></i>Resoluciones registradas
						</h6>
					</div>
					<div class="card-body">
						<?php if($resoluciones): ?>
						<div class="table-responsive">
							<table id="tabla_resoluciones" class="table table-hover table-striped">
								<thead class="thead-light">
								<tr>
									<th>Fecha inicial</th>
									<th>Fecha final</th>
									<th>Años</th>
									<th>Número</th>
									<th>Curso aprobado</th>
									<th>Modalidad</th>
									<th>Solicitud</th>
									<th>Estado</th>
									<th class="text-center">Acciones</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($resoluciones as $resolucion): ?>
									<?php
									$hoy = new DateTime(date('Y-m-d'));
									$fin = new DateTime($resolucion->fechaResolucionFinal);
									$vigente = ($fin >= $hoy);
									$diasRestantes = $vigente ? $hoy->diff($fin)->days : 0;
									$porVencer = $vigente && $diasRestantes <= 90;
									?>
									<tr>
									<td><?= $resolucion->fechaResolucionInicial; ?></td>
									<td><?= $resolucion->fechaResolucionFinal; ?></td>
									<td><?= $resolucion->anosResolucion; ?></td>
									<td><?= $resolucion->numeroResolucion; ?></td>
									<td>
										<span class="d-inline-block text-truncate" style="max-width: 220px;" title="<?= htmlspecialchars($resolucion->cursoAprobado, ENT_QUOTES, 'UTF-8'); ?>">
											<?= $resolucion->cursoAprobado; ?>
										</span>
									</td>
									<td><?= $resolucion->modalidadAprobada; ?></td>
									<td><?= $resolucion->idSolicitud; ?></td>
									<td>
									<?php if(!$vigente): ?>
									<span class="badge badge-danger px-3 py-2">
									<i class="mdi mdi-close-circle mr-1"></i>Vencida
									</span>
									<?php elseif($porVencer): ?>
									<span class="badge badge-warning px-3 py-2">
									<i class="mdi mdi-timer-sand mr-1"></i>Por vencer (<?= $diasRestantes ?> días)
									</span>
									<?php else: ?>
									<span class="badge badge-success px-3 py-2">
									<i class="mdi mdi-check-circle mr-1"></i>Vigente
									</span>
									<?php endif; ?>
									</td>
									<td class="text-center">
									<div class="btn-group" role="group" aria-label="acciones">
									<a class="btn btn-outline-info btn-sm"
									href="<?= base_url() . 'uploads/resoluciones/' . $resolucion->resolucion; ?>"
									target="_blank"
									title="Ver resolución PDF">
										<i class="mdi mdi-file-pdf-box"></i>
									</a>
									<button class="btn btn-outline-warning btn-sm editarResolucion"
										data-id-res="<?= $resolucion->id_resoluciones ?>"
										data-id-org="<?= $organizacion->id_organizacion ?>"
										title="Editar resolución">
										<i class="mdi mdi-pencil"></i>
									</button>
									<!-- Botón vencer con ícono; deshabilitado si ya está vencida -->
									<button class="btn btn-outline-warning btn-sm vencerResolucion"
										data-id-res="<?= $resolucion->id_resoluciones ?>"
										data-id-org="<?= $organizacion->id_organizacion ?>"
										data-fecha-fin="<?= $resolucion->fechaResolucionFinal ?>"
										title="<?= $vigente ? 'Marcar como vencida' : 'Ya vencida' ?>"
										<?= $vigente ? '' : 'disabled' ?>>
										<i class="mdi mdi-timer-off"></i>
									</button>
									<button class="btn btn-outline-danger btn-sm eliminarResolucion"
										data-id-org="<?= $organizacion->id_organizacion ?>"
										data-id-res="<?= $resolucion->id_resoluciones ?>"
										title="Eliminar resolución">
										<i class="mdi mdi-trash-can"></i>
									</button>
									</div>
									</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<?php else: ?>
							<div class="alert alert-info mb-0">No hay resoluciones registradas.</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
