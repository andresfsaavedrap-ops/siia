<?php

/***
 * @var $logged_in
 * @var $tipo_usuario
 */
if ($logged_in == FALSE && $tipo_usuario == "none"): ?>
	<script src="<?= base_url('assets/js/functions/user/register.js?v=1.0.0.1') . time() ?>" type="module"></script>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-center auth px-0 admin-login">
				<div class="row w-100 mx-0">
					<div class="col-lg-10 col-sm-12 mx-auto">
						<div class="auth-form-light text-left py-5 px-4 px-sm-5 bordered">
							<div class="brand-logo">
								<a href="<?= base_url() ?>"><img src="<?= base_url('assets/img/siia_logo.png') ?>" alt="logo"></a>
								<hr>
								<h3 class=""> Formulario de registro organizaciones</h3>
								<hr>
							</div>
							<?= form_open('', array('id' => 'formulario_registro', 'class' => 'pt-3')); ?>
							<div class="row">
								<!-- Información de la organización -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<h4>Información básica de la organización:</h4><small class="pull-right"><span class="spanRojo">*</span>Campos requeridos</small>
									<hr>
									<div class="col-12 mb-2">
										<label for="organizacion">Nombre de la organización: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="organizacion" id="organizacion" placeholder="Nombre de la organización..." required="" autofocus onkeyup="mayus(this);" value="<?php echo  set_value('organizacion');  ?>">
									</div>
									<div class="col-12 mb-2">
										<label for="nit">NIT de la organización (sin puntos + dígito de verificación):
											<span class="spanRojo">*</span>
										</label>
										<div class="input-group">
											<input type="number" class="form-control" form="formulario_registro" name="nit" id="nit"
												placeholder="Número de NIT" required maxlength="10" minlength="3"
												oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
											<span class="input-group-text">-</span>
											<input type="number" class="form-control" form="formulario_registro" name="nit_digito" id="nit_digito"
												placeholder="Dígito de verificación" required maxlength="1" minlength="1"
												oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
										</div>
									</div>
									<div class="col-12 mb-2">
										<label for="sigla">Sigla de la organización: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="sigla" id="sigla" placeholder="Sigla de la organización..." required="" onkeyup="mayus(this);">
									</div>
									<div class="col-12 mb-2">
										<label for="primer_nombre_rep_legal">Primer nombre del representante legal: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="primer_nombre_rep_legal" id="nombre" placeholder="Primer nombre del representante..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="segundo_nombre_rep_legal">Segundo nombre del representante legal:</label>
										<input type="text" class="form-control" form="formulario_registro" name="segundo_nombre_rep_legal" id="nombre_s" placeholder="Segundo nombre del representante...">
									</div>
									<div class="col-12 mb-2">
										<label for="primer_apellido_rep_regal">Primer apellido del representante legal: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="primer_apellido_rep_regal" id="apellido" placeholder="Primer apellido del representante..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="segundo_apellido_rep_regal">Segundo apellido del representante legal:</label>
										<input type="text" class="form-control" form="formulario_registro" name="segundo_apellido_rep_regal" id="apellido_s" placeholder="Segundo apellido del representante...">
									</div>
									<div class="col-12 mb-2">
										<label for="correo_electronico_rep_legal">Correo electrónico del representante legal: <span class="spanRojo">*</span></label>
										<input type="email" class="form-control" form="formulario_registro" name="correo_electronico_rep_legal" id="correo_electronico_rep_legal" placeholder="Correo electrónico del representante legal..." required="">
									</div>
								</div>
								<!-- Información de la persona encargada del trámite -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<h4>Información de la persona encargada del trámite:</h4><small class="pull-right"><span class="spanRojo">*</span>Campos requerido</small>
									<hr>
									<div class="col-12 mb-2">
										<label for="primer_nombre_persona">Primer nombre: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="primer_nombre_persona" id="nombre_p" placeholder="Primer nombre..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="primer_apellido_persona">Primer apellido: <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="primer_apellido_persona" id="apellido_p" placeholder="Primer apellido..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="correo_electronico">Correo electrónico de organización (Notificaciones): <span class="spanRojo">*</span></label>
										<input type="email" class="form-control" form="formulario_registro" name="correo_electronico" id="correo_electronico" placeholder="Correo electrónico de la organización..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="nombre_usuario">Nombre de usuario (Inicio de sesión): <span class="spanRojo">*</span></label>
										<input type="text" class="form-control" form="formulario_registro" name="nombre_usuario" id="nombre_usuario" placeholder="Nombre de usuario..." required="">
									</div>
									<div class="col-12 mb-2">
										<label for="password">Contraseña: <span class="spanRojo">*</span></label>
										<div class="input-group flex-nowrap">
											<span id="show-pass1" class="mdi mdi-eye input-group-text"></span>
											<input type="password" class="form-control" form="formulario_registro" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required autocomplete="off">
										</div>
										<!-- Barra de progreso de la contraseña -->
										<div class="progress mt-2">
											<div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
										</div>
										<small id="password-strength-text" class="form-text"></small>
										<!-- Contenedor para los mensajes de requisitos -->
										<div id="password-requirements"></div>
									</div>
									<div class="col-12 mb-2">
										<label for="re_password">Repetir contraseña: <span class="spanRojo">*</span></label>
										<div class="input-group flex-nowrap">
											<span id="show-pass2" class="mdi mdi-eye input-group-text" aria-hidden="true"></span>
											<input type="password" class="form-control" form="formulario_registro" name="re_password" id="re_password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" required="" autocomplete="off">
										</div>
									</div>
									<!-- Política de tratamiento de datos -->
									<div class="form-check">
										<input type="checkbox" class="form-check-input" required data-toggle="modal" data-target="#politica_ventana" data-backdrop="static" data-keyboard="false" id="acepto_cond" form="formulario_registro" name="aceptocond" value="* Acepto condiciones y restricciones en SIIA.">
										<label class="form-check-label  text-muted" for="aceptoComActo">
											<span class="underlined">
												¿Acepta la política de tratamiento de la información?
												<span class="spanRojo">*</span>
											</span>
										</label><br>
										<a class="text-primary hover-cursor" data-toggle="modal" data-target="#politica_ventana" data-backdrop="static" data-keyboard="false">
											<span class="spanRojo">*</span>Política de tratamiento de la información
										</a>
									</div>
									<!-- Botón de registro -->
									<div class="mt-3">
										<a class="btn btn-block btn-primary btn-md font-weight-medium" id="confirmaRegistro">
											Registrarse
											<i class="mdi mdi-check-all ml-1" aria-hidden="true"></i>
										</a>
									</div>
								</div>
							</div>
							<?= form_close(); ?>
							<hr>
							<!-- Botón de iniciar sesión -->
							<div class="text-center mt-4 font-weight-light">
								Ya tienes cuenta? <a href="<?= base_url('login') ?>" class="text-primary registrar">Iniciar Sesión</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- Modal Política de Privacidad -->
