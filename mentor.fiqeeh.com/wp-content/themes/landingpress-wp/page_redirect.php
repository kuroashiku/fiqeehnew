<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists('landingpress_redirect_url') ) {
	function landingpress_redirect_url( $url ) {
		$url = trim( $url );
		if ( strpos( $url, 'api.whatsapp.com' ) !== false || strpos( $url, 'whatsapp://' ) !== false ) {
			$url = str_replace( '&amp;text=', '&text=', $url );
			return $url;
		}
		else {
			return esc_url( $url );
		}
	}
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0">
<title><?php echo wp_get_document_title(); ?></title>
<meta name="robots" content="noindex,nofollow">
<?php
if ( function_exists('landingpress_facebook_pixel_ids_facebookcommerce') ) {
	remove_filter( 'landingpress_facebook_pixel_ids', 'landingpress_facebook_pixel_ids_facebookcommerce');
}
if ( function_exists('landingpress_wp_head_seo_meta') ) {
	landingpress_wp_head_seo_meta();
}
if ( function_exists('landingpress_wp_head_facebook_opengraph') ) {
	landingpress_wp_head_facebook_opengraph();
}
if ( function_exists('landingpress_wp_head_facebook_pixels_config') ) {
	landingpress_wp_head_facebook_pixels_config();
}
if ( function_exists('landingpress_wp_head_facebook_pixels') ) {
	landingpress_wp_head_facebook_pixels();
}
if ( function_exists('landingpress_wp_head_adwords_config') ) {
	landingpress_wp_head_adwords_config();
}
if ( function_exists('landingpress_wp_head_adwords') ) {
	landingpress_wp_head_adwords();
}
if ( function_exists('landingpress_wp_head_google_analytics_old') ) {
	landingpress_wp_head_google_analytics_old();
}
if ( function_exists('landingpress_wp_head_google_tag_manager') ) {
	landingpress_wp_head_google_tag_manager();
}
$page_id = get_the_ID();
$redirect = get_post_meta( $page_id, '_landingpress_redirect', true );
$redirect_type = get_post_meta( $page_id, '_landingpress_redirect_type', true );
$redirect_delay = get_post_meta( $page_id, '_landingpress_redirect_delay', true );
$redirect_delay = intval( $redirect_delay );
$redirect_message = get_post_meta( $page_id, '_landingpress_redirect_message', true );
if ( ! $redirect_message ) {
	$redirect_message = __( 'Please wait...', 'landingpress-wp' );
}
?>
<?php if ( $redirect_type == 'meta' ) : ?>
<meta http-equiv="refresh" content="<?php echo esc_attr($redirect_delay); ?>; url=<?php echo landingpress_redirect_url($redirect); ?>" />
<?php endif; ?>
<?php if ( $redirect_type == 'meta' || $redirect_type == 'javascript' ) : ?>
<style type="text/css">
.landingpress-loading{position:fixed;z-index:999999;top:0;left:0;width:100%;height:100%;background:#fff;background:rgba(255,255,255,.8)}
.landingpress-message {display:block;position:absolute;top:50%;left:0;width:100%;margin:40px 0;font-size:14px;font-family:sans-serif;text-align:center}
/* Spinkit https://github.com/tobiasahlin/SpinKit MIT License */
.spinkit-wave{display:block;position:absolute;top:50%;left:50%;width:50px;height:40px;margin:-25px 0 0 -25px;font-size:10px;text-align:center}
.spinkit-wave .spinkit-rect{display:block;float:left;width:6px;height:50px;margin:0 2px;background-color:#e91e63;-webkit-animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out;animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out}
.spinkit-wave .spinkit-rect1{-webkit-animation-delay:-1.2s;animation-delay:-1.2s}
.spinkit-wave .spinkit-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}
.spinkit-wave .spinkit-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}
.spinkit-wave .spinkit-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}
.spinkit-wave .spinkit-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}@-webkit-keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}
</style>
<?php endif; ?>
<?php if ( $redirect_type == 'iframe' ) : ?>
<style type="text/css">
.landingpress-frame{position:fixed;top:0;left:0;bottom:0;right:0;width:100%;height:100%;border:none;margin:0;padding:0;overflow:hidden;z-index:999999;}
</style>
<?php endif; ?>
<?php if ( $redirect_type == 'javascript' && $redirect_delay > 0 ) : ?>
<script type="text/javascript">
setTimeout(function () {
   window.location.href = "<?php echo landingpress_redirect_url($redirect); ?>";
}, <?php echo $redirect_delay*1000; ?> );
</script>
<?php endif; ?>
<?php if ( $redirect_type == 'javascript' && ! $redirect_delay ) : ?>
<script type="text/javascript">
window.location.href = "<?php echo landingpress_redirect_url($redirect); ?>";
</script>
<?php endif; ?>
</head>
<body>
<?php if ( $redirect_type == 'meta' || $redirect_type == 'javascript' ) : ?>
	<div class="spinkit-wave">
		<div class="spinkit-rect spinkit-rect1"></div>
		<div class="spinkit-rect spinkit-rect2"></div>
		<div class="spinkit-rect spinkit-rect3"></div>
		<div class="spinkit-rect spinkit-rect4"></div>
		<div class="spinkit-rect spinkit-rect5"></div>
	</div>
	<div class="landingpress-message">
		<?php echo esc_html( $redirect_message ); ?>
	</div>
<?php endif; ?>
<?php if ( $redirect_type == 'iframe' ) : ?>
<iframe src="<?php echo landingpress_redirect_url($redirect); ?>" class="landingpress-frame">
	<?php esc_html_e( 'Your browser does not support iframes', 'landingpress-wp' ); ?>
</iframe>
<?php endif; ?>
</body>
</html>
