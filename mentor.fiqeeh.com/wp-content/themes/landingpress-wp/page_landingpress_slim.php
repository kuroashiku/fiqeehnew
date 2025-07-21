<?php
/**
 * Template Name: LP Slim Canvas (700px)
 * Template Post Type: post, page
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'landingpress_page_layout_class', 'landingpress_page_template_layout_class' );
function landingpress_page_template_layout_class( $layout ) {
	return 'page-landingpress page-landingpress-slim';
}
add_filter('landingpress_is_sidebar_active', '__return_true'); // disable page-sidebar-inactive body class
add_filter('landingpress_is_header_active', '__return_false');
add_filter('landingpress_is_menu_active', '__return_false');
add_filter('landingpress_is_footerwidgets_active', '__return_false');
add_filter('landingpress_is_footer_active', '__return_false');
add_filter('landingpress_is_breadcrumb_active', '__return_false');
add_filter('landingpress_is_title_active', '__return_false');
add_filter('landingpress_is_comments_active', '__return_false');
remove_action( 'landingpress_page_before', 'landingpress_custom_header_elementor' );
remove_action( 'landingpress_page_after', 'landingpress_custom_footer_elementor' );
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
