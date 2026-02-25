<!-- Menú flotante mejorado -->
<div class="floating-menu-container dropdown dropup" id="floatingMenuContainer">
    <button class="btn btn-primary btn-rounded dropdown-toggle px-3 py-2" id="floatingMenuToggle" title="Menú de Formularios"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bars"></i>
        <i id="floatingMenuChevron" class="fa fa-chevron-up ml-1"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right shadow-lg" id="floatingMenuPanel" aria-labelledby="floatingMenuToggle">
        <h6 class="dropdown-header">Menú de evaluación</h6>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verInfGenMenuAdmin">
            <span><span class="menu-num">1</span> Información General</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verDocLegalMenuAdmin">
            <span><span class="menu-num">2</span> Documentación Legal</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verJorActMenuAdmin">
            <span><span class="menu-num">3</span> Jornadas de Actualización</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verProgBasMenuAdmin">
            <span><span class="menu-num">4</span> Datos Básicos de Programas</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verFaciliMenuAdmin">
            <span><span class="menu-num">5</span> Facilitadores</span>
        </a>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="verDatModalidades">
            <span><span class="menu-num">6</span> Modalidades</span>
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item d-flex align-items-center justify-content-between" id="terminar_proceso_observacion">
            <span>Terminar Proceso de Observaciones</span>
            <i class="fa fa-check-circle text-success"></i>
        </a>
    </div>
</div>
