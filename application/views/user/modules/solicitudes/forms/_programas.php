<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $datosProgramas
 * @var $departamentos
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 */
/*
echo '<pre>';
var_dump($datosProgramas);
echo '</pre>';
return null;*/
?>
<!-- Formulario de programas de educación en economía solidaria - INICIO -->
<div id="programa_basico_de_economia_solidaria" data-form="4" class="formulario_panel">
	<h3 class="card-header mb-0"><i class="fa fa-server mr-2" aria-hidden="true"></i> 4. Programa organizaciones y redes SEAS</h3>
	<div class="card-body">
		<?php if($datosProgramas && !empty($datosProgramas)): ?>
			<div class="alert alert-success border-left border-success border-4">
				<div class="d-flex">
					<i class="fa fa-check-circle mr-3 fa-2x"></i>
					<p class="mb-0">Registro realizado con éxito para esta solicitud. Si desea modificar los datos por favor elimine el registro realizado.</p>
				</div>
			</div>
		<?php else: ?>
			<div class="alert alert-info mb-2">
				<p class="mb-2">
					Descargue, lea y acepte el documento anexo a la resolución 078 de 2025, en el cual se establecen los aspectos pedagógicos y metodológicos para el desarrollo del Programa Organizaciones y Redes del SEAS.
				</p>
				<div class="text-center mt-3 mb-3">
					<a href="<?= base_url("assets/docs/resolucion078/anexo_resolucion_078_2025.pdf"); ?>" class="btn btn-sm btn-danger" download>
						<i class="mdi mdi-file-pdf mr-1"></i> Descargar Anexo Técnico
					</a>
				</div>
				<p class="mb-0 font-weight-bold">
					<i class="fa fa-exclamation-circle mr-1" aria-hidden="true"></i> Recuerde que al aceptar el contenido el programa organizaciones y redes SEAS se registrará automáticamente el compromiso y este quedará en nuestra base de datos.
				</p>
			</div>
		<?php endif; ?>
		<!-- Grupo de check con los diferentes cursos -->
		<div class="container px-0">
			<div class="row">
				<div class="col-md-10 mx-auto">
					<div class="card border-light shadow-sm mb-4">
						<div class="card-header bg-light">
							<h5 class="mb-0"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i>
								Contenido del programa organizaciones y redes SEAS</h5>
						</div>
						<div class="card-body p-4">
							<!-- Check Programa Organizaciones y Redes SEAS -->
							<div class="form-group custom-control custom-checkbox" id="programa_seas">
								<input type="checkbox" class="custom-control-input" id="check_programa_seas" form="formulario_programas" name="programa_seas" value="* Programa organizaciones y redes SEAS" disabled <?= (isset($datosProgramas) && !empty($datosProgramas)) ? 'checked' : ''; ?>>
								<label class="custom-control-label" for="check_programa_seas"></label>
								<a href="#" class="ml-2 text-primary" data-toggle="modal" data-target="#modalProgramaSEAS" data-backdrop="static" data-keyboard="false">
									<span class="badge badge-danger">*</span> Lea y acepté los contenidos del programa de organizaciones y redes SEAS
								</a>
							</div>
							<!-- Check Curso Básico -->
							<div class="form-group" id="curso_basico_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_basico_es" form="formulario_programas" name="curso_basico_es" value="* Acreditación Curso Básico de Economía Solidaria" disabled>
									<label for="modalCursoBasico">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoBasico" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Básico de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Aval -->
							<div class="form-group" id="curso_basico_aval" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_basico_aval" form="formulario_programas" name="curso_basico_aval" value="* Acreditación Aval de Trabajo Asociado" disabled required>
									<label for="modalAval">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalAval" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Aval de Trabajo Asociado
									</a>
								</label>
							</div>
							<!-- Check Curso Medio -->
							<div class="form-group" id="curso_medio_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_medio_aval" form="formulario_programas" name="check_curso_medio_aval" value="* Acreditación Curso Medio de Economía Solidaria" disabled required>
									<label for="modalCursoMedio">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoMedio" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Medio de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Avanzando -->
							<div class="form-group" id="curso_avanzado_es" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_avanzado_es" form="formulario_programas" name="check_curso_avanzado_es" value="* Acreditación Curso Avanzado de Economía Solidaria" disabled required>
									<label for="modalCursoAvanzado">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoAvanzado" data-backdrop="static" data-keyboard="false">
										<span class="spanRojo">*</span> Acreditación Curso Avanzado de Economía Solidaria
									</a>
								</label>
							</div>
							<!-- Check Curso Economía Financiera -->
							<div class="form-group" id="curso_economia_financiera" style="display: none;">
								<label class="underlined">
									<input type="checkbox" id="check_curso_economia_financiera" form="formulario_programas" name="check_curso_economia_financiera" value="* Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" disabled required>
									<label for="modalCursoFinanciera">&nbsp;</label>
									<a data-toggle="modal" data-target="#modalCursoFinanciera" data-backdrop="static" data-keyboard="false" data-programa="Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria" data-id="<?php echo $solicitud->idSolicitud; ?>">
										<span class="spanRojo">*</span> Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria
									</a>
							</div>
						</div>
						<!-- Campo oculto con ID de la organización -->
						<input type="hidden" name="id_organizacion" id="id_organizacion" value="<?php echo $solicitud->organizaciones_id_organizacion; ?>">
					</div>
				</div>
			</div>
		</div>
		<!-- Tabla programas aceptados -->
		<?php if ($datosProgramas): ?>
			<div class="card shadow-sm mt-4">
				<div class="card-header bg-light d-flex justify-content-between align-items-center">
					<h5 class="mb-0"><i class="fa fa-table mr-2" aria-hidden="true"></i> Datos programas aceptados</h5>
					<button class="btn btn-outline-primary btn-sm dataReload">
						<i class="fa fa-refresh mr-1" aria-hidden="true"></i> Recargar
					</button>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-striped table-hover mb-0">
							<thead class="thead-light">
							<tr>
								<th>Nombre programa</th>
								<th>Acepta</th>
								<th>Fecha</th>
								<th>Acción</th>
							</tr>
							</thead>
							<tbody id="tbody">
							<?php
							foreach ($datosProgramas as $data) {
								echo "<tr>";
								echo "<td>" . $data->nombrePrograma . "</td>";
								echo "<td>";
								if($data->aceptarPrograma == "Si Acepta") {
									echo "<span class='badge badge-success'>" . $data->aceptarPrograma . "</span>";
								} else {
									echo "<span class='badge badge-secondary'>" . $data->aceptarPrograma . "</span>";
								}
								echo "</td>";
								echo "<td>" . $data->fecha . "</td>";
								if ($nivel != '7'):
									echo "<td><button class='btn btn-outline-danger btn-sm  eliminarDatosProgramas' data-id=" . $data->id . "><i class='fa-solid fa-trash mr-2'></i> Eliminar</button></td>";
								else:
									echo "<td>-</td>";
								endif;
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
	<!-- Botones de navegación -->
	<?php $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
<!-- Formulario de programas de educación en economía solidaria - FIN -->
<!-- Modal Cursos -->
<div class="modal fade" id="modalProgramaSEAS" tabindex="-1" role="dialog" aria-labelledby="modalProgramaSEASLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white text-center">
				<h4 class="modal-title"><i class="mdi mdi-school mr-2"></i>Información sobre Programa Organizaciones y Redes SEAS</h4>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white" ">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="header_politicas" class="col-md-12 text-center bg-light mb-3">
					<img alt="logo" id="imagen_header_politicas" src="<?php echo base_url(); ?>assets/img/logoHeader_j9rcK84myYnuevoLogo_0.png">
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info mb-4">
							<h5 class="text-center mb-3"><strong>Programa Organizaciones y Redes</strong></h5>
							<p>ARTÍCULO 1° OBJETO. La presente Resolución tiene por objeto, actualizar la reglamentación
								del trámite de acreditación que otorga la Unidad Administrativa Especial de Organizaciones
								Solidarias, a partir del Sistema de Educación para la Asociatividad Solidaria-SEAS y de su
								Programa Organizaciones y Redes</p>
							<div class="text-center mt-3">
								<a href="<?= base_url("assets/docs/resolucion078/resolucion_078_2025.pdf"); ?>" class="btn btn-sm btn-danger mr-2" download>
									<i class="mdi mdi-file-pdf-box mr-1"></i> Descargar Resolución 078 de 2025
								</a>
								<a href="<?= base_url("assets/docs/resolucion078/anexo_resolucion_078_2025.pdf"); ?>" class="btn btn-sm btn-danger" download>
									<i class="mdi mdi-file-word mr-1"></i> Descargar Anexo Técnico
								</a>
							</div>
						</div>
					</div>
					<!-- Malla SEAS -->
					<div class="col-md-12">
						<div class="card text-center mb-3">
							<div class="card-header bg-primary text-white">
								<h5><i class="mdi mdi-view-grid mr-2"></i>Malla Curricular SEAS</h5>
							</div>
							<div class="card-body">
								<div class="text-center">
									<img src="<?= base_url("assets/img/malla_seas.jpg"); ?>" alt="Malla Curricular SEAS" class="img-fluid">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-times mr-1" aria-hidden="true"></i> No, declino
				</button>
				<button type="button" class="btn btn-success" id="aceptar_programa_seas" data-programa="Programa organizaciones y redes SEAS" data-modal="modalProgramaSEAS" data-check="check_programa_seas" data-id="<?= $solicitud->idSolicitud; ?>">
					<i class="fa fa-check mr-1"></i> Sí, acepto
				</button>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/formulario_4.js?v=1.2.1') . time() ?>" type="module"></script>
