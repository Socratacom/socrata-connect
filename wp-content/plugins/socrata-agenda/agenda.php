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
    'title'  => 'AGENDA SCHEDULE',
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
				'group_title' => 'Entry {#}',
				'save_state' => true,
				// Sub-fields
				'fields' => array(
					array(
						'name' => 'Title',
						'id'   => "{$prefix}title",
						'type' => 'text',
						'size'=> 50,
						'placeholder' => 'Enter event title'
					),
					array(
						'name'       => 'Time',
						'id'         => "{$prefix}time",
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