<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $departamentos
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 * @var $documentacionLegal
 * @var $antecedentesAcademicos
 * @var $jornadasActualizacion
 * @var $archivoJornada
 * @var $aplicacion
 * @var $datosEnLinea
 * @var $datosProgramas
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<!-- Formulario de jornadas de actualización 3 -->
<div id="jornadas_de_actualizacion" data-form="3" class="formulario_panel">
	<h3 class="card-header mb-0 d-flex align-items-center">
		<i class="fas fa-handshake-alt mr-2"></i>
		3. Jornada de actualización pedagógica
	</h3>
	<div class="card-body">
		<?php if (empty($jornadasActualizacion)): ?>
			<div class="alert alert-info border-left border-info border-4">
				<div class="d-flex">
					<i class="fa fa-info-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registre los datos de la última jornada de actualización, organizada por Unidad Solidaria, a la que asistió. Si selecciona 'No', adjunte por favor una carta de compromiso y de clic en guardar.</p>
				</div>
			</div>
			<?php echo form_open_multipart('', array('id' => 'formulario_jornadas_actualizacion', 'class' => 'needs-validation', 'novalidate' => '')); ?>
			<!-- Participación en jornadas -->
			<div class="form-group row">
				<label class="col-md-12 font-weight-bold">
					<span class="badge badge-primary mr-2">3.1</span>
					¿Participó en la última jornada de actualización pedagógica, organizada por la Unidad Solidaria?
				</label>
				<div class="col-md-12 mt-3">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input jornaSelect" id="jornaSelectSi" name="jornaSelect" value="Si">
						<label class="custom-control-label" for="jornaSelectSi">Sí</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input jornaSelect" id="jornaSelectNo" name="jornaSelect" value="No" checked>
						<label class="custom-control-label" for="jornaSelectNo">No</label>
					</div>
				</div>
			</div>
			<!-- Archivo -->
			<div class="form-group mt-4 pb-2">
				<label class="font-weight-bold">Documento de la Jornada de Actualización o carta de compromiso</label>
				<div class="card border-info mb-4 shadow-sm">
					<div class="card-header bg-info text-white d-flex align-items-center">
						<i class="fa fa-info-circle mr-2"></i>
						<span class="font-weight-bold">Información importante</span>
					</div>
					<div class="card-body bg-light">
						<ul class="mb-0">
							<li class="mb-2">En caso de haber participado en la jornada de actualización adjúnte el certificado.</li>
							<li>En caso de no haber participado adjúnte una carta de compromiso de participación en la jornada de actualización pedagógica.</li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<label for="fileJornadas" class="font-weight-bold">
						Archivo (PDF):
						<span class="text-danger">*</span>
					</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" required accept="application/pdf" class="custom-file-input" id="fileJornadas" name="fileJornadas">
							<label class="custom-file-label" for="fileJornadas">Seleccionar archivo...</label>
						</div>
					</div>
					<small class="form-text text-muted mt-2">
						<i class="fa fa-exclamation-circle mr-1"></i>
						Solo se permiten archivos en formato PDF.
					</small>
				</div>
			</div>
			<div class="form-group mt-4">
				<button type="submit" class="btn btn-primary btn-md btn-block guardar_formulario_jornadas_actualizacion" data-name="jornadaAct" data-id="<?php echo $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-2" aria-hidden="true"></i>
					Guardar datos
				</button>
			</div>
			<?php echo form_close() ?>
		<?php endif; ?>
		<!-- Tabla jornadas -->
		<?php if ($jornadasActualizacion): ?>
			<div class="alert alert-success border-left border-success border-4">
				<div class="d-flex">
					<i class="fa fa-check-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
				</div>
			</div>
			<div class="table-responsive mt-4">
				<table id="tabla_jornada_actualizacion" class="table table-striped table-bordered table-hover">
					<thead class="thead-primary">
					<tr class="bg-primary text-white">
						<th>Participó en Jornadas</th>
						<th width="40%">Acciones</th>
					</tr>
					</thead>
					<tbody id="tbody">
					<?php
					echo "<tr>
                            <td class='align-middle font-weight-medium'>" . $jornadasActualizacion->asistio . "</td>";
					if ($nivel != '7'):
						echo "<td class='text-center'>
                                <div class='btn-group' role='group'>
                                    <button class='btn btn-danger btn-sm eliminarJornadaActualizacion'
                                        data-id-jornada='" . $jornadasActualizacion->idSolicitud . "'
                                        data-id-formulario='" . $archivoJornada->id_formulario . "'
                                        data-id-archivo='" . $archivoJornada->id_archivo . "'
                                        data-id-tipo='" . $archivoJornada->tipo . "'
                                        data-nombre-ar='" . $archivoJornada->nombre . "'>
                                        <i class='fa fa-trash mr-1' aria-hidden='true'></i> Eliminar
                                    </button>
                                    <a target='_blank' href='" . base_url() . "uploads/jornadas/" . $archivoJornada->nombre . "' class='btn btn-success btn-sm'>
                                        <i class='fa fa-eye mr-1' aria-hidden='true'></i> Ver documento
                                    </a>
                                </div>
                            </td>";
					endif;
					echo '</tr>';
					?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<!-- Script para actualizar el nombre del archivo seleccionado -->
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_3.js?v=1.2.1') . time() ?>" type="module"></script>
