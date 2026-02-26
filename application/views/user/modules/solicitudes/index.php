<?php
/***
 * @var $organizacion
 * @var $solicitudes
 * @var $dataInformacionGeneral
 */
$CI = &get_instance();
//$CI->load->model("ResolucionesModel");
?>
<script>
  window.SIIA_TOUR_CONTEXT = 'solicitudes';
</script>
<script src="<?= base_url('assets/js/functions/user/modules/solicitudes/main.js?v=1.0') . time() ?>" type="module"></script>
<!-- Tour del módulo (solo aquí) -->
<!-- <script src="<?= base_url('assets/js/functions/user/driver-solicitudes.js?v=1.0.0') . time() ?>"></script> -->
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<?php $this->load->view('user/modules/solicitudes/partials/_tabla_solicitudes'); ?>
			<?php $this->load->view('user/modules/solicitudes/partials/_formulario_creacion_solicitud'); ?>
		</div>
	</div>
