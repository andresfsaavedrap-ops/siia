<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-table text-primary mr-2"></i>
                            Relación de cambios
                        </h4>
                        <p class="text-muted mb-0 small">Listado de cambios registrados en la organización</p>
                    </div>
                    <a href="<?= site_url('admin/organizaciones'); ?>" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="mdi mdi-arrow-left mr-1"></i> Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="text-muted">Tabla de cambios</h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table id="tabla_enProceso_organizacion" class="table table-hover table-striped w-100 tabla_form" border="0" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Titulo</th>
                                        <th class="border-0 col-md-6">Descripcion</th>
                                        <th class="border-0">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                <?php 
                                    foreach ($notificaciones as $notificacion) {
                                        echo "<tr>";
                                        echo "<td class=\"font-weight-medium\">$notificacion->tituloNotificacion</td>";
                                        echo "<td>$notificacion->descripcionNotificacion</td>";
                                        echo "<td><span class=\"badge badge-light\">" . date('d/m/Y', strtotime($notificacion->fechaNotificacion)) . "</span></td>";
                                        echo "</tr>";
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">Puedes filtrar, buscar y exportar desde los botones de la tabla</small>
                        <a href="<?= site_url('admin/organizaciones'); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="mdi mdi-arrow-left mr-1"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
