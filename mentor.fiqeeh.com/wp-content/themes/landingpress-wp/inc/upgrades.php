<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'init', 'landingpress_upgrades_init', 20 );
function landingpress_upgrades_init() {
	// delete_option( 'landingpress_version' ); /* debug */
	// update_option( 'landingpress_version', '2.8.1' ); /* debug */
	$landingpress_version = get_option( 'landingpress_version' );
	if ( $landingpress_version == LANDINGPRESS_THEME_VERSION  ) {
		return;
	}
	landingpress_upgrades_check( $landingpress_version );
	update_option( 'landingpress_version', LANDINGPRESS_THEME_VERSION );
}

function landingpress_upgrades_check( $landingpress_version ) {
	if ( ! $landingpress_version ) {
		$landingpress_version = '2.8.1';
		landingpress_upgrade_fresh();
	}
	$landingpress_upgrades = get_option( 'landingpress_upgrades', array() );
	$upgrades = array(
		'2.9.0'  => 'landingpress_upgrade_v290',
		'2.9.1'  => 'landingpress_upgrade_v291',
	);
	foreach ( $upgrades as $version => $function ) {
		if ( version_compare( $landingpress_version, $version, '<' ) && ! isset( $landingpress_upgrades[ $version ] ) ) {
			call_user_func( $function );
			$landingpress_upgrades[ $version ] = true;
			update_option( 'landingpress_upgrades', $landingpress_upgrades );
		}
	}
}

function landingpress_upgrade_fresh() {
	// echo 'LandingPress v2.9.0 fresh install...'.'<br/>'; /* debug */
	update_option( 'elementor_css_print_method', 'internal' );
	update_option( 'woocommerce_cart_redirect_after_add', 'yes' );
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'no' );
}

function landingpress_upgrade_v290() {
	// echo 'LandingPress v2.9.0 upgrades...'.'<br/>'; /* debug */
	$mods = get_theme_mods();
	if ( isset( $mods['landingpress_breadcrumb'] ) ) {
		set_theme_mod( 'landingpress_breadcrumb_hide', ! $mods['landingpress_breadcrumb'] );
		remove_theme_mod( 'landingpress_breadcrumb' );
	}
	if ( isset( $mods['landingpress_footer_widgets'] ) ) {
		set_theme_mod( 'landingpress_footer_widgets_hide', ! $mods['landingpress_footer_widgets'] );
		remove_theme_mod( 'landingpress_footer_widgets' );
	}
	$archive_image = get_theme_mod( 'landingpress_archive_image' );
	$archive_content = get_theme_mod( 'landingpress_archive_content' );
	$archive_layout = '';
	if ( 'featured' == $archive_image ) {
		if ( 'excerpt' == $archive_content ) {
			$archive_layout = 'excerpt-image';
		}
		else {
			$archive_layout = 'content-image';
		}
	}
	elseif ( 'thumb-left' == $archive_image ) {
		$archive_layout = 'excerpt-thumb-left';
	}
	elseif ( 'thumb-right' == $archive_image ) {
		$archive_layout = 'excerpt-thumb-right';
	}
	elseif ( 'none' == $archive_image ) {
		if ( 'excerpt' == $archive_content ) {
			$archive_layout = 'excerpt';
		}
		else {
			$archive_layout = 'content';
		}
	}
	else {
		if ( 'excerpt' == $archive_content ) {
			$archive_layout = 'excerpt-image';
		}
		elseif ( 'content' == $archive_content ) {
			$archive_layout = 'content-image';
		}
	}
	if ( $archive_layout ) {
		set_theme_mod( 'landingpress_archive_layout', $archive_layout );
		remove_theme_mod( 'landingpress_archive_image' );
		remove_theme_mod( 'landingpress_archive_content' );
	}
	update_option( 'elementor_css_print_method', 'internal' );

	if ( ! get_theme_mod('landingpress_wc_optimization_unlock_redirecttocart') ) {
		update_option( 'woocommerce_cart_redirect_after_add', 'yes' );
	}
	remove_theme_mod( 'landingpress_wc_optimization_unlock_redirecttocart' );

	if ( ! get_theme_mod('landingpress_wc_optimization_unlock_ajaxaddtocart') ) {
		update_option( 'woocommerce_enable_ajax_add_to_cart', 'no' );
	}
	remove_theme_mod( 'landingpress_wc_optimization_unlock_ajaxaddtocart' );
	
	delete_transient( 'landingpress_wc_ongkir_caches_jne' );
	delete_transient( 'landingpress_wc_ongkir_caches_tiki' );
	delete_transient( 'landingpress_wc_ongkir_caches_pos' );
	delete_transient( 'landingpress_wc_ongkir_caches_jnt' );
	delete_transient( 'landingpress_wc_ongkir_caches_wahana' );
	delete_transient( 'landingpress_wc_ongkir_caches_indah' );
	delete_transient( 'landingpress_wc_ongkir_caches_sicepat' );
}

function landingpress_upgrade_v291() {
	// echo 'LandingPress v2.9.1 upgrades...'.'<br/>'; /* debug */
	$mods = get_theme_mods();
	if ( isset( $mods['landingpress_wc_product_gallery_zoom_enable'] ) ) {
		if ( $mods['landingpress_wc_product_gallery_zoom_enable'] ) {
			set_theme_mod( 'landingpress_wc_product_gallery_zoom_disable', '' );
		}
		else {
			set_theme_mod( 'landingpress_wc_product_gallery_zoom_disable', '1' );
		}
	}
	remove_theme_mod( 'landingpress_customize_css' );
	remove_theme_mod( 'landingpress_customize_fonts' );
	remove_theme_mod( 'landingpress_customize_saved' );
}
