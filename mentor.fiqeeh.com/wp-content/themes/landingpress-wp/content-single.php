<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$post_class = 'entry-post';
if ( get_post_type() != 'post' ) {
	$post_class .= ' entry-'.get_post_type();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<header class="entry-header">
		<?php 
		do_action( 'landingpress_entry_header_'.get_post_type().'_before' ); 
		if ( get_theme_mod( 'landingpress_post_image', '1' ) ) {
			echo landingpress_get_image( array( 'alt' => get_the_title(), 'link' => false, 'fallback' => false ) ); 
		}
		if ( landingpress_is_title_active() ) {
			the_title( '<h1 class="entry-title">', '</h1>' ); 
		}
		if ( get_theme_mod( 'landingpress_post_meta', '1' ) ) :
			echo '<div class="entry-meta">'.landingpress_get_entry_meta().'</div>';
		endif; 
		do_action( 'landingpress_entry_header_'.get_post_type().'_after' ); 
		?>
	</header>
	<?php do_action( 'landingpress_entry_content_'.get_post_type().'_before' ); ?>
	<div class="entry-content">
		<?php 
		the_content();
		landingpress_link_pages(); 
		?>
	</div>
	<?php 
	do_action( 'landingpress_entry_content_'.get_post_type().'_after' );
	echo landingpress_get_the_term_list( get_the_ID(), 'post_tag', '<footer class="entry-footer"><div class="entry-meta"><span>'.__( 'Tags:', 'landingpress-wp' ).'</span> ', ' ', '</div></footer>' ); 
	?>
</article>
