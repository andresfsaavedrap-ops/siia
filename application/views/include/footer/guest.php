<!-- Footer Content -->
<footer>
	<div class="govco-footer">
		<div class="row govco-portales-contenedor m-0">
			<div class="col-4 govco-footer-logo-portal">
				<div class="govco-logo-container-portal">
					<span class="govco-logo"></span>
					<span class="govco-separator"></span>
					<span class="govco-co"></span>
				</div>
			</div>
			<!-- Datos de Entidad -->
			<div class="col-4 govco-info-datos-portal">
				<div class="govco-separator-rows"></div>
				<div class="govco-texto-datos-portal">
					<p class="govco-text-header-portal-1">
						<?= APP_NAME ?>
					</p>
					<p>Dirección: <br class="govco-mostrar">
						<?= DIR ?> <br class="govco-mostrar">
						Código Postal: xxxx <br> <br class="govco-mostrar">
				</div>
				<div class="govco-network extramt-network">
					<div class="govco-iconContainer">
						<span class="icon-portal govco-twitter-square"></span>
						<span class="govco-link-portal">@Entidad</span>
					</div>
					<div class="govco-iconContainer">
						<span class="icon-portal govco-instagram-square"></span>
						<span class="govco-link-portal">@Entidad</span>
					</div>
					<div class="govco-iconContainer">
						<span class="icon-portal govco-facebook-square"></span>
						<span class="govco-link-portal">@Entidad</span>
					</div>
				</div>
			</div>
			<!-- Datos de contacto -->
			<div class="col-4 govco-info-telefonos">
				<div class="govco-separator-rows"></div>
				<div class="govco-texto-telefonos">
					<p class="govco-text-header-portal-1">
						<span class="govco-phone-alt"></span>
						Contacto
					</p>
					<p>PBX: <?= PBX; ?>
						<br class="govco-mostrar">
						Correo institucional: <br>
						<?= CORREO_SIA ?>
					</p>
				</div>
				<!-- Políticas y otros -->
				<div class="govco-links-portal-container">
					<div class="col-12 m-0 mt-2">
						<a class="govco-link-portal" href="#">Políticas</a>
						<a class="govco-link-portal" href="#">Mapa del sitio</a>
					</div>
					<div class="col-12 m-0 mt-2">
						<a class="govco-link-portal" href="#">Términos y condiciones</a> <br>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<div class="hidden" id="scripts-siia">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- utils.js BDC -->
	<script src="https://cdn.www.gov.co/layout/v4/script.js"></script>
	<!-- js bootstrap -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<!-- Scripts -->
	<script src="<?= base_url('assets/js/jquery.validate.js') ?>" type="text/javascript"></script>
	<!-- Script init -->
	<script type="module"  src="<?= base_url('assets/js/functions/home.js'); ?>"></script>
	<script type="module"  src="<?= base_url('assets/js/functions/facilitadores.js'); ?>"></script>
	<script type="module"  src="<?= base_url('assets/js/functions/encuesta.js?v=1.0') . time() ?>"></script>
	<!--Add the following script at the bottom of the web page (immediately before the </body> tag)-->
	<!--<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=49054954"></script>-->
</div>
</body>
<!-- Volver arriba -->
<!-- Usar Bootstrap 5 -->
<!-- <div class="row">
  <div class="col-md-5"></div>
  <div class="col-md-2 mt-5">
    <button class="volver-arriba-govco ml-5" aria-describedby="descripcionId" aria-label="Volver arriba">
    </button>
    <span class="d-none" id="descripcionId"> Seleccione esta opción como atajo para volver al inicio de esta página. </span>
  </div>
  <div class="col-md-5"></div> -->

</html>
