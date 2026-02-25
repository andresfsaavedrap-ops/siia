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
/*echo '<pre>';
	var_dump($solicitud);
	echo '</pre>';
	return null;*/
?>
<!-- Estilos personalizados módulo -->
<link href="<?= base_url('assets/css/user/modules/solicitud.css?v=1.2') ?>" rel="stylesheet" type="text/css" />
<!-- Funciones personalizadas módulo -->
<script src="<?= base_url('assets/js/functions/solicitud.js?v=1.0') . time() ?>" type="module" ></script>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<!-- Menú de Formularios con Línea de Progreso Horizontal -->
			<div class="col-md-12 formularios">
				<div class="progress-container">
					<div class="sidebar-content">
						<div class="progress-header">
							<a href="#" class="home-link" data-form="inicio" data-id="<?= $solicitud->idSolicitud ?>">
								<h3><i class="fa fa-home mr-2" aria-hidden="true"></i> Proceso de Diligenciamiento </h3>
							</a>
							<!-- Campo oculto para el ID de la solicitud -->
							<input type="hidden" id="id_solicitud" value="<?= $solicitud->idSolicitud ?>">
							<button type="button" class="btn btn-primary btn-sm" id="btn-validar-solicitud" title="Validar Solicitud">
								Validar Solicitud <i class="fa fa-check" aria-hidden="true"></i>
							</button>
						</div>
						<div class="progress-bar-container">
							<div class="progress-bar" style="width: 0%"></div>
						</div>
						<div class="steps-container">
							<!-- Campo oculto para el ID de la solicitud -->
							<!-- Botón form 1 -->
							<div class="step" data-step="1">
								<div class="step-icon" data-form="1" data-form-name="informacion_general">
									<span>1</span>
								</div>
								<div class="step-tooltip">Información General de la Entidad</div>
								<div class="step-label">Información General</div>
							</div>
							<!-- Botón form 2 -->
							<div class="step" data-step="2">
								<div class="step-icon" data-form="2" data-form-name="documentacion_legal">
									<span>2</span>
								</div>
								<div class="step-tooltip">Documentación Legal</div>
								<div class="step-label">Documentación Legal</div>
							</div>
							<!-- Botón form 3 -->
							<div class="step" data-step="3">
								<div class="step-icon" data-form="3" data-form-name="jornadas_actualizacion">
									<span>3</span>
								</div>
								<div class="step-tooltip">Jornadas de Actualización</div>
								<div class="step-label">Jornadas de Actualización</div>
							</div>
							<!-- Botón form 4 -->
							<div class="step" data-step="4">
								<div class="step-icon" data-form="4" data-form-name="programas">
									<span>4</span>
								</div>
								<div class="step-tooltip">Programa organizaciones y redes SEAS.</div>
								<div class="step-label">Programa organizaciones</div>
							</div>
							<!-- Botón form 5 -->
							<div class="step" data-step="5">
								<div class="step-icon" data-form="5" data-form-name="equipo_docente">
									<span>5</span>
								</div>
								<div class="step-tooltip">Equipo de Facilitadores</div>
								<div class="step-label">Equipo de Facilitadores</div>
							</div>
							<!-- Botón form 6 -->
							<!--<div class="step" data-step="6" id="itemPlataforma">
								<div class="step-icon" data-form="6" data-form-name="plataforma">
									<span>6</span>
								</div>
								<div class="step-tooltip">Datos modalidad virtual</div>
								<div class="step-label">Modalidad virtual</div>
							</div>-->
							<!-- Botón form 6 Modalidades -->
							<div class="step" data-step="6" id="itemEnLinea">
								<div class="step-icon" data-form="6" data-form-name="modalidades">
									<span>6</span>
								</div>
								<div class="step-tooltip">Datos modalidades</div>
								<div class="step-label">Modalidades</div>
							</div>
							<!-- Botón finalizar proceso -->
							<!-- Se restringe para perfil de visualización -->
							<?php if ($nivel != '7'): ?>
								<div class="step" data-step="8" id="act_datos_sol_org">
									<div class="step-icon" data-form="100" data-form-name="finalizar_proceso">
										<i class="fa fa-check" aria-hidden="true"></i>
									</div>
									<div class="step-tooltip">Finalizar Proceso</div>
									<div class="step-label">Finalizar Proceso</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<button class="hide-menu-btn" id="hide-sidevar" title="Ocultar Menú">
						<i class="fa fa-times" aria-hidden="true"></i>
						<v>OCULTAR MENÚ</v>
					</button>
				</div>
			</div>
			<!-- Contenedor para notificaciones -->
			<div class="col-md-12">
				<div id="notification-container"></div>
			</div>
			<!-- Contenedor principal para los formularios -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div id="main-content">
							<!-- Aquí se cargarán los formularios dinámicamente -->
							<div class="text-center p-5">
								<i class="fa fa-spinner fa-spin fa-3x"></i>
								<p class="mt-3">Cargando formulario...</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="formulariosFaltantes" style="display: none"></div>
	</div>
</div>
</div>
