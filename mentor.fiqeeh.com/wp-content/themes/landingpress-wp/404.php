<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter('landingpress_is_sidebar_active', '__return_false');
add_filter('landingpress_is_menu_active', '__return_false');
add_filter('landingpress_is_footerwidgets_active', '__return_false');

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php get_template_part( 'content', 'none' ); ?>
	</main>
</div>
<?php if ( landingpress_is_sidebar_active() ) get_sidebar(); ?>
<?php get_footer(); ?>
