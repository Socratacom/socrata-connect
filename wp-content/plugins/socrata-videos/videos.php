<?php
/*
Plugin Name: Socrata Videos
Plugin URI: http://socrata.com/
Description: This plugin manages videos.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_videos' );
function create_socrata_videos() {
  register_post_type( 'socrata_videos',
    array(
      'labels' => array(
        'name' => 'Videos',
        'singular_name' => 'Videos',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New',
        'edit' => 'Edit',
        'edit_item' => 'Edit',
        'new_item' => 'New',
        'view' => 'View',
        'view_item' => 'View',
        'search_items' => 'Searchs',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title','thumbnail'),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'videos')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_videos_icon' );
function add_socrata_videos_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_videos div.wp-menu-image:before {
      content: '\f236';
    }
  </style>
  <?php
}

// Template Paths
add_filter( 'template_include', 'socrata_videos_single_template', 1 );
function socrata_videos_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_videos' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-videos.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-videos.php';
      }
    }
  }
  return $template_path;
}

// Metabox
add_filter( 'rwmb_meta_boxes', 'socrata_videos_register_meta_boxes' );
function socrata_videos_register_meta_boxes( $meta_boxes )
{
  $prefix = 'socrata_videos_';

  $meta_boxes[] = array(
    'title'  => __( 'Case Study Meta', 'socrata_videos_' ),
    'post_types' => array( 'socrata_videos' ),
    'context'    => 'normal',
    'priority'   => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => __( 'Customer', 'socrata_videos_' ),
        'id'    => "{$prefix}customer",
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => __( 'Site Name', 'socrata_videos_' ),
        'id'    => "{$prefix}site_name",
        'type'  => 'text',
      ),
      // URL
      array(
        'name' => __( 'URL', 'socrata_videos_' ),
        'id'   => "{$prefix}url",
        'desc' => __( 'Include the http:// or https://', 'socrata_videos_' ),
        'type' => 'url',
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Highlights',   
    'post_types'    => 'socrata_videos',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => esc_html__( 'Highlight', 'socrata_videos_' ),
        'id'    => "{$prefix}highlight",
        'type'  => 'text',
        'clone' => true,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Pull Quote',   
    'post_types'    => 'socrata_videos',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // TEXT
      array(
        'name'  => __( 'Name', 'socrata_videos_' ),
        'id'    => "{$prefix}name",
        'type'  => 'text',
      ),
      // TEXT
      array(
        'name'  => __( 'Title', 'socrata_videos_' ),
        'id'    => "{$prefix}title",
        'type'  => 'text',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Headshot', 'socrata_videos_' ),
        'id'               => "{$prefix}headshot",
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // TEXTAREA
      array(
        'name' => esc_html__( 'Quote', 'socrata_videos_' ),
        'id'   => "{$prefix}quote",
        'type' => 'textarea',
        'cols' => 20,
        'rows' => 3,
      ),
    ),
  );

  $meta_boxes[] = array(
    'title'         => 'Case Study Content',   
    'post_types'    => 'socrata_videos',
    'context'       => 'normal',
    'priority'      => 'high',
      'fields' => array(
        array(
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 15,
          'teeny'         => false,
          'media_buttons' => true,
        ),
      ),
    ),
  );

  return $meta_boxes;
}