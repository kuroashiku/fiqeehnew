<?php
/**
 * The template used for displaying page content in page.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry-page'); ?>>
	<header class="entry-header">
		<?php 
		do_action( 'landingpress_entry_header_page_before' ); 
		if( landingpress_is_title_active() ) {
			the_title( '<h1 class="entry-title">', '</h1>' ); 
		}
		do_action( 'landingpress_entry_header_page_after' ); 
		?>
	</header>
	<?php do_action( 'landingpress_entry_content_page_before' ); ?>
	<div class="entry-content">
		<?php 
		the_content(); 
		landingpress_link_pages(); 
		edit_post_link( esc_html__( 'Edit', 'landingpress-wp' ), '<span class="edit-link">', '</span>' ); 
		?>
	</div>
	<?php do_action( 'landingpress_entry_content_page_after' ); ?>
</article>
