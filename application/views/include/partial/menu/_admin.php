<?php
/***
 * @var $activeLink
 * @var $nivel
 */
// Función para verificar permisos basada en tu lógica JavaScript
function canAccess($required_levels, $user_level) {
    return in_array($user_level, $required_levels);
}
// Función mejorada para activeLink más específico
function isActiveSection($activeLink, $section_keys) {
    if (is_array($section_keys)) {
        return in_array($activeLink, $section_keys);
    }
    return $activeLink === $section_keys;
}
?>
<!-- Dashboard - Todos los niveles -->
<li class="nav-item <?php if (isActiveSection($activeLink, ['dashboard', 'panel'])) echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/panel');?>">
        <i class="ti-home menu-icon"></i>
        <span class="menu-title">Panel principal</span>
    </a>
</li>
<!-- Tramite - Todos excepto nivel 7 -->
<?php if (canAccess([0,1, 3, 6,8,9,10], $nivel)): ?>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#tramite-menu-collapse"
       aria-expanded="<?= isActiveSection($activeLink, ['tramite','tramite-inscritas','tramite-finalizadas','tramite-evaluacion','tramite-proceso']) ? 'true' : 'false' ?>" 
       aria-controls="tramite-menu-collapse">
        <i class="ti-clipboard menu-icon"></i>
        <span class="menu-title">Tramite</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse <?php if (isActiveSection($activeLink, ['tramite','tramite-inscritas','tramite-finalizadas','tramite-evaluacion','tramite-proceso'])) echo 'show'; ?>" 
         id="tramite-menu-collapse" data-parent="#sidebar">
		<ul class="nav flex-column sub-menu">
            <!-- Inscritas - Niveles que NO son 2,3,5 -->
            <?php if (canAccess([0,1,2,3,4,6,7], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/tramite')?>"
                   class="nav-link <?php if ($activeLink === 'tramite') echo 'active'; ?>">
                   Gestión
                </a>
            </li>
            <?php endif; ?>
            <!-- En Evaluacion - Niveles que NO son 5 -->
            <?php if (canAccess([0,1,4,6], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/tramite/solicitudes/finalizadas')?>"
                   class="nav-link <?php if ($activeLink === 'tramite-en-evaluacion') echo 'active'; ?>">
                   En Evaluación
                </a>
            </li>
            <?php endif; ?>
            <!-- En Proceso - Niveles que NO son 3,5 -->
            <?php if (canAccess([0], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/tramite/solicitudes/proceso')?>"
                   class="nav-link <?php if ($activeLink === 'tramite-en-proceso') echo 'active'; ?>">
                   En Proceso
                </a>
            </li>
            <?php endif; ?>
            <!-- Evaluación -->
            <?php if (canAccess([0,1,4,6], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/tramite/solicitudes/observaciones')?>"
                   class="nav-link <?php if ($activeLink === 'tramite-en-observaciones') echo 'active'; ?>">
                   En Observaciones
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</li>
<?php endif; ?>
<!-- Organizaciones - Todos excepto nivel 7 -->
<?php if (canAccess([0,1,2,3,4,5,6,7,8,9,10], $nivel)): ?>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#organizaciones-menu-collapse"
       aria-expanded="<?= isActiveSection($activeLink, ['organizaciones','organizaciones-inscritas','organizaciones-finalizadas','organizaciones-evaluacion','organizaciones-proceso']) ? 'true' : 'false' ?>" 
       aria-controls="organizaciones-menu-collapse">
        <i class="ti-id-badge menu-icon"></i>
        <span class="menu-title">Organizaciones</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse <?php if (isActiveSection($activeLink, ['organizaciones','organizaciones-inscritas','organizaciones-finalizadas','organizaciones-evaluacion','organizaciones-proceso'])) echo 'show'; ?>" 
         id="organizaciones-menu-collapse" data-parent="#sidebar">
		<ul class="nav flex-column sub-menu">
            <!-- Inscritas - Niveles que NO son 2,3,5 -->
            <?php if (canAccess([0,1,6,8,9,10], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/organizaciones')?>"
                   class="nav-link <?php if ($activeLink === 'organizaciones') echo 'active'; ?>">
                   Gestión
                </a>
            </li>
			<?php endif; ?>
			<?php if (canAccess([0,1,2,3,6,8,9,10], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/organizaciones/inscritas')?>"
                   class="nav-link <?php if ($activeLink === 'organizaciones-inscritas') echo 'active'; ?>">
                   Inscritas
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</li>
<?php endif; ?>
<!-- Docentes - Todos excepto nivel 7 -->
<?php if (canAccess([0,1,2,4,6,7], $nivel)): ?>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#docentes-menu-collapse"
       aria-expanded="<?= isActiveSection($activeLink, ['docentes','docentes-asignaciones','docentes-evaluacion']) ? 'true' : 'false' ?>"
       aria-controls="docentes-menu-collapse">
        <i class="ti-user menu-icon"></i>
        <span class="menu-title">Docentes</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse <?php if (isActiveSection($activeLink, ['docentes','docentes-asignaciones','docentes-evaluacion'])) echo 'show'; ?>"
         id="docentes-menu-collapse" data-parent="#sidebar">
        <ul class="nav flex-column sub-menu">
			<?php if (canAccess([0,1,6,8,9,10], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/docentes')?>"
                   class="nav-link <?php if ($activeLink === 'docentes') echo 'active'; ?>">
                   Panel
                </a>
            </li>
			<?php endif; ?>
            <!-- Inscritas - Niveles que NO son 2,3,5 -->
            <?php if (canAccess([0,1,2,6,7,8,9,10], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/docentes/inscritos')?>"
                   class="nav-link <?php if ($activeLink === 'docentes-inscritos') echo 'active'; ?>">
                   Inscritos
                </a>
            </li>
            <?php endif; ?>
            <!-- Asignaciones - Niveles que NO son 5 -->
            <?php if (canAccess([0,6], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/docentes/asignar')?>"
                   class="nav-link <?php if ($activeLink === 'docentes-asignaciones') echo 'active'; ?>">
                   Asignación
                </a>
            </li>
            <?php endif; ?>
            <!-- Finalizadas - Niveles que NO son 5 -->
            <?php if (canAccess([0,1,6], $nivel)): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/docentes/evaluar')?>"
                   class="nav-link <?php if ($activeLink === 'docentes-evaluacion') echo 'active'; ?>">
                   Evaluación
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</li>
<?php endif; ?>
<!-- Reportes - Niveles: 0,1,2,4,5 (excluye 3,6,7) -->
<?php if (canAccess([0,1,2,4,5,6,8,9,10], $nivel)): ?>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#reportes-menu-collapse"
       aria-expanded="<?= isActiveSection($activeLink, ['reportes', 'reportes-acreditadas', 'actividades-pedagogicas', 'reportes-telefonico']) ? 'true' : 'false' ?>"
       aria-controls="reportes-menu-collapse">
        <i class="icon-folder menu-icon"></i>
        <span class="menu-title">Reportes</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse <?php if (isActiveSection($activeLink, ['reportes', 'reportes-acreditadas', 'actividades-pedagogicas', 'reportes-telefonico'])) echo 'show';?>"
         id="reportes-menu-collapse" data-parent="#sidebar">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a href="<?= site_url('admin/reportes')?>"
                   class="nav-link <?php if ($activeLink === 'reportes') echo 'active'; ?>">
                   Panel
                </a>
            </li>
			<?php if (canAccess([0,1,2,6], $nivel)): ?>
			<li class="nav-item">
                <a href="<?= site_url('admin/reportes/organizaciones-acreditadas');?>"
                   class="nav-link <?php if ($activeLink === 'reportes-acreditadas') echo 'active'; ?>">
                   Acreditadas
                </a>
			</li>
            <li class="nav-item">
                <a href="<?= site_url('admin/reportes/actividades-pedagogicas');?>"
                   class="nav-link <?php if ($activeLink === 'actividades-pedagogicas') echo 'active'; ?>">
                   Act. Pedagógicas
                </a>
            </li>
			<li class="nav-item">
                <a href="<?= site_url('admin/reportes/actividades-pedagogicas');?>"
                   class="nav-link <?php if ($activeLink === 'actividades-pedagogicas') echo 'active'; ?>">
                   Encuesta
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/reportes/registros-telefonicos');?>"
                   class="nav-link <?php if ($activeLink === 'reportes-telefonico') echo 'active'; ?>">
                   Telefónico
                </a>
            </li>
        </ul>
    </div>
</li>
<?php endif; ?>
<!-- Histórico - Niveles 0,4,5 -->
<?php if (canAccess([0,4,5], $nivel)): ?>
<li class="nav-item <?php if ($activeLink === 'historico') echo 'active'; ?>">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Históricos">
        <i class="ti-time menu-icon"></i>
        <span class="menu-title">Histórico</span>
    </a>
</li>
<?php endif; ?>
<!-- Seguimientos - Niveles 0,5 -->
<?php if (canAccess([0,5], $nivel)): ?>
<li class="nav-item <?php if ($activeLink === 'seguimientos') echo 'active'; ?>">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Seguimientos">
        <i class="ti-thumb-up menu-icon"></i>
        <span class="menu-title">Seguimientos</span>
    </a>
</li>
<?php endif; ?>
<!-- Resoluciones del Sistema - Solo nivel 0 -->
<?php if (canAccess([0,1,6], $nivel)): ?>
<li class="nav-item <?php if (isActiveSection($activeLink, ['resoluciones'])) echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/resoluciones')?>">
        <i class="ti-bookmark-alt menu-icon"></i>
        <span class="menu-title">Resoluciones</span>
    </a>
</li>
<?php endif; ?>
<!-- Operaciones del Sistema - Solo nivel 0 -->
<?php if (canAccess([0,1,6], $nivel)): ?>
<li class="nav-item <?php if (isActiveSection($activeLink, ['operaciones', 'nit-entidades'])) echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/operaciones')?>">
        <i class="ti-settings menu-icon"></i>
        <span class="menu-title">Operaciones</span>
    </a>
</li>
<?php endif; ?>
<!-- Datos Abiertos - Niveles 0,6 -->
<?php if (canAccess([0], $nivel)): ?>
<li class="nav-item <?php if ($activeLink === 'datos-abiertos') echo 'active'; ?>">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalProximamente" data-funcionalidad="Datos Abiertos">
        <i class="ti-upload menu-icon"></i>
        <span class="menu-title">Datos Abiertos</span>
    </a>
</li>
<?php endif; ?>
<!-- Contacto - Solo nivel 0 -->
<?php if (canAccess([0,1,6], $nivel)): ?>
<li class="nav-item <?php if ($activeLink === 'contacto') echo 'active'; ?>">
    <a class="nav-link" href="<?= site_url('admin/contacto')?>">
        <i class="ti-email menu-icon"></i>
        <span class="menu-title">Contacto</span>
    </a>
</li>
<?php endif; ?>

