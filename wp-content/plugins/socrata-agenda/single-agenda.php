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
