<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ADDONS_PATH', trailingslashit( get_template_directory() ) . 'addons/' );
define( 'ADDONS_URL', trailingslashit( get_template_directory_uri() ) . 'addons/' );

include_once( ADDONS_PATH . 'system-check/system-check.php' );

add_action( 'after_setup_theme', 'landingpress_setup_theme_updater', 20 );
function landingpress_setup_theme_updater() {
	global $pagenow;
	require_once( ADDONS_PATH . 'updater/theme-updater.php' );
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
		if ( get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false) != 'valid' ) {
			if ( class_exists('EDD_Theme_Updater_Admin') ) {
				wp_redirect(admin_url("admin.php?page=landingpress"));
			}
			else {
				wp_redirect(admin_url("themes.php?page=landingpress-wp-license"));
			}
		}
	}	
}

$status = get_option( LANDINGPRESS_THEME_SLUG . '_license_key_status', false );
if ( ! in_array( $status, array( 'valid', 'expired' ) ) ) {
	return;
}

include_once( ADDONS_PATH . 'export-import/export-import.php' );

if ( class_exists( 'CMB_Meta_Box' ) ) {
	add_action( 'admin_notices', 'landingpress_metabox_active' );
}
else {
	if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
		add_action( 'admin_notices', 'landingpress_metabox_fail_php_version' );
	} 
	else {
		define( 'CMB_DEV', false );
		define( 'CMB_PATH', ADDONS_PATH . 'metabox/' );
		define( 'CMB_URL', ADDONS_URL . 'metabox/' );
		require_once( CMB_PATH . 'custom-meta-boxes.php' );
	}
}

