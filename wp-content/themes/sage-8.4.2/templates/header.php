<header class="banner scroll">
	<nav class="hidden-xs hidden-sm">
  		<a class="logo header-logo" href="<?php echo home_url('/'); ?>"></a>
	    <?php wp_nav_menu( array( 'theme_location' => 'primary_navigation','container' => '') ); ?>
  	</nav>  	
  	<nav class="hidden-md hidden-lg">
  		<a class="logo header-logo" href="<?php echo home_url('/'); ?>"></a>
	  	<button id="showRight" type="button" class="collapsed" data-toggle="collapse" aria-expanded="false">
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