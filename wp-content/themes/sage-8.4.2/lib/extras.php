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

/**
 * Match Height
 */
function match_height( $atts ) {
  extract( shortcode_atts( array(
    'class' => '',
  ), $atts ) );
  ob_start(); 
  ?>
  <script>jQuery(function(a){a(<?php echo " '.$class' "; ?>).matchHeight({byRow:!0})});</script>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('match-height', __NAMESPACE__ . '\\match_height');

/**
 * Addthis Sharing
 */
function addthis_sharing ($atts, $content = null) {
  ob_start();
  ?>
  <div class="addthis_inline_share_toolbox"></div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('addthis', __NAMESPACE__ . '\\addthis_sharing');



/**
 * Clean Archive Title
 */
function grd_custom_archive_title( $title ) {
  // Remove any HTML, words, digits, and spaces before the title.
  return preg_replace( '#^[\w\d\s]+:\s*#', '', strip_tags( $title ) );
}
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\\grd_custom_archive_title' );

/**
 * YouTube Modal
 */
function youtube_modal( $atts ) {
  ob_start(); 
  ?>

<!-- Video / Generic Modal -->
<div class="modal video-modal" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
      <div class="modal-body">
        <!-- content dynamically inserted -->
      </div>
    </div>
  </div>
</div>

<script>
// REQUIRED: Include "jQuery Query Parser" plugin here or before this point: 
// https://github.com/mattsnider/jquery-plugin-query-parser
 (function($){var pl=/\+/g,searchStrict=/([^&=]+)=+([^&]*)/g,searchTolerant=/([^&=]+)=?([^&]*)/g,decode=function(s){return decodeURIComponent(s.replace(pl," "));};$.parseQuery=function(query,options){var match,o={},opts=options||{},search=opts.tolerant?searchTolerant:searchStrict;if('?'===query.substring(0,1)){query=query.substring(1);}while(match=search.exec(query)){o[decode(match[1])]=decode(match[2]);}return o;};$.getQuery=function(options){return $.parseQuery(window.location.search,options);};$.fn.parseQuery=function(options){return $.parseQuery($(this).serialize(),options);};}(jQuery));

// YOUTUBE VIDEO CODE
jQuery(document).ready(function($){
  
// BOOTSTRAP 3.0 - Open YouTube Video Dynamicaly in Modal Window
// Modal Window for dynamically opening videos
$('a[href^="https://www.youtube.com"]').on('click', function(e){
  // Store the query string variables and values
  // Uses "jQuery Query Parser" plugin, to allow for various URL formats (could have extra parameters)
  var queryString = $(this).attr('href').slice( $(this).attr('href').indexOf('?') + 1);
  var queryVars = $.parseQuery( queryString );
 
  // if GET variable "v" exists. This is the Youtube Video ID
  if ( 'v' in queryVars )
  {
    // Prevent opening of external page
    e.preventDefault();
 
    // Variables for iFrame code. Width and height from data attributes, else use default.
    var vidWidth = 1280; // default
    var vidHeight = 720; // default
    if ( $(this).attr('data-width') ) { vidWidth = parseInt($(this).attr('data-width')); }
    if ( $(this).attr('data-height') ) { vidHeight =  parseInt($(this).attr('data-height')); }
    var iFrameCode = '<div class="container"><div class="row"><div class="col-sm-10 col-sm-offset-1"><div class="video-container"><iframe width="' + vidWidth + '" height="'+ vidHeight +'" scrolling="no" allowtransparency="true" allowfullscreen="true" src="https://www.youtube.com/embed/'+  queryVars['v'] +'?rel=0&wmode=transparent&showinfo=0&autoplay=0" frameborder="0"></iframe></div></div></div></div>';
 
    // Replace Modal HTML with iFrame Embed
    $('#mediaModal .modal-body').html(iFrameCode);

 
    // Open Modal
    $('#mediaModal').modal();
  }
});
 
// Clear modal contents on close. 
// There was mention of videos that kept playing in the background.
$('#mediaModal').on('hidden.bs.modal', function () {
  $('#mediaModal .modal-body').html('');
});
 
}); 
</script>


  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode('youtube-modal', __NAMESPACE__ . '\\youtube_modal');