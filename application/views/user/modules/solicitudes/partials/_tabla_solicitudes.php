<!-- Tarjeta si existe información en formulario 1 -->
<!-- Información General -->
<?php
/***
 * @var $organizacion
 * @var $solicitudes
 * @var $informacionGeneral
 */
$CI = &get_instance();
$CI->load->model("ResolucionesModel");
?>
<div class="col-lg-12 grid-margin stretch-card">
	<div class="card shadow-sm">
		<div class="card-body">
			<h4 class="card-title text-primary"><i class="mdi mdi-lightbulb mr-2"></i>Información a tener en cuenta</h4>
			<div class="card-description mt-3">
				<p>En este espacio podrás encontrar las solicitudes creadas anteriormente o podrás crear una nueva.</p>
				<div class="alert alert-info mb-4">
					<i class="fa fa-info-circle"></i>
					Por favor lea los siguientes manuales, que lo guiarán paso a paso en la creación y envío de su solicitud de acreditación:
				</div>
				<a href="<?php echo base_url('assets/docs/manuales/usuario/4.diligenciar_solicitud.pdf'); ?>" class="btn btn-outline-primary btn-sm ml-2" download>
					Crear y Administrar Solicitudes
					<i class="mdi mdi-download ml-1"></i>
				</a>
				<a href="<?php echo base_url('assets/docs/manuales/usuario/4.diligenciar_solicitud.pdf'); ?>" class="btn btn-outline-info btn-sm ml-2" download>
					Diligenciar y Enviar Solicitud
					<i class="mdi mdi-download ml-1"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<!-- Tabla y botón de creación de solicitudes -->
