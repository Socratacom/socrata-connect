<header class="banner">	

	<nav class="hidden-xs hidden-sm">
  		<a class="logo header-logo" href="<?php echo home_url('/'); ?>"></a>
		<ul class="header-nav">
			<<li>
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Agenda <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
					<li><a href="/agenda">Agenda Overview</a></li>
					<li><a href="/agenda/general">General Sessions</a></li>
					<li><a href="/agenda/data-camp">Data Camp</a></li>
					<li><a href="/agenda/education">Education &amp; Training</a></li>
					</ul>
				</div>
			</li>
			<li><a href="#" class="btn btn-default">Speakers</a></li>
			<li><a href="/registration" class="btn btn-primary">Register Today</a></li>
		</ul>  	
  	</nav>

  	<nav class="hidden-md hidden-lg">
  		<a class="logo header-logo" href="<?php echo home_url('/'); ?>"></a>
	  	<button id="showRight" type="button" class="hamburger collapsed" data-toggle="collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="ui-menu__content">
				<i class="ui-menu__line ui-menu__line_1"></i>
				<i class="ui-menu__line ui-menu__line_2"></i>
				<i class="ui-menu__line ui-menu__line_3"></i>
			</span>
		</button>
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="side-panel">
			<a href="/registration" class="btn btn-default btn-block margin-bottom-30">Register Today</a>
			<?php wp_nav_menu( array( 'theme_location' => 'mobile_navigation','container' => '','menu_class' => 'side-panel-menu' ) ); ?>
		</div>
	</nav>

</header>