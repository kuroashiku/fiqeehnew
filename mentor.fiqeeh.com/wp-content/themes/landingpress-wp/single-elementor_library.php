<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'body_class', 'landingpress_body_class_template_blank' );
function landingpress_body_class_template_blank( $classes ) {
	$classes[] = 'page-landingpress page-landingpress-full';
	return $classes;
}
add_filter('landingpress_is_sidebar_active', '__return_true'); // disable page-sidebar-inactive body class
add_filter('landingpress_is_header_active', '__return_false');
add_filter('landingpress_is_menu_active', '__return_false');
add_filter('landingpress_is_footerwidgets_active', '__return_false');
add_filter('landingpress_is_footer_active', '__return_false');
add_filter('landingpress_is_breadcrumb_active', '__return_false');
add_filter('landingpress_is_title_active', '__return_false');
add_filter('landingpress_is_comments_active', '__return_false');
get_header(); 
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	<?php else : ?>
	<?php endif; ?>
	</main>
</div>
<?php get_footer(); ?>
