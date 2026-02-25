import { alertaGuardado } from "../../../partials/alerts-config.js";
import { redirect } from "../../../partials/other-funtions-init.js";
import { getBaseURL } from "../../../config.js";
import { bindHistorialObservacionesClick } from "../../../partials/getObsRequest.js";
const baseURL = getBaseURL();
// Actualizar solicitud
$("#actualizar_solicitud").click(function () {
	redirect(baseURL + "solicitudes/solicitud/" + $(this).attr("data-solicitud"));
});
$(".volver_solicitudes").click(function () {
		redirect(baseURL + "organizacion/solicitudes");
});
// Enlazar el botón de historial de observaciones del usuario
bindHistorialObservacionesClick("#hist_org_obs");