<div class="modal fade" id="politica_ventana" tabindex="-1" role="dialog" aria-labelledby="politica">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="col-md-12">
					<img alt="logo-unidad-solidaria" id="imagen_header_politicas" class="img-responsive">
				</div>
			</div>
			<div class="modal-body">
				<h4 class="text-center modal-title">POLÍTICA DE PROTECCIÓN DE DATOS PERSONALES DE LA UNIDAD ADMINISTRATIVA ESPECIAL DE ORGANIZACIONES SOLIDARIAS</h4><br>
				<!-- Antecedentes -->
				<h5>I. ANTECEDENTES</h5>
				<p>
					La Ley de Protección de Datos Personales reconoce y protege el derecho que tienen todas las personas a conocer, actualizar y rectificar las informaciones que se hayan recogido sobre ellas en bases de datos o archivos que sean susceptibles de tratamiento por entidades de naturaleza pública o privada.</p>
				<p>
					Al hablar de datos personales nos referimos a toda información asociada a una persona y que permite su identificación, como su documento de identidad, lugar de nacimiento, estado civil, edad, lugar de residencia, trayectoria académica, laboral, o profesional. Existe también información más sensible como su estado de salud, sus características físicas, ideología política, vida sexual, entre otros aspectos.
				</p>
				<p>
					La protección de datos personales tiene un desarrollo constitucional consagrado en el artículo 15 y 20, es así que mediante la Ley 1581 de 2012, en su artículo primero desarrolla este derecho constitucional que tienen todas las personas a conocer, actualizar y rectificar las informaciones que se hayan recogido sobre ellas en bases de datos o archivos, y los demás derechos, libertades y garantías constitucionales a que se refiere el artículo 15 de la Constitución Política; así como el derecho a la información consagrado en el artículo 20 de la misma.
				</p>
				<p>
					La protección de datos son todas las medidas que se toman, tanto a nivel técnico como jurídico, para garantizar que la información de los usuarios de una compañía, entidad o de cualquier base de datos, esté segura de cualquier ataque o intento de acceder a ésta, por parte de personas no autorizadas.
				</p>
				<p>
					En desarrollo y en concordancia con los preceptos legales y constitucionales, la Unidad Administrativa Especial de Organizaciones Solidarias presenta la siguiente Política de Protección de Datos Personales.
				</p><br>
				<h6>PRINCIPIOS DE LA PROTECCIÓN DE DATOS: </h6>
				<p>
					En el desarrollo, interpretación y aplicación de la presente Política, en la Entidad se tendrán en cuenta de manera armónica e integral, los principios que a continuación se establecen:
				</p>
				<!-- Principios de la protección de datos -->
				<ol type="a">
					<li>
						Principio de legalidad en materia de Tratamiento de datos: El tratamiento de datos es una actividad reglada, la cual deberá estar sujeta a las disposiciones legales vigentes y aplicables que rigen el tema.
					</li>
					<li>
						Principio de veracidad o calidad de los registros o datos: La información contenida en los Bancos de Datos debe ser veraz, completa, exacta, actualizada, comprobable y comprensible. Se prohíbe el registro y divulgación de datos parciales, incompletos, fraccionados o que induzcan a error.
					</li>
					<li>
						Principio de finalidad: La administración de datos personales debe obedecer a una finalidad legítima de acuerdo con la Constitución y la ley. La finalidad debe informársele al titular de la información previa o concomitantemente con el otorgamiento de la autorización, cuando ella sea necesaria o en general siempre que el titular solicite información al respecto.
					</li>
					<li>
						Principio de acceso y circulación restringida: La administración de datos personales se sujeta a los límites que se derivan de la naturaleza de los datos, de las disposiciones de la ley y de los principios de la administración de datos personales especialmente de los principios de temporalidad de la información y la finalidad del Banco de Datos. Los datos personales, salvo la información pública, no podrán ser accesibles por Internet o por otros medios de divulgación o comunicación masiva, salvo que el acceso sea técnicamente controlable para brindar un conocimiento restringido sólo a los titulares o los usuarios autorizados conforme a la ley.
					</li>
					<li>
						Principio de temporalidad de la información: La información del titular no podrá ser suministrada a usuarios o terceros cuando deje de servir para la finalidad del Banco de Datos.
					</li>
					<li>
						Principio de interpretación integral de derechos constitucionales: Se interpretará en el sentido de que se amparen adecuadamente los derechos constitucionales, como son el Hábeas Data, el derecho al buen nombre, el derecho a la honra, el derecho a la intimidad y el derecho a la información. Los derechos de los titulares se interpretarán en armonía y en un plano de equilibrio con el derecho a la información previsto en el artículo 20 de la Constitución y con los demás derechos constitucionales aplicables.
					</li>
					<li>
						Principio de seguridad: La información que conforma los registros individuales constitutivos de los Bancos de Datos a que se refiere la ley, así como la resultante de las consultas que de ella hagan sus usuarios, se deberá manejar con las medidas técnicas que sean necesarias para garantizar la seguridad de los registros evitando su adulteración, pérdida, consulta o uso no autorizado.
					</li>
					<li>
						Principio de confidencialidad. Todas las personas naturales o jurídicas que intervengan en la administración de datos personales que no tengan la naturaleza de públicos están obligadas en todo tiempo a garantizar la reserva de la información, inclusive después de finalizada su relación con alguna de las labores que comprende la administración de datos, pudiendo sólo realizar suministro o comunicación de datos cuando ello corresponda al desarrollo de las actividades autorizadas por la ley y en los términos de la misma.
					</li>
					<li>
						Principio de transparencia: En el tratamiento de datos personales, la Entidad garantizará al titular su derecho de obtener en cualquier momento y sin restricciones, información acerca de la existencia de cualquier tipo de información o dato personal que sea de su interés o titularidad.
					</li>
					<li>
						Principio de libertad: el tratamiento de los datos personales sólo puede realizarse con el consentimiento, previo, expreso e informado del titular. Los datos personales no podrán ser obtenidos o divulgados sin previa autorización, o en ausencia de mandato legal, estatutario, o judicial que releve el consentimiento.
					</li>
				</ol>
				<hr />
				<!-- Propósito -->
				<h5>II. PROPÓSITO</h5>
				<p>Suministrar los lineamientos generales para los protección de los datos personales y sensibles a todos los usuarios de la Unidad Administrativa Especial de Organizaciones Solidarias, brindando herramientas que garanticen la autenticidad, integridad y confidencialidad de la información.</p>
				<hr />
				<!-- Definiciones -->
				<h5>III. DEFINICIONES</h5>
				<p>Para los efectos de la presente política y al tenor de la normatividad vigente en materia de protección de datos personales, se tendrán en cuenta las siguientes definiciones: Autorización: Consentimiento previo, expreso e informado del Titular para llevar a cabo el Tratamiento de datos personales.</p>
				<label>Aviso de privacidad:</label>
				<p>Comunicación verbal o escrita generada por el Responsable, dirigida al Titular para el tratamiento de sus datos personales, mediante la cual se le informa acerca de la existencia de las políticas de tratamiento de información que le serán aplicables, la forma de acceder a las mismas y las finalidades del tratamiento que se pretende dar a los datos personales.</p>
				<label>Base de Datos: </label>
				<p>Conjunto organizado de datos personales que sea objeto de tratamiento.</p>
				<label>Causahabiente: </label>
				<p>persona que ha sucedido a otra por causa del fallecimiento de ésta (heredero).</p>
				<label>Dato personal: </label>
				<p>Cualquier información vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables.</p>
				<label>Dato público: </label>
				<p>Es el dato que no sea semiprivado, privado o sensible. Son considerados datos públicos, entre otros, los datos relativos al estado civil de las personas, a su profesión u oficio, a su calidad de comerciante o de servidor público. Por su naturaleza, los datos públicos pueden estar contenidos, entre otros, en registros públicos, documentos públicos, gacetas y boletines oficiales y sentencias judiciales debidamente ejecutoriadas que no estén sometidas a reserva.</p>
				<label>Datos sensibles: </label>
				<p>Se entiende por datos sensibles aquellos que afectan la intimidad del titular o cuyo uso indebido puede generar su discriminación, tales como que revelen el origen racial o étnico, la orientación política, las convicciones religiosas o filosóficas, la pertenencia a sindicatos, organizaciones sociales, de derechos humanos o que promueva intereses de cualquier partido político o que garanticen los derechos y garantías.</p>
				<label>Encargado del Tratamiento: </label>
				<p>Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, realice el Tratamiento de datos personales por cuenta del responsable del tratamiento.</p>
				<label>Responsable del Tratamiento: </label>
				<p>Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, decida sobre la base de datos y/o el tratamiento de los datos.</p>
				<label>Titular: </label>
				<p>Persona natural cuyos datos personales sean objeto de tratamiento.</p>
				<label>Tratamiento: </label>
				<p> Cualquier operación o conjunto de operaciones sobre datos personales, tales como la recolección, almacenamiento, uso, circulación o supresión.</p>
				<label>Transferencia: </label>
				<p>La transferencia de datos tiene lugar cuando el responsable y/o encargado del tratamiento de datos personales, ubicado en Colombia, envía la información o los datos personales a un receptor, que a su vez es responsable del tratamiento y se encuentra dentro o fuera del país.</p>
				<label>Transmisión: </label>
				<p>Tratamiento de datos personales que implica la comunicación de los mismos dentro o fuera del territorio de la República de Colombia cuando tenga por objeto la realización de un tratamiento por el encargado por cuenta del responsable.</p>
				<hr />
				<!-- Declaración -->
				<h5>IV. DECLARACIÓN</h5>
				<p>
					La Entidad reconoce la titularidad que de los datos personales ostentan las personas y en consecuencia ellas de manera exclusiva pueden decidir sobre los mismos. Por lo tanto, La Entidad utilizará los datos personales para el cumplimiento de las finalidades autorizadas expresamente por el titular o por las normas vigentes. En el tratamiento y protección de datos personales, La Entidad tendrá los siguientes deberes, sin perjuicio de otros previstos en las disposiciones que regulen o lleguen a regular esta materia:
				</p>
				<ol type="a">
					<li>Garantizar al titular, en todo tiempo, el pleno y efectivo ejercicio del derecho de hábeas data</li>
					<li>Solicitar y conservar, copia de la respectiva autorización otorgada por el titular para el tratamiento de datos personales.</li>
					<li>Informar debidamente al titular sobre la finalidad de la recolección y los derechos que le asisten en virtud de la autorización otorgada</li>
					<li>Conservar la información bajo las condiciones de seguridad necesarias para impedir su adulteración, pérdida, consulta, uso o acceso no autorizado o fraudulento.</li>
					<li>Garantizar que la información sea veraz, completa, exacta, actualizada, comprobable y comprensible.</li>
					<li>Actualizar oportunamente la información, atendiendo de esta forma todas las novedades respecto de los datos del titular. Adicionalmente, se deberán implementar todas las medidas necesarias para que la información se mantenga actualizada.</li>
					<li>Rectificar la información cuando sea incorrecta y comunicar lo pertinente.</li>
					<li>Respetar las condiciones de seguridad y privacidad de la información del titular</li>
					<li>Tramitar las consultas y reclamos formulados en los términos señalados por la ley</li>
					<li>Identificar cuando determinada información se encuentra en discusión por parte del titular.</li>
					<li>Informar a solicitud del titular sobre el uso dado a sus datos</li>
					<li>Informar a la autoridad de protección de datos cuando se presenten violaciones a los códigos de seguridad y existan riesgos en la administración de la información de los titulares.</li>
					<li>Cumplir los requerimientos e instrucciones que imparta la Superintendencia de Industria y Comercio sobre el tema en particular</li>
					<li>Usar únicamente datos cuyo tratamiento esté previamente autorizado de conformidad con lo previsto en la ley 1581 de 2012.</li>
					<li>Velar por el uso adecuado de los datos personales de los niños, niñas y adolescentes, en aquellos casos en que se entra autorizado el tratamiento de sus datos.</li>
					<li>Registrar en la base de datos las leyenda "reclamo en trámite" en la forma en que se regula en la ley.</li>
					<li>Insertar en la base de datos la leyenda "información en discusión judicial" una vez notificado por parte de la autoridad competente sobre procesos judiciales relacionados con la calidad del dato personal</li>
					<li>Abstenerse de circular información que esté siendo controvertida por el titular y cuyo bloqueo haya sido ordenado por la Superintendencia de Industria y Comercio</li>
					<li>Permitir el acceso a la información únicamente a las personas que pueden tener acceso a ella</li>
					<li>Usar los datos personales del titular sólo para aquellas finalidades para las que se encuentre facultada debidamente y respetando en todo caso la normatividad vigente sobre protección de datos personales.</li>
				</ol>
				<hr />
				<!-- Responsable de implementación -->
				<h5>V. RESPONSABLE DE IMPLEMENTACIÓN</h5>
				<p>Responsable de las bases de datos: Es La Unidad Administrativa Especial de Organizaciones Solidarias a través del área responsable de la información Dirección de Investigaciones y Planeación – Grupo de Planeación y Estadística. El rol del responsable consiste en tomar las decisiones sobre las bases de datos y/o el tratamiento de los datos. Define la finalidad y la forma en que se recolectan, almacenan y administran los datos. Asimismo, está obligado a solicitar y conservar la autorización en la que conste el consentimiento expreso del titular de la información.</p>
				<hr />
				<!-- Procesos involucrados en la implementación -->
				<h5>VI. PROCESOS INVOLUCRADOS EN LA IMPLEMENTACIÓN</h5>
				<p>La presente política será aplicable a los datos personales registrados en cualquier base de datos de La Entidad cuyo titular sea una persona natural.</p>
				<p>La Entidad en todas sus actuaciones incorpora el respeto a la Protección de Datos, dando cumplimiento a cada uno de los principios establecidos en la Ley.</p>
				<p>La Entidad implementará todas las acciones y estrategias necesarias para el efectivo cumplimiento y garantía del Derechoi consagrado en la Ley Estatutaria 1581 de 2012.</p>
				<p>La Entidad dará a conocer a todos sus usuarios los derechos que se derivan de la protección de los datos personales.</p>
				<hr />
				<!-- Indicadores -->
				<h5>VII. INDICADORES</h5>
				<ol>
					<li>Uso de información por personal autorizado.</li>
					<li>Tratamiento de datos personales.</li>
				</ol>
				<hr />
				<!-- Cronograma general de implementación -->
				<h5>VIII. CRONOGRAMA GENERAL DE IMPLEMENTACIÓN</h5>
				<p>El presente documento de política de protección de datos personales entrará en vigencia desde la expedición del acto administrativo que así lo disponga.</p>
				<p>NOTA: El área responsable del tratamiento de los datos personales definirá los funcionarios y colaboradores que accederán a las bases de datos; así como, las contraseñas y procedimientos que sean necesarios. Así mismo, los colaboradores deberán seguir los lineamientos dados por el responsable del tratamiento y las políticas de tratamiento de datos personales de La Unidad.</p>
				<hr />
				<h5>IX. ANEXOS</h5>
				<p>N/A.</p>
				<small><a class="pull-right" title="Recurso de Politica" target="_blank" href="<?php echo PAGINA_WEB ?>sites/default/files/archivos/POLITICA%20PROTECCION%20DE%20DATOS%20V1.pdf">Recurso de la política.</a></small>
			</div>
			<div class="modal-footer justify-content-center">
				<div class="btn-group" role="group" aria-label="Basic mixed styles example">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="declino_politica">
						<i class="mdi mdi-close mr-1"></i>
						No, declino.
					</button>
					<button type="button" class="btn btn-sm btn-success" id="acepto_politica">
						<i class="mdi mdi-check mr-1"></i>
						Sí, acepto.
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Registro - INICIO -->
<div class="modal fade" id="ayuda_registro" tabindex="-1" role="dialog" aria-labelledby="ayudaRegistro">
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		<div class="modal-content border-0 shadow-lg">
			<div class="modal-header bg-primary text-white">
				<h3 class="modal-title font-weight-bold" id="ayudaRegistro">
					<i class="mdi mdi-check-circle mr-2"></i>¿La información ingresada es correcta?
				</h3>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-4">
				<div class="container-fluid" id="informacion_previa">
					<div class="alert alert-info mb-4">
						<i class="mdi mdi-information-outline mr-2"></i>
						Por favor, verifique los correos electrónicos en este momento. Se le notificará cualquier comunicación del sistema por este medio y se enviará un link de activación de la cuenta en el SIIA.
					</div>
					<div class="row">
						<!-- Primera tabla: Datos de la Organización -->
						<div class="col-lg-6 col-md-12 mb-4">
							<div class="card h-100 border-primary">
								<div class="card-header bg-primary text-white">
									<h5 class="mb-0 text-center">
										<i class="mdi mdi-office-building mr-2"></i>Datos de la Organización
									</h5>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-sm mb-0">
											<tbody>
												<tr>
													<td class="bg-light" width="40%"><strong>Organización</strong></td>
													<td id="modalConfOrg"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>NIT</strong></td>
													<td id="modalConfNit"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Sigla</strong></td>
													<td id="modalConfSigla"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- Segunda tabla: Datos del Representante Legal -->
						<div class="col-lg-6 col-md-12 mb-4">
							<div class="card h-100 border-success">
								<div class="card-header bg-success text-white">
									<h5 class="mb-0 text-center">
										<i class="mdi mdi-account-tie mr-2"></i>Datos del Representante Legal
									</h5>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-sm mb-0">
											<tbody>
												<tr>
													<td class="bg-light" width="40%"><strong>Primer nombre</strong></td>
													<td id="modalConfPNRL"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Segundo nombre</strong></td>
													<td id="modalConfSNRL"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Primer apellido</strong></td>
													<td id="modalConfPARL"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Segundo apellido</strong></td>
													<td id="modalConfSARL"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Correo electrónico</strong></td>
													<td id="modalConfCRep"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Tercera tabla: Datos del Usuario (Centrada) -->
					<div class="row justify-content-center mt-2">
						<div class="col-lg-8 col-md-10">
							<div class="card border-info mb-4">
								<div class="card-header bg-info text-white">
									<h5 class="mb-0 text-center">
										<i class="mdi mdi-account-key mr-2"></i>Datos del Usuario
									</h5>
								</div>
								<div class="card-body p-0">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-sm mb-0">
											<tbody>
												<tr>
													<td class="bg-light" width="40%"><strong>Nombre</strong></td>
													<td id="modalConfPn"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Apellido</strong></td>
													<td id="modalConfPa"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Nombre de usuario</strong></td>
													<td id="modalConfNU"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Contraseña</strong></td>
													<td id="modalConfPass"></td>
												</tr>
												<tr>
													<td class="bg-light"><strong>Correo de organización</strong></td>
													<td id="modalConfCOrg"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="form-check d-flex align-items-center mb-4 p-3 border rounded bg-light">
								<input type="checkbox" class="form-check-input mt-0 mr-3" id="aceptoComActo" style="transform: scale(1.2);">
								<label class="form-check-label" for="aceptoComActo">
									Acepto que se envíen comunicaciones, notificaciones y actos administrativos vía correo electrónico a:
									<strong id="modalConfCorreo" class="text-primary"></strong>
									<span class="text-danger">*</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="container" id="reenvio_email">
					<div class="card bg-light border-0 shadow-sm">
						<div class="card-body">
							<div class="d-flex align-items-center mb-3">
								<i class="mdi mdi-email-alert mdi-24px text-warning mr-3"></i>
								<p class="mb-0">
									Si el correo no le llega en los próximos 5 minutos, y no está en la bandeja de spam, por favor, escriba otro correo electrónico (Gmail.com, Outlook.com, Yahoo.com, Hotmail.com), y de click en "Volver a enviar el correo". Si el problema persiste, contáctese con
									<a href="mailto:<?php echo CORREO_ATENCION ?>" class="text-primary"><?php echo CORREO_ATENCION ?></a>
								</p>
							</div>
							<hr class="my-3">
							<div class="form-group mb-0">
								<label for="correo_electronico_rese" class="font-weight-bold">Correo electrónico de organización:<span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="mdi mdi-email input-group-text"></span>
									</div>
									<input type="email" class="form-control" name="correo_electronico_rese" id="correo_electronico_rese" placeholder="Ingrese un correo electrónico alternativo">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<div class="btn-group" role="group" aria-label="seccion-reenvio" style="display: none;" id="seccion-reenvio">
					<button type="button" id="btn-reenvio" class="btn btn-info">
						<i class="mdi mdi-email-send mr-1"></i> Volver a enviar el correo
					</button>
					<button type="button" id="btn-cerrar-reenvio" class="btn btn-danger">
						<i class="mdi mdi-login mr-1"></i> Cerrar e iniciar sesión
					</button>
				</div>
				<div class="btn-group" role="group" aria-label="seccion-guardar" id="seccion-guardar">
					<button type="button" id="btn-cerrar-modal" class="btn btn-outline-secondary" data-dismiss="modal">
						<i class="mdi mdi-arrow-left mr-1"></i> No, voy a verificar
					</button>
					<button type="button" id="guardar_registro" name="registro" disabled="disabled" class="btn btn-success submit">
						<i class="mdi mdi-check-circle mr-1"></i> Sí, Registrarme
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
