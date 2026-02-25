<?php
/***
 * @var $solicitudesEnProceso
 * @var Solicitudes $this
 *
 */
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/admin/modules/solicitudes/finalizadas.css'); ?>" type="text/css" />
<!-- Estilos específicos para componentes parciales -->
<link rel="stylesheet" href="<?= base_url('assets/css/admin/modules/solicitudes/partials.css?v=1.0') ?>" type="text/css" />
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-3" id="admin_proceso_header">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-progress-clock text-primary mr-2"></i>
                            Solicitudes en proceso
                        </h4>
                        <p class="text-muted mb-0 small">Gestiona y revisa las solicitudes que están actualmente en trámite</p>
                    </div>
					<?php $this->load->view('admin/solicitudes/partials/_btn_volver'); ?>
                </div>
            </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4" id="admin_proceso_stats">
            <div class="col-md-6">
                <div class="card border-left-info shadow-sm" style="border-left-width: 4px;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-light mr-3">
                                <i class="mdi mdi-progress-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-medium text-muted mb-0 small">Total en proceso</h6>
                                <h4 class="font-weight-bold mb-0">
                                    <?php
                                    $totalProceso = 0;
                                    if (is_array($solicitudesEnProceso)) {
                                        $totalProceso = count($solicitudesEnProceso);
                                    } elseif (is_object($solicitudesEnProceso)) {
                                        $totalProceso = 1;
                                    }
                                    echo $totalProceso;
                                    ?>
                                </h4>
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
                                <h6 class="font-weight-medium text-muted mb-0 small">Este Mes</h6>
                                <h4 class="font-weight-bold mb-0">
                                    <?php
                                    $esteMes = 0;
                                    $mesActual = date('Y-m');
                                    if (is_array($solicitudesEnProceso)) {
                                        $esteMes = count(array_filter($solicitudesEnProceso, function($s) use ($mesActual) {
                                            return isset($s->fecha) && date('Y-m', strtotime($s->fecha)) == $mesActual;
                                        }));
                                    } elseif (is_object($solicitudesEnProceso) && isset($solicitudesEnProceso->fecha)) {
                                        $esteMes = (date('Y-m', strtotime($solicitudesEnProceso->fecha)) == $mesActual) ? 1 : 0;
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

        <!-- Tabla principal -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm" id="admin_proceso_lista">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-medium mb-0">
                                <i class="mdi mdi-table mr-2 text-primary"></i>
                                Solicitudes en proceso
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabla_enProceso_organizacion" class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Organización</th>
                                        <th class="border-0">ID Solicitud</th>
                                        <th class="border-0">Fecha de creación</th>
                                        <th class="border-0">Tipo Solicitud</th>
                                        <th class="border-0">Motivo Solicitud</th>
                                        <th class="border-0">Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                <?php
                                    if (is_array($solicitudesEnProceso)) {
                                        foreach ($solicitudesEnProceso as $solicitud):
                                            echo "<tr>";
                                            echo "<td><div class='motivo-cell' title='" . htmlspecialchars($solicitud->nombreOrganizacion) . "'>";
                                            echo strlen($solicitud->nombreOrganizacion) > 100 ? substr($solicitud->nombreOrganizacion, 0, 100) . '...' : $solicitud->nombreOrganizacion;
                                            echo "</div></td>";
                                            echo "<td><span class='badge badge-primary'>" . $solicitud->idSolicitud . "</span></td>";
                                            echo "<td><i class='mdi mdi-calendar mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaCreacion)) . "</td>";
                                            echo "<td>" . $solicitud->tipoSolicitud . "</td>";
                                            echo "<td>";
                                            echo "<div class='motivo-cell' title='" . htmlspecialchars($solicitud->motivoSolicitud) . "'>";
                                            echo strlen($solicitud->motivoSolicitud) > 50 ? substr($solicitud->motivoSolicitud, 0, 50) . '...' : $solicitud->motivoSolicitud;
                                            echo "</div>";
                                            echo "</td>";
                                            echo "<td>" . $solicitud->nombre . "</td>";
                                            echo "</tr>";
                                        endforeach;
                                    } elseif (is_object($solicitudesEnProceso)) {
                                        $solicitud = $solicitudesEnProceso;
                                        echo "<tr>";
                                        echo "<td><div class='motivo-cell' title='" . htmlspecialchars($solicitud->nombreOrganizacion) . "'>";
                                        echo strlen($solicitud->nombreOrganizacion) > 100 ? substr($solicitud->nombreOrganizacion, 0, 100) . '...' : $solicitud->nombreOrganizacion;
                                        echo "</div></td>";
                                        echo "<td><span class='badge badge-primary'>" . $solicitud->idSolicitud . "</span></td>";
                                        echo "<td><i class='mdi mdi-calendar mr-1'></i>" . date('d/m/Y', strtotime($solicitud->fechaCreacion)) . "</td>";
                                        echo "<td>" . $solicitud->tipoSolicitud . "</td>";
                                        echo "<td>";
                                        echo "<div class='motivo-cell' title='" . htmlspecialchars($solicitud->motivoSolicitud) . "'>";
                                        echo strlen($solicitud->motivoSolicitud) > 50 ? substr($solicitud->motivoSolicitud, 0, 50) . '...' : $solicitud->motivoSolicitud;
                                        echo "</div>";
                                        echo "</td>";
                                        echo "<td>" . $solicitud->nombre . "</td>";
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
    </div>
</div>
</div>
