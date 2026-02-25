<div class="col-md-12" id="admin_ver_finalizadas">
<div class="clearfix"></div>
<hr/>
	<h4>Observaciones:</h4>
	<br/>
	<div class="table">
	<table id="tabla_enProceso_organizacion" width="100%" border=0 class="table table-striped table-bordered tabla_form">
		<thead>
			<tr>
				<td class="col-md-3">Formulario</td>
				<td class="col-md-1">Campo de formulario</td>
				<td class="col-md-6">Observación del campo</td>
				<td class="col-md-2">Valor del usuario</td>
				<td class="col-md-1">Fecha de Observacion</td>
				<td class="col-md-1">Número de Revision</td>
				<td class="col-md-1">Id de Solicitud</td>
			</tr>
		</thead>
		<tbody id="tbody">
		<?php 
			foreach ($observaciones as $observacion) {
				switch($observacion->valueForm) {
						case "informacionGeneral":
	        				$formulario = "Formulario 1. Informacion general";
					    break;
					  	case "documentacionLegal":
	        				$formulario = "Formulario 2. Documentacion legal";
					    break;
					    case "registroEducativo":
	        				$formulario = "Formulario 3. Registro educativo";
					    break;
					    case "antecedentesAcademicos":
	        				$formulario = "Formulario 4. Antecedentes academicos";
					    break;
					    case "jornadasActualizacion":
	        				$formulario = "Formulario 5. Jornadas actualización";
					    break;
					    case "datosBasicosProgramas":
	        				$formulario = "Formulario 6. Programa básico de economía solidaria";
					    break;
					    case "programasAvalEconomia":
	        				$formulario = "Formulario 7. Prog. de Economía Solidaria con Énfasis en Trabajo Asociado";
					    break;
					    case "programasAvalar":
	        				$formulario = "Formulario 8. Programas";
					    break;
					    case "docentes":
	        				$formulario = "Formulario 9. Facilitadores";
					    break;
					    case "plataforma":
	        				$formulario = "Formulario 10. Plataforma";
					    break;
					}
				echo "<tr><td>$formulario</td>";
				echo "<td>$observacion->keyForm</td>";
				echo "<td>$observacion->idForm</td>";
				echo "<td>$observacion->observacion</td>";
				echo "<td>$observacion->fechaObservacion</td>";
				echo "<td>$observacion->numeroRevision</td>";
				echo "<td>$observacion->idSolicitud</td></tr>";
			}	
		?>
		</tbody>
	</table>
	<button class="btn btn-danger btn-sm pull-left" id="admin_ver_org_volver"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver al panel principal</button>
	</div>
</div>