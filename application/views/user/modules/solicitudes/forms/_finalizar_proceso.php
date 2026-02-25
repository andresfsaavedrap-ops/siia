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
<!-- Continuar para finalizar Acreditación -->
<div id="finalizar_proceso" data-form="0" class="formulario_panel">
	<div id="verificacion_formularios"></div>
	<h4 class="card-header mb-0">
		<i class="fa fa-flag-checkered mr-2"></i> Finalizar Proceso de Acreditación
	</h4>
	<div class="card-body" id="verificar_btn">
		<div class="row">
			<div class="col-lg-8">
				<div class="d-flex align-items-center mb-4">
					<div class="bg-success text-white rounded-circle p-3 mr-3">
						<i class="fa fa-check fa-2x"></i>
					</div>
					<div>
						<h4 class="font-weight-bold mb-1">¿Desea finalizar el proceso?</h4>
						<p class="text-muted mb-0">Confirmación de envío de solicitud</p>
					</div>
				</div>
				<div class="alert alert-info border-left border-info border-4">
					<p class="mb-0">Si ya adjuntó todos los documentos e información necesaria para la solicitud, haga clic en <strong>"Sí, terminar"</strong> y espere a las observaciones si existen por parte del evaluador.</p>
				</div>
				<div class="mt-4 mb-2">
					<h5 class="text-muted">Antes de finalizar, verifique:</h5>
					<ul class="list-group">
						<li class="list-group-item d-flex align-items-center">
							<i class="fa-solid fa-file-lines text-primary mr-3"></i>
							Todos los formularios están completos
						</li>
						<li class="list-group-item d-flex align-items-center">
							<i class="fa fa-paperclip text-primary mr-3"></i>
							Los documentos requeridos están adjuntos
						</li>
						<li class="list-group-item d-flex align-items-center">
							<i class="fa fa-users text-primary mr-3"></i>
							La información de facilitadores está completa
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-4 d-flex align-items-center justify-content-center">
				<div class="text-center position-relative" style="width: 100%;">
					<!-- Contenedor con posición relativa para posicionar el check encima -->
					<div class="progress" style="height: 350px; position: relative;">
						<div class="progress-bar bg-success d-flex align-items-center justify-content-center"
							 role="progressbar"
							 style="width: 100%; font-weight: bold; font-size: 36px"
							 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
							100%
						</div>
						<!-- Icono de check centrado dentro de la barra -->
						<i class="fa-regular fa-circle-check text-white pb-4"
						   style="position: absolute; left: 50%; top: 30%; transform: translate(-50%, -50%); font-size: 84px;">
						</i>
					</div>
				</div>
			</div>


		</div>
	</div>
	<div class="d-flex justify-content-center gap-2">
		<button class="btn btn-danger mr-2" id="finalizar_no">
			<i class="fa fa-times mr-1"></i> No, voy a verificar
		</button>
		<button class="btn btn-success" id="finalizar_si" data-id="<?php echo $solicitud->idSolicitud ?>">
			<i class="fa fa-check mr-1"></i> Sí, terminar proceso
		</button>
	</div>
</div>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/formularios/terminar_solicitud.js?v=1.2.1') . time() ?>" type="module"></script>
