
<div class="center-block mt-4 encuesta" role="main">
	<div class="container">
		<div class="card p-4 mb-4">
			<h3>Encuesta de Satisfacción:</h3>
			<hr />
			<p class="lead">En este espacio puede decirnos qué le ha parecido el proceso de acreditación y en qué podemos mejorar en el Sistema Integrado de Información de Acreditación.</p>
			<p class="lead">Debe diligenciar los campos requeridos y dar clic en enviar. ¡Gracias!</p>

			<div class="form-group mb-3">
				<label for="nitOrg">
					<p>NIT de la organización (con dígito de verificación)</p>
				</label>
				<input type="text" id="nitOrg" class="form-control" placeholder="123456789-0" pattern="^\d{9,10}-\d$" title="Formato: 9-10 dígitos, guion y dígito verificador" required />
				<small class="help-text">Formato obligatorio: 123456789-0</small>
			</div>

			<div class="form-group mb-3">
				<label for="idSolicitudAcreditada">
					<p>Seleccione la solicitud acreditada</p>
				</label>
				<select id="idSolicitudAcreditada" class="form-control" required disabled>
					<option value="">Primero ingrese un NIT válido</option>
				</select>
				<small class="help-text">Se cargan automáticamente las solicitudes acreditadas de la organización.</small>
			</div>
			<!--	<form id="formEncuesta">-->
			<!--	Pregunta 1	-->
			<div class="form-group mb-3">
				<label>
					<p>1. ¿Cómo califica en general el trámite de acreditación? </p>
				</label>
				<div class="form-group">
					<select id="selector-normal" class="form-control calificacion_general" title="Por ejemplo: Excelente">
						<option selected>Elija una opción</option>
						<option value="Excelente">Excelente</option>
						<option value="Acorde a lo esperado">Acorde a lo esperado</option>
						<option value="Puede mejorar">Puede mejorar</option>
					</select>
					<small class="help-text">Seleccione la opción que más se ajuste.</small>
				</div>
			</div>
			<!--	Pregunta 2	-->
			<div class="form-group mb-3">
				<label>
					<p>2. Si su entidad tuvo contacto con el responsable de la evaluación, ¿Cómo califica su atención?</p>
				</label>
				<div class="form-group">
					<select id="selector-normal" class="form-control calificacion_evaluador" title="Por ejemplo: Excelente">
						<option selected>Elija una opción</option>
						<option value="Excelente">Excelente</option>
						<option value="Acorde a lo esperado">Acorde a lo esperado</option>
						<option value="Puede mejorar">Puede mejorar</option>
					</select>
					<small class="help-text">Su percepción nos ayuda a mejorar.</small>
				</div>
			</div>
			<!--	Pregunta 3	-->
			<div class="form-group mb-3">
				<p>3. Déjenos sus comentarios</p>
				<textarea name="comentarios" id="comentario" class="form-control input-govco" placeholder="Escriba sus comentarios aquí..." required></textarea>
			</div>
			<div class="form-group mb-3">
				<!--	Botón de enviar	-->
				<div class="p-2">
					<button class="btn btn-round btn-primary text-capitalize" id="enviarEcuesta">
						Enviar Encuesta
						<span class="govco-icon govco-save-1 small"></span>
					</button>
				</div>
				</form>
				<hr />
			</div>
		</div>
	</div>
</div>
