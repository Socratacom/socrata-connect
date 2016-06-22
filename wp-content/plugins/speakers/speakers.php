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