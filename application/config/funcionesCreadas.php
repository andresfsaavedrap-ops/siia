Panel formulario 2 camara
<div class="form-group">
<?php if($camara->camaraComercio != "" && $camara->camaraComercio != "default.pdf"){ ?>
	<h4>Cámara de comercio: <a target="_blank" href="<?php echo base_url('uploads/camaraComercio/'.$camara->camaraComercio.''); ?>" id="">Ver cámara de comercio</a></h4>
<?php } ?>
</div>