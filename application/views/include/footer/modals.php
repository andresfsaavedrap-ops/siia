<div class="" id="modals-sia">
	<!-- Modal Próximamente -->
	<div class="modal fade" id="modalProximamente" tabindex="-1" role="dialog" aria-labelledby="modalProximamenteLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="modalProximamenteLabel">
						<i class="mdi mdi-wrench mr-2"></i>
						Funcionalidad en Desarrollo
					</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<div class="mb-4">
						<i class="mdi mdi-worker text-primary" style="font-size: 4rem;"></i>
					</div>
					<h6 class="mb-3">La funcionalidad <span id="funcionalidadNombre">Próximamente</span> está actualmente en desarrollo</h6>
					<p class="text-muted mb-4">
						Nuestro equipo de desarrollo está trabajando para implementar esta funcionalidad. 
						Estará disponible en una próxima actualización del sistema.
					</p>
					<div class="alert alert-info mb-0">
						<i class="mdi mdi-information mr-2"></i>
						<small>Recibirás una notificación cuando esté disponible.</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">
						<i class="mdi mdi-check mr-2"></i>Entendido
					</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade in" id="panelPrincipal" tabindex="-1" role="dialog" aria-labelledby="panelprincipalh">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="panelprincipalh">Ayuda <i class="fa fa-info" aria-hidden="true"></i></h4>
				</div>
				<div class="modal-body">
					<img style="margin: 0 auto;" src="<?= base_url("assets/img/siia_logo.png"); ?>" class="img-responsive" alt="Banner">
					<hr />
					<?= $informacionModal; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="cerrarModalpanelPrincipal" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Informe de actividades -->
	<div class="modal fade in" id="modalInformeAct2019" tabindex="-1" role="dialog" aria-labelledby="modalInformeAct2019j">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalInformeAct2019j">Módulo de informe de actividades <i class="fa fa-flag" aria-hidden="true"></i></h4>
				</div>
				<div class="modal-body">
					<p><strong>¡Este módulo estará disponible en el 2019, espéralo!</strong></p>
					<p><small>En cumplimiento de la circular 001 de 2018 este módulo se activará en enero de 2019. En 2018 se emitirán las certificaciones de cursos como tradicionalmente se ha venido realizando.” Esto con el fin de evitar que se emitan certificaciones este año."</small></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" id="cerrarModalpanelPrincipal" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para guardar observaciones -->
	<div class="modal fade in" id="guardarOBSSI" tabindex="-1" role="dialog" aria-labelledby="guardarOBSSI">
		<div class="modal-dialog modal-xs" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="guardarOBSSIs">¿Guardar observaciones del formulario?</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-siia btn-sm" id="guardarSiObs">Si, guardar <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para bateria de observaciones -->
	<div class="modal fade in" id="modalBateriaObservaciones" tabindex="-1" role="dialog" aria-labelledby="modalBateriaObservaciones">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4>Observaciones</h4>
					<div class="form-group">
						<label>Tipo de observación:</label>
						<br>
						<select name="tipoBateriaObservacion" id="tipoBateriaObservacion" data-id-dep="1" class="selectpicker form-control show-tick">
							<option id="0" value="1" selected>1. Información General de la Entidad </option>
							<option id="1" value="2">2. Documentación Legal </option>
							<option id="1" value="3">3. Registros educativos de Programas </option>
							<option id="2" value="4">4. Antecedentes Académicos </option>
							<option id="3" value="5">5. Jornadas de actualización </option>
							<option id="4" value="6">6. Programa básico de economía solidaria </option>
							<option id="5" value="7">7. Programas Aval </option>
							<option id="6" value="8">8. Programas </option>
							<option id="7" value="9">9. Facilitadores </option>
							<option id="8" value="10">10. Datos Plataforma Virtual </option>
							<option id="9" value="11">Observaciones Generales </option>
						</select>
					</div>
					<div class="form-group">
						<label>Titulo:</label>
						<input type="text" class="form-control" id="tituloBateriaObservacion" placeholder="Titulo...">
					</div>
					<div class="form-group">
						<label>Observación:</label>
						<textarea class="form-control" id="observacionBateriaObservacion" placeholder="Observación..." rows="7"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-siia btn-sm" id="crearBateriaObservacion">Crear observación <i class="fa fa-check" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-warning btn-sm" id="actualizarBateriaObservacion">Actualizar observación <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- //Modal relación de cambios -->
	<div class="modal fade" id="modalRelacionCambios" tabindex="-1" role="dialog" aria-labelledby="relacionCambios">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<div class="d-flex justify-content-between align-items-center w-100">
						<h4 class="modal-title mb-0" id="relacionCambios">Relación de cambios</h4>
						<div class="d-flex align-items-center">
							<a id="verRelacionFiltrada" href="#" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm mr-2">Ver tabla de relación de cambios para filtrar y descargar <i class="fa fa-table" aria-hidden="true"></i></a>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-white">&times;</span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table id="tabla_relacionCambio" width="100%" border=0 class="table table-striped table-bordered tabla_form">
							<thead>
							<tr>
								<td>Titulo</td>
								<td class="col-md-6">Descripcion</td>
								<td>Fecha</td>
							</tr>
							</thead>
							<tbody id="tbody_relacionCambios">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Link términos -->
	<div class="modal fade" id="terminosCondiciones" tabindex="-1" role="dialog" aria-labelledby="terminosCondiciones">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="terminosCondiciones">Términos, condiciones y características de uso del trámite</h3>
				</div>
				<div class="modal-body">
					<p>El trámite no tiene costo.</p>
					<hr />
					<label>Características de los anexos:</label>
					<p>Los archivos deben estar en <strong>formato/extensión</strong> (<span class="spanRojo">pdf</span>) en <strong>minúscula</strong>.</p>
					<p>Las imagenes deben estar en <strong>formato/extensión</strong> (<span class="spanRojo">jpg/png/jpeg</span>) en <strong>minúscula</strong>.</p>
					<p>Los archivos deben tener un <strong>tamaño maximo</strong> de (<span class="spanRojo">~ 10</span>) Mb (megabytes).</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Servicio de atención -->
	<div class="modal fade" id="servicioAtencion" tabindex="-1" role="dialog" aria-labelledby="servicioAtencion">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="servicioAtencion">Servicio de atención</h3>
				</div>
				<div class="modal-body">
					<ul>
						<li><a href="https://www.uaeos.gov.co/" target="_blank">Página web de la Unidad Administrativa Especial de Organizaciones Solidarias</a></li>
						<li><a href="mailto:atencionalciudadano@uaeos.gov.co" target="_blank">atencionalciudadano@uaeos.gov.co</a></li>
						<li>Atención telefónica al <strong>3275252</strong> Ext. <strong>192-301</strong> (Bogotá); línea gratuita nacional <strong>018000122020</strong></li>
						<li>Atención personalizada: <strong>Carrera 10 No. 15 - 22</strong> Lunes a viernes de <strong>8 a.m. a 5:00 p.m.</strong>, en la ciudad de Bogotá.</li>
						<li>A través del Chat en la página web los días <strong>martes y jueves</strong> de <strong>9 am a 12 pm</strong></li>
					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para ver historial de observaciones -->
	<div class="modal fade" id="verHistObsUs" tabindex="-1" role="dialog" aria-labelledby="verhistobsus">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content shadow-lg border-0">
				<div class="modal-header bg-primary text-white">
					<h3 class="modal-title d-flex align-items-center" id="verhistobsus">
						<i class="mdi mdi-history mr-2"></i> Historial de Observaciones
					</h3>
				</div>
				<div class="modal-body bg-white">
					<div class="card shadow-sm">
						<div class="card-header bg-light">
							<strong>Listado</strong>
						</div>
						<div class="card-body p-2">
							<div class="table-responsive">
								<table id="tabla_historial_obs" width="100%" border=0 class="table table-striped table-bordered tabla_form">
									<thead>
									<tr>
										<td class="col-md-2">Formulario</td>
										<td class="col-md-2">Campo del formulario</td>
										<td class="col-md-3">Observación</td>
										<td class="col-md-1">Valida</td>
										<td class="col-md-2">Realizada</td>
										<td class="col-md-2">Fecha de Observación</td>
										<td class="col-md-1">Número de Revisión</td>
									</tr>
									</thead>
									<tbody id="tbody_hist_obs">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" id="crr_hist_obs" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Ayuda en Login- Inicio -->
	<div class="modal fade" id="ayuda_login" tabindex="-1" role="dialog" aria-labelledby="ayudaLogin">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="ayudaLogin">Ayuda </h4>
				</div>
				<div class="modal-body">
					<p>Contenido de ayuda para login</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Cerrar Sesión - Inicio -->
	<div class="modal fade" id="cerrar_sesion_admin" tabindex="-1" role="dialog" aria-labelledby="cerrarSesionAdmin">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title" id="cerrarSesionAdmin">¿Está seguro de cerrar sesión <label class="user-profile"><?= $nombre_usuario ?></label>?</h5>
				</div>
				<div class="modal-body">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No <i class="fa fa-times" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-siia btn-sm pull-right" id="salir_admin">Si <i class="fa fa-check" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal - Inicio -->
	<div class="modal fade" id="+++++++" tabindex="-1" role="dialog" aria-labelledby="--------------">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="--------------">Ayuda </h4>
				</div>
				<div class="modal-body">
					<!-- Contenido -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal - FIN -->
<!-- //TODO: Botón de ir arriba -->
<!--				<div class="backtoTop" id="back-to-top">-->
<!--					<div class="div-star-up" style="">-->
<!--						<button class="btn-up-hover back-to-top-button" aria-label="Volver a arriba" type="button" data-original-title="" title="">-->
<!--							<a class="a-start-up">-->
<!--								<span class="govco-icon govco-icon-shortu-arrow-n btn-svg-up-hover small"></span>-->
<!--								<span class="label-button-star-up">Volver a arriba</span>-->
<!--							</a>-->
<!--						</button>-->
<!--					</div>-->
<!--				</div>-->
<!-- Footer Content -->
<!-- Footer -->
<!-- content-wrapper ends -->
<!-- partial:../../partials/_footer.html -->

<script>
$(document).ready(function() {
    $('[data-target="#modalProximamente"]').on('click', function(e) {
        e.preventDefault();
        var funcionalidad = $(this).data('funcionalidad');
        $('#funcionalidadNombre').text(funcionalidad);
    });
});
</script>
