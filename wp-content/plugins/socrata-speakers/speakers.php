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
      'supports' => array( 'title' ),
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

// Dashboard Widget
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
      ),
    ),
    'tabs' => array(
			'speaker_meta' 			=> 'Speaker Meta',
			'speaker_bio' 			=> 'Speaker Bio',
		),
		'tab_style' => 'box',
    'fields' => array(
      // CHECKBOX
      array(
        'name' => esc_html__( 'Feature on homepage?', 'speakers_' ),
        'id'   => "{$prefix}feature",
        'type' => 'checkbox',
        // Value can be 0 or 1
        'std'  => 0,
        'tab'  => 'speaker_meta',
      ),
      // TEXT
      array(
        'name'  => esc_html__( 'Title', 'speakers_' ),
        'id'    => "{$prefix}title",
        'type'  => 'text',
        'tab'  => 'speaker_meta',
      ),
      // TEXT
      array(
        'name'  => esc_html__( 'Company/Organization', 'speakers_' ),
        'id'    => "{$prefix}company",
        'type'  => 'text',
        'tab'  => 'speaker_meta',
      ),
      // URL
      array(
        'name' => esc_html__( 'Website', 'speakers_' ),
        'id'   => "{$prefix}website",
        'desc' => esc_html__( 'Please include the http:// or https://', 'speakers_' ),
        'type' => 'url',
        'tab'  => 'speaker_meta',
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => __( 'Headshot', 'socrata-events' ),
        'id'               => "{$prefix}speaker_headshot",
        'desc' => __( 'Minimum size 300x300 pixels.', 'socrata-events' ),
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
        'tab'  => 'speaker_meta',
      ),
      // WYSIWYG/RICH TEXT EDITOR
      array(
        'id'      => "{$prefix}wysiwyg",
        'type'    => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'     => false,
        // Editor settings, see wp_editor() function: look4wp.com/wp_editor
        'options' => array(
          'textarea_rows' => 30,
          'teeny'         => true,
          'media_buttons' => false,
        ),
        'tab'  => 'speaker_bio',
      ),
    ),
  );

  return $meta_boxes;
}

// Shortcode [featured-speaker-tiles]
function featured_speaker_tiles($atts, $content = null) {
  ob_start();
  ?>
	<section class="section-padding mdc-bg-grey-900 text-center speaker-slider">
		<h2 class="text-white display-4 mb-5">Featured Speakers</h2>
		<div class="slider">
  <?php
    $args = array(
    'post_type' => 'socrata_speakers',
    'meta_query' => array(
      array(
        'key' => 'speakers_feature',
        'value' => '1'
      )
    ),
    'posts_per_page' => 100,
    'post_status' => 'publish',
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) { 
    while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=square' );
    $jobtitle = rwmb_meta( 'speakers_title' );
    $company = rwmb_meta( 'speakers_company' );
    $bio = rwmb_meta( 'speakers_wysiwyg' ); { ?>

      <?php if ( ! empty( $headshot ) ) { ?> 

			<div class="match-height slide">
				<div class="p-sm-3 p-md-5">
					<div class="text-center mb-3">
						<div class="one-one d-inline-block" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>); background-repeat: no-repeat; background-position: center; background-size:cover; height:100px; width:100px"></div>
					</div>
					<h4 class="text-regular text-center text-white mb-1"><?php the_title(); ?></h4>
					<p class="text-regular text-center text-white"><?php echo $jobtitle;?>, <?php echo $company;?></p>
					<?php if ( ! empty( $bio ) ) { ?>
					<p class="text-center"><a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-light">Read Bio</a></p>
					<?php };?>
				</div>
			</div>

      <?php } else { ?> 

			<div class="match-height slide">
				<div class="p-sm-3 p-md-5">
					<div class="text-center mb-4">
						<div class="d-inline-block border text-center" style="height:100px; width:100px;">
							<div class="text-white text-center text-uppercase p-2" style="font-size:11px;">No Image</div>
						</div>
					</div>
					<h4 class="text-regular text-center text-white mb-1"><?php the_title(); ?></h4>
					<p class="text-regular text-center text-white"><?php echo $jobtitle;?>, <?php echo $company;?></p>
					<?php if ( ! empty( $bio ) ) { ?>
					<p class="text-center"><a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-light">Read Bio</a></p>
					<?php };?>
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

</div>
<div class="arrows-container"></div>
</section>

  <script type="text/javascript">
  $(document).ready(function(){
    $('.slider').slick({
      arrows: true,
      appendArrows: $('.arrows-container'),
      prevArrow: '<div class="toggle-left"><i class="icon-left-arrow"></i></div>',
      nextArrow: '<div class="toggle-right"><i class="icon-right-arrow"></i></div>',
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,
      accessibility:false,
      dots:false,
      responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
    });
    $('.slider').show();
  });
  </script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('featured-speaker-tiles', 'featured_speaker_tiles');


// Shortcode [speaker-tiles]
function speaker_tiles($atts, $content = null) {
  ob_start();
  ?>

  <?php
    $args = array(
    'post_type' => 'socrata_speakers',
    'posts_per_page' => 100,
    'orderby' => 'title',
    'order' => 'ASC',
    'post_status' => 'publish',
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) { 
    while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=four-three' );
    $jobtitle = rwmb_meta( 'speakers_title' );
    $company = rwmb_meta( 'speakers_company' );
    $bio = rwmb_meta( 'speakers_wysiwyg' );
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-small' );
    $url = $thumb['0']; { ?>

      <?php if ( ! empty( $headshot ) ) { ?> 




        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card w-100 mb-4 match-height">   	

	          <div class="four-three" style="background-image:url(<?php foreach ( $headshot as $image ) { echo $image['url']; } ?>); background-repeat: no-repeat; background-position: center; background-size:cover;"></div>
	          <div class="card-body">
	            <h4 class="text-regular mb-1"><?php the_title(); ?></h4>
	            <div class="text-regular text-muted"><?php echo $jobtitle;?>, <?php echo $company;?></div>
						</div>
						<?php if ( ! empty( $bio ) ) { ?>
							<div class="card-footer pb-4" style="border:none; background-color:#fff;">
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary">Read Bio</a>
							</div>
						<?php };?>

          </div>         
        </div>

      <?php } else { ?>

        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card w-100 mb-4 match-height">   	

	          <div class="card-body mdc-bg-blue-500">
	            <h4 class="text-regular mb-1 text-white"><?php the_title(); ?></h4>
	            <div class="text-regular text-white"><?php echo $jobtitle;?>, <?php echo $company;?></div>
						</div>
						<?php if ( ! empty( $bio ) ) { ?>
							<div class="card-footer pb-4 mdc-bg-blue-500" style="border:none;">
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-light">Read Bio</a>
							</div>
						<?php };?>

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




