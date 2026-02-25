<!-- Menú flotante de observaciones -->
<div class="floating-menu-container dropdown dropup" id="floatingObservacionesContainer">
    <button class="btn btn-warning btn-rounded px-3 py-2" id="floatingObservacionesToggle" title="Batería de Observaciones"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-clipboard"></i>
        <i id="floatingObservacionesChevron" class="fa fa-chevron-up ml-1"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right shadow-lg" id="floatingObservacionesPanel" aria-labelledby="floatingObservacionesToggle">
        <h6 class="dropdown-header">
            <i class="fa fa-clipboard mr-2"></i>
            Batería de Observaciones
        </h6>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesGenerales">
            <span><i class="fa fa-list mr-2"></i>Observaciones Generales</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesInformacion">
            <span><i class="fa fa-info-circle mr-2"></i>Información General</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesDocumentacion">
            <span><i class="fa fa-file-text mr-2"></i>Documentación Legal</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesJornadas">
            <span><i class="fa fa-graduation-cap mr-2"></i>Jornadas de Actualización</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesProgramas">
            <span><i class="fa fa-book mr-2"></i>Programas Básicos</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesFacilitadores">
            <span><i class="fa fa-users mr-2"></i>Facilitadores</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verObservacionesModalidades">
            <span><i class="fa fa-th-large mr-2"></i>Modalidades</span>
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="crearNuevaObservacion">
            <span><i class="fa fa-plus mr-2"></i>Crear Nueva Observación</span>
            <i class="fa fa-plus-circle text-success"></i>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="exportarObservaciones">
            <span><i class="fa fa-download mr-2"></i>Exportar Observaciones</span>
            <i class="fa fa-file-excel-o text-info"></i>
        </a>
    </div>
</div>

