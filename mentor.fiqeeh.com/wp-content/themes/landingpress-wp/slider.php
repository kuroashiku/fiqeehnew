<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$args = array();
$category = get_theme_mod('landingpress_frontpage_slider_cat');
if ( $category > 0 ) {
	$args['cat'] = $category;
}
$number = get_theme_mod('landingpress_frontpage_slider_number');
$args['posts_per_page'] = $number ? $number : 5;

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) :
	global $landingpress_slider_js; 
	$landingpress_slider_js = true;
?>
<div class="slider-container slider-fold">
	<div class="slider-list">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="slider-item">
			<div class="slider-content">
				<?php echo landingpress_get_image( array( 'alt' => get_the_title(), 'link' => 'post' ) ); ?>
				<?php the_title( sprintf( '<div class="slider-caption"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
</div>
<?php endif; ?>
<?php 
/* Restore original Post Data */
wp_reset_postdata();
?>
