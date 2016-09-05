<?php
/*
Plugin Name: Socrata Speakers
Plugin URI: http://socrata.com/
Description: This plugin manages event speakers.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_speakers' );
function create_socrata_speakers() {
  register_post_type( 'socrata_speakers',
    array(
      'labels' => array(
        'name' => 'Speakers',
        'singular_name' => 'Speakers',
        'add_new' => 'Add New Speaker',
        'add_new_item' => 'Add New Speaker',
        'edit' => 'Edit Speaker',
        'edit_item' => 'Edit Speaker',
        'new_item' => 'New Speaker',
        'view' => 'View',
        'view_item' => 'View Speaker',
        'search_items' => 'Search Speakers',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'speakers')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_speakers_icon' );
function add_socrata_speakers_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_speakers div.wp-menu-image:before {
      content: '\f338';
    }
  </style>
  <?php
}

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_speakers_register_meta_boxes' );
function socrata_speakers_register_meta_boxes( $meta_boxes )
{
  $prefix = 'speakers_';

  $meta_boxes[] = array(
    'title'         => 'Profile Info',   
    'post_types'    => 'socrata_speakers',
    'context'       => 'normal',
    'priority'      => 'high',
    'validation' => array(
      'rules'    => array(
        "{$prefix}title" => array(
            'required'  => true,
        ),
        "{$prefix}company" => array(
            'required'  => true,
        ),
        "{$prefix}wysiwyg" => array(
            'required'  => true,
        ),
      ),
    ),
    'fields' => array(
      // CHECKBOX
      array(
        'name' => esc_html__( 'Feature on homepage?', 'speakers_' ),
        'id'   => "{$prefix}feature",
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
      // TEXT
      array(
        'name'  => esc_html__( 'Title', 'speakers_' ),
        'id'    => "{$prefix}title",
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => esc_html__( 'Company/Organization', 'speakers_' ),
        'id'    => "{$prefix}company",
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => esc_html__( 'Website', 'speakers_' ),
        'id'   => "{$prefix}website",
        'desc' => esc_html__( 'Please include the http:// or https://', 'speakers_' ),
        'type' => 'url',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Headshot', 'socrata-events' ),
        'id'               => "{$prefix}speaker_headshot",
        'desc' => __( 'Minimum size 300x300 pixels.', 'socrata-events' ),
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Bio',   
    'post_types'    => 'socrata_speakers',
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