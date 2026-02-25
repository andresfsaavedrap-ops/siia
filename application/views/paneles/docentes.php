<?php

/***
 * @var $dataInformacionGeneral
 * @var $docentes
 * @var $organizacion
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';
return null; */
?>
<hr />
<div class="container">
	<div class="row">
		<div class="col-12">
			<h4>Información a tener en cuenta:</h4>
			<p>Ingrese solo la información del equipo de facilitadores que desarrollará los cursos. Este debe ser de <span class="spanRojo">mínimo 3 facilitadores</span>. Anexe los soportes de estudios y de experiencia solicitados.</p>
			<p>Ingrese los datos del facilitador y de clic en <label>"Crear facilitador"</label>. Los archivos que debe adjuntar son: </p>
			<ul>
				<li>Hoja de vida</li>
				<li>Título de técnico, tecnólogo o profesional.</li>
				<li>Certificado o certificados que acrediten experiencia en actividades formativas, capacitación, como docente, facilitador, capacitador o instructor, en mínimo tres procesos formativos.</li>
				<li>Certificados que acrediten haber recibido capacitación en economía solidaria por mínimo <span class="spanRojo">60 Horas</span>.</li>
			</ul>
			<p>Recuerde que, si no cumple con los requisitos (documentos, certificados, horas), el facilitador no será válido, para dar continuidad con el trámite en caso de que solo registre tres (3) docentes.</p>
			<p>Su organización podrá visualizar el estado del docente si es válido o no, si no lo es, deberá subsanar las observaciones realizadas.</p>
		</div>
		<div class="col-12">
			<?php if ($dataInformacionGeneral == null || $dataInformacionGeneral == ""): ?>
				<div class="col-12">
					<div class="jumbotron">
						<h3>Información general:</h3>
						<p>Por favor completé el formulario número <strong>1. Información General</strong> en cualquier solicitud <strong>En Proceso</strong> para continuar actualizando los docentes.</p>
						<button class="btn btn-danger btn-sm volver_al_panel" id="informe_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
					</div>
				</div>
			<?php else: ?>
				<button class="btn btn-danger btn-sm volver_al_panel" id="informe_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
				<hr />
				<button class="btn btn-siia pull-right btn-sm" data-toggle='modal' data-target='#crearDocenteOrg'>Agregar nuevo facilitador <i class="fa fa-plus" aria-hidden="true"></i></button>
				<!-- Tabla facilitadores -->
				<h4>Mis facilitadores</h4>
				<table id="tabla_docentes" width="100%" border=0 class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>Primer nombre</td>
							<td>Segundo nombre</td>
							<td>Primer apellido</td>
							<td>Segundo apellido</td>
							<td>Nº cédula</td>
							<td>Profesión</td>
							<td>Horas de capacitación</td>
							<td>¿Aprobado?</td>
							<td>Observación</td>
							<td>Acciones / Archivos</td>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php foreach ($docentes as $docente):
							echo "<tr><td>$docente->primerNombreDocente</td>";
							echo "<td>$docente->segundoNombreDocente</td>";
							echo "<td>$docente->primerApellidoDocente</td>";
							echo "<td>$docente->segundoApellidoDocente</td>";
							echo "<td>$docente->numCedulaCiudadaniaDocente</td>";
							echo "<td>$docente->profesion</td>";
							echo "<td>$docente->horaCapacitacion</td>";
							if ($docente->valido == '0') {
								echo "<td>En proceso de evaluación </td>";
							} else if ($docente->valido == '1') {
								echo "<td>Si</td>";
							}
							echo "<td>$docente->observacion</td>";
							echo "<td><button class='btn btn-siia btn-sm verDocenteOrg' data-toggle='modal' data-nombre='$docente->primerNombreDocente $docente->primerApellidoDocente' data-id='$docente->id_docente' data-target='#verDocenteOrg'>Ver <i class='fa fa-eye' aria-hidden='true'></i> / Adjuntar <i class='fa fa-plus' aria-hidden='true'></i></button></td></tr>";
						endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
