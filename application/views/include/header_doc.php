<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta http-equiv="refresh" content="7200">
	<meta name="application-name" content="Sistema Integrado de Información de Acreditación - SIIA">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Unidad Solidaria">
	<meta name="revisit-after" content="30 days">
	<meta name="distribution" content="web">
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>" type="image/png">
	<!-- Styles -->
	<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link href="<?php echo base_url('assets/css/styles.css?v=1.0.7.19919') ?>" rel="stylesheet" type="text/css" />
	<!--<link href="<?php echo base_url('assets/fonts/Oswald.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fonts/Oswald300.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fonts/Oswald500.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fonts/CrimsonText.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fonts/CrimsonTextOpenSans400Oswald.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fonts/OpenSans400700.css') ?>" rel="stylesheet" />-->
	<!-- Custom CSS -->
	<link href="<?php echo base_url('assets/css/notifIt.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-select.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/animate.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-dropdownhover.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/mdb.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Scripts -->
	<!-- Styles -->
	<!--<link href="<?php /*echo base_url('assets/fonts/Oswald.css')*/ ?>" rel="stylesheet" />
	<link href="<?php /*echo base_url('assets/fonts/Oswald300.css')*/ ?>" rel="stylesheet" />
	<link href="<?php /*echo base_url('assets/fonts/Oswald500.css')*/ ?>" rel="stylesheet" />
	<link href="<?php /*echo base_url('assets/fonts/CrimsonText.css')*/ ?>" rel="stylesheet" />
	<link href="<?php /*echo base_url('assets/fonts/CrimsonTextOpenSans400Oswald.css')*/ ?>" rel="stylesheet" />
	<link href="<?php /*echo base_url('assets/fonts/OpenSans400700.css')*/ ?>" rel="stylesheet" />-->
	<!--<link href="<?php echo base_url('assets/css/styles.min.css') ?>" rel="stylesheet" type="text/css" />-->
	<link href="<?php echo base_url('assets/css/notifIt.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-select.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/animate.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/bootstrap-dropdownhover.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/mdb.min.css') ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/vis.min.css') ?>" rel="stylesheet" type="text/css" />
	<!-- Scripts -->
	<script src="<?php echo base_url('assets/js/modernizr.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-3.1.1.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/notifIt.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-select.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/langs/selector-i18n/defaults-es_ES.js') ?>" type="text/javascript"></script>
	<!-- Data Tables -->
	<script src="<?php echo base_url('assets/js/popper.min.js') ?>" type="text/javascript"></script>
	<!-- <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script> -->
	<script src="<?php echo base_url('assets/js/jquery.dataTables.nuevo.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/dataTables.buttons.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.html5.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.print.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.flash.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.colVis.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/jszip.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/pdfmake.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/vfs_fonts.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/buttons.bootstrap.min.js') ?>" type="text/javascript"></script>
	<!-- Fin Data Tables -->
	<script src="<?php echo base_url('assets/js/sidebar-menu.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/paging.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-dropdownhover.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/echarts.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/map/js/world.js') ?>"></script>
	<!--<script src="<?php echo base_url('assets/js/mdbs.min.js') ?>"></script>-->
	<script src="<?php echo base_url('assets/js/ckeditor.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/initck.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/vis.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/functions/main.js?v=1.0.8.61219') . time() ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/functions/observaciones.js?v=1.1.1') . time() ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/functions/panel.js?v=1.0.1') . time() ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/functions/solicitud.js?v=1.0.1') . time() ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/functions/contacto.js?v=1.0.8.61') . time() ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/functions/estadisticas.js?v=1.0.8.62') . time() ?>" type="text/javascript"></script>
	<!--<script src="<?php echo base_url('assets/js/script_o.min.js') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/script.js') ?>" type="text/javascript"></script>-->
	<script type="text/javascript">
		$(window).on('load', function() {
			$(".se-pre-con").fadeOut("slow");
		});
	</script>
	<!--Add the following script at the bottom of the web page (immediately before the </body> tag)-->
	<!--<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=49054954"></script>-->
</head>
<title>Docentes</title>
