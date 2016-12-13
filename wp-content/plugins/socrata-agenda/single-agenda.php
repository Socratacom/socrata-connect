<?php 
$speakers = rwmb_meta( 'agenda_speakers' );
$content = rwmb_meta( 'agenda_wysiwyg' );
?>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">

				<h1><?php the_title();?></h1>
				<div class="margin-bottom-60"><?php echo do_shortcode('[addthis]');?></div>
				<?php echo $content;?>

<!--<ul>
<?php foreach ( $speakers as $speaker ) { ?> 
<li><a href="<?php echo get_the_permalink($speaker); ?>"><?php echo get_the_title($speaker); ?></a></li>
<?php } ?>
</ul> -->

			</div>
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