</div>
<hr />
<!-- Modales ver docente -->
<div class="modal fade" id="verDocenteOrg" tabindex="-1" role="dialog" aria-labelledby="verdocenteorg">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" id="verdocenteorg">Facilitador: <label id="nombre_doc"></label>.</h3>
				<h4>¿Aprobado?: <label id="valido_doc"></label></h4>
				<small>Los archivos y campos marcados con asterisco (<span class="spanRojo">*</span>) son <strong>requeridos</strong> en la solicitud.</small><br />
				<small>Los archivos deben estar en <strong>formato/extensión</strong> (<span class="spanRojo">pdf</span>) en <strong>minúscula</strong>.</small><br />
				<small>Los archivos deben tener un <strong>tamaño máximo</strong> de (<span class="spanRojo">10</span>) MB (megabytes).</small><br />
			</div>
			<div class="modal-body">
				<div class="col-md-12" id="formulario_docentes">
					<?php echo form_open_multipart('', array('id' => 'formulario_docente')); ?>
					<div class="form-group">
						<label>Primer Nombre:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" id="primer_nombre_doc">
					</div>
					<div class="form-group">
						<label>Segundo Nombre:</label>
						<input type="text" class="form-control" id="segundo_nombre_doc">
					</div>
					<div class="form-group">
						<label>Primer Apellido:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" id="primer_apellido_doc">
					</div>
					<div class="form-group">
						<label>Segundo Apellido:</label>
						<input type="text" class="form-control" id="segundo_apellido_doc">
					</div>
					<div class="form-group">
						<label>Número de Cédula:<span class="spanRojo">*</span></label>
						<input type="number" class="form-control" id="numero_cedula_doc">
					</div>
					<div class="form-group">
						<label>Profesión:<span class="spanRojo">*</span></label>
						<input type="text" class="form-control" id="profesion_doc">
					</div>
					<div class="form-group">
						<label>Horas de Capacitación:<span class="spanRojo">*</span></label>
						<input type="number" class="form-control" id="horas_doc">
					</div>
					<?php echo form_close(); ?>
					<hr />
				</div>
				<br><br>
				<h4>Documentos.</h4>
				<hr />
				<div class="col-md-6 p-3">
					<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_hojavida')); ?>
					<div class="form-group">
						<label>Hoja de vida (PDF):<span class="spanRojo">*</span></label><br>
						<small>Solo adjuntar la hoja de vida <strong>sin soporte alguno</strong>.</small>
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteHojaVida" name="docenteHojaVida" id="docenteHojaVida">
						<input type="button" class="btn btn-siia btn-sm archivos_form_hojaVidaDocente fa-fa" style="width: 100%" data-name="docenteHojaVida" name="hojaVidaDocente" id="hojaVidaDocente" value="Guardar &#xf00c">
					</div>
					<?php echo form_close(); ?>
					<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_certificados')); ?>
					<div class="form-group">
						<label>Certificados de experiencia <span class="spanRojo">(3)</span>(PDF):<span class="spanRojo">*</span></label><br>
						<small>Solo adjuntar certificados como <strong>conferensista</strong>, <strong>docente</strong>, <strong>tallerista</strong>, <strong>instructor</strong>, entre otros, evitar relacionar como <strong>asesor</strong>, <strong>cargos directivos</strong>, entre otros.</small><br>
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados1">
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados2">
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteCertificados" name="docenteCertificados[]" id="docenteCertificados3">
						<input type="button" class="btn btn-siia btn-sm archivos_form_certificadoDocente fa-fa mt-3" style="width: 100%" data-name="docenteCertificados" name="certificadoDocente" id="certificadoDocente" value="Guardar &#xf00c">
					</div>
					<?php echo form_close(); ?>
					<hr />
				</div>
				<div class="col-md-6 p-3">
					<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_titulo')); ?>
					<div class="form-group">
						<label>Titulo Profesional (PDF):<span class="spanRojo">*</span></label><br>
						<small>Solo adjuntar el <strong>diploma ó acta de grado</strong>.</small><br>
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteTitulo" name="docenteTitulo" id="docenteTitulo">
						<input type="button" class="btn btn-siia btn-sm archivos_form_tituloDocente fa-fa" style="width: 100%" data-name="docenteTitulo" name="tituloDocente" id="tituloDocente" value="Guardar &#xf00c">
					</div>
					<?php echo form_close(); ?>
					<?php echo form_open_multipart('', array('id' => 'formulario_archivo_docente_certificados')); ?>
					<div class="form-group">
						<label>Certificados de economia solidaria (PDF):<span class="spanRojo">*</span></label><br>
						<small>Solo adjuntar certificados de <strong>economía solidaria, verificando las horas</strong>.</small><br><br>
						<input type="file" required accept="application/pdf" class="form-control" data-val="docenteCertificadosEconomia" name="docenteCertificadosEconomia" id="docenteCertificadosEconomia"><br>
						<label>¿Horas que tiene el certificado?:<span class="spanRojo">*</span></label><br>
						<input type="number" id="horasCertEcoSol" class="form-control" name="" min="40" placeholder="40">
						<input type="button" class="btn btn-siia btn-sm archivos_form_certificadoEconomiaDocente fa-fa" style="width: 100%" data-name="docenteCertificadosEconomia" name="certificadoDocenteEconomia" id="certificadoDocenteEconomia" value="Guardar &#xf00c">
					</div>
					<?php echo form_close(); ?>
					<hr />
				</div><br><br>
				<button type="button" class="btn btn-siia btn-sm actualizar_docente" style="width: 100%" value="No">Actualizar datos del facilitador <i class="fa fa-refresh" aria-hidden="true"></i></button>
				<br><br>
				<!-- Tabla archivos -->
				<div class="col-md-12" id="tabla_archivos_docentes">
					<h4>Archivos adjuntos al docente:</h4>
					<!--<a class="dataReloadDocente">Recargar <i class="fa fa-refresh" aria-hidden="true"></i></a>-->
					<table id="tabla_archivos_formulario" class="table table-striped table-bordered tabla_form">
						<thead>
							<tr>
								<td>Tipo</td>
								<td>Observación archivo</td>
								<td>Accion</td>
							</tr>
						</thead>
						<tbody id="tbody">
						</tbody>
					</table>
				</div>
				<div class="modal-footer" style="align-content: center; align-items: center; justify-content: center ">
					<div class="button-group">
						<button type="button" class="btn btn-danger btn-sm" data-toggle='modal' data-target='#eliminarDocente'>Eliminar facilitador <i class="fa fa-trash-o" aria-hidden="true"></i></button>
						<?php if ($organizacion->estado == 'Acreditado'): ?>
							<button type="button" class="btn btn-info btn-sm actualizar_docente" value="Si">ENVIAR A EVALUACIÓN DE FACILITADOR <i class="fa fa-refresh" aria-hidden="true"></i></button>
						<?php endif; ?>
						<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="eliminarDocente" tabindex="-2" role="dialog" aria-labelledby="eliminardocente">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="eliminardocente">¿Esta seguro de eliminar el facilitador?</h4>
			</div>
			<div class="modal-body">
				<p>Por favor, confirmar la eliminación del facilitador.</p>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No, no borrar al facilitador <i class="fa fa-times" aria-hidden="true"></i></button>
				<button type="button" class="btn btn-siia btn-sm pull-right" id="siEliminarDocente">Si, estoy seguro y confirmo que elimino al facilitador <i class="fa fa-check" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
