<?php
/*
Plugin Name: Socrata Announcements
Plugin URI: http://socrata.com/
Description: This plugin manages announcements.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_announcements' );
function create_socrata_announcements() {
  register_post_type( 'socrata_announcements',
    array(
      'labels' => array(
        'name' => 'Announcements',
        'singular_name' => 'Announcements',
        'add_new' => 'Add New Item',
        'add_new_item' => 'Add New Announcements Item',
        'edit' => 'Edit Announcements Item',
        'edit_item' => 'Edit Announcements Item',
        'new_item' => 'New Announcements Item',
        'view' => 'View',
        'view_item' => 'View Announcements Item',
        'search_items' => 'Search Announcements Items',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title', 'thumbnail' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'session')
    )
  );
}

// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_announcements_icon' );
function add_socrata_announcements_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_announcements div.wp-menu-image:before {
      content: '\f488';
    }
  </style>
  <?php
}

// TEMPLATE PATHS
add_filter( 'template_include', 'socrata_announcements_single_template', 1 );
function socrata_announcements_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_announcements' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-announcements.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-announcements.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-announcements.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-announcements.php';
      }
    }
  }
  return $template_path;
}

// CUSTOM EXCERPT
function socrata_announcements_excerpt() {
  global $post;
  $text = rwmb_meta( 'announcements_wysiwyg' );
  if ( '' != $text ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $excerpt_length = 20; // 20 words
    $excerpt_more = apply_filters('excerpt_more', ' ' . ' ...');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('get_the_excerpt', $text);
}

// PRINT TAXONOMY CATEGORIES
function persona_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_announcements_persona');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

function location_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_announcements_location');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

function session_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_announcements_track');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}


// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_announcements_register_meta_boxes' );
function socrata_announcements_register_meta_boxes( $meta_boxes )
{
  $prefix = 'announcements_';

  $meta_boxes[] = array(
    'title'  => __( 'No Link', 'announcements_' ),
    'post_types' => 'socrata_announcements',
    'context'    => 'side',
    'priority'   => 'high',
    'fields' => array(
      // CHECKBOX
      array(
        'id'   => "{$prefix}nolink",
        'desc' => __( 'Don&rsquo;t link to single announcements page', 'announcements_' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
    )
  );

  $meta_boxes[] = array(
    'title'         => 'Announcements Content',   
    'post_types'    => 'socrata_announcements',
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

  $meta_boxes[] = array(
    'title'         => 'Announcements Meta',   
    'post_types'    => 'socrata_announcements',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Date and Time', 'announcements_' ),
      ),
      // DATE
      array(
        'name'       => esc_html__( 'Date', 'announcements_' ),
        'id'         => "{$prefix}date",
        'type'       => 'date',
        // jQuery date picker options. See here http://api.jqueryui.com/datepicker
        'js_options' => array(
          'appendText'      => esc_html__( '(yyyy-mm-dd)', 'announcements_' ),
          'dateFormat'      => esc_html__( 'yy-mm-dd', 'announcements_' ),
          'changeMonth'     => true,
          'changeYear'      => true,
          'showButtonPanel' => true,
        ),
      ),
      // TIME
      array(
        'name'       => esc_html__( 'Start Time', 'announcements_' ),
        'id'         => $prefix . 'starttime',
        'type'       => 'time',
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'showSecond' => false,
        ),
      ),
      // TIME
      array(
        'name'       => esc_html__( 'End Time', 'announcements_' ),
        'id'         => $prefix . 'endtime',
        'type'       => 'time',
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'showSecond' => false,
        ),
      ),
      // HEADING
      array(
        'type' => 'heading',
        'name' => esc_html__( 'Speakers', 'announcements_' ),
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

  return $meta_boxes;
}






// Shortcode [announcements-posts]
function announcements_posts($atts, $content = null) {
  ob_start();
  ?>

<!--<div class="filter-bar background-primary-light padding-15 margin-bottom-30">
  <ul>
    <li><?php echo facetwp_display( 'facet', 'persona_dropdown' ); ?></li>
    <li><?php echo facetwp_display( 'facet', 'location_dropdown' ); ?></li>
    <li><?php echo facetwp_display( 'facet', 'session_dropdown' ); ?></li>
    <li><button onclick="FWP.reset()" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button></li>
  </ul>
</div>
-->
<h3 class="margin-bottom-30">Monday, March 6</h3>
<?php echo facetwp_display( 'template', 'announcements_monday' ); ?>
<h3 class="margin-bottom-30">Tuesday, March 7</h3>
<?php echo facetwp_display( 'template', 'announcements_tuesday' ); ?>
<h3 class="margin-bottom-30">Wednesday, March 8</h3>
<?php echo facetwp_display( 'template', 'announcements_wednesday' ); ?>





<script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>



  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('announcements-posts', 'announcements_posts');