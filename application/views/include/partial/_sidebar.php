<?php

/***
 * @var $activeLink
 * @var $tipo_usuario
 */

?>
<!-- partial:../../partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<?php
		if ($tipo_usuario == 'super'):
			$this->load->view('include/partial/menu/_super');
		endif;
		if ($tipo_usuario == 'admin'):
			$this->load->view('include/partial/menu/_admin');
		endif;
		if ($tipo_usuario == 'user'):
			$this->load->view('include/partial/menu/_user');
		endif;
		?>
		<!-- Botón de cerrar sesión al final -->
		<!--<li class="nav-item nav-logout">
            <a class="nav-link" style="cursor: pointer;"  id="salir_sesion">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Cerrar Sesión</span>
            </a>
        </li>-->
	</ul>
</nav>
