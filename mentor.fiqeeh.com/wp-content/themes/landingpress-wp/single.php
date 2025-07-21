<?php
/**
 * The template for displaying all single posts.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php 
	if ( have_posts() ) : 
		do_action( 'landingpress_content_before' ); 
		while ( have_posts() ) : the_post();
			do_action( 'landingpress_entry_'.get_post_type().'_before' );
			get_template_part( 'content-single', get_post_type() );
			do_action( 'landingpress_entry_'.get_post_type().'_after' );
		endwhile;
		do_action( 'landingpress_content_after' );
	else :
		get_template_part( 'content', 'none' );
	endif; 
	?>
	</main>
</div>
<?php if ( landingpress_is_sidebar_active() ) get_sidebar(); ?>
<?php get_footer(); ?>
