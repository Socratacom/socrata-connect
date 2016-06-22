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
        'add_new' => 'Add New Agenda',
        'add_new_item' => 'Add New Agenda',
        'edit' => 'Edit Agenda',
        'edit_item' => 'Edit Agenda',
        'new_item' => 'New Agenda',
        'view' => 'View',
        'view_item' => 'View Agenda',
        'search_items' => 'Search Agenda',
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