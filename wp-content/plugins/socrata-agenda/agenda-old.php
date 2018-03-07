<?php

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
      'has_archive' => true,
      'rewrite' => array('with_front' => false, 'slug' => 'session')
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
        'name' => 'Sessions',
        'menu_name' => 'Sessions',
        'add_new_item' => 'Add New Session',
        'new_item_name' => "New Session"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => true,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'agenda'),
    )
  );
}
add_action( 'init', 'socrata_agenda_location', 2 );
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
      'show_admin_column' => false,      
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'agend-location'),
    )
  );
}
add_action( 'init', 'socrata_agenda_persona', 1 );
function socrata_agenda_persona() {
  register_taxonomy(
    'socrata_agenda_persona',
    'socrata_agenda',
    array(
      'labels' => array(
        'name' => 'Persona',
        'menu_name' => 'Persona',
        'add_new_item' => 'Add New Persona',
        'new_item_name' => "New Persona"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true,
      'sort' => true,      
      'args' => array( 'orderby' => 'term_order' ),
      'show_admin_column' => false,
      'capabilities'=>array(
        'manage_terms' => 'manage_options',//or some other capability your clients don't have
        'edit_terms' => 'manage_options',
        'delete_terms' => 'manage_options',
        'assign_terms' =>'edit_posts'),
      'rewrite' => array('with_front' => false, 'slug' => 'agend-persona'),
    )
  );
}

// TEMPLATE PATHS
add_filter( 'template_include', 'socrata_agenda_single_template', 1 );
function socrata_agenda_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_agenda' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-agenda.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-agenda.php';
      }
    }
    if ( is_archive() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'archive-agenda.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'archive-agenda.php';
      }
    }
  }
  return $template_path;
}

// CUSTOM EXCERPT
function socrata_agenda_excerpt() {
  global $post;
  $text = rwmb_meta( 'agenda_wysiwyg' );
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
    $terms = get_the_terms($post->ID , 'socrata_agenda_persona');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

function location_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_agenda_location');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}

function session_the_categories() {
    // get all categories for this post
    global $terms;
    $terms = get_the_terms($post->ID , 'socrata_agenda_track');
    // echo the first category
    echo $terms[0]->name;
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($terms); $i++) {echo ', ' . $terms[$i]->name ;}
}


// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_agenda_register_meta_boxes' );
function socrata_agenda_register_meta_boxes( $meta_boxes )
{
  $prefix = 'agenda_';

  $meta_boxes[] = array(
    'title'  => __( 'No Link', 'agenda_' ),
    'post_types' => 'socrata_agenda',
    'context'    => 'side',
    'priority'   => 'high',
    'fields' => array(
      // CHECKBOX
      array(
        'id'   => "{$prefix}nolink",
        'desc' => __( 'Don&rsquo;t link to single agenda page', 'agenda_' ),
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
      ),
    )
  );

  $meta_boxes[] = array(
    'title'         => 'Agenda Content',   
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

  $meta_boxes[] = array(
    'title'         => 'Agenda Meta',   
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
    'title'         => 'Post Event',   
    'post_types'    => 'socrata_agenda',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
      // URL
      array(
        'name' => esc_html__( 'YouTube Share URL', 'agenda_' ),
        'id'   => "{$prefix}video",
        'desc' => esc_html__( 'Example: https://youtu.be/...', 'agenda_' ),
        'type' => 'url',
      ),
      // FILE ADVANCED (WP 3.5+)
      array(
        'name'             => esc_html__( 'Presentation Slides', 'agenda_' ),
        'id'               => "{$prefix}file",
        'desc' => esc_html__( 'Must be a PDF', 'agenda_' ),
        'type'             => 'file_advanced',
        'max_file_uploads' => 1,
        'mime_type'        => 'application', // Leave blank for all file types
      ),
    ),
  );

  return $meta_boxes;
}






// Shortcode [agenda-posts]
function agenda_posts($atts, $content = null) {
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
<h3 class="margin-bottom-30">Sunday, March 5</h3>
<?php echo facetwp_display( 'template', 'agenda_sunday' ); ?>
<h3 class="margin-bottom-30">Monday, March 6</h3>
<?php echo facetwp_display( 'template', 'agenda_monday' ); ?>
<h3 class="margin-bottom-30">Tuesday, March 7</h3>
<?php echo facetwp_display( 'template', 'agenda_tuesday' ); ?>
<h3 class="margin-bottom-30">Wednesday, March 8</h3>
<?php echo facetwp_display( 'template', 'agenda_wednesday' ); ?>





<script>!function(n){n(function(){FWP.loading_handler=function(){}})}(jQuery);</script>



  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('agenda-posts', 'agenda_posts');