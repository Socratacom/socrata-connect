<?php
    $bio = rwmb_meta( 'speakers_wysiwyg' );
    $jobtitle = rwmb_meta( 'speakers_title' );
    $company = rwmb_meta( 'speakers_company' );
    $headshot = rwmb_meta( 'speakers_speaker_headshot', 'size=medium' );
?>

<section class="section-padding speaker-bio">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <ul class="meta">
                    <li class="match-height"><?php foreach ( $headshot as $image ) { ?> <div class="headshot" style="background-image:url(<?php echo $image['url']; ?>);"></div> <?php } ?></li>                    
                    <li class="match-height"><h2><?php the_title(); ?><br><small><?php echo $jobtitle;?>, <?php echo $company;?></small></h2></li>
                </ul>
                <?php echo $bio;?>
            </div>
        </div>
    </div>
</section>