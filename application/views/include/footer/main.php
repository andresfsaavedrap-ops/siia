<?php

/***
 * @var $logged_in
 * @var $tipo_usuario
 */
?>
<!-- Modals -->
<?php $this->load->view('include/footer/modals'); ?>
<?php if ($logged_in && $tipo_usuario != "none"): ?>
	<footer class="footer">
		<div class="d-sm-flex justify-content-center justify-content-sm-between">
			<span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?= date('Y'); ?> <a href="<?= PAGINA_WEB ?>" target="_blank">Unidad Administrativa Especial Organizaciones Solidarias</a></span>
			<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Sistema Integrado de Información de Acreditación <i class="ti-bookmark-alt text-danger ml-1"></i></span>
		</div>
	</footer>
	<!-- partial -->
	</div>
	<!-- main-panel ends -->
	</div>
<?php endif; ?>
<!-- page-body-wrapper ends -->
</div>
<!-- scripts -->
<div class="hidden" id="scripts-siia">
	<!-- CKEditor -->
	<script src="<?= base_url('assets/js/ckeditor.js') ?>"></script>
	<script src="<?= base_url('assets/js/initck.js') ?>"></script>
	<!-- Script propio -->
	<script src="<?= base_url('assets/js/functions/main.js?v=1.0.8.61219') . time() ?>" type="module"></script>
	<script src="<?= base_url('assets/js/functions/login.js?v=1.0.7.61342') . time() ?>" type="module"></script>
	<script src="<?= base_url('assets/js/functions/super.js?v=1.0.0.1') . time() ?>" type="module"></script>
	<script src="<?= base_url('assets/js/functions/contacto.js?v=1.0.8.61') . time() ?>" type="module"></script>
	<script src="<?= base_url('assets/js/functions/estadisticas.js?v=1.0.8.62') . time() ?>" type="module"></script>
	<script src="<?= base_url('assets/js/functions/encuesta.js?v=1.0.8.62') . time() ?>" type="module"></script>
	<script type="text/javascript">
		$(window).on('load', function() {
			$(".se-pre-con").fadeOut("slow");
		});
	</script>
	<?php if ($logged_in && $tipo_usuario === 'user'): ?>
		<!-- Onboarding con Driver.js (solo usuario tipo 'user') -->
		<script src="<?= base_url('assets/js/functions/user/driver-onboarding.js?v=1.0.0') . time() ?>" type="module"></script>
	<?php endif; ?>
</div>
</body>

</html>
