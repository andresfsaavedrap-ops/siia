<?php
/***
 * @var $logged_in
 * @var $tipo_usuario
 * @var $resoluciones
 * @var $organizaciones
 */
$CI = &get_instance();
$CI->load->model("ResolucionesModel");
if($logged_in == TRUE && $tipo_usuario == "super" || $tipo_usuario == "admin"): ?>
	<script type="module" src="<?= base_url('assets/js/functions/admin/modules/resoluciones/main.js?v=1.1') . time() ?>" ></script>
	<!-- partial -->
	<div class="main-panel">
		<div class="content-wrapper">
			<!-- Header Section -->
			<div class="row mb-4">
				<div class="col-md-12">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h3 class="font-weight-bold text-primary mb-0">
								<i class="mdi mdi-file-document-edit text-primary mr-2"></i>
								Gestión de Resoluciones
							</h3>
							<p class="text-muted mb-0">Administra las resoluciones de acreditación registradas en el sistema</p>
						</div>
						<button type="button" class="btn btn-primary btn-lg shadow-sm resoluciones-modal" data-funct="crear" data-toggle="modal" data-target="#modal-resolucion">
							<i class="mdi mdi-plus mr-2"></i>
							Crear Resolución
						</button>
					</div>
				</div>
			</div>
			<!-- Statistics Cards -->
			<?php
			    $total_res = is_array($resoluciones) ? count($resoluciones) : 0;
			    $hoy = new DateTime(date('Y-m-d'));
			    $vigentes = 0; 
			    $por_vencer = 0; 
			    $vencidas = 0;
			
			    foreach ($resoluciones as $res) {
			        if (!isset($res->fechaResolucionFinal) || empty($res->fechaResolucionFinal)) continue;
			        $fin = new DateTime($res->fechaResolucionFinal);
			        if ($fin >= $hoy) {
			            $vigentes++;
			            $dias = (int)$hoy->diff($fin)->days;
			            if ($dias <= 90) $por_vencer++;
			        } else {
			            $vencidas++;
			        }
			    }
			?>
			<!-- Resoluciones table -->
			<div class="row mb-4">
			    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
			        <div class="card shadow-sm border-left-primary">
			            <div class="card-body">
			                <div class="row">
			                    <div class="col">
			                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Resoluciones</div>
			                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_res ?></div>
			                    </div>
			                    <div class="col-auto">
			                        <div class="icon-shape bg-primary-light rounded-circle">
			                            <i class="mdi mdi-file-document-multiple-outline text-primary"></i>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
			        <div class="card shadow-sm border-left-success">
			            <div class="card-body">
			                <div class="row">
			                    <div class="col">
			                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Vigentes</div>
			                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $vigentes ?></div>
			                    </div>
			                    <div class="col-auto">
			                        <div class="icon-shape bg-success-light rounded-circle">
			                            <i class="mdi mdi-check-circle text-success"></i>
			                        </div>
			                    </div>
			                </div>
			                <small class="text-muted">Incluye las que vencen después de hoy.</small>
			            </div>
			        </div>
			    </div>
			    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
			        <div class="card shadow-sm border-left-warning">
			            <div class="card-body">
			                <div class="row">
			                    <div class="col">
			                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Por vencer (≤ 90 días)</div>
			                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $por_vencer ?></div>
			                    </div>
			                    <div class="col-auto">
			                        <div class="icon-shape bg-warning-light rounded-circle">
			                            <i class="mdi mdi-calendar-alert text-warning"></i>
			                        </div>
			                    </div>
			                </div>
			                <small class="text-muted">Subconjunto de vigentes.</small>
			            </div>
			        </div>
			    </div>
			    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
			        <div class="card shadow-sm border-left-danger">
			            <div class="card-body">
			                <div class="row">
			                    <div class="col">
			                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Vencidas</div>
			                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $vencidas ?></div>
			                    </div>
			                    <div class="col-auto">
			                        <div class="icon-shape bg-danger-light rounded-circle">
			                            <i class="mdi mdi-alert-circle text-danger"></i>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card shadow">
						<div class="card-header bg-white border-0">
							<div class="d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">
									<i class="mdi mdi-table-large text-primary mr-2"></i>
									Registro de Resoluciones
								</h4>
								<div class="badge badge-primary badge-pill">
									<?= count($resoluciones) ?> registros
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="tabla_super_resoluciones" class="table table-hover table-striped">
									<thead class="thead-light">
										<tr>
											<th class="border-0">
												<i class="mdi mdi-domain mr-1"></i>Organización
											</th>
											<th class="border-0">
												<i class="mdi mdi-file-document mr-1"></i>Número Resolución
											</th>
											<th class="border-0">
												<i class="mdi mdi-domain mr-1"></i>Sigla
											</th>
											<th class="border-0">
												<i class="mdi mdi-card-account-details mr-1"></i>NIT
											</th>
											<th class="border-0">
												<i class="mdi mdi-calendar-range mr-1"></i>Años Vigencia
											</th>
											<th class="border-0">
												<i class="mdi mdi-calendar-start mr-1"></i>Fecha Inicio
											</th>
											<th class="border-0">
												<i class="mdi mdi-calendar-end mr-1"></i>Fecha Fin
											</th>
											<th class="border-0">
												<i class="mdi mdi-check-circle mr-1"></i>Estado
											</th>
											<th class="border-0 text-center">
												<i class="mdi mdi-cog mr-1"></i>Acciones
											</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php
										$hoy = date('Y-m-d');
										$hoyDate = new DateTime(date('Y-m-d'));
										foreach ($resoluciones as $resolucion):
											$finDate = new DateTime($resolucion->fechaResolucionFinal);
											$vigente = $finDate >= $hoyDate;
											$diasRestantes = $vigente ? (int)$hoyDate->diff($finDate)->days : null;
											$porVencer = $vigente && $diasRestantes <= 90;
										?>
										<tr class="align-middle">
											<td>
												<div class="d-flex align-items-center">
													<span class="font-weight-bold"><?= $resolucion->nombreOrganizacion ?></span>
												</div>
											</td>
											<td>
												<span class="badge badge-outline-primary px-3 py-2">
													<?= $resolucion->numeroResolucion ?>
												</span>
											</td>
											<td>
												<span class="font-weight-bold"><?= $resolucion->sigla ?></span>
											</td>
											<td>
												<span class="font-weight-bold"><?= $resolucion->numNIT ?></span>
											</td>
											<td>
												<span class="badge badge-outline-info px-3 py-2">
													<?= $resolucion->anosResolucion ?> años
												</span>
											</td>
											<td>
												<span class="text-muted"><?= $resolucion->fechaResolucionInicial ?></span>
											</td>
											<td>
												<span class="text-muted"><?= $resolucion->fechaResolucionFinal ?></span>
											</td>
											<td>
												<?php if(!$vigente): ?>
													<span class="badge badge-danger px-3 py-2">
														<i class="mdi mdi-close-circle mr-1"></i>Vencida
													</span>
												<?php elseif($porVencer): ?>
													<span class="badge badge-warning px-3 py-2">
														<i class="mdi mdi-calendar-alert mr-1"></i>Por vencer
													</span>
												<?php else: ?>
													<span class="badge badge-success px-3 py-2">
														<i class="mdi mdi-check-circle mr-1"></i>Vigente
													</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button class="btn btn-outline-primary btn-sm ver_resolucion_org"
													data-organizacion="<?= $resolucion->organizaciones_id_organizacion ?>"
													title="Gestionar por organización">
													<i class="mdi mdi-folder-open"></i>
												</button>
												<button class="btn btn-outline-warning btn-sm editarResolucion"
													data-id-res="<?= $resolucion->id_resoluciones ?>"
													data-id-org="<?= $resolucion->organizaciones_id_organizacion ?>"
													data-toggle="modal"
													data-target="#modal-resolucion"
													title="Editar resolución">
													<i class="mdi mdi-pencil"></i>
												</button>
												<!-- Botón vencer con ícono; deshabilitado si ya está vencida -->
												<button class="btn btn-outline-warning btn-sm vencerResolucion"
													data-id-res="<?= $resolucion->id_resoluciones ?>"
													data-id-org="<?= $resolucion->organizaciones_id_organizacion ?>"
													data-fecha-fin="<?= $resolucion->fechaResolucionFinal ?>"
													title="<?= $vigente ? 'Marcar como vencida' : 'Ya vencida' ?>"
													<?= $vigente ? '' : 'disabled' ?>>
													<i class="mdi mdi-timer-off"></i>
												</button>
												<!-- Eliminar solo visible para admin nivel 0 -->
												<?php if ($tipo_usuario === 'admin' && intval($nivel) === 0): ?>
													<button class="btn btn-outline-danger btn-sm eliminarResolucion"
														data-id-res="<?= $resolucion->id_resoluciones ?>"
														data-id-org="<?= $resolucion->organizaciones_id_organizacion ?>"
														title="Eliminar resolución">
														<i class="mdi mdi-trash-can"></i>
													</button>
												<?php endif; ?>
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
			<!-- Modal formulario crear resolución -->
			<div class="modal fade" id="modal-resolucion" tabindex="-1" role="dialog" aria-labelledby="modal-resolucion">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content shadow-lg border-0">
						<div class="modal-header bg-primary text-white border-0">
							<h4 class="modal-title text-white" id="resolu">
								<i class="mdi mdi-file-document-plus mr-2"></i>
								<span id="modal-title-resolucion">Crear Resolución</span>
							</h4>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body p-4">
							<div class="container-fluid">
								<?php echo form_open('', array('id' => 'form_resoluciones_super')); ?>
								
								<!-- Información de la Organización -->
								<div class="card border-0 shadow-sm mb-4">
									<div class="card-header bg-light border-0">
										<h6 class="mb-0 text-primary">
											<i class="mdi mdi-domain mr-2"></i>Información de la Organización
										</h6>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="form-label font-weight-bold">Organización <span class="text-danger">*</span></label>
													<select name="id-organizacion" id="id-organizacion" class="form-control selectpicker" required>
														<option value="">Seleccione una organización...</option>
														<?php foreach ($organizaciones as $organizacion) : ?>
															<option value="<?= $organizacion->id_organizacion ?>" data-nit="<?= $organizacion->numNIT ?>">
																<?= $organizacion->numNIT ?> | <?= $organizacion->sigla ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group mt-3">
													<label class="form-label font-weight-bold">Tipo de resolución <span class="text-danger">*</span></label>
													<div>
														<label class="mr-3"><input type="radio" name="tipoResolucionSuper" value="nueva" checked> Vigente</label>
														<label><input type="radio" name="tipoResolucionSuper" value="vieja"> Vieja</label>
													</div>
												</div>
											</div>
										</div>
										<!-- Si es resolución vieja -->
										<div id="resolucionViejaSuper" style="display:none;">
											<div class="form-group">
												<label class="form-label font-weight-bold">Curso aprobado</label>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="1" name="motivosSuper" checked> Acreditación Curso Básico de Economía Solidaria</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="2" name="motivosSuper"> Aval de Trabajo Asociado</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="3" name="motivosSuper"> Acreditación Curso Medio de Economía Solidaria</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="4" name="motivosSuper"> Acreditación Curso Avanzado de Economía Solidaria</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="5" name="motivosSuper"> Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria</div>
											</div>
											<div class="form-group">
												<label class="form-label font-weight-bold">Modalidad aprobada</label>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="1" name="modalidadesSuper" checked> Presencial</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="2" name="modalidadesSuper"> Virtual</div>
												<div class="form-check"><input class="form-check-input" type="checkbox" value="3" name="modalidadesSuper"> En Línea</div>
											</div>
										</div>
										<!-- Si es resolución vigente anclada a una solicitud acreditada -->
										<div id="resolucionVigenteSuper">
											<div class="form-group">
												<label class="form-label font-weight-bold">Solicitud acreditada</label>
												<select class="form-control" name="idSolicitudSuper" id="idSolicitudSuper">
													<option value="">Seleccione una solicitud...</option>
												</select>
												<small class="text-muted">Se cargarán las solicitudes acreditadas al seleccionar la organización.</small>
											</div>
										</div>
									</div>
								</div>

								<!-- Información de la Resolución -->
								<div class="card border-0 shadow-sm mb-4">
									<div class="card-header bg-light border-0">
										<h6 class="mb-0 text-primary">
											<i class="mdi mdi-file-document mr-2"></i>Datos de la Resolución
										</h6>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label font-weight-bold">Número de Resolución <span class="text-danger">*</span></label>
													<input type="text" name="numero-resolucion-super" id="numero-resolucion-super" class="form-control" required placeholder="Número de resolución">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label font-weight-bold">Años de Vigencia <span class="text-danger">*</span></label>
													<input type="number" name="anos-resolucion-super" id="anos-resolucion-super" class="form-control" required placeholder="Años de vigencia" min="1" max="10" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label font-weight-bold">Fecha de Inicio <span class="text-danger">*</span></label>
													<input class="form-control" placeholder="YYYY-MM-DD" type="date" id="fecha-inicio-super" required>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label font-weight-bold">Fecha de Finalización <span class="text-danger">*</span></label>
													<input class="form-control" placeholder="YYYY-MM-DD" type="date" id="fecha-fin-super" required disabled>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-md-12">
												<div class="form-group">
													<label class="form-label font-weight-bold">Adjuntar resolución (PDF) <span class="text-danger">*</span></label>
													<input type="file" class="form-control" id="resolucion_super" accept="application/pdf" required>
													<!-- Vista del archivo actual y acción de reemplazo: solo en modo editar -->
													<div class="d-flex align-items-center mt-2" id="archivoActualSuperWrapper" style="display:none;">
														<a href="#" target="_blank" id="linkPdfActualSuper" class="text-primary mr-3">Ver PDF actual</a>
														<button type="button" class="btn btn-outline-primary btn-sm" id="btn_reemplazar_archivo_sp" style="display:none;">
															<i class="mdi mdi-file-replace mr-1"></i>Reemplazar PDF
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						<div class="modal-footer bg-light border-0">
							<div class="d-flex justify-content-between w-100">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">
									<i class="mdi mdi-close mr-1"></i>Cancelar
								</button>
								<div>
									<button id="btn_actualizar_resolucion_sp" class="btn btn-warning" style="display:none;">
										<i class="mdi mdi-content-save-edit mr-1"></i>Actualizar Resolución
									</button>
									<button id="btn_crear_resolucion_sp" class="btn btn-success">
										<i class="mdi mdi-check mr-1"></i>Crear Resolución
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
			<script>
			$(document).ready(function() {
				// Inicializar tabla simple de resoluciones
				DataTableConfig.initGroupedTable(
					'#tabla_super_resoluciones',
					'Registro de Resoluciones',
					'resoluciones_siia',
					8,
					0,
					[1, 2, 3, 4, 5, 6, 7]
				);
			});
			</script>
		</div>
	</div>
<?php endif; ?>
</div>
