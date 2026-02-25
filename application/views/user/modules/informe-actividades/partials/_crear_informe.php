<?php
/***
 * @var Docentes $docentes
 * @var Solicitudes $dolicitudes
 * @var $departamentos
 * @var $municipios
 * @var InformeActividadesModel $informes
 */
$CI = &get_instance();
$CI->load->model("InformeActividadesModel");
//echo "<pre>";
//var_dump($informes);
//echo "</pre>";
//die();
?>
<!-- Proceso de registro informeActividades -->
<div class="col-lg-12 grid-margin stretch-card" id="registro_informe_actividades">
	<div class="card shadow-sm">
		<div class="card-body">
			<h3 class="card-title text-primary">
				<i class="mdi mdi-book mr-2"></i>
				Registrar Informe de Actividades
			</h3>
			<div class="card-description p-3">
				<!-- Barra de progreso -->
				<div class="progress" style="height: 20px;">
					<div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>
				<!-- Formulario 0 explicación -->
				<div id="form-0" class="form-section m-3">
					<div class="alert alert-info mb-4">
						<p class="mb-3">
							<i class="fa fa-info-circle"></i>
							Por favor lea atentamente la siguiente información la cual le ayudara a diligenciar su informe de actividades:
						</p>
						<ul>
							<li>Recuerde contar con la información detallada de los asistentes y todas las especificaciones del curso impartido.</li>
							<li>Los facilitadores así como los cursos en cursos, deben estar previamente aprobados y/o acreditados por la Unidad Solidaria.</li>
							<ol>
							<li>Debe tener en su computador los siguientes documentos correctamente diligenciados para su respectivo cargue:</li>
								<li>Archivo de asistencia (Entregar en PDF Único con firmas reales):
									<a class="btn btn-sm btn-outline-danger m-1" download href="<?= base_url("assets/docs/formatos/informe-actividades/formato-para-registro-de-asistencia-a-cursos-acreditados_0.xlsx"); ?>">
										<span class="mdi mdi-file-pdf" aria-hidden="true"></span>
										Descargar formato
									</a>
								</li>
								<li>
									Archivo con el detalle de cada asistente (Excel):
									<a class="btn btn-sm btn-outline-success m-1" download href="<?= base_url("assets/docs/formatos/informe-actividades/formato-para-reporte-de-actividades-pedagogicas_0_0.xlsx"); ?>">
										<span class="mdi mdi-file-excel" aria-hidden="true"></span>
										Descargar formato
									</a>
									<br>
								</li>
								<p>
									Recuerde leer detenidamente las instrucciones que se encuentran en el archivo excel, de ello dependerá que sea cargada correctamente la información de los asistentes al curso impartido.
								</p>
							</ol>
							<li>Recuerde diligenciar y verificar toda la información suministrada antes de finalizar.</li>
						</ul>
					</div>
				</div>
				<!-- Formulario informe de actividades -->
				<div id="form-50" class="form-section" style="display: none;">
					<hr />
					<h4 class="mt-3 text-black">Información del curso impartido:</h4>
					<p>Todos los campos marcados con <span class="text-danger">*</span> son requeridos</p>
					<hr />
					<?= form_open('', array('id' => 'formulario_informe_actividades')); ?>
					<div class="row">
						<div class="col-6">
							<!-- Fecha de inicio -->
							<div class="form-group">
								<label for="informe_fecha_incio">Fecha de inicio curso <span class="text-danger">*</span></label>
								<input type="date" class="form-control" name="informe_fecha_incio" id="informe_fecha_incio" required>
							</div>
							<!-- Fecha de fin -->
							<div class="form-group">
								<label for="informe_fecha_fin">Fecha de finalización curso <span class="text-danger">*</span></label>
								<input type="date" class="form-control" name="informe_fecha_fin" id="informe_fecha_fin" required>
							</div>
							<!-- Departamentos -->
							<div class="form-group">
								<label for="informe_departamento_curso">Departamento<span class="text-danger">*</span></label>
								<br>
								<select name="informe_departamento_curso" id="informe_departamento_curso" data-id-dep="4" class="form-control show-tick departamentos" required="">
									<?php foreach ($departamentos as $departamento): ?>
										<option id="<?= $departamento->id_departamento ?>" value="<?= $departamento->nombre ?>"><?= $departamento->nombre ?></option>
									<?php endforeach;?>
								</select>
							</div>
							<!-- Municipios -->
							<div class="form-group">
								<div id="div_municipios4">
									<label for="informe_municipio_curso">Municipio: <span class="text-danger">*</span></label>
									<br>
									<select name="informe_municipio_curso" id="informe_municipio_curso" class="form-control show-tick" required="">
										<?php foreach ($municipios as $municipio) : ?>
											<option id="<?= $municipio->id_municipio ?>" value="<?= $municipio->nombre ?>"><?= $municipio->nombre ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<!-- Duración Curso -->
							<div class="form-group">
								<label for="informe_duracion_curso">Duracion del Curso: <small class="text-danger">* Horas</small></label>
								<input type="number" name="informe_duracion_curso" class="form-control" id="informe_duracion_curso" min="20" placeholder="20" required>
							</div>
							<!-- Docente -->
							<div class="form-group">
								<label for="informe_docente">Docente: <span class="text-danger">*</span></label><br>
								<select name="informe_docente" id="informe_docente" class="form-control show-tick" required>
									<?php foreach ($docentes as $docente): ?>
										<option id='<?= $docente->id_docente ?>' value='<?= $docente->id_docente ?>'>
											<?= $docente->primerNombreDocente ?>  <?= $docente->primerApellidoDocente ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<!-- Intencionalidad Curso -->
							<div class="form-group">
								<label for="informe_intencionalidad_curso">Intencionalidad del Curso: <span class="text-danger">*</span></label><br>
								<select name="informe_intencionalidad_curso" id="informe_intencionalidad_curso" class="form-control show-tick" required>
									<option value="1">Promoción</option>
									<option value="2">Creación</option>
									<option value="3">Fortalecimiento</option>
									<option value="4">Desarrollo</option>
									<option value="5">Integración</option>
									<option value="6">Protección</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<!-- Curso -->
							<div class="form-group">
								<label for="informe_cursos">Programa impartido:  <span class="text-danger">*</span></label>
								<select name="informe_cursos" id="informe_cursos" class="form-control show-tick" required>
									<option value="1">Acreditación Curso Básico de Economía Solidaria</option>
									<option value="2">Aval de Trabajo Asociado</option>
									<option value="3">Acreditación Curso Medio de Economía Solidaria</option>
									<option value="4">Acreditación Curso Avanzado de Economía Solidaria</option>
									<option value="5">Acreditación Curso de Educación Económica y Financiera Para La Economía Solidaria</option>
								</select>
							</div>
							<!-- Tipo Curso -->
							<div class="form-group">
								<label for="informe_modalidad">Modalidad del curso: <span class="text-danger">*</span></label><br>
								<select name="informe_modalidad" id="informe_modalidad" class="form-control show-tick" required="">
									<option value="1">Presencial</option>
									<option value="2">Virtual</option>
									<option value="3">En Linea</option>
								</select>
							</div>
							<!-- Asistentes Curso -->
							<div class="form-group">
								<label for="informe_asistentes">Asistentes:</label>
								<input type="number" class="form-control" name="informe_asistentes" id="informe_asistentes" value="35" disabled>
							</div>
							<!-- Asistentes Mujeres Curso -->
							<div class="form-group">
								<label for="informe_numero_mujeres">Numero Mujeres: <span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="informe_numero_mujeres" id="informe_numero_mujeres" value="13" required>
							</div>
							<!-- Asistentes Hombres Curso -->
							<div class="form-group">
								<label for="informe_numero_hombres">Numero Hombres: <span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="informe_numero_hombres" id="informe_numero_hombres" value="12" required>
							</div>
							<!-- Asistentes No Binario Curso -->
							<div class="form-group">
								<label for="informe_numero_no_binario">No Binario: <span class="text-danger">*</span></label>
								<input type="number" class="form-control" name="informe_numero_no_binario" id="informe_numero_no_binario" value="10" required>
							</div>
						</div>
					</div>
					<?= form_close(); ?>
					<hr />
				</div>
				<!-- Formulario cargar archivos de informe  -->
				<div id="form-100" class="form-section" style="display: none">
					<hr />
					<h4 class="mt-3 text-black">Cargar archivo con las firmas de los asistentes:</h4>
					<hr />
					<div class="row">
						<div class="col-12">
							<div class="alert alert-info mb-4">
								<p>
									<i class="fa fa-info-circle"></i>
									El archivo de asistencia del curso debe estar en formato único pdf. (Se requiere solo un archivo si son varios archivos por favor unirlos en uno solo para hacer una consolidación de la asistencia)
								</p>
								<p class="mt-2">
									Seleccione el archivo y de clic en <strong>Finalizar</strong>
								</p>
							</div>
							<?= form_open('', array('id' => 'formulario_archivo_informe_actividades')); ?>
								<label>Archivo de Asistencia del curso:</label>
								<input type="file" class="form-control archivoAsistencia" accept="application/pdf" name="archivoPdfAsistencia" id="archivoPdfAsistencia" data-name="archivoPdfAsistencia" required>
							<?= form_close(); ?>
						</div>
					</div>
					<hr />
				</div>
				<div id="form-150" class="form-section" style="display: none">
					<hr />
					<h3 class="text-primary mb-4">
						<i class="fa fa-check-circle" aria-hidden="true"></i>
						¡Información cargada con éxito!
					</h3>
					<div class="alert alert-success mb-4">
						<p>La información ha sido cargada con éxito, por favor recuerde revisar que la información coincida con lo registrado</p>
						<p>A continuación debe diligenciar los asistentes a este curso, los cuales deben coincidir con la cantidad registrada anteriormente: <strong id="cantidadAsistentes"></strong></p>
					</div>
					<!-- Resumen registrado -->
					<div class="row mb-4">
						<div class="col-6">
							<table class="table table-bordered">
								<thead class="thead-light">
								<tr><th colspan="2">Resumen del Curso Registrado (Datos Básicos)</th></tr>
								</thead>
								<tbody>
								<tr>
									<th>Fecha de inicio</th>
									<td id="resumen_fecha_inicio"></td>
								</tr>
								<tr>
									<th>Fecha de finalización</th>
									<td id="resumen_fecha_fin"></td>
								</tr>
								<tr>
									<th>Departamento</th>
									<td id="resumen_departamento"></td>
								</tr>
								<tr>
									<th>Municipio</th>
									<td id="resumen_municipio"></td>
								</tr>
								<tr>
									<th>Duración (horas)</th>
									<td id="resumen_duracion"></td>
								</tr>
								<tr>
									<th>Docente</th>
									<td id="resumen_docente"></td>
								</tr>
								<tr>
									<th>Intencionalidad</th>
									<td id="resumen_intencionalidad"></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="col-6">
							<table class="table table-bordered">
								<thead class="thead-light">
									<tr>
										<th colspan="2">Resumen del Curso Registrado (Detalles)</th>
									</tr>
								</thead>
								<tbody>
								<tr>
									<th>Programa impartido</th>
									<td id="resumen_curso"></td>
								</tr>
								<tr>
									<th>Modalidad</th>
									<td id="resumen_modalidad"></td>
								</tr>
								<tr>
									<th>Asistentes totales</th>
									<td id="resumen_asistentes"></td>
								</tr>
								<tr>
									<th>Número Mujeres</th>
									<td id="resumen_mujeres"></td>
								</tr>
								<tr>
									<th>Número Hombres</th>
									<td id="resumen_hombres"></td>
								</tr>
								<tr>
									<th>No Binario</th>
									<td id="resumen_no_binario"></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="text-center">
						<div class="btn-group">
							<button class="btn btn-danger eliminar_informe_actividad" id="eliminarRegistro">
								<i class="fa fa-trash" aria-hidden="true"></i>
								Eliminar registro
							</button>
							<button class="btn btn-primary verAsistentes" id="registrarAsistentes">
								<i class="fa fa-user-circle" aria-hidden="true"></i>
								Registrar Asistentes
							</button>
						</div>
					</div>
					<hr />
				</div>
				<!-- Sección de botónes -->
				<div class="btn-group" id="btn-group-navitation">
					<button class="btn btn-sm btn-primary" id="back">
						<i class="fa fa-arrow-left" aria-hidden="true"></i>
						Atrás
					</button>
					<button class="btn btn-sm btn-primary" id="forward">
						Siguiente
						<i class="fa fa-arrow-right" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
