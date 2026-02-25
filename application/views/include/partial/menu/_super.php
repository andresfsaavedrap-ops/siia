<?php

/***
 * @var $activeLink
 */
?>
<!-- Dashboard -->
<li class="nav-item <?php if ($activeLink == 'dashboard') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/panel') ?>">
		<i class="ti-home menu-icon"></i>
		<span class="menu-title">Panel principal</span>
	</a>
</li>
<!-- Administradores -->
<li class="nav-item <?php if ($activeLink == 'administradores') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/administradores') ?>">
		<i class="ti-user menu-icon"></i>
		<span class="menu-title">Administradores</span>
	</a>
</li>
<!-- Usuarios -->
<li class="nav-item <?php if ($activeLink == 'usuarios') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/usuarios') ?>">
		<i class="icon-head menu-icon"></i>
		<span class="menu-title">Usuarios</span>
	</a>
</li>
<!-- Correos -->
<li class="nav-item <?php if ($activeLink == 'correos') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/correos') ?>">
		<i class="icon-mail menu-icon"></i>
		<span class="menu-title">Registro de correos</span>
	</a>
</li>
<!-- Solicitudes -->
<li class="nav-item <?php if ($activeLink == 'solicitudes') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/solicitudes') ?>">
		<i class="icon-book menu-icon"></i>
		<span class="menu-title">Solicitudes</span>
	</a>
</li>
<!-- Resoluciones -->
<li class="nav-item <?php if ($activeLink == 'resoluciones') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('super/resoluciones') ?>">
		<i class="icon-folder menu-icon"></i>
		<span class="menu-title">Resoluciones</span>
	</a>
</li>
