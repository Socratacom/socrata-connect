<?php 
$jobtitle = rwmb_meta( 'agenda_speakers','',$speaker );
$speakers = rwmb_meta( 'agenda_speakers' );
$content = rwmb_meta( 'agenda_wysiwyg' );
$startTime = rwmb_meta( 'agenda_starttime' );
$start = date('g:i a', strtotime($startTime));
$endTime = rwmb_meta( 'agenda_endtime' );
$end = date('g:i a', strtotime($endTime));
$old_date = rwmb_meta( 'agenda_date' );
$old_date_timestamp = strtotime($old_date);
$new_date = date('l, F j', $old_date_timestamp);   
?>

<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<h1 class="margin-bottom-15"><?php the_title();?></h1>
				<p><?php echo $new_date;?> | <?php echo $start;?> - <?php echo $end;?></p>
				<div class="margin-bottom-60"><?php echo do_shortcode('[addthis]');?></div>
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
		?>
			<div class="col-sm-6 col-md-3">
				<div class="match-height padding-30 margin-bottom-30" style="border:#d4e8f3 solid 4px; position:relative;">
					<div class="text-center margin-bottom-15">
					<?php foreach ( $headshot as $image ) { ?> <div style="background-image:url(<?php echo $image['url']; ?>); height:50px; width:50px; background-size:cover; background-position:center center; background-repeat:no-repeat; border-radius:50%; display:inline-block;"></div> <?php } ?>
					</div>
					<p class="text-center margin-bottom-0" style="font-size: 14px; font-weight:600;"><?php echo get_the_title($speaker); ?></p>
					<p class="text-center margin-bottom-0" style="font-size: 14px; font-weight:400; font-style:italic; line-height:normal;"><?php echo $jobtitle;?><?php if ( ! empty( $company ) ) { ?>, <?php echo $company;?> <?php };?></p>
					<a href="<?php echo get_the_permalink($speaker); ?>" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></a>	
				</div>
			</div>

		<?php } ?>
	</div>
<?php } ?>


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