function landingpress_metabox_active() {
	$message = esc_html__( 'LandingPress use custom version of CMB. Please deactivate your CMB plugin.', 'landingpress-wp' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

function landingpress_metabox_fail_php_version() {
	$message = esc_html__( 'LandingPress membutuhkan PHP dengan minimum versi 5.4 ke atas. Silahkan cek video tutorial di member area untuk merubah versi PHP di hosting Anda, atau minta tolong hosting Anda untuk upgrade versi PHP di website Anda.', 'landingpress-wp' ).' <br/><a href="'.esc_url('http://member.landingpress.net/00-troubleshooting-php-version-upload-max-file-size/').'">'.esc_html__( 'Tutorial merubah php version dan upload_max_filesize melalui cPanel', 'landingpress-wp' ).'</a>';
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

add_action( 'tgmpa_register', 'landingpress_tgmpa_register_plugins' );
function landingpress_tgmpa_register_plugins() {

	$plugins = array();

	$plugins[] = array(
		'name'		=> 'Elementor',
		'desc'		=> 'Gunakan plugin ini jika Anda ingin menggunakan Elementor untuk membuat landing page.',
		'slug'		=> 'elementor',
		'required'	=> false,
		'optional'	=> false,
		'version'   => '2.9.13',
	);

	$plugins[] = array(
		'name'		=> 'Classic Editor',
		'desc'		=> 'Gunakan plugin ini jika Anda tidak mau menggunakan Gutenberg, editor baru di WordPress saat edit post/page.',
		'slug'		=> 'classic-editor',
		'required'	=> false,
		'optional'	=> false,
		'version'   => '1.3',
	);

	// $plugins[] = array(
	// 	'name'		=> 'Easy Theme and Plugin Upgrades',
	// 	'desc'		=> 'Gunakan plugin ini untuk mempermudah Anda update theme/plugin secara manual tanpa harus deactivate&delete theme/plugin terlebih dahulu.',
	// 	'slug'		=> 'easy-theme-and-plugin-upgrades',
	// 	'required'	=> false,
	// 	'optional'	=> true,
	// 	'version'   => '',
	// );

	// $plugins[] = array(
	// 	'name'		=> 'Duplicate Post',
	// 	'desc'		=> 'Gunakan plugin ini untuk mempermudah Anda clone / duplicate halaman (post/page) yang sudah pernah dibuat untuk mempercepat kerja Anda.',
	// 	'slug'		=> 'duplicate-post',
	// 	'required'	=> false,
	// 	'optional'	=> true,
	// 	'version'   => '',
	// );

	$plugins[] = array(
		'name'		=> 'Wordfence Security',
		'desc'		=> 'Gunakan plugin ini untuk meningkatkan keamanan di website Anda. Ini hanya opsi, Anda tidak harus menggunakan Wordfence, Anda boleh menggunakan plugin security lain seperti Sucuri dkk, <strong>silahkan pilih salah satu</strong>.',
		'slug'		=> 'wordfence',
		'required'	=> false,
		'optional'	=> true,
		'version'   => '',
	);

	$plugins[] = array(
		'name'		=> 'Sucuri Security',
		'desc'		=> 'Gunakan plugin ini untuk meningkatkan keamanan di website Anda. Ini hanya opsi, Anda tidak harus menggunakan Sucuri, Anda boleh menggunakan plugin security lain seperti Wordfence dkk, <strong>silahkan pilih salah satu</strong>.',
		'slug'		=> 'sucuri-scanner',
		'required'	=> false,
		'optional'	=> true,
		'version'   => '',
	);

	// $plugins[] = array(
	// 	'name'		=> 'WP Fastest Cache',
	// 	'desc'		=> 'Gunakan plugin ini untuk mempercepat loading website Anda dengan full page cache. Ini hanya opsi, Anda tidak harus menggunakan WP Fastest Cache, Anda boleh menggunakan plugin cache lain seperti WP Super Cache, WP Rocket, dkk.',
	// 	'slug'		=> 'wp-fastest-cache',
	// 	'required'	=> false,
	// 	'optional'	=> true,
	// 	'version'   => '',
	// );

	// $plugins[] = array(
	// 	'name'		=> 'Smush Image Compression and Optimization',
	// 	'desc'		=> 'Gunakan plugin ini untuk kompress dan optimasi gambar yang Anda upload ke website. Ini hanya opsi, Anda tidak harus menggunakan Smush It, Anda boleh menggunakan plugin image compression lain seperti EWWW Image Optimizer, ShortPixel Image Optimizer, dkk.',
	// 	'slug'		=> 'wp-smushit',
	// 	'required'	=> false,
	// 	'optional'	=> true,
	// 	'version'   => '',
	// );

	// $plugins[] = array(
	// 	'name'		=> 'Regenerate Thumbnails',
	// 	'desc'		=> 'Gunakan plugin ini untuk regenerate thumbnail dari semua gambar yang pernah di-upload ke website setelah ganti theme atau ganti ukuran gambar di WordPress/WooCommerce misalnya. Ini hanya opsi, Anda tidak harus menggunakan plugin ini, Anda boleh menggunakan plugin regenerate thumbnail lain seperti Force Regenerate Thumbnails, reGenerate Thumbnails Advanced, dkk.',
	// 	'slug'		=> 'regenerate-thumbnails',
	// 	'required'	=> false,
	// 	'optional'	=> true,
	// 	'version'   => '',
	// );

	$plugins[] = array(
		'name'		=> 'Contact Form DB',
		'desc'		=> 'Gunakan plugin ini jika ingin menyimpan data yang masuk melalui widget Contact Form dan Payment Confirmation Form dari Elementor di LandingPress.',
		'slug'		=> 'contact-form-7-to-database-extension',
		'required'	=> false,
		'optional'	=> true,
		'version'   => '2.10.37',
		'source'    => 'https://github.com/mdsimpson/contact-form-7-to-database-extension/releases/download/2.10.37/contact-form-7-to-database-extension.zip',
		'external_url' => 'https://github.com/mdsimpson/contact-form-7-to-database-extension/releases/download/2.10.37/contact-form-7-to-database-extension.zip',
	);

	$parent_slug = class_exists('EDD_Theme_Updater_Admin') ? 'landingpress' : 'themes.php';
	$capability = class_exists('EDD_Theme_Updater_Admin') ? 'manage_options' : 'edit_theme_options';

	$config = array(
		'id'           => 'landingpress-tgmpa',
		'default_path' => '',
		'menu'         => 'landingpress-install-plugins',
		'parent_slug'  => $parent_slug,
		'capability'   => $capability,
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

}

add_action( 'admin_menu', 'landingpress_add_submenu_page', 15 );
function landingpress_add_submenu_page() {
	add_submenu_page( 'landingpress', esc_html__( 'Theme Settings', 'landingpress-wp' ), esc_html__( 'Theme Settings', 'landingpress-wp' ), 'manage_options', 'customize.php' );
	add_submenu_page( 'landingpress', esc_html__( 'Video Tutorial', 'landingpress-wp' ), esc_html__( 'Video Tutorial', 'landingpress-wp' ), 'manage_options', 'landingpress-tutorial', 'landingpress_submenu_redirect' );
	add_submenu_page( 'landingpress', esc_html__( 'Contact Support', 'landingpress-wp' ), esc_html__( 'Contact Support', 'landingpress-wp' ), 'manage_options', 'landingpress-support', 'landingpress_submenu_redirect' );
}

function landingpress_submenu_redirect() {
	if ( empty( $_GET['page'] ) ) {
		return;
	}
	if ( 'landingpress-tutorial' === $_GET['page'] ) {
		echo '<meta http-equiv="refresh" content="0;url=https://member.landingpress.net/video-tutorial/?utm_source=wp-menu&utm_campaign=landingpress-tutorial&utm_medium=wp-dash" />';
		die;
	}
	if ( 'landingpress-support' === $_GET['page'] ) {
		echo '<meta http-equiv="refresh" content="0;url=https://member.landingpress.net/support/?utm_source=wp-menu&utm_campaign=landingpress-support&utm_medium=wp-dash" />';
		die;
	}
}

function landingpress_submenu_support() {

}

if ( did_action( 'elementor/loaded' ) ) {
	include_once( ADDONS_PATH . 'elementor-landingpress/elementor-landingpress.php' );
	include_once( ADDONS_PATH . 'elementor-landingpress/elementor-controls.php' );
	include_once( ADDONS_PATH . 'elementor-landingpress/elementor-exportimport.php' );
	if ( version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {
		include_once( ADDONS_PATH . 'elementor-kit/elementor-kit.php' );
	}
}

if ( class_exists( 'woocommerce') && ! class_exists( 'LandingPress_WC_Ongkir_Shipping_Method' ) ) {
	$lp_wc_ongkir = true;
	if ( class_exists('WPBisnis_WC_Indo_Ongkir_Init') ) {
		$license_status = get_option( 'wpbisnis_wc_indo_ongkir_license_status' );
		if ( isset( $license_status->license ) && $license_status->license == 'valid' ) {
			$lp_wc_ongkir = false;
		}
	}
	if ( $lp_wc_ongkir ) {
		define( 'LP_WC_ONGKIR_PATH', ADDONS_PATH . 'ongkir/' );
		define( 'LP_WC_ONGKIR_URL', ADDONS_URL . 'ongkir/' );
		require_once( LP_WC_ONGKIR_PATH . 'landingpress-wc-ongkir.php' );
	}
}

/*
WP Filters Extras
http://www.beapi.fr
https://github.com/herewithme/wp-filters-extras
Copyright 2012 Amaury Balmer - amaury@beapi.fr
*/
function landingpress_remove_filters_with_method_name( $hook_name = '', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
		return false;
	foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
			if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && $filter_array['function'][1] == $method_name ) {
			    if( is_a( $wp_filter[$hook_name], 'WP_Hook' ) ) {
			        unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
			    }
			    else {
				    unset($wp_filter[$hook_name][$priority][$unique_id]);
			    }
			}
		}
	}
	return false;
}
function landingpress_remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
	global $wp_filter;
	if ( !isset($wp_filter[$hook_name][$priority]) || !is_array($wp_filter[$hook_name][$priority]) )
		return false;
	foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		if ( isset($filter_array['function']) && is_array($filter_array['function']) ) {
			if ( is_object($filter_array['function'][0]) && get_class($filter_array['function'][0]) && get_class($filter_array['function'][0]) == $class_name && $filter_array['function'][1] == $method_name ) {
			    if( is_a( $wp_filter[$hook_name], 'WP_Hook' ) ) {
			        unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
			    }
			    else {
				    unset($wp_filter[$hook_name][$priority][$unique_id]);
			    }
			}
		}
	}
	return false;
}

include_once( ADDONS_PATH . 'shortcodes/shortcodes.php' );
include_once( ADDONS_PATH . 'optimization/optimization.php' );
