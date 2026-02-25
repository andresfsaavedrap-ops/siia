<?php

/***
 * @var $faq array
 */
/*echo '<pre>';
	var_dump($solicitud);
	echo '</pre>';
	return null;*/
?>
<!-- Style page -->
<link href="<?= base_url('assets/css/user/ayuda.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
<!-- Página de Ayuda Mejorada -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<!-- Sección de Archivos y Recursos -->
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card shadow-sm">
					<div class="card-body">
						<h4 class="card-title text-primary mb-4">Recursos y Documentos</h4>
						<div class="row">
							<!-- Manual de usuario - Ahora abre modal -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100 card-hover" style="transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; cursor: pointer;" data-toggle="modal" data-target="#manualesModal">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-primary text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-book-open-page-variant"></i>
										</div>
										<h5 class="mb-0">Manuales de usuario</h5>
									</div>
									<p class="text-muted mb-3">Guías completas sobre cómo utilizar el sistema SIIA.</p>
									<div class="btn btn-outline-primary btn-sm">
										<i class="mdi mdi-folder-open mr-1"></i> Ver manuales (6)
									</div>
								</div>
							</div>
							<!-- Archivo de asistentes -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100" style="transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; cursor: pointer;" data-toggle="modal" data-target="#informeModal">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-success text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-file-excel"></i>
										</div>
										<h5 class="mb-0">Informes de actividades</h5>
									</div>
									<p class="text-muted mb-3">Recursos para reportar asistentes a los cursos de su organización.</p>
									<div class="btn btn-outline-primary btn-sm">
										<i class="mdi mdi-download mr-1"></i> Descargar
									</div>
								</div>
							</div>
							<!-- PQRD -->
							<div class="col-md-4 mb-3">
								<div class="card border-0 bg-light p-3 h-100">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-circle bg-warning text-white mr-3" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
											<i class="mdi mdi-message-text"></i>
										</div>
										<h5 class="mb-0">PQRD</h5>
									</div>
									<p class="text-muted mb-3">Sistema de Preguntas, Quejas, Reclamos y Denuncias.</p>
									<a href="https://sitios.unidadsolidaria.gov.co/portal/pqr/index.php?idcategoria=6" target="_blank" class="btn btn-outline-warning btn-sm">
										<i class="mdi mdi-open-in-new mr-1"></i> Acceder
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal para Manuales -->
			<div class="modal fade" id="manualesModal" tabindex="-1" role="dialog" aria-labelledby="manualesModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h5 class="modal-title" id="manualesModalLabel">
								<i class="mdi mdi-book-open-page-variant"></i>
								Manuales de Usuario - Sistema Integrado
							</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="list-group list-group-flush">
								<div class="row">
									<div class="col-lg-6 col-md-12">
										<!-- Manual 1 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/1.registro_en_el_sistema.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">1. Registro en el Sistema</h6>
												<p class="mb-0 text-muted small">Cómo registrarse y crear cuenta en el sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 2 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/2.actualizacion_de_datos.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">2. Actualización de Datos</h6>
												<p class="mb-0 text-muted small">Cómo actualizar y modificar datos personales</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 3 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/3.crear_administrar_solicitudes.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">3. Crear y Administrar Solicitudes</h6>
												<p class="mb-0 text-muted small">Gestión completa de solicitudes en el sistema</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 4 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/4.diligenciar_solicitud.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">4. Diligenciar Solicitud</h6>
												<p class="mb-0 text-muted small">Cómo completar y enviar solicitudes</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
									</div>
									<div class="col-lg-6 col-md-12">
										<!-- Manual 5 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/5.registro_de_facilitadores.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 border-bottom">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">5. Registro de Facilitadores</h6>
												<p class="mb-0 text-muted small">Proceso de registro y gestión de facilitadores</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										<!-- Manual 6 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/6.revision_de_observaciones_solicitud.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">6. Revisión de Observaciones de Solicitud</h6>
												<p class="mb-0 text-muted small">Cómo revisar y responder a observaciones</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										</a>
										<!-- Manual 7 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/7.realizar_proceso_de_renovación.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">7. Realizar Proceso de Renovación</h6>
												<p class="mb-0 text-muted small">Cómo realizar el proceso de renovación</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
										</a>
										<!-- Manual 8 -->
										<a href="<?php echo base_url('assets/docs/manuales/usuario/8.informe_actividades.pdf'); ?>" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0">
											<i class="mdi mdi-file-pdf text-danger mr-3" style="font-size: 28px;"></i>
											<div class="flex-grow-1">
												<h6 class="mb-1 font-weight-bold">8. Realizar Informe de Actividades</h6>
												<p class="mb-0 text-muted small">Cómo registrar tu informe de actividades</p>
											</div>
											<i class="mdi mdi-download text-primary ml-2"></i>
										</a>
									</div>
								</div>
							</div>
							<!-- Botón para descargar todos -->
							<div class="text-center mt-4">
								<hr>
								<button class="btn btn-primary" onclick="descargarTodosManuales()">
									<i class="mdi mdi-download-multiple mr-2"></i>
									Descargar todos los manuales
								</button>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								<i class="mdi mdi-close mr-1"></i> Cerrar
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal para informe de actividades -->
			<div class="modal fade" id="informeModal" tabindex="-1" role="dialog" aria-labelledby="informeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h5 class="modal-title" id="informeModalLabel">
								<i class="mdi mdi-file-pdf-box"></i>
								Manual de Informe de Actividades
							</h5>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							<!-- PDF embebido y centrado -->
							<embed src="<?= base_url('assets/docs/manuales/usuario/8.informe_actividades.pdf'); ?>" type="application/pdf" width="80%" height="500px" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" />
							<hr>
							<!-- Botones para descargar archivos -->
							<div class="row justify-content-center mt-3">
								<div class="col-md-5 mb-2">
									<a href="<?php echo base_url('assets/docs/formatos/informe-actividades/formato-para-registro-de-asistencia-a-cursos-acreditados_0.xlsx'); ?>" class="btn btn-outline-success btn-block" download>
										<i class="mdi mdi-file-pdf mr-2"></i> Descargar Archivo de asistencia (Firmas)
									</a>
								</div>
								<div class="col-md-5 mb-2">
									<a href="<?php echo base_url('assets/docs/formatos/informe-actividades/formato-para-reporte-de-actividades-pedagogicas_0_0.xlsx'); ?>" class="btn btn-outline-success btn-block" download>
										<i class="mdi mdi-file-excel mr-2"></i> Descargar Archivo con el detalle de cada asistente
									</a>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								<i class="mdi mdi-close mr-1"></i> Cerrar
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Sección de Ayuda -->
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card shadow-sm">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h3 class="card-title text-primary mb-0">
								<i class="mdi mdi-help-circle-outline mr-2"></i>Centro de Ayuda
							</h3>
							<span class="badge badge-info p-2">SIIA</span>
						</div>
						<p class="card-description mb-4 text-muted">
							<i class="mdi mdi-information-outline mr-1"></i>
							Preguntas frecuentes sobre la acreditación y el sistema SIIA
						</p>
						<div id="accordion" class="accordion">
							<!-- Pregunta frecuente -->
							<?php foreach ($faq as $i => $item): ?>
								<div class="card mb-2 border-0 shadow-sm">
									<div class="card-header bg-white" id="heading<?php echo $i; ?>">
										<h5 class="mb-0">
											<button class="btn btn-link text-dark d-flex justify-content-between align-items-center w-100" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
												<span>
													<i class="mdi <?php echo $item['icono']; ?> mr-2"></i>
													<?php echo $item['titulo']; ?>
												</span>
												<i class="mdi mdi-chevron-down"></i>
											</button>
										</h5>
									</div>
									<div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion">
										<div class="card-body bg-light">
											<?php echo $item['contenido']; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Scripts -->
	<script>
		function descargarTodosManuales() {
			const manuales = [
				'<?php echo base_url("assets/docs/manuales/usuario/1.registro_en_el_sistema.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/2.actualizacion_de_datos.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/3.crear_administrar_solicitudes.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/4.diligenciar_solicitud.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/5.registro_de_facilitadores.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/6..pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/.pdf"); ?>',
				'<?php echo base_url("assets/docs/manuales/usuario/.pdf"); ?>'
			];
			// Mostrar mensaje de descarga
			const button = event.target;
			const originalText = button.innerHTML;
			button.innerHTML = '<i class="mdi mdi-loading mdi-spin mr-2"></i>Descargando...';
			button.disabled = true;
			// Descargar cada manual con un pequeño delay
			manuales.forEach((url, index) => {
				setTimeout(() => {
					const link = document.createElement('a');
					link.href = url;
					link.target = '_blank';
					link.download = '';
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);

					// Restaurar botón cuando termine
					if (index === manuales.length - 1) {
						setTimeout(() => {
							button.innerHTML = originalText;
							button.disabled = false;
						}, 1000);
					}
				}, index * 500);
			});
		}
		// Script para mejorar la interacción con el acordeón
		$(document).ready(function() {
			// Función para rotar el icono cuando se abre/cierra el acordeón
			$('.btn-link').on('click', function() {
				var icon = $(this).find('.mdi-chevron-down');
				if ($(this).attr('aria-expanded') === 'true') {
					icon.css('transform', 'rotate(0deg)');
				} else {
					icon.css('transform', 'rotate(180deg)');
				}
			});
		});
	</script>
