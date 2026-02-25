<?php

/***
 * @var $activeLink
 * @var $organizacion
 */
/*echo "<pre>";
var_dump($organizacion);
die();
echo "</pre>";*/
?>
<!-- Dashboard -->
<li class="nav-item <?php if ($activeLink == 'dashboard') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('organizacion/panel') ?>">
		<i class="ti-home menu-icon"></i>
		<span class="menu-title">Panel principal</span>
	</a>
</li>
<!-- Solicitudes -->
<li class="nav-item <?php if ($activeLink == 'solicitudes') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('organizacion/solicitudes') ?>">
		<i class="icon-layout menu-icon"></i>
		<span class="menu-title">Solicitudes</span>
	</a>
</li>
<!-- Facilitadores -->
<li class="nav-item <?php if ($activeLink == 'facilitadores') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('organizacion/facilitadores') ?>">
		<i class="mdi mdi-account-group menu-icon"></i>
		<span class="menu-title">Facilitadores</span>
	</a>
</li>
<!-- Perfil -->
<li class="nav-item <?php if ($activeLink == 'perfil') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('organizacion/perfil') ?>">
		<i class="ti-user menu-icon"></i>
		<span class="menu-title">Perfil Organización</span>
	</a>
</li>
<!-- Informe de Actividades -->
<?php if ($organizacion->estado == "Acreditado"): ?>
	<li class="nav-item <?php if ($activeLink == 'informe-actividades') echo 'active'; ?>">
		<a class="nav-link" href="<?= site_url('organizacion/informe-actividades') ?>">
			<i class="ti-book menu-icon"></i>
			<span class="menu-title">Informe de Actividades</span>
		</a>
	</li>
<?php endif; ?>
<!-- Ayuda -->
<li class="nav-item <?php if ($activeLink == 'ayuda') echo 'active'; ?>">
	<a class="nav-link" href="<?= site_url('organizacion/ayuda') ?>">
		<i class="icon-help menu-icon"></i>
		<span class="menu-title">Ayuda</span>
	</a>
</li>
