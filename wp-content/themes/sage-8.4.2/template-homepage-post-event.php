<?php
/**
 * Template Name: Homepage Post Event
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'homepage-post-event'); ?>
<?php endwhile; ?>