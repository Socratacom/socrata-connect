<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Adds responisve image class to images
 */
function WPTime_add_custom_class_to_all_images($content){
    /* Filter by Qassim Hassan - http://wp-time.com */
    $my_custom_class = "img-responsive"; // your custom class
    $add_class = str_replace('<img class="', '<img class="'.$my_custom_class.' ', $content); // add class

    return $add_class; // display class to image
}
add_filter('the_content', __NAMESPACE__ . '\\WPTime_add_custom_class_to_all_images');

/**
 * Responsive Carousel [responsive-carousel id="" slide_id=""]
 */
function carousel_script_responsive( $atts ) {
  extract( shortcode_atts( array(
    'id' => '',
    'slide_id' => '',
  ), $atts ) );
  ob_start(); 
  ?>
<script>
  jQuery(function ($){
    $(<?php echo "'#$slide_id'"; ?>).slick({
    arrows: true,
    appendArrows: $(<?php echo "'#$id'"; ?>),
    prevArrow: '<div class="toggle-left"><i class="fa slick-prev fa-chevron-left"></i></div>',
    nextArrow: '<div class="toggle-right"><i class="fa slick-next fa-chevron-right"></i></div>',
    autoplay: false,
    autoplaySpeed: 8000,
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 4,
    accessibility:false,
    dots:false,

      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
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
    $(<?php echo "'#$slide_id'"; ?>).show();
  });
  </script>

  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('responsive-carousel', __NAMESPACE__ . '\\carousel_script_responsive');