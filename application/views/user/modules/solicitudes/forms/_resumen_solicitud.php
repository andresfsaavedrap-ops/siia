<?php
/***
 * @var $organizacion
 * @var $municipios
 * @var $departamentos
 * @var $solicitud
 * @var $nivel
 * @var $informacionGeneral
 */
/** echo '<pre>';
var_dump($aplicacion);
echo '</pre>';	
return null; */
?>
<!-- Inicio del Panel de Solicitud -->
<div id="estado_solicitud">
	<div class="card-body">
		<!-- Encabezado de la tarjeta -->
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h3 class="card-title mb-0">
				Datos de la solicitud
				<span class="badge badge-primary ml-2">ID: <?php echo $solicitud->idSolicitud ?></span>
			</h3>
			<button class="btn btn-outline-info btn-sm verHistObsUs" id="hist_org_obs" data-toggle="modal" data-id-solicitud="<?php echo $solicitud->idSolicitud; ?>" data-target="#verHistObsUs">
				<i class="fa fa-history" aria-hidden="true"></i> Historial de observaciones
			</button>
		</div>
		<div class="alert alert-info" role="alert">
			<i class="fa fa-info-circle mr-2"></i>
			Los campos en los formularios marcados con <span class="text-danger font-weight-bold">*</span> son requeridos en la solicitud.
		</div>
		<!-- Información de la solicitud en formato de tabla -->
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<tbody>
				<tr>
					<th class="bg-light" style="width: 30%">Estado de la organización</th>
					<td><?php echo $solicitud->nombre ?></td>
				</tr>
				<tr>
					<th class="bg-light">Tipo de Solicitud</th>
					<td><?php echo $solicitud->tipoSolicitud ?></td>
				</tr>
				<tr>
					<th class="bg-light">Motivo de Solicitud</th>
					<td><?php echo $solicitud->motivoSolicitudAcreditado ?></td>
				</tr>
				<tr>
					<th class="bg-light">Modalidad de Solicitud</th>
					<td><?php echo $solicitud->modalidadSolicitudAcreditado ?></td>
				</tr>
				<tr>
					<th class="bg-light">Estado anterior</th>
					<td><?php echo $solicitud->estadoAnterior ?></td>
				</tr>
				</tbody>
			</table>
		</div>
		<!-- Formularios por completar -->
		<div class="mt-4">
			<h4 class="font-weight-medium">
				<i class="fa fa-tasks mr-2"></i>Formularios por diligenciar
			</h4>
			<div class="card bg-light">
				<div class="card-body">
					<div id="formulariosFaltantes"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Botones de navegación -->
	<?= $this->load->view('user/modules/solicitudes/partials/_botones_navegacion_forms'); ?>
</div>
