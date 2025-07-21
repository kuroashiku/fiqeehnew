<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$archive_layout = get_theme_mod( 'landingpress_archive_layout' );
if ( !$archive_layout ) {
	$archive_layout = 'content-image';
}

if ( in_array( $archive_layout, array( 'content', 'content-image' ) ) ) {
	$archive_content = 'content';
}
else {
	$archive_content = 'excerpt';
}

if ( in_array( $archive_layout, array( 'content-image', 'excerpt-image' ) ) ) {
	$archive_image = 'post-thumbnail';
}
elseif ( in_array( $archive_layout, array( 'content-image', 'excerpt-image' ) ) ) {
	$archive_image = 'post-thumbnail';
}
elseif ( in_array( $archive_layout, array( 'thumb-left', 'thumb-right' ) ) ) {
	$archive_image = 'thumbnail';
}
elseif ( in_array( $archive_layout, array( 'thumb-medium-left', 'thumb-medium-right', 'gallery-2cols', 'gallery-3cols' ) ) ) {
	$archive_image = 'post-thumbnail-medium';
}
else {
	$archive_image = '';
}

if ( in_array( $archive_layout, array( 'content-image' ) ) ) {
	$archive_image_fallback = '';
}
else {
	$archive_image_fallback = 'attachment';
}

$readmore = get_theme_mod( 'landingpress_archive_morelink_text' );
if ( !$readmore ) {
	$readmore = esc_html__( 'Continue reading &rarr;', 'landingpress-wp' );
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix entry-blog blog-layout-'.$archive_layout); ?>>
	<div class="blog-section-image">
		<?php 
		if ( $archive_image ) :
			echo landingpress_get_image( array( 'alt' => get_the_title(), 'link' => 'post', 'size' => $archive_image, 'fallback' => $archive_image_fallback ) ); 
		endif; 
		?>
	</div>
	<div class="blog-section-content">
		<header class="entry-header">
			<?php 
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			if ( get_theme_mod( 'landingpress_archive_meta', '1' ) ) :
				echo '<div class="entry-meta">'.landingpress_get_entry_meta().'</div>';
			endif; 
			?>
		</header>
		<?php do_action( 'landingpress_entry_content_before' ); ?>
		<div class="entry-content">
			<?php 
			if ( 'excerpt' == $archive_content ) :
				the_excerpt();
				if ( get_theme_mod( 'landingpress_archive_morelink', '1' ) ) :
					echo '<p><a href="'.get_permalink().'" class="more-link">'.esc_html( $readmore ).'</a></p>';
				endif;
			else : 
				the_content( $readmore ); 
				landingpress_link_pages(); 
			endif; 
			?>
		</div>
		<?php do_action( 'landingpress_entry_content_after' ); ?>
	</div>
</article>
