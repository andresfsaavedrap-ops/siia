<div class="container">
	<div class="clearfix"></div>
	<hr/>
	<label for="habilitarModal">¿Habilitar modal de información?</label>
	<br/>
   	<div class="input-group">
		<div id="radioBtn" class="btn-group">
			<a class="btn btn-primary btn-sm notActive" data-toggle="habilitarModal" data-title="1">Si, habilitar el modal de información</a>
			<a class="btn btn-primary btn-sm notActive" data-toggle="habilitarModal" data-title="0">No, no habilitar el modal.</a>
		</div>
		<input type="hidden" name="habilitarModal" id="habilitarModal">
	</div>
	<div class="clearfix"></div>
	<hr/>
	<div class="form-group">
		<label>Mensaje informativo:*</label>
		<textarea id="contacto_mensaje_admin" class="form-control" placeholder="Mensaje..."><?php echo $informacionModal; ?></textarea>
	</div>
	<div class="clearfix"></div>
	<hr/>
	<button class="btn btn-sm btn-siia pull-right" id="guardarModalInformacion">Guardar configuración</button>
	<div class="clearfix"></div>
	<a href="<?php echo base_url('panelAdmin/opciones'); ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
</div>