<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3 ">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarGuest" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarGuest">
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item <?php if ($activeLink == 'home') {echo 'active';} ?> mr-1">
				<a class="nav-link text-uppercase" href="<?php echo base_url('home'); ?>">Inicio <i class="fa fa-home" aria-hidden="true"></i> <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item <?php if ($activeLink == 'estado') {echo 'active';} ?> mr-1">
				<a class="nav-link text-uppercase" href="<?php echo base_url('estado'); ?>">Estado de la solicitud <i class="fa fa-eye" aria-hidden="true"></i></a>
			</li>
			<li class="nav-item <?php if ($activeLink == 'facilitadores') {echo 'active';} ?> mr-1 ">
				<a class="nav-link text-uppercase" href="<?php echo base_url('facilitadores'); ?>" tabindex="-1" aria-disabled="true">Facilitadores válidos <i class="fa fa-users" aria-hidden="true"></i></a>
			</li>
		</ul>
<!--		<form class="form-inline my-2 my-lg-0">-->
<!--			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
<!--			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
<!--		</form>-->
		<ul class="navbar-nav mt-2 mt-lg-0">
			<li class="nav-item <?php if ($activeLink == 'login') {echo 'active';} ?> mr-1">
				<a class="nav-link text-uppercase" href="<?php echo base_url('login'); ?>">Iniciar sesión <i class="fa fa-sign-in" aria-hidden="true"></i></a>
			</li>
			<li class="nav-item <?php if ($activeLink == 'register'){echo 'active';} ?> mr-1">
				<a class="nav-link text-uppercase" href="<?php echo base_url('registro'); ?>" tabindex="-1" aria-disabled="true">Registrarme <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></a>
			</li>
		</ul>
	</div>
</nav>
