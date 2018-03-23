<?php
/*
Plugin Name: Socrata Agenda
Plugin URI: http://socrata.com/
Description: This plugin manages agenda items.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_agenda' );
function create_socrata_agenda() {
  register_post_type( 'socrata_agenda',
    array(
      'labels' => array(
        'name' => 'Agenda',
        'singular_name' => 'Agenda',
        'add_new' => 'Add New Schedule',
        'add_new_item' => 'Add New Agenda Schedule',
        'edit' => 'Edit Agenda Schedule',
        'edit_item' => 'Edit Agenda Schedule',
        'new_item' => 'New Agenda Schedule',
        'view' => 'View',
        'view_item' => 'View Agenda Schedule',
        'search_items' => 'Search Agenda Schedule',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title' ),
      'menu_icon' => 'dashicons-calendar',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'schedule')
    )
  );
}

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_agenda_register_meta_boxes' );
function socrata_agenda_register_meta_boxes( $meta_boxes )
{
  $prefix = 'agenda_';

  $meta_boxes[] = array(
    'title'  => 'SESSION SCHEDULE',
    'post_types' => 'socrata_agenda',
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
    	// GROUP
			array(
				'id'     => "{$prefix}item",
				'type'   => 'group',
				'clone'  => true,
				'sort_clone' => true,
				'collapsible' => true,
				'group_title' => array( 'field' => 'agenda_title' ),
				'save_state' => true,
				'default_state' => 'collapsed',
				// Sub-fields
				'fields' => array(
					array(
						'name' => 'Session Title',
						'id'   => "{$prefix}title",
						'type' => 'text',
						'size'=> 50,
						'placeholder' => 'Enter session title'
					),			
					// DATE
					array(
						'name'       => 'Date',
						'id'         => "{$prefix}date",
						'type'       => 'date',
						'placeholder' => 'Enter date',
						'timestamp'  => true,
						'js_options' => array(
							'numberOfMonths'  => 1,
		          'showButtonPanel' => true,
						),
					),
					array(
						'name'       => 'Start Time',
						'id'         => "{$prefix}starttime",
						'type'       => 'time',
						'placeholder' => 'Enter start time',
						'js_options' => array(
							'stepMinute'      => 5,
							'controlType'     => 'select',
							'showButtonPanel' => true,
							'oneLine'         => true,
						),
						'inline'     => false,
					),
					array(
						'name'       => 'End Time',
						'id'         => "{$prefix}endtime",
						'type'       => 'time',
						'placeholder' => 'Enter end time',
						'js_options' => array(
							'stepMinute'      => 5,
							'controlType'     => 'select',
							'showButtonPanel' => true,
							'oneLine'         => true,
						),
						'inline'     => false,
					),
					array(
						'name' => 'Location',
						'id'   => "{$prefix}location",
						'type' => 'text',
						'placeholder' => 'Enter location'
					),
					array(
						'name'		=> 'Description',
						'id'      => "{$prefix}description",
						'type'    => 'wysiwyg',
						'raw'     => false,
						'options' => array(
							'textarea_rows' => 5,
							'teeny'         => true,
							'media_buttons' => false,
						),
					),					
		      array(
		      	'name'       => 'Speakers',
		        'id'          => "{$prefix}speakers",
		        'type'        => 'post',
		        'post_type'   => 'socrata_speakers',
		        'field_type'  => 'select_advanced',
		        'placeholder' => 'Select a Speaker',
		        'clone' => true,
		        'sort_clone' => true,
		      ),
				),
			),
    )
  );

  return $meta_boxes;
}

// Shortcode [sessions slug="SOME-SLUG-NAME"]
function agenda_sessions($atts, $content = null) {
  extract( shortcode_atts( array(
    'slug' => '',
  ), $atts ) );
  ob_start();

	$args = array(
		'name' => $slug,
		'post_type' => 'socrata_agenda',
		'numberpost' => 1,
		'post_status' => 'publish',
	);

	// The Query
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) { 
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$sessions = rwmb_meta( 'agenda_item' ); { ?>

			<?php foreach ( $sessions as $session ) {
			$title = isset( $session['agenda_title'] ) ? $session['agenda_title'] : '';
			$description = isset( $session['agenda_description'] ) ? $session['agenda_description'] : '';
			$speakers = isset( $session['agenda_speakers'] ) ? $session['agenda_speakers'] : '';
			$id = uniqid();
			?>
			<div class="card mb-1">
				<div class="card-body">
				
					<div class="row">

						<?php if (!empty($location)) { ?> 
							<div class="col-sm-12 col-md-10">
								<?php if (!empty($description)) { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><a href="#<?php echo $id;?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo $id;?>"><?php echo $title;?></a></h4>
									<?php } else { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><?php echo $title;?></h4>
								<?php } ?>
							</div>
							<div class="col-sm-12 col-md-2 text-md-right"><?php echo $location;?></div>

							<?php } else { ?>
							<div class="col-sm-12">
								<?php if (!empty($description)) { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><a href="#<?php echo $id;?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo $id;?>"><?php echo $title;?></a></h4>
									<?php } else { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><?php echo $title;?></h4>
								<?php } ?>
							</div>

						<?php } ?> 

					</div>

					<?php if (!empty($description)) { ?>

						<div id="<?php echo $id;?>" class="collapse mt-3 pt-3 row" style="border-top:#e3e3e3 solid 1px;">
							<div class="col-sm-12">
								<?php echo $description;?>
								<?php if ( ! empty( $speakers ) ) { ?>
				  				<div class="d-flex align-items-baseline flex-wrap mt-3">
				  					<div class="text-uppercase text-muted pr-2">Speakers:</div>
										<div class="small text-muted">
										<?php
										$result="";
										foreach($speakers as $speaker) :
										$result.=get_the_title($speaker).', '; 
										endforeach;
										$trimmed=rtrim($result, ', ');
										echo $trimmed;
										?>
										</div>							
									</div>
									<?php }
								?>
							</div>
						</div>

					<?php } ?>
						
				</div>
			</div>

			<?php } ?>
			<?php }
		} ?>
	<?php
	} 

	/* Restore original Post Data */
	wp_reset_postdata(); 
    
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('sessions', 'agenda_sessions');

