<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N8VGCGK"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->

    <?php if (is_front_page()) {
     /* do_action('get_header');
      get_template_part('templates/home', 'header');*/
    }
    elseif (is_page('connect-2017')) {      
      do_action('get_header');
      get_template_part('templates/home', 'header');
    }
    else {      
      do_action('get_header');
      get_template_part('templates/header');
    } ?>

    <main class="main" role="main">
      <?php include Wrapper\template_path(); ?>
    </main>

    <?php if (is_front_page()) { }
    else {      
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    } ?>

  </body>  
</html>
