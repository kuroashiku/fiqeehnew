<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php 
	if ( have_posts() ) : 
		do_action( 'landingpress_content_before' ); 
		$i = 1; 
		echo '<div class="blog-post-area">';
		while ( have_posts() ) : the_post(); 
			$row = $i; 
			do_action( 'landingpress_entry_before' ); 
			get_template_part( 'content' ); 
			do_action( 'landingpress_entry_after' ); 
			do_action( 'landingpress_entry_after_row'.$row ); 
			$i++; 
		endwhile; 
		echo '</div>';
		echo landingpress_get_paginate_links(); 
		do_action( 'landingpress_content_after' ); 
	else : 
		get_template_part( 'content', 'none' ); 
	endif;
	?>
	</main>
</div>
<?php if ( landingpress_is_sidebar_active() ) get_sidebar(); ?>
<?php get_footer(); ?>
