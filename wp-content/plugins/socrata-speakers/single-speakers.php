<?php
	$bio = rwmb_meta( 'speakers_wysiwyg' );
	$jobtitle = rwmb_meta( 'speakers_title' );
	$company = rwmb_meta( 'speakers_company' );
	$headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=medium' );
  $dick = rwmb_meta( 'agenda_speakers' ); 
?>
<section class="section-padding speaker-bio">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 sidebar">
				<?php foreach ( $headshot as $image ) { ?>
        <div class="headshot" style="background-image:url(<?php echo $image['url']; ?>);"></div>
        <?php } ?>
			</div>
			<div class="col-sm-8">
				<h1 class="margin-bottom-15"><?php the_title(); ?></h1>
				<h3><?php echo $jobtitle;?>, <?php echo $company;?></h3>
				<?php echo $bio;?>		
			</div>
		</div>
	</div>
</section>