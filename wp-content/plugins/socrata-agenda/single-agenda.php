<?php 
$jobtitle = rwmb_meta( 'agenda_speakers','',$speaker );
$speakers = rwmb_meta( 'agenda_speakers' );
$content = rwmb_meta( 'agenda_wysiwyg' );
$video = rwmb_meta( 'agenda_video' );
$startTime = rwmb_meta( 'agenda_starttime' );
$start = date('g:i a', strtotime($startTime));
$endTime = rwmb_meta( 'agenda_endtime' );
$end = date('g:i a', strtotime($endTime));
$old_date = rwmb_meta( 'agenda_date' );
$old_date_timestamp = strtotime($old_date);
$new_date = date('l, F j', $old_date_timestamp);   
$slides = rwmb_meta( 'agenda_file' );
?>

<?php if ( ! empty( $video ) ) { ?>
<section class="background-black">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div id="video-player" class="embed-responsive embed-responsive-16by9" data-property="{videoURL:'<?php echo $video;?>',containment:'self',showControls:true,mute:false,autoPlay:true,loop:false,showYTLogo:false,gaTrack:true}"></div>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="margin-bottom-15"><?php the_title();?></h1>
				<p><?php echo $new_date;?> | <?php echo $start;?> - <?php echo $end;?></p>

				<?php if ( ! empty( $slides ) ) { ?> 
					<div class="row margin-bottom-60">
						<div class="col-sm-6">
							<?php echo do_shortcode('[addthis]');?>
						</div>
						<div class="col-sm-6">
							<div class="text-right"><a href="<?php foreach ( $slides as $presentation ) { echo $presentation['url']; } ?>" target="_blank" class="btn btn-primary btn-lg hidden-xs">Download Slides</a><a href="<?php foreach ( $slides as $presentation ) { echo $presentation['url']; } ?>" target="_blank" class="btn btn-primary btn-lg btn-block margin-top-15 hidden-sm hidden-md hidden-lg">Download Slides</a></div>
						</div>					
					</div>
				<?php } else { ?>
					<div class="margin-bottom-60">
						<?php echo do_shortcode('[addthis]');?>
					</div>
				<?php } ?>
				
				<?php echo $content;?>

				<?php if ( ! empty( $speakers ) ) { ?>
					<div class="row">
						<div class="col-sm-12">
							<h5 class="margin-bottom-30 text-uppercase">Speakers</h5>
						</div>

						<?php  foreach ( $speakers as $speaker ) { 
							$jobtitle = rwmb_meta( 'speakers_title','',$speaker );
							$headshot = rwmb_meta( 'speakers_speaker_headshot','size=thumbnail',$speaker );
							$company = rwmb_meta( 'speakers_company','',$speaker );
							$bio = rwmb_meta( 'speakers_wysiwyg','',$speaker );
						?>
							<div class="col-sm-6 col-md-3">
								<div class="match-height padding-30 margin-bottom-30" style="border:#d4e8f3 solid 4px; position:relative;">
									<div class="text-center margin-bottom-15">
									<?php if ( ! empty( $headshot ) ) { ?> 
										<?php foreach ( $headshot as $image ) { ?> <div style="background-image:url(<?php echo $image['url']; ?>); height:50px; width:50px; background-size:cover; background-position:center center; background-repeat:no-repeat; border-radius:50%; display:inline-block;"></div> <?php } ?>
									<?php } else { ?>
										<div style="background-image:url(/wp-content/uploads/no-image.png); height:50px; width:50px; background-size:cover; background-position:center center; background-repeat:no-repeat; border-radius:50%; display:inline-block;"></div>
									<?php } ?>									
									</div>
									<p class="text-center margin-bottom-0" style="font-size: 14px; font-weight:600;"><?php echo get_the_title($speaker); ?></p>
									<p class="text-center margin-bottom-0" style="font-size: 14px; font-weight:400; font-style:italic; line-height:normal;"><?php echo $jobtitle;?><?php if ( ! empty( $company ) ) { ?>, <?php echo $company;?> <?php };?></p>

									<?php if ( ! empty( $bio ) ) { ?><a href="<?php echo get_the_permalink($speaker); ?>" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></a><?php };?>
									
								</div>
							</div>

						<?php } ?>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</section>


<script> 
    jQuery(function(){
      jQuery("#video-player").YTPlayer();
    });
</script>
