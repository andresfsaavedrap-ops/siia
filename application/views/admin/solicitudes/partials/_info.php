<div class="info-panel fade-in">
    <div class="info-header">
        <h3><i class="mdi mdi-information-outline"></i>Información de la Solicitud</h3>
        <div class="info-toggle-buttons">
            <button id="desplInfoOrg" class="info-toggle-btn">
                <i class="mdi mdi-chevron-down"></i> Mostrar
            </button>
            <button id="plegInfoOrg" class="info-toggle-btn" style="display: none;">
                <i class="mdi mdi-chevron-up"></i> Ocultar
            </button>
        </div>
    </div>
    <div id="verInfoOrg" class="info-content">
        <div class="info-grid">
            <!-- Sección 1: Datos de la Organización -->
            <div class="info-section">
                <h4><i class="mdi mdi-domain"></i> Datos de la Organización</h4>
                <div class="info-field">
                    <label>Nombre de la organización:</label>
                    <span class="tipoLeer" id='nOrgSol'></span>
                </div>
                <div class="info-field">
                    <label>Sigla:</label>
                    <span class="tipoLeer" id='sOrgSol'></span>
                </div>
                <div class="info-field">
                    <label>Número NIT:</label>
                    <span class="tipoLeer" id='nitOrgSol'></span>
                </div>
                <div class="info-field">
                    <label>Nombre del representante:</label>
                    <span class="tipoLeer" id='nrOrgSol'></span>
                </div>
                <div class="info-field">
                    <label>Correo de la organización:</label>
                    <span class="tipoLeer" id='cOrgSol'></span>
                </div>
                <div class="info-field">
                    <label>Correo del representante legal:</label>
                    <span class="tipoLeer" id='cRepOrgSol'></span>
                </div>
				 <div class="info-field">
                    <label>Teléfono de la organización:</label>
                    <span class="tipoLeer" id='telOrgSol'></span>
                </div>
            </div>

            <!-- Sección 2: Datos de la Solicitud -->
            <div class="info-section">
                <h4><i class="mdi mdi-file-document-outline"></i> Datos de la Solicitud</h4>
                <div class="info-field">
                    <label>Fecha de creación:</label>
                    <span class="tipoLeer" id='fechaSol'></span>
                </div>
                <div class="info-field">
                    <label>Fecha de finalización:</label>
                    <span class="tipoLeer" id='revFechaFin'></span>
                </div>
                <div class="info-field">
                    <label>ID de la solicitud:</label>
                    <span class="tipoLeer" id='idSol'></span>
                </div>
                <div class="info-field">
                    <label>Tipo de solicitud:</label>
                    <span class="tipoLeer" id='tipoSol'></span>
                </div>
                <div class="info-field">
                    <label>Modalidad de la solicitud:</label>
                    <span class="tipoLeer" id='modSol'></span>
                </div>
                <div class="info-field">
                    <label>Motivo de la solicitud:</label>
                    <textarea class="tipoLeer" id='motSol' readonly></textarea>
                </div>
            </div>

            <!-- Sección 3: Datos de Seguimiento -->
            <div class="info-section">
                <h4><i class="mdi mdi-clock-outline"></i> Seguimiento y Estado</h4>
                <div class="info-field">
                    <label>Fecha de última actualización:</label>
                    <span class="tipoLeer" id='revFechaUltimaActualizacion'></span>
                </div>
                <div class="info-field">
                    <label>Número de solicitud:</label>
                    <span class="tipoLeer" id='numeroSol'></span>
                </div>
                <div class="info-field">
                    <label>Revisión #:</label>
                    <span class="tipoLeer" id='revSol'></span>
                </div>
                <div class="info-field">
                    <label>Fecha de última revisión:</label>
                    <span class="tipoLeer" id='revFechaSol'></span>
                </div>
                <div class="info-field">
                    <label>Estado de la organización:</label>
                    <span class="tipoLeer" id='estOrg'></span>
                </div>
                <div class="info-field">
                    <label>Asignada por:</label>
                    <span class="tipoLeer" id='asignada_por'></span>
                </div>
                <div class="info-field">
                    <label>Fecha de asignación:</label>
                    <span class="tipoLeer" id='fechaAsignacion'></span>
                </div>
                <div class="info-field">
                    <label>Cámara de comercio:</label>
                    <a href="" id="camaraComercio_org" target="_blank" class="info-btn info-btn-info">
                        <i class="mdi mdi-file-pdf-box"></i> Ver documento
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="info-actions">
        <a href="<?= base_url('admin/tramite/solicitudes/finalizadas') ?>" class="info-btn info-btn-danger">
            <i class="mdi mdi-arrow-left"></i> Volver al panel principal
        </a>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="info-btn info-btn-warning" id="verRelacionCambios" data-toggle='modal' data-target='#modalRelacionCambios'>
                <i class="mdi mdi-eye"></i> Ver relación de cambios
            </button>
            <button class="info-btn info-btn-info" id="solicitarCamara">
                <i class="mdi mdi-refresh"></i> Solicitar cámara de comercio
            </button>
            <button class="info-btn info-btn-primary verHistObsUs" id="hist_org_obs" data-backdrop="false" data-toggle='modal' data-target='#verHistObsUs'>
                <i class="mdi mdi-history"></i> Historial de observaciones
            </button>
        </div>
    </div>
</div>
