<?php
/***
 * @var $solicitudes
 */
$CI = &get_instance();
$CI->load->model("SolicitudesModel");
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin/modules/solicitudes/finalizadas.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?= base_url('assets/css/admin/modules/solicitudes/partials.css?v=1.0') ?>" type="text/css" />
<script type="module" src="<?= base_url('assets/js/functions/admin/modules/solicitudes/estados.js?v=1.2.1') . time() ?>"></script>

<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-3" id="admin_estado_header">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-clipboard-list text-primary mr-2"></i>
                            Estado de las solicitudes
                        </h4>
                        <p class="text-muted mb-0 small">Consulta y actualiza el estado de las solicitudes de organizaciones</p>
                    </div>
					<?php $this->load->view('admin/solicitudes/partials/_btn_volver'); ?>
                </div>
            </div>
        </div>
        <!-- Tarjetas de estadísticas -->
        <div class="row mb-3" id="admin_estado_stats">
            <?php
            // Totales y métricas rápidas
            $totalSolicitudes = 0;
            $esteMes = 0;
            $mesActual = date('Y-m');
            $estadosCount = [
                'Acreditado' => 0,
                'Archivada' => 0,
                'Negada' => 0,
                'Revocada' => 0
            ];
            if (is_array($solicitudes)) {
                $totalSolicitudes = count($solicitudes);
                foreach ($solicitudes as $s) {
                    if (!empty($s->fechaFinalizado) && date('Y-m', strtotime($s->fechaFinalizado)) === $mesActual) {
                        $esteMes++;
                    }
                    if (isset($s->nombre) && isset($estadosCount[$s->nombre])) {
                        $estadosCount[$s->nombre]++;
                    }
                }
            } elseif (is_object($solicitudes)) {
                $totalSolicitudes = 1;
                if (!empty($solicitudes->fechaFinalizado) && date('Y-m', strtotime($solicitudes->fechaFinalizado)) === $mesActual) {
                    $esteMes = 1;
                }
                if (isset($solicitudes->nombre) && isset($estadosCount[$solicitudes->nombre])) {
                    $estadosCount[$solicitudes->nombre]++;
                }
            }
            ?>
            <!-- Resumen por estado: full width -->
            <div class="col-md-12 mb-3">
                <div class="card border-left-success shadow-sm" style="border-left-width: 4px;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-start">
                            <div class="icon-circle bg-success-light mr-3">
                                <i class="mdi mdi-chart-donut text-success"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-medium text-muted mb-2 small">Resumen por estado</h6>
                                <div class="d-flex flex-wrap">
                                    <div class="mr-4 mb-1 small text-muted">Acreditado: <span class="font-weight-bold text-success"><?= $estadosCount['Acreditado'] ?></span></div>
                                    <div class="mr-4 mb-1 small text-muted">Archivada: <span class="font-weight-bold"><?= $estadosCount['Archivada'] ?></span></div>
                                    <div class="mr-4 mb-1 small text-muted">Negada: <span class="font-weight-bold"><?= $estadosCount['Negada'] ?></span></div>
                                    <div class="mb-1 small text-muted">Revocada: <span class="font-weight-bold"><?= $estadosCount['Revocada'] ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Totales: 2 columnas debajo -->
            <div class="col-md-6">
                <div class="card border-left-info shadow-sm" style="border-left-width: 4px;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-light mr-3">
                                <i class="mdi mdi-file-document-multiple text-info"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-medium text-muted mb-0 small">Total Solicitudes</h6>
                                <h4 class="font-weight-bold mb-0"><?= $totalSolicitudes ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-left-warning shadow-sm" style="border-left-width: 4px;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning-light mr-3">
                                <i class="mdi mdi-calendar-clock text-warning"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-medium text-muted mb-0 small">Finalizadas este mes</h6>
                                <h4 class="font-weight-bold mb-0"><?= $esteMes ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin tarjetas -->
        <!-- Tabla de solicitudes -->
        <div class="row mb-4">
            <div class="col-md-12" id="admin_ver_finalizadas">
                <div class="card shadow-sm" id="admin_estado_lista">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-medium mb-0">
                                <i class="mdi mdi-table mr-2 text-primary"></i>
                                Solicitudes
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla_enProceso_organizacion" width="100%" class="table table-hover table-striped tabla_form">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Organización</th>
                                        <th>NIT</th>
                                        <th>ID Solicitud</th>
                                        <th>Fecha de Creación</th>
                                        <th>Motivo</th>
                                        <th>Modalidad</th>
                                        <th>Estado actual</th>
                                        <th>Fecha Finalización</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                <?php
                                foreach ($solicitudes as $solicitud) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<div class='motivo-cell' title='" . htmlspecialchars($solicitud->nombreOrganizacion) . "'>";
                                    echo strlen($solicitud->nombreOrganizacion) > 100 ? substr($solicitud->nombreOrganizacion, 0, 100) . '...' : $solicitud->nombreOrganizacion;
                                    echo "</div>";
                                    echo "</td>";
                                    echo "<td>" . $solicitud->numNIT . "</td>";
                                    echo "<td><span class='badge badge-primary'>" . $solicitud->idSolicitud . "</span></td>";
                                    echo "<td><i class='mdi mdi-calendar mr-1'></i>" . $solicitud->fechaCreacion . "</td>";
                                    echo "<td>";
                                    echo "<div class='motivo-cell' title='" . htmlspecialchars($solicitud->motivoSolicitudAcreditado) . "'>";
                                    echo strlen($solicitud->motivoSolicitudAcreditado) > 50 ? substr($solicitud->motivoSolicitudAcreditado, 0, 50) . '...' : $solicitud->motivoSolicitudAcreditado;
                                    echo "</div>";
                                    echo "</td>";
                                    echo "<td>" . $solicitud->modalidadSolicitudAcreditado . "</td>";
                                    echo "<td>" . $solicitud->nombre . "</td>";
                                    echo "<td><i class='mdi mdi-calendar-check mr-1'></i>" . $solicitud->fechaFinalizado . "</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-primary btn-sm ver_estado_org' data-organizacion='" . $solicitud->id_organizacion . "' data-solicitud='" . $solicitud->idSolicitud . "'>";
                                    echo "<i class='mdi mdi-eye mr-1'></i>Ver estado";
                                    echo "</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ver estado de la solicitud -->
        <div class="row" id="v_estado_org" style="display: none;">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white">
                            <i class="mdi mdi-file-document-outline mr-2"></i>
                            Estado de la solicitud
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-1">Nombre de la Organización</h6>
                                <h5 class="font-weight-bold" id="resolucion_nombre_org"></h5>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">NIT</h6>
                                <h5 class="font-weight-bold" id="nit_organizacion"></h5>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">ID Solicitud</h6>
                                <h5 class="font-weight-bold"><span class="badge badge-primary" id="id_solicitud"></span></h5>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">Estado Actual</h6>
                                <h5 class="font-weight-bold" id="estado_actual_org"></h5>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">Modalidad</h6>
                                <h5 class="font-weight-bold" id="modalidad_solicitud"></h5>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">Motivo</h6>
                                <h5 class="font-weight-bold" id="motivo_solicitud"></h5>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1">Fecha de Finalización</h6>
                                <h5 class="font-weight-bold" id="fecha_finalización"></h5>
                            </div>
                        </div>

                        <hr/>
                        <!-- Nivel y estados exentos disponibles para JS -->
                        <script>
                            window.__nivelUsuario = '<?= isset($nivel) ? $nivel : "" ?>';
                            window.__estadosSinJustificacionNivel0 = ['Inscrito','En Proceso','Finalizado','En Observaciones','En Renovación'];
                        </script>
                        <!-- Select cambiar estado organización -->
                        <div class="form-group">
                            <label for="estadoSolicitud" class="font-weight-medium">Seleccionar nuevo estado</label>
                            <select class="form-control" name="estadoSolicitud" id="estadoSolicitud">
                                <option value="" selected disabled>Seleccione un estado...</option>
                                <option value="Acreditado">Acreditado</option>
                                <option value="Archivada">Archivada</option>
                                <!-- <option value="Negada">Negada</option>
                                <option value="Revocada">Revocada</option> -->
								<?php if($nivel == "0"): ?>
                                	<option value="Inscrito">Inscrito</option>
                                	<option value="En Proceso">En Proceso</option>
                                	<option value="Finalizado">Finalizado</option>
                                	<option value="En Observaciones">En Observaciones</option>
                                	<option value="En Renovación">En Renovación</option>
								<?php endif; ?>
                            </select>
                        </div>

                        <!-- Justificación (visible solo si el estado requiere justificación) -->
                        <div class="form-group mt-2" id="justificacion_wrapper" style="display: none;">
                            <label for="justificacionCambioEstado" class="font-weight-medium">Justificación del cambio</label>
                            <textarea class="form-control" id="justificacionCambioEstado" rows="3" placeholder="Explique por qué se cambia el estado de la solicitud"></textarea>
                            <small class="text-muted">Obligatoria cuando el nuevo estado lo requiere.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-outline-secondary" id="volverEst_org">
                                <i class="mdi mdi-arrow-left mr-1"></i> Regresar
                            </button>
                            <button class="btn btn-primary" id="actualizarEstadoOrganizacion" disabled>
                                <i class="mdi mdi-check mr-1"></i> Actualizar estado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
