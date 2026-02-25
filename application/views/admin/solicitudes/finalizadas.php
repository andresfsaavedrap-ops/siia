<?php
/***
 * @var $solicitudesAsignadas
 * @var Solicitudes $this
 * @var $nombre_usuario
 * @var $nivel
 */
?>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<!-- Configuración de variables globales para JavaScript -->
<script>
	// Configurar variables globales para el sistema de observaciones
	window.__bloquearObservaciones = <?= isset($bloquearObservaciones) && $bloquearObservaciones ? 'true' : 'false' ?>;
	window.__vistaModo = '<?= isset($vista_modo) ? $vista_modo : 'finalizadas' ?>';

	// Autocarga de una solicitud específica en modo observaciones
	window.__autocargarSolicitud = <?= isset($autocargarSolicitud) && $autocargarSolicitud ? 'true' : 'false' ?>;
	window.__idSolicitud = '<?= isset($idSolicitud) ? $idSolicitud : '' ?>';
	window.__idOrganizacion = '<?= isset($idOrganizacion) ? $idOrganizacion : '' ?>';
</script>
<script src="<?= base_url('assets/js/functions/admin/modules/solicitudes/observaciones.js?v=1.0.1') . time() ?>" type="module"></script>
<!-- Incluir JavaScript de batería de observaciones -->
<script src="<?= base_url('assets/js/functions/admin/modules/operaciones/bateria-observaciones.js?v=1.0.0') . time() ?>" type="module"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin/modules/solicitudes/finalizadas.css'); ?>" type="text/css" />
<!-- Estilos específicos para componentes parciales -->
<link rel="stylesheet" href="<?= base_url('assets/css/admin/modules/solicitudes/partials.css?v=1.0') ?>" type="text/css" />
<div class="main-panel">
	<div class="content-wrapper">
		<!-- Header Section -->
		<div class="row mb-3"  id="admin_ver_header">
			<div class="col-md-12">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="font-weight-bold text-primary mb-0">
							<i class="mdi mdi-check-circle text-primary mr-2"></i>
							<?= (isset($vista_modo) && $vista_modo === 'observaciones') ? 'Solicitudes en Observaciones' : 'Solicitudes en Evaluacion' ?>
						</h4>
						<p class="text-muted mb-0 small">
							<?= (isset($vista_modo) && $vista_modo === 'observaciones')
								? 'Gestiona y revisa las solicitudes en estado de observación'
								: 'Gestiona y revisa las solicitudes en evaluación del sistema SEAS' ?>
						</p>
					</div>
					<?php $this->load->view('admin/solicitudes/partials/_btn_volver'); ?>
				</div>
			</div>
		</div>
		<!-- Estadísticas rápidas -->
		<div class="row mb-4" id="admin_ver_stats">
			<div class="col-md-4">
				<div class="card border-left-success shadow-sm" style="border-left-width: 4px;">
					<div class="card-body py-3">
						<div class="d-flex align-items-center">
							<div class="icon-circle bg-success-light mr-3">
								<i class="mdi mdi-check-circle text-success"></i>
							</div>
							<div>
								<h6 class="font-weight-medium text-muted mb-0 small">Total Finalizadas</h6>
								<h4 class="font-weight-bold mb-0">
									<?php 
									$totalFinalizadas = 0;
									if (is_array($solicitudesAsignadas)) {
										$totalFinalizadas = count(array_filter($solicitudesAsignadas, function($s) { 
											return $s->fechaFinalizado != null; 
										}));
									} elseif (is_object($solicitudesAsignadas) && $solicitudesAsignadas->fechaFinalizado != null) {
										$totalFinalizadas = 1;
									}
									echo $totalFinalizadas;
									?>
								</h4>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="detalleSolicitud" tabindex="-1" role="dialog" aria-labelledby="ariaDetalleFinalizadas">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-detalle">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white" id="ariaDetalleFinalizadas">
                    <i class="mdi mdi-information-outline mr-2"></i>Detalle de la Solicitud
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-card mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-2 mb-md-0">
                            <div class="section-title"><i class="mdi mdi-domain mr-1"></i>Organización</div>
                            <p class="font-weight-medium mb-1" id="detalleOrganizacion">-</p>
                            <span class="badge badge-info" id="detalleNit">-</span>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <div class="small text-muted">ID Solicitud</div>
                                <div class="font-weight-medium" id="detalleIdSolicitud">-</div>
                            </div>
                            <script>
                            $(document).on('click', '.verDetalleSolicitud', function() {
                                const $btn = $(this);
                                $('#detalleIdSolicitud').text($btn.data('id') || '-');
                                $('#detalleOrganizacion').text($btn.data('organizacion') || '-');
                                $('#detalleNit').text($btn.data('nit') || '-');
                                $('#detalleTipo').text($btn.data('tipo') || '-');
                                $('#detalleMotivo').text($btn.data('motivo') || '-');
                                $('#detalleModalidad').text($btn.data('modalidad') || '-');
                                $('#detalleFecha').text($btn.data('fecha') || '-');
                                $('#detalleUltima').text($btn.data('ultima') || '-');
                                $('#detalleAsignada').text($btn.data('asignada') || '-');
                                $('#detalleFechaAsig').text($btn.data('fechaasig') || '-');
                                $('#detalleAsignadaPor').text($btn.data('asignadapor') || '-');
                                $('#detalleSolicitud').modal('show');
                            });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Tipo</div>
                            <div id="detalleTipo">-</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Modalidad</div>
                            <div id="detalleModalidad">-</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="detail-card">
                            <div class="small text-muted">Asignada a</div>
                            <span class="badge badge-success" id="detalleAsignada">-</span>
                        </div>
                    </div>
                </div>

                <div class="detail-card mt-2">
                    <div class="small text-muted">Motivo</div>
                    <p class="mb-0" id="detalleMotivo">-</p>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="detail-card">
                            <div class="small text-muted">Fecha Finalización</div>
                            <div id="detalleFecha">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <div class="small text-muted">Última Actualización</div>
                            <div id="detalleUltima">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <div class="small text-muted">Asignada Por</div>
                            <div id="detalleAsignadaPor">-</div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="small text-muted">Fecha Asignación</div>
                            <div id="detalleFechaAsig">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
			<div class="col-md-4">
				<div class="card border-left-info shadow-sm" style="border-left-width: 4px;">
					<div class="card-body py-3">
						<div class="d-flex align-items-center">
							<div class="icon-circle bg-info-light mr-3">
								<i class="mdi mdi-account-check text-info"></i>
							</div>
							<div>
								<h6 class="font-weight-medium text-muted mb-0 small">Mis Evaluaciones</h6>
								<h4 class="font-weight-bold mb-0">
									<?php 
									$misEvaluaciones = 0;
									if (is_array($solicitudesAsignadas)) {
										$misEvaluaciones = count(array_filter($solicitudesAsignadas, function($s) use ($nombre_usuario) { 
											return $s->asignada == $nombre_usuario && $s->fechaFinalizado != null; 
										}));
									} elseif (is_object($solicitudesAsignadas) && $solicitudesAsignadas->asignada == $nombre_usuario && $solicitudesAsignadas->fechaFinalizado != null) {
										$misEvaluaciones = 1;
									}
									echo $misEvaluaciones;
									?>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card border-left-warning shadow-sm" style="border-left-width: 4px;">
					<div class="card-body py-3">
						<div class="d-flex align-items-center">
							<div class="icon-circle bg-warning-light mr-3">
								<i class="mdi mdi-calendar-clock text-warning"></i>
							</div>
							<div>
								<h6 class="font-weight-medium text-muted mb-0 small">Este Mes</h6>
								<h4 class="font-weight-bold mb-0">
									<?php 
									$esteMes = 0;
									$mesActual = date('Y-m');
									if (is_array($solicitudesAsignadas)) {
										$esteMes = count(array_filter($solicitudesAsignadas, function($s) use ($mesActual) { 
											return $s->fechaFinalizado != null && date('Y-m', strtotime($s->fechaFinalizado)) == $mesActual; 
										}));
									} elseif (is_object($solicitudesAsignadas) && $solicitudesAsignadas->fechaFinalizado != null && date('Y-m', strtotime($solicitudesAsignadas->fechaFinalizado)) == $mesActual) {
										$esteMes = 1;
									}
									echo $esteMes;
									?>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Contenido principal -->
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="card shadow-sm" id="admin_ver_finalizadas">
					<div class="card-header bg-white border-0 pb-0">
						<div class="d-flex justify-content-between align-items-center">
							<h5 class="font-weight-medium mb-0">
								<i class="mdi mdi-table mr-2 text-primary"></i>
								<?= (isset($vista_modo) && $vista_modo === 'observaciones') ? 'Solicitudes en Observación' : 'Solicitudes en Evaluación' ?>
							</h5>
							<div class="d-flex align-items-center">
								<button class="btn btn-outline-primary btn-sm mr-2" onclick="refreshTable()">
									<i class="mdi mdi-refresh mr-1"></i>Actualizar
								</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<?php 
						$hasSolicitudes = false;
						if (is_array($solicitudesAsignadas)) {
							$solicitudesValidas = array_filter($solicitudesAsignadas, function($s) use ($nombre_usuario, $nivel) {
								return ($s->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6);
							});
							$hasSolicitudes = count($solicitudesValidas) > 0;
						} elseif (is_object($solicitudesAsignadas)) {
							$hasSolicitudes = (($solicitudesAsignadas->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6));
						}
						?>

						<?php if ($hasSolicitudes): ?>
                            <div class="table-responsive">
                                <table id="tabla_enProceso_organizacion" class="table table-hover table-striped w-100">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">Organización</th>
                                            <th class="border-0">NIT</th>
                                            <th class="border-0">ID Solicitud</th>
                                            <th class="border-0">Fecha Finalización</th>
                                            <th class="border-0">Última Actualización</th>
                                            <?php if (isset($vista_modo) && $vista_modo === 'observaciones'): ?>
                                            <th class="border-0">Última Revisión</th>
                                            <?php endif; ?>
                                            <th class="border-0">Asignada a</th>
                                            <th class="border-0">Fecha Asignación</th>
                                            <th class="border-0">Asignada Por</th>
                                            <th class="border-0">Acción</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
										if (is_array($solicitudesAsignadas)) {
                                            foreach ($solicitudesAsignadas as $solicitud) :
                                                if (($solicitud->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6)):
                                                    echo "<tr>";
                                                    echo "<td><div style=\"white-space: normal; word-break: break-word;\">" . htmlspecialchars($solicitud->nombreOrganizacion) . "</div></td>";
                                                    echo "<td>" . $solicitud->numNIT . "</td>";
                                                    echo "<td><span class='badge badge-primary'>" . $solicitud->idSolicitud . "</span></td>";
                                                    echo "<td><i class='mdi mdi-calendar mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaFinalizado)) . "</td>";
                                                    echo "<td><i class='mdi mdi-clock-outline mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaUltimaActualizacion)) . "</td>";
                                                    if (isset($vista_modo) && $vista_modo === 'observaciones'):
                                                        echo "<td><i class='mdi mdi-calendar-refresh mr-1'></i>" . ($solicitud->fechaUltimaRevision ? date('d/m/Y', strtotime($solicitud->fechaUltimaRevision)) : '-') . "</td>";
                                                    endif;
                                                    echo "<td><span class='badge badge-info'>" . $solicitud->asignada . "</span></td>";
                                                    echo "<td>" . date('d/m/Y', strtotime($solicitud->fechaAsignacion)) . "</td>";
                                                    echo "<td>" . $solicitud->asignada_por . "</td>";
                                                    echo "<td>";
                                                    echo "<button class='btn btn-primary btn-sm ver_organizacion_finalizada' ";
                                                    echo "data-organizacion='" . $solicitud->id_organizacion . "' ";
                                                    echo "data-solicitud='" . $solicitud->idSolicitud . "'>";
                                                    echo "<i class='mdi mdi-eye mr-1'></i>Ver información";
                                                    echo "</button>";
                                                    echo "<button class='btn btn-outline-info btn-sm ml-1 verDetalleSolicitud' ";
                                                    echo "data-toggle='modal' data-target='#detalleSolicitud' ";
                                                    echo "data-id='" . $solicitud->idSolicitud . "' ";
                                                    echo "data-organizacion='" . htmlspecialchars($solicitud->nombreOrganizacion) . "' ";
                                                    echo "data-nit='" . $solicitud->numNIT . "' ";
                                                    echo "data-tipo='" . htmlspecialchars($solicitud->tipoSolicitud) . "' ";
                                                    echo "data-motivo='" . htmlspecialchars($solicitud->motivoSolicitud) . "' ";
                                                    echo "data-modalidad='" . htmlspecialchars($solicitud->modalidadSolicitud) . "' ";
                                                    echo "data-fecha='" . date('d/m/Y', strtotime($solicitud->fechaFinalizado)) . "' ";
                                                    echo "data-ultima='" . date('d/m/Y', strtotime($solicitud->fechaUltimaActualizacion)) . "' ";
                                                    echo "data-asignada='" . htmlspecialchars($solicitud->asignada) . "' ";
                                                    echo "data-fechaasig='" . date('d/m/Y', strtotime($solicitud->fechaAsignacion)) . "' ";
                                                    echo "data-asignadapor='" . htmlspecialchars($solicitud->asignada_por) . "'";
													echo "<i class='mdi mdi-information-outline mr-1'></i>Detalle";
                                                    echo "</button>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                endif;
                                            endforeach;
										} elseif (is_object($solicitudesAsignadas)) {
											$solicitud = $solicitudesAsignadas;
											if (($solicitud->asignada == $nombre_usuario && $nivel == 1) || ($nivel == 0 || $nivel == 6)):
												echo "<tr>";
                                            echo "<td class='font-weight-medium'><div style=\"white-space: normal; word-break: break-word;\">" . htmlspecialchars($solicitud->nombreOrganizacion) . "</div></td>";
                                            echo "<td>" . $solicitud->numNIT . "</td>";
                                            echo "<td><span class='badge badge-primary'>" . $solicitud->idSolicitud . "</span></td>";
                                            echo "<td><i class='mdi mdi-calendar mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaFinalizado)) . "</td>";
                                            echo "<td><i class='mdi mdi-clock-outline mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaUltimaActualizacion)) . "</td>";
                                            if (isset($vista_modo) && $vista_modo === 'observaciones'):
                                                echo "<td><i class='mdi mdi-calendar-refresh mr-1'></i>" . ($solicitud->fechaUltimaRevision ? date('d/m/Y', strtotime($solicitud->fechaUltimaRevision)) : '-') . "</td>";
                                            endif;
                                            echo "<td><span class='badge badge-info'>" . $solicitud->asignada . "</span></td>";
                                            echo "<td>" . date('d/m/Y', strtotime($solicitud->fechaAsignacion)) . "</td>";
                                            echo "<td>" . $solicitud->asignada_por . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-primary btn-sm ver_organizacion_finalizada' ";
                                            echo "data-organizacion='" . $solicitud->id_organizacion . "' ";
                                            echo "data-solicitud='" . $solicitud->idSolicitud . "'>";
                                            echo "<i class='mdi mdi-eye mr-1'></i>Ver información";
                                            echo "</button>";
                                            echo "<button class='btn btn-outline-info btn-sm ml-1 verDetalleSolicitud' ";
                                            echo "data-toggle='modal' data-target='#detalleSolicitud' ";
                                            echo "data-id='" . $solicitud->idSolicitud . "' ";
                                            echo "data-organizacion='" . htmlspecialchars($solicitud->nombreOrganizacion) . "' ";
                                            echo "data-nit='" . $solicitud->numNIT . "' ";
                                            echo "data-tipo='" . htmlspecialchars($solicitud->tipoSolicitud) . "' ";
                                            echo "data-motivo='" . htmlspecialchars($solicitud->motivoSolicitud) . "' ";
                                            echo "data-modalidad='" . htmlspecialchars($solicitud->modalidadSolicitud) . "' ";
                                            echo "data-fecha='" . date('d/m/Y', strtotime($solicitud->fechaFinalizado)) . "' ";
                                            echo "data-ultima='" . date('d/m/Y', strtotime($solicitud->fechaUltimaActualizacion)) . "' ";
                                            echo "data-asignada='" . htmlspecialchars($solicitud->asignada) . "' ";
                                            echo "data-fechaasig='" . date('d/m/Y', strtotime($solicitud->fechaAsignacion)) . "' ";
                                            echo "data-asignadapor='" . htmlspecialchars($solicitud->asignada_por) . "'";
                                            echo "<i class='mdi mdi-information-outline mr-1'></i>Detalle";
                                            echo "</button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        endif;
										}
										?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="text-center py-5">
								<div class="icon-circle bg-info-light mx-auto mb-3" style="width: 60px; height: 60px;">
									<i class="mdi mdi-information text-info" style="font-size: 2rem;"></i>
								</div>
								<h5 class="font-weight-medium text-muted mb-2">Sin solicitudes finalizadas</h5>
								<p class="text-muted mb-0">No hay solicitudes finalizadas disponibles para mostrar</p>
								<small class="text-muted">Las solicitudes completadas aparecerán aquí</small>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Panel de detalles de solicitud -->
		<div class="col-12" id="admin_panel_ver_finalizada" style="display: none;">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white">
					<h5 class="mb-0 text-white">
						<i class="mdi mdi-file-document-outline mr-2"></i>
						Detalles de la Solicitud
					</h5>
				</div>
				<div class="card-body">
					<div class="panel-group" id="datos_org_final">
						<!-- Despliegue de resumen de información solicitud -->
						<?php $this->load->view('admin/solicitudes/partials/_info'); ?>
						<!-- Formularios solicitud -->
						<?php $this->load->view('admin/solicitudes/partials/_forms'); ?>
						<!-- Botón y menu de navegación -->
						<?php $this->load->view('admin/solicitudes/partials/_menu'); ?>
						<!-- Menú flotante de observaciones -->
						<?php $this->load->view('admin/operaciones/partials/_menu_observaciones'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
