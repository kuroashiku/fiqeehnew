<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$post_id = '';

if ( get_post_type() == 'post' )
	$post_id = get_the_ID();
elseif ( get_post_type() == 'attachment' )
	$post_id = $post->post_parent;

if ( !$post_id )
	return;

$related = landingpress_get_related_posts( $post_id );

if ( empty( $related) )
	return;

$args = array(
	'post__in' => $related,
	'post__not_in' => array($post_id),
	'posts_per_page' => 5,
	);

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :
?>
<div class="related-posts">
<h3><?php esc_html_e( 'Related Posts', 'landingpress-wp' ); ?></h3>
<ul>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<li>
		<?php if ( get_theme_mod( 'landingpress_post_related_image', '1' ) ) echo landingpress_get_image( array( 'size' => 'thumbnail', 'class' => 'alignleft', 'alt' => get_the_title(), 'link' => 'post', 'fallback' => 'attachment' ) ); ?>
		<?php the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
		<p><?php echo get_the_excerpt(); ?></p>
	</li>
<?php endwhile; ?>
</ul>
</div>
<?php endif; ?>
<?php 
/* Restore original Post Data */
wp_reset_postdata();
?>
