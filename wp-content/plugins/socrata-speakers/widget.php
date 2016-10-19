<?php

$custom_speaker_dashboard_widget = array(
	'my-dashboard-widget' => array(
	'title' => 'Speakers',
	'callback' => 'dashboardWidgetContent'
	)
);

 function dashboardWidgetContent() {
  /*  $user = wp_get_current_user();
    echo "Hello <strong>" . $user->user_login . "</strong>, this is your custom widget. You can, for instance, list all the posts you've published:";
 
    $r = new WP_Query( apply_filters( 'widget_posts_args', array(
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'author' => $user->ID
    ) ) );
 
    if ( $r->have_posts() ) :
    ?>
 
    <?php
    endif;
    */



    $args = array(
      'post_type' => 'socrata_speakers',
    );
    $myquery = new WP_Query($args);
    echo "<div style='text-align:center; font-size:50px; padding:30px;'>$myquery->found_posts</div>";
    echo "<a href='/wp-admin/post-new.php?post_type=socrata_speakers'>Add New</a>";
    wp_reset_postdata();

}