<?php
/**
 * Template Name: LP Blank Canvas + Header&Footer
 * Template Post Type: post, page
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'landingpress_page_layout_class', 'landingpress_page_template_layout_class' );
function landingpress_page_template_layout_class( $layout ) {
	return 'page-landingpress page-landingpress-full-hf';
}
add_filter('landingpress_is_sidebar_active', '__return_true'); // disable page-sidebar-inactive body class
get_header(); 
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post(); 
			the_content(); 
		endwhile; 
	endif; 
	?>
	</main>
</div>
<?php get_footer(); ?>
