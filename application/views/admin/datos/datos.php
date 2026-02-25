<div class="container">
	<div class="clearfix"></div>
	<hr/>
</div>
<div id="panel_socrata" class="col-md-5 center-block">
	<div class="form-group">
		<p>Puede consultar el conjunto de datos en datos abiertos dando <a target="_blank" href="https://www.datos.gov.co/Trabajo/Organizaciones-Entidades-Aplicaci-n-SIIA-Acreditad/2tsa-2de2">clic aqui</a>.</p>
		<button class="btn btn-siia form-control" id="act_datos_abiertos">Actualizar datos abiertos</button>
		<img src="<?php echo base_url(); ?>assets/img/loading.gif" id="loading" class="img-responsive col-md-2">
	</div>
	<div class="form-group">
		<button class="btn btn-info form-control" id="consultar_datos_abiertos">Consultar datos abiertos</button>
	</div>
	<button class="btn btn-danger btn-sm pull-left" id="admin_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
</div>
<div class="col-md-12" id="tabla_d_a">
<hr/>
	<table id="tabla_datos_s_org" width="100%" border=0 class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>NOMBRE DE LA ENTIDAD</td>
				<td>NÚMERO NIT</td>
				<td>SIGLA DE LA ENTIDAD</td>
				<td>ESTADO ACTUAL DE LA ENTIDAD</td>
				<td>FECHA CAMBIO DE ESTADO</td>
				<td>TIPO DE ENTIDAD</td>
				<td>DIRECCIÓN DE LA ENTIDAD</td>
				<td>DEPARTAMENTO DE LA ENTIDAD</td>
				<td>MUNICIPIO DE LA ENTIDAD</td>
				<td>TELÉFONO DE LA ENTIDAD</td>
				<td>EXTENSIÓN</td>
				<td>URL DE LA ENTIDAD</td>
				<td>ACTUACIÓN DE LA ENTIDAD</td>
				<td>TIPO DE EDUCACIÓN DE LA ENTIDAD</td>
				<td>PRIMER NOMBRE REPRESENTANTE LEGAL</td>
				<td>SEGUNDO NOMBRE REPRESENTANTE LEGAL</td>
				<td>PRIMER APELLIDO REPRESENTANTE LEGAL</td>
				<td>SEGUNDO APELLIDO REPRESENTANTE LEGAL</td>
				<td>NÚMERO CEDULA REPRESENTANTE LEGAL</td>
				<td>CORREO ELECTRÓNICO ENTIDAD</td>
				<td>CORREO ELECTRÓNICO REPRESENTANTE LEGAL</td>
				<td>NÙMERO DE LA RESOLUCIÒN</td>
				<td>FECHA DE INICIO DE LA RESOLUCIÒN</td>
				<td>AÑOS DE LA RESOLUCIÒN</td>
				<td>TIPO DE SOLICITUD</td>
				<td>MOTIVO DE LA SOLICITUD</td>
				<td>MODALIDAD DE LA SOLICITUD</td>
			</tr>
		</thead>
		<tbody id="tbody_d_socrata">
		</tbody>
	</table>
</div>