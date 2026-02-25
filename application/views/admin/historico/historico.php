<div class="col-md-12 tablaOrgHist">
	<button class="btn btn-siia pull-right btn-sm" id="verDivAgregarOrgHist">Agregar nueva organización historica <i class="fa fa-plus" aria-hidden="true"></i></button>
	<div class="clearfix"></div>
	<hr/>
	<h3>Organizaciones historicas:</h3>
	<table id="tabla_super_admins" width="100%" border=0 class="table table-striped table-bordered tabla_form">
	<thead>
		<tr>
			<!--<td>Personeria juridica</td>-->
			<td>ID</td>
			<td>Nombres series asuntos</td>
			<td>Nombre organizacion</td>
			<td>NIT</td>
			<td>Sigla</td>
			<td>Representante</td>
			<td>Correo organización</td>
			<td>Regional</td>
			<td>Fecha extrema inicial</td>
			<td>Fecha extrema final</td>
			<td>Caja</td>
			<td>Carpeta</td>
			<td>Tomo</td>
			<td>Otros</td>
			<td>Numero folios</td>
			<td>Soporte</td>
			<td>Observaciones</td>
			<td>Acción</td>
		</tr>
	</thead>
	<tbody id="tbody">
	<?php 
		foreach ($organizacionesHistoricas as $organizacion) {
				if($organizacion->id_historial != NULL){
					//echo "<td>$organizacion->personeriaJuridica</td>";
					echo "<tr><td>$organizacion->id_historial</td>";
					echo "<td>$organizacion->nombresSeriesAsuntos</td>";
					echo "<td>$organizacion->nombreOrganizacion</td>";
					echo "<td>$organizacion->numNIT</td>";
					echo "<td>$organizacion->sigla</td>";
					echo "<td>$organizacion->primerNombreRepLegal $organizacion->primerApellidoRepLegal</td>";
					echo "<td>$organizacion->direccionCorreoElectronicoOrganizacion</td>";
					echo "<td>$organizacion->regional</td>";
					echo "<td>$organizacion->fechaExtremaInicial</td>";
					echo "<td>$organizacion->fechaExtremaFinal</td>";
					echo "<td>$organizacion->caja</td>";
					echo "<td>$organizacion->carpeta</td>";
					echo "<td>$organizacion->tomo</td>";
					echo "<td>$organizacion->otros</td>";
					echo "<td>$organizacion->numeroFolios</td>";
					echo "<td>$organizacion->soporte</td>";
					echo "<td>$organizacion->observaciones</td>";
					echo "<td><button class='btn btn-siia btn-sm verDatosHistoricos' data-toggle='modal' data-id-org='$organizacion->organizaciones_id_organizacion' data-id='$organizacion->id_historial' data-target='#verDatosHistoricos'>Ver datos <i class='fa fa-eye' aria-hidden='true'></i></button> - <button class='btn btn-warning btn-sm verDatosHistoricosLinea' data-id-org='$organizacion->organizaciones_id_organizacion' data-id='$organizacion->id_historial'>Ver linea <i class='fa fa-eye' aria-hidden='true'></i></button></td></tr>";
				
				}
			}
	?>
	</tbody>
	</table>
	<button class="btn btn-danger btn-sm pull-left" id="admin_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
