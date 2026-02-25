<?php
/**
 * Componente reutilizable: evaluación de docentes por organización
 * - $organizacion (row)
 * - $docentes (array)
 * - $docenteInicial (row|null)
 * - $archivosInicial (array)
 */
?>
<div class="card shadow-sm" data-nit="<?= htmlspecialchars($organizacion->numNIT ?? '') ?>" data-org-id="<?= htmlspecialchars($organizacion->id_organizacion ?? '') ?>">
    <div class="card-header bg-white border-0" style="background: none !important;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold text-primary mb-0">
                <i class="mdi mdi-office mr-2"></i>
                <?= htmlspecialchars($organizacion->nombreOrganizacion ?? 'Organización') ?>
            </h5>
            <div class="text-muted small d-flex align-items-center">
                <span class="mr-3"><strong>NIT:</strong> <?= htmlspecialchars($organizacion->numNIT ?? '-') ?></span>
                <span class="mr-3"><strong>Sigla:</strong> <?= htmlspecialchars($organizacion->sigla ?? '-') ?></span>
                <span class="mr-3"><strong>Docentes:</strong> <?= is_array($docentes) ? count($docentes) : 0 ?></span>
                <?php if (!empty($is_embed)): ?>
                    <button class="btn btn-outline-primary btn-sm btnRecargarEmbed ml-3" data-nit="<?= htmlspecialchars($organizacion->numNIT ?? '') ?>">
                        <i class="mdi mdi-refresh mr-1"></i> Recargar
                    </button>
                <?php else: ?>
                    <button class="btn btn-outline-secondary btn-sm volver_lista_docentes ml-3">
                        <i class="mdi mdi-arrow-left mr-1"></i> Volver a la lista
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($is_embed) && !empty($organizacion->direccionCorreoElectronicoOrganizacion)): ?>
            <div class="mt-2" style="background:#e9f7fd;border:1px solid #b8e7f2;color:#0c5460;font-size:12px;padding:6px 8px;border-radius:4px;">
                Correo de notificaciones: <?= htmlspecialchars($organizacion->direccionCorreoElectronicoOrganizacion) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive mb-4">
            <table id="tabla_docentes_evaluar" width="100%" class="table table-hover table-striped table-md">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Profesión</th>
                        <th>Horas</th>
                        <th>Aprobado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tbody_orgDocentes">
                    <?php if (!empty($docentes)): ?>
                        <?php foreach ($docentes as $docente): ?>
                            <tr>
                                <td><?= htmlspecialchars(trim(($docente->primerNombreDocente ?? '') . ' ' . ($docente->primerApellidoDocente ?? ''))) ?></td>
                                <td><?= htmlspecialchars($docente->numCedulaCiudadaniaDocente ?? '-') ?></td>
                                <td><?= htmlspecialchars($docente->profesion ?? '-') ?></td>
                                <td><?= htmlspecialchars($docente->horaCapacitacion ?? '0') ?></td>
                                <td>
                                    <span class="badge <?= (string)($docente->valido ?? '0') === '1' ? 'badge-success' : 'badge-warning' ?>">
                                        <?= (string)($docente->valido ?? '0') === '1' ? 'Sí' : 'Pendiente' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm verEsteDocente" data-id="<?= $docente->id_docente ?>" data-org="<?= $organizacion->id_organizacion ?? '' ?>">
                                        <i class="mdi mdi-eye mr-1"></i> Ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay docentes registrados para esta organización.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($docenteInicial): ?>
            <?php
                // Reutilizar el componente de docente para el inicial
                $CI =& get_instance();
                $observacionesInicial = $CI->db->select('*')
                    ->from('observacionesDocente')
                    ->where('docentes_id_docente', $docenteInicial->id_docente)
                    ->order_by('created_at', 'DESC')
                    ->get()->result();
                echo $CI->load->view(
                    'admin/organizaciones/docentes/componente_docente',
                    [
                        'docente' => $docenteInicial,
                        'archivos' => $archivosInicial,
                        'observaciones' => $observacionesInicial,
                        'nivel' => isset($nivel) ? $nivel : null
                    ],
                    TRUE
                );
            ?>
        <?php else: ?>
            <div id="informacion_docentes" class="text-center text-muted py-4">
                Selecciona un docente de la tabla para ver su información.
            </div>
        <?php endif; ?>
    </div>
</div>
