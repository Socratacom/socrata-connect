<?php
/**
 * Template Name: Homepage Takeover
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'homepage-takeover'); ?>
<?php endwhile; ?>