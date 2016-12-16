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

// Template Paths
add_filter( 'template_include', 'socrata_speakers_single_template', 1 );
function socrata_speakers_single_template( $template_path ) {
  if ( get_post_type() == 'socrata_speakers' ) {
    if ( is_single() ) {
      // checks if the file exists in the theme first,
      // otherwise serve the file from the plugin
      if ( $theme_file = locate_template( array ( 'single-speakers.php' ) ) ) {
        $template_path = $theme_file;
      } else {
        $template_path = plugin_dir_path( __FILE__ ) . 'single-speakers.php';
      }
    }
  }
  return $template_path;
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

// Shortcode [speaker-tiles]
function speaker_tiles($atts, $content = null) {
  ob_start();
  ?>

  <?php
    $args = array(
    'post_type' => 'socrata_speakers',
    'meta_query' => array(
      array(
        'key' => 'speakers_feature',
        'value' => '1'
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
    $the_query->the_post();
    $headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=medium' );
    $jobtitle = rwmb_meta( 'speakers_title' );
    $company = rwmb_meta( 'speakers_company' );
    $bio = rwmb_meta( 'speakers_wysiwyg' );
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
    $url = $thumb['0']; { ?>

      <?php if ( ! empty( $headshot ) ) { ?> 

        <div class="col-sm-12 slide">
          <div class="tile">
            <div class="text-center">
              <span class="headshot" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>);"></span>
            </div>
            <div class="speaker-meta truncate">
              <h4 class="text-center text-uppercase color-success"><?php the_title(); ?></h4>
              <p class="text-center text-reverse job-title"><em><?php echo $jobtitle;?>, <?php echo $company;?></em></p>
            </div>
            <div class="speaker-meta-hover truncate">
              <h4 class="text-center text-uppercase color-success"><?php the_title(); ?></h4>
              <p class="text-center text-reverse job-title"><em><?php echo $jobtitle;?>, <?php echo $company;?></em></p>
              <div class="bio">
                <?php echo $bio;?>
              </div>
            </div>
            <div class="text-center arrow">
              <i class="fa fa-long-arrow-down text-reverse" aria-hidden="true"></i>
            </div>
            <a href="<?php the_permalink(); ?>" class="link"></a>
          </div>
        </div>

      <?php } else { ?> 

        <div class="col-sm-12 slide">
          <div class="tile">
            <div class="text-center">
              <span class="headshot" style="background-image:url(/wp-content/uploads/no-image.png);"></span>
            </div>
            <div class="speaker-meta truncate">
              <h4 class="text-center text-uppercase color-success"><?php the_title(); ?></h4>
              <p class="text-center text-reverse job-title"><em><?php echo $jobtitle;?></em></p>
            </div>
            <div class="speaker-meta-hover truncate">
              <h4 class="text-center text-uppercase color-success"><?php the_title(); ?></h4>
              <p class="text-center text-reverse job-title"><em><?php echo $jobtitle;?></em></p>
              <div class="bio">
                <?php echo $bio;?>
              </div>
            </div>
            <div class="text-center arrow">
              <i class="fa fa-long-arrow-down text-reverse" aria-hidden="true"></i>
            </div>
            <a href="<?php the_permalink(); ?>" class="link"></a>
          </div>
        </div>

      <?php } ?>

    <?php }

  } ?>

  <?php
  } 
  else {
  // no posts found
  }
  /* Restore original Post Data */
  wp_reset_postdata(); 
  ?>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('speaker-tiles', 'speaker_tiles');




require_once( plugin_dir_path( __FILE__ ) . '/widget.php' );
class Socrata_Speakers_Widget {
 
  function __construct() {
      add_action( 'wp_dashboard_setup', array( $this, 'add_speakers_dashboard_widget' ) );
  }

  function add_speakers_dashboard_widget() {
    global $custom_speaker_dashboard_widget;
 
    foreach ( $custom_speaker_dashboard_widget as $widget_id => $options ) {
      wp_add_dashboard_widget(
          $widget_id,
          $options['title'],
          $options['callback']
      );
    }
  } 
}
 
$wdw = new Socrata_Speakers_Widget();