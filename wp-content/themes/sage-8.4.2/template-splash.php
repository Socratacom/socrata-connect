<?php
/**
 * Template Name: Splash Page
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'homepage-splash'); ?>
<?php endwhile; ?>