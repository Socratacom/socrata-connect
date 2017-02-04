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
			<div class="col-sm-10 col-sm-offset-1">
                <ul class="speaker-meta">
                    <li class="match-height">
                        <?php foreach ( $headshot as $image ) { ?> <div class="headshot" style="background-image:url(<?php echo $image['url']; ?>);"></div> <?php } ?>
                    </li>
                    <li class="name match-height">
                        <h1 class="margin-bottom-15"><?php the_title(); ?></h1>
                        <h3><?php echo $jobtitle;?>, <?php echo $company;?></h3>
                    </li>
                </ul>
				<?php echo $bio;?>		
			</div>
		</div>
	</div>
</section>
<?php echo do_shortcode('[match-height class="match-height"]');?>