<div class="col-lg-12 grid-margin stretch-card" id="verSolicitudes">
	<div class="card shadow-sm">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div>
					<h4 class="card-title mb-0">Solicitudes</h4>
					<p class="text-muted small">Solicitudes <span class="badge badge-primary">registradas</span></p>
				</div>
				<a class="btn btn-primary btn-sm" id="nuevaSolicitud">
					<i class="mdi mdi-file-plus mr-2" aria-hidden="true"></i>Agregar nueva solicitud
				</a>
			</div>
			<hr class="mb-4" />
			<?php if ($solicitudes): ?>
				<div class="table-responsive text-center">
					<!-- <table id="tabla_solicitudes" class="table table-striped table-hover"> -->
					<table class="table table-striped table-hover">
						<thead class="bg-light">
							<tr>
								<th>ID</th>
								<th>Creación</th>
								<th>Estado</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody id="tbody">
						<?php foreach ($solicitudes as $solicitud): ?>
							<tr>
								<td><?= $solicitud->idSolicitud ?></td>
								<td><?= $solicitud->fechaCreacion ?></td>
								<td><?= $solicitud->nombre ?></td>
								<?php if($solicitud->nombre == "En Proceso"): ?>
									<td>
										<div class='btn-group text-center' role='group' aria-label='acciones'>
											<button type='button' class='btn btn-primary btn-sm verSolicitud' data-id="<?= $solicitud->idSolicitud ?>" title='Continuar Solicitud'>
												Continuar <i class='fa fa-check' aria-hidden='true'></i>
											</button>
											<button type='button' class='btn btn-danger btn-sm eliminarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Eliminar Solicitud'>
												Eliminar <i class='fa fa-trash' aria-hidden='true'></i>
											</button>
											<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
												Detalle <i class='fa fa-info' aria-hidden='true'></i>
											</button>
										</div>
									</td>
								<?php endif; ?>
								<?php if($solicitud->nombre == "En Renovación"): ?>
									<td>
										<div class='btn-group text-center' role='group' aria-label='acciones'>
											<button type='button' class='btn btn-primary btn-sm verSolicitud' data-id="<?= $solicitud->idSolicitud ?>" title='Continuar Solicitud'>
												Continuar <i class='fa fa-check' aria-hidden='true'></i>
											</button>
											<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
												Detalle <i class='fa fa-info' aria-hidden='true'></i>
											</button>
										</div>
									</td>
								<?php endif; ?>
								<?php if($solicitud->nombre == "Acreditado" || $solicitud->nombre == "Archivada" || $solicitud->nombre == "Negada" || $solicitud->nombre == "Revocada" || $solicitud->nombre == "Vencida" ): ?>
									<td>
										<div class='btn-group' role='group' aria-label='acciones'>
											<?php $resolucion = $CI->ResolucionesModel->getResolucionSolicitud($solicitud->idSolicitud) ?>
											<?php if($resolucion): ?>
												<a class="btn btn-sm btn-primary" style="text-decoration: none;" href="<?= base_url() . 'uploads/resoluciones/' . $resolucion->resolucion; ?>" target='_blank'>
													Resolución <i class='fa fa-eye' aria-hidden='true'></i>
												</a>
												<?php
												// Capturar datos de fechas para comprobación
												$fechaActual = new DateTime();
												$fechaFinResolucion = new DateTime($resolucion->fechaResolucionFinal);
												// Verificar si el motivoSolicitud contiene 'Programa organizaciones y redes SEAS.' (motivo 6)
												$esProgramaSEAS = false;
												if (!empty($solicitud->motivoSolicitud)) {
													// Verificar si es un JSON array
													$motivosArray = json_decode($solicitud->motivoSolicitud, true);
													if (is_array($motivosArray)) {
														// Es un JSON array, buscar el motivo 6
														$esProgramaSEAS = in_array('6', $motivosArray);
													} else {
														// Es un string separado por comas, buscar 'Programa organizaciones y redes SEAS.'
														$esProgramaSEAS = strpos($solicitud->motivoSolicitud, 'Programa organizaciones y redes SEAS.') !== false;
													}
												}
												// Configurar período de renovación según el tipo de motivo
												if ($esProgramaSEAS) {
													// Para Programa SEAS: habilitar 3 meses antes del vencimiento y hasta 6 meses después
													$fechaInicioRenovacion = clone $fechaFinResolucion;
													$fechaInicioRenovacion->modify('-3 months');
													$fechaLimiteRenovacion = clone $fechaFinResolucion;
													$fechaLimiteRenovacion->modify('+6 months');
													$dentroDelPeriodo = $fechaActual >= $fechaInicioRenovacion && $fechaActual <= $fechaLimiteRenovacion;
												} else {
													// Para otros motivos: mantener lógica actual (12 meses después del vencimiento)
													$fechaLimiteRenovacion = clone $fechaFinResolucion;
													$fechaLimiteRenovacion->modify('+12 months');
													$dentroDelPeriodo = $fechaActual <= $fechaLimiteRenovacion;
												}
												// Verificar si la solicitud está en estado permitido para renovación
												$estadosPermitidos = ['Acreditado', 'Vencida'];
												$puedeRenovar = in_array($solicitud->nombre, $estadosPermitidos);
												// Verificar si la solicitud ya fue renovada
												$yaRenovada = $CI->SolicitudesModel->solicitudYaRenovada($solicitud->idSolicitud);
												// Mostrar botón de renovación si cumple todas las condiciones y no ha sido renovada
												if($puedeRenovar && $dentroDelPeriodo && !$yaRenovada): ?>
													<button type='button' class='btn btn-success btn-sm renovarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Renovar Solicitud'>
														Renovar <i class='fa fa-check' aria-hidden='true'></i>
													</button>
												<?php endif; ?>
											<?php endif; ?>
											<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
												Detalle <i class='fa fa-info' aria-hidden='true'></i>
											</button>
										</div>
									</td>
								<?php endif; ?>
								<?php if($solicitud->nombre == "Finalizado"): ?>
									<td>
										<div class='btn-group' role='group' aria-label='acciones'>
											<button class='btn btn-primary btn-sm verObservaciones' data-id="<?= $solicitud->idSolicitud ?>" title='Ver Estado'>
												Estado <i class='fa fa-eye' aria-hidden='true'></i>
											</button>
											<?php if($solicitud->nombre != 'En Renovación'): ?>
											<button type='button' class='btn btn-danger btn-sm eliminarSolicitud' data-id='<?= $solicitud->idSolicitud ?>' title='Eliminar Solicitud'>
												Eliminar <i class='fa fa-trash' aria-hidden='true'></i>
											</button>
											<?php endif; ?>
											<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
												Detalle <i class='fa fa-info' aria-hidden='true'></i>
											</button>
										</div>
									</td>
								<?php endif; ?>
								<?php if($solicitud->nombre == "En Observaciones"): ?>
									<td>
										<div class='btn-group' role='group' aria-label='acciones'>
											<button class='btn btn-warning btn-sm verObservaciones' data-id="<?= $solicitud->idSolicitud ?>" title='Ver Observaciones'>
												Observaciones <i class='fa fa-eye' aria-hidden='true'></i>
											</button>
											<button class='btn btn-info btn-sm verDetalleSolicitud' data-toggle='modal' data-target='#modalVerDetalle' data-backdrop='static' data-keyboard='false' data-id='<?= $solicitud->idSolicitud ?>' title='Ver Detalle'>
												Detalle <i class='fa fa-info' aria-hidden='true'></i>
											</button>
										</div>
									</td>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="alert alert-info text-center">
					<i class="mdi mdi-information mb-5"></i>
					<p>No hay solicitudes registradas actualmente. Utilice el botón "Agregar nueva solicitud" para crear una.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Modal Detalle Solicitud - Versión Mejorada -->
