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




<?php
    $test = get_the_ID();
    $args = array(
    'post_type' => 'socrata_agenda',
    'meta_query' => array(
      'relation' => 'OR',
      array(
        'key' => 'agenda_speakers',
        'value' => $test,
        'compare' => '='

      )
    ),
    'posts_per_page' => 12,
    'post_status' => 'publish',
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) { 
    while ( $the_query->have_posts() ) {
    $the_query->the_post(); { ?>
      <p><?php the_title(); ?></p>
    <?php
    }
  } ?>

  <?php
  } 
  else { ?>
  <p>fuck</p>
  <?php

  }
  /* Restore original Post Data */
  wp_reset_postdata(); 
  ?>

  <?php echo get_the_ID();?>


			</div>
			<div class="col-sm-8">
				<h1 class="margin-bottom-15"><?php the_title(); ?></h1>
				<h3><?php echo $jobtitle;?>, <?php echo $company;?></h3>
				<?php echo $bio;?>		
			</div>
		</div>
	</div>
</section>