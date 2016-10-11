<?php
	$bio = rwmb_meta( 'speakers_wysiwyg' );
	$jobtitle = rwmb_meta( 'speakers_title' );
	$company = rwmb_meta( 'speakers_company' );
	$headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=medium' );
  $dick = rwmb_meta( 'agenda_speakers' ); 
?>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>






			</div>
			<div class="col-sm-8">
				<h1 class="margin-bottom-15"><?php the_title(); ?></h1>
				<h3><?php echo $jobtitle;?>, <?php echo $company;?></h3>
				<?php echo $bio;?>		
			</div>
		</div>
	</div>
</section>