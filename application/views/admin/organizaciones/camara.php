<?php
/***
 * @var $organizaciones
 */
?>
<!-- Script específico de Cámara de Comercio -->
<script src="<?= base_url('assets/js/functions/camara-comercio.js') ?>" type="module"></script>
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-file-document-outline text-primary mr-2"></i>
                            Gestión de Cámaras de Comercio
                        </h3>
                        <p class="text-muted mb-0">Administra y actualiza las cámaras de comercio de las organizaciones</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php $this->load->view('admin/solicitudes/partials/_btn_volver'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Organizaciones</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($organizaciones) ?></div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-primary-light rounded-circle">
                                    <i class="mdi mdi-domain text-primary"></i>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Con Usuario Activo</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php 
                                        $activas = 0;
                                        foreach($organizaciones as $org) {
                                            if(!empty($org->usuarios_id_usuario)) $activas++;
                                        }
                                        echo $activas;
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-success-light rounded-circle">
                                    <i class="mdi mdi-account-check text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sin Usuario</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($organizaciones) - $activas ?></div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-warning-light rounded-circle">
                                    <i class="mdi mdi-account-off text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tipos de NIT</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php 
                                        $nits = array();
                                        foreach($organizaciones as $org) {
                                            $prefijo = substr($org->numNIT, 0, 3);
                                            $nits[$prefijo] = true;
                                        }
                                        echo count($nits);
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-info-light rounded-circle">
                                    <i class="mdi mdi-numeric text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de organizaciones -->
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card" id="admin_ver_finalizadas">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-table-large text-primary mr-2"></i>
                            Listado de Organizaciones
                        </h4>
                        <div class="d-flex align-items-center">
                            <div class="badge badge-primary badge-pill">
                                <?= count($organizaciones) ?> registros
                            </div>
                            <!-- Botón para ver prioritarias en modal -->
                            <button id="btnPrioritarias" class="btn btn-outline-warning btn-sm ml-2" data-toggle="modal" data-target="#modalPrioritarias">
                                <i class="mdi mdi-alert mr-1"></i> Prioritarias
                            </button>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Busca por el número del NIT para facilidad.</p>
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table id="tabla_camaras_comercio" class="table table-hover table-striped" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>NIT</th>
                                        <th>Representante Legal</th>
                                        <th>Correo Organización</th>
                                        <th>Correo Representante</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php foreach ($organizaciones as $organizacion): ?>
                                        <tr class="align-middle">
                                            <?php
                                    $nombre = $organizacion->nombreOrganizacion;
                                    $nombreCorto = strlen($nombre) > 30 ? substr($nombre, 0, 30) . '...' : $nombre;
                                ?>
                                <td class="font-weight-medium" title="<?= htmlspecialchars($nombre) ?>"><?= htmlspecialchars($nombreCorto) ?></td>
                                            <td><?= $organizacion->numNIT ?></td>
                                            <td><?= $organizacion->primerNombreRepLegal . " " . $organizacion->segundoNombreRepLegal . " " . $organizacion->primerApellidoRepLegal . " " . $organizacion->segundoApellidoRepLegal ?></td>
                                            <td><?= $organizacion->direccionCorreoElectronicoOrganizacion ?></td>
                                            <td><?= $organizacion->direccionCorreoElectronicoRepLegal ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary btn-sm ver_adjuntar_camara" data-organizacion="<?= $organizacion->id_organizacion ?>">
                                                    <i class="mdi mdi-eye mr-1"></i> Ver organización
                                                </button>
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

<!-- Modal: Cámara de Comercio -->
<div class="modal fade" id="modalCamaraComercio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title text-white">
          <i class="mdi mdi-file-document-outline mr-2"></i>
          Cámara de Comercio
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="container-fluid">
          <!-- Información básica organización -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light border-0">
              <h6 class="mb-0 text-primary">
                <i class="mdi mdi-information mr-2"></i>Información de la Organización
              </h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">Organización:</label>
                    <div id="modal_camara_nombre" class="form-control-plaintext"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">NIT:</label>
                    <div id="modal_camara_nit" class="form-control-plaintext"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">Estado:</label><br>
                    <span id="modal_camara_estado" class="badge badge-secondary">No disponible</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Contenido principal: Vista previa y acciones -->
          <div class="row">
            <div class="col-md-8">
              <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                  <h6 class="mb-0 text-primary">
                    <i class="mdi mdi-file-pdf-box mr-2"></i>Vista previa (PDF)
                  </h6>
                  <a id="modal_camara_view_link" href="#" target="_blank" class="btn btn-sm btn-primary disabled" title="Abrir PDF">
                    <i class="mdi mdi-open-in-new mr-1"></i> Ver en nueva pestaña
                  </a>
                </div>
                <div class="card-body">
                  <div id="modal_camara_viewer_container" class="border rounded" style="height:480px;">
                    <object id="modal_camara_viewer" type="application/pdf" data="" width="100%" height="100%">
                      <p class="text-muted mb-0">No hay vista previa disponible.</p>
                    </object>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light border-0">
                  <h6 class="mb-0 text-success">
                    <i class="mdi mdi-upload mr-2"></i>Acciones
                  </h6>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="font-weight-bold">Cargar/Actualizar PDF</label>
                    <input type="file" accept="application/pdf" id="modal_camara_file" class="form-control-file mb-2">
                  </div>
                  <button id="modal_camara_upload_btn" type="button" class="btn btn-success btn-block" disabled>
                    <i class="mdi mdi-content-save mr-1"></i> Subir / Actualizar
                  </button>
                  <hr>
                  <button id="modal_camara_delete_btn" type="button" class="btn btn-danger btn-block">
                    <i class="mdi mdi-trash-can-outline mr-1"></i> Eliminar (volver a default)
                  </button>
                  <small class="text-muted d-block mt-2">Tamaño máximo 10 MB. Solo PDF.</small>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- /container-fluid -->
      </div>
      <div class="modal-footer bg-light border-0">
        <div class="d-flex justify-content-end w-100">
          <button class="btn btn-secondary" data-dismiss="modal">
            <i class="mdi mdi-close mr-1"></i> Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Modal: Cámara de Comercio -->

<!-- Modal: Organizaciones prioritarias (sin cámara) -->
<div class="modal fade" id="modalPrioritarias" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-warning text-dark border-0">
        <h5 class="modal-title">
          <i class="mdi mdi-alert mr-2"></i> Organizaciones prioritarias (sin cámara)
        </h5>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div id="prioritarias_loader" class="text-center my-4" style="display:none;">
          <div class="spinner-border text-warning" role="status">
            <span class="sr-only">Cargando...</span>
          </div>
          <div class="mt-2 text-muted">Cargando información...</div>
        </div>
        <div id="prioritarias_content">
          <!-- Aquí se inyecta el HTML que devuelve organizacionesSinCamaraDeComercio -->
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="mdi mdi-close mr-1"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /Modal: Organizaciones prioritarias -->

<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script>
$(document).ready(function() {
    // Inicializar tabla de organizaciones con configuración estándar
    DataTableConfig.initSimpleTable(
        '#tabla_camaras_comercio',
        'Cámaras de Comercio',
        'organizaciones_camara'
    );
});
</script>