</div>
<div class="container">
	<div class="divAgregarOrgHist">
		<div class="clearfix"></div>
		<hr/>
		<h3>Carpeta / caja:</h3>
		<div class="col-md-4">
			<!--<div class="form-group">
				<label>Personeria Juridica /C.C.:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="personeria" name="" placeholder="Personeria Juridica /C.C.">
			</div>-->
			<div class="form-group">
				<label>Nombres Series o Asuntos:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="nombresSeries" name="" placeholder="Nombres Series o Asuntos">
			</div>
			<div class="form-group">
				<label>¿Regionales?:<span class="spanRojo">*</span></label><br>
				<select name="regional" id="regional" class="selectpicker form-control show-tick" required="">
					<option id="1" value="Si">Si</option>
					<option id="2" value="No" selected>No</option>
				</select>
			</div>
			<div class="form-group">
				<label>Fechas Extremas - Inicial:<span class="spanRojo">*</span></label>
				<input type="date" class="form-control" id="fechaExtremaInicial" name="">
			</div>
			<div class="form-group">
				<label>Fechas Extremas - Final:<span class="spanRojo">*</span></label>
				<input type="date" class="form-control" id="fechaExtremaFinal" name="">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Caja:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="caja" name="" placeholder="Caja">
			</div>
			<div class="form-group">
				<label>Carpeta:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="carpeta" name="" placeholder="Carpeta">
			</div>
			<div class="form-group">
				<label>Tomo:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="tomo" name="" placeholder="Tomo">
			</div>
			<div class="form-group">
				<label>Otro:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" id="otro" name="" placeholder="Otro">
			</div>
			<div class="form-group">
				<label>Número de Folios:<span class="spanRojo">*</span></label>
				<input type="number" class="form-control" id="numeroFolios" name="" placeholder="Número de Folios">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Soporte:<span class="spanRojo">*</span></label><br>
				<select name="soporte" id="soporte" class="selectpicker form-control show-tick" required="">
					<option id="1" value="Papel">Papel</option>
					<option id="2" value="CD/DVD">CD/DVD</option>
				</select>
			</div>
			<div class="form-group">
				<label>Observaciones:<span class="spanRojo">*</span></label>
				<textarea class="form-control" id="observaciones" rows="6" placeholder="Observaciones..."></textarea>
			</div>
		</div>
		<div class="col-md-12">
			<h3>Información de la Organización:</h3>
			<div class="form-group">
				<label for="organizacion">Organizacion:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" form="formulario_historial" name="organizacion" id="organizacion" placeholder="Nombre Organización" required>
			</div>
			<div class="form-group">
				<label for="nit">NIT de la Organización:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" form="formulario_historial" name="nit" id="nit" placeholder="Numero NIT" required>
			</div>
			<div class="form-group">
				<label for="sigla">Sigla de la Organización:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" form="formulario_historial" name="sigla" id="sigla" placeholder="Sigla" required>
			</div>
			<div class="form-group">
				<label for="primer_nombre_rep_legal">Primer Nombre del Representante Legal:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" form="formulario_historial" name="primer_nombre_rep_legal" id="nombre" placeholder="Primer Nombre Representante" required>
			</div>
			<div class="form-group">
				<label for="segundo_nombre_rep_legal">Segundo Nombre del Representante Legal:</label>
				<input type="text" class="form-control" form="formulario_historial" name="segundo_nombre_rep_legal" id="nombre_s" placeholder="Segundo Nombre Representante">
			</div>
			<div class="form-group">
				<label for="primer_apellido_rep_regal">Primer Apellido del Representante Legal:<span class="spanRojo">*</span></label>
				<input type="text" class="form-control" form="formulario_historial" name="primer_apellido_rep_regal" id="apellido" placeholder="Primer Apellido Representante" required>
			</div>
			<div class="form-group">
				<label for="segundo_apellido_rep_regal">Segundo Apellido del Representante Legal:</label>
				<input type="text" class="form-control" form="formulario_historial" name="segundo_apellido_rep_regal" id="apellido_s" placeholder="Segundo Apellido Representante">
			</div>
			<div class="form-group">
				<label for="correo_electronico">Correo Electrónico de Organización:</label>
				<input type="email" class="form-control" form="formulario_historial" name="correo_electronico" id="correo_electronico" placeholder="Correo Electrónico Organización" required>
			</div>
			<div class="form-group">
				<label for="correo_electronico_rep_legal">Correo Electrónico del Representante Legal:</label>
				<input type="email" class="form-control" form="formulario_historial" name="correo_electronico_rep_legal" id="correo_electronico_rep_legal" placeholder="Correo Electrónico Representante Legal" required>
			</div>
		</div>
		<div class="col-md-12">
			<h3>Resolución:</h3>
			<div class="form-group col-md-3">
				<label>Fecha Inicio:</label>
				<input type="date" id="hist_fech_inicio" class="form-control" name="">
			</div>
			<div class="form-group col-md-3">
				<label>Fecha Final:</label>
				<input type="date" id="hist_fech_fin" class="form-control" name="">
			</div>
			<div class="form-group col-md-3">
				<label>Años de la resolución:</label>
				<input type="number" id="hist_anos" class="form-control" name="" placeholder="3">
			</div>
			<div class="form-group col-md-3">
				<label>Número de la resolución:</label>
				<input type="number" id="hist_num_res" class="form-control" name="" placeholder="45">
			</div>
			<div class="clearfix"></div>
			<hr/>
			<label>Adjuntar última resolución:</label>
			<input type="file" class="form-control" form="formulario_resoluciones" name="resolucion" id="resolucion" required accept="application/pdf">
			<br>
			<button class="btn btn-siia btn-sm pull-right" id="guardar_org_historica">Guardar organización <i class="fa fa-check" aria-hidden="true"></i></button>
		</div>
	</div>
