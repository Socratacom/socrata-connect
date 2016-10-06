<?php 
$speakers = rwmb_meta( 'agenda_speakers' ); 

?>
<section class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php $custom = get_post_custom();
foreach($custom as $key => $value) {
     echo $key.': '.$value.'<br />';
}?>
<hr>
<ul>
<?php foreach ( $speakers as $speaker ) { ?> 

<li><a href="<?php echo get_the_permalink($speaker); ?>"><?php echo get_the_title($speaker); ?></a></li>

<?php } ?>
</ul>





			</div>
		</div>
	</div>
</section>