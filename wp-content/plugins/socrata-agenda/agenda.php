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
        'add_new' => 'Add New Item',
        'add_new_item' => 'Add New Agenda Item',
        'edit' => 'Edit Agenda Item',
        'edit_item' => 'Edit Agenda Item',
        'new_item' => 'New Agenda Item',
        'view' => 'View',
        'view_item' => 'View Agenda Item',
        'search_items' => 'Search Agenda Items',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'agenda')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_agenda_icon' );
function add_socrata_agenda_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_agenda div.wp-menu-image:before {
      content: '\f145';
    }
  </style>
  <?php
}

// TAXONOMIES
add_action( 'init', 'socrata_agenda_track', 0 );
function socrata_agenda_track() {
  register_taxonomy(
    'socrata_agenda_track',
    'socrata_agenda',
    array(
      'labels' => array(
        'name' => 'Track',
        'menu_name' => 'Track',
        'add_new_item' => 'Add New Track',
        'new_item_name' => "New Track"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'agend-track'),
    )
  );
}
add_action( 'init', 'socrata_agenda_location', 0 );
function socrata_agenda_location() {
  register_taxonomy(
    'socrata_agenda_location',
    'socrata_agenda',
    array(
      'labels' => array(
        'name' => 'Location',
        'menu_name' => 'Location',
        'add_new_item' => 'Add New Location',
        'new_item_name' => "New Location"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'agend-location'),
    )
  );
}

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_agenda_register_meta_boxes' );
function socrata_agenda_register_meta_boxes( $meta_boxes )
{
  $prefix = 'agenda_';

  $meta_boxes[] = array(
    'title'         => 'Agenda Item Meta',   
    'post_types'    => 'socrata_agenda',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Date and Time', 'agenda_' ),
      ),
      // DATE
      array(
        'name'       => esc_html__( 'Date', 'agenda_' ),
        'id'         => "{$prefix}date",
        'type'       => 'date',
        // jQuery date picker options. See here http://api.jqueryui.com/datepicker
        'js_options' => array(
          'appendText'      => esc_html__( '(yyyy-mm-dd)', 'agenda_' ),
          'dateFormat'      => esc_html__( 'yy-mm-dd', 'agenda_' ),
          'changeMonth'     => true,
          'changeYear'      => true,
          'showButtonPanel' => true,
        ),
      ),
      // TIME
      array(
        'name'       => esc_html__( 'Start Time', 'agenda_' ),
        'id'         => $prefix . 'starttime',
        'type'       => 'time',
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'stepMinute' => 15,
          'showSecond' => false,
        ),
      ),
      // TIME
      array(
        'name'       => esc_html__( 'End Time', 'agenda_' ),
        'id'         => $prefix . 'endtime',
        'type'       => 'time',
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'stepMinute' => 15,
          'showSecond' => false,
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Speakers', 'agenda_' ),
      ),
      // POST
      array(
        'id'          => "{$prefix}speakers",
        'type'        => 'post',
        // Post type
        'post_type'   => 'socrata_speakers',
        // Field type, either 'select' or 'select_advanced' (default)
        'field_type'  => 'select_advanced',
        'placeholder' => esc_html__( 'Select a Speaker' ),
        'clone' => true,
        'sort_clone' => true,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Content',   
    'post_types'    => 'socrata_agenda',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => false,
          'media_buttons' => false,
        ),
      ),
    ),
  );

  return $meta_boxes;
}