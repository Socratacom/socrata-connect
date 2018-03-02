<?php
$bio = rwmb_meta( 'speakers_wysiwyg' );
$jobtitle = rwmb_meta( 'speakers_title' );
$company = rwmb_meta( 'speakers_company' );
$headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=square' );
?>

<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-10 col-lg-8 m-auto">
				<div class="d-flex flex-row flex-wrap align-items-center mb-5">
					<?php if (!empty($headshot)) { ?> 
					<div class="pr-3">
						<?php foreach ( $headshot as $image ) { ?> <div style="background-image:url(<?php echo $image['url']; ?>); background-repeat: no-repeat; background-size: cover; background-position: center; height:200px; width:200px;"></div> <?php } ?>
					</div>
					<?php } ?>
					<div class="mt-3 mt-sm-0 ">
						<h2><?php the_title(); ?><br><small><?php echo $jobtitle;?>, <?php echo $company;?></small></h2>
					</div>
				</div>
				<?php echo $bio;?>
				<div class="mt-5">
					<a href="/speakers" class="btn btn-secondary">Back to Speakers</a>
				</div>
			</div>
		</div>
	</div>
</section>