</div>
<div class="modal fade" id="verDatosHistoricos" tabindex="-1" role="dialog" aria-labelledby="verdatoshistoricos">
  	<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <h3 class="modal-title" id="verdatoshistoricos">Datos de: <label id="lbl_nombre_org_hist"></label></h3>
		    </div>
		    <div class="modal-body">
		    	<div class="row">
			    	<div class="col-md-12">
			    		<h4>Información de la carpeta:</h4>
			    		<!--<div class="form-group">
					    	<label>Personeria Juridica /C.C.:</label>
					    	<input type="text" class="form-control" id="ver_hist_perso">
				    	</div>-->
				    	<div class="form-group">
					    	<label>Nombres Series o Asuntos:</label>
					    	<input type="text" class="form-control" id="ver_hist_nombres_ser">
				    	</div>
				    	<div class="form-group">
					    	<label>¿Regionales?:</label>
					    	<select name="ver_hist_regional" id="ver_hist_regional" class="selectpicker form-control show-tick" required="">
								<option id="1" value="Si">Si</option>
								<option id="2" value="No" selected>No</option>
							</select>
				    	</div>
				    	<div class="form-group">
					    	<label>Fechas Extremas - Inicial:</label>
					    	<input type="text" class="form-control" id="ver_hist_fech_ei">
				    	</div>
				    	<div class="form-group">
					    	<label>Fechas Extremas - Final:</label>
					    	<input type="text" class="form-control" id="ver_hist_fech_ef">
				    	</div>
				    	<div class="form-group">
					    	<label>Caja:</label>
					    	<input type="text" class="form-control" id="ver_hist_caja">
				    	</div>
				    	<div class="form-group">
					    	<label>Carpeta:</label>
					    	<input type="text" class="form-control" id="ver_hist_carpeta">
				    	</div>
				    	<div class="form-group">
					    	<label>Tomo:</label>
					    	<input type="text" class="form-control" id="ver_hist_tomo">
				    	</div>
				    	<div class="form-group">
					    	<label>Otro:</label>
					    	<input type="text" class="form-control" id="ver_hist_otro">
				    	</div>
				    	<div class="form-group">
					    	<label>Numero de Folios:</label>
					    	<input type="text" class="form-control" id="ver_hist_folios">
				    	</div>
				    	<div class="form-group">
					    	<label>Soporte:</label>
					    	<select name="ver_hist_soporte" id="ver_hist_soporte" class="selectpicker form-control show-tick" required="">
								<option id="1" value="Papel">Papel</option>
								<option id="2" value="CD/DVD">CD/DVD</option>
							</select>
				    	</div>
				    	<div class="form-group">
					    	<label>Observaciones:</label>
					    	<textarea type="text" class="form-control" id="ver_hist_obser" rows="6"></textarea>
				    	</div>
			    	</div>
			    	<div class="clearfix"></div>
			    	<hr/>
			    	<div class="col-md-6">
			    		<h4>Información de la organización:</h4>
			    		<div class="form-group">
					    	<label>Nombre Organización:</label>
					    	<input type="text" class="form-control" name="" id="nombre_org_hist">
				    	</div>
				    	<div class="form-group">
					    	<label>Sigla de la Organización:</label>
					    	<input type="text" class="form-control" name="" id="sigla_org_hist">
				    	</div>
				    	<div class="form-group">
					    	<label>NIT de la Organización:</label>
					    	<input type="text" class="form-control" name="" id="nit_org_hist">
				    	</div>
				    	<div class="form-group">
					    	<label>Dirección de correo de la Organización:</label>
					    	<input type="text" class="form-control" name="" id="direccion_org_org_hist">
				    	</div>
				    	<div class="form-group">
					    	<label>Dirección de correo del representante de la Organización:</label>
					    	<input type="text" class="form-control" name="" id="direccion_rep_org_hist">
				    	</div>
				    	<div class="form-group">
					    	<label>Nombre del representante legal de la Organización:</label>
					    	<input type="text" class="form-control" name="" id="rep_org_hist">
				    	</div>
			    	</div>
			    	<div class="col-md-6">
			    		<div class="form-group">
							<label>Fecha Inicio:</label>
							<input type="date" id="res_fech_inicio" class="form-control" name="">
						</div>
						<div class="form-group">
							<label>Fecha Final:</label>
							<input type="date" id="res_fech_fin" class="form-control" name="">
						</div>
						<div class="form-group">
							<label>Años de la resolución:</label>
							<input type="number" id="res_anos" class="form-control" name="">
						</div>
						<div class="form-group">
							<label>Número de la resolución:</label>
							<input type="number" id="res_num_res" class="form-control" name="" placeholder="45">
						</div>
						<hr/>
						<div class="form-group">
							<label>Adjuntar última resolución:</label>
							<input type="file" class="form-control" form="formulario_resoluciones" name="ver_org_resolucion" id="ver_org_resolucion" required accept="application/pdf">
			    		</div>
			    		<hr/>
			    		<div class="form-group">
							<label>Adjuntar otra resolución:</label>
							<input type="file" class="form-control" form="formulario_resoluciones" name="ver_org_resolucion_otro" id="ver_org_resolucion_otro" required accept="application/pdf">
			    		</div>
			    		<div class="form-group">
					    	<label>Tipo:</label>
					    	<select name="ver_hist_tipo_org" id="ver_hist_tipo_org" class="selectpicker form-control show-tick" required="">
								<option id="0" value="" selected>Seleccione una opción...</option>
								<option id="1" value="Acreditación">Acreditación</option>
								<option id="2" value="Aval">Aval</option>
								<option id="3" value="Acreditación y Aval">Acreditación y Aval</option>
								<option id="4" value="Renovación">Renovación</option>
							</select>
				    	</div>
			    	</div>
			    	<div class="col-md-12">
			    		<hr/>
			    		<h4>Resoluciones:</h4>
			    		<div id="demas_res_hist">
			    			<div id="col-md-2">
			    				<div class="form-group">
					    			<label>Fecha Inicio: <p id="res_fech_i_inicio"></p></label>
								</div>
								<div class="form-group">
									<label>Fecha Fin: <p id="res_fech_f_fin"></p></label>
								</div>
								<div class="form-group">
									<label>Tipo: <p id="res_fech_tipo_hist"></p></label>
								</div>
								<div class="form-group">
							    	<label>Ver resolución:</label>
							    	<a href="" target="_blank" id="verResHist">Ver resolución</a>
						    	</div>
			    			</div>
						</div>
			    	</div>
		    	</div>
		    </div>
		    <div class="modal-footer">
		    	<button type="button" class="btn btn-danger btn-sm pull-left" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>
		    	<button type="button" class="btn btn-siia btn-sm" id="actualizar_hist_org">Actualizar <i class="fa fa-check" aria-hidden="true"></i></button>
		    </div>
    	</div>
  	</div>
</div>
<div class="col-md-12" id="verLineaTiempo">
	<h4>Linea de tiempo:</h4>
	<div id="lineaTiempo" class="timeline-tgt"></div>
</div>
