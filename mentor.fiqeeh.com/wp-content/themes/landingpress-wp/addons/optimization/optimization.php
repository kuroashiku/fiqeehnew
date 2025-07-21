<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! get_theme_mod('landingpress_optimization_wpversion') ) {
	remove_action( 'wp_head', 'wp_generator' );
}

if ( ! get_theme_mod('landingpress_optimization_wpemoji') ) {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	add_filter( 'emoji_svg_url', '__return_false' );
}

if ( ! get_theme_mod('landingpress_optimization_wprest') ) {
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
}

if ( ! get_theme_mod('landingpress_optimization_wpresponsive') ) {
	add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
}

if ( ! get_theme_mod('landingpress_optimization_wpoembed') ) {
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
}

add_filter( 'script_loader_tag', 'landingpress_defer_parsing_of_js', 9999 );
function landingpress_defer_parsing_of_js( $url ) {
	if ( !get_theme_mod('landingpress_optimization_defer') ) {
		return $url;
	}
	if ( defined( 'WP_ROCKET_VERSION' ) ) {
		return $url;
	}
	if ( is_user_logged_in() ) {
		return $url;
	}
	if ( false === strpos( $url, '.js' ) ) {
		return $url;
	}
	if ( false !== strpos( $url, 'jquery.js' ) ) {
		return $url;
	}
	if ( false !== strpos( $url, 'jquery.min.js' ) ) {
		return $url;
	}
	if ( false !== strpos( $url, 'defer' ) ) {
		return $url;
	}
	return str_replace( ' src', ' defer src', $url );
}

// add_filter( 'script_loader_src', 'landingpress_remove_script_version', 15, 1 );
// add_filter( 'style_loader_src', 'landingpress_remove_script_version', 15, 1 );
function landingpress_remove_script_version( $src ){
	if ( get_theme_mod('landingpress_optimization_version', '') ) {
		$parts = explode( '?ver', $src );
		return $parts[0];
	}
	else {
		return $src;
	}
}

add_action( 'wp_enqueue_scripts', 'landingpress_jquery_group', 5 );
function landingpress_jquery_group() {
	if ( get_theme_mod('landingpress_optimization_jquery') ) {
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	}
}

if ( get_theme_mod('landingpress_optimization_lazyload_disable') ) {
	add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}

if ( ! get_theme_mod('landingpress_optimization_wpembed') ) {
	add_action('init', 'landingpress_deregister_wp_embed');
	function landingpress_deregister_wp_embed() {
		if ( is_admin() ) {
			return;
		}
		if ( defined( 'CFCORE_VER' ) ) {
			return;
		}
		wp_deregister_script('wp-embed');
	}
}

if ( ! get_theme_mod('landingpress_optimization_wlw') ) {
	remove_action( 'wp_head', 'wlwmanifest_link' );
}

if ( ! get_theme_mod('landingpress_optimization_xmlrpc') ) {
	remove_action( 'wp_head', 'rsd_link' );
	add_filter( 'xmlrpc_enabled', '__return_false' );
	add_filter( 'wp_headers', 'landingpress_disable_x_pingback' );
	function landingpress_disable_x_pingback( $headers ) {
	    unset( $headers['X-Pingback'] );
		return $headers;
	}
	add_filter( 'xmlrpc_methods', 'landingpress_disable_xmlrpc_pingback' );
	function landingpress_disable_xmlrpc_pingback( $methods ) {
		unset( $methods['pingback.ping'] );
		return $methods;
	}
}
