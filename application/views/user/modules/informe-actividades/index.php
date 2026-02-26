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
<!-- Script modulo -->
<script> var informes = '<?= count($informes) ?>';</script>
<script type="module" src="<?= base_url('assets/js/functions/user/modules/informe-actividades/informe-actividades.js?v=1.1') . time() ?>"></script>
<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<!-- Tabla de cursos registrados -->
			<?php $this->load->view('user/modules/informe-actividades/partials/_informes'); ?>
			<?php $this->load->view('user/modules/informe-actividades/partials/_crear_informe'); ?>
		</div>
	</div>
