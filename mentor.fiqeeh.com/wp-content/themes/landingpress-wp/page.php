<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php 
	if ( have_posts() ) :
		do_action( 'landingpress_content_before' );
		while ( have_posts() ) : the_post();
			do_action( 'landingpress_entry_page_before' );
			get_template_part( 'content', 'page' );
			do_action( 'landingpress_entry_page_after' );
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
