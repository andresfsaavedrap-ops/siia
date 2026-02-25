<?php
// Parcial: Información + Archivos de un docente
// Función para verificar permisos (igual que en _admin.php)
function canAccess($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}

$CI =& get_instance();
$CI->load->model('AdministradoresModel');
?>
<div id="informacion_docentes">
    <?php
        $aprobado = (string)$docente->valido === '1';
        $fotoPerfil = isset($docente->fotoPerfil) && $docente->fotoPerfil
            ? base_url('uploads/docentes/fotos/' . $docente->fotoPerfil)
            : base_url('assets/img/default.png');
        // Verificar si el usuario tiene permisos para aprobar/desaprobar (solo niveles 0, 1, 6)
        $puedeAprobar = isset($nivel) ? canAccess([0, 1, 6], $nivel) : false;
    ?>
    <div id="panel_detalle_docente" class="card shadow-sm border-0 mb-3" style="background:#f7f9fc;">
        <div id="fila_informacion_docente" class="d-flex align-items-center px-3 py-3 border-bottom">
            <img src="<?= $fotoPerfil ?>" alt="Foto del docente" class="mr-3 rounded-circle border" style="width:72px;height:72px;object-fit:cover;">
            <div class="flex-grow-1">
                <h5 class="mb-1 d-flex align-items-center">
                    <i class="mdi mdi-account-badge mr-2 text-primary"></i>
                    Docente #<label id="id_docente" class="mb-0 ml-1"><?= htmlspecialchars($docente->id_docente) ?></label>
                    <span class="ml-2 badge <?= $aprobado ? 'badge-success' : 'badge-warning' ?>">
                        <i class="mdi <?= $aprobado ? 'mdi-check-circle' : 'mdi-alert-circle' ?> mr-1"></i>
                        <?= $aprobado ? 'Aprobado' : 'Pendiente por requisitos' ?>
                    </span>
                </h5>
                <div class="small text-muted">
                    <span class="mr-3"><strong>Cédula:</strong> <?= htmlspecialchars($docente->numCedulaCiudadaniaDocente) ?></span>
                    <span class="mr-3"><strong>Profesión:</strong> <?= htmlspecialchars($docente->profesion) ?></span>
                    <span><strong>Horas:</strong> <?= htmlspecialchars($docente->horaCapacitacion) ?></span>
                </div>
            </div>
        </div>
        <div class="row no-gutters px-3 py-3 m-3">
            <div class="col-md-6 pr-md-3">
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Primer Nombre</label>
                    <p id="primer_nombre_docente" class="h6 mb-0"><?= htmlspecialchars($docente->primerNombreDocente) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Segundo Nombre</label>
                    <p id="segundo_nombre_docente" class="h6 mb-0"><?= htmlspecialchars($docente->segundoNombreDocente) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Primer Apellido</label>
                    <p id="primer_apellido_docente" class="h6 mb-0"><?= htmlspecialchars($docente->primerApellidoDocente) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Segundo Apellido</label>
                    <p id="segundo_apellido_docente" class="h6 mb-0"><?= htmlspecialchars($docente->segundoApellidoDocente) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Número de Cédula</label>
                    <p id="numero_cedula_docente" class="h6 mb-0"><?= htmlspecialchars($docente->numCedulaCiudadaniaDocente) ?></p>
                </div>
            </div>
            <div class="col-md-6 pl-md-3">
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Profesión</label>
                    <p id="profesion_docente" class="h6 mb-0"><?= htmlspecialchars($docente->profesion) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Horas de Capacitación</label>
                    <p id="horas_cap_docente" class="h6 mb-0"><?= htmlspecialchars($docente->horaCapacitacion) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">¿Aprobado?</label>
                    <p class="mb-0" id="valido_docente">
                        <span class="badge <?= $aprobado ? 'badge-success' : 'badge-warning' ?>">
                            <i class="mdi <?= $aprobado ? 'mdi-check-circle' : 'mdi-alert-circle' ?> mr-1"></i>
                            <?= $aprobado ? 'Aprobado' : 'Pendiente por requisitos' ?>
                        </span>
                    </p>
                </div>
                <?php
                    $obsActual = !empty($observaciones) ? $observaciones[0] : null;
                    $obsAnterior = (isset($observaciones[1])) ? $observaciones[1] : null;
                    $autorActual = '';
                    if ($obsActual && isset($obsActual->administradores_id_administrador)) {
                        $adminA = $CI->AdministradoresModel->getAdministradores((int)$obsActual->administradores_id_administrador);
                        $autorActual = $adminA ? ($adminA->primerNombreAdministrador . ' ' . $adminA->primerApellidoAdministrador) : '';
                    }
                    $fechaActual = $obsActual && (isset($obsActual->created_at) || isset($obsActual->fechaObservacion))
                        ? htmlspecialchars(isset($obsActual->created_at) ? $obsActual->created_at : $obsActual->fechaObservacion)
                        : '';
                    $autorAnterior = '';
                    if ($obsAnterior && isset($obsAnterior->administradores_id_administrador)) {
                        $adminB = $CI->AdministradoresModel->getAdministradores((int)$obsAnterior->administradores_id_administrador);
                        $autorAnterior = $adminB ? ($adminB->primerNombreAdministrador . ' ' . $adminB->primerApellidoAdministrador) : '';
                    }
                    $fechaAnterior = $obsAnterior && (isset($obsAnterior->created_at) || isset($obsAnterior->fechaObservacion))
                        ? htmlspecialchars(isset($obsAnterior->created_at) ? $obsAnterior->created_at : $obsAnterior->fechaObservacion)
                        : '';
                ?>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Observación actual</label>
                    <?php if ($obsActual): ?>
                        <div id="obs_val_docente" class="h6 mb-1"><?= htmlspecialchars((string)$obsActual->observacion) ?></div>
                        <div class="text-muted small">
                            <?= $autorActual ? htmlspecialchars($autorActual) : '—' ?>
                            <?= $fechaActual ? ' | ' . $fechaActual : '' ?>
                        </div>
                    <?php else: ?>
                        <p id="obs_val_docente" class="h6 mb-0"><?= htmlspecialchars($docente->observacion ?? '') ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="text-uppercase text-muted small font-weight-bold d-block mb-1">Observación anterior</label>
                    <?php if ($obsAnterior): ?>
                        <div id="obs_valAnt_docente" class="h6 mb-1"><?= htmlspecialchars((string)$obsAnterior->observacion) ?></div>
                        <div class="text-muted small">
                            <?= $autorAnterior ? htmlspecialchars($autorAnterior) : '—' ?>
                            <?= $fechaAnterior ? ' | ' . $fechaAnterior : '' ?>
                        </div>
                    <?php else: ?>
                        <p id="obs_valAnt_docente" class="h6 mb-0"><?= htmlspecialchars($docente->observacionAnterior ?? '') ?></p>
                    <?php endif; ?>
                </div>
				<!-- Observaciones históricas -->
				<div class="mb-3">
					<label class="text-uppercase text-muted small font-weight-bold d-block mb-2">Observaciones realizadas</label>
					<?php if (!empty($observaciones)): ?>
						<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalObservacionesDocente<?= $docente->id_docente ?>">
							<i class="mdi mdi-eye"></i> Ver observaciones (<?= count($observaciones) ?>)
						</button>
					<?php else: ?>
						<p class="text-muted mb-0">Sin observaciones registradas para este docente.</p>
					<?php endif; ?>
				</div>
				<!-- Modal de Observaciones del Docente -->
				<div class="modal fade" id="modalObservacionesDocente<?= $docente->id_docente ?>" tabindex="-1" role="dialog" aria-labelledby="modalObservacionesDocenteLabel<?= $docente->id_docente ?>" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
					<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h5 class="modal-title text-white" id="modalObservacionesDocenteLabel<?= $docente->id_docente ?>">
							<i class="mdi mdi-comment-text-outline mr-2"></i>
							Observaciones del docente #<?= htmlspecialchars($docente->id_docente) ?>
						</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
						<?php
							// Detectar columnas opcionales si existen en los registros
							$hasAutor            = false;
							$hasSeveridad        = false;
							$hasVisible          = false;
							$hasResuelto         = false;
							$hasFechaResolucion  = false;
							$hasComentarioCierre = false;
							foreach ($observaciones as $o) {
								$hasAutor            = $hasAutor            || isset($o->administradores_id_administrador) || isset($o->autor);
								$hasSeveridad        = $hasSeveridad        || isset($o->severidad);
								$hasVisible          = $hasVisible          || isset($o->visibleParaOrganizacion);
								$hasResuelto         = $hasResuelto         || isset($o->resuelto);
								$hasFechaResolucion  = $hasFechaResolucion  || isset($o->fechaResolucion);
								$hasComentarioCierre = $hasComentarioCierre || isset($o->comentarioCierre);
							}
						?>
						<table id="tablaObservacionesDocente<?= $docente->id_docente ?>" class="table table-sm table-striped" width="100%">
							<thead class="thead-light">
							<tr>
								<th>Fecha</th>
								<?php if ($hasAutor): ?>
									<th>Autor</th>
								<?php endif; ?>
								<?php if ($hasSeveridad): ?>
									<th>Severidad</th>
								<?php endif; ?>
								<?php if ($hasVisible): ?>
									<th>Visible a organización</th>
								<?php endif; ?>
								<?php if ($hasResuelto): ?>
									<th>Resuelto</th>
								<?php endif; ?>
								<?php if ($hasFechaResolucion): ?>
									<th>Fecha resolución</th>
								<?php endif; ?>
								<th>Observación</th>
								<?php if ($hasComentarioCierre): ?>
									<th>Comentario cierre</th>
								<?php endif; ?>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($observaciones as $obs): ?>
								<tr>
								<td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($obs->fechaObservacion ?? 'now'))) ?></td>
                                <?php if ($hasAutor): ?>
                                    <?php
                                        $autorNombre = '-';
                                        if (isset($obs->administradores_id_administrador)) {
                                            $CI2 =& get_instance();
                                            $CI2->load->model('AdministradoresModel');
                                            $adminRow = $CI2->AdministradoresModel->getAdministradores((int)$obs->administradores_id_administrador);
                                            if ($adminRow) {
                                                $autorNombre = $adminRow->primerNombreAdministrador . ' ' . $adminRow->primerApellidoAdministrador;
                                            } else {
                                                $autorNombre = (string)$obs->administradores_id_administrador;
                                            }
                                        } elseif (isset($obs->autor)) {
                                            $autorNombre = (string)$obs->autor;
                                        }
                                    ?>
                                    <td><?= htmlspecialchars($autorNombre) ?></td>
                                <?php endif; ?>
								<?php if ($hasSeveridad): ?>
									<td><?= htmlspecialchars($obs->severidad ?? '-') ?></td>
								<?php endif; ?>
								<?php if ($hasVisible): ?>
									<td><?= isset($obs->visibleParaOrganizacion) ? ((int)$obs->visibleParaOrganizacion === 1 ? 'Sí' : 'No') : '-' ?></td>
								<?php endif; ?>
								<?php if ($hasResuelto): ?>
									<td><?= isset($obs->resuelto) ? ((int)$obs->resuelto === 1 ? 'Sí' : 'No') : '-' ?></td>
								<?php endif; ?>
								<?php if ($hasFechaResolucion): ?>
									<td><?= !empty($obs->fechaResolucion) ? htmlspecialchars(date('Y-m-d H:i', strtotime($obs->fechaResolucion))) : '-' ?></td>
								<?php endif; ?>
								<td><?= nl2br(htmlspecialchars($obs->observacionesDocente ?? $obs->observacion ?? '')) ?></td>
								<?php if ($hasComentarioCierre): ?>
									<td><?= nl2br(htmlspecialchars($obs->comentarioCierre ?? '')) ?></td>
								<?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
					</div>
				</div>
				</div>
				<script>
				$(function(){
					var tableId = '#tablaObservacionesDocente<?= $docente->id_docente ?>';
					if (window.DataTableConfig && $(tableId).length) {
					DataTableConfig.initSimpleTable(
						tableId,
						'Observaciones del docente',
						'observaciones_docente_<?= $docente->id_docente ?>'
					);
					}
				});
				</script>
        	</div>
        </div>
    </div>
    <hr />
    <div class="col-md-12">
        <label class="d-flex align-items-center">
            <i class="mdi mdi-file-document-outline mr-2 text-secondary"></i>
            Documentos:
        </label>
        <div class="table-responsive">
            <table id="tabla_archivos_formulario" width="100%" class="table table-hover table-striped table-md" style="table-layout:fixed;">
                <colgroup>
                    <col style="width:20%">
                    <col style="width:15%">
                    <col style="width:45%">
                    <col style="width:20%">
                </colgroup>
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Observación archivo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tbodyArchivosDocen">
                <?php foreach ($archivos as $archivo): 
                    $tipoLabel = 'Archivo'; $carpeta = '';
                    switch ($archivo->tipo) {
                        case 'docenteHojaVida': $tipoLabel = 'Hoja de vida'; $carpeta = base_url('uploads/docentes/hojasVida/'); break;
                        case 'docenteTitulo': $tipoLabel = 'Titulo profesional'; $carpeta = base_url('uploads/docentes/titulos/'); break;
                        case 'docenteCertificadosEconomia': $tipoLabel = 'Certificado de economía solidaria'; $carpeta = base_url('uploads/docentes/certificadosEconomia/'); break;
                        case 'docenteCertificados': $tipoLabel = 'Certificado de experiencia'; $carpeta = base_url('uploads/docentes/certificados/'); break;
                    }
                ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-file-document-outline text-secondary mr-2"></i>
                                <a class="docVistoArch btn btn-outline-primary btn-sm"
                                   href="<?= $carpeta . $archivo->nombre ?>"
                                   target="_blank"
                                   title="Ver: <?= htmlspecialchars($archivo->nombre) ?>">
                                    <i class="mdi mdi-eye mr-1"></i>
                                    Ver documento
                                </a>
                                <span class="archivo-nombre text-muted small ml-2 text-truncate d-inline-block"
                                      style="max-width: 160px;"
                                      title="<?= htmlspecialchars($archivo->nombre) ?>">
                                    <?= strlen($archivo->nombre) > 50 ? substr($archivo->nombre, 0, 50) . '…' : $archivo->nombre ?>
                                </span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($tipoLabel) ?></td>
                        <td>
                            <textarea id="archivoDoc<?= $archivo->id_archivosDocente ?>" class="form-control" rows="3" style="width:100%;"><?= htmlspecialchars($archivo->observacionArchivo ?? '') ?></textarea>
                        </td>
                        <td>
                            <button data-id="<?= $archivo->id_archivosDocente ?>" class="btn btn-success btn-sm guardarObsArchivoDoc">
                                Guardar <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr />
    <div class="row justify-content-center">
        <div class="col-12 text-center" id="divValidoDocente">
            <label class="text-uppercase text-muted small font-weight-bold d-block mb-2">Aprobación del docente</label>

            <?php if ($puedeAprobar): ?>
                <!-- Switch interactivo para usuarios con permisos -->
                <div class="custom-control custom-switch d-inline-block mb-4"
                     style="transform: scale(1.35); transform-origin: center;">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="switchValidoDocente"
                           <?= (string)$docente->valido === '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="switchValidoDocente">
                        <span class="badge <?= (string)$docente->valido === '1' ? 'badge-success' : 'badge-warning' ?>">
                            <?= (string)$docente->valido === '1' ? 'Aprobado' : 'Pendiente por requisitos' ?>
                        </span>
                    </label>
                </div>

                <!-- Radios ocultos para mantener compatibilidad con JS existente (.validoDocente) -->
                <div class="d-none">
                    <input type="radio" name="validoDocente" class="validoDocente" id="radioValidoSi" value="1" <?= (string)$docente->valido === '1' ? 'checked' : '' ?>>
                    <input type="radio" name="validoDocente" class="validoDocente" id="radioValidoNo" value="0" <?= (string)$docente->valido !== '1' ? 'checked' : '' ?>>
                </div>
            <?php else: ?>
                <!-- Vista de solo lectura para usuarios sin permisos -->
                <div class="mb-4">
                    <span class="badge <?= (string)$docente->valido === '1' ? 'badge-success' : 'badge-warning' ?>" style="font-size: 1.1em; padding: 8px 16px;">
                        <i class="mdi <?= (string)$docente->valido === '1' ? 'mdi-check-circle' : 'mdi-alert-circle' ?> mr-1"></i>
                        <?= (string)$docente->valido === '1' ? 'Aprobado' : 'Pendiente por requisitos' ?>
                    </span>
                </div>
                <div class="alert alert-info small">
                    <i class="mdi mdi-information mr-1"></i>
                    No tienes permisos para modificar el estado de aprobación de este docente.
                </div>
            <?php endif; ?>

            <div class="col-12 mt-3 mb-4" id="observacionDocente" style="<?= (string)$docente->valido === '1' ? 'display:none' : '' ?>">
                <label class="text-uppercase text-muted small font-weight-bold d-block text-center mb-2">
                    Observaciones si el docente no es aprobado
                </label>
                <textarea id="docente_val_obs" class="form-control w-75 mx-auto" rows="3"><?= htmlspecialchars($docente->observacion ?? '') ?></textarea>
            </div>
            <!-- Acceso rápido al historial completo de observaciones -->
            <div class="col-12 mt-3 mb-4">
                <div class="text-center">
                    <?php if (!empty($observaciones)): ?>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalObservacionesDocente<?= $docente->id_docente ?>">
                            <i class="mdi mdi-eye"></i> Ver historial de observaciones (<?= count($observaciones) ?>)
                        </button>
                    <?php else: ?>
                        <span class="text-muted small">Sin historial de observaciones registradas para este docente.</span>
                    <?php endif; ?>
                </div>
            </div>
    </div>

    <?php if ($puedeAprobar): ?>
        <script>
            (function() {
                var $switch = $('#switchValidoDocente');
                var $obs = $('#observacionDocente');

                function syncState() {
                    var isChecked = $switch.is(':checked');
                    $('#radioValidoSi').prop('checked', isChecked);
                    $('#radioValidoNo').prop('checked', !isChecked);

                    // Dispara el change en el radio seleccionado para que cualquier JS existente reaccione
                    $('.validoDocente:checked').trigger('change');

                    // Muestra/oculta observaciones con animación
                    if (isChecked) {
                        $obs.slideUp(150);
                    } else {
                        $obs.slideDown(150);
                    }

                    // Actualiza la badge del switch (Aprobado/Pendiente)
                    var $badge = $('label[for="switchValidoDocente"] .badge');
                    if ($badge.length) {
                        if (isChecked) {
                            $badge.removeClass('badge-warning').addClass('badge-success').text('Aprobado');
                        } else {
                            $badge.removeClass('badge-success').addClass('badge-warning').text('Pendiente por requisitos');
                        }
                    }
                }

                $switch.on('change', syncState);
            })();
        </script>
        <button class="docente_ btn btn-success btn-md guardarValidoDocente" style="width: 100%" data-id="<?= $docente->id_docente ?>">
            Guardar y enviar notificación <i class="fa fa-check" aria-hidden="true"></i>
        </button>
    <?php else: ?>
        <div class="alert alert-secondary text-center">
            <i class="mdi mdi-lock mr-2"></i>
            Solo los usuarios con permisos administrativos pueden aprobar o desaprobar docentes.
        </div>
    <?php endif; ?>
</div>
