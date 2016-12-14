<?php
if ( is_tax('socrata_agenda_track','data-camp') ) { ?>
	<section class="masthead">
		<div class="text">
			<div class="vertical-center padding-30">
				<h1 class="color-white margin-bottom-0 text-uppercase text-center">Data Camp</h1>
			</div>
		</div>
		<div class="img img-background" style="background-image:url(/wp-content/uploads/data-camp-hero.jpg);"></div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<p class="lead-lg">Socrata Connect not only delivers a healthy dose of inspiration, but also arms you with the practical know-how to bring those ideas to your organization. Data Camp is day 3 of Connect, and is a full agenda of hands-on, small workshop sessions for both executive and technical users. The agenda is fluid and flexible – stop in for just one session, break into self-guided small groups, or network with your peers. The training and ideas you’ll get from Data Camp alone make your trip to Connect well worth your time.</p>
					<p>The Data Camp agenda is still coming together and will certainly have additions and changes. Sign up for individual workshops will open two weeks before the event and stay open through Days 1 and 2 of Connect. Attendance at Data Camp is included in your Socrata Connect general registration.</p>
    <?php
}
elseif ( is_tax('socrata_agenda_track','education') ) { ?>
	<section class="masthead">
		<div class="text">
			<div class="vertical-center padding-30">
				<h1 class="color-white margin-bottom-0 text-uppercase text-center">Education &amp; Training</h1>
			</div>
		</div>
		<div class="img img-background" style="background-image:url(/wp-content/uploads/education-hero.jpg);"></div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<p class="lead-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ullamcorper nulla non metus auctor fringilla. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
    <?php
}
elseif ( is_tax('socrata_agenda_track','general') ) { ?>
	<section class="masthead">
		<div class="text">
			<div class="vertical-center padding-30">
				<h1 class="color-white margin-bottom-0 text-uppercase text-center">General Sessions</h1>
			</div>
		</div>
		<div class="img img-background" style="background-image:url(/wp-content/uploads/general-hero.jpg);"></div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<p class="lead-lg">Donec sed odio dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit. Cras mattis consectetur purus sit amet fermentum.</p>
    <?php
}
elseif ( is_tax('socrata_agenda_track','product') ) { ?>
	<section class="masthead">
		<div class="text">
			<div class="vertical-center padding-30">
				<h1 class="color-white margin-bottom-0 text-uppercase text-center">Product Sessions</h1>
			</div>
		</div>
		<div class="img img-background" style="background-image:url(/wp-content/uploads/product-hero.jpg);"></div>
	</section>
	<section class="section-padding">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<p class="lead-lg">Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis consectetur purus sit amet fermentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>
    <?php
}
?>
					<h4 class="margin-top-60"><?php the_archive_title();?> Sessions</h4>
					<div class="filter-bar background-primary-light padding-15 margin-bottom-30">
						<ul>
							<li><?php echo do_shortcode('[facetwp facet="persona_dropdown"]');?></li>
							<li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row facetwp-template">				

				<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-sm-6 col-md-4 col-lg-3">
				<div class="card border-primary-light margin-bottom-30 padding-15 match-height">
				<h4 class="margin-bottom-15"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
				<p class="margin-bottom-15"><?php echo socrata_agenda_excerpt();?></p>
				<div class="persona"><span>Perfect for:</span> <?php socrata_agenda_the_categories(); ?></div>
				</div>
				</div>
				<?php endwhile; ?>

			</div>
		</div>
	</section>
	<section class="section-padding background-primary-light">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="text-center margin-bottom-15">Register for Socrata Connect</h2>
					<p class="text-center">Join us March 6-8, 2017 at the Gaylord National Resort & Conference Center, Washington, DC</p>
					<div class="text-center margin-top-60"><a href="/registration" class="btn btn-primary btn-lg">Register Today</a></div>
				</div>
			</div>
		</div>
	</section>
	<script>!function(a){a(function(){FWP.loading_handler=function(){}})}(jQuery);</script>