<div class="modal fade" id="modalVerDetalle" tabindex="-1" role="dialog" aria-labelledby="modalVerDetalleLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content shadow-lg border-0">
			<!-- Header con gradiente y estilo mejorado -->
			<div class="modal-header bg-gradient-primary text-white border-0 py-4">
				<h4 class="modal-title font-weight-bold d-flex align-items-center" id="modalVerDetalleLabel">
					<div class="icon-circle bg-white bg-opacity-20 rounded-circle p-2 mr-3">
						<i class="ti-info-alt text-white"></i>
					</div>
					<div>
						<span class="h4 mb-0">Detalles de la Solicitud</span>
						<small class="d-block text-white-50 font-weight-normal">Información completa del registro</small>
					</div>
				</h4>
				<button type="button" class="btn btn-link text-white p-2 ml-auto" data-dismiss="modal" aria-label="Close">
					<i class="ti-close font-weight-bold" style="font-size: 1.2rem;"></i>
				</button>
			</div>

			<!-- Cuerpo del modal con diseño moderno -->
			<div class="modal-body p-0" style="background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);">
				<div class="container-fluid p-4">
					<!-- Barra de progreso decorativa -->
					<div class="progress mb-4" style="height: 4px; border-radius: 2px;">
						<div class="progress-bar bg-gradient-primary" style="width: 100%; border-radius: 2px;"></div>
					</div>

					<!-- Sección superior - Información básica y fechas -->
					<div class="row mb-4">
						<!-- Información básica -->
						<div class="col-lg-6 mb-3">
							<div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
								<!-- Decoración de fondo -->
								<div class="position-absolute" style="top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #4b49ac, #7978e9); border-radius: 50%; opacity: 0.1;"></div>

								<div class="card-body p-4">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-wrapper bg-primary bg-opacity-10 rounded-lg p-2 mr-3">
											<i class="ti-user text-primary" style="font-size: 1.2rem;"></i>
										</div>
										<h5 class="text-primary mb-0 font-weight-600">Información Básica</h5>
									</div>
									<div id="informacionSolicitudBasico" class="content-area">
										<!-- Contenido dinámico -->
									</div>
								</div>
								<!-- Borde decorativo -->
								<div class="border-left-primary" style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #4b49ac, #7978e9);"></div>
							</div>
						</div>

						<!-- Fechas -->
						<div class="col-lg-6 mb-3">
							<div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
								<!-- Decoración de fondo -->
								<div class="position-absolute" style="top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #26c6da, #00bcd4); border-radius: 50%; opacity: 0.1;"></div>

								<div class="card-body p-4">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-wrapper bg-info bg-opacity-10 rounded-lg p-2 mr-3">
											<i class="ti-calendar text-info" style="font-size: 1.2rem;"></i>
										</div>
										<h5 class="text-info mb-0 font-weight-600">Fechas Importantes</h5>
									</div>
									<div id="informacionSolicitudFechas" class="content-area">
										<!-- Contenido dinámico -->
									</div>
								</div>
								<!-- Borde decorativo -->
								<div class="border-left-info" style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #26c6da, #00bcd4);"></div>
							</div>
						</div>
					</div>
					<!-- Sección inferior - Estado y resolución -->
					<div class="row">
						<!-- Estado -->
						<div class="col-lg-6 mb-3">
							<div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
								<!-- Decoración de fondo -->
								<div class="position-absolute" style="top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #ffb822, #ffc107); border-radius: 50%; opacity: 0.1;"></div>

								<div class="card-body p-4">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-wrapper bg-warning bg-opacity-10 rounded-lg p-2 mr-3">
											<i class="ti-pulse text-warning" style="font-size: 1.2rem;"></i>
										</div>
										<h5 class="text-warning mb-0 font-weight-600">Estado Actual</h5>
									</div>
									<div id="informacionSolicitudEstado" class="content-area">
										<!-- Contenido dinámico -->
									</div>
								</div>
								<!-- Borde decorativo -->
								<div class="border-left-warning" style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #ffb822, #ffc107);"></div>
							</div>
						</div>

						<!-- Resolución -->
						<div class="col-lg-6 mb-3" id="informacionResolucionDiv">
							<div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
								<!-- Decoración de fondo -->
								<div class="position-absolute" style="top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(45deg, #0ddbb9, #00d2ff); border-radius: 50%; opacity: 0.1;"></div>

								<div class="card-body p-4">
									<div class="d-flex align-items-center mb-3">
										<div class="icon-wrapper bg-success bg-opacity-10 rounded-lg p-2 mr-3">
											<i class="ti-check text-success" style="font-size: 1.2rem;"></i>
										</div>
										<h5 class="text-success mb-0 font-weight-600">Resolución</h5>
									</div>
									<div id="informacionResolucion" class="content-area">
										<!-- Contenido dinámico -->
									</div>
								</div>
								<!-- Borde decorativo -->
								<div class="border-left-success" style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #0ddbb9, #00d2ff);"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Footer con botones mejorados -->
			<div class="modal-footer border-0 bg-light p-4">
				<div class="d-flex justify-content-between w-100">
					<div class="text-muted small">
						<i class="ti-info-alt mr-1"></i>
						Última actualización: <span class="font-weight-medium">Hace 2 minutos</span>
					</div>
					<button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
						<i class="ti-close mr-2"></i>Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- CSS adicional para el modal mejorado -->
