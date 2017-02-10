<?php
/*
Plugin Name: Socrata Announcements
Plugin URI: http://socrata.com/
Description: This plugin manages event announcement.
Version: 1.0
Author: Michael Church
Author URI: http://socrata.com/
License: GPLv2
*/

add_action( 'init', 'create_socrata_announcement' );
function create_socrata_announcement() {
  register_post_type( 'socrata_announcement',
    array(
      'labels' => array(
        'name' => 'Announcements',
        'singular_name' => 'Announcements',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Announcement',
        'edit' => 'Edit Announcement',
        'edit_item' => 'Edit Announcement',
        'new_item' => 'New Announcement',
        'view' => 'View',
        'view_item' => 'View Announcement',
        'search_items' => 'Search Announcements',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash'
      ),
      'public' => true,
      'menu_position' => 5,
      'supports' => array( 'title' ),
      'taxonomies' => array( '' ),
      'menu_icon' => '',
      'has_archive' => false,
      'rewrite' => array('with_front' => false, 'slug' => 'announcement')
    )
  );
}


// MENU ICON
//Using Dashicon Font https://developer.wordpress.org/resource/dashicons
add_action( 'admin_head', 'add_socrata_announcement_icon' );
function add_socrata_announcement_icon() { ?>
  <style>
    #adminmenu .menu-icon-socrata_announcement div.wp-menu-image:before {
      content: '\f488';
    }
  </style>
  <?php
}

// METABOXES
add_filter( 'rwmb_meta_boxes', 'socrata_announcement_register_meta_boxes' );
function socrata_announcement_register_meta_boxes( $meta_boxes )
{
  $prefix = 'announcement_';

  $meta_boxes[] = array(
    'title'         => 'Announcement Content',   
    'post_types'    => 'socrata_announcement',
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
    'title'         => 'Announcement Link',   
    'post_types'    => 'socrata_announcement',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields' => array(
        // TEXT
        array(
            'name'  => esc_html__( 'Call to action text', 'announcement_' ),
            'id'    => "{$prefix}text",
            'desc'  => esc_html__( 'Ex. Read More', 'announcement_' ),
            'type'  => 'text',
        ),
        // URL
        array(
            'name' => esc_html__( 'Link', 'announcement_' ),
            'id'   => "{$prefix}url",
            'desc' => esc_html__( 'Include http:// or https://', 'announcement_' ),
            'type' => 'url',
        ),
        // CHECKBOX
        array(
            'name' => esc_html__( 'Open in new window', 'announcement_' ),
            'id'   => "{$prefix}checkbox",
            'type' => 'checkbox',
            // Value can be 0 or 1
            'std'  => 0,
        ),
    ),
  );

  return $meta_boxes;
}

// Shortcode [announcement-posts]
function announcement_posts($atts, $content = null) {
  ob_start();
  ?>

    <?php

    // The Query
    $args = array(
    'post_type' => 'socrata_announcement',
    'posts_per_page' => 3
    );
    $query = new WP_Query( $args );

    // The Loop
    while ( $query->have_posts() ) { $query->the_post();
    $content = rwmb_meta( 'announcement_wysiwyg' );
    $new_window = rwmb_meta( 'announcement_checkbox' );
    $cta = rwmb_meta( 'announcement_text' );
    $link = rwmb_meta( 'announcement_url' );

    ?>

    <div class="col-sm-4 margin-bottom-30">
    <h5 class="margin-bottom-15 color-black"><?php the_title(); ?></h5>
    <?php echo $content;?>
    <?php if ( ! empty( $new_window ) ) { ?>

        <p><a href="<?php echo $link;?>" target="_blank">
        <?php if ( ! empty( $cta ) ) { ?>
            <?php echo $cta;?> <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
        <?php } else { ?>
            Read More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
        <?php } ?>
        </a></p>

    <?php } else { ?>

        <p><a href="<?php echo $link;?>">
        <?php if ( ! empty( $cta ) ) { ?>
            <?php echo $cta;?> <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
        <?php } else { ?>
            Read More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
        <?php } ?>
        </a></p>

    <?php } ?>
    </div>

    <?php
    }

    // Restore original Post Data
    wp_reset_postdata();
    ?>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('announcement-posts', 'announcement_posts');