// Shortcode [schedule slug="SOME-SLUG-NAME"]
function agenda_schedule($atts, $content = null) {
  extract( shortcode_atts( array(
    'slug' => '',
  ), $atts ) );
  ob_start();

	$args = array(
		'name' => $slug,
		'post_type' => 'socrata_agenda',
		'numberpost' => 1,
		'post_status' => 'publish',
	);

	// The Query
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) { 
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$sessions = rwmb_meta( 'agenda_item' ); { ?>

			<?php foreach ( $sessions as $session ) {
			$title = isset( $session['agenda_title'] ) ? $session['agenda_title'] : '';
			$description = isset( $session['agenda_description'] ) ? $session['agenda_description'] : '';
			$speakers = isset( $session['agenda_speakers'] ) ? $session['agenda_speakers'] : '';
			$starttime = isset( $session['agenda_starttime'] ) ? $session['agenda_starttime'] : '';
			$endtime = isset( $session['agenda_endtime'] ) ? $session['agenda_endtime'] : '';
			$location = isset( $session['agenda_location'] ) ? $session['agenda_location'] : '';
			$id = uniqid();
			?>
			<div class="card mb-1">
				<div class="card-body">
				
					<div class="row">
						<div class="mdc-text-orange-500 text-medium col-sm-12 col-md-3" style="white-space: nowrap;">
							<?php echo date('g:i a', strtotime($starttime));?> - <?php echo date('g:i a', strtotime($endtime));?>
						</div>

						<?php if (!empty($location)) { ?> 
							<div class="col-sm-12 col-md-7">
								<?php if (!empty($description)) { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><a href="#<?php echo $id;?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo $id;?>"><?php echo $title;?></a></h4>
									<?php } else { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><?php echo $title;?></h4>
								<?php } ?>
							</div>
							<div class="col-sm-12 col-md-2 text-md-right"><?php echo $location;?></div>

							<?php } else { ?>
							<div class="col-sm-9">
								<?php if (!empty($description)) { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><a href="#<?php echo $id;?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo $id;?>"><?php echo $title;?></a></h4>
									<?php } else { ?> 
									<h4 class="mb-0 text-regular" style="line-height: 1.5rem;"><?php echo $title;?></h4>
								<?php } ?>
							</div>

						<?php } ?> 

					</div>

					<?php if (!empty($description)) { ?>

						<div id="<?php echo $id;?>" class="collapse mt-3 pt-3 row" style="border-top:#e3e3e3 solid 1px;">
							<div class="col-sm-12">
								<?php echo $description;?>
								<?php if ( ! empty( $speakers ) ) { ?>
				  				<div class="d-flex align-items-baseline flex-wrap mt-3">
				  					<div class="text-uppercase text-muted pr-2">Speakers:</div>
										<div class="small text-muted">
										<?php
										$result="";
										foreach($speakers as $speaker) :
										$result.=get_the_title($speaker).', '; 
										endforeach;
										$trimmed=rtrim($result, ', ');
										echo $trimmed;
										?>
										</div>							
									</div>
									<?php }
								?>
							</div>
						</div>

					<?php } ?>
						
				</div>
			</div>

			<?php } ?>
			<?php }
		} ?>
	<?php
	} 

	/* Restore original Post Data */
	wp_reset_postdata(); 
    
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('schedule', 'agenda_schedule');