<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$site_branding_class = 'site-branding clearfix';
if ( is_active_sidebar( 'header' ) ) {
	$site_branding_class .= ' site-header-widget-active';
}
if ( $align = get_theme_mod('landingpress_header_alignment', 'center') ) {
	$site_branding_class .= ' site-header-align-'.$align;
}
$site_title_class = 'site-title clearfix';
$header_logo = get_theme_mod( 'landingpress_header_logo' );
$header_background = get_theme_mod('landingpress_header_background');
$header_image = get_header_image();
$header_placement = get_theme_mod( 'landingpress_header_placement', 'background' );
if ( $header_placement == 'background_nologo' ) {
	$header_placement = 'background';
	$site_title_class .= ' screen-reader-text';
}
if ( $header_image ) {
	$site_branding_class .= 'image' == $header_placement ? ' screen-reader-text' : '';
}
$site_branding_class .= $header_image || $header_background ? ' site-header-image-active' : ' site-header-image-inactive';
?>
<header id="masthead" class="site-header">
	<div class="<?php echo esc_attr($site_branding_class); ?>">
		<?php if ( $header_image && $header_placement == 'background' ) : ?>
			<div class="site-header-overlay">
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="<?php echo esc_attr($site_title_class); ?>">
				<?php if ( $header_logo ) : ?>
					<a class="header-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo esc_url( $header_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
				<?php else : ?>
					<div class="site-title">
						<a class="header-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					</div>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'header' ) ) : ?>
					<div class="header-widget">
						<?php dynamic_sidebar( 'header' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( $header_image && ( 'image' == $header_placement || 'image_title_top' == $header_placement ) ) : ?>
		<img class="site-header-image" src="<?php echo esc_url( $header_image ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
	<?php endif; ?>
</header>