<style>
	/* Estilos específicos para el modal mejorado */
	.modal-xl {
		max-width: 95%;
	}

	@media (min-width: 1200px) {
		.modal-xl {
			max-width: 1000px;
		}
	}

	.bg-gradient-primary {
		background: linear-gradient(135deg, #004884 0%, #035da8 100%) !important;
	}

	.bg-opacity-10 {
		--bs-bg-opacity: 0.1;
		background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
	}

	.bg-opacity-20 {
		--bs-bg-opacity: 0.2;
		background-color: rgba(255, 255, 255, var(--bs-bg-opacity)) !important;
	}

	.font-weight-600 {
		font-weight: 600 !important;
	}

	.rounded-lg {
		border-radius: 0.5rem !important;
	}

	.icon-wrapper {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 40px;
		height: 40px;
	}

	.icon-circle {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 45px;
		height: 45px;
	}

	.content-area {
		line-height: 1.6;
	}

	.card {
		transition: all 0.3s ease;
	}

	.card:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
	}

	.progress-bar {
		background: linear-gradient(90deg, #4b49ac 0%, #7978e9 50%, #4b49ac 100%);
		background-size: 200% 100%;
		animation: shimmer 2s infinite;
	}

	@keyframes shimmer {
		0% { background-position: -200% 0; }
		100% { background-position: 200% 0; }
	}

	/* Mejoras para responsive */
	@media (max-width: 768px) {
		.modal-dialog {
			margin: 10px;
			max-width: calc(100% - 20px);
		}

		.icon-circle {
			width: 35px;
			height: 35px;
		}

		.modal-title .h4 {
			font-size: 1.1rem;
		}

		.modal-body .container-fluid {
			padding: 20px 15px;
		}
	}
</style>

